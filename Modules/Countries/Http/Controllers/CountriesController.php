<?php namespace Modules\Countries\Http\Controllers;

use Modules\Core\Http\Controllers\BaseAdminController;
use Modules\Countries\Http\Requests\FormRequest;
use Modules\Countries\Repositories\CountryInterface as Repository;
use Modules\Countries\Entities\Country;

class CountriesController extends BaseAdminController {

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

    public function create()
    {
        $module = $this->repository->getTable();
        $form = $this->form(config($module.'.form'), [
            'method' => 'POST',
            'url' => route('admin.'.$module.'.store')
        ]);
        return view('core::admin.create')
            ->with(compact('module','form'));
    }

    public function edit(Country $model)
        {
            $module = $model->getTable();
            $form = $this->form(config($module.'.form'), [
                'method' => 'PUT',
                'url' => route('admin.'.$module.'.update',$model),
                'model'=>$model
            ]);
            return view('core::admin.edit')
                ->with(compact('model','module','form'));
        }

    public function store(FormRequest $request)
    {
        $data = $request->all();

        $model = $this->repository->create($data);
        $model->code = ($model->id < 10) ? '0'.$model->id : $model->id;
        $model->save();

        return $this->redirect($request, $model, trans('core::global.new_record'));
    }

    public function update(Country $model,FormRequest $request)
    {
        $data = $request->all();

        $data['id'] = $model->id;
        $data['code'] = ($model->id < 10) ? '0'.$model->id : $model->id;
        $model = $this->repository->update($data);

        return $this->redirect($request, $model, trans('core::global.update_record'));
    }

}
