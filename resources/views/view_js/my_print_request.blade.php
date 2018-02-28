<script type="text/javascript">
$(document).ready(function(){

  getItem();
  let req_number = -1;
  //get req from api
  function getItem(){
    $.ajax({
      url:'/api/requests/'+{{$id}},
      //dataType: 'html',
    }).done(function(requests){

      let output = '';
      $.each(requests, function(key, request){
          req_number = request.id;
          output += '<table class="table_source" cellpadding="10">';
          output += '<tr><td>Категория</td><td>'+request.category.name+'</td></tr>';
          if(request.theme != null){ output += '<tr><td>Тема</td><td>'+request.theme+'</td></tr>';}
          output += '<tr><td>Сообщение</td><td>'+request.message+'</td></tr>';
          output += '<tr><td>Дата создания</td><td>'+request.created_at+'</td></tr>';
          output += '<tr><td>Приоритет</td><td>'+request.priority.name+'</td></tr>';
          output += '<tr><td>Статус</td><td>'+request.status.name+'</td></tr>';
          output += '<tr><td>Автор</td><td>'+request.username+'<br>'+request.email;
          output += '<br>кабинет '+request.cabinet;
          if(request.tel != null){ output += '<br>телефон '+request.tel+'</td></tr>';}
          if(request.admin != null){ output += '<tr><td>Исполнитель</td><td> '+request.admin.name+'</td></tr>';}
          if(request.comment != null){ output += '<tr><td>Комментарий</td><td> '+request.comment+'</td></tr>';}
          if(request.closed_time != null){ output += '<tr><td>Был закрыт</td><td> '+request.closed_time+'</td></tr>';}
          output += '</table>';
      });

      $('#apiitems').html(output);
    });
  }

  $('body').on('click', '.print', function(e){
    e.preventDefault();

    var divToPrint=document.getElementById('apiitems');
    var newWin=window.open('','Print-Window');
    newWin.document.open();
    newWin.document.write(`<html><body onload="window.print()"><br><br><br><br><br>
    <center><font size=4>Запрос #`+req_number+`</font><br><br>`+divToPrint.innerHTML+`</center></body></html>`);
    newWin.document.close();
    setTimeout(function(){newWin.close();},10);

  });

});
</script>
