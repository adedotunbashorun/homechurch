<?php namespace Modules\Offering\Repositories;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Repositories\RepositoriesAbstract;

class EloquentOffering extends RepositoriesAbstract implements OfferingInterface
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
        return getOfferingDataTabeleQuery($this->model)->count();
    }

    public function getOffering()
    {
        return getOfferingDataTabeleQuery($this->model);
    }

    // public function getForDataTable()
    // {
    //     // $query = $this->model
    //     //     // ->join('offering.offeringable_table', 'offering.offeringable_table.id', '=', 'offering.offeringable_id')
    //     //     ->join('homechurches', 'homechurches.id', '=', 'homechurches.groupchat_id')
    //     //     ->join('groupchats', 'groupchats.id', '=', 'offering.groupchat_id')
    //     //     ->select([
    //     //         'offering.id as id',
    //     //         'offering.amount as amount',
    //     //         'offering.date as date',
    //     //         'homechurches.name as church_id',
    //     //         // 'groupchats.name as church_id',
    //     //     ]);

    //     // return $query;
    // }

}