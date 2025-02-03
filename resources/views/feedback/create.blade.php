@extends('layouts.master')

@section('content')
{{-- message --}}
{!! Toastr::message() !!}
    </br>
    <div class="page-wrapper">
        <div class="container container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header"  style="text-align: center;">
                            <h4 class="card-title mb-0">{{ __('messages.Feedback_Form') }}</h4>
                        </div>
                        </br>
                        <div class="card-body">
                            <form action="{{ route('feedback/store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="subject" class="form-label">{{ __('messages.Subject') }}</label>
                                    <input type="text" name="subject" id="subject" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="message" class="form-label">{{ __('messages.Message') }}</label>
                                    <textarea name="message" id="message" class="form-control" required></textarea>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">{{ __('messages.Submit_Feedback') }}</button>
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
