<script type="text/javascript">
var cur_page = 1;
var timelapse = 5000;
var ordering = 'desc';
var sorting = 'requests.created_at';

$(document).ready(function(){
    setInitial();
    function setInitial(){
      $.ajax({
        url:'/api/users/'+{{Auth::id()}},
        success: function(requests){
          timelapse = requests.timelapse;
          $('#select_amount').val(requests.per_page);
          $('#set_timelapse').val(requests.timelapse);
          if( requests.showtag == 'all'){
            $('#indicator').text('все запросы:');
          }else{
            $('#indicator').text('мои запросы:');
          }
          getRequests(cur_page, sorting);
        }
      });
    }

  //get requests from api
  //when calling getRequests YOU NEED TO clear and null previous timer
  function getRequests(page, sorting){
    $.ajax({
      method: 'POST',
      url:'/api/requests',
      //dataType : 'html',
      data: {page: page, sorting: sorting, ordering: ordering, _method: 'GET'},
      success: function(requests){
        //$('#request_table').html(requests);

        var x = new Array(2), i=0; // x[0] = requests with pagination; x[0].data = requests; x[1] = statuses;
        $.each(requests, function(key, request){
          x[i] = request;
          i++;
        });

        // construct table
        cur_page = x[0].current_page;
        if(cur_page != 1){
          var iterator = (cur_page-1)*x[0].per_page+1;
        }else{
          var iterator = 1;
        }
        let output = '';
        output += `
            <table class="table_source text-center">
            <tr style="background-color:#ECECEC;">
            <th width=30px>No</th><th style="width:150px;">Категория<img data-sort="categories.name" src="/storage/images/filter-icon.png" class="filter_img" /></th><th style="width:120px">Тема</th><th style="width:400px">Запрос</th>
            <th style="width:90px">Дата создания<img data-sort="requests.created_at" src="/storage/images/filter-icon.png" class="filter_img" /></th><th style="width:100px">Приоритет<img data-sort="priorities.name" src="/storage/images/filter-icon.png" class="filter_img" /></th>
            <th style="width:120px">Статус<img data-sort="statuses.name" src="/storage/images/filter-icon.png" class="filter_img" /></th>
            <th style="min-width:100px">Автор</th>
            <!--имя емайл кабинет телефон-->
            </tr>
        `;

        if(x[0].data.length > 0){
          $.each(x[0].data, function(key, request){
              if(request.status.name == 'Сделано' && request.admin.showtag == 'all'){
                return true;
              }
              var d = new Date(request.created_at);
              var created_date = d.getDate()+'/'+d.getMonth()+'/'+d.getFullYear()+' '+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();

              if(iterator%2 == 0){
                output += '<tr style="text-align:center;background-color:#E0E0E0;border: 1px solid #D5B8B7;">';
              }else{
                output += '<tr style="text-align:center;background-color:white;border: 1px solid #D5B8B7;">';
              }
              output += '<td style="background-color:#F4F4F3;border: 1px solid #D5B8B7;">'+iterator+'</td><td>'+request.category.name+'</td><td>';
              if(request.theme != null){ output += request.theme;}
              output += '</td><td><div class="request_msg" data-id="'+request.id+'">'+request.message+'</div></td><td>'+created_date+'</td><td>'+request.priority.name+'</td>';

              //Status show algorithm; Static status names used here, dont change status names
              if({{Auth::id()}} == request.admin_id || request.status.name == 'Открыт'){
                switch (request.status.name) {
                  case 'Открыт':
                      output += '<td><select onchange="set_status('+request.id+')" id="'+request.id+'" class="my_selects">';
                      $.each(x[1], function(key, value){
                        if(value.id == request.status_id){
                          output += '<option selected value="'+value.id+'">'+value.name+'</option>';
                        }else{
                          output += '<option value="'+value.id+'">'+value.name+'</option>';
                        }
                      });
                      output += '</select></td>';
                      break;
                  case 'Сделано':
                      output += '<td>'+request.status.name+'<div class="adminborder" title="Комментарий: '+request.comment+'">'+request.admin.name+'</div></td>';
                      break;
                  default:
                      output += '<td><select onchange="set_status('+request.id+')" id="'+request.id+'" class="my_selects">';
                      $.each(x[1], function(key, value){
                        if(value.id == request.status_id){
                          output += '<option selected value="'+value.id+'">'+value.name+'</option>';
                        }else{
                          output += '<option value="'+value.id+'">'+value.name+'</option>';
                        }
                      });
                      output += '</select><div class="adminborder">'+request.admin.name+'</div></td>';
                }
              }else{
                if(request.admin != null){
                  // neet to add edit for admin
                  @if(Auth::user()->usertype_id == '1' || Auth::user()->usertype_id == '2')
                    output += '<td><select onchange="set_status('+request.id+')" id="'+request.id+'" class="my_selects">';
                    $.each(x[1], function(key, value){
                      if(value.id == request.status_id){
                        output += '<option selected value="'+value.id+'">'+value.name+'</option>';
                      }else{
                        output += '<option value="'+value.id+'">'+value.name+'</option>';
                      }
                    });
                    output += '</select><div class="adminborder">'+request.admin.name+'</div></td>';
                  @else
                    output += '<td>'+request.status.name+'<div class="adminborder">'+request.admin.name+'</div></td>';
                  @endif
                }else{
                  output += '<td>'+request.status.name+'</td>';
                }
              }
              //end of algorithm

              output += '<td>'+request.username+'<br>'+request.email;
              if(request.cabinet != null){ output += '<br>кабинет '+request.cabinet;}
              if(request.tel != null){ output += '<br>телефон '+request.tel;}
              output += '</td></tr>';
              iterator++;
          });
        }else{
          output += '<tr><td colspan=6><strong>Список пуст.</strong></td></tr>';
        }

        output += '</table>';

        //PAGINATION START
        output += `
        <div class="pagination-wrap">
				<div class="counter"> Страница `+x[0].current_page+` из `+x[0].last_page+`</div>
				<ul class="pagination">
				<li><a title="В начало" style="cursor:pointer" class="to_beginning">В начало</a></li>`; // onclick="load_DB(1,'+$set_amount+')
    		if(x[0].current_page<=3){
    			var curr_p = 1;
    			if(x[0].last_page > 5){
    				for (i = 0; i < 5; i++) {
    					if(curr_p == x[0].current_page){
    						output += '<li class="active"><a id="cur_p">'+curr_p+'</a></li>';
    					}
    					else{
    						output += '<li><a title="'+curr_p+'" style="cursor:pointer" id="'+curr_p+'" class="to_page">'+curr_p+'</a></li>'; // onclick="load_DB('+curr_p+','+$set_amount+')
    					}
    					curr_p++;
    				}
    			}else{
    				for (i = 0; i < x[0].last_page; i++) {
    					if(curr_p==x[0].current_page){
    						output += '<li class="active"><a id="cur_p">'+curr_p+'</a></li>';
    					}
    					else{
    						output += '<li><a title="'+curr_p+'" style="cursor:pointer" id="'+curr_p+'" class="to_page">'+curr_p+'</a></li>'; // onclick="load_DB('+curr_p+','+$set_amount+')
    					}
    					curr_p++;
    				}
    			}
    		}
    		else{
    			if(x[0].last_page == 4){
    				curr_p=1;
    			}else{curr_p = x[0].current_page-2;}

    			if(x[0].last_page > 5){
    				for (i = 0; i < 5; i++) {
    					if(curr_p > x[0].last_page){break;}
    					if(curr_p == x[0].current_page){
    						output += '<li class="active"><a id="cur_p">'+curr_p+'</a></li>';
    					}
    					else{
    						output += '<li><a title="'+curr_p+'" style="cursor:pointer" id="'+curr_p+'" class="to_page">'+curr_p+'</a></li>'; // onclick="load_DB('+curr_p+','+$set_amount+')
    					}
    					curr_p++;
    				}
    			}else{
    				for (i = 0; i < x[0].last_page; i++) {
    					if(curr_p > x[0].last_page){break;}
    					if(curr_p == x[0].current_page){
    						output += '<li class="active"><a id="cur_p">'+curr_p+'</a></li>';
    					}
    					else{
    						output += '<li><a title="'+curr_p+'" style="cursor:pointer" id="'+curr_p+'" class="to_page">'+curr_p+'</a></li>'; // onclick="load_DB('+curr_p+','+$set_amount+')
    					}
    					curr_p++;
    				}
    			}
    		}
    		output +=	`<li><a title="В конец" style="cursor:pointer" id="`+x[0].last_page+`" class="to_ending">В конец</a></li>
    				</ul></div>`; //load_DB('+$number_ofp+','+$set_amount+')
        //PAGINATION END

        $('#request_table').html(output);
        timer = window.setTimeout(getRequests, timelapse, cur_page, sorting);
      }
    });
    //end of ajax
  }

  // pagination first page
  $('body').on('click', '.to_beginning', function(e){
    e.preventDefault();
    if(timer){clearTimeout(timer); timer = null;}
    getRequests(1, sorting);
  });
  // pagination last page
  $('body').on('click', '.to_ending', function(e){
    e.preventDefault();
    if(timer){clearTimeout(timer); timer = null;}
    getRequests(this.id, sorting);
  });
  // pagination to page number #
  $('body').on('click', '.to_page', function(e){
    e.preventDefault();
    if(timer){clearTimeout(timer); timer = null;}
    getRequests(this.id, sorting);
  });

  //edit status listener
  $('body').on('change', '.my_selects', function(e){
    e.preventDefault();
    if(this.value == 3){
      location.href = "/close_request/"+this.id;
    }else {
      editStatus(this.id, this.value);
    }
  });

  //edit status api
  function editStatus(rid, status){
      $.ajax({
        method:'POST',
        url:'/api/requests/'+rid,
        data: {status: status, admin_id: {{Auth::id()}}, _method: 'PUT'}
      }).done(function(user){
        if(timer){clearTimeout(timer); timer = null;}
        getRequests(cur_page, sorting);
      });
  }

  //show all requets
  $('body').on('click', '.showtag_all', function(e){
    e.preventDefault();
    editShowtag('all');
  });
  //show my requests
  $('body').on('click', '.showtag_mine', function(e){
    e.preventDefault();
    editShowtag('mine');
  });

  //edit showtag using api
  function editShowtag(showtag){
      $.ajax({
        method:'POST',
        url:'/api/usersextended/'+{{Auth::id()}},
        data: {func: 'showtag', showtag: showtag, _method: 'PUT'}
      }).done(function(user){
        if(timer){clearTimeout(timer); timer = null;}
        getRequests(cur_page, sorting);
        if( showtag == 'all'){
          $('#indicator').text('все запросы:');
        }else{
          $('#indicator').text('мои запросы:');
        }
      });
  }

  //edit per_page on user
  $('body').on('change', '.my_select_reqs', function(e){
    e.preventDefault();
    editPer_page(this.value);
  });

  //edit per_page on user
  function editPer_page(per_page){
      $.ajax({
        method:'POST',
        url:'/api/usersextended/'+{{Auth::id()}},
        data: {func: 'per_page', per_page: per_page, _method: 'PUT'}
      }).done(function(user){
        if(timer){clearTimeout(timer); timer = null;}
        getRequests(1, sorting);
      });
  }

  //edit timelapse on user
  $('body').on('change', '.my_select_timelapse', function(e){
    e.preventDefault();
    editTimelapse(this.value);
  });

  //edit timelapse on user
  function editTimelapse(timelapse_t){
      $.ajax({
        method:'POST',
        url:'/api/usersextended/'+{{Auth::id()}},
        data: {func: 'timelapse', timelapse: timelapse_t, _method: 'PUT'}
      }).done(function(user){
        if(timer){clearTimeout(timer); timer = null;}
        timelapse = timelapse_t;
        getRequests(cur_page, sorting);
      });
  }

  $('body').on('click', '.filter_img', function(e){
    e.preventDefault();
    if(ordering == 'desc'){
      ordering = 'asc';
    }else{
      ordering = 'desc';
    }
    sorting = $(this).data('sort');
    if(timer){clearTimeout(timer); timer = null;}
    getRequests(cur_page, sorting);
  });

  $('body').on('click', '.imgbut', function(e){
    e.preventDefault();
    location.href = "/export_to_excel";
  });

  $('body').on('click', '.request_msg', function(e){
    e.preventDefault();
    location.href = "/print_request/"+$(this).data('id');
  });
});
</script>
