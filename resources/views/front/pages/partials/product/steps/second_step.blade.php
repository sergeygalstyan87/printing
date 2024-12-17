<div class="">
    <div class="form-group custom_group ">
        <label class="form-label" for="project_title">Project Name <span
                    class="text-danger">*</span></label>
        <input type="text" class="custom_input" id="project_title"
               name="project_title" value="{{$project ? $project->project_title : ''}}">
    </div>
    <div class="form-group set_group_block">
        <label for="sets">SETS <span class="text-danger">*</span></label>
        <div class="set_group">
            <button type="button" id="decrease" class="btn btn-primary">-</button>
            <input type="number" id="set_count" value="{{$project ? $project->sets->count() : 1}}" min="1" max="200" readonly>
            <button type="button" id="increase" class="btn btn-primary">+</button>
            <span>Max: 200</span>
        </div>
    </div>

    @if($project && $project->sets->count())
        <div id="set[]" class="set_inputs">
            @foreach($project->sets as $key => $value)
                    <div class="set_input" data-set-index-key="{{$value->id}}">
                        <label>SET {{$key+1}} NAME</label>
                        <div class="set_input_item" data-set-id="{{$value->id}}">
                            <input type="text" class="form-control" placeholder="Set Name" name="set_title[{{$value->id}}]" value="{{$value->set_title}}">
                            <button type="button" class="remove_set">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </div>
            @endforeach
        </div>
    @else
        <div id="set[]" class="set_inputs" >
            <div class="set_input" data-set-index-key="1">
                <label>SET 1 NAME</label>
                <div class="set_input_item">
                    <input type="text" class="form-control" placeholder="Set Name" name="set_title[1]" value="SET 1">
                    <button type="button" class="remove_set hidden">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>