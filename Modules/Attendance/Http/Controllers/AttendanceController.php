<?php namespace Modules\Attendance\Http\Controllers;

use Modules\Core\Http\Controllers\BaseAdminController;
use Modules\Attendance\Http\Requests\FormRequest;
use Modules\Attendance\Repositories\AttendanceInterface as Repository;
use Modules\Attendance\Entities\Attendance;
use Yajra\Datatables\Datatables;
use DateTime;

class AttendanceController extends BaseAdminController {

    public function __construct(Repository $repository)
    {
        parent::__construct($repository);
    }

    public function index()
    {
        $module = $this->repository->getTable();
        $title = trans($module . '::global.group_name');
        $g_attendance = $this->repository->getForDataTableGrouped();
        // dd($g_attendance);
        return view('attendance::admin.index')
            ->with(compact('title', 'module','g_attendance'));
    }

    public function create()
    {
        $module = $this->repository->getTable();
        $form = $this->form(config($module.'.form'), [
            'method' => 'POST',
            'url' => route('admin.'.$module.'.store'),
            'data' => [
                'homechurches' => pluck_user_homechurch()->pluck('name', 'id')->all(),
                'groupchats' => pluck_user_groupchats()->pluck('name', 'id')->all(),
            ]
        ]);
        return view('core::admin.create')
            ->with(compact('module','form'));
    }

    public function edit(Attendance $model)
    {
        $module = $model->getTable();
        $form = $this->form(config($module.'.form'), [
            'method' => 'PUT',
            'url' => route('admin.'.$module.'.update',$model),
            'model'=>$model,
            'data' => [
                'homechurches' => pluck_user_homechurch()->pluck('name', 'id')->all(),
                'groupchats' => pluck_user_groupchats()->pluck('name', 'id')->all(),
            ]
        ])->modify('homechurch_id', 'select', [
            'selected' => $model->homechurch_id
        ]);
        return view('core::admin.edit')
            ->with(compact('model','module','form'));
    }

    public function store(FormRequest $request)
    {
        $data = $request->all();

        $model = $this->repository->create($data);

        return $this->redirect($request, $model, trans('core::global.new_record'));
    }

    public function update(Attendance $model,FormRequest $request)
    {
        $data = $request->all();

        $data['id'] = $model->id;

        $model = $this->repository->update($data);

        return $this->redirect($request, $model, trans('core::global.update_record'));
    }

    public function dataTable()
    {
        $id = request()->get('id');
        $model = !empty($id) ? $this->repository->getForDatatable($id) : $this->repository->getForDatatable();

        $model_table = $this->repository->getTable();

        return Datatables::of($model)
            ->addColumn('total', function($row) {
                return $row->male +  $row->female +  $row->children;
            })
            ->addColumn('action', $model_table . '::admin._table-action')
            ->editColumn('status', function($row) {
                $html = '';
                $html .= status_label($row->status);

                return $html;
            })
            ->editColumn('date', function($row) {
                $date = new DateTime($row->date);
                return $date->format('Y-M-d');
            })
            ->addColumn('week', function($row) {
                $date = new DateTime($row->date);
                return $date->format('W');
            })
            ->escapeColumns(['action'])
            ->removeColumn('id')
            ->make();
    }

    public function dataTableGrouped()
    {
        $id = request()->get('id');
        $type = request()->get('type');
        $model = $this->repository->getForDataTableGrouped($type);

        $model_table = $this->repository->getTable();

        return Datatables::of($model)
            ->addColumn('total', function($row) {
                return $row->male +  $row->female +  $row->children;
            })
            ->addColumn('action', $model_table . '::admin._table-action')
            ->editColumn('status', function($row) {
                $html = '';
                $html .= status_label($row->status);

                return $html;
            })
            ->editColumn('date', function($row) {
                $date = new DateTime($row->date);
                return $date->format('Y-M-d');
            })
            ->addColumn('week', function($row) {
                $date = new DateTime($row->date);
                return $date->format('W');
            })
            ->escapeColumns(['action'])
            ->removeColumn('id')
            ->make();
    }
}
