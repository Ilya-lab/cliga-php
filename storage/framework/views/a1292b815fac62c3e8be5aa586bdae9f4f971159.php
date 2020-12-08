<?php $__env->startSection('title'); ?>Регистрация нового пользователя <?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?><link rel="stylesheet" href="<?php echo e(asset('css/switchery/switchery.min.css')); ?>" /> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<?php $__env->startComponent('components.main_block'); ?>
    <?php $__env->slot('title'); ?>Регистрация <?php $__env->endSlot(); ?>
    <?php $__env->slot('description'); ?>нового пользователя системы <?php $__env->endSlot(); ?>
    <form method="POST" action="<?php echo e(route('register')); ?>" class="form-horizontal form-label-left">
        <?php echo csrf_field(); ?>

        <div class="form-group row">
            <label for="name" class="control-label col-md-3 col-sm-3 col-xs-12">Имя пользователя</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="name" type="text" class="has-feedback-left form-control<?php echo e($errors->has('name') ? ' is-invalid' : ''); ?>" name="name" value="<?php echo e(old('name')); ?>" required autofocus>
                <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                <?php if($errors->has('name')): ?>
                    <ul class="parsley-errors-list filled" id="parsley-id-7"><li class="parsley-required"><?php echo e($errors->first('name')); ?></li></ul>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-group row">
            <label for="email" class="control-label col-md-3 col-sm-3 col-xs-12">E-Mail</label>

            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="email" type="email" class="has-feedback-left form-control<?php echo e($errors->has('email') ? ' is-invalid' : ''); ?>" name="email" value="<?php echo e(old('email')); ?>" required>
                <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                <?php if($errors->has('email')): ?>
                    <ul class="parsley-errors-list filled" id="parsley-id-7"><li class="parsley-required"><?php echo e($errors->first('email')); ?></li></ul>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-group row">
            <label for="password" class="control-label col-md-3 col-sm-3 col-xs-12">Пароль</label>

            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="password" type="password" class="has-feedback-left form-control<?php echo e($errors->has('password') ? ' is-invalid' : ''); ?>" name="password" required>
                <span class="fa fa-terminal form-control-feedback left" aria-hidden="true"></span>
                <?php if($errors->has('password')): ?>
                    <ul class="parsley-errors-list filled" id="parsley-id-7"><li class="parsley-required"><?php echo e($errors->first('password')); ?></li></ul>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-group row">
            <label for="password-confirm" class="control-label col-md-3 col-sm-3 col-xs-12">Подтверждение пароля</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="password-confirm" type="password" class="has-feedback-left form-control" name="password_confirmation" required>
                <span class="fa fa-terminal form-control-feedback left" aria-hidden="true"></span>
            </div>
        </div>
        <div class="form-group row">
            <label for="admin" class="control-label col-md-3 col-sm-3 col-xs-12">Администратор системы</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <label>
                    <input id="admin" name="user_type" type="checkbox" class="js-switch" />
                </label>
            </div>
        </div>
        <div class="form-group row">
            <label for="user_active" class="control-label col-md-3 col-sm-3 col-xs-12">Включен</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <label>
                    <input id="user_active" name="active" type="checkbox" class="js-switch" checked />
                </label>
            </div>
        </div>
        <div class="ln_solid"></div>
        <div class="form-group row mb-0">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <button type="submit" class="btn btn-primary">
                    Зарегистрировать
                </button>
            </div>
        </div>
    </form>
<?php echo $__env->renderComponent(); ?>
<script src="<?php echo e(asset('js/switchery/switchery.min.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>