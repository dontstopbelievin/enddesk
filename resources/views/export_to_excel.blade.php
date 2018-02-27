@extends('layouts.app')

@section('content')

@include('/view_js/my_export_to_excel')

<div id="request_table"></div>
<div class="container">
  <div class="row">
    <div class="col-md-1 col-md-offset-1">
      <a class="btn btn-success" href="/home"><span class="glyphicon glyphicon-arrow-left"></span></span> Назад</a>
    </div>
    <div class="col-md-8">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4>Экспорт в excell:</h4>
        </div>
        <div class="panel-body">
          <form id="itemForm">
            <div class="form-group row">
              <label for="sortFrom" class="col-md-2 col-form-label">От <span style="color:red;">*</span></label>
              <div class="col-md-5 conrols">
                <input type="date" id='sortFrom' class="form-control" required>
              </div>
            </div>
            <div class="form-group row">
              <label for="sortTo" class="col-md-2 col-form-label" >До <span style="color:red;">*</span></label>
              <div class="col-md-5">
                <input type="date" id='sortTo' class="form-control" required>
              </div>
            </div>
            <div class="form-group row">
              <label for="select_category" class="col-md-2 col-form-label">Категория</label>
              <div class="col-md-5">
                <select class="form-control" id="select_category">
                  <option value="all">Все категории</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="select_priority" class="col-md-2 col-form-label">Приоритет</label>
              <div class="col-md-5">
                <select class="form-control" id="select_priority">
                  <option value="all">Все приоритеты</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="select_status" class="col-md-2 col-form-label">Статус</label>
              <div class="col-md-5">
                <select class="form-control" id="select_status">
                  <option value="all">Все статусы</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="select_admin" class="col-md-2 col-form-label">Исполнитель</label>
              <div class="col-md-5">
                <select class="form-control" id="select_admin">
                  <option value="all">Все администраторы</option>
                </select>
              </div>
            </div>
            <div class="text-center">
              <input type="submit" value="Экспортировать" class="btn btn-primary">
            </div>
          </form>
          <div class="msg text-center"></div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
