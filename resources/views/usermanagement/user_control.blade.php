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
                        <h3 class="page-title">{{ __('messages.User_Management_Control') }}</h3>
                        <p class="text-subtitle text-muted">{{ __('messages.For_user_to_check_they_list') }}</p>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/home">{{ __('messages.Dashboard') }}</a></li>
                            <li class="breadcrumb-item">{{ __('messages.Maintenance') }}</li>
                            <li class="breadcrumb-item active">{{ __('messages.User_Control') }}</li>
                        </ul>
                    </div>
                    <div class="col-12" style="text-align: right">
                        <a href="{{ route('user/add/new') }}" class="btn btn-primary">{{ __('messages.Create_New_User') }}</a>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- message --}}
        {!! Toastr::message() !!}
        <section class="section">
            <div class="card">
                <div class="card-header">
                    {{ __('messages.User_Datatable') }}
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>{{ __('messages.ID') }}</th>
                                <th>{{ __('messages.Full_Name') }}</th>
                                <th>{{ __('messages.Email_Address') }}</th>
                                <th>{{ __('messages.Role_Name') }}</th>
                                <th class="text-center">{{ __('messages.Modify') }}</th>
                            </tr>    
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                                <tr>
                                    <td class="id">{{ ++$key }}</td>
                                    <td class="name">{{ $item->name }}</td>
                                    <td class="email">{{ $item->email }}</td>
                                    @if($item->role_name =='Admin')
                                    <td class="role_name"><span  class="badge bg-success">{{ __('messages.Admin') }}</span></td>
                                    @endif
                                    @if($item->role_name =='Employee')
                                    <td class="role_name"><span  class="badge bg-info">{{ __('messages.Employee') }}</span></td>
                                    @endif
                                    @if($item->role_name =='Normal User')
                                    <td class="role_name"><span  class=" badge bg-warning">{{ __('messages.Normal_User') }}</span></td>
                                    @endif
                                    <td class="text-center">
                                        <a href="{{ url('view/detail/'.$item->id) }}">
                                            <span class="badge bg-success"><i class="bi bi-pencil-square"></i></span>
                                        </a>  
                                        <a href="{{ url('delete_user/'.$item->id) }}" onclick="return confirm('Are you sure to want to delete it?')"><span class="badge bg-danger"><i class="bi bi-trash"></i></span></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
