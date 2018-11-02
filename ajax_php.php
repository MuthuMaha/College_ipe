<?php
include_once '../../secure_login/includes/functions.php';  
include_once 'ajax_php.php';  
// sec_session_start(); 
//if(($_SESSION['is_doe']==false) && ($_SESSION['is_principal']==false))
// {
    //Header('Location:../../secure_login/'); 
// }


 
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");


include_once("../000_main_includes/config.php");
include_once("../000_main_includes/common_functions.php");





include_once 'duplicate_check/index.php';

//require("../../config/config.php");
//$secure_con=Db::getInstance()->getConnection();

$this_campus_id=$_SESSION['campus_id'];//exit
if(isset($_POST['delete_previous_approval_list']))
{
	delete_previous_approval_list($con,$this_campus_id);
}

if(isset($_POST['get_initial_table_display']))
{
	get_initial_table_display($con,$this_campus_id);
}

if(isset($_POST['check_initial_condition_of_sl']))
{
	check_initial_condition_of_sl($con,$this_campus_id);
}

if(isset($_POST['get_all_info_of_sl']))
{
	get_all_info_of_sl($con,$this_campus_id);
}


if(isset($_POST['dat_conversion_function']))
{
	dat_conversion_function($con,$this_campus_id);
}

if(isset($_POST['get_process_upload_track_value']))
{
	get_process_upload_track_value($con,$this_campus_id);
}

if(isset($_POST['display_result_of_sl']))
{
	display_result_of_sl($con,$this_campus_id);
}
if(isset($_POST['open_view_imk_modal_of_sl']))
{
	open_view_imk_modal_of_sl($con); //recheck
}


if(isset($_POST['view_status_info_modal_of_sl']))
{
	view_status_info_modal_of_sl($con,$this_campus_id);
}
if(isset($_POST['delete_this_branch_result_of_sl']))
{
	delete_this_branch_result_of_sl($con,$this_campus_id);
}
if(isset($_POST['approve_delete']))
{
	approve_delete($con,$this_campus_id);
}

if(isset($_POST['display_merged_msg']))
{
	 
	display_merged_data($con);
	
}

function delete_previous_approval_list($con,$this_campus_id) //CRB not required...  // (Small =>Checked)
{
 $sl=$_POST['sl'];
 $res=$con->query("delete from 101_mismatch_approval_request where test_sl='$sl' and this_college_id='$this_campus_id'"); 
 if($res)
 {
	 echo "flushed_success";
 }
	exit;
}


function approve_delete($con,$this_campus_id) //CRB required--DO REFERING EXAM ADMIN'S--------- CRB Done....// (Small =>Checked)
{
   $sl=$_POST['sl'];
   $approve_selected=$_POST['approve_selected'];
   $student_id_array=explode(",",$approve_selected);


   $delete_selected=$_POST['delete_selected'];
   $delete_selected_array=explode(",",$delete_selected);
   $delete_count=sizeof($delete_selected_array);
   if($delete_selected=="")
   {
   	$delete_count=0;
   }

   //echo $delete_count;
   //exit;

 $res=$con->query("select omr_scanning_type,subject_string_final,mode from 1_exam_admin_create_exam where sl='$sl'");
 $row=mysqli_fetch_array($res);
 
  $omr_scanning_type=$row['omr_scanning_type']; 
 $test_mode_id=$row['mode'];



$res_table_name=$con->query("select marks_upload_temp_table_name from 0_test_modes where test_mode_id='$test_mode_id'");
$row_table_name=mysqli_fetch_array($res_table_name);

$marks_upload_temp_table_name=$row_table_name['marks_upload_temp_table_name'];


 $subject_array=array();
 $marks_array=array();

 if($omr_scanning_type=="advanced")
 {
    $subject_array=array();
    $subject_array[]="PHYSICS";
    $subject_array[]="CHEMISTRY";
    $subject_array[]="MATHEMATICS";
    $R_U_W_string_array=array();

 	$total_array=array();
 	$_R_U_W_array=array();

    $marks_array=array();
                $res=$con->query("select PHYSICS,CHEMISTRY,MATHEMATICS,TOTAL,Result_String from 101_mismatch_approval_request where STUD_ID IN($approve_selected) and this_college_id='$this_campus_id' and test_sl='$sl' ORDER BY FIND_IN_SET(STUD_ID,'$approve_selected')");
 	
 	while($row=mysqli_fetch_array($res))
 	{
    $p=$row['PHYSICS'];
 	$c=$row['CHEMISTRY'];
 	$m=$row['MATHEMATICS'];
    $three=$p.",".$c.",".$m;
    $marks_array[]=$three;
    $R_U_W_string_array[]=$row['Result_String'];

 	$total_array[]=$row['TOTAL'];
 	$_R_U_W_array[]=$row['Result_String'];

 	}
 }

 else
if($omr_scanning_type=="non_advanced")
{

     $temp=$row['subject_string_final'];  //overriding previous value
     $_R_U_W_array=array();
     $temp_array=explode(",",$temp);

        $subject_array=array();
	foreach($temp_array as $val)
	{

      $res=$con->query("select subject_name from 0_subjects where subject_id = '$val'");
      $row=mysqli_fetch_array($res);
       $m=$row['subject_name'];
       $subject_array[]=strtoupper($m);
	}








    $marks_array=array();
	$res=$con->query("select other_subjects_info,TOTAL,Result_String from 101_mismatch_approval_request where STUD_ID IN($approve_selected) and this_college_id='$this_campus_id' and test_sl='$sl' ORDER BY FIND_IN_SET(STUD_ID,'$approve_selected')");
	//echo "COUNT=".mysqli_num_rows($res);// exit;
 	
 	while($row=mysqli_fetch_array($res))
 	{
     $marks_array[]=$row['other_subjects_info'];
 	 $total_array[]=$row['TOTAL'];
 	 $_R_U_W_array[]=$row['Result_String'];
 	 

 	}
   //echo "marks array=";
 	//echo json_encode($marks_array); exit;

}

$total_stud=sizeof($marks_array);





	$inside_string="test_code_sl_id,STUD_ID,";
	$subject_name_string=implode(",",$subject_array);
	$number_of_subject=sizeof($subject_array);

	$last_string=$inside_string.$subject_name_string.",TOTAL,this_college_id,Result_String";
	


	//APPROVING.........
	mysqli_autocommit($con,FALSE);
$approval_count=sizeof($student_id_array);
foreach($student_id_array as $key=>$ind_id)

{ //echo "in".$key."in";
	 $line=$marks_array[$key];
	//json_encode($line); //exit;
     $this_R_U_W_string=$R_U_W_string_array[$key];

	$mark_line=explode(",",$line); 
   // echo json_encode($mark_line);
    //exit;
	 
	 if($number_of_subject==3)
	 {
	$res1=$con->query("insert into $marks_upload_temp_table_name($last_string)
	values('{$sl}','{$ind_id}','{$mark_line[0]}','{$mark_line[1]}','{$mark_line[2]}','{$total_array[$key]}','{$this_campus_id}','{$this_R_U_W_string}')"); 

            $approved_status=1;
            $current_user_employee_id=$_SESSION['EMPLOYEE_ID'];
	$res2=$con->query("update 101_mismatch_approval_request set status='$approved_status',approval_status_by='$current_user_employee_id' where STUD_ID='$ind_id' and test_sl='$sl' and this_college_id='$this_campus_id'");

	//echo "fine"; exit;
	 }
  else
	 if($number_of_subject==4)
	 {          
	$res1=$con->query("insert into $marks_upload_temp_table_name($last_string)
	values('{$sl}','{$ind_id}','{$mark_line[0]}','{$mark_line[1]}','{$mark_line[2]}','{$mark_line[3]}','{$total_array[$key]}','{$this_campus_id}','{$this_R_U_W_string}')"); 

            $approved_status=1;
            $current_user_employee_id=$_SESSION['EMPLOYEE_ID'];
	$res2=$con->query("update 101_mismatch_approval_request set status='$approved_status',approval_status_by='$current_user_employee_id' where STUD_ID='$ind_id' and test_sl='$sl' and this_college_id='$this_campus_id'");
	 }

else	 
	if($number_of_subject==5)
	 {
	$res1=$con->query("insert into $marks_upload_temp_table_name($last_string)
	values('{$sl}','{$ind_id}','{$mark_line[0]}','{$mark_line[1]}','{$mark_line[2]}','{$mark_line[3]}','{$mark_line[4]}','{$total_array[$key]}','{$this_campus_id}','{$this_R_U_W_string}')"); 

             $approved_status=1;
             $current_user_employee_id=$_SESSION['EMPLOYEE_ID'];
	$res2=$con->query("update 101_mismatch_approval_request set status='$approved_status',approval_status_by='$current_user_employee_id' where STUD_ID='$ind_id' and test_sl='$sl' and this_college_id='$this_campus_id'");
	 }





}
	//echo $delete_count; exit;
	


	 //DELETING



if($delete_count>=1)
{
	$deleted_status=2;
	$current_user_employee_id=$_SESSION['EMPLOYEE_ID'];
	$res_del=$con->query("update 101_mismatch_approval_request set status='$deleted_status',approval_status_by='$current_user_employee_id' where STUD_ID IN($delete_selected) and this_college_id='$this_campus_id' and test_sl='$sl'"); 
}


//echo mysqli_error($con);


if(($delete_count>=1) && ($approval_count>=1))
{

	if($res1 && $res2 && $res_del)
	{
       mysqli_commit($con);
       echo "done";

	}
	  else
  {    mysqli_rollback($con);
       echo "ajax_error";
  }
}


else
	if(($delete_count==0) && ($approval_count>=1))
      {

			if($res1 && $res2)
			{
		       mysqli_commit($con);
		       echo "done";

			}
			  else
		  {    mysqli_rollback($con);
		       echo "ajax_error";
		  }
      }

else
	if(($delete_count>=1) && ($approval_count==0))
      {

			if($res_del)
			{
		       mysqli_commit($con);
		       echo "done";

			}
			  else
		  {    mysqli_rollback($con);
		       echo "ajax_error";
		  }
      }


exit;
}

//approve_delete:approve_delete,sl:sl,approve_selected:approve_selected,delete_selected:delete_selected


function get_initial_table_display($con,$this_campus_id) //CRB not required.........(Small =>Checked)
{


	$r=$con->query("select STATE_ID as state_id from t_campus where CAMPUS_ID='$this_campus_id'");
	$rw=mysqli_fetch_array($r);
	$state_id=$rw['state_id'];
	
	                          echo ' 
   <div class="panel-body">
     <div class="tab-content">
      <div role="tabpanel" class="tab-pane active" id="list">
                                <table class="table table-striped table-bordered table-list" >
                                    <thead>
                                        <!--<th>Test Code</th>
                                    	<th>Scanning Type</th>-->';

                                        echo '<th style="width: 2%;text-align:center;">Exam Id</th>';
                                       	// echo '<th>Approval</th>';
                                        echo '<th>Exam Date</th>';
                                        echo '<th>Start Date</th>';
                                    	echo '<th style="width:12%;">Test Code</th>
                                        <th>Board</th>
										<th style="color:red;">Status Info</th>
                                    	<th>Last_date_to_upload</th>
                                        <th >Generate rank </th>
										<th class="th-width">Campus View</th>
                                    </thead>
                                    <tbody> <tr>
        <td>John</td>
        <td>Doe</td>
        <td>john@example.com</td> <td>John</td>
        <td>Doe</td>
        <td>john@example.com</td> <td>John</td>
        <td>Doe</td>
        <td><i class="fa fa-eye" aria-hidden="true"></i></td>
      </tr><tr>
        <td>John</td>
        <td>Doe</td>
        <td>john@example.com</td> <td>John</td>
        <td>Doe</td>
        <td>john@example.com</td> <td>John</td>
        <td>Doe</td>
        <td><i class="fa fa-eye" aria-hidden="true"></i></td>
      </tr><tr>
        <td>John</td>
        <td>Doe</td>
        <td>john@example.com</td> <td>John</td>
        <td>Doe</td>
        <td>john@example.com</td> <td>John</td>
        <td>Doe</td>
        <td><i class="fa fa-eye" aria-hidden="true"></i></td>
      </tr>';
	$show_limit=$_POST['show_limit'];
	//$res=$con->query("select * from 1_exam_admin_create_exam where FIND_IN_SET($state_id,state_id) ORDER BY sl desc LIMIT $show_limit,8"); //S
	$res=$con->query("select sl,omr_scanning_type,result_generated1_no0,test_type,mode,test_code,model_year,paper,start_date,state_id,status_serialized,is_college_id_mobile_uploaded from 1_exam_admin_create_exam where FIND_IN_SET($state_id,state_id) ORDER BY sl desc LIMIT $show_limit,8");
							      $show_count=mysqli_num_rows($res);	
									if($show_count==0)
									{
                                       echo '<center><p style="color:red;font-=weight:bold;">No more Results to Show</p></center>';
										exit;
									}
	$class_name_array=array();
	$stream_name_array=array();
	$program_name_array=array();
	$group_name_array=array();
	
	while($row=mysqli_fetch_array($res))
	{    
	      $class_name_array=array();
	  $stream_name_array=array();
	  $program_name_array=array();
	      $group_name_array=array();
	      $omr_scanning_type=$row['omr_scanning_type'];
	

	
	  
	  
	    $test_sl=$row['sl'];
	 
	   $test_type=$row['test_type'];
	   $test_mode=$row['mode'];

                                  
	      $is_college_id_mobile_uploaded=$row['is_college_id_mobile_uploaded'];
	      $mobile_college_id_array=explode(",",$is_college_id_mobile_uploaded);

	      //echo json_encode($mobile_college_id_array); exit;
	$mobile_uploaded_status="0";
	      if(in_array($this_campus_id,$mobile_college_id_array))
	      {
	      	//echo "mobile_uploaded";
	      	$mobile_uploaded_status="1";
	      }
//echo $mobile_uploaded_status; exit;
   



	   
	       //$res_in=$con->query("select * from 1_exam_gcsp_id where test_sl='$test_sl'"); //S
	   $res_in=$con->query("select GROUP_ID,STREAM_ID,PROGRAM_ID,CLASS_ID from 1_exam_gcsp_id where test_sl='$test_sl'");
	   $count_ins=mysqli_num_rows($res_in);
	   

	   $res_recompute=$con->query("select is_uploaded from 1_exam_recompute_request_campus_id where campus_id='$this_campus_id' and sl='$test_sl'");
	   $count_recompute=mysqli_num_rows($res_recompute);
                                       $recompute_status="";
	   if($count_recompute!=0)
	   {

	   	$row_recompute=mysqli_fetch_array($res_recompute);
	   	$is_uploaded=$row_recompute['is_uploaded'];
	   	if($is_uploaded=="0"){
	   	$recompute_status="should_upload_again";
	   	}
	   }



	   
	   if($count_ins==1)
	  {
	  
	  
	  }
	  
	 while($row_in=mysqli_fetch_array($res_in))
	   {
	  $group_id=$row_in['GROUP_ID'];
	  $stream_id=$row_in['STREAM_ID'];
	  $program_id=$row_in['PROGRAM_ID'];
	  $class_id=$row_in['CLASS_ID'];
	  
	  $res_group=$con->query("select GROUP_NAME from t_course_group where GROUP_ID='$group_id'");
	  $row_group=mysqli_fetch_array($res_group);
	  $group_name_array[]=$group_name=$row_group['GROUP_NAME'];
	  
	  $res_stream=$con->query("select STREAM_NAME from t_stream where STREAM_ID='$stream_id'");
	  $row_stream=mysqli_fetch_array($res_stream);
	  $stream_name_array[]=$stream_name=$row_stream['STREAM_NAME'];
	  
	  $res_program_name=$con->query("select PROGRAM_NAME from t_program_name where PROGRAM_ID='$program_id'");
	  $row_program_name=mysqli_fetch_array($res_program_name);
	  $program_name_array[]=$program_name=$row_program_name['PROGRAM_NAME'];
	  
	  $res_class_name=$con->query("select DISPLAY_NAME from t_study_class where CLASS_ID='$class_id'");
	  $row_class_name=mysqli_fetch_array($res_class_name);
	  $class_name_array[]=$class_name=$row_class_name['DISPLAY_NAME'];
	  
	  //$res_c
	   
	   
	   }
	   
	
	
	
	
	
	 $status_serialized_array=$row['status_serialized'];
	 if($status_serialized_array !="")
	 { $status_non_serialized_array=unserialize($status_serialized_array);
	       if(isset($status_non_serialized_array[$this_campus_id]))
	   {
	   $success_or_danger="success";
	   }
	   else{
	     $success_or_danger="danger";
	       }
	 
	 }
	 else
	 {
	 $success_or_danger="danger"; 
	 }
	 
	 
	
	 
	
	          echo '  <tr>
                                        	<td>'.$row['sl'].'</td>
	<!--<td>'.$row['omr_scanning_type'].'</td>-->';
                        
                          $this_campus_id=$_SESSION['campus_id'];
                          $res_approval=$con->query("select count(*) as c from 101_mismatch_approval_request where test_sl='$test_sl' and this_college_id='$this_campus_id' and status='0'");
                          $row_approval=mysqli_fetch_array($res_approval);
                           $approval_count=$row_approval['c'];
                                      if($approval_count >=1)
                                      {
  if($omr_scanning_type=="non_advanced")
  {
  	  echo '<td><button type="submit" class="btn btn-danger btn-fill" onclick="display_result_of_sl('.$row['sl'].')" >NA(X)</button></td>';
  }

  else
  	if($omr_scanning_type=="advanced")
  	{
  	echo '<td><button type="submit" class="btn btn-danger btn-fill" onclick="display_result_of_sl('.$row['sl'].')" >NA(X)</button></td>'; //loluadv
  	}
  
                                             
                                      }
                                      else //leenu
                                      {

    if($omr_scanning_type!="merged")
  {
      echo '<td><button type="submit" class="btn btn-success btn-fill">AP(✔)</button></td> ';
  }
  else
  {
    $sl_array=array();
  	$rr=$con->query("select merged_exam_id from 1_merged_exams where exam_id='$test_sl'");
    while($rww=mysqli_fetch_array($rr))
    {
    	$sl_array[]=$rww['merged_exam_id'];
    }

    $sl_string=implode(",",$sl_array);
  	echo '<td colspan="2"></td>
  	<td>'.$row['test_code'].'</td>

  	<td colspan="9" style="color:green;font-weight:bold;">(IIT_P1P2) MERGED EXAM OF SL: '.$sl_string. '<img src="../assets/img/more.png" style=" cursor:pointer;height: 23px;width: 23px;margin-left: 1%;" onClick="display_merged(\'' . $sl_string . '\')"></td>';
  }


                                      }


                                       $start_date=$row['start_date'];
	  $date_d_m_y = date("d-m-Y", strtotime($start_date));


	     if($omr_scanning_type !="merged")
	     {
	     	echo '<td>'.$date_d_m_y.'</td><td>'.$row['test_code'].'</td>';

	
	     }
                                            




	$len=sizeof($class_name_array);
	if($len==1)
	{
	echo '<td>'.$group_name_array[0].'</td><td>'.$class_name_array[0].'</td><td>'.$stream_name_array[0].'</td><td>'.$program_name_array[0].'</td>';	
	}
	else
	    if($len>1)
	{
	$string="";
	$display_two="";
	$it=0;
	for($i=0;$i<$len;$i++)
	{   $a=$class_name_array[$i];
	$b=$stream_name_array[$i];
	$c=$program_name_array[$i];
	$d=$group_name_array[$i];
	$string=$string."( (".$d."-".$a."-".$b."-".$c.")"; 
	if($i==0)
	{  $it++;
	$display_two=$display_two."(".$d."-".$a."-".$b."-".$c.")";
	}
	}

	
                                             if($it>=0)
                                             {
              echo '<td colspan="4">'.$display_two.'<img src="../assets/img/more.png" style=" cursor:pointer; height: 23px;width: 23px;margin-left: 1%;" onClick="display_all(\'' . $string . '\',\''.$row['test_code'].'\')"></td>';
                                             }
                                             else
                                             {
                                             	echo '<td colspan="4">'.$string.'</td>';
                                             }
	}



	
	$t=$row['test_type'];
	$res_now1=$con->query("select test_type_name from 0_test_types where test_type_id='$t'");
	$row_now1=mysqli_fetch_array($res_now1);
	$test_type_name=$row_now1['test_type_name'];
	
	$m=$row['mode'];
	$res_now2=$con->query("select test_mode_name from 0_test_modes where test_mode_id='$m'");
	$row_now2=mysqli_fetch_array($res_now2);
	$test_mode_name=$row_now2['test_mode_name'];
	
	
	$paper=$row['paper'];
	if($paper=="")
	{
	$paper=$paper;
	}
	else
	{
	$paper="-".$paper;
	}
	
	
	
	
	
	
	if($omr_scanning_type !="merged")
	{
	echo '<td>'.$test_type_name.'</td>
	<td>'.$test_mode_name.'</td>
	<td>'.$row['model_year'].' '.$paper.'</td>';	
	}
	
                                        
                                            
	 if($omr_scanning_type=="non_advanced")
	 {
	 echo ' <td> 
                                           <button type="submit" class="btn btn-info btn-fill" onclick="view_imk_modal_of_sl('.$row['sl'].')" data-toggle="modal" >I-M-K</button></td>';
	 }
	 else
	if($omr_scanning_type=="advanced")
	 {
	 echo ' <td> 
                                           <button type="submit" class="btn btn-info btn-fill" onclick="view_imk_modal_of_sl_advanced('.$row['sl'].')" data-toggle="modal" >I-M-K</button></td>';
	 }
	 
	
	   if($omr_scanning_type !="merged")
	   {
	   	   echo '<td> 
                                           <button type="submit" class="btn btn-info btn-fill" onclick="view_status_info_modal_of_sl('.$row['sl'].')" data-toggle="modal" >Status</button></td>';
	   }
	 


	 if($omr_scanning_type=="merged")
	 {
	 	echo '<td ></td>';
	 }
	   
	   
                                        	 if($omr_scanning_type=="non_advanced")
	 {  
                                                if($recompute_status=="should_upload_again")
                                                {
echo '<td><button type="submit" class="btn btn-warning btn-fill" onclick="check_initial_condition_of_sl('.$row['sl'].')" >ReUpld</button></td>';
                                                }
                                                else
                                                {
	 	if($success_or_danger=="success"){$out="Done✔";}
                                                if($success_or_danger=="danger"){$out="Upload";}

                                               if(($mobile_uploaded_status=="1") && ($out=="Upload"))
                                               {
echo '<td><button type="submit" class="btn btn-primary btn-fill" onclick="check_initial_condition_of_sl('.$row['sl'].')" >Web<i class="fa fa-refresh" aria-hidden="true"></i></button></td>';

                                               }
                                               else
                                               {
                                               	echo '<td><button type="submit" class="btn btn-'.$success_or_danger.' btn-fill" onclick="check_initial_condition_of_sl('.$row['sl'].')" >'.$out.'</button></td>';
                                               }

                                            

                                                }







	 }
	 else
	if($omr_scanning_type=="advanced")
	 { 

                                                if($recompute_status=="should_upload_again")
                                                {
echo '<td><button type="submit" class="btn btn-warning btn-fill" onclick="check_initial_condition_of_sl_advanced('.$row['sl'].')" >ReUpld</button></td>';	

                                                }
                                                else
                                                {

	 	if($success_or_danger=="success"){$out="Done✔";}
                                                if($success_or_danger=="danger"){$out="Upload";}


                                                   if(($mobile_uploaded_status=="1") && ($out=="Upload"))
                                               {

  echo '<td><button type="submit" class="btn btn-primary btn-fill" onclick="check_initial_condition_of_sl_advanced('.$row['sl'].')" >Web<i class="fa fa-refresh" aria-hidden="true"></i></button></td>';	
                                               }
  
                                               else
                                               {

  echo '<td><button type="submit" class="btn btn-'.$success_or_danger.' btn-fill" onclick="check_initial_condition_of_sl_advanced('.$row['sl'].')" >'.$out.'</button></td>';	
                                               }

                                                }




	 }
	  
	  
	  if($omr_scanning_type=="non_advanced")
	  {
	   echo '<td><button type="submit" class="btn btn-info btn-fill" onclick="display_result_of_sl('.$row['sl'].')" >Result</button></td>
                                             ';  
	  }
	 else
	if($omr_scanning_type=="advanced")
	 {
	echo '<td><button type="submit" class="btn btn-info btn-fill" onclick="display_result_of_sl('.$row['sl'].')" >Result</button></td>
                                             ';	 
	 }
	 else
	if($omr_scanning_type=="merged")
	 {
	echo '<td><button type="submit" class="btn btn-info btn-fill" onclick="display_result_of_sl('.$row['sl'].')" >Result</button></td>
                                             ';	 
	 }

	
	 /* if($row['result_generated1_no0']==1)
         	{
	                        	echo'<td><button type="submit" class="btn btn-info btn-fill"  ><a href="pdf_files/generate_pdf.php?exam_identifier='.$row['sl'].'&code_identifier='.$this_campus_id.'" style="    color: white;" target="_blank">PDF</a></button></td>
	                                          <td><button type="submit" class="btn btn-info btn-fill" ><a href="pdf_files/generate_excel.php?exam_identifier='.$row['sl'].'&code_identifier='.$this_campus_id.'" style="    color: white;" target="_blank">EXCEL</a></button></td></tr>';
	                                        	
	          	}       
	          else{
	          	echo'<td><button type="submit" class="btn btn-info btn-fill" disabled >PDF</button></td>
	                                          <td><button type="submit" class="btn btn-info btn-fill" disabled>EXCEL</button></td></tr>';                        	
	               }	*/  
                                            
	if($success_or_danger=="success")
	{
	echo '<td><a href="generate-zip/index.php?sl='.$row['sl'].'&exam_type='.$omr_scanning_type.'&code_identifier='.$this_campus_id.'" style=" color: white;" target="_blank"><img src="../assets/img/file.png" style="height:30px;width:30px"/></a></td>';
	}
	else
	{echo '<td></td>';
	}
	
	               if($row['result_generated1_no0']==1)
         	{
	                        	echo'
	        <td><a href="pdf_files/?exam_identifier='.$row['sl'].'&code_identifier='.$this_campus_id.'" style="    color: white;" target="_blank"><img src="../assets/img/pdf.png" style="height:30px;width:30px"/></a></td>
	                                          <td><a href="pdf_files/generate_excel.php?exam_identifier='.$row['sl'].'&code_identifier='.$this_campus_id.'" style="    color: white;" target="_blank"><img src="../assets/img/excel.png" style="height:30px;width:30px"/></a></td></tr>';
	                                        	
	          	}       
	          else{
	          	echo'<td></td>
	                                          <td></td></tr>';                        	
	               }	


	}
	

	
	
	
	
	
                                       
                                   echo ' </tbody>
                                </table>

                            </div></div></div>';
  
	//  exit i removed
	//exit;
}


function check_initial_condition_of_sl($con,$this_campus_id) //CRB not required......(Small =>Checked)
{
	$sl=$_POST['sl'];

	$current_date=current_date_y_m_d();
    $current_time=current_time_12_hour_format_h_m_s();

	
	//$res=$con->query("select * from 1_exam_admin_create_exam where sl='$sl'");//S
	$res=$con->query("select last_date_to_upload,last_time_to_upload,subject_string_final,to_from_range,total_questions,mark_file_long_string,mark_file_rows,key_answer_file_long_string,status_serialized from 1_exam_admin_create_exam where sl='$sl'");

	$row=mysqli_fetch_array($res);
	
	$subject_string_final=$row['subject_string_final'];
	$to_from_range=$row['to_from_range'];
	$total_questions=$row['total_questions'];
	$mark_file_long_string=$row['mark_file_long_string'];
	$mark_file_rows=$row['mark_file_rows'];
	$key_answer_file_long_string=$row['key_answer_file_long_string'];
	$last_date_to_upload=$row['last_date_to_upload'];
	$last_time_to_upload=$row['last_time_to_upload'];

	


    $res_recompute=$con->query("select is_uploaded from 1_exam_recompute_request_campus_id where campus_id='$this_campus_id' and sl='$sl'");
   $count_recompute=mysqli_num_rows($res_recompute);

   if($count_recompute!=0)
   {

   	$row_recompute=mysqli_fetch_array($res_recompute);
   	$is_uploaded=$row_recompute['is_uploaded'];
   	if($is_uploaded=="0"){
   	echo "not_there"; exit;
   	}
   	else
   	if($is_uploaded=="1")
   	{
   	echo "already_there"; exit;
   	}
   }


	
	if($last_date_to_upload !="")
	{

	if($current_date>$last_date_to_upload)
	{  echo "date_over";
	exit;
	}
	else
	if($current_date==$last_date_to_upload)
	{  
        if($current_time > $last_time_to_upload)
        {
        	echo "date_over";
	    exit;
        }

	}	



	}
	
	
	if(($subject_string_final=="")||($to_from_range=="")||($total_questions==0)||($mark_file_long_string=="")||($mark_file_rows==0)||
	($key_answer_file_long_string==""))
	{
	echo "i-m-k_incomplete";
	exit;
	}
	
	
	$status_serialized=$row['status_serialized'];
	if($status_serialized !="")
	{
	  $status_non_serialized_array=unserialize($status_serialized);	
	  if(isset($status_non_serialized_array[$this_campus_id]))
	  {
	  echo "already_there"; exit;
	  }
	  else
	  {
	  echo "not_there"; exit;
	  }
	}
	else
	{
	echo "not_there"; exit;
	}
	
	
	
	
	exit;
}
function get_all_info_of_sl($con) //CRB not required......(Small =>Checked)
{
	$sl=$_POST['sl'];
	
	//$res=$con->query("select sl,omr_scanning_type,test_code, from 1_exam_admin_create_exam where sl='$sl'"); //S
	$res=$con->query("select sl,omr_scanning_type,test_code,is_college_id_mobile_uploaded from 1_exam_admin_create_exam where sl='$sl'");


	$row=mysqli_fetch_array($res);
	$test_code=$row['test_code'];
	$exam_id=$row['sl'];
	$omr_scanning_type=$row['omr_scanning_type'];
	$no_reprocess="no_reprocess";
	if($omr_scanning_type=="advanced"){$dat_or_iit=".IIT";} else if($omr_scanning_type=="non_advanced"){$dat_or_iit=".DAT";}
	$this_campus_id=$_SESSION['campus_id'];  //$campus_id=$_SESSION['campus_id'];

                                  
	      $is_college_id_mobile_uploaded=$row['is_college_id_mobile_uploaded'];
	      $mobile_college_id_array=explode(",",$is_college_id_mobile_uploaded);

	     // echo json_encode($mobile_college_id_array); //exit;
	      $mobile_uploaded_status="0";





	      if(in_array($this_campus_id,$mobile_college_id_array))
	      {
	      	//echo "mobile_uploaded";
	      	$mobile_uploaded_status="1";
	      }

//echo "mobile up status=>".$mobile_uploaded_status."<--";


	
	 echo ''.$mobile_uploaded_status.'<form id="myform" method="post">

             <p style="background-color: #7e7eef;color: white; text-shadow: 2px 2px 4px #000000;">  Test Code: '.$test_code.' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Exam ID: '.$exam_id.'  </p>
                    <div class="form-group">
                        <br>
                        <p style="display:inline;margin-left: 10%;">Select '.$dat_or_iit.' File :</p><input style="display:inline;    margin-left: 2%;"  type="file" id="myfile" />

<input type="button" id="btn" class="btn btn-info btn-fill"
 onclick="upload_and_process_dat_of_exam_sl('.$sl.',\''.$omr_scanning_type.'\',\''.$no_reprocess.'\')" value="Upload" style=" margin-left: 10%;"/>
	
                    </div>
                    <div class="form-group" style="color: #847575;">
	    
	<center><b style="margin-left:-41%;">Step(1 of 2): Uploading '.$dat_or_iit.' to the Server</b></center>
                        <div class="progress" style="width: 80%;margin-left: 10%;">
	   
                            <div class="progress-bar progress-bar-success myprogress" role="progressbar" style="width:0%;color:black;font-weight:bold;"><center>0&nbsp;Percent&nbsp;Completed</center></div>
                        </div>

                        <div class="msg" style="margin-left:38%;color:#6c9e33"></div>
	
                    </div>

                   
                </form>
	<center><b style="margin-left:-33%;color: #847575;">Step(2 of 2): Processing '.$dat_or_iit.' to Output the Result</b></center>
	<div style="width:80%;position:relative;top:48%;left:10%;z-idex:100000000;"><b>
                <div id="pgb" style="border-bottom: 1px solid #d4acac;color:#6c9e33 ! important;">
                </div>
	</b>
	
	<div style="margin-left:88%;"><br>
	
	<button type="button" id="ref_page" class="btn btn-danger">Close</button>
	</div><br>
                </div>
	';
	
	//exit;
}//function ends


// just after file uploads this function will run..
function dat_conversion_function($con,$this_campus_id) //BOTH ADV AND NON ADV GOING...   // CRB required---DO IT ......
{ //echo "dat_conversion_function starts"; exit;
//exit;

//echo "df starts"; exit;


//echo "daaaa"; exit;

if(is_array($this_campus_id)) // passing array in reprocessing
{
//echo "resp array";
$passing_array=$this_campus_id;
//echo json_encode($this_campus_id); 
$description="recompute";
$this_campus_id=$passing_array[1];  // 0 what it does.... // 1 this_college_id // 2 sl of exam

$sl=$passing_array[2]; 
$test_code_sl_id=$passing_array[2];
}
else
{// This part is for not recompute....
 //POST DATA can read here
	$description="not_recompute";
	$sl=$_POST['sl'];  // sl of a Test 
	$test_code_sl_id=$sl;

	//echo "nrc";exit;
}


if($description=="not_recompute")	
{
   mysqli_autocommit($con,FALSE);
}


//Check Recompute -> Delete Previous Results
  //Check this condition again....

// in college level re uploading... if college re uploads and runs usual dat_convertion function... it would be non_recompute n reuploading.. but needs to check in 1_exm_recomp_req...++
// even if not re uploading do we need to delete this campus level previous temp and final??..
// in case of recomputing also.. need to delete college wise temp and final ... (what about 101_mismatch approval req??)
// delete_this_function..... deletes 101_mismatch_approval also...
// in case of recompute... 101_mismatch_approval SHOULD NOT DELETE...only temp and final rank should delete...!!
	if($description=="not_recompute") // usual old process
	{
	$res_recompute=$con->query("select * from 1_exam_recompute_request_campus_id where campus_id='$this_campus_id' and sl='$sl'");
	   $count_recompute=mysqli_num_rows($res_recompute);
                                       $recompute_status="";
	   if($count_recompute!=0)
	   {

	   	$row_recompute=mysqli_fetch_array($res_recompute);
	   	$is_uploaded=$row_recompute['is_uploaded'];
	   	if($is_uploaded=="0")
	   	{
	   	
	   	delete_this_campus_all_temp_and_final_result($con,$sl,$this_campus_id);
	   	//deletes all previous temp and final results...
	   	//
	   	}


	   }
	 //  echo "breaking here"; exit;
	}
	  	   
// line verified
	   //


//echo $omr_scanning_type; exit;





	
	//ADD MANY CHECK CONDITION SHOULD ADD HERE.. LIKE KEY INSERTED OR NOT THERE...+++++

	//DELETE PREVIOUS MARKS FIRST OF THIS SL AND COLLEGE

	$res=$con->query("select * from 1_exam_admin_create_exam where sl='$sl'");
	$row=mysqli_fetch_array($res);
	$test_mode_id=$row['mode'];
	$res_table_name=$con->query("select marks_upload_temp_table_name from 0_test_modes where test_mode_id='$test_mode_id'");
	$row_table_name=mysqli_fetch_array($res_table_name);
	$marks_upload_temp_table_name=$row_table_name['marks_upload_temp_table_name'];

	$test_code=$row['test_code'];
	$omr_scanning_type=$row['omr_scanning_type'];
	
	
// RIYAZ CODE INCLUDE HERE....

/*
//for checking old dat/iit uploading....
if($description=="not_recompute")
{//desc not_compute starts

	//echo "931 done"; exit;
  	$exam_id=$sl;
	$campus_id=$_SESSION['campus_id'];
	$file_to_compare='';
	$campus_name=get_campusName($campus_id,$con);

	if($omr_scanning_type=='advanced'){
	
	$file_to_compare="uploads/".$exam_id."/first/".$campus_name."_".$exam_id.".iit" ;
	
	}elseif($omr_scanning_type=='non_advanced'){
	
	$file_to_compare="uploads/".$exam_id."/first/".$campus_name."_".$exam_id.".dat" ;
	
	
	}
    
	//echo "fa"; exit;
	$status = file_anaysis($con,$file_to_compare,$omr_scanning_type);
	
	if($status['status']==1)

	{

	
	//var_dump($status['duplicate_path']);
	//echo "Uploaded file is alreay found in server on Path=\t".$status['duplicate_path'];
	//exit;	  
               
             unlink($file_to_compare);
	     $response_array=array();
	     $response_array[0]="Uploaded_file_exists";
	     $response_array[1]=$status['duplicate_path'];
	 echo json_encode($response_array);
	 exit;
	
	}
}//desc not_compute_ends
//
	*/
	//echo "969"; exit;
//echo $omr_scanning_type;
//echo $description; exit;

    if($omr_scanning_type=="non_advanced")
	{
	//OMR SCANNING TYPE =COMMON=NON ADVANCED OUTER START
   
	if($description=="not_recompute")
	{
	 $filename="uploads/$sl/temp_$this_campus_id.dat";    //THIS WILL TAKE BOTH .DAT and .dat
	}
	else
	if($description=="recompute")
	{
	$filename="../../College/3_view_created_exam/uploads/$sl/final/$this_campus_id.dat";
	}




	if (file_exists($filename))
	{
	$String = file_get_contents($filename);
	if($String === FALSE)
	{
	 $response_array=array();
	     $response_array[0]="file_not_exist";
	     $response_array[1]="file_not_exist ERROR";
	 echo json_encode($response_array);
	 exit;
	 
	  
	}
	}
	else
	{        $response_array=array();
	     $response_array[0]="file_not_exist";
	     $response_array[1]="file_not_exist ERROR";
	 echo json_encode($response_array);
	 exit;
	}
	

//DEFINITIONS AND CONSTANT WRT PARTICULAR TEST

  $subject_string=$row['subject_string_final']; // id of final subject string
  $subject_string_array=explode(",",$subject_string);
  
  $temp=array();
  foreach($subject_string_array as $ind_id)
  {
	  $res_this=$con->query("select subject_name from 0_subjects where subject_id='$ind_id'");
	  $row_this=mysqli_fetch_array($res_this);
	   $t=$row_this['subject_name'];	   
	  $temp[]=strtoupper($t);
  
  }
  
  $subject_string_array=$temp;
  
  
  //$subject_string_array=explode(",",$subject_string);
  $number_of_subject=sizeof($subject_string_array);
  $to_from_range=$row['to_from_range'];
  $to_from_range="0,".$to_from_range;
  $to_from_range_array=explode(",",$to_from_range);
  $total_question=$row['total_questions'];


//MARK FILE FOR 200 QUESTIONS

$mark_file_long_string=$row['mark_file_long_string'];
//$mark_file_long_string="0,".$mark_file_long_string;
$mark_file_long_string_array=explode(",",$mark_file_long_string);
$mark_file_rows=$row['mark_file_rows'];


$positive_mark_array=array();
$positive_mark_array[0]=0;

$negative_mark_array=array();
$negative_mark_array[0]=0;
$out=1;
$iterate_in=0;
$l=1;
for($out=1;$out<=$mark_file_rows;$out++)
{ 
	$this_from=$mark_file_long_string_array[$iterate_in++];
	$this_to=$mark_file_long_string_array[$iterate_in++];
	$this_positive_mark=$mark_file_long_string_array[$iterate_in++];
	$this_negative_mark=$mark_file_long_string_array[$iterate_in++];
	
	//LOOP Out
	
	for($l=$this_from;$l<=$this_to;$l++)
	{
	$positive_mark_array[$l]=$this_positive_mark;
	$negative_mark_array[$l]=$this_negative_mark;
	}
	
	
	
}

$key_answer_file_long_string=$row['key_answer_file_long_string'];
$key_answer_file_long_string="0,".$key_answer_file_long_string;
$initial_key_array=explode(",",$key_answer_file_long_string);
//echo json_encode($initial_key_array);
$correct_answer_key=array();

foreach($initial_key_array as $val)
{
// 1A   2B   4C   8D

   if($val=="A") {$val="1";}
   else
   	if($val=="B") {$val="2";}
   else
   	if($val=="C") {$val="4";}
   else
   	if($val=="D") {$val="8";}


	//if($val=="3"){$val="4";}
	//else
	//if($val=="4"){$val="8";}
	$correct_answer_key[]=$val;






}
//echo json_encode($correct_answer_key);
//exit;
	 

$type="200";

if($type !="200") { echo "Invalid Type";exit;}


$big_array=explode("No.=",$String);

$Total_Students_Count= sizeof($big_array);
$Total_Students_Count=$Total_Students_Count-1;


//echo "Total Students Count:".$Total_Students_Count=$Total_Students_Count-1; exit;
//echo '<br>';

$final_array_list=array();
$students_id_array=array();
$current_usn_flag_array=array();

   //foreach ($big_array as $val)
    $num=1; // Start from 1st Index   ### SKIP THE FIRST INDEX AS 1st INDEX IS ZERO
    $i=1;
    $students_id_array[]="Starting_0_Index_Dummy";
	$current_usn_flag_array[]="0";
    $ccc=1;




	foreach(array_slice($big_array, $num) as $key => $val)

{ //$val is individual line
$val=trim($val);
	//echo $val; echo "\n";
	$individual_array = preg_split('/\s+/', $val);
   $j=1;

   $student_marked[$i][0]=$individual_array[0]."-".$individual_array[1];
   
   $current_usn_with_flag_if_exist=$individual_array[0];
   $current_usn_with_flag_if_exist_array=explode("-",$current_usn_with_flag_if_exist);
   $current_usn=$current_usn_with_flag_if_exist_array[0];
   if(isset($current_usn_with_flag_if_exist_array[1]))
   {
	   $current_usn_flag=$current_usn_with_flag_if_exist_array[1];
   }
   else
	   $current_usn_flag="0";
   
   $students_id_array[]=$current_usn;
   //$students_id_array[]=$individual_array[0];
   $current_usn_flag_array[]=$current_usn_flag;
   	  
   
   
   //echo json_encode($students_id_array);

//exit;

    for($k=202;$k<=401;$k++)
    {
      
    	$student_marked[$i][$j]=$individual_array[$k];
    	$j++;

    }
     $s=$i;
//echo $number_of_subject; exit;

$this_student_R_U_W_string="";


     for($n=1;$n<=$number_of_subject;$n++)
     {
     $current_range=$to_from_range_array[$n];
     $to_from_explode=explode("-",$current_range);
     $from=$to_from_explode[0];
     $to=$to_from_explode[1];
     $this_subject_total=0;

         for($this_range=$from;$this_range<=$to;$this_range++)
         { //echo "Range:".$this_range;
           //echo $student_marked[$s][$this_range] ; echo "=";
           //echo $correct_answer_key[$this_range]; //exit;
    //ADD GRACE>>QUESTION DELETE>>OR>>
	   
                      $check_OR = substr($correct_answer_key[$this_range], 0, 3);
                     if($check_OR=="OR-")
                         { 

	         if($student_marked[$s][$this_range]==0)
	     	  {
	     	  	$this_student_R_U_W_string.="U";
	     	  	continue; //didnt attempt
	     	  }
	              if($student_marked[$s][$this_range]=="1"){$student_marked[$s][$this_range]="A";}
	       	  if($student_marked[$s][$this_range]=="2"){$student_marked[$s][$this_range]="B";}
	       	  if($student_marked[$s][$this_range]=="4"){$student_marked[$s][$this_range]="C";}
	       	  if($student_marked[$s][$this_range]=="8"){$student_marked[$s][$this_range]="D";}

	     	$OR_individual_array=explode("-",$correct_answer_key[$this_range]);
	     	$correct_count=0;
	       foreach($OR_individual_array as $k=>$ind_or)
	       {  if ($k == 0) 
	       	  continue;
	       	  
	          	if($student_marked[$s][$this_range]==$ind_or)
	       	{   
	       	$correct_count++; 
	       	}
	       }
	        if($correct_count>0){$this_subject_total= $this_subject_total+$positive_mark_array[$this_range];$this_student_R_U_W_string.="R";}
	        else if($correct_count==0){$this_subject_total= $this_subject_total-$negative_mark_array[$this_range]; $this_student_R_U_W_string.="W";}


                         }


	 else if($correct_answer_key[$this_range]=="G"){$this_subject_total= $this_subject_total+$positive_mark_array[$this_range];$this_student_R_U_W_string.="G";}
	 else if($correct_answer_key[$this_range]=="X"){$this_subject_total= $this_subject_total;$this_student_R_U_W_string.="D";}

                        else
	if($student_marked[$s][$this_range]==0) // CATCH 0 HERE
                       {
                       	  $this_student_R_U_W_string.="U";
                          $this_subject_total=$this_subject_total+0;
                       }
	   else
	                  if($student_marked[$s][$this_range]==$correct_answer_key[$this_range])
                       {
                       	  $this_student_R_U_W_string.="R";
                          $this_subject_total= $this_subject_total+$positive_mark_array[$this_range];

                       }
                        else
	if($student_marked[$s][$this_range]!=$correct_answer_key[$this_range])    
                       {
                       	  $this_student_R_U_W_string.="W";
                          $this_subject_total= $this_subject_total-$negative_mark_array[$this_range];
                       }
	    

                        // echo $this_subject_total."-";


                         $students_calculated_marks[$s][$n]=$this_subject_total;
                         $students_calculated_marks[$s]['R_U_W_string']=$this_student_R_U_W_string;

                         //echo json_encode($students_calculated_marks); exit;

                        
                        //echo "-".$this_subject_total."-";
         } //echo json_encode($students_calculated_marks);   exit;

 
     }

$i++;
//exit;
//unset($individual_array);
unset($student_marked);
   
}// exit;


//echo json_encode($students_calculated_marks); exit;

//THIS BELOW IS WITHOUT CONSIDERING DYNAMIC NO OF SUBJECT LOOP...BELOW IS ONLY FOR DB INSERTION.. 
//echo "db_before_exit";exit;


 /*
          $response_array=array();
	  $response_array[]="success";
	  $response_array[]="non_advanced";
	  $response_array[]=$students_id_array;
	  $response_array[]=$number_of_subject;
	  $response_array[]=$students_calculated_marks;
	  $response_array[]="non_advanced";
	  
	  echo json_encode($response_array);
	*/	  
	  
	  //
 //lolu


// for recompute 
           if($description=="not_recompute")
           {
	  $response_array=array();
	  $response_array[]="success";
	  $response_array[]="non_advanced";
	  $response_array[]=$sl;
	  $response_array[]=$students_id_array;
	  $response_array[]=$number_of_subject;
	  $response_array[]=$students_calculated_marks;
	  $response_array[]="0";
	  $response_array[]=$current_usn_flag_array;
	
	  
	  $omr_scanning_type="non_advanced";

//till here...
	  validate_students($con,$response_array,$sl,$omr_scanning_type);



           }

           else
           	if($description=="recompute")
           	{

          $response_array=array();
	  $response_array[]="success";
	  $response_array[]="non_advanced";
	  $response_array[]=$sl;
	  $response_array[]=$students_id_array;
	  $response_array[]=$number_of_subject;
	  $response_array[]=$students_calculated_marks;
	  $response_array[]="0";
	  $response_array[]=$current_usn_flag_array;

	  $response_array[]="recompute";
	  $response_array[]=$this_campus_id;
//in case of recompute... validating students are not done...

	  $omr_scanning_type="non_advanced";
	 
	  //echo "db ins";exit;
          db_insert_and_status_update_success($con,$response_array);

           	}
         
  if($description=="not_recompute")
           {  exit;
           }

	 
	  

/*





	$subject_array=$subject_string_array;
	
	
	$length=sizeof($subject_array);

//echo "here"; echo $number_of_subject; //exit;
$total=0;
for($i=1;$i<=$Total_Students_Count;$i++)
{
	
	$inside_string="test_code_sl_id,TEST_CODE,STUD_ID,";
	$subject_string=implode(",",$subject_array);
	
	$last_string=$inside_string.$subject_string.",TOTAL,this_college_id";
	
	 //exit; 
	//echo json_encode($students_calculated_marks);
	//exit;
	 
	 if($number_of_subject==3)
	 { $total=$students_calculated_marks[$i][1]+$students_calculated_marks[$i][2]+$students_calculated_marks[$i][3];
	$res=$con->query("insert into $marks_upload_temp_table_name($last_string)
	values('{$test_code_sl_id}','{$test_code}','{$students_id_array[$i]}','{$students_calculated_marks[$i][1]}','{$students_calculated_marks[$i][2]}','{$students_calculated_marks[$i][3]}','{$total}','{$this_campus_id}')"); 
	 }
	 	 if($number_of_subject==4)
	 { $total=$students_calculated_marks[$i][1]+$students_calculated_marks[$i][2]+$students_calculated_marks[$i][3]+$students_calculated_marks[$i][4];
	$res=$con->query("insert into $marks_upload_temp_table_name($last_string)
	values('{$test_code_sl_id}','{$test_code}','{$students_id_array[$i]}','{$students_calculated_marks[$i][1]}','{$students_calculated_marks[$i][2]}','{$students_calculated_marks[$i][3]}','{$students_calculated_marks[$i][4]}','{$total}','{$this_campus_id}')"); 
	 }
	 	 	 if($number_of_subject==5)
	{ $total=$students_calculated_marks[$i][1]+$students_calculated_marks[$i][2]+$students_calculated_marks[$i][3]+$students_calculated_marks[$i][4]+$students_calculated_marks[$i][5];
	$res=$con->query("insert into $marks_upload_temp_table_name($last_string)
	values('{$test_code_sl_id}','{$test_code}','{$students_id_array[$i]}','{$students_calculated_marks[$i][1]}','{$students_calculated_marks[$i][2]}','{$students_calculated_marks[$i][3]}','{$students_calculated_marks[$i][4]}','{$students_calculated_marks[$i][5]}','{$total}','{$this_campus_id}')"); 
	 }

	
	//echo mysqli_error($con);
	
	/*
	if($i%1==0)
	{
	$myfile = fopen("uploads_process_track/Input.txt", "w") or die("Unable to open file!");
        $txt = ($i*100)/$Total_Students_Count;
	if($txt==100){$txt=99;}
        fwrite($myfile, $txt);
        fclose($myfile);
	}
	*0/
}

//COPYING>> START>>> DELETE LATER
//DO LOCK STATUS LATER
// CURRENT DATE AND TIME TAKE SAME..DONT TAKE SEPERATE
$res2=$con->query("select * from 1_exam_admin_create_exam where sl='$sl'");
$row2=mysqli_fetch_array($res2);
$current_hitting=$row2['current_hitting'];
$omr_scanning_type=$row2['omr_scanning_type'];
$test_code_sl_id=$row2['sl'];
$test_code=$row2['test_code'];
	$current_date=current_date_y_m_d();
    $current_time=current_time_12_hour_format_h_m_s();

if($current_hitting==0)
{
	//$con->query("update 1_exam_admin_create_exam set current_hitting='$current_hitting' where $current_hitting='$zero' and sl='$sl' ");
}

$status_serialized=$row2['status_serialized'];
if($status_serialized=="")
{
	$status_non_serialized_array=array();

	$status_non_serialized_array[$this_campus_id]=$Total_Students_Count." ".$current_date." ".$current_time;
	$status_serialized_array=serialize($status_non_serialized_array);
	$res1=$con->query("update 1_exam_admin_create_exam set status_serialized='$status_serialized_array' where sl='$sl'");
}
else
{
 $status_serialized_array=$status_serialized;
 $status_non_serialized_array=unserialize($status_serialized_array);

 $status_non_serialized_array[$this_campus_id]=$Total_Students_Count." ".$current_date." ".$current_time;
 $status_serialized_array=serialize($status_non_serialized_array);
 $res1=$con->query("update 1_exam_admin_create_exam set status_serialized='$status_serialized_array' where sl='$sl'");
 
}
//DO LOCK HERE ALSO

$track_individual_branch_uploads_serialized=$row2['track_individual_branch_uploads'];
$this_branch_string="";
if($track_individual_branch_uploads_serialized=="")
{
	
	$this_branch_string=$this_branch_string.$current_date." ".$current_time;
	

	$track_individual_branch_uploads_non_serialized_array[$this_campus_id]=$this_branch_string;
	$track_individual_branch_uploads_serialized_array=serialize($track_individual_branch_uploads_non_serialized_array);
	
	$res2=$con->query("update 1_exam_admin_create_exam set track_individual_branch_uploads='$track_individual_branch_uploads_serialized_array' where sl='$sl'");
}
else
{
	$track_individual_branch_uploads_serialized_array=$track_individual_branch_uploads_serialized;
	$track_individual_branch_uploads_non_serialized_array=unserialize($track_individual_branch_uploads_serialized_array);
	
	
	if(isset($track_individual_branch_uploads_non_serialized_array[$this_campus_id]))
	{
	 $this_branch_string=$track_individual_branch_uploads_non_serialized_array[$this_campus_id];
	 $this_branch_string=$this_branch_string.",".$current_date." ".$current_time;
	 
	}
	else
	{
	 $this_branch_string=$this_branch_string.$current_date." ".$current_time;	
	}

	$track_individual_branch_uploads_non_serialized_array[$this_campus_id]=$this_branch_string;
	$track_individual_branch_uploads_serialized_array=serialize($track_individual_branch_uploads_non_serialized_array);
	
	$res2=$con->query("update 1_exam_admin_create_exam set track_individual_branch_uploads='$track_individual_branch_uploads_serialized_array' where sl='$sl'");
	
	
}

if($res && $res1 && $res2)
{ echo "db_done";exit;}
	 

//COPYING>>ENDS>>DELETE LATER


*/
}//OMR SCANNING TYPE =COMMON=NON ADVANCED OUTER ENDS

else
	if($omr_scanning_type=="advanced")
	  {//ADVANCED PROCESS OUTER MOST BRACKET OPEN STARTS
	
	//echo "here adv";
       //exit;	
	
	
	include "advanced.php";

	$correct_ias_array_of_sl_plus_additional_data=get_correct_ias_array_of_sl_plus_additional_data($con,$sl);
	$iit_year_p1_p2=$correct_ias_array_of_sl_plus_additional_data[0];

	$this_college_id=$_SESSION['campus_id'];
	$correct_ias_array=$correct_ias_array_of_sl_plus_additional_data[1];



	$model_year=$correct_ias_array_of_sl_plus_additional_data[2];
	$paper=$correct_ias_array_of_sl_plus_additional_data[3];
//echo "00";
	

       
        //echo $iit_year_p1_p2."->sl=".$sl."->this college id=>".$this_college_id; 

        //echo json_encode($correct_ias_array); exit;
        //echo "->".$model_year."->".$paper;
        $not_recompute="not_recompute"; //usual dat_convertion function will use this for advanced... for recompute it will directly access function in advanced.php

	process_iit($con,$iit_year_p1_p2,$sl,$this_college_id,$correct_ias_array,$model_year,$paper,$not_recompute);

	
	}//ADVANCED PROCESS OUTER MOST BRACKET CLOSE ENDS




//exit;
//echo $individual_array[401];

//$temp_array=array();
//echo $temp_array[-1]=3;



	
	//index2.php ends
	if($description=="not_recompute")
	{
	exit;
	}
	
	
	
}//dat_conversion_function ends


if(isset($_POST['db_insert_and_status_update_success']))
{
	db_insert_and_status_update_success($con,$this_campus_id);
}

function delete_this_campus_all_temp_and_final_result($con,$sl,$this_campus_id) //CRB might be required.....do it... 2 fun flowing.. (Small =>)
{
	//echo 'here';
	
	//AUTO COMMIT OFF It
	$current_date=current_date_y_m_d();
    $current_time=current_time_12_hour_format_h_m_s();
	$originalDate = $current_date;
    $d_m_y = date("d-m-Y", strtotime($originalDate));
	
	//SEE N DO CORRECT
	$res_init=$con->query("select mode,omr_scanning_type,status_serialized from 1_exam_admin_create_exam where sl='$sl'");
	$row=mysqli_fetch_array($res_init);
	
	//BELOW IS EXECUTED WHEN RESULT IS NOT GENEFRATED BY THE EXAM ADMIN
	
	
	
	$test_mode_id=$row['mode'];

	$res_table_name=$con->query("select marks_upload_temp_table_name,marks_upload_final_table_name from 0_test_modes where test_mode_id='$test_mode_id'");
	$row_table_name=mysqli_fetch_array($res_table_name);

	$marks_upload_temp_table_name=$row_table_name['marks_upload_temp_table_name'];
	$marks_upload_final_table_name=$row_table_name['marks_upload_final_table_name'];
	
	
	//

	
	$omr_scanning_type=$row['omr_scanning_type'];
	$status_serialized=$row['status_serialized'];
	$status_non_serialized_array=unserialize($status_serialized);
	if($status_serialized=="")
	{
	//echo "didnt_generate_result_to_delete";exit;
	}
	
	//$this_campus_id; exit;
	if(!isset($status_non_serialized_array[$this_campus_id]))
	{
	//echo "didnt_generate_result_to_delete";exit;
	}
	//LOCK IT

	unset ($status_non_serialized_array[$this_campus_id]);    //DELETE THIS COLLEGE ID FROM THE EDIT_STATUS COLUMN AND UPDATE TABLE
	$status_serialized=serialize($status_non_serialized_array);
	
	
	$res=$con->query("update 1_exam_admin_create_exam set status_serialized='$status_serialized' where sl='$sl'");
	
	
	
	//L start
	//DO LOCK HERE ALSO
	//THIS BELOW WILL ADD THE DATE OF DELETED RESULT'S COLLEGE ID IN track_individual_branch_deletes

  $track_individual_branch_deletes_serialized=$row['track_individual_branch_deletes'];
  $this_branch_string="";
  if($track_individual_branch_deletes_serialized=="")
    {
	
	  $this_branch_string=$this_branch_string.$current_date." ".$current_time;
	
	  $track_individual_branch_deletes_non_serialized_array[$this_campus_id]=$this_branch_string;
	  $track_individual_branch_deletes_serialized_array=serialize($track_individual_branch_deletes_non_serialized_array);
	
	  $res=$con->query("update 1_exam_admin_create_exam set track_individual_branch_deletes='$track_individual_branch_deletes_serialized_array' where sl='$sl'");
    }
  else
    {
	    $track_individual_branch_deletes_serialized_array=$track_individual_branch_deletes_serialized;
	    $track_individual_branch_deletes_non_serialized_array=unserialize($track_individual_branch_deletes_serialized_array);
	
	
	       if(isset($track_individual_branch_deletes_non_serialized_array[$this_campus_id]))
	        {
	  $this_branch_string=$track_individual_branch_deletes_non_serialized_array[$this_campus_id];
	  $this_branch_string=$this_branch_string.",".$current_date." ".$current_time;
	        }
	else
	{
	$this_branch_string=$this_branch_string.$current_date." ".$current_time;	
	}

	$track_individual_branch_deletes_non_serialized_array[$this_campus_id]=$this_branch_string;
	$track_individual_branch_deletes_serialized_array=serialize($track_individual_branch_deletes_non_serialized_array);
	
	         $res=$con->query("update 1_exam_admin_create_exam set track_individual_branch_deletes='$track_individual_branch_deletes_serialized_array' where sl='$sl'");
	
	
     }
	//L end
	
	//respective testmode table should delete
	
	if($omr_scanning_type=="non_advanced")
	{
	$res2=$con->query("delete from $marks_upload_temp_table_name where test_code_sl_id='$sl' and this_college_id='$this_campus_id'");
	$res=$con->query("delete from 101_mismatch_approval_request where test_sl='$sl' and this_college_id='$this_campus_id'"); 

	    $res2=$con->query("delete from $marks_upload_final_table_name where test_code_sl_id='$sl' and this_college_id='$this_campus_id'");

	}
	else
	if($omr_scanning_type=="advanced")
	{
	$res2=$con->query("delete from $marks_upload_temp_table_name where test_code_sl_id='$sl' and this_college_id='$this_campus_id'");
	$res=$con->query("delete from 101_mismatch_approval_request where test_sl='$sl' and this_college_id='$this_campus_id'"); 
	$res2=$con->query("delete from $marks_upload_final_table_name where test_code_sl_id='$sl' and this_college_id='$this_campus_id'");
	}
	
	if($res && $res2)
	{
	//echo "deleted_success";
	}
	//exit;


    
}
function db_insert_and_status_update_success($con,$response_array) //NOW DOING ADVANCED ..IF CLUBBING NON ADVANCED..UPDATE COMMENT HERE..
//NOW DOING FOR NON ADVANCED ALSO...
{

	//echo json_encode($response_array);
	//exit;

	//echo "database now in "; exit;

	//echo "inn"; exit;
	 /* ADVANCED RESPONSE ARRAY FORMAT
	  $response_array[]="success";  0
	  $response_array[]="advanced"; 1
	  $response_array[]=$sl;        2
	  $response_array[]=$student_usn_array;  3
	  $response_array[]=$physics_marks_array; 4
	  $response_array[]=$chemistry_marks_array; 5
	  $response_array[]=$mathematics_marks_array; 6
	  $response_array[]=usn flag array coming here 7
    */
	
	/*  NON ADVANCED ARRAY FORMAT
	  $response_array2[]="success";
	  $response_array2[]="non_advanced";
	  $response_array2[]=$response_array[2]; //sl
	  $response_array2[]=$response_array[3]; //usn
	  $response_array2[]=$response_array[4]; //no of sub
	  $response_array2[]=$response_array[5]; //student calculated marks
	  $response_array2[]=$response_array[6]; //0
	  $response_array2[]=$response_array[7]; //student usn flag array
	*/	  
	//DELETE PREVIOUS RESULT CONDITION CHECK....OF THIS SL AND CAMPUS ID AND MODE WISE DATABASE






//echo "db";
//echo json_encode($response_array[9]); exit;




$description=$response_array[8]; // recompute or not_recompute

					if($description=="not_recompute")
				{
			$this_campus_id=$_SESSION['campus_id'];


			    }
					else if($description=="recompute")
				{
				  $this_campus_id=$response_array[10]; 

				}


//echo "--------desc=".$description;




$sl=$response_array[2];


//Delete previous generated results starts




// delete previous generated results ends



$res2=$con->query("select * from 1_exam_admin_create_exam where sl='$sl'");
$row2=mysqli_fetch_array($res2);
$current_hitting=$row2['current_hitting'];
$omr_scanning_type=$row2['omr_scanning_type'];
$test_code_sl_id=$row2['sl'];
$test_code=$row2['test_code'];
//BLOCKS HELPS FOR NON ADVANCED STARTS

  $subject_string=$row2['subject_string_final']; // id of final subject string
  $subject_string_array=explode(",",$subject_string);
  $number_of_subject=sizeof($subject_string_array);


  $temp=array();
  foreach($subject_string_array as $ind_id)
  {
	  $res_this=$con->query("select subject_name from 0_subjects where subject_id='$ind_id'");
	  $row_this=mysqli_fetch_array($res_this);
	   $t=$row_this['subject_name'];	   
	  $temp[]=strtoupper($t);
  
  }
  
  $subject_string_array=$temp;

  $subject_array=$subject_string_array; //Name according to 0_test_modes..NO NO... its according to subject string final...


//BLOCKS HELPS FOR NA ENDS


$test_mode_id=$row2['mode']; //exit;

	
$res_table_name=$con->query("select marks_upload_temp_table_name from 0_test_modes where test_mode_id='$test_mode_id'");
$row_table_name=mysqli_fetch_array($res_table_name);

$marks_upload_temp_table_name=$row_table_name['marks_upload_temp_table_name'];



$zero="zero";


// COMIT HERE 
if($omr_scanning_type=="advanced")
{             
	
	$little_student_usn_array=$response_array[3];
	$student_usn_flag_array=$response_array[7];
	
	$pre_physics_marks_array=$response_array[4];
	$pre_chemistry_marks_array=$response_array[5];
	$pre_mathematics_marks_array=$response_array[6];
	$R_U_W_string_array=$response_array[9];
	
	
	
	$student_usn_array=array();
	$physics_marks_array=array();
	$chemistry_marks_array=array();
	$mathematics_marks_array=array();
	$RUW_array_temp_table_insert=array();
	
	$inner_total=0;
	$s_count=sizeof($little_student_usn_array);  // not neglecting starting index dummy (its only in non advanced)
	$d_count=0;
	$a_count=0;
	
	foreach($little_student_usn_array as $key=>$val)
	{
	  if($student_usn_flag_array[$key]=="D") 
	  {
	 $d_count++; 
	  }
	  else	  
	  if($student_usn_flag_array[$key]=="A") 
	  { //exit;
         $a_count++;
	      $res=$con->query("select * from t_student where ADM_NO LIKE '__$val' and CAMPUS_ID='$this_campus_id' ");	
	  $row=mysqli_fetch_array($res);
	  $this_student_full_usn=$row['ADM_NO'];

	  if($description=="not_recompute")
	  {
	  $inner_total=$pre_physics_marks_array[$key]+$pre_chemistry_marks_array[$key]+$pre_mathematics_marks_array[$key];
	  $zero=0;
	  $current_user_employee_id=$_SESSION['EMPLOYEE_ID'];
	  $blank="";
	  $this_R_U_W_string=$R_U_W_string_array[$key];

	  $res_ins=$con->query("insert into 101_mismatch_approval_request(test_sl,STUD_ID,this_college_id,PHYSICS,CHEMISTRY,MATHEMATICS,TOTAL,status,approval_sent_by,approval_status_by,Result_String)
	 values('{$sl}','{$this_student_full_usn}','{$this_campus_id}','{$pre_physics_marks_array[$key]}',
	 '{$pre_chemistry_marks_array[$key]}','{$pre_mathematics_marks_array[$key]}','{$inner_total}','{$zero}','{$current_user_employee_id}',
	 '{$blank}','{$this_R_U_W_string}')");
	       echo mysqli_error($con);	

	  }
	  else	
	  	           if($description=="recompute")
	 {
                           $res_recompute=$con->query("select status from 101_mismatch_approval_request where test_sl='$sl' and STUD_ID='$this_student_full_usn' and this_college_id='$this_campus_id'");
                           $row_recompute=mysqli_fetch_array($res_recompute);
                           $status=$row_recompute['status'];
                           if($status=="1")
                             {


                           	
	  $student_usn_array[]=$this_student_full_usn;
	  $physics_marks_array[]=$pre_physics_marks_array[$key];
	  $chemistry_marks_array[]=$pre_chemistry_marks_array[$key];
	  $mathematics_marks_array[]=$pre_mathematics_marks_array[$key];
	  $RUW_array_temp_table_insert[]=$R_U_W_string_array[$key];

                             }


	         }
	  
	 







	  }
	  else
	  {
	 	  $res=$con->query("select * from t_student where ADM_NO LIKE '__$val' and CAMPUS_ID='$this_campus_id' ");	
	  $row=mysqli_fetch_array($res);
	  $this_student_full_usn=$row['ADM_NO'];
	  
	  $student_usn_array[]=$this_student_full_usn;
	  $physics_marks_array[]=$pre_physics_marks_array[$key];
	  $chemistry_marks_array[]=$pre_chemistry_marks_array[$key];
	  $mathematics_marks_array[]=$pre_mathematics_marks_array[$key];
	  $RUW_array_temp_table_insert[]=$R_U_W_string_array[$key];
	
	  }
  
	}
	
	//s_count=incoming little usn array count

	$Total_Students_Count=sizeof($student_usn_array);
	if($s_count==$d_count) //All students are deleted
	{
	      
	 $response_array=array();
	     $response_array[0]="no_students";
	     $response_array[1]="no_students";
	 echo json_encode($response_array);  // wrong integer is in .iit
	 exit;
	}

	
	
	for($i=0;$i<$Total_Students_Count;$i++)
	{
	$this_current_usn=$student_usn_array[$i];
	$this_physics_marks=$physics_marks_array[$i];
	$this_chemistry_marks=$chemistry_marks_array[$i];
	$this_mathematics_marks=$mathematics_marks_array[$i];
	$total_marks=$this_physics_marks+$this_chemistry_marks+$this_mathematics_marks;
	$this_R_U_W_string=$RUW_array_temp_table_insert[$i];
	
	$res=$con->query("insert into $marks_upload_temp_table_name(test_code_sl_id,STUD_ID,PHYSICS,CHEMISTRY,MATHEMATICS,TOTAL,this_college_id,Result_String)values('{$test_code_sl_id}','{$this_current_usn}','{$this_physics_marks}','{$this_chemistry_marks}','{$this_mathematics_marks}','{$total_marks}','{$this_campus_id}','{$this_R_U_W_string}')");

	echo mysqli_error($con);
	
	}

	//echo "exiting iit temp"; exit;
	//echo mysqli_error($con); exit;
	
	if($res)
	{
	  //	echo "inserted";
	}
}

else
	if($omr_scanning_type=="non_advanced")


{          /*
			          $response_array2[]=$response_array[2]; //sl
			  $response_array2[]=$response_array[3]; //usn
			  $response_array2[]=$response_array[4]; //no of sub
			  $response_array2[]=$response_array[5]; //student calculated marks
			  $response_array2[]=$response_array[6]; //0
			  $response_array2[]=$response_array[7]; //student usn flag array
			*/  
	  
	  
	$little_student_usn_array=$response_array[3];
	$no_of_subjects=$response_array[4];
	$students_calculated_marks=$response_array[5];
	$student_usn_flag_array=$response_array[7];
	
	$track_student_mark_key=array();
	
	$student_usn_array=array();

	$RUW_array_temp_table_insert=array();



	
	$inner_total=0;
	
	$s_count=sizeof($little_student_usn_array)-1;  //neglecting starting index dummy
	$d_count=0;
	$a_count=0;
	foreach($little_student_usn_array as $key=>$val)
	{//foreach start
	 if($val=="Starting_0_Index_Dummy")  
	  {
	 
	  }
	  else
	  if($student_usn_flag_array[$key]=="D") 
	  {
	 $d_count++;  
	  }
	  else	  
	  if($student_usn_flag_array[$key]=="A") 
	  { //exit;
	              $a_count++;
	      $res=$con->query("select * from t_student where ADM_NO LIKE '__$val' and CAMPUS_ID='$this_campus_id' ");	
	  $row=mysqli_fetch_array($res);
	  $this_student_full_usn=$row['ADM_NO'];
	  

		  if($description=="not_recompute")
			  {
			  $no_of_subjects;
			  $p=1;
			  $inner_total=0;
			  
			  $mark_array=array();
			  for($p=1;$p<=$no_of_subjects;$p++)
			  {
			 $mark_array[]=$students_calculated_marks[$key][$p]; 
			 $inner_total=$inner_total+$students_calculated_marks[$key][$p]; 
			  }
			  $mark_array_string=implode(",",$mark_array);
			  
			  
			  //$inner_total=$pre_physics_marks_array[$key]+$pre_chemistry_marks_array[$key]+$pre_mathematics_marks_array[$key];
			  $zero=0;
			  //echo "aa";
			   $current_user_employee_id=$_SESSION['EMPLOYEE_ID'];
			  $blank="";
			  $this_R_U_W_string=$students_calculated_marks[$key]['R_U_W_string']; //lobby 



			$res_ins=$con->query("insert into 101_mismatch_approval_request(test_sl,STUD_ID,this_college_id,other_subjects_info,no_of_subjects,TOTAL,status,approval_sent_by,approval_status_by,Result_String)
			 values('{$sl}','{$this_student_full_usn}','{$this_campus_id}','{$mark_array_string}','{$no_of_subjects}','{$inner_total}','{$zero}','{$current_user_employee_id}','{$blank}','{$this_R_U_W_string}')");
			         echo mysqli_error($con);

			  }


		  else
		if($description=="recompute")
		{
                           $res_recompute=$con->query("select status from 101_mismatch_approval_request where test_sl='$sl' and STUD_ID='$this_student_full_usn' and this_college_id='$this_campus_id'");
                           $row_recompute=mysqli_fetch_array($res_recompute);
                           $status=$row_recompute['status'];
                           if($status=="1")
                           {
                           	$track_student_mark_key[]=$key;
	$student_usn_array[$key]=$this_student_full_usn;
	$RUW_array_temp_table_insert[$key]=$students_calculated_marks[$key]['R_U_W_string'];


                           }


		}

 	 } //if == A



	  else
	    {
	 	  $res=$con->query("select * from t_student where ADM_NO LIKE '__$val' and CAMPUS_ID='$this_campus_id' ");	
	  $row=mysqli_fetch_array($res);
	  $this_student_full_usn=$row['ADM_NO'];

	  $track_student_mark_key[]=$key;
	  
	  $student_usn_array[$key]=$this_student_full_usn;

	  $RUW_array_temp_table_insert[$key]=$students_calculated_marks[$key]['R_U_W_string'];
	
	
	    }
   } //foreach ends









	$Total_Students_Count=sizeof($student_usn_array);
	

 if($description=="non_recompute")
 {

	if($s_count==$d_count) //All students are deleted
	{
	      
	 $response_array=array();
	     $response_array[0]="no_students";
	     $response_array[1]="no_students";
	 echo json_encode($response_array);  // wrong integer is in .iit
	 exit;
	}

 }






	
	$students_id_array=array();
	$students_id_array=$student_usn_array;
    
	foreach($track_student_mark_key as $key=>$i) 
	{
	//$i=$i-1;
	$inside_string="test_code_sl_id,STUD_ID,";
	$subject_string=implode(",",$subject_array);
	
	$last_string=$inside_string.$subject_string.",TOTAL,this_college_id,Result_String";

	$this_R_U_W_string=$RUW_array_temp_table_insert[$key];
	
	 //exit; 
	//echo json_encode($students_calculated_marks);
	//exit;
	 
	 if($number_of_subject==3)
	 { $total=$students_calculated_marks[$i][1]+$students_calculated_marks[$i][2]+$students_calculated_marks[$i][3];
	$res_insert=$con->query("insert into $marks_upload_temp_table_name($last_string)
	values('{$test_code_sl_id}','{$students_id_array[$i]}','{$students_calculated_marks[$i][1]}','{$students_calculated_marks[$i][2]}','{$students_calculated_marks[$i][3]}','{$total}','{$this_campus_id}','{$this_R_U_W_string}')"); 
	 }
	 	 if($number_of_subject==4)
	 { $total=$students_calculated_marks[$i][1]+$students_calculated_marks[$i][2]+$students_calculated_marks[$i][3]+$students_calculated_marks[$i][4];
	$res_insert=$con->query("insert into $marks_upload_temp_table_name($last_string)
	values('{$test_code_sl_id}','{$students_id_array[$i]}','{$students_calculated_marks[$i][1]}','{$students_calculated_marks[$i][2]}','{$students_calculated_marks[$i][3]}','{$students_calculated_marks[$i][4]}','{$total}','{$this_campus_id}','{$this_R_U_W_string}')"); 
	 }
	 	 	 if($number_of_subject==5)
	{ $total=$students_calculated_marks[$i][1]+$students_calculated_marks[$i][2]+$students_calculated_marks[$i][3]+$students_calculated_marks[$i][4]+$students_calculated_marks[$i][5];
	$res_insert=$con->query("insert into $marks_upload_temp_table_name($last_string)
	values('{$test_code_sl_id}','{$students_id_array[$i]}','{$students_calculated_marks[$i][1]}','{$students_calculated_marks[$i][2]}','{$students_calculated_marks[$i][3]}','{$students_calculated_marks[$i][4]}','{$students_calculated_marks[$i][5]}','{$total}','{$this_campus_id}','{$this_R_U_W_string}')"); 
	 }
	
	}
	/*
	for($i=0;$i<$Total_Students_Count;$i++)
	{
	$this_current_usn=$student_usn_array[$i];
	$this_physics_marks=$physics_marks_array[$i];
	$this_chemistry_marks=$chemistry_marks_array[$i];
	$this_mathematics_marks=$mathematics_marks_array[$i];
	$total_marks=$this_physics_marks+$this_chemistry_marks+$this_mathematics_marks;
	
	$res=$con->query("insert into $marks_upload_temp_table_name(test_code_sl_id,TEST_CODE,STUD_ID,PHYSICS,CHEMISTRY,MATHEMATICS,TOTAL,this_college_id)values('{$test_code_sl_id}','{$test_code}','{$this_current_usn}','{$this_physics_marks}','{$this_chemistry_marks}','{$this_mathematics_marks}','{$total_marks}','{$this_campus_id}')");
	
	}
	*/
	//echo mysqli_error($con); exit;
	
	if($res)
	{
	  //	echo "inserted";
	}
	
	
   } // if omr non_advanced ends here

//BELOW IS COMMON STATUS UPDATE FOR ADVANCED AND NON ADVANCED
//DO LOCK STATUS LATER
// CURRENT DATE AND TIME TAKE SAME..DONT TAKE SEPERATE
	$current_date=current_date_y_m_d();
    $current_time=current_time_12_hour_format_h_m_s();

if($current_hitting==0)
{
	//$con->query("update 1_exam_admin_create_exam set current_hitting='$current_hitting' where $current_hitting='$zero' and sl='$sl' ");
}

$status_serialized=$row2['status_serialized'];
if($status_serialized=="")
{
	$status_non_serialized_array=array();

	$status_non_serialized_array[$this_campus_id]=$Total_Students_Count." ".$current_date." ".$current_time;
	$status_serialized_array=serialize($status_non_serialized_array);
	$res=$con->query("update 1_exam_admin_create_exam set status_serialized='$status_serialized_array' where sl='$sl'");
}
else
{
 $status_serialized_array=$status_serialized;
 $status_non_serialized_array=unserialize($status_serialized_array);

 $status_non_serialized_array[$this_campus_id]=$Total_Students_Count." ".$current_date." ".$current_time;
 $status_serialized_array=serialize($status_non_serialized_array);
 $res=$con->query("update 1_exam_admin_create_exam set status_serialized='$status_serialized_array' where sl='$sl'");
 
}
//DO LOCK HERE ALSO

$track_individual_branch_uploads_serialized=$row2['track_individual_branch_uploads'];
$this_branch_string="";
if($track_individual_branch_uploads_serialized=="")
{
	
	$this_branch_string=$this_branch_string.$current_date." ".$current_time;
	

	$track_individual_branch_uploads_non_serialized_array[$this_campus_id]=$this_branch_string;
	$track_individual_branch_uploads_serialized_array=serialize($track_individual_branch_uploads_non_serialized_array);
	
	$res=$con->query("update 1_exam_admin_create_exam set track_individual_branch_uploads='$track_individual_branch_uploads_serialized_array' where sl='$sl'");
}
else
{
	$track_individual_branch_uploads_serialized_array=$track_individual_branch_uploads_serialized;
	$track_individual_branch_uploads_non_serialized_array=unserialize($track_individual_branch_uploads_serialized_array);
	
	
	if(isset($track_individual_branch_uploads_non_serialized_array[$this_campus_id]))
	{
	 $this_branch_string=$track_individual_branch_uploads_non_serialized_array[$this_campus_id];
	 $this_branch_string=$this_branch_string.",".$current_date." ".$current_time;
	 
	}
	else
	{
	 $this_branch_string=$this_branch_string.$current_date." ".$current_time;	
	}

	$track_individual_branch_uploads_non_serialized_array[$this_campus_id]=$this_branch_string;
	$track_individual_branch_uploads_serialized_array=serialize($track_individual_branch_uploads_non_serialized_array);
	
	$res=$con->query("update 1_exam_admin_create_exam set track_individual_branch_uploads='$track_individual_branch_uploads_serialized_array' where sl='$sl'");
	
	
}


// Recompute uploaded status update =>Wrong label
// Reupload college level status update... =>Correct Label...

// This is while when college re uploads finishes its db insertion.. below is correct confirmed...
  if($description=="not_recompute")
  {

$res_recompute=$con->query("select * from 1_exam_recompute_request_campus_id where campus_id='$this_campus_id' and sl='$sl'");
	   $count_recompute=mysqli_num_rows($res_recompute);
                                       $recompute_status="";
	   if($count_recompute!=0) //i.e more than zero...
	   {

	   	$row_recompute=mysqli_fetch_array($res_recompute);
	   	$is_uploaded=$row_recompute['is_uploaded'];
	   	if($is_uploaded=="0")
	   	{
	   	//..check whether deleting previous records did in dat_convertion function...
	   	//delete_this_campus_all_temp_and_final_result($con,$sl,$this_campus_id);
	   	//deletes all previous temp and final results...
	   	//
	   	    $one="1";
	   $res_update=$con->query("update 1_exam_recompute_request_campus_id set is_uploaded='$one' where campus_id='$this_campus_id' and sl='$sl' ");
	   	}
	   }



  }
	





//






//Below should change i guess...  recompute should skip the below process i think... see again...

if($description=="not_recompute")
{




//file temp to final rename and valid folder....
   if($omr_scanning_type=="advanced")
   {
   	$ext=".iit";
   }
   else
     if($omr_scanning_type=="non_advanced")
   {
   	$ext=".dat";
   }

	if (!is_dir('uploads/'.$sl.'/final'))
	 {
    mkdir('uploads/'.$sl.'/final', 0777, true);
     }


    
   $temp_file_name="temp_".$this_campus_id.$ext;
   $final_file_name=$this_campus_id.$ext;
   copy('uploads/'.$sl.'/'.$temp_file_name.'','uploads/'.$sl.'/final/'.$final_file_name.'');    // copy temp.ext  into "/final" for reprocessing

   $res_col_name=$con->query("select CAMPUS_NAME from t_campus where CAMPUS_ID='$this_campus_id'");
   $row_col_name=mysqli_fetch_array($res_col_name);
   $college_name=$row_col_name['CAMPUS_NAME'];//exit;

   	if (!is_dir('uploads/'.$sl.'/valid'))
	 {
    mkdir('uploads/'.$sl.'/valid', 0777, true);
     }

    copy('uploads/'.$sl.'/'.$temp_file_name.'','uploads/'.$sl.'/valid/'.$final_file_name.''); //lolo

//
                $fname="uploads/$sl/valid/$this_campus_id$ext";    //THIS WILL TAKE BOTH .DAT and .dat
                $us="_";
    $college_name_file="uploads/$sl/valid/$college_name$us$sl$ext";

    file_put_contents($fname,str_replace('-A','',file_get_contents($fname)));
    file_put_contents($fname,str_replace('-D','',file_get_contents($fname)));
    chmod($fname,0777);

    rename($fname,$college_name_file);


}
   



	if($description=="not_recompute")
	{
      //exit;
		mysqli_commit($con);
	

	 $response_array=array();
	     $response_array[0]="db_done";
	     $response_array[1]="database_inserted";
	 $response_array[2]=$s_count;
	 $response_array[3]=$a_count;
	 $response_array[4]=$d_count;
	 
	// echo "dispyng lt";
	 echo json_encode($response_array);  


    }


	 if($description=="not_recompute")
	 {
	 	exit;
	 }
	 
}

function get_process_upload_track_value($con,$this_campus_id)
{
	
	$myfile = fopen("uploads_process_track/Input.txt", "r") or die("Unable to open file!");
    $val= fread($myfile,filesize("uploads_process_track/Input.txt"));
	echo $val;

	exit;
}



function display_merged_data($con) //CRB not required.... (Small=>Checked)
{
	$sl_array_merged=$_POST['sl_array'];
     $result=array();
	foreach($sl_array_merged as $value)
	{
    $sql=$con->query("select ea.sl,ea.test_code,tc.GROUP_NAME,ts.STREAM_NAME,tp.PROGRAM_NAME,tsc.DISPLAY_NAME,tm.test_type_name,m.test_mode_name,ea.model_year,ea.paper,DATE_FORMAT(ea.start_date, '%d-%m-%Y') as start_date from 1_exam_admin_create_exam ea,1_exam_gcsp_id eg,t_course_group tc,t_stream ts,t_program_name tp,t_study_class tsc,0_test_modes m,0_test_types tm where ea.sl='{$value}' and ea.sl=eg.test_sl and eg.GROUP_ID=tc.GROUP_ID and eg.STREAM_ID=ts.STREAM_ID and eg.PROGRAM_ID=tp.PROGRAM_ID and eg.CLASS_ID=tsc.CLASS_ID and ea.test_type=tm.test_type_id and ea.mode=m.test_mode_id");
                    
       while($row=mysqli_fetch_array($sql))
       {
       	$result[]=$row;
       }
     }
    echo ' <table class="table table-hover table-bordered">
    <thead>
      <tr>
        <th>Exam Sl</th>
        <th>Test Code</th>
        <th>Group</th>
        <th>Stream</th>
        <th>Program</th>
        <th>Class</th>
        <th>Test Type</th>
        <th>Mode</th>
        <th>Model Year</th>
        <th>Exam Date</th>
        
      </tr>
    </thead>
    <tbody>';
    foreach($result as $value)
    {
         echo '<tr><td>'.$value['sl'].'</td><td>'.$value['test_code'].'</td><td>'.$value['GROUP_NAME'].'</td><td>'.$value['STREAM_NAME'].'</td><td>'.$value['PROGRAM_NAME'].'</td><td>'.$value['DISPLAY_NAME'].'</td><td>'.$value['test_mode_name'].'</td><td>'.$value['test_mode_name'].'</td><td>'.$value['model_year']. '-'. $value['paper']. '</td><td>'.$value['start_date'].  '</td></tr>';
     } 
    echo'</tbody>
  </table>';
  exit;
 }


function display_result_of_sl($con,$this_campus_id) //ONLY FOR NON ADVANCED...CLUBBED FOR ADVANCED ALSO>>>DONE..............//CRB not required... (Small => )
{

	$sl=$_POST['sl'];
	$current_date=current_date_d_m_y();
	$current_time=current_time_12_hour_format_h_m_s();
	
	
$res2=$con->query("select * from 1_exam_admin_create_exam  where sl='$sl'");
$row2=mysqli_fetch_array($res2);


$test_mode_id=$row2['mode'];
$test_code=$row2['test_code'];
$omr_scanning_type=$row2['omr_scanning_type'];
if($omr_scanning_type=="advanced")
{
$subject_string_final="1,2,3";
$student_mark_subject_flow_array=explode(",",$subject_string_final);
}
else
if($omr_scanning_type=="non_advanced")
{
$subject_string_final=$row2['subject_string_final'];//id
$student_mark_subject_flow_array=explode(",",$subject_string_final);
}
if($omr_scanning_type=="merged")
{
$subject_string_final="1,2,3";
$student_mark_subject_flow_array=explode(",",$subject_string_final);
}








//echo json_encode($student_mark_subject_flow_array);

$result_generated1_no0=$row2['result_generated1_no0'];

$res_now=$con->query("select * from 101_mismatch_approval_request where test_sl='$sl' and this_college_id='$this_campus_id' and status='0' ORDER BY TOTAL DESC");
$count_now=mysqli_num_rows($res_now);




$res_table_name=$con->query("select marks_upload_temp_table_name,marks_upload_final_table_name from 0_test_modes where test_mode_id='$test_mode_id'");
$row_table_name=mysqli_fetch_array($res_table_name);

$marks_upload_temp_table_name=$row_table_name['marks_upload_temp_table_name'];
$marks_upload_final_table_name=$row_table_name['marks_upload_final_table_name'];


$res_recompute=$con->query("select * from 1_exam_recompute_request_campus_id where sl='$sl'");
$count_recompute=mysqli_num_rows($res_recompute);


//$result_generated1_no0=1;
if($result_generated1_no0==0)
{
$marks_upload_table_name=$marks_upload_temp_table_name;
}
else
{
$marks_upload_table_name=$marks_upload_final_table_name;
}


if($count_recompute>0) // only for making college to view final generated result even if few college are yet to reupload...
{
   
    $res_recompute=$con->query("select * from 1_exam_recompute_request_campus_id where sl='$sl' and campus_id='$this_campus_id'");
    $this_count=mysqli_num_rows($res_recompute);

    if($this_count>=1)
    {

    $row_res_compute=mysqli_fetch_array($res_recompute);

    $this_campus_is_uploaded=$row_res_compute['is_uploaded'];
    if($this_campus_is_uploaded==1)
    {

	$marks_upload_table_name=$marks_upload_temp_table_name;
	$result_generated1_no0=0;

    }
    else
    {
    $marks_upload_table_name=$marks_upload_final_table_name;
	$result_generated1_no0=1;
    }

    }


    else if($this_count==0)
     
    {

	$marks_upload_table_name=$marks_upload_final_table_name;
	$result_generated1_no0=1;
    }
}
	
	
	

	//Take Subject Names From Subject String Final...
	
	//OMIT BELOW
/*
	$res=$con->query("select test_mode_subjects from 0_test_modes where test_mode_id=(select mode from 1_exam_admin_create_exam where sl=$sl)");
	$row=mysqli_fetch_array($res);
	$temp=$row['test_mode_subjects'];



	
	$display_priority_id=$temp;
	$display_priority_array=explode(",",$display_priority_id);

	$patch_array=array();

	foreach($display_priority_array as $key=>$value)
	{
	$patch_array[] = array_search($value, $student_mark_subject_flow_array); 
	} */

      //OMIT ABOVE
	$temp=$subject_string_final;  

	$temp_array=explode(",",$temp);


    $subject_array=array();
	foreach($temp_array as $val)
	{

      $res=$con->query("select subject_name from 0_subjects where subject_id = '$val'");
      $row=mysqli_fetch_array($res);
      $subject_array[]=$row['subject_name'];

	}

//echo json_encode($subject_array); exit;
   //overriding previous value exi
   /*
	$res=$con->query("select subject_name from 0_subjects where subject_id IN($temp)");
	
	
	while($row=mysqli_fetch_array($res))
	{
	
	}
	*/
//JUMP	
	
	//bgv

	//echo json_encode($subject_array); exit;
	
	$res=$con->query("select * from $marks_upload_table_name where test_code_sl_id='$sl' and this_college_id='$this_campus_id' ORDER BY TOTAL DESC");
	$count=mysqli_num_rows($res);
	
	//$test_code=$row['test_code'];
	echo '<div class="modal-dialog modal-lg" >
      <div class="modal-content" style="    width: 125%;left: -13%;">
        <div class="modal-header">
         
           
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div style="    width: 56%;    display: inline-block;">
            	<h4 class="modal-title" style="display:inline;">Results of Exam: <span style="font-weight:500;">'.$test_code.'</span></h4>
            </div>
             <div style=" display: inline-block;">
            	 <h4 class="modal-title" style="display:inline;">Last Data as on: '.$current_date.' at '.$current_time.'</h4>
            	 <img src="../assets/img/refresh.png" height="60" width="60" style="display:inline;cursor:pointer;    margin-top: -1%;" onclick="display_result_of_sl('.$sl.');">
            </div>
          
        </div>
        <div class="modal-body" style="min-height: 400px;">
         <div class="row">
           
            <div class="col-md-offset-2 col-md-8">

              <table class="table table-responsive table-hover table-bordered " style="border:1px solid #dec6c6;text-align:center;">';
	  if($count_recompute>0)
	  {
	  	echo '<center style="font-weight:bold;color:red;text-align:justify;">Few College should REUPLOAD their .dat/.iit files of this exam.. once after Exam Admin regenerates Ranking; Your new Result will be Refreshed automatically...Below are your temporary results.. However allotted Marks,Campus Ranks,Section Ranks of this College would remain same.. City/Dist/State/All India ranks will be Refreshed after the new Ranks are Generated at the end by Exam Admin... </center>';
	  }




	  if($result_generated1_no0==0)
	  { echo '<tr><th>Status</th><th>Sl</th><th>Student Id</th>';
	  }
	  else
	  {
	  	echo '<tr><th>Sl</th><th>Student Id</th>';
	  }
                
	
	 foreach($subject_array as $subject_name_individual)
	 { $subject_name_individual=strtoupper($subject_name_individual);
	 echo '<th>'.$subject_name_individual.'</th>';
	 }
	//echo '<th>PHY Marks</th><th>MAT Marks</th><th>BIO Marks</th><th>CHE Marks</th>';
	
                   if($result_generated1_no0==0)
                     {  echo '<th>Total</th>';
                     	 if($count_now>=1){
                     	 	 echo '<th>Approve</th><th>Delete</th>';  
                     	 }
                     	
                     }
                     else
                     {
                     echo '<th>Total</th><th>Stream</th><th>Program</th><th>Section</th><th>Campus</th><th>City</th><th>District</th><th>State</th><th>All India</th>';	
                     }


	
	
	echo '</tr>';
	/*
	if($count_now>=1)
	{   $a_int=1;
	       $patch_array_count=sizeof($patch_array);
	while($row_now=mysqli_fetch_array($res_now))
	{
	$subject_marks_string=$row_now['other_subjects_info'];
	$subject_marks_array=explode(",",$subject_marks_string);
	echo '<tr style="background-color:red;"><td style="">Approval</td><td>'.$a_int++.'</td><td>'.$row_now['STUD_ID'].'</td>';
	foreach($patch_array as $key=>$value)
	{
	echo '<td>'.$subject_marks_array[$value].'</td>';
	}
	echo '<td>'.$row_now['TOTAL'].'</td>';
	}
	
	}
                */

                 if($count_now>=1)
                 {
                    $a_int=1;
                    $r=1;
                     while($row_now=mysqli_fetch_array($res_now))
	{

                        if($omr_scanning_type=="advanced")
                        {
                        //$subject_marks_string=$row_now['other_subjects_info'];	
                    
                        $p=$row_now['PHYSICS'];
                        $c=$row_now['CHEMISTRY'];
                        $m=$row_now['MATHEMATICS'];
                        $subject_marks_string=$p.",".$c.",".$m;

                        }
                     else
                      if($omr_scanning_type=="non_advanced")
                        {
                        $subject_marks_string=$row_now['other_subjects_info'];

                        }
                       





	$subject_marks_array=explode(",",$subject_marks_string);
	echo '<tr style="background-color:#ff9c7e;"><td style="">Approval</td><td>'.$a_int++.'</td><td>'.$row_now['STUD_ID'].'</td>';
	foreach($subject_marks_array as $key=>$value)
	{
	echo '<td>'.$value.'</td>';
	}
                      echo '<td>'.$row_now['TOTAL'].'</td>';

                        if($count_now>=1)
                        {
                        	   echo '<td><input type="radio" class="approve" value="'.$row_now['STUD_ID'].'" name="radio'.$r.'"></td>
                               <td><input type="radio" class="delete" value="'.$row_now['STUD_ID'].'" name="radio'.$r++.'"></td>';
                        }
                   
	}

                 }

	
	
	$total=0;
	$int=1;



                 if($result_generated1_no0==0) //bgvv
	{
	while($row=mysqli_fetch_array($res)) //iteranting marks from marks table...
	{ 

	echo '<tr><td style="color:green;">Confirmed</td><td>'.$int++.'</td><td>'.$row['STUD_ID'].'</td>';
	
	                foreach($subject_array as $subject_name_individual)
	{
	$subject_name_individual=strtoupper($subject_name_individual);
	echo '<td>'.$row[$subject_name_individual].'</td>';
	}
                         
	 
	 
	 echo '<td>'.$row['TOTAL'].'</td></tr>';
	}
	}


                if($result_generated1_no0==1)
	{
	//echo json_encode($subject_array); exit;
                    	while($row=mysqli_fetch_array($res)) //iteranting marks from marks table...
	{ 

	echo '<tr><td>'.$int++.'</td><td>'.$row['STUD_ID'].'</td>';
	
	                foreach($subject_array as $subject_name_individual)
	{
	$subject_name_individual=strtoupper($subject_name_individual);
	echo '<td>'.$row[$subject_name_individual].'</td>';
	}
                         
	 
	 
	 echo '<td>'.$row['TOTAL'].'</td><td>'.$row['STREAM_RANK'].'</td><td>'.$row['PROGRAM_RANK'].'</td><td>'.$row['SEC_RANK'].'</td><td>'.$row['CAMP_RANK'].'</td><td>'.$row['CITY_RANK'].'</td><td>'.$row['DISTRICT_RANK'].'</td><td>'.$row['STATE_RANK'].'</td><td>'.$row['ALL_INDIA_RANK'].'</td></tr>';
	}

	}


	
              echo '</table>
                   </div>';
                   if(($count_now>=1) && ($_SESSION['is_principal']==true))
                          {
                    echo '<div class="col-md-2" >
                           <input type="radio" id="approve_all" name="all">Approve All<br>
                       <input type="radio" id="delete_all" name="all">Delete All<br>
                       <input type="radio" id="reset_all" name="all">Reset All<br>
                       <button class="btn btn-success btn-fill" style="position:fixed;z-index: 9999;" onclick="approve_delete('.$sl.')">Approve<br>Delete</button>
                      </div>';
                   }

                   


	

	   
            echo '</div>';



                     if(($count==0) &&($count_now)==0)
	 {
	 echo '<br><br><br><br><center style="color:red;">RESULT IS NOT GENERATED YET..Upload .DAT and Process</center>';
	 }	
else                      if(($count==0) &&($count_now)>0)
	 {
	 echo '<br><br><center style="color:red;">Above are the List of Students whose USN needs approval from the Principal</center>';
	 }



            
          

          
        echo '</div>
        <div class="modal-footer">
             <button type="submit" class="btn btn-info btn-fill pull-right" data-dismiss="modal">CLOSE</button>
          
        </div>
      </div>
    </div>';
	
	//exit;
}

function open_view_imk_modal_of_sl($con) //CRB not required
{
	$sl=$_POST['sl'];
	$res=$con->query("select * from 1_exam_admin_create_exam where sl='$sl'");
	$row=mysqli_fetch_array($res);
	
	$test_mode_id=$row['mode'];
    $test_code=$row['test_code'];
	
	
	
	$res_now=$con->query("select test_mode_name,test_mode_subjects from  0_test_modes where test_mode_id='$test_mode_id'");
	$row_now=mysqli_fetch_array($res_now);
	
	$test_mode_subjects=$row_now['test_mode_subjects'];
	
	
	$subject_array=array();	
	$sub=$con->query("select subject_name from 0_subjects where subject_id IN($test_mode_subjects) ORDER BY FIND_IN_SET(subject_id,'$test_mode_subjects')");
	while($row_sub=mysqli_fetch_array($sub))
	{
	$subject_array[]=$row_sub['subject_name'];
	}
	

	$subject_string_initial=implode(",",$subject_array);
	
	
	
	//$subject_string_initial=$row['subject_string_initial'];
	
	$temp=array();
	$subject_string_final=$row['subject_string_final']; //THIS IS ID
	$subject_string_id_final_array=explode(",",$subject_string_final);
	foreach($subject_string_id_final_array as $ind_id)
	{
	$res_here=$con->query("select subject_name from 0_subjects where subject_id='$ind_id'");
	$row_here=mysqli_fetch_array($res_here);
	    $temp[]=$row_here['subject_name'];
	}
	$subject_string_final=implode(",",$temp);
	
	
	
	
	//$total_subject=$row['total_subject'];
	$total_subject=sizeof($subject_array);
	
	$total_questions=$row['total_questions'];
	//exit;
	$info_file_edited_date_and_time=$row['info_file_edited_date_and_time'];
	if($info_file_edited_date_and_time !="")
	{
	$date_and_time_array=explode(" ",$info_file_edited_date_and_time);	
	$originalDate = $date_and_time_array[0];
    $info_d_m_y = date("d-m-Y", strtotime($originalDate));
	$info_time=$date_and_time_array[1];
	$info_file_edited_date_and_time=$info_d_m_y." at ".$info_time;
	}
	else
	if($info_file_edited_date_and_time==""){$info_file_edited_date_and_time="Didnt Add Yet";}
	
	
	//MARK File
	$mark_file_long_string=$row['mark_file_long_string'];
	$mark_file_long_string_array=explode(",",$mark_file_long_string);
	$mark_file_rows=$row['mark_file_rows'];
	$mark_file_edited_date_and_time=$row['mark_file_edited_date_and_time'];
	if($mark_file_edited_date_and_time !="")
	{
	$date_and_time_array=explode(" ",$mark_file_edited_date_and_time);	
	$originalDate = $date_and_time_array[0];
    $mark_d_m_y = date("d-m-Y", strtotime($originalDate));
	$mark_time=$date_and_time_array[1];
	$mark_file_edited_date_and_time=$mark_d_m_y." at ".$mark_time;
	}
	else
	if($mark_file_edited_date_and_time==""){$mark_file_edited_date_and_time="Didnt Add Yet";}
	
	
	
	//MARK FILE
	
	//ANSWER KEY FILE
	$key_answer_file_long_string=$row['key_answer_file_long_string'];
	$key_answer_file_edited_date_and_time=$row['key_answer_file_edited_date_and_time'];
	if($key_answer_file_edited_date_and_time !="")
	{
	$date_and_time_array=explode(" ",$key_answer_file_edited_date_and_time);	
	$originalDate = $date_and_time_array[0];
    $key_d_m_y = date("d-m-Y", strtotime($originalDate));
	$key_time=$date_and_time_array[1];
	$key_answer_file_edited_date_and_time=$key_d_m_y." at ".$key_time;
	}
	else
	if($key_answer_file_edited_date_and_time==""){$key_answer_file_edited_date_and_time="Didnt Add Yet";}
	
	//ANSWER KEY FILE
	
	$current_date=current_date_d_m_y();
	$current_time=current_time_12_hour_format_h_m_s();
	
	 echo '<div class="modal-dialog modal-lg">
      <div class="modal-content" style="    width: 125%;left: -13%;">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
           <div style="    width: 56%;    display: inline-block;">
          <h4 class="modal-title" style="display:inline;">Test Code:J1-HTYB-HTh <span style="font-weight:500">' . $test_code .'</span></h4>&nbsp;&nbsp;&nbsp; <h4 class="modal-title" style="display:inline;">Test Details: <span style="font-weight:500">' . $test_code .'</span></h4>
          </div>
           <div style=" display: inline-block;">
          <h4 class="modal-title" style="display:inline;">Last Data as on: '.$current_date.' at '.$current_time.'</h4>
	 
	  <img src="../assets/img/refresh.png" height="60" width="60" style="display:inline;cursor:pointer;    margin-top: -1%;" onclick="view_imk_modal_of_sl('.$sl.');">

	  
	   </div>
        </div>
        <div class="modal-body">
         <div class="row">
            <div class="col-md-6">
              <div class="card">
                                <h6 style="display:inline;position:relative;    left: 57%;">Last Edited On:'.$info_file_edited_date_and_time.'</h6><br>
                                <h4 style="display:inline;" class="title">CAMPUS DETAILS</h4>';
                             
	 if($subject_string_final=="")
	 {
	 $subject_string_initial_array=explode(',',$subject_string_initial);
	 
	 
	 $id=1;
	 foreach($subject_string_initial_array as $val)
	 {
	 if($total_subject !=1)
	 {echo '<!--<button id="button'.$id.'" value="no" onclick="bring_this_down('.$id.','.$total_subject.')">'.$val.'</button>-->';
	 $id++;
	 }
	 }
	 
	 }
	 
	 
                            echo '<div class="content table-responsive ">
                                <table class="table table-hover">
                                    <thead>
                                        <th>CAMPUS_ID</th>
                                        <th>CAMPUS_NAME</th>
                                        <th>STATUS</th>
                                        <th><button type="button" class="btn btn-info btn-fill ">>></button></th>
                                        
                                    </thead>
                                    <tbody>';
	        if($subject_string_final=="")
	{	
	$init=1;
	for($init=1;$init<=$total_subject;$init++)
	{
	if($total_subject==1)
	{
	 echo '<tr> <td id="sub'.$init.'">'.$subject_string_initial.'</td>
	     <td><input type="number" class="form-control left"  id="start'.$init.'" ></td>
                                             <td><input type="number" class="form-control right"  id="end'.$init.'"   ></td>
                                        </tr>';
	
	}
	else
	{
	 echo '<tr> <td id="sub'.$init.'"></td>
	     <td><input type="number" class="form-control left"  id="start'.$init.'" style="background:#efd6d6;" disabled ></td>
                                             <td><input type="number" class="form-control right" temp="'.$init.'" id="end'.$init.'"  style="background:#efd6d6;" disabled  ></td>
                                        </tr>';
	
	}	
	
	
	}	
                                  
                                            }
	else
	{
	
	$m=1;
	$subject_string_final_array=explode(",",$subject_string_final);
	$to_from_range=$row['to_from_range'];
	$to_from_range_array=explode(",",$to_from_range);
	
	for($m=0;$m<$total_subject;$m++)
	{
	$first_from_to=$to_from_range_array[$m];
	$internal_explode_array=explode("-",$first_from_to);
	
	echo '<tr><td>'.$subject_string_final_array[$m].'</td>
	           <td>'.$internal_explode_array[0].'</td>
	   <td>'.$internal_explode_array[1].'</td>
	   </tr>';
	
	}
	
	
	
	
	
	
	
	
	}
                                       
                                   echo '</tbody>
	   
                                </table>';
	if($total_subject==1)
	{
	echo '<!--<button type="submit" id="store" onclick="insert_info_file_of_sl('.$sl.','.$total_subject.')" class="btn btn-info btn-fill" style="margin-left: 84%;">STORE</button>-->';
	}
	else
	{
	echo '<!--<button type="submit" id="store" onclick="insert_info_file_of_sl('.$sl.','.$total_subject.')" class="btn btn-info btn-fill hidden" style="margin-left: 84%;">STORE</button>-->';	
	}
	if($subject_string_final!="")
	{
	echo '<!--<button type="submit"  onclick="delete_and_edit_info_and_mark_of_sl('.$sl.')" class="btn btn-info btn-fill " style="margin-left: 50%;">Delete Info and Mark to Update Newly</button>-->';	
	
	}
	
	

                           echo '</div>
                        </div>
                
            </div>
            <div class="col-md-6">
                 <div class="card">
                                <h6 style="display:inline;position:relative;    left: 57%;">Last Edited On:'.$mark_file_edited_date_and_time.'</h6><br>
                                <h4 style="display:inline;" class="title">SECTION DETAILS</h4>
                             
                            <div class="content table-responsive ">
                                <table class="table table-hover ">
                                    <thead>
                                        <th>SECTION ID</th>
                                         <th>NAME</th>
                                        <th>STATUS</th>
                                        <th></th>
                                        
                                    </thead>
                                    <tbody>';
	
	        if($mark_file_long_string=="")
	{
	echo '<tr>
                                      
                                            <td id="mrow1">  <input type="number" class="form-control mleft" id="mstart1" placeholder="1"></td>
                                            <td>  <input type="number" class="form-control mright" id="mend1" mtemp="1" 
	total_questions="'.$total_questions.'"  ></td>
                                            <td>  <input type="number" class="form-control" id="mpositive1" ></td>
                                            <td>  <button type="button" class="btn btn-info btn-fill ">\/</button></td>
                                        </tr>';
	
	for($minit=2;$minit<=10;$minit++)
	{
	echo '<tr id="mrow'.$minit.'" class="hidden">
                                      
                                            <td>  <input type="number" class="form-control mleft" id="mstart'.$minit.'" ></td>
                                            <td>  <input type="number" class="form-control mright" id="mend'.$minit.'" mtemp="'.$minit.'"  total_questions="'.$total_questions.'"></td>
                                            <td>  <input type="number" class="form-control" id="mpositive'.$minit.'"  ></td>
                                            <td>  <input type="number" class="form-control" id="mnegative'.$minit.'"  ></td>
                                        </tr>';
	
	} 
                                       
                                
                             
                                    echo '</tbody>
                                </table>';
	echo '<!--<button type="submit" id="mark_store" onclick="insert_mark_file_of_sl('.$sl.','.$total_questions.')" class="btn btn-info btn-fill hidden" style="margin-left: 84%;">STORE </button>-->';
	
	}
	else
	{
	
	$iterate=0;
	for($minit=1;$minit<=$mark_file_rows;$minit++)
	{
	
	
	
	echo '<tr id="mrow'.$minit.'" >
                                      
                                            <td>'.$mark_file_long_string_array[$iterate++].'</td>
                                            <td>'.$mark_file_long_string_array[$iterate++].'</td>
                                            <td>'.$mark_file_long_string_array[$iterate++].'</td>
                                            <td>'.$mark_file_long_string_array[$iterate++].'</td>
                                        </tr>';
	
	} 
                                       
                                
                             
                                    echo '</tbody>
                                </table>';
	echo '<!--<button type="submit"  onclick="delete_and_edit_info_and_mark_of_sl('.$sl.')" class="btn btn-info btn-fill " style="margin-left: 50%;">Delete Info and Mark to Update Newly</button>-->';
	
	}
	
	
	
	
	
	
                           echo '</div>
                        </div>
            </div>

            <div class="col-md-12">
                 <div class="card">
                           
                                <h4 style="display:inline;" class="title">SUBJECT DETAILS</h4><h6 style="display:inline;    position: relative;
    left: 65%;">Last Edited On:'.$key_answer_file_edited_date_and_time.'</h6>';
                             if($key_answer_file_long_string=="")
	 { 
                            echo '<div class="content table-responsive ">
                                <table class="table table-hover ">
                                    <thead>
                                        <th style="    width: 52px;">ADM_NO</th>
                                        <th>NAME</th>
                                        <th>SUB1</th>
                                        <th>SUB2</th>
                                        <th>SUB3</th>
                                        <th>SUB4</th>
                                        <th>SUB5</th>
                                        <th>SUB6</th>
                                        <th>SUB7</th>
										<th>SEND NOTIFY</th>
										<th>EMAIL NOTIFY</th>
										<th>MAKE AS INCOMPLETE</th>
                                   
                                        
                                        
                                    </thead>
                                    <tbody>';
	
	 $loop=1;
	$total_row=ceil($total_questions/20);
	$dstart=1;$dend=20;
	
	$i=1;
	
	$count_to_twenty=1;
	for($loop=1;$loop<=$total_row;$loop++)
	 { 
	echo '<tr><td>'.$dstart.'-<br>'.$dend.'</td>';
	
	         
	 for($count_to_twenty=1;$count_to_twenty<=20;$count_to_twenty++)
	 {
	if($i<=$total_questions)
                                    {
	 echo '<td>  <input type="number"  id="key'.$i.'" class="form-control key" required></td>';   
	} 
	$i++; 
	 
	
	
	 }$dstart+=20;$dend+=20; 
	 
	echo '</tr>';
	 }

                                       
                                    echo '</tbody>
                                </table>';
	
	if(($subject_string_final !="") && ($mark_file_long_string !=""))
	{
	echo '<!--<button type="submit" id="answer_key_file_store" onclick="insert_key_answer_file_of_sl('.$sl.','.$total_questions.')" class="btn btn-info btn-fill" style="margin-left: 92%;">STORE</button>-->';
	
	}	

                            echo '</div>';
	
	 }//	key_answer_file_long_string
	 
	 
	 
	 
	                   else if($key_answer_file_long_string!="")
	 { 
                            echo '<div class="content table-responsive " id="key_answer_div">
                                <table class="table table-hover ">
                                    <thead>
                                        <th style="    width: 52px;">Q NO</th>
                                        <th>X1</th>
                                        <th>X2</th>
                                        <th>X3</th>
                                        <th>X4</th>
                                        <th>X5</th>
                                        <th>X6</th>
                                        <th>X7</th>
                                        <th>X8</th>
                                        <th>X9</th>
                                        <th>X10</th>
	<th>Y1</th>
                                        <th>Y2</th>
                                        <th>Y3</th>
                                        <th>Y4</th>
                                        <th>Y5</th>
                                        <th>Y6</th>
                                        <th>Y7</th>
                                        <th>Y8</th>
                                        <th>Y9</th>
                                        <th>Y10</th>
                                   
                                        
                                        
                                    </thead>
                                    <tbody>';
	
	 $loop=1;
	$total_row=ceil($total_questions/20);
	$dstart=1;$dend=20;
	$key_answer_file_long_string_array=explode(",",$key_answer_file_long_string);
	
	$i=0;
	
	$count_to_twenty=1;
	for($loop=1;$loop<=$total_row;$loop++)
	 { 
	echo '<tr><td>'.$dstart.'-<br>'.$dend.'</td>';
	
	         
	 for($count_to_twenty=1;$count_to_twenty<=20;$count_to_twenty++)
	 {
	if($i<$total_questions)
                                    {
	 echo '<td> '.$key_answer_file_long_string_array[$i].'</td>';   
	} 
	$i++; 
	 
	
	
	 }$dstart+=20;$dend+=20; 
	 
	echo '</tr>';
	 }

                                       
                                    echo '</tbody>
                                </table>';
	echo '<!--<button type="submit" id="store" onclick="edit_key_answer_file_of_sl('.$sl.','.$total_questions.')" class="btn btn-info btn-fill" style="margin-left: 92%;">EDIT</button>-->';

                            echo '</div>';
	
	 }//
	 
	 
	 
	 
	 
                        echo '</div>
            </div>



            
          </div>

          
        </div>
        <div class="modal-footer">
             
          
        </div>
      </div>
    </div>';
	
	
	
	//exit;
}

function view_status_info_modal_of_sl($con,$this_campus_id)  //CRB not required
{
	$sl=$_POST['sl'];
	$current_date=current_date_d_m_y();
	$current_time=current_time_12_hour_format_h_m_s();
	
	        $res=$con->query("select * from 1_exam_admin_create_exam where sl='$sl'");
	$row=mysqli_fetch_array($res);
	  
	$test_code_name=$row['test_code'];
	$edit_status=$row['edit_status'];
	$edit_status_array=explode(",",$edit_status);
	$upload_date_time_string="";
	$last_date_to_upload=date("d-m-Y", strtotime($row['last_date_to_upload']));
	$last_time_to_upload=date("h:i a", strtotime($row['last_time_to_upload']));	
	$test_code=$row['test_code'];
	//START FOR UOPLOADS
	$track_individual_branch_uploads_serialized=$row['track_individual_branch_uploads'];
	if($track_individual_branch_uploads_serialized=="")
	{
	$upload_date_time_string="";
	
	        }
	else
	{
	$track_individual_branch_uploads_serialized_array=$track_individual_branch_uploads_serialized;
	$track_individual_branch_uploads_non_serialized_array=unserialize($track_individual_branch_uploads_serialized_array);
	//$this_branch_string=$track_individual_branch_uploads_non_serialized_array[$this_campus_id];
	if(isset($track_individual_branch_uploads_non_serialized_array[$this_campus_id]))
	{
	$upload_date_time_string=$track_individual_branch_uploads_non_serialized_array[$this_campus_id];
	}
	else
	{
	$upload_date_time_string="";
	}
	

	
	
	    }
	
	if($upload_date_time_string=="")
	{
	$upload_date_time_string_array=array();
	}
	else
	{
	$upload_date_time_string_array=explode(",",$upload_date_time_string);	
	}
	
	//END FOR UPLOADS
	
	//START FOR DELETES
	 $track_individual_branch_deletes_serialized=$row['track_individual_branch_deletes'];
	if($track_individual_branch_deletes_serialized=="")
	{
	$deletes_date_time_string="";
	
	        }
	else
	{
	$track_individual_branch_deletes_serialized_array=$track_individual_branch_deletes_serialized;
	$track_individual_branch_deletes_non_serialized_array=unserialize($track_individual_branch_deletes_serialized_array);
	//$this_branch_string=$track_individual_branch_uploads_non_serialized_array[$this_campus_id];
	if(isset($track_individual_branch_deletes_non_serialized_array[$this_campus_id]))
	{
	$deletes_date_time_string=$track_individual_branch_deletes_non_serialized_array[$this_campus_id];
	}
	else
	{
	$deletes_date_time_string="";
	}
	

	
	
	    }
	
	if($deletes_date_time_string=="")
	{
	$deletes_date_time_string_array=array();
	}
	else
	{
	$deletes_date_time_string_array=explode(",",$deletes_date_time_string);	
	}
	
	
	
	
	//END FOR DELETES
	
	//echo json_encode($upload_date_time_string_array);exit;
	
	echo '<div class="modal-dialog modal-lg">
      <div class="modal-content" style="    width: 125%;left: -13%;">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">×</button>
          <div style="    width: 56%;    display: inline-block;">
          <h4 class="modal-title" style="display:inline;">Test Status-Info of: <span style="font-weight:500;">'.$test_code.'</span></h4>
          </div>
           <div style=" display: inline-block;">
          <h4 class="modal-title" style="display:inline;">
	  Last Data as on: '.$current_date.' at '.$current_time.'</h4>
	 
	  <img src="../assets/img/refresh.png" height="60" width="60" style="display:inline;cursor:pointer;margin-top: -1%;" onclick="view_status_info_modal_of_sl('.$sl.');">
	  </div>
	  
        </div>
        <div class="modal-body">
         <div class="row" style="min-height:500px;">
	 
	 <div class="col-md-3" style="text-align: justify;">
	  <ul>
	    <li style="border-bottom: 1px solid #ccc8c8;">When a Info-Mark-Key File of a particular Test is \'deleted or Updated\' then Your Previous Uploaded Marks will be deleted. So You have to Upload the .DAT and regenerate the Result once again(AKC)</li>
	<li style="border-bottom: 1px solid #ccc8c8;"> When the <button class="btn btn-fill btn-danger">Upload</button> Button is <span style="color:red;font-weight:bold;">RED</span>. It Means Uploading is Pending
	</li>
	<li style="border-bottom: 1px solid #ccc8c8;"> When the <button class="btn btn-fill btn-success">Upload</button> Button is <span style="color:green;font-weight:bold;">GREEN</span>. It Means Uploading of .Dat is Finished and the Result is Successfully Generated
	</li> 
	<li style="border-bottom: 1px solid #ccc8c8;">District Rank,State Rank,All India Rank will be Generated when all Other Branches will Upload their .DAT. When all other individual Branches finishes uploading then Other Ranks will be Generated at the End.
	</li>
	  </ul>
	 </div>
	 
	 <div class=" col-md-8" style="margin-top:1%;">';

	  echo "<span style='color:blue;'>Last Date to Upload .dat/.iit:<input type='text' class='info-input' value='$last_date_to_upload' readonly>
	 Time:<input type='text' value='$last_time_to_upload' class='info-input' readonly></span>
         
	 "; echo '<br><br>';
	 
	echo '
	<table class="table table-hover" style="border:1px solid #d6d5d5;"> <tr><th>File</th><th>Task</th><th>Date</th><th>Time</th></tr>';
	
	
	   $date_time_array=array();
	           $file_task_desc_array=array();
	   foreach($edit_status_array as $val)
	 {
	 
	 $this_line_array=explode("@",$val);
	 
	 array_push($file_task_desc_array,$this_line_array[0]."|".$this_line_array[1]);
	 $this_line_date_dmy=$this_line_array[2];
	 $this_line_date_ymd=date("Y-m-d", strtotime($this_line_date_dmy));
	 $this_line_date_ymd_and_time=$this_line_date_ymd." ".$this_line_array[3];
	 
	 
	 array_push($date_time_array,$this_line_date_ymd_and_time);
	 
	 
	     }
         foreach($upload_date_time_string_array as $val)	
         {
	 array_push($date_time_array,$val);
	 array_push($file_task_desc_array,"THIS TEST|.DAT/.IIT UPLOADED AND RESULT GENERATED");
	 
	 }	
	 
	   foreach($deletes_date_time_string_array as $val)	
         {
	 array_push($date_time_array,$val);
	 array_push($file_task_desc_array,"YOU HAVE DELETED| MARKS AND RESULT OF THIS TEST");
	 
	 }
	 
	 
	 asort($date_time_array);
	   //echo json_encode($date_time_array);
	   $index_array=array();
	   $value_array=array();
	   foreach($date_time_array as $key=>$value)
	   {
	   $index_array[]=$key;
	   $value_array[]=$value;
	   
	   }
	   
	   //echo "val array=";print_r($value_array);
	   
	   foreach($index_array as $indexval)
	   {
	   $this_file_and_task=$file_task_desc_array[$indexval];
	   $this_file_and_task_array=explode("|",$this_file_and_task);
	   $file=$this_file_and_task_array[0];
	   $task=$this_file_and_task_array[1];
	   $this_value=$date_time_array[$indexval];
	   $this_value_array=explode(" ",$this_value);
	   $date_ymd=$this_value_array[0];
	   $date=date("d-m-Y", strtotime($date_ymd));
	   
	   $time=$this_value_array[1];
	   $color=""; $weight="";
	   
	   
	   	      if (strpos($task, '.DAT/.IIT') !== false) 
	 {
	 $color="green";
	 $weight="bold";
	 }
	 else
	 if (strpos($task, 'Updated') !== false) 
	 {
	 $color="red";
	 $weight="bold";
	 }
	 else
	 if (strpos($file, 'ALL BRANCH') !== false) 
	 {
	 $color="#1b6e80";
	 $weight="bold";
	 }
	 
	 else
	 if (strpos($file, 'YOU HAVE DELETED') !== false) 
	 {
	 $color="red";
	 $weight="bold";
	 }
	 
	 
	     echo '<tr style="color:'.$color.';">
	  <td style="font-weight:'.$weight.'">'.$file.'</td>
	  <td style="font-weight:'.$weight.'">'.$task.'</td>
	  <td style="font-weight:'.$weight.'">'.$date.'</td>
	  <td style="font-weight:'.$weight.'">'.$time.'</td></tr>';
	   
	   }	   
	   
          echo '</table>
	  <center style="color:red;font-weight:bold;">* When Any INFO/MARK/KEY file is updated then your Previous Uploads and Results will be deleted</center>
	  ';
	 

        echo '</div>
	
	
	<div class="col-md-1">
	<button class="btn btn-fill btn-danger" style="margin-left: -47%;width: 168%;" onclick="delete_this_branch_result_of_sl('.$sl.')">
	<span>DELETE <br>ALL THE<br>MARKS &amp;<br>RESULTS</span>
	</button>
	</div>
	
	<!--<center style="color:red;font-weight:bold;">* When Any INFO/MARK/KEY file is updated then your Previous Uploads and Results will be deleted</center>-->



        <div class="modal-footer">
             
          
        </div>
      </div>
    </div>';
	
	exit;
}

function delete_this_branch_result_of_sl($con,$this_campus_id)  //CRB  required...do.... CRB done..... Locking is pending.. and some more flag settings pending..
{
	//Flags might be 1_recompuite.. then delete files from uploads...
	//delete from final table also for safety...
$sl=$_POST['sl'];
	 
	 //WHEN RESULT IS GENEFRATED.. tHEN CANT DELETE THE BRANCH RESULT---do it--done
	 
	 
    mysqli_autocommit($con,FALSE);
	
	
	//AUTO COMMIT OFF It
	$current_date=current_date_y_m_d();
    $current_time=current_time_12_hour_format_h_m_s();
	$originalDate = $current_date;
    $d_m_y = date("d-m-Y", strtotime($originalDate));
	
	//SEE N DO CORRECT
	$res_init=$con->query("select * from 1_exam_admin_create_exam where sl='$sl'");
	$row=mysqli_fetch_array($res_init);
	
	$result_generated1_no0=$row['result_generated1_no0'];
	if($result_generated1_no0==1)
	{
	echo "result_is_generated_by_the_exam_admin_cant_delete_now";
	exit;
	}
	
	//BELOW IS EXECUTED WHEN RESULT IS NOT GENEFRATED BY THE EXAM ADMIN
	
	
	
	$test_mode_id=$row['mode'];

	$res_table_name=$con->query("select marks_upload_temp_table_name from 0_test_modes where test_mode_id='$test_mode_id'");
	$row_table_name=mysqli_fetch_array($res_table_name);

	$marks_upload_temp_table_name=$row_table_name['marks_upload_temp_table_name'];
	
	
	
	//

	
	
	
	
	
	
	$omr_scanning_type=$row['omr_scanning_type'];
	$status_serialized=$row['status_serialized'];
	$status_non_serialized_array=unserialize($status_serialized);
	if($status_serialized=="")
	{
	echo "didnt_generate_result_to_delete";exit;
	}
	
	//$this_campus_id; exit;
	if(!isset($status_non_serialized_array[$this_campus_id]))
	{
	echo "didnt_generate_result_to_delete";exit;
	}
	//LOCK IT

	unset ($status_non_serialized_array[$this_campus_id]);    //DELETE THIS COLLEGE ID FROM THE EDIT_STATUS COLUMN AND UPDATE TABLE
	$status_serialized=serialize($status_non_serialized_array);
	
	



	$res_update1=$con->query("update 1_exam_admin_create_exam set status_serialized='$status_serialized' where sl='$sl'");
	
	
	
	//L start
	//DO LOCK HERE ALSO
	//THIS BELOW WILL ADD THE DATE OF DELETED RESULT'S COLLEGE ID IN track_individual_branch_deletes

$track_individual_branch_deletes_serialized=$row['track_individual_branch_deletes'];
$this_branch_string="";
if($track_individual_branch_deletes_serialized=="")
{
	
	$this_branch_string=$this_branch_string.$current_date." ".$current_time;
	
	$track_individual_branch_deletes_non_serialized_array[$this_campus_id]=$this_branch_string;
	$track_individual_branch_deletes_serialized_array=serialize($track_individual_branch_deletes_non_serialized_array);
	
	$res_update2=$con->query("update 1_exam_admin_create_exam set track_individual_branch_deletes='$track_individual_branch_deletes_serialized_array' where sl='$sl'");
}
else
{
	$track_individual_branch_deletes_serialized_array=$track_individual_branch_deletes_serialized;
	$track_individual_branch_deletes_non_serialized_array=unserialize($track_individual_branch_deletes_serialized_array);
	
	
	if(isset($track_individual_branch_deletes_non_serialized_array[$this_campus_id]))
	{
	  $this_branch_string=$track_individual_branch_deletes_non_serialized_array[$this_campus_id];
	  $this_branch_string=$this_branch_string.",".$current_date." ".$current_time;
	}
	else
	{
	$this_branch_string=$this_branch_string.$current_date." ".$current_time;	
	}

	$track_individual_branch_deletes_non_serialized_array[$this_campus_id]=$this_branch_string;
	$track_individual_branch_deletes_serialized_array=serialize($track_individual_branch_deletes_non_serialized_array);
	
	$res_update2=$con->query("update 1_exam_admin_create_exam set track_individual_branch_deletes='$track_individual_branch_deletes_serialized_array' where sl='$sl'");
	
	
}
	//L end
	
	//respective testmode table should delete
	
	if($omr_scanning_type=="non_advanced")
	{
	$res_del1=$con->query("delete from $marks_upload_temp_table_name where test_code_sl_id='$sl' and this_college_id='$this_campus_id'");
	$res_del2=$con->query("delete from 101_mismatch_approval_request where test_sl='$sl' and this_college_id='$this_campus_id'"); 
	}
	else
	if($omr_scanning_type=="advanced")
	{
	$res_del1=$con->query("delete from $marks_upload_temp_table_name where test_code_sl_id='$sl' and this_college_id='$this_campus_id'");
	$res_del2=$con->query("delete from 101_mismatch_approval_request where test_sl='$sl' and this_college_id='$this_campus_id'"); 
	}
	



	if($res_update1 && $res_update2 && $res_del1 && $res_del2)
	{
    mysqli_commit($con);
	echo "deleted_success";
	}
  else
  {    mysqli_rollback($con);
       echo "ajax_error";
  }





	exit;
}







//ADVANCED ISSET STARTS
if(isset($_POST['open_view_imk_modal_of_sl_advanced']))
{
	open_view_imk_modal_of_sl_advanced($con);
}
if(isset($_POST['check_initial_condition_of_sl_advanced']))
{
	check_initial_condition_of_sl_advanced($con,$this_campus_id);
} 
if(isset($_POST['validate_students']))
{
	validate_students($con,$con_omr,$this_campus_id);
}
if(isset($_POST['reprocess_old_and_new_usn']))
{
	reprocess_old_and_new_usn($con,$this_campus_id);
}
if(isset($_POST['display_result_of_sl_advanced']))
{
	display_result_of_sl_advanced($con,$this_campus_id);
}
if(isset($_POST['multiple_usn']))
{
	multiple_usn($con,$this_campus_id);
}
//ADVANCED ISSET ENDS
//  BLOCK IS FOR ADVANCED--STARTS

function open_view_imk_modal_of_sl_advanced($con) //CRB not required
{ 
$sl=$_POST['sl'];
   $res=$con->query("select * from 1_exam_admin_create_exam where sl='$sl'");
   $row=mysqli_fetch_array($res);
   $key_answer_file_long_string=$row['key_answer_file_long_string'];
   $text="";
   if($key_answer_file_long_string=="")
   { $text="Key Answers are not Added by the Exam Admin";
	   for($s=1;$s<=100;$s++)
	   {
	 $key_answer_file_long_string_array[]="";  
	   }
   }
   else
   {
	  $key_answer_file_long_string_array=explode(",",$key_answer_file_long_string); 
   }
   
   
   $model_year=$row['model_year'];
   $paper=$row['paper'];
   $exam_id=$row['sl'];
   $test_code=$row['test_code'];
  //RIYAZ.. Get value from another table .. Answer Key

  echo '<!-- commented  .table thead th:last-child 
	   {
             padding-right: 10px;
	   }-->';
	 echo '<style>
	 .c 
	    {padding:0.5px ! important;
}
	 </style><div class="modal-dialog modal-lg">
      <div class="modal-content" style="    width: 130%;left: -16%;">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="display:inline;">Key File (.ias) for Test Code: <span style="font-weight:500;">'.$test_code.' </span>and Exam ID: <span style="font-weight:500;">' . $exam_id . '</span></h4><h4 class="modal-title" style="display:inline;position:relative;    left: 52%;"><!--Last Edited On:11-11-2017--></h4>
        </div>
        <div class="modal-body">
         <div class="row">
            <div class="col-md-12">
              <div class="card">';
	  echo '<center style="color:red;font-weight:bold;">'.$text.'</center>';
	  
	
	  
	  //
	  include "../../Exam_Admin/3_view_created_exam/z_ias_format.php";
	  
	   $response_array=ias_model_year_paper($model_year,$paper);
	  
	   $sub_array=$response_array[0];
	   $class_array=$response_array[1];
	   $no_of_question_per_section=$response_array[2];
	   $total_q=$response_array[3];
	   $question_number_array=$response_array[4];
	   
	   $temp=$no_of_question_per_section;
	  
               
	 
	  
	   $lc=1;
              $row_c= ceil($no_of_question_per_section/6);
	
	
	
	                      $count=1;
                    $question_series_count=1;
	
                    for($i=1;$i<=3;$i++)
                   {
                 echo ' <h5>'.$sub_array[$i].':</h5>
	
                <table class="table ">
                    <tbody>';
                        $break=0;
                        $question_series_count=1;
                        for($j=1;$j<=$row_c;$j++)
                        { 
                        echo

                         '<tr>';
                            
                            for($count=1;$count<=6;$count++)
                            {
                                   if($question_series_count<=$no_of_question_per_section)
                                {
                                   echo '<td class="c">'.$question_number_array[$lc-1].'</td>



                                         <td class="c"><input type="text" id="ias'.$lc.'"  class="'.$class_array[$lc].' inpclass" value="'.$key_answer_file_long_string_array[$lc-1].'" readonly/></td>';  $lc++;




                                         $question_series_count++;
                                         
                                }
                                else
                                { 
                                   //// echo '<td></td>
                                    //     <td></td>';

                                    //$question_series_count=1;
//$
                                }



                            }
                        


                       

                        echo '</tr>';  


                        }




                    
                   echo ' </tbody>
                  </table>
                  <div>&nbsp;</div>';          
        }
	  
	  
	  
	  
	  
	  
	  
	  //
	
	
}

function check_initial_condition_of_sl_advanced($con,$this_campus_id) //CRB not required
{
	$sl=$_POST['sl'];
	
	
	$res=$con->query("select * from 1_exam_admin_create_exam where sl='$sl'");
	$row=mysqli_fetch_array($res);
	
	
	$key_answer_file_long_string=$row['key_answer_file_long_string'];
	$last_date_to_upload=$row['last_date_to_upload'];
	$current_date=current_date_y_m_d();


    $res_recompute=$con->query("select * from 1_exam_recompute_request_campus_id where campus_id='$this_campus_id' and sl='$sl'");
   $count_recompute=mysqli_num_rows($res_recompute);

   if($count_recompute!=0)
   {

   	$row_recompute=mysqli_fetch_array($res_recompute);
   	$is_uploaded=$row_recompute['is_uploaded'];
   	if($is_uploaded=="0"){
   	echo "not_there"; exit;
   	}
   	else
   	if($is_uploaded=="1")
   	{
   	echo "already_there"; exit;
   	}
   }


	if($last_date_to_upload !="")
	{
	if($current_date>$last_date_to_upload)
	{  echo "date_over";
	exit;
	}	
	}
	
	
	
	
	if(($key_answer_file_long_string==""))
	{
	echo "ias_incomplete";
	exit;
	}
	
	
	$status_serialized=$row['status_serialized'];
	if($status_serialized !="")
	{
	  $status_non_serialized_array=unserialize($status_serialized);	
	  if(isset($status_non_serialized_array[$this_campus_id]))
	  {
	  echo "already_there"; exit;
	  }
	  else
	  {
	  echo "not_there"; exit;
	  }
	}
	else
	{
	echo "not_there"; exit;
	}
	
	//279  282
	
	
	exit;
}
//validate_students:validate_students($con,$response_array);


function multiple_usn($con,$this_campus_id) //CRB not required
{

$sl=$_POST['sl'];
$omr_scanning_type=$_POST['omr_scanning_type'];
$pre_app_array=$_POST['pre_app_array'];
 


 if($omr_scanning_type=="advanced")
 {
 	 $filename="uploads/$sl/temp_$this_campus_id.iit"; 
 }
 else
  if($omr_scanning_type=="non_advanced")
 {
 	 $filename="uploads/$sl/temp_$this_campus_id.dat"; 
 }

  $usn_array=$_POST['usn_array'];
  $key_array=$_POST['key_array'];
  $new_usn=$_POST['new_usn'];



  //...
  
  // $filename="2016P1.iit";

  // today / tomo .... 
 

   $string = file_get_contents($filename);
   $lines = file($filename);
   $current_usn_with_flag_if_exist=array();
   $j=0;
   $new_contents=array();


 if($omr_scanning_type=="advanced")
 {

 foreach ($lines as $line_num => $line)
	{
	$line=trim($line);	
	 $current_single_iit_line=$line;
         $current_single_iit_line_array=explode(",",$current_single_iit_line);
	 $old_usn=$current_single_iit_line_array[1];
        //echo $current_line;
        if($key_array[$j]==$line_num)
        {

        	

        	if($new_usn[$j]!=null)
        	{ 

            $new_usn_word=$new_usn[$j];

            $catch_A=$pre_app_array[$j];
            if(($catch_A=="A") && ($new_usn[$j]=="D"))
            	 {
            	 	$old_usn_with_flag_array=explode("-",$old_usn);
            	 	$old_only_usn=$old_usn_with_flag_array[0];
                    $new_usn_word=$old_only_usn."-D";

            	 }
            	 else
            	    if(($catch_A!="A") && ($new_usn[$j]=="D"))
            	 {
            	 	$old_usn_with_flag_array=explode("-",$old_usn);
            	 	$old_only_usn=$old_usn_with_flag_array[0];
                    $new_usn_word=$old_only_usn."-D";

            	 }	


 	    $current_single_iit_line_array[1]=$new_usn_word;
 	    $current_single_iit_line=implode('"', $current_single_iit_line_array);
 	    $current_single_iit_line=str_replace('"',",",$current_single_iit_line);
            $new_contents[]=$current_single_iit_line;
            }



            else{
              $new_contents[]=$current_single_iit_line;	
                }

               $j++;
        }
      else{
              $new_contents[]=$current_single_iit_line;
          }


     }	
     $new_contents = implode("\n", $new_contents);
     file_put_contents($filename, $new_contents); 

    // display_repeated();
     echo "done_rep_now";



 }

else
	if($omr_scanning_type=="non_advanced")
	{ $d_array=array();
	//echo json_encode($key_array);
	 foreach ($lines as $line_num => $line)
	{
	 $line=trim($line);	
	 $current_single_iit_line=$line;
        // $current_single_iit_line_array=explode(",",$current_single_iit_line);
	// $old_usn=$current_single_iit_line_array[1];

         //echo (   ($key_array[$j]-1)*4)+1; echo "---";
        //echo $current_line;
        if((($key_array[$j]-1)*4)+1==($line_num+1))
        {


	 $current_single_iit_line=$line;
         $current_single_iit_line_array=explode("=",$current_single_iit_line);
	 $old_usn=$current_single_iit_line_array[1];


        	if($new_usn[$j]!=null)
        	{ 

            $new_usn_word=$new_usn[$j];

            $catch_A=$pre_app_array[$j];
            if(($catch_A=="A") && ($new_usn[$j]=="D"))
            	 {
            	 	$old_usn_with_flag_array=explode("=",$line);
            	 	$old_only_usn=$old_usn_with_flag_array[0];
                    $new_usn_word=$old_only_usn."-D";

            	 }
            	 else
            	    if(($catch_A!="A") && ($new_usn[$j]=="D"))
            	 {
            	 	$old_usn_with_flag_array=explode("=",$line);
            	 	$old_only_usn=$old_usn_with_flag_array[0];
                    $new_usn_word=$old_only_usn."-D";

            	 }	


 	    //$current_single_iit_line_array[1]=$new_usn_word;
 	    //$current_single_iit_line=implode('"', $current_single_iit_line_array);
 	   // $current_single_iit_line=str_replace('"',",",$current_single_iit_line);
            $current_single_iit_line="No.=".$new_usn_word;
            $new_contents[]=$current_single_iit_line;
            }



            else{
              $new_contents[]=$current_single_iit_line;	
                }

               $j++;
        }
      else{
              $new_contents[]=$current_single_iit_line;
          }
//echo json_encode($d_array); exit;

     }	
     $new_contents = implode("\n", $new_contents);
     file_put_contents($filename, $new_contents); 

    // display_repeated();
     echo "done_rep_now";
	}


	//exit;



	exit;
}



function validate_students($con,$response_array,$sl,$omr_scanning_type) // AS OF NOW ADVANCED...ADD COMMENT IF CLUBBING FOR NON ADVANCED...NOW DOING NON ADVANCED HERE
{  
	//Check this function for CRB...dat_validate_db insert....


	/* ADVANCED
          $response_array=array();
	  $response_array[]="success";
	  $response_array[]="advanced";
	  $response_array[]=$sl;                     2
	  $response_array[]=$student_usn_array;      3
	  $response_array[]=$physics_marks_array;    4
	  $response_array[]=$chemistry_marks_array;  5
	  $response_array[]=$mathematics_marks_array;6
	  $response_array[]=$student_usn_flag_array; 7

	  $response_array[]=$response_array   ; 9
	  
	  
	  
	*/	  
	/* NON ADVANCED 
	  $response_array=array();
	  $response_array[]="success";
	  $response_array[]="non_advanced";
	  $response_array[]=$sl;                         2
	  $response_array[]=$students_id_array;          3
	  $response_array[]=$number_of_subject;          4
	  $response_array[]=$students_calculated_marks;  5
	  $response_array[]=0;                           6
	  $response_array[]=$student_usn_flag_array;     7

     */	

	  //echo json_encode($response_array[4]);exit;

	  //echo "valid"; echo json_encode($response_array[9]); exit;
	
    $omr_scanning_type=$response_array[1];
    $sl= $response_array[2];//exit;
	$student_usn_array=$response_array[3];
	$student_usn_flag_array=$response_array[7];

//echo json_encode($response_array[5]);exit; popo
    //ADD
/*
    $filename="2016P1.iit";
 $string = file_get_contents($filename);
 $lines = file($filename);
$current_usn_with_flag_if_exist=array();


 foreach ($lines as $line_num => $line)
  {
     $line=trim($line);   
     $current_single_iit_line=$line;
     if($current_single_iit_line=="")
     {
      continue;
     }
     $current_single_iit_line_array=explode(",",$current_single_iit_line);
    $current_usn_with_flag_if_exist[]=$current_single_iit_line_array[1];

  }
*/

	//ADD END











	/*
    echo sizeof($student_usn_array);
	echo json_encode($student_usn_array);
	echo sizeof($student_usn_flag_array);
	echo json_encode($student_usn_flag_array);
    */
	$temp_student_usn_array=array();
	$jump_array=array();
	$approve_jump_array=array();
	$dummy=1;
	foreach($student_usn_flag_array as $key=>$t_val)
	{ /*
       if($t_val !="D")
       {
         $temp_student_usn_array[]=$student_usn_array[$key];
       }
       else
       {
       	//$temp_student_usn_array[]=$student_usn_array[$key];
       	$jump_array[]=$key;
       }
       */

	         if($t_val =="D")
	       {
	         $temp_student_usn_array[]="dummy".$dummy++;
	       	 $jump_array[]=$key;
	       }
	       else
	       {


                   if($t_val =="A")
                   	 {
                   	 	$approve_jump_array[]=$key;
                   	 }


	       	$temp_student_usn_array[]=$student_usn_array[$key];
	       	
	       }
	}//pil

	//echo json_encode($jump_array);//exit;
//echo sizeof($temp_student_usn_array);
   // echo json_encode($temp_student_usn_array);
	


  //CHECK DOUBLE USN START
	
	//$data.= '<div class="content table-responsive">
//lolm

    // /*
	$duplicates=array_unique( array_diff_assoc( $temp_student_usn_array, array_unique( $temp_student_usn_array ) ) );
	$uarr = array_unique($temp_student_usn_array);
	$duplicates=(array_diff($temp_student_usn_array, array_diff($uarr, array_diff_assoc($temp_student_usn_array, $uarr))));
	$key_array=array();
	$j=1;


   // echo json_encode($duplicates);
	//exit;
	
	if(sizeof($duplicates)>0)
	{   $data="";
	$data.=  '<div id="dsiplay_here">';
	$data.='<div class="row">';
	$data.='<div class="col-md-12">';

	$data.='<div class="col-md-offset-3 col-md-6">';
	$data.= '<table class="table table-bordered">';
	//$data.= '<tr><th> scanned Serial</th><th>Repeated USN Number</th><th>Previous Approval State</th><th>Correct USN Number'.json_encode($duplicates).'</th>
	$data.= '<tr><th> scanned Serial</th><th>Repeated USN Number</th><th>Previous Approval State</th><th>Correct USN Number</th>
	<th>Delete</th></tr>';
	$trace=1;
	$break=1;
	$ccc=1;
	foreach($duplicates as $key=>$val)
	{       
	      $str="-";
	      //$class="no";
                  if(in_array(($key),$approve_jump_array))
                  {
                  	$str="Sent for Approval in Previous Iteration";
                  	//$class="approval";
                  }

                  if($omr_scanning_type=="advanced")
                  {
                  	$data.= '<tr><td>'.($key+1).'</td><td>'.$val.'</td><td style="text-align:center;" class="get_app">'.$str.'</td>'; 
                  }
                  else
                  if($omr_scanning_type=="non_advanced")
                  {
                  	$data.= '<tr><td>'.($key).'</td><td>'.$val.'</td><td style="text-align:center;" class="get_app">'.$str.'</td>'; 
                  }

	      
	      
	      $data.= '<td><input type="text" id="inp'.$j++.'"></td>
                  <td><button type="button" class="btn btn-warning btn-xs warning-btn" onclick="del2('.$ccc++.');">Delete</button></td>
	      </tr>';
	          $key_array[]=$key;
	          $trace++;
	          $break++;
	}


	$data.= '</table>';
	if(sizeof($duplicates)>0 && $break==1)
	{
	goto here;
	}

	$duplicate_string=implode(",",$duplicates);
	$key_string=implode(",",$key_array);
	$data.= '<input type="hidden" id="x" value="'.$duplicate_string.'">';
	$data.= '<input type="hidden" id="y" value="'.$key_string.'">';

        if($omr_scanning_type=="advanced")
        {
          
          $data.= '<button id="but" onclick="multiple_usn(\''.$sl.'\',\''.$omr_scanning_type.'\')">Change</button>';
        }
        else
        	if($omr_scanning_type=="non_advanced")
        	{
        	$data.="<span style='color: red;font-weight: bold;'>Above are the Duplicates USN numbers in the .dat... Change the USN in the dat and re upload once again.. !! </span>";
        	}
	



	$data.= '</div></div></div></div>';

              //multiple_usn response
              $response_display_array=array();

	  $response_display_array[0]="multiple_usn";
	  $response_display_array[1]=$data;
	
	  echo json_encode($response_display_array); exit;





	 }
	else
	{
	
	}
	    

//*/
 //CHECK DOUBLE USN ENDS	

here:
	$res=$con->query("select * from 1_exam_admin_create_exam where sl='$sl'");
	
	
	$row=mysqli_fetch_array($res);
	
	echo mysqli_error($con); //exit;
	$omr_scanning_type=$row['omr_scanning_type'];
	$subject_string_final=$row['subject_string_final'];
	
	
	$res2=$con->query("select * from 1_exam_gcsp_id where test_sl='$sl'");
	$exam_group_id_array=array();
	$exam_stream_id_array=array();
	$exam_program_id_array=array();
	$exam_class_id_array=array();
	
	while($row2=mysqli_fetch_array($res2))
	{
	
	$exam_group_id_array[]=$exam_group_id=$row2['GROUP_ID'];
	$exam_stream_id_array[]=$exam_stream_id=$row2['STREAM_ID'];
	$exam_program_id_array[]=$exam_program_id=$row2['PROGRAM_ID'];
	$exam_class_id_array[]=$exam_class_id=$row2['CLASS_ID'];	
	}

/*
echo json_encode($exam_group_id_array);
echo json_encode($exam_stream_id_array);
echo json_encode($exam_program_id_array);
echo json_encode($exam_class_id_array);
exit;
*/
	
    $gcsp_count=sizeof($exam_group_id_array);
    $track=0;

  

	$campus_id=$_SESSION['campus_id'];
	
	$wrong_usn_array=array();
	$description_array=array();
	$error_usn_string="";
	$scanned_paper_number_array=array();
	$scanned_paper_number=0;
	$usn_correct_desc_array=array();

	//echo json_encode($student_usn_array); exit;
	
	foreach ($student_usn_array as $key=>$value) 
	  {//Ganu for start
	     $scanned_paper_number++;
	 if($student_usn_flag_array[$key]=="D") continue;
	 if($student_usn_flag_array[$key]=="A") continue;
	 if($value=="Starting_0_Index_Dummy") { $scanned_paper_number--; continue;}
	 
	 
	 //lolu



             $mismatch_position_catch_array=array();
             $position_description_array=array();
             $position_scanned_paper_number_array=array();

             


          for($track=0;$track<$gcsp_count;$track++)
          	{ //track start
	 
	 //ROW
	     $res=$con->query("select * from t_student ts,t_program_name tp,t_stream s,t_study_class tc where ts.ADM_NO LIKE '__$value' and ts.CAMPUS_ID='$campus_id' and ts.PROGRAM_ID=tp.PROGRAM_ID and ts.STREAM_ID=s.STREAM_ID and ts.CLASS_ID=tc.CLASS_ID");

          //$res=$con->query("select * from t_student where ADM_NO LIKE '__$value' and CAMPUS_ID='$campus_id' ");
	 
 
	 $count=mysqli_num_rows($res);
	 if($count==0)
	 { 	
           $mismatch_position_catch_array[]=1;	 //INVALID USN  
            

	 }
	 else
	 {//USN BELONGS TO THIS COLLEGE STARTS
	           $row=mysqli_fetch_array($res);
	   $course_track_id=$row['COURSE_TRACK_ID'];



	          // $res2=$con->query("select * from t_course_track tc,t_course_group tg where COURSE_TRACK_ID='$course_track_id' and tc.GROUP_ID=tg.GROUP_ID");
	   //ROW2
	   $res2=$con->query("select * from t_course_track where COURSE_TRACK_ID='$course_track_id'");
	   $row2=mysqli_fetch_array($res2);
	   $this_student_admission_number=$row['ADM_NO'];  //$row is correct
	   $this_student_group_id=$row2['GROUP_ID'];


	   $this_student_stream_id=$row['STREAM_ID'];
	   $this_student_program_id=$row['PROGRAM_ID']; 
	   $this_student_class_id=$row['CLASS_ID'];

	  // $row2=mysqli_fetch_array($res2);
	  // $this_student_admission_number=$row['ADM_NO'];  //$row is correct

             //$res3=$con->query("select * from t_course_track tc,t_course_group tg where COURSE_TRACK_ID='$course_track_id' and tc.GROUP_ID=tg.GROUP_ID");
            // $row3=mysqli_fetch_array($res3);
	   $this_student_group_name=$row2['GROUP_NAME'];

	   $this_student_stream_name=$row['STREAM_NAME'];
	   $this_student_program_name=$row['PROGRAM_NAME'];
	   $this_student_class_name=$row['CLASS_NAME'];       





	   //echo "stud stream id=".$this_student_stream_id."exam stream id=".$exam_stream_id_array[$track]; echo '\n';
	   //exit;

	if($this_student_group_id !=$exam_group_id_array[$track]) 
	{
	$mismatch_position_catch_array[]=2; //GROUP MISMATCH
	}
	 else
	{
	   if($this_student_stream_id !=$exam_stream_id_array[$track])
	   {	
	   $mismatch_position_catch_array[]=3; //STREAM MISMATCH	   
	   }  
                else
	{
	 if($this_student_program_id !=$exam_program_id_array[$track])
	   {
	   	$mismatch_position_catch_array[]=4; //PROGRAM MISMATCH
	   }
	   else
	   {
	  if($this_student_class_id !=$exam_class_id_array[$track])
	   {
	   	$mismatch_position_catch_array[]=5; //CLASS YEAR MISMATCH
	   }
	   
	   }
	
	}	
	 
	}
	 
	 }//USN BELONGS TO THIS COLLEGE ENDS
	 
	 
	}//track end


//oooo

	//echo "Mismatch Position Catch Array=>";
	   //echo json_encode($mismatch_position_catch_array); exit;


        $mismatch_line_count=sizeof($mismatch_position_catch_array);

       // echo "mIsmatch Line count=".$mismatch_line_count."GCSP COUNT=".$gcsp_count;
       // echo "gscp coun t=".$gcsp_count."mismatch catch counr=".$mismatch_line_count;


         	if($gcsp_count==$mismatch_line_count)
         {
           // echo "max is";

            //if($mismatch_line_count==0)
            	//continue;



         	 $max_of_mismatch_position_catch_array=max($mismatch_position_catch_array);
            //exit;


         	if($max_of_mismatch_position_catch_array==1)
         	{$wrong_usn_array[]=$value;$description_array[]="USN Doesnot Belong to This College";$scanned_paper_number_array[]=$scanned_paper_number;
             $usn_correct_desc_array[]="NA";

         	}
         	else
         	if($max_of_mismatch_position_catch_array==2)
         	{$wrong_usn_array[]=$value;$description_array[]="Group Mismatch";$scanned_paper_number_array[]=$scanned_paper_number;
             $usn_correct_desc_array[]=$this_student_group_name."-".$this_student_class_name."-".$this_student_stream_name."-".$this_student_program_name;
         	}
         	else
         	if($max_of_mismatch_position_catch_array==3)
         	{$wrong_usn_array[]=$value;$description_array[]="Stream Mismatch";$scanned_paper_number_array[]=$scanned_paper_number;
             $usn_correct_desc_array[]=$this_student_group_name."-".$this_student_class_name."-".$this_student_stream_name."-".$this_student_program_name;
         	}
         	else
         	if($max_of_mismatch_position_catch_array==4)
         	{$wrong_usn_array[]=$value;$description_array[]="Program Mismatch";$scanned_paper_number_array[]=$scanned_paper_number;
             $usn_correct_desc_array[]=$this_student_group_name."-".$this_student_class_name."-".$this_student_stream_name."-".$this_student_program_name;
         	}
         	else
         	if($max_of_mismatch_position_catch_array==5)
         	{$wrong_usn_array[]=$value;$description_array[]="Class Year Mismatch";$scanned_paper_number_array[]=$scanned_paper_number;
            $usn_correct_desc_array[]=$this_student_group_name."-".$this_student_class_name."-".$this_student_stream_name."-".$this_student_program_name;
         	}


           	 
	         	
	         

         }



	 
 }//Ganu for End
 //exit;
	/*
exit;
  
    echo "Wrong USN ARRAY=";
	echo json_encode($wrong_usn_array);
	echo "Mismatch Position Catch Array=>";
	echo json_encode($mismatch_position_catch_array);
	echo "ALL USN=";
	echo json_encode($student_usn_array); exit;

	//echo json_encode($mismatch_position_catch_array); exit;
//$wrong_usn_array[]=$value;
	       //$description_array[]="USN Doesnot Belong to This College";
           //$scanned_paper_number_array[]=$scanned_paper_number;
	*/
	$wrong_usn_array_count=sizeof($wrong_usn_array);
	
	if($wrong_usn_array_count>=1) // Mismatch is present
	{
	
	
	//$random_number=5;
	//$i=0;
	
    
	$data="";
	$data.= '<div class="content table-responsive">
	 <div class="col-md-11">';
	$data.=  '<table class="table table-hover  table-bordered"><thead>
	   <tr style="font-size:16px;color:#040404;"><td>Scanned Paper Serial</td><td> USN </td><td>Entered USN\'s Info</td><td>Actual Belongs to(GCSP)</td>';


 if($omr_scanning_type=="advanced")
 {
 	$data.='<td>Physics</td><td>Chemistry</td><td>Mathematics</td>';
 }
else
if($omr_scanning_type=="non_advanced")	
{
	
$subject_string_final_array=explode(",",$subject_string_final);
$sub_name=array();

//echo json_encode($subject_string_final); exit;
foreach($subject_string_final_array as $ind_sub)
{
 $res_sub=$con->query("select subject_name from 0_subjects where subject_id='$ind_sub'");
 $row_sub=mysqli_fetch_array($res_sub);
 $sub_name[]=$row_sub['subject_name'];
}

$sub_size=sizeof($sub_name);
foreach($sub_name as $disp)
{
	$data.='<td style="text-transform: capitalize;">'.$disp.'</td>';
}

}


        
	   $data.='<td>Total</td><td> Enter Correct USN</td>
	   <td style="color:green;    font-size: 15px;
	font-weight: bold;">Approve</td>
	   <td style="color:red;    font-size: 15px;
	font-weight: bold;">Delete</td><tr></thead>';
	   $error_usn_string="";
	   
	   
	for($i=0;$i<$wrong_usn_array_count;$i++)
	{
	 $data.= '<tr><td class="scanned_number">'.$scanned_paper_number_array[$i].'</td><td> '.$wrong_usn_array[$i].' </td>
	 <td id="info'.$i.'">'.$description_array[$i].'</td>
	 <td>'.$usn_correct_desc_array[$i].'</td>';


 if($omr_scanning_type=="advanced")
 {
 	$t_total=$response_array[4][$scanned_paper_number_array[$i]-1]+$response_array[5][$scanned_paper_number_array[$i]-1]+$response_array[6][$scanned_paper_number_array[$i]-1];
    $data.='<td style="text-align:center;">'.$response_array[4][$scanned_paper_number_array[$i]-1].'</td><td style="text-align:center;">'.$response_array[5][$scanned_paper_number_array[$i]-1].'</td><td style="text-align:center;">'.$response_array[6][$scanned_paper_number_array[$i]-1].'</td><td style="text-align:center;">'.$t_total.'</td>';
 }
 else
  if($omr_scanning_type=="non_advanced")
 {
 	//$t_total=$response_array[4][$scanned_paper_number_array[$i]-1]+$response_array[5][$scanned_paper_number_array[$i]-1]+$response_array[6][$scanned_paper_number_array[$i]-1];

     $this_tot=0;
      for($ite=0;$ite<$sub_size;$ite++)
      {
        $this_tot+=$response_array[5][$scanned_paper_number_array[$i]][$ite+1];
      	$data.='<td style="text-align:center;">'.$response_array[5][$scanned_paper_number_array[$i]][$ite+1].'</td>';
      }
    
      $data.='<td style="text-align:center;">'.$this_tot.'</td>';

   // $response_array[5]
 }

     






	  $data.= '<td><input type="text" id="usn'.$i.'" autofocus class="uinput"></td>
	 <td ><button type="button" class="btn btn-success btn-xs success-btn" onclick="approve('.$i.');">Approve</button></td>
	 <td><button type="button" class="btn btn-warning btn-xs warning-btn" onclick="del('.$i.');">Delete</button></td><tr>';
	 
	 
	 if($error_usn_string==""){$error_usn_string= $wrong_usn_array[$i];}
	 else {$error_usn_string= $error_usn_string.",".$wrong_usn_array[$i];}



	}

            
	 $data.= '</table>
	    
	 	 	 <button  class="btn btn-info btn-fill" onclick="reprocess(\''.$error_usn_string.'\','.$sl.',\''.$omr_scanning_type.'\',\''.$wrong_usn_array_count.'\')" >RE PROCESS</button>
	 <button  class="btn btn-info btn-fill" onclick="hide_div(1)">CLOSE</button>


	 
	 
	 </div>
	  <div class="col-md-1">
                 <button  class="btn  btn-fill btn-success" style="margin-left: -2%;
    position: fixed;" onclick="fast_app_del(\''.$wrong_usn_array_count.'\')" >
                  Fast✓(App/D)
                 </button><br>

                 <button  class="btn  btn-fill btn-primary" style="margin-left: -2%;margin-top:2%;
    position: fixed;" onclick="reset_app_del(\''.$wrong_usn_array_count.'\')" >
                  Reset(App/D)
                 </button>
                 

	  </div>


	 
	 </div>


	 
	 ';
	 

	 //Mismatch is Present......
            if($omr_scanning_type=="advanced")
	{$response_display_array=array();

	  $response_display_array[0]="usn_mismatch_error_advanced";
	  $response_display_array[1]=$data;
	
	echo json_encode($response_display_array); 
            }
	else
	  if($omr_scanning_type=="non_advanced")
	{$response_display_array=array();
	
	  $response_display_array[0]="usn_mismatch_error_non_advanced";
	  $response_display_array[1]=$data;
	
	echo json_encode($response_display_array); 
            }
	
	
	exit;
	
	}


	else //Condition for mismatch is not present.... add data in database....
	{ 
	

	/*


         This function is:   validate_students function...
        Below both is for not_recompute...because recomputing dont deal with validating students for mismatch again... but it ll take care of 101_mismatch_approval_request later



	*/
	 if($omr_scanning_type=="advanced")
	 {
	  $response_array2=array();
	  $response_array2[]="success";
	  $response_array2[]="advanced";
	  $response_array2[]=$response_array[2]; //sl
	  $response_array2[]=$response_array[3]; //usn
	  $response_array2[]=$response_array[4]; //phy
	  $response_array2[]=$response_array[5]; //che
	  $response_array2[]=$response_array[6]; //maths
	  $response_array2[]=$response_array[7]; //usn flag
	  $response_array2[]="not_recompute";
	  $response_array2[]=$response_array[9]; //R_U_W string array...
	  
	          db_insert_and_status_update_success($con,$response_array2);
	 }
	 else
	 if($omr_scanning_type=="non_advanced")
	 {
	  $response_array2=array();
	  $response_array2[]="success";
	  $response_array2[]="non_advanced";
	  $response_array2[]=$response_array[2]; //sl
	  $response_array2[]=$response_array[3]; //usn
	  $response_array2[]=$response_array[4]; //no of sub
	  $response_array2[]=$response_array[5]; //student calculated marks
	  $response_array2[]=$response_array[6]; //0
	  $response_array2[]=$response_array[7]; //student usn flag array
	  $response_array2[]="not_recompute";
	  
	   
                  db_insert_and_status_update_success($con,$response_array2);
	  
	   exit;
	  
	  
	 
	 }
	}
	
	
	exit;
}

function reprocess_old_and_new_usn($con,$this_campus_id) //NOW DOING FOR ADVANCED..UPDATE HERE IF DOING FOR NON ADVANCED.. NOW DOING ON ADVANCED....  CRB not required
{
	 $sl=$_POST['sl'];
	 $old_usn_string=$_POST['old_usn_string'];
	 $old_usn_array=explode(",",$old_usn_string);
     $new_usn_string=$_POST['new_usn_string'];
	 $new_usn_array=explode(",",$new_usn_string);

	 $scanned_number=$_POST['scanned_number'];
	 
	 $res=$con->query("select * from 1_exam_admin_create_exam where sl='$sl'");
	 $row=mysqli_fetch_array($res);
	 $omr_scanning_type=$row['omr_scanning_type'];
	 
   if($omr_scanning_type=="advanced")
   {
	   
	   
	   
	        $file_name = "uploads/$sl/temp_$this_campus_id.iit"; //set your folder path
	//$new_file_name="uploads/$sl/$this_campus_id.iit";
	// Correct: Here OLD USN should be replaced with NEw USN Array in the temp file itself... after succesfull correct usn and db then file should be renamed as original...
	$oldMessage = "";
	$deletedFormat = "";

	//read the entire string
	$str=file_get_contents($file_name);
	$length=sizeof($old_usn_array);


                 /*
	 for($i=0;$i<$length;$i++)
	 { 
	         if($new_usn_array[$i]=="D")
	 {
	$str = preg_replace("/[a-z],$old_usn_array[$i],/", "x,$old_usn_array[$i]-D,", $str);  
	 }
	 else
	 if($new_usn_array[$i]=="A")
	 {
	$str = preg_replace("/[a-z],$old_usn_array[$i],/", "x,$old_usn_array[$i]-A,", $str);  
	 }
	 else
	 $str = preg_replace("/[a-z],$old_usn_array[$i],/", "x,$new_usn_array[$i],", $str); 
	// $str=str_replace($old_usn_array[$i], "$new_usn_array[$i]",$str); 
	 }

	file_put_contents($file_name, $str);

	echo "changed";
	exit;
	              */
            //NEW START
               $string = file_get_contents($file_name);
               $lines = file($file_name);
              // echo json_encode($scanned_number);
              foreach($scanned_number as $index=>$ind_scanned_number)
              { //echo $ind_scanned_number; echo "<br>";
                   if($new_usn_array[$index]=="D")
	 { 
	//$str = preg_replace("/[a-z],$old_usn_array[$i],/", "x,$old_usn_array[$i]-D,", $str);  
                    $this_full_line= $lines[$ind_scanned_number-1]; // old line
                    $temp_line=$this_full_line;
                    $current_single_iit_line_array=explode(",",$this_full_line);
	            $old_usn=$current_single_iit_line_array[1]; 
	            $new_usn=$old_usn."-D";
	            $new_replaced_line=preg_replace("/[a-z],$old_usn/", "x,$new_usn", $temp_line); //new line
	           // $string = preg_replace("/[a-z],$old_usn_array[$i],/", "x,$new_usn_array[$i],", $str); 
	            $string=str_replace($this_full_line, $new_replaced_line,$string);

	 }
	   else
	   if($new_usn_array[$index]=="A")
	 {
	//$str = preg_replace("/[a-z],$old_usn_array[$i],/", "x,$old_usn_array[$i]-D,", $str);  
                    $this_full_line= $lines[$ind_scanned_number-1]; // old line
                    $temp_line=$this_full_line;
                    $current_single_iit_line_array=explode(",",$this_full_line);
	            $old_usn=$current_single_iit_line_array[1]; 
	            $new_usn=$old_usn."-A";
	            $new_replaced_line=preg_replace("/[a-z],$old_usn/", "x,$new_usn", $temp_line); //new line
	           // $string = preg_replace("/[a-z],$old_usn_array[$i],/", "x,$new_usn_array[$i],", $str); 
	            $string=str_replace($this_full_line, $new_replaced_line,$string);

	 }
	 else
	 {
	 	 
	//$str = preg_replace("/[a-z],$old_usn_array[$i],/", "x,$old_usn_array[$i]-D,", $str);  
                    $this_full_line= $lines[$ind_scanned_number-1]; // old line
                    $temp_line=$this_full_line;
                    $current_single_iit_line_array=explode(",",$this_full_line);
	            $old_usn=$current_single_iit_line_array[1];
	            $new_usn=$new_usn_array[$index];
	            $new_replaced_line=preg_replace("/[a-z],$old_usn/", "x,$new_usn", $temp_line); //new line
	           // $string = preg_replace("/[a-z],$old_usn_array[$i],/", "x,$new_usn_array[$i],", $str); 
	            $string=str_replace($this_full_line, $new_replaced_line,$string);

	 
	 }


              }

              	file_put_contents($file_name, $string);

	            echo "changed";
	            exit;



	//NEW ENDS










   }
   else
	   if($omr_scanning_type=="non_advanced")
{
	   
	    $file_name = "uploads/$sl/temp_$this_campus_id.dat"; //set your folder path
	//$new_file_name="uploads/$sl/$this_campus_id.iit";
	// Correct: Here OLD USN should be replaced with NEw USN Array in the temp file itself... fdatz succesfull correct usn and db then file should be renamed as original...
	$oldMessage = "";
	$deletedFormat = "";

	//read the entire string
	$str=file_get_contents($file_name);
	$length=sizeof($old_usn_array);



	 for($i=0;$i<$length;$i++)
	 { 
	         if($new_usn_array[$i]=="D")
	 {
	$str = preg_replace("/=$old_usn_array[$i][\n\r]/", "=$old_usn_array[$i]-D", $str);  
	 }
	 else
	 if($new_usn_array[$i]=="A")
	 {
	$str = preg_replace("/=$old_usn_array[$i][\n\r]/", "=$old_usn_array[$i]-A", $str);  
	 }
	 else
	 $str = preg_replace("/=$old_usn_array[$i][\n\r]/", "=$new_usn_array[$i]", $str); 
	// $str=str_replace($old_usn_array[$i], "$new_usn_array[$i]",$str); 
	 }

	file_put_contents($file_name, $str);
	  echo "changed";
	exit; 

           //  PREVIOUS
	
              /*
             	        $file_name = "uploads/$sl/temp_$this_campus_id.dat"; //set your folder path
	//$new_file_name="uploads/$sl/$this_campus_id.iit";
	// Correct: Here OLD USN should be replaced with NEw USN Array in the temp file itself... after succesfull correct usn and db then file should be renamed as original...
	$oldMessage = "";
	$deletedFormat = "";

	//read the entire string
	$str=file_get_contents($file_name);
	$length=sizeof($old_usn_array);

   //echo json_encode($scanned_number);

            //NEW START
               $string = file_get_contents($file_name);
               $lines = file($file_name);
              // echo json_encode($scanned_number);
              foreach($scanned_number as $index=>$ind_scanned_number)
              { //echo $ind_scanned_number; echo "<br>";
                   if($new_usn_array[$index]=="D")
	 { 
	//$str = preg_replace("/[a-z],$old_usn_array[$i],/", "x,$old_usn_array[$i]-D,", $str);  
                    //$this_full_line= $lines[$ind_scanned_number-1];     // old line
                    $this_full_line= $lines[(($ind_scanned_number-1)*4)];

                    $temp_line=$this_full_line; //exit;
                    $current_single_iit_line_array=explode("=",$this_full_line);
	            $old_usn=$current_single_iit_line_array[1]; 
	            $new_usn="No.=".$old_usn."-D";

	            //No.=0371077


	            $new_replaced_line=preg_replace($temp_line,$new_usn, $temp_line); //new line
	           // $string = preg_replace("/[a-z],$old_usn_array[$i],/", "x,$new_usn_array[$i],", $str); 
	            $string=str_replace($this_full_line, $new_replaced_line,$string);

	 }
	   else
	   if($new_usn_array[$index]=="A")
	 {
	//$str = preg_replace("/[a-z],$old_usn_array[$i],/", "x,$old_usn_array[$i]-D,", $str);  
                    $this_full_line= $lines[(($ind_scanned_number-1)*4)]; // old line
                    $temp_line=$this_full_line;
                    $current_single_iit_line_array=explode("=",$this_full_line);
	            $old_usn=$current_single_iit_line_array[1]; 
	            $new_usn="No.=".$old_usn."-A";
	            $new_replaced_line=preg_replace($temp_line,$new_usn, $temp_line); //new line
	           // $string = preg_replace("/[a-z],$old_usn_array[$i],/", "x,$new_usn_array[$i],", $str); 
	            $string=str_replace($this_full_line, $new_replaced_line,$string);

	 }
	 else
	 {
	 	 
	//$str = preg_replace("/[a-z],$old_usn_array[$i],/", "x,$old_usn_array[$i]-D,", $str);  
                    $this_full_line= $lines[(($ind_scanned_number-1)*4)]; // old line
                    $temp_line=$this_full_line;
                    $current_single_iit_line_array=explode("=",$this_full_line);
	            $old_usn=$current_single_iit_line_array[1];
	            $new_usn="No.=".$new_usn_array[$index];
	            $new_replaced_line=preg_replace($temp_line, $new_usn, $temp_line); //new line
	           // $string = preg_replace("/[a-z],$old_usn_array[$i],/", "x,$new_usn_array[$i],", $str); 
	            $string=str_replace($this_full_line, $new_replaced_line,$string);
                   // k
	 
	 }


              }

              	file_put_contents($file_name, $string);

	            echo "changed";
	            exit;
	            */
}
	  

	
	
}


function display_result_of_sl_advanced($con,$this_campus_id) //CRB not required....EXITED Function...
{     

	exit;
	   $sl=$_POST['sl'];
	$current_date=current_date_d_m_y();
	$current_time=current_time_12_hour_format_h_m_s();
	
	
$res2=$con->query("select * from 1_exam_admin_create_exam where sl='$sl'");
$row2=mysqli_fetch_array($res2);

$test_mode_id=$row2['mode'];
$result_generated1_no0=$row2['result_generated1_no0'];

$res_now=$con->query("select * from 101_mismatch_approval_request where test_sl='$sl' and this_college_id='$this_campus_id' ORDER BY TOTAL DESC");
$count_now=mysqli_num_rows($res_now);

$res_table_name=$con->query("select marks_upload_temp_table_name,marks_upload_final_table_name from 0_test_modes where test_mode_id='$test_mode_id'");
$row_table_name=mysqli_fetch_array($res_table_name);


$marks_upload_temp_table_name=$row_table_name['marks_upload_temp_table_name'];
$marks_upload_final_table_name=$row_table_name['marks_upload_final_table_name'];

//$result_generated1_no0=1;
if($result_generated1_no0==0)
{
$marks_upload_table_name=$marks_upload_temp_table_name;	

}
else
{
$marks_upload_table_name=$marks_upload_final_table_name;
}

	

	$res=$con->query("select * from $marks_upload_table_name where test_code_sl_id='$sl' and this_college_id='$this_campus_id' ORDER BY TOTAL DESC");
	$count=mysqli_num_rows($res);
	//$test_code=$row['test_code'];
	echo '<div class="modal-dialog modal-lg" >
      <div class="modal-content" style="    width: 125%;left: -13%;">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="display:inline;">Result</h4><h4 class="modal-title" style="display:inline;position:relative;    left: 53%;">Last Data as on: '.$current_date.' at '.$current_time.'</h4>
	  <!--<button style="display:inline;position:relative;    left: 53%;" onclick="display_result_of_sl('.$sl.');">Ref</button>-->
	  
	  <img src="../assets/img/refresh.png" height="60" width="60" style="display:inline;position:relative;cursor:pointer;    margin-top: -1%;    left: 52%;" onclick="display_result_of_sl('.$sl.');">
	  
	  
        </div>
        <div class="modal-body" style="min-height: 400px;">
         <div class="row">
           
            <div class="col-md-offset-2 col-md-8">

              <table class="table table-responsive table-bordered table-hover" style="border:1px solid #dec6c6;text-align:center">';

              
	  if($result_generated1_no0==0)
	  {
	  	echo ' <tr><th>Status</th><th>Sl</th><th>Student Id</th><th>PHYSICS</th><th>CHEMISTRY</th><th>MATHEMATICS</th><th>Total</th></tr>';
	  }
               else
               	if($result_generated1_no0==1)
               	{
                 echo ' <tr><th>Sl</th><th>Student Id</th><th>PHYSICS</th><th>CHEMISTRY</th><th>MATHEMATICS</th><th>Total</th><th>Section</th><th>Campus</th><th>City</th><th>District</th><th>State</th><th>All India</th></tr>';
               	}

	if($count_now>=1)
	{   $a_int=1;
	       
	while($row_now=mysqli_fetch_array($res_now))
	{
	$subject_marks_string=$row_now['other_subjects_info'];
	$subject_marks_array=explode(",",$subject_marks_string);
	echo '<tr style="background-color:red;"><td style="">Approval</td><td>'.$a_int++.'</td><td>'.$row_now['STUD_ID'].'</td>';
	echo '<td>'.$row_now['PHYSICS'].'</td>';
	echo '<td>'.$row_now['CHEMISTRY'].'</td>';
	echo '<td>'.$row_now['MATHEMATICS'].'</td>';
	
	echo '<td>'.$row_now['TOTAL'].'</td>';
	}
	
	}


	$it=1;
	$total=0;

	if($result_generated1_no0==0)
	{
	while($row=mysqli_fetch_array($res))
	{ //$total=$row['PHYSICS']+$row['CHEMISTRY']+$row['MATHEMATICS'];
	
	echo '<tr><td style="color:green;">Confirmed</td><td>'.$it++.'</td><td>'.$row['STUD_ID'].'</td><td>'.$row['PHYSICS'].'</td><td>'.$row['CHEMISTRY'].'</td><td>'.$row['MATHEMATICS'].'</td><td>'.$row['TOTAL'].'</td></tr>';
	}	
	}

	else
	if($result_generated1_no0==1)
	{
	while($row=mysqli_fetch_array($res))
	{ //$total=$row['PHYSICS']+$row['CHEMISTRY']+$row['MATHEMATICS'];
	
	echo '<tr><td>'.$it++.'</td><td>'.$row['STUD_ID'].'</td><td>'.$row['PHYSICS'].'</td><td>'.$row['CHEMISTRY'].'</td><td>'.$row['MATHEMATICS'].'</td><td>'.$row['TOTAL'].'</td><td>'.$row['SEC_RANK'].'</td><td>'.$row['CAMP_RANK'].'</td><td>'.$row['CITY_RANK'].'</td><td>'.$row['DISTRICT_RANK'].'</td><td>'.$row['STATE_RANK'].'</td><td>'.$row['ALL_INDIA_RANK'].'</td></tr>';
	}
	}






	
              echo '</table>';	
                     if($count==0)
	 {
	 echo '<center style="color:red;">RESULT IS NOT GENERATED YET..Upload .DAT and Process</center>';
	 }	 

	   
            echo '</div>



            
          </div>

          
        </div>
        <div class="modal-footer">
             <button type="submit" class="btn btn-info btn-fill pull-right" data-dismiss="modal">CLOSE</button>
          
        </div>
      </div>
    </div>';
	
	exit;
}

//  BLOCK IS FOR ADVANCED--ENDS





?>

<?php

if($del=="yes")
{
	return false;
}

?>

<script src="aria-progressbar.js"></script>
	
        <script>
            $(function () {
	
	 'use strict';
      var pgb = $('#pgb');
      var i = 0;
      pgb.ariaProgressbar({
        progressClass: 'progress progress_streamtext'
      });
	  pgb.ariaProgressbar('update', i);
	  
	  
	  
   
            });


     function upload_and_process_dat_of_exam_sl(sl,advanced_or_non_advanced,reprocess_status)
	 {
	// alert("SHOW"+sl+advanced_or_non_advanced);
	    $('.myprogress').css('width', '0');
                    $('.msg').text('');
                    var filename = $('#filename').val();
                    var myfile = $('#myfile').val();
	filename="temp";
                    if (filename == '' || myfile == '') {
                        alert('Please enter file name and select file');
                        return;
                    }
                    var formData = new FormData();
                    formData.append('myfile', $('#myfile')[0].files[0]);
                    formData.append('filename', filename);
	formData.append('sl', sl);
	formData.append('advanced_or_non_advanced', advanced_or_non_advanced);
	
                    $('#btn').attr('disabled', 'disabled');
                     $('.msg').text('Uploading in progress...');
                    $.ajax({
                        url: 'uploadscript.php',
                        data: formData,
                        processData: false,
                        contentType: false,
                        type: 'POST',
                        // this part is progress bar
                        xhr: function () {
	
                            var xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener("progress", function (evt) {
                                if (evt.lengthComputable) {
                                    var percentComplete = evt.loaded / evt.total;
                                    percentComplete = parseInt(percentComplete * 100);
                                    $('.myprogress').text(percentComplete + '%');
                                    $('.myprogress').css('width', percentComplete + '%');
	//if()
                                }
                            }, false);
                            return xhr;
                        },
                        success: function (data) {
	//alert("completed");
	data=data.trim();
	
	$('.msg').text(data);
	if(data=="Invalid File Format")
	{   if(advanced_or_non_advanced=="non_advanced")
	{
	$('.msg').text("Invalid File Format... Upload Proper (.dat) Once again");
	alert("Invalid File Format... Upload Proper (.dat) Once again"); return false;	
	}
	
	else
	if(advanced_or_non_advanced=="advanced")
	{
	$('.msg').text("Invalid File Format... Upload Proper (.iit) Once again");
	alert("Invalid File Format... Upload Proper (.iit) Once again"); return false;	
	}
	
	}
	
	if(data=="File Uploaded Successfully!!!")
	
	{    delete_previous_approval_list(sl,reprocess_status);
	 
	}
                            
	
                            
                           // $('#btn').removeAttr('disabled');
                        }
                    });
	 }
	 
	  function web_process_call(sl)
	  {
	  	//alert("webP");

	  	var reprocess_status="no_reprocess";
        var temp='oo';

        alert(temp);
        $("#upload_div").html(temp);
	  	  $("#upload_div").removeClass('hidden');
	$("#opacity_div").removeClass('hidden');

	return false;
        delete_previous_approval_list(sl,reprocess_status);

        	 // $("#upload_div").html(data);
	

	  }
	  
	  function delete_previous_approval_list(sl,reprocess_status)
	  {
	  //alert(sl); return false;
	  var delete_previous_approval_list="yes";
	  $.ajax({
	        url:"ajax_php.php",
	data:{delete_previous_approval_list:delete_previous_approval_list,sl:sl},
	type:"POST",
	success:function(data)
	{
	data=data.trim();
	//alert(data);
	if(data=="flushed_success")
	{
	setTimeout(function(){ 
	           dat_conversion_function(sl,reprocess_status);
	              }, 500);
	}
	}
	       
	        });
	  }
	  
	  
	  
	  
	  function dat_conversion_function(sl,reprocess_status)
	  {// alert("dcf");
  //alert("reps->"+reprocess_status);
  //alert("a");
	  localStorage.setItem("convertion_status", "not_finished");
	  if(reprocess_status!="reprocess")
	  {
	before_after_timer("before");  
	  }
	  
	         
	         
	
	  var dat_conversion_function="yes";
	  $.ajax({
	       url:"ajax_php.php",
	   async:"true",
	   data:{dat_conversion_function:dat_conversion_function,sl:sl,reprocess_status:reprocess_status}, //BOTH ADV NON ADVANCED
	   type:"POST",
	   success:function(data)
	   {
	   data=data.trim();

	  alert(data); 
	   console.log(data);//return false;
	  // alert(data); return false;

	   var obj = JSON.parse(data);
	   var status=obj[0];             //0 STATUS READ
	                                  // IF STATUS=ERROR
	  // DISPLAY 1 INDEX AS ERROR DESCRIPTION AND RETURN IT..


	if(status=="Uploaded_file_exists")	
	{
	var path=obj[1];
	$("#pgb").hide();
	    $('.msg').text("You Have uploaded the Same Old .dat/.iit in other Exam..!!");
                                alert("Duplicate File Upload Exist in\npath="+path);
	return false;
	}	  
	   if(status=="invalid_iit_error")
	   {
	   var error_message=obj[1];
	    //alert(error_message);
	    $("#pgb").hide();
	   $('.msg').text("Invalid .IIT Uploaded.. Check and upload once again");
	   alert("Invalid .IIT Uploaded.."); return false;
	   
	   }
	   	if(status=="file_not_exist")
	   {
	   var error_message=obj[1];
	    $("#pgb").hide();
	   $('.msg').text("Error in Uploading the File...");
	   alert("Error in Uploading the File... Upload correct (.dat/.iit) file once again..!!"); return false; 
	   
	   }
	   	if(status=="multiple_usn")
	   { // alert("muuuuuuu");
	   var internal_data=obj[1];
	  $("#error_content").html(internal_data);
	  $("#opacityo_div2").removeClass('hidden');
	  return false;  
	   }
	   	if(status=="usn_mismatch_error_advanced")
	   { //alert("advanced miss");
	   var internal_data=obj[1];
	  $("#error_content").html(internal_data);
	$("#opacityo_div2").removeClass('hidden');
	 return false;  
	   }

	   	if(status=="usn_mismatch_error_non_advanced")
	   { //alert("nonadvanced miss");
	   var internal_data=obj[1];
	  $("#error_content").html(internal_data);
	$("#opacityo_div2").removeClass('hidden');
	 return false;  
	   }
	   	  if(status=="db_done") //loli
	   {   $("#opacityo_div2").addClass('hidden');
	   var error_message=obj[1];
	   var s_count=obj[2];
	   var a_count=obj[3];
	   if(s_count==a_count)
	   {
	   alert("All "+s_count+" Students List have gone for Principal Approval");
	   }
	   
	   localStorage.setItem("convertion_status", "finished");
	   before_after_timer("after"); return false;
	   
	   }
	     if(status=="no_students")
	   {
	   var error_message=obj[1];
	   alert("All Students are deleted.. No Student is there to Proceed.. !!\n Results are not Generated");
	   location.reload();
	   return false;
	   
	   }
	   
	
	
	
	   
	   
	   //DO UPSIDE 
	   
	   return false;
	   console.log(data);
	  // console.log(data);
	  // alert("now"+data); //CATCH ALL TYPES OF ECHO HERE>> MANY ARE PENDING..
	  // return false;
	   if(data=="Invalid_iit")
	   {   $("#pgb").hide();
	   $('.msg').text("Invalid .IIT Uploaded.. Check and upload once again");
	   alert("Invalid .IIT Uploaded.."); return false;
	   }
	   
	   
	   
	    if(data=="db_done") //dat process
	   {
	localStorage.setItem("convertion_status", "finished");
	before_after_timer("after"); return false;  
	   }
	   
	/*	   
          $response_array=array();
	  $response_array[]="success";
	  $response_array[]="non_advanced";
	  $response_array[]=$students_id_array;
	  $response_array[]=$students_calculated_marks;
	  $response_array[]="non_advanced";
	  
	  echo json_encode($response_array);
	*/	   
	   
	   //this below part is of advanced
	   
	    var obj = JSON.parse(data);
	var advanced_or_non_advanced=obj[1];
	if(advanced_or_non_advanced=="advanced")
	{	
	var status=obj[0];
	
	
	
	if(status=="success")  // get different for dat and iit
	{
	 var student_usn_array=obj[2];
	 var physics_marks_array=obj[3];
	 var chemistry_marks_array=obj[4];
	 var mathematics_marks_array=obj[5];
	 //alert(student_usn_array);
                             

	 var validate_students="yes";
	 $.ajax({
	url:"ajax_php.php",
	async:"true",
	data:{validate_students:validate_students,sl:sl,student_usn_array:student_usn_array},
	type:"POST",
	success:function(data) 
	{// return false;
	data=data.trim();
	//alert("here1");
	alert(data); 
	//alert("here2");
	            var obj_val_adv = JSON.parse(data);
	var status=obj_val_adv[0];
	
	
	if(status=="error")
	{// alert("correct"); //return false;
	var internal_data=obj_val_adv[1];
	//alert("oooo"+internal_data);
	$("#error_content").html(internal_data);
	$("#opacityo_div2").removeClass('hidden');
	} // write o catch else part... no error part
	else
	if(status=="no_error")
	{ //before_after_timer(after);
	//return false;
	var db_insert_and_status_update_success="yes";
	$.ajax({
	      url:"ajax_php.php",
	  type:"POST",
	  data:{db_insert_and_status_update_success:db_insert_and_status_update_success,sl:sl,student_usn_array:student_usn_array,physics_marks_array:physics_marks_array,
	  chemistry_marks_array:chemistry_marks_array,mathematics_marks_array:mathematics_marks_array},
	  success:function(data)
	  {
	  data=data.trim();
	  alert(data);
	  alert("oooo");
	  if(data=="no_students")
	  {
	  alert("All Students are deleted.. No Student is there to Proceed.. !!\n Results are not Generated");
	  location.reload();
	  return false;
	  }
	  if(data=="db_done")
	{
	//$("#opacityo_div2").addClass('hidden');
	localStorage.setItem("convertion_status", "finished");
	before_after_timer("after"); 

	localStorage.setItem("convertion_status", "finished");
	
	before_after_timer("after"); return false;

	
	return false;
	}
	  
	  
	  }
	
	      });
	
	
	
	
	//localStorage.setItem("convertion_status", "finished");
	//before_after_timer("after");
	}
	else{
	
	alert("Error in Process.. Try after some time.. or Contact Application Admin");  return false;
	}
	//response_display_array
	//alert(data);
	return false;
	}	
	 
	       });
	//alert("yess"); return false;
	 
	}
	            
	   }//END OFF ADVANCED RETURNED
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	           else
	   if(data=="file_not_exist")
	   {
	   alert("Error in Uploading the File... Upload correct (.dat/.iit) file once again..!!"); return false;
	   }
	   else
	   if(data=="db_done")
	   {
	localStorage.setItem("convertion_status", "finished");
	//$("#opacityo_div2").addClass('hidden');
	before_after_timer("after"); return false;  
	   }
	  
	   
	                    
	  
	  
	   }
	  
	        });



    
	  
	  }
	  
	  //
	  
	  function before_after_timer(before_or_after)
	  {
	  if(before_or_after=="before")
	  {
	   var pgb = $('#pgb');
	   var i=0;
	   var first=setInterval(function(){
	   
	
	  
	   
	   var convertion_status=localStorage.getItem("convertion_status");
	   if(convertion_status=="not_finished")
	   {

                   var start_stop=50;
	   var middle_from=50; var middle_to=90.32;
	   


	   
	          if(i<start_stop)    //INITIAL STOP COUNT AT 20
	  {
	  
	       var random_1_to_4=Math.floor((Math.random() * 35) + 1);   //10to 35
	       i=i + +random_1_to_4;
	  
	  
	 localStorage.setItem("LocalI", i);
	             pgb.ariaProgressbar('update', i);  
	  }	  
	         
	 
	  if((i>=middle_from) && (i<middle_to))
	  {
	  var temp=+i + +0.01;
	   i = temp.toFixed(2);
	 localStorage.setItem("LocalI", i);
	             pgb.ariaProgressbar('update', i);
	  }
	  
	  
	  
	  
	   
	       }
	     
	   
	   
	   
	                                   }, 1000);
	  }
	  if(before_or_after=="after")
	  {            clearInterval(first);
	                   
	             
	   var getI=localStorage.getItem("LocalI");
	   localStorage.setItem("LocalI", 0);
	  // alert(getI);
	   if(getI > 10)
	   {
	   rem=(getI % 10);
	   getI=+getI + (10-rem); //alert(getI);
	   }
	   else
	   {
	 getI=10;  
	   }
	   var seconds_to_complete=3;
	   var diff=(100-getI);
	   var add=diff/seconds_to_complete;
	   add=Math.floor(add);
	var pgb = $('#pgb');
	                                setInterval(function(){
	
	getI=+getI + +add;	
	    
	
	
	    //getI=+getI + +5;
	if(getI>=100) {getI=100;}
	//alert(getI);
	pgb.ariaProgressbar('update', getI);
	if(getI==100)
	{
	$("#pgb").html("<br><br><center style='color:#6c9e33;'><b>PROCESS IS COMPLETED... VIEW YOUR RESULT NOW</b></center>");
	}
	
	              }, 1000);
	  }	   
	   
	  }
	  
	$("#ref_page").click(function(){
	
	window.location.href="";
	
});


   
 $("#approve_all").click(function(){



 $(".approve").each(function(){

    $(this).prop('checked', true);
 });


});

$("#delete_all").click(function(){

 $(".delete").each(function(){

    $(this).prop('checked', true);
 });

});

   
 $("#reset_all").click(function(){


 $(".approve").each(function(){

    $(this).prop('checked', false);
 });

  $(".delete").each(function(){

    $(this).prop('checked', false);
 });

});

  </script>

