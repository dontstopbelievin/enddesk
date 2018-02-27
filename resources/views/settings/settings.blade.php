@extends('layouts.app')

@section('content')

@include('/../view_js/my_settings')

<div class="row">
  <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4>Настройки</h4>
        </div>
        <div class="panel-body" style="padding:0px;">
          <div class="text-center" style="background-color:#0088cc;height:30px;padding:0px;">
              <div class="menu_first">Мой профиль</div>
              @if($user->usertype_id == 1 || $user->usertype_id == 2)
              <div class="menu_second">Справочная информация</div>
              @endif
          </div>
          <div class="row" style="padding:35px;">
            <div class="col-md-4">
              <div class="content">
                <p>Изменить пароль</p>
                <form id="itemForm">
                  <div class="form-group">
                    <input type="text" id="password" class="form-control" required placeholder="Пароль">
                  </div>
                  <div class="form-group">
                    <input type="hidden" id="user_id" value="{{$user->id}}">
                  </div>
                  <div class="form-group">
                    <input type="text" id="password_confirmation" class="form-control" required placeholder="Подтвердите пароль">
                  </div>
                  <input type="submit" value="Изменить" class="btn btn-primary" >
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
</div>
@endsection
