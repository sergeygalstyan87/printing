@forelse($sets as $key=>$set)
    <div class="set_item" data-set-index-key="{{$set->id}}">
        <h5 class="set_title">{{$set ? $set->set_title : ''}}</h5>
        <div class="set_item_upload_block">
            @foreach($uploadedFileTypeTitles as $index => $uploadedFileType)
                <div class="file_upload_block" data-set-id="{{ $set->id }}">
                    <label class="file_type">{{ $uploadedFileType }}</label>

                    <div class="fileUpload file-container">
                        <label for="fileUpload-{{$key}}-{{$index}}" class="file-upload">
                            <div>
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                                <div class="img_preview_block"></div>
                            </div>
                            <input type="file" id="fileUpload-{{$key}}-{{$index}}" class="file_upload_input"
                                   name="uploaded_files[{{$key}}][{{ strtolower(str_replace(' ', '_', $uploadedFileType)) }}][]"
                                   value=""
                                   data-file-type="{{ strtolower(str_replace(' ', '_', $uploadedFileType)) }}" hidden multiple
                            >
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@empty
    @for($i=0; $i<$set_count; $i++)
        <div class="set_item">
            <h5 class="set_title"></h5>
            <div class="set_item_upload_block">
                @foreach($uploadedFileTypeTitles as $key => $uploadedFileType)
                    <div class="file_upload_block" >
                        <label class="file_type">{{ $uploadedFileType }}</label>
                        <div class="fileUpload file-container">
                            <label for="fileUpload-{{$i}}-{{$key}}" class="file-upload">
                                <div>
                                    <i class="fa-solid fa-cloud-arrow-up"></i>
                                    <div class="img_preview_block"></div>
                                </div>
                                <input type="file" id="fileUpload-{{$i}}-{{$key}}" class="file_upload_input"
                                       name="uploaded_files[{{$i}}][{{ strtolower(str_replace(' ', '_', $uploadedFileType)) }}][]"
                                       value=""
                                       data-file-type="{{ strtolower(str_replace(' ', '_', $uploadedFileType)) }}" hidden multiple
                                >
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endfor
@endforelse

@if(count($sets) && $set_count > count($sets))
    @for($i=0; $i<$set_count - count($sets); $i++)
        <div class="set_item" >
            <h5 class="set_title">SET {{count($sets) + $i + 1}}</h5>
            <div class="set_item_upload_block">
                @foreach($uploadedFileTypeTitles as $key => $uploadedFileType)
                    <div class="file_upload_block" >
                        <label class="file_type">{{ $uploadedFileType }}</label>
                        <div class="fileUpload file-container">
                            <label for="fileUpload-{{count($sets) + $i + 1}}-{{$key}}" class="file-upload">
                                <div>
                                    <i class="fa-solid fa-cloud-arrow-up"></i>
                                    <div class="img_preview_block"></div>
                                </div>
                                <input type="file" id="fileUpload-{{count($sets) + $i + 1}}-{{$key}}" class="file_upload_input"
                                       name="uploaded_files[{{count($sets) + $i + 1}}][{{ strtolower(str_replace(' ', '_', $uploadedFileType)) }}][]"
                                       value=""
                                       data-file-type="{{ strtolower(str_replace(' ', '_', $uploadedFileType)) }}" hidden multiple
                                >
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endfor
@endif
<input type="text" class="file_upload_folder_name"
       name="uploaded_files"
       value=""
       hidden
>