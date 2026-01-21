@extends('app')
@section('content')
<?php $write_permission = session('write_permission'); ?>
<?php $delete_permission = session('delete_permission'); ?>
@if(Session::has('slug-nav'))
{{ Session::forget('slug-nav') }}
@endif
<style type="text/css">
    .navbar-nav>li>a {
        padding: 0px;
    }
    .dropdown-menu {
        padding: 2px;
        margin: 0px;
    }
    .dropdown-menu table {
        margin: 0px !important;
    }
    .dropdown-menu table td {
        padding: 0px !important;
        border: 0px !important;
        white-space: nowrap;
        text-align: left !important;
    } 
    table td .fa.fa-info-circle {
        font-size: 23px;
    }
    td.center-align-phone ul.nav {
        display: grid;
        width: 100%;
    }
    .text-success {
        color: #51a351;
    }
    .text-warning {
        color: #df8505;
    }
</style>
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="{{ url('/') }} ">{{ Lang::get('home.nicu_sub_admission_dashboard') }}</a>
        </li>
        <li>
            <a href="{{ action('Admission\PediatricController@index') }}">Pediatric Admission </a>
        </li>
        <li class="current">
            <a href="javascript:void(0);">Pediatric Admission History Of {{ $babyName or '' }}  {{ $babyMrno or '' }}</a>
        </li>
    </ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
    <div class="col-md-12">
        <div class="widget box table-view-shadow">
            <div class="widget-header">
                <h4>Pediatric Admission History</h4>
                @if(in_array('PEDI_FORM',$write_permission))
                <a href="{{ action('Admission\PediatricController@show',SiteHelpers::encrypt_id($baby_id)).'/create' }}" title="" class="btn btn-info btn-basic-shadow pull-right create-btn-spacing"><i class="fa fa-plus"></i><span>Create New</span></a>  
                @endif           
                @if(in_array('LABREQUEST',$write_permission))   
                    <a href="{{ action('Nurse\NurseSheetController@overallLabValuePrint', $babyMrno).'?closewinlink=pediatric-visit-list' }}" class="btn btn-primary create-btn-spacing mr-15 pull-right">
                        <i class="fa fa-print"></i>
                        <span>Lab Report</span>
                    </a> 
                @endif                     
            </div>
            <div class="widget-content inherittable">
                <div id="data-list_wrapper" class="dataTables_wrapper form-inline" role="grid">
                    <div class="row">
                    </div>
                </div>
                <table class="table table-striped table-bordered table-responsive datatable dataTable"  id="data-list">
                    <thead>
                        <tr>
                            <th>{{ Lang::get('home.nicu_sub_admission_sno')}}</th>
                            <th>{{ Lang::get('home.nicu_sub_admission_admission')}}</th>
                            <th>{{ Lang::get('home.ip')}}</th>
                            <th class="hidden-xs">{{ Lang::get('home.nicu_sub_admission_doa') }}</th>
                            <th class="hidden-xs">
                                Admission Print 
                            </th>
                            <th class="hidden-xs">
                                Summary Print 
                            </th>
                            <th class="hidden-xs">
                                Issued Detail
                            </th>
                            @if(in_array('PEDI_FORM',$delete_permission))
                            <th class="hidden-xs">
                                {{ Lang::get('home.nicu_sub_admission_delete') }}
                            </th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @php $i=0; @endphp
                        @foreach($results as $res_key => $result)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>
                                <a class="icon pull-left @if(!in_array('PEDI_FORM',$write_permission)) permission-denied @endif" href="@if(in_array('PEDI_FORM',$write_permission)) {{ action('Admission\PediatricController@edit',SiteHelpers::encrypt_id($result->id)) }} @else javascript:void(0); @endif">
                                    Admission {{  $i }}
                                </a>                                
                                <span class="pull-left">
                                    @if (isset($file_list[$result->id]))
                                    @foreach($file_list[$result->id] as $type => $count)
                                    @include('registration.media_list')
                                    @endforeach
                                    @endif
                                </span>
                            </td>
                            <td>{{  $result->ip_number }}</td>
                            <td class="hidden-xs">
                                @if(date('Y',strtotime($result->admission_date)) > 1970) 
                                {{  date('d-m-Y',strtotime($result->admission_date)) }}
                                @endif
                            </td>
                            <td class="center-align-phone hidden-xs">
                                <a class="btn btn-warning btn-view" href="{{ action('Admission\PediatricController@print',\SiteHelpers::encrypt_id($result->id)) }}">
                                <i class="fa fa-print"></i> 
                                </a>
                            </td>
                            <td class="center-align-phone hidden-xs">
                                <a class="btn btn-warning btn-view" href="{{ action('Admission\PediatricController@summaryprint',\SiteHelpers::encrypt_id($result->id)) }}">
                                <i class="fa fa-print"></i> 
                                </a>
                            </td>
                            <td class="center-align-phone hidden-xs">
                                <ul class="nav navbar-nav">
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle {!! isset($result->issued_to) && !is_null($result->issued_to) ? 'text-success' : 'text-warning' !!}" data-toggle="dropdown">
                                            <i class="fa fa-info-circle"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            @if (isset($result->issued_to) && !is_null($result->issued_to))
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <td>Issued To:</td>
                                                        <td>{!! $result->issued_to !!}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Issued To Relationship:</td>
                                                        <td>{!! $result->issued_to_relationship !!}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Issued Date & Time:</td>
                                                        <td>{!! date('d-m-Y h:i A', strtotime($result->issued_date_time)) !!}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Issued By:</td>
                                                        <td>{!! $result->user_name !!}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            @else
                                            Not yet issued
                                            @endif
                                        </ul>
                                    </li>
                                </ul>
                            </td>
                            @if(in_array('PEDI_FORM',$delete_permission))
                            <td class="center-align-phone hidden-xs">
                                <a class="btn btn-danger btn-view mr-10" href="javascript:void(0);" onclick="DeleteData({{$result->id}})">
                                <i class="fa fa-trash"></i> 
                                </a>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /.col-md-12 -->
</div>
<!-- /.row -->
<!-- /Page Content -->
{!! Form::open(['method'=> 'DELETE','url' => '','id'=>'DeleteForm']) !!}
{!! Form::close() !!}
@endsection
@section('scripts')
<script type="text/javascript">
    function DeleteData(id) {
        bootbox.confirm("Are you sure?", function(confirmed) {
            if (confirmed) {
                $("#DeleteForm").attr('action', "{{ action('Admission\PediatricController@index') }}/" + id);
                $("#DeleteForm").submit();
            }
        });
    }
</script>
@endsection
