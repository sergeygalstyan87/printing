<?php

namespace App\Actions;

use LaravelViews\Actions\Action;
use LaravelViews\Views\View;
use LaravelViews\Actions\Confirmable;
class DeclineOrderAction extends Action
{
    /**
     * Any title you want to be displayed
     * @var String
     * */
    public $title = "Cancel Order";
    public $className = "decline";

    /**
     * This should be a valid Feather icon string
     * @var String
     */
    public $icon = "thumbs-down";
public function isRedirect(){
    return true;
}
    /**
     * Execute the action when the user clicked on the button
     *
     * @param $model Model object of the list where the user has clicked
     * @param $view Current view where the action was executed from
     */
    public function handle($model, View $view)
    {
        return redirect(route('dashboard.orders.decline', $model->id));
        $this->success('Order cancelled successfully.');
    }


}
