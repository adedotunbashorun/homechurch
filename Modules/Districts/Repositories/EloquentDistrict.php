<?php namespace Modules\Districts\Repositories;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Repositories\RepositoriesAbstract;

class EloquentDistrict extends RepositoriesAbstract implements DistrictInterface
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
        $query = getDataTabeleQuery($this->model)->with(['country' => function($querys) {
                            return $querys->select('id','name');
                        }])->with(['region' => function($querys) {
                            return $querys->select('id','name');
                        }])->with(['state' => function($querys) {
                            return $querys->select('id','name');
                        }])->get();

        return $query;
    }
}