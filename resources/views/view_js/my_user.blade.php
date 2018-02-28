<script type="text/javascript">
$(document).ready(function(){

  getUserTypes();
  getItems();

  //get usertypes from api
  function getUserTypes(){
    $.ajax({
      url:'/api/usertypes'
    }).done(function(selectValues){
      $.each(selectValues, function(key, value) {
        if(value.id == '1'){return true;}
        $('#select_usertype').append($("<option></option>").attr("value",value.id).text(value.name));
        $('#select_usertype2').append($("<option></option>").attr("value",value.id).text(value.name));
      });
    });
  }

  //delete item through api
  $('body').on('click', '.confirm_delete', function(e){
    e.preventDefault();

    let id = $(this).data('id');
    $.ajax({
      method:'POST',
      url:'/api/users/'+id,
      data: {_method: 'DELETE'}
    }).done(function(category){
      location.reload();
    });
  });

  //edit event listener
  $('#itemFormEdit').on('submit', function(e){
    e.preventDefault();

    let id = parseInt($('#toEdit').html());
    let  name = $('#name2').val();
    let  usertype = $('#select_usertype2').val();
    let  password = $('#password2').val();
    let  password_confirmation = $('#password_confirmation2').val();
    editItem(id, name, usertype, password, password_confirmation);
  });

  //edit item using api
  function editItem(id, name, usertype, password, password_confirmation){//alert(id+' '+text+' '+body);
      $.ajax({
        method:'POST',
        url:'/api/users/'+id,
        data: {name: name, usertype: usertype, password: password, password_confirmation: password_confirmation, _method: 'PUT'}
      }).done(function(user){
        location.reload();
      });
  }

  //add event
  $('#itemForm').on('submit', function(e){
    e.preventDefault();

    let  name = $('#name').val();
    let  email = $('#email').val();
    let  usertype = $('#select_usertype').val();
    let  password = $('#password').val();
    let  password_confirmation = $('#password_confirmation').val();
    addItem(name, email, usertype, password, password_confirmation);
  });

  //add using api
  function addItem(name, email, usertype, password, password_confirmation){
      $.ajax({
        method:'POST',
        url:'/api/users',
        data: {name: name, email: email, usertype: usertype, password: password, password_confirmation: password_confirmation}
      }).done(function(users){
        location.reload();
      });
  }

  //get items from api
  function getItems(){
    $.ajax({
      url:'/api/users',
      //dataType: 'html',
    }).done(function(users){//alert(users);
      let output = '<table class="table_source" style="background-color:white;border-collapse: initial;table-layout:auto"><tr>';
      output += '<td><strong>№</strong></td><td><strong>Имя</strong></td><td><strong>E-mail</strong></td><td><strong>Вид пользователя</strong></td><td><strong>Действие</strong></td></tr>';
      if(users.length > 0){
        var index=1;
        $.each(users, function(key, user){
            output += '<tr><td>'+index+'</td>';
            output += `<td>${user.name}</td>
                      <td>${user.email}</td>
                      <td>${user.usertype.name}</td>
                      <td><a href="#" class="deleteLink" data-id="${user.id}">Удалить</a>
                      <a href="#" class="editLink" data-name="${user.name}" data-id="${user.id}">Изменить</a></td>
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
