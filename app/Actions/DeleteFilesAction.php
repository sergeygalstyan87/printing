<?php

namespace App\Actions;

use App\Http\Controllers\Front\GoogleDriveController;
use App\Models\Order;
use Illuminate\Support\Facades\File;
use LaravelViews\Actions\Action;
use LaravelViews\Views\View;

class DeleteFilesAction extends Action
{
    /**
     * Any title you want to be displayed
     * @var String
     * */
    public $title = "Delete order files";

    /**
     * This should be a valid Feather icon string
     * @var String
     */
    public $icon = "";

    /**
     * Execute the action when the user clicked on the button
     *
     * @param $model Model object of the list where the user has clicked
     * @param $view Current view where the action was executed from
     */
    public function handle($model, View $view)
    {
        foreach ($model as $item){
            $order = Order::find($item);
            GoogleDriveController::deleteFolder($order->est_number);
        }

        $this->success('Files deleted successfully.');
    }
}
