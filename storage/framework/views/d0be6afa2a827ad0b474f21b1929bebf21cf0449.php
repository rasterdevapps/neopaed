<?php $__env->startSection('content'); ?>
<?php $write_permission = session('write_permission'); ?>
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb ">
        <li>
            <i class="icon-home"></i>
            <a href="<?php echo e(url('/'), false); ?>">Dashboard</a>
        </li>
        <li class="current">
            <a href="<?php echo e(action('Admission\PediatricController@index'), false); ?>">Pediatric Admission</a>
        </li>
    </ul>
    <ul class="pull-right nicu-list discharge-color-code1 list-none hide">
        <li>
            <a class='btn btn-info btn-basic-shadow search-btn' href="<?php echo e(action('Search\PediatricController@create').'?module=admission', false); ?>">
                <i class="fa fa-search"></i>  
                <span>Advanced Search</span>
            </a>
        </li>
    </ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
    <div class="col-md-12">
        <div class="widget box table-view-shadow">
            <div class="widget-header">
                <h4>Pediatric Admission</h4>
                <?php if(in_array('PEDI_FORM',$write_permission)): ?>
                <a href="<?php echo e(action('Admission\PediatricController@show',SiteHelpers::encrypt_id(0)).'/create', false); ?>" title="" class="btn btn-info btn-basic-shadow pull-right create-btn-spacing"><i class="fa fa-plus"></i><span>Create New</span></a>  
                <?php endif; ?>                              
            </div>
            <div class="widget-content">
                <div id="data-list_wrapper" class="dataTables_wrapper form-inline" role="grid">
                    <div class="row">
                        <div class="dataTables_header clearfix">
                            <div class="col-xs-4 col-sm-6 col-md-6">
                                <div id="data-list_length" class="dataTables_length">
                                    <label class="data_limit">
                                        <?php echo Form::open(['url' => action('Admission\PediatricController@index'), 'method' => 'get', 'id' => 'limit-form']); ?>

                                        <select name="limit" size="1" aria-controls="data-list">
                                            <option value="10" <?php if($pagination['limits'] == 10): ?> selected="selected" <?php endif; ?>  >10</option>
                                            <option value="25" <?php if($pagination['limits'] == 25): ?> selected="selected" <?php endif; ?>>25</option>
                                            <option value="50" <?php if($pagination['limits'] == 50): ?> selected="selected" <?php endif; ?>>50</option>
                                            <option value="100" <?php if($pagination['limits'] == 100): ?> selected="selected" <?php endif; ?>>100</option>
                                            <option value="1000" <?php if($pagination['limits'] == 1000): ?> selected="selected" <?php endif; ?>>All</option>
                                        </select>
                                        <span class="hidden-xs">records per page</span>
                                        <?php echo Form::hidden('sortby',SiteHelpers::encrypt_id($order['sortby']),['id'=>'sortby']); ?>

                                        <?php echo Form::hidden('sortorder',$order['sortorder'],['id'=>'sortorder']); ?>

                                        <?php echo Form::close(); ?>

                                    </label>
                                </div>
                            </div>
                            <?php echo Form::open(['url' => action('Admission\PediatricController@index'), 'method' => 'get', 'id' => 'search-form','class' => 'search_form']); ?>

                            <div class="col-xs-8 col-sm-6 col-md-4 pull-right">
                                <div class="input-group">
                                    <span id="search" class="input-group-addon">
                                        <i class="glyphicon glyphicon-search"></i>
                                    </span>
                                    <input type="text" aria-controls="data-list" class="form-control" name="search_txt" value="<?php echo e($search['search_txt'], false); ?>" placeholder="Search">
                                    <a href="<?php echo e(action('Admission\PediatricController@index'), false); ?>" class="input-group-addon">
                                        <i class="glyphicon glyphicon-remove"></i>
                                    </a>
                                </div>
                            </div>
                            <?php echo Form::close(); ?>

                        </div>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-responsive" id="data-list">
                    <thead>
                        <tr>
                            <th class="sorting_by sorting_icon <?php if($order['sortby'] == 'BabyName'): ?> sorting_<?php echo e($order['sortorder'], false); ?>_icon <?php endif; ?>" data-field="<?php echo e(SiteHelpers::encrypt_id('BabyName'), false); ?>">BabyName</th>
                            <th class="sorting_by sorting_icon <?php if($order['sortby'] == 'BMrNo'): ?> sorting_<?php echo e($order['sortorder'], false); ?>_icon <?php endif; ?> hidden-xs" data-field="<?php echo e(SiteHelpers::encrypt_id('BMrNo'), false); ?>"><?php echo e(Lang::get('home.mrn'), false); ?></th>
                            <th class="sorting_by sorting_icon <?php if($order['sortby'] == 'DOB'): ?> sorting_<?php echo e($order['sortorder'], false); ?>_icon <?php endif; ?>" data-field="<?php echo e(SiteHelpers::encrypt_id('DOB'), false); ?>">DOB</th>
                            <th class="center-align-phone">DOA</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($results) > 0): ?>
                        <?php for($i = 0; $i <  @count($results); $i++): ?>
                        <tr>
                            <td>
                                <a class="icon" href="<?php echo e(action('Admission\PediatricController@sublist',\SiteHelpers::encrypt_id($results[$i]->BabyId)), false); ?>">
                                    <?php echo e($results[$i]->BabyName, false); ?>

                                </a>
                            </td>
                            <td class="hidden-xs"><?php echo e($results[$i]->BMrNo, false); ?></td>
                            <td><?php echo e(date('d-m-Y',strtotime($results[$i]->DOB)), false); ?></td>
                            <td>
                                <?php $admissondate = ''; ?>
                                <?php if(isset($admission_date_list[$results[$i]->BMrNo])): ?>    
                                <?php $__currentLoopData = $admission_date_list[$results[$i]->BMrNo]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $admission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php 
                                        $admissondate .= 'Admission ' . ($key+1) . '  :  ' . date("d-m-Y",strtotime($admission->admission_date)) . '<br/>';
                                    ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>  
                                <i class="fa fa-calendar bs-tooltip admission-date" data-placement="left" data-original-title="<?php echo $admissondate; ?>" aria-hidden="true"></i>
                            </td>
                        </tr>
                        <?php endfor; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center"><span>No Record Found</span></td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-md-12">
                        <div class="dataTables_footer clearfix">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="dataTables_info pagination_info" id="DataTables_Table_0_info">
                                    Showing <?php echo e($pagination['limit'][0], false); ?> to <?php echo e($pagination['limit'][1], false); ?> of <?php echo e($pagination['total'], false); ?> entries <?php echo e($search['search_txt'] != '' ? '(filtered from '. $getTotal .' total entries)' : '', false); ?>

                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="dataTables_paginate paging_bootstrap pagination_footer">
                                    <ul class="pagination">
                                        <li class="prev <?php if(Request::query('page') == '' || Request::query('page') == $pagination['start']): ?> disabled <?php endif; ?>">
                                            <a class="<?php if(Request::query('page') != $pagination['start'] &&  Request::query('page') != ''): ?> sort_with_page <?php endif; ?>" href="<?php if(Request::query('page') == $pagination['start'] || Request::query('page') == ''): ?> javascript:void(0); <?php else: ?> <?php echo e(url('pediatric-admission?page='.$pagination['previous']), false); ?><?php endif; ?>">&#8592; Previous</a>
                                        </li>
                                        <?php for($i = $pagination['start']; $i <= $pagination['end']; $i++): ?> 
                                        <li class="<?php if($i == Request::query('page')): ?> active <?php elseif(Request::query('page') == '' && $i == $pagination['start']): ?> active <?php endif; ?>">
                                            <a class='sort_with_page' href="<?php echo e(url('pediatric-admission?page='.$i), false); ?>"><?php echo e($i, false); ?></a>
                                        </li>
                                        <?php endfor; ?>
                                        <li class="next <?php if(Request::query('page') == $pagination['end'] || $pagination['total'] <= $pagination['limits']): ?> disabled <?php endif; ?>">
                                            <a class="<?php if(Request::query('page') != $pagination['end'] && $pagination['start'] != $pagination['end']): ?> sort_with_page <?php endif; ?>" href="<?php if(Request::query('page') == $pagination['end'] || $pagination['total'] <= $pagination['limits']): ?> javascript:void(0); <?php else: ?> <?php echo e(url('pediatric-admission?page='.$pagination['next']), false); ?><?php endif; ?>">Next &#8594; </a>  
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.col-md-12 -->
</div>
<!-- /.row -->
<!-- /Page Content -->
<?php echo Form::open(['method'=> 'DELETE','url' => '','id'=>'DeleteForm']); ?>

<?php echo Form::close(); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script type="text/javascript">
    $('#search').click(function() {
        $('#search-form').submit();
    });
    $('.sorting_by').on('click', function(e) {
        e.preventDefault();
        var sortby = $(this).data('field');
        pagination(sortby);
    });
    $('.sort_with_page').click(function(e) {
        e.preventDefault();
        var sorting_param = $('#limit-form').serialize();
        var link = $(this).attr('href');
        var searchText = $('input[name="search_txt"]').val();
        window.location = link + '&search_txt=' + searchText + '&' + sorting_param;
    });
    $('select[name="limit"]').on('change', function(e) {
        e.preventDefault();
        pagination();
    });

    function pagination(sortby) {
        var pagination_url = $('#limit-form').attr('action');
        var limit = $('select[name="limit"] option:selected').val();
        var searchText = $('input[name="search_txt"]').val();
        var sorting_param = $('#limit-form').serialize();
        var sorting_param1 = sorting_param.split('&sortorder=')[0];
        var sorting_param2 = sorting_param.split('&sortorder=')[1];
        if (sortby) {
            $('#sortby').val(sortby);
            if (sorting_param2 == 'desc') {
                var sortorder = 'asc';
                $('#sortorder').val(sortorder);
            } else {
                var sortorder = 'desc';
                $('#sortorder').val(sortorder);
            }
            window.location = pagination_url + '?page=1&search_txt=' + searchText + '&limit=' + limit + '&sortby=' + sortby + '&sortorder=' + sortorder;
        } else {
            window.location = pagination_url + '?page=1&search_txt=' + searchText + '&' + sorting_param;
        }
    }
   $('.admission-date').tooltip({ html: true });
    
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>