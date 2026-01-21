@extends('app')
@section('content')
<?php $permission = session('menu_permission'); ?>
<style>
    .ui-datepicker {
        z-index: 1050 !important;
    }
    .cContHeader {
        z-index: 6;
    }
    .label-control {
        margin-top: 0px;
    }
    .toggle-on, .toggle-on:hover {
        background: #8c8cb4 !important;
    }
    .custom-select2 .form-group {
        margin-bottom: 0px;
    }
    @media (min-width: 767px) and (max-width: 979px) {
        .custom-input {
            clear: both;
        }
    }
</style>

<div class="row-spacing">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="col-xs-11 col-sm-11 col-md-11">
            <h4 class="text-center">{{ $title }}</h4>
        </div>
        <div class="col-xs-1 col-sm-1 col-md-1 plr-0">
            <a href="javascript:void(0);" title="Add Appointment" class="btn btn-success" id="patient-detail">
                <i class="fa fa-plus "></i>
            </a>
        </div>
    </div>
    <div class="myCalendar col-xs-12 col-sm-12 col-md-12 p-0"></div>
</div>
{{ Form::hidden('auth_user', json_encode($auth_user)) }}
@php 
$seen_by = ValuelistHelpers::mas_doctors_list();
$category = ValuelistHelpers::appointmentType();
@endphp
{!! Form::hidden('select_field_data', $baby_list) !!}
{!! Form::hidden('neuro_dr_id', env('DEFAULT_NEURO_SEEN_BY')) !!}
<div class="modal fade flow-control-modal" id="createappointment" role="dialog">
    <div class="modal-dialog modal-lg">
        {{ Form::open(['method' => 'PATCH', 'url' => action('Flow\FlowController@patientDetailUpdate', 0), 'id' => 'create-patient-control', 'class' => 'm-0']) }}
        <div class="modal-content">
            <div class="modal-header bg-color">                
                <h5 class="modal-title"><h3>Add Appointment</h3></h5>
                <button type="button" class="close modal-close" data-dismiss="modal" aria-label="Close" style="margin-right: 0px !important">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>
            <div class="modal-body">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="mt-10 widget box">
                        <div class="widget-header">
                            <h4><i class="fa fa-reorder"></i>Scheduled Details</h4>
                        </div>
                        <div class="widget-content row">
                            <div class="col-md-12 col-sm-12 col-xs-12 custom-select2">
                                {!! Form::hidden('tags', true) !!}
                                @include('select', [
                                'label_name' => 'Patient:',
                                'placeholder' => 'Select',
                                'error_message' => 'This field is required.'
                                ])
                            </div>
                            <div class="col-md-offset-3 col-md-9 mb-15">
                                <span class="custom-error error-message hide">Please select from the list or enter the patient name</span>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <div class="row form-group">
                                    <div class="col-md-3 text-right label-control">
                                        {{ Form::label('category','Category:', ['class'=>'required-label']) }}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {{ Form::select('category',['' => 'N/A']+$category,null,['class' => 'form-control','required']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6" style="margin-bottom: 2px">
                                <div class="row form-group">
                                    <div class="col-md-3 text-right label-control">
                                        {{ Form::label('consultant','Seen By:', ['class'=>'required-label']) }}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {{ Form::select('consultant',['' => 'N/A']+$seen_by,null,['class' => 'full-width','required']) }}
                                        <div class="text-center">
                                            <span class="error-message error-admission">This field is required.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <div class="row form-group">
                                    <div class="col-md-3 text-right label-control">
                                        {{ Form::label('date','Date:') }}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {{ Form::text('date',null,['class' => 'form-control','required', 'readonly']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <div class="row form-group">
                                    <div class="col-md-3 text-right label-control">
                                        {{ Form::label('time','Time:') }}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <div class="display-flex">
                                            <div class="input-width-mini mr-15">
                                                {{ Form::select('time',SiteHelpers::prepare_time()['time'],null,['class' => 'form-control input-width-mini mr-15','required']) }}
                                            </div>
                                            <div class="input-width-mini mr-15">
                                                {{ Form::select('mins',SiteHelpers::prepare_time()['mins'],null,['class' => 'form-control input-width-mini mr-15', 'id'=>'mins','required']) }}
                                            </div>
                                            <div class="input-width-mini">
                                                {{ Form::select('session',SiteHelpers::prepare_time()['session'],null,['class' => 'form-control input-width-mini mr-15', 'id'=>'session','required']) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <div class="row form-group">
                                    <div class="col-md-3 text-right label-control">
                                        {{ Form::label('contact_no','Contact No.:') }}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {{ Form::text('contact_no',null,['class' => 'form-control', 'disabled']) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-10 widget box">
                        <div class="widget-header">
                            <h4>
                                <i class="fa fa-reorder"></i>
                                Do you need <b>Neuro Development</b> on same date?
                                <input id="need_neuro" name="need_neuro" data-on="Yes" data-off="No"  data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-color">
                <button type="submit" class="btn btn-primary btn-shadow-special" id="save-patient-detail" data-dismiss="static" aria-label="Close">Save</button>
                <button type="button" class="btn btn-default btn-shadow-special" data-dismiss="modal" aria-label="Close">Cancel</button>
            </div>
        </div>
        {{ Form::close() }}
    </div>
</div>
<div class="modal fade flow-control-modal" id="editappointment" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            {{ Form::open(['method' => 'PATCH', 'url' => action('Flow\FlowController@patientDetailUpdate', 0), 'id' => 'patient-control', 'class' => 'm-0']) }}
            <div class="modal-header bg-color">                
                <h5 class="modal-title"><h3>Edit Appointment</h3></h5>
                <button type="button" class="close modal-close" data-dismiss="modal" aria-label="Close" style="margin-right: 0px !important">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="mt-10 widget box">
                        <div class="widget-header">
                            <h4><i class="fa fa-reorder"></i>Scheduled Details</h4>
                        </div>
                        <div class="widget-content row">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <div class="row">
                                    <div class="col-md-3 text-right label-control">
                                        {{ Form::hidden('appointment_id')}}
                                        {{ Form::label('patient','Patient:') }}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {{ Form::label('patient_content', '') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <div class="row">
                                    <div class="col-md-3 text-right label-control">
                                        {{ Form::label('category','Category:') }}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {{ Form::label('category_content', '') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <div class="row">
                                    <div class="col-md-3 text-right label-control">
                                        {{ Form::label('consultant','Seen By:') }}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {{ Form::label('consultant_content', '') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <div class="row">
                                    <div class="col-md-3 text-right label-control">
                                        {{ Form::label('date','Date & Time:') }}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {{ Form::label('date_content', '') }}
                                        {{ Form::label('hrs_content', '') }}{{ Form::label('mins_content', '') }}&nbsp{{ Form::label('session_content', '') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <div class="row">
                                    <div class="col-md-3 text-right label-control">
                                        {{ Form::label('contactno','Contact No.:') }}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {{ Form::label('contact_no_content', '') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <div class="row">
                                    <div class="col-md-3 text-right label-control">
                                        {{ Form::label('reason','Reason:') }}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {{ Form::label('reason_content', '') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-10 widget box">
                        <div class="widget-header">
                            <h4>
                                <i class="fa fa-reorder"></i>
                                Do you want to reschedule the appointment ?
                                <input id="edit" name="edit" data-on="Yes" data-off="No"  data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                            </h4>
                        </div>
                        <div class="widget-content row hide" id="reschedule">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="row form-group">
                                    <div class="col-md-12">
                                        {{ Form::label('reason','Reason:') }}
                                    </div>
                                    <div class="col-md-12">
                                        {{ Form::textarea('reason',null,['class' => 'form-control','rows'=>1,'required']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <div class="row form-group">
                                    <div class="col-md-3 text-right label-control">
                                        {{ Form::label('appointmentDate','Date:') }}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {{ Form::text('appointmentDate',null,['class' => 'form-control','required', 'readonly']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <div class="row form-group">
                                    <div class="col-md-3 text-right label-control">
                                        {{ Form::label('appointmentTime','Time:') }}
                                    </div>
                                    <div class="col-md-9 custom-input display-flex">
                                        <div class="input-width-small mr-15">
                                            {{ Form::select('newTime',SiteHelpers::prepare_time()['time'],null,['class' => 'form-control','id'=>'newTime','required']) }}
                                        </div>
                                        <div class="input-width-small mr-15">
                                            {{ Form::select('newMins',SiteHelpers::prepare_time()['mins'],null,['class' => 'form-control', 'id'=>'newMins','required']) }}
                                        </div>
                                        <div class="input-width-small">
                                            {{ Form::select('newSession',SiteHelpers::prepare_time()['session'],null,['class' => 'form-control', 'id'=>'newSession','required']) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-10 widget box">
                        <div class="widget-header">
                            <h4>
                                <i class="fa fa-reorder"></i>
                                Do you want to cancel the appointment ?
                                <input id="cancel" name="cancel" data-on="Yes" data-off="No"  data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-color">
                <button type="submit" class="btn btn-primary btn-shadow-special" id="update-patient-detail" data-dismiss="static" aria-label="Close" disabled>Update</button>
                <button type="button" class="btn btn-default btn-shadow-special" data-dismiss="modal" aria-label="Close">Cancel</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
    // var appoinments = [];
    // var already_exist = [];
        var isOp, patientId, holder, reason;
        var oCal1;
        var load_data = true;
        var current = new Date();
        var current_date = current.getDate();
        current_date = current_date > 9 ? current_date : '0' + current_date;
        var current_month = current.getMonth() + 1;
        current_month = current_month > 9 ? current_month : '0' + current_month;
        var current_year = current.getFullYear();
        var current_hour = current.getHours();
        var current_session = current_hour >= 12 ? 'PM' : 'AM';
        current_hour = current_hour > 12 ? current_hour - 12 : current_hour;
        var current_minutes = current.getMonth() + 1;
        var calendar = $(".myCalendar").CalenStyle({
            initialize: function()
            {
                oCal1 = this;
            },
        // the array of sections to add to the Calendar View
        // "Header", "Calendar", "EventList", "FilterBar" and "ActionBar"
            sectionsList: ["Header", "Calendar", "EventList"],
        // can be any language for which i18n strings are specified in "calenstyle-i18n.js". For example, "en", "de"
            language: "",
        // an array of Very Short Day Names from Sunday to Saturday
            veryShortDayNames: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
        // an array of Short Day Names from Sunday to Saturday
            shortDayNames: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
        // an array of Full Day Names from Sunday to Saturday
            fullDayNames: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
        // an array of Short Month Names from January to December
            shortMonthNames: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        // an array of Full Month Names from January to December
            fullMonthNames: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
        // an array numbers from 0 to 9 which will be used to display numeric values
            numbers: ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"],
        // content displayed on tooltip
            eventTooltipContent: "Default",
        // can be used to apply a custom time format.
        // can be specified as an object with callback functions returning formatted datetime string named as format specifier.
            formatDates: {},
        // tooltip content for time slot in the AppointmentView
            slotTooltipContent: function(oSlotAvailability)
            {
                if (oSlotAvailability.status === "Busy") return "";
                else if (oSlotAvailability.status === "Free")
                {
                    if (oSlotAvailability.count === undefined || oSlotAvailability.count === null) return "<div class=cavTooltipBookNow>Book Now</div>";
                    else return "<div class=cavTooltipSlotCount>" + oSlotAvailability.count + " slots available</div><div class=cavTooltipBookNow>Book Now</div>";
                }
            },
        // an object containing strings displayed on CalenStyle UI which can be customized
            miscStrings:
            {
                today: "Today",
                week: "Week",
                allDay: "All Day",
                ends: "Ends",
                emptyEventTitle: "(No Title)",
                emptyGoogleCalendarEventTitle: "Busy"
            },
        // To customize duration strings use duration as a callback function.
            duration: "Default",
        // Custom duration unit strings can be specified to replace default duration unit strings displayed on CalenStyle UI.
            durationStrings:
            {
                y: ["year ", "years "],
                M: ["month ", "months "],
                w: ["w ", "w "],
                d: ["d ", "d "],
                h: ["h ", "h "],
                m: ["m ", "m "],
                s: ["s ", "s "]
            },
        // an array of views available to be displayed on the Calendar View
        // a view specified in the array will be added as a menu item in the Header section
        // a view specified as visibleView will be displayed first
        // you can switch between Views by selecting menu item.
            viewsToDisplay: [
            {
                viewName: "DetailedMonthView",
                viewDisplayName: "Month"
            },
            {
                viewName: "WeekView",
                viewDisplayName: "Week"
            },
            {
                viewName: "DayView",
                viewDisplayName: "Day"
            }],
        // the Calendar View you want to display
        // "DetailedMonthView", "MonthView", "WeekView", "DayView", "AgendaView", "WeekPlannerView", "QuickAgendaView", "TaskPlannerView", "CustomView", "DayEventListView", "DayEventDetailView", "AppointmentView", "DatePicker"
            visibleView: "DetailedMonthView",
        // the Date for which the Calendar View is rendered
            selectedDate: new Date(),
        // a set of components which can be added in Header Sections
            headerComponents:
            {
                DatePickerIcon: "<span class='cContHeaderButton cContHeaderDatePickerIcon clickableLink cs-icon-Calendar'></span>",
                FullscreenButton: function(bIsFullscreen)
                {
                    var sIconClass = (bIsFullscreen) ? "cs-icon-Contract" : "cs-icon-Expand";
                    return "<span class='cContHeaderButton cContHeaderFullscreen clickableLink " + sIconClass + "'></span>";
                },
                PreviousButton: "<span class='cContHeaderButton cContHeaderNavButton cContHeaderPrevButton clickableLink cs-icon-Prev'></span>",
                NextButton: "<span class='cContHeaderButton cContHeaderNavButton cContHeaderNextButton clickableLink cs-icon-Next'></span>",
                TodayButton: "<span class='cContHeaderButton cContHeaderToday clickableLink'></span>",
                HeaderLabel: "<span class='cContHeaderLabelOuter'><span class='cContHeaderLabel'></span></span>",
                HeaderLabelWithDropdown: "<span class='cContHeaderLabelOuter clickableLink'><span class='cContHeaderLabel'></span><span class='cContHeaderButton cContHeaderDropdownMenuArrow'></span></span>",
                MenuSegmentedTab: "<span class='cContHeaderMenuSegmentedTab'></span>",
                MenuDropdownIcon: "<span class='cContHeaderButton cContHeaderMenuButton clickableLink'>&#9776;</span>"
            },
        // an array of components to include in each Header Section
        // you can customize Header as per visual and functional requirements.
            headerSectionsList:
            {
                left: ['TodayButton', "PreviousButton", "NextButton"],
                center: ["HeaderLabel"],
                right: ["MenuSegmentedTab"]
            },
        // the Menu Items to display are specified in dropdownMenuElements
        dropdownMenuElements: ["ViewsToDisplay"], // ["ViewsToDisplay", "DatePicker"]
        // the CalenStyle object for which DatePicker is created
        parentObject: null,
        // the CalenStyle object of the DatePicker
        datePickerObject: null,
        // he DateTime Format Separator
        formatSeparatorDateTime: " ",
        // the Date Format Separator
        formatSeparatorDate: "-",
        // the Time Format Separator
        formatSeparatorTime: ":",
        // the time format in which the time is displayed inside the Calendar View
        is24Hour: true,
        // the DateTime Format specified in the Events
        inputDateTimeFormat: "dd-MM-yyyy HH:mm:ss",
        //  indicates default event duration, which can be used to create end date of event for which end date is not supplied in the event source
        eventDuration: 30, // In minutes
        // indicates default event duration for all day event, which can be used to create end date of event for which end date is not supplied in the event source
        allDayEventDuration: 1, // In days
        // an interval after which Current Time Indicator position is auto updated to indicate Current Time
        timeIndicatorUpdationInterval: 15,
        // a value of a time slot(one row) in the Detail Views("WeekView", "DayView")
        unitTimeInterval: 5, // [5, 10, 15, 20, 30]
        // sets whether to display time labels (for example, 01:00) for Hour or time labels for Each Time Slot in the Detail Views("WeekView", "DayView")
        timeLabels: "Hour", // ["Hour", "All"]
        // the TZD string of timezone in which input dates from data sources is specified
        inputTZOffset: "+05:30",
        // used when you specify Google Calendar as a source, to send it as a Query Parameter
        tz: "Asia/Calcutta", // For Google Calendar
        // the TZD string of timezone in which input dates from data sources is specified
        outputTZOffset: "+05:30", // +05:30
        // start Day of the week
        weekStartDay: 1,
        // specifies Week Number Calculation Method - "US" or "Europe/ISO"
        weekNumCalculation: "US", // ["US", "Europe/ISO"]
        // a value of Number of Days To Display in DetailView
        daysInCustomView: 4,
        // a value of Days To Display in DayListView("DayEventListView", "DayEventDetailView")
        daysInDayListView: 7,
        // a value of Days To Display in AppointmentView
        daysInAppointmentView: 4,
        // the duration of AgendaView
        agendaViewDuration: "Week", // ["Month", "Week", "CustomDays"]
        // a value of days to display in the AgendaView if "agendaViewDuration: CustomDays"
        daysInAgendaView: 15,
        // theme of Agenda View
        agendaViewTheme: '',
        // Set whether you want to show Days with no events in Agenda View. 
        // If you set it to true, "No Events" text is displayed below Date String.
        showDaysWithNoEventsInAgendaView: false,
        // Set whether you want to display a fixed height for each cell of "WeekPlannerView".
        fixedHeightOfWeekPlannerViewCells: true,
        // the duration of Quick Agenda View
        quickAgendaViewDuration: "Week", // ["Week", "CustomDays"]
        // a value of days to display in the Quick Agenda View if "quickAgendaViewDuration: CustomDays"
        daysInQuickAgendaView: 5,
        // the duration of Task Planner View
        taskPlannerViewDuration: "Week", // ["Week", "CustomDays"]
        // a value of days to display in the Task Planner View if "taskPlannerViewDuration: CustomDays"
        daysInTaskPlannerView: 5,
        // Set whether you want to display a fixed height for each cell of "TaskPlannerView".
        fixedHeightOfTaskPlannerView: true,
        // a value of View Transition Animation Speed in milliseconds
        transitionSpeed: 600,
        // perform view transition animations or simply replace a view
        showTransition: false,
        // If fixedNumberOfWeeksInMonthView is set to true, 6 weeks will be displayed in month views. 
        // Else, number of weeks for a selected month will be displayed.
        fixedNumOfWeeksInMonthView: false,
        // display Week Number in MonthView and DetailedMonthView
        displayWeekNumInMonthView: false,
        // defines action to perform on day click in MonthView
        actionOnDayClickInMonthView: "ModifyEventList", // ["ModifyEventList", "ChangeDate", "DisplayEventListDialog"]
        // used to set whether to add Events or Event Indicator Line or Custom Event View in the MonthView
        eventIndicatorInMonthView: "Events", // ["DayHighlight", "Events", "Custom"]
        // used to set the way to indicate the existence of Events for day
        eventIndicatorInDatePicker: "DayNumberBold", // ["DayNumberBold", "Dot"]
        // used to set whether to Event Indicator Line or Custom Event View in the DayListView
        eventIndicatorInDayListView: "DayHighlight", // ["DayHighlight", "Custom"]
        // width of the Day Highlighter Line is calculated as a percentage of averageEventsPerDayForDayHighlightView
        averageEventsPerDayForDayHighlightView: 5,
        // If set to true, height of all rows of DetailedMonthView is set equal and Events that fit into the Row are added. 
        // hiddenEventsIndicatorLabel is added in the days for which all events can not be added. 
        // hiddenEventsIndicatorAction will be taken on click of hiddenEventsIndicatorLabel.
        // If set to false, height of each row in the DetailedMonthView will be increased to accommodate all events for the day.
        hideExtraEvents: true,
        // If hideExtraEvents is set to true, height of all rows of DetailedMonthView is set equal and Events that fit into the Row are added. 
        // hiddenEventsIndicatorLabel is added in the days for which all events can not be added. 
        // hiddenEventsIndicatorAction will be taken on click of hiddenEventsIndicatorLabel. 
        // You can set any string or html string as a hiddenEventsIndicatorLabel. 
        // If you want to show count of hidden events in the hiddenEventsIndicatorLabel you can use string "(count)".
        hiddenEventsIndicatorLabel: "+(count) more",
        // This is an action to be taken on click of hiddenEventsIndicatorLabel.
        // With the default action, "ShowEventDialog", Event dialog listing all events will be displayed over a Month Day cell for which hiddenEventsIndicatorLabel is clicked.
        // hiddenEventsIndicatorAction can also be used as a callback function with parameters (dDate, oArrEvents, bShow). Here, dDate is the date for which event is triggered, oArrEvents is the array of Events for dDate, bShow indicates whether callback is to show dialog/start action or hide dialog/end action.
        hiddenEventsIndicatorAction: "ShowEventDialog",
        // If set to false, events will not be displayed on the calendar even if calDataSource is specified.
        addEventsInMonthView: true,
        // If set to false, events will not be displayed on the calendar even if calDataSource is specified. 
        // But Event Dialog can be displayed. This View can be used where less space is available for displaying calendar.
        displayEventsInMonthView: true,
        // enable or disable Drag and Drop of Event in Month View.
        isDragNDropInMonthView: false,
        // show or hide Event Tooltip in Month View
        isTooltipInMonthView: false,
        // enable or disable Drag and Drop of Event in Detail View
        isDragNDropInDetailView: false,
        // enable or disable Resizing of Event in Detail View
        isResizeInDetailView: true,
        // show or hide Event Tooltip in Detail View
        isTooltipInDetailView: false,
        // enable or disable Drag and Drop of Event in Quick Agenda View
        isDragNDropInQuickAgendaView: false,
        // show or hide Event Tooltip in Quick Agenda View
        isTooltipInQuickAgendaView: false,
        // enable or disable Drag and Drop of Event in Task Planner View
        isDragNDropInTaskPlannerView: false,
        // show or hide Event Tooltip in Task Planner View
        isTooltipInTaskPlannerView: false,
        // show or hide tooltip in AppointmentView
        isTooltipInAppointmentView: true,
        // height Of Action Bar
        actionBarHeight: 30,
        // position of Filter Bar in the View
        filterBarPosition: "Top", // ["Top", "Bottom", "Left", "Right"]
        // height Of Filter Bar
        filterBarHeight: 200,
        // width Of Filter Bar
        filterBarWidth: 200,
        // an array used to set parameters of Filter to be applied on Events Array
        eventFilterCriteria: [],
        // an action to take when no filter criteria is selected by user
        noneSelectedFilterAction: "SelectNone", //["SelectNone", "SelectAll"]
        // If changeCalendarBorderColorInJS is set to true then, calendarBorderColor value will be set as a border-color of all calendar structure borders. 
        // Else, border-color specified in CSS will be rendered.
        calendarBorderColor: "FFFFFF",
        // If changeCalendarBorderColorInJS is set to true then, calendarBorderColor value will be set as a border-color of all calendar structure borders. 
        // Else, border-color specified in CSS will be rendered.
        changeCalendarBorderColorInJS: false,
        // a number of months for which data needs to be loaded
        extraMonthsForDataLoading: 1,
        // When extraMonthsForDataLoading is set to a value other than 0, data for specified number of extra months is loaded.
        // If extraMonthsForDataLoading is set to 1 and Current Month is June(6), then data for May(6-1), June(6) and July(6+1) is loaded.
        // If "Previous" button is clicked, then Current Month is May(5), Previous Month is April(5-1) and next Month is June(5+1). But data for May, June and July is already present so data for April is requested and the data for July is deleted.
        // If you don't want to delete existing data while navigating then set deleteOldDataWhileNavigating to false.
        // If you set datasetModificationRule as "ReplaceSpecified", then you need to set deleteOldDataWhileNavigating to false.
        deleteOldDataWhileNavigating: true,
        // ["Default", "ReplaceAll", "ReplaceSpecified"]
        datasetModificationRule: "Default",
        // ["Event", "EventCalendar", "EventSource"]
        changeColorBasedOn: "EventCalendar",
        // Default border-color of an event in case it is not specified in the Event, Event Source Array or Event Type Array. 
        // To get transparent borders, specify "transparent" or ""
        borderColor: "",
        // Default text-color of an event in case it is not specified in the eventSource, calDataSource or eventCalendarSource.
        textColor: "FFFFFF",
        // When onlyTextForNonAllDayEvents is set to true, Non All Day Event is displayed as a Text in nonAllDayEventsTextColor; else it is displayed same as All Day Event.
        onlyTextForNonAllDayEvents: true,
        // If Event Color is not specified in eventSource, calDataSource or eventCalendarSource, a Color from this array will be assigned to the Event. 
        // If all colors from this array are used up then, programmatically generated colors will be assigned.
        eventColorsArray: ["C0392B", "D2527F", "674172", "336E7B", "36D7B7", "68C3A3", "E87E04", "6C7A89", "F9690E"],
        // Default Event Indicator in case it event Icon is not specified in the eventSource, calDataSource or eventCalendarSource.
        eventIcon: "Dot", // ["Dot", "cs-icon-Event"]
        // Event Icon is displayed, if hideEventIcon is set to false for a particular view, otherwise it will not be displayed.
        hideEventIcon: {
            Default: false,
            DetailedMonthView: false,
            MonthView: false,
            WeekView: false,
            DayView: false,
            CustomView: false,
            QuickAgendaView: false,
            TaskPlannerView: false,
            DayEventDetailView: false,
            AgendaView: false,
            WeekPlannerView: false
        },
        // Event Time is displayed, if hideEventTime is set to false for a particular view, otherwise it will not be displayed.
        hideEventTime: {
            Default: false,
            DetailedMonthView: false,
            MonthView: false,
            WeekView: false,
            DayView: false,
            CustomView: false,
            QuickAgendaView: false,
            TaskPlannerView: false,
            DayEventDetailView: false,
            AgendaView: false,
            WeekPlannerView: false
        },
        // an array of business Hours for each Day of the Week
        businessHoursSource: [
        {
            day: 1,
            times: [{
                startTime: "09:00",
                endTime: "19:00"
            }]
        },
        {
            day: 2,
            times: [{
                startTime: "09:00",
                endTime: "19:00"
            }]
        },
        {
            day: 3,
            times: [{
                startTime: "09:00",
                endTime: "19:00"
            }]
        },
        {
            day: 4,
            times: [{
                startTime: "09:00",
                endTime: "19:00"
            }]
        },
        {
            day: 5,
            times: [{
                startTime: "09:00",
                endTime: "19:00"
            }]
        },
        {
            day: 6,
            times: [{
                startTime: "09:00",
                endTime: "19:00"
            }]
        }],
        // hide dates and times apart from business hours
        excludeNonBusinessHours: false,
        // allow events to be dropped on Non Business Hours
        isNonBusinessHoursDroppable: true,
        // allow events to be dropped on Restricted Section
        isRestrictedSectionDroppable: true,
        eventOrTaskStatusIndicators: [
        {
            name: "Overdue",
            color: "E74C3C"
        },
        {
            name: "Completed",
            color: "27AE60"
        },
        {
            name: "InProgress",
            color: "F1C40F"
        }],
        // JSON object set to source in calDataSource with sourceType as a JSON
        calDataSource: [
        {
            sourceFetchType: "DateRange",
            sourceType: "FUNCTION",
            source: function(fetchStartDate, fetchEndDate, durationStartDate, durationEndDate, oConfig, loadViewCallback)
            {
                if (load_data) {
                    var start_date = durationStartDate.getDate();
                    start_date = start_date > 9 ? start_date : '0' + start_date;
                    var start_month = durationStartDate.getMonth() + 1;
                    start_month = start_month > 9 ? start_month : '0' + start_month;
                    var start_year = durationStartDate.getFullYear();
                    var end_date = durationEndDate.getDate();
                    end_date = end_date > 9 ? end_date : '0' + end_date;
                    var end_month = durationEndDate.getMonth() + 1;
                    end_month = end_month > 9 ? end_month : '0' + end_month;
                    var end_year = durationEndDate.getFullYear();
                    var start_at = start_date + '-' + start_month + '-' + start_year;
                    var end_at = end_date + '-' + end_month + '-' + end_year;
                    var calObj1 = this;
                    calObj1.incrementDataLoadingCount(1);
                    var oEventResponse = generateJsonEvents(start_at, end_at);
                    if (oEventResponse != undefined)
                    {
                        if (oEventResponse[0])
                        {
                            calObj1.parseDataSource("eventSource", oEventResponse[1], durationStartDate, durationEndDate, loadViewCallback, oConfig, false);
                        }
                    }
                    load_data = false;
                }
            }
        }],
        visibleViewChanged: function(selectedDate, highlightDates)
        {
            load_data = true;
            oCal1.reloadData();
            oCal1.refreshView();
        },
        previousButtonClicked: function(selectedDate, highlightDates)
        {
            load_data = true;
            oCal1.reloadData();
            oCal1.refreshView();
        },
        nextButtonClicked: function(selectedDate, highlightDates)
        {
            load_data = true;
            oCal1.reloadData();
            oCal1.refreshView();
        },
        todayButtonClicked: function(selectedDate, highlightDates)
        {
            load_data = true;
            oCal1.reloadData();
            oCal1.refreshView();
        },
        eventsAddedInView: function(visibleView, eventClass)
        {
            var thisObj = this;
            $(thisObj.elem).find(eventClass).popover(
            {
                placement: "top",
                trigger: "hover",
                html: true,
                container: "body",
                content: function()
                {
                    var oTooltipContent = $(this).data("tooltipcontent");
                    var title = oTooltipContent.title;
                    if (($(this).data("pos").split("|")).length == 4) {
                        var rowpos = parseInt($(this).data("pos").split("|")[0]) + 1;
                        var colpos = parseInt($(this).data("pos").split("|")[2]);
                        var id = $("#cmvMonthTableRow" + rowpos + " .cmvTableColumn" + colpos).attr("id");
                        var date = (id.split("cmvDay-")[1]).split("-");
                        var day = date[0].length > 1 ? date[0] : "0" + date[0];
                        var month = (parseInt(date[1]) + 1) > 9 ? (parseInt(date[1]) + 1) : "0" + (parseInt(date[1]) + 1);
                        date = day + "-" + month + "-" + date[2];
                        var currentpos = date + " " + oTooltipContent.startDateTime + "||" + date + " " + oTooltipContent.endDateTime;
                    } else {
                        var pos = ($(this).data("pos").split("|")[0]).toString();
                        var rowpos = pos.length == 3 ? ("0" + pos) : pos;
                        var colpos = $(this).data("pos").split("|")[1];
                        var id = $(".cdvTimeSlotTableRow" + rowpos + " .cdvDetailTableColumn" + colpos).attr("title");
                        id = new Date(id);
                        var getDate = id.getDate() < 10 ? ('0' + id.getDate()) : id.getDate();
                        var getMonth = (id.getMonth() + 1) > 9 ? (id.getMonth() + 1) : '0' + (id.getMonth() + 1);
                        var getYear = id.getFullYear();
                        date = getDate + "-" + getMonth + "-" + getYear;
                        var currentpos = date + " " + oTooltipContent.startDateTime + "||" + date + " " + oTooltipContent.endDateTime;
                    }
                    var selected_id = $(this).attr('data-id'); 
                    var reason = $(this).attr('data-reason');
                    // appoinments.forEach(function(value, key) {
                    //     if ((Object.keys(value.date))[0] == currentpos) {
                    //         patientId = (Object.values(value.date))[0];
                    //         patientId = patientId.replace(/[a-zAreason-z-]/g, '');
                    //         if (selected_id == patientId) {
                    //             reason = value.reason;
                    if (typeof reason !== "undefined" && typeof reason !== "object" && reason != 'null' && reason != '') {
                        reason = "<b>Reason: " + reason + "</b><br/>";
                    } else {
                        reason = '';
                    }
                    //             return true;
                    //         }
                    //     }
                    // });
                    // sTooltipText = '';
                    // if (typeof patientId != 'undefined') {
                    //     var patientId1 = patientId.split('true')[1];
                    //     var patientId2 = patientId.split('false')[1];
                    //     if ($.isNumeric(patientId1)) {
                    //         patientId = patientId1;
                    //         isOp = true;
                            // sTooltipText = "<div class='cTooltipTitle text-center " + isOp + "' id='" + patientId + "'>" + title.replace(']', ']<br/>') + "</div><div class='cTooltipTime text-center'>" + reason + "Start Time:" + oTooltipContent.startDateTime + "<br/>" + "End Time:" + oTooltipContent.endDateTime + "</div>";
                        // } else {
                        //     patientId = patientId2;
                        //     isOp = false;
                            // sTooltipText = "<div class='cTooltipTitle text-center " + isOp + "' id='" + patientId + "'>" + title.replace(']', ']<br/>') + "</div><div class='cTooltipTime text-center'>" + reason + "Start Time:" + oTooltipContent.startDateTime + "<br/>" + "End Time:" + oTooltipContent.endDateTime + "</div>";
                    sTooltipText = "<div class='cTooltipTitle text-center'>" + title.replace(']', ']<br/>') + "</div><div class='cTooltipTime text-center'>" + reason + "Start Time:" + oTooltipContent.startDateTime + "<br/>" + "End Time:" + oTooltipContent.endDateTime + "</div>";
                        // }
                    // }
                    return sTooltipText;
                }
            });
},
eventClicked: function(visibleView, eventClass) {
    console.log(visibleView, eventClass);
    var temp_id = $(eventClass).attr('data-id');
    var patientId = temp_id;
    if ($('input[name="auth_user"]').val() == 'true') {
        eventScheduler(patientId);
    }
},
        // used to define data source for DatePicker
datePickerCalDataSource: [
{
    config:
    {
        sourceCountType: "Event"
    }
}],
        // Set whether Calendar should be responsive to the Window Resize Event.
adjustViewOnWindowResize: true,
        // Set whether Hammer.js should be used as a Touch Gesture Library. Default Gestures added will be "swiperight" for navigating to Previous View and "swipeleft" for navigating to Next View.
useHammerjsAsGestureLibrary: false,
});

function generateJsonEvents(start, end) {
    var data = [];
    data[0] = true;
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        data: {
            start_at: start,
            end_at: end
        },
        url: "{{ url('appointment-calendar') }}",
        async: false,
        success: function(response) {
            data[1] = JSON.parse(response);
                // appoinments = data[1];
                // already_exist.push(start + '||' + end);
        }
    });
    return data;
}

function eventScheduler(patientId) {
    $.ajax({
        type: "GET",
        url: "patient-detail-edit/" + patientId,
        success: function(message) {
            var message = message.appointment_detail;
            console.log(message);
            $('#editappointment').modal('show');
            $('#patient-control label[for="category_content"]').html((typeof message.category != 'undefined' && message.category != null) ? message.category : '-');
            var appointment_date = message.modified_appointment_date != null ? message.modified_appointment_date : message.appointment_date;

            if (typeof appointment_date !== 'undefined') {
                var temp_appointment_date = appointment_date.split('-');
                appointment_date = temp_appointment_date[2] + '-' + temp_appointment_date[1] + '-' + temp_appointment_date[0];
                var appointment_time = message.modified_appointment_time != null ? message.modified_appointment_time : message.appointment_time;
                appointment_time = appointment_time > 9 ? appointment_time : '0' + appointment_time;
                var appointment_min = message.modified_appointment_min != null ? message.modified_appointment_min : message.appointment_min;
                appointment_min = appointment_min > 9 ? appointment_min : '0' + appointment_min;
                appointment_min = ':' + appointment_min;
                var appointment_session = message.modified_appointment_session != null ? message.modified_appointment_session : message.appointment_session;
                $('#patient-control label[for="date_content"]').html(appointment_date);
                $('#patient-control label[for="hrs_content"]').html(appointment_time);
                $('#patient-control label[for="mins_content"]').html(appointment_min);
                $('#patient-control label[for="session_content"]').html(appointment_session);
            } else {
                $('#patient-control label[for="date_content"]').html('-');
                $('#patient-control label[for="hrs_content"]').html('');
                $('#patient-control label[for="mins_content"]').html('');
                $('#patient-control label[for="session_content"]').html('');                
            }

            if (typeof message.name_qualification !== null && typeof message.name_qualification !== 'undefined') {
                $('#patient-control label[for="consultant_content"]').html(message.name_qualification);
            } else {
                $('#patient-control label[for="consultant_content"]').html('-');                
            }
            $('#patient-control label[for="consultant_content"]').html('-');                
            if (typeof message.baby_name !== 'undefined' && typeof message.baby_name_mrn !== 'undefined') {
                if (message.baby_name == null) {
                    $('#patient-control label[for="patient_content"]').html(message.baby_name_mrn);
                } else {
                    $('#patient-control label[for="patient_content"]').html(message.baby_name);                    
                }
            } else {
                $('#patient-control label[for="patient_content"]').html('-');
                $("#patient-control label[for='contact_no_content']").html('-');
            }
            $('#patient-control select[name="consultant"]').select2("val", "");
            $('#patient-control input[name="appointment_id"]').val(patientId);
            if (message.reason != null && message.reason != '') {
                $('#patient-control label[for="reason_content"]').html(message.reason);
            } else {
                $('#patient-control label[for="reason_content"]').parent().parent().parent().addClass('hide');
            }
        }
    });
}
$('#patient-detail').on('click', function() {
    $('#createappointment').modal({
        backdrop: 'static',
        show: true
    });
    $('.create').show();
    $('.update').hide();
    $('#ssearch').select2("val", "");
    $('#patient-control .modal-body').find(':input').prop('disabled', false);
    $('#date').datepicker({
        dateFormat: 'dd-mm-yy',
        minDate: new Date()
    }).val(current_date + '-' + current_month + '-' + current_year);
    $('#time').val(10);
    $('#mins').val(0);
    $('#session').val('AM');
});
$('#save-patient-detail').on('click', function(e) {
    e.preventDefault();
    var empty = [];
    var isempty = true;
    var validClass = "#create-patient-control #category";
    var urlType = "PATCH";
    var url = "patient-detail-update/0";
    $(validClass).each(function() {
        if ($('#ssearch').val() == '') {
            $('#ssearch').parents('.custom-input').find('.text-center span').addClass('error-admission');
            if ($('#ssearch').parents('.custom-input').find('.text-center span').hasClass('error-message')) {
                $('#ssearch').parents('.custom-input').find('.text-center span').removeClass('error-admission');
            }
            empty.push("false");
        } else if ($.isNumeric($('#ssearch').val()) && $('#ssearch').val() == $('#s2id_ssearch .select2-chosen').html()) {
            $('.custom-error').removeClass('hide');
            empty.push("false");
        } else if ($(this).val() == '') {
            if (!$(this).parent().children().hasClass('error')) {
                $(this).parent().children().after("<label class='error'>This field is required.</label>");
            }
            empty.push("false");
        } else if ($('#create-patient-control #consultant').val() == '') {
            $('#create-patient-control #consultant').parents('.col-md-9 custom-input').find('.text-center span').addClass('error-admission');
            if ($('#create-patient-control #consultant').parents('.col-md-9 custom-input').find('.text-center span').hasClass('error-message')) {
                $('#create-patient-control #consultant').parents('.col-md-9 custom-input').find('.text-center span').removeClass('error-admission');
            }
            empty.push("false");
        } else {
            $(this).parent().parent().children().find('.error').remove();
            $('.custom-error').addClass('hide');
            empty.push("true");
        }
    });
    Object.values(empty).forEach(function(value, key) {
        if (value == "false") {
            isempty = false;
        }
    });
    if (isempty) {
        var data_content = $($("#create-patient-control")[0].elements).serializeArray();
        var added_content = {
            'name': 'patient',
            'value': $('#ssearch').val()
        };
        data_content.push(added_content);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: urlType,
            url: url,
            data: data_content,
            success: function(message) {
                load_data = true;
                oCal1.reloadData();
                oCal1.refreshView();
                $('#createappointment').modal('hide');
            }
        });

        var need_neuro = $("#create-patient-control #need_neuro").prop('checked');
        if (need_neuro) {
            var neuro_dr_id = $('input[name="neuro_dr_id"]').val();
            data_content[4].value = neuro_dr_id;
            $.ajax({
                type: urlType,
                url: url,
                data: data_content,
                success: function(message) {
                    load_data = true;
                    oCal1.reloadData();
                    oCal1.refreshView();
                    $('#createappointment').modal('hide');
                }
            });
        }
    } else {
        console.log('your error message')
    };
});
var update_form_validation = false;
$('#edit').on('change', function() {
    var allow_edit = $(this).prop('checked');
    if (allow_edit) {
        update_form_validation = true;
        $('#reschedule').removeClass('hide');
        $('#update-patient-detail').attr('disabled', false);
        $('#cancel').bootstrapToggle('off');
        $('#appointmentDate').datepicker({
            dateFormat: 'dd-mm-yy',
            minDate: new Date()
        });
        $('#appointmentDate').val(current_date + '-' + current_month + '-' + current_year);
        $('#newTime').val(10);
        $('#newMins').val(0);
        $('#newSession').val('AM');
    } else {
        update_form_validation = false;
        $('#reschedule').addClass('hide');
        if (!$('#cancel').prop('checked')) {
            $('#update-patient-detail').attr('disabled', true);
        }
    }
});
$('#cancel').on('change', function() {
    var allow_cancel = $(this).prop('checked');
    if (allow_cancel) {
        $('#edit').bootstrapToggle('off');
        $('#reschedule').addClass('hide');
        $('#patient-control .modal-body').find('textarea').val('');
        $('#update-patient-detail').attr('disabled', false);
    } else {
        if (!$('#edit').prop('checked')) {
            $('#update-patient-detail').attr('disabled', true);
        }
    }
});
$('#update-patient-detail').on('click', function(e) {
    e.preventDefault();
    var appointment_id = $('input[name="appointment_id"]').val();
    var empty = [];
    var isempty = true;
        // var validClass = "#patient-control #reason";
    var urlType = "PATCH";
    var url = "patient-detail-update/" + appointment_id;
        // if (update_form_validation) {
        //     $(validClass).each(function() {
        //         if ($(this).val() == '') {
        //             if (!$(this).parent().children().hasClass('error')) {
        //                 $(this).parent().children().after("<label class='error'>This field is required.</label>");
        //             }
        //             empty.push("false");
        //         } else if ($('#patient-control #consultant').val() == '') {
        //             $('#patient-control #consultant').parents('.col-md-9.custom-input').find('.text-center span').addClass('error-admission');
        //             if ($('#patient-control #consultant').parents('.col-md-9.custom-input').find('.text-center span').hasClass('error-message')) {
        //                 $('#patient-control #consultant').parents('.col-md-9.custom-input').find('.text-center span').removeClass('error-admission');
        //             }
        //             empty.push("false");
        //         } else {
        //             $(this).parent().parent().children().find('.error').remove();
        //             empty.push("true");
        //         }
        //     });
        //     Object.values(empty).forEach(function(value, key) {
        //         if (value == "false") {
        //             isempty = false;
        //         }
        //     });
        // }
    if (isempty) {
        var data_content = $($("#patient-control")[0].elements).serializeArray();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: urlType,
            url: url,
            data: data_content,
            success: function(message) {
                load_data = true;
                oCal1.reloadData();
                oCal1.refreshView();
                $('#editappointment').modal('hide');
            }
        });
    } else {
        console.log('your error message');
    }
});
$('#createappointment').on('hidden.bs.modal', function() {
    $('#create-patient-control .modal-body').find(':input').val('');
    $('#create-patient-control .modal-body').find('.error').remove();
});
$('#editappointment').on('hidden.bs.modal', function() {
    $('#patient-control .modal-body').find(':input').val('');
    $('#patient-control .modal-body').find('.error').remove();
    $('#edit').bootstrapToggle('off');
    $('#cancel').bootstrapToggle('off');
    $('#reschedule').addClass('hide');
});
$('#ssearch').on('change', function() {
    var selected_patient = $(this).val();
    if ($.isNumeric(selected_patient)) {
        if ($('#ssearch').val() == $('#s2id_ssearch .select2-chosen').html()) {
            $('.custom-error').removeClass('hide');
        } else {
            $('.custom-error').addClass('hide');                
        }
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            data: {
                baby_id : selected_patient
            },
            url: "{{ url('get-contact-number') }}",
            success: function(response) {
                $('#contact_no').val(response.data);         
            }
        });
    }
});
});
</script>
@endsection

