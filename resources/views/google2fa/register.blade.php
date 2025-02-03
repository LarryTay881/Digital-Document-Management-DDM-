@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mt-4">
            <div class ="card card-default">
                <h4 class = "card-heading text-center mt-3">Set Up Google Authenticator</h4>

                <div class="card-body text-center">
                   
                    <p>Set up your two factor authentication by scanning the barcode below. However, you can also use the <strong>{{$secret}}</strong></p>
                
                    <div>
                        {!! $QR_Image !!}
                    </div>
                    <p>You must setup Google Authenticator before Continuing. Otherwise, you will be unable login.</p>
                    <div>
                        <a href="{{ route('complete.registration') }}" class="btn btn-primary">Complete Registration</a>
                    </div>         
                </div>     
            </div>
        </div>
    </div>
</div>

 @endsection