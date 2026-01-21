<link rel="stylesheet" type="text/css" href="{{$site_url}}/css/nurse_sheet_approval.css">
{!! Form::hidden('monitor_data', json_encode($monitor_data)) !!}
{!! Form::hidden('ventilator_data', json_encode($ventilator_data)) !!}
{!! Form::hidden('pump_data', json_encode($pump_data)) !!}
@php
$site_url = url('/').'/public';
@endphp
<div class="sheet-loader"></div>
<div class="modal fade bs-example-modal-lg" id="approval-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close close-alt btn" data-dismiss="modal" aria-label="close" disabled="true"><span aria-hidden="true">&times;</span></button>
            <h5 class="text-center color-white"><b>Waiting for approval</b></h5>
        </div>
        <div class="modal-body row">
            <div class="panel panel-default">
                <div class="panel-body p-0">
                    <div class="stepper">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a class="persistant-disabled" href="#stepper-step-1" data-toggle="tab" aria-controls="stepper-step-1" role="tab">
                                    <span class="round-tab"><i class="fas fa-pager"></i><b>Monitor</b></span>
                                </a>
                            </li>
                            <li role="presentation">
                                <a class="persistant-disabled" href="#stepper-step-2" data-toggle="tab" aria-controls="stepper-step-2" role="tab">
                                    <span class="round-tab"><i class="fas fa-lungs"></i><b>Ventilator</b></span>
                                </a>
                            </li>
                            <li role="presentation">
                                <a class="persistant-disabled" href="#stepper-step-3" data-toggle="tab" aria-controls="stepper-step-3" role="tab">
                                    <span class="round-tab"><i class="fas fa-syringe"></i><b>Pump</b></span>
                                </a>
                            </li>
                        </ul>
                        <form role="form" class="m-0">
                            <div class="tab-content">
                                <div id="modal-loader" class="loading-center" style="background: url('{{ $site_url }}/img/icons/preloader.gif') center no-repeat #e8eef6"></div>

                                <div class="tab-pane fade in active" role="tabpanel" id="stepper-step-1">
                                    <div class="tab-sub-content col-md-12 col-sm-12 col-xs-12" id="monitor-data">
                                        <div class="p-15 text-center no-data-msg">No pending data found</div>
                                    </div>
                                    <div class="edit-machine-data"></div>
                                    <div class="tab-footer">
                                        <ul class="list-inline pull-right">
                                            <li class="monitor-next">
                                                <a class="btn btn-info next-step"><i class="fa fa-forward" aria-hidden="true"></i> Next</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-pane fade" role="tabpanel" id="stepper-step-2">
                                    <div class="tab-sub-content col-md-12 col-sm-12 col-xs-12" id="ventilator-data">
                                        <div class="p-15 text-center no-data-msg">No pending data found</div>
                                    </div>
                                    <div class="edit-machine-data"></div>
                                    <div class="tab-footer">
                                        <ul class="list-inline pull-right">
                                            <li class="ventilator-next">
                                                <a class="btn btn-info next-step"><i class="fa fa-forward" aria-hidden="true"></i> Next</a>
                                            </li>
                                            <li class="ventilator-back">
                                                <a class="btn btn-default prev-step"><i class="fa fa-backward" aria-hidden="true"></i> Back</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-pane fade" role="tabpanel" id="stepper-step-3">
                                    <div class="tab-sub-content col-md-12 col-sm-12 col-xs-12" id="pump-data">
                                        <div class="p-15 text-center no-data-msg">No pending data found</div>
                                    </div>
                                    <div class="edit-machine-data"></div>
                                    <div class="tab-footer">
                                        <ul class="list-inline pull-right">
                                            <li class="prescription-back">
                                                <a class="btn btn-default prev-step"><i class="fa fa-backward" aria-hidden="true"></i> Back</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@include('nurse_sheet.nurse_sheet_approval_script')
