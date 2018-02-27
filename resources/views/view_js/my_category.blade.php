<script type="text/javascript">
$(document).ready(function(){

  getItems();

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
        url:'http://localhost/api/categories',
        data: {name: name}
      }).done(function(category){
        location.reload();
      });
  }

  //delete item through api
  $('body').on('click', '.confirm_delete', function(e){
    e.preventDefault();

    let id = $(this).data('id');
    $.ajax({
      method:'POST',
      url:'http://localhost/api/categories/'+id,
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
        url:'http://localhost/api/categories/'+id,
        data: {name: name, _method: 'PUT'}
      }).done(function(category){
        location.reload();
      });
  }

  //get items from api
  function getItems(){
    $.ajax({
      url:'http://localhost/api/categories'
    }).done(function(categories){
        let output = '<table class="table_source" style="background-color:white;border-collapse: initial;table-layout:auto"><tr>';
        output += '<td><strong>№</strong></td><td><strong>Название</strong></td><td><strong>Действие</strong></td></tr>';
        if(categories.length > 0){
          var index=1;
          $.each(categories, function(key, category){
              output += '<tr><td>'+index+'</td>';
              output += `<td>${category.name}</td>
                        <td><a href="#" class="deleteLink" data-id="${category.id}">Удалить</a>
                        <a href="#" class="editLink" data-name="${category.name}" data-id="${category.id}">Изменить</a></td>
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
