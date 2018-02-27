@extends('layouts.app')

@section('content')

@include('/../view_js/my_priority')

<div class="container">
  <div class="row">
    <div class="col-md-1 col-md-offset-1">
      <a class="btn btn-success" href="/settings/2"><span class="glyphicon glyphicon-arrow-left"></span></span> Назад</a>
    </div>
    <div class="col-md-4">
      <form id="itemForm">
      <div class="panel panel-default">
        <div class="panel-body">
          <h4>Добавить приоритет</h4>
            <div class="form-group">
              <input type="text" id="name" class="form-control" required placeholder="Название">
            </div>
            <input type="submit" value="Добавить" class="btn btn-primary" >
        </div>
      </div>
      </form>
    </div>
  </div>
  <div class="row">
    <div class="col-md-offset-2 col-md-8">
      <h3>Приоритеты</h3>
        <ul id="apiitems" class="list-group"></ul>
    </div>
  </div>
</div>
<div id="edit_box">
  <form id="itemFormEdit">
        <div class="edit_div panel panel-default">
          <div class="panel-body">
        <h4 id="formtitle">Изменить</h4>
        <div class="form-group">
          <input type="text" id="textEdit" class="form-control" required placeholder="Название">
        </div>
        <input type="submit" value="Изменить" class="btn btn-primary">
        <a class="btn btn-success cancel_editform">Отмена</a>
      </div>
    </div>
  </form>
</div>
<div id="delete_box">
  <table id ="delete_table">
    <tr>
      <td align=center>
        Вы действительно хотите удалить?<br>
        <a class="btn btn-warning confirm_delete" data-id="">Да</a>
        <a class="btn btn-success cancel_delete">Нет</a>
      </td>
    </tr>
  </table>
</div>
@endsection
