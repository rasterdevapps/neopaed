@extends('app')
@section('content')
<?php $write_permission = session('write_permission'); ?>
<?php $delete_permission = session('delete_permission'); ?>
@php $hide=true ; @endphp
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="{{ url('/') }}">Dashboard</a>
        </li>
        <li >
            <a href="{{ action('Admission\PostnatalController@index') }}">Postnatal Admission</a>
        </li>
        <li class="current">
            <a href="javascript:void(0);">Postnatal History of {{ $baby_name }}</a>
        </li>
    </ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
<div class="col-md-12">
<div class="widget box table-view-shadow">
<div class="widget-header">
    <h4>Postnatal Admission List</h4>
    @if(in_array('POST_DAY',$write_permission))
    <a href="{{ action('Admission\PostnatalController@create') }}" title="Create New" class="btn btn-basic-shadow create-btn-spacing btn-info pull-right">
    <i class="fa fa-plus "></i>
    <span>Create New</span>
    </a>  
    @endif                              
</div>
<div class="widget-content inherittable">
    <div id="data-list_wrapper" class="dataTables_wrapper form-inline" role="grid">
        <div>
            <table class="table table-striped table-bordered datatable table-responsive"  id="data-list">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th >Admissions</th>
                        <th >{{ Lang::get('home.ip') }}</th>
                        <th data-hide="tablet,phone">Admission Date </th>
                        <!-- <th class="center-align-phone">Print</th> -->
                        <!-- <th class="center-align-phone">Delete</th> -->
                        <th>Neonatal Proforma Print</th>
                        <th>Print</th>
                        <th class="hide">Edited Print</th>
    @if(in_array('POST_DAY',$delete_permission))
                        <th>Delete</th>
    @endif                              
                    </tr>
                </thead>
                <tbody>
                    @if(@count($admissionList) > 0 )  
                    @for ($i = 0; $i <  @count($admissionList); $i++)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>
                            <a class="@if(!in_array('POST_FORM',$write_permission)) permission-denied @endif" href="@if(in_array('POST_FORM',$write_permission)) {{ action('Admission\PostnatalController@edit', SiteHelpers::encrypt_id($admissionList[$i]->pid)) }} @else javascript:void(0); @endif">
                            {{  $admissionList[$i]->episodes }}
                            </a>
                        </td>
                        <td>{{  $admissionList[$i]->ip_number }}</td>
                        <td>@if(date('Y',strtotime($admissionList[$i]->admission_date)) > 1970) {{ date('d-m-Y',strtotime($admissionList[$i]->admission_date)) }} @endif</td>
                        <!-- <td>
                            @if($admissionList[$i]->episodes =='Admission 1')  
                            <!-- <td class="center-align-phone"><a href="{{ action('Registration\NeonatalController@show', SiteHelpers::encrypt_id($neonatal->NeonatalId)) }}"><i class="fa fa-print"></i> <span class="hidden-phone">Print</span></a></td> --
                            <a class="icon btn btn-warning btn-view" href="{{ action('Registration\NeonatalController@show', SiteHelpers::encrypt_id($neonatal->NeonatalId)) }}" title="Generated Print">
                            <i class="fa fa-print"></i> 
                            </a>
                            @else
                            <!-- <td class="center-align-phone"><a href="{{ action('Admission\PostnatalController@printData', $admissionList[$i]->pid) }}"><i class="fa fa-print"></i> <span class="hidden-phone">Print</span></a></td> --
                            <a class="icon btn btn-warning btn-view" href="{{ action('Admission\PostnatalController@printData', SiteHelpers::encrypt_id($admissionList[$i]->pid)) }}" title="Generated Print">
                            <i class="fa fa-print"></i> 
                            </a>
                            @endif
                        </td> -->
                         <td>
                            <a class="icon btn btn-warning btn-view" href="{{ action('Registration\NeonatalController@show', SiteHelpers::encrypt_id($neonatal->NeonatalId)) }}" title="Generated Print">
                            <i class="fa fa-print"></i> 
                            </a>
                        </td>
                        <td>
                            <a class="icon btn btn-warning btn-view" href="{{ action('Admission\PostnatalController@printData', SiteHelpers::encrypt_id($admissionList[$i]->pid)) }}" title="Generated Print">
                            <i class="fa fa-print"></i> 
                            </a>
                        </td>
    @if(in_array('POST_DAY',$delete_permission))
                        <td>
                            <a class="icon btn btn-danger btn-remove mr-10" href="javascript:void(0);" onclick="DeleteData({{ $admissionList[$i]->pid }},{{ $admissionList[$i]->hasAdmission }} )" title="Remove Record">
                            <i class="fa fa-trash"></i> 
                            </a>
                        </td>
    @endif                              
                        <td class="hide">
                            @if($admissionList[$i]->edited)
                            <a class="icon btn btn-default btn-view open-doc-editor" href="{{ action('Admission\PostnatalController@getAbbreviatedsummaryShow', $admissionList[$i]->pid) }}" title="Final Print">
                            <i class="fa fa-file-word-o"></i> 
                            </a>
                            @else
                            -
                        @endif
                        </td>
                    </tr>
                    @endfor
                    @else
                    <tr class="text-center">
                        <td colspan="6">No Record Found </td>
                    </tr>
                    @endif  
                </tbody>
            </table>
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
    function DeleteData(id, hasAdmission) {
    
    
      if (hasAdmission == true) {
    
             Showalert('warning','Access denied : This Admission refered to postnatal daycare record !');
    
      } else {
    
        bootbox.confirm("Are you sure?",function(confirmed) {
          if(confirmed){
            $("#DeleteForm").attr('action',"{{ action('Admission\PostnatalController@index') }}/"+id);
            $("#DeleteForm").submit();
          }
        });
    
      }
      
    }
</script>
@endsection
