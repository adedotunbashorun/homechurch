<?php namespace Modules\Countries\Entities;

use Modules\Core\Entities\Base;
use Modules\Core\Presenters\PresentableTrait;
use Modules\History\Traits\Historable;

class Country extends Base {

    use PresentableTrait,Historable;

    protected $presenter = 'Modules\Countries\Presenters\ModulePresenter';

    protected $guarded = ['_token','exit'];

    public $attachments = ['image'];

    public function regions()
    {
        return $this->hasMany('Modules\Regions\Entities\Region','country_id');
    }

    public function states()
    {
        return $this->hasMany('Modules\States\Entities\State','country_id');
    }

    public function districts()
    {
        return $this->hasMany('Modules\Districts\Entities\District','country_id');
    }

    public function zones()
    {
        return $this->hasMany('Modules\Zones\Entities\Zone','country_id');
    }

    public function areas()
    {
        return $this->hasMany('Modules\Areas\Entities\Area','country_id');
    }

    public function churches()
    {
        return $this->hasMany('Modules\Churches\Entities\Church','country_id');
    }

    public function homechurches()
    {
        return $this->hasMany('Modules\Homechurches\Entities\Homechurch','country_id');
    }

}