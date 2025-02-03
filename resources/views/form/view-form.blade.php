@extends('layouts.master')

@php 
if (!isset($form_data)) {
    $form_data = "";
}
@endphp

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">{{ __('messages.View_Template') }}</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('messages.Dashboard') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('/') }}">{{ __('messages.Forms') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('messages.View_Template') }}</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="text-align: center;">
                        <h4 class="card-title mb-0">
                            @if($template_name != "")
                                {{ $template_name }}
                            @else
                                Template {{ $template_id }}
                            @endif
                        </h4>
                    </div>
                    <br>
                    <div class="card-body" id="build-wrap">
                        <script>
                            function decode(str) {
                                let txt = document.createElement("textarea");
                                txt.innerHTML = str;
                                return txt.value;
                            }
                            $( document ).ready(function() {
                                var form_data = decode("{{ $form_data }}").replace(/^"+|"+$/g, ''); 
                                const fbTemplate = document.getElementById('build-wrap');
                                var renderedForm = $('<div>');
                                renderedForm.formRender({ 'formData' : form_data });
                                fbTemplate.innerHTML = renderedForm.formRender("html");
                            });
                        </script>
                    </div>                               
                </div>
            </div>
        </div>
        <div class="text-center">
            <button type="button" class="btn btn-primary" id="sendFormButton">{{ __('messages.Send') }}</button>
        </div>
    </div>
    
    <div class="modal custom-modal fade" id="emailModal" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Send Form Link</h3>
                    </div>
                    <div class = "modal-btn">
                        <input type="email" class="form-control" id="emailInput" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" placeholder="Enter email address">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="closeModal">{{ __('messages.Cancel') }}</button>
                            <button type="button" class="btn btn-primary" id="sendEmailButton">{{ __('messages.Send') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<script src="https://formbuilder.online/assets/js/form-render.min.js"></script>
<script>
    $(document).ready(function() {

        $('#sendFormButton').click(function() {
            $('#emailModal').modal('show');
        });

        $('#sendEmailButton').click(function() {
            var email = $('#emailInput').val();

            if (email) {
                var currentPageUrl = window.location.href;
                var id = currentPageUrl.split('/').pop();
                var formLink = "{{ route('form/link', ':id') }}".replace(':id', id);
                var emailSubject = "Form {{ $template_name }}";
                var emailBody = `${formLink}`;
                $("#sendEmailButton").attr("disabled", true)
                $.ajax({
                    url: '/form/send',
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        email: email,
                        subject: emailSubject,
                        body: emailBody,
                    },
                    success: function(response) {
                        $('#emailModal').modal('hide');
                        toastr.success("Form link send sucessfully!");
                        console.log(response);
                        $("#sendEmailButton").attr("disabled", false)
                    },
                    error: function(error) {
                        toastr.error("Form link failed to send!");
                        console.error(error);
                        $("#sendEmailButton").attr("disabled", false)
                    },
                });
            }
        });
        $('#closeModal').click(function() {
            $('#emailModal').modal('hide');
        });
    });
</script>
@endsection