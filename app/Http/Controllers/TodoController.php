<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Todo;
use App\Models\Tag;

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
      'tag' => 'required',
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

    $tag = new Tag;
    $tag->name = $request->input('tag');
    $tag->todo_id = $todo->id;
    $tag->save();

    $todo->tag = $tag->name;
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

    $todo = Todo::findOrFail($id);
    $todo->content = $request->input('content');
    $todo->tag = $request->input('tag');
    $todo->save();

    return redirect()->route('index');
  }

  public function delete(Todo $todo)
  {
    $todo->delete();
    return redirect()->route('index');
  }

  public function find(Request $request)
  {
    $content = $request->input('content');
    $tag = $request->input('tag');

    $tasks = Todo::query();

    if (!empty($content)) {
      $tasks->where('content', 'LIKE', '%' . $content . '%');
    }

    if (!empty($tag)) {
      $tasks->where('tag', $tag);
    }

    $tasks = $tasks->orderBy('created_at', 'desc')->get();

    return view('task', ['todos' => $tasks]);
  }

  public function search(Request $request)
  {
    $content = $request->input('content');
    $tag_id = $request->input('tag_id');

    $query = Todo::query();

if ($content) {
  $query->where('content', 'LIKE', "%{$content}%");
}

if ($tag_id) {
  $query->whereHas('tags', function ($query) use ($tag_id) {
    $query->where('id', $tag_id);
  });
}

$todos = $query->get();

    return view('task', compact('todos'));
  }

}