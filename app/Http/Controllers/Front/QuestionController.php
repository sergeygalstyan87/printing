<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use App\Services\QuestionService;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    protected $questionService = null;
    protected $orderService = null;

    public function __construct(
        QuestionService $questionService,
        OrderService $orderService )
    {
        $this->questionService = $questionService;
        $this->orderService = $orderService;
    }
    public function store(Request $request)
    {
        //
    }
}
