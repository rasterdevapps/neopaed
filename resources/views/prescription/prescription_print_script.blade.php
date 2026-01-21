@section('scripts') 
<script type="text/javascript">
    $(document).ready(function() {
        var regular_row = 5;
        var required_row = 5;
        var intravenous_row = 15;
        var stat_row = 15;

        var unit_grams = <?php echo json_encode(ValuelistHelpers::infusiondoesunitgrams()); ?>;
        var unit_kg = <?php echo json_encode(ValuelistHelpers::infusiondoeskilograms()); ?>;
        var duration_type = <?php echo json_encode(ValuelistHelpers::infusiondoesduration()); ?>;
        var qty_unit = <?php echo json_encode(ValuelistHelpers::infusionquantityunits()); ?>;
        var syringe_size = <?php echo json_encode(ValuelistHelpers::getsyringesize()); ?>;
        var brand_name = <?php echo json_encode(ValuelistHelpers::getBrandName()); ?>;
        var unit_grams_oral = <?php echo json_encode(ValuelistHelpers::oraldoesunitgrams()); ?>;
        var doctors_list = <?php echo json_encode(ValuelistHelpers::mas_doctors_list()); ?>;
        var user_initial = <?php echo json_encode(ValuelistHelpers::getUserInitial()); ?>;
        var user_sign = <?php echo json_encode(ValuelistHelpers::getUserSign()); ?>;
        var user_data = <?php echo json_encode(ValuelistHelpers::getUserBasedDetails()); ?>;
        var user_details = [];
        var prescription_val;
        var babyId = $("input[name='babyid']").val();
        var admissionId = $("input[name='admissionid']").val();
        var date = $("input[name='date']").val();
        $("#prescription_date option[value='']:selected").attr('disabled', "disabled");
        var basicdate = date.replace(/\s/, 'T');
        basicdate = basicdate.split('-');
        var fromdate = new Date(basicdate[2], (basicdate[1] - 1), basicdate[0]);
        var from_date, to_date;
        fromdate.setDate(fromdate.getDate());
        date = (fromdate.getDate() > 9) ? fromdate.getDate() : '0' + fromdate.getDate();
        month = ((fromdate.getMonth() + 1) > 9) ? (fromdate.getMonth() + 1) : ('0' + (fromdate.getMonth() + 1));
        year = fromdate.getFullYear();
        from_date = year + '-' + month + '-' + date;
        from_date_picker = date + '-' + month + '-' + year;
        var todate = new Date(fromdate);
        todate.setDate(todate.getDate() + 6);
        date = (todate.getDate() > 9) ? todate.getDate() : '0' + todate.getDate();
        month = ((todate.getMonth() + 1) > 9) ? (todate.getMonth() + 1) : ('0' + (todate.getMonth() + 1));
        year = todate.getFullYear();
        to_date = year + '-' + month + '-' + date;
        to_date_picker = date + '-' + month + '-' + year;
        $('input[name="fromdate"]').datepicker({
            dateFormat: 'dd-mm-yy',
            onSelect: function(_date) {
                var newdate = $(this).datepicker('getDate'); // Retrieve selected date
                var from_date = $.datepicker.formatDate('yy-mm-dd', newdate);
                from_date_picker = $.datepicker.formatDate('dd-mm-yy', newdate);
                newdate.setDate(newdate.getDate() + 6); // Add 6 days

                to_date_picker = $.datepicker.formatDate('dd-mm-yy', newdate);
                $('input[name="todate"]').val(to_date_picker); // Reformat

                var to_date = $.datepicker.formatDate('yy-mm-dd', newdate);

                $('input[name="todate"]').val(to_date_picker);
                $('.print-date').html(from_date_picker + ' to ' + to_date_picker);

                dateFilter(from_date, to_date);
                generateSheets(prescription_val);
                prescriptionTableCreation(babyId, admissionId, from_date, to_date);

            }
        }).val(from_date_picker);
        $('input[name="todate"]').datepicker({
            dateFormat: 'dd-mm-yy',
            onSelect: function(_date) {
                var newdate = $(this).datepicker('getDate'); // Retrieve selected date
                var to_date = $.datepicker.formatDate('yy-mm-dd', newdate);
                to_date_picker = $.datepicker.formatDate('dd-mm-yy', newdate);
                newdate.setDate(newdate.getDate() - 6); // Substract 6 days

                from_date_picker = $.datepicker.formatDate('dd-mm-yy', newdate);
                $('input[name="fromdate"]').val(from_date_picker); // Reformat

                var from_date = $.datepicker.formatDate('yy-mm-dd', newdate);

                $('input[name="fromdate"]').val(from_date_picker);
                $('.print-date').html(from_date_picker + ' to ' + to_date_picker);

                dateFilter(from_date, to_date);
                generateSheets(prescription_val);
                prescriptionTableCreation(babyId, admissionId, from_date, to_date);

            }
        }).val(to_date_picker);
        $('.print-date').html(from_date_picker + ' to ' + to_date_picker);
        dateFilter(from_date, to_date);
        prescriptionTableCreation(babyId, admissionId, from_date, to_date);

        var started_user_initial_img_alt = '<img src="{{ $site_url }}/img/no-image.png" alt="Started By" class="alt-image" />';
        var stopped_user_initial_img_alt = '<img src="{{ $site_url }}/img/no-image.png" alt="Stopped By" class="alt-image" />';
        var cancelled_user_initial_img_alt = '<img src="{{ $site_url }}/img/no-image.png" alt="Cancelled By" class="alt-image" />';
        var prescribed_img_alt = '<img src="{{ $site_url }}/img/no-image.png" alt="Prescribed By" class="alt-image" />';

        function prescriptionTableCreation(babyId, admissionId, fromdate, todate) {
            $(".temp-row").hide();
            $(".prescription-loader").show();
            $(".prescription-loader").css({
                "background": "url('{{ url('/') }}/public/img/icons/preloader.gif') center no-repeat #fff",
                "padding": "50px",
                "text-align": "center",                
                "position": "fixed",
                "width": "100%",
                "height": "100%",
                "left": "0px",
                "top": "0px",
                "z-index": "5",
            });
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'GET',
                url: '{{ url("print-filter-by-date") }}' + '/' + babyId + '/' + admissionId + '/' + fromdate + '/' + todate,
                success: function(prescription) {
                    prescription_val = prescription;
                    var working_weight = prescription_val.basic_val;
                    if (typeof working_weight != 'undefined' && working_weight != null && working_weight != '') {
                        $('.working-wt').html(working_weight);
                    }
                    if (prescription_val.prescribed.prescribed_date_list.length > 0) {
                        var start_date = prescription_val.prescribed.prescribed_date_list[0];
                        start_date = start_date.split('-');
                        start_date = start_date[1] + '-' + start_date[0] + '-' + start_date[2];
                        $('.start-date').html(start_date);
                    }
                    generateSheets(prescription);
                    $(".prescription-loader").hide();
                    $(".temp-row").show();
                }
            });
        }
        var pres_sheet_date, prescription_sheet_date;

        function dateFilter(fromdate, todate) {
            prescription_sheet_date = [];
            prescription_sheet_time = [];
            pres_sheet_date = [];
            var start = new Date(fromdate),
            end = new Date(todate),
            currentDate = start;
            var sheet_date = [];
            var sheet_date1 = [];
            while (currentDate <= end) {
                var date_list = currentDate;
                date = (date_list.getDate() > 9) ? date_list.getDate() : '0' + date_list.getDate();
                month = ((date_list.getMonth() + 1) > 9) ? (date_list.getMonth() + 1) : ('0' + (date_list.getMonth() + 1));
                year = date_list.getFullYear();
                hours = (date_list.getHours() > 9) ? date_list.getHours() : ('0' + date_list.getHours());
                minutes = (date_list.getMinutes() > 9) ? date_list.getMinutes() : ('0' + date_list.getMinutes());
                date_list = date + '/' + month;
                date_list1 = month + '-' + date + '-' + year;
                time_list = hours + ':' + minutes;
                prescription_sheet_date.push(date_list);
                pres_sheet_date.push(date_list1);
                prescription_sheet_time.push(time_list);
                currentDate.setDate(currentDate.getDate() + 1);
            }
        }

        function generateSheets(prescription, fromdate = '', todate = '') {
            user_details = [];
            var prescription_list = prescription.prescribed.prescription_list;
            var data_1_1 = data_1_2 = data_2 = data_3 = '';
            var regular_list = typeof prescription_list[1] !== "undefined" ? prescription_list[1] : [];
            var regular_not_terminate = [];
            var regular_terminate = [];
            $.each(regular_list, function(key, item) {
                if (item.terminate == null) {
                    regular_not_terminate.push(item);
                } else {
                    regular_terminate.push(item);
                }
            });
            regular_list = $.merge(regular_not_terminate, regular_terminate);
            var stat_list = typeof prescription_list[4] !== "undefined" ? prescription_list[4] : [];
            var stat_not_terminate = [];
            var stat_terminate = [];
            $.each(stat_list, function(key, item) {
                if (item.terminate == null) {
                    stat_not_terminate.push(item);
                } else {
                    stat_terminate.push(item);
                }
            });
            stat_list = $.merge(stat_not_terminate, stat_terminate);
            var required_list = typeof prescription_list[2] !== "undefined" ? prescription_list[2] : [];
            var required_not_terminate = [];
            var required_terminate = [];
            $.each(required_list, function(key, item) {
                if (item.terminate == null) {
                    required_not_terminate.push(item);
                } else {
                    required_terminate.push(item);
                }
            });
            required_list = $.merge(required_not_terminate, required_terminate);
            var intravenous_list = typeof prescription_list[3] !== "undefined" ? prescription_list[3] : [];
            intravenous_list.sort((a, b) => (a.hdr_id > b.hdr_id) ? 1 : -1);

            var order_no_1 = '';
            var order_no_2 = '';

            var sheet_length = [];
            sheet_length.push(Math.ceil(regular_list.length / (regular_row * 2)));
            sheet_length.push(Math.ceil(stat_list.length / stat_row));
            sheet_length.push(Math.ceil(required_list.length / required_row));
            sheet_length.push(Math.ceil(intravenous_list.length / intravenous_row));
            var sheet_count = Math.max.apply(null, sheet_length);
            sheet_count = sheet_count > 0 ? sheet_count : 1;
            var regular_start1 = stat_start1 = required_start1 = intravenous_start1 = 0;
            var regular_start2 = 6;
            var stat_start2 = 7;
            var tab_view = '';
            var tab_view_2 = '';
            tab_view += '<div role="tabpanel" class="tabbable tabbable-custom">';
            tab_view += '<ul class="nav nav-tabs" role="tablist">';
            tab_view_2 += '<div role="tabpanel" class="tabbable tabbable-custom">';
            tab_view_2 += '<ul class="nav nav-tabs" role="tablist">';
            for (var sheet_i = 1; sheet_i <= sheet_count; sheet_i++) {
                if (sheet_i == 1) {
                    tab_view += '<li role="presentation" class="active">';
                    tab_view_2 += '<li role="presentation" class="active">';
                } else {
                    tab_view += '<li role="presentation">';
                    tab_view_2 += '<li role="presentation">';
                }
                tab_view += '<a href="#sheet' + sheet_i + '" role="tab" data-toggle="tab">Sheet' + sheet_i + '</a>';
                tab_view_2 += '<a href="#sheet' + sheet_i + '_inter" role="tab" data-toggle="tab">Sheet' + sheet_i + '</a>';
                tab_view += '</li>';
                tab_view_2 += '</li>';
            }
            tab_view += '</ul>';
            tab_view += '<div class="tab-content tab-view-shadow">';
            tab_view_2 += '</ul>';
            tab_view_2 += '<div class="tab-content tab-view-shadow">';
            
            for (var sheet_i = 1; sheet_i <= sheet_count; sheet_i++) {
                if (sheet_i == 1) {
                    regular_sheet_1 = sheet_i * regular_row;
                    stat_sheet_1 = sheet_i * parseInt(stat_row / 2);
                    regular_sheet_2 = sheet_i * (regular_row * 2);
                    stat_sheet_2 = sheet_i * stat_row;
                    required_sheet_1 = sheet_i * required_row;
                    intravenous_sheet_1 = sheet_i * intravenous_row;
                    order_no_1 += '<div role="tabpanel" class="tab-pane active" id="sheet' + sheet_i + '">';
                    order_no_2 += '<div role="tabpanel" class="tab-pane active" id="sheet' + sheet_i + '_inter">';
                } else {
                    regular_start1 = (regular_row * 2) * (sheet_i - 1);
                    stat_start1 = stat_row * (sheet_i - 1);
                    required_start1 = required_row * (sheet_i - 1);
                    intravenous_start1 = intravenous_row * (sheet_i - 1);
                    regular_sheet_1 = regular_start1 + regular_row;
                    regular_start2 = regular_sheet_1;
                    stat_sheet_1 = stat_start1 + parseInt(stat_row / 2);
                    stat_start2 = stat_sheet_1;
                    regular_sheet_2 = regular_start2 + regular_row;
                    stat_sheet_2 = stat_start2 + Math.ceil(stat_row / 2);
                    required_sheet_1 = required_start1 + required_row;
                    intravenous_sheet_1 = intravenous_start1 + intravenous_row;
                    order_no_1 += '<div role="tabpanel" class="tab-pane" id="sheet' + sheet_i + '">';
                    order_no_2 += '<div role="tabpanel" class="tab-pane" id="sheet' + sheet_i + '_inter">';
                }
                var regular_drug_1 = '<div id="regulardrug_1" class="mt-10">';
                regular_drug_1 += '<table class="page-break-inside">'
                regular_drug_1 += '<thead>';
                for (var i = regular_start1; i < regular_sheet_1; i++) {
                    var regular_value = typeof regular_list[i] !== "undefined" ? regular_list[i] : [];
                    var row_id = typeof regular_value.hdr_id !== "undefined" ? regular_value.hdr_id : i;
                    if (i == regular_start1) {
                        regular_drug_1 += '<tr><td colspan="20" class="p-0"><h5><b>REGULAR PRESCIPTIONS</b></h5></td></tr>';
                        regular_drug_1 += '<tr>';
                        regular_drug_1 += '<td class="text-center sno-width"><b>S.No</b></td><td colspan="4"><b>DATE AND MONTH</b></td>';
                        regular_drug_1 += '<td class="prescription-border-left prescription-border-right"></td>';
                        for (j = 0; j < prescription_sheet_date.length; j++) {
                            if (typeof prescription_sheet_date[j] === "undefined") {
                                var strDate1 = '';
                            } else {
                                regular_drug_1_Date = prescription_sheet_date[j];
                            }
                            regular_drug_1 += '<td class="time-font cell-bg" id="date-' + i + '-' + j + '"><b>' + regular_drug_1_Date + '</b></td>';
                        }
                        regular_drug_1 += '</tr><tr><td class="sno-width"></td><td colspan="4" class="white-space-nowarp main-table-div"><b>TICK TIMES OR ENTER VARIABLE TIME</b></td>';
                        regular_drug_1 += '<td class="prescription-border-left prescription-border-right"></td>';
                        for (j = 0; j < prescription_sheet_date.length; j++) {
                            regular_drug_1 += '<td class="cell-bg"></td>';
                        }
                    }
                    var regular_val_1 = updateRegularPrescriptionList(regular_value, i);
                    regular_drug_1 += '</tr></thead><tbody id="regular-' + row_id + '" class="prescription-border-top ' + regular_val_1[1] + '">';
                    regular_drug_1 += regular_val_1[0];
                    regular_drug_1 += '</tbody>';
                }
                regular_drug_1 += '</table></div>';
                var once_only = '<div class="page-break-always"></div>';
                once_only += '<h5 class="mt-5">ONCE ONLY AND PREMEDICATION DRUGS</h5>';
                once_only += '<table class="once_only_1 page-break-inside">';
                once_only += '<tr>';
                once_only += '<td class="text-center">S.No</td>';
                once_only += '<td class="text-center">DATE</td>';
                once_only += '<td class="text-center stat-drug">DRUG</td>';
                once_only += '<td class="text-center stat-dose">DOSE</td>';
                once_only += '<td class="text-center">TIME</td>';
                once_only += '<td class="text-center">ROUTE</td>';
                once_only += '<td class="text-center">SIGNATURE</td>';
                once_only += '<td class="text-center">Status</td>';
                once_only += '</tr>';
                for (once = stat_start1; once < stat_sheet_1; once++) {
                    var stat_value = typeof stat_list[once] !== "undefined" ? stat_list[once] : [];
                    once_only += updateStatPrescriptionList(stat_value, once);
                }
                once_only += '</table>';
                var regular_drug_2 = '<div id="regulardrug_2" class="mt-10"><table class="page-break-inside">';
                regular_drug_2 += '<thead>';
                for (var i = regular_start2; i < regular_sheet_2; i++) {
                    var regular_value = typeof regular_list[i] !== "undefined" ? regular_list[i] : [];
                    var row_id = typeof regular_value.hdr_id !== "undefined" ? regular_value.hdr_id : i;
                    if (i == regular_start2) {
                        regular_drug_2 += '<tr><td colspan="20"><h5><b>REGULAR PRESCIPTIONS</b></h5></td></tr>';
                        regular_drug_2 += '<tr>';
                        regular_drug_2 += '<td class="text-center sno-width"><b>S.No</b></td><td colspan="4"><b>DATE AND MONTH</b></td>';
                        regular_drug_2 += '<td class="prescription-border-left prescription-border-right"></td>';
                        for (j = 0; j < prescription_sheet_date.length; j++) {
                            if (typeof prescription_sheet_date[j] === "undefined") {
                                var strDate = '';
                            } else {
                                regular_drug_2_Date = prescription_sheet_date[j];
                            }
                            regular_drug_2 += '<td class="time-font cell-bg" id="date-' + i + '-' + j + '"><b>' + regular_drug_2_Date + '</b></td>';
                        }
                        regular_drug_2 += '</tr><tr><td class="sno-width"></td><td colspan="4"><b>TICK TIMES OR ENTER VARIABLE TIME</b></td>';
                        regular_drug_2 += '<td class="prescription-border-left prescription-border-right"></td>';
                        for (j = 0; j < prescription_sheet_date.length; j++) {
                            regular_drug_2 += '<td class="cell-bg"></td>';
                        }
                    }
                    var regular_val_2 = updateRegularPrescriptionList(regular_value, i);
                    regular_drug_2 += '</tr></thead><tbody id="regular-' + row_id + '" class="prescription-border-top ' + regular_val_2[1] + '">';
                    regular_drug_2 += regular_val_2[0];
                    regular_drug_2 += '</tbody>';
                }
                regular_drug_2 += '</table></div>';
                var once_only_2 = '<div class="page-break-always"></div>';
                once_only_2 += '<h5 class="mt-5">ONCE ONLY AND PREMEDICATION DRUGS</h5>';
                once_only_2 += '<table class="once_only_2 page-break-inside">';
                once_only_2 += '<tr>';
                once_only_2 += '<td class="text-center">S.No</td>';
                once_only_2 += '<td class="text-center">DATE</td>';
                once_only_2 += '<td class="text-center stat-drug">DRUG</td>';
                once_only_2 += '<td class="text-center stat-dose">DOSE</td>';
                once_only_2 += '<td class="text-center">TIME</td>';
                once_only_2 += '<td class="text-center">ROUTE</td>';
                once_only_2 += '<td class="text-center">SIGNATURE</td>';
                once_only_2 += '<td class="text-center">Status</td>';
                once_only_2 += '</tr>';
                for (once = stat_start2; once < stat_sheet_2; once++) {
                    var stat_value = typeof stat_list[once] !== "undefined" ? stat_list[once] : [];
                    once_only_2 += updateStatPrescriptionList(stat_value, once);
                }
                once_only_2 += '</table>';
                var required_drug = '<div id="requireddrug" class="mt-10"><table class="page-break-inside">';
                required_drug += '<thead>';
                for (var i = required_start1; i < required_sheet_1; i++) {
                    var required_value = typeof required_list[i] !== "undefined" ? required_list[i] : [];
                    var row_id = typeof required_value.hdr_id !== "undefined" ? required_value.hdr_id : i;
                    if (i == required_start1) {
                        required_drug += '<tr><td colspan="20"><h5><b>AS REQUIRED DRUGS</b></h5></td></tr>';
                        required_drug += '<tr>';
                        required_drug += '<td class="text-center sno-width"><b>S.No</b></td><td colspan="4"><b>DATE AND MONTH</b></td>';
                        required_drug += '<td class="prescription-border-left prescription-border-right remove-column"></td>';
                        required_drug += '<td class="prescription-border-left prescription-border-right"></td>';
                        for (j = 0; j < prescription_sheet_date.length; j++) {
                            if (typeof prescription_sheet_date[j] === "undefined") {
                                var strDate = '';
                            } else {
                                required_drug_Date = prescription_sheet_date[j];
                            }
                            required_drug += '<td class="cell-bg time-font" id="date-' + i + '-' + j + '"><b>' + required_drug_Date + '</b></td>';
                        }
                        required_drug += '</tr><tr><td class="sno-width"></td><td colspan="4"><b>TICK TIMES OR ENTER VARIABLE TIME</b></td>';
                        required_drug += '<td class="prescription-border-left prescription-border-right remove-column"></td>';
                        required_drug += '<td class="prescription-border-left prescription-border-right"></td>';
                        for (j = 0; j < prescription_sheet_date.length; j++) {
                            required_drug += '<td class="cell-bg"></td>';
                        }
                    }
                    var required_val = updateRequiredPrescriptionList(required_value, i);
                    required_drug += '</tr></thead><tbody id="required-' + row_id + '" class="prescription-border-top ' + required_val[1] + '">';
                    required_drug += required_val[0];
                    required_drug += '</tbody>';
                }
                required_drug += '</table></div>';
                var once_only_intra = '<div class="page-break-always"></div>';
                var intravenous = '<div id="intravenous"><b>INTRAVENOUS INFUSION THERAPY</b><table class="page-break-inside">';
                intravenous += '<tr class="intravenous-list prescription-border-bottom">';
                intravenous += '<td class="text-center sno-width"><b>S.No</b></td>';
                intravenous += '<td class="text-center"><b>DATE</b></td>';
                intravenous += '<td class="text-center"><b>TIME</b></td>';
                intravenous += '<td class="text-center"><b>INTRAVENOUS<br/>FLUID</b></td>';
                intravenous += '<td class="text-center"><b>Volume</b></td>';
                intravenous += '<td class="text-center"><b>DRUG<br/>ADDED</b></td>';
                intravenous += '<td class="text-center"><b>DOSE</b></td>';
                intravenous += '<td class="text-center"><b>Rate<br/>(ml/hr)</b></td>';
                intravenous += '<td class="text-center"><b>Running<br/>Duration</b></td>';
                intravenous += '<td class="text-center"><b>Doctor\'s<br/>Initials</b></td>';
                intravenous += '<td class="text-center"><b>Batch<br/>Number</b></td>';
                intravenous += '<td class="text-center"><b>Status</b></td>';
                intravenous += '</tr>';
                for (i = intravenous_start1; i < intravenous_sheet_1; i++) {
                    var intravenous_value = typeof intravenous_list[i] !== "undefined" ? intravenous_list[i] : [];
                    var row_id = typeof intravenous_value.hdr_id !== "undefined" ? intravenous_value.hdr_id : i;
                    intravenous += '<tbody id="intravenous-' + row_id + '" class="prescription-border-top">';
                    intravenous += updateIntravenousPrescriptionList(intravenous_value, i);
                    intravenous += '</tbody>';
                }
                intravenous += '</table></div>';

                var entries_by = '';
                var temp_prescribed = [];
                var prescribed_info = JSON.parse(JSON.stringify(user_details));
                entries_by += '<table>';
                $.each(prescribed_info, function(key, value) {
                    var exists = false;
                    if (value != null) {
                        $.each(temp_prescribed, function(k, val2) {
                            if (value.user == val2.user) {
                                exists = true;
                            };
                        });
                        entries_by += (temp_prescribed.length % 3 == 0) ? '<tr>' : '';
                        if (exists == false && typeof value.user != "undefined" && value.user != "" && value.user != null) {
                            temp_prescribed.push(value);
                            entries_by += '<td><span>';
                            entries_by += value.initial;
                            entries_by += ' - ';
                            entries_by += value.name;
                            entries_by += '</span></td>';
                        }
                        entries_by += (temp_prescribed.length % 3 == 0) ? '</tr>' : '';
                    }
                });
                entries_by += '</table>';

                var basicdtl = '<div class="print-date pull-right mb-5"></div>';

                basicdtl += '<div class="basic-detail-container"><table class="mb-10"><thead class="basic-details"><tr><td><div class="max-width">SURNAME</div><div class="main-text max-width">&nbsp</div></td><td colspan="2"><div class="white-space-nowarp">PATIENT NAME</div><div class="main-text">{{$baby->BabyName}}</div></td><td><div class="max-width">{{ Lang::get("home.mrn") }}</div><div class="main-text max-width">{{$baby->BMrNo}}</div></td><td><div class="max-width">WEIGHT</div><div class="main-text max-width">{{$baby->BirthWeight}}</div></td><td class="vertical-align-top"><div class="white-space-nowarp">DRUG ALLERGIES</div><div class="main-text">{{@$baby->allegries != "" ? @$baby->allegries : "None"}}</div></td></tr><tr><td><div class="white-space-nowarp max-width">FIRST NAMES</div><div class="main-text max-width">&nbsp</div></td><td class="ip-number-content"><div class="max-width">{{ Lang::get("home.ip") }}</div>@if(isset($ip_details->ip_number))<div class="main-text white-space-nowarp max-width">{{$ip_details->ip_number}}</div>@else<div class="main-text max-width">&nbsp</div>@endif</td><td class="gender-content"><div class="max-width">SEX</div><div class="main-text max-width">{{$baby->Sex}}</div></td><td class="dob-content"><div class="white-space-nowarp max-width">DATE OF BIRTH</div><div class="main-text white-space-nowarp max-width">{{empty($baby->DOB) ? '' : date("d-m-Y",strtotime($baby->DOB))}}</div></td><td><div class="max-width">Sheet No.</div><div class="main-text">' + sheet_i + '</div></td><td rowspan="2" class="vertical-align-top"><div class="main-text prescribed-by">'+entries_by+'</div></td></tr><tr><td><div class="max-width">WARD</div><div class="main-text white-space-nowarp max-width">{{@$patient_bed_log->ward_name}} / {{@$patient_bed_log->room_no}} / {{@$patient_bed_log->bed_no}}</div></td><td colspan="3" class="main-text consultant-name"><div>CONSULTANT</div><div class="main-text">{{\SiteHelpers::get_doctors_name($baby->neonatal_consultant)}}</div></td><td><div class="white-space-nowarp max-width">Start Date</div><div class="main-text start-date white-space-nowarp max-width">&nbsp</div></td></tr></thead></table></div>';

                order_no_1 += basicdtl + regular_drug_1 + once_only + regular_drug_2 + once_only_2 + required_drug + once_only_intra + intravenous;

                order_no_2 += intravenous + once_only + regular_drug_2 + once_only_2 + required_drug + once_only_intra;

                var header_content = $('.header-content').html();

                order_no_2 += header_content + basicdtl + regular_drug_1;

                order_no_1 += '</div>';
                order_no_2 += '</div>';
            }

            tab_view += order_no_1;
            tab_view += '</div>';
            tab_view += '</div>';
            tab_view_2 += order_no_2;
            tab_view_2 += '</div>';
            tab_view_2 += '</div>';

            var prescription_detail_list = '<div class="prescription-print-sheet prescription-data-list">'+tab_view_2 + '</div>';
            $('#prescription-page-a3 .temp-row').html(prescription_detail_list);
            $('.print-date').html(from_date_picker + ' to ' + to_date_picker);

            $('#prescription-page .prescription-data-list').html(tab_view);
        }

        function updateRegularPrescriptionList(regular_value, sno = '') {
            var prescribed_date_list = pres_sheet_date;
            var id = typeof regular_value.hdr_id !== "undefined" ? regular_value.hdr_id : '';
            var brand_name = typeof regular_value.brand_name !== "undefined" ? regular_value.brand_name : '';
            var generic_pharmacological_name = typeof regular_value.generic_pharmacological_name !== "undefined" ? regular_value.generic_pharmacological_name : '';
            var drug_name = typeof brand_name !== "undefined" && brand_name != "" ? (brand_name + "/" + generic_pharmacological_name) : '';
            drug_name = drug_name.replace(/[/]/g, ' / ');
            drug_name = drug_name.replace(/[(]/g, ' ( ');
            drug_name = drug_name.replace(/[)]/g, ' ) ');
            var dose_val = (typeof regular_value.dose !== "undefined" && regular_value.dose != null) ? regular_value.dose : '';
            var alt_dose_val = (typeof regular_value.alt_dose !== "undefined" && regular_value.alt_dose != null) ? regular_value.alt_dose : '';
            var infusion_type = (typeof regular_value.infusion_type !== "undefined" && regular_value.infusion_type != null) ? regular_value.infusion_type : '';
            var oral_route = (typeof regular_value.oral_route !== "undefined" && regular_value.oral_route != null) ? regular_value.oral_route : '';
            var creamicon = '';
            if (oral_route == '') {
                var dose_units_g = (typeof regular_value.dose_units_g !== "undefined" && regular_value.dose_units_g != null) ? unit_grams[regular_value.dose_units_g] : '';
                var alt_dose_units_g = (typeof regular_value.alt_dose_units_g !== "undefined" && regular_value.alt_dose_units_g != null) ? unit_grams[regular_value.alt_dose_units_g] : '';
            } else {
                var dose_units_g = (typeof regular_value.dose_units_g !== "undefined" && regular_value.dose_units_g != null) ? unit_grams_oral[regular_value.dose_units_g] : '';
                var alt_dose_units_g = (typeof regular_value.alt_dose_units_g !== "undefined" && regular_value.alt_dose_units_g != null) ? unit_grams_oral[regular_value.alt_dose_units_g] : '';
                if (dose_units_g == 'topical' || alt_dose_units_g == 'topical') {
                    creamicon = '<i class="fas fa-highlighter"></i>';
                }
                infusion_type = oral_route;
            }
            var dose = (typeof dose_val !== "undefined" && dose_val != '' && dose_val != null && dose_val > 0) ? (dose_val + " " + dose_units_g) : '';
            var altdose = (typeof alt_dose_val !== "undefined" && alt_dose_val != '' && alt_dose_val != null && alt_dose_val > 0) ? (alt_dose_val + " " + alt_dose_units_g) : '';
            if (dose != '' && altdose != '') {
                var dose = dose + ' / ' + altdose;
            } else if (dose != '') {
                var dose = dose;
            } else if (altdose != '') {
                var dose = altdose;
            } else {
                var dose = '';
            }
            var start_date = typeof regular_value.start_date !== "undefined" ? regular_value.start_date : '';
            var review_date = typeof regular_value.review_date !== "undefined" ? regular_value.review_date : '';
            var prescription_date = typeof regular_value.prescription_date !== "undefined" ? regular_value.prescription_date : '';
            var instruction = typeof regular_value.instruction !== "undefined" ? regular_value.instruction : '';
            var created_user = typeof regular_value.hdr_created_user !== "undefined" && regular_value.hdr_created_user !== null ? regular_value.hdr_created_user : '';
            var frequency = (typeof regular_value.frequency !== "undefined" && regular_value.frequency != null) ? regular_value.frequency : '';
            var terminate = typeof regular_value.terminate !== "undefined" ? regular_value.terminate : '';
            var terminateorder = '';
            if (start_date != '') {
                start_date = start_date.replace(/\s/, 'T');
                var date = new Date(start_date);
                start_date = ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '/' + (((date.getMonth() + 1) > 9) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '/' + date.getFullYear();
                var drug_start_date = date;
            }
            if (review_date != '') {
                review_date = review_date.replace(/\s/, 'T');
                var date = new Date(review_date);
                review_date = ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '/' + (((date.getMonth() + 1) > 9) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '/' + date.getFullYear();
            }
            if (prescription_date != '') {
                prescription_date = prescription_date.replace(/\s/, 'T');
                var date = new Date(prescription_date);
                prescription_date = ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '/' + (((date.getMonth() + 1) > 9) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '/' + date.getFullYear();
            }
            var pres_detail = regular_value.pres_dtl;
            var event_time = [];
            var eventtime = [];
            if (typeof pres_detail !== "undefined") {
                $.each(pres_detail, function(pres_key, pres_value) {
                    $.each(pres_value, function(key, value) {
                        event_time.push(key);
                    });
                });
            }
            $.each(event_time, function(i, el) {
                if ($.inArray(el, eventtime) === -1) eventtime.push(el);
            });
            eventtime.sort();
            if (eventtime.length > 0) {
                for (i = 0; i < 6; i++) {
                    var pres_value;
                    if (eventtime.length == 2 && i == 1) {
                        eventtime[2] = eventtime[i];
                        pres_value = '';
                    } else {
                        pres_value = eventtime[i];
                    }
                    var regular_info = '';
                    regular_info += '<td class="width-10 text-center time-font prescription-border-left prescription-border-right"><b>' + (typeof pres_value != 'undefined' ? pres_value : '') + '</b></td>';
                    var empty_regular_info = '<td class="width-10 text-center time-font prescription-border-left prescription-border-right"></td>';
                    var terminatecolor = '';
                    for (j = 0; j < prescribed_date_list.length; j++) {
                        var time_info = status_icon = started_date = stopped_date = started_user_initial_img = stopped_user_initial_img = '';
                        var pdate = prescribed_date_list[j].split('-');
                        var terminate_datetime;
                        if (terminate != null) {
                            terminate_datetime = terminate.split('-');
                            terminate_year = terminate_datetime[0];
                            terminate_month = terminate_datetime[1];
                            terminate_date = terminate_datetime[2].split(' ');
                            terminate_hour = terminate_date[1].split(':')[0];
                            terminate_date = terminate_datetime[2].split(' ')[0];
                            var terminate_datetime = new Date(terminate_year, (terminate_month - 1), terminate_date, terminate_hour);
                            var event_time = new Date(pdate[2], (pdate[0] - 1), pdate[1], pres_value);
                            if (event_time >= terminate_datetime && event_time >= drug_start_date) {
                                $('#regular-' + id).addClass('terminate-prescription');
                                var terminateorder = 'terminate-prescription';
                                terminatecolor = 'terminate-bg';
                            } else {
                                terminatecolor = '';
                            }
                            var terminate_bg = '<td class="cancelled_icon"><img src="{{$site_url}}/img/cancelled-stamp.png" alt="Cancelled By" class="cancelled_icon" /></td>';
                        } else {
                            var terminate_bg = '<td></td>';
                        }
                        if (typeof prescribed_date_list[j] !== "undefined") {
                            prescribeddate = prescribed_date_list[j].split('-');
                            var date = new Date(prescribeddate[2], (prescribeddate[0] - 1), prescribeddate[1]);
                            var strDate = ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '-' + (((date.getMonth() + 1) > 9) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '-' + date.getFullYear();
                            if (typeof pres_detail !== "undefined" && typeof pres_detail[strDate] != "undefined" && typeof pres_detail[strDate][pres_value] != "undefined" && typeof pres_detail[strDate][pres_value][0] !== "undefined") {
                                time_info = pres_detail[strDate][pres_value][0];
                                var send_status = time_info.is_send;
                                var confirm_date = (time_info.modified_started_date != null && typeof time_info.modified_started_date != 'undefined') ? time_info.modified_started_date : time_info.started_date;
                                var confirm_user = (time_info.modified_started_user != null && typeof time_info.modified_started_user != 'undefined') ? time_info.modified_started_user : time_info.started_user;
                                if (confirm_user != null) {
                                    if (user_initial[confirm_user] != null) {
                                        started_user_initial_img = '<img src="{{ $site_url }}/img/users/' + user_initial[confirm_user] + '" alt="Started By" />';
                                    } else {
                                        started_user_initial_img = started_user_initial_img_alt;
                                    }
                                    if (confirm_user && started_user_initial_img != '' && user_data[confirm_user] != '') {
                                        user_details.push({
                                            user: confirm_user,
                                            initial: started_user_initial_img,
                                            name: user_data[confirm_user]
                                        });
                                    }
                                    started_date = confirm_date;
                                    if (started_date != '' && started_date != null) {
                                        started_date = started_date.replace(/\s/, 'T');
                                        var date = new Date(started_date);
                                        var drug_started = date;
                                        var hours = date.getHours() > 9 ? date.getHours() : ('0' + date.getHours());
                                        var minutes = date.getMinutes() > 9 ? date.getMinutes() : ('0' + date.getMinutes());
                                        started_date = hours + ':' + minutes;
                                        var start_date_only = ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '-' + (((date.getMonth() + 1) > 9) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '-' + date.getFullYear();
                                    }
                                }
                                var stopby_user = (time_info.modified_stopped_user != null && typeof time_info.modified_stopped_user != 'undefined') ? time_info.modified_stopped_user : time_info.stopped_user;
                                if (stopby_user != null && send_status == 20) {
                                    if (user_initial[stopby_user] != null) {
                                        stopped_user_initial_img = '<img src="{{ $site_url }}/img/users/' + user_initial[stopby_user] + '" alt="Stopped By" />';
                                    } else {
                                        stopped_user_initial_img = stopped_user_initial_img_alt;
                                    }
                                    if (stopby_user != '' && stopped_user_initial_img != '' && user_data[stopby_user] != '') {
                                        user_details.push({
                                            user: stopby_user,
                                            initial: stopped_user_initial_img,
                                            name: user_data[stopby_user]
                                        });
                                    }
                                    stopped_date = (time_info.modified_stopped_date != null && typeof time_info.modified_stopped_date != 'undefined') ? time_info.modified_stopped_date : time_info.stopped_date;
                                    if (stopped_date != '' && stopped_date != null) {
                                        stopped_date = stopped_date.replace(/\s/, 'T');
                                        var date = new Date(stopped_date);
                                        var hours = date.getHours() > 9 ? date.getHours() : ('0' + date.getHours());
                                        var minutes = date.getMinutes() > 9 ? date.getMinutes() : ('0' + date.getMinutes());
                                        var stop_date_month = ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '-' + (((date.getMonth() + 1) > 9) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1)));
                                        var stop_date_only = ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '-' + (((date.getMonth() + 1) > 9) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '-' + date.getFullYear();

                                        if (started_date != '' && started_date != null) {
                                            // if (start_date_only != stop_date_only) {
                                            //     stopped_date = stop_date_month + ' ' + hours + ':' + minutes;
                                            // } else {
                                                stopped_date = hours + ':' + minutes;
                                            // }
                                        } else {
                                            stopped_date = hours + ':' + minutes;
                                        }
                                    }
                                }
                                cancelled_user = (time_info.modified_cancelled_user != null && typeof time_info.modified_cancelled_user != 'undefined') ? time_info.modified_cancelled_user : time_info.cancelled_user;
                                if (cancelled_user != null) {
                                    if (user_initial[cancelled_user] != null) {
                                        stopped_user_initial_img = '<img src="{{ $site_url }}/img/users/' + user_initial[cancelled_user] + '" alt="Cancelled By" />';
                                    } else {
                                        stopped_user_initial_img = cancelled_user_initial_img_alt;
                                    }
                                    if (cancelled_user != '' && stopped_user_initial_img != '' && user_data[cancelled_user] != '') {
                                        user_details.push({
                                            user: cancelled_user,
                                            initial: stopped_user_initial_img,
                                            name: user_data[cancelled_user]
                                        });
                                    }
                                    stopped_date = (time_info.modified_cancel_datetime != null && typeof time_info.modified_cancel_datetime != 'undefined') ? time_info.modified_cancel_datetime : time_info.cancel_datetime;
                                    if (stopped_date != '' && stopped_date != null) {
                                        stopped_date = stopped_date.replace(/\s/, 'T');
                                        var date = new Date(stopped_date);
                                        var hours = date.getHours() > 9 ? date.getHours() : ('0' + date.getHours());
                                        var minutes = date.getMinutes() > 9 ? date.getMinutes() : ('0' + date.getMinutes());
                                        var stop_date_month = ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '-' + (((date.getMonth() + 1) > 9) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1)));
                                        var stop_date_only = ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '-' + (((date.getMonth() + 1) > 9) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '-' + date.getFullYear();

                                        if (started_date != '' && started_date != null) {
                                            // if (start_date_only != stop_date_only) {
                                            //     stopped_date = stop_date_month + ' ' + hours + ':' + minutes;
                                            // } else {
                                                stopped_date = hours + ':' + minutes;
                                            // }
                                        } else {
                                            stopped_date = hours + ':' + minutes;
                                        }

                                    }
                                }
                                if (started_user_initial_img != '' && stopped_user_initial_img == '') {
                                    regular_info += '<td class="cell-bg user-info-cell text-center prescribed-info-td drug-id-' + time_info.dtl_id + '" data-pres="' + time_info.dtl_id + '" data-advice-id="' + time_info.prescription_id + '"><table><tbody><tr><td class="prescribed-info-border prescribed-info-border-bottom">' + started_user_initial_img + '</td><td class="prescribed-info-border-bottom"></td></tr><tr><td class="prescribed-info-border confirm-date">' + started_date + '</td><td></td></tr></tbody></table></td>';
                                } else if (started_user_initial_img != '' && stopped_user_initial_img != '') {
                                    regular_info += '<td class="cell-bg user-info-cell text-center prescribed-info-td drug-id-' + time_info.dtl_id + '" data-pres="' + time_info.dtl_id + '" data-advice-id="' + time_info.prescription_id + '"><table><tbody><tr><td class="prescribed-info-border prescribed-info-border-bottom">' + started_user_initial_img + '</td><td class="prescribed-info-border-bottom">' + stopped_user_initial_img + '</td></tr><tr><td class="prescribed-info-border confirm-date">' + started_date + '</td><td class="stop-date">' + stopped_date + '</td></tr></tbody></table></td>';
                                } else if (stopped_user_initial_img != '') {
                                    regular_info += '<td class="cell-bg user-info-cell text-center prescribed-info-td drug-id-' + time_info.dtl_id + '" data-pres="' + time_info.dtl_id + '" data-advice-id="' + time_info.prescription_id + '"><table><tbody><tr><td class="prescribed-info-border-bottom">' + stopped_user_initial_img + '</td></tr><tr><td class="stop-date">' + stopped_date + '</td></tr></tbody></table></td>';
                                } else {
                                    regular_info += '<td class="cell-bg user-info-cell text-center prescribed-info-td drug-id-' + time_info.dtl_id + ' ' + terminatecolor + '" data-pres="' + time_info.dtl_id + '" data-advice-id="' + time_info.prescription_id + '"></td>';
                                }
                            } else {
                                regular_info += '<td class="prescription-empty cell-bg user-info-cell ' + pres_value + ':0 ' + terminatecolor + '">&nbsp</td>';
                            }
                        } else {
                            regular_info += '<td class="prescription-empty cell-bg user-info-cell ' + pres_value + ':0 ' + terminatecolor + '">&nbsp</td>';
                        }
                        empty_regular_info += '<td class="prescription-empty cell-bg user-info-cell 0:0 ' + terminatecolor + '">&nbsp</td>';
                    }
                    var regular_info1, regular_info2, regular_info3, regular_info4, regular_info5, regular_info6;
                    if (jQuery.inArray(pres_value, ['00', '01', '02', '03']) !== -1) {
                        regular_info1 = regular_info;
                    }
                    if (jQuery.inArray(pres_value, ['04', '05', '06', '07']) !== -1) {
                        regular_info2 = regular_info;
                    }
                    if (jQuery.inArray(pres_value, ['08', '09', '10', '11']) !== -1) {
                        regular_info3 = regular_info;
                    }
                    if (jQuery.inArray(pres_value, ['12', '13', '14', '15']) !== -1) {
                        regular_info4 = regular_info;
                    }
                    if (jQuery.inArray(pres_value, ['16', '17', '18', '19']) !== -1) {
                        regular_info5 = regular_info;
                    }
                    if (jQuery.inArray(pres_value, ['20', '21', '22', '23']) !== -1) {
                        regular_info6 = regular_info;
                    }
                }
                var regular_data = '<tr><td rowspan="6" class="text-center sno-width">' + (sno + 1) + '</td><td colspan="4" class="cell-align"><span class="hide">' + id + '</span><span>Drug Name &nbsp</span><span class="main-text cell-align-spacing">' + drug_name + '</span></td>' + ((regular_info1 != '' && typeof regular_info1 != 'undefined') ? regular_info1 : empty_regular_info) + '</tr>';
                regular_data += '<tr><td class="dose-cell cell-align"><span>Dose</span><div class="main-text white-space-nowarp">' + dose + '</div></td><td class="route-cell cell-align"><span>Route</span><div class="main-text">' + infusion_type + '</div></td><td class="start-cell cell-align"><span class="avoid-wrap">Start Date</span><div class="avoid-wrap main-text">' + start_date + '</div></td><td class="cell-align"><span class="avoid-wrap">Review Date</span><div class="avoid-wrap main-text">' + review_date + '</div></td>' + ((regular_info2 != '' && typeof regular_info2 != 'undefined') ? regular_info2 : empty_regular_info) + '</tr>';
                if (created_user != '') {
                    if (user_sign[created_user] != null) {
                        var usersign = '<img src="{{ $site_url }}/img/users/' + user_sign[created_user] + '" alt="Prescribed By" class="user-sign" />';
                    } else {
                        var usersign = prescribed_img_alt;
                    }
                }
                regular_data += '<tr><td colspan="3" class="cell-align"><div class="sign-align-div"><span>Signature&nbsp<span>' + usersign + '&nbsp<span class="avoid-wrap"><b>' + prescription_date + '</b></span></span></span></div></td>' + terminate_bg + ((regular_info3 != '' && typeof regular_info3 != 'undefined') ? regular_info3 : empty_regular_info) + '</tr>';
                regular_data += '<tr><td class="cell-align" colspan="3" rowspan="3"><div>Additional Instructions</div><div class="main-text">' + instruction + '</div></td><td class="cell-align" rowspan="3">Frequency<div class="main-text">' + frequency + '</div></td>' + ((regular_info4 != '' && typeof regular_info4 != 'undefined') ? regular_info4 : empty_regular_info) + '</tr>';
                regular_data += '<tr>' + ((regular_info5 != '' && typeof regular_info5 != 'undefined') ? regular_info5 : empty_regular_info) + '</tr>';
                regular_data += '<tr>' + ((regular_info6 != '' && typeof regular_info6 != 'undefined') ? regular_info6 : empty_regular_info) + '</tr>';
            } else {
                for (k = 0; k < 6; k++) {
                    switch (k) {
                        case 0:
                        var regular_data = '<tr><td rowspan="6" class="text-center sno-width">' + (sno + 1) + '</td><td colspan="4"><span class="hide">' + id + '</span><span>Drug Name &nbsp</span><span class="main-text">' + drug_name + '</span></td>';
                        break;
                        case 1:
                        regular_data += '<tr><td><span>Dose</span><div class="main-text white-space-nowarp">' + dose + '</div></td><td><span>Route</span><div class="main-text">' + infusion_type + '</div></td><td><span class="avoid-wrap">Start Date</span><div class="avoid-wrap main-text">' + start_date + '</div></td><td><span class="avoid-wrap">Review Date</span><div class="avoid-wrap main-text">' + review_date + '</div></td>';
                        break;
                        case 2:
                        regular_data += '<tr><td colspan="3"><span>Signature</span><span>&nbsp</span><span class="avoid-wrap main-text">' + prescription_date + '</span></td><td></td>';
                        break;
                        case 3:
                        regular_data += '<tr><td colspan="3" rowspan="3" class="vertical-align-top"><div>Additional Instructions</div><div class="main-text">' + instruction + '</div></td><td class="vertical-align-top" rowspan="3">Frequency<div class="main-text">' + frequency + '</div></td>';
                        break;
                    }
                    for (j = 0; j < prescribed_date_list.length + 1; j++) {
                        if (j == 0) {
                            regular_data += '<td class="prescription-empty ' + j + ':0 prescription-border-left prescription-border-right">&nbsp</td>';
                        } else {
                            regular_data += '<td class="cell-bg prescription-empty ' + j + ':0">&nbsp</td>';
                        }
                    }
                    regular_data += '</tr>';
                }
            }
            return [regular_data, terminateorder];
        }

        function updateRequiredPrescriptionList(required_value, sno = '') {
            var prescribed_date_list = pres_sheet_date;
            var id = typeof required_value.hdr_id !== "undefined" ? required_value.hdr_id : '';
            var brand_name = typeof required_value.brand_name !== "undefined" ? required_value.brand_name : '';
            var generic_pharmacological_name = typeof required_value.generic_pharmacological_name !== "undefined" ? required_value.generic_pharmacological_name : '';
            var drug_name = typeof brand_name !== "undefined" && brand_name != "" ? (brand_name + "/" + generic_pharmacological_name) : '';
            drug_name = drug_name.replace(/[/]/g, ' / ');
            drug_name = drug_name.replace(/[(]/g, ' ( ');
            drug_name = drug_name.replace(/[)]/g, ' ) ');
            var dose_val = (typeof required_value.dose !== "undefined" && required_value.dose != null) ? required_value.dose : '';
            var alt_dose_val = (typeof required_value.alt_dose !== "undefined" && required_value.alt_dose != null) ? required_value.alt_dose : '';
            var oral_route = (typeof required_value.oral_route !== "undefined" && required_value.oral_route != null) ? required_value.oral_route : '';
            var infusion_type = (typeof required_value.infusion_type !== "undefined" && required_value.infusion_type != null) ? required_value.infusion_type : '';
            var creamicon = '';
            if (oral_route != '') {
                var dose_units_g = (typeof required_value.dose_units_g !== "undefined" && required_value.dose_units_g != null) ? unit_grams_oral[required_value.dose_units_g] : '';
                var alt_dose_units_g = (typeof required_value.alt_dose_units_g !== "undefined" && required_value.alt_dose_units_g != null) ? unit_grams_oral[required_value.alt_dose_units_g] : '';
                if (dose_units_g == 'topical' || alt_dose_units_g == 'topical') {
                    creamicon = '<i class="fas fa-highlighter"></i>';
                }
            } else {
                var dose_units_g = (typeof required_value.dose_units_g !== "undefined" && required_value.dose_units_g != null) ? unit_grams[required_value.dose_units_g] : '';
                var alt_dose_units_g = (typeof required_value.alt_dose_units_g !== "undefined" && required_value.alt_dose_units_g != null) ? unit_grams[required_value.alt_dose_units_g] : '';
                oral_route = infusion_type;
            }
            var dose = (typeof dose_val !== "undefined" && dose_val != '' && dose_val != null && dose_val > 0) ? (dose_val + " " + dose_units_g) : '';
            var altdose = (typeof alt_dose_val !== "undefined" && alt_dose_val != '' && alt_dose_val != null && alt_dose_val > 0) ? (alt_dose_val + " " + alt_dose_units_g) : '';
            if (dose != '' && altdose != '') {
                var dose = dose + ' / ' + altdose;
            } else if (dose != '') {
                var dose = dose;
            } else if (altdose != '') {
                var dose = altdose;
            } else {
                var dose = '';
            }
            var frequency = typeof required_value.frequency !== "undefined" ? required_value.frequency : '';
            var oral_route = (typeof required_value.oral_route !== "undefined" && required_value.oral_route != null) ? required_value.oral_route : '';
            var instruction = typeof required_value.instruction !== "undefined" ? required_value.instruction : '';
            var start_date = typeof required_value.start_date !== "undefined" ? required_value.start_date : '';
            var review_date = typeof required_value.review_date !== "undefined" ? required_value.review_date : '';
            var prescription_date = typeof required_value.prescription_date !== "undefined" ? required_value.prescription_date : '';
            var created_user = typeof required_value.hdr_created_user !== "undefined" && required_value.hdr_created_user !== null ? required_value.hdr_created_user : '';
            var terminate = typeof required_value.terminate !== "undefined" ? required_value.terminate : '';
            var terminateorder = '';
            if (start_date != '') {
                start_date = start_date.replace(/\s/, 'T');
                var date = new Date(start_date);
                start_date = ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '/' + (((date.getMonth() + 1) > 9) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '/' + date.getFullYear();
                var drug_start_date = date;
            }
            if (review_date != '') {
                review_date = review_date.replace(/\s/, 'T');
                var date = new Date(review_date);
                review_date = ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '/' + (((date.getMonth() + 1) > 9) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '/' + date.getFullYear();
            }
            if (prescription_date != '') {
                prescription_date = prescription_date.replace(/\s/, 'T');
                var date = new Date(prescription_date);
                prescription_date = ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '/' + (((date.getMonth() + 1) > 9) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '/' + date.getFullYear();
            }
            var required_date = required_time = required_dose_route = required_dose_by = '';
            var pres_detail = required_value.pres_dtl;
            var event_time = [];
            var eventtime = [];
            if (typeof pres_detail !== "undefined") {
                $.each(pres_detail, function(pres_key, pres_value) {
                    $.each(pres_value, function(key, value) {
                        event_time.push(key);
                    });
                });
            }
            $.each(event_time, function(i, el) {
                if ($.inArray(el, eventtime) === -1) eventtime.push(el);
            });
            eventtime.sort();
            if (eventtime.length > 0) {
                for (i = 0; i < 6; i++) {
                    var pres_value;
                    if (eventtime.length == 2 && i == 1) {
                        eventtime[2] = eventtime[i];
                        pres_value = '';
                    } else {
                        pres_value = eventtime[i];
                    }
                    var required_info = '';
                    required_info += '<td class="width-10 text-center time-font prescription-border-left prescription-border-right"><b>' + (typeof pres_value != 'undefined' ? pres_value : '') + '</b></td>';
                    var empty_required_info = '<td class="width-10 text-center time-font prescription-border-left prescription-border-right"></td>';
                    var terminatecolor;
                    for (j = 0; j < prescribed_date_list.length; j++) {
                        var time_info = status_icon = started_date = stopped_date = started_user_initial_img = stopped_user_initial_img = '';
                        var pdate = prescribed_date_list[j].split('-');
                        var terminate_datetime;
                        if (terminate != null) {
                            terminate_datetime = terminate.split('-');
                            terminate_year = terminate_datetime[0];
                            terminate_month = terminate_datetime[1];
                            terminate_date = terminate_datetime[2].split(' ');
                            terminate_hour = terminate_date[1].split(':')[0];
                            terminate_date = terminate_datetime[2].split(' ')[0];
                            var terminate_datetime = new Date(terminate_year, (terminate_month - 1), terminate_date, terminate_hour);
                            var event_time = new Date(pdate[2], (pdate[0] - 1), pdate[1], pres_value);
                            if (event_time >= terminate_datetime && event_time >= drug_start_date) {
                                $('#required-' + id).addClass('terminate-prescription');
                                var terminateorder = 'terminate-prescription';
                                terminatecolor = 'terminate-bg';
                            } else {
                                terminatecolor = '';
                            }
                            var terminate_bg = '<td class="prescription-border-right cancelled_icon"><img src="{{$site_url}}/img/cancelled-stamp.png" alt="Cancelled By" class="cancelled_icon" /></td>';
                        } else {
                            var terminate_bg = '<td class="prescription-border-right"></td>';
                        }
                        if (typeof prescribed_date_list[j] !== "undefined") {
                            prescribeddate = prescribed_date_list[j].split('-');
                            var date = new Date(prescribeddate[2], (prescribeddate[0] - 1), prescribeddate[1]);
                            var strDate = ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '-' + (((date.getMonth() + 1) > 9) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '-' + date.getFullYear();
                            if (typeof pres_detail !== "undefined" && typeof pres_detail[strDate] != "undefined" && typeof pres_detail[strDate][pres_value] != "undefined" && typeof pres_detail[strDate][pres_value][0] !== "undefined") {
                                time_info = pres_detail[strDate][pres_value][0];
                                var send_status = time_info.is_send;
                                var confirm_date = (time_info.modified_started_date != null && typeof time_info.modified_started_date != 'undefined') ? time_info.modified_started_date : time_info.started_date;
                                var confirm_user = (time_info.modified_started_user != null && typeof time_info.modified_started_user != 'undefined') ? time_info.modified_started_user : time_info.started_user;
                                if (confirm_user != null) {
                                    if (user_initial[confirm_user] != null) {
                                        started_user_initial_img = '<img src="{{ $site_url }}/img/users/' + user_initial[confirm_user] + '" alt="Started By" />';
                                    } else {
                                        started_user_initial_img = started_user_initial_img_alt;
                                    }
                                    if (confirm_user != '' && started_user_initial_img != '' && user_data[confirm_user] != '') {
                                        user_details.push({
                                            user: confirm_user,
                                            initial: started_user_initial_img,
                                            name: user_data[confirm_user]
                                        });
                                    }
                                    started_date = confirm_date;
                                    if (started_date != '' && started_date != null) {
                                        started_date = started_date.replace(/\s/, 'T');
                                        var date = new Date(started_date);
                                        var drug_started = date;
                                        var hours = date.getHours() > 9 ? date.getHours() : ('0' + date.getHours());
                                        var minutes = date.getMinutes() > 9 ? date.getMinutes() : ('0' + date.getMinutes());
                                        started_date = hours + ':' + minutes;
                                        var start_date_only = ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '-' + (((date.getMonth() + 1) > 9) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '-' + date.getFullYear();
                                    }
                                }
                                var stopby_user = (time_info.modified_stopped_user != null && typeof time_info.modified_stopped_user != 'undefined') ? time_info.modified_stopped_user : time_info.stopped_user;
                                if (stopby_user != null && send_status == 20) {
                                    if (user_initial[stopby_user] != null) {
                                        stopped_user_initial_img = '<img src="{{ $site_url }}/img/users/' + user_initial[stopby_user] + '" alt="Stopped By" />';
                                    } else {
                                        stopped_user_initial_img = stopped_user_initial_img_alt;
                                    }
                                    if (stopby_user != '' && stopped_user_initial_img != '' && user_data[stopby_user] != '') {
                                        user_details.push({
                                            user: stopby_user,
                                            initial: stopped_user_initial_img,
                                            name: user_data[stopby_user]
                                        });
                                    }
                                    stopped_date = (time_info.modified_stopped_date != null && typeof time_info.modified_stopped_date != 'undefined') ? time_info.modified_stopped_date : time_info.stopped_date;
                                    if (stopped_date != '' && stopped_date != null) {
                                        stopped_date = stopped_date.replace(/\s/, 'T');
                                        var date = new Date(stopped_date);
                                        var hours = date.getHours() > 9 ? date.getHours() : ('0' + date.getHours());
                                        var minutes = date.getMinutes() > 9 ? date.getMinutes() : ('0' + date.getMinutes());
                                        var stop_date_month = ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '-' + (((date.getMonth() + 1) > 9) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1)));
                                        var stop_date_only = ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '-' + (((date.getMonth() + 1) > 9) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '-' + date.getFullYear();

                                        if (started_date != '' && started_date != null) {
                                            // if (start_date_only != stop_date_only) {
                                            //     stopped_date = stop_date_month + ' ' + hours + ':' + minutes;
                                            // } else {
                                                stopped_date = hours + ':' + minutes;
                                            // }
                                        } else {
                                            stopped_date = hours + ':' + minutes;
                                        }

                                    }
                                }
                                cancelled_user = (time_info.modified_cancelled_user != null && typeof time_info.modified_cancelled_user != 'undefined') ? time_info.modified_cancelled_user : time_info.cancelled_user;
                                if (cancelled_user != null) {
                                    if (user_initial[cancelled_user] != null) {
                                        stopped_user_initial_img = '<img src="{{ $site_url }}/img/users/' + user_initial[cancelled_user] + '" alt="Cancelled By" />';
                                    } else {
                                        stopped_user_initial_img = cancelled_user_initial_img_alt;
                                    }
                                    if (cancelled_user != '' && stopped_user_initial_img != '' && user_data[cancelled_user] != '') {
                                        user_details.push({
                                            user: cancelled_user,
                                            initial: stopped_user_initial_img,
                                            name: user_data[cancelled_user]
                                        });
                                    }
                                    stopped_date = (time_info.modified_cancel_datetime != null && typeof time_info.modified_cancel_datetime != 'undefined') ? time_info.modified_cancel_datetime : time_info.cancel_datetime;
                                    if (stopped_date != '' && stopped_date != null) {
                                        stopped_date = stopped_date.replace(/\s/, 'T');
                                        var date = new Date(stopped_date);
                                        var hours = date.getHours() > 9 ? date.getHours() : ('0' + date.getHours());
                                        var minutes = date.getMinutes() > 9 ? date.getMinutes() : ('0' + date.getMinutes());
                                        var stop_date_month = ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '-' + (((date.getMonth() + 1) > 9) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1)));
                                        var stop_date_only = ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '-' + (((date.getMonth() + 1) > 9) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '-' + date.getFullYear();
                                        var stop_date_only = stop_date_only.split('-');

                                        if (started_date != '' && started_date != null) {
                                            // if (start_date_only != stop_date_only) {
                                            //     stopped_date = stop_date_month + ' ' + hours + ':' + minutes;
                                            // } else {
                                                stopped_date = hours + ':' + minutes;
                                            // }
                                        } else {
                                            stopped_date = hours + ':' + minutes;
                                        }

                                    }
                                }
                                if (started_user_initial_img != '' && stopped_user_initial_img == '') {
                                    required_info += '<td class="cell-bg user-info-cell text-center prescribed-info-td drug-id-' + time_info.dtl_id + '" data-pres="' + time_info.dtl_id + '" data-advice-id="' + time_info.prescription_id + '"><table><tbody><tr><td class="prescribed-info-border prescribed-info-border-bottom">' + started_user_initial_img + '</td><td class="prescribed-info-border-bottom"></td></tr><tr><td class="prescribed-info-border confirm-date">' + started_date + '</td><td></td></tr></tbody></table></td>';
                                } else if (started_user_initial_img != '' && stopped_user_initial_img != '') {
                                    required_info += '<td class="cell-bg user-info-cell text-center prescribed-info-td drug-id-' + time_info.dtl_id + '" data-pres="' + time_info.dtl_id + '" data-advice-id="' + time_info.prescription_id + '"><table><tbody><tr><td class="prescribed-info-border prescribed-info-border-bottom">' + started_user_initial_img + '</td><td class="prescribed-info-border-bottom">' + stopped_user_initial_img + '</td></tr><tr><td class="prescribed-info-border confirm-date">' + started_date + '</td><td class="cancel-date">' + stopped_date + '</td></tr></tbody></table></td>';
                                } else if (stopped_user_initial_img != '') {
                                    required_info += '<td class="cell-bg user-info-cell text-center prescribed-info-td drug-id-' + time_info.dtl_id + '" data-pres="' + time_info.dtl_id + '" data-advice-id="' + time_info.prescription_id + '"><table><tbody><tr><td class="prescribed-info-border-bottom">' + stopped_user_initial_img + '</td></tr><tr><td class="cancel-date">' + stopped_date + '</td></tr></tbody></table></td>';
                                } else {
                                    required_info += '<td class="cell-bg user-info-cell text-center prescribed-info-td drug-id-' + time_info.dtl_id + ' ' + terminatecolor + '" data-pres="' + time_info.dtl_id + '" data-advice-id="' + time_info.prescription_id + '"></td>';
                                }
                            } else {
                                required_info += '<td class="prescription-empty cell-bg user-info-cell ' + pres_value + ':0 ' + terminatecolor + '">&nbsp</td>';
                            }
                        } else {
                            required_info += '<td class="prescription-empty cell-bg user-info-cell ' + pres_value + ':0 ' + terminatecolor + '">&nbsp</td>';
                        }
                        empty_required_info += '<td class="prescription-empty cell-bg user-info-cell ' + pres_value + ':0 ' + terminatecolor + '">&nbsp</td>';
                    }
                    var required_info1, required_info2, required_info3, required_info4, required_info5, required_info6;
                    if (jQuery.inArray(pres_value, ['00', '01', '02', '03']) !== -1) {
                        required_info1 = required_info;
                    }
                    if (jQuery.inArray(pres_value, ['04', '05', '06', '07']) !== -1) {
                        required_info2 = required_info;
                    }
                    if (jQuery.inArray(pres_value, ['08', '09', '10', '11']) !== -1) {
                        required_info3 = required_info;
                    }
                    if (jQuery.inArray(pres_value, ['12', '13', '14', '15']) !== -1) {
                        required_info4 = required_info;
                    }
                    if (jQuery.inArray(pres_value, ['16', '17', '18', '19']) !== -1) {
                        required_info5 = required_info;
                    }
                    if (jQuery.inArray(pres_value, ['20', '21', '22', '23']) !== -1) {
                        required_info6 = required_info;
                    }
                }
                var required_data = '<tr class="required-list prescription-border-top">';
                required_data += '<td rowspan="6" class="text-center sno-width">' + (sno + 1) + '</td><td colspan="4" class="prescription-border-right cell-align"><span class="hide">' + id + '</span><span class="pb-10">Drug Name &nbsp</span><span class="main-text cell-align-spacing">' + drug_name + '</span></td>';
                required_data += '<td class="prescription-border-right remove-column cell-align text-center">Date</td>' + ((required_info1 != '' && typeof required_info1 != 'undefined') ? required_info1 : empty_required_info) + '</tr>';
                required_data += '<tr class="required-list">';
                required_data += '<td class="cell-align"><span>Dose</span><div class="main-text white-space-nowarp">' + dose + '</div></td>';
                required_data += '<td class="cell-align"><span class="white-space-nowarp">Max. Frequency<br/><span class="main-text">' + frequency + '</span></span></td>';
                required_data += '<td class="cell-align"><span>Route</span><div class="main-text">' + oral_route + '</div></td>';
                required_data += '<td class="prescription-border-right cell-align"><span class="avoid-wrap">Start Date</span><div class="avoid-wrap main-text">' + start_date + '</div></td>';
                required_data += '<td class="prescription-border-right remove-column cell-align text-center">Time</td>' + ((required_info2 != '' && typeof required_info2 != 'undefined') ? required_info2 : empty_required_info) + '</tr>';
                if (created_user != '') {
                    if (user_sign[created_user] != null) {
                        var usersign = '<img src="{{ $site_url }}/img/users/' + user_sign[created_user] + '" alt="Created By" class="user-sign" />';
                    } else {
                        var usersign = prescribed_img_alt;
                    }
                }
                required_data += '<tr class="required-list">';
                required_data += '<td colspan="2" class="cell-align"><div class="sign-align-div"><span>Signature&nbsp<span>' + usersign + '&nbsp<span class="avoid-wrap"><b>' + prescription_date + '<b></span></span></span></div></td>';
                required_data += '<td class="cell-align"><div class="avoid-wrap">Review date</div><div class="avoid-wrap main-text">' + review_date + '</div></td>';
                required_data += terminate_bg;
                required_data += '<td class="remove-padding prescription-border-right remove-column"><div class="plr-5" style="padding-right: 30px">Dose</div><div class="cross-bottom"></div><div class="pull-right plr-5" style="padding-left: 30px">Route</div></td>' + ((required_info3 != '' && typeof required_info3 != 'undefined') ? required_info3 : empty_required_info) + '</tr>';
                required_data += '<tr class="prescription-border-right required-list">';
                required_data += '<td colspan="4" rowspan="3" class="prescription-border-right cell-align" style="padding-top: 0px; padding-bottom: 0px;"><div>Additional Instructions</div><div class="main-text">' + instruction + '</div></td>';
                required_data += '<td rowspan="3" class="prescription-border-right cell-align remove-column" style="padding-top: 0px; padding-bottom: 0px;"><div class="avoid-wrap">Given by</div><div>&nbsp</div></td>' + ((required_info4 != '' && typeof required_info4 != 'undefined') ? required_info4 : empty_required_info) + '</tr>';
                required_data += '<tr class="required-list">' + ((required_info5 != '' && typeof required_info5 != 'undefined') ? required_info5 : empty_required_info) + '</tr>';
                required_data += '<tr class="required-list">' + ((required_info6 != '' && typeof required_info6 != 'undefined') ? required_info6 : empty_required_info) + '</tr>';
            } else {
                for (k = 0; k < 6; k++) {
                    switch (k) {
                        case 0:
                        var required_data = '<tr class="required-list prescription-border-top">';
                        required_data += '<td rowspan="6" class="text-center sno-width">' + (sno + 1) + '</td><td colspan="4" class="prescription-border-right"><span class="hide">' + id + '</span><span class="pb-10">Drug Name &nbsp</span><span class="main-text">' + drug_name + '</span></td>';
                        required_data += '<td class="prescription-border-right remove-column">Date</td>';
                        break;
                        case 1:
                        required_data += '<tr class="required-list">';
                        required_data += '<td><span>Dose</span><div class="main-text white-space-nowarp">' + dose_val + '</div></td>';
                        required_data += '<td><span class="white-space-nowarp">Max. Frequency<span class="main-text">' + frequency + '</span></span></td>';
                        required_data += '<td><span>Route</span><div class="main-text">' + oral_route + '</div></td>';
                        required_data += '<td class="prescription-border-right"><span class="avoid-wrap">Start Date</span><div class="avoid-wrap main-text">' + start_date + '</div></td>';
                        required_data += '<td class="prescription-border-right remove-column">Time</td>';
                        break;
                        case 2:
                        required_data += '<tr class="required-list">';
                        required_data += '<td colspan="2"><span>Signature</span><span>&nbsp</span><span class="avoid-wrap main-text">' + prescription_date + '</span></td>';
                        required_data += '<td><div class="avoid-wrap">Review date</div><div class="avoid-wrap main-text">' + review_date + '</div></td>';
                        required_data += '<td class="prescription-border-right"></td>';
                        required_data += '<td class="remove-padding prescription-border-right remove-column"><div class="plr-5" style="padding-right: 30px">Dose</div><div class="cross-bottom"></div><div class="pull-right plr-5" style="padding-left: 30px">Route</div></td>';
                        break;
                        case 3:
                        required_data += '<tr class="prescription-border-right required-list">';
                        required_data += '<td rowspan="3" class="prescription-border-right vertical-align-top" colspan="4" style="padding-top: 0px; padding-bottom: 0px;"><div>Additional Instructions</div><div class="main-text">' + instruction + '</div></td>';
                        required_data += '<td rowspan="3" class="prescription-border-right vertical-align-top remove-column" style="padding-top: 0px; padding-bottom: 0px;"><div class="avoid-wrap">Given by</div><div>&nbsp</div></td>';
                        break;
                    }
                    for (j = 0; j < prescribed_date_list.length + 1; j++) {
                        if (j == 0) {
                            required_data += '<td class="prescription-empty ' + j + ':0 prescription-border-right">&nbsp</td>';
                        } else {
                            required_data += '<td class="cell-bg prescription-empty ' + j + ':0">&nbsp</td>';
                        }
                    }
                    required_data += '</tr>';
                }
            }
            return [required_data, terminateorder];
        }

        function updateIntravenousPrescriptionList(intravenous_value, i = 0) {
            var id = typeof intravenous_value.hdr_id !== "undefined" ? intravenous_value.hdr_id : '';
            var brand_name = typeof intravenous_value.brand_name !== "undefined" ? intravenous_value.brand_name : '';
            var generic_pharmacological_name = typeof intravenous_value.generic_pharmacological_name !== "undefined" ? intravenous_value.generic_pharmacological_name : '';
            var drug_name = typeof brand_name !== "undefined" && brand_name != '' ? (brand_name + '/' + generic_pharmacological_name) : '';
            drug_name = drug_name.replace(/[/]/g, ' / ');
            drug_name = drug_name.replace(/[(]/g, ' ( ');
            drug_name = drug_name.replace(/[)]/g, ' ) ');
            var dose_val = (typeof intravenous_value.dose !== "undefined" && intravenous_value.dose != null && intravenous_value.dose > 0) ? intravenous_value.dose : '';
            var dose_units_g = (typeof intravenous_value.dose_units_g !== "undefined" && intravenous_value.dose_units_g != null) ? unit_grams[intravenous_value.dose_units_g] : '';
            var dose_units_kg = (typeof intravenous_value.dose_units_kg !== "undefined" && intravenous_value.dose_units_kg != null) ? unit_kg[intravenous_value.dose_units_kg] : '';
            var dose_units_time = (typeof intravenous_value.dose_units_time !== "undefined" && intravenous_value.dose_units_time != null) ? duration_type[intravenous_value.dose_units_time] : '';
            var dose = '';
            if (dose_val != '') {
                dose = dose_val + ' ' + dose_units_g + '/' + dose_units_kg + '/' + dose_units_time;
            }
            var qty = (typeof intravenous_value.quantity !== "undefined" && intravenous_value.quantity != null) ? intravenous_value.quantity : '';
            var qtyunit = (typeof intravenous_value.quantity_units !== "undefined" && intravenous_value.quantity_units != null) ? intravenous_value.quantity_units : '';
            var qty_values = '';
            if (qty != '' && qty_unit != '') {
                qty_values = ' ( ' + qty + ' ' + qty_unit[qtyunit] + ' )';
            }
            var rate = (typeof intravenous_value.rate !== "undefined" && intravenous_value.rate != '' && intravenous_value.rate != null && intravenous_value.rate > 0) ? intravenous_value.rate : '';
            var infusion_type = typeof intravenous_value.infusion_type !== "undefined" ? intravenous_value.infusion_type : '';
            var start_date = (typeof intravenous_value.start_date !== "undefined" && intravenous_value.start_date != null) ? intravenous_value.start_date : '';
            var review_date = typeof intravenous_value.review_date ? intravenous_value.review_date : '';
            var prescription_date = typeof intravenous_value.prescription_date !== "undefined" ? intravenous_value.prescription_date : '';
            var prescription_time = typeof intravenous_value.prescription_date !== "undefined" ? intravenous_value.prescription_date : '';
            var instruction = typeof intravenous_value.instruction !== "undefined" ? intravenous_value.instruction : '';
            var drug_added = (typeof intravenous_value.drug_added !== "undefined" && intravenous_value.drug_added != null) ? intravenous_value.drug_added : '';
            var dose_feq_addition = (typeof intravenous_value.dose_feq_addition !== "undefined" && intravenous_value.dose_feq_addition != null && intravenous_value.dose_feq_addition != '') ? intravenous_value.dose_feq_addition : '';
            var batch_no = (typeof intravenous_value.batch_no !== "undefined" && intravenous_value.batch_no != null) ? intravenous_value.batch_no : '';
            var prescribed_by = (typeof intravenous_value.prescribed_by !== "undefined" && intravenous_value.prescribed_by != null) ? intravenous_value.prescribed_by : '';
            var created_user = typeof intravenous_value.hdr_created_user !== "undefined" && intravenous_value.hdr_created_user !== null ? intravenous_value.hdr_created_user : '';
            var instruction = typeof intravenous_value.instruction ? intravenous_value.instruction : '';
            var drug_add_freq = '';
            if (drug_added != '' && dose_feq_addition != '') {
                drug_add_freq = drug_added + ', ' + dose_feq_addition;
            } else if (drug_added != '') {
                drug_add_freq = drug_added;
            } else if (dose_feq_addition != '') {
                drug_add_freq = dose_feq_addition;
            }
            if (start_date != '') {
                var start_time = start_date.replace(/\s/, 'T');
                var date = new Date(start_time);
                var hours = date.getHours() > 9 ? date.getHours() : ('0' + date.getHours());
                var minutes = date.getMinutes() > 9 ? date.getMinutes() : ('0' + date.getMinutes());
                var prescription_time = hours + ':' + minutes;
            } else if (prescription_time != '') {
                var start_time = prescription_time.replace(/\s/, 'T');
                var date = new Date(prescription_time);
                var hours = date.getHours() > 9 ? date.getHours() : ('0' + date.getHours());
                var minutes = date.getMinutes() > 9 ? date.getMinutes() : ('0' + date.getMinutes());
                var prescription_time = hours + ':' + minutes;
            }
            if (start_date != '' && start_date != null) {
                start_date = start_date.replace(/\s/, 'T');
                var date = new Date(start_date);
                var prescription_date = ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '/' + (((date.getMonth() + 1) > 9) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '/' + date.getFullYear();
            } else if (prescription_date != '' && prescription_date != null) {
                start_date = prescription_date.replace(/\s/, 'T');
                var date = new Date(prescription_date);
                var prescription_date = ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '/' + (((date.getMonth() + 1) > 9) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '/' + date.getFullYear();
            }
            var volume_val = (typeof intravenous_value.volume !== "undefined" && intravenous_value.volume != null && intravenous_value.volume > 0) ? intravenous_value.volume + " ml" : '';
            var syringe_size_val = (typeof intravenous_value.syringe_size !== "undefined" && intravenous_value.syringe_size != null) ? (intravenous_value.syringe_size + " ml") : '';
            if (volume_val != '' && syringe_size_val != '') {
                volume_val = volume_val + ',' + syringe_size_val;
            } else if (volume_val != '') {
                volume_val = volume_val;
            } else if (syringe_size_val != '') {
                volume_val = syringe_size_val;
            } else {
                volume_val = '';
            }
            var duration = (typeof intravenous_value.duration !== "undefined" && intravenous_value.duration != null && intravenous_value.duration > 0) ? intravenous_value.duration : "";
            if (duration != '') {
                duration = duration + " " + intravenous_value.duration_time;
            }
            var pres_detail = intravenous_value.pres_dtl;
            var started_date = stopped_date = cancel_datetime = userInitial = nurseInitial = '';
            var nurseInitial, startnurseInitial = '';
            if (typeof pres_detail !== "undefined" && Object.values(pres_detail).length > 0) {
                var values_intravenous = (Object.values(Object.values(pres_detail)[0])[0])[0];
                var time_info = values_intravenous;
                var send_status = time_info.is_send;
                started_date = (time_info.modified_started_date != null && typeof time_info.modified_started_date != 'undefined') ? time_info.modified_started_date : time_info.started_date;
                started_user = (time_info.modified_started_user != null && typeof time_info.modified_started_user != 'undefined') ? time_info.modified_started_user : time_info.started_user;
                stopped_date = (time_info.modified_stopped_date != null && typeof time_info.modified_stopped_date != 'undefined') ? time_info.modified_stopped_date : time_info.stopped_date;
                stopped_user = (time_info.modified_stopped_user != null && typeof time_info.modified_stopped_user != 'undefined') ? time_info.modified_stopped_user : time_info.stopped_user;
                cancel_datetime = (time_info.modified_cancel_datetime != null && typeof time_info.modified_cancel_datetime != 'undefined') ? time_info.modified_cancel_datetime : time_info.cancel_datetime;
                cancelled_user = (time_info.modified_cancelled_user != null && typeof time_info.modified_cancelled_user != 'undefined') ? time_info.modified_cancelled_user : time_info.cancelled_user;
                if (started_date == null) {
                    started_date = '';
                }
                if (stopped_date == null || send_status != 20) {
                    stopped_date = '';
                }
                if (cancel_datetime == null) {
                    cancel_datetime = '';
                }
                if (started_date != '' && started_date != null) {
                    started_date = started_date.replace(/\s/, 'T');
                    var date = new Date(started_date);
                    var drug_started = date;
                    var hours = date.getHours() > 9 ? date.getHours() : ('0' + date.getHours());
                    var minutes = date.getMinutes() > 9 ? date.getMinutes() : ('0' + date.getMinutes());
                    started_date = hours + ':' + minutes;
                    var start_date_only = ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '-' + (((date.getMonth() + 1) > 9) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '-' + date.getFullYear();
                    if (started_user != '' && started_user != null && user_initial[started_user] != null) {
                        startnurseInitial = '<img src="{{ $site_url }}/img/users/' + user_initial[started_user] + '" alt="Started By" />';
                    } else {
                        startnurseInitial = started_user_initial_img_alt;
                    }
                    var confirm_user = (time_info.modified_started_user != null && typeof time_info.modified_started_user != 'undefined') ? time_info.modified_started_user : time_info.started_user;
                    if (confirm_user != '' && startnurseInitial != '' && user_data[confirm_user] != '') {
                        user_details.push({
                            user: confirm_user,
                            initial: startnurseInitial,
                            name: user_data[confirm_user]
                        });
                    }
                }
                if (stopped_date != '' && stopped_date != null && send_status == 20) {
                    stopped_date = stopped_date.replace(/\s/, 'T');
                    var date = new Date(stopped_date);
                    var hours = date.getHours() > 9 ? date.getHours() : ('0' + date.getHours());
                    var minutes = date.getMinutes() > 9 ? date.getMinutes() : ('0' + date.getMinutes());
                    var stop_date_month = ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '-' + (((date.getMonth() + 1) > 9) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1)));

                    var stop_date_only = ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '-' + (((date.getMonth() + 1) > 9) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '-' + date.getFullYear();

                    if (started_date != '' && started_date != null) {
                        // if (start_date_only != stop_date_only) {
                        //     stopped_date = stop_date_month + ' ' + hours + ':' + minutes;
                        // } else {
                            stopped_date = hours + ':' + minutes;
                        // }
                    } else {
                        stopped_date = hours + ':' + minutes;
                    }

                    if (stopped_user != '' && stopped_user != null && user_initial[stopped_user] != null) {
                        nurseInitial = '<img src="{{ $site_url }}/img/users/' + user_initial[stopped_user] + '" alt="Stopped By" />';
                    } else {
                        nurseInitial = stopped_user_initial_img_alt;
                    }
                    var stopby_user = (time_info.modified_stopped_user != null && typeof time_info.modified_stopped_user != 'undefined') ? time_info.modified_stopped_user : time_info.stopped_user;
                    if (stopby_user != '' && nurseInitial != '' && user_data[stopby_user] != '') {
                        user_details.push({
                            initial: nurseInitial,
                            name: user_data[stopby_user]
                        });
                    }
                } else if (cancelled_user != '' && cancelled_user != null) {
                    cancel_datetime = cancel_datetime.replace(/\s/, 'T');
                    var date = new Date(cancel_datetime);
                    var hours = date.getHours() > 9 ? date.getHours() : ('0' + date.getHours());
                    var minutes = date.getMinutes() > 9 ? date.getMinutes() : ('0' + date.getMinutes());
                    var stop_date_month = ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '-' + (((date.getMonth() + 1) > 9) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1)));
                    var stop_date_only = ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '-' + (((date.getMonth() + 1) > 9) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '-' + date.getFullYear();
                    var stop_date_only = stop_date_only.split('-');

                    if (started_date != '' && started_date != null) {
                        // if (start_date_only != stop_date_only) {
                        //     stopped_date = stop_date_month + ' ' + hours + ':' + minutes;
                        // } else {
                            stopped_date = hours + ':' + minutes;
                        // }
                    } else {
                        stopped_date = hours + ':' + minutes;
                    }

                    if (cancelled_user != '' && cancelled_user != null && user_initial[cancelled_user] != null) {
                        nurseInitial = '<img src="{{ $site_url }}/img/users/' + user_initial[cancelled_user] + '" alt="Cancelled By" />';
                    } else {
                        nurseInitial = cancelled_user_initial_img_alt;
                    }
                    cancelled_user = (time_info.modified_cancelled_user != null && typeof time_info.modified_cancelled_user != 'undefined') ? time_info.modified_cancelled_user : time_info.cancelled_user;
                    if (cancelled_user != '' && nurseInitial != '' && user_data[cancelled_user] != '') {
                        user_details.push({
                            user: cancelled_user,
                            initial: nurseInitial,
                            name: user_data[cancelled_user]
                        });
                    }

                }
                if (created_user != '' && created_user != null && user_initial[created_user] != null) {
                    userInitial = '<img src="{{ $site_url }}/img/users/' + user_initial[created_user] + '" class="Created By" />';
                } else {
                    userInitial = '<img src="{{ $site_url }}/img/no-image.png" alt="Started By" class="alt-image" />';
                }
            }
            var intravenous_data = '';
            if (drug_name != '') {
                intravenous_data += '<tr class="intravenous-list intravenous-full">';
            } else {
                intravenous_data += '<tr class="intravenous-list intravenous-empty">';
            }
            intravenous_data += '<td class="text-center avoid-wrap main-text sno-width">' + (i + 1) + '</td>';
            intravenous_data += '<td class="text-center avoid-wrap main-text">' + prescription_date + '</td>';
            intravenous_data += '<td class="text-center avoid-wrap main-text">' + prescription_time + '</td>';
            intravenous_data += '<td class="text-center main-text">' + drug_name + '<div class="white-space-nowrap">' + qty_values + '</div>' + '<div class="additional-instruction"><b>' + (instruction != "" && instruction != undefined ? '(' + instruction + ')' : "") + '</b></div></td>';
            intravenous_data += '<td class="text-center main-text">' + volume_val + '</td>';
            intravenous_data += '<td class="text-center">' + drug_add_freq + '</td>';
            intravenous_data += '<td class="text-center main-text">' + dose + '</td>';
            intravenous_data += '<td class="text-center main-text">' + rate + '</td>';
            intravenous_data += '<td class="text-center main-text">' + duration + '</td>';
            intravenous_data += '<td class="text-center">' + userInitial + '</td>';
            intravenous_data += '<td class="text-center">' + batch_no + '</td>';
            if (started_date != '') {
                intravenous_data += '<td class="text-center prescribed-info-td intra-status"><table><tbody><tr><td class="prescribed-info-border prescribed-info-border-bottom">' + startnurseInitial + '</td><td class="prescribed-info-border-bottom">' + nurseInitial + '</td></tr><tr><td class="prescribed-info-border confirm-date">' + started_date + '</td><td class="stop-date">' + stopped_date + '</td></tr></tbody></table>';
            } else if (cancel_datetime != '') {
                intravenous_data += '<td class="text-center prescribed-info-td intra-status"><table><tbody><tr><td class="prescribed-info-border-bottom">' + nurseInitial + '</td></tr><tr><td class="stop-date">' + stopped_date + '</td></tr></tbody></table>';
            } else {
                intravenous_data += '<td class="text-center prescribed-info-td intra-status-empty"><table><tbody><tr><td class="prescribed-info-border prescribed-info-border-bottom">' + startnurseInitial + '</td><td class="prescribed-info-border-bottom">' + nurseInitial + '</td></tr><tr><td class="prescribed-info-border confirm-date">' + started_date + '</td><td class="stop-date">' + stopped_date + '</td></tr></tbody></table>';
            }
            intravenous_data += '</tr>';
            return intravenous_data;
        }

        function updateStatPrescriptionList(stat_value, once) {
            var brand_name = typeof stat_value.brand_name !== "undefined" ? stat_value.brand_name : '';
            var generic_pharmacological_name = typeof stat_value.generic_pharmacological_name !== "undefined" ? stat_value.generic_pharmacological_name : '';
            var drug_name = typeof brand_name !== "undefined" && brand_name != "" ? (brand_name + "/" + generic_pharmacological_name) : '';
            if (stat_value.prescription_date != '' && stat_value.prescription_date != null) {
                prescription_date = (stat_value.prescription_date).replace(/\s/, 'T');
                var date = new Date(prescription_date);
                prescription_date = ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '/' + (((date.getMonth() + 1) > 9) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '/' + date.getFullYear();
            }
            if (stat_value.prescription_date != '' && stat_value.prescription_date != null) {
                prescription_time = stat_value.prescription_date.replace(/\s/, 'T');
                var date = new Date(prescription_time);
                var hours = date.getHours() > 9 ? date.getHours() : ('0' + date.getHours());
                var minutes = date.getMinutes() > 9 ? date.getMinutes() : ('0' + date.getMinutes());
                prescription_time = hours + ':' + minutes;
            }
            var dose_val = (typeof stat_value.dose !== "undefined" && stat_value.dose != null) ? stat_value.dose : '';
            var alt_dose_val = (typeof stat_value.alt_dose !== "undefined" && stat_value.alt_dose != null) ? stat_value.alt_dose : '';
            var oral_route = (typeof stat_value.oral_route !== "undefined" && stat_value.oral_route != null) ? stat_value.oral_route : '';
            var infusion_type = (typeof stat_value.infusion_type !== "undefined" && stat_value.infusion_type != null) ? stat_value.infusion_type : '';
            var creamicon = '';
            if (oral_route != '') {
                var dose_units_g = (typeof stat_value.dose_units_g !== "undefined" && stat_value.dose_units_g != null) ? unit_grams_oral[stat_value.dose_units_g] : '';
                var alt_dose_units_g = (typeof stat_value.alt_dose_units_g !== "undefined" && stat_value.alt_dose_units_g != null) ? unit_grams_oral[stat_value.alt_dose_units_g] : '';
                if (dose_units_g == 'topical' || alt_dose_units_g == 'topical') {
                    creamicon = '<i class="fas fa-highlighter"></i>';
                }
            } else {
                var dose_units_g = (typeof stat_value.dose_units_g !== "undefined" && stat_value.dose_units_g != null) ? unit_grams[stat_value.dose_units_g] : '';
                var alt_dose_units_g = (typeof stat_value.alt_dose_units_g !== "undefined" && stat_value.alt_dose_units_g != null) ? unit_grams[stat_value.alt_dose_units_g] : '';
                oral_route = infusion_type;
            }
            var dose = (typeof dose_val !== "undefined" && dose_val != '' && dose_val != null && dose_val > 0) ? (dose_val + " " + dose_units_g) : '';
            var altdose = (typeof alt_dose_val !== "undefined" && alt_dose_val != '' && alt_dose_val != null && alt_dose_val > 0) ? (alt_dose_val + " " + alt_dose_units_g) : '';
            if (dose != '' && altdose != '') {
                var dose = dose + ' / ' + altdose;
            } else if (dose != '') {
                var dose = dose;
            } else if (altdose != '') {
                var dose = altdose;
            } else {
                var dose = '';
            }
            if (stat_value.hdr_created_user != '') {
                if (user_sign[stat_value.hdr_created_user] != null) {
                    var usersign = '<img src="{{ $site_url }}/img/users/' + user_sign[stat_value.hdr_created_user] + '" alt="Prescribed By" class="user-sign" />';
                } else {
                    var usersign = prescribed_img_alt;
                }
            }
            if (drug_name != '') {
                var time_info = (Object.values(Object.values(stat_value.pres_dtl)[0])[0])[0];
                var started_user_initial_img = stopped_user_initial_img = started_date = stopped_date = '';
                var confirm_date = (time_info.modified_started_date != null && typeof time_info.modified_started_date != 'undefined') ? time_info.modified_started_date : time_info.started_date;
                var confirm_user = (time_info.modified_started_user != null && typeof time_info.modified_started_user != 'undefined') ? time_info.modified_started_user : time_info.started_user;
                if (confirm_user != null) {
                    if (user_initial[confirm_user] != null) {
                        started_user_initial_img = '<img src="{{ $site_url }}/img/users/' + user_initial[confirm_user] + '" alt="Started By" />';
                    } else {
                        started_user_initial_img = started_user_initial_img_alt;
                    }
                    if (confirm_user && started_user_initial_img != '' && user_data[confirm_user] != '') {
                        user_details.push({
                            user: confirm_user,
                            initial: started_user_initial_img,
                            name: user_data[confirm_user]
                        });
                    }
                    started_date = confirm_date;
                    if (started_date != '' && started_date != null) {
                        started_date = started_date.replace(/\s/, 'T');
                        var date = new Date(started_date);
                        var drug_started = date;
                        var hours = date.getHours() > 9 ? date.getHours() : ('0' + date.getHours());
                        var minutes = date.getMinutes() > 9 ? date.getMinutes() : ('0' + date.getMinutes());
                        
                        var start_date_month = ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '-' + (((date.getMonth() + 1) > 9) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1)));

                        var start_date_only = start_date_month + '-' + date.getFullYear();

                        started_date = hours + ':' + minutes;
                    }
                }
                var stopby_user = (time_info.modified_stopped_user != null && typeof time_info.modified_stopped_user != 'undefined') ? time_info.modified_stopped_user : time_info.stopped_user;
                if (stopby_user != null && time_info.is_send == 20) {
                    if (user_initial[stopby_user] != null) {
                        stopped_user_initial_img = '<img src="{{ $site_url }}/img/users/' + user_initial[stopby_user] + '" alt="Stopped By" />';
                    } else {
                        stopped_user_initial_img = stopped_user_initial_img;
                    }
                    if (stopby_user != '' && stopped_user_initial_img != '' && user_data[stopby_user] != '') {
                        user_details.push({
                            user: stopby_user,
                            initial: stopped_user_initial_img,
                            name: user_data[stopby_user]
                        });
                    }
                    stopped_date = (time_info.modified_stopped_date != null && typeof time_info.modified_stopped_date != 'undefined') ? time_info.modified_stopped_date : time_info.stopped_date;
                    if (stopped_date != '' && stopped_date != null) {
                        stopped_date = stopped_date.replace(/\s/, 'T');
                        var date = new Date(stopped_date);
                        var hours = date.getHours() > 9 ? date.getHours() : ('0' + date.getHours());
                        var minutes = date.getMinutes() > 9 ? date.getMinutes() : ('0' + date.getMinutes());
                        var stop_date_month = ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '-' + (((date.getMonth() + 1) > 9) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1)));

                        var stop_date_only = stop_date_month + '-' + date.getFullYear();
                        if (started_date != '' && started_date != null) {
                            // if (start_date_only != stop_date_only) {
                            //     stopped_date = stop_date_month + ' ' + hours + ':' + minutes;
                            // } else {
                                stopped_date = hours + ':' + minutes;
                            // }
                        } else {
                            stopped_date = hours + ':' + minutes;
                        }
                    }
                }
                cancelled_user = (time_info.modified_cancelled_user != null && typeof time_info.modified_cancelled_user != 'undefined') ? time_info.modified_cancelled_user : time_info.cancelled_user;
                if (cancelled_user != null) {
                    if (user_initial[cancelled_user] != null) {
                        stopped_user_initial_img = '<img src="{{ $site_url }}/img/users/' + user_initial[cancelled_user] + '" alt="Cancelled By" />';
                    } else {
                        stopped_user_initial_img = cancelled_user_initial_img_alt;
                    }
                    if (cancelled_user != '' && stopped_user_initial_img != '' && user_data[cancelled_user] != '') {
                        user_details.push({
                            user: stopby_user,
                            initial: stopped_user_initial_img,
                            name: user_data[cancelled_user]
                        });
                    }
                    stopped_date = (time_info.modified_cancel_datetime != null && typeof time_info.modified_cancel_datetime != 'undefined') ? time_info.modified_cancel_datetime : time_info.cancel_datetime;
                    if (stopped_date != '' && stopped_date != null) {
                        stopped_date = stopped_date.replace(/\s/, 'T');
                        var date = new Date(stopped_date);
                        var hours = date.getHours() > 9 ? date.getHours() : ('0' + date.getHours());
                        var minutes = date.getMinutes() > 9 ? date.getMinutes() : ('0' + date.getMinutes());
                        var stop_date_month = ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '-' + (((date.getMonth() + 1) > 9) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1)));

                        var stop_date_only = stop_date_month + '-' + date.getFullYear();
                        if (started_date != '' && started_date != null) {
                            // if (start_date_only != stop_date_only) {
                            //     stopped_date = stop_date_month + ' ' + hours + ':' + minutes;
                            // } else {
                                stopped_date = hours + ':' + minutes;
                            // }
                        } else {
                            stopped_date = hours + ':' + minutes;
                        }
                    }
                }
                var once_only = '<tr>';
                once_only += '<td class="text-center">' + (once + 1) + '</td>';
                once_only += '<td class="text-center">' + prescription_date + '</td>';
                once_only += '<td class="text-center">' + drug_name + '</td>';
                once_only += '<td class="text-center">' + dose + '</td>';
                once_only += '<td class="text-center">' + prescription_time + '</td>';
                once_only += '<td class="text-center">' + oral_route + '</td>';
                once_only += '<td class="text-center">' + usersign + '</td>';
                if (started_user_initial_img != '' && stopped_user_initial_img == '') {
                    once_only += '<td class="user-info-cell text-center prescribed-info-td drug-id-' + time_info.dtl_id + '" data-pres="' + time_info.dtl_id + '" data-advice-id="' + time_info.prescription_id + '"><table><tbody><tr><td class="prescribed-info-border prescribed-info-border-bottom">' + started_user_initial_img + '</td><td class="prescribed-info-border-bottom"></td></tr><tr><td class="prescribed-info-border confirm-date">' + started_date + '</td><td></td></tr></tbody></table></td>';
                } else if (started_user_initial_img != '' && stopped_user_initial_img != '') {
                    once_only += '<td class="user-info-cell text-center prescribed-info-td drug-id-' + time_info.dtl_id + '" data-pres="' + time_info.dtl_id + '" data-advice-id="' + time_info.prescription_id + '"><table><tbody><tr><td class="prescribed-info-border prescribed-info-border-bottom">' + started_user_initial_img + '</td><td class="prescribed-info-border-bottom">' + stopped_user_initial_img + '</td></tr><tr><td class="prescribed-info-border confirm-date">' + started_date + '</td><td class="stop-date">' + stopped_date + '</td></tr></tbody></table></td>';
                } else if (stopped_user_initial_img != '') {
                    once_only += '<td class="user-info-cell text-center prescribed-info-td drug-id-' + time_info.dtl_id + '" data-pres="' + time_info.dtl_id + '" data-advice-id="' + time_info.prescription_id + '"><table><tbody><tr><td class="prescribed-info-border-bottom">' + stopped_user_initial_img + '</td></tr><tr><td class="stop-date">' + stopped_date + '</td></tr></tbody></table></td>';
                } else {
                    once_only += '<td class="user-info-cell text-center prescribed-info-td drug-id-' + time_info.dtl_id + '" data-pres="' + time_info.dtl_id + '" data-advice-id="' + time_info.prescription_id + '"></td>';
                }
                once_only += '</tr>';
            } else {
                var once_only = '<tr>';
                once_only += '<td class="text-center prescription-empty">' + (once + 1) + '</td>';
                once_only += '<td class="text-center prescription-empty">&nbsp</td>';
                once_only += '<td class="text-center prescription-empty">&nbsp</td>';
                once_only += '<td class="text-center prescription-empty">&nbsp</td>';
                once_only += '<td class="text-center prescription-empty">&nbsp</td>';
                once_only += '<td class="text-center prescription-empty">&nbsp</td>';
                once_only += '<td class="text-center prescription-empty">&nbsp</td>';
                once_only += '<td class="text-center prescription-empty">&nbsp</td>';
                once_only += '</tr>';
            }
            return once_only;
        }
        $(document).on('click', '.prescription-print-btn', function() {
            bootbox.dialog({
                message: '<button data-bb-handler="success" type="button" class="btn btn-success print-a4">A4</button><button data-bb-handler="main" type="button" class="btn btn-primary print-a3">A3</button>',
                title: "Please select print sheet type"
            });
        });

        $('#inter-change').prop('checked', false).trigger('change');

    });
$(document).on('change', '#inter-change', function() {
    if ($(this).is(':checked')) {
        $('#prescription-page-a3').css('display', 'block');
        $('#prescription-page').css('display', 'none');
    } else {
        $('#prescription-page-a3').css('display', 'none');
        $('#prescription-page').css('display', 'block');            
    }
});
</script>
@endsection
