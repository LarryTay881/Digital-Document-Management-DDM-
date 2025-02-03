@extends('layouts.master')
@section('content')
    {{-- message --}}
    {!! Toastr::message() !!}
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">{{ __('messages.Personal_Information') }}</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/home">{{ __('messages.Dashboard') }}</a></li>
                            <li class="breadcrumb-item">{{ __('messages.Maintenance') }}</li>
                            <li class="breadcrumb-item active">{{ __('messages.Employee_Form') }}</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header" style="text-align: center;">
                            <h4 class="card-title mb-0">{{ __('messages.Information_Form') }}</h4>
                        </div>
                        <br>
                        <div class="card-body">
                            <form action="{{ route('form/input/save') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">{{ __('messages.Full_Name') }}</label>
                                            <div class="col-lg-9">
                                                <input type="text" class="form-control @error('full_name') is-invalid @enderror" name="full_name" value="{{ old('full_name') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">{{ __('messages.Gender') }}</label>
                                            <div class="col-lg-9">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input " type="radio" name="gender" id="gender_male" value="Male" checked>
                                                    <label class="form-check-label" for="gender_male">{{ __('messages.Male') }}</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="gender" id="gender_female" value="Female">
                                                    <label class="form-check-label" for="gender_female">{{ __('messages.Female') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">{{ __('messages.Date_of_Birth') }}</label>
                                            <div class="col-lg-9">
                                                <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{ old('date_of_birth') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">{{ __('messages.Address') }}</label>
                                            <div class="col-lg-9">
                                                <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">{{ __('messages.State') }}</label>
                                            <div class="col-lg-9">
                                                <input type="text" class="form-control @error('state') is-invalid @enderror" name="state" value="{{ old('state') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">{{ __('messages.City') }}</label>
                                            <div class="col-lg-9">
                                                <input type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">{{ __('messages.Country') }}</label>
                                            <div class="col-lg-9">
                                                <input type="text" class="form-control @error('country') is-invalid @enderror" name="country" value="{{ old('country') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">{{ __('messages.Postal_Code') }}</label>
                                            <div class="col-lg-9">
                                                <input type="text" class="form-control @error('postal_code') is-invalid @enderror" name="postal_code" value="{{ old('postal_code') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-left">
                                    <button type="submit" class="btn btn-primary">{{ __('messages.Submit') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection