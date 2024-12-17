<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    //
    public function index()
    {
        $items = [];
        $model = new Order();
        $orders = [];
        $orders['new'] = $model->getNewOrdersCount();
        $orders['in_progress'] = $model->getInProgressCount();
        $orders['ready_to_start'] = $model->getReadyToStartCount();
        $orders['requests'] = $model->getOrderRequestsCount();
        $orders['total'] = $orders['new']+ $orders['in_progress']+$orders['ready_to_start'] +$orders['requests'];

        return view('dashboard.pages.reports.index', compact('items','orders'));
    }

    public function monthly(Request $request)
    {
        $request->validate([
            'year' => 'required|numeric|min:2024|max:'.now()->year
        ]);

        $year = $request->get('year') ?? now()->year;
        $data = [

            // Add more data as needed
        ];
        for ($m = 1; $m <= 12; $m++) {
            $month = date('M', mktime(0, 0, 0, $m, 1, date('Y')));

            $data[$month] = [
                'label' => $month,
                'y' => 0
            ];

        }

        $payments = DB::select('select amount, created_at from orders where status="completed" and year(created_at) = '.$year);
        if (!empty($payments)) {
            foreach ($payments as $item) {
                $l = date('M', strtotime($item->created_at));
                $data[$l]['y'] += $item->amount;

            }
        }
        $data = array_values($data);
        // Return JSON response
        return response()->json($data);
    }

    public function monthlyTax(Request $request)
    {
        $request->validate([
            'year' => 'required|numeric|min:2024|max:'.now()->year
        ]);

        $year = $request->get('year') ?? now()->year;
        $data = [

        ];
        for ($m = 1; $m <= 12; $m++) {
            $month = date('M', mktime(0, 0, 0, $m, 1, date('Y')));

            $data[$month] = [
                'label' => $month,
                'y' => 0
            ];

        }
        $payments = DB::select('select tax, created_at from orders where status="completed" and year(created_at) = '.$year);
        if (!empty($payments)) {
            foreach ($payments as $item) {
                $l = date('M', strtotime($item->created_at));
                $data[$l]['y'] += $item->tax;

            }
        }
        $data = array_values($data);
        return response()->json($data);
    }

    public function topProducts(Request $request)
    {
        $from = $request->get('from');
        $to = $request->get('from');
        $from_date = new DateTime($from);
        $to_date = new DateTime($to);

        $query = Product::leftJoin(
            'orders',
            function ($join) {
                $join->on('orders.product_id', '=', 'products.id');
                $join->on('orders.status', '=', DB::raw('"completed"'));
            }
        );

        if (isset($from) && isset($to)) {
            $query->whereBetween('orders.created_at', [$from_date, $to_date]);
        } else if (isset($from)) {
            $query->whereBetween('orders.created_at', '>=', $from_date);
        } else if (isset($to)) {
            $query->whereDate('orders.created_at', '<=', $to_date);
        }

        $orders = $query
            ->groupBy("products.id")
            ->orderBy('total_amount', 'desc')
            ->select(
                'products.title as title',
                'products.slug as slug',
                DB::raw('IF(count(orders.id) > 0, sum(orders.amount), 0) as total_amount')
            )
            ->offset(0)
            ->limit(10)
            ->get();

        foreach ($orders as $key => $order) {
            $order['index'] = $key + 1;
        }

        // Return JSON response
        return response()->json(['data' => $orders]);
    }

    public function topCategories(Request $request)
    {
        $from = $request->get('from');
        $to = $request->get('from');
        $from_date = new DateTime($from);
        $to_date = new DateTime($to);

        $query = Category::leftJoin(
            'products',
            'products.category_id', '=', 'categories.id'
        )
            ->leftJoin(
                'orders',
                function ($join) {
                    $join->on('orders.product_id', '=', 'products.id');
                    $join->on('orders.status', '=', DB::raw('"completed"'));
                }
            );

        if (isset($from) && isset($to)) {
            $query->whereBetween('orders.created_at', [$from_date, $to_date]);
        } else if (isset($from)) {
            $query->whereBetween('orders.created_at', '>=', $from_date);
        } else if (isset($to)) {
            $query->whereDate('orders.created_at', '<=', $to_date);
        }

        $categories = $query
            ->groupBy("categories.id")
            ->orderBy('amount', 'desc')
            ->select(
                'categories.name',
                'categories.id',
                DB::raw('SUM(orders.amount) as amount')
            )
            ->get();

        $total_amount = 0;

        foreach ($categories as $category) {
            $total_amount += $category['amount'] ?? 0;
        }

        // Return JSON response
        return response()->json(['data' => $categories, 'total_amount' => $total_amount]);
    }
}
