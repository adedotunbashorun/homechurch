<?php namespace Modules\Testimonials\Http\Controllers;

use Modules\Core\Http\Controllers\BaseAdminController;
use Modules\Testimonials\Http\Requests\FormRequest;
use Modules\Testimonials\Repositories\TestimonialInterface as Repository;
use Modules\Testimonials\Entities\Testimonial;
use Yajra\Datatables\Datatables;

class TestimonialsController extends BaseAdminController {

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

    public function edit(Testimonial $model)
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
        $data['user_id'] = current_user()->id;
        (current_user()->hasRoleName('admin')) ?: $data['status'] = 0;
        $model = $this->repository->create($data);

        return $this->redirect($request, $model, trans('core::global.new_record'));
    }

    public function update(Testimonial $model,FormRequest $request)
    {
        $data = $request->all();

        $data['id'] = $model->id;
        (current_user()->hasRoleName('admin')) ?: $data['status'] = 0;

        $model = $this->repository->update($data);

        return $this->redirect($request, $model, trans('core::global.update_record'));
    }

    public function dataTable()
    {
        $id = request()->get('id');
        $model = !empty($id) ? $this->repository->getForDatatable($id) : $this->repository->getForDatatable();

        $model_table = $this->repository->getTable();

        return Datatables::of($model)
            ->addColumn('action', $model_table . '::admin._table-action')
            ->editColumn('first_name', function($row) {
                return $row->first_name.' '.$row->last_name;
            })
            ->editColumn('status', function($row) {
                $html = '';
                $html .= status_label($row->status);
                return $html;
            })
            ->editColumn('message', function($row) {
                return str_limit($row->message, 50);
            })
            ->escapeColumns(['action'])
            ->removeColumn('id')
            ->make();
    }

}
