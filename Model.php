<?php
include 'classes/utils.php';
//session_start();
unset($_SESSION);
class Model {
    
    public $urlval = "http://192.168.0.116:8080/AgencyBankingMWare/";
   // public $urlval = "http://localhost:8080/AgencyBankingMWare/";
    public static function conClose() {
        mysql_close();
    }
 private static function DbConnect()
{
         $host='192.168.0.116:3306';
         //$host = 'localhost';
         //$pass = "cellulant123";
	 $pass="password";
         //$pass = 'ollysun';
	 $userName="moses";
         //$userName="THandler";
         //$userName = "root";
	 $database="agencybanking";
	 $connection = mysql_connect($host,$userName,$pass)or die(mysql_error());
	if(!$connection || !mysql_ping($connection)){
            echo 'Failed to obtain a succesful connection to the localHost';
		mysql_close();
        }else{
            mysql_ping($connection);
            mysql_select_db($database,$connection)or die(mysql_error());
        }
}
public static function login($username,$password)
{
            self::DbConnect();
        $sql=" select * from  users where username='$username' and password='$password'";
        $result=mysql_query($sql) or die(mysql_error());
        return $result;
         mysql_close();
}
public static function CorporateDetail($username)
{
        self::DbConnect();
        $list=array();
        $sql=" select * from  corporate where corpId='$username' ";
        $result=mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_object($result)) {
             $obj=new Corporate();
             $obj->corpID=$row->Id;
             $obj->compName=$row->corpname;
             $obj->balance=$row->balance;
             $obj->username=$row->corpId;
              $list[]=$obj;
        }
        return $list;
         mysql_close();
}
public static function getAllCustomerDetails()
{
        self::DbConnect();
        $list=array();
        $sql=" select * from  customer ";
        $result=mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_object($result)) {
            $cust=new Customer();
            $cust->agentID=$row->Id;
            $cust->agentfName=$row->AgentFirstName;
            $cust->agentlName=$row->AgentLastNamee;
            
              $list[]=$cust;
        }
        return $list;
         mysql_close();
}
public static function getCustomerRecord($Id)
{
        self::DbConnect();
        $list=array();
        $sql=" select * from  customer where custId='$Id'";
        $result=mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_object($result)) {
            $cust=new Customer();
            $cust->Id=$row->id;
            $cust->agentId=$row->agentId;
            $cust->balance=$row->balance;
            $cust->dateCreated=$row->createdDate;
            $cust->customerId=$row->custId;
            $cust->custName=$row->customerName;
            $cust->custEmail=$row->customeremail;
            $cust->custPhone=$row->phoneNumber;
            $cust->PIN=$row->Pin;
              $list[]=$cust;
        }
        return $list;
         mysql_close();
}
public static function getCorporatedata($id)
{
        self::DbConnect();
        $list=array();
        $sql=" select * from  corporate where corpId='$id' ";
        $result=mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_object($result)) {
             $obj=new Corporate();
             $obj->corpID=$row->Id;
             $obj->compName=$row->corpname;
             $obj->balance=$row->balance;
          //    $obj->username=$row->cropId;
              $list[]=$obj;
        }
        return $list;
         mysql_close();
}
public static function getAgentDetail($id)
{
        self::DbConnect();
        $list=array();
        $sql=" select * from  agent where AgentId='$id' ";
        $result=mysql_query($sql) or die(mysql_error());
      
        while ($row = mysql_fetch_object($result)) {
             $obj=new Agent();
             $obj->agentID=$row->AgentId;
             $obj->agentName=$row->AgentName;
             $obj->agentPhone=$row->AgentPhone;
             $obj->tillBalance=$row->TillBalance;
             $obj->corpId=$row->corporateId;
             
              $list[]=$obj;
        }
        return $list;
         mysql_close();
}
public static function getAllAgent($startpoint, $limit)
{
        self::DbConnect();
        $list=array();
        $sql =     "select a.Id, u.fullname, u.phoneNumber, a.AgentType
                    from user_tab u inner join agent a on u.Id = a.userId 
                    LIMIT {$startpoint}, {$limit}";
        $result = mysql_query($sql) or die(mysql_error());
        $row = mysql_num_rows($result);
        while ($row = mysql_fetch_object($result)) {
            //var_dump($row); die();
             $ag = new Agent();
             $ag->agentfullname = $row->fullname;
             $ag->agentPhone = $row->phoneNumber;
             $ag->agentType = $row->AgentType;
             $ag->agentID = $row->Id;
              $list[]= $ag;
        }
        //var_dump($list);
        return $list;
        
        
         mysql_close();
}

public static function searchbyagentname($searchval)
{
    self::DbConnect();
    $list=array();
    $sql= "select a.Id, u.fullname, u.phoneNumber, a.AgentType
           from user_tab u inner join agent a On u.Id = a.userId 
           where u.fullname = '{$searchval}'";
           echo $sql; die();
        $result = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_object($result)) {
             $ag = new Agent();
             $ag->agentfullname = $row->fullname;
             $ag->agentPhone = $row->phoneNumber;
             $ag->agentType = $row->AgentType;
             $ag->agentID = $row->Id;
              $list[]= $ag;
        }
        
        return $list;
        
        mysql_close();
}



public static function searchbyagentID($searchval)
{
    self::DbConnect();
    $list=array();
    $sql = "select a.Id, u.fullname, u.phoneNumber, a.AgentType
            from user_tab u inner join agent a on u.Id = a.userId 
            where a.Id = '$searchval'";
    $result = mysql_query($sql) or die(mysql_error());
    while ($row = mysql_fetch_object($result)) {
            //var_dump($row); die();
             $ag = new Agent();
             $ag->agentfullname = $row->fullname;
             $ag->agentPhone = $row->phoneNumber;
             $ag->agentType = $row->AgentType;
             $ag->agentID = $row->Id;
              $list[]= $ag;
     }
        return $list;
        
        mysql_close();
}


public static function searchagentByAllAgent($start, $limit,$phone,$name,$type)
{
    self::DbConnect();
    $list=array();$result = '';$sql = '';
    
    if (empty($sql)){
        $sql= "select a.Id, u.fullname, u.phoneNumber, a.AgentType
            from user_tab u inner join agent a on u.Id = a.userId 
            LIMIT {$start}, {$limit}";
         $result = mysql_query($sql) or die(mysql_error());
    }
    
    
    $sqlval = "select a.Id, u.fullname, u.phoneNumber, a.AgentType
               from user_tab u inner join agent a on u.Id = a.userId";
//            echo $sql;die();
//limit  $start, $limit
            
     if (!empty($phone)){
            $sqlval = $sqlval ." AND u.phoneNumber = '" . $phone ."'";
            $_SESSION['query'] = $sqlval;
            //echo $_SESSION['query'];die();
            $sqlval = $sqlval ." LIMIT {$start}, {$limit}";
            //echo $sqlval;die();
            $result = mysql_query($sqlval) or die(mysql_error());
        }   

        
        if (!empty($name)){
            $sqlval = $sqlval ." AND u.fullname = '" . $name ."'";
            $_SESSION['query'] = $sqlval;
            //echo $_SESSION['query'];die();
            $sqlval = $sqlval ." LIMIT {$start}, {$limit}";
            //echo $sqlval; die();
            $result = mysql_query($sqlval) or die(mysql_error());
            //echo $result;die();
        }
        
        if (!empty($type)){
            $sqlval = $sqlval ." AND a.AgentType = '" . $type ."'";
            $_SESSION['query'] = $sqlval;
            //echo $_SESSION['query'];die();
            $sqlval = $sqlval ." LIMIT {$start}, {$limit}";
            $result = mysql_query($sqlval) or die(mysql_error());
        }
        
        while ($row = mysql_fetch_object($result)) {
             $ag = new Agent();
             $ag->agentfullname = $row->fullname;
             $ag->agentPhone = $row->phoneNumber;
             $ag->agentType = $row->AgentType;
             $ag->agentID = $row->Id;
              $list[]= $ag;
        }
        //var_dump($list);
        return $list;
        
        mysql_close();
        
        
}
                                                
public static function searchCustomer($start, $limit,$phone,$custname,$acctType)
{
     self::DbConnect();
    $list=array();$result = '';$sql = '';
    
    if (empty($sql)){
        $sql= "select * from customer_tab LIMIT {$start}, {$limit}";
         $result = mysql_query($sql) or die(mysql_error());
    }
    
    $sqlval = "select * from customer_tab";
    
    if (!empty($phone)){
            $sqlval = $sqlval ." where phoneNumber = '" . $phone ."'";
            $_SESSION['query'] = $sqlval;
            //echo $_SESSION['query'];die();
            $sqlval = $sqlval ." LIMIT {$start}, {$limit}";
            //echo $sqlval;die();
            $result = mysql_query($sqlval) or die(mysql_error());
    }  
    
    if (!empty($custname)){
            $sqlval = $sqlval ." where customerName = '" . $custname ."'";
            $_SESSION['query'] = $sqlval;
            //echo $_SESSION['query'];die();
            $sqlval = $sqlval ." LIMIT {$start}, {$limit}";
            //echo $sqlval;die();
            $result = mysql_query($sqlval) or die(mysql_error());
    }  
    
    if (!empty($acctType)){
            $sqlval = $sqlval ." where accountType = '" . $acctType ."'";
            $_SESSION['query'] = $sqlval;
            //echo $_SESSION['query'];die();
            $sqlval = $sqlval ." LIMIT {$start}, {$limit}";
            //echo $sqlval;die();
            $result = mysql_query($sqlval) or die(mysql_error());
    }
    
    while ($row = mysql_fetch_object($result)) {
             $ag = new Customer();
             $ag->Id = $row->id ;
             $ag->firstName = $row->customerName;
             $ag->lastName = $row->lastName;
             $ag->IdNumber = $row->IdentificationId;
             $ag->IdType = $row->identificationType;
             $ag->acctType = $row->accountType;
             $ag->address = $row->address;
             $ag->custPhone = $row->phoneNumber;
             $ag->custEmail = $row->email ;
             $ag->dateCreated = $row->createdDate;
             $ag->status = $row->status;
             $ag->remark = $row->remark;
              $list[]= $ag;
        }
        //var_dump($list);
        return $list;
        
        mysql_close();
}

public static function listagentdetail($agentid)
{
    self::DbConnect();
    $list = array();
    $sql =       "select a.Id, u.fullname, u.phoneNumber, a.AgentType, a.createdDate,
                  u.email, u.lastname, u.remark
                  from user_tab u inner join agent a On u.Id = a.userId 
                  where a.Id = '{$agentid}'";
    $result = mysql_query($sql) or die(mysql_error());
    while ($row = mysql_fetch_object($result)) {
            //var_dump($row); die();
             $ag = new Agent();
             $ag->agentfullname = $row->fullname;
             $ag->agentPhone = $row->phoneNumber;
             $ag->agentType = $row->AgentType;
             $ag->agentID = $row->Id;
             $ag->agentlName = $row->lastname;
             $ag->email = $row->email;
             $ag->DOB = $row->createdDate;
             $ag->remark = $row->remark;
              $list[]= $ag;
     }
        return $list;
        
        mysql_close();
}
public static function listAllRequest($start, $limit)
{
    self::DbConnect();
    $list = array();
    $sql = "select * from systemuserrequest order by 1 desc LIMIT {$start}, {$limit}";
    $result = mysql_query($sql) or die(mysql_errno());
    while($row = mysql_fetch_object($result)){
        $request = new changeRequest();
        $request->Id = $row->Id;
        $request->agentname = $row->AgentId;
        $request->amount = $row->amount;
        $request->approval = $row->approver;
        $request->phone = $row->phoneNumber;
        $request->approvalTime = $row->approvalTime;
        $request->status = $row->status;
        $request->requestType = $row->requestType;
        $request->initiator = $row->Initiator;
        $list[] = $request;
    }
    
    return $list;
    
    mysql_close();
}

public static function  listAllUser($start, $limit)
{
    self::DbConnect();
    $list = array();
    $sql = "select * from user_tab LIMIT {$start}, {$limit}";
    $result = mysql_query($sql) or die(mysql_errno());
    while($row = mysql_fetch_object($result)){
        $request = new users();
        $request->fullname = $row->fullname;
        $request->address = $row->address;
        $request->email = $row->email;
        $request->phonenumber = $row->phoneNumber;
        $request->usertype = $row->userType;
        $request->userid = $row->Id;
        $request->createtime = $row->createdDate;
        $request->remark = $row->remark;
        $list[] = $request;
    }
    
    return $list;
    
    mysql_close();
}

public  static function listAllRoles()
{
    self::DbConnect();
    $list = array();
    $sql = "select r.Id, r.createdDate, r.description, r.roles, rp.actionName
            from role r inner join rolepermission rp on r.Id = rp.RoleId";
    $result = mysql_query($sql) or die(mysql_errno());
    while($row = mysql_fetch_object($result)){
        $request = new Role();
        $request->rolepermission = $row->actionName;
        $request->rolename = $row->roles;
        $request->roledescription = $row->description;
        $request->roleId = $row->Id;
        $request->roledate = $row->createdDate;
        $list[] = $request;
    }
    
    return $list;
    
    mysql_close();
}

public static function listRequestID($id)
{
    self::DbConnect();
    $list = array();
    $sql = "select * from systemuserrequest where Id = " . $id;
    $result = mysql_query($sql) or die(mysql_errno());
    while($row = mysql_fetch_object($result)){
        $request = new changeRequest();
        $request->Id = $row->Id;
        $request->agentname = $row->AgentId;
        $request->amount = $row->amount;
        $request->approval = $row->approver;
        $request->phone = $row->phoneNumber;
        $request->approvalTime = $row->approvalTime;
        $request->status = $row->status;
        $request->requestType = $row->requestType;
        $request->initiator = $row->Initiator;
        $request->submitted = $row->submitedTime;
        $list[] = $request;
    }
    return $list;
  mysql_close();
}

public static function listCustomerID($id)
{
    self::DbConnect();
    $list = array();
    $sql = "select * from customer_tab where id = " . $id;
    $result = mysql_query($sql) or die(mysql_errno());
    while($row = mysql_fetch_object($result)){
        $request = new Customer();
        $request->firstName = $row->customerName;
        $request->lastName = $row->lastName;
        $request->acctType = $row->accountType;
        $request->custPhone = $row->phoneNumber;
        $request->custEmail = $row->email;
        $request->IdType = $row->identificationType;
        $request->IdNumber = $row->IdentificationId;
        $request->address = $row->address;
        $request->remark = $row->remark;
        $request->dateCreated = $row->createdDate;
        $request->Id = $row->id;
        $request->status = $row->status;
        $list[] = $request;
    }
    return $list;
	mysql_close();
}

public static function listUserID($id)
{
    self::DbConnect();
    $list = array();
    $sql = "select * from user_tab where Id =" . $id;
    $result = mysql_query($sql) or die(mysql_errno());
    while($row = mysql_fetch_object($result)){
        $request = new users();
        $request->fullname = $row->fullname;
        $request->address = $row->address;
        $request->email = $row->email;
        $request->phonenumber = $row->phoneNumber;
        $request->usertype = $row->userType;
        $request->userid = $row->Id;
        $request->createtime = $row->createdDate;
        $request->status = $row->status;
        $request->remark = $row->remark;
        $list[] = $request;
    }
    return $list;
   mysql_close();
}

public static function getAllTransaction()
{
        self::DbConnect();
        $list=array();
        $sql=" select * from  transactions";
        $result=mysql_query($sql) or die(mysql_error());
              while ($row = mysql_fetch_object($result)) {
             $trans=new Transaction();
             $trans->transId=$row->TransId;
             $trans->actionX=$row->Actionx;
             $trans->trxDate=$row->TrxDate;
             $trans->amount=$row->Amount;
             $trans->agentId=$row->agentId;
             $trans->customer=$row->Customer;
             $trans->remarks=$row->Remarks;
             $trans->status=$row->Status;
              $list[]=$trans;
        }
        return $list;
         mysql_close();
}

public static function searchTransactionbyCustomer($startpoint,$limit,$custval,$transactionid,$type,$agent,$start,$end)
{
        self::DbConnect();
        $list=array();
        $var = 0; $result = '';$sql = '';
    
        if (empty($sql)){
            $sql= "select * from  transactions  LIMIT {$startpoint}, {$limit}"; 
            $result = mysql_query($sql) or die(mysql_error());
        }

        $sqlval = "select * from  transactions";
         if (!empty($custval)){
            $sqlval = $sqlval." where Customer = '". $custval."'";
            $_SESSION['query'] = $sqlval;
            $sqlval = $sqlval ." LIMIT {$startpoint}, {$limit}";
            $result=mysql_query($sqlval) or die(mysql_error());
        }   

        if (!empty($transactionid)){
            
            $sqlval = $sqlval." where TransId = '".$transactionid."'";
            $_SESSION['query'] = $sqlval;
            $sqlval = $sqlval ." LIMIT {$startpoint}, {$limit}";
            $result=mysql_query($sqlval) or die(mysql_error());
        }
        
        if (!empty($type)){
            
            $sqlval = $sqlval." where Actionx  = '".$type."'";
            $_SESSION['query'] = $sqlval;
            $sqlval = $sqlval ." LIMIT {$startpoint}, {$limit}";
            //echo $sqlval; die();
            $result=mysql_query($sqlval) or die(mysql_error());
        }
        
        if (!empty($agent)){
            $sqlval = $sqlval." where agentId  = '".$agent."'";
            $_SESSION['query'] = $sqlval;
            $sqlval = $sqlval ." LIMIT {$startpoint}, {$limit}";
            $result=mysql_query($sqlval) or die(mysql_error());
        }
        
        if (!empty($start) && !empty($end)){
            $sqlval2 = "select * from transactions where ";
            $sqlval2 = $sqlval2." TrxDate  between '".$start ."' and '" . $end . "'";
            $_SESSION['query'] = $sqlval2;
            $sqlval = $sqlval ." LIMIT {$startpoint}, {$limit}";
            $result=mysql_query($sqlval2) or die(mysql_error());
        }

          while ($row = mysql_fetch_object($result)) {
             $trans=new Transaction();
             $trans->transId=$row->TransId;
             $trans->actionX=$row->Actionx;
             $trans->trxDate=$row->TrxDate;
             $trans->amount=$row->Amount;
             $trans->agentId=$row->agentId;
             $trans->customer=$row->Customer;
             $trans->remarks=$row->Remarks;
             $trans->status=$row->Status;
              $list[]=$trans;
        }
        return $list;
         mysql_close();
}

public static function gettransactionType()
{
    self::DbConnect();
    $username = array();
    $sql= "select distinct Actionx from transactions";
    $result = mysql_query($sql) or die(mysql_error());
    while ($row = mysql_fetch_assoc($result)) {
        $username[] = $row['Actionx'];
    }
    //var_dump($username);die();
     return $username;
    
     Model::conClose();
}

public static function getAgentRecordBalance($agentid)
{
    self::DbConnect();
    $balance = '';
    $sql= "select balance from agentBalance where agentId = '{$agentid}'";
    $result = mysql_query($sql) or die(mysql_error());
    while ($row = mysql_fetch_assoc($result)) {
        $balance = $row['balance'];
    }
    //echo $balance; die();
    //var_dump($username);die();
     return $balance;
    
     Model::conClose();
}

public static function getUserlogin($phone)
{
    self::DbConnect();
    $sql= "select username from  userlogin where  phoneNumber = $phone";
    $result = mysql_query($sql) or die(mysql_error());
    $row = mysql_fetch_assoc($result);
    $username = $row['username'];
     return $username;
    
     Model::conClose();
}


public static function getAgentTransaction($start,$limit,$phonenumber, $cust, $transtype,$status, $from, $to)
{
        self::DbConnect();
        $list=array();
        $userdetail = Model::getUserlogin($phonenumber);
        $sqlval = "select * from transactions";
        
        if (!empty($phonenumber))
        {
            $sql = "select * from transactions where agentId = 
            (select username from userlogin where phoneNumber = '$phonenumber')  limit $start, $limit ";
            $result = mysql_query($sql) or die(mysql_error());
        }
       
       if (!empty($cust) && !empty($userdetail))
       {
           $sqlval = $sqlval . " where Customer = '$cust' AND agentId = '$userdetail'";
           $_SESSION['query'] = $sqlval;
           $sqlval = $sqlval ." LIMIT {$start}, {$limit}";
           $result=mysql_query($sqlval) or die(mysql_error());
       }
       
       if (!empty($transtype) && !empty($userdetail))
       {
           $sqlval = $sqlval . " where Actionx = '$transtype' AND agentId = '$userdetail'";
           $_SESSION['query'] = $sqlval;
           $sqlval = $sqlval ." LIMIT {$start}, {$limit}";
           $result=mysql_query($sqlval) or die(mysql_error());
       }
       
        if (!empty($status) && !empty($userdetail))
       {
           $sqlval = $sqlval . "  where Status = '$status' AND agentId = '$userdetail'";
           $_SESSION['query'] = $sqlval;
           $sqlval = $sqlval ." LIMIT {$start}, {$limit}";
           $result=mysql_query($sqlval) or die(mysql_error());
       }
       
       if (!empty($from) && !empty($to)){
            $sqlval = $sqlval ."  where TrxDate  between '".$from ."' and '" . $to . "' AND agentId = '$userdetail'";
            $_SESSION['query'] = $sqlval;
            $sqlval = $sqlval . " LIMIT {$start}, {$limit}";
            $result = mysql_query($sqlval) or die(mysql_error());
           
        }
       
        while ($row = mysql_fetch_object($result)) {
             $trans=new Transaction();
             $trans->transId=$row->TransId;
             $trans->actionX=$row->Actionx;
             $trans->trxDate=$row->TrxDate;
             $trans->amount=$row->Amount;
             $trans->agentId=$row->agentId;
             $trans->customer=$row->Customer;
             $trans->status=$row->Status;
             
              $list[]=$trans;
        
      }
        return $list;
         mysql_close();
}

public static function getAgentName($Id)
{
    self::DbConnect();
    $sql= "select username from userlogin where phoneNumber = $Id";
    $result = mysql_query($sql) or die(mysql_error());
    $row = mysql_fetch_assoc($result);
    $amount = $row['username'];
     return $amount;
    
     Model::conClose();
}

public static function getUserID($Id)
{
    self::DbConnect();
    $sql= "select userID from userlogin where phoneNumber = $Id";
    $result = mysql_query($sql) or die(mysql_error());
    $row = mysql_fetch_assoc($result);
    $user = $row['userID'];
     return $user;
    
     Model::conClose();
}

public static function getUserbalance($Id)
{
    self::DbConnect();
    $sql= "select amount from fundaccount where agentId = '{$Id}' AND
     status = 'Open'";
    $result = mysql_query($sql) or die(mysql_error());
    $row = mysql_fetch_assoc($result);
    $amount = $row['amount'];
     return $amount;
    
     Model::conClose();
}

public static function getAgentCashFlow($start, $limit,$Idval,$recon, $from,$to)
{
        self::DbConnect();
        $list=array();
        $username = Model::getAgentName($Idval);
        $userid = Model::getUserID($Idval);
        //echo $username;die();
        $sql = "select * from cashflow";
        //$sqlval = "select * from cashflow where status = 'O'";
//        $query = "select cf.AgentID, cf.transactionAmount, cf.Balance,
//                  cf.flowType,cf.transactionDate,cf.trnxID,
//                  fa.reconcilation, fa.status from fundaccount fa, cashflow cf 
//                  where fa.agentId = (select Id from agent where userId = (select
//                  userId from userlogin where phoneNumber = '{$Idval}')) 
//                  where fa.reconciliation = '$recon'";
        if (!empty($Idval))
        {
            $sqlval = "select * from cashflow where AgentID = 
                   (select username from userlogin where phoneNumber = '$Idval') 
                   AND status = 'O' limit {$start}, {$limit}";
            $result = mysql_query($sqlval) or die(mysql_error());
        }
       
        if (!empty($recon) && !empty($Idval))
       {
           $query = "select cf.Id, cf.AgentID, cf.transactionAmount, cf.Balance,
                  cf.flowType,cf.transactionDate,cf.trnxID,fa.status from fundaccount fa, cashflow cf 
                  where fa.agentId = (select Id from agent where userId = '{$userid}') 
                  AND fa.reconcilation = '$recon'";
           $_SESSION['query'] = $query;
           $query = $query ." LIMIT {$start}, {$limit}";
           //echo $query;die();
           $result=mysql_query($query) or die(mysql_error());
       }
        
        
        if (!empty($from) && !empty($to)){
            $sql = $sql." where AgentID = '$username' AND transactionDate  
                   between '".$from ."' and '" . $to . "'";
            $_SESSION['query'] = $sql;
           $sql = $sql ." LIMIT {$start}, {$limit}";
           $result=mysql_query($sql) or die(mysql_error());
        }
       
        while ($row = mysql_fetch_object($result)) {
             $trans = new cashflow();
             $trans->Id=$row->Id;
             $trans->AgentID=$row->AgentID;
             $trans->Balance=$row->Balance;
             $trans->flowType=$row->flowType;
             $trans->status=$row->status;
             $trans->transactionAmount=$row->transactionAmount;
             $trans->transactionDate=$row->transactionDate;
             $trans->trnxID = $row->trnxID; 
              $list[]=$trans;
        }
      
        return $list;
         mysql_close();
}

public static function getAgentTranslist($id)
{
        self::DbConnect();
        $list=array();
        $sql=" select * from  transactions where agentId='$id'";
        $result=mysql_query($sql) or die(mysql_error());
              while ($row = mysql_fetch_object($result)) {
             $trans=new Transaction();
             $trans->transId=$row->TransId;
             $trans->actionX=$row->Actionx;
             $trans->trxDate=$row->TrxDate;
             $trans->amount=$row->Amount;
             $trans->agentId=$row->agentId;
             $trans->customer=$row->Customer;
             $trans->remarks=$row->Remarks;
             $trans->status=$row->Status;
             
              $list[]=$trans;
        }
        return $list;
         mysql_close();
}

public static function getAllAgentTill()
{
        self::DbConnect();
        $list=array();
        $sql="select * from fundAccount";
        $result=mysql_query($sql) or die(mysql_error());
              while ($row = mysql_fetch_object($result)) {
             $till=new AgentTill();
             $till->Id=$row->Id;
             $till->amount=$row->amount;
             $till->createdDate=$row->createdDate;
             $till->agentId=$row->agentId;
              $list[]=$till;
        }
        return $list;
         mysql_close();
}


public static function getAllActiveSession($start,$limit,$username, $role, $logindate)
{
        self::DbConnect();
        $list=array();$result = '';$sql = '';
    
        if (empty($sql)){
            $sql="select * from activesession limit $start, $limit"; 
            $result = mysql_query($sql) or die(mysql_error());
        }

        $sqlval = "select * from  activesession";
 
        if (!empty($username)){
            $sqlval = $sqlval." WHERE username = '". $username."'";
            $_SESSION['query'] = $sqlval;
            $sqlval = $sqlval ." LIMIT {$start}, {$limit}";
            $result=mysql_query($sqlval) or die(mysql_error());
        }   

        if (!empty($role)){
            $sqlval = $sqlval ." WHERE role = '".$role."'";
            $_SESSION['query'] = $sqlval;
            $sqlval = $sqlval ." LIMIT {$start}, {$limit}";
            $result=mysql_query($sqlval) or die(mysql_error());
        }
        
        if (!empty($logindate)){
            $sqlval = $sqlval." WHERE LoginDate = '".$logindate."'";
            $_SESSION['query'] = $sqlval;
            $sqlval = $sqlval ." LIMIT {$start}, {$limit}";
            $result=mysql_query($sqlval) or die(mysql_error());
        }
        
        while ($row = mysql_fetch_object($result)) {
             $session = new sessionrpt();
             $session->sessionId = $row->Id;
             $session->firstname = $row->firstname;
             $session->lastname = $row->lastname;
             $session->username  = $row->username;
             $session->role = $row->role;
             $session->logindate = $row->LoginDate;
             $session->logoutdate = $row->LogOutDate;
             $session->status = $row->status;
              $list[]=$session;
        }
        return $list;
         mysql_close();
}

public static function TerminateSession($id)
{
    self::DbConnect();
    $list=array();
    $sql="select * from activesession where  Id = '$id'";
    $result = mysql_query($sql) or die(mysql_error());
    while ($row = mysql_fetch_object($result)) {
             $session = new sessionrpt();
             $session->sessionId = $row->Id;
             $session->firstname = $row->firstname;
             $session->lastname = $row->lastname;
             $session->username  = $row->username;
             $session->role = $row->role;
             $session->logindate = $row->LoginDate;
             $session->logoutdate = $row->LogOutDate;
             $session->status = $row->status;
              $list[]=$session;
        }
        return $list;
         mysql_close();
}

public static function SearchActivity($start,$limit,$username,$status,$phone)
{
        self::DbConnect();
        $list=array();$result = '';$sql = '';
    
        if (empty($sql)){
            $sql= " select * from  activityLog limit $start, $limit"; 
            $result = mysql_query($sql) or die(mysql_error());
        }

        $sqlval = "select * from  activityLog where '1' = '1'";
         
         if (!empty($username)){
            $sqlval = $sqlval." AND username = '". $username."'";
            $_SESSION['query'] = $sqlval;
            $sqlval = $sqlval ." LIMIT {$start}, {$limit}";
            $result=mysql_query($sqlval) or die(mysql_error());
        }   

        
        if (!empty($status)){
            $sqlval = $sqlval ." AND status = '".$status."'";
            $_SESSION['query'] = $sqlval;
            $sqlval = $sqlval ." LIMIT {$start}, {$limit}";
            $result=mysql_query($sqlval) or die(mysql_error());
        }
        
        if (!empty($phone)){
            $sqlval = $sqlval ." AND phoneNumber = '".$phone."'";
            $_SESSION['query'] = $sqlval;
            $sqlval = $sqlval ." LIMIT {$start}, {$limit}";
            $result=mysql_query($sqlval) or die(mysql_error());
        }
        
        while ($row = mysql_fetch_object($result)) {
             $activity = new activitylogs();
             $activity->Id = $row->Id;
             $activity->activity = $row->activity;
             $activity->phone = $row->phoneNumber;
             $activity->createDate  = $row->createdDate ;
             $activity->remarks = $row->remarks;
             $activity->status = $row->status;
             $activity->username = $row->username;
              $list[]=$activity;
        }
        return $list;
         mysql_close();
}

public static function getAllCorporateAcct()
{
        self::DbConnect();
        $list=array();
        $sql="select ct.corpId, ct.corpname, a.accountName, a.accountNo, a.accountType, 
              a.createdDate from corporate_tab ct inner join account a 
              on ct.Id = a.corpId";
        $result=mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_object($result)) {
             $corplink = new corplinkacct();
             $corplink->Id = $row->corpId;
             $corplink->acctNo = $row->accountNo;
             $corplink->acctName = $row->accountName;
             $corplink->createdatetime  = $row->createdDate ;
             $corplink->acctType = $row->accountType;
             $corplink->corpname = $row->corpname;
              $list[]=$corplink;
        }
        return $list;
         mysql_close();
}

public static function listparambyservicename($servicename)
{
       self::DbConnect();
        $list=array();
        $sql="select  paramValue from serviceparams where serviceName = '$servicename'";
        $result=mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_object($result)) {
             $service = new servicename();
             $service->paramvalue = $row->paramValue;
              $list[]=$service;
        }
        return $list;
         mysql_close();
}

public static function getRolename($Id)
{
        self::DbConnect();
        $rolename = '';
        $sql="select roles from role where Id = '$Id'";
        //echo $sql; die();
        $result=mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_object($result)) {
             //$role = new Role();
              $rolename = $row->roles;
        }
        return $rolename;
         mysql_close();
}

public static function listAllpermission($roleid)
{
    self::DbConnect();
    $list='';
    $sql="select actionName from rolepermission where RoleId = '$roleid'";
    $result = mysql_query($sql) or die(mysql_error());
    while ($row = mysql_fetch_object($result)) {
              $list = $row->actionName;
        }
        return $list;
         mysql_close();
}

public static function listToplevel($level)
{
    self::DbConnect();
    //$list= array();
    $sql="select distinct Links from agencybanking.toplevellinks where subLevel  = '$level'";
    $result = mysql_query($sql) or die(mysql_error());
    while ($row = mysql_fetch_object($result)) {
              $list = $row->Links;
        }
        return $list;
         mysql_close();
}

public static function viewallcorporatelist()
{
    self::DbConnect();
    $list= array();
    $sql="select corpname from corporate_tab";
    $result = mysql_query($sql) or die(mysql_error());
    while ($row = mysql_fetch_object($result)) {
              $list[] = $row->corpname;
    }
        return $list;
         mysql_close();
}

public static function viewcorporatebyID($ID)
{
    self::DbConnect();
    $list = '';
    $sql= "select corpname from corporate_tab where Id = $ID";
    $result = mysql_query($sql) or die(mysql_error());
    while ($row = mysql_fetch_object($result)) {
              $list = $row->corpname;
        }
        return $list;
         mysql_close();
}

public static function updateCustomer($ag)
{
    self::DbConnect();
    $val = Model::listCustomerID($ag->Id);
    $resultval = json_decode(json_encode($val), 1);
    //var_dump($resultval); die();
    
    if (!empty($ag->acctType))
    {
        $acctType = $ag->acctType; 
    }else{
        foreach ($resultval as $value) {
            $acctType = $value['acctType'];
        }     
    }
    
    if (!empty($ag->lastName))
    {
        $last = $ag->lastName; 
    }else{
        foreach ($resultval as $value) {
            $last = $value['lastName'];
        }     
    }
    
    if (!empty($ag->custPhone))
    {
        $phone = $ag->custPhone; 
    }else{
        foreach ($resultval as $value) {
            $phone = $value['custPhone'];
        }     
    }
    
    if (!empty($ag->custEmail))
    {
        $email = $ag->custEmail; 
    }else{
        foreach ($resultval as $value) {
            $email = $value['custEmail'];
        }     
    }
    
    if (!empty($ag->address))
    {
        $address = $ag->address; 
    }else{
        foreach ($resultval as $value) {
            $address = $value['address'];
        }     
    }
    
    if (!empty($ag->IdType))
    {
        $IdType = $ag->IdType; 
    }else{
        foreach ($resultval as $value) {
            $IdType = $value['IdType'];
        }     
    }
    
    if (!empty($ag->IdNumber))
    {
        $IdNumber = $ag->IdNumber; 
    }else{
        foreach ($resultval as $value) {
            $IdNumber = $value['IdNumber'];
        }     
    }
    
    if (!empty($ag->firstName))
    {
        $first = $ag->firstName; 
    }else{
        foreach ($resultval as $value) {
            $first = $value['firstName'];
        }     
    }
    $sql="Update customer_tab
          SET createdDate = '{$ag->dateCreated}',
          IdentificationId = '{$IdNumber}',
          customerName = '{$first}',
          lastName = '{$last}',
          email = '{$email}',
          phoneNumber = '{$phone}',
          accountType = '{$acctType}',
          identificationType = '{$IdType}',
          address = '{$address}',
          status = 'C'
          WHERE id = '{$ag->Id}'";
    $result = mysql_query($sql) or die(mysql_error());
    if (isset($result))
    {
        $numrow = mysql_affected_rows();
    }
        return $numrow;
         mysql_close();
}

public static function updateAllCustomer($ag)
{
    self::DbConnect();
    $val = Model::listCustomerID($ag->Id);
    $resultval = json_decode(json_encode($val), 1);
    //var_dump($resultval); die();
    
    if (!empty($ag->acctType))
    {
        $acctType = $ag->acctType; 
    }else{
        foreach ($resultval as $value) {
            $acctType = $value['acctType'];
        }     
    }
    
    if (!empty($ag->lastName))
    {
        $last = $ag->lastName; 
    }else{
        foreach ($resultval as $value) {
            $last = $value['lastName'];
        }     
    }
    
    if (!empty($ag->custPhone))
    {
        $phone = $ag->custPhone; 
    }else{
        foreach ($resultval as $value) {
            $phone = $value['custPhone'];
        }     
    }
    
    if (!empty($ag->custEmail))
    {
        $email = $ag->custEmail; 
    }else{
        foreach ($resultval as $value) {
            $email = $value['custEmail'];
        }     
    }
    
    if (!empty($ag->address))
    {
        $address = $ag->address; 
    }else{
        foreach ($resultval as $value) {
            $address = $value['address'];
        }     
    }
    
    if (!empty($ag->IdType))
    {
        $IdType = $ag->IdType; 
    }else{
        foreach ($resultval as $value) {
            $IdType = $value['IdType'];
        }     
    }
    
    if (!empty($ag->IdNumber))
    {
        $IdNumber = $ag->IdNumber; 
    }else{
        foreach ($resultval as $value) {
            $IdNumber = $value['IdNumber'];
        }     
    }
    
    if (!empty($ag->firstName))
    {
        $first = $ag->firstName; 
    }else{
        foreach ($resultval as $value) {
            $first = $value['firstName'];
        }     
    }
    $sql="Update customer_tab
          SET createdDate = '{$ag->dateCreated}',
          IdentificationId = '{$IdNumber}',
          customerName = '{$first}',
          lastName = '{$last}',
          email = '{$email}',
          phoneNumber = '{$phone}',
          accountType = '{$acctType}',
          identificationType = '{$IdType}',
          address = '{$address}',
          status = 'C'
          WHERE id = '{$ag->Id}'";
    $result = mysql_query($sql) or die(mysql_error());
    if (isset($result))
    {
        $numrow = mysql_affected_rows();
    }
        return $numrow;
         mysql_close();
}

public static function checkvalidation()
{
    if ($_SESSION["authorized"] != TRUE)
    {
        $host  = $_SERVER['HTTP_HOST'];
        $uri   = '/AgencyBanking';
        $extra = 'index.php';
        header("Location: http://$host$uri/$extra");
        exit;
    }
}

public static function callABWM($url) {
          $ch = curl_init();         
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_HEADER, 0);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          $result = curl_exec($ch);
          curl_close($ch);
          return $result;     
}

}

?>
