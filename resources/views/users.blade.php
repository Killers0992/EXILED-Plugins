@extends('adminlte::page')

@section('title', 'EXILED Plugins | Users')

@section('adminlte_css')
<link rel="stylesheet" type="text/css" href="main.css">
@stop

@section('content_header')
    <h1 class="m-0">Users</h1>
@stop

@section('content')

<div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Users</h3>
                        <div class="card-tools">
                            <form action="{{ route('users') }}" method="GET">
                            <div class="input-group input-group-sm">
                               
                                <input type="text" name="query" class="form-control float-right" value="{{ request()->input('query') }}" placeholder="Search by name">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>Nickname</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{$user->nickname}}</td>

                                        <td class="text-left">

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($users->hasPages())
                        <div class="card-footer">
                            <div class="col-md-12 text-center">{{ $users->appends(request()->except('page'))->links() }}</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

      </div><!-- /.container-fluid -->
@stop

@section('adminlte_js')

<script>

  $(document).ready(function() {
        var is_touch_device = 'ontouchstart' in document.documentElement;

        if (!is_touch_device) {
            $('[data-toggle="tooltip"]').tooltip();
        }

</script>
@stop