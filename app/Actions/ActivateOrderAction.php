<?php

namespace App\Actions;

use App\Http\Controllers\Admin\TrelloController;
use LaravelViews\Actions\Action;
use LaravelViews\Views\View;

class ActivateOrderAction extends Action
{
    /**
     * Any title you want to be displayed
     * @var String
     * */
    public $title = "Approve Proof";
    public $className = "activate";

    /**
     * This should be a valid Feather icon string
     * @var String
     */
    public $icon = "thumbs-up";

    /**
     * Execute the action when the user clicked on the button
     *
     * @param $model Model object of the list where the user has clicked
     * @param $view Current view where the action was executed from
     */
    public function handle($model, View $view)
    {
        $model->proof_approved = 1;
        $model->save();
        TrelloController::addCard($model);
        $this->success('Proof approved successfully.');
    }
    public function renderIf($model, View $view)
    {
        return !$model->proof_approved;
    }


}
