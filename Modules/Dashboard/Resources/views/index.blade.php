@extends('core::admin.master')

@section('page-css')
@stop

@section('page-js')
@stop

@section('page-group-title')
    Dashboard
@stop

@section('main')
    <div class="kt-portlet">
        <div class="kt-portlet__body kt-portlet__body--fit">
            <div class="row row-no-padding row-col-separator-xl">
                @if(current_user()->hasRoleName('admin'))
                <div class="col-md-6">
                    <div class="kt-widget1">
                        @include('dashboard::_widget',[
                            'module' => 'users',
                            'color' => 'success',
                            'count' => app(\Modules\Users\Repositories\UserInterface::class)->countAll()
                        ])
                    </div>
                </div>
                @endif
                <div class="col-md-6">
                    <div class="kt-widget1">
                        @include('dashboard::_widget',[
                            'module' => 'groupchats',
                        ])
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="kt-widget1">
                        @include('dashboard::_widget',[
                            'module' => 'homechurches',
                            'color' => 'warning',
                        ])
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="kt-widget1">
                        @include('dashboard::_widget',[
                            'module' => 'churches',
                            'color' => 'danger',
                        ])
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="kt-widget1">
                        @include('dashboard::_widget',[
                            'module' => 'offering',
                            'color' => 'info',
                            'sum' => true
                        ])
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="kt-widget1">
                        @include('dashboard::_widget',[
                            'module' => 'announcements',
                            'color' => 'info',
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="kt-portlet kt-portlet--mobile">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            Submitted Homechurches
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <div class="kt-portlet__head-wrapper">
                            <div class="kt-portlet__head-actions">
                                <a href="{{route('admin.users.index')}}" class="btn btn-brand btn-sm">
                                    <i class="fa fa-list"></i>
                                    View All
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    @include('homechurches::admin._dash_list',['module' => 'homechurches' ,'models' => $homechurches])
                </div>
            </div>
        </div>
        @if(current_user()->hasRoleName('admin'))
        <div class="col-lg-6">
            <div class="kt-portlet kt-portlet--mobile">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            Chat Reports
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <div class="kt-portlet__head-wrapper">
                            <div class="kt-portlet__head-actions">
                                <a href="{{route('admin.users.index')}}" class="btn btn-brand btn-sm">
                                    <i class="fa fa-list"></i>
                                    View All
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    @include('users::admin._dash_list',['module' => 'users' ,'models' => $users])
                </div>
            </div>
        </div>
        @endif
        @if(current_user()->hasRoleName('admin'))
        <div class="col-lg-6">
            <div class="kt-portlet kt-portlet--mobile">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            Recent Registrations
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <div class="kt-portlet__head-wrapper">
                            <div class="kt-portlet__head-actions">
                                <a href="{{route('admin.users.index')}}" class="btn btn-brand btn-sm">
                                    <i class="fa fa-list"></i>
                                    View All
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    @include('users::admin._dash_list',['module' => 'users' ,'models' => $users])
                </div>
            </div>
        </div>
        @endif
        <div class="col-lg-6">
            <div class="kt-portlet kt-portlet--mobile">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            Recent Activities
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <div class="kt-portlet__head-wrapper">
                            <div class="kt-portlet__head-actions">
                                <a href="{{route('admin.history.index')}}" class="btn btn-brand btn-sm">
                                    <i class="fa fa-list"></i>
                                    View All
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    @include('history::admin._latest')
                </div>
            </div>
        </div>
    </div>
@stop
