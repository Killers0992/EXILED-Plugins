@extends('adminlte::page')

@section('title', 'EXILED Plugins | Profile')

@section('adminlte_css')
<style>

</style>
<link rel="stylesheet" type="text/css" href="{{ asset('main.css') }}">
@stop

@section('content_header')
    <h1 class="m-0">Profile</h1>
@stop

@section('content')
<div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">

              <div class="card-body box-profile">
              <div class="box-tools text-right">
                </div>
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="{{ $user->profile_url }}"
                       alt="User profile picture">
                </div>

                <h3 class="profile-username text-center">{{ $user->nickname }}</h3>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Plugins </b> <a class="float-right">{!! $plcount !!}</a>
                  </li>
                </ul>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
          <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Plugins</h3>

              </div>
              <div class="card-body">
                    
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
@stop