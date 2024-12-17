@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets/css/checkout.css') }}">
    <script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
    <style>
        h1{font-size: 20px;color: #000000}
        .text-muted{font-size: 15px;color: #000000!important;}
        .upload_image_block{width: 50px;height: 30px;min-width: unset}
        .upload_image_preview{width: 100%;height: 100%;}
        .refresh:hover{cursor: pointer;}
    </style>
@endpush

@section('content')
    <section class="page-content container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-5 col-md-5">
                                <div class="media align-items-center">
                                    <span class="w-96" style="display: inline-block; width: 200px">
                                        <img src="{{ asset('storage/content/' . $item->product->images[0]) }}" alt=".">
                                    </span>
                                    <div class="mx-3 mb-2">
                                        <h1>{{ $item->product->title }}</h1>
                                        <p class="text-muted">
                                            <span class="m-r"><b>Quantity</b></span>
                                            <span>{{  $item->qty }}</span>
                                        </p>
                                        <?php
                                        $attributes = json_decode($item->attrs,true);
                                        ?>
                                        @if(isset($item) && !empty($attributes))
                                            @foreach($attributes['types'] as $key=>$type)
                                                <p class="text-muted">
                                                    <span><b>{{ $key }}</b></span>
                                                    <span>{{ $type }}</span>
                                                </p>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-3">
                                <div class="row mb-2" id="proof_info" style="height: 100%;">
                                    <div class="col" style="border-left: 1px solid #dfdfdf;border-right: 1px solid #dfdfdf">
                                        <div class="d-flex flex-column justify-content-end" style="height: 100%;">
                                            @if(isset($item->proof))
                                                <div style="margin: auto">
                                                    <iframe src="{{ asset('storage/content/proofs/' . $item->proof->file) }}" frameborder="0" height="100px" width="300px"></iframe>
                                                </div>
                                            @endif
                                            <div class="form-group mb-0">
                                                <div class="progress_bars"></div>
                                                <h5>Send already uploaded File to Client</h5>
                                                <div class="form-file d-flex align-items-center justify-content-between">
                                                    <div>
                                                        <form
                                                                method="post"
                                                                action="#"
                                                                enctype="multipart/form-data"
                                                        >
                                                            @csrf
                                                            <label class="btn btn-outline btn-rounded btn-primary text-primary" id="selectFileButton">
                                                                Select file ...
                                                                <input type="file" id="proofFileInput" name="proof_file" accept="application/pdf" class="checkout_image" required style="display: none;" />
                                                            </label>
                                                        </form>
                                                        <div class="text-danger small error"></div>
                                                    </div>
                                                    <div class="uploaded_images">
                                                        @if(isset($item->proof))
                                                            <div class = "upload_image_block" >
                                                                <div class="upload_image_preview">
                                                                    <div style="width:100%;height:100%;border: 1px solid #000;align-items: center;
                                  justify-content: center;
                                  display: flex;position: relative">
                                                                        {{pathinfo($item->proof->file)['extension']}}
                                                                    </div>
                                                                    <input type="hidden" name="proofs[]" value="{{$item->proof->id}}">
                                                                </div>
                                                                <div class="delete_img" data-proof='{{$item->proof->id}}' style="font-size: 11px">x</div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <form
                                                                class="mt-auto"
                                                                method="post"
                                                                action="{{ isset($proof) ? route('dashboard.orders.send_proof_email', ['id' => $item->id]) : '#' }}"
                                                        >
                                                            @csrf
                                                            <div>
                                                                <button type="submit" class="btn btn-success text-white proof_send_btn" {{isset($proof) ? '' : 'disabled'}}>Send</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col d-flex flex-column justify-content-between align-items-end">
                                <div class="media flex-column align-items-end justify-content-end">
                                    <span style="text-align: left;font-weight: bold">
                                         @if( isset($item))
                                            {{$item->est_number}}
                                        @endif
                                    </span>
                                    <span style="text-align: left;color:red;font-weight: bold">
                                          @switch($item->delivery_status)
                                            @case(0)
                                            @case(5)
                                                Design & Prepress
                                                @break
                                            @case(1)
                                                Production
                                                @break
                                            @case(2)
                                                Ready
                                                @break
                                            @case(3)
                                                Picked up
                                                @break
                                            @case(4)
                                                Shipping
                                                @break
                                            @default
                                                Unknown status
                                        @endswitch
                                    </span>
                                    @if($rate)
                                        <span style="color: #000000;text-align: right">
                                        <b>{{$rate['text']}}</b>
                                        <br>
                                        {{$rate['terms']}}
                                    </span>
                                    @endif
                                </div>
                                <div class="media align-items-center justify-content-end">
                                    @if( isset($item))
                                        <a href="{{ route('dashboard.orders.invoice', ['id' => isset($item) ? $item->id :'']) }}" target="_blank"
                                           class="btn btn-success text-white">Download Invoice</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <ul class="nav nav-pills nav-pills-info mb-3" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active show" id="pills-billing-tab" data-toggle="pill"
                           href="#billing_info" role="tab" aria-controls="billing_info"
                           aria-selected="true">Billing Information</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-customer-tab" data-toggle="pill" href="#customer_info"
                           role="tab" aria-controls="customer_info" aria-selected="false">Customer Information</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-description-tab" data-toggle="pill" href="#description_info"
                           role="tab" aria-controls="description_info" aria-selected="false">Description</a>
                    </li>
                    @if($item->status == 'completed')
                        <li class="nav-item">
                            <a class="nav-link" id="pills-tracking-tab" data-toggle="pill" href="#tracking_info"
                               role="tab" aria-controls="tracking_info" aria-selected="false">Tracking</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" id="pills-price-tab" data-toggle="pill" href="#price_info"
                               role="tab" aria-controls="price_info" aria-selected="false">Set Price</a>
                        </li>
                    @endif
                </ul>

                <div class="tab-content" id="pills-tabContent-3">
                    <div class="tab-pane fade show active" id="billing_info" role="tabpanel"
                         aria-labelledby="billing_info">
                        <div class="tab-pane fade active show" id="tab_4">
                            <div class="row mb-2">
                                <div class="col-6">
                                    <span class="text-lg">Product Price</span>
                                    <div class="font-weight-bold"><b>${{ isset($item) ? $item->original_amount : '' }}</b></div>
                                </div>
                                <div class="col-6">
                                    <span class="text-lg">Tax</span>
                                    <div class="font-weight-bold"><b>${{ isset($item) ? $item->tax : '' }}</b></div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6">
                                    <span class="text-lg">Shipping Price</span>
                                    <div class="font-weight-bold"><b>${{ isset($item) ? $item->shipping_price : 0 }}</b></div>
                                </div>
                                <div class="col-6">
                                    @if(isset($item) && $item->coupon_id)
                                        <span class="text-lg">Coupon</span>
                                        <div class="font-weight-bold"><b>{{ $item->coupon->name }} ({{ $item->coupon->percent }}%)</b></div>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <hr class="my-3" style="border-color:#cdcdcd">
                                <span class="text-lg">Total</span>
                                <div class="font-weight-bold text-success"><b>${{ isset($item) ? $item->amount : '' }}</b></div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade show" id="customer_info" role="tabpanel"
                         aria-labelledby="customer_info">
                        <div class="row mb-2">
                            <div class="col-6">
                                <span class="text-lg">First Name</span>
                                <div class="font-weight-500"><b>{{ (!empty($item->first_name)?$item->first_name:'N/A') }}</b></div>
                            </div>
                            <div class="col-6">
                                <span class="text-lg">Last Name</span>
                                <div class="font-weight-500"><b>{{ (!empty($item->last_name)?$item->last_name:'N/A') }}</b></div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6">
                                <span class="text-lg">Email</span>
                                <div class="font-weight-500"><b>{{ (!empty($item->email)?$item->email:'N/A') }}</b></div>
                            </div>
                            <div class="col-6">
                                <span class="text-lg">Phone</span>
                                <div class="font-weight-500"><b>{{ (!empty($item->phone)?$item->phone:'N/A') }}</b></div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6">
                                <span class="text-lg">Company</span>
                                <div class="font-weight-500"><b>{{ (!empty($item->company)?$item->company:'N/A') }}</b></div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6">
                                <span class="text-lg">Delivery</span>
                                <div class="font-weight-500"><b>{{ isset($item) ? ucfirst($item->delivery_type):'' }}</b></div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            @if(isset($item) && $item->delivery_type != 'pickup')
                                <div class="col-6">
                                    <span class="text-lg">Address</span>
                                    <div class="font-weight-500"><b>{{ $item->address.' Unit '.$item->unit.' '.$item->city.' '.$item->state.' '.$item->zip }}</b></div>
                                </div>
                                <div class="col-6">
                                    <span class="text-lg">Shiping Provider</span>
                                    <div class="font-weight-500"><b>{{ $item->shipping_provider }}</b></div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane fade show" id="description_info" role="tabpanel"
                         aria-labelledby="description_info">
                        <div class="row mb-2">
                            <div class="col-6">
                                <span class="text-lg">Type</span>
                                <div class="font-weight-500"><b>{{$item->type}}</b></div>
                            </div>
                            <div class="col-6">
                                <span class="text-lg">Job name / PO</span>
                                <div class="font-weight-500"><b>{{$item->job_name}}</b></div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6">
                                <span class="text-lg">Project Notes</span>
                                <div class="font-weight-500"><b>{!! $item->notes !!}</b></div>
                            </div>
                            <div class="col-6">
                                <span class="text-lg">Do you need help with file?</span>
                                <div class="font-weight-500"><b>{{ $item->help_with_file}}</b></div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6">
                                <span class="text-lg">Type the changes here</span>
                                <div class="font-weight-500"><b>{{ $item->changes }}</b></div>
                            </div>
                            <div class="col-6">
                                <span class="text-lg">Proofing Options?</span>
                                <div class="font-weight-500"><b>{{  $item->proofing_options }}</b></div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6">
                                @if(isset($item) && $item->delivery_id)
                                    <span class="text-lg">Production time</span>
                                    <div class="font-weight-500"><b>{{ isset($item) ? $item->delivery->title : ''}}</b></div>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6">
                                @if( isset($item) && $item->images )
                                    @foreach($item->images as $image)
                                        <div class="mr-3">
                                            <iframe src="https://drive.google.com/file/d/{{$image}}/preview" width="180" height="200"></iframe>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade show" id="tracking_info" role="tabpanel"
                         aria-labelledby="tracking_info">
                        <div class="row mb-2">
                            <div class="col-6">
                                <div class="card-body">
                                    <form
                                            method="post"
                                            action="{{ (isset($item) ) ? route('dashboard.orders.update', ['id' => $item->id]) : route('dashboard.orders.store') }}"
                                            enctype="multipart/form-data"
                                    >
                                        <div class="form-group">
                                            <label for="track_number">Track Number</label>
                                            <input
                                                    id="track_number"
                                                    type="text"
                                                    class="form-control"
                                                    placeholder="Enter Track Number"
                                                    name="track_number"
                                                    value="{{ (isset($item) && isset($item->track_number) ) ? $item->track_number : old('track_number') }}"
                                            >
                                            @error('track_number')
                                            <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="track_number_link">Track Link</label>
                                            <input
                                                    id="track_number_link"
                                                    type="text"
                                                    class="form-control"
                                                    placeholder="Enter Track Link"
                                                    name="track_number_link"
                                                    value="{{ (isset($item) && isset($item->track_number_link) ) ? $item->track_number_link : old('track_number_link') }}"
                                            >
                                            @error('track_number_link')
                                            <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="delivery_status">Status</label>
                                            <select id="delivery_status" class="form-control stock" name="delivery_status">
                                                <option value="0" {{ isset($item) &&  $item->delivery_status == '0' ? 'selected' : '' }}>Prepress
                                                </option>
                                                <option value="1" {{ isset($item) && $item->delivery_status == '1' ? 'selected' : '' }}>Production
                                                </option>
                                                <option value="2" {{ isset($item) && $item->delivery_status == '2' ? 'selected' : '' }}>Ready
                                                </option>
                                                @if(isset($item) && $item->delivery_type == 'shipping')
                                                    <option value="4" {{ isset($item) && $item->delivery_status == '4' ? 'selected' : '' }}>Shipping
                                                    </option>
                                                @else
                                                    <option value="3" {{ isset($item) && $item->delivery_status == '3' ? 'selected' : '' }}>Picked
                                                        up
                                                    </option>
                                                @endif
                                            </select>
                                            @error('delivery_status')
                                            <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div style="display:flex;justify-content: space-between;align-items: center">
                                            <button class="btn btn-primary">Save</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade show" id="price_info" role="tabpanel"
                         aria-labelledby="price_info">
                        <div class="row mb-2">
                            <div class="col-6">
                                <div class="card-body">
                                    <form
                                    method="post"
                                    action="{{  route('dashboard.orders.update_price', ['id' => $item->id]) }}"
                                    enctype="multipart/form-data"
                            >
                                <div class="form-group">
                                    <label for="original_amount">Order Price</label>
                                    <input
                                            id="original_amount"
                                            type="text"
                                            class="form-control"
                                            placeholder="Enter price"
                                            name="original_amount"
                                            value="{{  $item->original_amount }}"
                                    >
                                    @error('original_amount')
                                    <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="tax">Tax
                                        <i class="icon dripicons-clockwise refresh tax_refresh text-danger" title="Recount Tax"></i>
                                    </label>
                                    <input
                                            id="tax"
                                            type="text"
                                            class="form-control"
                                            placeholder="Enter price"
                                            name="tax"
                                            value="{{  $item->tax }}"
                                            data-tax="{{$tax_rate}}"
                                    >
                                    @error('tax')
                                    <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>
                                @if($item->delivery_type == 'shipping')
                                <div class="form-group">
                                    <label for="shipping_price">Shipping Price</label>
                                    <input
                                            id="shipping_price"
                                            type="text"
                                            class="form-control"
                                            placeholder="Enter Shipping Price"
                                            name="shipping_price"
                                            value="{{ (isset($item) && isset($item->shipping_price) ) ? $item->shipping_price : old('shipping_price') }}"
                                    >
                                    @error('shipping_price')
                                    <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>
                                 @endif
                                <div class="form-group">
                                    <label for="tax">Total <i class="icon dripicons-clockwise refresh tax_refresh text-danger" title="Recount Price"></i></label>
                                    <input
                                            id="total"
                                            type="text"
                                            class="form-control"
                                            name="amount"
                                            value="{{  $item->amount }}"
                                    >
                                    @error('tax')
                                    <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div style="display:flex; justify-content: space-between;align-items: center">
                                    <button class="btn btn-primary">Save</button>

                                </div>

                            </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('admin/assets/js/components/select2-init.js') }}"></script>
    <script>
        $(document).ready(function () {

            $(document).on('click', '.delete_img', function () {
                const proofId = $(this).data('proof')
                $.ajax({
                    type: "DELETE",
                    url: `/dashboard/orders/delete-proof/${proofId}`,
                    success: () => {
                        $(this).parents('.upload_image_block').remove();
                        window.location.reload();
                    },
                });
            })

            $(document).on('click', '.upload_image_preview', function () {
                $('#order-product-proof').modal('show');
            })

            var Upload = function (file, progressBar, uploadedImages) {
                this.file = file;
                this.progressBar = progressBar;
                this.uploadedImages = uploadedImages;
            };

            Upload.prototype.getType = function () {
                return this.file.type;
            };
            Upload.prototype.getSize = function () {
                return this.file.size;
            };
            Upload.prototype.getName = function () {
                return this.file.name;
            };
            Upload.prototype.validateFileSize = function () {
                var maxSize = 629145600; // 600MB in bytes
                var fileSize = this.getSize();
                return fileSize <= maxSize;
            };
            Upload.prototype.doUpload = function () {
                let that = this,
                    formData = new FormData()

                formData.append("file", this.file, this.getName());
                formData.append("_token", '{{ csrf_token() }}');
                this.progressBar.append('<div id="progress-wrp"><div class="progress-bar"></div><div class="status">0%</div></div>')

                $.ajax({
                    type: "POST",
                    url: "{{ route('dashboard.orders.upload_proof', ['id' => $item->id]) }}",
                    xhr: function () {
                        var myXhr = $.ajaxSettings.xhr();
                        if (myXhr.upload) {
                            myXhr.upload.addEventListener('progress', that.progressHandling, false);
                        }
                        return myXhr;
                    },
                    success: function (data) {
                        that.uploadedImages.find('.upload_image_block').remove()
                        that.uploadedImages.append(data.proof);
                        let progress_bar_id = "#progress-wrp";
                        $(progress_bar_id + " .progress-bar").css("width", +100 + "%");
                        $(progress_bar_id + " .status").text(100 + "%");
                        $(progress_bar_id).remove();
                        window.location.reload();
                    },
                    async: true,
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    timeout: 60000
                });
            };

            Upload.prototype.progressHandling = function (event) {
                let percent = 0,
                    position = event.loaded || event.position,
                    total = event.total,
                    progress_bar_id = "#progress-wrp"

                if (event.lengthComputable) {
                    percent = Math.ceil(position / total * 97);
                }
                $(progress_bar_id + " .progress-bar").css("width", +percent + "%");
                $(progress_bar_id + " .status").text(percent + "%");
                if (percent === 100) {
                    $(progress_bar_id).remove()
                }
            };

            $(".checkout_image").on("change", function (e) {
                let files = $(this)[0].files
                let progressBar = $('.progress_bars');
                let uploadedImages = $('.uploaded_images');
                let errorBlock = $(this).next('.error');
                errorBlock.empty();

                Object.entries(files).forEach(([key, val]) => {
                    let upload = new Upload(val, progressBar, uploadedImages);
                    if (upload.validateFileSize()) {
                        upload.doUpload();
                    }else {
                        errorBlock.text("Uploaded file is too large. Max File size is 600Mb");
                    }
                });
                $(this).val('')
            });

            $('.tax_refresh').click(()=>{
                let total_price = parseFloat($("#original_amount").val());
                let tax_rate = $('#tax').data('tax');
                let tax = parseFloat((total_price  * tax_rate).toFixed(2));
                $("#tax").val(tax);
                $("#price_cost").val(total_price);
                let shipping = $("#shipping_price").val();
                if(!shipping){
                    shipping = 0;
                }else{
                    shipping = parseFloat(shipping);
                }
                let i = parseFloat((total_price + tax + shipping).toFixed(2));
                $('#total').val(i);

            })
        });
    </script>
@endpush
