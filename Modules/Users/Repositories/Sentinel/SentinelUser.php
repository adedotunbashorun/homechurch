<?php namespace Modules\Users\Repositories\Sentinel;

use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\Hash;
use Modules\History\Traits\Historable;
use Modules\Users\Events\UserWasUpdated;
use Modules\Users\Exceptions\UserNotFoundException;
use Modules\Users\Repositories\UserInterface;

class SentinelUser implements UserInterface
{
    use Historable;
    /**
     * @var \Modules\Users\Entities\Sentinel\User
     */
    protected $user;
    /**
     * @var \Cartalyst\Sentinel\Roles\EloquentRole
     */
    protected $role;

    public function __construct()
    {
        $this->user = Sentinel::getUserRepository()->createModel();
        $this->role = Sentinel::getRoleRepository()->createModel();
    }

    /**
     * Get empty model
     *
     * @return model
     */
    public function getModel()
    {
        $model = config('auth.providers.users.model');
        return $model::getModel();
    }

    /**
     * Get table name
     *
     * @return string
     */
    public function getTable()
    {
        return 'users';
    }

    /**
     * Returns all the users
     * @return object
     */
    public function all()
    {
        return $this->user->all();
    }

    /**
     * Create a user resource
     * @param $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->user->create((array) $data);
    }

    /**
     * Create a user and assign roles to it
     * @param  array $data
     * @param  array $roles
     * @param bool $activated
     */
    public function createWithRoles($data, $roles, $activated = false)
    {
        $this->hashPassword($data);
        $user = $this->create((array) $data);

        if (!empty($roles)) {
            $user->roles()->attach($roles);
        }

        if ($activated) {
            $activation = Activation::create($user);
            Activation::complete($user, $activation->code);
        }
        return $user;
    }

    /**
     * Find a user by its ID
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->user->find($id);
    }

    /**
     * Find a user by its key and value
     * @param $id
     * @return mixed
     */
    public function findBy($key, $value)
    {
        return $this->user->where($key,$value)->first();
    }

    /**
     * Update a user
     * @param $user
     * @param $data
     * @return mixed
     */
    public function update($user, $data)
    {
        $user = $user->update($data);

        event(new UserWasUpdated($user));

        return $user;
    }

    /**
     * @param $userId
     * @param $data
     * @param $roles
     * @internal param $user
     * @return mixed
     */
    public function updateAndSyncRoles($userId, $data, $roles)
    {
        $user = $this->user->find($userId);

        $this->checkForNewPassword($data);

        $this->checkForManualActivation($user, $data);

        $user = $user->fill($data);
        $user->save();

        event(new UserWasUpdated($user));

        if (!empty($roles)) {
            $user->roles()->sync($roles);
        }

        return $user;
    }

    /**
     * Deletes a user
     * @param $id
     * @throws UserNotFoundException
     * @return mixed
     */
    public function delete($id)
    {
        if ($user = $this->user->find($id)) {
            return $user->delete();
        };

        throw new UserNotFoundException();
    }

    /**
     * Find a user by its credentials
     * @param  array $credentials
     * @return mixed
     */
    public function findByCredentials(array $credentials)
    {
        return Sentinel::findByCredentials($credentials);
    }

    /**
     * Hash the password key
     * @param array $data
     */
    private function hashPassword(array &$data)
    {
        $data['password'] = Hash::make($data['password']);
    }

    /**
     * Check if there is a new password given
     * If not, unset the password field
     * @param array $data
     */
    private function checkForNewPassword(array &$data)
    {
        if (! $data['password']) {
            unset($data['password']);

            return;
        }

        $data['password'] = Hash::make($data['password']);
    }

    /**
     * Check and manually activate or remove activation for the user
     * @param $user
     * @param array $data
     */
    private function checkForManualActivation($user, array &$data)
    {
        if (Activation::completed($user) && !$data['activated']) {
            return Activation::remove($user);
        }

        if (!Activation::completed($user) && $data['activated']) {
            $activation = Activation::create($user);

            return Activation::complete($user, $activation->code);
        }
    }

    public function getForDataTable(){
        $type = \Session::get('userRoute');
        $model = config('auth.providers.users.model');
        if($type == 'members'){
            $query = [];
            if (current_user()->hasRoleName('admin')) {
                $query = $model::whereHas('roles', function ($q) {
                    $q->where('slug', 'user');
                })->get();
            } else {
                $members = get_current_user_members();
                $query = $model::whereIn('id', $members)->get();
            }
            
            return $query;
        }

        $query= $model::whereHas('roles', function($q){
            $q->where('slug','!=', 'user');
        })->get();

        return $query;
    }

    public function countAll(){
        $model = config('auth.providers.users.model');
        //dd($model);
        return $model::count();
    }
}
