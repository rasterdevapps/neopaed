@extends('app')
@section('content')
<style type="text/css">
    .expande-title {
        color: white;
        font-size: 24px;
    }
    .color-white:hover, .color-white:focus {
        color: white;
    }
    .single-problem .info-tick {
        padding: 2px 8px;
    }
</style>
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="{{ url('/') }}">Dashboard</a>
        </li>
        <li class="">
            <a title="Problem based" href="{{ action('ProblemBaseDaycare\ProblemPostnatalController@index') }}">{!! $navigate['module_name'] !!}</a>
        </li>
        <li class="current">
            <a title="Create">Create</a>
        </li>
    </ul>
</div>
<!-- /Breadcrumbs line -->
{!! Form::model($baby,['url' => action('ProblemBaseDaycare\ProblemPostnatalController@store'),'id'=> 'problem_base_daycare']) !!}
<div class="row problem-based-container container-fluid">
    <div class="col-md-12 main-title mt-15 widget box col-sm-12 col-xs-12">
        <div class="widget-header">
            <h4><i class="fa fa-reorder"></i>Basic Details - <b>{{ $baby->BabyName .' - '. $baby->BMrNo }}</h4>
            <a href="javascript:void(0);" data-main-header="problem-basics" class="expande-title up pull-right ml-15">
            <i class="fa fa-angle-down fa-lg" aria-hidden="true"></i>
            </a>
        </div>
        <div class="widget-content p-must-0">
            <div class="hidden">
                {!! Form::hidden('baby_id', @$baby_id) !!}
                {!! Form::hidden('admission_id', @$admissionid) !!}
                {!! Form::hidden('mother_id', @$baby->MotherId)!!}
                {!! Form::hidden('problem_id', $problem_id) !!}
                {!! Form::hidden('problem_id_encrypt', SiteHelpers::encrypt_id($problem_id)) !!}
            </div>
            <div class="col-md-12 problem-basics col-xs-12 ptb-15 plr-0">
                <div class="col-md-3 col-sm-6">
                    <div class="form-group">
                        {!! Form::label('DOB','DOB:') !!}
                        {!! Form::text('DOB',null,['class'=>'form-control input-shadow-special ','readonly']) !!}
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div>
                        <table class="form-group">
                            <thead>
                                <th colspan="3" class="p-must-0">{!! Form::label('Gestation','Gestation:') !!}</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="p-must-0">{!! Form::text('g_weeks',null,['class'=>'form-control input-shadow-special input-width-small','placeholder'=>'Weeks','id'=>'g_weeks','readonly']) !!}</td>
                                    <td class="p-must-0 text-center">+</td>
                                    <td class="p-must-0">{!! Form::text('g_days',null,['class'=>'form-control input-shadow-special input-width-small','placeholder'=>'Days','id'=>'g_days','readonly']) !!}</td>
                                </tr>
                                <tr>
                                    <td><label class="error help-block" for="cg_weeks" generated="true"></label></td>
                                    <td></td>
                                    <td><label class="error help-block" for="cg_days" generated="true"></label> </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="form-group">
                        {!! Form::label('BirthWeight','Birth Weight:') !!}
                        {!! Form::text('BirthWeight',null,['class'=>'form-control input-shadow-special ','readonly']) !!}
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="form-group">
                        {!! Form::label('Sex','Sex:') !!}
                        {!! Form::select('Sex',['Male'=>'Male','Female'=>'Female','Indeterminate'=>'Indeterminate'],null,['class'=>'form-control  input-shadow-special ','disabled']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-xs-12">
        <a href="javascript:void(0);" class="add-episode btn btn-primary btn-basic-shadow pull-right">
        <i class="fa fa-plus" aria-hidden="true"></i>
        <span>Add Episode</span>
        </a>
        <a style ="margin-right: 10px;"href="{{ url('postproblem-systems-episodes/'.$id) }}" class="btn btn-primary btn-basic-shadow pull-right">
        <span>BACK/LIST OF PROBLEMS</span>
        </a>
        <!-- <a href="javascript:void(0);" class="add-episode btn btn-primary btn-basic-shadow pull-right">
            <i class="fa fa-plus" aria-hidden="true"></i>
            <span>Add Episode</span>
        </a> -->
    </div>
    <div class="col-md-12 main-title full-width widget box col-xs-12">
        <div class="col-md-12 widget-header">
            <h4 class="full-width display-inline-block color-white mtb-0">
                <i class="fa fa-reorder"></i>{{ ucfirst($problem_title) }}  
                 <!--  <a href="javascript:void(0);" data-main-header="postnatal-problem-lists" class="expande-title up pull-right">
                    <i class="fa fa-angle-down fa-lg" aria-hidden="true"></i>
                </a> -->
            </h4>
        </div>
        <div class="col-md-12 widget-content mb-15 col-xs-12 postnatal-problem-lists">
            <div class="problem-lists">
                <div class="single-problem">
                    <div>
                        <h5> <a href="javascript:void(0);" data-pcontent="1" class="edit-episode color-white">Episode 1</a><a href="javascript:void(0);" class="info-tick btn-info"><i class="fa fa-info" aria-hidden="true"></i></a>
                            <a href="javascript:void(0);" data-pcontent="2" data-episode-id="0" class="pull-right remove-episode color-white">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </a>
                        </h5>
                        <div>
                            <div class="problem-contents display-block" id="content1">
                                @include('ProblemBaseDaycare.problem_form',[$left_column_param, $problem_layout, $right_column_param, $uniqueId, $single_column_param, $problem_id, $param_values, $episode_id, $published_id, $drugs, $antibiotic])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-3 col-sm-6">
                    <button type="submit" class="btn btn-primary btn-shadow-special form-control btn-block prblm_save_btn">
                        <i class="fa fa-floppy-o" aria-hidden="true"></i>
                        <span> Save </span>
                    </button>
                </div>
                <div class="col-md-3 col-sm-6">
                    <a class="btn btn-info btn-shadow-special form-control btn-block" href="{{ action('ProblemBaseDaycare\ProblemPostnatalController@episodeslist',$id) }}">
                        <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                        <span>Cancel </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
@endsection
@section('scripts')
<script type="text/javascript">
$(document).on('click', '.prblm_save_btn', function(e){
    if ($('#problem_base_daycare').valid() === true) {
        e.preventDefault();
        var print_flag = $(this).data('flag');
        $('#print_flag').val(print_flag);
        $('.prblm_save_btn').prop('disabled', true);
        
        $(this).html('<i class="fas fa-spinner fa-pulse"></i> Loading...');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            data: $('#problem_base_daycare input, #problem_base_daycare select, #problem_base_daycare textarea').serialize(),
            url: "{{ action('ProblemBaseDaycare\ProblemPostnatalController@store') }}",
            success: function (response) {
                Showalert('success', 'Postnatal problem based details updated successfully');
                window.location.href = response.edit_url;
            },
            error: function()
            {
                Showalert('error', 'Something went wrong, Please try again later...!');
            }
        });
    }
});
    $('input[name="start_date[]"], input[name="end_date[]"]').on('change', function() {
        var fromdate = $('input[name="start_date[]"]').val();
        var todate = $('input[name="end_date[]"]').val();
        fromdate = fromdate.split('-');
        var from_date = new Date(fromdate[2], (fromdate[1] - 1), fromdate[0]);
        fromdate = fromdate[1] + '-' + fromdate[0] + '-' + fromdate[2];
        todate = todate.split('-');
        var to_date = new Date(todate[2], (todate[1] - 1), todate[0]);
        todate = todate[1] + '-' + todate[0] + '-' + todate[2];
        $('.error-message').remove();
        if (!(to_date > from_date)) {
            $('input[name="end_date[]"]').after('<span class="error-message" style="display: inline-block;">To date must be greater then from date</span>');
        }
    });
    $(document).ready(function() {
        var destination_elements_drug = '';
        $('.add_master_data[data-type="drug"]').each(function() {
            destination_elements_drug += $(this).data('destination_elements')+',';
        });
        destination_elements_drug = destination_elements_drug.slice(0, -1);
        $('.add_master_data[data-type="drug"]').attr('data-destination_elements', destination_elements_drug);

        var destination_elements_antibiotic = '';
        $('.add_master_data[data-type="antibiotic"]').each(function() {
            destination_elements_antibiotic += $(this).data('destination_elements')+',';
        });
        destination_elements_antibiotic = destination_elements_antibiotic.slice(0, -1);
        $('.add_master_data[data-type="antibiotic"]').attr('data-destination_elements', destination_elements_antibiotic);
    });
</script>
@include('postnatal_problem.problem_script',[$problem_parameter])
@endsection