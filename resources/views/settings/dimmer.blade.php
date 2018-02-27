<script type="text/javascript">

$(document).ready(function(){

  dimmer = document.createElement("table");
  dimmer.style.width =  window.innerWidth + 'px';
  var body = document.body,
    html = document.documentElement;
  var height = Math.max( body.scrollHeight, body.offsetHeight,
                       html.clientHeight, html.scrollHeight, html.offsetHeight );
  dimmer.style.height = height + 1000+'px';
  dimmer.className = 'dimmer';

  var delete_box = document.getElementById("delete_box");
  		delete_box.style.top = window.innerHeight/2 - 200 + 'px';
  		delete_box.style.left = window.innerWidth/2 - 210 + 'px';
  var edit_box = document.getElementById("edit_box");
      edit_box.style.top = window.innerHeight/2 - 200 + 'px';
      edit_box.style.left = window.innerWidth/2 - 210 + 'px';

  //show edit form
  $('body').on('click', '.editLink', function(e){
    e.preventDefault();
    var edit_box = document.getElementById("edit_box");
    let id = $(this).data('id');
    $('#formtitle').html('Изменить '+$(this).data('name')+'<div id="toEdit" style="visibility: hidden; display:inline;">'+id+'</div>');

    dimmer.onclick = function(){
      document.body.removeChild(this);
      edit_box.style.visibility = 'hidden';
      document.body.setAttribute("style", "overflow-y: visible;");
      document.ontouchmove = function(e){ return true; }
    }

    document.body.appendChild(dimmer);
    document.body.setAttribute("style", "overflow-y: hidden;");
    document.ontouchmove = function(e){ e.preventDefault(); }
    edit_box.style.visibility = 'visible';
    var w = window.innerWidth;
    var h = window.innerHeight;
    if(h>w){
      edit_box.style.top = h/2 - 100 +'px';
      edit_box.style.left = w/2 - 170 + 'px';
    }else{
      @if(Request::is('setting/user'))
        edit_box.style.top = h/2 - 270 +'px';
      @else
        edit_box.style.top = h/2 - 170 +'px';
      @endif
      edit_box.style.left = w/2 - 210 + 'px';
    }

    return false;
  });

  //show delete form
  $('body').on('click', '.deleteLink', function(e){
    e.preventDefault();
    var delete_box = document.getElementById("delete_box");

		dimmer.onclick = function(){
			document.body.removeChild(this);
			delete_box.style.visibility = 'hidden';
			document.body.setAttribute("style", "overflow-y: visible;");
			document.ontouchmove = function(e){ return true; }
      $('.confirm_delete').data('id', "");
		}

		document.body.appendChild(dimmer);
		document.body.setAttribute("style", "overflow-y: hidden;");
    let id = $(this).data('id');
    $('.confirm_delete').data('id', id);
		document.ontouchmove = function(e){ e.preventDefault(); }
		delete_box.style.visibility = 'visible';
		var w = window.innerWidth;
		var h = window.innerHeight;
		if(h>w){
			delete_box.style.top = h/2 - 100 +'px';
			delete_box.style.left = w/2 - 170 + 'px';
			}else{
			delete_box.style.top = h/2 - 100 +'px';
			delete_box.style.left = w/2 - 210 + 'px';
		}

		return false;
  });

  $(body).on('click', '.cancel_delete', function(){
    document.body.removeChild(dimmer);
    delete_box.style.visibility = 'hidden';
    document.body.setAttribute("style", "overflow-y: visible;");
    document.ontouchmove = function(e){ return true; }
    $('.confirm_delete').data('id', "");
  });

  $(body).on('click', '.cancel_editform', function(){
    document.body.removeChild(dimmer);
    edit_box.style.visibility = 'hidden';
    document.body.setAttribute("style", "overflow-y: visible;");
    document.ontouchmove = function(e){ return true; }
    $('.confirm_delete').data('id', "");
  });

});

</script>
