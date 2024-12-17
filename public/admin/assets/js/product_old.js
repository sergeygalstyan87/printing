$(document).ready(function () {

    /* Image sorting and delete */
    $(".product_images").sortable();

    $(document).on("click", ".delete_image", function () {
        $(this).parents(".product_image").remove();
    });
    /* End Image sorting and delete */

    let deliveries = $('.delivery_group').length
    $(document).on('click', '.add_delivery_type', function () {
        $('.delivery_groups').append('<div class="form-group delivery_group"><div><label>Title</label> <input type="text" class="form-control" placeholder="Delivery title" name="delivery[' + deliveries + '][title]" value="" required> </div> <div> <label>Percent</label> <input type="number" class="form-control" placeholder="Delivery percent" name="delivery[' + deliveries + '][price]" value="0" required></div><button type="button" class="btn btn-danger delete_delivery_type">Delete</button></div>')
        deliveries++
    })

    $(document).on('click', '.delete_delivery_type', function () {
        $(this).parents('.delivery_group').remove()
    })

    let custom_inputs = $('.custom_input_group').length
    $(document).on('click', '.add_custom_input', function () {
        $('.custom_inputs').append('<div class="form-group custom_input_group"><div><label>Title</label><input type="text" class="form-control" placeholder="Title" name="inputs[' + custom_inputs + '][title]" value="" required></div><button type="button" class="btn btn-danger delete_custom_input">Delete</button></div>')
        custom_inputs++
    })

    $(document).on('click', '.delete_custom_input', function () {
        $(this).parents('.custom_input_group').remove()
    })

    $(document).on('input', '.qnt_item_price', function () {
        let qnt_total = 0,
            qnt_block = $(this).parents('.quantity_block')

        qnt_block.find('.qnt_item_price').each(function (i, obj) {
            qnt_total += parseFloat($(obj).val())
        });

        qnt_block.find('.quantity_total').html(qnt_total.toFixed(4))

    })

    /* Change category */
    $(document).on('change', '#category_id', function () {
        let cat_id = $(this).val(),
            subcategories = categories_array.filter(function (el) {
                return el.parent == cat_id
            }),
            html = '<div class="form-group"><label for="subcategory_id">Sub Category</label><select id="subcategory_id" class="form-control" name="subcategory_id">';

        $.each(subcategories, function (index, quantity) {
            html += '<option value="' + quantity.id + '">' + quantity.name + '</option>'
        });

        html += '</select></div>'
        $('.subcategories').html(html)
    })

    /* Attributes, Quantities, Shipping */

    function updateOrders(){
        let ids = $('.attribute_types ul.select2-selection__rendered li').map(function(i) {
            let title = $(this).attr('title')
            return $('.attribute_types option').filter(function () {
                var parser = new DOMParser,
                    dom = parser.parseFromString(
                    '<!doctype html><body>' + $(this).html(),
                    'text/html'),
                    decodedHtml = dom.body.textContent;
                return decodedHtml === title;
            }).val();
        }).get();

        let attribute_ids = $('.attributes_select_block ul.select2-selection__rendered li').map(function(i) {
            let title = $(this).attr('title')
            return $('.attributes_select_block option').filter(function () { return $(this).html() === title; }).val();
        }).get();

        let quantity_ids = $('.quantities_select_block ul.select2-selection__rendered li').map(function(i) {
            let title = $(this).attr('title')
            return $('.quantities_select_block option').filter(function () { return $(this).html() === title; }).val();
        }).get();

        ids.forEach((item, index) => {
            $('.type_id_for_order[value="'+item+'"]').parents('.attr_group').find('.qnt_item_order').val(index)
        })

        attribute_ids.forEach((item, index) => {
            $('.attribute_order_input[data-id="'+item+'"]').val(index)
        })

        quantity_ids.forEach((item, index) => {
            $('.quantity_order[data-id="'+item+'"]').val(index)
        })
    }

    let quantities_arr = [],
        attributes = $('#attributes'),
        quantities = $('#quantities'),
        sizes = $('#sizes')

    Object.entries(quantities_object).forEach(([key, val]) => {
        quantities_arr[val.id] = val.number
    });

    function generateQuantities(quantity) {
        let quantities_blocks = $('.quantities_blocks')
        if (quantities_blocks.find('.quantity_' + quantity).length === 0) {
            quantities_blocks.append('<div class="quantity_block quantity_' + quantity + '" data-quantity="' + quantity + '">' +
                '<div class="quantity_top_block">' +
                '<h4>Prices for quantity ' + quantities_arr[quantity] + '</h4>' +
                '<div>Total: <b>$<span class="quantity_total">0</span></b></div>' +
                '</div>' +
                '<div class="quantity_attributes"></div>' +
                '<div class="quantity_sizes"></div>' +
                '<div class="quantity_grommets"></div>' +
                // '<div class="quantity_shipping">' +
                // '<h6>Shipping price for quantity ' + quantities_arr[quantity] + '</h6>' +
                // '<input type="number" name="shippings[' + quantity + '][price]" value="0" step="0.0001" class="form-control">' +
                // '</div>' +
                '</div>')
        }
    }

    function generateAttributes(qnt_id) {
        $.each(attributes.val(), (index, attribute) => {
            let attr_id = attribute
            $.each($('#attribute_' + attribute).val(), (index, type) => {
                generateTypes(qnt_id, attr_id, type)
            });
        });
    }

    function generateTypes(quantity, attribute, type, text = false) {
        let readonly_input = "<input readonly type='text' value='" + $("#attribute_" + attribute + " option[value='" + type + "']").text() + "' class='form-control'>"
        $('.quantity_' + quantity + ' .quantity_attributes').append('<div class="attr_group type_' + attribute + ' group_' + type + '">' +
            readonly_input +
            '<span>$</span><input type="number" step="0.0001" name="types[quantity_' + quantity + '_type_' + type + '][price]" value="0" class="form-control qnt_item_price">' +
            '<input type="hidden" name="types[quantity_' + quantity + '_type_' + type + '][quantity_id]" value="' + quantity + '">' +
            '<input type="hidden" name="types[quantity_' + quantity + '_type_' + type + '][type_id]" value="' + type + '" class="type_id_for_order">' +
            '<input type="hidden" name="types[quantity_' + quantity + '_type_' + type + '][order]" value="0" class="qnt_item_order">' +
            '<input type="hidden" name="types[quantity_' + quantity + '_type_' + type + '][quantity_order]" value="0" class="quantity_order"  data-id="' + quantity + '">' +
            '</div>')
    }

    function generateSizes() {
        setTimeout(() => {
            $.each($('.quantity_block'), (index, quantity) => {
                let qnt_id = $(quantity).attr('data-quantity')
                if ($(quantity).find('.quantity_sizes .square_size').length === 0 && $('#size_status').is(":checked")) {
                    $(quantity).find('.quantity_sizes').html('<h6>Sizes</h6>' +
                        '<div class="attr_group square_size">' +
                        '<input type="text" readonly value="Square FT" class="form-control">' +
                        '<span>$</span><input type="text" step="0.0001" name="sizes[quantity_' + qnt_id + '][price]" value="0" class="form-control square_ft_price">' +
                        '<input type="hidden" name="sizes[quantity_' + qnt_id + '][quantity_id]" value="' + qnt_id + '">' +
                        '</div>')
                }

                $.each(sizes.val(), (index, size) => {
                    let size_text = $("#sizes option[value='" + size + "']").text(),
                        readonly_input = "<input readonly type='text' value='" + size_text + "' class='form-control'>"

                    if ($(quantity).find('.quantity_sizes .size_' + size).length === 0) {
                        $(quantity).find('.quantity_sizes').append('<div class="attr_group size_' + size + '" style="display: none">' +
                            readonly_input +
                            '<span>$</span><input type="text" step="0.0001" name="sizes[quantity_' + qnt_id + '_size_' + size + '][price]" value="0" class="form-control square_ft_price">' +
                            '<input type="hidden" name="sizes[quantity_' + qnt_id + '_size_' + size + '][quantity_id]" value="' + qnt_id + '">' +
                            '<input type="hidden" name="sizes[quantity_' + qnt_id + '_size_' + size + '][size_id]" value="' + size + '">' +
                            '</div>')
                    }
                });

            });
        }, 0)
    }

    function generateGrommets() {
        $.each($('.quantity_block'), (index, quantity) => {
            let qnt_id = $(quantity).attr('data-quantity')
            if ($(quantity).find('.quantity_grommets .square_size').length === 0 && $('#grommet_status').is(":checked")) {
                $(quantity).find('.quantity_grommets').html('<h6>Grommets</h6>' +
                    '<div class="attr_group">' +
                    '<input type="text" readonly value="Grommet price" class="form-control">' +
                    '<span>$</span><input type="text" step="0.0001" name="grommets['+qnt_id+'][price]" value="0" class="form-control">' +
                    '</div>')
            }
        });
    }

    $(document).on('click', '#pills-11-tab', function () {

        /* Init all attributes */
        quantities.select2({
            placeholder: 'Please select a quantities',
            closeOnSelect: false
        });

        quantities.on("select2:selecting", function (e) {
            e.preventDefault()
            let selected_quantities = quantities.val(),
                qnt_id = e.params.args.data.id,
                check = selected_quantities.indexOf(qnt_id)

            if( check > -1){
                selected_quantities.splice(check, 1)
                $('.quantity_' + parseInt(qnt_id)).remove()
            }else{
                selected_quantities.push(qnt_id)
                generateQuantities(qnt_id)
                generateAttributes(qnt_id)
                generateSizes()
                generateGrommets()
            }

            quantities.val(selected_quantities);
            quantities.trigger('change');
        });

        quantities.on('select2:unselect', function (e) {
            let elem = e.params.data
            $('.quantity_' + parseInt(elem.id)).remove()
        });

        attributes.select2({
            placeholder: 'Please select a attributes',
            closeOnSelect: false
        });

        attributes.on("select2:selecting", function (e) {
            e.preventDefault()
            let selected_attributes = attributes.val(),
                attribute_id = e.params.args.data.id,
                attribute_text = e.params.args.data.text,
                check = selected_attributes.indexOf(attribute_id)

            if( check > -1){
                selected_attributes.splice(check, 1)
                $('.type_' + attribute_id).remove()
            }else{
                let obj = types.filter(o => o.attribute_id === parseInt(attribute_id)),
                    options = ''


                Object.entries(obj).forEach(([key, val]) => {
                    options += '<option value="' + val.id + '">' + val.name + '</option>'
                });

                $('.attribute_types').append('<div class="form-group row type_group type_' + attribute_id + '">' +
                    '<div class="col-md-12">' +
                    '<label for="attribute_' + attribute_id + '">' + attribute_text + '</label>' +
                    '<select id="attribute_' + attribute_id + '" multiple="multiple" class="form-control" >' + options + '</select>' +
                    '<input type="hidden" min="0" value="0" name="attributes[' + attribute_id + '][order]" class="form-control attribute_order_input" data-id="'+attribute_id+'">' +
                    '</div>' +
                    '</div>')

                let attr = $('#attribute_' + attribute_id);

                attr.select2({
                    placeholder: 'Please select a attribute types',
                    closeOnSelect: false
                });

                attr.on("select2:selecting", function (e) {
                    e.preventDefault()
                    let selected_types = attr.val(),
                        type_id = e.params.args.data.id,
                        check = selected_types.indexOf(type_id)

                    if( check > -1){
                        selected_types.splice(check, 1)
                        $('.group_' + type_id).remove()
                    }else{
                        selected_types.push(type_id)
                        $.each(quantities.val(), function (index, quantity) {
                            generateTypes(quantity, attribute_id, type_id)
                        });
                    }

                    attr.val(selected_types);
                    attr.trigger('change');
                });

                attr.on('select2:unselect', function (e) {
                    let elem = e.params.data
                    $('.group_' + parseInt(elem.id)).remove()
                });

                selected_attributes.push(attribute_id)
            }

            attributes.val(selected_attributes);
            attributes.trigger('change');

            setTimeout(() => {
                $("ul.select2-selection__rendered").sortable({
                    containment: 'parent',
                    update: () => {
                        updateOrders()
                    }
                });
            }, 500)

            updateOrders()
        });

        attributes.on('select2:unselect', function (e) {
            let elem = e.params.data
            $('.type_' + parseInt(elem.id)).remove()
        });

        sizes.select2({
            placeholder: 'Please select a sizes',
            closeOnSelect: false
        });

        sizes.on("select2:selecting", function (e) {
            e.preventDefault()
            let selected_sizes = sizes.val(),
                size_id = e.params.args.data.id,
                check = selected_sizes.indexOf(size_id)

            if( check > -1){
                selected_sizes.splice(check, 1)
                $('.size_' + size_id).remove()
            }else{
                selected_sizes.push(size_id)
                generateSizes(size_id)
            }

            sizes.val(selected_sizes);
            sizes.trigger('change');
        });

        sizes.on('select2:unselect', function (e) {
            let elem = e.params.data
            $('.size_' + parseInt(elem.id)).remove()
        });

        /* Attribute change events */

        $('.edit_select2').select2({
            placeholder: 'Please select a attribute types'
        });

        $('.edit_select2').on("select2:selecting", function (e) {
            e.preventDefault()
            let selected_types = $(this).val(),
                type_id = e.params.args.data.id,
                check = selected_types.indexOf(type_id),
                type_attr_id = $(this).attr('id').split("_").pop()

            if( check > -1){
                selected_types.splice(check, 1)
                $('.group_' + type_id).remove()
            }else{
                selected_types.push(type_id)
                $.each(quantities.val(), function (index, quantity) {
                    generateTypes(quantity, type_attr_id, type_id)
                });
            }

            $(this).val(selected_types);
            $(this).trigger('change');
            updateOrders()
        });

        $('.edit_select2').on('select2:unselect', function (e) {
            let elem = e.params.data
            $('.group_' + parseInt(elem.id)).remove()
        });

        $("ul.select2-selection__rendered").sortable({
            containment: 'parent',
            update: () => {
                updateOrders()
            }
        });
    })
    /* End Attributes, Quantities, Shipping */

    $(document).on('change', '#size_status', function () {
        if ($(this).is(":checked")) {
            generateSizes()
            $('.custom_sizes').show()
            $('.size_types').show()
        } else {
            $.each($('.quantity_sizes'), (index, sizes) => {
                $(sizes).html('')
            });
            $('.custom_sizes').hide()
            $('.size_types').hide()
        }
    })

    $(document).on('change', '#grommet_status', function () {
        if ($(this).is(":checked")) {
            generateGrommets()
            $('.custom_grommets').show()
        } else {
            $('.custom_grommets').hide()
        }
    })

    $(document).on('input', '.square_ft_price', function () {
        let qnt_price = $(this).val()
        $(this).parents('.quantity_sizes').find('.square_ft_price').each(function (i, obj) {
            $(obj).val(qnt_price)
        });
    })

    let discounts = $('.discount_group').length
    $(document).on('click', '.add_discount', function () {
        $('.discounts_block').append('<div class="form-group discount_group"><div><label>Total Square FT</label> <input type="number" min="0" class="form-control" placeholder="Over" name="square_discounts[' + discounts + '][total]" value="" required> </div> <div> <label>Percent</label> <input type="number" class="form-control" placeholder="Delivery percent" name="square_discounts[' + discounts + '][percent]" value="0" required></div><button type="button" class="btn btn-danger delete_square_discount">Delete</button></div>')
        discounts++
    })

    $(document).on('click', '.delete_square_discount', function () {
        $(this).parents('.discount_group').remove()
    })

    $(document).on('click', '.submit_add_product', function (e) {
        e.preventDefault()
        let validation_errors = 0
        $('#product_attributes input:not([type=radio]):not([type=checkbox]):not([type=hidden]):not([type=search]):not([readonly])').each(function(i, obj) {
            if($(obj).val().trim().length){
                $(obj).removeClass('error')
            }else{
                $(obj).addClass('error')
                validation_errors = 1
            }
        });
        if(!validation_errors){
            $(this).parents('form').submit()
        }
    })

});

/* Editor configs */
CKEDITOR.replace('content', {
    colorButton_enableMore: true,
    extraPlugins: 'colorbutton,font',
    on: {
        afterPasteFromWord: function (evt) {
            var filter = evt.editor.filter.clone(),
                fragment = CKEDITOR.htmlParser.fragment.fromHtml(evt.data.dataValue),
                writer = new CKEDITOR.htmlParser.basicWriter();

            // Disallow certain styles.
            filter.disallow('span{font-family,color}');

            // Process, and overwrite evt.data.dataValue.
            filter.applyTo(fragment);
            fragment.writeHtml(writer);
            evt.data.dataValue = writer.getHtml();
        }
    }
});
