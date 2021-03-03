@extends('adminlte::page')

@section('title', 'EXILED Plugins | My Plugins')

@section('content_header')
    <h1 class="m-0">My Plugins</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    Total plugins: {{$count}}
                </div>
            </div>
            <div class="card">
              <div class="card-body">
                <form action="{{ route('plugin.list') }}" method="GET">
                  <div class="input-group input-group-sm">
                    <input type="text" name="query" class="form-control float-right" value="{{ request()->input('query') }}" placeholder="Search by name">

                      <select class="form-control" name="filter" id="filter"> 
                        <option {{ request()->has('filter') ? '' : 'selected'}} value="-1">Filter By Category</option>
                        @foreach($categories as $category)
                          <option {{ $category->id == request()->input('filter') ? 'selected' : ''}} value="{{$category->id}}">{{$category->category_name}}</option>
                          @endforeach
                      </select>
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
                        @if ($count == 0)
                        <tr>
                          <td>

                            <div class="info-box bg-navy">
                              <div class="info-box-content">
                                <span class="info-box-text text-center">Plugin list is empty.</span>
                              </div>

                          </td>
                      </tr>
                        @endif
                        @foreach($plugins as $plugin)
                        <tr>
                            <td>
                              <a class="info-box bg-navy" href="{{ route('plugin.view', ['id' => $plugin->id]) }}">
                                <span class="info-box-icon"><img src="{{$plugin->image_url}}"></span>
                    
                                <div class="info-box-content">
                                  <span class="info-box-text">{{$plugin->name}} <b>made by</b> {{$plugin->user->nickname}}</span>

                                      <div class="flex flex-col">
                                        <div class="flex my-1">
                                            <code><span class="mr-2 text-xs text-gray-500">{{$plugin->downloads_count}} Downloads</span></code>
                                            <code><span class="mr-2 text-xs text-gray-500">Updated <abbr>{{$plugin->last_update}}</abbr></span></code>
                                            <code><span class="text-xs text-gray-500">Created <abbr>{{$plugin->creation_date}}</abbr></span></code>
                                        </div>
                                        <p class="text-sm leading-snug">
                                          {{$plugin->small_description}}
                                        </p>
                                        {!!$plugin->categoryobj->categorynice!!}
                                        <form method="get" action="{{route('plugin.edit', ['id' => $plugin->id])}}">
                                            <button type="submit" class="btn btn-block btn-primary bg-purple btn-xs" style="width: 150px; float: right;">Edit</button>
                                        </form>
                                      </div>
                                  </div>
                                  </span>
                                </a>

                            </td>
                        </tr>
                        @endforeach
                  </tbody>
              </table>

              </div>
              @if($plugins->hasPages())
              <div class="card-footer">
                  <div class="col-md-12 text-center">{{ $plugins->appends(request()->except('page'))->links() }}</div>
              </div>
          @endif
          </div>
        </div>
    </div>
@stop

@section('adminlte_js')

<script>
</script>
@stop