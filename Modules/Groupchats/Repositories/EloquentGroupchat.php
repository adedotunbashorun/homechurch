<?php namespace Modules\Groupchats\Repositories;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Repositories\RepositoriesAbstract;

class EloquentGroupchat extends RepositoriesAbstract implements GroupchatInterface
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
                                    ->where('area_id',request('area_id'))
                                    ->where('church_id',request('church_id'))->get();
            }
            return  $model = $query->get();
        }
        $query = getDataTabeleQuery($this->model)
            ->join('churches', 'churches.id', '=', 'groupchats.church_id')
            ->join('countries', 'countries.id', '=', 'groupchats.country_id')
            ->join('regions', 'regions.id', '=', 'groupchats.region_id')
            ->join('states', 'states.id', '=', 'groupchats.state_id')
            ->join('districts', 'districts.id', '=', 'groupchats.district_id')
            ->join('zones', 'zones.id', '=', 'groupchats.zone_id')
            ->join('areas', 'areas.id', '=', 'groupchats.area_id');
            if(!empty(request('country_id')) && !empty(request('region_id')) && !empty(request('state_id'))){
                $model = $query->where('groupchats.country_id', request('country_id'))
                                ->where('groupchats.region_id',request('region_id'))
                                ->where('groupchats.state_id',request('state_id'))
                                ->where('groupchats.district_id',request('district_id'))
                                ->where('groupchats.zone_id',request('zone_id'))
                                ->where('groupchats.area_id',request('area_id'))
                                ->where('groupchats.church_id',request('church_id'));
            }
            $model = $query->select([
                'groupchats.id as id',
                'groupchats.name as name',
                'groupchats.code as code',
                'groupchats.description as description',
                'groupchats.status as status',
                'states.name as state_id',
                'countries.name as country_id',
                'regions.name as region_id',
                'districts.name as district_id',
                'zones.name as zone_id',
                'areas.name as area_id',
                'churches.name as church_id',
            ]);

        return $model;
    }

}