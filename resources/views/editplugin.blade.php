@extends('adminlte::page')

@section('title', 'EXILED Plugins | Edit plugin')

@section('content_header')
    @trixassets
    <h1 class="m-0">Editing {{$plugin->name}} plugin</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="box box-primary">
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form role="form" action="{{ route('plugin.editchanges') }}" method="post">
                           @csrf
                           <input type="text" name="pluginid" hidden="true" value="{{$plugin->id}}">
                          <div class="box-body">
                            <div class="form-group">
                              <label for="pluginname">Name</label>
                              <input type="text" class="form-control" name="pluginname" value="{{$plugin->name}}">
                            </div>
                            <div class="form-group">
                                <label for="pluginname">Small description</label>
                                <input type="text" class="form-control" name="pluginsmalldescription" value="{{$plugin->small_description}}">
                            </div>
                            <input id="plugindescription" type="text" hidden="true" name="plugindescription" value="{{$plugin->description}}">
                            <div class="form-group">
                                <label for="pluginname">Description</label><br>
                                <div class="bg-gray">
                                    <trix-editor input="plugindescription"></trix-editor>
                                </div>
                                
                            </div>
                            <div class="form-group">
                                <label for="category">Category</label>
                                <select class="form-control" name="category" id="category">
                                    @foreach($categories as $category)
                                    <option {{ $plugin->category == $category->id ? 'selected' : ''}} value="{{$category->id}}">{{$category->category_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="pluginname">Image url</label>
                                <input type="text" class="form-control" name="pluginimage" value="{{$plugin->image_url}}">
                            </div>
                            <div class="form-group">
                                <label for="pluginname">Wiki url</label>
                                <input type="text" class="form-control" name="pluginwiki" value="{{$plugin->wiki_url}}">
                            </div>
                            <div class="form-group">
                                <label for="pluginname">Issues url</label>
                                <input type="text" class="form-control" name="pluginissues" value="{{$plugin->issues_url}}">
                            </div>
                            <div class="form-group">
                                <label for="pluginname">Source url</label>
                                <input type="text" class="form-control" name="pluginsource" value="{{$plugin->source_url}}">
                            </div>
                          </div>
                          <!-- /.box-body -->
            
                          <div class="box-footer">
                            <button type="submit" class="btn btn-success">Save changes</button>
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
            <div class="card">
                <div class="card-body">
                    <div class="box box-primary">
                        <form role="form" action="{{ route('plugin.delete') }}" method="post">
                            @csrf
                            <input type="text" name="pluginid" hidden="true" value="{{$plugin->id}}">
                           <div class="box-body">
                             <div class="form-group">
                               <label for="pluginname">Retype name of your plugin if you want to remove that plugin. {{$plugin->name}}</label>
                               <input type="text" class="form-control" name="pluginname">
                             </div>
                           </div>
                           <!-- /.box-body -->
             
                           <div class="box-footer">
                             <button type="submit" class="btn btn-danger">Remove plugin</button>
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
    </div>
@stop

@section('adminlte_js')

<script>
Trix.config.lang.bold = 'Really Bold';
document.querySelector('button[data-trix-attribute="bold"]').setAttribute('title', 'Really Bold');
</script>
@stop