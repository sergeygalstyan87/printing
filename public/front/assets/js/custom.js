import {checkInputs} from "./uploadModal.js";

$(document).ready(function () {
    let typeInfo = [];
    let type_information = [];
    let hiddenTypes = [];
    let sizeInfo = [];
    let size_information = [];

    if($("#type_information").length > 0){
         type_information = $("#type_information").html();
         typeInfo = $.parseJSON(type_information);

         size_information = $("#size_information").html();
         sizeInfo = $.parseJSON(size_information);
         hiddenTypes = $.parseJSON($("#related_types").html());

         completeRelatedItems();
   }
    function getAttributesForType(type_id){
        var attr_info = typeInfo.types;
        var n = -1;
        $.each(attr_info,function(attr_key,attr_val){

            $.each(attr_val,function(type_key,type_val){

                if(type_key == type_id){
                   n = attr_key;
                }
            })
        })
      return n;
    }
    function completeRelatedItems() {
        var selected = $(".product_attr_select option");

        var disabled_types = [];
        var selected_types = [];
        var need_to_disable_type = [];
        $.each(selected,function(){
            if($(this).parent().attr('id') == 'quantity'){
                if($(this).parent().val() !=null){
                    selected_types.push('qty-'+$(this).parent().val());
                }
                if($(this).attr('disabled') == 'disabled'){
                    disabled_types.push('qty-'+$(this).val());
                }
            }else{
                if($(this).parent().val() !=null){
                    selected_types.push($(this).parent().val());
                }
                if($(this).attr('disabled') == 'disabled'){
                    disabled_types.push($(this).val());
                }
            }


        });

       selected_types = $.unique(selected_types);


        for(var i=0; i<selected_types.length; i++){
          if(typeof hiddenTypes[selected_types[i]] == 'object'){
           for(var k=0;k<hiddenTypes[selected_types[i]].length;k++){
              need_to_disable_type.push(hiddenTypes[selected_types[i]][k]);
           }
         }
        }

        var differenceArrayForDisabling = $.grep(need_to_disable_type, function (el) {
            return $.inArray(el, disabled_types) === -1;
        });
        var differenceArrayForEnabling = $.grep(disabled_types, function (el) {
            return $.inArray(el, need_to_disable_type) === -1;
        });

        var updated_attributes = [];

        for(var j=0; j<differenceArrayForEnabling.length; j++){
            var attr_id = getAttributesForType(differenceArrayForEnabling[j]);
            if( $("#attribute_"+attr_id).length > 0){
                $("#attribute_"+attr_id+" option[value='" + differenceArrayForEnabling[j] + "']").removeAttr("disabled");
            }else{
             ;
                if(differenceArrayForEnabling[j].includes("qty")){
                    let parts = differenceArrayForEnabling[j].split("qty-");
                    let number = parts[1];

                    if($("#quantity option[value='" + number + "']").is(':selected')){
                        $("#quantity option[value='" + number + "']").removeAttr('selected');
                        $("#quantity option[value='" + number + "']").prop("disabled", true);
                        var firstNonDisabledOption = $('#quantity option:not(:disabled)').first();
                        firstNonDisabledOption.prop('selected',true);
                    }else{
                        $("#quantity option[value='" + number + "']").removeAttr("disabled");
                    }
                    $("#quantity").selectric('refresh');
                }else{
                    $("#sizes option[value='" + differenceArrayForEnabling[j] + "']").removeAttr("disabled");
                    $("#sizes").selectric('refresh');
                }

            }
            if(!updated_attributes.includes(attr_id)){
                updated_attributes.push(attr_id);
            }
        }
        for(var j=0; j<differenceArrayForDisabling.length; j++){
            var attr_id = getAttributesForType(differenceArrayForDisabling[j]);

    if( $("#attribute_"+attr_id).length > 0){
        var optionValues = $("#attribute_"+attr_id+" option").map(function() {
            return $(this).val();
        }).get();


    let differenceArray = optionValues.filter(value => !differenceArrayForDisabling.includes(value));
    $("#attribute_"+attr_id+" option[value='" + differenceArrayForDisabling[j] + "']").removeAttr('selected');
    $("#attribute_"+attr_id+" option[value='" + differenceArrayForDisabling[j] + "']").addClass('hid_opt');

    $("#attribute_"+attr_id+" option[value='" + differenceArrayForDisabling[j] + "']").prop("disabled", true);
    var firstNonDisabledOption = $('#attribute_'+attr_id+' option:not(:disabled)').first();
    firstNonDisabledOption.prop('selected',true);
    //$("#attribute_"+attr_id).val(differenceArray[0])
    //$("#attribute_"+attr_id).val(differenceArray[0]);
}else{
        if(differenceArrayForDisabling[j].includes("qty")){
            let parts = differenceArrayForDisabling[j].split("qty-");
            let number = parts[1];

            if($("#quantity option[value='" + number + "']").is(':selected')){
                $("#quantity option[value='" + number + "']").removeAttr('selected');
                $("#quantity option[value='" + number + "']").prop("disabled", true);
                var firstNonDisabledOption = $('#quantity option:not(:disabled)').first();
                firstNonDisabledOption.prop('selected',true);
            }else{
                $("#quantity option[value='" + number + "']").prop("disabled", true);
            }
            $("#quantity").selectric('refresh');
        }else{
            if($("#sizes option[value='" + differenceArrayForDisabling[j] + "']").is(':selected')){
                $("#sizes option[value='" + differenceArrayForDisabling[j] + "']").removeAttr('selected');
                $("#sizes option[value='" + differenceArrayForDisabling[j] + "']").prop("disabled", true);
                var firstNonDisabledOption = $('#sizes option:not(:disabled)').first();
                firstNonDisabledOption.prop('selected',true);
            }else{
                $("#sizes option[value='" + differenceArrayForDisabling[j] + "']").prop("disabled", true);
            }
            $("#sizes").selectric('refresh');
        }
    //chekc if selected

}

            if(!updated_attributes.includes(attr_id)){
                updated_attributes.push(attr_id);
            }
        }
        //check if disabled and options count is same, then hide attribute
        //if some disabled is selected, find first and select it

        for(var k=0;k<updated_attributes.length;k++){


            $("#attribute_"+updated_attributes[k]).selectric('refresh');
            if($("#attribute_"+updated_attributes[k]+" option").length == $("#attribute_"+updated_attributes[k]+" option:disabled").length){
                $("#attr_block_"+updated_attributes[k]).hide();
            }else{
                $("#attr_block_"+updated_attributes[k]).show();
            }
        }

        $(".hidden_attr").hide();
    }

function calulateByPages(formData){
    let total = 0,
        delivery = $('input[name=delivery]'),
        quantity = $('#quantity').find(":selected").text(),
        quantity_id = $('#quantity').val(),
        selected_delivery = $('input[name=delivery]:checked').val(),
        calculation=[],
        result = [],
        cover_pages_count = 0,
        inside_pages_count = 0;

       var coupon_percent = parseFloat($('.coupon_percent').val());

        $(formData).each(function (index, obj) {
            var attr_id = 0;
            var is_attr = obj.name.split('attribute_');
            if (is_attr.length == 2) {
                attr_id = is_attr[1];
            }
           if(attr_id ==32){
               var a = $("#attribute_32 :selected").text();
               var numbers = a.match(/\d+/g);
               if (numbers && numbers.length >= 2) {
                   cover_pages_count = numbers[1];
                   inside_pages_count = numbers[2];
               }
           }else if(attr_id == 41){
               calculation['inside_paper'] = typeInfo.types[attr_id][obj.value].price_keys;
               calculation['inside_pages_count'] = inside_pages_count / 2;
           }else if(attr_id == 42){
               if($("#attribute_"+attr_id+" :selected").text() == 'Same as inside'){
                   calculation['cover_paper'] = typeInfo.types['41'][$("#attribute_41").val()].price_keys;
               }else{
                   calculation['cover_paper'] = typeInfo.types[attr_id][obj.value].price_keys;
               }
               calculation['cover_pages_count'] = cover_pages_count / 2;
           }else if(attr_id  > 0){
               var attr_calculation = typeInfo.types[attr_id][obj.value];

               if(attr_calculation.full_paper == 1){
                   result['attr_id']['price'] = attr_calculation.full_paper
               }
           }
        })

}
    function calculateTotal() {

        let total = 0,
            delivery = $('input[name=delivery]'),
            quantity = $('#quantity').find(":selected").text(),
            quantity_id = $('#quantity').val(),
            selected_delivery = $('input[name=delivery]:checked').val(),
            overset = $("#offset_qty").val();
            // coupon_percent = parseFloat($('.coupon_percent').val());


        var formData = $("#calculation_form").serializeArray();
       // calulateByPages(formData);return false;
        var calculation = [];
        $(formData).each(function (index, obj) {

            if ($("[name='" + obj.name + "']").length > 0) {
                var item_val = $("[name='" + obj.name + "']").val();
                if ((typeof calculation['details']) == 'undefined') {
                    calculation['details'] = [];
                }
                if (obj.name == 'quantity') {
                    $.each(typeInfo.quantity, function (index, value) {
                        if (value.id == item_val) {
                            calculation['qty'] = value.value;
                            calculation['qty_discount'] = value.discount;
                        }
                    })
                } else {

                    if(obj.name == 'sizes'){

                       if(item_val == 0){
                            var size_type = 'in';
                            if($("#size_type").length > 0){
                                size_type = $("#size_type").val();
                            }

                           calculation['width'] = $(".custom_width").val();
                           calculation['height'] = $(".custom_height").val();
                           if(size_type == 'ft'){
                               calculation['width'] = 12 * calculation['width'];
                               calculation['height'] = 12 * calculation['height'];
                           }
                       }else{
                           var i = typeInfo.types[2][item_val].size_id;
                           calculation['width'] = sizeInfo[i].width;
                           calculation['height'] = sizeInfo[i].height;
                       }
                    }else{
                        var cover_pages_count = 0;
                        var inside_pages_count = 0;
                        if($("#attribute_32").length > 0){
                            var a = $("#attribute_32 :selected").text();
                            var numbers = a.match(/\d+/g);
                            if (numbers && numbers.length >= 2) {
                                 cover_pages_count = numbers[1];
                                 inside_pages_count = numbers[2];
                            }
                        }
                        var is_attr = obj.name.split('attribute_');
                        let is_paper_type = $("[name='" + obj.name + "']").data('paper');
                        if (is_attr.length == 2) {
                            var attr_id = is_attr[1];

                            if (is_paper_type) {

                                calculation['paper'] = typeInfo.types[attr_id][item_val].price_keys;

                            }else if(attr_id == 41){
                                //cover stock
                                calculation['inside_paper'] = typeInfo.types[attr_id][item_val].price_keys;
                                calculation['inside_pages_count'] = inside_pages_count / 2;
                               // calculation['details'].push(typeInfo.types[attr_id][item_val]);
                            }else if(attr_id == 42){
                                //cover stock
                               // calculation['details'].push(typeInfo.types[attr_id][item_val]);
                                if($("#attribute_"+attr_id+" :selected").text() == 'Same as inside'){
                                    calculation['cover_paper'] = typeInfo.types['41'][$("#attribute_41").val()].price_keys;
                                }else{
                                    calculation['cover_paper'] = typeInfo.types[attr_id][item_val].price_keys;
                                }
                                calculation['cover_pages_count'] = cover_pages_count / 2;
                            }else {
                                calculation['details'].push(typeInfo.types[attr_id][item_val]);
                            }
                        }
                    }
                    //only custom

                    if(calculation.width ==undefined){
                        if($(".custom_width").val() == ''){
                            changeValuesForCustom();
                        }
                        var size_type = 'in';
                        if($("#size_type").length > 0){
                            size_type = $("#size_type").val();
                        }
                        calculation['width'] = $(".custom_width").val();
                        calculation['height'] = $(".custom_height").val();
                        if(size_type == 'ft'){
                            calculation['width'] = 12 * calculation['width'];
                            calculation['height'] = 12 * calculation['height'];
                        }
                    }

                }
            }
        });

        var prices = [];
        let price_if_size_is_same = 0;

        if(parseFloat(calculation.qty) >= parseFloat(overset)){
            $.each(calculation.paper, function (key, value) {
               calculation.paper[key].price = value.machine_price;

            })
        }

        $.each(calculation.paper, function (key, value) {

            var paper_width = sizeInfo[value['size_id']].width;

            var paper_height = sizeInfo[value['size_id']].height;
            var elements_count_1 = calculateElementsPerPage(paper_width, paper_height, calculation.width, calculation.height);
            var elements_count_2 = calculateElementsPerPage(paper_height, paper_width, calculation.width, calculation.height);
            var elements_count = (elements_count_1 > elements_count_2) ? elements_count_1 : elements_count_2;


            if(elements_count > 0 ){

                var paper_count = Math.ceil(calculation.qty / elements_count);
                // need to get mark is machine price should work or not, if not, couldn't take that price as it is 0

                    var price = paper_count * value['price'];

                $.each(calculation.details, function (d_key, d_value) {

                    if ($("#attr_block_" + d_value['attr_id']).css('display') != 'none') {

                        if (d_value['full_paper'] == 1) {
                            if(parseFloat(calculation.qty) >= parseFloat(overset)){

                                var d_price =  d_value['price_keys'][key]?.['machine_price'] ?? 0;
                            }else{
                                var d_price = d_value['price_keys'][key]?.['price'] ?? 0;
                            }
                                price = price + d_price * paper_count;

                        } else if(d_value['full_paper'] == 2){

                        }else {

                            price = price + d_value['price'] * calculation.qty;
                        }
                    }

                });

                prices.push(price);
                if(((parseFloat(calculation.width,2)+0.25) == paper_width) && ((parseFloat(calculation.height,2)+0.25) == paper_height)){
                    price_if_size_is_same = price;
                }

            }

        });

        var finishing_price = $("#finishing_price").val();
        //calculate per sqr

        if((calculation.paper == "" || calculation.paper == undefined) && calculation.cover_paper == undefined){
            var price = 0;
            var item_sqr_ft = (calculation.width /12) * (calculation.height / 12);
           $.each(calculation.details, function (d_key, d_value) {
                if ($("#attr_block_" + d_value['attr_id']).css('display') != 'none') {
                    if (d_value['full_paper'] == 2) {
                        price = price + (d_value['price']) * item_sqr_ft * calculation.qty;
                    } else {

                        if(d_value['id'] == 51){
                            price = price + d_value['price'] * calculation.qty*$(".custom_grommet").val();
                        }else{
                            price = price + d_value['price'] * calculation.qty;
                        }

                    }
                }

            });
            var total_sqr = item_sqr_ft * calculation.qty;
            if($(".square_discounts").length > 0){
                var disc = $(".square_discounts").val();
                var discount_obj = $.parseJSON(disc);
                var disc_percent  = [0];
                $.each(discount_obj,function(index,val){

                    if(parseFloat(index,2) < parseFloat(total_sqr,2)){
                        disc_percent.push(parseFloat(val,2));
                    }
                })
               var discount_sqr = Math.max.apply(Math,disc_percent);

                price = price - price * discount_sqr / 100;

            }
        }else{
            if(calculation.cover_paper == undefined){
                //calculate per list or per item

                if(price_if_size_is_same > 0 && price_if_size_is_same > 0){
                    price = price_if_size_is_same;
                }else{
                    let filteredPrices = prices.filter(price => price > 0);
                    price = Math.min.apply(null, filteredPrices);
                }
                price = price + calculation.qty * parseFloat(finishing_price);
            }else{

                var price = 10000000;
                var calculation_size = 0;
                var elements_count_data = 0;
                let paper_count = 0,
                    paper_count_inside = 0,
                elements_count;
                $.each(calculation.cover_paper, function (key, value) {
                    var paper_width = sizeInfo[value['size_id']].width;
                    var paper_height = sizeInfo[value['size_id']].height;
                    var elements_count_1 = calculateElementsPerPage(paper_width, paper_height, calculation.width, calculation.height);
                    var elements_count_2 = calculateElementsPerPage(paper_height, paper_width, calculation.width, calculation.height);
                     elements_count = (elements_count_1 > elements_count_2) ? elements_count_1 : elements_count_2;

                    if(elements_count > 0){
                      paper_count = Math.ceil(calculation.cover_pages_count*calculation.qty / elements_count);

                        paper_count_inside = Math.ceil(calculation.inside_pages_count * calculation.qty / elements_count);

                        if(paper_count * value['price'] < price){
                           elements_count_data = elements_count;
                           calculation_size = value['size_id'];
                          price = paper_count * value['price']+paper_count_inside*calculation.inside_paper[calculation_size].price;

                        }

                   }
                });

                $.each(calculation.details, function (d_key, d_value) {

                    var attr_name = $('label[for="attribute_' + d_value['attr_id'] + '"]').text();
                    if ($("#attr_block_" + d_value['attr_id']).css('display') != 'none') {
                        if (d_value['full_paper'] == 1) {
                            var total_pages = 0;
                            if(attr_name.includes("Cover")){

                                total_pages = Math.ceil(calculation.cover_pages_count * calculation.qty / elements_count);
                            }else if(attr_name.includes("Inside")){
                                total_pages = Math.ceil(calculation.inside_pages_count * calculation.qty / elements_count);
                            }else{

                                total_pages = Math.ceil(calculation.cover_pages_count * calculation.qty / elements_count)+Math.ceil(calculation.inside_pages_count * calculation.qty / elements_count);
                            }

                           price = price + (d_value['price_keys'][calculation_size]?.['price'] ?? 0) * total_pages;

                            // price = price + (d_value['price_keys'][calculation_size]?.['price'] ?? 0) * total_pages;
                        }else {
                            price = price + d_value['price'] * calculation.qty;
                        }
                    }
                });
            }
        }

        price = price - price * calculation['qty_discount'] / 100;

        var min_price = parseFloat($("#min_price").val());
        if(min_price > 0 && price < min_price){
            price = min_price;
        }

        delivery.each(function (i, obj) {
            let delivery_price = price + (price / 100 * parseFloat($(obj).val()))
            $(obj).parent().find('b').text('$' + delivery_price.toFixed(2))
        });
        if (selected_delivery) {
            price += price / 100 * parseFloat(selected_delivery)
        }
        var old_price = price;
        // price = price - price * coupon_percent / 100;

        var total_amount = isNaN(price) ? 0 : price.toFixed(2);



        $('.new-price').text('$' + total_amount);
        $("#total_price_amount").val(total_amount);
        $("#total_amount").val(total_amount);
        $("#per_item_amount").val(total_amount);
        // if(coupon_percent > 0){
        //     $('.new-price-discount').text('$' + old_price.toFixed(2));
        // }else{
        //     $('.new-price-discount').text('');
        // }

        if(quantity > 1){
            $(".price_item_block").show();
            var item_price = (price / quantity).toFixed(2);
            $(".price_item_block").html('($' +item_price+' for each)');
        }else{
            $(".price_item_block").hide();
        }
        return false;


        $('.product_attr_select option:selected').each(function (i, obj) {

            return false;
            let attr_data = JSON.parse($(obj).val()),
                price,
                custom = !!$('.custom_size_enabled').length

            // get price from object
            Object.entries(attr_data).forEach(([key, val]) => {
                if (Array.isArray(val)) {
                    price = val.filter(o => o.quantity === parseInt(quantity_id))[0].value
                } else {
                    if (val.quantity === parseInt(quantity_id)) {
                        price = val.price
                        custom = true
                    }
                }
            });

            // calculate size price
            if ($('.custom_size_block:visible').length !== 0 && custom) {
                let custom_width = $('.custom_width').val(),
                    custom_height = $('.custom_height').val(),
                    size_type_value = $('#size_type').val() === 'ft' ? 1 : 12,
                    custom_total_square = custom_width * custom_height

                let square_discounts = $('.square_discounts')
                let discount_percent = 0
                if (square_discounts.length) {
                    const square_discounts_arr = Object.entries(JSON.parse(square_discounts.val()))
                    square_discounts_arr.every(discount => {
                        let dis_total = discount[0],
                            dis_percent = discount[1]
                        if (dis_total <= custom_total_square) {
                            discount_percent = dis_percent
                        } else {
                            return false
                        }
                        return true
                    });
                    price = price * (1 - discount_percent / 100)
                }
                price = (parseFloat(custom_width) / size_type_value) * (parseFloat(custom_height) / size_type_value) * price
            }

            total += parseFloat(price) * parseInt(quantity)
        });

        if ($('.grommets_block').length) {
            let grommet_attrs = JSON.parse($('.grommet_attrs').val()),
                grommet_price = grommet_attrs[quantity_id],
                grommet_qny = $('#grommets').val()

            total += grommet_qny * grommet_price
        }

        delivery.each(function (i, obj) {
            let delivery_price = total + (total / 100 * parseFloat($(obj).val()))
            $(obj).parent().find('b').text('$' + delivery_price.toFixed(2))
        });

        if (selected_delivery) {
            total += total / 100 * parseFloat(selected_delivery)
        }

        if (coupon_percent) {
            total = total - ((total * coupon_percent) / 100);
        }

        total = isNaN(total) ? 0 : total.toFixed(2)
        $('.new-price').text('$' + total)
        $('.total_amount').val(total)
        $('.per_item_amount').val(total)
    }

    function calculateElementsPerPage(paperWidth, paperHeight, elementWidth, elementHeight) {
        var cutting_width = $("#cutting_width").val();
        var cutting_height = $("#cutting_height").val();
        elementWidth = parseFloat(elementWidth) + parseFloat(cutting_width);

        elementHeight = parseFloat(elementHeight) + parseFloat(cutting_height);

        if (paperWidth <= 0 || paperHeight <= 0 || elementWidth <= 0 || elementHeight <= 0) {
            return 0;
        }

        const horizontalElements = Math.floor(paperWidth / elementWidth);
        const verticalElements = Math.floor(paperHeight / elementHeight);

        return horizontalElements * verticalElements;
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
        completeRelatedItems();

        calculateTotal()
    })

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

    $('input[name=delivery]:checked').each(function() {
        $(this).trigger('change');
    });

    $(document).on('click', '.ec-product-inner', function () {
        location.href = $(this).find('.image').attr('href')
    })

    $(document).on('click', '.add_cart', function (e) {
        $("#ec-overlay").show();

        e.preventDefault();
        $('#uploadModal').trigger('show.bs.modal');
        setTimeout(()=>{
            $("#calculation_form").submit();
            sessionStorage.removeItem('uploaded_folder_name');
        }, 1000)
    })

    $(document).on('click', '.update_cart', function (e) {
        $("#ec-overlay").show();
        e.preventDefault();
        $('#uploadModal').trigger('show.bs.modal');
        setTimeout(()=>{
            $("#calculation_form").submit();
            sessionStorage.removeItem('uploaded_folder_name');
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
        //location.href = '/order/' + btoa(encodeQueryData(url))
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

    // Initial input fields count
    let setCount = $('#set_count').val();
    const maxSets = 200;
    let setIndexKey = setCount;

    function toggleRemoveButtons() {
        if (setCount > 1) {
            $('.remove_set').removeClass('hidden');
        } else {
            $('.remove_set').addClass('hidden');
        }
    }

    $('#increase').on('click', function () {
        if (setCount < maxSets) {
            setCount++;
            setIndexKey++;

            $('#set_count').val(setCount);
            let clonedSet = $('.set_inputs .set_input').first().clone();
            clonedSet.find('label').text('SET ' + setCount + ' NAME');
            clonedSet.find('input').val('SET ' + setCount);
            let timestamp = Date.now();

            clonedSet.find('input').attr('name', `set_title[${timestamp}_${setIndexKey}]`);
            clonedSet.find('.set_input_item').removeAttr('data-set-id');
            clonedSet.attr('data-set-index-key', `${timestamp}_${setIndexKey}`);

            $('.set_inputs').append(clonedSet);
            toggleRemoveButtons();
            updateTotalPrice();
        }
    });

    $('#decrease').on('click', function () {
        if (setCount > 1) {
            $('.set_inputs .set_input').last().remove();
            setCount--;
            $('#set_count').val(setCount);
            updateTotalPrice();
        }
    });

    $(document).on('click', '.remove_set', function () {
        if (setCount > 1) {
            let set_input = $(this).closest('.set_input');
            let set_index = set_input.data('set-index-key')

            $.ajax({
                url: '/tmp-delete',
                type: 'DELETE',
                data: {
                    set_index: set_index,
                    product_id: $('#product_id').val(),
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Update the session storage if necessary
                    sessionStorage.setItem('uploaded_folder_name', JSON.stringify(response.session_data));
                },
                error: function() {
                    console.error('Failed to delete set from server session.');
                }
            });

            set_input.remove();
            setCount--;
            $('#set_count').val(setCount);
            renumberSets();
            updateTotalPrice();
        }
    });

    function renumberSets() {
        $('.set_inputs .set_input').each(function (index) {
            let newIndex = index + 1;
            $(this).find('label').text('SET ' + newIndex + ' NAME');
        });
    }

    // function checkInputs() {
    //     const jobName = $('#project_title').val().trim();
    //     const typeSelected = $('input[name="type"]:checked').val();
    //
    //     if (jobName !== '' && typeSelected) {
    //         $('.add_cart').prop('disabled', false);
    //     } else {
    //         $('.add_cart').prop('disabled', true);
    //     }
    // }

    function updateTotalPrice() {
        let designPrice = parseFloat($('#order_type_3').data('price'));
        let setCount = parseInt($('#set_count').val());
        let perItemAmount = parseFloat($('#per_item_amount').val());

        let totalAmount = setCount * perItemAmount;

        if ($('#order_type_3').is(':checked')) {
            totalAmount += designPrice;
        }

        // Update the displayed total price
        $('.new-price').text('$' + totalAmount.toFixed(2));
        $("#total_price_amount").val(totalAmount);
        $("#total_amount").val(totalAmount);
    }

    $('#project_title').on('input', function() {
        checkInputs();
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

    $('#order_type_1').on('click', function() {
        $('#uploadModal').modal('show');
        checkInputs();
    });

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

    function encodeQueryData(data) {
        const ret = [];
        for (let d in data)
            ret.push(encodeURIComponent(d) + '=' + encodeURIComponent(data[d]));
        return ret.join('&');
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

        // jQuery.each($('.product_attr_select option:not([data-quantity=' + selected_qnt + '])'), (index, item) => {
        //
        //     $(item).attr('hidden', 'hidden')
        // });
        // jQuery.each($('.product_attr_select option[data-quantity=' + selected_qnt + ']'), (index, item) => {
        //
        //     $(item).removeAttr('hidden')
        // });
        //
        // jQuery.each($('.product_attr_select'), (index, item) => {
        //     let text = $(item).find(":selected").text()
        //     $(item).find('option:not([hidden=hidden])').filter(function () {
        //
        //         return $(this).text() == text;
        //     }).prop('selected', true);
        // });

        calculateTotal()
    }

    setQuantityItems()

    $(document).on('change', '#quantity', setQuantityItems)

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

    var isEditForm = $(".custom_width").attr('data-edit');

    $(document).on('change', '#sizes', function () {

        let selected_type = $('#sizes').find(":selected").text().trim();

        if (selected_type === 'Custom size') {
            $('.custom_size').hide()
            $('.custom_size_block').css('display', 'flex');
            changeValuesForCustom();
        } else {
            $('.custom_size').show()
            $('.custom_size_block').hide()
        }

       // calculateTotal()
    })

    $(document).on('click', '.custom_size', function () {
        //changeValuesForCustom();
        $("#sizes option").filter(function () {
            return $(this).text().trim() === 'Custom size';
        }).prop('selected', true);

        $('#sizes').trigger('change').selectric('refresh')
        $('.product_sizes_block').addClass('flex-wrap')

        calculateTotal()
    })

    if ($('#sizes').val() == 0) {
        $('#sizes').trigger('change');
    }

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
function changeValuesForCustom(){

    var customWidthFT = $(".custom_width").attr('data-value');
    var customHeightFT = $(".custom_height").attr('data-value');
    var t = $("#size_type").val();
    if(isEditForm && t == 'in'){
        customWidthFT = customWidthFT / 12;
        customHeightFT = customHeightFT / 12;
    }

    var selected_width = $("#width_in_ft").val();
    var selected_height = $("#height_in_ft").val();
    if(selected_width  !=''){
        customWidthFT = selected_width;
    }
    if(selected_height  !=''){
        customHeightFT = selected_height;
    }
   if(t == 'in'){
       let floatValue = parseFloat(customWidthFT * 12);

       // Use toFixed to round to 2 decimal places and convert it back to a string
       let formattedValue = floatValue.toFixed(2);

       // Use parseFloat again to remove trailing zeros
       formattedValue = parseFloat(formattedValue);

       $(".custom_width").val(formattedValue);
       $("#width_in_ft").val(customWidthFT);

       let floatValueH = parseFloat(customHeightFT * 12);

       // Use toFixed to round to 2 decimal places and convert it back to a string
       let formattedValueH = floatValueH.toFixed(2);

       // Use parseFloat again to remove trailing zeros
       let formattedValueh = parseFloat(formattedValueH);
       $(".custom_height").val(formattedValueh);
       $("#height_in_ft").val(customHeightFT);
   }else{
       let floatValue = parseFloat(customWidthFT);

       // Use toFixed to round to 2 decimal places and convert it back to a string
       let formattedValue = floatValue.toFixed(2);

       // Use parseFloat again to remove trailing zeros
       formattedValue = parseFloat(formattedValue);
       $(".custom_width").val(formattedValue);
       $("#width_in_ft").val(customWidthFT);
       let floatValueH = parseFloat(customHeightFT);

       // Use toFixed to round to 2 decimal places and convert it back to a string
       let formattedValueH = floatValueH.toFixed(2);

       // Use parseFloat again to remove trailing zeros
       let formattedValueh = parseFloat(formattedValueH);


       $(".custom_height").val(formattedValueh);
       $("#height_in_ft").val(customHeightFT);
   }
}

    $(document).on('keyup', '.custom_grommet', function () {
        calculateTotal();
    })
    /*$(document).on('input', '.custom_grommet', function () {
        let grommet_qnt = $(this).val()

        $('#grommets').find(":selected").attr('value', grommet_qnt)
        calculateTotal()
    })*/

    $(document).on('mouseover', '.user_dropdown', function () {
        $('.user_dropdown_block').addClass('show')
    })

    $(document).on('mouseout', '.user_dropdown', function () {
        $('.user_dropdown_block').removeClass('show')
    })

    $(document).on('blur', '.custom_width, .custom_height', function () {
        let val = $(this).val(),
            size_type = $('#size_type').val(),
            size_type_value = size_type === 'ft' ? 1 : 12,
            max_size = size_type_value * parseFloat($(this).attr('data-size'))

        if (max_size && parseFloat(val) > max_size) {
            $(this).val(max_size.toString().match(/^-?\d+(?:\.\d{0,2})?/)[0]); // with 2 point
            sizePopup()
        } else if (val.indexOf(".") !== -1 && countDecimals(parseFloat(val)) > 2) {
            $(this).val(parseFloat(val).toFixed(2))
        }
        var   customWidth = $(".custom_width").val();
        var customHeight = $(".custom_height").val();
        var customWidthFT = customWidth;
        var customHeightFT = customHeight;
        if($(this).attr('class') == 'custom_width' && customWidth !='' ){
            if(size_type == 'in'){
                customWidthFT = parseFloat((customWidth / 12));
            }else{
                customWidthFT = customWidth;
            }
            $("#width_in_ft").val(customWidthFT.toString().match(/^-?\d+(?:\.\d{0,2})?/)[0]);

        }
        if($(this).attr('class') == 'custom_height' && customHeight !='' ){
            if(size_type == 'in'){
                customHeightFT = parseFloat((customHeight / 12));
            }else{
                customHeightFT = customHeight;
            }
            $("#height_in_ft").val(customHeightFT.toString().match(/^-?\d+(?:\.\d{0,2})?/)[0]);
        }


        calculateTotal()
    })

    function countDecimals(value) {
        if ((value % 1) != 0)
            return value.toString().split(".")[1].length;
        return 0;
    }

    function sizePopup() {
        let w = $('.custom_width').attr('data-size'),
            h = $('.custom_height').attr('data-size'),
            size_type = $('#size_type').val(),
            size_type_value = size_type === 'ft' ? 1 : 12,
            quote = size_type === 'ft' ? "'" : '"'
        let size = (size_type_value * w).toString().match(/^-?\d+(?:\.\d{0,2})?/)[0]
        $('.size_popup_sizes').html(size + quote + ' x ' + size_type_value * h + quote)
        $('.size_popup_modal').addClass('active')
    }

    $(document).on('click', '.size_popup_footer button, .size_popup_header i', function () {
        $('.size_popup_modal').removeClass('active')
    })

    $(document).ready(function(){
        // $(window).keydown(function(event){
        //     if(event.keyCode == 13) {
        //         event.preventDefault();
        //         return false;
        //     }
        // });
        if($("#size_type").length > 0){
            // if($("#size_type").val() == 'ft'){
                changeFTtext();
            // }
        }
    })

    function changeFTtext(){
        var size_type = $("#size_type").val();


        if($(".only_custom_exists").length > 0){

        }else{
            $("#sizes option").each(function(val){
                if($(this).val() > 0){
                    var w = $(this).data('width');
                    var h = $(this).data('height');
                    if(size_type == 'ft') {
                        // var new_text = w / 12 + '\' x ' + h / 12+'\'';

                        var widthInFeet = (w / 12).toFixed(1);
                        var heightInFeet = (h / 12).toFixed(1);

                        var widthString = widthInFeet % 1 === 0 ? Math.floor(widthInFeet) + "'" : widthInFeet + "'";
                        var heightString = heightInFeet % 1 === 0 ? Math.floor(heightInFeet) + "'" : heightInFeet + "'";
                        var new_text = widthString + ' x ' + heightString;
                    }else{
                        w = String(w);
                        h = String(h);
                        if (!w.includes('"')) {
                            w = w + '"';
                        }
                        if (!h.includes('"')) {
                            h = h + '"';
                        }
                        var new_text = w + ' x ' + h;
                        // var new_text = w  + '" x ' + h+'"';
                    }
                    $(this).text(new_text)
                }

            })
            $("#sizes").selectric('refresh');
        }

            if($(".custom_width").length > 0){
                var c_w = $(".custom_width").data('value');
                if($("#width_in_ft").val() !=''){
                    c_w = $("#width_in_ft").val();
                }
                var c_h = $(".custom_height").data('value');
                if($("#height_in_ft").val() !=''){
                    c_h = $("#height_in_ft").val();
                }

                if(size_type == 'in') {
                    $(".custom_width").val((c_w * 12).toFixed(2));
                    $(".custom_height").val((c_h * 12).toFixed(2));
                }else{
                    $(".custom_width").val(parseFloat(c_w).toFixed(2));
                    $(".custom_height").val(parseFloat(c_h).toFixed(2));
                }

            }

    }

    $(document).on('change', '#size_type', function () {
        changeFTtext();
    })

    $('.subscribe_btn').click(function() {
        const email = $('.ec-email-subscribe').val();

        $('.subscribe-error').text('');
        $('.subscribe-success').text('');

        if (!email || !isValidEmail(email)) {
            $('.subscribe-error').text('Please enter a valid email address.');
            return;
        }

        $.ajax({
            type: 'POST',
            url: '/subscribe',
            data: { email: email },
            success: function(response) {
                $('.subscribe-success').text(response.message);
                $('.ec-email-subscribe').val('');
            },
            error: function(xhr, status, error) {
                $('.subscribe-error').text(xhr.responseJSON.errors.email);
            }
        });
    });

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

    $(".single_product_contact").on('click',function(){
        $(".product_deliveries").hide();
        $(".ec-single-price-stoke").hide();
        $(".qty_block").hide();
        $(".ec-single-qty").hide();
        $(".custom_group").removeClass('qty_block_custom');
        $(".ec-single-qty-custom").show();
    })

    $("#cancel_btn").on('click',function(e){
        e.preventDefault();
        $(".product_deliveries").show();
        $(".ec-single-price-stoke").show();
        $(".qty_block").show();
        $(".ec-single-qty").show();
        $(".custom_group").addClass('qty_block_custom');
        $(".ec-single-qty-custom").hide();
    });

    // Initialize intlTelInput for each input
    var phoneInputElement = $("input[name='phone']");

    if (phoneInputElement.length > 0) {
        var iti = window.intlTelInput(phoneInputElement[0], {
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@21.0.8/build/js/utils.js?1712488050476",
            i18n: {
                ca: "Canada",
                us: "United States",
            },
            onlyCountries: ["ca", "us"],
            initialCountry: "us",
            countrySearch: false,
            formatOnDisplay: true,
            autoPlaceholder: "polite",
            showSelectedDialCode: true,
        });
    }
    var inputCustomElement = $("input[name='custom_phone']");

    if (inputCustomElement.length > 0) {
        var iti_custom = window.intlTelInput(inputCustomElement[0], {
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@21.0.8/build/js/utils.js?1712488050476",
            i18n: {
                ca: "Canada",
                us: "United States",
            },
            onlyCountries: ["ca", "us"],
            initialCountry: "us",
            countrySearch: false,
            formatOnDisplay: true,
            autoPlaceholder: "polite",
            showSelectedDialCode: true,
        });
    }


    $("#request_continue").on('click',function(e){
        e.preventDefault();
        let formData = $('#calculation_form').serialize();

        let errors = 0;
        const fieldArray = [
            $('#custom_first_name'),
            $('#custom_last_name'),
            $('#custom_email'),
            $('#custom_message'),
            $('#custom_phone'),
            $('#custom_qty'),
        ]

        if($('#custom_address_block').is(':visible')){
            fieldArray.push($('#custom_address_block input[name=custom_zip]'));
            fieldArray.push($('#custom_address_block input[name=custom_city]'));
            fieldArray.push($('#custom_address_block input[name=custom_state]'));
            fieldArray.push($('#custom_address_block input[name=custom_address]'));
        }

        fieldArray.forEach(elem => {
            errors += checkError(elem);
        })

        if (!errors) {
            Swal.fire({
                title: "Send Request?",
                text: "Are you sure you want to send the request with the provided data?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3474d4",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: '/create-custom-order',
                        data: formData,
                        dataType: 'json',
                        encode: true
                    })
                    .done(function (response) {
                        $('#askQuestionModal').modal('hide');

                        // Reset the form
                        $('#askQuestionModal').on('hidden.bs.modal', function () {
                            $(this).find('form')[0].reset();
                        });
                        Swal.fire({
                            position: 'center',
                            title: "Request Submitted Successfully!",
                            text: "Your request has been received and is being processed by our team. You will receive an email confirmation shortly.",
                            icon: "success",
                            showConfirmButton: true,
                            confirmButtonColor: "#3474d4",
                        })
                        .then((result) => {
                           $("#cancel_btn").trigger('click');
                        });
                    })
                    .fail(function (xhr, textStatus, errorThrown) {
                        console.error(xhr.responseText);
                    });
                }
            });
        }
    })

    function checkError(field) {
        let errors = 0;
        if (field.length >= 1) {
            field.each(function () {
                const value = $(this).val().trim();
                const fieldName = $(this).attr('name');
                // Clear previous error state
                $(this).removeClass('is-invalid');
                // Check for specific field validations
                switch (fieldName) {
                    case 'custom_email':
                        if (!isValidEmail(value)) {
                            $(this).addClass('is-invalid error');
                            errors++;
                        }
                        break;
                    case 'custom_phone':
                        $('.error-msg').text("");
                        if (!iti_custom.isValidNumberPrecise()) {
                            const errorCode = iti_custom.getValidationError();
                            const errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];
                            const msg = errorMap[errorCode] || "Invalid number";
                            $('.error-msg').text(msg);
                            $('.error-msg').show();

                            $(this).addClass('error is-invalid');
                            errors++;
                        }
                        break;
                    default:
                        if (!value) {
                            $(this).addClass('is-invalid error');
                            errors++;
                        }
                }
            });
        }

        return errors === field.length;
    }

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

    $(document).on('click', '.checkout_page .tooltipIcon', function() {
        let tooltip_wrapper = $(this).closest('.form-group').find('.tooltip-wrapper');
        tooltip_wrapper.toggleClass('visible');
    });
})
