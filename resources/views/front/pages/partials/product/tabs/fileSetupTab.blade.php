<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-4">
                <span class="font-weight-bold file_setup_label">Bleed:</span>
            </div>
            <div class="col file_setup_label_desc">
                {{isset($product->bleed) ? $product->bleed : '0.125"'}}
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-4">
                <span class="font-weight-bold file_setup_label">Resolution:</span>
            </div>
            <div class="col file_setup_label_desc">
                350 DPI
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-4">
                <span class="font-weight-bold file_setup_label">Color Mode:</span>
            </div>
            <div class="col file_setup_label_desc">
                CMYK
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-4">
                <span class="font-weight-bold file_setup_label">File Formats:</span>
            </div>
            <div class="col file_setup_label_desc">
                TIF, TIFF, EPS, AI, PSD, BMP, GIF, JPG, PNG, PDF
            </div>
        </div>


        <div class="row mt-3">
            <div class="col-md-4">
                <span class="font-weight-bold file_setup_label">Max File Upload Size:</span>
            </div>
            <div class="col file_setup_label_desc">
                75MB
            </div>
        </div>


        <div class="row mt-3">
            <div class="col-md-4">
                <span class="font-weight-bold file_setup_label">Instant Online Proof:</span>
            </div>
            <div class="col file_setup_label_desc">
                An instant proof will be available for you to review and approve. If you select this option, you must
                check your files for errors, as YansPrint will not provide you with an additional proof.<br>
            </div>
        </div>


        <div class="row mt-3">
            <div class="col-md-4">
                <span class="font-weight-bold file_setup_label">Manually Processed, PDF Proof:</span>
            </div>
            <div class="col file_setup_label_desc">
                <span class="font-weight-bold">24 Hours (Excluding Weekends and Holidays).</span> We will check your
                files and ensure they have the correct file specifications.
                If we find any problems with your files, we'll contact you, otherwise you'll receive a link to your
                PROOF to review within 1 business day.
            </div>
        </div>


        <div class="row mt-3">
            <div class="col-md-4">
                <span class="font-weight-bold file_setup_label">Note:</span>
            </div>
            <div class="col file_setup_label_desc">
                Prices include processing one set of uploaded files and creating a single proof. You can view the
                <a target="_blank" href="{{route('profile.orders')}}">status of your order online 24/7 under "Order
                    History"</a>
            </div>
        </div>
{{--        <div class="row mt-3">--}}
{{--            <div class="col-md-4">--}}
{{--                <span class="font-weight-bold file_setup_label text-danger"></span>--}}
{{--            </div>--}}
{{--            <div class="col file_setup_label_desc">--}}
{{--                If you have submitted a CD of your files, the proof turnaround will begin after we have received your--}}
{{--                CD. In addition, for all orders during the holiday season, we will be extending our proof turnaround--}}
{{--                time by 1 business day. Files not built correctly may delay the order.--}}
{{--            </div>--}}
{{--        </div>--}}

    </div>
</div>