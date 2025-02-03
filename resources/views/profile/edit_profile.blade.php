@extends('layouts.master')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">{{ __('messages.Edit_Profile') }}</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/home">{{ __('messages.Dashboard') }}</a></li>
                        <li class="breadcrumb-item">{{ __('messages.Personal_Information') }}</li>
                        <li class="breadcrumb-item active">{{ __('messages.Edit_Profile') }}</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="text-align: center;">
                        <h4 class="card-title mb-0">{{ __('messages.Edit_Your_Profile') }}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-horizontal" action="{{ route('updateProfile') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{ $user->id }}">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>{{ __('messages.Full_Name') }}</label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group has-icon-left">
                                                <div class="position-relative">
                                                    <input type="text" class="form-control"
                                                        placeholder="Name" id="full-name" name="fullName" value="{{ $user->name }}">
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
                                                        placeholder="Email" id="email" name="email" value="{{ $user->email }}">
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-envelope"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </br>
                                        <div class="col-md-4">
                                            <label>{{ __('messages.Avatar') }}</label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                            @if ($user->avatar != "" || $user->avatar != NULL)
                                                <img src="{{ route('show/avatar', ['avatar' => $user->avatar]) }}" alt="Avatar" width="150">
                                            @else
                                                <img src="{{ asset('assets/img/faces/1.jpg') }}" alt="Default Avatar" width="150">
                                            @endif
                                            </div>
                                            <div class="form-group">
                                                <input type="file" class="form-control-file" id="avatar" name="avatar">
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">{{ __('messages.Update_Profile') }}</button>
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
</div>
@endsection
