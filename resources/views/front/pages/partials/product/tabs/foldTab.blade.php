<div class="row box">
    @foreach($types as $type)
        @if($type->attribute_id == $keyFolding)
            @if($type->type_details)
                <div class="col-6 col-lg-6 productPaperGrid fragment-paperStockTabs mb-3">
                    <div class="card">
                        <div class="card-block">
                            <div class="paperTypesBlock">
                                <div class="paperTypeImageDiv">
                                    <div class="gloss-coated-cover-img">
                                        @if(isset($type->type_details['image']))
                                            <img src="{{ asset('/storage/content/'.$type->type_details['image']) }}">
                                        @endif
                                    </div>
                                    @if(isset($type->type_details['image_text']))
                                        <span>{{ $type->type_details['image_text'] }}</span>
                                    @endif
                                </div>
                                <div class="paperTypeDescription">
                                    <h5 class="paper-header bold">{{ $type->type_details['title'] ?? '' }}</h5>
                                    <div class="check-list-new-item">
                                        <ul>
                                            @foreach($type->type_details['description_lines'] ?? [] as $line)
                                                <li>
                                                    <span class="paper-list-item">{{$line}}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif
    @endforeach
</div>