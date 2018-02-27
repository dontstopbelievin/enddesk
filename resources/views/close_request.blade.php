@extends('layouts.app')

@section('content')

@include('/view_js/my_close_request')

<div class="container">
  <div class="row">
    <div class="col-md-1 col-md-offset-1">
      <a class="btn btn-success" href="/home"><span class="glyphicon glyphicon-arrow-left"></span> Назад</a>
    </div>
    <div class="col-md-8">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3>Запрос</h3>
        </div>
        <div class="panel-body">
          <div id="apiitems"></div>
          <form id="itemForm" style="padding-top:10px;">
            <div class="form-group row">
              <label for="comment" class="col-md-3 col-form-label">Комментарий <span style="color:red;">*</span></label>
              <div class="col-md-9">
              <textarea type="textarea" id="comment" class="form-control" required placeholder="Введите комментарий" style="resize:vertical;"></textarea>
              </div>
            </div>
            <div class="text-center">
              <input type="submit" value="Закрыть запрос" class="btn btn-primary">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
