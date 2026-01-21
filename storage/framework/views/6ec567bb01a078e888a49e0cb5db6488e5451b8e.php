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
            <?php echo $__env->make('status_report_chart', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
        <div class="item">
            <?php echo $__env->make('year_wise_status_report_chart', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
        <div class="item">
            <div class="row row-spacing">
                <div class="col-md-6 col-sm-6">
                    <div class="widget box homepage-overview-board">
                        <div class="widget-header">
                            <h4>
                                <span href="<?php echo e(action('Registration\BabyController@index'), false); ?>">
                                    <i class="fa fa-reorder"></i>
                                </span> <?php echo e(Lang::get('home.recent_baby_registration'), false); ?>

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
                                        <th><?php echo e(Lang::get('home.baby_name'), false); ?></th>
                                        <th class="align-center input-width-small"><?php echo e(Lang::get('home.mrn'), false); ?></th>
                                        <?php if($results['baby'] && is_array($write_permission) && in_array('BABY_REG',$write_permission)): ?>
                                            <th class="align-center input-width-small"><?php echo e(Lang::get('home.edit'), false); ?></th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(@count($results['baby']) > 0): ?>
                                    <?php for($i = 0; $i <  @count($results['baby']); $i++): ?>
                                    <?php if($results['baby'][$i]->BabyName != '' && $results['baby'][$i]->BMrNo != ''): ?>
                                    <tr>
                                        <td ><?php echo e($results['baby'][$i]->BabyName, false); ?></td>
                                        <td class="align-center input-width-small"><?php echo e($results['baby'][$i]->BMrNo, false); ?></td>
                                        <?php if($results['baby'] && is_array($write_permission) && in_array('BABY_REG',$write_permission)): ?>
                                            <td class="align-center input-width-small center-align-phone">
                                                <a class="btn btn-info btn-view" href="<?php echo e(action('Registration\BabyController@edit', SiteHelpers::encrypt_id($results['baby'][$i]->BabyId)), false); ?>">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                    <?php endif; ?>  
                                    <?php endfor; ?>
                                    <?php else: ?>
                                    <tr class="text-center">
                                        <td colspan="3"> No registration found</td>
                                    </tr>
                                    <?php endif; ?>
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
                                <span href="<?php echo e(action('Registration\OpController@index'), false); ?>">
                                    <i class="fa fa-reorder"></i>
                                </span> <?php echo e(Lang::get('home.recent_op_registration'), false); ?>

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
                                        <th > <?php echo e(Lang::get('home.baby_name'), false); ?></th>
                                        <th class="align-center input-width-small"><?php echo e(Lang::get('home.mrn'), false); ?></th>
                                        <?php if($results['op'] && is_array($write_permission) && in_array('OP_REG',$write_permission)): ?>
                                            <th class="align-center input-width-small"><?php echo e(Lang::get('home.edit'), false); ?></th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(@count($results['op']) > 0): ?>
                                    <?php for($i = 0; $i <  @count($results['op']); $i++): ?>
                                    <tr>
                                        <td ><?php echo e($results['op'][$i]->BabyName, false); ?></td>
                                        <td class="align-center input-width-small"><?php echo e($results['op'][$i]->BMrNo, false); ?></td>
                                        <?php if($results['op'] && is_array($write_permission) && in_array('OP_REG',$write_permission)): ?>
                                            <td class="align-center input-width-small center-align-phone">
                                                <a class="btn btn-info btn-view" href="<?php echo e(action('Registration\OpController@edit', SiteHelpers::encrypt_id($results['op'][$i]->OpId)), false); ?>">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                    <?php endfor; ?>
                                    <?php else: ?>
                                    <tr class="text-center">
                                        <td colspan="3"> No registration found</td>
                                    </tr>
                                    <?php endif; ?>
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
                                <span href="<?php echo e(action('Admission\NicuController@index'), false); ?>">
                                    <i class="fa fa-reorder"></i>
                                </span> <?php echo e(Lang::get('home.recent_nicu_admission'), false); ?>

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
                                        <th > <?php echo e(Lang::get('home.baby_name'), false); ?></th>
                                        <th class="align-center input-width-small"><?php echo e(Lang::get('home.mrn'), false); ?></th>
                                        <?php if(isset($results['nicu']) && is_array($write_permission) && in_array('NICU_FORM',$write_permission)): ?>
                                            <th class="align-center input-width-small"><?php echo e(Lang::get('home.edit'), false); ?></th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(@count($results['nicu']) > 0): ?>
                                    <?php for($i = 0; $i <  @count($results['nicu']); $i++): ?>
                                    <?php if($results['nicu'][$i]->BMrNo != ''): ?>
                                    <tr>
                                        <td ><?php echo e($results['nicu'][$i]->BabyName, false); ?></td>
                                        <td class="align-center input-width-small"><?php echo e($results['nicu'][$i]->BMrNo, false); ?></td>
                                        <?php if(isset($results['nicu']) && is_array($write_permission) && in_array('NICU_FORM',$write_permission)): ?>
                                            <td class="align-center input-width-small center-align-phone">
                                                <a class="btn btn-info btn-view" href="<?php echo e(action('Admission\NicuController@edit',SiteHelpers::encrypt_id($results['nicu'][$i]->NicuId)), false); ?>">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                    <?php endif; ?>   
                                    <?php endfor; ?>
                                    <?php else: ?>
                                    <tr class="text-center">
                                        <td colspan="3"> No admission found</td>
                                    </tr>
                                    <?php endif; ?>
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
                                <span href="<?php echo e(action('Admission\NicuController@index'), false); ?>">
                                    <i class="fa fa-reorder"></i>
                                </span> <?php echo e(Lang::get('home.recent_postanatal_admission'), false); ?>

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
                                        <th> <?php echo e(Lang::get('home.baby_name'), false); ?></th>
                                        <th class="align-center input-width-small"><?php echo e(Lang::get('home.mrn'), false); ?></th>
                                        <?php if(isset($results['postnatal']) && is_array($write_permission) && in_array('POST_FORM',$write_permission)): ?>
                                            <th class="align-center input-width-small"><?php echo e(Lang::get('home.edit'), false); ?></th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(@count($results['postnatal']) > 0): ?>
                                    <?php for($i = 0; $i <  @count($results['postnatal']); $i++): ?>
                                    <tr>
                                        <td ><?php echo e($results['postnatal'][$i]->BabyName, false); ?></td>
                                        <td class="align-center input-width-small"><?php echo e($results['postnatal'][$i]->BMrNo, false); ?></td>
                                        <?php if(isset($results['postnatal']) && is_array($write_permission) && in_array('POST_FORM',$write_permission)): ?>
                                            <td class="align-center input-width-small center-align-phone">
                                                <a class="btn btn-info btn-view" href="<?php echo e(action('Admission\PostnatalController@edit',SiteHelpers::encrypt_id($results['postnatal'][$i]->pid)), false); ?>">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                    <?php endfor; ?>
                                    <?php else: ?>
                                    <tr class="text-center">
                                        <td colspan="3"> No admission found </td>
                                    </tr>
                                    <?php endif; ?>
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
