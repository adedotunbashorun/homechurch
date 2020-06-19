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
        if(!empty(current_user()->churchtype)){
            $query = getDataTabeleQuery($this->model);
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
        $query = getDataTabeleQuery($this->model)
            ->join('countries', 'countries.id', '=', 'churches.country_id')
            ->join('regions', 'regions.id', '=', 'churches.region_id')
            ->join('states', 'states.id', '=', 'churches.state_id')
            ->join('districts', 'districts.id', '=', 'churches.district_id')
            ->join('zones', 'zones.id', '=', 'churches.zone_id')
            ->join('areas', 'areas.id', '=', 'churches.area_id');
            if(!empty(request('country_id')) && !empty(request('region_id')) && !empty(request('state_id'))){
                $model = $query->where('churches.country_id', request('country_id'))
                                ->where('churches.region_id',request('region_id'))
                                ->where('churches.state_id',request('state_id'))
                                ->where('churches.district_id',request('district_id'))
                                ->where('churches.zone_id',request('zone_id'))
                                ->where('churches.area_id',request('area_id'));
            }
            $model = $query->select([
                'churches.id as id',
                'churches.name as name',
                'churches.code as code',
                'states.name as state_id',
                'countries.name as country_id',
                'regions.name as region_id',
                'districts.name as district_id',
                'zones.name as zone_id',
                'areas.name as area_id',
            ]);

        return $model;
    }

}