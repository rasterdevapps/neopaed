@extends('app')
@section('content')
<style type="text/css">
    .row {
        display: flex;
        flex-direction: column;
        align-items: center;
        overflow: auto;
    }
    #ward-container {
        width: 1080px;
        height: 2264px;
        -ms-transform: scale(0.8);
        -moz-transform: scale(0.8);
        -o-transform: scale(0.8);
        -webkit-transform: scale(0.8);
        transform: scale(0.8);

        -ms-transform-origin: 50% 0;
        -moz-transform-origin: 50% 0;
        -o-transform-origin: 50% 0;
        -webkit-transform-origin: 50% 0;
        transform-origin: 50% 0;
    }
    #ward-frame-container {
        background-color: #000000;
        width: 100%;
        height: 100%;
    }
    #ward-frame {
        width: 100%;
        height: 100%;
    }
    #pagination-container {
        position: absolute;
        right: -5px;
        top: -20px;
    }
    #pagination-container > ul {
        padding: 10px;
    }
    #pagination-container > ul > li {
        margin-right: 15px;
        border: 5px solid transparent;
        width: 45px;
        height: 45px;
        display: inline-block;
        border-radius: 50px;
    }
    #pagination-container > ul > li:hover {
        position: relative;
        top: -5px;
        left: -6px;
        width: 35px;
        height: 35px;
        background-color: white;
    }
    #pagination-container > ul > #page-1, #pagination-container > ul > #page-2 {
        margin-right: 12px;
    }
    #pagination-container > ul > #page-3 {
        margin-right: 11px;
    }
    #pagination-container > ul > #page-4 {
        margin-right: 25px;
    }
    .modal-body td > div {
        border-radius: 10px;
        border: 1px solid black;
        margin: 5px;
        padding: 5px;
    }
    .modal-body {
        height: 500px;
        overflow: auto;
    }
    .modal-body p {
        font-size: 10px;
        margin-bottom: 0px;
    }
    .selected-td div {
        border: 1px solid red !important;
        background: antiquewhite;
    }
    .modal-header .close {
        margin-top: 7px;
        font-size: 42px !important;
    }
    #pacs-container {
        position: absolute;
        top: 715px;
        width: 1080px;
        height: 1549px;
    }
    #empty-view {
        display: flex;
        align-items: center;
        height: 100%;
        font-size: 24px;
        color: #80808082;
    }
    #pacs-loader {
        position: fixed;
        left: 0px;
        top: 624px;
        width: 100%;
        height: calc(100% - 624px);
        z-index: 5;
        background: url('{{ url('/') }}/public/img/chart-loader.gif') center no-repeat #000000;
}
@media screen and (max-width: 480px) {
    #ward-container {
        margin-left: 180px;
    }
}
@media screen and (max-width: 992px) {
    #ward-container {
        -ms-transform: scale(0.5);
        -moz-transform: scale(0.5);
        -o-transform: scale(0.5);
        -webkit-transform: scale(0.5);
        transform: scale(0.5);

        -ms-transform-origin: 50% 0;
        -moz-transform-origin: 50% 0;
        -o-transform-origin: 50% 0;
        -webkit-transform-origin: 50% 0;
        transform-origin: 50% 0;
    }
}
</style>
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
        <li class="current">NICU Ward Dashboard</li>                                                
    </ul>      
    <a href="{{ url('ward-dashboard') }}" class="close-nav pull-right"><i class="fa fa-times"></i></a>     
    <div class="pull-right">
        @php 
        echo \SiteHelpers::menuList($mrn, 'nicu_dashboard');
        @endphp
    </div>    
    @if (isset($next_url) && !is_null($next_url))
        <a href="{{ $next_url }}" class="btn ward-bed-nav pull-right">
            <i class="fa fa-chevron-right" aria-hidden="true"></i>
        </a>
    @endif   
    @if (isset($prev_url) && !is_null($prev_url))
        <a href="{{ $prev_url }}" class="btn ward-bed-nav pull-right mr-15">
            <i class="fa fa-chevron-left" aria-hidden="true"></i>
        </a>
    @endif
</div>
<!-- /Breadcrumbs line -->
<div class="row row-spacing">
    {!! Form::hidden('baby_id', $baby_id) !!}
    {!! Form::hidden('mrn', $mrn) !!}
    {!! Form::hidden('admission_date', $admission_date) !!}
    <div id="ward-container">
        <div id="pagination-container">
            <ul>
                <li class="pagination" id="page-1" data-page="1"></li>
                <li class="pagination" id="page-2" data-page="2"></li>
                <li class="pagination" id="page-3" data-page="3"></li>
                <li class="pagination" id="page-4" data-page="4"></li>
            </ul>
        </div>
        <div id="ward-frame-container">
            @php $ward_folder = substr($_SERVER['REMOTE_ADDR'], 0, 4) == '172.' @endphp
            @if ($ward_folder) 
            @php $url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/nicu-dashboard?bed_no='.$bed_no; @endphp
            @else
            @php $url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/nicu-dashboard-public?bed_no='.$bed_no; @endphp
            @endif
            <input type="hidden" name="orginal" value="{!! $url !!}">
            <iframe src="{!! $url !!}" id="ward-frame" frameborder="0" auto_zoom="remote"></iframe>
        </div>
        <div id="pacs-container" class="display-none">
            <div id="pacs-loader"></div>
            <img src="">
        </div>
    </div>
</div>
<div class="modal fade" id="study-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close modal-close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <h3 class="text-center text-white">Studies</h3>
                </h5>
            </div>
            <div class="modal-body row m-10">
                <div id="empty-view">No Data found</div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        var baby_id = $('input[name="baby_id"]').val();
        var mrn = $('input[name="mrn"]').val();
        var admission_date = $('input[name="admission_date"]').val();
        $('#ward-frame').contents().find('body').css('overflow', 'auto');
        var page_load = 0;
        var image_link = '';
        $('.pagination').on('click', function() {
            var page_no = $(this).attr('data-page');
            if (page_no == 4) {
                var study_content = '<table class="full-width">';
                study_content += '<tbody>';
                var cell_content = '';
                if (page_load == 0) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'GET',
                        data: {
                            mrn: mrn,
                            modality: 'DX',
                            admission_date: admission_date
                        },
                        url: "{{ url('get-pacs-studies') }}",
                        async: false,
                        success: function(response) {
                            var image_list = response.image_list;
                            image_link = response.image_url;
                            var i = 0;
                            $.each(image_list, function(key, value) {
                                if (i % 4 == 0) {
                                    cell_content += '<tr>';
                                }
                                var cell = '<td id="cell-' + i + '" class="text-center" data-studyid="' + value.study_id + '" data-seriesid="' + value.series_id + '" data-instanceid="' + value.instance_id + '" data-rows="' + value.rows + '" data-contenttype="' + value.content_type + '" data-modality="' + value.modality + '" data-patientname="' + value.patient_name + '" data-rawtime="' + value.temp_study_date_time + '" data-seriesdescription="' + value.series_description + '">';
                                cell += '<div>';
                                cell += '<img src="http://172.16.7.211/neonatal_dev/public/img/no-image.png"/>';
                                cell += '<p>' + value.series_description + '</p>';
                                cell += '<p>' + value.study_date_time + '</p>';
                                cell += '</div>';
                                cell += '</td>';
                                cell_content += cell;
                                i++;
                                if (i % 4 == 0) {
                                    cell_content += '</tr>';
                                }
                            });
                        }
                    });
                }
                study_content += cell_content;
                study_content += '</tbody>';
                study_content += '</table>';
                if (cell_content != '') {
                    $('#study-modal .modal-body').html(study_content);
                }
                $('#study-modal').modal({
                    backdrop: 'static',
                    keyboard: false,
                    show: true
                });
                if (page_load == 0) {
                    setTimeout(loadImages(), 100);
                }
                page_load++;
            } else {
                loadFrame(page_no);
            }
        });

        function loadFrame(page_no) {
            $('#pacs-container').addClass('display-none');
            var url = $('#ward-frame-container input[name="orginal"]').val();
            url+= '&requested_page='+page_no;
            $('#ward-frame-container iframe').attr('src', url);
        }

        var loaded = 0;

        function loadImages() {
            var cell_count = $('td').length - 1;
            if (cell_count >= loaded) {
                loadPacsImage();
            }
        }

        function loadPacsImage() {
            var element = $('#cell-' + loaded);
            var study_id = element.data('studyid');
            var series_id = element.data('seriesid');
            var instance_id = element.data('instanceid');
            var rows = element.data('rows');
            var content_type = element.data('contenttype');
            var view_link = image_link;
            view_link = view_link.replace('STUDY_ID', study_id);
            view_link = view_link.replace('SERIES_ID', series_id);
            view_link = view_link.replace('INSTANCE_ID', instance_id);
            view_link = view_link.replace('CONTENT_TYPE', content_type);
            view_link = view_link.replace('SIZE', rows);
            element.find('img').load(function(){
                loaded++;
                loadImages();
            }).attr('src', view_link);
        }

        $(document).on('click', 'td', function() {
            $('td').removeClass('selected-td');
            $(this).addClass('selected-td');
            $('#study-modal').modal('hide');
            loadFrame(4);
            $('#pacs-container').removeClass('display-none');
            $('#pacs-loader').removeClass('hide');
            var mrn = $('input[name="mrn"]').val();
            var patient_name = $(this).data('patientname');
            var date_time = $(this).data('rawtime');
            var modality = $(this).data('modality');
            var study_id = $(this).data('studyid');
            var series_id = $(this).data('seriesid');
            var series_description = $(this).data('seriesdescription');
            var instance_id = $(this).data('instanceid');
            var content_type = $(this).data('contenttype');
            setTimeout(function() {
                var view_link = image_link;
                view_link = view_link.replace('STUDY_ID', study_id);
                view_link = view_link.replace('SERIES_ID', series_id);
                view_link = view_link.replace('INSTANCE_ID', instance_id);
                view_link = view_link.replace('CONTENT_TYPE', content_type);
                view_link = view_link.replace('rows=SIZE&', '');
                $('#ward-frame').contents().find('app-nicu-stepper4 #patientId').html(mrn);
                $('#ward-frame').contents().find('app-nicu-stepper4 #patientName').html(patient_name);
                $('#ward-frame').contents().find('app-nicu-stepper4 #modality').html(modality + ' - ' + series_description);
                $('#ward-frame').contents().find('app-nicu-stepper4 #studyDate').html(date_time);
                $('#pacs-container').find('img').load(function(){
                    $('#pacs-loader').addClass('hide');
                }).attr('src', view_link);
            }, 500);
        });
    });
</script>
@endsection