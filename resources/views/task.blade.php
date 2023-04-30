<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/reset.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/style2.css') }}">
  <title>Document</title>
</head>

<body style="background-color: #2d197c;">
  <div class="todo">
    <h2 style="color: black; text-align: left;">Todo List</h2>
    <div class="user-info">
      @auth
      <p>「{{ Auth::user()->name }}」でログイン中</p>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn-logout">ログアウト</button>
      </form>
      @endauth
    </div>
    <form action="{{ route('search') }}" method="get">
      <div class="between">
        @csrf
        @if($errors->has('content'))
        <div style="color: black; font-size: medium;">
          {{ $errors->first('content') }}
        </div>
        <br>
        @endif
        <div style="position: relative;">
          <div style="display: inline-block; width: 80%; margin-right: 5%;">
            <input name="content" type="text" class="input-add" style="width: 100%;">
          </div>
          <div style="display: inline-block; width: 10%; ">
            <select name="tag_id" class="input-add" style="width: 100%;">
              <option value=""></option>
              <option value="1" {{ old('tag_id') == '1' ? 'selected' : '' }}>家事</option>
              <option value="2" {{ old('tag_id') == '2' ? 'selected' : '' }}>勉強</option>
              <option value="3" {{ old('tag_id') == '3' ? 'selected' : '' }}>運動</option>
              <option value="4" {{ old('tag_id') == '4' ? 'selected' : '' }}>食事</option>
              <option value="5" {{ old('tag_id') == '5' ? 'selected' : '' }}>移動</option>
            </select>
          </div>
          <div style="display: inline-block;">
            <button type="submit" class="button-add">検索</button>
          </div>
        </div>
      </div>
    </form>
    <table>
      <tr>
        <th>登録日</th>
        <th>タスク名</th>
        <th>タグ</th>
        <th>更新</th>
        <th>削除</th>
      </tr>
      @foreach ($todos as $todo)
      @if (!$tag_id || ($todo->tag_id && $todo->tag_id == $tag_id))
      <tr>
        <td>{{ $todo->created_at }}</td>
        <td>
          <form action="{{ route('update', $todo->id) }}" method="GET">
            @csrf
            <input type="text" name="content" value="{{ $todo->content }}" class="input-edit1">
        </td>
        <td>
          <select name="tag_id" class="input-edit2">
            <option value="1" @if($todo->tag_id == 1) selected @endif>家事</option>
            <option value="2" @if($todo->tag_id == 2) selected @endif>勉強</option>
            <option value="3" @if($todo->tag_id == 3) selected @endif>運動</option>
            <option value="4" @if($todo->tag_id == 4) selected @endif>食事</option>
            <option value="5" @if($todo->tag_id == 5) selected @endif>移動</option>
          </select>
        </td>
        <td>
          <button type="submit" class="button-update">更新</button>
          </form>
        </td>
        <td>
          <form action="{{ route('delete', $todo->id) }}" method="POST">
            @csrf
            <button type="submit" class="button-delete">削除</button>
          </form>
        </td>
      </tr>
      @endif
      @endforeach
    </table>
    <br>
    <a href="{{ route('index') }}" class="btn-return">戻る</a>
  </div>
</body>

</html>