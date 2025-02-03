@extends('layouts.master')
@section('content')
    {{-- message --}}
    {!! Toastr::message() !!}
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">{{ __('messages.Form_Upload_File') }}</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('messages.Dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('messages.Page_View') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('messages.Form_Upload_File') }}</li>
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
                                    <a href="{{ route('generate.fileUpload.report', ['format' => 'pdf']) }}" class="btn btn-primary">{{ __('messages.Generate_PDF') }}</a>
                                </div>
                                <div class="col-6 text-left">
                                    <a href="{{ route('generate.fileUpload.report', ['format' => 'excel']) }}" class="btn btn-primary">{{ __('messages.Generate_Excel') }}</a>
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
                                    <th>{{ __('messages.Upload_By') }}</th>
                                    <th>{{ __('messages.Date_Time') }}</th>
                                    <th>{{ __('messages.File_Name') }}</th>
                                    <th>{{ __('messages.Uuid') }}</th>
                                    <th class="text-center">{{ __('messages.Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($fileUpload as $key=>$items )
                                <tr>
                                    <td class="id">{{ $items->id }}</td>
                                    <td>
                                        <strong>{{ $items->upload_by }}</strong>
                                    </td>
                                    <td>{{ $items->date_time }}</td>
                                    <td><a href="{{ url('download/file/'.$items->file_name) }}" class="file_name">{{ $items->file_name }}</a></td>
                                    <td>{{ $items->uuid }}</td>
                                    <td class="text-center">
                                        @if (Auth::user()->role_name=='Admin' || Auth::user()->role_name=='Employee')
                                            <a href="{{ route('ocr/recognize', ['id' => $items->id]) }}">
                                                <span class="badge bg-success"><i class="bi bi-file-font"></i></span>
                                            </a>
                                        @endif
                                        <a class="delete" href="#" data-toggle="modal" data-target="#delete_record">
                                            <span class="badge bg-danger"><i class="bi bi-trash"></i></span>
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
    <div class="modal custom-modal fade" id="delete_record" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete File Record</h3>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <form action="{{ route('download/file/delete') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" class="e_id" value="">
                            <input type="hidden" name="file_name" class="e_file_name" value="">
                            <div class="d-flex">                              
                                <button type="submit" class="mx-1 flex-fill btn btn-primary continue-btn submit-btn">{{ __('messages.Delete') }}</button>  
                                <button href="javascript:void(0);" data-dismiss="modal" class="mx-1 flex-fill btn btn-primary continue-btn cancel-btn">{{ __('messages.Cancel') }}</button>                  
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
        $('.e_file_name').val(_this.find('.file_name').text());
    });
</script>
@endsection
@endsection
