@php 
      $results = (isset($baby)) ? (array) $baby : (array) $results;
@endphp
@php 
      $togglesDetails = ['VentilationRequired', 'delivery_cpap', 'Ventilation', 'UAC', 'UVC', 'ParentsSpokenTo', 'NextAppointmentStatus'];
    $toggleValues = $results;
@endphp
@php 
      $tagsids = ['DescriptionOfResuscitation', 'MajorComplaints', 'Plan', 'MattersDiscussed', 'FinalDiagnosis', 'Advice'];
@endphp
<script type="text/javascript">
    $(document).ready(function () {
        $('#Investigations').tagsinput({
            allowDuplicates: false
        });
        if ($('#Investigations').val() && $('#Investigations').val() != '' && $('#Investigations').val() != null) {
            var investigation_values = $('#Investigations').val().split(',');
            if (investigation_values.length > 0) {
                $.each(investigation_values, function (index, value) {
                    $('#Investigations').tagsinput('add', value);
                });
            }
        }
    });

    @foreach($togglesDetails as $values)
        @if(isset($toggleValues[$values]) && is_null($toggleValues[$values]) || empty($toggleValues[$values]) || $toggleValues[$values] == 'No')
            $('#' + "{{ $values }}").bootstrapToggle('off');
        @elseif(isset($toggleValues[$values]) && !is_null($toggleValues[$values]) && $toggleValues[$values] == 'Yes')
            $('#' + "{{ $values }}").bootstrapToggle('on');
        @endif
    @endforeach
    $('#echocardiography_status').on('change', function () {
        echoCardiographyReport();
    });
    $('#discharge_cuss').on('change', function () {
        cranialUltrasoundReport();
    });
    $(document).ready(function () {
        $('#RopScreening').on('change', function () {
            nicuropDependancy();
        });
        $('#ROPTreatment').on('change', function () {
            nicuropTreatementDependancy();
        });
        $('#HearingScreening').on('change', function () {
            nicuhearingDependancy();
        });
        nicuropDependancy();
        nicuropTreatementDependancy();
        nicuhearingDependancy();
        echoCardiographyReport();
        cranialUltrasoundReport();
        $('select[name="investigations_test"]').on('change', function (e) {
            if (typeof e.added != 'undefined') {
                var package_id = e.added.id;
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'GET',
                    data: {
                        package_id: package_id
                    },
                    url: "{{ action('Masters\InvestigationsController@getTestList') }}",
                    success: function (response) {
                        var result = response.results;
                        var package_id = '';
                        var test_name = '';
                        $.each(result, function (key, value) {
                            $.each(value, function (test_key, test_value) {
                                $('#Investigations').tagsinput('add', test_value.test_name);
                            });
                        });
                    }
                });
            }
        });
    });

    $('select[name="investigations_test"]').on("removed", function (e) {
        var removed_value = e.val;
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            data: {
                package_id: removed_value
            },
            url: "{{ action('Masters\InvestigationsController@getTestList') }}",
            success: function (response) {
                var result = response.results;
                $.each(result, function (key, value) {
                    $.each(value, function (test_key, test_value) {
                        $('#Investigations').tagsinput('remove', test_value.test_name);
                    });
                });
            }
        });
    });
</script>