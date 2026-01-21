@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<style type="text/css">
    .expande-title i {
    top: -2px;
    }
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
    .single-problem .tick {
    padding: 3.5px 4.5px;
    }
</style>
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li><i class="fa fa-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
        <li><a title="problem base system" href="{{ action('ProblemBaseDaycare\ProblemDaycareController@index') }}">Problems base daycare </a></li>
        <li class="current"><a title="">Edit</a></li>
    </ul>
    <div class="pull-right">
        @php 
        $mmrn = $baby->BMrNo; 

        echo \SiteHelpers::menuList($mmrn, 'problem_base_daycare');
        @endphp
    </div>
</div>
<!-- /Breadcrumbs line -->
{!! Form::model($baby,['url' => action('ProblemBaseDaycare\ProblemDaycareController@update',$daycare_id),'id'=> 'problem_base_daycare','method'=>'patch']) !!}
<div class="row problem-based-container container-fluid">
    <div class="col-md-12 main-title mt-15 widget box col-sm-12 col-xs-12">
        <div class="widget-header">
            <h4><i class="fa fa-reorder"></i>Basic Details - <b>{{ $baby->BabyName .' - '. $baby->BMrNo }}</h4>
            <a href="javascript:void(0);" data-main-header="problem-basics" class="expande-title up pull-right ml-15">
            <i class="fa fa-angle-down fa-lg" aria-hidden="true"></i>
            </a>
            <span class="display-status-block color-white">
            <span href="javascript:void(0);" class="pull-right">Ongoing Episodes</span>
            <span href="javascript:void(0);" class="info-tick btn-info pull-right">
            <i class="fa fa-info" aria-hidden="true"></i>
            </span>
            <span href="javascript:void(0);" class="pull-right">Completed Episodes</span>
            <span href="javascript:void(0);" class="tick btn-success pull-right">
            <i class="fa fa-check" aria-hidden="true"></i>
            </span>
            </span>
        </div>
        <div class="widget-content p-must-0">
            {!! Form::hidden('baby_id',@$daylist->baby_id) !!}
            {!! Form::hidden('admission_id',@$daylist->admission_id) !!}
            {!! Form::hidden('mother_id',@$daylist->mother_id)!!}
            {!! Form::hidden('problem_id',@$daylist->problem_id) !!}
            {!! Form::hidden('problem_id_encrypt',SiteHelpers::encrypt_id(@$daylist->problem_id)) !!}
            <div class="col-md-12 problem-basics col-xs-12 ptb-15 plr-0">
                <div class="col-md-3 col-sm-6">
                    <div class="form-group">
                        {!! Form::label('DOB','DOB:') !!}
                        {!! Form::text('DOB',null,['class'=>'form-control input-shadow-special','readonly']) !!}
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <table class="form-group">
                        <thead>
                            <th colspan="3" class="p-must-0">{!! Form::label('Gestation','Gestation:') !!}</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="p-must-0">{!! Form::text('g_weeks',null,['class'=>'form-control input-shadow-special input-width-small','placeholder'=>'Weeks','readonly']) !!}</td>
                                <td class="p-must-0 text-center">+</td>
                                <td class="p-must-0">{!! Form::text('g_days',null,['class'=>'form-control input-shadow-special  input-width-small','placeholder'=>'Days','readonly']) !!}</td>
                            </tr>
                            <tr>
                                <td><label class="error help-block" for="cg_weeks" generated="true"></label></td>
                                <td></td>
                                <td><label class="error help-block" for="cg_days" generated="true"></label> </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="form-group">
                        {!! Form::label('BirthWeight','Birth Weight:') !!}
                        {!! Form::text('BirthWeight',null,['class'=>'form-control input-shadow-special','readonly']) !!}
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="form-group">
                        {!! Form::label('Sex','Sex:') !!}
                        {!! Form::select('Sex',['Male'=>'Male','Female'=>'Female','Indeterminate'=>'Indeterminate'],null,['class'=>'form-control input-shadow-special','readonly']) !!}
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
        <a style="margin-right: 10px"href="{{ url('problem-systems-episodes/'.$ids) }}" class="btn btn-primary btn-basic-shadow pull-right">BACK/LIST OF PROBLEMS</a>
    </div>
    <div class="col-md-12 main-title full-width widget box col-xs-12">
        <div class="col-md-12 widget-header">
            <h4 class="full-width display-inline-block mtb-0">
                <i class="fa fa-reorder"></i> {!! ucfirst($problem_title) !!}
                <!--  <a href="javascript:void(0);" data-main-header="problem-lists" class="expande-title up pull-right">
                    <i class="fa fa-angle-down fa-lg" aria-hidden="true"></i>
                    </a> -->
            </h4>
        </div>
        <div class="col-md-12 widget-content mb-15 col-xs-12">
            <div class="problem-lists">
                @php 
                $i =1; 
                $episodes->sortby('epidode_id');
                @endphp 
                @foreach($episodes as $subepisodeslists)
                <div class="single-problem">
                    @php $problem_id     = $subepisodeslists->problem_id; @endphp
                    @php $problembase    = ProblemBaseHelpers::getProblemProperty($subepisodeslists->pp_id) @endphp
                    @php $problem_layout = $problembase->problem_layout; @endphp 
                    @php $single_column_param = $left_column_param = $right_column_param = array(); @endphp
                    @php $uniqueId = 'problem-'.$subepisodeslists->problem_id.'-'.$i  @endphp
                    @php $episode_id = $subepisodeslists->episode_id; @endphp
                    @php $published_id = $subepisodeslists->pp_id @endphp
                    @php $param_values = (array)json_decode($subepisodeslists->problems_parameters) @endphp
                    @if($problembase->problem_layout == 1)
                    @php $single_column_param = collect(json_decode($problembase->problem_fields))->where('para_position','single-column-problem'); @endphp
                    @elseif($problembase->problem_layout == 2)
                    @php $left_column_param  = collect(json_decode($problembase->problem_fields))->where('para_position','problem-fields-left'); @endphp
                    @php $right_column_param = collect(json_decode($problembase->problem_fields))->where('para_position','problem-fields-right');  @endphp
                    @endif
                    <div>
                        <h5>
                            <a href="javascript:void(0);" data-pcontent= "{{ $i }}" class="edit-episode color-white">Episode {{ $i }}</a>
                            @if(isset($subepisodeslists->start_date) && !is_null($subepisodeslists->start_date) && isset($subepisodeslists->end_date) && !is_null($subepisodeslists->end_date)) 
                            <a href="javascript:void(0);" class="tick btn-success"><i class="fa fa-check" aria-hidden="true"></i></a>
                            @else
                            <a href="javascript:void(0);" class="info-tick btn-info"><i class="fa fa-info" aria-hidden="true"></i></a>
                            @endif 
                            <a href="javascript:void(0);" data-pcontent= "{{ $i }}" data-episode-id= "{{ $episode_id }}" title="remove episode" class="pull-right remove-episode color-white">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                            </a>
                        </h5>
                        <div>
                            <div class="problem-contents" id="content{{$i}}">
                                @include('ProblemBaseDaycare.problem_form',[$problem_id, $problem_layout, $single_column_param, $uniqueId, $param_values, $episode_id, $published_id, $drugs])
                            </div>
                        </div>
                    </div>
                </div>
                @php $i++; @endphp
                @endforeach 
                @if(Session::has('create-episode') && isset($problembase))
                <div class="single-problem">
                    @php $problem_id     = $problems->problem_id; @endphp
                    @php $problem_layout = $problembase->problem_layout; @endphp 
                    @php $single_column_param = $left_column_param = $right_column_param = $param_values = array(); @endphp
                    @php $episodeno =  count($episodes)+1; @endphp
                    @php $uniqueId = 'problem-'.$problems->problem_id.'-'.$episodeno  @endphp
                    @php $episode_id = 0 @endphp
                    @php $published_id = $problems->published_id @endphp
                    @if($problems->problem_layout == 1)
                    @php $single_column_param = collect(json_decode($problems->problem_fields))->where('para_position','single-column-problem'); @endphp
                    @elseif($problems->problem_layout == 2)
                    @php $left_column_param  = collect(json_decode($problems->problem_fields))->where('para_position','problem-fields-left'); @endphp
                    @php $right_column_param = collect(json_decode($problems->problem_fields))->where('para_position','problem-fields-right');  @endphp
                    @endif
                    <div>
                        <h5>
                            <a href="javascript:void(0);" data-pcontent= "{{ $i }}" class="edit-episode">{!! 'Episode '.$episodeno !!}</a>
                            <a href="javascript:void(0);" class="info-tick btn-info"><i class="fa fa-info" aria-hidden="true"></i></a>
                            <a href="javascript:void(0);" data-pcontent= "{{ $i }}" data-episode-id= "{{ $episode_id }}" title="remove episode" class="pull-right remove-episode">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                            </a>
                        </h5>
                        <div>
                            <div class="problem-contents" id="content{{$i}}">
                                @include('ProblemBaseDaycare.problem_form',[$problem_id, $problem_layout, $single_column_param, $uniqueId, $param_values, $episode_id, $published_id, $drugs])
                            </div>
                        </div>
                    </div>
                    @php Session::forget('create-episode') @endphp  
                    @endif
                </div>
            </div>
            {{ Form::hidden('column_param', collect(json_decode($problems->problem_fields))) }}
            <div class="col-md-12">
                <div class="col-md-3 col-sm-6">
                    <button class="btn btn-primary btn-shadow-special form-control btn-block update_btn">
                    <i class="fa fa-pencil" aria-hidden="true"></i>
                    <span> Update </span>
                    </button>
                </div>
                <div class="col-md-3 col-sm-6">
                    <a class="btn btn-info btn-shadow-special form-control btn-block" href="{{ action('ProblemBaseDaycare\ProblemDaycareController@episodeslist',$ids) }}">
                    <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                    <span>Cancel </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
<!-- <div class="modal fade" id="antibitic-drug" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close btn" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <h3>Antibiotics</h3>
                </h5>
            </div>
            <div class="modal-body row m-20">
                <div class="form-group">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <input type="text" name="anitibiotic_name" value="" class="form-control input-fields-shadow input-width-medium name">
                                </td>
                                <td>
                                    <select name="anitibiotic_status" id ="anitibiotic_status" class="form-control input-fields-shadow input-width-medium has-success">
                                        <option selected="selected" value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="save-antibiotic" class="btn btn-default btn-primary save-button-shadow">Save</button>
            </div>
        </form>
    </div>
    </div>
    </div> -->
@php $problem_parameter = json_decode($problems->problem_fields) @endphp 
@endsection
@section('scripts')
<script type="text/javascript">
$(document).on('click', '.update_btn', function(e){
    // if ($('#problem_base_daycare').valid() === true) {
        e.preventDefault();
        // var print_flag = $(this).data('flag');
        // $('#print_flag').val(print_flag);
        $('.update_btn').prop('disabled', true);

        $(this).html('<i class="fas fa-spinner fa-pulse"></i> Loading...');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            data: $('#problem_base_daycare input, #problem_base_daycare select, #problem_base_daycare textarea').serialize(),
            url: "{{ action('ProblemBaseDaycare\ProblemDaycareController@update', $daycare_id) }}",
            success: function (response) {
                Showalert('success', 'Problem based daycare details saved successfully');
                $('.update_btn').prop('disabled', false).html('<i class="fa fa-pencil" aria-hidden="true"></i><span> Update </span>');

                // window.location.href = response.edit_url;
                location.reload();
            },
            error: function()
            {
                $('.update_btn').prop('disabled', false).html('<i class="fa fa-pencil" aria-hidden="true"></i><span> Update </span>');
                Showalert('error', 'Something went wrong, Please try again later...!');
            }
        });
    // }
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
@include('ProblemBaseDaycare.problem_script',[$problem_parameter])
@endsection