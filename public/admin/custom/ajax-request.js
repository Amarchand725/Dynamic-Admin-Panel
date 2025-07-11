$("form.submitBtnWithFileUpload").on('submit', function (e) {
    e.preventDefault();
    var thi = $(this);
    var url = $(this).attr('action');
    var method = $(this).attr('method');
    var modal_id = $(this).attr('data-modal-id');
    // Get the form data
    var formElement = $('#' + modal_id).find('#create-form');

    prepareFormDataBeforeSubmit(formElement);
    var formData = new FormData(formElement[0]);

    thi.find('.sub-btn').hide();
    thi.find('.loading-btn').show();

    $.ajax({
        url: url,
        type: method,
        data: formData,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },

        success: function (response) {
            thi.find('.sub-btn').show();
            thi.find('.loading-btn').hide();
            
            if (response.success == true) {
                
                toastr.success(response.message, 'Success', { timeOut: 1000 });

                if (response.route !== undefined) {
                    window.location.href = response.route;
                }else{
                    var oTable = $('.data_table').dataTable();
                    oTable.fnDraw(false);

                    // Check if it's an import response
                    if (response.files_count !== undefined && response.import_results !== undefined) {
                        let summary = `<strong>Total Files:</strong> ${response.files_count}<br>`;
                        summary += `<strong>Total Records Imported:</strong> ${response.total_records_inserted}<br><br>`;
                        summary += `<strong>Details:</strong><br>`;
                        response.import_results.forEach(function (result) {
                            summary += `- ${result.file}: ${result.records} records<br>`;
                        });

                        // Show summary under the file input inside the same modal
                        $('#' + modal_id).find('#import-summary-content').html(summary);
                    }else{
                        $('#' + modal_id).modal('hide');
                        $('#' + modal_id).removeClass('show');
                        $('#' + modal_id).parents('.card').find('.offcanvas-backdrop').removeClass('show');
                    }    
                }
            }else if (response.error) {
                // $('#' + modal_id).modal('hide');
                toastr.error(response.error);
            } else if (response.error == false) {
                toastr.error(response.message);
            }
        },
        error: function (xhr) {
            thi.find('.sub-btn').show();
            thi.find('.loading-btn').hide();
            // Parse the JSON response to get the error messages
            var errors = JSON.parse(xhr.responseText);
            
            // Reset the form errors
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').empty();
            $('.error').empty();

            // Loop through the errors and display them
            $.each(errors.errors, function (key, value) {
                const message = value[0];

                // Show a Toastr alert
                toastr.error(message);
                
                $('#' + key).addClass('is-invalid'); // Add the is-invalid class to the input element
                $('#' + key + '_error').text(value[0]); // Add the error message to the error element
            });
        }
    });
});
function prepareFormDataBeforeSubmit(formElement) {
    $(formElement).find('.summernote').each(function () {
        var content = $(this).summernote('code');
        $(this).val(content);
    });
}

$('.submitBtn').click(function (e) {
    e.preventDefault(); // Prevent the form from submitting normally
    var thi = $(this);

    var url = $(this).closest('form').attr('action');
    var method = $(this).closest('form').attr('method');

    var formId = $(this).closest('form').attr('id');
    var modal_id = $(this).closest('form').attr('data-modal-id');

    // var formData = $('#' + modal_id).find("#"+formId).serialize();
    var formData = $("#"+formId).serialize();
    
    // Check if the description variable exists in the serialized form data
    var fieldExists = formData.indexOf('description=') > -1;

    // if (fieldExists) {
    //     //Get editor value.
    //     var editorData = CKEDITOR.instances.description.getData();
    //     // Combine the editor data with the serialized form data
    //     formData = formData + '&description=' + encodeURIComponent(editorData);
    // }

    if (fieldExists) {
        // Get Summernote content (assumes #description is the textarea enhanced with Summernote)
        var editorData = $('#description').summernote('code');
    
        // Update/replace the existing `description` field in formData
        formData = formData.replace(/description=[^&]*/, 'description=' + encodeURIComponent(editorData));
    }

    thi.parents('.action-btn').find('.sub-btn').hide();
    thi.parents('.action-btn').find('.loading-btn').show();

    // Send the AJAX request
    // Add the CSRF token to the request headers
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: url,
        method: method,
        data: formData,
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function (response) {
            thi.parents('.action-btn').find('.sub-btn').show();
            thi.parents('.action-btn').find('.loading-btn').hide();

            if (response.success == true) {
                toastr.success(response.message, 'Success', { timeOut: 1000 });

                if (response.route !== undefined) {
                    window.location.href = response.route;
                }else{
                    var oTable = $('.data_table').dataTable();
                    oTable.fnDraw(false);

                    $('#' + modal_id).modal('hide');
                    $('#' + modal_id).removeClass('show');
                    $('#' + modal_id).parents('.card').find('.offcanvas-backdrop').removeClass('show');
                }
            } else if (response.error) {
                var html = '<div class="alert alert-danger">'+response.error+'</div>';
                $("#errorMessage").html(html).show();
                $('.error').text('');
                toastr.error(response.error);
            }
        },
        error: function (xhr) {
            thi.parents('.action-btn').find('.sub-btn').show();
            thi.parents('.action-btn').find('.loading-btn').hide();
            // Parse the JSON response to get the error messages
            var errors = JSON.parse(xhr.responseText);
            // Reset the form errors
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').empty();
            $('.error').empty();

            // Loop through the errors and display them
            $.each(errors.errors, function (key, value) {
                $('#' + key).addClass('is-invalid'); // Add the is-invalid class to the input element
                $('#' + key + '_error').text(value[0]); // Add the error message to the error element
            });
        }
    });
});

$(document).on('click', '.show', function () {
    var targeted_modal = $(this).attr('data-bs-target');
    var modal_label = $(this).attr('title');

    $(targeted_modal).find('#modal-label').html(modal_label);
    var html = '<div class="d-block w-100">' +
        '<div class="d-block w-100">' +
        '<div class="d-flex justify-content-center align-items-center" style="height: 20vw;>' +
        '<div class="demo-inline-spacing">' +
        '<div class="spinner-border spinner-border-lg text-primary" role="status">' +
        '<span class="visually-hidden">Loading...</span>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>';
    $(targeted_modal).find('#show-content').html(html);
    var show_url = $(this).attr('data-show-url');
    $.ajax({
        url: show_url,
        method: 'GET',
        success: function (response) {
            $(targeted_modal).find('#show-content').html(response);
        }
    });
});

$(document).on('click', '.delete', function () {
    var delete_url = $(this).attr('data-del-url');
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: delete_url,
                type: 'DELETE',
                success: function (response) {
                    if (response.status==true) {
                        Swal.fire({
                            title: 'Deleted!',
                            text: response.message,
                            icon: 'success',
                            timer: 1000,
                            showConfirmButton: false
                        });
                        var oTable = $('.data_table').dataTable();
                        oTable.fnDraw(false);
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: response.error || 'An unexpected error occurred.',
                            icon: 'error'
                        });
                    }
                },
                error: function (xhr) {
                    let errorMessage = "An unexpected error occurred. Please try again.";
                    
                    if (xhr.status === 403 && xhr.responseJSON) {
                        errorMessage = xhr.responseJSON.message || "You do not have permission to perform this action.";
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
            
                    Swal.fire({
                        title: 'Permission Denied!',
                        text: errorMessage,
                        icon: 'error'
                    });
                } 
            });
        }
    })
});

//Open modal for adding
$('#add-btn, .add-btn').on('click', function () {
    var targeted_modal = $(this).attr('data-bs-target');
    var store_url = $(this).attr('data-url');
    var modal_label = $(this).attr('title');
    var content_url = $(this).attr('data-create-url');
    loadForm(targeted_modal, store_url, modal_label, content_url);
});

//Open modal for editing
$(document).on('click', '.edit-btn', function () {
    var targeted_modal = $(this).attr('data-bs-target');
    var store_url = $(this).attr('data-url');
    var modal_label = $(this).attr('title');
    var content_url = $(this).attr('data-edit-url');
    loadForm(targeted_modal, store_url, modal_label, content_url);
});

function loadForm(targeted_modal, store_url, modal_label, content_url){
    $(targeted_modal).find('#modal-label').html(modal_label);
    $(targeted_modal).find("#create-form").attr("action", store_url);
    $(targeted_modal).find("#create-form").attr("method", 'POST');

    $.ajax({
        url: content_url,
        method: 'GET',
        beforeSend: function () {
            // Show a loading spinner or text before the response is loaded
            $(targeted_modal).find('#edit-content').html('<div class="text-center"><i class="fas fa-spinner fa-spin fa-2x"></i> Loading...</div>');
        },
        success: function (response) {
            // $(targeted_modal).find('#edit-content').html(response);
            const $modal = $(targeted_modal);
            $modal.find('#edit-content').html(response);

            // ✅ Check what kind of form was just loaded
            const $initTarget = $modal.find('[data-init]');
            const initType = $initTarget.data('init');

            // ✅ Run specific JS logic
            if (initType === 'dynamic-fields') {
                if (typeof initDynamicFormFeatures === 'function') {
                    initDynamicFormFeatures();
                }
            }
        },
        error: function (xhr) {
            if (xhr.status === 403) {
                // Handle permission error
                $(targeted_modal).find('#edit-content').html('<div class="alert alert-danger text-center">You do not have permission to access this resource.</div>');
            } else {
                // Handle other errors
                $(targeted_modal).find('#edit-content').html('<div class="alert alert-danger text-center">An error occurred. Please try again later.</div>');
            }
        }    
    });
}

function initDynamicFormFeatures() {
    $('select').each(function () {
        $(this).select2({ dropdownParent: $(this).parent() });
    });

    const stepperEl = document.querySelector('.wizard-vertical-icons-example');
    window.stepper = new Stepper(stepperEl, { linear: false, animation: true });

    const stepperHeader = document.getElementById('stepperTabs');
    const stepperContent = document.getElementById('stepperContent');

    Sortable.create(stepperHeader, {
        animation: 150,
        onEnd: function () {
            const order = [];
            document.querySelectorAll('.bs-stepper-header .step').forEach((step) => {
                order.push(step.dataset.target.replace('#', ''));
            });
            document.getElementById('field_order').value = JSON.stringify(order);
        }
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-field')) {
            const name = e.target.dataset.name;

            const stepEl = document.querySelector(`[data-target="#${name}"]`);
            const contentEl = document.getElementById(name);

            // Get all steps before removing
            const allSteps = Array.from(document.querySelectorAll('.step'));
            const removedIndex = allSteps.indexOf(stepEl);

            // Remove the step and content
            stepEl?.remove();
            contentEl?.remove();

            // Optional: remove trailing line
            const lines = document.querySelectorAll('.bs-stepper-header .line');
            if (lines.length) {
                lines[lines.length - 1].remove();
            }

            // Reinitialize stepper
            window.stepper.destroy();
            window.stepper = new Stepper(document.querySelector('.wizard-vertical-icons-example'), {
                linear: false,
                animation: true
            });

            // Refresh steps
            const updatedSteps = document.querySelectorAll('.step');

            // Determine new tab to activate
            if (updatedSteps.length > 0) {
                const newIndex = (removedIndex < updatedSteps.length) ? removedIndex : updatedSteps.length - 1;
                window.stepper.to(newIndex + 1); // Stepper index is 1-based
            }
        }

        const trigger = e.target.closest('.step-trigger');
        if (trigger) {
            const step = trigger.closest('.step');
            if (step && step.dataset.target) {
                const allSteps = Array.from(document.querySelectorAll('.step'));
                const index = allSteps.indexOf(step);
                if (index !== -1) {
                    window.stepper.to(index + 1);
                }
            }
        }
    });

    let fieldCount = 0;
    document.getElementById('add-field').addEventListener('click', function () {
        const name = `field_${Date.now()}`;
        const label = `New Field ${++fieldCount}`;

        const step = document.createElement('div');
        step.classList.add('step');
        step.dataset.target = `#${name}`;
        step.innerHTML = `
            <button type="button" class="step-trigger">
                <span class="bs-stepper-circle"><i class="ti ti-file-description"></i></span>
                <span class="bs-stepper-label">
                    <span class="bs-stepper-title">${label}</span>
                    <span class="bs-stepper-subtitle">Setup ${label}</span>
                </span>
            </button>
            <button type="button" class="btn btn-sm text-danger remove-field ms-1" data-name="${name}">×</button>
        `;
        stepperHeader.appendChild(step);
        stepperHeader.insertAdjacentHTML('beforeend', '<div class="line"></div>');

        const content = document.createElement('div');
        content.classList.add('content');
        content.id = name;

        let dataTypeOptions = '';
        for (const key in FIELD_TYPES) {
            dataTypeOptions += `<option value="${key}">${FIELD_TYPES[key]}</option>`;
        }

        let inputTypeOptions = '';
        for (const key in INPUT_TYPES) {
            inputTypeOptions += `<option value="${key}">${INPUT_TYPES[key]}</option>`;
        }

        let checkboxes = '';
        FIELD_ATTRS.forEach(attr => {
            const labelText = attr.replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase());
            checkboxes += `
                <div class="mb-2">
                    <label>
                        <input type="checkbox" name="fields[${name}][${attr}]" value="1"> ${labelText}
                    </label>
                </div>
            `;
        });

        content.innerHTML = `
            <div class="content-header mb-3">
                <h6 class="mb-0">${label}</h6>
                <small>Enter ${label} Settings.</small>
            </div>
            <div class="row g-3">
                <div class="col-sm-12">
                    <div class="mb-3">
                        <label>Field Name</label>
                        <input type="text" name="fields[${name}][name]" value="${name}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Data Type</label>
                        <select name="fields[${name}][type]" class="form-select">${dataTypeOptions}</select>
                    </div>
                    <div class="mb-3">
                        <label>Input Type</label>
                        <select name="fields[${name}][input_type]" class="form-select">${inputTypeOptions}</select>
                    </div>
                    <div class="mb-3">
                        <label>Label</label>
                        <input type="text" name="fields[${name}][label]" value="${label}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Placeholder</label>
                        <input type="text" name="fields[${name}][placeholder]" class="form-control">
                    </div>
                    ${checkboxes}
                    <div class="mb-3">
                        <label>Extra (JSON)</label>
                        <textarea name="fields[${name}][extra]" class="form-control" rows="3">{}</textarea>
                    </div>
                    <button type="button" class="btn btn-outline-danger btn-sm remove-field" data-name="${name}">Remove Field</button>
                </div>
            </div>
        `;

        stepperContent.appendChild(content);

        window.stepper.destroy();
        window.stepper = new Stepper(document.querySelector('.wizard-vertical-icons-example'), {
            linear: false,
            animation: true
        });

        const steps = document.querySelectorAll('.step');
        window.stepper.to(steps.length);
    });
}

//calling datatable
function initializeDataTable(pageUrl, columns) {
    tableClass = '.data_table';
    if ($.fn.DataTable.isDataTable(tableClass)) {
        $(tableClass).DataTable().destroy();
    }

    $(tableClass).DataTable({
        processing: true,
        serverSide: true,
        ordering: false,
        // ajax: pageUrl + "?loaddata=yes",
        ajax: {
            url: pageUrl + "?loaddata=yes",
            type: "GET",
            data: function(d) {
                d.search = $('input[type="search"]').val();
            },
            // error: function(xhr, error, code) {
            //     console.log(xhr);
            //     console.log(error);
            //     console.log(code);
            // }
        },
        columns: columns
    });
}

$('#country').on('change', function(){
    var url = $(this).attr('data-url');
    var country = $(this).val();
    $('#city').html('');
    $.ajax({
        url: url,
        data:{country:country},
        method: 'GET',
        success: function (response) {
            if(response){
                let options = '<option value="">Select State</option>';
                response.forEach(state => {
                    options += `<option value="${state.name}">${state.name}</option>`;
                });
                $('#state').html(options);
            }
        },
        error: function (xhr) {
            if (xhr.status === 403) {
                // Handle permission error
                toastr.error('You do not have permission to access this resource.');
            } else {
                // Handle other errors
                toastr.error('An error occurred. Please try again later.');
            }
        }    
    });
})
$('#state').on('change', function(){
    var url = $(this).attr('data-url');
    var state = $(this).val();
    $.ajax({
        url: url,
        data:{state:state},
        method: 'GET',
        success: function (response) {
            if(response){
                let options = '<option value="">Select City</option>';
                response.forEach(state => {
                    options += `<option value="${state.name}">${state.name}</option>`;
                });
                $('#city').html(options);
            }
        },
        error: function (xhr) {
            if (xhr.status === 403) {
                // Handle permission error
                toastr.error('You do not have permission to access this resource.');
            } else {
                // Handle other errors
                toastr.error('An error occurred. Please try again later.');
            }
        }    
    });
})

$(document).on('click', '.deleteImage', function () {
    var delete_url = $(this).attr('data-del-url');
    var thi = $(this);
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: delete_url,
                type: 'DELETE',
                success: function (response) {
                    if (response.status==true) {
                        Swal.fire({
                            title: 'Deleted!',
                            text: response.message,
                            icon: 'success',
                            timer: 1000,
                            showConfirmButton: false
                        });
                        thi.parents('.preview-wrapper').remove();
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: response.error || 'An unexpected error occurred.',
                            icon: 'error'
                        });
                    }
                },
                error: function (xhr) {
                    let errorMessage = "An unexpected error occurred. Please try again.";
                    
                    if (xhr.status === 403 && xhr.responseJSON) {
                        errorMessage = xhr.responseJSON.message || "You do not have permission to perform this action.";
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
            
                    Swal.fire({
                        title: 'Permission Denied!',
                        text: errorMessage,
                        icon: 'error'
                    });
                } 
            });
        }
    })
});

$(document).on('click', '.purchase-order-btn', function () {
    var targeted_modal = $(this).attr('data-bs-target');
    var store_url = $(this).attr('data-url');
    var modal_label = $(this).attr('title');
    var content_url = $(this).attr('data-create-url');
    
    $(targeted_modal).find('#modal-label').html(modal_label);
    $(targeted_modal).find("#create-form").attr("action", store_url);
    $(targeted_modal).find("#create-form").attr("method", 'POST');

    $.ajax({
        url: content_url,
        method: 'GET',
        beforeSend: function () {
            // Show a loading spinner or text before the response is loaded
            $(targeted_modal).find('#edit-content').html('<div class="text-center"><i class="fas fa-spinner fa-spin fa-2x"></i> Loading...</div>');
        },
        success: function (response) {
            $(targeted_modal).find('#edit-content').html(response);
        },
        error: function (xhr) {
            if (xhr.status === 403) {
                // Handle permission error
                $(targeted_modal).find('#edit-content').html('<div class="alert alert-danger text-center">You do not have permission to access this resource.</div>');
            } else {
                // Handle other errors
                $(targeted_modal).find('#edit-content').html('<div class="alert alert-danger text-center">An error occurred. Please try again later.</div>');
            }
        }    
    });
});

//used for getting order data for creating purchase order
$(document).on('change', '#get-order', function () {
    const selectedOption = $(this).find('option:selected');
    const createUrl = selectedOption.data('create-url');

    if (createUrl) {
        $.ajax({
            url: createUrl,
            type: 'GET',
            beforeSend: function () {
                // Show a loading spinner or text before the response is loaded
                $('#order-form-container').html('<div class="text-center"><i class="fas fa-spinner fa-spin fa-2x"></i> Loading...</div>');
            },
            success: function (response) {
                $('#order-form-container').html(response);
            },
            error: function (xhr) {
                if (xhr.status === 403) {
                    // Handle permission error
                    $('#order-form-container').html('<div class="alert alert-danger text-center">You do not have permission to access this resource.</div>');
                } else {
                    // Handle other errors
                    $('#order-form-container').html('<div class="alert alert-danger text-center">An error occurred. Please try again later.</div>');
                }
            }    
        });
    } else {
        $('#order-form-container').html('');
    }
});