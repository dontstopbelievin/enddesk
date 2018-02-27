@extends('layouts.app')

@section('content')

@include('/view_js/my_home')

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-body">
          @if(Auth::guest())
          <p><a class="btn btn-primary" href="/requests">Подать заявку</a></p>
          @else
          <p>
          <a class="btn btn-primary showtag_all">Все запросы</a>
          <a class="btn btn-primary showtag_mine" style="margin-left:10px;">Мои запросы</a>
          <img title="Экспорт в excel" class ="imgbut" src="/storage/images/excelicon.ico"/>
          </p>
          @endif
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-4">
      @if(Auth::guest())
      <strong style="font-size:16px;padding-left:10px">Текущие запросы</strong>
      @else
      <strong style="padding-left:10px">Текущие запросы &rarr; <span id="indicator">все запросы:</span> </strong>
      @endif
    </div>
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-body" style="padding:0px">
          <div class="params">
      			Обновлять каждые
      			<select class="my_select_timelapse" id="set_timelapse">
      			<option value=5000>5 сек</option>
      			<option value=10000>10 сек</option>
      			<option value=30000>30 сек</option>
      			<option value=60000>1 мин</option>
      			</select>
      			Запросов на странице
      			<select class="my_select_reqs" id="select_amount">
      			<option value=10>10</option>
      			<option value=20>20</option>
      			<option value=30>30</option>
      			<option value=50>50</option>
      			</select></div>
          <div id="request_table"></div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
