
@extends('layouts.master')
@section('content')
    {{-- message --}}
    {!! Toastr::message() !!}
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">{{ __('messages.Form_Report') }}</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('messages.Dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('messages.Page_View') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('messages.Form_Report') }}</li>
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
                                    <a href="{{ route('generate.report', ['format' => 'pdf']) }}" class="btn btn-primary">{{ __('messages.Generate_PDF') }}</a>
                                </div>
                                <div class="col-6 text-left">
                                    <a href="{{ route('generate.report', ['format' => 'excel']) }}" class="btn btn-primary">{{ __('messages.Generate_Excel') }}</a>
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
                                    <th>{{ __('messages.No') }}</th>
                                    <th>{{ __('messages.Full_Name') }}</th>
                                    <th>{{ __('messages.Gender') }}</th>
                                    <th>{{ __('messages.Date_of_Birth') }}</th>
                                    <th>{{ __('messages.Address') }}</th>
                                    <th>{{ __('messages.State') }}</th>
                                    <th>{{ __('messages.City') }}</th>
                                    <th>{{ __('messages.Country') }}</th>
                                    <th>{{ __('messages.Postal_Code') }}</th>
                                    <th class="text-center">{{ __('messages.Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataFormInput as $key=>$items )
                                <tr>
                                    <td class="id">{{ $items->id }}</td>
                                    <td>
                                        <strong>{{ $items->full_name }}</strong>
                                    </td>
                                    <td>{{ $items->gender }}</td>
                                    <td>{{ $items->date_of_birth }}</td>
                                    <td>{{ $items->address }}</td>
                                    <td>{{ $items->state }}</td>
                                    <td>{{ $items->city }}</td>
                                    <td>{{ $items->country }}</td>
                                    <td>{{ $items->postal_code }}</td>
                                    <td class="text-center">
                                        <a href="{{ url('form/input/edit/'.$items->id) }}">
                                            <span class="badge bg-success"><i class="bi bi-pencil"></i>
                                        </a>
                                        <a class="delete" href="#" data-toggle="modal" data-target="#delete_form_record">
                                            <span class="badge bg-danger"><i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Record From Modal -->
    <div class="modal custom-modal fade" id="delete_form_record" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>{{ __('messages.Delete_Form_Record') }}</h3>
                        <p>{{ __('messages.Are_you_sure_want_to_delete?') }}</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <form action="{{ route('form/input/delete') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" class="e_id" value="">
                            <div class="row">
                                <div class="col-6" style="padding-left: 150px">
                                    <button type="submit" class="btn btn-primary">{{ __('messages.Delete') }}</button>
                                </div>
                                <div class="col-6">
                                    <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">{{ __('messages.Cancel') }}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete Record From Modal -->

@section('script')
{{-- delete js --}}
<script>
    $(document).on('click','.delete',function()
    {
        var _this = $(this).parents('tr');
        $('.e_id').val(_this.find('.id').text());
    });
</script>
@endsection
@endsection
