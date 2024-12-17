@php
$items =  json_decode($items, true)
@endphp

<div class="shipping_types" style="display: none">
    @if(empty($items))
        <div class="shipping_types_block size_block" data-index="1">
            <div class="form-group">
                <label for="until_pcs">Until ֊ pcs</label>
                <input
                        id="until_pcs"
                        type="number"
                        class="form-control"
                        placeholder="Until pcs"
                        name="until_pcs"
                        value=""
                >
                @error('until_pcs')
                <div class="invalid-feedback"
                     style="display: block">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="width">Width (IN)</label>
                <input
                        id="width"
                        type="number"
                        class="form-control"
                        placeholder="Enter Width"
                        name="width"
                        value=""
                >
                @error('width')
                <div class="invalid-feedback"
                     style="display: block">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="height">Height (IN)</label>
                <input
                        id="height"
                        type="number"
                        class="form-control"
                        placeholder="Enter Height"
                        name="height"
                        value=""
                >
                @error('height')
                <div class="invalid-feedback"
                     style="display: block">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="length">Length (IN)</label>
                <input
                        id="length"
                        type="number"
                        class="form-control"
                        placeholder="Enter length"
                        name="length"
                        value=""
                >
                @error('length')
                <div class="invalid-feedback"
                     style="display: block">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="weight">Weight (LB)</label>
                <input
                        id="weight"
                        type="number"
                        class="form-control"
                        placeholder="Enter Weight"
                        name="weight"
                        value=""
                >
                @error('weight')
                <div class="invalid-feedback"
                     style="display: block">{{ $message }}</div>
                @enderror
            </div>
            <button type="button" style="margin-top: 27px" class="btn btn-danger delete_shipping_type">Delete</button>
        </div>
    @else
        @foreach($items as $i)
        <div class="shipping_types_block size_block" data-index="{{$i['id']}}">
        <div class="form-group">
            <label for="until_pcs">Until ֊ pcs</label>
            <input
                    id="until_pcs"
                    type="number"
                    class="form-control"
                    placeholder="Until pcs"
                    name="until_pcs"
                    value="{{ (isset($items) && isset($i['until_pcs']) ) ? $i['until_pcs'] : 0 }}"
            >

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @error('shipping_info.0.until_pcs')
            <div class="invalid-feedback"
                 style="display: block">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="width">Width (IN)</label>
            <input
                    id="width"
                    type="number"
                    class="form-control"
                    placeholder="Enter Width"
                    name="width"
                    value="{{ (isset($items) && isset($i['width']) ) ? $i['width'] : 0 }}"
            >
            @error('width')
            <div class="invalid-feedback"
                 style="display: block">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="height">Height (IN)</label>
            <input
                    id="height"
                    type="number"
                    class="form-control"
                    placeholder="Enter Height"
                    name="height"
                    value="{{ (isset($items) && isset($i['height']) ) ? $i['height'] : 0 }}"
            >
            @error('height')
            <div class="invalid-feedback"
                 style="display: block">{{ $message }}</div>
            @enderror
        </div>
            <div class="form-group">
            <label for="length">Length (IN)</label>
            <input
                    id="length"
                    type="number"
                    class="form-control"
                    placeholder="Enter length"
                    name="length"
                    value="{{ (isset($items) && isset($i['length']) ) ? $i['length'] : 0 }}"
            >
            @error('length')
            <div class="invalid-feedback"
                 style="display: block">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="weight">Weight (LB)</label>
            <input
                    id="weight"
                    type="number"
                    class="form-control"
                    placeholder="Enter Weight"
                    name="weight"
                    value="{{ (isset($items) && isset($i['weight']) ) ? $i['weight'] : 0 }}"
            >
            @error('weight')
            <div class="invalid-feedback"
                 style="display: block">{{ $message }}</div>
            @enderror
        </div>
            <button type="button" style="margin-top: 27px" class="btn btn-danger delete_shipping_type">Delete</button>
        </div>
        @endforeach
    @endif
</div>
<div id="validation-errors"> </div>
<div class="shipping_types_buttons" style="display: none">
    <button type="button" class="btn btn-warning add_shipping_types_block">Add New</button>
    <div class="form-group mt-2">
        <a href="javascript:void(0)" id="save_shipping_percent" class="btn btn-success" style="color:white;">Save</a>
    </div>
</div>

@push('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function () {

        function deleteShippingBlock(index) {

            let shippingBlocks = document.querySelectorAll('.shipping_types_block');
                let blockToDelete = document.querySelector(`.shipping_types_block[data-index="${index}"]`);
                blockToDelete.parentNode.removeChild(blockToDelete);
                deleteShippingPercent(index);
        }

        function deleteShippingPercent(index) {

            $.ajax({
                type: "POST",
                url: "{{route('dashboard.products.delete_shipping_sizes')}}",
                data: {
                    "id": index,
                    "product_id": {{$item->id}}
                },
                dataType: 'json',
                success: (response) => {
                    console.log(response)
                    $('#validation-errors').html('');
                    $.each(response.errors, function(key,value) {
                        $('#validation-errors').append('<div class="text-danger">'+value+'</div');
                    });

                },
            });
        }

        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('delete_shipping_type')) {
                let shippingBlock = event.target.closest('.shipping_types_block');
                if (shippingBlock) {
                    let dataIndex = shippingBlock.getAttribute('data-index');
                    deleteShippingBlock(dataIndex);
                }
            }
        });

        document.querySelector('.add_shipping_types_block').addEventListener('click', function () {
            let shippingBlocks = document.querySelectorAll('.shipping_types_block');
            let lastBlock = shippingBlocks[shippingBlocks.length - 1];

            let newBlock = lastBlock.cloneNode(true);
            let lastIndex = parseInt(lastBlock.getAttribute('data-index'));
            let newIndex = lastIndex + 1;
            newBlock.setAttribute('data-index', newIndex);

            let inputs = newBlock.querySelectorAll('input[type="number"]');
            inputs.forEach(function (input) {
                input.value = '';
            });

            let shippingTypes = document.querySelector('.shipping_types');
            shippingTypes.appendChild(newBlock);

            let newInputs = newBlock.querySelectorAll('input[type="number"]');
            newInputs.forEach(function (input) {
                input.addEventListener('change', function () {
                    handleSaveShippingPercent();
                });
            });
        });

        document.querySelector('#save_shipping_percent').addEventListener('click', function () {
            handleSaveShippingPercent();
        });

        function handleSaveShippingPercent() {
            $("div,input").removeClass('error_message');
            let shippingData = [];

            let shippingBlocks = document.querySelectorAll('.shipping_types_block');

            for (let i = 0; i < shippingBlocks.length; i++) {
                let block = shippingBlocks[i];
                let until_pcs = block.querySelector('input[name="until_pcs"]').value;
                let width = block.querySelector('input[name="width"]').value;
                let height = block.querySelector('input[name="height"]').value;
                let length = block.querySelector('input[name="length"]').value;
                let weight = block.querySelector('input[name="weight"]').value;

                if (width == 0) {
                    $(block.querySelector('input[name="width"]')).addClass('error_message');
                }
                if (weight == 0) {
                    $(block.querySelector('input[name="weight"]')).addClass('error_message');
                }
                if (height == 0) {
                    $(block.querySelector('input[name="height"]')).addClass('error_message');
                }
                if (length == 0) {
                    $(block.querySelector('input[name="length"]')).addClass('error_message');
                }
                if (until_pcs == 0) {
                    $(block.querySelector('input[name="until_pcs"]')).addClass('error_message');
                }

                let shippingBlockData = {
                    id: i + 1,
                    until_pcs: until_pcs,
                    width: width,
                    height: height,
                    length: length,
                    weight: weight,
                };
                shippingData.push(shippingBlockData);
            };

            let hasErrors = document.querySelectorAll('.error_message').length > 0;
            if (hasErrors) {
                return false;
            }

            $.ajax({
                type: "POST",
                url: "{{route('dashboard.products.edit_shipping_sizes', $item->id)}}",
                data: { "shipping_info": shippingData },
                dataType: 'json',
                success: (response) => {
                    console.log(response)
                    $('#validation-errors').html('');
                    $.each(response.errors, function(key,value) {
                        $('#validation-errors').append('<div class="text-danger">'+value+'</div');
                    });

                },
            });
        }
    });

</script>
@endpush