@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Rooms</div>
                    <div class="card-body">
                        <a href="{{ url('/admin/rooms/create') }}" class="btn btn-success btn-sm" title="Add New Room">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>

                        {!! Form::open(['method' => 'GET', 'url' => '/admin/rooms', 'class' => 'form-inline my-2 my-lg-0 float-right', 'role' => 'search'])  !!}
                        <select name="shift" id="shift" class="form-control mr-1">
                            <option value="">- All Subject -</option>
                            @foreach($subjects as $key => $value)
                                <option value="{{ $key }}" @if(request('subject')) {{ request('subject') == $key ? 'selected' : ''}} @else {{ $key  == 'user' ? 'selected' : '' }} @endif>{{ $value }}</option>
                            @endforeach
                        </select>
                        <select name="shift" id="shift" class="form-control mr-1">
                            <option value="">- All Shift -</option>
                            @foreach($shifts as $key => $value)
                                <option value="{{ $key }}" @if(request('shift')) {{ request('shift') == $key ? 'selected' : ''}} @else {{ $key  == 'user' ? 'selected' : '' }} @endif>{{ $value }}</option>
                            @endforeach
                        </select>
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Search..." value="{{ request('search') }}">
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
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
{{--                                        <th>Shift</th>--}}
                                        <th>Quantify</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($rooms as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->name }}</td>
{{--                                        <td>--}}
{{--                                            @foreach($item->shifts as $shift)--}}
{{--                                                <li>{{ $shift->name }}</li>--}}
{{--                                            @endforeach--}}
{{--                                        </td>--}}
                                        <td>{{ $item->quantify }}</td>
                                        <td>
                                            <a href="{{ url('/admin/rooms/' . $item->id) }}" title="View Room"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
                                            <a href="{{ url('/admin/rooms/' . $item->id . '/edit') }}" title="Edit Room"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>
                                            {!! Form::open([
                                                'method' => 'DELETE',
                                                'url' => ['/admin/rooms', $item->id],
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i>', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-sm',
                                                        'title' => 'Delete Room',
                                                        'onclick'=>'return confirm("Confirm delete?")'
                                                )) !!}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $rooms->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>
                        <div class="card-body" style="float: right;">
                            <a href="{{ url('/admin/pdf') }}" class="btn btn-primary btn-sm" title="Export PDF">
                                <i class="fa fa-file-export" aria-hidden="true"></i> Export PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
