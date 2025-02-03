@extends('layouts.slave')

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
<div class="page-wrapper2">
    <div class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="text-align: center;">
                    <h4 class="card-title mb-0">{{ $template_name }}</h4>
                    </div>
                    <div class="card-body" id="build-wrap">
                        
                    </div>
                    <form id="formSubmitResponse">
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" id="submitFormButton">{{ __('messages.Submit') }}</button>
                        </div>
                    </form>
                    </br>
                </div>
            </div>
        </div>
        <script src="{{ asset('assets/js/formresponse.js') }}"></script>
    </div>
</div>

@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<script src="https://formbuilder.online/assets/js/form-render.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
@endsection
