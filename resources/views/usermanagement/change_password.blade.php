@extends('layouts.master')
@section('menu')
@endsection
@section('content')
<div id="main">
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">{{ __('messages.Form_Change_Password') }}</h3>
                        <p class="text-subtitle text-muted">{{ __('messages.For_user_to_change_their_password') }}</p>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">{{ __('messages.Dashboard') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('messages.Change_Password') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    
    {{-- message --}}
    {!! Toastr::message() !!}

    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <br>
                    <form method="POST" action="{{ route('change/password/db') }}" class="md-float-material">
                        @csrf
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" class="form-control form-control-lg @error('current_password') is-invalid @enderror" 
                            name="current_password" value="{{ old('current_password') }}" placeholder="{{ __('messages.Enter_Old_Password') }}">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                            @error('current_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" class="form-control form-control-lg @error('new_password') is-invalid @enderror" 
                            name="new_password" placeholder="{{ __('messages.Enter_New_Password') }}">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                            @error('new_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" class="form-control form-control-lg" name="new_confirm_password" placeholder="{{ __('messages.Choose_Confirm_Password') }}">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">{{ __('messages.Change_Password') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection