<?php namespace Modules\Homechurches\Http\Controllers;

use Modules\Core\Http\Controllers\BaseAdminController;
use Modules\Homechurches\Http\Requests\FormRequest;
use Modules\Homechurches\Repositories\HomechurchInterface as Repository;
use Modules\Homechurches\Entities\Homechurch;
use DB;

class HomechurchesController extends BaseAdminController {

    public function __construct(Repository $repository)
    {
        parent::__construct($repository);
    }

    public function index()
    {
        $module = $this->repository->getTable();
        $title = trans($module . '::global.group_name');
        return view('core::admin.index')
            ->with(compact('title', 'module'));
    }

    public function submittedHomechurches()
    {
        $module = $this->repository->getTable();
        $title = trans($module . '::global.submitted_index');
        $models = $this->repository->make(['owner'])->where('owner_id','!=', null)->paginate(5);
        if (request()->ajax()) {
            return view('homechurches::admin._list', compact('models'));
        }
        return view('homechurches::admin.submitted_index')
            ->with(compact('title', 'module','models'));
    }

    public function approveSubmittedHomechurches($id)
    {
        try {
            \DB::beginTransaction();
            $model = $this->repository->byId($id);
            $model->status = 1;
            $model->save();
            \DB::commit();
            return redirect()->back()->withSuccess('submitted home church approved successfully!');
        } catch (\Exception $e) {
            dd($e->getMessage());
            \DB::rollback();
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function getByChurch($id)
    {
        return response()->json([
            'homechurches' => $this->repository->allBy('church_id',$id),
            'success' => true
        ], 200);
    }

    public function create()
    {
        $module = $this->repository->getTable();
        $homechurches_users = DB::table('homechurch_user')->get()->pluck('id');
        $form = $this->form(config($module.'.form'), [
            'method' => 'POST',
            'url' => route('admin.'.$module.'.store'),
            'data' => [
                'churches' => pluck_user_church()->pluck('name', 'id')->all(),
                'users' => get_unassigned_members($homechurches_users)
            ]
        ]);
        return view('core::admin.create')
            ->with(compact('module','form'));
    }

    public function edit(Homechurch $model)
    {
        $module = $model->getTable();
        $homechurches_users = DB::table('homechurch_user')->get()->pluck('user_id');
        $form = $this->form(config($module.'.form'), [
            'method' => 'PUT',
            'url' => route('admin.'.$module.'.update',$model),
            'model'=>$model,'model'=>$model,
            'data' => [
                'churches' => pluck_user_church()->pluck('name', 'id')->all(),
                'users' => get_unassigned_members($homechurches_users)
            ]
        ])->modify('church_id', 'select', [
            'selected' => $model->church_id
        ]);
        return view('core::admin.edit')
            ->with(compact('model','module','form'));
    }

    public function store(FormRequest $request)
    {
        $data = $request->all();
        $data = get_relationship($data);
        $data['description'] = !empty($data['description']) ?: ucwords($data['name']);
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
        if(!empty($data['users']) && !empty($data['users'][0])){
            $users = collect($request->users);

            $model->users()->attach($users);
        }

        return $this->redirect($request, $model, trans('core::global.new_record'));
    }

    public function update(Homechurch $model,FormRequest $request)
    {
        $data = $request->all();

        $data['id'] = $model->id;
        $data = get_relationship($data);
        $data['code'] = (($data['country_id'] < 10) ? '0'.$data['country_id'] : $data['country_id']).
        (($data['region_id'] < 10) ? '0'.$data['region_id'] : $data['region_id']).
        (($data['state_id'] < 10) ? '0'.$data['state_id'] : $data['state_id']).
        (($data['district_id'] < 10) ? '0'.$data['district_id'] : $data['district_id']).
        (($data['zone_id'] < 10) ? '0'.$data['zone_id'] : $data['zone_id']).
        (($data['area_id'] < 10) ? '0'.$data['area_id'] : $data['area_id']).
        (($data['church_id'] < 10) ? '0'.$data['church_id'] : $data['church_id']).
        (($model->id < 10) ? '0'.$model->id : $model->id);
        $data['description'] = !empty($data['description']) ?: ucwords($data['name']);
        
        $model = $this->repository->update($data);
        if(!empty($data['users'])){
            $users = collect($request->users);

            $model->users()->attach($users);
        }

        return $this->redirect($request, $model, trans('core::global.update_record'));
    }

}
