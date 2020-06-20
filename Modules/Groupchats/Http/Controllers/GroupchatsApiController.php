<?php namespace Modules\Groupchats\Http\Controllers;

use Modules\Core\Http\Controllers\BaseApiController;
use Modules\Groupchats\Repositories\GroupchatInterface as Repository;

class GroupchatsApiController extends BaseApiController {

    public function __construct(Repository $repository)
    {
        parent::__construct($repository);
    }

    public function getByChurch($id)
    {
        return response()->json([
            'groupchats' => $this->repository->getModel()->where('church_id',$id)->whereStatus(1)->get(),
            'success' => true
        ], 200);
    }

    public function getByState($id)
    {
        return response()->json([
            'groupchats' => $this->repository->getModel()->where('state_id',$id)->whereStatus(1)->get(),
            'success' => true
        ], 200);
    }

}
