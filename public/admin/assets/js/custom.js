$(document).on('click', '.btn-sm.btn-danger:not(.delete-order), .delete_order_images', function (e){
    e.preventDefault()
    let btn = $(this)

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
            btn.parents('form').submit()
            Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
            )
        }
    })

});

$(document).on('change', '#form_full_paper', function () {

    if ($(this).val() == 1) {
        $("#form_per_item").hide();
        $("#form_per_sqr").hide();
        $("#form_per_list").show();
    }else if ($(this).val() == 2){
        $("#form_per_list").hide();
        $("#form_per_item").hide();
        $("#form_per_sqr").show();
    } else {
        $("#form_per_item").show();
        $("#form_per_sqr").hide();
        $("#form_per_list").hide();
    }
})
$(document).on('change', '#rel_attributes_input', function () {

    if ($(this).is(":checked")) {
        $(this).val(1);
        $('#related_block').show()

    } else {
        $(this).val(0);
        $('#related_block').hide()

    }
})
let templateIndexCounter = $('.clone_block').length;
let fileIndexCounter = 0;
$(document).on('click', '.input-container .add-btn', function () {
    let newInputGroup = $(this).closest('.clone_block').clone();
    let parent_node = $(this).closest('.input_block');
    templateIndexCounter++;
    newInputGroup = updateFileIndices(newInputGroup, templateIndexCounter, '');
    newInputGroup.find('.add-btn')
        .removeClass('btn-success add-btn')
        .addClass('btn-danger remove-btn')
        .text('−');

    $(parent_node).append(newInputGroup);
});
$(document).on('click', '.add_product_type_images', function (e) {
    e.preventDefault();

    let parent = $(this).closest('#product_type_images');

    let cloned_block = parent.find('.clone_block').first().clone();

    cloned_block.find('input, select').val('');

    parent.find('.input-container').append(cloned_block);
    cloned_block.find('select').select2();
});

$(document).on('click', '.input-container .remove-btn', function () {
    $(this).closest('.clone_block').remove();
});

$(document).on('click', '#template .add-file-btn', function () {
    let newInputGroup = $(this).closest('.input-group').clone();
    let parent_node = $(this).closest('.card-body');
    fileIndexCounter = $(this).data('index');
    fileIndexCounter++;
    let inputGroupCount = parent_node.find('.input-group').length;
    newInputGroup = updateFileIndices(newInputGroup, inputGroupCount++, 'templateFile');
    // newInputGroup.find('.add-file-btn')
    //     .removeClass('btn-success add-file-btn')
    //     .addClass('btn-danger remove-file-btn')
    //     .text('−');

    $(parent_node).append(newInputGroup);
    $(this).data('index', fileIndexCounter);
});

$(document).on('click', '#template .remove-file-btn', function () {
    let parent_node = $(this).closest('.card-body');
    if(parent_node.find('.input-group').length > 1){
        $(this).closest('.input-group').remove();
    }else{
        $(this).closest('.input-group').find('.custom-file-input').val('');
        $(this).closest('.input-group').find('.custom-file-label').html('Choose file');
    }
});
function updateFileIndices(newInputGroup, indexCounter, inputField){
    newInputGroup.find('input').val('');
    newInputGroup.find('.download-new-file-btn').remove();
    newInputGroup.find('.custom-file-label').html('Choose file');
    newInputGroup.find('input').each(function () {
        let name = $(this).attr('name');

        if (name) {
            if(inputField === 'templateFile'){
                name = name.replace(/(template_details\[\d+\]\[\w+\])\[\d+\]/, `$1[${indexCounter}]`);
            }else{
                name = name.replace(/template_details\[\d+\]/, `template_details[${indexCounter}]`);
            }
            $(this).attr('name', name);
        }
    });
    return newInputGroup;
}
$(document).on('change', '.custom-file-input', function () {
    let fileName = $(this).val().split('\\').pop();
    $(this).closest('.custom-file').find('.custom-file-label').html(fileName);
});

$(document).on("click", '.clear-extra-form', function() {
    const block = $(this).closest(".clear_body");
    block.find(":input").not(':button, :submit, :reset, :hidden, :file').val("");
    block.find(":checkbox, :radio").prop("checked", false);
    block.find(":file").each(function() {
        $(this).val('');
        $(this).siblings('.custom-file-label').text('Choose file');
    });

    block.find(":hidden").val("");
});

function imagePreview(file, block){
    const imagePreview = block.find('.imagePreview');
    block.show();
    if (file) {
        const reader = new FileReader();

        reader.onload = function (e) {
            imagePreview.attr('src', e.target.result);
            imagePreview.show();
        }

        reader.readAsDataURL(file);
    } else {
        imagePreview.hide();
        imagePreview.attr('src', '');
    }
}
