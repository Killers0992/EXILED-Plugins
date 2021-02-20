

<?php $__env->startSection('title', 'EXILED Plugins | Plugin'); ?>

<?php $__env->startSection('content_header'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <a class="info-box bg-navy">
            <span class="info-box-icon"><img src="<?php echo e($plugin->image_url); ?>"></span>

            <div class="info-box-content">
                <span class="info-box-text"><?php echo e($plugin->name); ?> <b>made by</b> <?php echo e($plugin->user->nickname); ?></span>

                  <div class="flex flex-col">
                    <div class="flex my-1">
                        <code><span class="mr-2 text-xs text-gray-500"><?php echo e($plugin->downloads_count); ?> Downloads</span></code>
                        <code><span class="mr-2 text-xs text-gray-500">Updated <abbr><?php echo e($plugin->last_update); ?></abbr></span></code>
                        <code><span class="text-xs text-gray-500">Created <abbr><?php echo e($plugin->creation_date); ?></abbr></span></code>
                        <code><span class="text-xs text-gray-500">Exiled Version: <abbr><?php echo e($plugin->latest_exiled_version); ?></abbr></span></code>
                          
                          <?php if(is_null(Auth::user()) ? false : Auth::user()->steamid == $plugin->owner_steamid): ?>
                            <form method="get" action="<?php echo e(route('plugin.edit', ['id' => $plugin->id])); ?>">
                                <button type="submit" class="btn btn-block btn-primary bg-purple btn-xs" style="width: 150px; float: right;">Edit</button>
                            </form>
                            <?php endif; ?>
                    </div>
                    <?php echo $plugin->categorynice; ?>

                </div>
              </div>
              </span>
        </a>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="table text-center" style="border: none;">
                    <tbody>
                    <tr>
                        <td>
                            <a href="<?php echo e(route('plugin.view', ['id' => $plugin->id])); ?>">Description</a>
                        </td>
                        <td>
                            <a href="<?php echo e(route('plugin.view.files', ['id' => $plugin->id])); ?>">Files</a>
                        </td>
                        <?php if(!empty($plugin->issues_url)): ?>
                        <td>
                            <a href="<?php echo e($plugin->issues_url); ?>">Issues</a>
                        </td>
                        <?php endif; ?>
                        <?php if(!empty($plugin->wiki_url)): ?>
                        <td>
                            <a href="<?php echo e($plugin->wiki_url); ?>">Wiki</a>
                        </td>
                        <?php endif; ?>
                        <?php if(!empty($plugin->source_url)): ?>
                        <td>
                            <a href="<?php echo e($plugin->source_url); ?>">Source</a>
                        </td>
                        <?php endif; ?>
                    </tr>
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                   <?php echo $plugin->description; ?>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('adminlte_js'); ?>

<script>
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/plugins/resources/views/viewplugin.blade.php ENDPATH**/ ?>