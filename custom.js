   // $(document).ready(function(){

function fetchdata(ul){
    // alert(ul);
        $.ajax({
            type: 'GET',
            data:{campus_id:<?php echo $_SESSION['campus_id']; ?>},
            url:ul,
            success:function(data){
                // alert(data.campus_id);
         var output="";
              $.each(data.Employee.data, function(index, value) {     
      
        output += '<tr><td>'+ value.PAYROLL_ID +'</td><td>'+ value.NAME + value.SURNAME + value.USER_NAME +'</td><td>'+ value.SUBJECT +'</td><td>'+ value.SUBJECT +'</td><td><div class="center"><button data-toggle="modal" data-target="#squarespaceModal" data-name="'+ value.PAYROLL_ID +'" class="" style="background: none;border: none"><i class="fa fa-pencil"></i></button></div></td></tr>';
      
        }); 
            var paginate='';
            paginate+="<ul class='pagination'>";
                paginate+="<li><a href='#' onclick='fetchdata(\""+data.Employee.first_page_url+"\");'>first</a></li>";
                paginate+="<li><a href='#' onclick='fetchdata(\""+data.Employee.last_page_url+"\")'>last</a></li>";
                paginate+="<li ><a onclick='fetchdata(\""+data.Employee.next_page_url+"\")'>next</a></li>";
                paginate+="<li ><a onclick='fetchdata(\""+data.Employee.prev_page_url+"\")'>pre</a></li>";
            paginate+="</ul>";
                  $('.page').html(paginate);
                 $('.list').html(output);
                 $('#subject').empty();$('#section').empty();
                 $.each(data.Subject, function(key, value) {   
                     $('#subject')                      
                         .append($("<option></option>")
                                    .attr("value",value.subject_id)
                                    .text(value.subject_name)); 
                });
                 $.each(data.Section, function(key, value) {   
                     $('#section')
                       
                         .append($("<option></option>")
                                    .attr("value",value.SECTION_ID)
                                    .text(value.section_name)); 
                });
            }

            // error: function (xhr) {
            //     var err = JSON.parse(xhr.responseText);
            //     alert(err.error);
            //     }
        });
    return true;
}
   
// });
$(function () {
  $('#squarespaceModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var code = button.data('name'); 
    subset(code);
    $('#code').text(code);
     $('.payroll').val(code);
  });
});
function subset(code){
      $.ajax({
            type: 'GET',
            data:{PAYROLL_ID:code},
            url:"http://175.101.3.68/ipe/public/api/subjectlist",
            success:function(data){
               
         var output="";
              $.each(data, function(index, value) {                                   
               
      
        output += '<tr><td>'+ value.subject_name +'</td><td>'+ value.section_name +'</td><td><div class="center"><button data-toggle="modal" data-target="#squarespaceModal" data-name="'+ value.EMPLOYEE_ID +'" class="" style="background: none;border: none"><i class="fa fa-pencil"></i></button><button data-toggle="modal" data-target="#squarespaceModal" data-name="'+ value.EMPLOYEE_ID +'" class="" style="background: none;border: none"><i class="fa fa-trash"></i></button></div></td></tr>';
      
        }); 
           
                 $('.sub').html(output);
            }

            // error: function (xhr) {
            //     var err = JSON.parse(xhr.responseText);
            //     alert(err.error);
            //     }
        });
}
// });
$(function () {
  $('#add_sub').on('click', function (event) {
    var EMPLOYEE_ID=$('.payroll').val();
    var SUBJECT_ID=$('#subject').val();
    var SECTION_ID=$('#section').val();
     $.ajax({
            type: 'POST',
            data:{
                EMPLOYEE_ID:EMPLOYEE_ID,
                SUBJECT_ID:SUBJECT_ID,
                SECTION_ID:SECTION_ID,
            },
            url:"http://175.101.3.68/ipe/public/api/subjectadd",
            success:function(data){
               
         var output="";
              $.each(data, function(index, value) {                                   
               
      
        output += '<tr><td>'+ value.subject_name +'</td><td>'+ value.section_name +'</td><td><div class="center"><button data-toggle="modal" data-target="#squarespaceModal" data-name="'+ value.EMPLOYEE_ID +'" class="" style="background: none;border: none"><i class="fa fa-pencil"></i></button><button data-toggle="modal" data-target="#squarespaceModal" data-name="'+ value.EMPLOYEE_ID +'" class="" style="background: none;border: none"><i class="fa fa-trash"></i></button></div></td></tr>';
      
        }); 
           
                 $('.sub').html(output);
            }

            // error: function (xhr) {
            //     var err = JSON.parse(xhr.responseText);
            //     alert(err.error);
            //     }
        });
    // var button = $(event.relatedTarget);
    // var code = button.data('name'); 
    // subset(code);
    // $('#code').text(code);
    //  $('.payroll').val(code);
  });
});