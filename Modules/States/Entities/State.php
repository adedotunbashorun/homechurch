<?php namespace Modules\States\Entities;

use Modules\Core\Entities\Base;
use Modules\Core\Presenters\PresentableTrait;
use Modules\History\Traits\Historable;

class State extends Base {

    use PresentableTrait;
    use Historable;

    protected $presenter = 'Modules\States\Presenters\ModulePresenter';

    protected $fillable = [];

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

    public function districts()
    {
        return $this->hasMany('Modules\Districts\Entities\District','state_id');
    }

    public function zones()
    {
        return $this->hasMany('Modules\Zones\Entities\Zone','state_id');
    }

    public function areas()
    {
        return $this->hasMany('Modules\Areas\Entities\Area','state_id');
    }

    public function churches()
    {
        return $this->hasMany('Modules\Churches\Entities\Church','state_id');
    }

    public function homechurches()
    {
        return $this->hasMany('Modules\Homechurches\Entities\Homechurch','state_id');
    }

}