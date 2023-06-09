<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Todo;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
  public function index()
  {
    if (Auth::check()) {
      $user_id = Auth::id();
      $todos = Todo::where('user_id', $user_id)->orderBy('created_at', 'desc')->get();
      return view('index', compact('todos'));
    }
    return redirect()->route('login');
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
      'tag_id' => 'required',
    ], [
      'content.max' => '・タスクは20文字以内で入力してください。',
    ]);

    if ($validator->fails()) {
      return redirect()
        ->back()
        ->withErrors($validator)
        ->withInput();
    }
    

    $tag = Tag::find($request->input('tag_id'));
    $todo = new Todo();
    $todo->user_id = Auth::id();
    $todo->content = $request->content;
    $todo->tag()->associate($tag);
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
    $tagId = $request->input('tag_id');
    if (!empty($tagId)) {
      $tag = Tag::find($tagId);
      if ($tag) {
        $todo->tag_id = $tagId;
      }
    }
    $todo->save();

    // 更新前のURLにリダイレクトする
    return redirect()->back();
  }

  public function delete(Todo $todo)
  {
    $todo->delete();
    return redirect()->back();
  }

public function find(Request $request)
{
    $content = $request->input('content');
    $tag = $request->input('tag');

    $tasks = Todo::query();

    return view('task', [
        'todos' => $tasks,
        'tag_id' => $tag_id ?? null, 
    ]);
}

  public function search(Request $request)
  {
    $content = $request->input('content');
    $tag_id = $request->input('tag_id');

    $todos = Todo::query()
      ->when($content, function ($query, $content) {
        return $query->where('content', 'LIKE', "%{$content}%");
      })
      ->when($tag_id, function ($query, $tag_id) use ($content) {
        if ($content) {
          return $query->where('tag_id', $tag_id)
            ->where('content', 'LIKE', "%{$content}%");
        } else {
          return $query->where('tag_id', $tag_id);
        }
      })
      ->paginate(10);

    return view('task', compact('todos', 'tag_id',));
  }

}