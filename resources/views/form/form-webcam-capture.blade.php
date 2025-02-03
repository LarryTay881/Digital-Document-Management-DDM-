@extends('layouts.master')
@section('style')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
@endsection
@section('content')
    {{-- message --}}
    {!! Toastr::message() !!}
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">{{ __('messages.Capture_Image') }}</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('/') }}">{{ __('messages.Dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('/') }}">{{ __('messages.Forms') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('messages.Capture_Image') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header" style="text-align: center;">
                            <h4 class="card-title mb-0">{{ __('messages.Capture_Image') }}</h4>
                        </div>
                        <br>
                        <form action="{{ route('form/webcam/capture') }}" id="file-capture-image" class="uploader" method="POST">
                            @csrf
                            <div class="form-group">
                                <div class="col-xl-12">
                                    <center><div id="my_camera"></div></center>
                                    <br/>
                                    <div class="form-group text-center">
                                        <input type=button value="Capture Image" onClick="take_snapshot()">
                                        <input type="hidden" name="image" class="image-tag">
                                    </div>
                                    <div class="text-center">
                                        <div>{{ __('messages.Your_captured_image_will_appear_here...') }}</div>
                                        <div id="results"></div>
                                    </div>
                                    <div class="col-md-12 text-center">
                                        <br/>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">{{ __('messages.Submit') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        Webcam.set({
            width: 490,
            height: 350,
            image_format: 'jpg',
            jpeg_quality: 90
        });
        
        Webcam.attach( '#my_camera' );
        
        function take_snapshot() {
            Webcam.snap( function(data_uri) {
                $(".image-tag").val(data_uri);
                document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';
            } );
        }
    </script>
@endsection