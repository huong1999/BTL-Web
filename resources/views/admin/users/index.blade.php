@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Users</div>
                    <div class="card-body">
                        <a href="{{ url('/admin/users/create') }}" class="btn btn-success btn-sm" title="Add New User">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>

                        {!! Form::open(['method' => 'GET', 'url' => '/admin/users', 'class' => 'form-inline my-2 my-lg-0 float-right', 'role' => 'search'])  !!}
                        <select name="role" id="role" class="form-control mr-1">
                            <option value="">- All Role -</option>
                            @foreach($roles as $key => $value)
                                <option value="{{ $key }}" @if(request('role')) {{ request('role') == $key ? 'selected' : ''}} @else {{ $key  == 'user' ? 'selected' : '' }} @endif>{{ $value }}</option>
                            @endforeach
                        </select>
                        <select name="class" id="class" class="form-control mr-1">
                            <option value="">- All Class -</option>
                            @foreach($classes as $key => $value)
                                <option value="{{ $key }}" {{ request('class') == $key ? 'selected' : ''}}>{{ $value }}</option>
                            @endforeach
                        </select>
                        <select name="subject" id="subject" class="form-control mr-1">
                            <option value="">- All Subject -</option>
                            @foreach($subjects as $key => $value)
                                <option value="{{ $key }}" {{ request('subject') == $key ? 'selected' : ''}}>{{ $value }}</option>                            @endforeach
                        </select>
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Search..."
                                   value="{{ request('search') }}">
                            <span class="input-group-append">
                                <button class="btn btn-secondary" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                        {!! Form::close() !!}

                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Code</th>
                                    <th>Date Of Birth</th>
                                    <th>Class</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $item)
                                    <tr class="item{{$item->id}}">
                                        <td>{{ $item->id }}</td>
                                        <td><a href="{{ url('/admin/users', $item->id) }}">{{ $item->name }}</a></td>
                                        <td>{{ $item->code }}</td>
                                        <td>{{ $item->date_of_birth }}</td>
                                        <td>{{ $item->class->name }}</td>
                                        <td>
                                            <a href="{{ url('/admin/users/' . $item->id . '/edit') }}"
                                               title="Edit User">
                                                <button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o"
                                                                                          aria-hidden="true"></i>
                                                </button>
                                            </a>
                                            {!! Form::open([
                                                'method' => 'DELETE',
                                                'url' => ['/admin/users', $item->id],
                                                'style' => 'display:inline'
                                            ]) !!}
                                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i>', array(
                                                    'type' => 'submit',
                                                    'class' => 'btn btn-danger btn-sm delete-user',
                                                    'title' => 'Delete User',
                                                    'onclick'=>'return confirm("Confirm delete?")',
                                                    'value' => '{{ $item->id }}',
                                            )) !!}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div
                                class="pagination"> {!! $users->appends(['search' => Request::get('search', 'role')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
    $(".delete-user").click(function(){
        var id = $(this).val();
        var token = $("meta[name='csrf-token']").attr("content");

        $.ajax(
        {
            url: "admin/users/"+id,
            type: 'DELETE',
            success: function (data){
                console.log("it Works");
                $('.item' + data['id']).remove();
            },
            error: function (data) {
                console.error('Error:', data);
            }
        });

    });
    </script>
@endsection
