<?php

namespace Modules\Users\Http\Controllers;

use Modules\Core\Events\PasswordWasChangedEvent;
use Modules\Users\Http\Requests\ChangePasswordFormRequest;
use Modules\Users\Http\Requests\FormEditRequest;
use Modules\Users\Http\Requests\FormRequest;
use Modules\Users\Repositories\AuthenticationInterface;
use Modules\Users\Repositories\RoleInterface;
use Modules\Users\Repositories\UserInterface as Repository;
use Modules\Users\Services\PermissionManager;
use Yajra\Datatables\Datatables;

class UsersController extends BaseUsersController
{
    public function __construct(Repository $repository, PermissionManager $permissions, AuthenticationInterface $auth, RoleInterface $role)
    {
        parent::__construct($repository);
        $this->permissions = $permissions;
        $this->auth = $auth;
        $this->role = $role;
    }

    public function create($parent = null)
    {   
        try {
            $model = $this->repository->getModel();
            $module = $model->getTable();
            $form = $this->form(config($module . '.form'), [
                'method' => 'POST',
                'url' => route('admin.' . $module . '.store'),
                'data' => [
                    'countries' => \Countries::getAll()->pluck('name', 'id')->all(),
                    'regions' => \Regions::getAll()->pluck('name', 'id')->all(),
                    'states' => \States::getAll()->pluck('name', 'id')->all(),
                    'districts' => \Districts::getAll()->pluck('name', 'id')->all(),
                    'zones' => \Zones::getAll()->pluck('name', 'id')->all(),
                    'areas' => \Areas::getAll()->pluck('name', 'id')->all(),
                    'churches' => \Churches::getAll()->pluck('name', 'id')->all(),
                    'homechurches' => \Homechurches::getAll()->pluck('name', 'id')->all(),
                    'groupchats' => \Groupchats::getAll()->pluck('name', 'id')->all()
                ]
            ]);
            $roles = $this->role->all();
            return view('core::admin.create')
                ->with(compact('model', 'module', 'form', 'roles'));
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $model = $this->repository->find($id);
            $module = 'users';
            $form = $this->form(config($module . '.form'), [
                'method' => 'PUT',
                'url' => route('admin.' . $module . '.update', $model),
                'model' => $model,
                'data' => [
                        'countries' => \Countries::getAll()->pluck('name', 'id')->all(),
                        'regions' => \Regions::getAll()->pluck('name', 'id')->all(),
                        'states' => \States::getAll()->pluck('name', 'id')->all(),
                        'districts' => \Districts::getAll()->pluck('name', 'id')->all(),
                        'zones' => \Zones::getAll()->pluck('name', 'id')->all(),
                        'areas' => \Areas::getAll()->pluck('name', 'id')->all(),
                        'churches' => pluck_user_church()->pluck('name', 'id')->all(),
                        'homechurches' => pluck_user_homechurch()->pluck('name', 'id')->all(),
                        'groupchats' => pluck_user_groupchats()->pluck('name', 'id')->all()
                    ]
                ])->modify('type', 'select', [
                    'selected' => $model->churchtype,
                ])->modify($model['churchtype'].'_id', 'select', [
                    'selected' => !empty(get_current_church($model->id)) ? get_current_church($model->id)->churchleaderable_id : ''
                ]);
            $roles = $this->role->all();
            $currentUser = $this->auth->check();
            return view('core::admin.edit')
            ->with(compact('model', 'module', 'form', 'id', 'roles', 'currentUser'));
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
        
    }

    public function store(FormRequest $request)
    {
        $data = $this->mergeRequestWithPermissions($request);

        $model = $this->repository->createWithRoles($data, $request->roles, true);

        !empty($request->type) ? get_type($request) : '';
        return $this->redirect($request, $model, trans('core::global.new_record'));
    }

    public function update($id, FormEditRequest $request)
    {
        $form_req = $request->all();
        $form_req['user_id'] = $id;
        $data = $this->mergeRequestWithPermissions($request);

        $model = $this->repository->updateAndSyncRoles($id, $data, $request->roles);
        $model->churchtype = $form_req['type'];
        $model->save();

        if (!empty($form_req['type']) || ($form_req['homechurch_group'] == 'homechurch') && !empty($form_req['homechurch_id'])) {
            get_type($form_req);
        }

        if(!empty($form_req['homechurch_group']) && $form_req['homechurch_group'] != 'homechurch') {
           $groups = \Homechurches::getGroup($form_req['groups']);
           foreach($groups->data as $key => $homechurch_id) {
                $form_req['homechurch_id'] = $homechurch_id;
                get_type($form_req);
           }
        }
        return $this->redirect($request, $model, trans('core::global.update_record'));
    }

    public function changePassword()
    {
        $model = $this->repository->getModel();
        $module = str_replace('_', '', $model->getTable());
        $form = $this->form('Users\Forms\ChangePasswordForm', [
            'method' => 'POST',
        ]);
        return view('users::admin.change_password')->with(compact('form', 'module'));
    }

    public function postChangePassword(ChangePasswordFormRequest $request)
    {
        $data = $request->all();
        $model = $this->repository->changeUserPassword(current_user(), $data);

        \Notification::success(trans('users::global.change_password_success'));

        $email_data['password'] = $data['password'];
        $email_data['email'] = $model->email;
        $email_data['user_name'] = $model->first_name . ' ' . $model->last_name;

        event(new PasswordWasChangedEvent($email_data));

        return redirect(route('admin.users.change-password'));
    }

    public function dataTable()
    {
        $model = $this->repository->getForDatatable();

        //$model_table = str_replace('_','',$this->repository->getTable());
        $model_table = 'users';

        return Datatables::of($model)
            ->addColumn('action', $model_table . '::admin._table-action')
            ->removeColumn('id')
            ->make();
    }
}
