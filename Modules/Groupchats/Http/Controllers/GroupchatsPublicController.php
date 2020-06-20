<?php namespace Modules\Groupchats\Http\Controllers;

use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Groupchats\Http\Requests\FormRequest;
use Modules\Groupchats\Http\Requests\AddUserRequest;
use Modules\Users\Entities\Sentinel\User;
use Illuminate\Http\Request;
use Modules\Groupchats\Repositories\GroupchatInterface as Repository;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use App\Events\GroupCreated;
use DB;
class GroupchatsPublicController extends BasePublicController {

    public function __construct(Repository $repository)
    {
        $this->middleware('auth:account' || 'auth:admin');
        parent::__construct($repository);
    }

    public function store(FormRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['description'] = !empty($data['description']) ? $data['description'] : ucwords($data['name']);
            $data = get_relationship($data);
            $model = $this->repository->create($data);
            $model->code = (($data['country_id'] < 10) ? '0'.$data['country_id'] : $data['country_id']).
            (($data['region_id'] < 10) ? '0'.$data['region_id'] : $data['region_id']).
            (($data['state_id'] < 10) ? '0'.$data['state_id'] : $data['state_id']).
            (($data['district_id'] < 10) ? '0'.$data['district_id'] : $data['district_id']).
            (($data['zone_id'] < 10) ? '0'.$data['zone_id'] : $data['zone_id']).
            (($data['area_id'] < 10) ? '0'.$data['area_id'] : $data['area_id']).
            (($data['church_id'] < 10) ? '0'.$data['church_id'] : $data['church_id']).
            (($model->id < 10) ? '0'.$model->id : $model->id);
            $model->save();

            if(!empty($data['users'])  && !empty($data['users'][0])){
                $users = collect($request->users);

                $model->users()->attach($users);
            }

            broadcast(new GroupCreated($model))->toOthers();
            DB::commit();
            return response()->json([
                'msg' => "group created successfully",
                'model' => $model,
                'success' => true
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'msg' => $e->getMessage(),
                'success' => false
            ], 401);
        }
        // return $this->redirect($request, $model, trans('core::global.new_record'));
    }

    public function index()
    {
        try {
            $groups = current_user()->groupchats;
            $members = !empty($groups[0]) ? DB::table('groupchat_user')->where('groupchat_id', $groups[0]->id)->pluck('user_id') : [];
            $group_members = User::whereIn('id', $members)->get();
            return view('groupchats::public.index')
                ->with(compact('groups','group_members'));
        } catch (\Exception $e) {
            session()->flash('error', "You don't belong to a group.");
            return redirect()->back();
            //throw $th;
        }
        
    }

    public function addUser(AddUserRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $model = $this->repository->byId($data['group_id']);

            $users = collect($request->users);

            $model->users()->attach($users);

            broadcast(new GroupCreated($model))->toOthers();
            DB::commit();
            return response()->json([
                'msg' => "user added successfully",
                'model' => $model,
                'success' => true
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'msg' => $e->getMessage(),
                'success' => false
            ], 401);
        }
    }

    public function addUserToChat(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $model = $this->repository->byId($data['groupchat_id']);

            $model->users()->attach(current_user()->id);

            broadcast(new GroupCreated($model))->toOthers();
            DB::commit();
            return response()->json([
                'msg' => "You have been added to $model->name group successfully!",
                'model' => $model,
                'success' => true
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'msg' => $e->getMessage(),
                'success' => false
            ], 401);
        }
    }

    public function removeUser($group_id, $user_id)
    {
        DB::beginTransaction();
        try {
            $model = $this->repository->byId($group_id);

            $model->users()->detach($user_id);

            broadcast(new GroupCreated($model))->toOthers();

            DB::commit();
            return response()->json([
                'msg' => "user removed successfully",
                'model' => $model,
                'success' => true
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'msg' => $e->getMessage(),
                'success' => false
            ], 401);
        }
    }

}
