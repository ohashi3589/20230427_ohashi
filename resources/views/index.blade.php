<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/reset.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
  <title>Document</title>
</head>

<body style="background-color: #2d197c;">
  <div class="todo">
    <h2 style="color: black; text-align: left;">Todo List</h2>
    <form method="POST" action="{{ route('store') }}">
      @csrf
      <div class="between">
        <div style="position: relative;">
          @if($errors->has('content'))
          <div style="color: black; font-size: medium; position: absolute; left: 0; top: -25px;">
            {{ $errors->first('content') }}
          </div>
          @endif
          <div style="display: inline-block; width: 80%; margin-right: 5%;">
            <input name="content" type="text" class="input-add" style="width: 100%;">
          </div>
          <div style="display: inline-block;">
            <button type="submit" class="button-add">追加</button>
          </div>
        </div>
      </div>
    </form>
    <table>
      <tr>
        <th>登録日</th>
        <th>タスク名</th>
        <th>更新</th>
        <th>削除</th>
      </tr>
      @foreach ($todos as $todo)
      <tr>
        <td>{{ $todo->created_at }}</td>
        <td>
          <form action="{{ route('update', $todo->id) }}" method="POST">
            @csrf
            <input name="_method" type="hidden" value="POST">
            <input name="content" type="text" class="input-edit" value="{{ $todo->content }}">
        </td>
        <td>
          <button type="submit" class="button-edit">更新</button>
          </form>
        </td>
        <td>
          <form action="{{ route('delete', $todo->id) }}" method="POST">
            @csrf
            <input name="_method" type="hidden" value="POST">
            <button type="submit" class="button-danger">削除</button>
          </form>
        </td>
      </tr>
      @endforeach
    </table>
  </div>
</body>

</html>