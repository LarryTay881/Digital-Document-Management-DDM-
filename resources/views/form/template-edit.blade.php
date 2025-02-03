@extends('layouts.master')
@section('content')

<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">{{ __('messages.Form_Builder') }}</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('/') }}">{{ __('messages.Dashboard') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('/') }}">{{ __('messages.Forms') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('messages.Form_Builder') }}</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="text-align: center;">
                        <h4 class="card-title mb-0">{{ __('messages.Form_Builder') }}</h4>
                    </div>
                    </br>
                    <div id="build-wrap"></div> 
                </div>
            </div>
        </div>
        <form method="POST">
            @csrf
            <div class="form-group">
                <script src="{{ asset('assets/js/formbuilder.js') }}"></script>
            </div> 
        </form>
    </div>
</div>

@endsection