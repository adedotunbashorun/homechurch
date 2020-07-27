<?php namespace Modules\Attendance\Repositories;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Repositories\RepositoriesAbstract;
use Carbon\Carbon;

class EloquentAttendance extends RepositoriesAbstract implements AttendanceInterface
{

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model
            ->where('id','!=', '')->get();

    }

    public function getForDataTable()
    {   
        $query = getDataTabeleQuery($this->model)
                    ->with(['homechurches' => function($querys) {
                        return $querys->select('id','name');
                    }])->get();
        return $query;
    }

    public function getForDataTableGrouped($type = 'Y-M')
    {   
        $query = getDataTabeleQuery($this->model)->with(['homechurches' => function($querys) {
                        return $querys->select('id','name');
                    }])->get()->groupBy(function($date) use($type) {
                        return Carbon::parse($date->date)->format($type);
                    });
        return $query;
    }
}