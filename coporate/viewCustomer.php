<?php
include '../Controller.php';
Model::checkvalidation();
unset($_SESSION['query']);
$query = '';
$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
$limit = 20;
$startpoint = ($page * $limit) - $limit;
$agentList = searchCustomer($startpoint, $limit);
if (!isset($_SESSION['query']))
{
    $query = "select * from customer_tab";
}  else {
    $query = trim($_SESSION['query']);
    unset($_SESSION['query']);
}
sessiontimeout();
logmeout();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Banking Agency</title>
        <link type="text/css" rel="stylesheet" href="../style.css"/> 
        <link href="../pagination.css" rel="stylesheet" type="text/css" />
	<link href="../B_black.css" rel="stylesheet" type="text/css" />
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
                 <ul>
              </div>
          </div>
       <div id="contentWrapper">
           <div id="menu">
                <h1>Corporate Menu</h1>
                   <ul>
                   <?php echo quickuserRole(); ?>
                  </ul>
                <div id="slidingjpg">
                    <img src="../images/corporate.jpg"  alt="" title="branchless banking"/>
                </div>
            </div>
         <div id="mainContent">
           <div id ="formcontainer">
            <div class="searchcriteria">
             <form id="form1" name="form1" method="post" action="<?php  echo $_SERVER['PHP_SELF'];?>">
                 <table>
                     <tr>
                        <td>
                            <input type="text" name="phone" size="20px" placeholder =" Search By PhoneNumber"  value=""/>
                        </td>
                        <td>&nbsp;</td>
                        <td>
                            <input type="text" name="customername" size="20px" placeholder =" Search by FirstName" size="10px"  value=""/>
                        </td>
                        <td>&nbsp;</td>
                        <td>
                            <select name="accountType">
                                <option value="">---Select AccountType---</option>
                                <option value="saving">Saving</option>
                                <option value="current">Current</option>
                            </select>
                        </td>
                        <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
                        <td><input type="submit" name="searchcustomer" value="GO"/></td>
                    </tr>
                 </table>
                 
                 </form>
            </div>
          <div style="width:745px;  display: block;">
             <table width="100%" class="tbagent" style="font-size: 10px;">
                      <tr class="oddRow">
                            <th>Customer FirstName </th>
                            <th>Customer LastName</th>
                             <th>Phone</th>
                             <th>Email</th>
                             <th>Created Date</th>
                             <th>Status</th>
                             <th>Remark</th>
                            <th>Action</th>
                        </tr> 
                        <?php 
                        if (count($agentList) > 0)
                        {
                            foreach ($agentList as $obj) 
                            {
                                echo '<tr>';
                                echo '<td style="font-size: 11px;">' . $obj->firstName. '</td>';
                                echo '<td style="font-size: 11px;">' . $obj->lastName. '</td>';
                                echo '<td style="font-size: 11px;">' . $obj->custPhone . '</td>';
                                echo '<td style="font-size: 11px;">' . $obj->custEmail . '</td>';
                                echo '<td style="font-size: 11px;">' . $obj->dateCreated . '</td>';
                                echo '<td style="font-size: 11px;">' . $obj->status . '</td>';
                                echo '<td style="font-size: 11px;">' . $obj->remark . '</td>';
                          ?>
                        <td style="font-size: 10px;"><a href="<?php echo "updateCustomer.php?customerID=$obj->Id"; ?>"> Edit </a> | <a href="<?php echo "displaycustomer.php?customerID=$obj->Id"; ?>"> Disable </a></td>
                       <?php
                            }
                         echo '</tr>';
                        }  else {
                            echo "<tr colspan =7><td>No Records</td></tr>";
                        }
                            
                        ?>
                    </table>
               </div>
           <?php echo pagination($query,$limit,$page); ?>
           </div>
         </div>
       </div>
          </div>
        </div>
        <div id="footer"></div>
    </body>
</html>
