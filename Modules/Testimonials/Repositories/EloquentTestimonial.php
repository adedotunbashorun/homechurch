<?php namespace Modules\Testimonials\Repositories;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Repositories\RepositoriesAbstract;

class EloquentTestimonial extends RepositoriesAbstract implements TestimonialInterface
{

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getForDataTable()
    {
        $query = (current_user()->hasRoleName('admin')) ? $this->model->join('users','users.id','=','testimonials.user_id')->orderBy('id','desc') :
        $this->model->where('user_id',current_user()->id)->join('users','users.id','=','testimonials.user_id')->orderBy('id','desc');

        $model = $query->select([
            'testimonials.id as id',
            'testimonials.name as name',
            'testimonials.body as body',
            'testimonials.status as status',
            'users.first_name as first_name',
            'users.last_name as last_name',
        ]);

        return $model;
    }

}