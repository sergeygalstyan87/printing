
<div class="product_attributes">
    @if($product->square_discounts)
        <input type="hidden" class="square_discounts"
               value="{{ json_encode($product->square_discounts) }}">
    @endif

    @if($product->only_custom && $product->custom_sizes == 1)
        <div class="form-group custom_size_label">
            <label for="sizes">Size</label>
            <div class="product_sizes_block">
                <div class="custom_size_block custom_size_enabled only_custom_exists"
                     style="display: flex;">
                    <div style="display:flex;">
                        <span>W</span>
                        <input type="number" class="custom_width"
                               data-size="{{ $product->max_width }}"
                               data-value="{{ $product->default_width}}"
                               style="min-width: 51px"
                               value=""
                               name="custom_width"
                               step="0.01"

                        >
                    </div>
                    <div style="display:flex;margin-left: 4%;">
                        <span>H</span>
                        <input type="number" class="custom_height"
                               data-size="{{ $product->max_height }}"
                               data-value="{{ $product->default_height  }}"
                               style="min-width: 51px"
                               value=""
                               name="custom_height"
                               step="0.01"
                        >
                    </div>
                    <div class="full-width"
                         style="display:flex;margin-top:15px;margin-left: 4%;">

                        <select name="size_type" id="size_type"
                                style="margin-bottom: 5px;">
                            @if($product->size_type == 'both')
                                <option value="ft" selected>FT</option>
                                <option value="in">IN</option>
                            @elseif($product->size_type == null)
                                <option value="in"
                                        selected>IN
                                </option>
                            @else
                                <option value="{{ $product->size_type }}"
                                        selected>{{ strtoupper($product->size_type) }}
                                </option>
                            @endif

                        </select>
                    </div>

                </div>
            </div>

        </div>
    @endif




    @php
        $attributes = [];
        $detail_info = [];
        if(!empty($product->detail_info)){
          $detail_info = json_decode($product->detail_info, true);
        }

    @endphp
    <div id="type_information" style="display:none;">
        @php
            echo json_encode($product_information);
        @endphp
    </div>
    <div id="size_information" style="display:none;">
        @php
            echo json_encode($sizes);
        @endphp
    </div>
    <?php
    $hidden_types = [];
    if (!empty($product->hidden_types)) {
        $hidden_types = json_decode($product->hidden_types, true);
    }
    ?>
        <input type="hidden" value="{{$product->offset_qty}}" id="offset_qty" name="offset_qty"/>

    @foreach($con_a as $aaa_id => $attribute)
        @php
            $attr_id_open_list = $product->attr_id_open_list ?? [];
            $is_show_attr_label = in_array(\App\Enums\AttributeProperties::show_attr_label, $attribute['attribute_properties']);
            $is_color = in_array(\App\Enums\AttributeProperties::color, $attribute['attribute_properties']);
        @endphp
        @if($aaa_id !=2)
            <div class="form-group absolute_label {{ in_array($aaa_id,$hidden_attrs) ? 'hidden_attr':'visible_attr'}}
                {{in_array($aaa_id, $attr_id_open_list) && $is_show_attr_label ? 'is_show_attr_label' : ''}}"
                 id="attr_block_{{$aaa_id}}"
                 style="display:{{ in_array($aaa_id,$hidden_attrs) ? 'none':'flex'}}">
                @if(in_array($aaa_id, $attr_id_open_list))
                    @if($is_show_attr_label)
                        <label class="opened_list_label">{{ $attribute['name'] }}
                            @if($attribute['help_text'])
                                <i class="fa-solid fa-circle-question helpIcon " data-attr-id="{{ $aaa_id }}"></i>
                            @endif
                        </label>
                    @endif
                    <div class="opened_list">
                        @foreach($product_information['types'][$aaa_id] as $type_id => $type_data)
                            <div class="opened_list_item" data-attr="{{ $aaa_id }}" data-id="{{ $type_id }}" style="width: calc(100% / {{count($product_information['types'][$aaa_id])}} - 12px)">

                                <label for="option_{{ $type_id }}">
                                    @if(isset($type_data['img']))
                                        <img src="{{asset('/storage/content/types/'.$type_data['img'])}}" class="type_icon" alt="Type icon">
                                    @endif
                                    <span class="option-label">{{ $type_data['name'] }}</span>
                                </label>
                            </div>
                        @endforeach
                        <select name="attribute_{{ $aaa_id }}"
                                id="attribute_{{ $aaa_id }}"
                                class="form-control product_attr_select select_type"
                                data-attr="{{ $aaa_id }}"
                                data-paper="{{$attribute['is_paper_type']}}"
                                style="display: none">
                            @foreach($product_information['types'][$aaa_id] as $type_id => $type_data)
                                <option data-attr="{{$aaa_id}}"
                                        value="{{ $type_id }}"
                                        data-id="{{ $type_id }}"
                                        {{($project && in_array($type_id, $project->attrs['selected_values'])) ? 'selected' : ''}}>{{ $type_data['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                @else
                    <label>{{ $attribute['name'] }}
                        @if($attribute['help_text'])
                            <i class="fa-solid fa-circle-question helpIcon " data-attr-id="{{ $aaa_id }}"></i>
                        @endif
                    </label>

                    <select name="attribute_{{ $aaa_id }}"
                            id="attribute_{{ $aaa_id }}"
                            class="form-control product_attr_select select_type"
                            data-attr="{{ $aaa_id }}"
                            data-paper="{{$attribute['is_paper_type']}}">
                        @foreach($product_information['types'][$aaa_id] as $type_id => $type_data)
                            <option data-attr="{{$aaa_id}}"
                                    value="{{ $type_id }}"
                                    data-id="{{ $type_id }}"
                                    data-img="{{ isset($type_data['img']) ? asset('/storage/content/types/'.$type_data['img']) : '' }}"
                                    {{($project && in_array($type_id, $project->attrs['selected_values'])) ? 'selected' : ''}}>

                                @if(isset($type_data['img']))
                                    <img src="{{ asset('/storage/content/types/'.$type_data['img']) }}" alt="type image">
                                @endif
                                {{ $type_data['name'] }}</option>
                        @endforeach
                    </select>
                @endif
            </div>
            @if($aaa_id == 16)
                <div class="form-group custom_grommet_block absolute_label"
                     style="display: none">
                    <label>Custom Grommets
                        @if($attribute['help_text'])
                            <i class="fa-solid fa-circle-question helpIcon " data-attr-id="{{ $aaa_id }}"></i>
                        @endif
                    </label>
                    <div>
                        <input type="number" class="custom_grommet"
                               id="custom_grommet" name="custom_grommet"
                               value="0">
                    </div>
                </div>
            @endif
        @else
            @if($product->only_custom !=1)
                <div class="form-group absolute_label">
                    <label>Size
                        @if($attribute['help_text'])
                            <i class="fa-solid fa-circle-question helpIcon " data-attr-id="{{ $aaa_id }}"></i>
                        @endif
                    </label>
                    <div class="product_sizes_block @if($product->custom_sizes) flex-column @endif">
                        <div class="d-flex align-items-center justify-content-between w-100 gap-3">
                            <select id="sizes"
                                    class="form-control product_attr_select"
                                    data-attr="sizes" name="sizes">
                                @foreach($product_information['types'][2] as $type_id => $type_data)
                                        <?php
                                            $width = $height = 0;
                                            $arr = explode('x', $type_data['name']);
                                            $width = isset($arr[0]) ? trim($arr[0]) : 0;
                                            $height = isset($arr[1]) ? trim($arr[1]) : 0;
                                        ?>
                                    <option value="{{ $type_id }}"
                                            data-height="{{ $height }}"
                                            data-width="{{ $width }}"
                                            {{($project && in_array($type_id, $project->attrs['selected_values'])) ? 'selected' : ''}}
                                    >{{ $type_data['name'] }}</option>
                                @endforeach
                                @if($product->custom_sizes)
                                    <option value="0" {{($project && isset($project->attrs['types']['Custom Size'])) ? 'selected' : ''}}>
                                        Custom size
                                    </option>
                                @endif
                            </select>


                                <?php $is_disabled = ($product->size_type == null || $product->size_type != 'both') ? 'disabled' : '';
                                    $is_hidden = ($product->size_type == null || $product->size_type != 'both') ? 'hide_size_type' : '';
                                ?>
                            @php
                                $width_custom = null;
                                $height_custom = null;
                                $type_custom = null;
                                if($project && isset($project->attrs['types']['Custom Size'])){
                                   if (preg_match('/(\d+)(?:\'|"|)(?:x)(\d+)(?:\'|"|)\s*(\w+)/', $project->attrs['types']['Custom Size'], $matches)) {
                                        $width_custom = $matches[1];
                                        $height_custom = $matches[2];
                                        $type_custom = $matches[3];
                                    }
                                }
                            @endphp
                            <select name="size_type" id="size_type" class="<?= $is_hidden; ?>"
                                    style="margin-bottom: 5px;" <?= $is_disabled; ?>>
                                @if($product->size_type == 'both')
                                    <option value="ft" {{$type_custom ? ($type_custom == 'FT' ? 'selected' : '') : (!isset($project->attrs['types']['Size']) ? 'selected' : '')}}>FT</option>
                                    <option value="in" {{$type_custom ? ( $type_custom == 'IN' ? 'selected' : '') : (isset($project->attrs['types']['Size']) ? 'selected' : '') }}>IN</option>
                                @elseif($product->size_type == null)
                                    <option value="in"
                                            selected>IN
                                    </option>
                                @else
                                    <option value="{{ $product->size_type }}"
                                            selected>{{ strtoupper($product->size_type) }}
                                    </option>
                                @endif

                            </select>
                        </div>
                        @if($product->custom_sizes)
                            <a class="custom_size">Custom size</a>
                            <div class="custom_size_block mb-2">
                                <div>
                                    <span>W</span>
                                    <input type="number"
                                           class="custom_width"
                                           data-size="{{ $product->max_width }}"
                                           data-value="{{ $width_custom ?? $product->default_width }}"
                                           data-edit="{{$project ? 1 : 0}}"
                                           value="{{$width_custom ?? ''}}"
                                           style="width:100%"
                                           name="custom_width"
                                           step="0.01"

                                    >
                                </div>
                                <div>
                                    <span>H</span>
                                    <input type="number"
                                           class="custom_height"
                                           data-size="{{ $product->max_height }}"
                                           data-value="{{$height_custom ?? $product->default_height  }}"
                                           value="{{$height_custom ?? ''}}"
                                           style="width:100%"
                                           name="custom_height"
                                           step="0.01"
                                    >
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        @endif
    @endforeach

    @if(count($product->inputs))
        @foreach($product->inputs as $i => $input)
            <div class="form-group custom_input_group absolute_label">
                <label for="input_{{ $input->id }}">{{ $input->title }}</label>
                <input type="text" name="input_{{ $input->id }}"
                       class="custom_input"
                       data-name="input_{{ $input->id }}" value="">
            </div>
        @endforeach
    @endif
    <input type="hidden" value="" id="width_in_ft"/>
    <input type="hidden" value="" id="height_in_ft"/>


    <?php if (count($product_information['quantity']) == 1): ?>
    <input type="hidden" name="quantity" id="quantity"
{{--           value="<?= $product_information['quantity'][0]['value']?>"/>--}}
           value="{{$project ? $project->qty : $product_information['quantity'][0]['value']}}"/>
    <?php else: ?>
    <div class="form-group qty_block absolute_label">
        <label
                for="qty_count">Quantity</label>
        <select name="quantity" id="quantity"
                class="form-control product_attr_select"
                data-attr="2">

            @foreach($product_information['quantity'] as $qty_id => $qty_data)
                <option data-info="{{json_encode($qty_data)}}"
                        value="{{ $qty_data['id'] }}" {{ ($project && $project->qty == $qty_data['value']) ? 'selected' : ''}}>{{ $qty_data['value'] }}</option>
            @endforeach
        </select>
    </div>


    <?php endif; ?>
    <div class="form-group custom_group qty_block_custom ">
        <label class="form-label"
               for="custom_qty">Quantity <span class="text-danger">*</span></label>
        <input type="number" name="custom_qty"
               class="custom_input_qty custom_input" id="custom_qty"
               value="">
    </div>
    @php
        $user = auth()->user();
        if ($user) {
            $user_address = $user->addresses()->where('default', 1)->first() ?? new Address();
        }
    @endphp
    <div class="form-group custom_group qty_block_custom">
        <label class="form-label" for="custom_name">First Name <span
                    class="text-danger">*</span></label>
        <input type="text" class="custom_input" id="custom_first_name"
               name="custom_first_name" @guest value=""
               @else value="{{ $user_address->first_name}}" @endif>
    </div>
        <div class="form-group custom_group qty_block_custom">
        <label class="form-label" for="custom_name">Last Name <span
                    class="text-danger">*</span></label>
        <input type="text" class="custom_input" id="custom_last_name"
               name="custom_last_name" @guest value=""
               @else value="{{ $user_address->last_name}}" @endif>
    </div>
    <div class="form-group custom_group qty_block_custom">
        <label for="custom_email">Email <span
                    class="text-danger">*</span></label>
        <div style="width: calc(100% - 33%)">
            <input type="email" class="custom_input" id="custom_email"
                   name="custom_email" @guest value=""
                   @else value="{{ $user_address->email}}" @endif>
            <div class="invalid-feedback">
                Please enter valid email.
            </div>
        </div>
    </div>
    <div class="form-group custom_group qty_block_custom">
        <label for="custom_phone">Phone <span
                    class="text-danger">*</span></label>
        <div style="width: calc(100% - 33%)">
            <input type="tel" class="custom_input" id="custom_phone"
                   name="custom_phone" @guest value=""
                   @else value="{{ $user_address->phone}}" @endif>
            <div class="invalid-feedback error-msg">
                Please enter valid phone number.
            </div>
        </div>
    </div>
    <div class="form-group custom_group qty_block_custom">
        <label for="custom_message">Notes: <span
                    class="text-danger">*</span></label>
        <textarea class="custom_input" id="custom_message"
                  name="custom_message" rows="9"
                  style="height: 120px !important;"></textarea>
    </div>
    @if(isset($product->shipping_info))
        <div class="form-group custom_group custom_delivery_type qty_block_custom">
            <label class="switch">
                <input class="" type="checkbox" name="custom_delivery_type"
                       id="custom_delivery_type">
                <span class="slider round"></span>
            </label>
            <label>Shipping</label>
        </div>
        <div class="custom_group qty_block_custom custom_address"
             id="custom_address_block">
            <label for="custom_address">Address <span
                        class="text-danger">*</span></label>
            <input type="text" id="custom_address" name="custom_address"
                   autocomplete="false" @guest value=""
                   @else value="{{ $user_address->address}}" @endif>
            <div class="row">
                <div class="col-md-6 mt-3">
                    <label class="form-label">Unit/Apartment/Suite</label>
                    <input type="text" name="custom_unit"
                           class="form-control custom_input" @guest value=""
                           @else value="{{ $user_address->unit}}" @endif>
                </div>
                <div class="col-md-6 mt-3">
                    <label class="form-label">ZIP<span
                                class="text-danger">*</span></label>
                    <input type="text" name="custom_zip"
                           class="form-control custom_input" @guest value=""
                           @else value="{{ $user_address->zip}}" @endif>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mt-3">
                    <label class="form-label">City<span
                                class="text-danger">*</span></label>
                    <input type="text" name="custom_city"
                           class="form-control custom_input" @guest value=""
                           @else value="{{ $user_address->city}}" @endif>
                </div>
                <div class="col-md-6 mt-3">
                    <label class="form-label">State<span
                                class="text-danger">*</span></label>
                    <input type="text" name="custom_state"
                           class="form-control custom_input" @guest value=""
                           @else value="{{ $user_address->state}}" @endif>
                </div>
            </div>
        </div>
    @endif
</div>
<input type="hidden" id="free_shipping"
       value="{{setting('free_shipping')}}"/>
<div>
    <div style="position: relative">
        <div>
            <label style="font-weight: 400;color: #000">Production Turnaround</label>
            <i class="fa-solid fa-circle-question tooltipIcon" id="tooltipIcon"></i>
            <div class="tooltip-wrapper" id="tooltip">
                <div style="border-bottom:1px solid #d6d6d6; background:#f2f2f2; color:#000; padding:10px 10px;">
                    <h6>Production Turnaround</h6>
                </div>
                <div style="padding:18px; background:#fff; color: #000">
                    <div style="background:#fff;color: black;">
                        <div>
                            @if($product->production_turnaround)
                                {!! $product->production_turnaround !!}
                            @else
                                <p><span style="font-weight: 800">Production Turnaround</span> is the estimated number of business days needed to print a project. It doesn’t include the shipping or delivery.</p>
                                <p><span style="font-weight: 800">“Express” Turnaround</span> means as soon as humanly possible under current production schedule. NO CUT OFF TIMES. YansPrint team will be in direct contact with you to coordinate the project.</p>
                                <p>If the order is placed by 12 noon, approved and paid* before 4pm PST, production starts that same day, and 1 Business day will be considered the next working day.</p>
                                <p class="ng-tns-c24-2">*For Net 30 terms contact your account manager.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="product_deliveries">
        @switch($product->deliveries->count())
            @case(1)
                @php $delivery_item_size = '100%'; @endphp
                @break

            @case(2)
                @php $delivery_item_size = '49%'; @endphp
                @break

            @default
                @php $delivery_item_size = '32%'; @endphp
        @endswitch

        @foreach($product->deliveries as $d => $delivery)
            <label for="delivery_{{ $delivery->id }}"
                   style="flex-basis: {{ $delivery_item_size }}"
                   class="{{$project ? ($project->attrs['delivery_id'] == $delivery->id ? 'active' : '') : ($d == 0 ? 'active' : '')}} {{$delivery->is_over ? 'hidden is_over' : ''}} ">
                <span>{{ $delivery->title }}</span>
                <b>${{ $delivery->price }}</b>
                <input id="delivery_{{ $delivery->id }}" type="radio"
                       name="delivery"
                       value="{{ $delivery->price }}" {{ isset($project) ? ($project->attrs['delivery_id'] == $delivery->id ? 'checked' : '') : ($d == 0 ? 'checked' : '') }}>
                @if($delivery->is_over)
                    <input type="hidden" value="{{$delivery->is_over_count}}"
                           class="over_count">
                @endif
            </label>
        @endforeach
    </div>
</div>