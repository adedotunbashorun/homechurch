<?php namespace Modules\Zones\Repositories;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Repositories\RepositoriesAbstract;

class EloquentZone extends RepositoriesAbstract implements ZoneInterface
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

    public function getForDataTable($id = '')
    {
        $query = getDataTabeleQuery($this->model)->with(['country' => function($querys) {
                        return $querys->select('id','name');
                    }])->with(['region' => function($querys) {
                        return $querys->select('id','name');
                    }])->with(['state' => function($querys) {
                        return $querys->select('id','name');
                    }])->with(['district' => function($querys) {
                        return $querys->select('id','name');
                    }]);
        if(!empty($id)) {
            return $query->where('district_id',$id)->get();
        }
        return $query->get();
    }

}