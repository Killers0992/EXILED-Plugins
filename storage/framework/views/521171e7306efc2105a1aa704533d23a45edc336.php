

<?php $__env->startSection('title', 'EXILED Plugins | Edit plugin'); ?>

<?php $__env->startSection('content_header'); ?>
    <?php echo view('laravel-trix::trixassets')->render(); ?>
    <h1 class="m-0">Editing <?php echo e($plugin->name); ?> plugin</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="box box-primary">
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form role="form" action="<?php echo e(route('plugin.editchanges')); ?>" method="post">
                           <?php echo csrf_field(); ?>
                           <input type="text" name="pluginid" hidden="true" value="<?php echo e($plugin->id); ?>">
                          <div class="box-body">
                            <div class="form-group">
                              <label for="pluginname">Name</label>
                              <input type="text" class="form-control" name="pluginname" value="<?php echo e($plugin->name); ?>">
                            </div>
                            <div class="form-group">
                                <label for="pluginname">Small description</label>
                                <input type="text" class="form-control" name="pluginsmalldescription" value="<?php echo e($plugin->small_description); ?>">
                            </div>
                            <input id="plugindescription" type="text" hidden="true" name="plugindescription" value="<?php echo e($plugin->description); ?>">
                            <div class="form-group">
                                <label for="pluginname">Description</label><br>
                                <div class="bg-gray">
                                    <trix-editor input="plugindescription"></trix-editor>
                                </div>
                                
                            </div>
                            <div class="form-group">
                                <label for="category">Category</label>
                                <select class="form-control" name="category" id="category">
                                    <option <?php echo e($plugin->category == 0 ? 'selected' : ''); ?> value="0">None</option>
                                    <option <?php echo e($plugin->category == 1 ? 'selected' : ''); ?> value="1">Features</option>
                                    <option <?php echo e($plugin->category == 2 ? 'selected' : ''); ?> value="2">Utility</option>
                                    <option <?php echo e($plugin->category == 3 ? 'selected' : ''); ?> value="3">Customization</option>
                                    <option <?php echo e($plugin->category == 4 ? 'selected' : ''); ?> value="4">Reworks</option>
                                    <option <?php echo e($plugin->category == 4 ? 'selected' : ''); ?> value="5">SCPs</option>
                                    <option <?php echo e($plugin->category == 4 ? 'selected' : ''); ?> value="6">Dev Tool</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="pluginname">Image url</label>
                                <input type="text" class="form-control" name="pluginimage" value="<?php echo e($plugin->image_url); ?>">
                            </div>
                            <div class="form-group">
                                <label for="pluginname">Wiki url</label>
                                <input type="text" class="form-control" name="pluginwiki" value="<?php echo e($plugin->wiki_url); ?>">
                            </div>
                            <div class="form-group">
                                <label for="pluginname">Issues url</label>
                                <input type="text" class="form-control" name="pluginissues" value="<?php echo e($plugin->issues_url); ?>">
                            </div>
                            <div class="form-group">
                                <label for="pluginname">Source url</label>
                                <input type="text" class="form-control" name="pluginsource" value="<?php echo e($plugin->source_url); ?>">
                            </div>
                          </div>
                          <!-- /.box-body -->
            
                          <div class="box-footer">
                            <button type="submit" class="btn btn-success">Save changes</button>
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
            <div class="card">
                <div class="card-body">
                    <div class="box box-primary">
                        <form role="form" action="<?php echo e(route('plugin.delete')); ?>" method="post">
                            <?php echo csrf_field(); ?>
                            <input type="text" name="pluginid" hidden="true" value="<?php echo e($plugin->id); ?>">
                           <div class="box-body">
                             <div class="form-group">
                               <label for="pluginname">Retype name of your plugin if you want to remove that plugin. <?php echo e($plugin->name); ?></label>
                               <input type="text" class="form-control" name="pluginname">
                             </div>
                           </div>
                           <!-- /.box-body -->
             
                           <div class="box-footer">
                             <button type="submit" class="btn btn-danger">Remove plugin</button>
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
Trix.config.lang.bold = 'Really Bold';
document.querySelector('button[data-trix-attribute="bold"]').setAttribute('title', 'Really Bold');
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/plugins/resources/views/editplugin.blade.php ENDPATH**/ ?>