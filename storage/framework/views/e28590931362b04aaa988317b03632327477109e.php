

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
                        <span class="mr-2 text-xs text-gray-500"><?php echo e($plugin->downloads_count); ?>

                            Downloads
                        </span>
                        <span class="mr-2 text-xs text-gray-500">Updated:
                          <abbr><?php echo e($plugin->last_update); ?></abbr>
                        </span>
                        <span class="text-xs text-gray-500">Exiled Version:
                            <abbr><?php echo e($plugin->latest_exiled_version); ?></abbr>
                          </span>
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
                            <a href="">Files</a>
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
                    Recent files:
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>File name</th>
                                <th>Size</th>
                                <th>Uploaded</th>
                                <th>Exiled Version</th>
                                <th>Downloads</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo $file->typenice; ?></td>
                                    <td><?php echo e($file->file_name); ?> - <?php echo e($file->version); ?></td>
                                    <td><?php echo $file->filesizenice; ?></td>
                                    <td><?php echo e($file->upload_time); ?></td>
                                    <td><?php echo e($file->exiled_version); ?></td>
                                    <td><?php echo e($file->downloads_count); ?></td>
                                    <td class="text-left">

                                        <?php if(is_null(Auth::user()) ? false : Auth::user()->steamid == $plugin->owner_steamid): ?>
                                        <form role="form" action="<?php echo e(route('plugin.delete.file', ['id' => $plugin->id])); ?>" method="post">
                                            <?php echo csrf_field(); ?>
                                            <input hidden="true" name="fileid" value="<?php echo e($file->file_id); ?>">
                                            <button type="submit">
                                                <abbr title="Delete"><i class="text-danger fas fa-ban"></i></abbr>
                                            </button>
                                        </form>
                                        <?php endif; ?>
                                        <a type="submit" href="<?php echo e(route('plugin.download.file', ['id' => $plugin->id, 'fileid' => $file->file_id])); ?>">
                                            <abbr title="Download"><i class="text-success fas fa-download"></i></abbr>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                    </table>
                    <?php if($files->count() == 0): ?>
                    <div class="text-center">
                        <a>No files found.</a>
                    </div>
                    <?php endif; ?>
                </div>
                <?php if($files->hasPages()): ?>
                <div class="card-footer">
                    <div class="col-md-12 text-center"><?php echo e($files->appends(request()->except('page'))->links()); ?></div>
                </div>
            <?php endif; ?>
            </div>
        </div>
    </div>
    <?php if(is_null(Auth::user()) ? false : Auth::user()->steamid == $plugin->owner_steamid): ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    Upload file
                    <form role="form" action="<?php echo e(route('plugin.upload.file', ['id' => $plugin->id])); ?>" method="post">
                        <?php echo csrf_field(); ?>
                       <div class="box-body">
                        <div class="form-group">
                            <label for="pluginname">Type</label>
                            <select class="form-control" name="type" id="type">
                                <option selected="" value="0">Release</option>
                                <option value="1">Beta</option>
                                <option value="2">Alpha</option>
                              </select>
                         </div>
                         <div class="form-group">
                           <label for="pluginname">Exiled version</label>
                           <input type="text" class="form-control" name="exiledversion" id="pluginname" placeholder="2.0.0">
                         </div>
                         <div class="form-group">
                            <label for="pluginname">Version</label>
                            <input type="text" class="form-control" name="version" id="pluginname" placeholder="1.0.0">
                          </div>
                         <div class="form-group">
                            <label for="pluginname">Changelog</label>
                            <input type="text" class="form-control" name="changelog" id="changelog" placeholder="No changelog">
                          </div>
                          <div class="form-group">
                            <label for="pluginname">File URL</label>
                            <input type="text" class="form-control" name="fileurl" id="changelog" placeholder="https://host.host/plugin.dll">
                          </div>
                       </div>
                       <!-- /.box-body -->
         
                       <div class="box-footer">
                         <button type="submit" class="btn btn-success">Upload</button>
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
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('adminlte_js'); ?>

<script>
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/plugins/resources/views/viewpluginfiles.blade.php ENDPATH**/ ?>