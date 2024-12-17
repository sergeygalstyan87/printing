<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AnswerEmail;
use App\Services\QuestionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class QuestionController extends Controller
{
    protected $questionService = null;

    public function __construct( QuestionService $questionService )
    {
        $this->questionService = $questionService;
    }

    public function index()
    {
        $items = $this->questionService->getItems();
        return view('dashboard.pages.questions.index', compact('items'));
    }

    public function add()
    {
        return view('dashboard.pages.questions.form');
    }

    public function store(Request $request)
    {
        $this->questionService->create($request->except('_token'));
        return redirect()->route('dashboard.questions.index');
    }

    public function edit($id)
    {
        $item = $this->questionService->getItem($id);
        return view('dashboard.pages.questions.form', compact(['item']));
    }

    public function update(Request $request, $id)
    {
        $this->questionService->update($request->except('_token'), $id);

        return redirect()->route('dashboard.questions.index');
    }

    public function delete($id)
    {
        $this->questionService->delete($id);
        return redirect()->route('dashboard.questions.index')->with('success', 'Question deleted successfully');
    }

    public function answer($id)
    {
        $item = $this->questionService->getItem($id);
        return view('dashboard.pages.questions.answer', compact(['item']));
    }
    public function sendAnswer(Request $request, $id)
    {
        $item = $this->questionService->getItem($id);
        $requestData = array_merge($request->all(), ['is_answered' => true]);
        $this->questionService->update($requestData, $id);

        Mail::to($item->email)->send(new AnswerEmail($item));

        return redirect()->route('dashboard.questions.index');
    }
}
