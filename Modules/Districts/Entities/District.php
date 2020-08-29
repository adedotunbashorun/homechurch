<?php namespace Modules\Districts\Entities;

use Modules\Core\Entities\Base;
use Modules\Core\Presenters\PresentableTrait;
use Modules\History\Traits\Historable;

class District extends Base {

    use PresentableTrait;
    use Historable;

    protected $presenter = 'Modules\Districts\Presenters\ModulePresenter';

    protected $guarded = ['_token','exit'];

    public $attachments = ['image'];

    public function country()
    {
        return $this->belongsTo('Modules\Countries\Entities\Country','country_id');
    }

    public function region()
    {
        return $this->belongsTo('Modules\Regions\Entities\Region','region_id');
    }

    public function state()
    {
        return $this->belongsTo('Modules\States\Entities\State','state_id');
    }

}