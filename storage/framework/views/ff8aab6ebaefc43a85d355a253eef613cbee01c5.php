<?php $__env->startSection('title', 'EXILED Plugins | Plugins'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1 class="m-0">Plugins</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    Total plugins: <?php echo e($count); ?>

                </div>
            </div>
            <div class="card">
              <div class="card-body">

                <form action="<?php echo e(route('home')); ?>" method="GET">
                  <div class="input-group input-group-sm">
                      <input type="text" name="query" class="form-control float-right" value="" placeholder="Search plugin by name.">
                      <div class="input-group-append">
                          <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                      </div>
                  </div>
                  </form>

              </div>
          </div>
            <div class="card">
              <div class="card-body">
                
                <table class="table table-hover text-nowrap">
                  <tbody>
                        <?php if($count == 0): ?>
                        <tr>
                          <td>

                            <div class="info-box bg-navy">
                              <div class="info-box-content">
                                <span class="info-box-text text-center">Plugin list is empty.</span>
                              </div>

                          </td>
                      </tr>
                        <?php endif; ?>
                        <?php $__currentLoopData = $plugins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plugin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                              <a class="info-box bg-navy" href="<?php echo e(route('plugin.view', ['id' => $plugin->id])); ?>">
                                <span class="info-box-icon"><img src="<?php echo e($plugin->image_url); ?>"></span>
                    
                                <div class="info-box-content">
                                  <span class="info-box-text"><?php echo e($plugin->name); ?> <b>made by</b> <?php echo e($plugin->user->nickname); ?></span>

                                      <div class="flex flex-col">
                                        <div class="flex my-1">
                                            <span class="mr-2 text-xs text-gray-500"><?php echo e($plugin->downloads_count); ?>

                                                Downloads
                                            </span>
                                            <span class="mr-2 text-xs text-gray-500">Updated
                                              <abbr><?php echo e($plugin->last_update); ?></abbr>
                                            </span>
                                            <span class="text-xs text-gray-500">Created 
                                              <abbr><?php echo e($plugin->creation_date); ?></abbr>
                                            </span>
                                        </div>
                                        <p class="text-sm leading-snug">
                                          <?php echo e($plugin->small_description); ?>

                                        </p>
                                        <?php echo $plugin->categorynice; ?>

                                        <?php if(!empty($plugin->latest_file_id)): ?>
                                        <form method="get" action="<?php echo e(route('plugin.download.file', ['id' => $plugin->id, 'fileid' => $plugin->latest_file_id])); ?>">
                                          <button type="submit" class="btn btn-block btn-primary bg-purple btn-xs" style="width: 150px; float: right;">Download</button>
                                        </form>
                                        <?php else: ?>
                                        <button type="submit" class="btn btn-block btn-primary bg-purple btn-xs" style="width: 150px; float: right;">Download</button>
                                        <?php endif; ?>
                                      </div>
                                  </div>
                                  </span>
                                </a>

                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </tbody>
              </table>

              </div>
              <?php if($plugins->hasPages()): ?>
              <div class="card-footer">
                  <div class="col-md-12 text-center"><?php echo e($plugins->appends(request()->except('page'))->links()); ?></div>
              </div>
          <?php endif; ?>
          </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('adminlte_js'); ?>

<script>
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/plugins/resources/views/home.blade.php ENDPATH**/ ?>