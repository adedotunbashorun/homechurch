<?php namespace Modules\Dashboard\Http\Controllers;

use Modules\Core\Http\Controllers\BaseAdminController;
use Nwidart\Modules\Routing\Controller;
use Carbon\Carbon;
use DB;

class DashboardController extends Controller {

    public function __construct()
    {
        $this->middleware('auth.admin');
    }

	public function index()
	{
        if (current_user()->hasRoleName('user')) {
	        return redirect()->route('account.dashboard');
	    }
        $data['users'] = app('Modules\Users\Entities\Sentinel\User')::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->limit(5)->get();
        $data['homechurches'] = app('Modules\Homechurches\Entities\Homechurch')::where('owner_id','!=', null)
                    ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->limit(5)->get();
		return view('dashboard::index')->with($data);
	}

}