$(document).ready(function() 
{
    var urlSubmit = "/form/submit/response";

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      });

    const fbTemplate = document.getElementById('build-wrap');
    var renderedForm = $('<div>');
    renderedForm.formRender({ 'formData' : form_data });
    fbTemplate.innerHTML = renderedForm.formRender("html");

    $('#formSubmitResponse').on('submit', function() {
        var currentPageUrl = window.location.href;
        var id = currentPageUrl.split('/').pop();
        var formData = {};
        $('#build-wrap input, #build-wrap select, #build-wrap textarea').each(function() {
            if ($(this).attr('type') === 'radio') {
                // Handle radio buttons
                if ($(this).is(':checked')) {
                    formData[$(this).attr('name')] = $(this).val();
                }
            } else {
                // Handle other input types (text, select, textarea)
                formData[$(this).attr('name')] = $(this).val();
            }        
        });

        $.ajax({
            type: 'POST',
            url: urlSubmit,
            dataType: 'json',
            data: {
                id: id,
                formData: JSON.stringify(formData)
            },
            success: function(response) {
                toastr.success('Response saved successfully :)');
            },
            error: function(error) {
                toastr.error('Error saving response :(');
                console.log(error);
            }
        });
    });
    
});