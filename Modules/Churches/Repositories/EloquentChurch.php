<?php namespace Modules\Churches\Repositories;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Repositories\RepositoriesAbstract;

class EloquentChurch extends RepositoriesAbstract implements ChurchInterface
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

    public function countAll()
    {
        return getDataTabeleQuery($this->model)->count();
    }

    public function getForDataTable()
    {
        $query = getDataTabeleQuery($this->model)->with(['country' => function($querys) {
            return $querys->select('id','name');
        }])->with(['region' => function($querys) {
            return $querys->select('id','name');
        }])->with(['state' => function($querys) {
            return $querys->select('id','name');
        }])->with(['district' => function($querys) {
            return $querys->select('id','name');
        }])->with(['zone' => function($querys) {
            return $querys->select('id','name');
        }])->with(['area' => function($querys) {
            return $querys->select('id','name');
        }]);
        if(!empty(current_user()->churchtype)){
            if(!empty(request('country_id'))&& !empty(request('region_id'))){
                return $model = $query->where('country_id', request('country_id'))
                                    ->where('region_id',request('region_id'))
                                    ->where('state_id',request('state_id'))
                                    ->where('district_id',request('district_id'))
                                    ->where('zone_id',request('zone_id'))
                                    ->where('area_id',request('area_id'))->get();
            }
            return  $model = $query->get();
        }
        if(!empty(request('country_id')) && !empty(request('region_id')) && !empty(request('state_id'))){
            $model = $query->where('churches.country_id', request('country_id'))
                            ->where('churches.region_id',request('region_id'))
                            ->where('churches.state_id',request('state_id'))
                            ->where('churches.district_id',request('district_id'))
                            ->where('churches.zone_id',request('zone_id'))
                            ->where('churches.area_id',request('area_id'));
        }
        $model = $query->get();
        return $model;
    }

}