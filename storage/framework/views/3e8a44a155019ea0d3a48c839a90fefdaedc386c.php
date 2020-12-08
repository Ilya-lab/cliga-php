<?php $__env->startSection('title'); ?>Пользователи системы <?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
<link href="<?php echo e(asset('js/datatables/jquery.dataTables.min.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(asset('js/datatables/buttons.bootstrap.min.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(asset('js/datatables/fixedHeader.bootstrap.min.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(asset('js/datatables/responsive.bootstrap.min.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(asset('js/datatables/scroller.bootstrap.min.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(asset('css/icheck/flat/green.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js_footer'); ?>
<script src="<?php echo e(asset('js/datatables/jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/datatables/dataTables.bootstrap.js')); ?>"></script>
<script src="<?php echo e(asset('js/datatables/dataTables.buttons.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/datatables/buttons.bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/datatables/jszip.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/datatables/pdfmake.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/datatables/vfs_fonts.js')); ?>"></script>
<script src="<?php echo e(asset('js/datatables/buttons.html5.min.js?ff2')); ?>"></script>
<script src="<?php echo e(asset('js/datatables/buttons.print.min.js?ff')); ?>"></script>
<script src="<?php echo e(asset('js/datatables/dataTables.fixedHeader.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/datatables/dataTables.keyTable.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/datatables/dataTables.responsive.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/datatables/responsive.bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/datatables/dataTables.scroller.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/icheck/icheck.min.js')); ?>"></script>

<script src="<?php echo e(asset('js/pace/pace.min.js')); ?>"></script>
<script>
    var handleDataTableButtons = function() {
            "use strict";
            0 !== $("#datatable-responsive").length && $("#datatable-responsive").DataTable({
                dom: "Bfrtip",
                buttons: [{
                    extend: "copy",
                    className: "btn-sm"
                }, {
                    extend: "excel",
                    className: "btn-sm"
                }, {
                    extend: "pdf",
                    className: "btn-sm"
                }, {
                    extend: "print",
                    className: "btn-sm"
                }],
                responsive: !0
            })
        },
        TableManageButtons = function() {
            "use strict";
            return {
                init: function() {
                    handleDataTableButtons()
                }
            }
        }();
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#datatable-responsive').DataTable();
    });
    TableManageButtons.init();
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php $__env->startComponent('components.main_block'); ?>
    <?php $__env->slot('title'); ?>Пользователи <?php $__env->endSlot(); ?>
    <?php $__env->slot('description'); ?>список пользователей системы <?php $__env->endSlot(); ?>
    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap responsive-utilities jambo_table bulk_action" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>#</th>
            <th>Имя пользователя</th>
            <th>Email</th>
            <th>Активен</th>
            <th>Дата регистрации</th>
            <th>Дата обновления</th>
            <th>Роли</th>
        </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="even pointer">
                <td class="align-content-center"><?php echo e($loop->index + 1); ?></td>
                <td><?php if($user->user_type == 1): ?> <strong><a href="<?php echo e(route('profile', [ 'id' => $user->id])); ?>"><?php echo e($user->name); ?></a></strong> <?php else: ?> <a href="<?php echo e(route('profile', [ 'id' => $user->id])); ?>"><?php echo e($user->name); ?></a> <?php endif; ?></td>
                <td><?php echo e($user->email); ?></td>
                <td class="a-center"><input type="checkbox" class="flat" disabled <?php if($user->active == 1): ?> checked <?php endif; ?>></td>
                <td class="a-center"><?php echo e(date('d.m.Y', strtotime($user->created_at))); ?></td>
                <td class="a-center"><?php echo e(date('d.m.Y', strtotime($user->updated_at))); ?></td>
                <td>&nbsp;</td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
<?php echo $__env->renderComponent(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>