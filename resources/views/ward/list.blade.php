@extends('app')
@section('content')
@php 
$write_permission = session('write_permission');
Session::put('slug-nav','discharge-list');
@endphp
<style type="text/css">
    .unselectable {
        -moz-user-select: -moz-none;
        -moz-user-select: none;
        -o-user-select: none;
        -khtml-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .dragaware {
        cursor: pointer;
    }

    .draggable_clone {
        position: absolute; /* also set via javascript */
        z-index: 100001;
        pointer-events:none; /* disable mouse events on the clone */
    }

    .draggable.dragging, .draggable .dragging {
        opacity: 0.5;
    }

    .sortable .sortable_clone {
        position: absolute; /* also set via javascript */
        z-index: 100001;
        list-style-type: none;
        opacity: 0.5;
    }

    .sortable .sortable_placeholder {
        box-sizing: border-box;
        list-style-type: none;
        background: #eee;
        border: 2px dotted #52b218;
    }
    .bed-frame, .bed-transfer
    {
        -webkit-touch-callout: none; /* iOS Safari */
        -webkit-user-select: none; /* Safari */
        -khtml-user-select: none; /* Konqueror HTML */
        -moz-user-select: none; /* Old versions of Firefox */
        -ms-user-select: none; /* Internet Explorer/Edge */
        user-select: none; /* Non-prefixed version, currently
                              supported by Chrome, Edge, Opera and Firefox */
                          }
                          .containerr {
                            /*position: sticky;*/
                            margin: 20px;
                            overflow: hidden;
                            width: 50px;
                            position: fixed;
                            top: 30%;
                            right: 15px;
                            z-index: 99;
                            height: 230px;
                            border-radius: 5px;
                        }
                        .hidden {
                            display: none;
                        }
                        .entry {
                            height: 50px;
                            position: absolute;
                            width: 50px;
                            z-index: 99;
                        }
                        .circle {
                            border: 2px solid #545556;
                            border-radius: 50%;
                            cursor: pointer;
                            height: 40px;
                            position: absolute;
                            transition: border-color 300ms;
                            width: 40px;
                            background: #1e1e2d;
                            z-index: -1;
                            box-shadow: 1px 0px 10px #444;
                        }
                        .entry-label {
                            cursor: pointer;
                            user-select: none;
                            -moz-user-select: none;
                            margin: 7px 0px 0px 16px !important;
                            font-size: 17px;
                            font-weight: 500;
                            color: #fff;
                        }
                        .highlight 
                        {
                            background: #4D98EF;
                            border-radius: 50%;
                            height: 30px;
                            left: 13px;
                            pointer-events: none;
                            position: absolute;
                            top: 13px;
                            transition: transform 400ms cubic-bezier(0.175, 0.885, 0.32, 1.2);
                            transform: translateY(-50px);
                            width: 30px;
                        }
                        .hidden:nth-child(1):checked ~ .highlight {
                            transform: translateY(0);
                        }
                        .hidden:nth-child(3):checked ~ .highlight {
                            transform: translateY(52px);
                        }
                        .hidden:nth-child(5):checked ~ .highlight {
                            transform: translateY(112px);
                        }
                        .hidden:nth-child(7):checked ~ .highlight {
                            transform: translateY(172px);
                        }
                        .hidden:checked + .entry .circle,.hidden:checked + .entry .entry-label{
                            border-color: #4D98EF;
                            color: #fff
                        }
                        .entry:nth-child(2) {
                            left: 8px;
                            top: 8px;
                        }
                        .entry:nth-child(4) {
                            left: 8px;
                            top: 60px;
                        }
                        .entry:nth-child(6) {
                            left: 8px;
                            top: 120px;
                        }
                        .entry:nth-child(8) {
                            left: 8px;
                            top: 180px;
                        }
                        .entry:nth-child(8) .entry-label {
                            margin-left: 8px !important;
                        }
                        .entry:last-child .entry-label {
                            margin-left: 8px !important;
                        }
                        .circle:hover{
                            background: #6F3DAB;
                            background: -webkit-linear-gradient(top, #6F3DAB, #8BA5FD);
                            background: -moz-linear-gradient(top, #6F3DAB, #8BA5FD);
                            background: linear-gradient(to bottom, #6F3DAB, #8BA5FD);
                            z-index: -1;
                        }
                        .circle:hover + .entry-label{
                            /*z-index: -1;*/
                            color: #fff;
                        }
                        .widget.box
                        {
                            border: none !important;
                        }
                        .ward-bed-shadow {
                            box-shadow: inset 0 0 10px #000000;
                        }
                        .tab-content-row {
                            overflow-y: scroll;
                            max-height: 750px;
                            
                        }
                        .card {
                            position: relative;
                            display: inline-block;
                        }
                        .card img {
                            width: 22px;
                            height: 22px;
                        }
                        .card .img-top {
                            display: none;
                            position: absolute;
                            top: 6px;
                            left: 6px;
                            z-index: 99;
                        }
                        .card:hover .img-top {
                            display: inline;
                        }
                        input[value="All"] {
                            margin-right: 10px !important: 
                        }
                        @media (max-width: 480px) {
                            .tabbable-custom > .tab-content, .widget.box .widget-content.no-padding .row, .tab-content .col-md-12
                            {
                                padding: 3px;
                                border: none
                            }
                        }
                        @media (min-width: 1200px) {
                            .col-lg-3 {
                                width: 24.8%;
                            }
                        }
                        .ward-baby-management .widget-content::-webkit-scrollbar {
                          display: none;
                      }

                      .ward-baby-management .widget-content {
                          -ms-overflow-style: none;  
                          scrollbar-width: none;  
                      }
                      hr
                      {
                        border-top: 2px solid #eee;
                    }
                    .widget.box .widget-content.no-padding .row
                    {
                        padding-right: 0px !important;
                        padding-left: 0px !important;
                    }
                    @media screen and (min-width: 300px) and (max-width: 375px)
                    {
                        .ward-baby-management span{
                            font-size: 20px !important;
                        }
                    }
                    .tabbable-custom > .tab-content
                    {
                        padding-top: 0px;
                    }
                    #nurse-bed-model .badge
                    {
                        font-size: 16px;
                    }
                    .ui-datepicker {
                        z-index: 1051 !important;
                    }
</style>
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="{{ url('/') }}">Dashboard</a>
        </li>
        <li class="current">
            <a href="{{ action('Ward\BabyWardController@index') }}">Ward Management</a>
        </li>
    </ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing ward-baby-management">
    <div class="col-md-12">
        <div class="widget box">
            <div class="widget-content room-wise-list no-padding">
                @include('ward.bed-list')
            </div>
        </div>
    </div>
    <!-- /.col-md-12 -->
</div>
<!--=== Page Content end===-->
<!--=== baby list for admit ===-->
<div class="modal fade baby-bed-modal" id="baby-bed-modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>  
                <h5 class="modal-title">
                    <h3>Baby List</h3>
                </h5>
            </div>
            <div class="row modal-body p-15">
                {!! Form::open(['url'=>action('Ward\BabyWardController@getaddbabytobed'), 'method'=>'GET','id'=>'registration-bed-list']) !!}
                <div class="col-md-12 pb-15">
                    {!! Form::label('admission_baby_id','Baby Name:') !!}
                    {!! Form::select('admission_baby_id',[],null,['class'=>'form-control']) !!}
                </div>
                <div class="col-md-12">
                    {!! Form::label('admission_device_id','Device List:') !!}
                    {!! Form::select('admission_device_id',DeviceHelpers::getdeviceList(),null,['class'=>'select2-select-00 full-width-fix','multiple']) !!}
                </div>
            </div>
            <div class="modal-footer">
                <div class="col-md-12">
                    <button id="admitte-baby-bed" type="button" class="btn btn-primary btn-shadow-special pull-right"> Submit </button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
<!--=== baby list for admit end ===-->
<!--=== baby list for admit ===-->
<div class="modal fade baby-pump-modal" id="baby-pump-modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close btn header-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title">
                    <h3>Syringe Pump List</h3>
                </h5>
            </div>
            <div class="modal-body" id="baby-pump-table">
            </div>
            <div class="modal-footer">
                <div class="col-md-12">
                </div>
            </div>
        </div>
    </div>
</div>
<!--=== baby list for admit  ===-->
<div class="modal fade baby-infusion-modal" id="baby-infusion-modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close btn header-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title">
                    <h3>Infusion Pump List</h3>
                </h5>
            </div>
            <div class="modal-body" id="baby-infusion-table">
            </div>
            <div class="modal-footer">
                <div class="col-md-12">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade flow-control-modal" id="nurse-bed-model" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="text-center text-white">Registration</h3>
                <button type="button" class="close modal-close" data-dismiss="modal" aria-hidden="true" style="color:white"><i class="fa fa-times"></i></button>
            </div>
            <div class="modal-body">
                <div class="tab-content">
                    <div class="tab-pane" id="tab2">
                        <div class="col-md-12 center-window">
                            <button value="QUICK" class="btnn btn-primary ward-step2 btn-shadow-special question-option" type="button">
                                Quick
                            </button>
                            <button value="BASIC" class="btnn btn-primary ward-step2 btn-shadow-special question-option" type="button">
                                Basic
                            </button>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab3">
                        <div class="col-md-12 center-window">
                            <button value="NEW" class="btnn btn-primary ward-step3 btn-shadow-special question-option" type="button">
                                New
                            </button>
                            <button value="ALREADY" class="btnn btn-primary ward-step3 btn-shadow-special question-option" type="button">
                                Already
                            </button>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab4">
                        <div class="col-md-12">
                            <form id="quickreg">
                                <div class="form-group text-center mt-15">
                                    <span class="badge badge-success ward-name-span"></span>&ensp;
                                    <span class="badge badge-danger room-name-span"></span>&ensp;
                                    <span class="badge badge-primary bed-name-span"></span>&ensp;
                                </div>
                                <input type="hidden" name="hward_name" class="form-control" value="4F_NICU" data-value="" readonly required>
                                <input type="hidden" name="hroom_name" class="form-control" value="400" data-value="" readonly required>
                                <input type="hidden" name="hbed_name" class="form-control" data-value="" readonly required>
                                <div class="form-group"> 
                                    <label for="baby_mrn">Baby's {{ Lang::get('home.mrn') }}</label>
                                    <input type="text" name="baby_mrn" class="form-control">
                                    <span></span>
                                </div>
                                <div class="form-group"> 
                                    <label for="gender" class="required-label">Gender</label>
                                    <select name="gender" class="form-control" required>
                                        <option value="">- - Select - -</option>
                                        <option value="MALE">Male</option>
                                        <option value="FEMALE">Female</option>
                                        <option value="UNKNOWN">Unknown</option>
                                    </select>
                                    <span></span>
                                </div>
                                <div class="form-group"> 
                                    <label for="age" class="required-label">Age (In Days)</label>
                                    <input type="text" name="age" class="form-control" onkeypress="return isNumber(event, this);" required>
                                    <span></span>
                                </div>
                                <input type="hidden" name="ward_name">
                                <input type="hidden" name="room_no">
                                <input type="hidden" name="bed_no">
                                <div class="col-md-12 plr-0">
                                    <button type="submit" class="btn btn-shadow-special pull-right" id="start-quick-regi"> Start </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab5">
                        <div class="col-md-12">
                            <form id="alreadyreg">
                                <div class="form-group text-center mt-15">
                                    <span class="badge badge-success ward-name-span"></span>&ensp;
                                    <span class="badge badge-danger room-name-span"></span>&ensp;
                                    <span class="badge badge-primary bed-name-span"></span>&ensp;
                                </div>
                                <input type="hidden" name="hward_name" class="form-control" value="4F_NICU" data-value="" readonly required>
                                <input type="hidden" name="hroom_name" class="form-control" value="400" data-value="" readonly required>
                                <input type="hidden" name="hbed_name" class="form-control" data-value="" readonly required>
                                <div class="form-group"> 
                                    <label for="baby_mrn" class="required-label">Baby's {{ Lang::get('home.mrn') }}</label>
                                    <input type="text" name="baby_mrn" class="form-control" maxlength="6" required>
                                    <span></span>
                                </div>
                                <input type="hidden" name="ward_name">
                                <input type="hidden" name="room_no">
                                <input type="hidden" name="bed_no">
                                <div class="col-md-12 plr-0">
                                    <button type="submit" class="btn btn-shadow-special pull-right" id="visit-regi"> Start </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab6">
                        <div class="col-md-12">
                            <form id="basicreg">
                                <div class="form-group text-center mt-15">
                                    <span class="badge badge-success ward-name-span"></span>&ensp;
                                    <span class="badge badge-danger room-name-span"></span>&ensp;
                                    <span class="badge badge-primary bed-name-span"></span>&ensp;
                                </div>
                                <div class="form-group">
                                    <label for="mother_mrn">Mother {{ Lang::get('home.mrn') }}</label>
                                    <input type="text" name="mother_mrn" class="form-control" maxlength="6">
                                    <span></span>
                                </div>
                                <div class="form-group">
                                    <label for="baby_mrn" class="required-label">Baby's {{ Lang::get('home.mrn') }}</label>
                                    <input type="text" name="baby_mrn" class="form-control" maxlength="6">
                                    <span></span>
                                </div>
                                <div class="form-group"> 
                                    <label for="baby_ip_number" class="required-label">Baby's {{ Lang::get('home.ip') }}</label>
                                    <input type="text" name="baby_ip_number" class="form-control" value="IP/" maxlength="10">
                                    <span></span>
                                </div>
                                <input type="hidden" id="add_ward_id">
                                <input type="hidden" id="add_room_id">
                                <input type="hidden" id="add_bed_id">
                                <div class="col-md-12 plr-0">
                                    <button type="submit" class="btn btn-shadow-special start-bed-regi pull-right"> Start </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="background-color: white;">
            </div>
        </div>
    </div>
</div>

<div class="modal fade nurse-monitor-model" id="nurse-monitor-model" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header monitor-header">
                <button type="button" class="close btn close-icon" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title">
                    <h3>Monitor</h3>
                </h5>
            </div>
            <div class="modal-body" id="nurse-monitor-model-body">
            </div>
            <div class="modal-footer bg-white">
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
$('.bed-transfer').on('touchmove', function(e, pos)
{
    getdropComponent(e);
});
/* restricte the droping object  */
$(document).ready(function() {
    $.removeCookie("motherMrn", {
        path: '/'
    });
    $.removeCookie("babyMrn", {
        path: '/'
    });
    $.removeCookie("babyIpNumber", {
        path: '/'
    });
    $.removeCookie("add_ward_id", {
        path: '/'
    });
    $.removeCookie("add_room_id", {
        path: '/'
    });
    $.removeCookie("add_bed_id", {
        path: '/'
    });
    $.removeCookie("babyNurseUpdate", {
        path: '/'
    });
    $.removeCookie("babyCurrentBed", {
        path: '/'
    });
    $.removeCookie("babyCurrentRoom", {
        path: '/'
    });
    $.removeCookie("babyCurrentWard", {
        path: '/'
    });
});

function findParentNodeClass(el, className) {
    className = className.toLowerCase();
    while (el && el.parentElement) {
        el = el.parentElement;
        if (el.classList.contains(className)) {
            return el;
        }
    }
    return null;
}

function bedLogInterChange(babyIdone, admissionIdone, wardIdone, roomIdone, bedIdone, oldBedIdone, babyIdtwo, admissionIdtwo, wardIdtwo, roomIdtwo, bedIdtwo, oldBedIdtwo) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: "GET",
        url: "{{ action('Ward\BabyWardController@getbabyinterchange') }}",
        data: {
            babyIdone: babyIdone,
            admissionIdone: admissionIdone,
            wardIdone: wardIdone,
            roomIdone: roomIdone,
            bedIdone: bedIdone,
            oldBedIdone: oldBedIdone,
            babyIdtwo: babyIdtwo,
            admissionIdtwo: admissionIdtwo,
            wardIdtwo: wardIdtwo,
            roomIdtwo: roomIdtwo,
            bedIdtwo: bedIdtwo,
            oldBedIdtwo: oldBedIdtwo
        },
        success: function(response) {
            Showalert(response.type, response.message);
        },
        error: function(response) {
            Showalert(response.type, response.message);
        }
    });
}
//restirct event listner for basic components 
function restrictComponentListner(componentId) {
    var basicComponent = document.getElementById(componentId);
    basicComponent.addEventListener('dragstart', restricteBabyDrop, false);
    basicComponent.addEventListener('drop', restricteBabyDrop, false);
}
$('.bed-register').click(function() {
    $('.bed-register').removeClass('btn-success').addClass('btn-primary');
    $(this).addClass('btn-success');
});
$("input[name='baby_mrn']").on("keyup", function() {
    $(this).val(this.value.replace(/[^a-zA-Z0-9]/g, ''));
});
$("input[name='baby_ip_number']").on("keyup", function() {
    $(this).val(this.value.replace(/[^a-zA-Z0-9/]/g, ''));
});
$('.start-bed-regi').click(function(e) {
    e.preventDefault();
    /*CLEAR COOKIES*/
    $.removeCookie("motherMrn");
    $.removeCookie("babyMrn");
    $.removeCookie("babyIpNumber");
    $.removeCookie("add_ward_id");
    $.removeCookie("add_room_id");
    $.removeCookie("add_bed_id");
    if ($('#basicreg input[name="baby_mrn"]').val() == '') {
        $('#basicreg input[name="baby_mrn"]').parent().find('span').addClass('error-message').text('Please enter Baby\'s {{ Lang::get("home.mrn") }}');
        $('#basicreg input[name="baby_mrn"]').focus();
        return false;
    }
    else {
        $('#basicreg input[name="baby_mrn"]').parent().find('span').text("");
        if ($('#basicreg input[name="baby_mrn"]').val().length != 6) {
            $('#basicreg input[name="baby_mrn"]').parent().find('span').addClass('error-message').text('Baby\'s {{ Lang::get("home.mrn") }} must be 6 characters');
            $('#basicreg input[name="baby_mrn"]').focus();
            return false;
        }
    }
    var baby_mrn = $('#basicreg input[name="baby_mrn"]').val();
    var result_exist = [];
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: "GET",
        url: "{{ url('patient-status') }}",
        data: {
            baby_mrn: baby_mrn
        },
        success: function(response) {
            var baby_id = 0;
            if (response.result == null) {
                var ip_number = $('#basicreg input[name="baby_ip_number"]').val().replace('IP/', '');
                if (ip_number == '') {
                    $('#basicreg input[name="baby_ip_number"]').parent().find('span').addClass('error-message').text('Please enter Baby\'s {{ Lang::get("home.ip") }}');
                    $('#basicreg input[name="baby_ip_number"]').focus();
                    return false;
                }
                else {
                    $('#basicreg input[name="baby_ip_number"]').parent().find('span').text("");
                    if (ip_number.length < 7) {
                        $('#basicreg input[name="baby_ip_number"]').parent().find('span').addClass('error-message').text('Baby\'s {{ Lang::get("home.ip") }} must be 7 characters');
                        $('#basicreg input[name="baby_ip_number"]').focus();
                        return false;
                    }
                }
                $.cookie("motherMrn", $('#basicreg input[name="mother_mrn"]').val(), {
                    path: '/'
                });
                $.cookie("babyMrn", baby_mrn, {
                    path: '/'
                });
                $.cookie("babyIpNumber", $('#basicreg input[name="baby_ip_number"]').val(), {
                    path: '/'
                });
                $.cookie("add_ward_id", $('#add_ward_id').val(), {
                    path: '/'
                });
                $.cookie("add_room_id", $('#add_room_id').val(), {
                    path: '/'
                });
                $.cookie("add_bed_id", $('#add_bed_id').val(), {
                    path: '/'
                });
                window.location = "{{ action('Registration\NurseMotherController@create')}}";
            } else {
                if (typeof response.result.baby_id !== 'undefined' && response.result.baby_id != '' && response.result.baby_id != null) {
                    baby_id = response.result.baby_id;
                    mother_mrn = response.result.MMrNo;
                    mother_id = response.result.MotherId;
                    if (response.result.status != 'discharged') {
                        $('#basicreg input[name="baby_mrn"]').parent().find('span').addClass('error-message').text('Baby\'s already exist in NICU ward...');
                        $('#basicreg input[name="baby_mrn"]').focus();
                    }
                    else
                    {
                        var ip_number = $('#basicreg input[name="baby_ip_number"]').val().replace('IP/', '');
                        if (ip_number == '') {
                            $('#basicreg input[name="baby_ip_number"]').parent().find('span').addClass('error-message').text('Please enter Baby\'s {{ Lang::get("home.ip") }}');
                            $('#basicreg input[name="baby_ip_number"]').focus();
                            return false;
                        }
                        else {
                            $('#basicreg input[name="baby_ip_number"]').parent().find('span').text("");
                            if (ip_number.length < 7) {
                                $('#basicreg input[name="baby_ip_number"]').parent().find('span').addClass('error-message').text('Baby\'s {{ Lang::get("home.ip") }} must be 7 characters');
                                $('#basicreg input[name="baby_ip_number"]').focus();
                                return false;
                            }
                        }
                        var ip_number = $('#basicreg input[name="baby_ip_number"]').val();
                        $.cookie("add_ward_id", $('#add_ward_id').val(), {
                            path: '/'
                        });
                        $.cookie("add_room_id", $('#add_room_id').val(), {
                            path: '/'
                        });
                        $.cookie("add_bed_id", $('#add_bed_id').val(), {
                            path: '/'
                        });
                        $.ajax({
                            type: "GET",
                            url: "{{ url('ward-basic-reg') }}",
                            data: {
                                baby_id: baby_id,
                                baby_mrn: baby_mrn,
                                mother_mrn: mother_mrn,
                                mother_id: mother_id,
                                baby_ip_number: ip_number
                            },
                            success: function(response) {
                                window.location = response;
                            }
                        });
                    }
                }
            }
        }
    });
});
$(document).on('click', '.add-patient', function() {
    $('#nurse-bed-model').modal({
        backdrop: 'static',
        show: true
    });
    var wardId = $(this).data('add-ward-id');
    var wardName = $(this).data('add-ward-name');
    var wardName = $(this).data('add-ward-name');
    var roomId = $(this).data('add-room-id');
    var roomName = $(this).data('add-room-name');
    var bedId = $(this).data('add-bed-id');
    var bedName = $(this).data('add-bed-name');
    $('.bed-register').attr('data-add-ward-id', wardId);
    $('.bed-register').attr('data-add-room-id', roomId);
    $('.bed-register').attr('data-add-bed-id', bedId);
    $('#add_ward_id').val(wardId);
    $('#add_room_id').val(roomId);
    $('#add_bed_id').val(bedId);
    $('#quickreg input[name="ward_name"]').val(wardId);
    $('#quickreg input[name="room_no"]').val(roomId);
    $('#quickreg input[name="bed_no"]').val(bedId);
    $('#quickreg input[name="hbed_name"]').val(bedName);
    $('#alreadyreg input[name="ward_name"]').val(wardId);
    $('#alreadyreg input[name="room_no"]').val(roomId);
    $('#alreadyreg input[name="bed_no"]').val(bedId);
    $('#alreadyreg input[name="hbed_name"]').val(bedName);
    var hmd_ward_id = $(this).attr('data-hms-ward-id');
    var hmd_room_id = $(this).attr('data-hms-room-id');
    var hmd_bed_id = $(this).attr('data-hms-bed-id');
    $('#quickreg input[name="hward_name"]').attr('data-value', hmd_ward_id);
    $('#quickreg input[name="hroom_name"]').attr('data-value', hmd_room_id);
    $('#quickreg input[name="hbed_name"]').attr('data-value', hmd_bed_id);
    $('#alreadyreg input[name="hward_name"]').attr('data-value', hmd_ward_id);
    $('#alreadyreg input[name="hroom_name"]').attr('data-value', hmd_room_id);
    $('#alreadyreg input[name="hbed_name"]').attr('data-value', hmd_bed_id);
    $('.ward-name-span').text('Ward : ' + wardName);
    $('.room-name-span').text('Room : ' + roomName);
    $('.bed-name-span').text('Bed : ' + bedName);
});
$('#admitte-baby-bed').click(function() {
    var babyid = $('select[name="admission_baby_id"]').val();
    var wardid = $('select[name="admission_baby_id"]').data('ward-transfer-id');
    var roomid = $('select[name="admission_baby_id"]').data('room-transfer-id');
    var bedid = $('select[name="admission_baby_id"]').data('bed-transfer-id');
    var deivceList = $('#admission_device_id').val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: "GET",
        url: "{{ action('Ward\BabyWardController@getaddbabytobed') }}",
        data: {
            babyid: babyid,
            wardid: wardid,
            roomid: roomid,
            bedid: bedid,
            deivceList: deivceList
        },
        success: function(response) {
            Showalert(response.type, response.message);
            $("#baby-bed-modal").modal("hide");
            location.reload();
        },
        error: function(response) {
            Showalert(response.type, response.message);
            $("#baby-bed-modal").modal("hide");
        }
    });
});

function getRemoveSyringePump(wardId, roomId, bedId, babyId, admissionId, slug) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: "PATCH",
        url: "{{ action('Syringepump\SyrangePumpController@update', 0) }}",
        data: {
            wardId: wardId,
            roomId: roomId,
            bedId: bedId,
            babyId: babyId,
            admissionId: admissionId,
            slug: slug
        },
        success: function(response) {
            Showalert(response.type, response.message);
            if (response.type == 'success') {
                location.reload();
            }
        },
        error: function(response) {
            Showalert(response.type, response.message);
            location.reload();
        }
    });
}

function getRemoveInfusionPump(wardId, roomId, bedId, babyId, admissionId) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: "PATCH",
        url: "{{ action('infusion\InfusionController@update', 0) }}",
        data: {
            wardId: wardId,
            roomId: roomId,
            bedId: bedId,
            babyId: babyId,
            admissionId: admissionId
        },
        success: function(response) {
            //  Showalert(response.type,response.message);
            location.reload();
        },
        error: function(response) {
            // Showalert(response.type,response.message);
            location.reload();
        }
    });
}

function dischargeUrl(babyId, admissionId, ward_id) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: "GET",
        url: "{{ url('discharge-baby') }}",
        data: {
            babyId: babyId,
            admissionId: admissionId,
            ward_id: ward_id
        },
        success: function(response) {
            if (response.type == 'success') {
                window.location = response.url + '?flow=from-dashboard';
            }
        },
        error: function(response) {
            response = JSON.parse(response.responseText);
            Showalert(response.type, response.message);
        }
    });
}
$('.list-chart-details').click(function() {
    var babyId = $(this).data('baby-encrypt');
    var url = "{{ url('nurse-sheets-manual-graph') }}";
    window.location = url + '/' + babyId;
});
$.removeCookie("nicuformedit");
$('.edit-nicu-details').click(function(e) {
    e.preventDefault();
    $.cookie("nicuformedit", 'basicform', {
        expires: 1,
        path: '/'
    });
    window.location = $(this).attr('href');
});
$('.list-details').click(function() {
    var babyId = $(this).data('baby-id');
    var admissionId = $(this).data('admission-id');
    if (admissionId == 0) {
        Showalert('error', 'Please complete NICU admission for this baby');
    }
    $.ajax({
        type: "GET",
        url: "{{ url('nurse-sheets-manual-print-latest') }}",
        data: {
            admissionId: admissionId
        },
        success: function(response) {
            if (response.type == 'success') {
                window.location = response.url
            }
        },
        error: function(response) {
            response = JSON.parse(response.responseText);
            Showalert(response.type, response.message);
        }
    });
});
var height = $(window).height() - $('.crumbs.bread-crumbs-shadow').height() - $('.widget-header').height() - 80;
if ($(window).height() > 576 && height < $('.widget-content .ward-manager').height()) {
    $('.widget-content .ward-manager .widget').css({
        'height': height,
        'overflow-y': 'auto',
        'overflow-x': 'auto'
    });
}
$(document).on('click', '.room_filter_option', function() {
    var room_id = $(this).val();
    var ward_id = $(this).data('ward_id');
    if (room_id != 'All') {
        $('.room-parent-' + ward_id).fadeOut();
        $('.room_filter_id_' + room_id).fadeIn();
        $('hr').hide();
    } else {
        $('.room-parent').fadeIn();
        $('hr').show();
    }
});
$(document).on('click', '.card-pf', function() {
    $('.card-pf-view').removeClass('active');
    $(this).addClass('active');
});
$(document).on('click', '.discharge-patient', function() {
    var babyId = $(this).data('add-baby-id');
    var admissionId = $(this).data('add-admission-id');
    var ward_id = $(this).data('add-ward-id');
    var roomId = $(this).data('add-room-id');
    var bedId = $(this).data('add-bed-id');
    var admissionId = $(this).data('add-admission-id');
    var slug = 'REMOVE_BED_PUMP';
    bootbox.confirm("Are you sure you want to discharge patient?", function(confirmed) {
        if (confirmed) {
            var slug = 'REMOVE_BED_PUMP';
            dischargeUrl(babyId, admissionId, ward_id);
            // getRemoveSyringePump(ward_id, roomId, bedId, babyId, admissionId, slug);
        }
    });
});
var s = $('.search-box'),
    f = $('#search_form'),
    a = $('.after'),
    m = $('h4');
s.focus(function() {
    if (f.hasClass('search-open')) return;
    f.addClass('search-in');
    setTimeout(function() {
        f.addClass('search-open');
        f.removeClass('search-in');
    }, 1300);
});
$('#search_form::after').click(function() {
    alert('dfdfhggf');
    if (f.hasClass('search-open')) return;
    f.addClass('search-in');
    setTimeout(function() {
        f.addClass('search-open');
        f.removeClass('search-in');
    }, 1300);
});
a.on('click', function(e) {
    e.preventDefault();
    if (!f.hasClass('search-open')) return;
    s.val('');
    f.val('');
    f.addClass('close');
    f.removeClass('search-open');
    $('.nav-tabs').show();
    $('#search_results_mrn').removeClass('active');
    $('.ward-names').hide();
    $('.tab-content .tab-pane:nth-child(2)').addClass('active');
    $('.room_number_header').show();
    setTimeout(function() {
        f.removeClass('close');
    }, 1300);
})
$('.button-search-input').click(function()
{
    if (!$('.input-search').hasClass('open-search')) {
        $('.input-search').addClass('open-search');
        $(this).addClass('close-search');
        $(this).html('<i class="fa fa-times"></i>');
        $('.search-box').css('position', 'absolute').css('right', '0px').css('z-index', '3');
    }
});
$(document).on('click', '.close-search', function()
{
    $('.input-search').removeClass('open-search');
    $('.input-search').val('');
    $(this).html('<i class="fa fa-search"></i>');
    $('.nav-tabs').show();
    $('#search_results_mrn').removeClass('active');
    $('.ward-names').hide();
    $('.tab-content .tab-pane:nth-child(2)').addClass('active');
    $('.room_number_header').show();
    $('.search-box').removeAttr('style');
});
$('#search_input_text_field').keyup(function() {
    var filter = $(this).val();
    $('.room_number_header').show();
    if (filter && filter.length > 0) {
        $('.room_number_header').hide();
        // $('.bed-manager').find('.card-pf-title:not(:contains("'+filter+'"))').parentsUntil('.bed-manager').parent().addClass('d-none');
        var result_babies = '';
        $('.bed-manager').find('.card-pf-title:contains("' + filter + '")').each(function() {
            // result_babies += '';
            if ($(this).parents('.tab-pane').attr('id') != 'search_results_mrn') {
                var layout_id = $(this).parents('.bed-manager').attr('id');
                var baby_gender = '';
                if ($(this).parents('.bed-manager').hasClass('male_baby')) {
                    baby_gender = 'male_baby';
                } else if ($(this).parents('.bed-manager').hasClass('female_baby')) {
                    baby_gender = 'female_baby';
                }
                result_babies += '<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 bed-manager ' + baby_gender + ' bed-managerr px-0" id="' + layout_id + '">';
                result_babies += $(this).parents('.bed-manager').eq(0).html();
                result_babies += '</div>';
            }
        });
        if (result_babies.length == 0) {
            result_babies = '<h3 class="text-center" style="margin-top:100px">No results found for this {{ Lang::get("home.mrn") }}</h3>';
        }
        $('#search_results_mrn').html(result_babies);
        $('.ward-names').show();
        $('.nav-tabs').hide();
        $('.tab-pane').removeClass('active');
        $('#search_results_mrn').addClass('active');
        $('.bs-tooltip').tooltip();
    }
});
$('.ward-names').hide();
$(document).on('click', '#transfer-option', function() {
    var wardName = $('input[name="ward_name"]').val();
    var roomName = $('input[name="room_name"]').val();
    var bedName = $('input[name="bed_name"]').val();
    $('#current-ward-name-span').text('Ward : ' + wardName);
    $('#current-room-name-span').text('Room : ' + roomName);
    $('#current-bed-name-span').text('Bed : ' + bedName);
    var babyId = $('input[name="baby_id"]').val();
    var admissionId = $('input[name="admission_id"]').val();
    $('input[name="babyId"]').val(babyId);
    $('input[name="admissionId"]').val(admissionId);
    var wardId = $('input[name="ward_id"]').val();
    var roomId = $('.ward[data-admission-id="' + admissionId + '"]').attr('data-add-room-id');
    // var bedId = $('.ward[data-admission-id="'+admissionId+'"]').attr('data-add-bed-id');
    var bedId = $('input[name="bed_id"]').val();
    var bedMrn = $('input[name="bed_mrn"]').val();
    var bedIp = $('input[name="bed_ip"]').val();
    $('input[name="wardId"]').val(wardId);
    $('input[name="oldBedId"]').val(bedId);
    $('input[name="bed_mrno"]').val(bedMrn);
    $('input[name="bed_ipnumber"]').val(bedIp);
});
$('#bed-transfer #bed_no').on('change', function() {
    var bed_id = $(this).val();
    var bed_info = $(this).find('option[value="' + bed_id + '"]');
    var bed_name = bed_info.html();
    $('input[name="tbed_name"]').val(bed_name);
    var admissionId = $('#bed-transfer input[name="admissionId"]').val();
    var room_id = bed_info.attr('data-room-id')
    var room_id = bed_info.attr('data-room-id')
    $('input[name="roomId"]').val(room_id);
    $('input[name="bedId"]').val(bed_id);
    var hms_ward_id = bed_info.attr('data-hms-ward-id');
    var hms_room_id = bed_info.attr('data-hms-room-id');
    var hms_bed_id = bed_info.attr('data-hms-bed-id');
    $('input[name="hms_ward_id"]').val(hms_ward_id);
    $('input[name="hms_room_id"]').val(hms_room_id);
    $('input[name="hms_bed_id"]').val(hms_bed_id);
});
$(document).on('click', 'button[value="NICU_DISCHARGE"], button[value="NICU_TRANSFER_DISCHARGE"]', function() {
    var baby_id = $('input[name="baby_id"]').val();
    $('#discharge-baby-nicu').val(baby_id).trigger('change');
});
$("#transfer-patient-model").on('hidden.bs.modal', function() {
    $('#bed-transfer').trigger('reset');
    $('label').remove('.has-error');
});
$('#quickreg input[name="dob"]').datepicker({
    dateFormat: 'dd-mm-yy'
});
$('#already_admitted').slideUp();
$('select[name="admission_type"]').on('change', function() {
    var admission_type = $(this).val();
    if (admission_type == 2) {
        $('#already_admitted').slideDown();
    } else {
        $('#already_admitted').slideUp();
    }
});
$('#alreadyreg #visit-regi').on('click', function(e) {
    e.preventDefault();
    if ($('#alreadyreg input[name ="baby_mrn"]').val() == '') {
        $('#alreadyreg input[name ="baby_mrn"]').parent().find('span').addClass('error-message').text('Please enter Baby\'s {{ Lang::get("home.mrn") }}');
        $('#alreadyreg input[name ="baby_mrn"]').focus();
        return false;
    }
    else {
        $('#alreadyreg input[name ="baby_mrn"]').parent().find('span').text("");
        if ($('#alreadyreg input[name ="baby_mrn"]').val().length != 6) {
            $('#alreadyreg input[name ="baby_mrn"]').parent().find('span').addClass('error-message').text('Baby\'s {{ Lang::get("home.mrn") }} must be 6 characters');
            $('#alreadyreg input[name ="baby_mrn"]').focus();
            return false;
        }
    }
    var current_element = $(this);
    current_element.html('<i class="fas fa-spinner fa-pulse"></i> Loading...').prop('disabled', true);
    var baby_mrn = $('#alreadyreg input[name="baby_mrn"]').val();
    if (baby_mrn != '') {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            url: "{{ action('Ward\BabyWardController@getPatientStatus') }}",
            data: {
                baby_mrn: baby_mrn,
            },
            success: function(response) {
                if (response.result == null || response.result.status == 'discharged') {
                    hmsiprequest(current_element);
                } else {
                    Showalert('error', 'Baby already admitted !');
                    current_element.html(' Start ').prop('disabled', false);
                }
            }
        });
    }
});

function hmsiprequest(current_element) {
    var hward_name = $('#alreadyreg input[name="hward_name"]').attr('data-value');
    var hroom_name = $('#alreadyreg input[name="hroom_name"]').attr('data-value');
    var hbed_name = $('#alreadyreg input[name="hbed_name"]').attr('data-value');
    var baby_mrn = $('#alreadyreg input[name="baby_mrn"]').val();
    var ward_name = $('#alreadyreg input[name="ward_name"]').val();
    var room_no = $('#alreadyreg input[name="room_no"]').val();
    var bed_no = $('#alreadyreg input[name="bed_no"]').val();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: "{{ action('Fhir\HmsInterfacingController@registerPatientInHMS') }}",
        data: {
            hward_name: hward_name,
            hroom_name: hroom_name,
            hbed_name: hbed_name,
            ward_name: ward_name,
            room_no: room_no,
            bed_no: bed_no,
            baby_mrn: baby_mrn,
            visit: 1,
        },
        success: function(response) {
            if (typeof response.type !== 'undefined' && typeof response.message !== 'undefined') {
                var type = response.type;
                var message = response.message;
                Showalert(type.toLowerCase(), message);
                current_element.html(' Start ').prop('disabled', false);
            }
        },
        complete: function(response) {
            collectPatientDetails(response.admission_id);
            $('#nurse-bed-model').modal('hide');
        }
    });
}
$('.ward-step2').click(function() {
    $('#nurse-bed-model .tab-pane').removeClass('active');
    if ($(this).val() == 'QUICK') {
        $('#nurse-bed-model #tab3').addClass('active');
    }
    if ($(this).val() == 'BASIC') {
        $('#nurse-bed-model #tab6').addClass('active');
    }
});
$('.ward-step3').click(function() {
    $('#nurse-bed-model .tab-pane').removeClass('active');
    if ($(this).val() == 'NEW') {
        $('#nurse-bed-model #tab4').addClass('active');
    }
    if ($(this).val() == 'ALREADY') {
        $('#nurse-bed-model #tab5').addClass('active');
    }
});
$('#nurse-bed-model').on('hide.bs.modal', function(e) {
    $('#nurse-bed-model .tab-pane').removeClass('active');
    $('#nurse-bed-model #tab2').addClass('active');
    $('#nurse-bed-model form').trigger("reset");
    $('#nurse-bed-model .error-message').html('');
});
</script>
@endsection
