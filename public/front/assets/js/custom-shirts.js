import {checkInputs} from "./uploadModal.js";
$(document).ready(function () {
    let typeInfo = [];
    let type_information = [];
    let hiddenTypes = [];
    let sizeInfo = [];
    let size_information = [];
    let overset = 500;
    if($("#type_information").length > 0){
        type_information = $("#type_information").html();
        typeInfo = $.parseJSON(type_information);

        size_information = $("#size_information").html();
        sizeInfo = $.parseJSON(size_information);
        hiddenTypes = $.parseJSON($("#related_types").html());

        //completeRelatedItems();
    }

    function setQuantityItems() {
        let qnt = $('#quantity'),
            selected_qnt = qnt.find(":selected").val()

        let selected_qnt_text = parseInt(qnt.find(":selected").text());

        const overCountElement = $('.over_count');
        if (overCountElement.length > 0) {
            const overCount = parseInt($('.over_count').val());

            if (selected_qnt_text >= overCount) {
                $('.product_deliveries label').removeClass('active').addClass('hidden');

                // Show only labels with class 'is_over' and check the radio button
                let $overLabels = $('.product_deliveries label.is_over');
                if ($overLabels.length > 0) {
                    $overLabels.removeClass('hidden').addClass('active').find('input[type="radio"]').prop('checked', true);
                }
            } else {
                $('.product_deliveries label').removeClass('hidden');
                // $('.product_deliveries label:not(.hidden)').first().addClass('active');
                $('.product_deliveries label.is_over').removeClass('active').addClass('hidden');
                // $('.product_deliveries label:not(.hidden) input[type="radio"]').first().prop('checked', true);
            }
        }



        calculateTotal()
    }

    function renderShipmentMethodList(shipmentList) {

        const container = $('.single_product_sipping_total');

        var html = `
        <tr>
            <th>Shipping Method </th>
            <th>Prices</th>
        </tr>`;
        $(".single_product_sipping_total").append("<thead></thead>");
        $(".single_product_sipping_total thead").append(html);
        $(".single_product_sipping_total").append("<tbody></tbody>");

        $.each(shipmentList, function(provider, keys) {

            var h = `<tr><td ><b>${keys.text}</b> ${keys.terms}</td>`;
            if(keys.price > 0){
                h += `<td >+${keys.price}$</td></tr>`;
            }else{
                h += `<td></td></tr>`;
            }

            $('.single_product_sipping_total tbody').append(h);

        });

    }

    $(document).on('change', 'input[name=delivery]', function () {
        $('.product_deliveries label').removeClass('active')
        $(this).parent().addClass('active')

        calculateTotal()
    })

    $(document).on('change', '.product_attr_select, .coupon_percent, #quantity', function () {

        let selectedImages = [];

        $('.selectric-selected').each(function () {
            const typeId = $(this).data('id');
            const imagesForType = productImagesByType[typeId] || [];
            if(imagesForType.length){
                selectedImages = selectedImages.concat(imagesForType.length ? imagesForType[0] : []);
            }

        });

        selectedImages = defaultProductImages.concat([...new Set(selectedImages)]);

        if(selectedImages.length > defaultProductImages.length){
            updateImages(selectedImages);
        }

        if($(this).data('attr') == 16 && $(this).val() == 51){
            $(".custom_grommet_block").show();
        }else if($(this).data('attr') == 16 &&  $(this).val() !=51){
            $(".custom_grommet_block").hide();
        }

        calculateTotal()
    })
    setQuantityItems()

    function updateImages(images) {
        if ($(".single-product-cover").hasClass('slick-initialized')) {
            $(".single-product-cover").slick('unslick');
        }

        const mobileSwiperWrapper = document.querySelector('.mobile_single_product .swiper-wrapper');

        // Update Swiper slides with new images
        mobileSwiperWrapper.innerHTML = images.map((image, index) => `
        <div class="swiper-slide">
            <div class="single_product_big_image open_product_popup"
                 style="background-image: url('${image}')"
                 data-id="${index}"
                 data-image="${image}"
            ></div>
        </div>
    `).join('');

        if (window.mobileSwiperInstance) {
            window.mobileSwiperInstance.destroy(true, true);
        }

        // Reinitialize Swiper
        window.mobileSwiperInstance = new Swiper(".mobile_single_product", {
            pagination: {
                el: ".swiper-pagination",
            },
        });

        window.mobileSwiperInstance.slideTo(images.length - 1, 0, false);

        // Update Cover Container
        const coverContainer = document.querySelector('.single-product-cover');
        coverContainer.innerHTML = images.map((image, index) => `
        <div class="single-slide">
            <div class="single_product_big_image open_product_popup"
                 style="background-image: url('${image}')"
                 data-id="${index}"
                 data-image="${image}"
            ></div>
        </div>
    `).join('');

        // Update Popup Images
        const popupImagesContainer = document.querySelector('.popup_images');
        popupImagesContainer.innerHTML = images.map((image, index) => `
        <a href="${image}"
           class="image-popup-vertical-fit product_popup_${index}">
            <img src="${image}"
                 style="object-fit: cover; object-position: center; width: 100%; height: 100%;">
        </a>
    `).join('');

        $(".single-product-cover").slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: false,
            loop: false,
            asNavFor: ".single-nav-thumb",
            initialSlide: $(".single-product-cover .slick-slide").length - 1
        });

        popUp_init();

    }

    $(document).on('keyup', '.custom_input_apparel', function () {
        calculateTotal();
    })

     function calculateTotal(){

         let total = 0,
             delivery = $('input[name=delivery]'),
             selected_delivery = $('input[name=delivery]:checked').val();

         var formData = $("#calculation_form").serializeArray();

         var calculation = [];
         var quantities = {};
         let total_price = 0;
         let total_count = 0;
         let per_item_amount = 0;
         $(formData).each(function (index, obj) {
             var attr = $('[name="'+obj.name+'"]');
             if(attr.hasClass('need_calculate')){
                 if(attr.hasClass('qty_item')){
                     var qty = 0;
                     if($("[name='" + obj.name + "']").val() > 0){
                         qty = $("[name='" + obj.name + "']").val();
                     }
                     var data_id = $("[name='" + obj.name + "']").attr('data-attr');
                     if (!quantities.hasOwnProperty(data_id)) {
                         // If the key doesn't exist, initialize it as an array
                         quantities[data_id] = [];
                     }
                     quantities[data_id].push({[$("[name='" + obj.name + "']").attr('data-id')]:parseInt(qty, 10)});


                 }else{
                     calculation.push({
                         [$("[name='" + obj.name + "']").attr('data-attr')]:parseInt($("[name='" + obj.name + "']").val(), 10),
                     });
                 }

             }
         });

         $.each(typeInfo.types, function(key, list) {
             if (quantities.hasOwnProperty(key)) {
                $.each(quantities[key],function(q_type,q_val){
                    var qty_type_id = Object.keys(q_val)[0];
                    var qty_type_value = q_val[qty_type_id];

                    //calculate price for each size(prodcut price)
                    total_price = total_price+list[qty_type_id].price*qty_type_value;
                    total_count = total_count + qty_type_value;
                })
             }
         });

         $.each(calculation, function(key, list) {

             var attr_id = Object.keys(list)[0];
             if (typeInfo.types.hasOwnProperty(attr_id)) {
                 var type_id = list[attr_id];
                 var pr = 0;
                 if(typeInfo.types[attr_id][type_id].price > 0){
                     total_price = total_price + typeInfo.types[attr_id][type_id].price*total_count;
                 }
             }


         });

         let closestValue = null;
         $.each(typeInfo.quantity, function (index, value) {
             if (value.id <= total_count) {
                 if (!closestValue || value.id > closestValue.id) {
                     closestValue = value;
                 }
             }
         });

         if (closestValue && closestValue.discount) {
             total_price = total_price - (total_price * closestValue.discount / 100);
         }

         delivery.each(function (i, obj) {
             let delivery_price = total_price + (total_price / 100 * parseFloat($(obj).val()))
             $(obj).parent().find('b').text('$' + delivery_price.toFixed(2))
         });
         if (selected_delivery) {
             total_price += total_price / 100 * parseFloat(selected_delivery)
         }

         total_price = parseFloat(total_price).toFixed(2);
         $('.new-price').text('$' + total_price);
         $("#total_price_amount").val(total_price);
         $("#total_amount").val(total_price);
         $("#per_item_amount").val(total_price);

     }

    $('input[name=delivery]:checked').each(function() {
        $(this).trigger('change');
    });

    $(document).on('click', '.ec-product-inner', function () {
        location.href = $(this).find('.image').attr('href')
    })

    $(document).on('click', '.calculate_shipping', function () {
        const route = $(this).attr('data-url');
        const loadingSpinner = `<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>`
        $('.single_product_sipping_total').html(loadingSpinner)
        $.ajax({
            type: "POST",
            url: route,
            data: {
                zip_code: $('.shipping_postcode').val(),
                quantity_id: $('#quantity').val(),
                product_id: $('input[name="product_id"]').val(),
                total_price:$("#total_price_amount").val(),
            },
            dataType: 'json',
            success: (data) => {
                $('#shipping-errors').html('');
                if (data.message) {
                    $('.single_product_sipping_total').html('')
                    $('#shipping-errors').append('<div class="text-danger">'+data.message+'</div');
                }else{
                    $('.single_product_sipping_total').html('')
                    renderShipmentMethodList(data)
                }

            }
        });
    })

    $('.shipping_postcode').on('input', function () {
        $('.single_product_sipping_total').html("")
        $('.calculate_shipping').attr('disabled', !$(this).val())
    })

    $(document).on('click', '.open_product_popup', function () {
        let id = $(this).attr('data-id')

        $('.product_popup_' + id).click()
    })

    // Function to handle each tab's description
    function handleTabDescription(tab) {
        const product_description = tab.find('.ec-single-pro-tab-desc');

        if (product_description.length) {
            let description_height = 0;

            product_description.each((index, desc) => {
                description_height += $(desc).height();
            });

            const read_more_block = tab.find('.product_read_more_block');

            if (description_height >= 550) {
                product_description.addClass('more_content');
                read_more_block.addClass('more_content');
                $('.product_read_more_block button').text('Read More');
            }else{
                $('.product_read_more_block').hide();
            }
        }
    }

    $(document).ready(function () {
        const activeTab = $('.tab-pane.show.active');
        handleTabDescription(activeTab);
    });

    $('.nav-tabs button').on('shown.bs.tab', function (e) {
        $('.product_read_more_block').show();
        const tab = $($(e.target).data('bs-target'));
        handleTabDescription(tab);
    });

    $(document).on('click', '.product_read_more_block button', function (e) {
        e.preventDefault();

        const tabContent = $(this).closest('.tab-pane');
        const product_description = tabContent.find('.ec-single-pro-tab-desc');
        const read_more_block = tabContent.find('.product_read_more_block');

        product_description.toggleClass('more_content');
        read_more_block.toggleClass('more_content');

        const button_text = $(this).text() === 'Read More' ? 'Show Less' : 'Read More';
        $(this).text(button_text);
    });

    $(document).on('mouseover', '.menu_category_products li a, .menu_products li a', function () {
        let url = $(this).attr('data-url'),
            image = $(this).attr('data-image'),
            title = $(this).attr('data-title')
        $('.menu_hover_product').html('<li><a href="' + url + '" class=""><img src="' + image + '" alt="' + title + '"><button class="btn btn-primary layer shop_btn" type="button">SHOP NOW</button>' + title + '</a></li>')
    })

    $(window).on('orientationchange', function() {
        $(window).one('resize', function() {
            // Reinit sliders
            $('.ec-blog-slider, #ec-cat-slider').owlCarousel('destroy')
            $('.ec-blog-slider, #ec-cat-slider').owlCarousel({
                margin:30,
                loop: true,
                dots:false,
                nav:false,
                smartSpeed: 1000,
                autoplay:true,
                items:3,
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 1,
                        nav:false
                    },
                    576: {
                        items: 2,
                        nav:false
                    },
                    768: {
                        items: 2,
                        nav:false
                    },
                    992: {
                        items: 3,
                        nav:false
                    },
                    1200: {
                        items:4,
                        nav:false
                    },
                    1367: {
                        items: 4,
                        nav:false
                    }
                }
            });
        });
    });

    $(document).on('mouseover', '.user_dropdown', function () {
        $('.user_dropdown_block').addClass('show')
    })

    $(document).on('mouseout', '.user_dropdown', function () {
        $('.user_dropdown_block').removeClass('show')
    })

    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    window.addEventListener("scroll", function() {
        const header = document.querySelector('.ec-header');
        document.querySelector('.ec-header').classList.add('scroll_shadow');
        const scrollPosition = window.scrollY;
        const triggerPoint = 100;

        if (scrollPosition > triggerPoint) {
            header.classList.add('scroll_shadow');
            document.querySelector('.mobile_search_block').classList.add('hidden_search');
        } else {
            header.classList.remove('scroll_shadow');
            document.querySelector('.mobile_search_block').classList.remove('hidden_search');
        }

        if (scrollPosition === 0) {
            header.classList.remove('scroll_shadow');
        }
    });

    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    const isMobile = window.matchMedia("only screen and (max-width: 991px)").matches;

    if (isMobile) {
        $('#tooltipIcon').on('click', function() {
            $('#tooltip').toggleClass('visible');
        });

        $(document).on('click', function(event) {
            if (!$(event.target).closest('#tooltipIcon, #tooltip').length) {
                $('#tooltip').removeClass('visible');
            }
        });
    }

    $('.qty_item').on('input', function () {
        let value = $(this).val();
        let validValue = value.replace(/[^0-9]/g, '');
        $(this).val(validValue);

        if (validValue.trim() !== '') {
            $(this).parent('div').addClass('selected_border');
        } else {
            $(this).parent('div').removeClass('selected_border');
        }
    });

    $(document).on('click', '.add_cart, .product_design', function (e) {
        $("#ec-overlay").show();

        e.preventDefault();
        setTimeout(()=>{
            $("#calculation_form").submit();
        }, 1000)
    })

    $(document).on('click', '.update_cart', function (e) {
        $("#ec-overlay").show();
        e.preventDefault();
        setTimeout(()=>{
            $("#calculation_form").submit();
        }, 1000)
    })

    $(document).on('click', '.product_continue', function (e) {
        e.preventDefault();
        if ($('.custom_input_group').length) {
            let has_error = false
            $('.custom_input_group').each(function (i, obj) {
                if (!$(obj).find('input').val().trim().length) {
                    $(obj).find('input').attr('style', 'border: 1px solid red !important')
                    has_error = true
                } else {
                    $(obj).find('input').attr('style', '')
                }
            });
            if (has_error) {
                return
            }
        }
        let url = {},
            quantity_id = $('#quantity option:selected').val()
        if($('input[name=delivery]:checked').val() == undefined){
            url['delivery'] = -1;
        }else{
            url['delivery'] = $('input[name=delivery]:checked').val();
        }
        if($(".custom_input").length > 0){
            const customInputs = document.querySelectorAll('.custom_input');

// Iterate through each custom input
            customInputs.forEach(input => {

                const value = input.value; // Get the value of the input

                const dataName = input.dataset.name; // Get the value of the data-name attribute
                url[dataName] =  value;
            });
        }

        url['product_id'] = $(this).attr('data-id')

        url['quantity_id'] = quantity_id
        url['coupon'] = $('.coupon_name').val();

        $('.product_attr_select').each(function (i, obj) {

            let data = JSON.parse($(obj).find('option:selected').val())

            Object.entries(data).forEach(([key, val]) => {
                if (Array.isArray(data)) {
                    let size_id = data.filter(o => o.quantity === parseInt(quantity_id))[0].id
                    url['size_' + size_id] = data.filter(o => o.quantity === parseInt(quantity_id))[0].price
                } else {
                    val.forEach(item => {
                        if (item.quantity === parseInt(quantity_id)) {
                            url['attr_' + item.id] = item.value
                        }
                    })
                }
            });
        });
        $('.first_step').hide();
        $('.product_continue').hide();
        $('.mobile_total_block').hide();
        $('.second_step').show();
        $('.buttons_block').show();
        $('.upload_files_block').show();
        $('.add_cart').prop('disabled', true);
        $('.update_cart').prop('disabled', false);
        const input = $('#project_title');
        input.focus();
        $('html, body').animate({ scrollTop: input.offset().top - 250 }, 500);

        updateTotalPrice();
        checkInputs();

        return true;
    });

    $('input[name="type"]').on('change', function(e) {
        e.preventDefault();

        if ($('#order_type_1').is(':checked')) {
            $('#uploadModal').modal('show');
        }
        if($('#order_type_3').is(':checked')){
            Swal.fire({
                title: "Title",
                text: "Text",
                confirmButtonColor: "#3474d4",
                confirmButtonText: "Ok",
            });
        }

        checkInputs();
        updateTotalPrice();
    });

    $('#project_title').on('input', function() {
        checkInputs();
    });

    $(document).on('click', '.back_first_step', (e)=>{
        e.preventDefault();
        $('.first_step').show();
        $('.product_continue').show();
        $('.second_step').hide();
        $('.buttons_block').hide();
        $('.upload_files_block').hide();

        let totalAmount = parseFloat($('#per_item_amount').val());

        // Update the displayed total price
        $('.new-price').text('$' + totalAmount.toFixed(2));
        $("#total_price_amount").val(totalAmount);
        $("#total_amount").val(totalAmount);

        checkInputs();
    })

    function updateTotalPrice() {
        let designPrice = parseFloat($('#order_type_3').data('price'));
        let totalAmount = parseFloat($('#per_item_amount').val());

        if ($('#order_type_3').is(':checked')) {
            totalAmount += designPrice;
        }

        // Update the displayed total price
        $('.new-price').text('$' + totalAmount.toFixed(2));
        $("#total_price_amount").val(totalAmount);
        $("#total_amount").val(totalAmount);
    }
})