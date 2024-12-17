<div class="delivery_groups">
    @if(isset($item))
        @foreach($item->deliveries as $d => $delivery)
            <div class="form-group delivery_group">
                <input type="hidden"
                       name="delivery[{{$d}}][id]"
                       value="{{ $delivery->id }}">
                <div class="col-3">
                    <label>Title</label>
                    <input type="text" class="form-control"
                           placeholder="Delivery title"
                           name="delivery[{{$d}}][title]"
                           value="{{ $delivery->title }}" required>
                </div>
                <div class="col-3">
                    <label>Percent</label>
                    <input type="text" class="form-control"
                           placeholder="Delivery price"
                           name="delivery[{{$d}}][price]"
                           value="{{ $delivery->price }}" required>
                </div>
                <div class="col-3">
                    <label>Days</label>
                    <input type="number" class="form-control"
                           placeholder="Delivery days"
                           name="delivery[{{$d}}][days]"
                           min="1" max="365" step="1"
                           value="{{ $delivery->days }}" required>
                </div>
                <div class="is_over_time">
                    <label>Is Over</label>
                    <input class="form-control is_over_checkbox" type="checkbox" name="delivery[{{$d}}][is_over]"
                            {{ $delivery->is_over ? 'checked' : '' }}>
                </div>
                <div class="is_over_count {{ $delivery->is_over ? '' : 'd-none' }}">
                    <label>Over count</label>
                    <input type="number" class="form-control" name="delivery[{{$d}}][is_over_count]"
                           value="{{ $delivery->is_over_count }}">
                </div>

                <button type="button" class="btn btn-danger delete_delivery_type">
                    Delete
                </button>
            </div>
        @endforeach
    @endif
</div>