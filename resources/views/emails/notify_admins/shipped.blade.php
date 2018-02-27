@component('mail::message')

<center>
<table class="table_source" cellpadding="10">
<tr>
  <td colspan="2" align=center>Был подан новый запрос:</td>
</tr>
<tr><td>Категория</td><td>{{$my_category->name}}</td></tr>
@if($my_request->theme != null)
<tr><td>Тема</td><td>{{$my_request->theme}}</td></tr>
@endif
<tr><td>Сообщение</td><td>{{$my_request->message}}</td></tr>
<tr><td>Дата создания</td><td>{{$my_request->created_at}}</td></tr>
<tr><td>Приоритет</td><td>{{$my_priority->name}}</td></tr>
<tr><td>Автор</td><td>{{$my_request->username}}<br>{{$my_request->email}}
<br>кабинет {{$my_request->cabinet}}
@if($my_request->tel != null)
<br>телефон {{$my_request->tel}}</td></tr>
@endif
</table>
</center>

@endcomponent
