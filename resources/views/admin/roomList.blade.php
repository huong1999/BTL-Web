<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Export Rooms Exam List PDF</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <style>
        .container{
            padding: 5%;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-12">
            <a href="{{ url('admin/pdf') }}" class="btn btn-success mb-2">Export PDF</a>
            <table class="table table-striped table-bordered table-hover" id="laravel_crud">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Quantify</th>
                </tr>
                </thead>
                <tbody>
                @foreach($rooms as $room)
                    <tr>
                        <td>{{ $room->id }}</td>
                        <td>{{ $room->name }}</td>
                        <td>{{ $room->quantify }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
