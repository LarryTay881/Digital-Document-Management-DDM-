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
                        <h3 class="page-title">{{ __('messages.User_Management_View') }}</h3>
                        <p class="text-subtitle text-muted">{{ __('messages.For_user_to_check_they_list') }}</p>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('messages.Dashboard') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('messages.User_Management_View') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('messages.User_View_Detail') }}</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-horizontal" action="{{ route('update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $data[0]->id }}">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>{{ __('messages.Full_Name') }}</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group has-icon-left">
                                            <div class="position-relative">
                                                <input type="text" class="form-control"
                                                    placeholder="Name" id="first-name-icon" name="fullName" value="{{ $data[0]->name }}">
                                                <div class="form-control-icon">
                                                    <i class="bi bi-person"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label>{{ __('messages.Email_Address') }}</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group has-icon-left">
                                            <div class="position-relative">
                                                <input type="email" class="form-control"
                                                    placeholder="Email" id="first-name-icon" name="email" value="{{ $data[0]->email }}">
                                                <div class="form-control-icon">
                                                    <i class="bi bi-envelope"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label>{{ __('messages.Role_Name') }}</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group position-relative has-icon-left mb-4">
                                            <fieldset class="form-group">
                                                <select class="form-select" name="role_name" id="role_name" style="padding:0.55rem 2.5rem;">
                                                    <option value="{{ $data[0]->role_name }}" {{ ( $data[0]->role_name == $data[0]->role_name) ? 'selected' : ''}}> 
                                                        {{ $data[0]->role_name }}
                                                    </option>
                                                    @foreach ($roleName as $key => $value)
                                                    <option value="{{ $value->role_type }}"> {{ $value->role_type }}</option>
                                                    @endforeach  
                                                </select>
                                                <div class="form-control-icon">
                                                    <i class="bi bi-bag-check"></i>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit"
                                            class="btn btn-primary me-1 mb-1">{{ __('messages.Update') }}</button>
                                        <a  href="{{ route('userManagement') }}"
                                            class="btn btn-light-secondary me-1 mb-1">{{ __('messages.Back') }}</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection