<?php

namespace App\Http\Livewire;

use App\Actions\ActivateOrderAction;
use App\Actions\DeclineOrderAction;
use App\Actions\DeleteFilesAction;
use App\Actions\DeleteOrderAction;
use App\Actions\GenerateInvoiceAction;
use App\Filters\OrdersActiveFilter;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use LaravelViews\Facades\UI;
use LaravelViews\Views\GridView;

class OrdersGridView extends GridView
{
    /**
     * Sets a model class to get the initial data
     */
    public $maxCols = 4;
    public $withBackground = true;
    protected $model = Order::class;
    public $searchBy = ['first_name', 'last_name', 'email', 'est_number','product.title'];
    public $cardComponent = 'dashboard.components.orders-card';

    protected function filters()
    {
        return [
            new OrdersActiveFilter
        ];
    }
    protected function actionsByRow()
    {

        return [
            new GenerateInvoiceAction,
            new ActivateOrderAction,
            new DeclineOrderAction,
            new DeleteOrderAction
      ];

    }

    /** For bulk actions */
    protected function bulkActions()
    {
        return [
            new DeleteFilesAction,
        ];
    }

    public function repository(): Builder
    {
        $query = Order::query();


        return $query;
    }
    /**
     * Sets the data to every card on the view
     *
     * @param $model Current model for each card
     */
    public function card($model)
    {
        return [
            'est_number'=>$model->est_number,
            'user_first_name'=>$model->first_name,
            'user_last_name'=>$model->last_name,
            'image'    =>   $model->product->avatar(),
            'amount'   =>  $model->amount,
            'product_title' => $model->product->title,
            'date' => Carbon::parse($model->paid_at)->format('j M Y'),
            'delivery_type'=>ucfirst($model->delivery_type),
            'shipping_provider'=>$model->shipping_provider,
            'model'=>$model
        ];
    }

    public function sortableBy()
    {
        return [
            'Created Date' => 'created_at',
            'Payment Date' => 'paid_at'
        ];
    }
}
