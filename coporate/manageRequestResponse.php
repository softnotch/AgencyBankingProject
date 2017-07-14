<?php
include '../Controller.php';
Model::checkvalidation();

$requestid = $_GET['requestId'];
//$_SERVER['QUERY_STRING']  = " ";
//unset($_REQUEST['requestId']);

$resultval = populateRequestDetail($requestid);
$result = json_decode(json_encode($resultval), 1);
//var_dump($result); die();
//foreach($result as $val)
//{
//	var_dump($val['initiator']); die();
//}
//unset($_REQUEST['requestId']);
sessiontimeout();
logmeout();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Banking Agency</title>
        <link type="text/css" rel="stylesheet" href="../style.css"/>    
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
         <div id="menu" >
                <h1>Corporate Menu</h1>
                   <ul>
                   <?php echo quickuserRole(); ?>
                  </ul>
                  <div id="slidingjpg">
                    <img src="../images/corporate.jpg"  alt="" title="branchless banking"/>
                </div>
            </div>
         <div id="mainContent">
            <?php 
                if (isset($_REQUEST['wmapprove']))
                {
     echo '<div id="response"><span class="statusSuccess"></span><span class="successtext">Your Request has been Approve. </span></div>';
                    unset($_GET['wmapprove']);unset($_REQUEST['requestId']);
                }elseif(isset ($_GET['wmdecline']))
                {
    echo '<div id="error"><span class="statuserror"></span><span class="statustext">Your Request has been Decline. </span></div>';
                unset($_REQUEST['wmdecline']);unset($_REQUEST['requestId']);
                }
                elseif(isset($_REQUEST['wmerr'])) {
    echo '<div id="error"><span class="statuserror"></span><span class="statustext">Sorry connection Error </span></div>'; 
                unset($_GET['wmerr']);unset($_REQUEST['requestId']);
                }
            ?>
           <div id ="formcontainer">
             <form id="form1" name="form1" method="post" action="../Controller.php">
	 <input type="hidden" value="<?php echo $requestid; ?>" name="hiddenagent"/>
                 <div class="caption" style="width:530px;"> 
                <?php 
		foreach($result as $ag){
		//	echo $ag['status']; die();
                    $status = $ag['status'];
                 if (strcasecmp($ag['status'],"Pending") != 0)
                 { echo 'This Request Is Closed';
                     
                 }else{ echo 'Approve or Decline Request for Agent'; }}?></div>
                 <div id="agentdiv">
                 <table class="agentform" width="100%">
		<?php 
			foreach($result as $ag){
                    echo ' <tr>
                        <td id="key">Initiator</td>
                        <td id="value">' .  $ag['initiator'] . '</td>
                     </tr>';
                echo '<tr>
                 <td id="key">Request</td>
                 <td id="value">' . $ag['requestType'] . '</td>
               </tr>';
               echo ' <tr>
                 <td id="key">Approver</td>
                 <td id="value">'. $ag['approval'] . '</td>
               </tr>';
               echo '<tr>
                 <td id="key">Status</td>
                 <td id="value">' . $ag['status'] . '</td>
               </tr>';
                 echo '<tr>
                     <td id="key">Submitted Time</td>
                     <td id="value">' . $ag['submitted'] .'</td>
                 </tr>';
                echo ' <tr>
                     <td id="key">Approval Time</td>
                     <td id="value">' . $ag['approvalTime'] . '</td>
                 </tr>';
                echo ' <tr>
                     <td id="key">Recipient</td>
                     <td id="value">' . $ag['agentname'] . '('. $ag['phone'] . ')' . '</td>
                 </tr>';
                    if (strcasecmp($ag['status'],"Pending") == 0)
                    {
                echo '<tr>
                 <td id="key">Comment</td>
                 <td id="value"><textarea name="comment" rows="6" cols="26"></textarea></td>
                 </tr>';
                echo '<tr>
                     <td id="key">
             <input type="submit" value="Approve" name="Approve" />
                    </td>
                 <td id="value">
              <input type="submit" value="Decline" name="Decline"/></td>
               </tr>';
               }} ?>  
                 </table>
                 </div>
           </form>
           </div>
         </div>
       </div>
          </div> 
        </div>
        <div id="footer"></div>
    </body>
</html>
