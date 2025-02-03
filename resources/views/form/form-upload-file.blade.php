@extends('layouts.master')
@section('content')
{{-- message --}}
    {!! Toastr::message() !!}
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">{{ __('messages.File_Upload') }}</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('/') }}">{{ __('messages.Dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('/') }}">{{ __('messages.Forms') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('messages.File_Upload') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header" style="text-align: center;">
                            <h4 class="card-title mb-0">{{ __('messages.File_Upload') }}</h4>
                        </div>
                        <br>
                        <form action="{{ route('form/upload/file') }}" id="file-upload-form" class="uploader" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">

                                <input type="file" name="file_name[]" id="file" class="input-file @error('file_name[]') is-invalid @enderror" multiple>
                                <label for="file" class="btn btn-tertiary js-labelFile">
                                    <i class="icon fa fa-check"></i>
                                    <span class="js-fileName">{{ __('messages.Choose_a_file') }}</span>
                                </label>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">{{ __('messages.Submit') }}</button>
                            </div>
                            <br>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('style')
<style>
    .btn-tertiary {
        color: #555;
        padding: 0;
        line-height: 40px;
        width: 300px;
        margin: auto;
        display: block;
        border: 2px solid #555;
    }
    .btn-tertiary:hover, .btn-tertiary:focus {
        color: #888888;
        border-color: #888888;
    }

    /* input file style */
    .input-file {
        width: 0.1px;
        height: 0.1px;
        opacity: 0;
        overflow: hidden;
        position: absolute;
        z-index: -1;
    }
    .input-file + .js-labelFile {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        padding: 0 10px;
        cursor: pointer;
    }
    .input-file + .js-labelFile .icon:before {
        content: "";
    }
    .input-file + .js-labelFile.has-file .icon:before {
        content: "";
        color: #5AAC7B;
    }
</style>
@endsection
@section('script')
    <script>
        (function() {
            $('.input-file').each(function() {
                var $input = $(this),
                    $label = $input.next('.js-labelFile'),
                    labelVal = $label.html();

                $input.on('change', function() {
                    var files = $input[0].files;
                    var fileName = '';

                    if (files.length > 0) {
                        for (var i = 0; i < files.length; i++) {
                            fileName += files[i].name;
                            if (i < files.length - 1) {
                                fileName += ', ';
                            }
                        }
                    } else {
                        fileName = labelVal;
                    }

                    $label.addClass('has-file').find('.js-fileName').html(fileName);
                });
            });
        })();
    </script>
@endsection