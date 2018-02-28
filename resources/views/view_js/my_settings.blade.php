<script type="text/javascript">
$(document).ready(function(){

  //edit event listener
  $('#itemForm').on('submit', function(e){
    e.preventDefault();

    let id = $('#user_id').val();
    let  password = $('#password').val();
    let  password_confirmation = $('#password_confirmation').val();
    editItem(id, password, password_confirmation);
  });

  //edit item using api
  function editItem(id, password, password_confirmation){//alert(id+' '+text+' '+body);
      $.ajax({
        method:'POST',
        url:'/api/usersextended/'+id,
        data: {func: 'changePassword', password: password, password_confirmation: password_confirmation, _method: 'PUT'}
      }).done(function(user){
        location.reload();
      });
  }

  $(".menu_first").css("background-color", "#0066cc");

  $('body').on('click', '.menu_first', function(){
    window.location.replace('1');
    $(".menu_second").css("background-color", "#0088cc");
    $(".menu_first").css("background-color", "#0066cc");
    var output = "";
    output = `
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
            `;
    $('.content').html(output);
  });
  $('body').on('click', '.menu_second', function(){
    $(".menu_first").css("background-color", "#0088cc");
    $(".menu_second").css("background-color", "#0066cc");
    var output = "";
    output = `
            <p><a class="btn btn-primary" href="/setting/user">Управление Учетными записями</a></p>
            <p><a class="btn btn-primary" href="/setting/priority">Управление Приоритетами</a></p>
            <p><a class="btn btn-primary" href="/setting/category">Управление Категориями</a></p>
            <p><a class="btn btn-primary" href="/setting/status">Управление Статусами</a></p>
            `;
    $('.content').html(output);
  });

  @if(!empty($menu) && $menu == '2')
    $(".menu_first").css("background-color", "#0088cc");
    $(".menu_second").css("background-color", "#0066cc");
    var output = "";
    output = `
            <p><a class="btn btn-primary" href="/setting/user">Управление Учетными записями</a></p>
            <p><a class="btn btn-primary" href="/setting/priority">Управление Приоритетами</a></p>
            <p><a class="btn btn-primary" href="/setting/category">Управление Категориями</a></p>
            <p><a class="btn btn-primary" href="/setting/status">Управление Статусами</a></p>
            `;
    $('.content').html(output);
  @endif

});

</script>
