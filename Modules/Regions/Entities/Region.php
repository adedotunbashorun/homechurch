<?php namespace Modules\Regions\Entities;

use Modules\Core\Entities\Base;
use Modules\Core\Presenters\PresentableTrait;
use Modules\History\Traits\Historable;

class Region extends Base {

    use PresentableTrait;
    use Historable;

    protected $presenter = 'Modules\Regions\Presenters\ModulePresenter';

    protected $guarded = ['_token','exit'];

    public $attachments = ['image'];

    public function country()
    {
        return $this->belongsTo('Modules\Countries\Entities\Country','country_id');
    }

    public function states()
    {
        return $this->hasMany('Modules\States\Entities\State','region_id');
    }

    public function districts()
    {
        return $this->hasMany('Modules\Districts\Entities\District','region_id');
    }

    public function zones()
    {
        return $this->hasMany('Modules\Zones\Entities\Zone','region_id');
    }

    public function areas()
    {
        return $this->hasMany('Modules\Areas\Entities\Area','region_id');
    }

    public function churches()
    {
        return $this->hasMany('Modules\Churches\Entities\Church','region_id');
    }

    public function homechurches()
    {
        return $this->hasMany('Modules\Homechurches\Entities\Homechurch','region_id');
    }
}