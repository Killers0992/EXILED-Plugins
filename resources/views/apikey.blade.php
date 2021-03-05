@extends('adminlte::page')

@section('title', 'EXILED Plugins | API Key')

@section('content_header')
    <h1 class="m-0">API Key</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="box box-primary">
                        <!-- /.box-header -->
                        <!-- form start -->
                        <div class="box-body">
                            <div class="form-group">
                              <label for="apikey">API Key</label>
                              <input type="text" class="form-control" name="pluginissues" value="{{$apiKey->api_key ?? ''}}">
                            </div>
                          </div>
                          <div class="input-group input-group-sm">
                            <div class="input-group-append">

                        <form role="form" action="{{ route('api.create') }}" method="post">
                           @csrf
                          <div class="box-footer">
                            <button type="submit" class="btn btn-success">Create API KEY</button>
                          </div>
                        </form>
                    </div>
                    <div class="input-group-append">

                        <form role="form" action="{{ route('api.delete') }}" method="post">
                            @csrf
                           <div class="box-footer">
                             <button type="submit" class="btn btn-danger">Delete API KEY</button>
                           </div>
                         </form>
                        </div>
                        </div>
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