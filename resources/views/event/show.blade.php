@extends('print')
@section('content')
<style type="text/css">
    .print-tool-bar{
        z-index: 999999;
    }
    .event-dashboard {
        background-color: #ffffff;
        width: 40%;
        min-width: 500px;
        /*position: absolute;
        transform: translate(-50%,-50%);
        top: 60%;
        left: 50%;*/
        padding: 20px 0;
        padding-bottom: 50px;
        border-radius: 10px;
        text-align: center;
        margin-left: 20%;
    }

    .event-dashboard .timerDisplay {
        position: relative;
        width: 92%;
        background: #ffffff;
        left: 4%;
        padding: 40px 0;
        /*font-family: 'Roboto mono',monospace;*/
        color: #0381bb;
        font-size: 40px;
        display: flex;
        align-items: center;
        justify-content: space-around;
        border-radius: 5px;
        box-shadow: 0 0 20px rgba(0, 139, 253, 0.25);
    }

    .event-dashboard .buttons {
        width: 90%;
        margin: 60px auto 0 auto;
        display: flex;
        justify-content: space-around;
    }

    .event-dashboard .buttons button {
        width: 120px;
        height: 45px;
        background-color: #20b380;
        color: #ffffff;
        border: none;
        font-family: 'Poppins', sans-serif;
        font-size: 18px;
        border-radius: 5px;
        cursor: pointer;
        outline: none;
    }

    .event-dashboard #resetTimer {
        background-color: #d23332;
    }

    .event-dashboard .buttons button:nth-last-child(1) {
        background-color: #d23332;
    }

    #event-modal .modal-body {
        min-height: 300px;
    }

    .event-container {
        position: relative;
        border-radius: 10px;
    }

    .event-container .icon {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #b9b6b6;
        transition: 0.7s;
        z-index: 1;
        box-shadow: 2px 2px 6px #000000a3;
    }

    /*.event-box.female {
        background: #ffb3b3;
    }

    .event-box.male {
        background: #76a1e9;
    }*/

    .event-container .icon .fa {
        font-size: 25px;
        transition: 0.7s;
        color: #fff;
    }

    .event-container .face {
        /*width: 300px;*/
        height: 130px;
        transition: 0.5s;
    }

    .event-container .face.face1 {
        position: relative;
        background: #333;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1;
        /*transform: translateY(100px);*/
        margin-bottom: 25px;
    }


    /*.event-container:hover .face.face1{
        background: #ff0057;
        transform: translateY(0px);
        }*/

    .event-container .face.face1 .content {
        opacity: 1;
        transition: 0.5s;
    }

    .event-container:hover .face.face1 .content {
        opacity: 1;
    }

    .event-container .face.face1 .content i {
        max-width: 100px;
    }

    .event-container .face.face2 {
        position: relative;
        background: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
        box-sizing: border-box;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.8);
        /*transform: translateY(-100px);*/
    }

    .event-container:hover .face.face2 {
        /*transform: translateY(0);*/
    }

    .event-container .face.face2 .content p {
        margin: 0;
        padding: 0;
        text-align: center;
        color: #414141;
    }

    .event-container .face.face2 .content h3 {
        margin: 0 0 10px 0;
        padding: 0;
        color: #fff;
        font-size: 24px;
        text-align: center;
        color: #414141;
    }

    .event-container a {
        text-decoration: none;
        color: #414141;
    }

    .time-heading {
        font-weight: 600;
    }

    @media(max-width: 1024px) {
        .container.main {
            margin-left: 0px !important;
            margin-right: 0px !important;
            padding-right: 20px !important;
            padding-left: 20px !important;
        }
        .col-md-3 {
            padding-left: 5px !important;
            padding-right: 5px !important;
        }
        .event-container .face.face1
        {
            margin-bottom: 10px !important;
        }
    }

    @media(max-width: 849px) {
        .event-dashboard {
            margin-left: 20px !important;
            min-width: 550px !important;
        }
    }

    @media(max-width: 732px) {
        body.print .container {
            padding: 0px !important;
            margin: 0px 5px !important;
        }
        .col-xs-3 {
            padding: 2px !important;
        }
        body.print {
            padding: 0px !important;
            margin: 0px !important;
        }
        .event-container {
            width: 600px;
            margin-left: 13px;
        }
        .table {
            padding-left: 10px !important;
            padding-right: 10px !important;
        }
        html,
        body {
            overflow-x: hidden !important;
        }
        .event-dashboard {
            margin-left: 10px !important;
            min-width: 480px !important;
        }
    }

    @media(max-width: 439px) {
        body.print .container {
            padding: 0px !important;
            margin: 0px 5px !important;
        }
        .col-xs-3 {
            padding: 2px !important;
        }
        body.print {
            padding: 0px !important;
            margin: 0px !important;
        }
        .event-container {
            width: 400px;
            margin-left: 13px;
        }
        .table {
            padding-left: 10px !important;
            padding-right: 10px !important;
        }
        html,
        body {
            overflow-x: hidden !important;
        }
        .event-dashboard {
            margin-left: 10px !important;
            min-width: 380px !important;
        }
        .event-container .face.face1
        {
            margin-bottom: 3px !important;
            height: 155px !important;
        }
    }

    @media(max-width: 369px) {
        .event-container {
            width: 350px;
            margin-left: 13px;
        }
        .event-dashboard {
            margin-left: 10px !important;
            min-width: 310px !important;
        }
    }

    .event-start {
        color: #3eec3e;
        padding: 5px;
    }

    .event-stop {
        color: #fff;
    }

    .e0023 .event-stop,
    .e0020 .event-stop,
    .e0021 .event-stop
    {
        color: #555 !important;
    }

    .table tbody td {
        font-weight: 600;
        border-top: 0px !important;
    }

    .timer-span {
        display: inline-block;
        height: 25px;
        padding: 6px;
        color: #00e7ff;
    }

    .flow-control-modal .modal-header .close {
        margin-top: -23px;
        font-size: 19px !important;
        margin-right: 23px;
    }

    .flow-control-modal .modal-header {
        padding: 0px !important;
        padding-top: 7px !important;
        margin-top: 0px !important;
    }

    .flow-control-modal .modal-header h3 {
        padding: 0px !important;
        padding-top: 7px !important;
        margin-top: 0px !important;
        padding-bottom: 4px !important;
    }

    .flow-control-modal .modal-header .close {
        opacity: 1;
        margin-top: -37px;
    }
    .btn-close {
        background-color: #e6e6e6 !important;
        color: black !important;
    }
    .event-box h5
    {
        color: #fff !important;
    }
    .event-box.e0020 h5,
    .event-box.e0021 h5,
    .event-box.e0023 h5,
    .event-box.e0026 h5,
    .event-box.e0029 h5,
    .event-box.e0032 h5
    {
        color: #666 !important;
    }

</style>
<div class="modal fade flow-control-modal" id="event-modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="text-center text-white event-title">Event Name</h3>
                <!-- <button type="button" class="close modal-close" data-dismiss="modal" aria-hidden="true" style="color:white"><i class="fa fa-times"></i></button> -->
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="event-dashboard">
                        <div class="timerDisplay">
                            00 : 00 : 00 : 000
                        </div>
                        <div class="event-update-info" style="display: none;"></div>
                        <div class="nurse-id-container" style="display: none;">
                            <h4 class="mt-20">Select Staff</h4>
                            <select id="nurse_id" style="width: 100%;">
                                @if(isset($nurse_list) && !empty($nurse_list))
                                    <option value="">-- select --</option>
                                    @foreach($nurse_list as $key => $value)
                                        <option value="{{ $value->id }}">{{ $value->name.' - '.$value->register_no }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="buttons">
                            <!-- <button id="pauseTimer">Pause</button> -->
                            <button id="startTimer">Start</button>
                            <button id="resetTimer" style="display: none;">Stop</button>
                            <button id="updateEvent" style="display: none;">Update Event</button>
                            <!-- <button type="button" class="btn btn-default btn-close" data-dismiss="modal" aria-hidden="true">Close</button> -->
                            <input type="hidden" id="current-event-class" value="" />
                            <input type="hidden" id="current-event-name" value="" />
                            <input type="hidden" id="current-event-code" value="" />
                            <input type="hidden" id="event-stopped-timer" value="" />
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="modal-footer" style="background-color: white;">
                <div class="row mx-0">
                    <div class="col-md-12 text-center">
                        
                    </div>
                </div>
                </div> -->
        </div>
    </div>
</div>
<script type="text/javascript">
    let [milliseconds, seconds, minutes, hours] = [0, 0, 0, 0];
    let timerRef = document.querySelector('.timerDisplay');
    let int = null;
    let event_started_time = '';
    let current_event_class_name = '';
    let current_event_name = '';

    function eventAlreadyStarted(started_time, event_name, event_code) {
        event_started_time = started_time;
        current_event_name = event_name;
        var class_name = str_slug(event_code);
        current_event_class_name = class_name;
        var now = new Date();
        timerRef = document.querySelector('.timerDisplay');
        var started_date = new Date(started_time);
        var diff_time = Math.abs(started_date - now);
        $('#current-event-class').val(class_name);
        $('#current-event-name').val(event_name);
        $('#current-event-code').val(event_code);
        $('.event-title').text(event_name);
        $('#startTimer').hide();
        $('#resetTimer').show();
        $('#event-modal').modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        });
        milliseconds = diff_time;
        if (int !== null) {
            clearInterval(int);
        }
        int = setInterval(displayTimer, 10);
    }

    function str_slug(string) {
        return string.toLowerCase().replace(/ /g, '-').replace(/[-]+/g, '-').replace(/[^\w-]+/g, '');
    }

    function displayTimer() {
        var now = new Date();
        if (event_started_time != '') {
            event_started_time = event_started_time.replace(/\s/, 'T');
            var started_date = new Date(event_started_time);
            var temp_milliseconds = now.getMilliseconds() - started_date.getMilliseconds();
            milliseconds = temp_milliseconds > 0 ? temp_milliseconds : 1000 - Math.abs(temp_milliseconds);
            var diff_time = Math.abs(started_date - now);
            hours = Math.floor((diff_time / (1000 * 60 * 60)) % 24);
            minutes = Math.floor((diff_time / (1000 * 60)) % 60);
            seconds =  Math.floor((diff_time / 1000) % 60);
        } else {
            var started_date = new Date();
            milliseconds += 10;
            if (milliseconds == 1000) {
                milliseconds = 0;
                seconds++;
                if (seconds == 60) {
                    seconds = 0;
                    minutes++;
                    if (minutes == 60) {
                        minutes = 0;
                        hours++;
                    }
                }
            } else if (milliseconds > 1000) {
                seconds = Math.floor(milliseconds / 1000); //ignore any left over units smaller than a second
                minutes = Math.floor(seconds / 60);
                seconds = seconds % 60;
                hours = Math.floor(minutes / 60);
                minutes = minutes % 60;
                milliseconds = 0;
            }
        }
        let h = hours < 10 ? "0" + hours : hours;
        let m = minutes < 10 ? "0" + minutes : minutes;
        let s = seconds < 10 ? "0" + seconds : seconds;
        // let ms = milliseconds < 10 ? "00" + milliseconds : milliseconds < 100 ? "0" + milliseconds : milliseconds;
        let ms = milliseconds;
        ms= (ms/10).toFixed(0);
        if(ms.length < 2) {
            ms= "0" + ms;
        }
        else if(ms.length > 2)
        {
            ms = ms.toString().slice(0, 2);
        }
        timerRef.innerHTML = `${h} : ${m} : ${s} : ${ms}`;

        if (current_event_class_name != '') {
            $('.' + current_event_class_name + ' i.fa').hide();
            $('.' + current_event_class_name + ' span.timer-span').show().text(` ${h} : ${m} : ${s} : ${ms}`);
        }
    }
</script>
<div class="row row-spacing">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-borderless">
                <tbody>
                    <tr>
                        <td>Baby Name : {{ @$baby_details->BabyName }}</td>
                        <td>{{ Lang::get('home.mrn') }} NO : {{ @$baby_details->BMrNo }}</td>
                        <td>{{ Lang::get('home.ip') }} : {{ @$baby_details->ip_number }}</td>
                        <td>DOB : {{ isset($baby_details->DOB) && $baby_details->DOB != '' ? date('d-m-Y', strtotime($baby_details->DOB)) : '' }}</td>
                    </tr>
                    <tr>
                        <td>Gestation : {{ SiteHelpers::decode_gestation(@$baby_details->Gestation) }}</td>
                        <td>Sex : {{ @$baby_details->Sex }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row row-spacing">
    <div class="col-md-12">
        <div class="event-container row">
            <input type="hidden" id="baby-mrn" value="{{ @$baby_details->BMrNo }}">
            <input type="hidden" id="baby-bed-id" value="{{ @$bed_id }}">
            @if(isset($event_list) && count($event_list) > 0)
            @foreach($event_list as $evnt_key => $event_value)
            <div class="col-md-3 col-sm-3 col-xs-3">
                <div class="face face1">
                    <div class="content">
                        <div class="icon text-center event-box {{ str_slug($event_value->event_code) }} {{ strtolower($baby_details->Sex) }}" data-event_name="{{ $event_value->event_name }}" data-event_code="{{ $event_value->event_code }}" @if(isset($event_value->bg_color) && !empty($event_value->bg_color)) style="background-color: {{ $event_value->bg_color }};" @endif >
                            <h5 class="text-center"><strong>{{ $event_value->event_name }}</strong></h5>
                            <!-- <i class="fa fa-linkedin-square" aria-hidden="true"></i> -->
                            <?php 
                                if (file_exists( public_path() . '/img/event_icons/icons/'.str_slug($event_value->event_code).'.svg')) {
                                    echo '<img src="'.url('/').'/public/img/event_icons/icons/'.str_slug($event_value->event_code).'.svg" width="65" height="65" />';
                                } else {
                                    echo '<img src="'.url('/').'/public/img/event_icons/icons/e0005.svg" width="65" height="65" />';
                                } 
                             ?>
                            <span class="timer-span"></span>
                            @php
                            $current_event_code = isset($running_events_details[0]) ? $running_events_details[0]->event_code : '';
                            if ($current_event_code != $event_value->event_code) {
                                $last_event_entry = collect($stop_event_details)->where('event_code', $event_value->event_code)->sortByDesc('event_date_time')->first();
                            } else {
                                $last_event_entry = collect($running_events_details)->where('event_code', $event_value->event_code)->sortByDesc('event_date_time')->first();
                            }
                            @endphp
                            @if(isset($last_event_entry->stop) && !empty($last_event_entry->stop))
                            <h6 class="text-center time-heading event-stop">Stop at: {{ date('d/m/Y H:i:s', strtotime($last_event_entry->stop)) }}</h6>
                            @elseif(isset($last_event_entry->start) && !empty($last_event_entry->start))
                            <h6 class="text-center time-heading event-start">Start at: {{ date('d/m/Y H:i:s', strtotime($last_event_entry->start)) }}</h6>
                            <script type="text/javascript">
                                eventAlreadyStarted("{{ $last_event_entry->start }}", "{{ $event_value->event_name }}", "{{ $event_value->event_code }}");
                            </script>
                            @else
                            <h6 class="text-center time-heading"></h6>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript" src="{{ url('/') }}/public/js/dateTimeFormat.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        window.Echo.channel('care-event-update').listen('CareEventMarker', function (data) {
            console.log(data);
            var mrn = $('#baby-mrn').val();
            var responseData = data.event_data;
            if (mrn == responseData.mrn) {
                var displayTime = dateFormat(responseData.event_date_time, "dd/mm/yyyy, HH:MM:ss");
                var current_class_name = str_slug(responseData.event_code);
                if (responseData.event_status == 'START') {
                    eventAlreadyStarted(responseData.event_date_time, responseData.event, responseData.event_code);
                    $('.' + current_class_name + ' .time-heading').text("Start at: " + displayTime).addClass('event-start').removeClass('event-stop');
                    $('.event-update-info').hide().html('');
                }  else if (responseData.event_status == 'STOP') {
                    $('.' + $('#current-event-class').val() + ' .time-heading').text("Stop at: " + displayTime).removeClass('event-start').addClass('event-stop');
                    stopTimer();
                    $('.event-update-info').hide().html('');
                }  else if (responseData.event_status == 'Temperory Stopped') {
                    $('.' + $('#current-event-class').val() + ' .time-heading').text("Stop at: " + displayTime).removeClass('event-start').addClass('event-stop');
                    // stopTimer();
                    $('#resetTimer').hide();
                    clearInterval(int);
                    $('.event-update-info').html('<h4>Event has been stopped, Wating to update staff info...<h4>').show();
                }
            }
        });
        $('.event-box').click(function () {
            if (current_event_name != '') {
                $('#event-modal').modal({
                    backdrop: 'static',
                    keyboard: false,
                    show: true
                });
                return false;
            } else {
                var event_name = $(this).data('event_name');
                var event_code = $(this).data('event_code');
                eventUpdate(event_name, event_code);
            }
        });

        $('#nurse_id').select2();
        if (typeof $('#nurse_id').val() != 'undefined') {
            var field_val = $('#nurse_id').val().length;
            if (field_val == 0) {
                $('#nurse_id').select2("val", "");
            }
        }
    });
    document.getElementById('startTimer').addEventListener('click', () => {
        if (int !== null) {
            clearInterval(int);
        }
        int = setInterval(displayTimer, 10);
        $('#startTimer').hide();
        $('#resetTimer').show();
        var time = getCurrentTime();
        $('.event-update-info').hide().html('');
        $('.' + str_slug($('#current-event-code').val()) + ' .time-heading').text("Start at: " + time).addClass('event-start').removeClass('event-stop');
        var display_time = getCurrentTime().split('.')[0];
        storeEventMarker('START', display_time);
    });

    document.getElementById('resetTimer').addEventListener('click', () => {
        var time = getCurrentTime();
        var display_time = time.split('.')[0];
        $('.' + str_slug($('#current-event-code').val()) + ' .time-heading').text("Stop at: " + display_time).removeClass('event-start').addClass('event-stop');
        // storeEventMarker('STOP', time);
        // stopTimer();
        clearInterval(int);
        $('#event-stopped-timer').val(display_time);
        $('#resetTimer').hide();
        $('.event-update-info').hide().html('');
        $('#updateEvent').show();
        $('.nurse-id-container').show();
        $('.timerDisplay').hide();
        sendStopTimer();

    });

    document.getElementById('updateEvent').addEventListener('click', () => {
        var stoped_time = $('#event-stopped-timer').val();
        var event_stopped = storeEventMarker('STOP', stoped_time);
        if(event_stopped){
            stopTimer();
            $('#event-stopped-timer').val('');
            $('#updateEvent').hide()
            $('.nurse-id-container').hide();
            $('.timerDisplay').show();
            $('#nurse_id').val('').trigger('change');
            $('#nurse_id').select2("val", "");
        }
    });

    function eventUpdate(event_name, event_code) {
        $('#current-event-class').val('');
        $('#current-event-name').val('');
        $('.event-title').text(event_name);
        $('#event-modal').modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        });
        var className = str_slug(event_name);
        $('#current-event-class').val(className);
        $('#current-event-name').val(event_name);
        $('#current-event-code').val(event_code);
    }

    function storeEventMarker(type, time) {
        var event_name  = $('#current-event-name').val();
        var event_code  = $('#current-event-code').val();
        var mrn         = $('#baby-mrn').val();
        var bed_id      = $('#baby-bed-id').val();
        var nurse_id = '';
        if (type == 'STOP') {
            nurse_id = $('#nurse_id').val();
            if (nurse_id == '' || nurse_id == null) {
                alert("Please select Employee ID to stop this event");
                return false;
            }
        }
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: '{{ url("store-event-data") }}',
            data: {
                event: event_name,
                event_code: event_code,
                mrn: mrn,
                status: type,
                event_time: time,
                bed_id: bed_id,
                nurse_id: nurse_id
            },
            beforeSend: function () {

            },
            success: function (response) {

            },
            complete: function (response) {

            },
            error: function (response) {

            }
        });
        return true;
    }

    function getCurrentTime() {
        var today = new Date();
        var day = today.getDate();
        var month = today.getMonth() + 1;
        var year = today.getFullYear();
        var hour = today.getHours();
        var minute = today.getMinutes();
        var second = today.getSeconds();
        var milliseconds = today.getMilliseconds();
        var milliseconds= (today.getMilliseconds()/10).toFixed(0);
        if(milliseconds.length < 2) milliseconds= "0" + milliseconds;
        if (day < 10) {
            day = '0' + day;
        }
        if (month < 10) {
            month = '0' + month;
        }
        if (hour < 10) {
            hour = '0' + hour;
        }
        if (minute < 10) {
            minute = '0' + minute;
        }
        if (second < 10) {
            second = '0' + second;
        }
        return day + '/' + month + '/' + year + ' ' + hour + ':' + minute + ':' + second + '.' + milliseconds;
    }

    var request_in_process = false;

    function updateMarker() {
        if (!request_in_process) {
            request_in_process = true;
            var mrn     = $('#baby-mrn').val();
            var bed_id  = $('#baby-bed-id').val();
            var current_running_event  = $('#current-event-code').val();
            var current_event_status = '';
            if (current_running_event != '' && current_running_event != null && current_running_event !== undefined) {
                if ($('.'+str_slug(current_running_event)).find('.time-heading').hasClass('event-stop')) {
                    current_event_status  = 'STOP';
                }
                else if ($('.'+str_slug(current_running_event)).find('.time-heading').hasClass('event-start')) {
                    current_event_status  = 'START';
                }
            }
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'GET',
                url: '{{ url("get-event-result") }}',
                data:{
                    mrn: mrn,
                    bed_id: bed_id,
                    current_event: current_running_event,
                    event_status: current_event_status
                },
                success: function (response) {
                    var result_status = response.result.status;
                    var current_class_name = '';
                    if(result_status == 'new event started' && response.result.event_status == 'START') {
                        var event_name = response.result.event_name;
                        var class_name = str_slug(response.result.event_code);
                        var temp_running = response.result.event_time;
                        var running_part_1 = temp_running.split('-');
                        var running_part_2 = running_part_1[2].split(' ');
                        var running_date = running_part_2[0];
                        var running_month = running_part_1[1];
                        var running_year = running_part_1[0];
                        var running_time = running_part_2[1].split('.')[0];
                        var running_at = running_date + '/' + running_month + '/' + running_year + ' ' + running_time;
                        var old_running_content = $('.' + event_name).find('.time-heading').text();
                        var new_running_content = "Start at: " + running_at;
                        eventAlreadyStarted(temp_running, response.result.event_name, response.result.event_code);
                        $('.' + class_name).find('.time-heading').text(new_running_content).addClass('event-start').removeClass('event-stop');
                        current_class_name = class_name;
                    }
                    else if(result_status == 'event status modified' &&  response.result.event_status == 'STOP') {
                        var event_name = response.result.event_name;
                        var class_name = str_slug(response.result.event_code);
                        var temp_stop = response.result.event_time;
                        if (temp_stop != null) {
                            var stop_part_1 = temp_stop.split('-');
                            var stop_part_2 = stop_part_1[2].split(' ');
                            var stop_date = stop_part_2[0];
                            var stop_month = stop_part_1[1];
                            var stop_year = stop_part_1[0];
                            var stop_time = stop_part_2[1].split('.')[0];
                            var stop_at = stop_date + '/' + stop_month + '/' + stop_year + ' ' + stop_time;
                            var new_stop_content = "Stop at: " + stop_at;
                            if (class_name != current_class_name) {
                                if ($('.' + class_name).find('.time-heading').hasClass('event-start')) {
                                    $('.' + class_name).find('.time-heading').text(new_stop_content).removeClass('event-start').addClass('event-stop');
                                    stopTimer();
                                    current_class_name = '';
                                } else {
                                    $('.' + class_name).find('.time-heading').text(new_stop_content).removeClass('event-start').addClass('event-stop');
                                }
                            }
                        }
                    }
                    else if(result_status == 'event status modified' &&  response.result.event_status == 'START') {
                        var event_name = response.result.event_name;
                        var class_name = str_slug(response.result.event_code);
                        var temp_running = response.result.event_time;
                        var running_part_1 = temp_running.split('-');
                        var running_part_2 = running_part_1[2].split(' ');
                        var running_date = running_part_2[0];
                        var running_month = running_part_1[1];
                        var running_year = running_part_1[0];
                        var running_time = running_part_2[1].split('.')[0];
                        var running_at = running_date + '/' + running_month + '/' + running_year + ' ' + running_time;
                        var old_running_content = $('.' + event_name).find('.time-heading').text();
                        var new_running_content = "Start at: " + running_at;
                        eventAlreadyStarted(temp_running, response.result.event_name, response.result.event_code);
                        $('.' + class_name).find('.time-heading').text(new_running_content).addClass('event-start').removeClass('event-stop');
                        current_class_name = class_name;
                    }
                    else if(result_status == 'another event updated' &&  response.result.event_status == 'START') {
                        var event_name = response.result.event_name;
                        var class_name = str_slug(response.result.event_code);
                        var temp_running = response.result.event_time;
                        var running_part_1 = temp_running.split('-');
                        var running_part_2 = running_part_1[2].split(' ');
                        var running_date = running_part_2[0];
                        var running_month = running_part_1[1];
                        var running_year = running_part_1[0];
                        var running_time = running_part_2[1].split('.')[0];
                        var running_at = running_date + '/' + running_month + '/' + running_year + ' ' + running_time;
                        var old_running_content = $('.' + event_name).find('.time-heading').text();
                        var new_running_content = "Start at: " + running_at;
                        eventAlreadyStarted(temp_running, response.result.event_name, response.result.event_code);
                        $('.' + class_name).find('.time-heading').text(new_running_content).addClass('event-start').removeClass('event-stop');
                        current_class_name = class_name;
                    }
                    // console.log(result_status);
                },
            });
	    request_in_process = false;
        }
        setTimeout(updateMarker, 5000);
    }

    // setTimeout(updateMarker, 5000);

    function stopTimer() {
        if (int !== null) {
            clearInterval(int);
            current_event_class_name = '';
            event_started_time = '';
            current_event_name = '';
        }
        [milliseconds, seconds, minutes, hours] = [0, 0, 0, 0];
        timerRef.innerHTML = '00 : 00 : 00 : 000 ';
        $('#startTimer').show();
        $('#resetTimer').hide();
        $('#event-modal').modal('hide');
        $('.' + $('#current-event-class').val() + ' i.fa').show();
        $('.' + $('#current-event-class').val() + ' span.timer-span').text('').hide();
    }
    function sendStopTimer(){
        var mrn     = $('#baby-mrn').val();
        var event_code  = $('#current-event-code').val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: '{{ url("care-event/send-stop-status") }}',
            data: {
                mrn: mrn,
                event_code: event_code
            },
            beforeSend: function () {

            },
            success: function (response) {

            },
            complete: function (response) {

            },
            error: function (response) {

            }
        });
    }
</script>
@endsection
