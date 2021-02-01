@extends('adminlte::page')

@section('title', 'EXILED Plugins | Plugin')

@section('content_header')
@stop

@section('content')
    <div class="row">
        <a class="info-box bg-navy">
            <span class="info-box-icon"><img src="{{$plugin->image_url}}"></span>

            <div class="info-box-content">
                <span class="info-box-text">{{$plugin->name}} <b>made by</b> {{$plugin->user->nickname}}</span>

                <div class="flex flex-col">
                    <div class="flex my-1">
                        <span class="mr-2 text-xs text-gray-500">{{$plugin->downloads_count}}
                            Downloads
                        </span>
                        <span class="mr-2 text-xs text-gray-500">Updated:
                          <abbr>{{$plugin->last_update}}</abbr>
                        </span>
                        <span class="text-xs text-gray-500">Exiled Version:
                            <abbr>{{$plugin->latest_exiled_version}}</abbr>
                          </span>
                          @if(is_null(Auth::user()) ? false : Auth::user()->steamid == $plugin->owner_steamid)
                          <form method="get" action="{{route('plugin.edit', ['id' => $plugin->id])}}">
                              <button type="submit" class="btn btn-block btn-primary bg-purple btn-xs" style="width: 150px; float: right;">Edit</button>
                          </form>
                          @endif
                    </div>
                    {!!$plugin->categorynice!!}

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
                            <a href="{{ route('plugin.view', ['id' => $plugin->id])}}">Description</a>
                        </td>
                        <td>
                            <a href="">Files</a>
                        </td>
                        @if(!empty($plugin->issues_url))
                        <td>
                            <a href="{{$plugin->issues_url}}">Issues</a>
                        </td>
                        @endif
                        @if(!empty($plugin->wiki_url))
                        <td>
                            <a href="{{$plugin->wiki_url}}">Wiki</a>
                        </td>
                        @endif
                        @if(!empty($plugin->source_url))
                        <td>
                            <a href="{{$plugin->source_url}}">Source</a>
                        </td>
                        @endif
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
                            @foreach ($files as $file)
                                <tr>
                                    <td>{!!$file->typenice!!}</td>
                                    <td>{{$file->file_name}} - {{$file->version}}</td>
                                    <td>{!!$file->filesizenice!!}</td>
                                    <td>{{$file->upload_time}}</td>
                                    <td>{{$file->exiled_version}}</td>
                                    <td>{{$file->downloads_count}}</td>
                                    <td class="text-left">

                                        @if(is_null(Auth::user()) ? false : Auth::user()->steamid == $plugin->owner_steamid)
                                        <form role="form" action="{{ route('plugin.delete.file', ['id' => $plugin->id]) }}" method="post">
                                            @csrf
                                            <input hidden="true" name="fileid" value="{{$file->file_id}}">
                                            <button type="submit">
                                                <abbr title="Delete"><i class="text-danger fas fa-ban"></i></abbr>
                                            </button>
                                        </form>
                                        @endif
                                        <a type="submit" href="{{ route('plugin.download.file', ['id' => $plugin->id, 'fileid' => $file->file_id]) }}">
                                            <abbr title="Download"><i class="text-success fas fa-download"></i></abbr>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                    </table>
                    @if($files->count() == 0)
                    <div class="text-center">
                        <a>No files found.</a>
                    </div>
                    @endif
                </div>
                @if($files->hasPages())
                <div class="card-footer">
                    <div class="col-md-12 text-center">{{ $files->appends(request()->except('page'))->links() }}</div>
                </div>
            @endif
            </div>
        </div>
    </div>
    @if (is_null(Auth::user()) ? false : Auth::user()->steamid == $plugin->owner_steamid)
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    Upload file
                    <form role="form" action="{{ route('plugin.upload.file', ['id' => $plugin->id]) }}" method="post">
                        @csrf
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
                       @if (count($errors) > 0)
                         <br>
                         <div class="alert alert-danger alert-dismissible">
                         <h5><i class="icon fas fa-exclamation-triangle"></i> Error:</h5>
                             <ul>
                                 @foreach ($errors->all() as $error)
                                     <li>{{ $error }}</li>
                                 @endforeach
                             </ul>
                         </div>
                         @endif
                     </form>
                </div>
            </div>
        </div>
    </div>
    @endif
@stop

@section('adminlte_js')

<script>
</script>
@stop