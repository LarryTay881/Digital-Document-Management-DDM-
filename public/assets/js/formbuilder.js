$(document).ready(function() 
{
  var urlSave = "/form/save/template";
  var urlEdit = "/form/update/template"; // Define the URL for editing templates
  var template_id = null;

  $.ajaxSetup({
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
  });

  const fbTemplate = document.getElementById('build-wrap');
  var options = {
    onSave: function(evt, formData) {
        if (form_data != "") {
          $.ajax({
            type: 'POST',
            url: urlEdit,
            dataType: 'json',
            data: {
              id: document.getElementById("formId").value,
              formData: JSON.stringify(formData)
            },
            success: function(response) {
              toastr.success('Template edited successfully :)');
            },
            error: function(error) {
              toastr.error('Error editing template :(');   
              console.log(error);
            }
          });
        } else 
        {
          // We are saving a new template
          $('#templateName').modal('show');
          $('#save').off('click');
            // Handle save button click inside the modal
          $('#save').on('click', function () {
          const templateName = $('#templateNameInput').val();
            if (!templateName) {
              toastr.warning('Template name cannot be empty.');
                return;
            }
            $.ajax({
              type: 'POST',
              url: urlSave,
              dataType: 'json',
              data: {
                templateName: templateName,
                formData: JSON.stringify(formData)
              },
              success: function(response) {
                toastr.success(templateName + ' template saved successfully :)');
                $('#templateName').modal('hide');
              },
              error: function(error) {
                toastr.error('Error saving template :(');   
                console.log(error);
              }        
            });
          });
          $('#closeModal').on('click', function () {
            $('#templateName').modal('hide');
          });
        }
      },
    };

  $(fbTemplate).formBuilder(options).promise.then(formBuilder => {
    if (form_data != "") {
      formBuilder.actions.setData(JSON.parse(form_data));
      $.ajax({
        type: 'GET',
        url: urlEdit,
        dataType: 'json',
        success: function(response) {
          if (response.formData != null) {
            formBuilder.actions.setData(JSON.parse(response.formData));
            template_id = response.id; // Set template_id for editing
          }
        },
        error: function(error) {
          console.log(error);
        }
      });

      let formData = localStorage.getItem("formData");
      if (formData != null) {
        formBuilder.actions.setData(JSON.parse(formData));  
      }
    }
  });
});
