@extends('adminlte::page')

@section('title', 'EXILED Plugins | Plugin members')

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
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>Nickname</th>
                                <td>Group</th>
                                @if(is_null(Auth::user()) ? false : (is_null(Auth::user()) ? false : (Auth::user()->id == $plugin->user_id)))
                                <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($members as $member)
                                <tr>
                                    <td>{{$member->user->nickname}}</td>
                                    <td>{{$member->groupe->group_name}}</td>
                                    @if(is_null(Auth::user()) ? false : (Auth::user()->id == $plugin->user_id) && $member->steamid != $plugin->user_id)
                                    <td class="text-left">
                                        <form role="form" action="" method="post">
                                            @csrf
                                            <input hidden="true" name="fileid" value="">
                                            <button type="submit">
                                                <abbr title="Delete"><i class="text-danger fas fa-ban"></i></abbr>
                                            </button>
                                        </form>
                                    </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($members->hasPages())
                    <div class="card-footer">
                        <div class="col-md-12 text-center">{{ $members->appends(request()->except('page'))->links() }}</div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @if (is_null(Auth::user()) ? false : (Auth::user()->allowedPlugin('add.member', $plugin) || Auth::user()->hasPermission('add.member.admin')))
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    Add member
                    <form role="form" enctype="multipart/form-data" action="{{ route('plugin.members.add', ['id' => $plugin->id]) }}" method="post">
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label for="user">User</label>
                                <select class="form-control" style="padding-left:0;" name="user" id="user"></select>
                            </div>

                            <div class="form-group">
                                <label for="group">Group</label>
                                <select class="form-control" name="group" id="group">
                                    @foreach($groups as $group)
                                    <option value="{{$group->id}}">{{$group->group_name}}</option>
                                    @endforeach
                                  </select>
                             </div>
                       </div>
                       <!-- /.box-body -->
         
                       <div class="box-footer">
                         <button type="submit" class="btn btn-success">Submit</button>
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

    $(document).ready(function () {
        function escapeHtml(str) {
            var div = document.createElement('div');
            div.appendChild(document.createTextNode(str));
            return div.innerHTML;
        }
    
        $('#user').select2({
            ajax: {
                url: "{{route('users.json')}}",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term, // search term
                        page: params.page,
                    };
                },
                processResults: function (data, params) {
                    return { results: data };
                },
                cache: true,
            },
            escapeMarkup: function (markup) { return markup; },
            minimumInputLength: 2,
            multiple: true,
            templateResult: function (data) {
                if (data.loading) return '<span class="text-white">' + escapeHtml(data.text) + '</span>';
    
                return '<img class="img-fluid img-circle img-size-32" src="' + escapeHtml(data.image) + '" alt="Plugin Image"> \
                    <span class="text-white" style="padding-left:5px;"> \
                        ' + escapeHtml(data.name) + ' \
                    </span> \
                    ';
            },
            templateSelection: function (data) {
                return '<div style="padding-right:10px;"> \
                    <span> \
                        <img class="img-fluid img-circle img-size-32" src="' + escapeHtml(data.image) + '" style="height:28px;margin-top:4px;" alt="Plugin Image"> \
                    </span> \
                    <span class="text-white" style="padding-left:5px;"> \
                        ' + escapeHtml(data.name) + ' \
                    </span> \
                </div>';
            }
        });
    });
    </script>
@stop