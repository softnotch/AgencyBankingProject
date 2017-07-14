<?php
include '../Controller.php';
unset($_SESSION['query']);
Model::checkvalidation();
    if (isset($_SESSION['id']))
    {
        //echo $_SESSION['id']; die();
        $agentbalance = getAgentFund(trim($_SESSION['id']));
        //echo $agentbalance; die();
        $agentList = populateAgentdetail(trim($_SESSION['id']));
        $objectdetail = json_decode(json_encode($agentList), 1);
        //var_dump($objectdetail); die();
    }
    
    $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
    $limit = 20;
    $start = ($page * $limit) - $limit;
    if ( isset($_SESSION['agentPhone']))
    {
        $agentphone = trim($_SESSION['agentPhone']);
        $agentcashflow = getAgentCashFlow($start,$limit,$_SESSION['agentPhone']);
        //var_dump($agentcashflow); die();
        $objdecode = json_decode(json_encode($agentcashflow), 1);
        //var_dump($objdecode);die();
    }
    
 if (!isset($_SESSION['query']))
{
    $query = "SELECT * FROM cashflow where agentId = 
              (select username from userlogin where phoneNumber = '{$agentphone}')
              AND status = 'O'";
}  else {
    $query = trim($_SESSION['query']);
    //unset($_SESSION['query']);
}
sessiontimeout();
logmeout();  
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>View Agent Record</title>
        <link type="text/css" rel="stylesheet" href="../style.css"/> 
        <link rel="stylesheet" href="../jquery/development/themes/base/jquery.ui.all.css" />
        <link rel="stylesheet" href="../jquery/development/demos/demos.css"/>
        <link href="../pagination.css" rel="stylesheet" type="text/css" />
	<link href="../B_black.css" rel="stylesheet" type="text/css" />
        <script src="../jquery/development/jquery-1.8.2.js"></script>
        <script src="../jquery/development/ui/jquery.ui.core.js"></script>
        <script src="../jquery/development/ui/jquery.ui.widget.js"></script>
        <script src="../jquery/development/ui/jquery.ui.datepicker.js"></script>
        <script>
            $(function() {
		$("#fromdate").datepicker({
			defaultDate: "+1w",
			changeMonth: true,
                        dateFormat: "yy-mm-dd",
			onSelect: function( selectedDate ) {
				$( "#to" ).datepicker( "option", "minDate", selectedDate );
			}
		});
		$("#todate").datepicker({
			defaultDate: "+1w",
			changeMonth: true,
                        dateFormat: "yy-mm-dd",
			onSelect: function( selectedDate ) {
				$( "#from" ).datepicker( "option", "maxDate", selectedDate );
			}
		});
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
          <div id="content">
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
            </div>
           <div id="mainContent">
         <div id="agentcontent">
           <div class="caption">Agent Account Reconciliation Search Form</div>
             <div id="agentdiv">
             <form id="form1" name="form1" method="post" action="<?php  echo $_SERVER['PHP_SELF'];?>">
             <table class="agentform" id="searchform" width="530px;"> 
               <tr>
                 <td id="key">Reconcile Type</td>
                 <td id="value">
                     <select name="reconType" width="10">
                         <option value="">---Select ReconType---</option>
                         <option value="0">Unreconcile</option>
                         <option value="1">Reconcile</option>
                     </select>
                 </td>
             </tr>
             <tr>
                 <td id="key">Reconcile Date</td>
                 <td id="value">
                  <input type="text" id="fromdate" name="fromdate" placeholder="from what date" value="" width="5px"/><br>
                  <input type="text" id="todate" placeholder="To what date" name="todate" value="" width="5px"/></td>
            </tr> 
             <tr>
                 <td id="key"></td>
                 <td id="value"><input type="submit" name="searchrecon" value="GO" width="10px"/></td>
             </tr>
             </table>
                 </div>
           </div>
           <div id="fundAccount">
               <div class="caption">Agent Detail</div>
               <table class="recon">
		<?php foreach($objectdetail as $ag){
                   echo '<tr><td id="key">Agent Name</td><td id="value">'. $ag['agentfullname'] . '</td></tr>';
                   echo '<tr><td id="key">Agent Phone</td><td id="value">' . $ag['agentPhone'] . '</td></tr>';
                 }?>
                   <tr><td id="key">Fund Amount</td><td id="value"><?php echo $agentbalance; ?></td></li>
               </table>
           </div>
           <table width="745px" class="tbagent">
                      <tr class="oddRow">
                            <th>SN</th>
                            <th>AgentID</th>
                            <th>Balance</th>
                            <th>TransactionAmount</th>
                            <th>FlowType</th>
                            <th>Status</th>
                            <th>TransactionDate</th>
                            <th>Transaction ID</th>
                            <th>Transaction Mode</th>
                        </tr> 
                        <?php 
                        $sumAmount = 0;$sumbalance = 0;
                        if (count($objdecode) > 0)
                        {
                            foreach ($objdecode as $obj) 
                            {
                                 $valagent = $obj['AgentID'];
                                $sumAmount = $sumAmount + $obj['transactionAmount'];
                                $sumbalance = $sumbalance + $obj['Balance'];
                                echo '<tr>';
                                echo '<td>' . $obj['Id'] . '</td>';
                                echo '<td>' . $obj['AgentID'] . '</td>';
                                echo '<td>' . $obj['Balance']. '</td>';
                                echo '<td>' . $obj['transactionAmount'] . '</td>';
                                echo '<td>' . $obj['flowType'] . '</td>';
                                echo '<td>' . $obj['status'] . '</td>';
                                echo '<td>' . $obj['transactionDate'] . '</td>';
                                echo '<td>' . $obj['trnxID'] . '</td>';
                                echo '<td>'; $stat = $obj['status'];
                                    if ($stat == 'O'){
                                        echo 'Open';
                                    }  else {
                                        echo 'Closed';
                                    }
                              echo '</td>';
			        echo '</tr>';
                            }
                        }  else {
                            echo "<tr><td colspan=100%>No Records</td></tr>";
                        }             
                       ?> 
                        <input type="hidden" name="agentid" value="<?php  if (isset($valagent)){ echo $valagent;} ?>" />
                        <input type="hidden" name="sumamount" value="<?php echo  $sumAmount; ?>" />
                        <input type="hidden" name="balance" value="<?php echo  $sumbalance; ?>" />
                        <tr><td></td><td></td><td><?php echo $sumbalance;?></td><td><?php echo $sumAmount; ?></td><td></td><td></td><td></td><td></td><td></td></tr>
                        <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><input type="submit" name="reconcile" value="Reconcile Now" width="30px"/></td></tr>
                        
                    </table>
                    
            </form>
              <?php $output =  pagination($query,$limit,$page). "<br/>";
               
                if (isset($_GET['wmreconcile'])) {
                    $output .= '<div id ="error"><span class="statusSuccess"></span><span class="statustext">Reconcilation carried out successfully</span></div><br/>';            
                    unset($_GET['wmreconcile']);
               }  else if (isset($_GET['wmerror'])){
                   $output .= '<div id ="error"><span class="statusSuccess"></span><span class="statustext">Sorry, Total Amount Remitted not Balanced</span></div><br/>';            
                    unset($_GET['wmerror']);   
               }elseif (isset($_GET['wmresponderror'])) {
                   $output .= '<div id ="error"><span class="statusSuccess"></span><span class="statustext">Http is out of reach</span></div><br/>';            
                    unset($_GET['wmresponderror']);     
               }elseif (isset($_GET['wmnorecord'])) {
                   $output .= '<div id ="error"><span class="statusSuccess"></span><span class="statustext">No Record To reconcile</span></div><br/>';            
                    unset($_GET['wmresponderror']);     
               }
               echo $output;
            ?>
       </div> 
         </div>
       </div>
         </div> 
        <div id="footer"></div>
    </body>
</html>
