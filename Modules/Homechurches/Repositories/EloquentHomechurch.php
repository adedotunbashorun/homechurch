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

    public function updateGroup(array $data)
    {
        $model = $this->group->find($data['id']);

        $model->fill($data);

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

    public function getGroupForDataTable($id = null)
    {
        if(request()->get('type'))
        {
            $query = getDataTabeleQuery($this->group)->whereType(request()->get('type'))->with(['church' => function($querys) {
                return $querys->select('id','name');
            }]);
            if(!empty($id)){
                return $query->whereChurchId($id)->get();
            }
            return $query->get();
        }
        $query = $this->group->with(['church' => function($querys) {
            return $querys->select('id','name');
        }])->get();

        return $query;
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
                }])->with(['church' => function($querys) {
                    return $querys->select('id','name');
                }]);
        if(!empty(current_user()->churchtype) || !empty(current_user()->homechurch_group)){
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
        if(!empty(request('country_id')) && !empty(request('region_id')) && !empty(request('state_id'))){
            $model = $query->where('homechurches.country_id', request('country_id'))
                            ->where('homechurches.region_id',request('region_id'))
                            ->where('homechurches.state_id',request('state_id'))
                            ->where('homechurches.district_id',request('district_id'))
                            ->where('homechurches.zone_id',request('zone_id'))
                            ->where('homechurches.area_id',request('area_id'))
                            ->where('homechurches.church_id',request('church_id'));
        }
        $model = $query->get();
        return $model;
    }

}