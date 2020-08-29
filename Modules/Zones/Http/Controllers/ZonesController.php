<?php namespace Modules\Zones\Http\Controllers;

use Modules\Core\Http\Controllers\BaseAdminController;
use Modules\Zones\Http\Requests\FormRequest;
use Modules\Zones\Repositories\ZoneInterface as Repository;
use Modules\Zones\Entities\Zone;
use Yajra\Datatables\Datatables;

class ZonesController extends BaseAdminController {

    public function __construct(Repository $repository)
    {
        parent::__construct($repository);
    }

    public function index()
    {
        $module = $this->repository->getTable();
        $id = request()->get('id');
        $title = trans($module . '::global.group_name');
        return view('zones::admin.index')
            ->with(compact('title', 'module','id'));
    }

    public function getDistrictZone($id)
    {
        return response()->json([
            'zones' => $this->repository->allBy('district_id',$id),
            'success' => true
        ], 200);
    }

    public function create()
    {
        $module = $this->repository->getTable();
        $form = $this->form(config($module.'.form'), [
            'method' => 'POST',
            'url' => route('admin.'.$module.'.store'),
            'data' => [
                'countries' => \Countries::getAll()->pluck('name', 'id')->all(),
                'regions' => \Regions::getAll()->pluck('name', 'id')->all(),
                'states' => \States::getAll()->pluck('name', 'id')->all(),
                'districts' => \Districts::getAll()->pluck('name', 'id')->all()
            ]
        ]);
        return view('core::admin.create')
            ->with(compact('module','form'));
    }

    public function edit(Zone $model)
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
                'districts' => \Districts::getAll()->pluck('name', 'id')->all()
            ]
        ])->modify('country_id', 'select', [
            'selected' => $model->country_id
        ])->modify('region_id', 'select', [
            'selected' => $model->region_id
        ])->modify('state_id', 'select', [
            'selected' => $model->state_id
        ])->modify('district_id', 'select', [
            'selected' => $model->district_id
        ]);
        return view('core::admin.edit')
            ->with(compact('model','module','form'));
    }


    public function store(FormRequest $request)
    {
        $data = $request->all();
        $data = get_relationship($data);
        $data['code'] = '00';
        $model = $this->repository->create($data);
        $model->code = (($data['country_id'] < 10) ? '0'.$data['country_id'] : $data['country_id']).
        (($data['region_id'] < 10) ? '0'.$data['region_id'] : $data['region_id']).
        (($data['state_id'] < 10) ? '0'.$data['state_id'] : $data['state_id']).
        (($data['district_id'] < 10) ? '0'.$data['district_id'] : $data['district_id']).
        (($model->id < 10) ? '0'.$model->id : $model->id);
        $model->save();

        return $this->redirect($request, $model, trans('core::global.new_record'));
    }

    public function update(Zone $model,FormRequest $request)
    {
        $data = $request->all();

        $data['id'] = $model->id;
        $data = get_relationship($data);
        $data['code'] = (($data['country_id'] < 10) ? '0'.$data['country_id'] : $data['country_id']).
        (($data['region_id'] < 10) ? '0'.$data['region_id'] : $data['region_id']).
        (($data['state_id'] < 10) ? '0'.$data['state_id'] : $data['state_id']).
        (($data['district_id'] < 10) ? '0'.$data['district_id'] : $data['district_id']).
        (($model->id < 10) ? '0'.$model->id : $model->id);
        $model = $this->repository->update($data);

        return $this->redirect($request, $model, trans('core::global.update_record'));
    }

    public function dataTable()
    {
        $id = request()->get('district_id');
        $model = !empty($id) ? $this->repository->getForDatatable($id) : $this->repository->getForDatatable();

        $model_table = $this->repository->getTable();

        return Datatables::of($model)
            ->addColumn('action', $model_table . '::admin._table-action')
            ->editColumn('name', function($row) {
                $html = '';
                $html .= '<a href="/admin/areas?id='.$row->id.'" target="_blank">'.$row->name.'</a>';

                return $html;
            })
            ->escapeColumns(['action'])
            ->removeColumn('id')
            ->make();
    }

}
