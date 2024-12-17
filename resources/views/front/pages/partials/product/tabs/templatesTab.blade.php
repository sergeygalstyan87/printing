<div class="row col-md-12">
    <p class="mt-0">
        <span class="font-weight-bold">To reduce file size, please upload in .jpg format.</span> If you choose another
        file format, please ensure all layers are flattened. For best results, please use our downloadable templates
        below. All the available templates already have the correct dimensions, including bleed.
    </p>
</div>
<div class="template_table">
    @if($product->template_details)
        <table class="table table-hover" style="min-width: 570px">
            <thead>
            <tr>
                <th scope="col"><span class="float-left font-weight-bold py-2">Title</span></th>
                @if(isset($product->template_details[0]['vertical']) && $product->template_details[0]['vertical'][0])
                    <th scope="col">
                        <span class="float-left font-weight-bold py-2">Vertical Templates</span>
                        <span class="border templates_orientation_block_v float-left d-inline-block"></span>
                    </th>
                @endif
                @if(isset($product->template_details[0]['horizontal']) && $product->template_details[0]['horizontal'][0])
                    <th scope="col">
                        <span class="float-left font-weight-bold py-2">Horizontal Templates</span>
                        <span class="border templates_orientation_block_h float-left d-inline-block"></span>
                    </th>
                @endif
                @if(isset($product->template_details[0]['without_type']) && $product->template_details[0]['without_type'][0])
                    <th scope="col">
                        <span class="float-left font-weight-bold py-2">Default</span>
                    </th>
                @endif
            </tr>
            </thead>
            <tbody>

            @foreach($product->template_details as $template)
                @if($template['title'])
                    <tr>
                        <th scope="row">{{$template['title']}}</th>
                        @if(isset($template['vertical']) && $template['vertical'][0])
                            <td>
                                @foreach($template['vertical'] as $file)
                                    @php
                                        $icon = getFileIconByExtension($file);
                                    @endphp
                                    <a href="{{ asset('/storage/content/templates/' . $file) }}" class="illustrator"
                                       download>
                                        <img src="{{ $icon }}" alt="File Icon">
                                    </a>
                                @endforeach
                            </td>
                        @endif
                        @if(isset($template['horizontal']) && $template['horizontal'][0])
                            <td>
                                @foreach($template['horizontal'] as $file)
                                    @php
                                        $icon = getFileIconByExtension($file);
                                    @endphp
                                    <a href="{{ asset('/storage/content/templates/' . $file) }}" class="illustrator"
                                       download>
                                        <img src="{{ $icon }}" alt="File Icon">
                                    </a>
                                @endforeach
                            </td>
                        @endif
                        @if(isset($template['without_type']) && $template['without_type'][0])
                            <td>
                                @foreach($template['without_type'] as $file)
                                    @php
                                        $icon = getFileIconByExtension($file);
                                    @endphp
                                    <a href="{{ asset('/storage/content/templates/' . $file) }}" class="illustrator"
                                       download>
                                        <img src="{{ $icon }}" alt="File Icon">
                                    </a>
                                @endforeach
                            </td>
                        @endif

                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    @endif

</div>

<!-- Mobile Accordion -->
@if($product->template_details)
    <div class="accordion d-lg-none accordion-flush" id="template_accordion">
        @foreach($product->template_details as $key => $template)
            @if($template['title'])
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading_{{$key}}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_{{$key}}" aria-expanded="true" aria-controls="collapse_{{$key}}">
                            {{$template['title']}}
                        </button>
                    </h2>
                    <div id="collapse_{{$key}}" class="accordion-collapse collapse" aria-labelledby="heading_{{$key}}">
                        <div class="accordion-body">
                                @if(isset($template['vertical']) && $template['vertical'][0])
                                    <div class="template_type_block">
                                        <p class="template_type">Vertical Templates</p>
                                        <div class="template_files">
                                            @foreach($template['vertical'] as $file)
                                                @php
                                                    $icon = getFileIconByExtension($file);
                                                @endphp
                                                <a href="{{ asset('/storage/content/templates/' . $file) }}" class="illustrator" download>
                                                    <img src="{{ $icon }}" alt="File Icon">
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                @if(isset($template['horizontal']) && $template['horizontal'][0])
                                    <div class="template_type_block">
                                        <p class="template_type">Horizontal Templates</p>
                                        <div class="template_files">
                                            @foreach($template['horizontal'] as $file)
                                                @php
                                                    $icon = getFileIconByExtension($file);
                                                @endphp
                                                <a href="{{ asset('/storage/content/templates/' . $file) }}" class="illustrator" download>
                                                    <img src="{{ $icon }}" alt="File Icon">
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                @if(isset($template['without_type']) && $template['without_type'][0])
                                    <div class="template_type_block">
                                        <p class="template_type">Default Templates</p>
                                        <div class="template_files">
                                            @foreach($template['without_type'] as $file)
                                                @php
                                                    $icon = getFileIconByExtension($file);
                                                @endphp
                                                <a href="{{ asset('/storage/content/templates/' . $file) }}" class="illustrator" download>
                                                    <img src="{{ $icon }}" alt="File Icon">
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
@endif