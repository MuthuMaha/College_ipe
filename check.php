 <html>
 <!-- <script type="text/javascript" src="jQuery.js"></script> -->
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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
         <tbody>
          
          </tbody>
        </table>
  <script type="text/javascript">
    $(document).ready(function(){
        $.ajax({
            type: 'GET',
            url: "http://175.101.3.68/ipe/public/api/employeelist",
            success:function(data){
         var output="";
              $.each(data, function(index, value) {                                   
      
        output += '<tr><td>'+ value.PAYROLL_ID +'</td><td>'+ value.SURNAME +'</td><td><button type="button" name="edit" class="btn btn-warning btn-xs edit" id="'+ value.EMPLOYEE_ID +'">Edit</button></td><td><button type="button" name="delete" class="btn btn-danger btn-xs delete" id="'+ value.EMPLOYEE_ID +'">Delete</button></td></tr>';
      
        }); 
                  // alert(output);
                 $('tbody').html(output);
            }
            // error: function (xhr) {
            //     var err = JSON.parse(xhr.responseText);
            //     alert(err.error);
            //     }
        });
    return true;
   
});
</script>
</head>

<body>
<input type="button" id="submit" value="submit" />
</body>
 </html>