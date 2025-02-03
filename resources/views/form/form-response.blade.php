@extends('layouts.master')
@section('content')
{!! Toastr::message() !!}
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">
                        @if($formName != "")
                                {{ $formName }} Form Reponse List
                            @else
                                Form {{ $dataTemplate->id }} Response List
                            @endif
                    </h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('messages.Dashboard') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('/') }}">{{ __('messages.Forms') }}</a></li>
                        <li class="breadcrumb-item active">Form {{ $dataTemplate->id }} Reponse List</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-12" style="text-align: right">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#reportOptionsModal">{{ __('messages.Generate_Report') }}</button>
        </div>

        <!-- Report Options Modal -->
        <div class="modal custom-modal fade" id="reportOptionsModal" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>{{ __('messages.Select_Report_Format') }}</h3>
                        </div>
                        <div class="row">
                            <div class="col-6 text-right">
                                <a href="{{ route('generate.form.response', ['id' => $dataTemplate->id, 'format' => 'pdf']) }}" class="btn btn-primary">{{ __('messages.Generate_PDF') }}</a>
                            </div>
                            <div class="col-6 text-left">
                                <a href="{{ route('generate.form.response', ['id' => $dataTemplate->id, 'format' => 'excel']) }}" class="btn btn-primary">{{ __('messages.Generate_Excel') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                            @foreach($fields as $label)
                                <th>{{ $label }}</th>
                            @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($responses as $response)
                            <tr>
                                @foreach($response as $field => $value)
                                        <td>{{ $value }}</td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection