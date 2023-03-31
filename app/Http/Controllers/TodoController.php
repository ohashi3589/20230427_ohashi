<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Todo;

class TodoController extends Controller
{
  public function index()
  {
    $todos = Todo::orderBy('created_at', 'desc')->get();
    return view('index', compact('todos'));
  }

  public function create()
  {
    $todos = Todo::all();
    return view('index', compact('todos'));
  }

  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'content' => 'required|max:20',
    ], [
      'content.max' => '・タスクは20文字以内で入力してください。',
    ]);

    if ($validator->fails()) {
      return redirect()
        ->back()
        ->withErrors($validator)
        ->withInput();
    }

    $todo = new Todo;
    $todo->content = $request->content;
    $todo->save();

    return redirect()->route('index');
  }

  public function edit($id)
  {
    $todo = Todo::findOrFail($id);
    return view('index', compact('todo'));
  }

public function update(Request $request, $id)
{
    $todo = Todo::findOrFail($id);
    $todo->content = $request->input('content');
    $todo->save();

    return redirect()->route('index');
}

public function delete(Todo $todo)
{
    $todo->delete();
    return redirect()->route('index');
}

}