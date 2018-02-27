<script type="text/javascript">
$(document).ready(function(){
  getCategory();
  getPriority();

  //add request
  $('#itemForm').on('submit', function(e){
    e.preventDefault();

    let  name = $('#name').val();
    let  email = $('#email').val();
    var  select_category = $('#select_category').val();
    let  theme = $('#theme').val();
    var  select_priority = $('#select_priority').val();
    let  cabinet = $('#cabinet').val();
    let  tel = $('#tel').val();
    let  message = $('#message').val();
    addItem(name, email, select_category, theme, select_priority, cabinet, tel, message);
  });

  //add request using api
  function addItem(name, email, select_category, theme, select_priority, cabinet, tel, message){
      $.ajax({
        method:'POST',
        url:'http://localhost/api/requests',
        data: {name: name, email: email, select_category: select_category, theme: theme,
          select_priority: select_priority, cabinet: cabinet, tel: tel, message: message}
      }).done(function(users){
        location.reload();
      });
  }

  //get categories from api
  function getCategory(){
    $.ajax({
      url:'http://localhost/api/categories'
    }).done(function(selectValues){
      $.each(selectValues, function(key, value) {
        $('#select_category').append($("<option></option>").attr("value",value.id).text(value.name));
      });
    });
  }

  //get priorities from api
  function getPriority(){
    $.ajax({
      url:'http://localhost/api/priorities'
    }).done(function(selectValues){
      $.each(selectValues, function(key, value) {
        $('#select_priority').append($("<option></option>").attr("value",value.id).text(value.name));
      });
    });
  }
});
</script>
