<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Routing\Controller;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Modules\Core\Traits\RedirectingTrait;
use Yajra\Datatables\Datatables;

abstract class BaseAdminController extends Controller {

    use FormBuilderTrait, RedirectingTrait;

    protected $repository;

    public function __construct($repository = null)
    {
        $this->middleware('auth.admin');
        $this->middleware('permissions')->except(['getCountryRegion','getRegionState','getStateDistrict','getDistrictZone','getZoneArea','getAreaChurch','getHomechurchesGroupByType']);
        $this->middleware('bindings');
        $this->repository = $repository;
    }

    public function index()
    {
        $module = $this->repository->getTable();
        //$module = str_replace('_','',$module);
        $title = trans($module . '::global.group_name');

        return view('core::admin.index')
            ->with(compact('title', 'module'));
    }

    protected function redirect($request, $model, $message = null)
    {
        $redirectUrl = $request->get('exit') ? $model->indexUrl() : $model->editUrl();
        if (!is_null($message))
        {
            return redirect($redirectUrl)->withSuccess($message);
        }

        return redirect($redirectUrl);
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function dataTable()
    {
        $id = request()->get('id');
        $model = !empty($id) ? $this->repository->getForDatatable($id) : $this->repository->getForDatatable();

        $model_table = $this->repository->getTable();

        return Datatables::of($model)
            ->addColumn('action', $model_table . '::admin._table-action')
            ->editColumn('status', function($row) {
                $html = '';
                $html .= status_label($row->status);

                return $html;
            })
            ->editColumn('is_featured', function($row) {
                $html = '';
                $html .= is_featured_label($row->is_featured);

                return $html;
            })
            ->escapeColumns(['action'])
            ->removeColumn('id')
            ->make();
    }

    public function destroy($model)
    {
        $this->repository->delete($model);
        session()->flash('success', 'record deleted successfully');
    }
}
