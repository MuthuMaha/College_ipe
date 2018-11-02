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
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/animate.min.css" rel="stylesheet"/>
    <link href="../assets/css/light-bootstrap-dashboard.css" rel="stylesheet"/>
    <link href="../assets/css/demo.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="../assets/css/pe-icon-7-stroke.css" rel="stylesheet" />
<style type="text/css">

.table > thead > tr > th{
  background-color: #23343a;
  padding: 0px;
  text-align: center;
  color: white;
}
.table > tbody > tr > td{

  padding: 0px;
  text-align: center;
  /*color: white;*/
}
.btn-lg.
.progress {
  border-color: silver;
  border-radius: 0.35rem;
  border-width: 0.05rem;
  height: 3rem;
}

.progress__bar {
  background-color: #5cb85c;
  border-radius: 0.35rem;
  border-width: 0;
  height: 3rem;
  -webkit-transition: 0.1s width ease;
  -o-transition: 0.1s width ease;
  transition: 0.1s width ease;
}

.btn-circle.btn-lg {
  width: 25px;
  height: 25px;
  padding: 5px 8px;
  font-size: 9px;
  line-height: 1.33;
  border-radius: 25px;
}
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
<body onload='fetchdata("http://103.206.115.37/ipe/public/api/employeelist"),crudApp.createTable("VSP100606")'>
  <div class="modal fade" id="squarespaceModal1" role="dialog" style="z-index:10000;">
    <div class="modal-dialog modal-sm">
      <div class="modal-content" style="left: -139%;width: 184%;">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit </h4>
        </div>
        <div class="modal-body" style="height: 90px;">                      
                <input type="hidden" name="PAYROLL_ID" class="uppayroll">
                <input type="hidden" name="subject_id" class="subject_id">
                <input type="hidden" name="section_id" class="section_id">
                <input type="hidden" name="id" class="upid">
              <div class="form-group col-md-3">
                <label for="exampleInputEmail1">Subject</label>
               <select class="form-control" id="upsubject" name="subject">
                <option>SELECT</option>
               </select>
              </div>
              <div class="form-group col-md-3">
                <label for="exampleInputPassword1">Section</label>
               <select class="form-control" id="upsection" name="section">
                <option>SELECT</option>
               </select>
              </div>
        </div>
        <div class="modal-footer">
           <button type="submit" class="btn btn-info btn-fill pull-right" id="update" data-dismiss="modal">UPDATE</button>
        </div>
      </div>
    </div>
  </div>
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
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content" style="    width: 125%;left: -13%;">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="display:inline;">info/key/Ans</h4><h4 class="modal-title" style="display:inline;position:relative;    left: 62%;">Last Edited On:11-11-2017</h4>
        </div>
        <div class="modal-body">
         <div class="row">
            <div class="col-md-6">
              <div class="card">
                                <h6 style="display:inline;position:relative;    left: 67%;">Last Edited On:11-11-2017</h6><br>
                                <h4 style="display:inline;" class="title">Info File</h4><h4 style="display:inline;    position: relative;
    left: 65%;cursor:pointer" data-toggle="modal" data-target="#info">ADD <i class="fa fa-plus-circle" aria-hidden="true"></i></h4>
                             
                            <div class="content table-responsive table-full-width">
                                <table class="table table-hover">
                                    <thead>
                                        <th>Subject Name</th>
                                        <th>Question Start No</th>
                                        <th>Question End No</th>
                                        
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>MAT</td>
                                            <td>  <input type="text" class="form-control" placeholder="1"></td>
                                            <td>  <input type="text" class="form-control" placeholder="30" ></td>
                                        </tr>
                                        <tr>
                                            <td>MAT</td>
                                            <td>  <input type="text" class="form-control" placeholder="1"></td>
                                            <td>  <input type="text" class="form-control" placeholder="30" ></td>
                                        </tr>
                                        <tr>
                                            <td>MAT</td>
                                            <td>  <input type="text" class="form-control" placeholder="1"></td>
                                            <td>  <input type="text" class="form-control" placeholder="30" ></td>
                                        </tr>
                                        <tr>
                                            <td>MAT</td>
                                            <td>  <input type="text" class="form-control" placeholder="1"></td>
                                            <td>  <input type="text" class="form-control" placeholder="30" ></td>
                                        </tr>
                                        <tr>
                                            <td>MAT</td>
                                            <td>  <input type="text" class="form-control" placeholder="1"></td>
                                            <td>  <input type="text" class="form-control" placeholder="30" ></td>
                                        </tr>
                                        <tr>
                                            <td>MAT</td>
                                            <td>  <input type="text" class="form-control" placeholder="1"></td>
                                            <td>  <input type="text" class="form-control" placeholder="30" ></td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                
            </div>
            <div class="col-md-6">
                 <div class="card">
                                <h6 style="display:inline;position:relative;    left: 67%;">Last Edited On:11-11-2017</h6><br>
                                <h4 style="display:inline;" class="title">Mark File</h4><h4 style="display:inline;    position: relative;
    left: 65%;cursor:pointer" data-toggle="modal" data-target="#Mark">ADD <i class="fa fa-plus-circle" aria-hidden="true"></i></h4>
                             
                            <div class="content table-responsive table-full-width">
                                <table class="table table-hover ">
                                    <thead>
                                        <th>QNo From</th>
                                         <th>QNo To</th>
                                        <th>+ve Mark</th>
                                        <th>-ve Mark</th>
                                        
                                    </thead>
                                    <tbody>
                                        <tr>
                                      
                                            <td>  <input type="text" class="form-control" placeholder="1"></td>
                                            <td>  <input type="text" class="form-control" placeholder="30" ></td>
                                            <td>  <input type="text" class="form-control" placeholder="4"></td>
                                            <td>  <input type="text" class="form-control" placeholder="1" ></td>
                                        </tr>
                                        <tr>
                                            <td>  <input type="text" class="form-control" placeholder="1"></td>
                                            <td>  <input type="text" class="form-control" placeholder="30" ></td>
                                            <td>  <input type="text" class="form-control" placeholder="4"></td>
                                            <td>  <input type="text" class="form-control" placeholder="1" ></td>
                                        </tr>
                                        <tr>
                                            <td>  <input type="text" class="form-control" placeholder="1"></td>
                                            <td>  <input type="text" class="form-control" placeholder="30" ></td>
                                            <td>  <input type="text" class="form-control" placeholder="4"></td>
                                            <td>  <input type="text" class="form-control" placeholder="1" ></td>
                                        </tr>
                                        <tr>
                                           <td>  <input type="text" class="form-control" placeholder="1"></td>
                                            <td>  <input type="text" class="form-control" placeholder="30" ></td>
                                            <td>  <input type="text" class="form-control" placeholder="4"></td>
                                            <td>  <input type="text" class="form-control" placeholder="1" ></td>
                                        </tr>
                                        <tr>
                                          <td>  <input type="text" class="form-control" placeholder="1"></td>
                                            <td>  <input type="text" class="form-control" placeholder="30" ></td>
                                            <td>  <input type="text" class="form-control" placeholder="4"></td>
                                            <td>  <input type="text" class="form-control" placeholder="1" ></td>
                                        </tr>
                                        <tr>
                                            <td>  <input type="text" class="form-control" placeholder="1"></td>
                                            <td>  <input type="text" class="form-control" placeholder="30" ></td>
                                            <td>  <input type="text" class="form-control" placeholder="4"></td>
                                            <td>  <input type="text" class="form-control" placeholder="1" ></td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
            </div>

            <div class="col-md-12">
                 <div class="card">
                           
                                <h4 style="display:inline;" class="title">Answer Key File</h4><h6 style="display:inline;    position: relative;
    left: 70%;">Last Edited On:11-11-2017</h6>
                             
                            <div class="content table-responsive table-full-width">
                                <table class="table table-hover ">
                                    <thead>
                                        <th style="    width: 52px;">Q NO</th>
                                        <th>X1</th>
                                        <th>X1</th>
                                        <th>X1</th>
                                        <th>X1</th>
                                        <th>X1</th>
                                        <th>X1</th>
                                        <th>X1</th>
                                        <th>X1</th>
                                        <th>X1</th>
                                        <th>X1</th>
                                        <th>X1</th>
                                        <th>X1</th>
                                        
                                        
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1-20</td>
                                            <td>  <input type="text" class="form-control" placeholder="1"></td>
                                            <td>  <input type="text" class="form-control" placeholder="1" ></td>
                                            <td>  <input type="text" class="form-control" placeholder="2"></td>
                                            <td>  <input type="text" class="form-control" placeholder="4" ></td>
                                            <td>  <input type="text" class="form-control" placeholder="2"></td>
                                            <td>  <input type="text" class="form-control" placeholder="4" ></td>
                                            <td>  <input type="text" class="form-control" placeholder="1"></td>
                                            <td>  <input type="text" class="form-control" placeholder="3" ></td>
                                            <td>  <input type="text" class="form-control" placeholder="2"></td>
                                            <td>  <input type="text" class="form-control" placeholder="3" ></td>
                                            <td>  <input type="text" class="form-control" placeholder="1"></td>
                                            <td>  <input type="text" class="form-control" placeholder="4" ></td>
                                        </tr>
                                        <tr>
                                             <td>1-20</td>
                                            <td>  <input type="text" class="form-control" placeholder="1"></td>
                                            <td>  <input type="text" class="form-control" placeholder="1" ></td>
                                            <td>  <input type="text" class="form-control" placeholder="2"></td>
                                            <td>  <input type="text" class="form-control" placeholder="4" ></td>
                                            <td>  <input type="text" class="form-control" placeholder="2"></td>
                                            <td>  <input type="text" class="form-control" placeholder="4" ></td>
                                            <td>  <input type="text" class="form-control" placeholder="1"></td>
                                            <td>  <input type="text" class="form-control" placeholder="3" ></td>
                                            <td>  <input type="text" class="form-control" placeholder="2"></td>
                                            <td>  <input type="text" class="form-control" placeholder="3" ></td>
                                            <td>  <input type="text" class="form-control" placeholder="1"></td>
                                            <td>  <input type="text" class="form-control" placeholder="4" ></td>
                                        </tr>
                                        <tr>
                                            <td>1-20</td>
                                            <td>  <input type="text" class="form-control" placeholder="1"></td>
                                            <td>  <input type="text" class="form-control" placeholder="1" ></td>
                                            <td>  <input type="text" class="form-control" placeholder="2"></td>
                                            <td>  <input type="text" class="form-control" placeholder="4" ></td>
                                            <td>  <input type="text" class="form-control" placeholder="2"></td>
                                            <td>  <input type="text" class="form-control" placeholder="4" ></td>
                                            <td>  <input type="text" class="form-control" placeholder="1"></td>
                                            <td>  <input type="text" class="form-control" placeholder="3" ></td>
                                            <td>  <input type="text" class="form-control" placeholder="2"></td>
                                            <td>  <input type="text" class="form-control" placeholder="3" ></td>
                                            <td>  <input type="text" class="form-control" placeholder="1"></td>
                                            <td>  <input type="text" class="form-control" placeholder="4" ></td>
                                        </tr>
                                        <tr>
                                            <td>1-20</td>
                                            <td>  <input type="text" class="form-control" placeholder="1"></td>
                                            <td>  <input type="text" class="form-control" placeholder="1" ></td>
                                            <td>  <input type="text" class="form-control" placeholder="2"></td>
                                            <td>  <input type="text" class="form-control" placeholder="4" ></td>
                                            <td>  <input type="text" class="form-control" placeholder="2"></td>
                                            <td>  <input type="text" class="form-control" placeholder="4" ></td>
                                            <td>  <input type="text" class="form-control" placeholder="1"></td>
                                            <td>  <input type="text" class="form-control" placeholder="3" ></td>
                                            <td>  <input type="text" class="form-control" placeholder="2"></td>
                                            <td>  <input type="text" class="form-control" placeholder="3" ></td>
                                            <td>  <input type="text" class="form-control" placeholder="1"></td>
                                            <td>  <input type="text" class="form-control" placeholder="4" ></td>
                                        </tr>
                                        <tr>
                                          <td>1-20</td>
                                            <td>  <input type="text" class="form-control" placeholder="1"></td>
                                            <td>  <input type="text" class="form-control" placeholder="1" ></td>
                                            <td>  <input type="text" class="form-control" placeholder="2"></td>
                                            <td>  <input type="text" class="form-control" placeholder="4" ></td>
                                            <td>  <input type="text" class="form-control" placeholder="2"></td>
                                            <td>  <input type="text" class="form-control" placeholder="4" ></td>
                                            <td>  <input type="text" class="form-control" placeholder="1"></td>
                                            <td>  <input type="text" class="form-control" placeholder="3" ></td>
                                            <td>  <input type="text" class="form-control" placeholder="2"></td>
                                            <td>  <input type="text" class="form-control" placeholder="3" ></td>
                                            <td>  <input type="text" class="form-control" placeholder="1"></td>
                                            <td>  <input type="text" class="form-control" placeholder="4" ></td>
                                        </tr>
                                        <tr>
                                             <td>1-20</td>
                                            <td>  <input type="text" class="form-control" placeholder="1"></td>
                                            <td>  <input type="text" class="form-control" placeholder="1" ></td>
                                            <td>  <input type="text" class="form-control" placeholder="2"></td>
                                            <td>  <input type="text" class="form-control" placeholder="4" ></td>
                                            <td>  <input type="text" class="form-control" placeholder="2"></td>
                                            <td>  <input type="text" class="form-control" placeholder="4" ></td>
                                            <td>  <input type="text" class="form-control" placeholder="1"></td>
                                            <td>  <input type="text" class="form-control" placeholder="3" ></td>
                                            <td>  <input type="text" class="form-control" placeholder="2"></td>
                                            <td>  <input type="text" class="form-control" placeholder="3" ></td>
                                            <td>  <input type="text" class="form-control" placeholder="1"></td>
                                            <td>  <input type="text" class="form-control" placeholder="4" ></td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
            </div>            
          </div>          
        </div>
        <div class="modal-footer">
             <button type="submit" class="btn btn-info btn-fill pull-right" data-dismiss="modal">STORE</button>          
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="display_result_modal" role="dialog">
  </div>
    <div class="modal fade" id="imk_modal_id" role="dialog">
  </div>
<div class="wrapper">
    <div class="sidebar menu-width" id="sidebar-id" data-color="purple" data-image="../assets/img/sidebar-5.jpg">
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
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.6/lumen/bootstrap.min.css">
<div class="container" >
<div class="row">
<div id="user" class="col-md-12" >
  <div class="panel panel-primary panel-table animated slideInDown">
   <!-- <div class="panel-heading " style="padding:5px;">
        <div class="row">
        <div class="col col-xs-3 text-left">
        </div>
        <div class="col col-xs-5 text-center" style="height: 40px;">
            <h1 class="panel-title">Employee's List</h1>
        </div>
        </div>
    </div> -->
   <div class="panel-body">
     <div class="tab-content">
      <div role="tabpanel" class="tab-pane active" id="list">
       <table class="table table-striped table-bordered table-list">
        <thead>
         <tr>
            <th class="avatar">PAYROLL_ID</th>
            <th>name</th>
            <th>subject</th>
            <th>section</th>
            <th><em class="fa fa-cog"></em> MAnage</th>
          </tr> 
         </thead>
         <tbody class="list">
         
          </tbody>
        </table>
      </div><!-- END id="list" -->
        
      <div role="tabpanel" class="tab-pane " id="thumb">
        <div class="row">
        <div class="col-md-12">
        
        <div class="ok">
         <div class="col-md-3">
         <div class="panel panel-default panel-thumb">
            <div class="panel-heading">
                <h3 class="panel-title">Djelal Eddine</h3>
            </div>
            <div class="panel-body avatar-card">
             
            </div>
            <div class="panel-footer">
               <a href="#" class="btn btn-primary" title="Edit"    ><i class="fa fa-pencil"></i></a>
               <a href="#" class="btn btn-warning" title="ban"   ><i class="fa fa-ban"   ></i></a>
               <a href="#" class="btn btn-danger"  title="delete"  ><i class="fa fa-trash" ></i></a>
            </div>
         </div>
         </div>
       </div>
        
        <div class="ban">
         <div class="col-md-3">
         <div class="panel panel-default panel-thumb">
            <div class="panel-heading">
                <h3 class="panel-title">Moh Aymen</h3>
            </div>
            <div class="panel-body avatar-card">
             
            </div>
            <div class="panel-footer">
               <a href="#" class="btn btn-primary" title="Edit"    ><i class="fa fa-pencil">        </i></a>
               <a href="#" class="btn btn-warning" title="ban"   ><i class="fa fa-ban"   >admitted</i></a>
               <a href="#" class="btn btn-danger"  title="delete"  ><i class="fa fa-trash" >        </i></a>
            </div>
         </div>
         </div>
       </div>
        
        <div class="new">
         <div class="col-md-3">
         <div class="panel panel-default panel-thumb">
            <div class="panel-heading">
                <h3 class="panel-title">Dia ElHak</h3>
            </div>
            <div class="panel-body avatar-card">
            
            </div>
            <div class="panel-footer">
               <a href="#" class="btn btn-primary" title="Edit"    ><i class="fa fa-pencil"   >     </i></a>
               <a href="#" class="btn btn-success" title="validate"><i class="fa fa-check-square">validate</i></a>
               <a href="#" class="btn btn-warning" title="ban"   ><i class="fa fa-ban"       >      </i></a>
               <a href="#" class="btn btn-danger"  title="delete"  ><i class="fa fa-trash"     >        </i></a>
            </div>
         </div>
         </div>
       </div>
       
       </div>
      </div>
      </div><!-- END id="thumb" -->
       
     </div><!-- END tab-content --> 
    </div>
   
   <div class="page panel-footer text-center">
        
   </div>
  </div><!--END panel-table-->
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



<!-- line modal -->
<div class="modal fade" id="squarespaceModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            <h3 class="modal-title" id="lineModalLabel">Manage</h3>
        </div>
        <div class="modal-body">
            <h1 id="code"></h1><p style="float:right;margin-top: -70px;"><b>U-Update<br>D-Delete<br>S-Save<br>A-Add<br></b></p>
            <div id="container" >
                </div>
        </div>
        <div class="modal-footer">
            </div>
        </div>
    </div>
  </div>
</div>
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
    <!-- <script src="custom.js"></script> -->
	<!-- <script src="custom.js?v=<?php echo get_version();?>"></script> -->
	
<script type="text/javascript">

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
      
        output += '<tr><td>'+ value.PAYROLL_ID +'</td><td>'+ value.NAME + value.SURNAME + value.USER_NAME +'</td><td>'+ value.SUBJECT +'</td><td>'+ value.DESIGNATION +'</td><td><div class="center"><button data-toggle="modal" data-target="#squarespaceModal" data-name="'+ value.PAYROLL_ID +'"  onclick=" crudApp.createTable(\''+ value.PAYROLL_ID+'\')"  class="" style="background: none;border: none" ><i class="fa fa-pencil"></i></button></div></td></tr>';
      
        }); 
            var paginate='';
            paginate+="<ul class='pagination'>";
                paginate+="<li><a href='#' onclick='fetchdata(\""+data.Employee.first_page_url+"\");'><<</a></li>";
                paginate+="<li ><a onclick='fetchdata(\""+data.Employee.prev_page_url+"\")'><</a></li>";
                paginate+="<li ><a href='#'>"+data.Employee.from+"</a></li>";
                paginate+="<li ><a onclick='fetchdata(\""+data.Employee.next_page_url+"\")'>></a></li>";
                paginate+="<li><a href='#' onclick='fetchdata(\""+data.Employee.last_page_url+"\")'>>></a></li>";
            paginate+="</ul>";
                  $('.page').html(paginate);
                 $('.list').html(output);
                 $('#subject').empty();
                 $('#section').empty();
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
                 $.each(data.Subject, function(key, value) {   
                     $('#upsubject')
                         
                         .append($("<option></option>")
                                    .attr("value",value.subject_id)
                                    .text(value.subject_name)); 
                });
                 $.each(data.Section, function(key, value) {   
                     $('#upsection')
                       
                         .append($("<option></option>")
                                    .attr("value",value.SECTION_ID)
                                    .text(value.section_name)); 
                });
            }
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
$(function () {
  $('#squarespaceModal1').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var upid = button.data('id'); 
    var subject_id = button.data('subject_id'); 
    var section_id = button.data('section_id'); 
    var EMPLOYEE_ID = button.data('employee_id'); 
    // alert(EMPLOYEE_ID);
     $('.uppayroll').val(EMPLOYEE_ID);
     $('.upid').val(upid);
     $('.subject_id').val(subject_id);
     $('.section_id').val(section_id);
  });
});
function subset(code){
      $.ajax({
            type: 'GET',
            data:{PAYROLL_ID:code},
            url:"http://103.206.115.37/ipe/public/api/subjectlist",
            success:function(data){
               
         var output="";
              $.each(data, function(index, value) {                                   
               
      
        output += '<tr><td>'+ value.subject_name +'</td><td>'+ value.section_name +'</td><td><div class="center"><button data-id="'+ value.id +'" data-subject_id="'+ value.subject_id +'" data-SECTION_ID="'+ value.SECTION_ID +'" data-EMPLOYEE_ID="'+ value.EMPLOYEE_ID +'"  id="sedit" data-toggle="modal" data-target="#squarespaceModal1" onclick="crudApp.createTable(<?php print_r(file_get_contents("http://103.206.115.37/ipe/public/api/subjectlist?PAYROLL_ID=RJY100635"));?>" style="background: none;border: none" ><i class="fa fa-pencil"></i></button><button data-name="'+ value.id +'" id="sdelete" style="background: none;border: none" onclick="sdelete('+value.id+',\'' + code+ '\')"><i class="fa fa-trash"></i></button></div></td></tr>';
      
        }); 
           
                 $('.sub').html(output);
            }
        });
}
// });
function subadd(code){
    var EMPLOYEE_ID=code;
    var SUBJECT_ID=$('#subjec').val();
    var SECTION_ID=$('#sectio').val();
     $.ajax({
            type: 'POST',
            data:{
                EMPLOYEE_ID:EMPLOYEE_ID,
                SUBJECT_ID:SUBJECT_ID,
                SECTION_ID:SECTION_ID,
            },
            url:"http://103.206.115.37/ipe/public/api/subjectadd",
            success:function(data){
               
         var output="";
              crudApp.createTable(EMPLOYEE_ID);
            }
        });
 }

function subupdate(id,code,value){

    var update =value; 
    var subject_id = $('#subjec1').val(); 
    var section_id = $('#sectio1').val(); 
    if(!subject_id){
        alert('all field required'); 
        return false;
    }
    if(!section_id){
        alert('all field required');
        return false;
    }
    var employee_id =code;

     $.ajax({
            type: 'POST',
            data:{
               update:update,
               EMPLOYEE_ID:employee_id,
                SUBJECT_ID:subject_id,
                SECTION_ID:section_id,
            },
            url:"http://103.206.115.37/ipe/public/api/subjectup",
            success:function(data){
                crudApp.createTable(employee_id);
            }
      
});
 }
function sdelete(id,employee_id){
   
     $.ajax({
            type: 'POST',
            data:{
               id:id,
               EMPLOYEE_ID:employee_id,
            },
            url:"http://103.206.115.37/ipe/public/api/subjectdel",
            success:function(data){
               
         var output="";
             crudApp.createTable(employee_id);
            }
        });

}
var output="";
 var roll=1;
    var crudApp = new function () {

  this.category =JSON.parse(file_get_contents("http://103.206.115.37/ipe/public/api/employeelist?campus_id="+<?php echo $_SESSION['campus_id']; ?>));
 
        this.category1 = JSON.parse(file_get_contents("http://103.206.115.37/ipe/public/api/employeelist?campus_id="+<?php echo $_SESSION['campus_id'] ?>));
        this.col = [];
        this.createTable = function (value) {
            var url="http://103.206.115.37/ipe/public/api/subjectlist?PAYROLL_ID="+value;
            this.myBooks=JSON.parse(file_get_contents(url));
           var i = 0;

            // EXTRACT VALUE FOR TABLE HEADER.
            for (var i = 0; i < this.myBooks.length; i++) {
                for (var key in this.myBooks[i]) {
                    if (this.col.indexOf(key) === -1) {
                        this.col.push(key);
                    }
                }
            }

            // CREATE A TABLE.
            var table = document.createElement('table');
            table.setAttribute('id', 'booksTable');     // SET TABLE ID.
            table.setAttribute('class','table table-striped table-bordered table-list');
            table.setAttribute('style','.table > thead > tr > th{  background-color: #23343a; padding: 0px;text-align: center; color: white;}');

            var tr = table.insertRow(-1);               // CREATE A ROW (FOR HEADER).

            for (var h = 0; h < this.col.length; h++) {
                // ADD TABLE HEADER.
                var th = document.createElement('th');
                th.innerHTML = this.col[h].replace('_', ' ');
                th.setAttribute('style','background-color: #23343a; font-weight:normal;text-align: center; color: white; text-transform: uppercase;');
                tr.appendChild(th);
            }
            // ADD ROWS USING JSON DATA.
            for (var i = 0; i < this.myBooks.length; i++) {

                tr = table.insertRow(-1);           // CREATE A NEW ROW.

                for (var j = 0; j < this.col.length; j++) {
                    var tabCell = tr.insertCell(-1);
                    tabCell.innerHTML = this.myBooks[i][this.col[j]];
                }
                // DYNAMICALLY CREATE AND ADD ELEMENTS TO TABLE CELLS WITH EVENTS.

                this.td = document.createElement('td');

                // *** CANCEL OPTION.
                tr.appendChild(this.td);
                var lblCancel = document.createElement('label');
                lblCancel.innerHTML = '✖';
                lblCancel.setAttribute('onclick', 'crudApp.Cancel(this,"'+value+'")');
                lblCancel.setAttribute('style', 'display:none;');
                lblCancel.setAttribute('title', 'Cancel');
                lblCancel.setAttribute('id', 'lbl' + i);
                this.td.appendChild(lblCancel);

                // *** SAVE.
                tr.appendChild(this.td);
                var btSave = document.createElement('input');

                btSave.setAttribute('type', 'button');      // SET ATTRIBUTES.
                btSave.setAttribute('value', 'S');
                btSave.setAttribute('id', 'Save' + i);
                btSave.setAttribute('style', 'display:none;');
                btSave.setAttribute('onclick', 'subupdate("'+i+'","'+value+'","'+this.myBooks[i][this.col[0]]+'"),crudApp.Save(this,"'+value+'")');       // ADD THE BUTTON's 'onclick' EVENT.
                this.td.appendChild(btSave);

                // *** UPDATE.
                tr.appendChild(this.td);
                var btUpdate = document.createElement('input');

                btUpdate.setAttribute('type', 'button');    // SET ATTRIBUTES.
                btUpdate.setAttribute('value', 'U');
                btUpdate.setAttribute('id', 'Edit' + i);
                btUpdate.setAttribute('style', 'background-color:#23343a;color:white;');
                btUpdate.setAttribute('onclick', 'crudApp.Update(this,"'+value+'")');   // ADD THE BUTTON's 'onclick' EVENT.
                this.td.appendChild(btUpdate);

                // *** DELETE.
                this.td = document.createElement('th');
                tr.appendChild(this.td);
                var btDelete = document.createElement('input');
                btDelete.setAttribute('type', 'button');    // SET INPUT ATTRIBUTE.
                btDelete.setAttribute('value', 'D');
                btDelete.setAttribute('style', 'background-color:#23343a;color:white;font-weight:normal;');
                btDelete.setAttribute('onclick', 'crudApp.Delete(this,"'+value+'"),sdelete("'+this.myBooks[i][this.col[0]]+'","'+value+'")');   // ADD THE BUTTON's 'onclick' EVENT.
                this.td.appendChild(btDelete);
            }


            // ADD A ROW AT THE END WITH BLANK TEXTBOXES AND A DROPDOWN LIST (FOR NEW ENTRY).

            tr = table.insertRow(-1);           // CREATE THE LAST ROW.

            for (var j = 0; j < 3; j++) {
                var newCell = tr.insertCell(-1);
                if (j >= 1) {

                    if (j == 2) {   // WE'LL ADD A DROPDOWN LIST AT THE SECOND COLUMN (FOR Category).

                        var select = document.createElement('select');   
                        select.id="sectio";   // CREATE AND ADD A DROPDOWN LIST.
                        select.className +="form-control";
                        select.innerHTML = '<option value="">SELECT</option>';
                        for (k = 0; k < this.category.Section.length; k++) {
                            select.innerHTML = select.innerHTML +
                                '<option value="' + this.category.Section[k].SECTION_ID + '">' + this.category.Section[k].section_name + '</option>';
                        }
                        newCell.appendChild(select);
                    }
                    else {
                         var select = document.createElement('select');    
                         select.id="subjec"; // CREATE AND ADD A DROPDOWN LIST.
                        select.className +="form-control";
                        select.innerHTML = '<option value="">SELECT</option>';
                        for (k = 0; k < this.category1.Subject.length; k++) {
                            select.innerHTML = select.innerHTML +
                                '<option value="' + this.category1.Subject[k].subject_id + '">' + this.category1.Subject[k].subject_name + '</option>';
                        }
                        newCell.appendChild(select);
                    }
                }
            }

            this.td = document.createElement('td');
            tr.appendChild(this.td);

            var btNew = document.createElement('input');

            btNew.setAttribute('type', 'button');       // SET ATTRIBUTES.
            btNew.setAttribute('value', 'A');
            btNew.setAttribute('id', 'New' + i);
            btNew.setAttribute('style', 'background-color:#23343a;color:white;');
            btNew.setAttribute('onclick', 'subadd("'+value+'"),crudApp.CreateNew(this,"'+value+'")');       // ADD THE BUTTON's 'onclick' EVENT.
            this.td.appendChild(btNew);

            var div = document.getElementById('container');
            div.innerHTML = '';
            div.appendChild(table);    // ADD THE TABLE TO THE WEB PAGE.

        };

        // ****** OPERATIONS START.

        // CANCEL.
        this.Cancel = function (oButton,value) {

            // HIDE THIS BUTTON.
            oButton.setAttribute('style', 'display:none; float:none;');

            var activeRow = oButton.parentNode.parentNode.rowIndex;

            // HIDE THE SAVE BUTTON.
            var btSave = document.getElementById('Save' + (activeRow - 1));
            btSave.setAttribute('style', 'display:none;');

            // SHOW THE UPDATE BUTTON AGAIN.
            var btUpdate = document.getElementById('Edit' + (activeRow - 1));
            btUpdate.setAttribute('style', 'display:block; margin:0 auto; background-color:#23343a;color:white;');

            var tab = document.getElementById('booksTable').rows[activeRow];

            for (i = 0; i < this.col.length; i++) {
                var td = tab.getElementsByTagName("td")[i];
                td.innerHTML = this.myBooks[(activeRow - 1)][this.col[i]];
            }
        }


        // EDIT DATA.
        this.Update = function (oButton,value) {
            var activeRow = oButton.parentNode.parentNode.rowIndex;
            var tab = document.getElementById('booksTable').rows[activeRow];
           
            // SHOW A DROPDOWN LIST WITH A LIST OF CATEGORIES.
            for (i = 1; i < 3; i++) {
                if (i == 2) {
                    var td = tab.getElementsByTagName("td")[i];
                    var ele = document.createElement('select');   
                    ele.className +="form-control";
                    ele.id="sectio1";  // DROPDOWN LIST.
                    ele.innerHTML = '<option value="">SELECT</option>';
                    for (k = 0; k < this.category.Section.length; k++) {
                        ele.innerHTML = ele.innerHTML +
                            '<option value="' + this.category1.Section[k].SECTION_ID + '">' + this.category1.Section[k].section_name + '</option>';
                    }
                     
                    td.innerText = '';
                    td.appendChild(ele);
                }
                else {
                      var td = tab.getElementsByTagName("td")[i];
                    var ele = document.createElement('select');   
                    ele.className +="form-control";
                    ele.id="subjec1";   // DROPDOWN LIST.
                    ele.innerHTML = '<option value="">SELECT</option>';
                    for (k = 0; k < this.category1.Subject.length; k++) {
                        ele.innerHTML = ele.innerHTML +
                           '<option value="' + this.category1.Subject[k].subject_id + '">' + this.category1.Subject[k].subject_name + '</option>';
                    }                   
                    td.innerText = '';
                    td.appendChild(ele);
                }

            }

                roll=roll+1;
            var lblCancel = document.getElementById('lbl' + (activeRow - 1));
            lblCancel.setAttribute('style', 'cursor:pointer; display:block; width:20px; float:left; position: absolute;');

            var btSave = document.getElementById('Save' + (activeRow - 1));
            btSave.setAttribute('style', 'display:block; margin-left:30px; float:left; background-color:#23343a;color:white;');

            // HIDE THIS BUTTON.
            oButton.setAttribute('style', 'display:none;');
        };


        // DELETE DATA.
        this.Delete = function (oButton,value) {
            var activeRow = oButton.parentNode.parentNode.rowIndex;
            this.myBooks.splice((activeRow - 1), 1);    // DELETE THE ACTIVE ROW.
            this.createTable(value);                         // REFRESH THE TABLE.
        };

        // SAVE DATA.
        this.Save = function (oButton,value) {
            var activeRow = oButton.parentNode.parentNode.rowIndex;
            var tab = document.getElementById('booksTable').rows[activeRow];

            // UPDATE myBooks ARRAY WITH VALUES.
            for (i = 1; i < this.col.length; i++) {
                var td = tab.getElementsByTagName("td")[i];
                if (td.childNodes[0].getAttribute('type') == 'text' || td.childNodes[0].tagName == 'SELECT') {  // CHECK IF ELEMENT IS A TEXTBOX OR SELECT.
                    this.myBooks[(activeRow - 1)][this.col[i]] = td.childNodes[0].options[td.childNodes[0].selectedIndex].text;      // SAVE THE VALUE.

                }
            }
            this.createTable(value);     // REFRESH THE TABLE.
        }

        // CREATE NEW.
        this.CreateNew = function (oButton,value) {
            var activeRow = oButton.parentNode.parentNode.rowIndex;
            var tab = document.getElementById('booksTable').rows[activeRow];
            var obj = {};

            // ADD NEW VALUE TO myBooks ARRAY.
            for (i = 1; i < this.col.length; i++) {
                var td = tab.getElementsByTagName("td")[i];
                if (td.childNodes[0].getAttribute('type') == 'text' || td.childNodes[0].tagName == 'SELECT') {      // CHECK IF ELEMENT IS A TEXTBOX OR SELECT.
                    var txtVal = td.childNodes[0].options[td.childNodes[0].selectedIndex].text;   
                    if (txtVal != 'SELECT') {
                        obj[this.col[i]] = txtVal.trim();
                    }
                    else {
                        obj = '';
                        alert('all fields are compulsory');
                        break;
                    }
                }
            }
            obj[this.col[0]] = this.myBooks.length + 1;     // NEW ID.

            if (Object.keys(obj).length > 0) {      // CHECK IF OBJECT IS NOT EMPTY.
                this.myBooks.push(obj);           // PUSH (ADD) DATA TO THE JSON ARRAY.
                this.createTable(value);                 // REFRESH THE TABLE.
            }
        }

        // ****** OPERATIONS END.
    }

function file_get_contents (url, flags, context, offset, maxLen) {
    // Read the entire file into a string
    //
    // version: 906.111
    // discuss at: http://phpjs.org/functions/file_get_contents
    // +   original by: Legaev Andrey
    // +      input by: Jani Hartikainen
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Brett Zamir (http://brett-zamir.me)
    // +   input by: Raphael (Ao) RUDLER
    // +   bugfixed by: Brett Zamir (http://brett-zamir.me)
    // %        note 1: This function uses XmlHttpRequest and cannot retrieve resource from different domain without modifications.
    // %        note 2: Synchronous by default (as in PHP) so may lock up browser. Can
    // %        note 2: get async by setting a custom "phpjs.async" property to true and "notification" for an
    // %        note 2: optional callback (both as context params, with responseText, and other JS-specific
    // %        note 2: request properties available via 'this'). Note that file_get_contents() will not return the text
    // %        note 2: in such a case (use this.responseText within the callback). Or, consider using
    // %        note 2: jQuery's: $('#divId').load('http://url') instead.
    // %        note 3: The context argument is only implemented for http, and only partially (see below for
    // %        note 3: "Presently unimplemented HTTP context options"); also the arguments passed to
    // %        note 3: notification are incomplete
    // *     example 1: file_get_contents('http://kevin.vanzonneveld.net/pj_test_supportfile_1.htm');
    // *     returns 1: '123'
    // Note: could also be made to optionally add to global $http_response_header as per http://php.net/manual/en/reserved.variables.httpresponseheader.php
    var tmp, headers = [],
        newTmp = [],
        k = 0,
        i = 0,
        href = '',
        pathPos = -1,
        flagNames = 0,
        content = null,
        http_stream = false;
    var func = function (value) {
        return value.substring(1) !== '';
    };

    // BEGIN REDUNDANT
    this.php_js = this.php_js || {};
    this.php_js.ini = this.php_js.ini || {};
    // END REDUNDANT
    var ini = this.php_js.ini;
    context = context || this.php_js.default_streams_context || null;

    if (!flags) {
        flags = 0;
    }
    var OPTS = {
        FILE_USE_INCLUDE_PATH: 1,
        FILE_TEXT: 32,
        FILE_BINARY: 64
    };
    if (typeof flags === 'number') { // Allow for a single string or an array of string flags
        flagNames = flags;
    } else {
        flags = [].concat(flags);
        for (i = 0; i < flags.length; i++) {
            if (OPTS[flags[i]]) {
                flagNames = flagNames | OPTS[flags[i]];
            }
        }
    }

    if (flagNames & OPTS.FILE_BINARY && (flagNames & OPTS.FILE_TEXT)) { // These flags shouldn't be together
        throw 'You cannot pass both FILE_BINARY and FILE_TEXT to file_get_contents()';
    }

    if ((flagNames & OPTS.FILE_USE_INCLUDE_PATH) && ini.include_path && ini.include_path.local_value) {
        var slash = ini.include_path.local_value.indexOf('/') !== -1 ? '/' : '\\';
        url = ini.include_path.local_value + slash + url;
    } else if (!/^(https?|file):/.test(url)) { // Allow references within or below the same directory (should fix to allow other relative references or root reference; could make dependent on parse_url())
        href = this.window.location.href;
        pathPos = url.indexOf('/') === 0 ? href.indexOf('/', 8) - 1 : href.lastIndexOf('/');
        url = href.slice(0, pathPos + 1) + url;
    }

    if (context) {
        var http_options = context.stream_options && context.stream_options.http;
        http_stream = !! http_options;
    }

    if (!context || http_stream) {
        var req = this.window.ActiveXObject ? new ActiveXObject('Microsoft.XMLHTTP') : new XMLHttpRequest();
        if (!req) {
            throw new Error('XMLHttpRequest not supported');
        }

        var method = http_stream ? http_options.method : 'GET';
        var async = !! (context && context.stream_params && context.stream_params['phpjs.async']);

        if (ini['phpjs.ajaxBypassCache'] && ini['phpjs.ajaxBypassCache'].local_value) {
            url += (url.match(/\?/) == null ? "?" : "&") + (new Date()).getTime(); // Give optional means of forcing bypass of cache
        }

        req.open(method, url, async);
        if (async) {
            var notification = context.stream_params.notification;
            if (typeof notification === 'function') {
                // Fix: make work with req.addEventListener if available: https://developer.mozilla.org/En/Using_XMLHttpRequest
                if (0 && req.addEventListener) { // Unimplemented so don't allow to get here
/*
                    req.addEventListener('progress', updateProgress, false);
                    req.addEventListener('load', transferComplete, false);
                    req.addEventListener('error', transferFailed, false);
                    req.addEventListener('abort', transferCanceled, false);
                    */
                } else {
                    req.onreadystatechange = function (aEvt) { // aEvt has stopPropagation(), preventDefault(); see https://developer.mozilla.org/en/NsIDOMEvent
                        // Other XMLHttpRequest properties: multipart, responseXML, status, statusText, upload, withCredentials
/*
    PHP Constants:
    STREAM_NOTIFY_RESOLVE   1       A remote address required for this stream has been resolved, or the resolution failed. See severity  for an indication of which happened.
    STREAM_NOTIFY_CONNECT   2     A connection with an external resource has been established.
    STREAM_NOTIFY_AUTH_REQUIRED 3     Additional authorization is required to access the specified resource. Typical issued with severity level of STREAM_NOTIFY_SEVERITY_ERR.
    STREAM_NOTIFY_MIME_TYPE_IS  4     The mime-type of resource has been identified, refer to message for a description of the discovered type.
    STREAM_NOTIFY_FILE_SIZE_IS  5     The size of the resource has been discovered.
    STREAM_NOTIFY_REDIRECTED    6     The external resource has redirected the stream to an alternate location. Refer to message .
    STREAM_NOTIFY_PROGRESS  7     Indicates current progress of the stream transfer in bytes_transferred and possibly bytes_max as well.
    STREAM_NOTIFY_COMPLETED 8     There is no more data available on the stream.
    STREAM_NOTIFY_FAILURE   9     A generic error occurred on the stream, consult message and message_code for details.
    STREAM_NOTIFY_AUTH_RESULT   10     Authorization has been completed (with or without success).

    STREAM_NOTIFY_SEVERITY_INFO 0     Normal, non-error related, notification.
    STREAM_NOTIFY_SEVERITY_WARN 1     Non critical error condition. Processing may continue.
    STREAM_NOTIFY_SEVERITY_ERR  2     A critical error occurred. Processing cannot continue.
    */
                        var objContext = {
                            responseText: req.responseText,
                            responseXML: req.responseXML,
                            status: req.status,
                            statusText: req.statusText,
                            readyState: req.readyState,
                            evt: aEvt
                        }; // properties are not available in PHP, but offered on notification via 'this' for convenience
                        // notification args: notification_code, severity, message, message_code, bytes_transferred, bytes_max (all int's except string 'message')
                        // Need to add message, etc.
                        var bytes_transferred;
                        switch (req.readyState) {
                        case 0:
                            //     UNINITIALIZED     open() has not been called yet.
                            notification.call(objContext, 0, 0, '', 0, 0, 0);
                            break;
                        case 1:
                            //     LOADING     send() has not been called yet.
                            notification.call(objContext, 0, 0, '', 0, 0, 0);
                            break;
                        case 2:
                            //     LOADED     send() has been called, and headers and status are available.
                            notification.call(objContext, 0, 0, '', 0, 0, 0);
                            break;
                        case 3:
                            //     INTERACTIVE     Downloading; responseText holds partial data.
                            bytes_transferred = req.responseText.length * 2; // One character is two bytes
                            notification.call(objContext, 7, 0, '', 0, bytes_transferred, 0);
                            break;
                        case 4:
                            //     COMPLETED     The operation is complete.
                            if (req.status >= 200 && req.status < 400) {
                                bytes_transferred = req.responseText.length * 2; // One character is two bytes
                                notification.call(objContext, 8, 0, '', req.status, bytes_transferred, 0);
                            } else if (req.status === 403) { // Fix: These two are finished except for message
                                notification.call(objContext, 10, 2, '', req.status, 0, 0);
                            } else { // Errors
                                notification.call(objContext, 9, 2, '', req.status, 0, 0);
                            }
                            break;
                        default:
                            throw 'Unrecognized ready state for file_get_contents()';
                        }
                    }
                }
            }
        }

        if (http_stream) {
            var sendHeaders = http_options.header && http_options.header.split(/\r?\n/);
            var userAgentSent = false;
            for (i = 0; i < sendHeaders.length; i++) {
                var sendHeader = sendHeaders[i];
                var breakPos = sendHeader.search(/:\s*/);
                var sendHeaderName = sendHeader.substring(0, breakPos);
                req.setRequestHeader(sendHeaderName, sendHeader.substring(breakPos + 1));
                if (sendHeaderName === 'User-Agent') {
                    userAgentSent = true;
                }
            }
            if (!userAgentSent) {
                var user_agent = http_options.user_agent || (ini.user_agent && ini.user_agent.local_value);
                if (user_agent) {
                    req.setRequestHeader('User-Agent', user_agent);
                }
            }
            content = http_options.content || null;
/*
            // Presently unimplemented HTTP context options
            var request_fulluri = http_options.request_fulluri || false; // When set to TRUE, the entire URI will be used when constructing the request. (i.e. GET http://www.example.com/path/to/file.html HTTP/1.0). While this is a non-standard request format, some proxy servers require it.
            var max_redirects = http_options.max_redirects || 20; // The max number of redirects to follow. Value 1 or less means that no redirects are followed.
            var protocol_version = http_options.protocol_version || 1.0; // HTTP protocol version
            var timeout = http_options.timeout || (ini.default_socket_timeout && ini.default_socket_timeout.local_value); // Read timeout in seconds, specified by a float
            var ignore_errors = http_options.ignore_errors || false; // Fetch the content even on failure status codes.
            */
        }

        if (flagNames & OPTS.FILE_TEXT) { // Overrides how encoding is treated (regardless of what is returned from the server)
            var content_type = 'text/html';
            if (http_options && http_options['phpjs.override']) { // Fix: Could allow for non-HTTP as well
                content_type = http_options['phpjs.override']; // We use this, e.g., in gettext-related functions if character set
                //   overridden earlier by bind_textdomain_codeset()
            } else {
                var encoding = (ini['unicode.stream_encoding'] && ini['unicode.stream_encoding'].local_value) || 'UTF-8';
                if (http_options && http_options.header && (/^content-type:/im).test(http_options.header)) { // We'll assume a content-type expects its own specified encoding if present
                    content_type = http_options.header.match(/^content-type:\s*(.*)$/im)[1]; // We let any header encoding stand
                }
                if (!(/;\s*charset=/).test(content_type)) { // If no encoding
                    content_type += '; charset=' + encoding;
                }
            }
            req.overrideMimeType(content_type);
        }
        // Default is FILE_BINARY, but for binary, we apparently deviate from PHP in requiring the flag, since many if not
        //     most people will also want a way to have it be auto-converted into native JavaScript text instead
        else if (flagNames & OPTS.FILE_BINARY) { // Trick at https://developer.mozilla.org/En/Using_XMLHttpRequest to get binary
            req.overrideMimeType('text/plain; charset=x-user-defined');
            // Getting an individual byte then requires:
            // responseText.charCodeAt(x) & 0xFF; // throw away high-order byte (f7) where x is 0 to responseText.length-1 (see notes in our substr())
        }

        if (http_options && http_options['phpjs.sendAsBinary']) { // For content sent in a POST or PUT request (use with file_put_contents()?)
            req.sendAsBinary(content); // In Firefox, only available FF3+
        } else {
            req.send(content);
        }

        tmp = req.getAllResponseHeaders();
        if (tmp) {
            tmp = tmp.split('\n');
            for (k = 0; k < tmp.length; k++) {
                if (func(tmp[k])) {
                    newTmp.push(tmp[k]);
                }
            }
            tmp = newTmp;
            for (i = 0; i < tmp.length; i++) {
                headers[i] = tmp[i];
            }
            this.$http_response_header = headers; // see http://php.net/manual/en/reserved.variables.httpresponseheader.php
        }

        if (offset || maxLen) {
            if (maxLen) {
                return req.responseText.substr(offset || 0, maxLen);
            }
            return req.responseText.substr(offset);
        }
        return req.responseText;
    }
    return false;
}

</script>
  

<div id="wait" style="width: 100%;height: 100%;z-index: 9999999;position: fixed;top: 0%;left: 0%;padding: 2px;background-color: #cecaca; opacity: 0.5;"><img onclick="window.location.href="" src="../assets/demo_wait.gif" width="64" height="64" style="
    margin-left: 50%;
    margin-top: 20%;cursor:pointer;
"><br>
<span style="margin-left:50%;">Loading..</span>

</div>
<script type="text/javascript">

    // $(document).ready(function(){

$(document).ready(function(){
        $(document).ajaxStart(function(){
        $("#wait").css("display", "block");
    });
    $(document).ajaxComplete(function(){
        $("#wait").css("display", "none");
    });
    show_group_list();  
});
</script>
<!-- <?php
$value = 100;
$value2="";
?>
<script type='text/javascript'>
var xyz = <?php echo $value; ?>;
var abc='123';
alert (xyz);
</script>
<script type="text/javascript">
    var myjavascript = "12345";
</script>

<?php 
   $phpVar =  '<script>document.write(myjavascript);</script>';

   echo $phpVar;
?> -->
</html>
</html>
