@extends('layouts.admin')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')

    <section class="page-content container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">{{ (isset($item)) ? 'Edit' : 'Create' }} attribute</h5>
                    <form
                        method="post"
                        action="{{ (isset($item) ) ? route('dashboard.attributes.update', ['id' => $item->id]) : route('dashboard.attributes.store') }}"
                    >
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Name</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Enter name"
                                    name="name"
                                    value="{{ (isset($item) && isset($item->name) ) ? $item->name : old('name') }}"
                                >
                                @error('name')
                                    <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Notes</label>
                                <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Enter notes"
                                        name="notes"
                                        value="{{ (isset($item) && isset($item->notes) ) ? $item->notes : old('notes') }}"
                                >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Description (Displayed in the Details Tab on the Product Page)</label>
                                <textarea
                                        type="text"
                                        class="form-control"
                                        placeholder="Enter description"
                                        name="description">
                                    {{ (isset($item) && isset($item->description) ) ? $item->description : old('description') }}
                                </textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Help text that provides more details</label>
                                <textarea
                                        type="text"
                                        class="form-control"
                                        placeholder="Enter text"
                                        name="help_text">
                                    {{ (isset($item) && isset($item->help_text) ) ? $item->help_text : old('help_text') }}
                                </textarea>
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_crude" {{ ((isset($item ) && $item->is_crude == 1) || (old('is_crude') == 1)) ? 'checked' : '' }} value="1" id="is_crude">
                                    <label class="form-check-label" for="is_crude">Is Paper Type?</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_apparel" {{ ((isset($item ) && $item->is_apparel) || (old('is_apparel') == 1)) ? 'checked' : '' }} value="1" id="is_apparel">
                                    <label class="form-check-label" for="is_apparel">Is Apparel Size?</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_multiple" {{ ((isset($item ) && $item->is_multiple) || (old('is_multiple') == 1)) ? 'checked' : '' }} value="1" id="is_multiple">
                                    <label class="form-check-label" for="is_multiple">Multiple select</label>
                                </div>
                                <div class="form-check p-0">
                                    <label class="form-check-label" for="attribute_properties">Choose Attribute Properties</label>
                                    <div class="col-6">
                                        <select name="attribute_properties[]" multiple="multiple" id="attribute_properties">
                                            @foreach(\App\Enums\AttributeProperties::getNames() as  $key => $property)
                                                <option value="{{$key}}" {{isset($item ) && $item->attribute_properties && in_array($key, $item->attribute_properties) ? 'selected' : ''}}>
                                                    {{$property}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-light">
                            <button class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-secondary clear-form">Clear</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>

    <script>
        $('#attribute_properties').select2({
            allowClear: true,
            placeholder: "Select a property",
            width: '100%',
            multiple:true,
            search: true,
        });
    </script>
@endpush
