@extends('layouts.admin')

@section('main-content')

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">{{ __('Dashboard') }}</h1>

<!-- Map Container -->
<div id="map" style="height: 400px; margin-bottom: 20px;"></div>

<!-- Device Status Card -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="m-0 font-weight-bold text-primary">Device Status</h5>
    </div>
    <div class="card-body">
        <p>Status: {{ $widget['deviceStatus']['status'] }}</p>
        <p>Last Update: {{ $widget['deviceStatus']['lastUpdate'] }}</p>
    </div>
</div>

<!-- Last 5 Locations Card -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="m-0 font-weight-bold text-primary">Last 5 Locations</h5>
    </div>
    <div class="card-body">
        @if(count($widget['locations']) > 0)
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
                    @foreach($widget['locations'] as $index => $location)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $location->latitude }}</td>
                        <td>{{ $location->longitude }}</td>
                        <td>{{ $location->created_at }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p>No locations available.</p>
        @endif
    </div>
</div>

<!-- Include Leaflet.js library -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<!-- Add your custom map script -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var map = L.map('map').setView([{{ $widget['locations']->first()->latitude }}, {{ $widget['locations']->first()->longitude }}], 13);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        var firstLocation = 0;
        
        @foreach($widget['locations'] as $index => $location)
            var markerColor = ({{ $index }} === firstLocation) ? 'red' : 'blue';
            var marker = L.marker([{{ $location->latitude }}, {{ $location->longitude }}], {
                icon: L.icon({
                    iconUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-icon.png',
                    iconSize: [25, 41],
                    iconAnchor: [12, 41],
                    popupAnchor: [1, -34],
                    tooltipAnchor: [16, -28],
                    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
                    shadowSize: [41, 41],
                    shadowAnchor: [12, 41],
                    className: 'marker-icon-' + markerColor
                })
            }).addTo(map);

            marker.bindPopup("<b>Location {{ $index + 1 }}</b><br>Latitude: {{ $location->latitude }}<br>Longitude: {{ $location->longitude }}<br><br><a href='https://www.google.com/maps?q={{ $location->latitude }},{{ $location->longitude }}' target='_blank'>Open in Google Maps</a>");

            marker.on('mouseover', function (e) {
                this.openPopup();
            });

            marker.on('mouseout', function (e) {
                this.closePopup();
            });

            marker.on('click', function () {
                window.open('https://www.google.com/maps?q={{ $location->latitude }},{{ $location->longitude }}', '_blank');
            });
        @endforeach
    });
</script>

<style>
    .marker-icon-red {
        filter: hue-rotate(0deg);
    }

    .marker-icon-blue {
        filter: hue-rotate(240deg);
    }
</style>


@endsection