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
                        <code><span class="mr-2 text-xs text-gray-500">{{$plugin->downloads_count}} Downloads</span></code>
                        <code><span class="mr-2 text-xs text-gray-500">Updated <abbr>{{$plugin->last_update}}</abbr></span></code>
                        <code><span class="text-xs text-gray-500">Created <abbr>{{$plugin->creation_date}}</abbr></span></code>
                        <code><span class="text-xs text-gray-500">Exiled Version: <abbr>{{$plugin->latest_exiled_version}}</abbr></span></code>
                          
                        @if (Auth::user()->allowedPlugin('edit.plugin', $plugin) || Auth::user()->hasPermission('edit.plugin.admin'))
                        <form method="get" action="{{route('plugin.edit', ['id' => $plugin->id])}}">
                            <button type="submit" class="btn btn-block btn-primary bg-purple btn-xs" style="width: 150px; float: right;">Edit</button>
                        </form>
                        @endif
                    </div>
                    {!!$plugin->categoryobj->categorynice!!}
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
                            <a href="{{ route('plugin.view.files', ['id' => $plugin->id])}}">Files</a>
                        </td>
                        <td>
                            <a href="{{ route('plugin.view.members', ['id' => $plugin->id])}}">Members</a>
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
                   {!!$plugin->description!!}
                </div>
            </div>
        </div>
    </div>
@stop

@section('adminlte_js')

<script>
</script>
@stop