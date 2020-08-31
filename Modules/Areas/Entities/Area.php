<?php namespace Modules\Areas\Entities;

use Modules\Core\Entities\Base;
use Modules\Core\Presenters\PresentableTrait;
use Modules\History\Traits\Historable;

class Area extends Base {

    use PresentableTrait,Historable;

    protected $presenter = 'Modules\Areas\Presenters\ModulePresenter';

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

    public function district()
    {
        return $this->belongsTo('Modules\Districts\Entities\District','district_id');
    }

    public function zone()
    {
        return $this->belongsTo('Modules\Zones\Entities\Zone','zone_id');
    }

    public function churches()
    {
        return $this->hasMany('Modules\Churches\Entities\Church','area_id');
    }

    public function homechurches()
    {
        return $this->hasMany('Modules\Homechurches\Entities\Homechurch','area_id');
    }

}