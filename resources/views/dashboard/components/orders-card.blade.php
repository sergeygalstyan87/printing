@props([
  'image' => '',
  'title' => '',
  'subtitle' => '',
  'description' => '',
  'withBackground' => false,
  'model',
  'actions' => [],
  'hasDefaultAction' => false,
  'selected' => false
])
<div class="flex flex-col">
    <img class="h-44 w-full rounded-2xl object-cover object-center" style="height: 160px" src="{{ $image }}" alt="image">
    <div class="card -mt-8 grow rounded-2xl p-3">
        <div class="row">
            <div class="col-12 d-flex gap-x-2">
                <a href="{{ $model->is_custom ? route('dashboard.orders.edit-request', $model->id) : route('dashboard.orders.edit', $model->id) }}"
                   class="text-sm+ font-medium text-slate-700 line-clamp-1 hover:text-primary focus:text-primary dark:text-navy-100 dark:hover:text-accent-light dark:focus:text-accent-light">
                   @if($est_number)
                        {{$est_number}}
                    @else
                      {{$model->generateEstNumberInfo()}}
                    @endif
                </a>
                <span style="text-align: right;color:black;font-weight: bold">
                     {{$amount}}$
                </span>
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-12 d-flex gap-x-2" style="font-size: 14px;color:black;">
                {{$product_title}}
                <span style="text-align: right;color:black;font-weight: bold">{{$model->qty}}</span>
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-12 d-flex gap-x-2" style="font-size: 14px;color:black;">
                    {{$user_first_name}} {{$user_last_name}}
                <span style="text-align: right;font-weight: bold;color:black;">
                     <a href="tel:{{$model->phone}}" class="text-sm+ font-medium text-slate-700 line-clamp-1 hover:text-primary focus:text-primary dark:text-navy-100 dark:hover:text-accent-light dark:focus:text-accent-light">
                        {{$model->phone}}
                    </a>
                </span>

            </div>
        </div>
        <div class="row mt-1">
            <div class="col-12 d-flex gap-x-2" style="font-size: 14px;color:black;">
                    Created
                <span style="text-align: right;color:black;font-weight: bold">
                    {{\Carbon\Carbon::parse($model->created_at)->format('j M Y H:i'),}}
                </span>
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-12 d-flex gap-x-2" style="font-size: 14px;color:black;">
                Paid
                <span style="text-align: right;color:black;font-weight: bold">
                    @if($model->paid_at)
                        {{\Carbon\Carbon::parse($model->paid_at)->format('j M Y H:i'),}}
                    @else
                        N/A
                    @endif
                </span>
            </div>
        </div>
        <div class="row mt-2" >
            <div class="col-12 d-flex gap-x-2" style="font-size: 14px;color:black;">
                {{$delivery_type}}
                <span style="text-align: right;color:black;font-weight: bold">
                    {{$shipping_provider}}
                </span>
                <span style="text-align: left;color:red;font-weight: bold">
                  @switch($model->delivery_status)
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
            </div>
        </div>
        <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: {{$model->getProgress()}}%" aria-valuenow="{{$model->getProgress()}}" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        @if (count($actions))
            <div class="flex justify-end items-center">
                @foreach($actions as $action )
                @if ($action->renderIf($model, $this))
                    <x-lv-tooltip :tooltip="$action->title">
                        <x-lv-icon-button class="p-1 border-2 border-transparent text-gray-600 rounded-full hover:text-gray-700 focus:outline-none focus:text-gray-700 focus:bg-gray-100 transition duration-150 ease-in-out {{$action->className}}"  :icon="$action->icon" size="sm"  wire:click.prevent="executeAction('{{ $action->id }}', '{{ $model->getKey() }}')" />
                    </x-lv-tooltip>
                @endif
                @endforeach
            </div>
        @endif
    </div>
</div>


<style>
    .h-5{
        width: 1.25rem!important;
        height:  1.25rem!important;
    }
</style>
