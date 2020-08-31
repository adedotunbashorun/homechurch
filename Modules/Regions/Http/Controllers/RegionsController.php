<?php namespace Modules\Regions\Http\Controllers;

use Modules\Core\Http\Controllers\BaseAdminController;
use Modules\Regions\Http\Requests\FormRequest;
use Modules\Regions\Repositories\RegionInterface as Repository;
use Modules\Countries\Repositories\CountryInterface;
use Modules\Regions\Entities\Region;

class RegionsController extends BaseAdminController {
    protected $country;
    public function __construct(Repository $repository,CountryInterface $country)
    {
        parent::__construct($repository);
        $this->country = $country;
    }

    public function index()
    {
        $module = $this->repository->getTable();
        $title = trans($module . '::global.group_name');
        return view('core::admin.index')
            ->with(compact('title', 'module'));
    }

    public function search()
    {
        $query = request('query');
        $array = $this->country->getAllBySearchQuery($query, 'name',false);
        return response()->json($array, 200);
    }

    public function getCountryRegion($id)
    {
        return response()->json([
            'regions' => $this->repository->allBy('country_id',$id),
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
            ]
        ]);
        return view('core::admin.create')
            ->with(compact('module','form'));
    }

    public function edit(Region $model)
        {
            $module = $model->getTable();
            $form = $this->form(config($module.'.form'), [
                'method' => 'PUT',
                'url' => route('admin.'.$module.'.update',$model),
                'model'=>$model,
                'data' => [
                    'countries' => \Countries::getAll()->pluck('name', 'id')->all(),
                ]
            ])->modify('country_id', 'select', [
                'selected' => $model->country_id
            ]);
            return view('core::admin.edit')
                ->with(compact('model','module','form'));
        }

    public function store(FormRequest $request)
    {
        try {
            $data = $request->all();
            $data['code'] = ($data['country_id'] < 10) ? '0'.$data['country_id'] : $data['country_id'];
            $model = $this->repository->create($data);
            $model->code = (($data['country_id'] < 10) ? '0'.$data['country_id'] : $data['country_id']).(($model->id < 10) ? '0'.$model->id : $model->id);
            $model->save();

            return $this->redirect($request, $model, trans('core::global.new_record'));
        } catch (\Exception $e) {
            dd($e->getMessage());
            //throw $th;
        }
    }

    public function update(Region $model,FormRequest $request)
    {
        $data = $request->all();

        $data['id'] = $model->id;
        $data['code'] = (($data['country_id'] < 10) ? '0'.$data['country_id'] : $data['country_id']).
        (($model->id < 10) ? '0'.$model->id : $model->id);
        $model = $this->repository->update($data);

        $model->states()->update([
            'country_id' => $data['country_id'],
        ]);

        $model->districts()->update([
            'country_id' => $data['country_id'],
        ]);

        $model->zones()->update([
            'country_id' => $data['country_id'],
        ]);

        $model->areas()->update([
            'country_id' => $data['country_id'],
        ]);

        $model->churches()->update([
            'country_id' => $data['country_id'],
        ]);

        $model->homechurches()->update([
            'country_id' => $data['country_id'],
        ]);

        return $this->redirect($request, $model, trans('core::global.update_record'));
    }

}
