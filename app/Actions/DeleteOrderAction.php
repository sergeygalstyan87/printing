<?php

namespace App\Actions;

use LaravelViews\Actions\Action;
use LaravelViews\Views\View;
use LaravelViews\Actions\Confirmable;
class DeleteOrderAction extends Action
{
    /**
     * Any title you want to be displayed
     * @var String
     * */
    public $title = "Delete Order";
    public $className = "delete_item";
    public function getConfirmationMessage($item = null)
    {
        return 'Are you sure to delete this order?';
    }
    /**
     * This should be a valid Feather icon string
     * @var String
     */
    public $icon = "trash-2";

    /**
     * Execute the action when the user clicked on the button
     *
     * @param $model Model object of the list where the user has clicked
     * @param $view Current view where the action was executed from
     */
    public function handle($model, View $view)
    {

        $model->delete();
        $this->success('order deleted successfully.');
    }


}
