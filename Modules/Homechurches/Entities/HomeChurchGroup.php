<?php namespace Modules\Homechurches\Entities;

use Modules\Core\Entities\Base;
use Modules\Core\Presenters\PresentableTrait;

class HomeChurchGroup extends Base {

    use PresentableTrait;

    protected $presenter = 'Modules\Homechurches\Presenters\ModulePresenter';

    protected $guarded = ['_token','exit','group','homechurches_id'];

    public $attachments = ['image'];

    public function setDataAttribute($query)
    {
        return $this->attributes['data'] = json_encode($query);
    }

    public function getDataAttribute($query)
    {
        return json_decode($query);
    }

}