<?php namespace Modules\Homechurches\Repositories;

// use Illuminate\Database\Eloquent\Model;
use Modules\Core\Repositories\RepositoriesAbstract;
use Modules\Homechurches\Entities\Homechurch as Model;
use Modules\Homechurches\Entities\HomeChurchGroup;
use stdClass;

class EloquentHomechurch extends RepositoriesAbstract implements HomechurchInterface
{
    protected $group;
    public function __construct(Model $model, HomeChurchGroup $group)
    {
        $this->model = $model;
        $this->group = $group;
    }

    public function getGroupTable()
    {
        return $this->group->getTable();
    }

    public function createGroup(array $data)
    {
        // Create the model
        $model = $this->group->fill($data);

        if ($model->save()) {
            return $model;
        }

        return false;
    }

    public function groupDelete($id)
    {
        return $this->group->find($id)->delete();
    }

    public function getGroups()
    {
        $model = $this->group->all();
        return $model;
    }

    public function getGroup($id)
    {
        $model = $this->group->where('id', $id)->firstOrFail();
        return $model;
    }

    public function getGroupByType($church_id, $type)
    {
        $model = $this->group->where('church_id', $church_id)->where('type', $type)->get();
        return $model;
    }

    public function getGroupIn($ids)
    {
        $model = $this->group->whereIn('id', $ids)->get();
        return $model;
    }

    public function getAll()
    {
        return $this->model
            ->where('id','!=', '')->get();
    }

    public function byPage($page = 1, $limit = 10, array $with = array(), $all = false)
    {
        $result = new stdClass;
        $result->page = $page;
        $result->limit = $limit;
        $result->totalItems = 0;
        $result->items = array();

        $query = $this->make($with)->where('owner_id',current_user()['id']);

        $totalItems = $query->count();

        $query->order()
            ->skip($limit * ($page - 1))
            ->take($limit);

        $models = $query->get();

        // Put items and totalItems in stdClass
        $result->totalItems = $totalItems;
        $result->items = $models->all();

        return $result;
    }

    public function getGroupForDataTable()
    {
        $query = $this->group->join('churches', 'churches.id', '=', 'home_church_groups.church_id');
        $model = $query->select([
            'home_church_groups.id as id',
            'home_church_groups.name as name',
            'home_church_groups.type as type',
            'churches.name as church',
        ]);

        return $model;
    }

    public function getForDataTable()
    {
        if(!empty(current_user()->churchtype) || !empty(current_user()->homechurch_group)){
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
            ->join('churches', 'churches.id', '=', 'homechurches.church_id')
            ->join('countries', 'countries.id', '=', 'homechurches.country_id')
            ->join('regions', 'regions.id', '=', 'homechurches.region_id')
            ->join('states', 'states.id', '=', 'homechurches.state_id')
            ->join('districts', 'districts.id', '=', 'homechurches.district_id')
            ->join('zones', 'zones.id', '=', 'homechurches.zone_id')
            ->join('areas', 'areas.id', '=', 'homechurches.area_id');
            if(!empty(request('country_id')) && !empty(request('region_id')) && !empty(request('state_id'))){
                $model = $query->where('homechurches.country_id', request('country_id'))
                                ->where('homechurches.region_id',request('region_id'))
                                ->where('homechurches.state_id',request('state_id'))
                                ->where('homechurches.district_id',request('district_id'))
                                ->where('homechurches.zone_id',request('zone_id'))
                                ->where('homechurches.area_id',request('area_id'))
                                ->where('homechurches.church_id',request('church_id'));
            }
            $model = $query->select([
                'homechurches.id as id',
                'homechurches.name as name',
                'homechurches.code as code',
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