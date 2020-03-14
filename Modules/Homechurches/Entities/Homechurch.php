<?php namespace Modules\Homechurches\Entities;

use Modules\Core\Entities\Base;
use Modules\Core\Presenters\PresentableTrait;

class Homechurch extends Base {

    use PresentableTrait;

    protected $presenter = 'Modules\Homechurches\Presenters\ModulePresenter';

    protected $guarded = ['_token','exit'];

    public $attachments = ['image'];

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function hasUser($user_id)
    {
        foreach ($this->users as $user) {
            if($user->id == $user_id) {
                return true;
            }
        }
    }

}