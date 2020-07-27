<?php namespace Modules\Attendance\Entities;

use Modules\Core\Entities\Base;
use Modules\Core\Presenters\PresentableTrait;
use Modules\History\Traits\Historable;

class Attendance extends Base {

    use PresentableTrait,Historable;

    protected $presenter = 'Modules\Attendance\Presenters\ModulePresenter';
    protected $table = 'attendance';

    protected $guarded = ['_token','exit'];

    public $attachments = ['image'];
    
    public function homechurches()
    {
        return $this->belongsTo('Modules\Homechurches\Entities\Homechurch','homechurch_id');
    }

}