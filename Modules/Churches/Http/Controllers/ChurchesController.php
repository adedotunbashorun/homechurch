<?php namespace Modules\Churches\Http\Controllers;

use Modules\Core\Http\Controllers\BaseAdminController;
use Modules\Churches\Http\Requests\FormRequest;
use Modules\Churches\Repositories\ChurchInterface as Repository;
use Modules\Churches\Entities\Church;

class ChurchesController extends BaseAdminController {

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

    public function getAreaChurch($id)
    {
        return response()->json([
            'churches' => $this->repository->allBy('area_id',$id),
            'success' => true
        ], 200);
    }

    public function create()
    {
        // dd(current_user()->hasChurch(current_user()['churchtype']));
        $module = $this->repository->getTable();
        $form = $this->form(config($module.'.form'), [
            'method' => 'POST',
            'url' => route('admin.'.$module.'.store'),
            'data' => [
                'countries' => \Countries::getAll()->pluck('name', 'id')->all(),
                'regions' => \Regions::getAll()->pluck('name', 'id')->all(),
                'states' => \States::getAll()->pluck('name', 'id')->all(),
                'districts' => \Districts::getAll()->pluck('name', 'id')->all(),
                'zones' => \Zones::getAll()->pluck('name', 'id')->all(),
                'areas' => (current_user()->hasChurch(current_user()['churchtype'])) ? getAreaFormData()->pluck('name', 'id')->all() : \Areas::getAll()->pluck('name', 'id')->all()
            ]
        ]);
        return view('core::admin.create')
            ->with(compact('module','form'));
    }

    public function edit(Church $model)
    {
        $module = $model->getTable();
        $form = $this->form(config($module.'.form'), [
            'method' => 'PUT',
            'url' => route('admin.'.$module.'.update',$model),
            'model'=>$model,
            'data' => [
                'countries' => \Countries::getAll()->pluck('name', 'id')->all(),
                'regions' => \Regions::getAll()->pluck('name', 'id')->all(),
                'states' => \States::getAll()->pluck('name', 'id')->all(),
                'districts' => \Districts::getAll()->pluck('name', 'id')->all(),
                'zones' => \Zones::getAll()->pluck('name', 'id')->all(),
                'areas' => (current_user()->hasChurch(current_user()['churchtype'])) ? getAreaFormData()->pluck('name', 'id')->all() : \Areas::getAll()->pluck('name', 'id')->all()
            ]
        ])->modify('country_id', 'select', [
            'selected' => $model->country_id
        ])->modify('region_id', 'select', [
            'selected' => $model->region_id
        ])->modify('state_id', 'select', [
            'selected' => $model->state_id
        ])->modify('district_id', 'select', [
            'selected' => $model->district_id
        ])->modify('zone_id', 'select', [
            'selected' => $model->zone_id
        ])->modify('area_id', 'select', [
            'selected' => $model->area_id
        ]);
        return view('core::admin.edit')
            ->with(compact('model','module','form'));
    }

    public function store(FormRequest $request)
    {
        $data = $request->all();
        $data = get_relationship($data);
        $data['code'] = $data['country_id'].$data['region_id'].$data['state_id'].$data['district_id'].$data['zone_id'].$data['area_id'];

        $model = $this->repository->create($data);
        $model->code = (($data['country_id'] < 10) ? '0'.$data['country_id'] : $data['country_id']).
        (($data['region_id'] < 10) ? '0'.$data['region_id'] : $data['region_id']).
        (($data['state_id'] < 10) ? '0'.$data['state_id'] : $data['state_id']).
        (($data['district_id'] < 10) ? '0'.$data['district_id'] : $data['district_id']).
        (($data['zone_id'] < 10) ? '0'.$data['zone_id'] : $data['zone_id']).
        (($data['area_id'] < 10) ? '0'.$data['area_id'] : $data['area_id']).
        (($model->id < 10) ? '0'.$model->id : $model->id);
        $model->save();

        return $this->redirect($request, $model, trans('core::global.new_record'));
    }

    public function update(Church $model,FormRequest $request)
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
        (($model->id < 10) ? '0'.$model->id : $model->id);
        $model = $this->repository->update($data);
        $model->homechurches()->update([
            'country_id' => $data['country_id'],
            'region_id' => $data['region_id'],
            'state_id' => $data['state_id'],
            'district_id' => $data['district_id'],
            'zone_id' => $data['zone_id'],
            'area_id' => $data['area_id'],
        ]);

        return $this->redirect($request, $model, trans('core::global.update_record'));
    }

}
