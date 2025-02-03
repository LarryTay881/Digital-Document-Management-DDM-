@extends('layouts.master')
@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.11/cropper.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> <!-- Link to your local style.css -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.11/cropper.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/tesseract.js@4/dist/tesseract.min.js'></script>
@endsection

@section('content')
    {{-- message --}}
    {!! Toastr::message() !!}
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">{{ __('messages.Recognize') }}</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('/') }}">{{ __('messages.Dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('/') }}">{{ __('messages.OCR') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('messages.Recognize') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header" style="text-align: center;">
                            <h3 class="card-title mb-0">{{ __('messages.Recognize') }}</h5>
                        </div>
                        <br>
                        <form action="{{ route('ocr/recognize') }}" id="ocr-recognize" class="uploader" method="GET">
                            @csrf
                            <div class="form-group">
                                <h4 class="card-title mb-0"><center>Please select any text on the form.</h2>
                                <p><center>Drag the blue selector box until it contains only the answer text for a question, then click "Read".</p>
                                <p><center>After you have all the answer(s) selected, click "Download" to proceed.</p>
                                <div style="width: 595px;; height: 842px;;">
                                    <img id="image" src="{{ route('ocr/show/image', ['id' => request('id')]) }}" width="595" height="842">
                                </div>
                                </br>
                                <label for="ocrLanguage">Select the language to read:</label>
                                <select name="ocrLanguage" id="ocrLanguage">
                                    <option value="eng">EN</option>
                                    <option value="eng">BM</option>
                                    <option value="chi_sim">CN</option>
                                </select>
                                </br>
                                <button class="btn btn-primary custom-btn" type="button" id="crop">Read</button>
                                <button class="btn btn-primary custom-btn" type="button" id="down">Submit</button>

                                <div id="selections"></div>
                            </div>
                        </form>
                        <form method="POST">
                            <div id="ocrResult" style="display: none;" class="form-group col-sm-12"></div>
                            <div style="display: flex; justify-content: center; align-items: center;">
                                <button style="margin: 0 10px; display:none;" class="btn btn-primary custom-btn" type="button" id="generate">Generate Form</button>
                            </div>
                            <div id="ocrFieldSection" style="display: none;" class="form-group col-sm-12"></div>
                            <div style="display: flex; justify-content: center; align-items: center;">
                                <button style="margin: 0 10px; display:none;" class="btn btn-primary custom-btn" type="button" id="ocrTemplate">Save as Template</button>
                                <button style="margin: 0 10px; display:none;" class="btn btn-primary custom-btn" type="button" id="ocrResponse">Save as Response</button>
                                <br/>
                            </div>
                        </form>
                    </br>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal custom-modal fade" id="saveModal" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Save Response</h3>
                    </div>
                    <div class="modal-btn">
                        <label for="templateSelect">Select Template:</label>
                        <select class="form-control" id="templateSelect" name="templateSelect">
                        </select>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="closeModal">{{ __('messages.Cancel') }}</button>
                            <button type="button" class="btn btn-primary" id="save">{{ __('messages.Save') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal custom-modal fade" id="templateName" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Save Template Name</h3>
                    </div>
                    <div class="modal-btn">
                        <input type="text" class="form-control" id="templateNameInput" placeholder="Enter Template Name">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="closingModal">{{ __('messages.Cancel') }}</button>
                            <button type="button" class="btn btn-primary" id="saving">{{ __('messages.Save') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        async function recognize_text(base64Image){
            var base64data = base64Image.split(',')[1];
            var apiUrl = 'http://127.0.0.1:5000/ocr';
            console.log(base64data)
            var formData = new FormData();
            formData.append("base64", base64data);

            // async to wait for the result
            try {
                var response = await fetch(apiUrl, {
                    method: 'POST',
                    mode: 'cors',  // Set the mode to 'cors' to enable cross-origin requests
                    body: formData,
                });
            if (!response.ok) {
                throw new Error('API request failed');
            }
            var result = await response.json();
            result=result.result
            temp = ""

            for (let i = 0; i < result.length; i++) {
                temp += result[i] + "\n"
                console.log(result[i])
            }

            console.log(temp)
            const ocrResult = document.getElementById('ocrResult');
            const newOcr = document.createElement('textarea');
            const nonEmptyRows = temp.split('\n').filter(row => row.trim() !== '');
            const nonEmptyText = nonEmptyRows.join('\n');
            newOcr.id = 'ocrRow';
            newOcr.rows = '10';
            newOcr.className = 'form-control';
            newOcr.value = nonEmptyText;
            ocrResult.appendChild(newOcr);
            ocrResult.style.display = 'block';
            document.getElementById('generate').style.display = 'block';  

            // document.getElementById('down').disabled = false;
            } catch (error) {
            console.error('Error:', error);
            // Handle error, show error message, etc.
            }
        }
        var readText = "";
        var labelRegex = /([a-zA-Z0-9]+\s*[^:]+)\s*:/g;
        const image = document.getElementById('image');
        const cropper = new Cropper(image, {
            aspectRatio: 0,
        });

        document.getElementById('crop').addEventListener('click', function () {
            var br = document.createElement('br')
            var im = document.createElement("img");
            var pt = document.createElement("p");
            var ocrLan = document.getElementById('ocrLanguage').value;
            document.getElementById('down').disabled = true;
            var croppedImage = cropper.getCroppedCanvas().toDataURL("image/png");
            recognize_text(croppedImage)
           
        });
        
        document.getElementById('generate').addEventListener('click', function () {
            const ocrRow = document.getElementById('ocrRow');
            const formData = ocrRow.value.split('\n');
            const ocrFieldSection = document.getElementById('ocrFieldSection');

            ocrFieldSection.innerHTML = '';

            formData.forEach((row, index) => {
                if (row.trim() !== '') {
                    const matches = row.match(labelRegex);
                    if (matches) {
                        matches.forEach((match) => {
                            const label = match.replace(/[^a-zA-Z0-9]+/g, '');
                            const labelBeforeColon = match.split(':')[0].trim();
                            let userInput = row.split(':')[1].trim();
                            
                            userInput = userInput.replace(/_/g, "");
                            userInput = userInput.replace(/^\s+/, '');

                            const labelElement = document.createElement('label');
                            labelElement.textContent = labelBeforeColon + ":";
                            ocrFieldSection.appendChild(labelElement);
                            const inputElement = document.createElement('input');
                            inputElement.id = labelBeforeColon.replace(/\s/g, '_');
                            inputElement.type = 'text';
                            inputElement.className = 'form-control';
                            inputElement.value = userInput;
                            ocrFieldSection.appendChild(inputElement);
                        });
                    }
                }
            });

            ocrFieldSection.style.display = 'block';
            document.getElementById('ocrTemplate').style.display = 'block';
            document.getElementById('ocrResponse').style.display = 'block';
        });

        document.getElementById('down').addEventListener('click', function () {
            const content = readText;
            var file = new Blob([content], { type: 'text/plain' });
            file.name = "sample.txt";

            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);

            var submitFileForm = document.createElement("form");
            submitFileForm.name = "submitFile";
            submitFileForm.method = "POST";
            submitFileForm.action = "{{ route('ocr/saveresult') }}";
            submitFileForm.enctype = "multipart/form-data";

            var fileSubmit = document.createElement("input");
            fileSubmit.type = "FILE";
            fileSubmit.name = "filesubmit";
            fileSubmit.files = dataTransfer.files;
            submitFileForm.appendChild(fileSubmit);

            document.body.appendChild(submitFileForm);
            submitFileForm.submit();
        });

        document.getElementById('ocrTemplate').addEventListener('click', function () {
            $('#templateName').modal('show');
            $('#saving').off('click');
            $('#saving').on('click', function () {
                const templateName = $('#templateNameInput').val();
                if (!templateName) {
                    toastr.warning('Template name cannot be empty.');
                    return;
                }
                const ocrFieldSection = document.getElementById('ocrFieldSection');
                const formElements = ocrFieldSection.querySelectorAll('input[type="text"]');
                const formDataArray = [];

                formElements.forEach((element) => {
                    const label = element.id;
                    const value = element.value;
                    formDataArray.push({ 
                        type: 'text',
                        required: false,
                        label: label,
                        className: 'form-control',
                        name: label,
                        access: false,
                        subtype: 'text',
                        value: ''                
                    });
                });
                const formDataJSON = JSON.stringify(formDataArray);

                fetch('{{ route('save/ocr/template') }}?templateName=' + templateName, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ formData: formDataJSON })
                })
            
                .then(response => response.json())
                .then(data => {
                    toastr.success(templateName + ' template saved successfully :)');
                    $('#templateName').modal('hide');

                })
                .catch(error => {
                    toastr.error('Error saving template :(');
                    console.log(error);
                });
            });
            $('#closingModal').on('click', function () {
                $('#templateName').modal('hide');
            });
        });

        document.getElementById('ocrResponse').addEventListener('click', function () {
            fetch('{{ route('get/template/list') }}', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                const templateSelect = document.getElementById('templateSelect');
                templateSelect.innerHTML = '';
                data.templates.forEach(template => {
                    const option = document.createElement('option');
                    option.value = template.id;
                    option.text = template.template_name;
                    templateSelect.add(option);
                });
                $('#saveModal').modal('show');
            })
            .catch(error => {
                toastr.error('Error fetching template list :(');
                console.log(error);
            });
        });

        document.getElementById('save').addEventListener('click', function () {
            const templateId = document.getElementById('templateSelect').value;          
            const ocrFieldSection = document.getElementById('ocrFieldSection');
            const formElements = ocrFieldSection.querySelectorAll('input[type="text"]');
            const formDataArray = {};

            formElements.forEach((element) => {
                const label = element.id;
                const value = element.value;
                formDataArray[label] = value;
            });
            fetch('{{ route('get/template/fields') }}?templateId=' + templateId, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
            })
            .then(response => response.json())
            .then(templateData => {
                var jsonArray = JSON.parse(templateData.formData);
                const templateFieldCount = jsonArray.length;
                const responseFieldCount = Object.keys(formDataArray).length;

                if (templateFieldCount != responseFieldCount) {
                    toastr.error('Number of fields in the response does not match the template.');
                } else {
                    const formDataJSON = formDataArray;
                    fetch('{{ route('save/ocr/response') }}?templateId=' + templateId, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ formData: formDataJSON })
                    })
                    .then(response => response.json())
                    .then(data => {
                        toastr.success('Response saved successfully :)');
                        $('#saveModal').modal('hide');
                    })
                    .catch(error => {
                        toastr.error('Error saving response :(');
                        console.log(error);
                    });
                }
            })
            .catch(error => {
                toastr.error('Error fetching template data :(');
                console.log(error);
            });
        });

        document.getElementById('closeModal').addEventListener('click', function () {
            $('#saveModal').modal('hide');
        });
    </script>
@endsection