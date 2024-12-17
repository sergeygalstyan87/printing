const token = $('meta[name="csrf-token"]').attr('content');
let beforeCloseConfirmed = false;
export let currentSetId = [];
let currentTypeIds = null;
let product = $('#product_id').val() ? $('#product_id').val() : null;

$('#uploadModal').on('show.bs.modal', function (e) {
    $('.loader_block').show();
    let button = $(e.relatedTarget); // The button that triggered the modal
    currentSetId = button.data('set-id') || '';
    currentTypeIds = button.data('type-ids');
    let setIds = [];
    if(currentSetId){
        setIds = currentSetId;
    }

    let radioButton = $('#order_type_1');
    if(radioButton.length){
        currentSetId = radioButton.data('set-id') || '';
        currentTypeIds = radioButton.data('type-ids') || '';
    }

    let selectedValues = [];
    $('.product_attr_select').each(function (i, obj) {
        let selectedValue = $(obj).val();

        if (selectedValue) {
            selectedValues.push(selectedValue);
        }
    });

    let setCount = $('#set_count').val();
    $('.set_input_item').each(function() {
        setIds.push($(this).data('set-id'));
    });

    const modalBody = $('#uploadModal .modal-body');
    modalBody.empty();

    $.ajax({
        url: '/get-uploaded-file-type',
        method: 'post',
        data: {
            set_id: setIds,
            setCount: setCount,
            type_ids: currentTypeIds,
            selected_values: selectedValues,
            product_id: product,
            _token: token,
        },
        success: function (response) {
            const setInputs = $('.set_input');

            if(!currentSetId || Array.isArray(currentSetId)){
                modalBody.html(response.view);
                const setItemsModal = $('.set_item');

                setInputs.each(function (index) {
                    const setName = $(this).find('input[name^="set_title"]').val();
                    const setInputIndex =  $(this).attr('data-set-index-key');
                    $(setItemsModal[index]).find('.set_title').text(`${setName}`);
                    $(setItemsModal[index]).attr('data-set-index-key', setInputIndex);
                });
            }else{
                modalBody.html(response.view);
            }
            let filesCount = 0;
            let loadedFiles = 0;

            $.each(response.uploadedFiles, function(setIndex, fileTypes) {
                const setItem = $(`.set_item[data-set-index-key="${setIndex}"]`);

                filesCount += Object.values(fileTypes).reduce((sum, fileFolders) => {
                    // Check if fileFolders is an array; if so, use its length, else count the keys in the object
                    if (Array.isArray(fileFolders)) {
                        return sum + fileFolders.length; // Add the length if it's an array
                    } else if (typeof fileFolders === 'object' && fileFolders !== null) {
                        return sum + Object.keys(fileFolders).length; // Add the number of keys if it's an object
                    }
                    return sum; // If neither, return the sum unchanged
                }, 0);

                $.each(fileTypes, function(fileType, fileFolders) {
                    const fileUploadInput = setItem.find(`input.file_upload_input[data-file-type="${fileType}"]`);

                    // Call previewFiles and wait for each file to load
                    previewFiles(fileUploadInput, fileFolders, function() {
                        if (Array.isArray(fileFolders)) {
                            loadedFiles += fileFolders.length; // Increment by the length of the array
                        } else if (typeof fileFolders === 'object' && fileFolders !== null) {
                            loadedFiles += Object.keys(fileFolders).length; // Increment by the number of keys in the object
                        }
                        // Check if all files are loaded
                        if (loadedFiles === filesCount) {
                            $('.loader_block').hide();
                        }
                    });
                });
            });
            if(!filesCount){
                $('.loader_block').hide();
            }
            sessionStorage.setItem('uploaded_folder_name', JSON.stringify(response.uploadedFiles));
            $('.file_upload_folder_name').val(JSON.stringify(response.uploadedFiles));
        },
        error: function (xhr, status, error) {
            console.error('AJAX Error:', error);
            $('.loader_block').hide();
        }
    });
});

$('#uploadModal').on('hide.bs.modal', function (e) {

    if (beforeCloseConfirmed) {
        beforeCloseConfirmed = false;
        return;
    }

    e.preventDefault();

    Swal.fire({
        title: 'Are you sure?',
        text: "Make sure that you've saved your changes before closing.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, close it',
        confirmButtonColor: '#3474d4',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            beforeCloseConfirmed = true;
            $('#uploadModal').modal('hide');
            allFiles = {};
            checkInputs();
        }
    });
});

function removeRequest(file, event){
    $('.loader_block').show();
    let type = ($(event.target).closest('.file_upload_block').find('.file_type')?.[0]?.innerText)?.toLowerCase();
    const setId = $(event.target).closest('.file_upload_block').data('set-id');

    $.ajax({
        url: '/tmp-delete',
        type: 'DELETE',
        data: {
            file: file,
            set_id: setId,
            type: type,
            product_id: product,
            _token: token
        },
        success: function(response) {
            sessionStorage.setItem('uploaded_folder_name', JSON.stringify(response.session_data));
        },
        error: function() {
            console.error('File deletion failed.');
        },
        complete: function() {
            $('.loader_block').hide();
        }
    });
}

export function checkInputs() {
    const jobName = $('#project_title')?.val()?.trim();
    const typeSelected = $('input[name="type"]:checked')?.val();
    let hasNonEmptyArray = false;

    let sessionData = sessionStorage.getItem('uploaded_folder_name');
    if (sessionData) {
        // Parse session data to check for non-empty arrays
        const parsedData = JSON.parse(sessionData);

        // Iterate over the parsed data to check for at least one non-empty array
        for (let key in parsedData) {
            if (parsedData.hasOwnProperty(key)) {
                const fileTypes = parsedData[key];

                for (let fileType in fileTypes) {
                    if (fileTypes.hasOwnProperty(fileType) && Array.isArray(fileTypes[fileType]) && fileTypes[fileType].length > 0) {
                        hasNonEmptyArray = true;
                        break;
                    }
                }
                if (hasNonEmptyArray) break;
            }
        }
    }

    if (jobName !== '' && typeSelected ) {
        if(typeSelected == 'Upload Print Ready Files'){
            if(hasNonEmptyArray){
                $('.add_cart').prop('disabled', false);
            }else{
                $('.add_cart').prop('disabled', true);
            }
        }else{
            $('.add_cart').prop('disabled', false);
        }
    } else {
        $('.add_cart').prop('disabled', true);
    }
}
let allFiles = {};
$(document).on('change', '.file_upload_input', function (event) {
    let inputFile = $(this);
    let newFiles = Array.from(event.target.files); // Get the newly uploaded files

    let fileType = $(this).data('file-type');
    if (!allFiles[fileType]) {
        allFiles[fileType] = [];
    }
    newFiles.forEach(file => {
        if (!allFiles[fileType].some(existingFile => existingFile.name === file.name && existingFile.size === file.size)) {
            allFiles[fileType].push(file);
        }
    });
    const dataTransfer = new DataTransfer();

    // Add remaining files in allFiles back to DataTransfer
    allFiles[fileType].forEach(file => dataTransfer.items.add(file));
    inputFile[0].files = dataTransfer.files;
    previewFiles(inputFile[0], newFiles);
});

function previewFiles(inputElement, files, callback) {
    $('.loader_block').show();
    let inputName = $(inputElement).attr('name');
    let formData = new FormData();
    $.each(files, function(i, file) {
        formData.append(inputName, file);
    });

    $.ajax({
        url: '/tmp-preview',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            response.forEach(function(fileData) {
                // Create a container for the image and details
                let previewContainer = $('<div>', { class: 'img-preview-container' });
                let img;

                if(fileData.url){
                    img = $('<img>', {
                        src: fileData.url,
                        alt: 'Uploaded Image',
                        class: 'img-preview',
                    });
                }else{
                    img = $('<p>', {
                        text: fileData.name,
                        class: 'img-preview file_name',
                    });
                }

                let detailsLayer = $('<div>', { class: 'details-layer' });
                let fileName = $('<p>', { text: fileData.name });
                let fileSize = $('<p>', { text: (fileData.size / 1024).toFixed(2) + ' KB' });
                let removeBtn = $('<p>', {
                    text: 'Remove',
                    class: 'remove-btn',
                    'data-folder': fileData.folder || fileData.name,
                    'data-exist': fileData.folder,
                });
                if ($('.img_preview_block').hasClass('slick-initialized')) {
                    $('.img_preview_block').slick('unslick');
                }
                detailsLayer.append(fileName).append(fileSize).append(removeBtn);
                previewContainer.append(img).append(detailsLayer);

                $(inputElement).closest('.file-container').find('.img_preview_block').append(previewContainer);

                // Initialize the Slick slider
                $('.img_preview_block').slick({
                    dots: true,
                    arrows: false,
                    infinite: true,
                    speed: 500,
                    slidesToShow: 1
                });
            });

            if (typeof callback === 'function') {
                callback();
            }
        },
        error: function() {
            console.log('File upload failed.');
        },
        complete: function() {
            $('.loader_block').hide();
        }
    });
}

// Use event delegation for the remove button
$(document).on('click', '.remove-btn', function(e) {
    e.preventDefault();
    let removeBtn = $(this);
    let previewContainer = removeBtn.closest('.img-preview-container');
    let inputFile = removeBtn.closest('.file-container').find('.file_upload_input');
    let fileDataFolder = removeBtn.data('folder');
    let isExist = removeBtn.data('exist');

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        confirmButtonColor: '#3474d4',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            if(isExist){
                removeRequest(fileDataFolder, e);
                previewContainer.remove();
            }else{
                // const inputFile = $(inputElement);
                let fileType = inputFile.data('file-type');

                if (allFiles[fileType]) {
                    // Filter out the file with the matching name
                    allFiles[fileType] = allFiles[fileType].filter(file => file.name !== fileDataFolder);
                }
                const dataTransfer = new DataTransfer();

                // Add remaining files in allFiles back to DataTransfer
                allFiles[fileType].forEach(file => dataTransfer.items.add(file));
                inputFile[0].files = dataTransfer.files;
                previewContainer.remove();
            }

            // Reinitialize Slick slider
            if ($('.img_preview_block').hasClass('slick-initialized')) {
                $('.img_preview_block').slick('unslick');
            }
            $('.img_preview_block').slick({
                dots: true,
                arrows: false,
                infinite: true,
                speed: 500,
                slidesToShow: 1
            });
        }
    });
});

$(document).on('click', '#file_upload_btn', function (e) {
    e.preventDefault();
    let formData = new FormData();
    let hasFiles = false; // Flag to track if any files were added

    $('.set_item').each(function(setIndex) {
        let setIndexKey = $(this).data('set-index-key') || setIndex;
        // console.log($(this))
        $(this).find('.file_upload_input').each(function() {
            let element = $(this);
            let fileType = $(this).data('file-type');
            let filesArray = Array.from(element[0].files);

            if (filesArray.length > 0) {
                hasFiles = true; // Set flag to true if files are added
                filesArray.forEach((file, fileIndex) => {
                    formData.append(`uploaded_files[${setIndexKey}][${fileType}][${fileIndex}]`, file);
                });
            }
        });
    });

    if (!hasFiles) {
        Swal.fire({
            title: 'No Changes Detected',
            text: 'There are no new files to upload.',
            icon: 'warning',
            confirmButtonText: 'OK',
            confirmButtonColor: '#3474d4'
        });
        return;
    }

    uploadFiles(formData);
});

function uploadFiles(formData) {
    $('.loader_block').show();

    if (product) {
        formData.append('product_id', product);
    }

    if (Array.isArray(currentSetId)) {
        currentSetId.forEach((id, index) => {
            formData.append(`set_id[${index}]`, id);
        });
    } else {
        formData.append('set_id', currentSetId);
    }

    $.ajax({
        url: '/tmp-upload',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            sessionStorage.setItem('uploaded_folder_name', JSON.stringify(response));
            beforeCloseConfirmed = true;
            $('#uploadModal').modal('hide');
            allFiles = {};
            checkInputs();
        },
        error: function() {
            console.log('File upload failed.');
        },
        complete: function() {
            $('.loader_block').hide();
        }
    });
}

$(document).on('click', '.details-layer', (e) => {
    if (!$(e.target).hasClass('remove-btn')) {
        e.preventDefault();
    }
});

