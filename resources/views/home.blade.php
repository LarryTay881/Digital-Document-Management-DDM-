@extends('layouts.master')
@section('menu')
@endsection
@section('content')
<div id="main">
    <div class="page-wrapper">
        <div class="page-heading">
            <h3>{{ __('messages.Profile_Statistics') }}</h3>
        </div>
        {{-- message --}}
        {!! Toastr::message() !!}
        <div class="page-content">
            <section class="row">
                <div class="col-12 col-lg-9">
                    <div class="row">
                        @if (Auth::user()->role_name=='Admin')
                        <div style="width: 30%;">
                            <div class="card">
                                <div class="card-body px-4 py-4">
                                    <div class="d-flex align-items-center">
                                        <div class="stats-icon green bg-green text-white rounded-circle">
                                            <i class="iconly-boldAdd-User"></i>
                                        </div>
                                        <div class="ml-3">
                                            <h6 class="text-muted font-weight-bold mb-1">{{ __('messages.Total_User') }}</h6>
                                            <h6 class="font-weight-extrabold mb-0">{{ $users }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>  
                        @endif                    
                        
                        <div style="width: 30%;">
                            <div class="card">
                                <div class="card-body px-4 py-4">
                                    <div class="d-flex align-items-center">
                                        <div class="stats-icon red bg-red text-white rounded-circle">
                                            <i class="iconly-boldBookmark"></i>
                                        </div>
                                        <div class="ml-3">
                                            <h6 class="text-muted font-weight-bold mb-1">{{ __('messages.Total_Employee_Form') }}</h6>
                                            <h6 class="font-weight-extrabold mb-0">{{ $form_inputs }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div style="width: 30%;">
                            <div class="card">
                                <div class="card-body px-4 py-4">
                                    <div class="d-flex align-items-center">
                                        <div class="stats-icon red bg-red text-white rounded-circle">
                                            <i class="iconly-boldBookmark"></i>
                                        </div>
                                        <div class="ml-3">
                                            <h6 class="text-muted font-weight-bold mb-1">{{ __('messages.Total_File_Upload') }}</h6>
                                            <h6 class="font-weight-extrabold mb-0">{{ $file_uploads }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div style="width: 30%;">
                            <div class="card">
                                <div class="card-body px-4 py-4">
                                    <div class="d-flex align-items-center">
                                        <div class="stats-icon red bg-red text-white rounded-circle">
                                            <i class="iconly-boldBookmark"></i>
                                        </div>
                                        <div class="ml-3">
                                            <h6 class="text-muted font-weight-bold mb-1">{{ __('messages.Total_Form_Template') }}</h6>
                                            <h6 class="font-weight-extrabold mb-0">{{ $form_templates }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div style="width: 30%;">
                            <div class="card">
                                <div class="card-body px-4 py-4">
                                    <div class="d-flex align-items-center">
                                        <div class="stats-icon red bg-red text-white rounded-circle">
                                            <i class="iconly-boldBookmark"></i>
                                        </div>
                                        <div class="ml-3">
                                            <h6 class="text-muted font-weight-bold mb-1">{{ __('messages.Total_OCR_Result') }}</h6>
                                            <h6 class="font-weight-extrabold mb-0">{{ $ocr_result }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="page-content">
                            <h2>{{ __('messages.Profile_Statistics_Chart') }}</h2>
                            <div class="chart-container">
                                <canvas id="profileStatisticsChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="recent-activity">
                            <h2>{{ __('messages.Recent_Document_Uploads') }}</h2>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Document Name</th>
                                        <th>User</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($fileUploads as $fileUpload)
                                    <tr>
                                        <td>{{ $fileUpload->file_name }}</td>
                                        <td>{{ $fileUpload->upload_by }}</td>
                                        <td>{{ $fileUpload->date_time }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<!-- Include the JavaScript code for the chart -->
<script>
    // JavaScript code for the pie chart
    var ctx = document.getElementById('profileStatisticsChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'pie', // Set the chart type to pie
        data: {
            labels: ['Users', 'Form Inputs', 'File Uploads', 'Form Templates', 'OCR'],
            datasets: [{
                data: [
                    {{ $users }},
                    {{ $form_inputs }},
                    {{ $file_uploads }},
                    {{ $form_templates }},
                    {{ $ocr_result }}
                ],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)'
                ], // Customize chart slice colors
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)'
                ], // Customize chart slice colors
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Profile Statistics Chart'
            },
            animation: {
                animateScale: true,
                animateRotate: true
            }
        }
    });
</script>

<style>
    .chart-container {
        height: 400px; /* Adjust the height as needed */
    }
</style>

    
@endsection