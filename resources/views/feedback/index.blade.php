@extends('layouts.master')
@section('content')
    {{-- message --}}
    {!! Toastr::message() !!}
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">{{ __('messages.User_Feedback') }}</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('messages.Dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('messages.Maintenance') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('messages.User_Feedback') }}</li>
                        </ul>
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
                                    <th>{{ __('messages.Subject') }}</th>
                                    <th>{{ __('messages.Message') }}</th>
                                    <th class="text-center">{{ __('messages.Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($feedback as $feedbackItem)
                                <tr>
                                    <td class="id">{{ $feedbackItem->id }}</td>
                                    <td>
                                        <strong>{{ $feedbackItem->subject }}</strong>
                                    </td>
                                    <td>
                                        {!! nl2br(e($feedbackItem->message)) !!}
                                    </td>
                                    <td class="text-center">
                                        <a class="delete" href="#" data-toggle="modal" data-target="#delete_feedback_record">
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

    <!-- Delete Record Form Modal -->
    <div class="modal custom-modal fade" id="delete_feedback_record" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>{{ __('messages.Delete_Feedback_Record') }}</h3>
                        <p>{{ __('messages.Are_you_sure_want_to_delete?') }}</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <form action="{{ route('feedback/delete') }}" method="POST">
                            @csrf
                            @method('DELETE')
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
    <!-- /Delete Record Form Modal -->

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
