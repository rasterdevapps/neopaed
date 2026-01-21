@extends('app')
@section('content')
<?php 
$permissions = session('menu_permission');
$read_permissions = session('read_permission');
$write_permissions = session('write_permission');
?>
<style type="text/css">
    .no-filter {
        display: flex;
        height: 83vh;
        justify-content: center;
        align-items: center;
        opacity: 0.5;
    }
    .table>tbody>tr>td {
        line-height: 1.9;
    }
    .box {
        border: 1px solid #d9d9d9;
        box-shadow: 0 1px 2px 0 rgb(0 0 0 / 20%), 0 1px 3px 0 rgb(0 0 0 / 10%);
    }
    .box .widget-header {
        background: var(--theme-color);
        border-bottom-color: #d9d9d9;
        line-height: 35px;
        padding: 1px 12px;
        margin-bottom: 0;
    }
    .not-active-btn {
        opacity: 0.5;
    }
</style>
<div class="row">
    <div class="search-alignment">
        {!! Form::open(['url'=>action('HomeController@search'), 'method'=>'get']); !!}
            <h4 class="text-center">Baby Reports</h4>
            <div class="search-container">
                {!! Form::select('baby_id', ['0'=>'- - Select Baby - -']+$results['babylist'], @$baby_id, ['class'=>'select2-select-00 input-fields-shadow full-width-fix']) !!}
                <button class="btn btn-primary search-baby save-button-shadow mlr-15"><i class="fa fa-search"></i> {{Lang::get('home.search')}} </button>
                <a href="{{url('search-reports')}}" class="btn btn-default save-button-shadow"> Reset </a>
            </div>
        {!! Form::close() !!}
        @if ($baby_id != '')
            @if(is_array($permissions) && (in_array('MOTHER_REG',$permissions) || in_array('BABY_REG',$permissions) || in_array('NEONATAL',$permissions) || in_array('NICU_FORM',$permissions) || in_array('POST_FORM',$permissions) || in_array('NICU_DAY',$permissions) || in_array('POST_DAY',$permissions) || in_array('NICU_DISCHARGE',$permissions) || in_array('POST_DISCHARGE',$permissions) || in_array('PEDI_FORM',$permissions) || in_array('TEST_ECHO',$permissions) || in_array('TEST_ULTRA',$permissions) || in_array('TEST_CULTURE',$permissions) || in_array('OP_REG',$permissions) || in_array('PEDIATRICS_OP_REG',$permissions) || in_array('NEURO_DEVELOPMENT',$permissions) || in_array('PRESCRIPTION',$permissions))) 
                <div class="box mt-20" style="margin-bottom:20px !important">
                <div class="widget-header">
                    <h3 class="text-white text-center">
                        <strong>  
                        Reports of <span class="text-captialize"> {!! $results['baby_details']->BabyName !!}</span> - {!! $results['baby_details']->BMrNo !!}
                        </strong>
                    </h3>
                </div>
                <div class="row mx-0 report-content-home mb-10">
                @if(is_array($permissions) && (in_array('NICU_DISCHARGE',$permissions) || in_array('POST_DISCHARGE',$permissions) || in_array('PEDI_FORM',$permissions) || in_array('TEST_ECHO',$permissions) || in_array('TEST_ULTRA',$permissions) || in_array('TEST_CULTURE',$permissions) || in_array('OP_REG',$permissions) || in_array('PEDIATRICS_OP_REG',$permissions) || in_array('NEURO_DEVELOPMENT',$permissions))) 
                    <div class="col-md-12 text-center">
                        <div style="padding-top:-2px">
                            <h3>Reports To Patients</h3>
                        </div>
                    </div>
                    @if($results['nicu_summary_daycare'] && is_array($permissions) && in_array('NICU_DISCHARGE',$permissions)) 
                        <div class="col-md-6 col-sm-6">
                            <div class="widget box homepage-overview-board">
                                <div class="widget-header">
                                    <h4><span href="javascript:void(0);">
                                        <i class="fa fa-reorder"></i></span>NICU Discharge Summary
                                    </h4>
                                    <div class="toolbar no-padding">
                                        <div class="btn-group">
                                            <span class="btn btn-xs widget-collapse" id="widget-collapse-1"><i class="fa fa-angle-up fa-2x"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content no-padding">
                                    <table class="table table-striped table-checkable table-hover">
                                        <thead>
                                            <tr>
                                                <th class="align-left">Admission List</th>
                                                <th class="align-center input-width-small">Edit</th>
                                                <th class="align-center input-width-small">Print</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($results['nicu_summary_daycare']) > 0 && isset($results['neonatal_list'][0]->NeonatalId))
                                                @for ($i = 0; $i <  @count($results['nicu_summary_daycare']); $i++)
                                                    <tr>
                                                        <td class="align-left">{{  $results['nicu_summary_daycare'][$i]->episodes }}</td>
                                                        <td>
                                                            @if (in_array('NICU_DISCHARGE',$write_permissions))
                                                            <a href="{{ action('Admission\NicuController@dischargeedit', SiteHelpers::encrypt_id($results['nicu_summary_daycare'][$i]->NicuId)) }}" class="btn btn-info btn-view">
                                                            <i class="fa fa-edit" aria-hidden="true"></i>
                                                            </a>
                                                            @endif
                                                        </td>
                                                        <td class="align-center input-width-small">
                                                            @if (in_array('NICU_DISCHARGE',$read_permissions))
                                                            @php $url = SiteHelpers::encrypt_id($results['nicu_summary_daycare'][$i]->BabyId.'-'.$results['nicu_summary_daycare'][$i]->AdmissionId); @endphp
                                                            <a class="icon btn btn-warning btn-view" href="{{ url('nicu-discharge-summary/'.$url) }}">
                                                            <i class="fa fa-print"></i>
                                                            </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endfor
                                            @else 
                                                <tr class="text-center">
                                                    <td colspan="3">No Reports Found</td>
                                                </tr>
                                            @endif    
                                        </tbody>
                                    </table>
                                    <!-- /.row -->
                                </div>
                                <!-- /.widget-content -->
                            </div>
                            <!-- /.widget -->
                        </div>
                    @endif
                    @if($results['postnatal_summary'] && is_array($permissions) && in_array('POST_DISCHARGE',$permissions))   
                        <div class="col-md-6 col-sm-6">
                            <div class="widget box homepage-overview-board">
                                <div class="widget-header">
                                    <h4><span href="javascript:void(0);"><i class="fa fa-reorder"></i></span>Postnatal Discharge Summary</h4>
                                    <div class="toolbar no-padding">
                                        <div class="btn-group">
                                            <span class="btn btn-xs widget-collapse" id="widget-collapse-2"><i class="fa fa-angle-up fa-2x"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content no-padding">
                                    <table class="table table-striped table-checkable table-hover">
                                        <thead>
                                            <tr>
                                                <th class="align-left">Admission List</th>
                                                <th class="align-center input-width-small">Edit</th>
                                                <th class="align-center input-width-small">Print</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($results['postnatal_discharge']) > 0)    
                                                @for ($i = 0; $i <  @count($results['postnatal_discharge']); $i++)
                                                    <tr>
                                                        <td class="align-left">{{  $results['postnatal_discharge'][$i]->episodes }}</td>
                                                        <td>
                                                            @if (in_array('POST_DISCHARGE',$write_permissions))
                                                            <a href="{{ action('Admission\PostnatalDischargeController@edit', SiteHelpers::encrypt_id($results['postnatal_discharge'][$i]->posdisid)) }}" class="btn btn-info btn-view">
                                                            <i class="fa fa-edit" aria-hidden="true"></i>
                                                            </a>
                                                            @endif
                                                        </td>
                                                        <td class="align-center input-width-small">
                                                            @if (in_array('POST_DISCHARGE',$read_permissions))
                                                            @php $url = SiteHelpers::encrypt_id($results['postnatal_discharge'][$i]->BabyId.'-'.$results['postnatal_discharge'][$i]->AdmissionId); @endphp
                                                            <a class="icon btn btn-warning btn-view" href="{{ url('postproblem-systems-summary/'.$url) }}">
                                                            <i class="fa fa-print"></i>
                                                            </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endfor
                                            @else 
                                                <tr class="text-center">
                                                    <td colspan="3"> No Reports Found</td>
                                                </tr>
                                            @endif    
                                        </tbody>
                                    </table>
                                    <!-- /.row -->
                                </div>
                                <!-- /.widget-content -->
                            </div>
                            <!-- /.widget -->
                        </div>
                    @endif 
                    @if($results['pediatric_summary'] && is_array($permissions) && in_array('PEDI_FORM',$permissions))   
                        <div class="col-md-6 col-sm-6">
                            <div class="widget box homepage-overview-board">
                                <div class="widget-header">
                                    <h4><span href="javascript:void(0);"><i class="fa fa-reorder"></i></span>Pediatric Discharge Summary</h4>
                                    <div class="toolbar no-padding">
                                        <div class="btn-group">
                                            <span class="btn btn-xs widget-collapse" id="widget-collapse-3"><i class="fa fa-angle-up fa-2x"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content no-padding">
                                    <table class="table table-striped table-checkable table-hover">
                                        <thead>
                                            <tr>
                                                <th class="align-left">Admission List</th>
                                                <th class="align-center input-width-small">Edit</th>
                                                <th class="align-center input-width-small">Print</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($results['pediatric_summary']) > 0)    
                                                @foreach($results['pediatric_summary'] as $pediatric_summary_value)
                                                    <tr>
                                                        <td class="align-left">{{  $pediatric_summary_value->episodes }}</td>
                                                        <td class="align-center input-width-small">
                                                            @if (in_array('PEDI_FORM',$write_permissions))
                                                            @php $url = SiteHelpers::encrypt_id($pediatric_summary_value->id); @endphp
                                                            <a class="btn btn-info btn-view" href="{{ action('Admission\PediatricController@edit', $url) }}#dischargeform">
                                                            <i class="fa fa-edit"></i>
                                                            </a>
                                                            @endif
                                                        </td>
                                                        <td class="align-center input-width-small">
                                                            @if (in_array('PEDI_FORM',$read_permissions))
                                                            @php $url = SiteHelpers::encrypt_id($pediatric_summary_value->id); @endphp
                                                            <a class="icon btn btn-warning btn-view" href="{{ action('Admission\PediatricController@summaryprint', $url) }}">
                                                            <i class="fa fa-print"></i>
                                                            </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else 
                                                <tr class="text-center">
                                                    <td colspan="3"> No Reports Found</td>
                                                </tr>
                                            @endif    
                                        </tbody>
                                    </table>
                                    <!-- /.row -->
                                </div>
                                <!-- /.widget-content -->
                            </div>
                            <!-- /.widget -->
                        </div>
                    @endif 
                    @if($results['echocardiogram'] && is_array($permissions) && in_array('TEST_ECHO',$permissions))  
                        <div class="col-md-6 col-sm-6">
                            <div class="widget box homepage-overview-board">
                                <div class="widget-header">
                                    <h4><span href="javascript:void(0);"><i class="fa fa-reorder"></i></span>Echocardiography</h4>
                                    <div class="toolbar no-padding">
                                        <div class="btn-group">
                                            <span class="btn btn-xs widget-collapse" id="widget-collapse-4"><i class="fa fa-angle-up fa-2x"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content no-padding">
                                    <table class="table table-striped table-checkable table-hover">
                                        <thead>
                                            <tr>
                                                <th class="align-left">List</th>
                                                <th class="align-center input-width-small">Edit</th>
                                                <th class="align-center input-width-small">Print</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($results['echocardiogram']) > 0)    
                                                @for ($i = 0; $i <  @count($results['echocardiogram']); $i++)
                                                    <tr>
                                                        <td class="align-left">{{  date('d-m-Y', strtotime($results['echocardiogram'][$i]->TestDate)) }}</td>
                                                        <td class="align-center input-width-small">
                                                            @if (in_array('TEST_ECHO',$write_permissions))
                                                            <a class="btn btn-info btn-view" href="{{ action('Extras\CardioController@edit',SiteHelpers::encrypt_id($results['echocardiogram'][$i]->EchoId)) }}">
                                                            <i class="fa fa-edit"></i>
                                                            </a>
                                                            @endif
                                                        </td>
                                                        <td class="align-center input-width-small">
                                                            @if (in_array('TEST_ECHO',$read_permissions))
                                                            <a class="icon btn btn-warning btn-view" href="{{ action('Extras\CardioController@printData',SiteHelpers::encrypt_id($results['echocardiogram'][$i]->EchoId)) }}">
                                                            <i class="fa fa-print"></i>
                                                            </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endfor
                                            @else 
                                                <tr class="text-center">
                                                    <td colspan="3"> No Reports Found</td>
                                                </tr>
                                            @endif    
                                        </tbody>
                                    </table>
                                    <!-- /.row -->
                                </div>
                                <!-- /.widget-content -->
                            </div>
                            <!-- /.widget -->
                        </div>
                    @endif 
                    @if($results['ultra'] && is_array($permissions) && in_array('TEST_ULTRA',$permissions))    
                        <div class="col-md-6 col-sm-6">
                            <div class="widget box homepage-overview-board">
                                <div class="widget-header">
                                    <h4><span href="javascript:void(0);"><i class="fa fa-reorder"></i></span>Cranial Ultrasonography</h4>
                                    <div class="toolbar no-padding">
                                        <div class="btn-group">
                                            <span class="btn btn-xs widget-collapse" id="widget-collapse-5"><i class="fa fa-angle-up fa-2x"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content no-padding">
                                    <table class="table table-striped table-checkable table-hover">
                                        <thead>
                                            <tr>
                                                <th class="align-left">List</th>
                                                <th class="align-center input-width-small">Edit</th>
                                                <th class="align-center input-width-small">Print</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($results['ultra']) > 0)    
                                                @for ($i = 0; $i <  @count($results['ultra']); $i++)
                                                    <tr>
                                                        <td class="align-left">{{  date('d-m-Y', strtotime($results['ultra'][$i]->TestDate)) }}</td>
                                                        <td class="align-center input-width-small">
                                                            @if (in_array('TEST_ULTRA',$write_permissions))
                                                            <a class="btn btn-info btn-view" href="{{ action('Extras\UltraController@edit',SiteHelpers::encrypt_id($results['ultra'][$i]->UltraId)) }}">
                                                            <i class="fa fa-edit"></i>
                                                            </a>
                                                            @endif
                                                        </td>
                                                        <td class="align-center input-width-small">
                                                            @if (in_array('TEST_ULTRA',$read_permissions))
                                                            <a class="icon btn btn-warning btn-view" href="{{ action('Extras\UltraController@printData',SiteHelpers::encrypt_id($results['ultra'][$i]->UltraId)) }}">
                                                            <i class="fa fa-print"></i>
                                                            </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endfor
                                            @else 
                                                <tr class="text-center">
                                                    <td colspan="3"> No Reports Found</td>
                                                </tr>
                                            @endif    
                                        </tbody>
                                    </table>
                                    <!-- /.row -->
                                </div>
                                <!-- /.widget-content -->
                            </div>
                            <!-- /.widget -->
                        </div>
                    @endif
                    @if($results['ultra'] && is_array($permissions) && in_array('TEST_CULTURE',$permissions))    
                        <div class="col-md-6 col-sm-6">
                            <div class="widget box homepage-overview-board">
                                <div class="widget-header">
                                    <h4><span href="javascript:void(0);"><i class="fa fa-reorder"></i></span>Culture Registry</h4>
                                    <div class="toolbar no-padding">
                                        <div class="btn-group">
                                            <span class="btn btn-xs widget-collapse" id="widget-collapse-6"><i class="fa fa-angle-up fa-2x"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content no-padding">
                                    <table class="table table-striped table-checkable table-hover">
                                        <thead>
                                            <tr>
                                                <th class="align-left">List</th>
                                                <th class="align-center input-width-small">Edit</th>
                                                <th class="align-center input-width-small">Print</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($results['culture']) > 0)    
                                                @for ($i = 0; $i <  @count($results['culture']); $i++)
                                                    <tr>
                                                        <td class="align-left">{{  date('d-m-Y', strtotime($results['culture'][$i]->EntryDate)) }}</td>
                                                        <td class="align-center input-width-small">
                                                            @if (in_array('TEST_CULTURE',$write_permissions))
                                                            <a class="btn btn-info btn-view" href="{{ action('Extras\CultureController@edit',SiteHelpers::encrypt_id($results['culture'][$i]->CultureId)) }}">
                                                            <i class="fa fa-edit"></i>
                                                            </a>
                                                            @endif
                                                        </td>
                                                        <td class="align-center input-width-small">
                                                            @if (in_array('TEST_CULTURE',$read_permissions))
                                                            <a class="icon btn btn-warning btn-view" href="{{ action('Extras\CultureController@printData',SiteHelpers::encrypt_id($results['culture'][$i]->CultureId)) }}">
                                                            <i class="fa fa-print"></i>
                                                            </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endfor
                                            @else 
                                                <tr class="text-center">
                                                    <td colspan="3"> No Reports Found</td>
                                                </tr>
                                            @endif    
                                        </tbody>
                                    </table>
                                    <!-- /.row -->
                                </div>
                                <!-- /.widget-content -->
                            </div>
                            <!-- /.widget -->
                        </div>
                    @endif
                    @if($results['neonatal_op_visite'] && is_array($permissions) && in_array('OP_REG',$permissions))    
                        <div class="col-md-6 col-sm-6">
                            <div class="widget box homepage-overview-board">
                                <div class="widget-header">
                                    <h4><span href="javascript:void(0);"><i class="fa fa-reorder"></i></span>Neonatal Op Reports</h4>
                                    <div class="toolbar no-padding">
                                        <div class="btn-group">
                                            <span class="btn btn-xs widget-collapse" id="widget-collapse-7"><i class="fa fa-angle-up fa-2x"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content no-padding">
                                    <table class="table table-striped table-checkable table-hover">
                                        <thead>
                                            <tr>
                                                <th class="align-left">Visite List</th>
                                                <th class="align-center input-width-small">Edit</th>
                                                <th class="align-center input-width-small">Print</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($results['neonatal_op_visite']) > 0)    
                                                @for ($i = 0; $i <  @count($results['neonatal_op_visite']); $i++)
                                                    <tr>
                                                        <td class="align-left">{{  $results['neonatal_op_visite'][$i]->op_visite }}</td>
                                                        <td class="align-center input-width-small">
                                                            @if (in_array('OP_REG',$write_permissions))
                                                            <a class="btn btn-info btn-view" href="{{ action('Registration\OpController@edit',SiteHelpers::encrypt_id($results['neonatal_op_visite'][$i]->OpId)) }}">
                                                            <i class="fa fa-edit"></i>
                                                            </a>
                                                            @endif
                                                        </td>
                                                        <td class="align-center input-width-small">
                                                            @if (in_array('OP_REG',$read_permissions))
                                                            <a class="icon btn btn-warning btn-view" href="{{ url('out-patient/'.SiteHelpers::encrypt_id($results['neonatal_op_visite'][$i]->OpId)) }}">
                                                            <i class="fa fa-print"></i>
                                                            </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endfor
                                            @else 
                                                <tr class="text-center">
                                                    <td colspan="3"> No Reports Found</td>
                                                </tr>
                                            @endif    
                                        </tbody>
                                    </table>
                                    <!-- /.row -->
                                </div>
                                <!-- /.widget-content -->
                            </div>
                            <!-- /.widget -->
                        </div>
                    @endif 
                    @if($results['pediatric_op_visite'] && is_array($permissions) && in_array('PEDIATRICS_OP_REG',$permissions))    
                        <div class="col-md-6 col-sm-6">
                            <div class="widget box homepage-overview-board">
                                <div class="widget-header">
                                    <h4><span href="javascript:void(0);"><i class="fa fa-reorder"></i></span>Pediatric Op Reports</h4>
                                    <div class="toolbar no-padding">
                                        <div class="btn-group">
                                            <span class="btn btn-xs widget-collapse" id="widget-collapse-8"><i class="fa fa-angle-up fa-2x"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content no-padding">
                                    <table class="table table-striped table-checkable table-hover">
                                        <thead>
                                            <tr>
                                                <th class="align-left">Visite List</th>
                                                <th class="align-center input-width-small">Edit</th>
                                                <th class="align-center input-width-small">Print</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($results['pediatric_op_visite']) > 0)    
                                                @for ($i = 0; $i <  @count($results['pediatric_op_visite']); $i++)
                                                    <tr>
                                                        @php 
                                                            $pediatric_op_count = count($results['pediatric_op_visite']) - $i;
                                                            $pediatric_op_count = strlen($pediatric_op_count) > 1 ? '0'.($pediatric_op_count) : '00'.($pediatric_op_count)
                                                        @endphp
                                                        <td class="align-left">Visit - {{ $pediatric_op_count }}</td>
                                                        <td class="align-center input-width-small">
                                                            @if (in_array('PEDIATRICS_OP_REG',$write_permissions))
                                                            <a class="btn btn-info btn-view" href="{{ action('Registration\PediatricOpController@edit',SiteHelpers::encrypt_id($results['pediatric_op_visite'][$i]->id)) }}">
                                                            <i class="fa fa-edit"></i>
                                                            </a>
                                                            @endif
                                                        </td>
                                                        <td class="align-center input-width-small">
                                                            @if (in_array('PEDIATRICS_OP_REG',$read_permissions))
                                                            <a class="icon btn btn-warning btn-view" href="{{  action('Registration\PediatricOpController@show',SiteHelpers::encrypt_id($results['pediatric_op_visite'][$i]->id)) }}">
                                                            <i class="fa fa-print"></i>
                                                            </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endfor
                                            @else 
                                                <tr class="text-center">
                                                    <td colspan="3"> No Reports Found</td>
                                                </tr>
                                            @endif    
                                        </tbody>
                                    </table>
                                    <!-- /.row -->
                                </div>
                                <!-- /.widget-content -->
                            </div>
                            <!-- /.widget -->
                        </div>
                    @endif 
                    @if($results['neuro_visit'] && is_array($permissions) && in_array('NEURO_DEVELOPMENT',$permissions))    
                        <div class="col-md-6 col-sm-6">
                            <div class="widget box homepage-overview-board">
                                <div class="widget-header">
                                    <h4><span href="javascript:void(0);"><i class="fa fa-reorder"></i></span>Neuro Development Reports</h4>
                                    <div class="toolbar no-padding">
                                        <div class="btn-group">
                                            <span class="btn btn-xs widget-collapse" id="widget-collapse-9"><i class="fa fa-angle-up fa-2x"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content no-padding">
                                    <table class="table table-striped table-checkable table-hover">
                                        <thead>
                                            <tr>
                                                <th class="align-left">Visite List</th>
                                                <th class="align-center input-width-small">Edit</th>
                                                <th class="align-center input-width-small">Print</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($results['neuro_visit']) > 0)    
                                                @for ($i = 0; $i <  @count($results['neuro_visit']); $i++)
                                                    <tr>
                                                        @php 
                                                            $neuro_op_count = count($results['neuro_visit']) - $i;
                                                            $neuro_op_count = strlen($neuro_op_count) > 1 ? '0'.($neuro_op_count) : '00'.($neuro_op_count)
                                                        @endphp
                                                        <td class="align-left">Visit - {{ $neuro_op_count }}</td>
                                                        <td class="align-center input-width-small">
                                                            @if (in_array('NEURO_DEVELOPMENT',$write_permissions))
                                                            <a class="btn btn-info btn-view" href="{{  action('Registration\NeuroController@edit',SiteHelpers::encrypt_id($results['neuro_visit'][$i]->id)) }}">
                                                            <i class="fa fa-edit"></i>
                                                            </a>
                                                            @endif
                                                        </td>
                                                        <td class="align-center input-width-small">
                                                            @if (in_array('NEURO_DEVELOPMENT',$read_permissions))
                                                            <a class="icon btn btn-warning btn-view" href="{{  action('Registration\NeuroController@show',SiteHelpers::encrypt_id($results['neuro_visit'][$i]->id)) }}">
                                                            <i class="fa fa-print"></i>
                                                            </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endfor
                                            @else 
                                                <tr class="text-center">
                                                    <td colspan="3"> No Reports Found</td>
                                                </tr>
                                            @endif    
                                        </tbody>
                                    </table>
                                    <!-- /.row -->
                                </div>
                                <!-- /.widget-content -->
                            </div>
                            <!-- /.widget -->
                        </div>
                    @endif 
                @endif
                @if(is_array($permissions) && (in_array('MOTHER_REG',$permissions) || in_array('BABY_REG',$permissions) || in_array('NEONATAL',$permissions) || in_array('NICU_FORM',$permissions) || in_array('POST_FORM',$permissions) || in_array('NICU_DAY',$permissions) || in_array('POST_DAY',$permissions) || in_array('PEDI_FORM',$permissions) || in_array('PRESCRIPTION',$permissions))) 
                    <div class="row mx-0">
                        <div class="col-md-12 text-center">
                            <h3>Reports To MRD</h3>
                        </div>
                    </div>
                    @if(is_array($permissions) && (in_array('MOTHER_REG',$permissions) || in_array('BABY_REG',$permissions) || in_array('NEONATAL',$permissions))) 
                        <div class="row mx-0 mb-15">
                            <div class="col-md-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="align-left">List</th>
                                            <th class="align-center input-width-small">Edit</th>
                                            <th class="align-center input-width-small">View/Print</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(is_array($permissions) && in_array('MOTHER_REG',$permissions)) 
                                            <tr>
                                                <td>Mother</td>
                                                <td class="align-center">
                                                    @if (in_array('MOTHER_REG',$write_permissions))
                                                    <a href="{{ action('Registration\MotherController@edit', SiteHelpers::encrypt_id(@$results['motherrecord']->MotherId))}}" class="btn btn-info btn-view"> 
                                                    <i class="fa fa-edit" aria-hidden="true"></i> 
                                                    </a>
                                                    @endif
                                                </td>
                                                <td  class="align-center">-</td>
                                            </tr>
                                        @endif 
                                        @if(is_array($permissions) && in_array('BABY_REG',$permissions)) 
                                            <tr>
                                                <td>Baby</td>
                                                <td class="align-center">
                                                    @if (in_array('BABY_REG',$write_permissions))
                                                    <a href="{{ action('Registration\BabyController@edit', SiteHelpers::encrypt_id($results['baby_details']->BabyId))}}" class="btn btn-info btn-view"> 
                                                    <i class="fa fa-edit" aria-hidden="true"></i>
                                                    </a>
                                                    @endif
                                                </td>
                                                <td  class="align-center">-</td>
                                            </tr>
                                        @endif 
                                        @if(isset($results['neonatal_list'][0]->NeonatalId) && is_array($permissions) && in_array('NEONATAL',$permissions))
                                            <tr>
                                                <td>Neonatal Proforma </td>
                                                <td class="align-center">
                                                    @if (in_array('NEONATAL',$write_permissions))
                                                    <a  href="{{ action('Registration\NeonatalController@edit', SiteHelpers::encrypt_id($results['neonatal_list'][0]->NeonatalId)) }}" class="btn btn-info btn-view">
                                                    <i class="fa fa-edit" aria-hidden="true"></i>
                                                    </a>
                                                    @endif
                                                </td>
                                                <td class="align-center">
                                                    @if (in_array('NEONATAL',$read_permissions))
                                                    <a href="{{ url('neonatal/'.SiteHelpers::encrypt_id($results['neonatal_list'][0]->NeonatalId)) }}" class="icon btn btn-warning btn-view">
                                                    <i class="fa fa-print" aria-hidden="true"></i>
                                                    </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif 
                                        <tr>
                                            <td>Vaccine Chart </td>
                                            <td class="align-center">
                                                @if(is_array($write_permissions) && (in_array('OP_REG',$write_permissions) || in_array('PEDIATRICS_OP_REG',$write_permissions)))    
                                                    <a  href="{{ action('Registration\OpController@vaccineChart', SiteHelpers::encrypt_id($results['baby_details']->BabyId)) }}" class="btn btn-info btn-view">
                                                    <i class="fa fa-edit" aria-hidden="true"></i>
                                                    </a>
                                                @endif 
                                            </td>
                                            <td class="align-center">
                                                @if(is_array($read_permissions) && (in_array('OP_REG',$read_permissions) || in_array('PEDIATRICS_OP_REG',$read_permissions)))    
                                                    <a href="{{ action('Registration\OpController@vaccineChartPrint', SiteHelpers::encrypt_id($results['baby_details']->BabyId)) }}" class="icon btn btn-warning btn-view">
                                                        <i class="fa fa-print" aria-hidden="true"></i>
                                                    </a>
                                                @endif 
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Lab Report </td>
                                            <td class="align-center">-</td>
                                            <td class="align-center">
                                                <a href="{{ action('Nurse\NurseSheetController@overallLabValuePrint', $results['baby_details']->BMrNo).'?closewinlink=search-reports' }}" class="icon btn btn-warning btn-view">
                                                <i class="fa fa-print" aria-hidden="true"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            @php 
                                                $pacs_link = \SiteHelpers::pacsViewerLink();
                                                $pacs_link = str_replace('MRN', $results['baby_details']->BMrNo, $pacs_link);
                                            @endphp
                                            <td>PAC's </td>
                                            <td class="align-center">-</td>
                                            <td class="align-center">
                                                <a href="{{ $pacs_link }}" class="icon btn btn-success btn-view">
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @php $current_age = null; @endphp
                                        @php $current_chart_age = null; @endphp
                                        @if (isset($results['baby_details']->g_weeks) && isset($results['baby_details']->g_days) && isset($results['baby_details']->DOB))
                                            @php 
                                                $DOB = date('Y-m-d', strtotime($results['baby_details']->DOB));
                                                $OpDate = date('Y-m-d');
                                                $current_age = \SiteHelpers::getChronologicalage($DOB, $OpDate);
                                            @endphp
                                            @if ($results['baby_details']->g_weeks < 37 && !empty($results['baby_details']->g_weeks))
                                                @php 
                                                  $baby_corrected_age = \SiteHelpers::calculateCorrectedGestation($results['baby_details']->g_weeks, $results['baby_details']->g_days, $results['baby_details']->DOB, date('Y-m-d'));
                                                  $current_chart_age = $baby_corrected_age['corrected_age_weeks'];
                                                @endphp
                                            @endif
                                        @endif  
                                        <tr>
                                            <td>Intergrowth 21st Century Chart</td>
                                            <td>-</td>
                                            <td>
                                                <a class="btn btn-success btn-view @if(isset($results['baby_details']->g_weeks) && !empty($results['baby_details']->g_weeks) && $results['baby_details']->g_weeks < 37 && $current_chart_age <= 64 && $current_age < 5) active-btn @else not-active-btn @endif" href="{{ action('charts\InterGrowthChartController@index').'?baby_id='.SiteHelpers::encrypt_id($results['baby_details']->BabyId).'&closewinlink=search-reports' }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>WHO Growth Chart (0 to 5)</td>
                                            <td>-</td>
                                            <td>
                                                <a class="btn btn-success btn-view @if(((empty($results['baby_details']->g_weeks) || (isset($results['baby_details']->g_weeks) && $results['baby_details']->g_weeks > 36)) || (isset($results['baby_details']->g_weeks) && $results['baby_details']->g_weeks <= 36 && $current_chart_age > 64)) && $current_age < 5) active-btn @else not-active-btn @endif" href="{{ action('charts\WhoGrowthChartcontroller@index').'?baby_id='.SiteHelpers::encrypt_id($results['baby_details']->BabyId).'&closewinlink=search-reports' }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>WHO Growth Chart (>= 5)</td>
                                            <td>-</td>
                                            <td>
                                                <a class="btn btn-success btn-view @if($current_age >= 5) active-btn @else not-active-btn @endif" id="Greater-than-five-chart" href="{{ action('charts\WhoGrowthChartcontroller@greaterthanfive').'?baby_id='.SiteHelpers::encrypt_id($results['baby_details']->BabyId).'&closewinlink=search-reports' }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- /.row -->
                            </div>
                        </div>
                    @endif 
                    @if($results['nicuadmission'] && is_array($permissions) && in_array('NICU_FORM',$permissions))
                        <div class="col-md-6 col-sm-6">
                            <div class="widget box homepage-overview-board">
                                <div class="widget-header">
                                    <h4><span href="javascript:void(0);"><i class="fa fa-reorder"></i></span>Nicu Admission</h4>
                                    <div class="toolbar no-padding">
                                        <div class="btn-group">
                                            <span class="btn btn-xs widget-collapse" id="widget-collapse-10"><i class="fa fa-angle-up fa-2x"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content no-padding">
                                    <table class="table table-striped table-checkable table-hover">
                                        <thead>
                                            <tr>
                                                <th class="align-left">List</th>
                                                <th class="align-center input-width-small">Edit</th>
                                                <th class="align-center input-width-small">Print</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($results['nicuadmission']) > 0 && isset($results['neonatal_list'][0]->NeonatalId))   
                                                @foreach($results['nicuadmission'] as $nicu_admission_value)
                                                    <tr>
                                                        <td class="align-left">{{  $nicu_admission_value->episodes }}</td>
                                                        <td>
                                                            @if (in_array('NICU_FORM',$write_permissions))
                                                            <a href="{{ action('Admission\NicuController@edit', SiteHelpers::encrypt_id($nicu_admission_value->NicuId)) }}" class="btn btn-info btn-view">
                                                            <i class="fa fa-edit" aria-hidden="true"></i>
                                                            </a>
                                                            @endif
                                                        </td>
                                                        <td class="align-center input-width-small">
                                                            @if (in_array('NICU_FORM',$read_permissions))
                                                            <a class="icon btn btn-warning btn-view" href="{{ action('Admission\NicuController@printData', SiteHelpers::encrypt_id($nicu_admission_value->NicuId)) }}">
                                                            <i class="fa fa-print"></i>
                                                            </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else 
                                                <tr class="text-center">
                                                    <td colspan="3"> No Reports Found</td>
                                                </tr>
                                            @endif    
                                        </tbody>
                                    </table>
                                    <!-- /.row -->
                                </div>
                                <!-- /.widget-content -->
                            </div>
                            <!-- /.widget -->
                        </div>
                    @endif
                    @if($results['postnatal_admmission'] && is_array($permissions) && in_array('POST_FORM',$permissions)) 
                        <div class="col-md-6 col-sm-6">
                            <div class="widget box homepage-overview-board">
                                <div class="widget-header">
                                    <h4><span href="javascript:void(0);"><i class="fa fa-reorder"></i></span>Postnatal Admission</h4>
                                    <div class="toolbar no-padding">
                                        <div class="btn-group">
                                            <span class="btn btn-xs widget-collapse" id="widget-collapse-11"><i class="fa fa-angle-up fa-2x"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content no-padding">
                                    <table class="table table-striped table-checkable table-hover">
                                        <thead>
                                            <tr>
                                                <th class="align-left">List</th>
                                                <th class="align-center input-width-small">Edit</th>
                                                <th class="align-center input-width-small">Print</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($results['postnatal_admmission']) > 0)   
                                                @for ($i = 0; $i <  @count($results['postnatal_admmission']); $i++)
                                                    <tr>
                                                        <td>{{  $results['postnatal_admmission'][$i]->episodes }}</td>
                                                        <td>
                                                            @if (in_array('POST_FORM',$write_permissions))
                                                            <a href="{{ action('Admission\PostnatalController@edit', SiteHelpers::encrypt_id($results['postnatal_admmission'][$i]->pid)) }}" class="btn btn-info btn-view">
                                                            <i class="fa fa-edit" aria-hidden="true"></i>
                                                            </a>
                                                            @endif
                                                        </td>
                                                        <td class="align-center input-width-small">
                                                            @if (in_array('POST_FORM',$read_permissions))
                                                            <a class="icon btn btn-warning btn-view" href="{{ action('Admission\PostnatalController@printData', SiteHelpers::encrypt_id($results['postnatal_admmission'][$i]->pid)) }}">
                                                            <i class="fa fa-print"></i>
                                                            </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endfor
                                            @else 
                                                <tr class="text-center">
                                                    <td colspan="3"> No Reports Found</td>
                                                </tr>
                                            @endif    
                                        </tbody>
                                    </table>
                                    <!-- /.row -->
                                </div>
                                <!-- /.widget-content -->
                            </div>
                            <!-- /.widget -->
                        </div>
                    @endif
                    @if($results['daycare_list'] && is_array($permissions) && in_array('NICU_DAY',$permissions)) 
                        <div class="col-md-6 col-sm-6">
                            <div class="widget box homepage-overview-board">
                                <div class="widget-header">
                                    <h4><span href="javascript:void(0);"><i class="fa fa-reorder"></i></span>Nicu Daycare Sheets</h4>
                                    <div class="toolbar no-padding">
                                        <div class="btn-group">
                                            <span class="btn btn-xs widget-collapse" id="widget-collapse-12"><i class="fa fa-angle-up fa-2x"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content no-padding">
                                    <table class="table table-striped table-checkable table-hover">
                                        <thead>
                                            <tr>
                                                <th class="align-left">List</th>
                                                <th class="align-center input-width-small">Edit</th>
                                                <th class="align-center input-width-small">Print</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $i = 1 @endphp
                                            @if(count($results['daycare_list']) > 0)   
                                                @foreach($results['daycare_list'] as $key => $day_lists)
                                                    <tr>
                                                        <td colspan="3" class="align-center">
                                                            <h5 class="display-inline-block">{{  $key }} </h5>
                                                            <span class="btn daycare-list-1 pull-right" data-daycare-list=".daycare-list-1-{{ $i }}" href="javascript:void(0);">
                                                            <i class="fa fa-angle-up icon-angle-down"></i>
                                                            </span>
                                                        </td>
                                                    </tr>        
                                                    @php $j = count($day_lists) @endphp
                                                    @foreach($day_lists as $day_key => $list)   
                                                        <tr class="daycare-list-1-{{ $i }}">
                                                            <td class="align-left">{{ 'Day ' . ($j) }}</td>
                                                            <td class="align-center input-width-small">
                                                                @if (in_array('NICU_DAY',$write_permissions))
                                                                <a href="{{ action('Admission\DaycareController@edit', SiteHelpers::encrypt_id($list['DayId'])) }}" class="btn btn-info btn-view">
                                                                    <i class="fa fa-edit" aria-hidden="true"></i>
                                                                </a>
                                                                @endif
                                                            </td>
                                                            <td class="align-center input-width-small">
                                                                @if (in_array('NICU_DAY',$read_permissions))
                                                                <a class="icon btn btn-warning btn-view" href="{{ action('Admission\DaycareController@printData', SiteHelpers::encrypt_id($list['DayId'])) }}">
                                                                    <i class="fa fa-print"></i>
                                                                </a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @php $j-- @endphp  
                                                    @endforeach
                                                    @php $i++ @endphp  
                                                @endforeach
                                            @else 
                                                <tr class="text-center">
                                                    <td colspan="3"> No Reports Found</td>
                                                </tr>
                                            @endif    
                                        </tbody>
                                    </table>
                                    <!-- /.row -->
                                </div>
                                <!-- /.widget-content -->
                            </div>
                            <!-- /.widget -->
                        </div>
                    @endif
                    @if($results['postnatal_daycare'] && is_array($permissions) && in_array('POST_DAY',$permissions)) 
                        <div class="col-md-6 col-sm-6">
                            <div class="widget box homepage-overview-board">
                                <div class="widget-header">
                                    <h4><span href="javascript:void(0);"><i class="fa fa-reorder"></i></span>Postnatal Daycare Sheets</h4>
                                    <div class="toolbar no-padding">
                                        <div class="btn-group">
                                            <span class="btn btn-xs widget-collapse" id="widget-collapse-13"><i class="fa fa-angle-up fa-2x"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content no-padding">
                                    <table class="table table-striped table-checkable table-hover">
                                        <thead>
                                            <tr>
                                                <th>List</th>
                                                <th class="align-center input-width-small">Edit</th>
                                                <th class="align-center input-width-small">Print</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $i = 1 @endphp
                                            @if(count($results['postnatal_daycare']) > 0)   
                                                @foreach($results['postnatal_daycare'] as $key => $day_lists)
                                                    <tr>
                                                        <td colspan="3">
                                                            <h5 class="display-inline-block">{{  $key }} </h5>
                                                            <span class="btn daycare-list-2 pull-right" data-daycare-list=".daycare-list-2-{{ $i }}" href="javascript:void(0);">
                                                            <i class="fa fa-angle-up icon-angle-down"></i>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    @foreach($day_lists as $list)
                                                        <tr class="daycare-list-2-{{ $i }}">
                                                            <td class="align-left">{{   'Day '.$i }}</td>
                                                            <td class="align-center input-width-small">
                                                                @if (in_array('POST_DAY',$write_permissions))
                                                                <a href="{{ action('Admission\PostnatalDaycareController@edit', SiteHelpers::encrypt_id($list['PDayId'])) }}" class="btn btn-info btn-view">
                                                                    <i class="fa fa-edit" aria-hidden="true"></i>
                                                                </a>
                                                                @endif
                                                            </td>
                                                            <td class="align-center input-width-small">
                                                                @if (in_array('POST_DAY',$read_permissions))
                                                                <a class="icon btn btn-warning btn-view" href="{{ action('Admission\PostnatalDaycareController@printData', SiteHelpers::encrypt_id($list['PDayId'])) }}">
                                                                <i class="fa fa-print"></i>
                                                                </a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @php $i++ @endphp  
                                                    @endforeach
                                                @endforeach
                                            @else 
                                                <tr class="text-center">
                                                    <td colspan="3"> No Reports Found</td>
                                                </tr>
                                            @endif    
                                        </tbody>
                                    </table>
                                    <!-- /.row -->
                                </div>
                                <!-- /.widget-content -->
                            </div>
                            <!-- /.widget -->
                        </div>
                    @endif
                    @if($results['pediatric_summary'] && is_array($permissions) && in_array('PEDI_FORM',$permissions))   
                        <div class="col-md-6 col-sm-6">
                            <div class="widget box homepage-overview-board">
                                <div class="widget-header">
                                    <h4><span href="javascript:void(0);"><i class="fa fa-reorder"></i></span>Pediatric Admission</h4>
                                    <div class="toolbar no-padding">
                                        <div class="btn-group">
                                            <span class="btn btn-xs widget-collapse" id="widget-collapse-14"><i class="fa fa-angle-up fa-2x"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content no-padding">
                                    <table class="table table-striped table-checkable table-hover">
                                        <thead>
                                            <tr>
                                                <th class="align-left">Admission List</th>
                                                <th class="align-center input-width-small">Edit</th>
                                                <th class="align-center input-width-small">Print</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($results['pediatric_summary']) > 0)    
                                                @foreach($results['pediatric_summary'] as $value_pediatric_summary)
                                                    <tr>
                                                        <td class="align-left">{{  $value_pediatric_summary->episodes }}</td>
                                                        <td class="align-center input-width-small">
                                                            @if (in_array('PEDI_FORM',$write_permissions))
                                                            @php $url = SiteHelpers::encrypt_id($value_pediatric_summary->id); @endphp
                                                            <a class="btn btn-info btn-view" href="{{ action('Admission\PediatricController@edit', $url) }}">
                                                            <i class="fa fa-edit"></i>
                                                            </a>
                                                            @endif
                                                        </td>
                                                        <td class="align-center input-width-small">
                                                            @if (in_array('PEDI_FORM',$read_permissions))
                                                            @php $url = SiteHelpers::encrypt_id($value_pediatric_summary->id); @endphp
                                                            <a class="icon btn btn-warning btn-view" href="{{ action('Admission\PediatricController@print', $url) }}">
                                                            <i class="fa fa-print"></i>
                                                            </a>
                                                            @endif
                                                        </td>  
                                                    </tr>
                                                @endforeach
                                            @else 
                                                <tr class="text-center">
                                                    <td colspan="3"> No Reports Found</td>
                                                </tr>
                                            @endif    
                                        </tbody>
                                    </table>
                                    <!-- /.row -->
                                </div>
                                <!-- /.widget-content -->
                            </div>
                            <!-- /.widget -->
                        </div>
                    @endif 
                    @if($results['nurse_sheet'] && is_array($permissions) && in_array('NICU_MODULE_SHEET',$permissions)) 
                        <div class="col-md-6 col-sm-6">
                            <div class="widget box homepage-overview-board">
                                <div class="widget-header">
                                    <h4><span href="javascript:void(0);"><i class="fa fa-reorder"></i></span>Nurse's Hourly Entry</h4>
                                    <div class="toolbar no-padding">
                                        <div class="btn-group">
                                            <span class="btn btn-xs widget-collapse" id="widget-collapse-15"><i class="fa fa-angle-up fa-2x"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content no-padding">
                                    <table class="table table-striped table-checkable table-hover">
                                        <thead>
                                            <tr>
                                                <th class="align-left">List</th>
                                                <th class="align-center input-width-small">Edit</th>
                                                <th class="align-center input-width-small">View/Print</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $i = count($results['nurse_sheet']) @endphp
                                            @if(count($results['nurse_sheet']) > 0)   
                                                @foreach($results['nurse_sheet'] as $key => $nurse_sheet_lists)
                                                    <tr>
                                                        <td colspan="3" class="align-center">
                                                            <h5 class="display-inline-block">Admission {{  $i }} </h5>
                                                            <span class="btn daycare-list-3 pull-right" data-daycare-list=".daycare-list-3-{{ $i }}" href="javascript:void(0);">
                                                            <i class="fa fa-angle-up icon-angle-down"></i>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="daycare-list-3-{{ $i }} p-must-0">
                                                            <table class="table table-striped table-checkable table-hover">
                                                                <tbody>
                                                                    @php 
                                                                        $admission_id = isset(collect($nurse_sheet_lists)->first()->admission_id) ? collect($nurse_sheet_lists)->first()->admission_id : null;
                                                                    @endphp 
                                                                    @if ($admission_id != null)
                                                                        <tr>
                                                                            <td class="align-left">Graphical View</td>
                                                                            <td>-</td>
                                                                            <td>
                                                                                <a class="btn btn-success btn-view" href="{{ action('Nurse\NurseChartController@graphicalview',[\SiteHelpers::encrypt_id($results['baby_details']->BabyId), \SiteHelpers::encrypt_id($admission_id)]) }}?date=&closewinlink=search-reports"><i class="fa fa-eye"></i></a>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="align-left">All-In-One chart</td>
                                                                            <td>-</td>
                                                                            <td>
                                                                                <a class="btn btn-success btn-view" href="{{ url('multiple-chart').'/'.\SiteHelpers::encrypt_id($results['baby_details']->BabyId).'/'.\SiteHelpers::encrypt_id($admission_id).'/0'}}/search-reports"><i class="fa fa-eye"></i></a>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="align-left">Weekly Chart</td>
                                                                            <td>-</td>
                                                                            <td>
                                                                                <a class="btn btn-warning btn-view" href="{{ url('nicu-nurse-sheets/get-weekly-observations/'.\SiteHelpers::encrypt_id($admission_id).'/0') }}?closewinlink=search-reports"><i class="fa fa-print" aria-hidden="true"></i></a>
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                    @foreach($nurse_sheet_lists as $list)   
                                                                        <tr>
                                                                            <td class="align-left">{{ $list->day_name }}</td>
                                                                            <td class="align-center input-width-small">
                                                                                @if (in_array('NICU_MODULE_SHEET',$write_permissions))
                                                                                <a href="{{ action('Nurse\NurseSheetController@edit', SiteHelpers::encrypt_id($list->id)) }}" class="btn btn-info btn-view">
                                                                                <i class="fa fa-edit" aria-hidden="true"></i>
                                                                                </a>
                                                                                @endif
                                                                            </td>
                                                                            <td class="align-center input-width-small">
                                                                                @if (in_array('NICU_MODULE_SHEET',$read_permissions))
                                                                                <a class="icon btn btn-warning btn-view" href="{{ action('Nurse\NurseSheetController@print', SiteHelpers::encrypt_id($list->id)) }}">
                                                                                <i class="fa fa-print"></i>
                                                                                </a>
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    @php $i-- @endphp  
                                                @endforeach
                                            @else 
                                                <tr class="text-center">
                                                    <td colspan="3"> No Reports Found</td>
                                                </tr>
                                            @endif    
                                        </tbody>
                                    </table>
                                    <!-- /.row -->
                                </div>
                                <!-- /.widget-content -->
                            </div>
                            <!-- /.widget -->
                        </div>
                    @endif
                    @if($results['prescription'] && is_array($permissions) && in_array('PRESCRIPTION',$permissions)) 
                        <div class="col-md-6 col-sm-6">
                            <div class="widget box homepage-overview-board">
                                <div class="widget-header">
                                    <h4><span href="javascript:void(0);"><i class="fa fa-reorder"></i></span>Prescription</h4>
                                    <div class="toolbar no-padding">
                                        <div class="btn-group">
                                            <span class="btn btn-xs widget-collapse" id="widget-collapse-16"><i class="fa fa-angle-up fa-2x"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content no-padding">
                                    <table class="table table-striped table-checkable table-hover">
                                        <thead>
                                            <tr>
                                                <th class="align-left">Admission List</th>
                                                <th class="align-center input-width-small">Edit</th>
                                                <th class="align-center input-width-small">Print</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $i = count($results['prescription']); @endphp
                                            @if(count($results['prescription']) > 0)    
                                                @foreach ($results['prescription'] as $key => $value)
                                                    <tr>
                                                        <td class="align-left">Admission {{ $i }}</td>
                                                        <td>
                                                            @if (in_array('PRESCRIPTION',$write_permissions))
                                                            <a href="{{ url('prescription/'.\SiteHelpers::encrypt_id($value.'-'.$key)) }}" class="btn btn-info btn-view">
                                                            <i class="fa fa-edit" aria-hidden="true"></i>
                                                            </a>
                                                            @endif
                                                        </td>
                                                        <td class="align-center input-width-small">
                                                            @if (in_array('PRESCRIPTION',$read_permissions))
                                                            <a class="icon btn btn-warning btn-view" href="{{ url('prescription-print/'.\SiteHelpers::encrypt_id($value).'/'.\SiteHelpers::encrypt_id($key).'/'.date('d-m-Y').'/'.'search-view') }}">
                                                            <i class="fa fa-print"></i>
                                                            </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @php $i--; @endphp
                                                @endforeach
                                            @else 
                                                <tr class="text-center">
                                                    <td colspan="3">No Reports Found</td>
                                                </tr>
                                            @endif    
                                        </tbody>
                                    </table>
                                    </table>
                                    <!-- /.row -->
                                </div>
                                <!-- /.widget-content -->
                            </div>
                            <!-- /.widget -->
                        </div>
                    @endif
                @endif
            @endif
        @else
            <div class="no-filter"><i class="fa fa-filter fa-2x"></i></div>
        @endif
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">    
$('.daycare-list-1').click(function() {
    var daycareList = $(this).data('daycare-list');
    if ($(this).children('i').hasClass("fa-angle-up")) {
        $(this).children('i').removeClass('fa-angle-up icon-angle-down').addClass('fa-angle-down icon-angle-up');
        $(daycareList).slideUp(); 
    } else {
        $(this).children('i').removeClass('fa-angle-down icon-angle-up').addClass('fa-angle-up icon-angle-down');
        $(daycareList).slideDown(); 
    }

}); 
$('.daycare-list-2').click(function() {
    var daycareList = $(this).data('daycare-list');
    if ($(this).children('i').hasClass("fa-angle-up")) {
        $(this).children('i').removeClass('fa-angle-up icon-angle-down').addClass('fa-angle-down icon-angle-up');
        $(daycareList).slideUp(); 
    } else {
        $(this).children('i').removeClass('fa-angle-down icon-angle-up').addClass('fa-angle-up icon-angle-down');
        $(daycareList).slideDown(); 
    }

}); 
$('.daycare-list-3').click(function() {
    var daycareList = $(this).data('daycare-list');
    if ($(this).children('i').hasClass("fa-angle-up")) {
        $(this).children('i').removeClass('fa-angle-up icon-angle-down').addClass('fa-angle-down icon-angle-up');
        $(daycareList).slideUp(); 
    } else {
        $(this).children('i').removeClass('fa-angle-down icon-angle-up').addClass('fa-angle-up icon-angle-down');
        $(daycareList).slideDown(); 
    }

});
</script>
@endsection
