<?php
include '../Controller.php';
Model::checkvalidation();
if (isset($_GET['userId']))
{
    $id = $_GET['userId'];
}

$_SESSION['id'] = $id;


//please remember to turn ME TO array(json_decode(json_encode($agentList), 1));
$result = populateRequestUser($id);
$objdecode = json_decode(json_encode($result), 1);
//var_dump($objdecode);die();
sessiontimeout();
logmeout();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Banking Agency</title>
        <link type="text/css" rel="stylesheet" href="../style.css"/> 
        <link rel="stylesheet" href="../jquery/development/themes/base/jquery.ui.all.css" />
        <link rel="stylesheet" href="../jquery/development/demos/demos.css"/>
        <script src="../jquery/development/jquery-1.8.2.js"></script>
        <script src="../jquery/development/ui/jquery.ui.core.js"></script>
        <script src="../jquery/development/ui/jquery.ui.widget.js"></script>
        <script src="../jquery/development/ui/jquery.ui.datepicker.js"></script>
        <link href="../jquery/css/bvalidator/bvalidator.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="../jquery/js/jquery.bvalidator.js"></script>
        <script>
                $(function() {
                    $("#dob").datepicker({
                        defaultDate: "+1w",
                        dateFormat: "yy-mm-dd"
                    });
                    
                     $('#form1').bValidator();
                    
                });
        </script>
    </head>
    <body>
        <div id="wrapper">
          <div id="banner">
              <div id="bannertxt">
                    <?php userinfo(); ?>
                    <div id="changepassword">
                        <a href="../changepassword.php"> Change Password</a>
                    </div>
                </div>
          </div>
          <div id="content" >
                <div id="userDetail">
               <div id="topmenu">
               <ul>
                 <li><a href='../superadmin/index.php'>Home</a></li>
                           <?php topmenumodule(); ?>
               </ul>
              </div>
              </div>
              <div id="contentWrapper">
            <div id="menu">
                <h1>User Administrator</h1>
                  <ul>
                    <?php echo UserManagementRole(); ?>
                  </ul>
                <div id="slidingjpg">
                    <img src="../images/system.jpg"  alt="" title="branchless banking"/>
                </div>
            </div>
         <div id="mainContent">
           <div id="formcontainer">
           <form name="form1" method="POST" action="../Controller.php">
      <input type="hidden" value="<? echo $id; ?>" name="hiddenid"/>
               <div class="caption" style="width: 530px;">
		<?php foreach($objdecode as $ag){
                   $remarkstatus = $ag['remark']; 
                 if (isset($ag['remark']))
                 { echo 'This Request has been sent already';
                     
                 }else{ echo 'View User'; }}
                 ?>
               </div>
               <?php 
                if (isset($_GET['wmreset']))
                {
     echo '<div id="response"><span class="statusSuccess"></span><span class="successtext">Your Request has been sent for Approval. </span></div>';
                    unset($_GET['wmreset']);
                }elseif(isset ($_GET['wmdisable']))
                {
    echo '<div id="error"><span class="statuserror"></span><span class="statustext">Your Request has been sent for Approval. </span></div>';
		unset($_GET['wmdisable']);
                }
                
            ?>
               <div id="agentdiv">
                <table class="agentform" width="100%">
		<?php foreach($objdecode as $ag){
              echo ' <tr>
               <td id="key">FullName</td>
               <td id="value">' . $ag['fullname'] .'</td>
               </tr>';
               echo '<tr>
               <td id="key">Phone</td>
               <td id="value">'. $ag['phonenumber'] . '</td>
               </tr>';
               echo '<tr>
               <td id="key">UserType</td>
               <td id="value">' . $ag['usertype'] . '</td>
               </tr>';
               echo '<tr>
               <td id="key">email</td>
               <td id="value">' . $ag['email'] . '</td>
               </tr>';
               echo '<tr>
                   <td id="key">Created Date and Time</td>
                   <td id="value">' . $ag['createtime'] . '</td>
               </tr>';
               echo '<tr>
               <td id="key">Address</td>
               <td id="value">' . $ag['address'] . '</td>
               </tr>';
               if (!isset($ag['remark'])){
               echo '<tr>
               <td id="key">Comment</td>
               <td id="value"><textarea name="comment" rows="6" cols="26"></textarea></td>
               </tr>
               <tr>
                  <td id="key"><input type="submit" value="DisableUser" name="unableuser" onClick="return confirm("Are you sure you want to Disable User?")"/></td>
                   <td id="value"><input type="submit" value="ResetPassword" name="resendpin" onClick="return confirm("Are you sure you want to Reset Password?")"/></td>
               </tr>';
               }}
		?>
                </table>
               </div>
           </form>
           </div>
           </div>
         </div>
        </div>
          </div>
        </div>
        <br><br>
        <div id="footer"></div>
    </body>
</html>
