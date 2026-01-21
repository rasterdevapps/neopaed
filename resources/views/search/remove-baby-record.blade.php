@extends('app')
@section('content')
    <div class="crumbs bread-crumbs-shadow">
        <ul id="breadcrumbs" class="breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="{{ url('/') }}">Dashboard</a>
            </li>
            <li>

            </li>
        </ul>
    </div>
    <div class="col-md-12 plr-0">
        <div class="row mtb-20">
            <div class="col-md-11">
                {{ Form::open(['url' => action('Search\RemoveBabyRecordController@index', 0), 'method'=>'get']) }}
                    <div class="col-md-9 col-sm-9 col-xs-9 pl-10">
                        {{ Form::select('baby_id', $results['baby_list'], $baby_id, ['class'=>'select2-select-00 input-fields-shadow col-md-9 full-width-fix']) }}
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3 plr-0">
                        <button class="btn btn-primary search-baby-record save-button-shadow"> Search </button>
                    </div> 
                {{ Form::close() }}
            </div>            
        </div>
        @if (isset($results['baby_id']->IsDeleted) && $results['baby_id']->IsDeleted != 1)
        <div class="row">
            <div class="col-md-12 text-center">
                <h3> Record of the Baby </h3>
                <h3>{!! $results['baby_id']->BabyName !!} - {!! $results['baby_id']->BMrNo !!}</h3>
            </div>
        </div> 
        <div class="col-md-12 plr-0">
            <table class="table">
                <thead>
                    <tr>
                        <th>List</th>
                        <th class="align-center remove">Remove</th>
                        <th class="align-center status">Status</th>
                    </tr>
                </thead>
                    <tbody>
                        @if(count($results['motherrecord']) > 0)
                            <tr class="mother-list">
                                <td>{!! $results['motherrecord'][0]->MotherName !!} - Mother</td>
                                @php $mother_status = SiteHelpers::Status($results['motherrecord'][0]->MotherId, 'Mother Registration'); @endphp
                                @if(empty($mother_status->Status) || $mother_status->Status == 'Restored')
                                    <td class="align-center">
                                        <a href="{{ action('Search\RemoveBabyRecordController@mother_destroy', ['baby_id' => $results['baby_id']->BabyId, 'mother_id' => $results['motherrecord'][0]->MotherId]) }}" class="mother-destroy"> 
                                            <i class="fa fa-trash" aria-hidden="true"></i> 
                                        </a>
                                    </td>
                                    <td class="align-center">-</td>
                                @else
                                    <td class="align-center">-</td>
                                    @if ($mother_status->Status == 'Pending')
                                        <td class="align-center">Waiting for an approval</td>
                                    @else 
                                        <td class="align-center"> {{ $mother_status->Status }}</td>
                                    @endif
                                @endif
                            </tr>
                        @else
                            <tr class="text-center">
                                <td colspan="3">Mother Record Deleted</td>
                            </tr>
                        @endif
                        @if(count($results['baby_details']) > 0)
                            <tr class="baby-list">
                                <td>{!! $results['baby_details'][0]->BabyName !!} - Baby</td>
                                @php $baby_status = SiteHelpers::Status($results['baby_details'][0]->BabyId, 'Baby Registration'); @endphp
                                @if(empty($baby_status->Status) || $baby_status->Status == 'Restored')
                                    <td class="align-center" class="visible">
                                        <a href="{{ action('Search\RemoveBabyRecordController@baby_destroy', $results['baby_details'][0]->BabyId)}}" class="baby-destroy remove-icon"> 
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                    <td class="align-center">-</td>
                                @else
                                    <td class="align-center">-</td>
                                    @if ($baby_status->Status == 'Pending')
                                        <td class="align-center">Waiting for an approval</td>
                                    @else
                                        <td class="align-center"> {{ $baby_status->Status }}</td>
                                    @endif
                                @endif
                            </tr>
                        @else
                            <tr class="text-center">
                                <td colspan="3">Baby Record Deleted</td>
                            </tr>
                        @endif
                    </tr>
                    @if(count($results['neonatal_list']) > 0)
                        <tr  class="neonatal-performa-list">
                            <td>{!! $results['baby_id']->BabyName !!} - Neonatal Proforma </td>
                            @php $neonatal_status = SiteHelpers::Status($results['neonatal_list'][0]->NeonatalId, 'Neonatal Proforma'); @endphp
                            @if(empty($neonatal_status->Status) || $neonatal_status->Status == 'Restored')
                                <td class="align-center">
                                    <a href="{{ action('Search\RemoveBabyRecordController@neonatal_performa_destroy',['baby_id' => $results['baby_id']->BabyId, 'neonatal_id' => SiteHelpers::encrypt_id($results['neonatal_list'][0]->NeonatalId)]) }}" class="neonatal-performa-destroy">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </a>
                                </td>
                                <td class="align-center">-</td>
                            @else
                                <td class="align-center">-</td>
                                @if ($neonatal_status->Status == 'Pending')
                                    <td class="align-center">Waiting for an approval</td>
                                @else
                                    <td class="align-center">{{ $neonatal_status->Status }}</td>
                                @endif
                            @endif
                        </tr>
                    @else
                        <tr class="text-center">
                            <td colspan="3">Neonatal performa record Deleted</td>
                        </tr>
                    @endif 
                </tbody>
            </table>
        </div> 
        <div class="row">
            @if($results['nicuadmission'])
                <div class="col-md-6 col-sm-6">
                    <div class="widget box homepage-overview-board">
                        <div class="widget-header">
                            <h4>
                                <a href="javascript:void(0);">
                                    <i class="fa fa-reorder"></i>
                                </a>Nicu Admission
                            </h4>
                            <div class="toolbar no-padding">
                                <div class="btn-group">
                                    <span class="btn btn-xs widget-collapse" id="widget-collapse-1">
                                        <i class="fa fa-angle-down arrow"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content no-padding">
                            <table class="table table-striped table-checkable table-hover">
                                <thead>
                                    <tr>
                                        <th>List</th>
                                        <th class="align-center">Remove</th>
                                        <th class="align-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($results['nicuadmission']) > 0)   
                                        @for ($i = 0; $i < @count($results['nicuadmission']); $i++)
                                            <tr class="nicu-list">
                                                <td>{{  $results['nicuadmission'][$i]->episodes }}</td>
                                                @php $nicu_status[$i] = SiteHelpers::Status($results['nicuadmission'][$i]->NicuId, 'NICU Admission'); @endphp
                                                @if(empty($nicu_status[$i]->Status) || $nicu_status[$i]->Status == 'Restored')
                                                    <td class="align-center center-align-phone">
                                                        <a class="icon nicu-destroy" href="{{ action('Search\RemoveBabyRecordController@nicu_destroy',['baby_id'=>$results['nicuadmission'][$i]->BabyId, 'nicu_id'=>$results['nicuadmission'][$i]->NicuId]) }}">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </td>
                                                    <td class="align-center">-</td>
                                                @else
                                                    <td class="align-center">-</td>
                                                    @if ($nicu_status[$i]->Status == 'Pending')
                                                        <td class="align-center">Waiting for an approval</td>
                                                    @else
                                                        <td class="align-center">{{ $nicu_status[$i]->Status }}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endfor
                                    @else 
                                        <tr class="text-center">
                                            <td colspan="3"> No Reports Found</td> 
                                        </tr>     
                                    @endif    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
            @if($results['postnatal_admmission']) 
                <div class="col-md-6 col-sm-6">
                    <div class="widget box homepage-overview-board">
                        <div class="widget-header">
                            <h4><a href="javascript:void(0);"><i class="fa fa-reorder"></i></a>Postnatal Admission</h4>
                            <div class="toolbar no-padding">
                                <div class="btn-group">
                                    <span class="btn btn-xs widget-collapse" id="widget-collapse-2">
                                        <i class="fa fa-angle-down arrow"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content no-padding postnatal-destroy">
                            <table class="table table-striped table-checkable table-hover">
                                <thead>
                                    <tr>
                                        <th>List</th>
                                        <th class="align-center remove">Remove</th>
                                        <th class="align-center status">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($results['postnatal_admmission']) > 0)   
                                        @for ($i = 0; $i <  @count($results['postnatal_admmission']); $i++)
                                            <tr class="postnatal-list">
                                                <td>{{  $results['postnatal_admmission'][$i]->episodes }}</td>
                                                @php $postnatal_status = SiteHelpers::Status($results['postnatal_admmission'][$i]->pid, 'Postnatal Admission'); @endphp
                                                @if(empty($postnatal_status->Status) || $postnatal_status->Status == 'Restored')
                                                    <td class="align-center center-align-phone remove">
                                                        <a class="icon" href="{{ action('Search\RemoveBabyRecordController@postnatal_destroy', ['baby_id'=>$results['postnatal_admmission'][$i]->BabyId, 'post_id' => SiteHelpers::encrypt_id($results['postnatal_admmission'][$i]->pid)]) }}">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </td>
                                                    <td class="align-center">-</td>
                                                @else
                                                    <td class="align-center">-</td>
                                                    @if ($postnatal_status->Status == 'Pending')
                                                        <td class="align-center">Waiting for an approval</td>
                                                    @else
                                                        <td class="align-center">{{ $postnatal_status->Status }}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endfor
                                    @else 
                                        <tr class="text-center">
                                            <td colspan="3"> No Reports Found</td>
                                        </tr>     
                                    @endif    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>                      
        <div class="row">    
            <div class="col-md-6 col-sm-6">
                <div class="widget box homepage-overview-board">
                    <div class="widget-header">
                        <h4><a href="javascript:void(0);"><i class="fa fa-reorder"></i></a>Nicu Daycare Sheets</h4>
                        <div class="toolbar no-padding">
                            <div class="btn-group">
                                <span class="btn btn-xs widget-collapse" id="widget-collapse-3">
                                    <i class="fa fa-angle-down arrow"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content no-padding">
                        <table class="table table-striped table-checkable table-hover">
                            <thead>
                                <tr>
                                    <th>List</th>
                                    <th class="align-center">Remove</th>
                                    <th class="align-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>                                
                                @php $i = 1 @endphp
                                @if(count($results['daycare_list']) > 0)
                                    @foreach($results['daycare_list'] as $key => $day_lists)
                                        <tr>
                                            <td><b>{{ $key }}</b></td>
                                            <td class="text-right" colspan="2">
                                                <a class="btn daycare-list" href="javascript:void(0);" data-daycare-list=".daycare-list-{{$i}}"  id="widget-collapse-9-{{$i}}">
                                                    <i class="fa fa-angle-up icon-angle-down arrow"></i>
                                                </a>
                                            </td>
                                        </tr> 
                                        @php $j = 1 @endphp
                                        @foreach($day_lists as $list)
                                            <tr class="daycare-list-{{$i}}">
                                                <td>{{ 'Day '.$j }}</td>
                                                @php $nicu_daycare_status = SiteHelpers::Status($list->DayId, 'Daycare Sheet'); @endphp
                                                @if(empty($nicu_daycare_status->Status) || $nicu_daycare_status->Status == 'Restored')
                                                    <td class="text-center">
                                                        <a href="{{ action('Search\RemoveBabyRecordController@nicu_daycare_destroy', $list->DayId) }}">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </td>
                                                    <td class="align-center">-</td>
                                                @else
                                                    <td class="align-center">-</td>
                                                    @if ($nicu_daycare_status->Status == 'Pending')
                                                        <td class="align-center">Waiting for an approval</td>
                                                    @else
                                                        <td class="align-center">{{ $nicu_daycare_status->Status }}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                            @php $j++ @endphp
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
                    </div>
                </div>                
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="widget box homepage-overview-board">
                    <div class="widget-header">
                        <h4><a href="javascript:void(0);"><i class="fa fa-reorder"></i></a>Postnatal Daycare Sheets</h4>
                        <div class="toolbar no-padding">
                            <div class="btn-group">
                                <span class="btn btn-xs widget-collapse" id="widget-collapse-4">
                                    <i class="fa fa-angle-down arrow"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content no-padding">
                        <table class="table table-striped table-checkable table-hover">
                            <thead>
                                <tr>
                                    <th>List</th>
                                    <th class="align-center">Remove</th>
                                    <th class="align-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>                                
                                @php $i = 1 @endphp
                                @if(count($results['postnatal_daycare']) > 0)
                                    @foreach($results['postnatal_daycare'] as $key => $day_lists)
                                        <tr>
                                            <td><b>{{ $key }}</b></td>
                                            <td class="text-right" colspan="2">
                                                <a class="btn daycare-list" href="javascript:void(0);"  data-daycare-list=".daycare-list-{{$i}}" id="widget-collapse-10-{{$i}}">                                                    
                                                    <i class="fa fa-angle-up icon-angle-down arrow"></i>
                                                </a>
                                            </td>
                                        </tr> 
                                        @php $j = 1 @endphp
                                        @foreach($day_lists as $list)
                                            <tr class="daycare-list-{{$i}}">
                                                <td>{{ 'Day '.$j }}</td>
                                                @php $post_daycare_status = SiteHelpers::Status($list->PDayId, 'Postnatal Daycare Sheet'); @endphp
                                                @if(empty($post_daycare_status->Status) || $post_daycare_status->Status == 'Restored')
                                                    <td class="text-center">
                                                        <a class="icon" href="{{ action('Search\RemoveBabyRecordController@postnatal_daycare_destroy', $list->PDayId) }}">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </td>
                                                    <td class="align-center">-</td>
                                                @else
                                                    <td class="align-center">-</td>
                                                    @if ($post_daycare_status->Status == 'Pending')
                                                        <td class="align-center">Waiting for an approval</td>
                                                    @else
                                                        <td class="align-center">{{ $post_daycare_status->Status }}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                            @php $j++ @endphp
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
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @if($results['postnatal_discharge'])
                <div class="col-md-6 col-sm-6">
                    <div class="widget box homepage-overview-board">
                        <div class="widget-header">
                            <h4><a href="javascript:void(0);"><i class="fa fa-reorder"></i></a>Postnatal Discharge</h4>
                            <div class="toolbar no-padding">
                                <div class="btn-group">
                                    <span class="btn btn-xs widget-collapse" id="widget-collapse-5">
                                        <i class="fa fa-angle-down arrow"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content no-padding">
                            <table class="table table-striped table-checkable table-hover">
                                <thead>
                                    <tr>
                                        <th>List</th>
                                        <th class="align-center">Remove</th>
                                        <th class="align-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($results['postnatal_discharge']) > 0)   
                                        @for ($i = 0; $i <  @count($results['postnatal_discharge']); $i++)
                                            <tr>
                                                <td>{{ $results['postnatal_discharge'][$i]->episodes }}</td>
                                                @php $postnatal_discharge_status = SiteHelpers::Status($results['postnatal_discharge'][$i]->posdisid, 'Postnatal Discharge'); @endphp
                                                @if(empty($postnatal_discharge_status->Status) || $postnatal_discharge_status->Status == 'Restored')
                                                    <td class="align-center center-align-phone">
                                                        <a href="{{ action('Search\RemoveBabyRecordController@postnatal_discharge_destroy', $results['postnatal_discharge'][$i]->posdisid) }}">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </td>
                                                    <td class="align-center">-</td>
                                                @else
                                                    <td class="align-center">-</td>
                                                    @if ($postnatal_discharge_status->Status == 'Pending')
                                                        <td class="align-center">Waiting for an approval</td>
                                                    @else
                                                        <td class="align-center">{{ $postnatal_discharge_status->Status }}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endfor
                                    @else 
                                        <tr class="text-center">
                                            <td colspan="3"> No Reports Found</td>
                                        </tr>     
                                    @endif    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>            
            @endif
            @if($results['op_visite'])
                <div class="col-md-6 col-sm-6">
                    <div class="widget box homepage-overview-board">
                        <div class="widget-header">
                            <h4><a href="javascript:void(0);"><i class="fa fa-reorder"></i></a>Op Reports</h4>
                            <div class="toolbar no-padding">
                                <div class="btn-group">
                                    <span class="btn btn-xs widget-collapse" id="widget-collapse-6">
                                        <i class="fa fa-angle-down arrow"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content no-padding dashboard-op-list" >
                            <table class="table table-striped table-checkable table-hover">
                                <thead>
                                    <tr>
                                        <th>Visite List</th>
                                        <th class="align-center">Remove</th>
                                        <th class="align-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($results['op_visite']) > 0)    
                                        @for ($i = 0; $i <  @count($results['op_visite']); $i++)
                                            <tr>
                                                <td>{{ $results['op_visite'][$i]->op_visite }}</td>
                                                @php $op_status = SiteHelpers::Status($results['op_visite'][$i]->OpId, 'OP Registration'); @endphp
                                                @if(empty($op_status->Status) || $op_status->Status == 'Restored')
                                                    <td class="align-center center-align-phone">
                                                        <a class="icon op-destroy" href="{{ action('Search\RemoveBabyRecordController@op_destroy',$results['op_visite'][$i]->OpId) }}">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </td>
                                                    <td class="align-center">-</td>
                                                @else
                                                    <td class="align-center">-</td>
                                                    @if ($op_status->Status == 'Pending')
                                                        <td class="align-center">Waiting for an approval</td>
                                                    @else
                                                        <td class="align-center">{{ $op_status->Status }}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endfor
                                    @else 
                                        <tr class="text-center">
                                            <td colspan="3"> No Reports Found</td>
                                        </tr>     
                                    @endif    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>                
            @endif                
        </div>   
        <div class="row">
            @if($results['echocardiogram']) 
                <div class="col-md-6 col-sm-6">
                    <div class="widget box homepage-overview-board">
                        <div class="widget-header">
                            <h4><a href="javascript:void(0);"><i class="fa fa-reorder"></i></a>Echocardiography</h4>
                            <div class="toolbar no-padding">
                                <div class="btn-group">
                                    <span class="btn btn-xs widget-collapse" id="widget-collapse-7">
                                        <i class="fa fa-angle-down arrow"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content no-padding dashboard-op-list" >
                            <table class="table table-striped table-checkable table-hover">
                                <thead>
                                    <tr>
                                        <th>List</th>
                                        <th class="align-center">Remove</th>
                                        <th class="align-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($results['echocardiogram']) > 0)    
                                        @for ($i = 0; $i <  @count($results['echocardiogram']); $i++)
                                            <tr>
                                                <td>{{  date('d-m-Y', strtotime($results['echocardiogram'][$i]->TestDate)) }}</td>
                                                @php $echo_status = SiteHelpers::Status($results['echocardiogram'][$i]->EchoId, 'Echocardiography'); @endphp
                                                @if(empty($echo_status->Status) || $echo_status->Status == 'Restored')
                                                    <td class="align-center center-align-phone">
                                                        <a class="icon echocardiography-destroy" href="{{ action('Search\RemoveBabyRecordController@echocardiography_destroy',$results['echocardiogram'][$i]->EchoId) }}">
                                                        <i class="fa fa-trash"></i>
                                                        </a>
                                                    </td>
                                                    <td class="align-center">-</td>
                                                @else
                                                    <td class="align-center">-</td>
                                                    @if ($echo_status->Status == 'Pending')
                                                        <td class="align-center">Waiting for an approval</td>
                                                    @else
                                                        <td class="align-center">{{ $echo_status->Status }}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endfor
                                    @else 
                                        <tr class="text-center">
                                            <td colspan="3"> No Reports Found</td>
                                        </tr>     
                                    @endif    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
            @if($results['ultraculture']) 
                <div class="col-md-6 col-sm-6">
                    <div class="widget box homepage-overview-board">
                        <div class="widget-header">
                            <h4><a href="javascript:void(0);"><i class="fa fa-reorder"></i></a>Cranial Ultrasonography</h4>
                            <div class="toolbar no-padding">
                                <div class="btn-group">
                                    <span class="btn btn-xs widget-collapse" id="widget-collapse-8">
                                        <i class="fa fa-angle-down arrow"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content no-padding dashboard-op-list" >
                            <table class="table table-striped table-checkable table-hover">
                                <thead>
                                    <tr>
                                        <th>List</th>
                                        <th class="align-center">Remove</th>
                                        <th class="align-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($results['ultraculture']) > 0)    
                                        @for ($i = 0; $i <  @count($results['ultraculture']); $i++)
                                            <tr>
                                                <td>{{  date('d-m-Y', strtotime($results['ultraculture'][$i]->TestDate)) }}</td>
                                                @php $ultra_status = SiteHelpers::Status($results['ultraculture'][$i]->UltraId, 'Ultra Sound Scan'); @endphp
                                                @if(empty($ultra_status->Status) || $ultra_status->Status == 'Restored')
                                                    <td class="align-center center-align-phone">
                                                        <a class="icon" href="{{ action('Search\RemoveBabyRecordController@cranial_ultrasonography_destroy',$results['ultraculture'][$i]->UltraId) }}">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </td>
                                                    <td class="align-center">-</td>
                                                @else
                                                    <td class="align-center">-</td>
                                                    @if ($ultra_status->Status == 'Pending')
                                                        <td class="align-center">Waiting for an approval</td>
                                                    @else
                                                        <td class="align-center">{{ $ultra_status->Status }}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endfor
                                    @else 
                                        <tr class="text-center">
                                            <td colspan="3"> No Reports Found</td>
                                        </tr>     
                                    @endif    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>                 
            @endif                  
        </div>
        @else
        <div class="text-center">
            No Record Found
        </div>
        @endif
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            var babyId = $('select[name="baby_id"]').val();

            $('.search-baby-record').click(function(e) {
                e.preventDefault();
                var babyId = $('select[name="baby_id"]').val();
                var searchUrl = '{{ url("search-baby-reports") }}/'+babyId;
                window.location.href = searchUrl;
            });

            $('.fa-angle-down').click();
            
            $('[id^="widget-collapse-"]').click(function() {
                var arrow = $(this).attr('id');
                if(!$("#"+arrow+" > i").hasClass('fa-angle-down')) {
                    $("#"+arrow+" > .arrow").removeClass('fa-angle-down icon-angle-up').addClass('fa-angle-up icon-angle-down');
                } else {
                    $("#"+arrow+" > .arrow").removeClass('fa-angle-up icon-angle-down').addClass('fa-angle-down icon-angle-up');
                }
            });

            $('.daycare-list').click(function() {
                var daycareList = $(this).data('daycare-list');
                if ($(this).children('i').hasClass("fa-angle-up")) {
                    $(this).children('i').removeClass('fa-angle-up icon-angle-down').addClass('fa-angle-down icon-angle-up');
                    $(daycareList).slideUp(); 
                } else {
                    $(this).children('i').removeClass('fa-angle-down icon-angle-up').addClass('fa-angle-up icon-angle-down');
                    $(daycareList).slideDown(); 
                }

            });      
            $('.mother-destroy').click(function(e){
                e.preventDefault();
                var href = $(this).attr('href');
                var message = '.mother-list';
                removerecord(href, message);
            });      
            $('.baby-destroy').click(function(e){
                e.preventDefault();
                var href = $(this).attr('href');
                var message = '.baby-list';
                removerecord(href, message);
            });     
            $('.neonatal-performa-destroy').click(function(e){
                e.preventDefault();
                var href = $(this).attr('href');
                var message = '.neonatal-performa-list';
                removerecord(href, message);
            });     
            $('.nicu-destroy').click(function(e){
                e.preventDefault();
                var href = $(this).attr('href');
                var message = '.nicu-list';
                removerecord(href, message);
            });
            $('.postnatal-destroy a').click(function(e){
                e.preventDefault();
                var href = $(this).attr('href');
                var message = '.postnatal-list';
                removerecord(href, message);
            }); 
            function removerecord(href, message) {                
                $.ajax({
                    type: "GET",
                    url: href,
                    success: function (response) {
                        Showalert(response.type,response.text);
                        if (response.type == 'success') {
                            var find_row = $('a[href="'+href+'"]').parents("tr");
                            find_row.find('td:nth-child(2)').html('<span>-</span>');
                            find_row.find('td:last-child').html('<span>'+response.status+'</span>');
                        }
                    },
                    error: function () {
                        Showalert('error','Contact Admin.');                     
                    }
                });
            }         
        });        
    </script>
@endsection
