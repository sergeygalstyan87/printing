<div id="template" class="clear_body">
    <div class="card-body">
        <div class="row input-container">
            <div class="col-12 input_block">
                @if(isset($item) && isset($item->template_details) && $item->template_details[0]['title'])
                    @foreach($item->template_details as $key => $template)
                        <div class="clone_block">
                            <div class="">
                                <label>Title</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control"
                                           placeholder="Template title"
                                           name="template_details[{{$key}}][title]"
                                           value="{{ isset($template['title']) ? $template['title'] : old("template_details.{$key}.title") }}">
                                    <div class="input-group-append">
                                        @if($key)
                                            <button class="btn btn-danger remove-btn" type="button">-</button>
                                        @else
                                            <button class="btn btn-success btn-outline-success add-btn" type="button">
                                                +
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="">
                                    <div class="card">
                                        <div class="card-header">
                                            Without Type
                                        </div>
                                        <div class="card-body">
                                            @if (isset($template['without_type']))
                                                @foreach($template['without_type'] as $fileTypeKey => $file)
                                                    <div class="input-group mb-3">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input"
                                                                   name="template_details[{{$key}}][without_type][{{$fileTypeKey}}]"
                                                                   value="{{$file}}">
                                                            {{-- for saving old file name --}}
                                                            <input type="hidden" class="custom-file-input"
                                                                   name="template_details[{{$key}}][without_type][{{$fileTypeKey}}]"
                                                                   value="{{$file}}">
                                                            <label class="custom-file-label"
                                                                   for="customFile"> {{ $file ?? 'Choose file' }}</label>
                                                        </div>
                                                        <div class="input-group-append">
                                                            <button class="btn btn-success btn-outline-success add-file-btn"
                                                                    type="button"
                                                                    data-index="{{count($template['without_type'])}}">
                                                                +
                                                            </button>
                                                            <button class="btn btn-danger remove-file-btn"
                                                                    type="button">-
                                                            </button>
                                                            <a class="btn btn-warning btn-outline-warning download-new-file-btn" href="{{asset('/storage/content/templates/' . $file)}}" download><i class="fas fa-download text-white"></i></a>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="input-group mb-3">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input"
                                                               name="template_details[{{$key}}][without_type][0]">
                                                        <label class="custom-file-label" for="customFile"> Choose
                                                            file</label></div>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-success btn-outline-success add-file-btn"
                                                                type="button" data-index='0'>+
                                                        </button>
                                                        <button class="btn btn-danger remove-file-btn"
                                                                type="button">-
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="card">
                                        <div class="card-header">
                                            Vertical Templates
                                        </div>
                                        <div class="card-body">
                                            @if (isset($template['vertical']))
                                                @foreach($template['vertical'] as $fileTypeKey => $file)
                                                    <div class="input-group mb-3">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input"
                                                                   name="template_details[{{$key}}][vertical][{{$fileTypeKey}}]"
                                                                   value="{{$file}}">
                                                            <input type="hidden" class="custom-file-input"
                                                                   name="template_details[{{$key}}][vertical][{{$fileTypeKey}}]"
                                                                   value="{{$file}}">
                                                            <label class="custom-file-label"
                                                                   for="customFile"> {{ $file ?? 'Choose file' }}</label>
                                                        </div>
                                                        <div class="input-group-append">
                                                            <button class="btn btn-success btn-outline-success add-file-btn"
                                                                    type="button"
                                                                    data-index="{{count($template['vertical'])}}">
                                                                +
                                                            </button>
                                                            <button class="btn btn-danger remove-file-btn"
                                                                    type="button">-
                                                            </button>
                                                            <a class="btn btn-warning btn-outline-warning download-new-file-btn" href="{{asset('/storage/content/templates/' . $file)}}" download><i class="fas fa-download text-white"></i></a>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="input-group mb-3">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input"
                                                               name="template_details[{{$key}}][vertical][0]">
                                                        <label class="custom-file-label" for="customFile"> Choose
                                                            file</label>
                                                    </div>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-success btn-outline-success add-file-btn"
                                                                type="button" data-index='0'>+
                                                        </button>
                                                        <button class="btn btn-danger remove-file-btn"
                                                                type="button">-
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="card">
                                        <div class="card-header">
                                            Horizontal Templates
                                        </div>
                                        <div class="card-body">
                                            @if (isset($template['horizontal']))
                                                @foreach($template['horizontal'] as $fileTypeKey => $file)
                                                    <div class="input-group mb-3">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input"
                                                                   name="template_details[{{$key}}][horizontal][{{$fileTypeKey}}]"
                                                                   value="{{$file}}">
                                                            <input type="hidden" class="custom-file-input"
                                                                   name="template_details[{{$key}}][horizontal][{{$fileTypeKey}}]"
                                                                   value="{{$file}}">
                                                            <label class="custom-file-label"
                                                                   for="customFile"> {{ $file ?? 'Choose file' }}</label>
                                                        </div>
                                                        <div class="input-group-append">
                                                            <button class="btn btn-success btn-outline-success add-file-btn"
                                                                    type="button"
                                                                    data-index="{{count($template['horizontal'])}}">
                                                                +
                                                            </button>
                                                            <button class="btn btn-danger remove-file-btn"
                                                                    type="button">-
                                                            </button>
                                                            <a class="btn btn-warning btn-outline-warning download-new-file-btn" href="{{asset('/storage/content/templates/' . $file)}}" download><i class="fas fa-download text-white"></i></a>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="input-group mb-3">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input"
                                                               name="template_details[{{$key}}][horizontal][0]">
                                                        <label class="custom-file-label" for="customFile"> Choose
                                                            file</label>
                                                    </div>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-success btn-outline-success add-file-btn"
                                                                type="button" data-index='0'>+
                                                        </button>
                                                        <button class="btn btn-danger remove-file-btn"
                                                                type="button">-
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="clone_block">
                        <div class="">
                            <label>Title</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control"
                                       placeholder="Template title"
                                       name="template_details[0][title]">
                                <div class="input-group-append">
                                    <button class="btn btn-success btn-outline-success add-btn" type="button">+</button>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="">
                                <div class="card">
                                    <div class="card-header">
                                        Without Type
                                    </div>
                                    <div class="card-body">
                                        <div class="input-group mb-3">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input"
                                                       name="template_details[0][without_type][0]">
                                                <label class="custom-file-label" for="customFile"> Choose file</label>
                                            </div>
                                            <div class="input-group-append">
                                                <button class="btn btn-success btn-outline-success add-file-btn"
                                                        type="button" data-index='0'>+
                                                </button>
                                                <button class="btn btn-danger remove-file-btn"
                                                        type="button">-
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <div class="card">
                                    <div class="card-header">
                                        Vertical Templates
                                    </div>
                                    <div class="card-body">
                                        <div class="input-group mb-3">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input"
                                                       name="template_details[0][vertical][0]">
                                                <label class="custom-file-label" for="customFile"> Choose file</label>
                                            </div>
                                            <div class="input-group-append">
                                                <button class="btn btn-success btn-outline-success add-file-btn"
                                                        type="button" data-index='0'>+
                                                </button>
                                                <button class="btn btn-danger remove-file-btn"
                                                        type="button">-
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <div class="card">
                                    <div class="card-header">
                                        Horizontal Templates
                                    </div>
                                    <div class="card-body">
                                        <div class="input-group mb-3">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input"
                                                       name="template_details[0][horizontal][0]">
                                                <label class="custom-file-label" for="customFile"> Choose file</label>
                                            </div>
                                            <div class="input-group-append">
                                                <button class="btn btn-success btn-outline-success add-file-btn"
                                                        type="button" data-index='0'>+
                                                </button>
                                                <button class="btn btn-danger remove-file-btn"
                                                        type="button">-
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="button" class="btn btn-secondary clear-extra-form">Clear Template Details</button>
    </div>
</div>