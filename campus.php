<?php
include_once '../../secure_login/includes/functions.php';
sec_session_start();
if(($_SESSION['is_doe']==false) && ($_SESSION['is_principal']==false) && ((!isset($_SESSION['is_doe'])) || (!isset($_SESSION['is_principal']))))
{
    Header('Location:../../secure_login/'); 
}
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
    <link rel="icon" type="image/png" href="assets/img/big-logo.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>Sri Chaitanya</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
  

    <!-- Bootstrap core CSS     -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="../assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Light Bootstrap Table core CSS    -->
    <link href="../assets/css/light-bootstrap-dashboard.css" rel="stylesheet"/>


    <link href="../assets/css/demo.css" rel="stylesheet" />
<link rel="stylesheet" href="aria-progressbar.css" />

    <!--     Fonts and icons     -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="../assets/css/pe-icon-7-stroke.css" rel="stylesheet" />
   
<style type="text/css">
.panel-heading{
   background-color: #f5f5f5;
   color: black;
}
.progress {
  border-color: silver;
  border-radius: 0.35rem;
  border-width: 0.05rem;
  height: 3rem;
}

.progress__bar {
  /*background-color: #5cb85c;*/
  border-radius: 0.35rem;
  border-width: 0;
  height: 3rem;
  -webkit-transition: 0.1s width ease;
  -o-transition: 0.1s width ease;
  transition: 0.1s width ease;
}
.pagination {
    display: inline-block;
}

.pagination a {
    color: black;
    float: left;
    padding: 8px 16px;
    text-decoration: none;
    transition: background-color .3s;
}

.pagination a.active {
    background-color: #9928d1;
    color: white;
}

.pagination a:hover:not(.active) {background-color: #ddd;}

.form-control {
    background-color: #FFFFFF;
    border: 1px solid #E3E3E3;
    border-radius: 4px;
    color: #565656;
    padding: 8px 12px;
    height: 27px;
    -webkit-box-shadow: none;
    box-shadow: none;
}
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    padding: 2px;
    line-height: 1.42857143;
    vertical-align: top;
    border-top: 1px solid #ddd;
}
.table > thead > tr > th {
   background-color: #eaeaea ! important;
}
.btn{
    padding:3px 10px 3px 10px;
}
.modal-header{
    background-color: #1DC7EA ! important;
}
.card {
    border-radius: 4px;
    box-shadow: 0 3px 12px grey ! important;
    background-color: #FFFFFF;
    margin-bottom: 30px;
}


.progress-bar-success {
	
    background-color: #5cb85c;
    background: #5cb85c;
    background: -webkit-linear-gradient(#12f912,#5cb85c);
    background: -o-linear-gradient(#12f912,#5cb85c);
    background: -moz-linear-gradient(#12f912,#5cb85c);
    background: linear-gradient(#12f912,#5cb85c);
}
.progress__bar {
	
	
    background-color: #5cb85c;
    background: #5cb85c;
    background: -webkit-linear-gradient(#12f912,#5cb85c);
    background: -o-linear-gradient(#12f912,#5cb85c);
    background: -moz-linear-gradient(#12f912,#5cb85c);
    background: linear-gradient(#12f912,#5cb85c);
}

.info-input{
    border: 0px;
    padding-left: 1%;
    color: red;
    font-weight: 600;
}
#sel1{
    height: 35px;
}
</style>

</head>
<body onload='fetchdata("http://175.101.3.68/ipe/public/api/sectionlist")'>
<!-- info modal -->
 <!-- Modal -->

  <div class="modal fade" id="info" role="dialog" style="z-index:10000;">
    <div class="modal-dialog modal-sm">
      <div class="modal-content" style="left: -139%;width: 184%;">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Info File</h4>
        </div>
        <div class="modal-body" style="height: 90px;">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Subject Name</label>
                                                <input type="text" class="form-control" placeholder="Last Name" value="Maths">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Q No Start</label>
                                                <input type="text" class="form-control" placeholder="Last Name" value="1">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Q No End</label>
                                                <input type="text" class="form-control" placeholder="Last Name" value="30">
                                            </div>
                                        </div>
        </div>
        <div class="modal-footer">
           <button type="submit" class="btn btn-info btn-fill pull-right" data-dismiss="modal">Save</button>
        </div>
      </div>
    </div>
  </div>

<!-- info modal -->
 <!-- Modal -->
  <div class="modal fade" id="Mark" role="dialog" style="z-index:1000000000;">
    <div class="modal-dialog modal-sm">
      <div class="modal-content" style="left: 52%;width: 184%;">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Mark File</h4>
        </div>
        <div class="modal-body" style="height: 90px;">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Qno From</label>
                                                <input type="text" class="form-control" placeholder="Last Name" value="1">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Q No To</label>
                                                <input type="text" class="form-control" placeholder="Last Name" value="10">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>+ve Mark</label>
                                                <input type="text" class="form-control" placeholder="Last Name" value="4">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>-ve Mark</label>
                                                <input type="text" class="form-control" placeholder="Last Name" value="1">
                                            </div>
                                        </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-info btn-fill pull-right" data-dismiss="modal">Save</button>
        </div>
      </div>
    </div>
  </div>


<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content" style="    width: 125%;left: -13%;">
        <div class="modal-header">
          <h4 class="modal-title" style="display:inline;">Student Subjectwise Marks List</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <button type="submit" id="skip" class="btn btn-danger btn-fill" data-dismiss="modal" disabled="" onclick="update(1,'all','n')" style="float: right;">SKIP ALL</button> 
          <button type="submit" id="notify" style="float: right;" class="btn btn-warning btn-fill" data-dismiss="modal" onclick="notify()">NOTIFY</button>   
          <input type="hidden" name="notifytext" id="notifytext">
        </div>
        <div class="modal-body">
         <div class="row">

            <div class="col-md-12">
                 <div class="">
                           
                                <!-- <h4 style="display:inline;" class="title">Subject Details</h4> -->
                             
                            <div class="content table-responsive ">
                                <table class="table table-hover" id="tab">
                                    <thead class="subhead">
                                       
                                        
                                        
                                    </thead>
                                    <tbody class="student_list">
                                       
                                    </tbody>
                                </table>
                                <div class="student_page">
 
                                </div>
                            </div>
                        </div>
            </div>



            
          </div>

          
        </div>
        <div class="modal-footer">
             <button type="submit" class="btn btn-info btn-fill pull-right" data-dismiss="modal">CLOSE</button>
          
        </div>
      </div>
    </div>
  </div>
  
  <!-- Result Modal Start-->
  <!-- Modal -->
  <div class="modal fade" id="display_result_modal" role="dialog">
    
  </div>
  <!-- Result Modal Ends -->
  
    <div class="modal fade" id="imk_modal_id" role="dialog">
   
  </div>
  
  
  

<div class="wrapper">
    <div class="sidebar menu-width" id="sidebar-id" data-color="purple" data-image="../assets/img/sidebar-5.jpg">

    <!--

        Tip 1: you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple"
        Tip 2: you can also add an image using data-image tag

    -->

        <div class="sidebar-wrapper">
            <div class="logo">
               <img src="../assets/img/big-logo.png" class="logo-display display-none"/>
                <a href="http://www.creative-tim.com" class="simple-text display-none" >
                    Sri Chaitanya
                </a>
                <div class="minimize display-none padding-left-8 pointer" id="slide_left"><i class="fa fa-arrow-left" style="font-size: 20px;" ></i></div>
                      <div class="maximize display-block padding-left-8 pointer" id="slide_right"><i class="fa fa-arrow-right" style="font-size: 20px;"></i></div>
            </div>
           <ul class="nav">
                <li >
                    <a href="../1_dashboard/">
                        <i class="fa fa-tachometer" title="Dashboard"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                
                <li class="active">
                    <a href="../3_view_created_exam/">
                        <i class="pe-7s-note2"  title="View Exam"></i>
                        <p>View Created Exam</p>
                    </a>
                </li>
                 <li>
                    <a href="">
                        <i  class="fa fa-bar-chart" title="Reports"></i>
                        <p>Reports</p>
                    </a>
                </li>
                
                <li class="active-pro">
                    <a href="#">
                        <i class="pe-7s-rocket"></i>
                        <p>DEMO</p>
                    </a>
                </li>
            </ul>
    	</div>
    </div>

    <div class="main-panel main-panel-width"  id="main-panel-id">
        <nav class="navbar navbar-default navbar-fixed">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Exam</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-left">
                        <li>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-dashboard"></i>
                            </a>
                        </li>
                        <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-globe"></i>
                                    <b class="caret"></b>
                                    <span class="notification">5</span>
                              </a>
                              <ul class="dropdown-menu">
                                <li><a href="#">Notification 1</a></li>
                                <li><a href="#">Notification 2</a></li>
                                <li><a href="#">Notification 3</a></li>
                                <li><a href="#">Notification 4</a></li>
                                <li><a href="#">Another notification</a></li>
                              </ul>
                        </li>
                        <li>
                           <a href="">
                                <i class="fa fa-search"></i>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                        <li>
                           <a>
                               <i class="fa fa-user-circle" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li>
                           <a style="padding-left: 0px;margin-left: -4%;">
                               <?php echo $_SESSION['employee_name']; ?>
                            </a>
                        </li>
                        
                        <li>
                            <a href="../../secure_login/logout/">
                                <i class="fa fa-power-off" aria-hidden="true"></i>&nbsp;Log out
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12" style="width: 100%;padding:0px;">
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="list panel-group" id="accordion" role="tablist" aria-multiselectable="true">
               
            </div>

<div class="pagination">
 
</div>

        </div>
    </div>
</div>

                    </div>


                 


                </div>
            </div>
        </div>

        <footer class="footer">
            <div class="container-fluid">
                <nav class="pull-left">
                    <ul>
                        <li>
                            <a href="#">
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Company
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Portfolio
                            </a>
                        </li>
                        <li>
                            <a href="#">
                               Blog
                            </a>
                        </li>
                    </ul>
                </nav>
                <p class="copyright pull-right">
                   &copy; 2018 <a href="http://srichaitanya.net/">Sri Chaitanya Educational Institutions</a>
                </p>
            </div>
        </footer>


    </div>
</div>



	<div id="upload_div" class="hidden" style="position: fixed;top: 18%;z-index: 9999;left: 28%;background-color: #F0F0F0;width: 50%;min-height: 50%;border: 2px solid grey;">
	

	</div>
	<div id="opacity_div" class="hidden" style="position: fixed;top: 0%;z-index: 9998;opacity: 0.7;background-color: grey;width: 100%;min-height: 100%;border: 2px solid grey;"></div>
	
	
	<!-- PROCESS OVERLAY STARTS-->
	<div id="opacityo_div2" class="hidden" style="position: fixed;top: 5%;z-index: 9999;left: 5%;background-color: #F0F0F0;width: 90%;min-height: 80%;border: 2px solid grey;">
	
	
	             

             <p style="background-color: #7e7eef;color: white; text-shadow: 2px 2px 4px #000000;font-size: 24px;padding: 1%;">  Invalid USN Numbers:  </p>
                    <div class="form-group">
					
					<!--<div id="error_content" style="max-height:500px;overflow-y:scroll;" > -->
                    <div id="error_content" style="max-height:500px;overflow-y:scroll;" > 
					</div>
					
                       
                        
				</b>
				<!--<div style="margin-left:88%;"><br><button type="button" class="btn btn-primary">Cancel</button></div><br>-->
                </div>
	</div>
	
	<!--PROCESS OVERLAY ENDS -->
	  <!-- Modal -->
<div id="display_all_details" class="modal fade" role="dialog" style="    height: 600px;">
  <div class="modal-dialog" style="max-height: 550px;margin-top:5%;">

    <!-- Modal content-->
    <div class="modal-content" style="    max-height: 550px;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Exam Details</h4>
      </div>
      <div class="modal-body">
        <div id="display_contents" style="    height: 350px;
    overflow-y: scroll;"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        
      </div>
    </div>

  </div>
</div> 

   <!-- Modal -->
<div id="display_merged_details" class="modal fade" role="dialog" style="    height: 600px;">
  <div class="modal-dialog" style="    height: 490px;    display: block;    margin-left: 14%;">

    <!-- Modal content-->
    <div class="modal-content" style=" max-height: 500px;    margin-top: 13%;    width: 70em;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Exam Details</h4>
      </div>
      <div class="modal-body" style="overflow-y: scroll; ">
        <div id="display_contents_merged" style="    height: 350px;"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>  
	
	
<!-- 	
<?php
require("../000_main_includes/common_page.php");
function get_version()
{
   return $mtime = filemtime('custom.js');
}
?> -->
</body>

    <!--   Core JS Files   -->
    <script src="../assets/js/jquery-1.10.2.js" type="text/javascript"></script>
     
    <script src="../assets/js/bootstrap.min.js" type="text/javascript"></script>

    <!--  Checkbox, Radio & Switch Plugins -->
    <script src="../assets/js/bootstrap-checkbox-radio-switch.js"></script>

    <!--  Charts Plugin -->
    <script src="../assets/js/chartist.min.js"></script>

    <!--  Notifications Plugin    -->
    <script src="../assets/js/bootstrap-notify.js"></script>

    <!--  Google Maps Plugin    -->
  

    <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
    <script src="../assets/js/light-bootstrap-dashboard.js"></script>

    <!-- Light Bootstrap Table DEMO methods, don't include it in your project! -->
    <script src="../assets/js/demo.js"></script>
	<!-- <script src="custom.js?v=<?php echo get_version();?>"></script> -->
	  
<script type="text/javascript">

    // $(document).ready(function(){

function fetchdata(ul){
    // alert(ul);
    var url="http://175.101.3.68/ipe/public/api/studlist";
        $.ajax({
            type: 'GET',
            data:{campus_id:<?php echo $_SESSION['campus_id']; ?>,exam_id:<?php echo $_GET['exam_id']; ?>},
            url:ul,
            success:function(data){
              
         var output="";
              $.each(data.data, function(index, value) {     
      
        output += ' <div class="panel panel-default"><a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse'+index+'" aria-controls="collapse'+index+'"><div class="panel-heading" role="tab" id="heading'+index+'" ><h4 class="panel-title">   SECTION_ID:'+value.SECTION_ID+'    </h4></div></a><div id="collapse'+index+'" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading'+index+'">                        <div class="panel-body">                            <p> '+value.SECTION_ID+'   &nbsp;&nbsp;&nbsp;  '+value.section_name+' &nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" onclick="call(\''+url+'\','+value.SECTION_ID+')">Status</button></p></div></div></div>';
      
        }); 
            var paginate='';
            paginate+="<ul class='pagination'>";
                paginate+="<li><a href='#' onclick='fetchdata(\""+data.first_page_url+"\");'><<</a></li>";
                paginate+="<li ><a onclick='fetchdata(\""+data.prev_page_url+"\")'><</a></li>";
                paginate+="<li ><a onclick='fetchdata(\""+data.next_page_url+"\")'>></a></li>";
                paginate+="<li><a href='#' onclick='fetchdata(\""+data.last_page_url+"\")'>>></a></li>";
            paginate+="</ul>";
                  $('.pagination').html(paginate);
                 $('.list').html(output);
            }
        });
    return true;
}
 function call(ul,SECTION_ID){
   document.getElementById('notifytext').value=SECTION_ID;
   $.ajax({
            type: 'GET',
            data:{SECTION_ID:SECTION_ID,exam_id:<?php echo $_GET['exam_id']; ?>},
            url:ul,
            success:function(data){
              
         var output="";
              $.each(data.Student.data, function(index, value) {     
      
        output += '<tr><td><input type="checkbox" id="'+index+'" onclick="changecheck('+index+')"/></td><td>'+value.ADM_NO+'</td><td>'+value.NAME+'</td><td>'+value.PHYSICS+'</td><td>'+value.CHEMISTRY+'</td><td>'+value.MATHEMATICS+'</td><td>'+value.BIOLOGY+'</td><td>'+value.BOTANY+'</td><td>'+value.ZOOLOGY+'</td><td>'+value.ENGLISH+'</td><td> '+value.GK+'</td><td>'+data.end[0].last_date_to_upload+'</td><td> <button type="submit" id="s'+index+'" disabled class="btn btn-info btn-fill" onclick="update('+value.sl+','+value.sl+','+index+')">SKIP</button></td></tr>';
        //data-dismiss="modal"
      
        }); 
              var output1='<th><input type="checkbox" id="selectAll" onclick="skip(this)"/></th><th>ADM_NO</th><th>NAME</th>';
              $.each(data.Subject, function(index, value) {  
              if(value.Field=='PHYSICS'||value.Field=='CHEMISTRY'||value.Field=='MATHEMATICS'||value.Field=='BIOLOGY'||value.Field=='BOTANY'||value.Field=='ZOOLOGY'||value.Field=='ENGLISH'||value.Field=='GK')        
        output1 += '<th>'+value.Field+'</th>';
      
        }); 
              output1+='<th>LASTDATE</th><th>Action</th>';

            var paginate='';
            paginate+="<ul class='pagination'>";
                paginate+="<li><a href='#' onclick='call(\""+data.Student.first_page_url+"\","+SECTION_ID+");'><<</a></li>";
                paginate+="<li ><a onclick='call(\""+data.Student.prev_page_url+"\","+SECTION_ID+")'><</a></li>";
                paginate+="<li ><a onclick='call(\""+data.Student.next_page_url+"\","+SECTION_ID+")'>></a></li>";
                paginate+="<li><a href='#' onclick='call(\""+data.Student.last_page_url+"\","+SECTION_ID+")'>>></a></li>";
            paginate+="</ul>";
                  $('.student_page').html(paginate);
                 $('.student_list').html(output);
                 $('.subhead').html(output1);
            }
        });
    return true;


 }

  function skip(a){
     $(a).closest('table').find('td input:checkbox').prop('checked', a.checked);
     if(a.checked)
       $('#skip').prop('disabled', false);
   if(!a.checked)
       $('#skip').prop('disabled', true);
  }
  function update(b,a,c){
    
    alert("skipped successfully");
   $.ajax({
            type: 'GET',
            data:{sl:b,check:a},
            url:"http://175.101.3.68/ipe/public/api/updatemanage",
            success:function(data){
              
         var output="";
              $.each(data, function(index, value) {     
      
        output += '';
        //data-dismiss="modal"
      
        });
            }
        });
    return true;

  }
 function changecheck(c){
    var text='#s'+c;
    $(text).prop('disabled',false);
 }
 function notify(){
    var section_id=$('#notifytext').val();
     $.ajax({
            type: 'GET',
            data:{
                SECTION_ID:section_id,
                exam_id:<?php echo $_GET['exam_id']; ?>
            },
            url:"http://175.101.3.68/ipe/public/api/notify",
            success:function(data){
                  $.each(data.Subject, function(index, value) {     
                     $.ajax({
                        type: 'GET',
                        data:{SECTION_ID:section_id},
                        url:"http://smsc.vianett.no/v3/send.ashx?src="+value[0].MOBILENO+"&dst="+value[0].MOBILENO+"&msg="+data.Result[0].ADM_NO+','+data.Result[1].ADM_NO+'_upload_these_student_details'+"&username=muthumaharajan1992@gmail.com&password=bawq9",
                        success:function(data){                        
                            if(data=='200|OK')
                          alert('Message send to all employee');
                        }

                        });
                    });
            }
        });
 }
</script>


</html>
