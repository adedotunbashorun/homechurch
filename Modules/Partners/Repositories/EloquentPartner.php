<?php namespace Modules\Partners\Repositories;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Repositories\RepositoriesAbstract;

class EloquentPartner extends RepositoriesAbstract implements PartnerInterface
{

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

}