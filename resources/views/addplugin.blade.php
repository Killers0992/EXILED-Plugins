@extends('adminlte::page')

@section('title', 'EXILED Plugins | Add plugin')

@section('content_header')
    <h1 class="m-0">Add Plugin</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="box box-primary">
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form role="form" action="{{ route('plugin.create') }}" method="post">
                           @csrf
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
</script>
@stop