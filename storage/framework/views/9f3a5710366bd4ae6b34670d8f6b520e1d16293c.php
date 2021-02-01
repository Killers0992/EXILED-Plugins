

<?php $__env->startSection('title', 'EXILED Plugins | Add plugin'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1 class="m-0">Add Plugin</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="box box-primary">
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form role="form" action="<?php echo e(route('plugin.create')); ?>" method="post">
                           <?php echo csrf_field(); ?>
                          <div class="box-body">
                            <div class="form-group">
                              <label for="pluginname">Plugin name</label>
                              <input type="text" class="form-control" name="pluginname" id="pluginname" placeholder="Example Plugin">
                            </div>
                            <div class="checkbox">
                              <label>
                                <input type="checkbox" name="plugincheck" id="plugincheck"> Accept rules of plugin policy.
                              </label>
                            </div>
                          </div>
                          <!-- /.box-body -->
            
                          <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                          </div>
                          <?php if(count($errors) > 0): ?>
                            <br>
                            <div class="alert alert-danger alert-dismissible">
                            <h5><i class="icon fas fa-exclamation-triangle"></i> Error:</h5>
                                <ul>
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                            <?php endif; ?>
                        </form>
                      </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('adminlte_js'); ?>

<script>
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/plugins/resources/views/addplugin.blade.php ENDPATH**/ ?>