<?php

namespace App\Actions;

use LaravelViews\Actions\Action;
use LaravelViews\Views\View;

class GenerateInvoiceAction extends Action
{
    /**
     * Any title you want to be displayed
     * @var String
     * */
    public $title = "Generate Invoice";
    public $className = "generate_invoice";

    /**
     * This should be a valid Feather icon string
     * @var String
     */
    public $icon = "file-text";

    /**
     * Execute the action when the user clicked on the button
     *
     * @param $model Model object of the list where the user has clicked
     * @param $view Current view where the action was executed from
     */
    public function handle($model, View $view)
    {
        if(!empty($model->invoice_number)){
            $fileName = $model->invoice_path;
        }else{
            $fileName = $model->generateInvoice();
        }
        $filePath = 'app/public/invoice/' . $fileName;
        if (file_exists(storage_path($filePath))) {
            $model->sendInvoiceBYRequest($model, $fileName);
            $model->update(['status'=>'pending','invoice_sent'=>date('Y-m-d H:i:s')]);
        }
        $this->success('Invoice generated successfully.');
    }

    public function renderIf($model, View $view)
    {
        return $model->amount > 0 && ($model->status=='customRequest' || $model->status=='pending');
    }
}
