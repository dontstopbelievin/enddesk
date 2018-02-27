<script type="text/javascript">
$(document).ready(function(){

  getItem();

  //get req from api
  function getItem(){
    $.ajax({
      url:'http://localhost/api/requests/'+{{$id}},
      //dataType: 'html',
    }).done(function(requests){

      let output = '';
      $.each(requests, function(key, request){
        output += '<table class="table_source">';
        output += '<tr><td>Категория</td><td>'+request.category.name+'</td></tr>';
        if(request.theme != null){ output += '<tr><td>Тема</td><td>'+request.theme+'</td></tr>';}
        output += '<tr><td>Сообщение</td><td>'+request.message+'</td></tr>';
        output += '<tr><td>Дата создания</td><td>'+request.created_at+'</td></tr>';
        output += '<tr><td>Приоритет</td><td>'+request.priority.name+'</td></tr>';
        output += '<tr><td>Статус</td><td>'+request.status.name+'</td></tr>';
        output += '<tr><td>Автор</td><td>'+request.username+'<br>'+request.email;
        output += '<br>кабинет '+request.cabinet;
        if(request.tel != null){ output += '<br>телефон '+request.tel+'</td></tr>';}
        output += '</table>';
      });

      $('#apiitems').html(output);
    });
  }

  //submit event
  $('#itemForm').on('submit', function(e){
    e.preventDefault();
    let  comment = $('#comment').val();
    updateItem(comment);
  });

  //update item using api
  function updateItem(comment){
      $.ajax({
        method:'POST',
        url:'http://localhost/api/requests/'+{{$id}},
        data: {status: '3', admin_id: {{Auth::id()}}, comment: comment, _method: 'PUT'}
      }).done(function(users){
        location.href="/home";
      });
  }

});
</script>
