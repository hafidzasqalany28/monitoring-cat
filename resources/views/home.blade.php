@extends('layouts.admin')

@section('main-content')

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">{{ __('Dashboard') }}</h1>

<!-- Map Container -->
<div id="map" style="height: 400px; margin-bottom: 20px;"></div>

<!-- Card for Device Status -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="m-0 font-weight-bold text-primary">Device Status</h5>
    </div>
    <div class="card-body">
        <!-- Dynamic device status content -->
        <p>Status: {{ $widget['deviceStatus']['status'] }}</p>
        <p>Last Update: {{ $widget['deviceStatus']['lastUpdate'] }}</p>
    </div>
</div>

<!-- Last 5 Locations -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="m-0 font-weight-bold text-primary">Last 5 Locations</h5>
    </div>
    <div class="card-body">
        @if(count($widget['locations']) > 0)
        <ul class="list-unstyled">
            @foreach($widget['locations'] as $location)
            <li>{{ $location->name }} ({{ $location->latitude }}, {{ $location->longitude }})</li>
            @endforeach
        </ul>
        @else
        <p>No locations available.</p>
        @endif
    </div>
</div>

@if (session('success'))
<div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if (session('status'))
<div class="alert alert-success border-left-success" role="alert">
    {{ session('status') }}
</div>
@endif

<!-- Include Leaflet.js library -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<!-- Add your custom map script -->
<script>
    // Ensure the document is fully loaded before initializing the map
    document.addEventListener("DOMContentLoaded", function () {
        // Initialize the map
        var map = L.map('map').setView([{{ $widget['locations']->first()->latitude }}, {{ $widget['locations']->first()->longitude }}], 13);

        // Add the base map layer (you can choose different tile providers)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Function to get marker color based on index
        function getMarkerColor(index) {
            return (index === {{ count($widget['locations']) - 1 }}) ? 'red' : 'blue';
        }

        // Add markers for each location in the last 5 locations
        @foreach($widget['locations'] as $index => $location)
            var markerColor = getMarkerColor({{ $index }});

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

            // Bind popup with additional content
            marker.bindPopup("<b>{{ $location->name }}</b><br>Latitude: {{ $location->latitude }}<br>Longitude: {{ $location->longitude }}<br><a href='https://www.google.com/maps?q={{ $location->latitude }},{{ $location->longitude }}' target='_blank'>Open in Google Maps</a>");

            // Add click event listener to open Google Maps
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