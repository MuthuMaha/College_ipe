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
<body onload='fetchdata("http://175.101.3.68/ipe/public/api/examlist"),crudApp.createTable("VSP100606")'>
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

<div class="container well" style="background-color: white;">
  <form>
    <div class="form-group col-md-2" ><label for="sel1">Year:</label>
  <select class="form-control" id="year" onchange='fetchdata("http://175.101.3.68/ipe/public/api/examlist")'>
    <option value="">SELECT</option>
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
  </select>
    </div>
    <div class="form-group col-md-2"><label for="sel1">Group:</label>
  <select class="form-control" id="group" onchange='fetchdata("http://175.101.3.68/ipe/public/api/examlist")'>
    <option value="">SELECT</option>
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
  </select>
    </div>
    <div class="form-group col-md-2"><label for="sel1">Stream:</label>
  <select class="form-control" id="stream" onchange='fetchdata("http://175.101.3.68/ipe/public/api/examlist")'>
    <option value="">SELECT</option>
     <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
  </select>
    </div>
    <div class="form-group col-md-2"><label for="sel1">Program:</label>
  <select class="form-control" id="program" onchange='fetchdata("http://175.101.3.68/ipe/public/api/examlist")'>
    <option value="">SELECT</option>
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
  </select>
    </div>
    <div class="form-group col-md-2"><label for="sel1">Status:</label>
  <select class="form-control" id="status" onchange='fetchdata("http://175.101.3.68/ipe/public/api/examlist")'>
    <option value="">SELECT</option>
    <option value="0">Ongoing</option>
    <option value="1">Completed</option>
    <option value="2">Upcoming</option>
  </select>
    </div>
 </form>
</div>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.6/lumen/bootstrap.min.css">
<div class="container" style="margin-top:20px;">
<div class="row">
<div id="user" class="col-md-12" >
  <div class="panel panel-primary panel-table animated slideInDown">
   <div class="panel-heading " style="padding:5px;">
        <div class="row">
        <div class="col col-xs-3 text-left">
        </div>
        <div class="col col-xs-5 text-center" style="height: 40px;">
            <h1 class="panel-title">Exam's List</h1>
        </div>
        </div>
    </div>
   <div class="panel-body">
     <div class="tab-content">
      <div role="tabpanel" class="tab-pane active" id="list">
       <table class="table table-striped table-bordered table-list">
        <thead>
         <tr>
            <th class="avatar">EXAM_ID</th>
            <th>TEST_CODE</th>
            <th>START_DATE</th>
            <th>Test_type_id</th>
            <th><em class="fa fa-cog"></em> Action</th>
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
            <h1 id="code"></h1>
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
    var year=$('#year').val();
    var group=$('#group').val();
    var stream=$('#stream').val();
    var program=$('#program').val();
    var status=$('#status').val();
    // alert(ul);
        $.ajax({
            type: 'GET',
            data:{
                  campus_id:<?php echo $_SESSION['campus_id']; ?>,
                  year:year,
                  group:group,
                  stream:stream,
                  program:program,
                  status:status,
              },
            url:ul,
            success:function(data){
              
         var output="";
              $.each(data.data, function(index, value) {     
      
        output += '<tr><td>'+ value.exam_id +'</td><td>'+ value.Exam_name +'</td><td>'+ value.Date_exam +'</td><td>'+ value.Test_type_id +'</td><td><div class="center"><button data-toggle="modal" data-name="'+ value.exam_id +'"  onclick="call('+ value.exam_id +')";"  class="" style="background: none;border: none" ><i class="fa fa-pencil"></i></button></div></td></tr>';
      
        }); 
            var paginate='';
            paginate+="<ul class='pagination'>";
                paginate+="<li><a href='#' onclick='fetchdata(\""+data.first_page_url+"\");'><<</a></li>";
                paginate+="<li ><a onclick='fetchdata(\""+data.prev_page_url+"\")'><</a></li>";
                paginate+="<li ><a onclick='fetchdata(\""+data.next_page_url+"\")'>></a></li>";
                paginate+="<li><a href='#' onclick='fetchdata(\""+data.last_page_url+"\")'>>></a></li>";
            paginate+="</ul>";
                  $('.page').html(paginate);
                 $('.list').html(output);
            }
        });
    return true;
}
 function call(exam_id){
    window.location.href = "campus.php?exam_id="+exam_id;
 }
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
