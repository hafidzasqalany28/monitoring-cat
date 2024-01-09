<!-- resources/views/gps-log/index.blade.php -->
@extends('layouts.admin')

@section('main-content')

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">{{ __('GPS Log') }}</h1>

<!-- GPS Log Table -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="m-0 font-weight-bold text-primary">Location History Log</h5>
    </div>
    <div class="card-body">
        @if(count($gpsLogs) > 0)
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($gpsLogs as $index => $gpsLog)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $gpsLog->latitude }}</td>
                        <td>{{ $gpsLog->longitude }}</td>
                        <td>{{ $gpsLog->created_at }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p>No GPS log data available.</p>
        @endif
    </div>
</div>

@endsection