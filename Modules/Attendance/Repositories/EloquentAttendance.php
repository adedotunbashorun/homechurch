<?php namespace Modules\Attendance\Repositories;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Repositories\RepositoriesAbstract;

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
}