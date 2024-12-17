<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use LaravelViews\Filters\Filter;

class OrdersActiveFilter extends Filter
{
    public $title =  "Status...";
    /**
     * Modify the current query when the filter is used
     *
     * @param Builder $query Current query
     * @param $value Value selected by the user
     * @return Builder Query modified
     */

    /**
     * Defines the title and value for each option
     *
     * @return Array associative array with the title and values
     */

    public function apply(Builder $query, $value, $request)
    {
        switch ($value):
            case 'custom_request':
                return $query->whereIn('status', ['customRequest', 'pending'])->where('is_custom', 1)->orderBy('id', 'desc');
                break;
            case 'all':
                return $query->orderBy('id', 'desc');
                break;
            case 'archived':
                return $query->whereIn('delivery_status', [3, 4])->orderBy('id', 'desc');
                break;
            case 'declined':
                return $query->where('status', 'canceled')->orderBy('id', 'desc');
                break;
            case 'ready_to_start':
                return $query->where('status', 'completed')->where('proof_approved',1)->whereIn('delivery_status',[0, 5])->orderBy('id', 'desc');
                break;
            case 'in_progress':
                return $query->whereIn('delivery_status',[1,2])->orderBy('id', 'desc');
                break;
            case 'new':
                return $query->where('status', 'completed')->where('proof_approved',0)->orderBy('id', 'desc');
                break;

            endswitch;
        //return $query->where('active', $value);
    }

    /**
     * Defines the title and value for each option
     *
     * @return Array associative array with the title and values
     */
    public function options()
    {
        return [
            'New'=>'new',
            'Ready To Start' => 'ready_to_start',
            'In Progress'=>'in_progress',
            'Archived' => 'archived',
            'Declined' => 'declined',
            'Order Requests'=>'custom_request',
            'All'=>'all'
        ];
    }
}
