<script type="text/javascript">
$(document).ready(function(){
  getCategory();
  getPriority();
  getStatuses();
  getAdmins();

  //submit event
  $('#itemForm').on('submit', function(e){
    e.preventDefault();

    var sortFrom = $('#sortFrom').val();
    sortFrom += ' 00:00:00';
    var sortTo = $('#sortTo').val();
    sortTo += ' 23:59:59';
    var  select_category = $('#select_category').val();
    var  select_status = $('#select_status').val();
    var  select_priority = $('#select_priority').val();
    var  select_admin = $('#select_admin').val();
    export_to_csv(sortFrom, sortTo, select_category, select_status, select_priority, select_admin);
  });

  //insert item using api
  function export_to_csv(sortFrom, sortTo, select_category, select_status, select_priority, select_admin){
      $.ajax({
        cache: false,
        method:'POST',
        url:'http://localhost/export_data',
        data: {sortFrom: sortFrom, sortTo: sortTo, select_category: select_category,
          select_priority: select_priority, select_status: select_status, select_admin: select_admin},
        //dataType: 'html',
      }).done(function(response){
         //alert(response);
         var a = document.createElement("a");
         a.href = response.file;
         a.download = response.name;
         document.body.appendChild(a);
         a.click();
         a.remove();
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

  //get statuses from api
  function getStatuses(){
    $.ajax({
      url:'http://localhost/api/statuses'
    }).done(function(selectValues){
      $.each(selectValues, function(key, value) {
        $('#select_status').append($("<option></option>").attr("value",value.id).text(value.name));
      });
    });
  }

  //get admins from api
  function getAdmins(){
    $.ajax({
      url:'http://localhost/api/users'
    }).done(function(selectValues){
      $.each(selectValues, function(key, value) {
        $('#select_admin').append($("<option></option>").attr("value",value.id).text(value.name));
      });
    });
  }

});
</script>
