<?php namespace Modules\Areas\Repositories;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Repositories\RepositoriesAbstract;

class EloquentArea extends RepositoriesAbstract implements AreaInterface
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
                }])->with(['district' => function($querys) {
                    return $querys->select('id','name');
                }])->with(['zone' => function($querys) {
                    return $querys->select('id','name');
                }]);
        if(!empty(current_user()->churchtype)){
            if(!empty(request('country_id'))&& !empty(request('region_id'))){
                return $model = $query->where('country_id', request('country_id'))
                ->where('region_id',request('region_id'))
                ->where('state_id',request('state_id'))
                ->where('district_id',request('district_id'))
                ->where('zone_id',request('zone_id'))->get();
            }
            return  $model = $query->get();
        }
        if(!empty(request('country_id')) && !empty(request('region_id')) && !empty(request('state_id'))){
            $model = $query->where('areas.country_id', request('country_id'))
                            ->where('areas.region_id',request('region_id'))
                            ->where('areas.state_id',request('state_id'))
                            ->where('areas.district_id',request('district_id'))
                            ->where('areas.zone_id',request('zone_id'));
        }
        $model = $query->get();
        return $model;
    }

}