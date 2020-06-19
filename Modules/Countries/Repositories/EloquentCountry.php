<?php namespace Modules\Countries\Repositories;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Repositories\RepositoriesAbstract;

class EloquentCountry extends RepositoriesAbstract implements CountryInterface
{

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getAll(array $data = [])
    {
        $query = $this->model->where('id','!=', '');
                // if(!empty($data)){
                //     return $model = $query->select($data)->get();
                // }
        return $model = $query->get();
    }

    public function getForDataTable()
    {
        if(!empty(current_user()->churchtype)){
            $query =  getDataTabeleQuery($this->model);
            return  $model = $query->get();
        }
        $selectArray = config($this->model->getTable() . '.th');
        $selectArray[] = 'id';
        return getDataTabeleQuery($this->model)->select($selectArray);
    }
}