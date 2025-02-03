@extends('layouts.master')
@section('content')
{!! Toastr::message() !!}
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">{{ __('messages.Template_List') }}</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('messages.Dashboard') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('/') }}">{{ __('messages.Forms') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('messages.Template_List') }}</li>
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
                                <th>{{ __('messages.Id') }}</th>
                                <th>{{ __('messages.Template_Name') }}</th>
                                <th>{{ __('messages.Upload_By') }}</th>
                                <th>{{ __('messages.Date_Time') }}</th>
                                <th class="text-center">{{ __('messages.Modify') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($dataTemplate as $key=>$items )
                            <tr>
                                <td class="id">{{ $items->id }}</td>
                                <td class="template_name">{{ $items->template_name }}</td>                          
                                <td><strong>{{ $items->upload_by }}</strong></td>
                                <td>{{ $items->date_time }}</td>
                                <td class="text-center">
                                    <a href="{{ route('form/template', ['id' => $items->id]) }}">
                                        <span class="badge bg-info"><i class="bi bi-search"></i></span>
                                    </a>
                                    <a href="{{ route('form/edit/template', ['id' => $items->id]) }}">
                                        <span class="badge bg-success"><i class="bi bi-pencil-square"></i></span>
                                    </a>
                                    <a class="send" href="#" data-toggle="modal">
                                        <span class="badge bg-warning"><i class="bi bi-box-arrow-up-right"></i></span>
                                    </a>
                                    <a class="delete" href="#" data-toggle="modal" data-target="#delete_template">
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

<div class="modal custom-modal fade" id="delete_template" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>{{ __('messages.Delete_Form_Template') }}</h3>
                    <p>{{ __('messages.Are_you_sure_want_to_delete?') }}</p>
                </div>
                <div class="modal-btn delete-action">
                    <form action="{{ route('form/delete') }}" method="POST">
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
<div class="modal custom-modal fade" id="emailModal" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>Send Form Link</h3>
                </div>
                <div class = "modal-btn">
                    <input type="hidden" name="id" class="e_template_id" value="">
                    <input type="hidden" name="id" class="e_template_name" value="">
                    <input type="email" class="form-control" id="emailInput" placeholder="Enter email address">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="closeModal">{{ __('messages.Cancel') }}</button>
                        <button type="button" class="btn btn-primary" id="sendEmailButton">{{ __('messages.Send') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('script')
{{-- delete js --}}
<script>
    $(document).on('click','.delete',function()
    {
        var _this = $(this).parents('tr');
        $('.e_id').val(_this.find('.id').text());
        $('.e_file_name').val(_this.find('.file_name').text());
    });
    $(document).on('click', '.send',function() 
    {
        var _this = $(this).parents('tr');
        $('.e_template_id').val(_this.find('.id').text());
        $('.e_template_name').val(_this.find('.template_name').text()); // Corrected this line
        $('#emailModal').modal('show');
    });

    $('#sendEmailButton').click(function() {
        var temp_id = $('.e_template_id').val();
        var temp_name = $('.e_template_name').val();
        var email = $('#emailInput').val();

        if (email) {
            var currentPageUrl = window.location.href;
            var formLink = "{{ route('form/link', ':id') }}".replace(':id', temp_id);
            var emailSubject = "Form "+ temp_name;
            var emailBody = `${formLink}`;
            $("#sendEmailButton").attr("disabled", true)
            $.ajax({
                url: '/form/send', // Change this to the actual route for sending emails
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    email: email,
                    subject: emailSubject,
                    body: emailBody,
                },
                success: function(response) {
                    // Handle success, e.g., show a success message
                    $('#emailModal').modal('hide');
                    toastr.success("Form link send sucessfully!");
                    console.log(response);
                    $("#sendEmailButton").attr("disabled", false)
                },
                error: function(error) {
                    // Handle error, e.g., show an error message
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
</script>
@endsection
@endsection