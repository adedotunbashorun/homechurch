<?php namespace Modules\Groupchats\Http\Controllers;

use Modules\Core\Http\Controllers\BaseAdminController;
use Modules\Groupchats\Http\Requests\FormRequest;
use Modules\Groupchats\Repositories\GroupchatInterface as Repository;
use Modules\Users\Entities\Sentinel\User;
use Modules\Churches\Repositories\ChurchInterface as Church;
use Modules\Groupchats\Entities\Groupchat;
use Modules\Groupchats\Events\GroupCreated;
use DB;

class GroupchatsController extends BaseAdminController {

    protected $church;

    public function __construct(Repository $repository, Church $church)
    {
        $this->church = $church;
        parent::__construct($repository);
    }

    public function index()
    {
        $module = $this->repository->getTable();
        $title = trans($module . '::global.group_name');
        return view('core::admin.index')
            ->with(compact('title', 'module'));
    }

    public function create()
    {
        $module = $this->repository->getTable();
        $groups = current_user()->groupchats;
        $all_groups = DB::table('groupchats')->get();
        $groups_users = DB::table('groupchat_user')->pluck('user_id');
        $users = User::whereNotIn('id', $groups_users)->get();
        $members = DB::table('groupchat_user')->where('groupchat_id', $groups[0]->id)->pluck('user_id');
        $group_members = User::whereIn('id', $members)->get();
        $churches = pluck_user_church();
        return view('core::admin.create')
            ->with(compact('module','users','groups','churches','all_groups','group_members'));
    }

    public function edit(Groupchat $model)
    {
        $module = $model->getTable();
        $groups = current_user()->groupchats;
        $all_groups = DB::table('groupchats')->get();
        $groups_users = DB::table('groupchat_user')->pluck('user_id');
        $users = User::whereNotIn('id', $groups_users)->get();
        $members = DB::table('groupchat_user')->where('groupchat_id', $model->id)->pluck('user_id');
        $group_members = User::whereIn('id', $members)->get();
        $churches = pluck_user_church();
        return view('core::admin.edit')
            ->with(compact('module','users','groups','churches','all_groups','model','group_members'));
    }

    public function store(FormRequest $request)
    {
        $data = $request->all();

        $model = $this->repository->create($data);
        
        return $this->redirect($request, $model, trans('core::global.new_record'));
    }

    public function update(Groupchat $model,FormRequest $request)
    {
        $data = $request->all();

        $data['id'] = $model->id;

        $model = $this->repository->update($data);

        return $this->redirect($request, $model, trans('core::global.update_record'));
    }

}
