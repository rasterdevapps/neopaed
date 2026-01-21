@extends('app')
@section('content')
<style type="text/css">
    .parent-age
    {
        background-color: #999 !important;
        color: #fff;
        min-height: 20px;
    }
    .droppable-area1 li
    {
        padding: 15px 65px 15px 20px;
    }
    .droppable-area1
    {
        overflow: auto !important;
    }
    .droppable-area2
    {
        list-style-type: none !important;
        padding: 0px !important;
    }
    .vaccine-age-ul
    {
        list-style-type: none;
    }
    .vaccine-age-ul .vaccine-age-li
    {
        font-size: 16px;
    }
    .draggable-item
    {
        font-size: 12px !important;
    }
    .vaccine-age-ul .vaccine-age-li:not(:first-child)
    {
        margin-top: 10px;
    }
    .placeholder-div
    {
        width: 100%;
        border: 1px dashed #555;
        height: inherit;
        text-align: center;
        display: block;
        background-color: skyblue;
    }
    .draggable-item a
    {
        padding: 2px 5px !important;
    }
    .draggable-item a.vaccine-name-remove-btn
    {
        right: 4px !important;

    }
    .draggable-item a.vaccine-name-edit-btn
    {
        right: 30px !important;
    }
</style>
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="{{ url('/') }}">Dashboard</a>
        </li>
        <li>
            <a href="{{ action('Masters\VaccineAgeController@index') }}">Vaccines Age</a>
        </li>
        <li class="current">
            <a>Map with vaccine</a>
        </li>
    </ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row" style="margin-top: 50px;">
    <div class="col-xs-12">
        <h3 class="text-center">Drag and drop name to age for mapping</h3>
    </div>
</div>
<div class="row row-spacing select-container-main" style="margin-top: 15px; z-index: 1;">
    <div class="master-layout col-md-12">
        <div style="width: 95%;">
            <div class="widget box">
                <div class="widget-header">
                    <h4><i class="fa fa-reorder"></i> Vaccine Age</h4>
                </div>
                <div class="widget-content">
                    @if(isset($vaccine_age) && !empty($vaccine_age))
                    <ul class="vaccine-age-ul">
                        @foreach($vaccine_age as $key => $value)
                            <li class="vaccine-age-li">{{ $value->age }}
                                <ul class="connected-sortable droppable-area1" data-age_id="{{ $value->id }}" id="age_list_{{ $value->id }}">
                                    @php $vaccine_map = $vaccines_mapped->where('vaccine_age_id', $value->id)->sortBy('sort_order')->toArray(); @endphp
                                    @if(count($vaccine_map) > 0)
                                        @foreach($vaccine_map as $v_key => $vaccine)
                                            <li class="draggable-item" data-vaccine_id="{{ $vaccine->id }}">
                                                <span>{{ $vaccine->name }}</span>
                                                <a class="btn btn-default btn-view" href="javascript:void(0);"><i class="fas fa-arrows-alt"></i></a>
                                                <a class="btn btn-primary btn-view vaccine-name-edit-btn" href="javascript:void(0);"><i class="fa fa-edit"></i></a>
                                                <a class="btn btn-danger btn-view vaccine-name-remove-btn" href="javascript:void(0);"><i class="fa fa-trash"></i></a>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="master-layout col-md-12" style="justify-content: normal;">
        <div style="width: 95%; overflow-x:visible ;">
            <div class="widget box">
                <div class="widget-header">
                    <h4><i class="fa fa-reorder"></i> Vaccine generic name</h4>
                    <a href="javascript:void(0);" id="add_vaccine_generic_name" class="btn btn-success pull-right"><i class="fa fa-plus-circle"></i> Add new vaccine</a>
                </div>
                <div class="widget-content">
                    @if(isset($vaccines_not_mapped) && !empty($vaccines_not_mapped))
                    <ul class="droppable-area2 vaccine-widget">
                        @foreach($vaccines_not_mapped as $key => $value)
                            <li class="draggable-item" data-vaccine_id="{{ $value->id }}">
                                <span>{{ $value->name }}</span>
                                <a class="btn btn-default btn-view" href="javascript:void(0);"><i class="fas fa-arrows-alt"></i></a>
                                <a class="btn btn-primary btn-view vaccine-name-edit-btn" href="javascript:void(0);"><i class="fa fa-edit"></i></a>
                                <a class="btn btn-danger btn-view vaccine-name-remove-btn" href="javascript:void(0);"><i class="fa fa-trash"></i></a>
                            </li>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- /.col-md-12 -->  
</div>
<!-- /.row -->
<!-- /Page Content -->
<div class="modal fade flow-control-modal" id="master-vaccine-name-modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="text-center text-white">Add Vaccine</h3>
                <button type="button" class="close modal-close" data-dismiss="modal" aria-hidden="true" style="color:white"><i class="fa fa-times"></i></button>
            </div>
            <div class="modal-body">
                <h5 class="text-center">Please enter vaccine generic name</h5>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('vaccine_name','Vaccine Name:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        <input type="text" id="vaccine_name" class="form-control" />
                        <input type="hidden" id="vaccine_id_modal" />
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="background-color: white;">
                <div class="row mx-0">
                    <div class="col-md-12 text-center">
                        <button type="button" class="btn btn-theme-primary" id="save-master-vaccine-data"><i class="fa fa-save"></i> Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-hidden="true"><i class="fa fa-refresh"></i> Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript" src="{{ url('/') }}/public/js/drag-drop.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $( drag_init );
        function drag_init() {
            $( ".droppable-area2, .droppable-area1" ).sortable({
                connectWith: ".connected-sortable",
                forcePlaceholderSize: true,
                placeholder: {
                    element: function(currentItem) {
                        return $('<li class="placeholder-div">Drop Here...</li>')[0];
                    },
                    update: function(container, p) {
                        return;
                    }
                },
                update: function( event, ui ) {
                    var age_id = $(event.target).data('age_id');
                    var vaccine_id = $(ui.item[0]).data('vaccine_id');
                    if (age_id && age_id != '' && age_id != null && vaccine_id && vaccine_id != '' && vaccine_id != null) {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type:'POST',
                            url:'{{ url("masters/vaccine-generic/map-vaccines") }}',
                            data: {age_id: age_id, vaccine_id:vaccine_id},
                            beforeSend:function() {

                            },
                            success:function(response) {
                                Showalert('success', 'Vaccine mapped successfully');
                            },
                            complete:function(response) {

                            },
                            error:function(response) {
                                if (typeof response.responseJSON.message != 'undefined') {
                                    var message = response.responseJSON.message;
                                    Showalert('error',message);
                                }
                                $('#master-vaccine-name-modal').modal('hide');
                            }
                        });
                        updateIndex('age_list_'+age_id);
                    }
                },
            });
            $( ".droppable-area1, .droppable-area2" ).disableSelection();
        } 
        function updateIndex(age_div)
        {
            var i = 1;
            var sort_order = new Array();;
            $('#'+age_div+ ' li').each(function()
            {
                var vaccine_id = $(this).data('vaccine_id');
                if (vaccine_id && vaccine_id !== undefined && vaccine_id != '') {
                    sort_order[vaccine_id] = i;
                    i++;
                }
            });
            console.log(sort_order);
            if (sort_order.length > 1) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type:'POST',
                    url:'{{ url("masters/vaccine-generic/sorting-vaccines") }}',
                    data: {sort_order: sort_order},
                    beforeSend:function() {

                    },
                    success:function(response) {

                    },
                    complete:function(response) {

                    },
                    error:function(response) {
                        if (typeof response.responseJSON.message != 'undefined') {
                            var message = response.responseJSON.message;
                            Showalert('error',message);
                        }
                        $('#master-vaccine-name-modal').modal('hide');
                    }
                });
            }
        }
        $('#add_vaccine_generic_name').on('click', function(event) {
            $('#vaccine_name').val('');
            $('#vaccine_id_modal').val('');
            $('#master-vaccine-name-modal').modal({backdrop: 'static', show: true });
            $('#master-vaccine-name-modal').on('shown.bs.modal', function() {
                $('#vaccine_name').focus();
            });
        });
        $('#save-master-vaccine-data').on('click', function(event) {
            var vaccine_name = $('#vaccine_name').val();
            if (vaccine_name == null || vaccine_name == '') {
                Showalert('error', 'Vaccine name empty...');
                $('#vaccine_name').focus();
                return false;
            }
            var vaccine_id = $('#vaccine_id_modal').val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:'POST',
                url:'{{ url("masters/vaccine-generic/store-vaccine") }}',
                data: {name: vaccine_name, vaccine_id: vaccine_id},
                beforeSend:function() {

                },
                success:function(response) {
                    if(vaccine_id == null || vaccine_id == '')
                    {
                        $('.vaccine-widget').append('<li class="draggable-item" data-vaccine_id="'+response.id+'"><span>'+vaccine_name+'</span><a class="btn btn-default btn-view"><i class="fas fa-arrows-alt"></i></a><a class="btn btn-primary btn-view vaccine-name-edit-btn" href="javascript:void(0);"><i class="fa fa-edit"></i></a><a class="btn btn-danger btn-view vaccine-name-remove-btn" href="javascript:void(0);"><i class="fa fa-trash"></i></a></li>');
                        Showalert('success', 'Vaccine added successfully');
                        $('#master-vaccine-name-modal').modal('hide');
                    }
                    else
                    {
                        $('.edited_span').text(vaccine_name).removeClass('edited_span');
                        Showalert('success', 'Vaccine updated successfully');
                        $('#vaccine_name').val('');
                        $('#vaccine_id_modal').val('');
                        $('#master-vaccine-name-modal').modal('hide');
                    }
                },
                complete:function(response) {

                },

                error:function(response) {
                    if (typeof response.responseJSON.message != 'undefined') {
                        var message = response.responseJSON.message;
                        Showalert('error',message);
                    }
                    $('#master-vaccine-name-modal').modal('hide');
                }
            });
        });
        
        $(document).on('click', '.vaccine-name-edit-btn', function(event) {
            $('.edited_span').removeClass('edited_span');
            var vaccine_name = $(this).parent().text().trim();
            var vaccine_id = $(this).parent().data('vaccine_id');
            $(this).siblings('span').addClass('edited_span');
            if (vaccine_id != null && vaccine_name != '' && vaccine_name != null && vaccine_id != '') {
                $('#vaccine_name').val(vaccine_name);
                $('#vaccine_id_modal').val(vaccine_id);
                $('#master-vaccine-name-modal').modal({backdrop: 'static', show: true });
                $('#master-vaccine-name-modal').on('shown.bs.modal', function() {
                    $('#vaccine_name').focus();
                })
            }
        });

        $(document).on('click', '.vaccine-name-remove-btn',function(event) {
            if (confirm("Do you want to delete this vaccine?") == true) {
                $('.delete-vaccine').removeClass('delete-vaccine');
                var age_id = $(this).parents('ul.connected-sortable').data('age_id');
                var vaccine_id = $(this).parent().data('vaccine_id');
                $(this).parent().addClass('delete-vaccine');
                if (vaccine_id != '' && vaccine_id != null) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type:'POST',
                        url:'{{ url("masters/vaccine-generic/delete-vaccine") }}',
                        data: {vaccine_id: vaccine_id},
                        beforeSend:function() {

                        },
                        success:function(response) {
                            Showalert('info', 'Vaccine removed successfully');
                            $('.delete-vaccine').remove();
                            if (age_id != null && age_id != '') {
                                updateIndex('age_list_'+age_id);
                            }
                        },
                        complete:function(response) {

                        },

                        error:function(response) {
                            if (typeof response.responseJSON.message != 'undefined') {
                                var message = response.responseJSON.message;
                                Showalert('error',message);
                            }
                        }
                    });
                }
            }
        });
    });
</script>
@endsection