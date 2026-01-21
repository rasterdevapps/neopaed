<style type="text/css">
   .carousel-fade .carousel-inner .item {
        transition-property: opacity;
    }

    .carousel-fade .carousel-inner .item {
        opacity: 0;
    }

    .carousel-fade .carousel-inner .active {
        opacity: 1;
    }

    .carousel-fade .carousel-inner .next,
    .carousel-fade .carousel-inner .prev {
        left: 0;
        transform: translate3d(0, 0, 0);
    }

    .carousel-fade .carousel-control {
        z-index: 2;
    }

    .carousel {
        height: 500px;
    }

    .carousel-inner,
    .carousel-inner .item {
        height: 100%;
    }

    .carousel-inner .item {
        overflow-y: hidden;
        overflow-x: hidden;
    }

    .carousel-indicators .active {
        width: 30px;
        height: 5px;
        background-color: springgreen;
    }

    .carousel-indicators li {
        width: 30px;
        height: 5px;
        border: 1px solid black;
        border-radius: 0px;
    }

    #myCarousel .table>tbody>tr>td {
        padding: 3px 8px;
    }

    #myCarousel .widget-content.no-padding table {
        margin-top: 0px;
    }
    .carousel-control, .carousel-control:hover, .carousel-control:focus {
        color: #f00;
    }
</style>
<script type="text/javascript">
    $('#myCarousel').carousel();
</script>
<div id="myCarousel" class="carousel slide" data-ride="carousel" data-touch="true" data-interval="false">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1" id="custom_chart"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <div class="item active">
            @include('status_report_chart')
        </div>
        <div class="item">
            @include('year_wise_status_report_chart')
        </div>
        <div class="item">
            <div class="row row-spacing">
                <div class="col-md-6 col-sm-6">
                    <div class="widget box homepage-overview-board">
                        <div class="widget-header">
                            <h4>
                                <span href="{{ action('Registration\BabyController@index') }}">
                                    <i class="fa fa-reorder"></i>
                                </span> {{ Lang::get('home.recent_baby_registration')}}
                            </h4>
                            <div class="toolbar no-padding">
                                <div class="btn-group">
                                    <span class="btn btn-xs widget-collapse"><i class="fa fa-angle-up fa-2x"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content no-padding">
                            <table class="table table-striped table-checkable table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ Lang::get('home.baby_name') }}</th>
                                        <th class="align-center input-width-small">{{ Lang::get('home.mrn') }}</th>
                                        @if($results['baby'] && is_array($write_permission) && in_array('BABY_REG',$write_permission))
                                            <th class="align-center input-width-small">{{ Lang::get('home.edit') }}</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (@count($results['baby']) > 0)
                                    @for ($i = 0; $i <  @count($results['baby']); $i++)
                                    @if($results['baby'][$i]->BabyName != '' && $results['baby'][$i]->BMrNo != '')
                                    <tr>
                                        <td >{{  $results['baby'][$i]->BabyName }}</td>
                                        <td class="align-center input-width-small">{{  $results['baby'][$i]->BMrNo }}</td>
                                        @if($results['baby'] && is_array($write_permission) && in_array('BABY_REG',$write_permission))
                                            <td class="align-center input-width-small center-align-phone">
                                                <a class="btn btn-info btn-view" href="{{ action('Registration\BabyController@edit', SiteHelpers::encrypt_id($results['baby'][$i]->BabyId)) }}">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            </td>
                                        @endif
                                    </tr>
                                    @endif  
                                    @endfor
                                    @else
                                    <tr class="text-center">
                                        <td colspan="3"> No registration found</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                            <!-- /.row-->
                        </div> <!-- /.widget-content -->
                    </div>
                    <!-- /.widget -->
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="widget box homepage-overview-board">
                        <div class="widget-header">
                            <h4>
                                <span href="{{ action('Registration\OpController@index') }}">
                                    <i class="fa fa-reorder"></i>
                                </span> {{ Lang::get('home.recent_op_registration') }}
                            </h4>
                            <div class="toolbar no-padding">
                                <div class="btn-group">
                                    <span class="btn btn-xs widget-collapse"><i class="fa fa-angle-up fa-2x"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content no-padding">
                            <table class="table table-striped table-checkable table-hover">
                                <thead>
                                    <tr>
                                        <th > {{ Lang::get('home.baby_name') }}</th>
                                        <th class="align-center input-width-small">{{ Lang::get('home.mrn') }}</th>
                                        @if($results['op'] && is_array($write_permission) && in_array('OP_REG',$write_permission))
                                            <th class="align-center input-width-small">{{ Lang::get('home.edit') }}</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (@count($results['op']) > 0)
                                    @for ($i = 0; $i <  @count($results['op']); $i++)
                                    <tr>
                                        <td >{{  $results['op'][$i]->BabyName }}</td>
                                        <td class="align-center input-width-small">{{  $results['op'][$i]->BMrNo }}</td>
                                        @if($results['op'] && is_array($write_permission) && in_array('OP_REG',$write_permission))
                                            <td class="align-center input-width-small center-align-phone">
                                                <a class="btn btn-info btn-view" href="{{ action('Registration\OpController@edit', SiteHelpers::encrypt_id($results['op'][$i]->OpId)) }}">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            </td>
                                        @endif
                                    </tr>
                                    @endfor
                                    @else
                                    <tr class="text-center">
                                        <td colspan="3"> No registration found</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                            <!-- /.row -->
                        </div>
                        <!-- /.widget-content -->
                    </div>
                    <!-- /.widget -->
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="widget box homepage-overview-board">
                        <div class="widget-header">
                            <h4>
                                <span href="{{ action('Admission\NicuController@index') }}">
                                    <i class="fa fa-reorder"></i>
                                </span> {{ Lang::get('home.recent_nicu_admission') }}
                            </h4>
                            <div class="toolbar no-padding">
                                <div class="btn-group">
                                    <span class="btn btn-xs widget-collapse"><i class="fa fa-angle-up fa-2x"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content no-padding">
                            <table class="table table-striped table-checkable table-hover">
                                <thead>
                                    <tr>
                                        <th > {{ Lang::get('home.baby_name') }}</th>
                                        <th class="align-center input-width-small">{{ Lang::get('home.mrn') }}</th>
                                        @if(isset($results['nicu']) && is_array($write_permission) && in_array('NICU_FORM',$write_permission))
                                            <th class="align-center input-width-small">{{ Lang::get('home.edit') }}</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (@count($results['nicu']) > 0)
                                    @for ($i = 0; $i <  @count($results['nicu']); $i++)
                                    @if($results['nicu'][$i]->BMrNo != '')
                                    <tr>
                                        <td >{{  $results['nicu'][$i]->BabyName }}</td>
                                        <td class="align-center input-width-small">{{  $results['nicu'][$i]->BMrNo }}</td>
                                        @if(isset($results['nicu']) && is_array($write_permission) && in_array('NICU_FORM',$write_permission))
                                            <td class="align-center input-width-small center-align-phone">
                                                <a class="btn btn-info btn-view" href="{{ action('Admission\NicuController@edit',SiteHelpers::encrypt_id($results['nicu'][$i]->NicuId)) }}">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            </td>
                                        @endif
                                    </tr>
                                    @endif   
                                    @endfor
                                    @else
                                    <tr class="text-center">
                                        <td colspan="3"> No admission found</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                            <!-- /.row -->
                        </div>
                        <!-- /.widget-content -->
                    </div>
                    <!-- /.widget -->
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="widget box homepage-overview-board">
                        <div class="widget-header">
                            <h4>
                                <span href="{{ action('Admission\NicuController@index') }}">
                                    <i class="fa fa-reorder"></i>
                                </span> {{ Lang::get('home.recent_postanatal_admission') }}
                            </h4>
                            <div class="toolbar no-padding">
                                <div class="btn-group">
                                    <span class="btn btn-xs widget-collapse"><i class="fa fa-angle-up fa-2x"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content no-padding">
                            <table class="table table-striped table-checkable table-hover">
                                <thead>
                                    <tr>
                                        <th> {{ Lang::get('home.baby_name') }}</th>
                                        <th class="align-center input-width-small">{{ Lang::get('home.mrn') }}</th>
                                        @if(isset($results['postnatal']) && is_array($write_permission) && in_array('POST_FORM',$write_permission))
                                            <th class="align-center input-width-small">{{ Lang::get('home.edit') }}</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (@count($results['postnatal']) > 0)
                                    @for ($i = 0; $i <  @count($results['postnatal']); $i++)
                                    <tr>
                                        <td >{{  $results['postnatal'][$i]->BabyName }}</td>
                                        <td class="align-center input-width-small">{{  $results['postnatal'][$i]->BMrNo }}</td>
                                        @if(isset($results['postnatal']) && is_array($write_permission) && in_array('POST_FORM',$write_permission))
                                            <td class="align-center input-width-small center-align-phone">
                                                <a class="btn btn-info btn-view" href="{{ action('Admission\PostnatalController@edit',SiteHelpers::encrypt_id($results['postnatal'][$i]->pid)) }}">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            </td>
                                        @endif
                                    </tr>
                                    @endfor
                                    @else
                                    <tr class="text-center">
                                        <td colspan="3"> No admission found </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                            <!-- /.row -->
                        </div>
                        <!-- /.widget-content -->
                    </div>
                    <!-- /.widget -->
                </div>
            </div>
        </div>
    </div>
    <!-- Controls -->
</div>
