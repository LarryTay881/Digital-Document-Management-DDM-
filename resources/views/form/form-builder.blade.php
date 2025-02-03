@extends('layouts.master')

@php 
if (!isset($form_data)) {
    $form_data = "";
}
@endphp

@section('content')
<script>
    function decode(str) {
        let txt = document.createElement("textarea");
        txt.innerHTML = str;
        return txt.value;
    }
    var form_data = decode("{{ $form_data }}").replace(/^"+|"+$/g, ''); 
</script>
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    @if(isset($id)) 
                    <h3 class="page-title">{{ __('messages.Edit_Template') }}</h3>
                    @else
                    <h3 class="page-title">{{ __('messages.Add_Template') }}</h3>               
                    @endif
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('/') }}">{{ __('messages.Dashboard') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('/') }}">{{ __('messages.Forms') }}</a></li>
                        @if(isset($id))
                        <li class="breadcrumb-item active">{{ __('messages.Edit_Template') }}</li>
                        @else
                        <li class="breadcrumb-item active">{{ __('messages.Add_Template') }}</li>
                        @endif        
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="text-align: center;">
                        <h4 class="card-title mb-0">
                        @if(isset($id))
                            @if($template_name != "")
                                {{ $template_name }}
                            @else
                                Template {{ $id }}
                            @endif
                        @else
                            {{ __('messages.Form_Builder') }}
                        @endif
                    </h4>
                    </div>
                    </br>
                    <div id="build-wrap"></div> 
                </div>
            </div>
        </div>
        @csrf
        @if(isset($id)) 
            <input type="hidden" value="{{ $id }}" id="formId"/>
        @endif
        <div class="form-group">
            <script src="{{ asset('assets/js/formbuilder.js') }}"></script>
        </div> 
    </div>
</div>
<div class="modal custom-modal fade" id="templateName" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>Save Template Name</h3>
                </div>
                <div class="modal-btn">
                    <input type="text" class="form-control" id="templateNameInput" placeholder="Enter Template Name">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="closeModal">{{ __('messages.Cancel') }}</button>
                        <button type="button" class="btn btn-primary" id="save">{{ __('messages.Save') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<script src="https://formbuilder.online/assets/js/form-builder.min.js"></script>
@endsection