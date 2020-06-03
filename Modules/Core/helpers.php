<?php

use Illuminate\Support\Str;
use Modules\Users\Entities\ChurchLeader;
use Modules\Users\Entities\Sentinel\User;
use Modules\Churches\Entities\Church;
use Modules\Areas\Entities\Area;
use Modules\Zones\Entities\Zone;
use Modules\Districts\Entities\District;
use Modules\States\Entities\State;
use Modules\Regions\Entities\Region;

if(!function_exists('generate_datatable')){
    function generate_datatable($table_headings){
        $str = '';
        $str .= '<table class="table table-bordered table-hover" id="data-table"><thead><tr>';
        foreach($table_headings as $th){
            $th = str_replace('_',' ',$th);
            $str .= '<th>'.ucwords($th).'</th>';
        }
        $str .= '<th></th>';
        $str .= '</tr></thead></table>';
        return $str;
    }
}

if(!function_exists('get_pages')){
    function get_pages()
    {
        $model = app('Modules\Pages\Repositories\PageInterface');
        return $model->select('all', false,'title','id');
    }
}
if(!function_exists('get_current_church')){
    function get_current_church($id = '')
    {
        $user_id = empty($id) ? current_user()->id : $id;
        return current_user()::getChurch($user_id);
    }
}

if(!function_exists('getDataTabeleQuery')){
    function getDataTabeleQuery($model){
        $churchtype = get_current_church();
        if(!empty($churchtype)){
            if(current_user()->hasChurch('groupchat')){
                return $query = $model->whereId(get_current_church()->churchleaderable_id);
            }elseif(current_user()->hasChurch('homechurch')){
                return $query = $model->whereId(get_current_church()->churchleaderable_id);
            }elseif(current_user()->hasChurch('church')){
                return $query = ($model->getTable() == 'churches') ? $model->whereId(get_current_church()->churchleaderable_id) : $model->whereChurchId(get_current_church()->churchleaderable_id);
            }elseif(current_user()->hasChurch('area')){
                return $query = ($model->getTable() == 'areas') ? $model->whereId(get_current_church()->churchleaderable_id) : $model->whereAreaId(get_current_church()->churchleaderable_id);
            }elseif(current_user()->hasChurch('zone')){
                return $query = ($model->getTable() == 'zones') ? $model->whereId(get_current_church()->churchleaderable_id) : $model->whereZoneId(get_current_church()->churchleaderable_id);
            }elseif(current_user()->hasChurch('district')){
                return $query = ($model->getTable() == 'districts') ? $model->whereId(get_current_church()->churchleaderable_id) : $model->whereDistrictId(get_current_church()->churchleaderable_id);
            }elseif(current_user()->hasChurch('state')){
                return $query = ($model->getTable() == 'states') ? $model->whereId(get_current_church()->churchleaderable_id) : $model->whereStateId(get_current_church()->churchleaderable_id);
            }elseif(current_user()->hasChurch('region')){
                $query = ($model->getTable() == 'regions') ? $model->whereId(get_current_church()->churchleaderable_id) : $model->whereRegionId(get_current_church()->churchleaderable_id);
            }else{
                return $query = $model;
            }
        }else{
            return $query = $model;
        }
    }
}

if(!function_exists('getOfferingDataTabeleQuery')){
    function getOfferingDataTabeleQuery($model){
        $churchtype = get_current_church();
        if(empty($churchtype)) {
            return $model;
        }
        $type = $churchtype['type'];
        switch ($type) {
            case 'homechurch':
                $home = \Homechurches::allBy('id',get_current_church()->churchleaderable_id)->pluck('id');
                return $model->whereIn('homechurch_id', $home);
                break;
            case 'groupchat':
                $group = \Groupchats::allBy('id',get_current_church()->churchleaderable_id)->pluck('id');
                return $model->whereIn('groupchat_id', $group);
                break;
            case'church':
                $church = \Churches::allBy('id',get_current_church()->churchleaderable_id)->pluck('id');
                $home = \Homechurches::allByIn('church_id',$church);
                $group = \Groupchats::allByIn('church_id',$church);
                return $model->whereIn('groupchat_id', $group)->orWhereIn('homechurch_id', $home);
                break;
            case 'area':
                $church = \Churches::allBy('area_id',get_current_church()->churchleaderable_id)->pluck('id');
                $home = \Homechurches::allByIn('church_id',$church);
                $group = \Groupchats::allByIn('church_id',$church);
                return $model->whereIn('groupchat_id', $group)->orWhereIn('homechurch_id', $home);
                break;
            case 'zone':
                $church = \Churches::allBy('zone_id',get_current_church()->churchleaderable_id)->pluck('id');
                $home = \Homechurches::allByIn('church_id',$church);
                $group = \Groupchats::allByIn('church_id',$church);
                return $model->whereIn('groupchat_id', $group)->orWhereIn('homechurch_id', $home);
                break;
            case 'district':
                $church = \Churches::allBy('district_id',get_current_church()->churchleaderable_id)->pluck('id');
                $home = \Homechurches::allByIn('church_id',$church);
                $group = \Groupchats::allByIn('church_id',$church);
                return $model->whereIn('groupchat_id', $group)->orWhereIn('homechurch_id', $home);
                break;
            case 'state':
                $church = \Churches::allBy('state_id',get_current_church()->churchleaderable_id)->pluck('id');
                $home = \Homechurches::allByIn('church_id',$church);
                $group = \Groupchats::allByIn('church_id',$church);
                return $model->whereIn('groupchat_id', $group)->orWhereIn('homechurch_id', $home);
                break;
            case    'region':
                $church = \Churches::allBy('region_id',get_current_church()->churchleaderable_id)->pluck('id');
                $home = \Homechurches::allByIn('church_id',$church);
                $group = \Groupchats::allByIn('church_id',$church);
                return $model->whereIn('groupchat_id', $group)->orWhereIn('homechurch_id', $home);
                break;
            default:
                return $model;
                break;
        }
        
    }
}

if(!function_exists('pluck_user_church'))
{
    function pluck_user_church()
    {
        $churchtype = get_current_church();
        if(empty($churchtype)) {
            return Churches::getAll();
        }
        $type = $churchtype['type'];
        switch ($type) {
            case 'church':
                return \Churches::allBy('id',get_current_church()->churchleaderable_id);
                break;
            case 'area':
                return \Churches::allBy('area_id',get_current_church()->churchleaderable_id);
                break;
            case 'zone':
                return \Churches::allBy('zone_id',get_current_church()->churchleaderable_id);
                break;
            case 'district':
                return \Churches::allBy('district_id',get_current_church()->churchleaderable_id);
                break;
            case 'state':
                return \Churches::allBy('state_id',get_current_church()->churchleaderable_id);
                break;
            case 'region':
                return \Churches::allBy('region_id',get_current_church()->churchleaderable_id);
                break;
            default:
                return Churches::getAll();
                break;
        }
    }
}

if(!function_exists('pluck_user_homechurch'))
{
    function pluck_user_homechurch()
    {
        $churchtype = get_current_church();
        if(empty($churchtype)) {
            return Homechurches::getAll();
        }
        $type = $churchtype['type'];
        switch ($type) {
            case 'homechurch':
                return \Homechurches::allBy('id',get_current_church()->churchleaderable_id);
                break;
            case'church':
                $church = \Churches::allBy('id',get_current_church()->churchleaderable_id)->pluck('id');
                return \Homechurches::allByIn('church_id',$church);
                break;
            case 'area':
                $church = \Churches::allBy('area_id',get_current_church()->churchleaderable_id)->pluck('id');
                return \Homechurches::allByIn('church_id',$church);
                break;
            case 'zone':
                $church = \Churches::allBy('zone_id',get_current_church()->churchleaderable_id)->pluck('id');
                return \Homechurches::allByIn('church_id',$church);
                break;
            case 'district':
                $church = \Churches::allBy('district_id',get_current_church()->churchleaderable_id)->pluck('id');
                return \Homechurches::allByIn('church_id',$church);
                break;
            case 'state':
                $church = \Churches::allBy('state_id',get_current_church()->churchleaderable_id)->pluck('id');
                return \Homechurches::allByIn('church_id',$church);
                break;
            case    'region':
                $church = \Churches::allBy('region_id',get_current_church()->churchleaderable_id)->pluck('id');
                return \Homechurches::allByIn('church_id',$church);
                break;
            default:
                return Homechurches::all([],true);
                break;
        }
    }
}

if(!function_exists('pluck_user_groupchats'))
{
    function pluck_user_groupchats()
    {
        $churchtype = get_current_church();
        if(empty($churchtype)) {
            return Groupchats::getAll();
        }
        $type = $churchtype['type'];
        switch ($type) {
            case 'groupchat':
                return \Groupchats::allBy('id',get_current_church()->churchleaderable_id);
                break;
            case'church':
                $church = \Churches::allBy('id',get_current_church()->churchleaderable_id)->pluck('id');
                return \Groupchats::allByIn('church_id',$church);
                break;
            case 'area':
                $church = \Churches::allBy('area_id',get_current_church()->churchleaderable_id)->pluck('id');
                return \Groupchats::allByIn('church_id',$church);
                break;
            case 'zone':
                $church = \Churches::allBy('zone_id',get_current_church()->churchleaderable_id)->pluck('id');
                return \Groupchats::allByIn('church_id',$church);
                break;
            case 'district':
                $church = \Churches::allBy('district_id',get_current_church()->churchleaderable_id)->pluck('id');
                return \Groupchats::allByIn('church_id',$church);
                break;
            case 'state':
                $church = \Churches::allBy('state_id',get_current_church()->churchleaderable_id)->pluck('id');
                return \Groupchats::allByIn('church_id',$church);
                break;
            case    'region':
                $church = \Churches::allBy('region_id',get_current_church()->churchleaderable_id)->pluck('id');
                return \Groupchats::allByIn('church_id',$church);
                break;
            default:
                return Groupchats::all([],true);
                break;
        }
    }
}

if(!function_exists('getChurchFormData')){
    function getChurchFormData(){
        $churchtype =  get_current_church();
        if(!empty($churchtype)){
            if($churchtype->type == 'church'){
                return Church::whereId($churchtype->churchleaderable_id)->get();
            }
            if($churchtype->type == 'area'){
                return Church::whereAreaId($churchtype->churchleaderable_id)->get();
            }
            if($churchtype->type == 'zone'){
                return Church::whereZoneId($churchtype->churchleaderable_id)->get();
            }
            if($churchtype->type == 'district'){
                return Church::whereDistrictId($churchtype->churchleaderable_id)->get();
            }
            if($churchtype->type == 'state'){
                return Church::whereStateId($churchtype->churchleaderable_id)->get();
            }
            if($churchtype->type == 'region'){
                return Church::whereRegionId($churchtype->churchleaderable_id)->get();
            }
        }else{
            return $query = [];
        }
    }
}

if(!function_exists('getAreaFormData')){
    function getAreaFormData(){
        $churchtype = get_current_church();
        if(!empty($churchtype)){
            if($churchtype->type == 'area'){
                return Area::whereId($churchtype->churchleaderable_id)->get();
            }
            if($churchtype->type == 'zone'){
                return Area::whereZoneId($churchtype->churchleaderable_id)->get();
            }
            if($churchtype->type == 'district'){
                return Area::whereDistrictId($churchtype->churchleaderable_id)->get();
            }
            if($churchtype->type == 'state'){
                return Area::whereStateId($churchtype->churchleaderable_id)->get();
            }
            if($churchtype->type == 'region'){
                return Area::whereRegionId($churchtype->churchleaderable_id)->get();
            }
        }else{
            return $query = [];
        }
    }
}

if(!function_exists('getZoneFormData')){
    function getZoneFormData(){
        $churchtype = get_current_church();
        if(!empty($churchtype)){
            if($churchtype->type == 'zone'){
                return Zone::whereId($churchtype->churchleaderable_id)->get();
            }
            if($churchtype->type == 'district'){
                return Zone::whereDistrictId($churchtype->churchleaderable_id)->get();
            }
            if($churchtype->type == 'state'){
                return Zone::whereStateId($churchtype->churchleaderable_id)->get();
            }
            if($churchtype->type == 'region'){
                return Zone::whereRegionId($churchtype->churchleaderable_id)->get();
            }
        }else{
            return $query = [];
        }
    }
}

if(!function_exists('getDistrictFormData')){
    function getDistrictFormData(){
        $churchtype = get_current_church();
        if(!empty($churchtype)){
            if($churchtype->type == 'district'){
                return District::whereId($churchtype->churchleaderable_id)->get();
            }
            if($churchtype->type == 'state'){
                return District::whereStateId($churchtype->churchleaderable_id)->get();
            }
            if($churchtype->type == 'region'){
                return District::whereRegionId($churchtype->churchleaderable_id)->get();
            }
        }else{
            return $query = [];
        }
    }
}

if(!function_exists('getStateFormData')){
    function getStateFormData(){
        $churchtype = get_current_church();
        if(!empty($churchtype)){
            if($churchtype->type == 'state'){
                return State::whereId($churchtype->churchleaderable_id)->get();
            }
            if($churchtype->type == 'region'){
                return State::whereRegionId($churchtype->churchleaderable_id)->get();
            }
        }else{
            return $query = [];
        }
    }
}

if(!function_exists('get_categories')){
    function get_categories($type='publication')
    {
        $model = app('Modules\Categories\Repositories\CategoryInterface');
        return $model->allBy('type',$type)->pluck('title', 'id')->all();
    }
}

if(!function_exists('get_relationship')){
    function get_relationship($data)
    {
        if(!empty($data['church_id'])){
            $res = Church::whereId($data['church_id'])->first();
            $data['country_id'] = $res->country_id;
            $data['region_id'] = $res->region_id;
            $data['state_id'] = $res->state_id;
            $data['district_id'] = $res->district_id;
            $data['zone_id'] = $res->zone_id;
            $data['area_id'] = $res->area_id;
        }
        if(!empty($data['area_id'])){
            $res = Area::whereId($data['area_id'])->first();
            $data['country_id'] = $res->country_id;
            $data['region_id'] = $res->region_id;
            $data['state_id'] = $res->state_id;
            $data['district_id'] = $res->district_id;
            $data['zone_id'] = $res->zone_id;
        }
        if(!empty($data['zone_id'])){
            $res = Zone::whereId($data['zone_id'])->first();
            $data['country_id'] = $res->country_id;
            $data['region_id'] = $res->region_id;
            $data['state_id'] = $res->state_id;
            $data['district_id'] = $res->district_id;
        }
        if(!empty($data['district_id'])){
            $res = District::whereId($data['district_id'])->first();
            $data['country_id'] = $res->country_id;
            $data['region_id'] = $res->region_id;
            $data['state_id'] = $res->state_id;
        }
        if(!empty($data['state_id'])){
            $res = State::whereId($data['state_id'])->first();
            $data['country_id'] = $res->country_id;
            $data['region_id'] = $res->region_id;
        }
        if(!empty($data['region_id'])){
            $res = Region::whereId($data['region_id'])->first();
            $data['country_id'] = $res->country_id;
        }
        return $data;
    }
}
if(!function_exists('get_unassigned_members')){
    function get_unassigned_members($users)
    {
        return \Modules\Users\Entities\Sentinel\User::whereNotIn('id', $users)->pluck('last_name','id')->all();
    }
}

if(!function_exists('get_assigned_members')){
    function get_assigned_members($users)
    {
        return \Modules\Users\Entities\Sentinel\User::whereIn('id', $users)->pluck('name','id')->all();
    }
}

if(!function_exists('get_faq_categories')){
    function get_faq_categories()
    {
        $model = app('Modules\Faqs\Repositories\FaqCategoryInterface');
        return $model->select('all', false,'category','category_id')->toArray();
    }
}

if(!function_exists('delete_btn')){
    function delete_btn($route='',$confirm=null){
        if(is_null($confirm)){
            $confirm = trans('core::global.delete_record');
        }
        return '<a class="btn btn-danger btn-sm delete-me btn-icon tooltips" href="'.$route.'" data-confirm="'.$confirm.'" data-placement="top" data-original-title="Delete">
                    <i class="fa fa-trash"></i>
                </a>';
    }
}

if(!function_exists('edit_btn')){
    function edit_btn($route=''){
        return '<a class="btn btn-primary btn-sm btn-icon tooltips" href="'.$route.'" data-placement="top" data-original-title="Edit">
                    <i class="fa fa-edit"></i>
                </a>';
    }
}

if(!function_exists('single_btn')){
    function single_btn($route='',$text=false){
        $text = ($text) ? $text : '';
        return '<a class="btn btn-warning btn-sm btn-icon tooltips" href="'.$route.'" data-placement="top" data-original-title="View Details">
                    <i class="fa fa-eye"></i>'.$text.'
                </a>';
    }
}
if(!function_exists('view_btn')){
    function view_btn($route='',$text=''){
        $text = !empty($text) ? $text : '';
        return '<a class="btn btn-info btn-sm" href="'.$route.'" data-placement="top" data-original-title="View Details">
                    <i class="fa fa-eye"></i>'.$text.'
                </a>';
    }
}

if(!function_exists('ajax_edit_btn')){
    function ajax_edit_btn($route=''){
        return '<a class="btn btn-warning btn-xs ajax-modal-link" href="" data-toggle="modal" data-href="'.$route.'">
                        <i class="fa fa-pencil"></i>
                    </a>';
    }
}

if(!function_exists('download_btn')){
    function download_btn($route){
        return '<a class="btn btn-warning btn-xs" href="'.$route.'">
            <i class="fa fa-eye"></i>
        </a>';
    }
}

if(!function_exists('approve_btn')){
    function approve_btn($route='',$text=''){
        $text = !empty($text) ? $text : '';
        return '<a class="btn btn-success btn-sm" href="'.$route.'" data-placement="top" data-original-title="Approve">
                    <i class="fa fa-check"></i>'.$text.'
                </a>';
    }
}

    /**
     * Return the user friendly date
     * @param null $date
     * @return string
     */
if(!function_exists('format_date')){
    function format_date($date = null)
    {
        if(!is_null($date) && $date != '0000-00-00'){
            $date = new DateTime($date);
            return $date->format('d/m/Y');
        }
        return null;
    }
}

if(!function_exists('format_datetime')){
    function format_datetime($date = null)
    {
        $date = new DateTime($date);
        return $date->format('d/m/Y H:i');
    }
}

    /**
     * Return the database time
     * @param null $userDate
     * @return null|string
     */
if(!function_exists('unformat_date')){
    function unformat_date($userDate = null)
    {
        if ($userDate)
        {
            $date = DateTime::createFromFormat('d/m/Y', $userDate);

            return $date->format('Y-m-d');
        }

        return '0000-00-00';
    }
}

if(!function_exists('unformat_datetime')){
    function unformat_datetime($userDate = null)
    {
        if ($userDate)
        {
            $date = DateTime::createFromFormat('d/m/Y H:i', $userDate);

            return $date->format('Y-m-d H:i');
        }

        return '0000-00-00';
    }
}

if(!function_exists('file_upload')){
    function file_upload($file, $dir = null)
    {
        if ($file)
        {
            // Generate random dir
            if ( ! $dir) $dir = str_random(8);

            // Get file info and try to move
            $destination = public_path() .  '/uploads/' . $dir;
            $filename    = str_random(12).'.'.$file->getClientOriginalExtension();
            //dd($filename);
            $path        = '/uploads/' . $dir  . $filename;
            $uploaded    = $file->move($destination, $filename);

            if ($uploaded) return array('path'=>$path,'filename'=>$filename);
        }
    }
}

if(!function_exists('process_photo')){
    function process_photo($request, $photopath){
        $file = $request->file('photo');
        $random_name = str_random(8);
        $destinationPath = $photopath;
        $extension = $file->getClientOriginalExtension();
        $filename = $random_name . '_cover.' . $extension;
        $uploadSuccess = $request->file('photo')
            ->move($destinationPath, $filename);
        return $filename;
    }
}

if(!function_exists('small_avatar')){
    function small_avatar($path,$attr=['class'=>'img-circle pull-left margin-right-10','style'=>'width:30px;']){
        if($path == ''){
            return \HTML::image('assets/admin/theme/img/avatar.png', 'profile photo', $attr);
        }
        return \HTML::image($path, 'profile photo', $attr);

    }
}

if(!function_exists('large_avatar')){
    function large_avatar($path,$attr=['class'=>'img-responsive']){
        if($path == ''){
            return \HTML::image('assets/admin/theme/img/profile.jpg', 'profile photo', $attr);
        }
        return \HTML::image('uploads/photos/'.$path, 'profile photo', $attr);

    }
}

if(!function_exists('status_label')){
    function status_label($status){
        if($status ==1){
            return '<label class="kt-badge kt-badge--inline kt-badge--success">Active</label>';
        }else{
            return '<label class="kt-badge kt-badge--inline kt-badge--danger">Inactive</label>';
        }
    }
}

if(!function_exists('is_featured_label')){
    function is_featured_label($status){
        if($status ==1){
            return '<label class="kt-badge kt-badge--inline kt-badge--success">Yes</label>';
        }else{
            return '<label class="kt-badge kt-badge--inline kt-badge--danger">No</label>';
        }
    }
}

if(!function_exists('payment_status_label')){
    function payment_status_label($status){
        if($status ==1){
            return '<label class="label label-success">Completed</label>';
        }else{
            return '<label class="label label-danger">Pending</label>';
        }
    }
}

if(!function_exists('readable_date')){
    function readable_date($date){
        return date('M d',strtotime($date));
    }
}

if(!function_exists('get_payment_plans')){
    function get_payment_plans(){
        return [
            'full'=>'Full Payment (Registration Fee and Total Amount)',
            'reg_only'=>'Registration Fee only',
            'reg_amount'=>'Registration and Any Amount'
        ];
    }
}

if(!function_exists('range_dropdown')){
    function range_dropdown($low,$high){
        $array = range($low,$high);
        $new_array = [];
        foreach($array as $a){
            $a = sprintf('%02d', $a);
            $new_array[$a] = $a;
        }
        return $new_array;
    }
}

if(!function_exists('format_currency')){
    function format_currency($amount)
    {

        $currency_symbol           = '$';
        $currency_symbol_placement = 'before';
        $thousands_separator       = ',';
        $decimal_point             = false;

        if ($currency_symbol_placement == 'before')
        {
            return $currency_symbol . number_format($amount, ($decimal_point) ? 2 : 0, $decimal_point, $thousands_separator);
        }
        else
        {
            return number_format($amount, ($decimal_point) ? 2 : 0, $decimal_point, $thousands_separator) . $currency_symbol;
        }
    }
}

if(!function_exists('format_amount')){
    function format_amount($amount = NULL)
    {
        if ($amount)
        {
            $decimal_point             = '.';

            return number_format($amount, ($decimal_point) ? 2 : 0, $decimal_point, '');
        }
        return NULL;
    }
}

if(!function_exists('standardize_amount')){
    function standardize_amount($amount)
    {
        $thousands_separator       = ',';
        $decimal_point             = '.';

        $amount = str_replace($thousands_separator, '', $amount);
        $amount = str_replace($decimal_point, '.', $amount);

        return $amount;
    }
}

if(!function_exists('range_dob_day')){
    function range_dob_day()
    {
        $dayRange = range(1, 31);
        $new_array = array(''=>'Day');
        foreach($dayRange as $key=> $dayNumber)
        {
            $new_array[$dayNumber] = $dayNumber;
        }
        return $new_array;
    }
}

if(!function_exists('range_dob_month')){
    function range_dob_month()
    {
        $monthRange = range(1,12);
        $new_array = array(''=>'Month');
        foreach($monthRange as $key=>$month)
        {
            $new_array[$month] = $month;
        }
        return $new_array;
    }
}

if(!function_exists('range_dob_year')){
    function range_dob_year()
    {
        $yearRange = range(1997, 1940);
        $new_array = array('' => 'Year');
        foreach ($yearRange as $key => $year) {
            $new_array[$year] = $year;
        }
        return $new_array;
    }
}

if(!function_exists('get_current_date')){
    function get_current_date(){
        $current_date = new Carbon\Carbon('this day');
        return $current_date->toDateTimeString();
    }
}

if(!function_exists('calculatePercentage')){
    function calculatePercentage($value,$total){
        return round($value/$total * 100);
    }
}

if(!function_exists('get_days')){
    function get_days(){
        return ['Sunday','Monday', 'Tuesday', 'Wednesday','Thursday','Friday','Saturday'];
    }
}

if(!function_exists('title_few')){
    function title_few($text,$limit){
        $text = strip_tags($text);
        $text = Str::words($text,$limit);
        return $text;
    }
}

if(!function_exists('get_type')) {
    function get_type($request) {
        $type = $request['type'];
        $check = ChurchLeader::whereUserId($request['user_id'])->first();
        switch ($type) {
            case 'homechurch':
                $data['user_id'] = $request['user_id'];
                $data['churchleaderable_id'] = $request['homechurch_id'];
                $data['churchleaderable_type'] = "Modules\Homechurches\Entities\Homechurch";
                $data['churchleaderable_table'] = "churches";
                $data['type'] = $type;
                if(empty($check)){
                    ChurchLeader::create($data);
                    $user = User::whereId($request['user_id'])->first();
                    $user->churchtype = 'homechurch';
                    $user->save();
                }
                break;
            case 'groupchat':
                $data['user_id'] = $request['user_id'];
                $data['churchleaderable_id'] = $request['groupchat_id'];
                $data['churchleaderable_type'] = "Modules\Groupchats\Entities\Groupchat";
                $data['churchleaderable_table'] = "churches";
                $data['type'] = $type;
                if(empty($check)){
                    ChurchLeader::create($data);
                    $user = User::whereId($request['user_id'])->first();
                    $user->churchtype = 'groupchat';
                    $user->save();
                }
                break;
            case 'church':
                $data['user_id'] = $request['user_id'];
                $data['churchleaderable_id'] = $request['church_id'];
                $data['churchleaderable_type'] = "Modules\Churches\Entities\Church";
                $data['churchleaderable_table'] = "churches";
                $data['type'] = $type;
                if(empty($check)){
                    ChurchLeader::create($data);
                    $user = User::whereId($request['user_id'])->first();
                    $user->churchtype = 'church';
                    $user->save();
                }
                break;
            case 'area':
                $data['user_id'] = $request['user_id'];
                $data['churchleaderable_id'] = $request['area_id'];
                $data['churchleaderable_type'] = "Modules\Areas\Entities\Area";
                $data['churchleaderable_table'] = "areas";
                $data['type'] = $type;if(empty($check)){
                    ChurchLeader::create($data);
                    $user = User::whereId($request['user_id'])->first();
                    $user->churchtype = 'area';
                    $user->save();
                }
                break;
            case 'zone':
                $data['user_id'] = $request['user_id'];
                $data['churchleaderable_id'] = $request['zone_id'];
                $data['churchleaderable_type'] = "Modules\Zones\Entities\Zone";
                $data['churchleaderable_table'] = "zones";
                $data['type'] = $type;if(empty($check)){
                    ChurchLeader::create($data);
                    $user = User::whereId($request['user_id'])->first();
                    $user->churchtype = 'zone';
                    $user->save();
                }
                break;
            case 'district':
                $data['user_id'] = $request['user_id'];
                $data['churchleaderable_id'] = $request['district_id'];
                $data['churchleaderable_type'] = "Modules\Districts\Entities\District";
                $data['churchleaderable_table'] = "districts";
                $data['type'] = $type;if(empty($check)){
                    ChurchLeader::create($data);
                    $user = User::whereId($request['user_id'])->first();
                    $user->churchtype = 'district';
                    $user->save();
                }
                break;
            case 'state':
               $data['user_id'] = $request['user_id'];
                $data['churchleaderable_id'] = $request['state_id'];
                $data['churchleaderable_type'] = "Modules\States\Entities\State";
                $data['churchleaderable_table'] = "states";
                $data['type'] = $type;if(empty($check)){
                    ChurchLeader::create($data);
                    $user = User::whereId($request['user_id'])->first();
                    $user->churchtype = 'state';
                    $user->save();
                }
                break;
            case 'region':
               $data['user_id'] = $request['user_id'];
                $data['churchleaderable_id'] = $request['region_id'];
                $data['churchleaderable_type'] = "Modules\Regions\Entities\Region";
                $data['churchleaderable_table'] = "regions";
                $data['type'] = $type;if(empty($check)){
                    ChurchLeader::create($data);
                    $user = User::whereId($request['user_id'])->first();
                    $user->churchtype = 'region';
                    $user->save();
                }
                break;
            
            default:
                break;
        }

    }
}