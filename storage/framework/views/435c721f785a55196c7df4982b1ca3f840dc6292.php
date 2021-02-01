<?php $layoutHelper = app('\JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper'); ?>

<?php if($layoutHelper->isLayoutTopnavEnabled()): ?>
    <?php ( $def_container_class = 'container' ); ?>
<?php else: ?>
    <?php ( $def_container_class = 'container-fluid' ); ?>
<?php endif; ?>

<?php $__env->startSection('adminlte_css'); ?>
    <?php echo $__env->yieldPushContent('css'); ?>
    <?php echo $__env->yieldContent('css'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(config('LaravelLogger.fontAwesomeCDN')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(config('LaravelLogger.loggerDatatablesCSScdn')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(config('LaravelLogger.bootstrapCssCDN')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('main.css')); ?>">

<?php $__env->stopSection(); ?>

<?php $__env->startSection('classes_body', $layoutHelper->makeBodyClasses()); ?>

<?php $__env->startSection('body_data', $layoutHelper->makeBodyData()); ?>

<?php $__env->startSection('body'); ?>
    <div class="wrapper">

        
        <?php if($layoutHelper->isLayoutTopnavEnabled()): ?>
            <?php echo $__env->make('adminlte::partials.navbar.navbar-layout-topnav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php else: ?>
            <?php echo $__env->make('adminlte::partials.navbar.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>

        
        <?php if(!$layoutHelper->isLayoutTopnavEnabled()): ?>
            <?php echo $__env->make('adminlte::partials.sidebar.left-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>

        
        <div id="content-wrapper-new" class="content-wrapper <?php echo e(config('adminlte.classes_content_wrapper') ?? ''); ?>">

            
            <div class="content-header">
                <div class="<?php echo e(config('adminlte.classes_content_header') ?: $def_container_class); ?>">
                    <?php echo $__env->yieldContent('content_header'); ?>
                </div>
            </div>

            
            <div class="content">
                <div class="<?php echo e(config('adminlte.classes_content') ?: $def_container_class); ?>">
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
            </div>

        </div>
        <?php $__env->startSection('footer'); ?>
        <div class="pull-right small text-gray" style="margin-right:10px;margin-top:-7px;">
        </div>
        <small>Copyright © 2021 Exiled Plugins</a> | Created by <a href="https://steamcommunity.com/id/Killers0992/">Killers0992</a></small>
        <?php $__env->stopSection(); ?>

        
        <?php if (! empty(trim($__env->yieldContent('footer')))): ?>
            <?php echo $__env->make('adminlte::partials.footer.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>

        
        <?php if(config('adminlte.right_sidebar')): ?>
            <?php echo $__env->make('adminlte::partials.sidebar.right-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('adminlte_js'); ?>
    <?php echo $__env->yieldPushContent('js'); ?>
    <?php echo $__env->yieldContent('js'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/plugins/resources/views/vendor/adminlte/page.blade.php ENDPATH**/ ?>