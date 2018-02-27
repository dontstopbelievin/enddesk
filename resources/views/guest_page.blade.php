@extends('layouts.app')

@section('content')

@include('/view_js/my_add_request')

<div class="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-body text-center">
          Ваш запрос будет добавлен в текущий список запросов<br>
          Письмо уведомление будет отправлено администраторам<br>
          <span style="color:red;">*</span> &mdash; обязательные поля
        </div>
      </div>
    </div>
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4>Новая заявка</h4>
        </div>
        <div class="panel-body">
          <form id="itemForm">
            <div class="form-group row">
              <label for="name" class="col-md-3 col-form-label">Имя <span style="color:red;">*</span></label>
              <div class="col-md-5 conrols">
                <input type="text" id="name" class="form-control" required placeholder="Введите ваше имя">
              </div>
            </div>
            <div class="form-group row">
              <label for="email" class="col-md-3 col-form-label" >E-mail почта <span style="color:red;">*</span></label>
              <div class="col-md-5">
                <input type="text" id="email" class="form-control" required placeholder="Введите e-mail почту">
              </div>
            </div>
            <div class="form-group row">
              <label for="cabinet" class="col-md-3 col-form-label">Кабинет <span style="color:red;">*</span></label>
              <div class="col-md-5">
              <input type="text" id="cabinet" class="form-control" required placeholder="Введите номер кабинета">
              </div>
            </div>
            <div class="form-group row">
              <label for="tel" class="col-md-3 col-form-label">Телефон</label>
              <div class="col-md-5">
              <input type="text" id="tel" class="form-control" placeholder="Введите телефон">
              </div>
            </div>
            <div class="form-group row">
              <label for="select_category" class="col-md-3 col-form-label">Категория <span style="color:red;">*</span></label>
              <div class="col-md-5">
                <select class="form-control" id="select_category" required>
                  <option value="">Выберите категорию</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="select_priority" class="col-md-3 col-form-label">Приоритет <span style="color:red;">*</span></label>
              <div class="col-md-5">
                <select class="form-control" id="select_priority" required>
                  <option value="">Выберите приоритет</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="theme" class="col-md-3 col-form-label">Тема</label>
              <div class="col-md-9">
              <input type="text" id="theme" class="form-control" placeholder="Введите тему">
              </div>
            </div>
            <div class="form-group row">
              <label for="message" class="col-md-3 col-form-label">Сообщение <span style="color:red;">*</span></label>
              <div class="col-md-9">
              <textarea type="textarea" id="message" class="form-control" required placeholder="Введите сообщение" style="resize:vertical;"></textarea>
              </div>
            </div>
            <div class="text-center">
              <input type="submit" value="Отправить заявку" class="btn btn-primary">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
