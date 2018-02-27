@extends('layouts.app')

@section('content')

@include('/view_js/my_print_request')

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
          <a class="btn btn-success print" style="margin-top:10px;">Печать</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
