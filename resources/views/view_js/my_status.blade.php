<script type="text/javascript">
$(document).ready(function(){

  getItems();

  //delete item through api
  $('body').on('click', '.confirm_delete', function(e){
    e.preventDefault();

    let id = $(this).data('id');
    $.ajax({
      method:'POST',
      url:'/api/statuses/'+id,
      data: {_method: 'DELETE'}
    }).done(function(category){
      location.reload();
    });
  });

  //edit event listener
  $('#itemFormEdit').on('submit', function(e){
    e.preventDefault();

    let id = parseInt($('#toEdit').html());
    let  name = $('#textEdit').val();

    editItem(name, id);
  });

  //edit item using api
  function editItem(name, id){//alert(id+' '+text+' '+body);
      $.ajax({
        method:'POST',
        url:'/api/statuses/'+id,
        data: {name: name, _method: 'PUT'}
      }).done(function(status){
        location.reload();
      });
  }

  //add event
  $('#itemForm').on('submit', function(e){
    e.preventDefault();

    let  name = $('#name').val();

    addItem(name);
  });
  //add item using api
  function addItem(name){
      $.ajax({
        method:'POST',
        url:'/api/statuses',
        data: {name: name}
      }).done(function(status){
        location.reload();
      });
  }

  //get items from api
  function getItems(){
    $.ajax({
      url:'/api/statuses'
    }).done(function(statuses){
    let output = '<table class="table_source" style="background-color:white;border-collapse: initial;table-layout:auto"><tr>';
    output += '<td><strong>№</strong></td><td><strong>Название</strong></td><td><strong>Действие</strong></td></tr>';
    if(statuses.length > 0){
      var index=1;
      $.each(statuses, function(key, status){
          output += '<tr><td>'+index+'</td>';
          output += `<td>${status.name}</td>
                    <td><a href="#" class="deleteLink" data-id="${status.id}">Удалить</a>
                    <a href="#" class="editLink" data-name="${status.name}" data-id="${status.id}">Изменить</a></td>
                    </tr>`;
          index++;
      });
    }else{
      output += '<tr><strong>Список пуст.</strong></tr>';
    }
    output += '</table>';
      $('#apiitems').append(output);
    });
  }
});

</script>
