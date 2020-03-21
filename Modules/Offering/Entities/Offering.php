<?php namespace Modules\Offering\Entities;

use Modules\Core\Entities\Base;
use Modules\Core\Presenters\PresentableTrait;

class Offering extends Base {

    use PresentableTrait;

    protected $presenter = 'Modules\Offering\Presenters\ModulePresenter';

    protected $guarded = ['_token','exit','type'];

    public $attachments = ['image'];

    protected $table = 'offering';

    public function offeringable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(config('auth.providers.users.model'));
    }
}