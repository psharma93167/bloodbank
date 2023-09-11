<?php
session_start();
$servername="localhost";
$username="root";
$password="";
$dbname="bloodbank";

$conn = new mysqli($servername,$username,$password,$dbname);
if($conn->connect_error){
    die ("connection failed:" .$conn->connect_error);
}

function getAllBanks($conn){
    $sql = "SELECT BloodBankCode,BloodBankName FROM mstbloodbank GROUP BY BloodBankCode,BloodBankName";
    $result = $conn->query($sql);
    $row=[];
    if($result->num_rows > 0){
        $row = $result->fetch_all();
    }
    return $row;
}

function getAllGroup($conn,$bankCode){
    try {
    $sql = "SELECT mstbloodgroup.* FROM `mstbloodbank`
    LEFT JOIN mstbloodgroup ON mstbloodgroup.BloodGroupCode = mstbloodbank.BloodGroupCode
    where BloodBankCode = '$bankCode'";
    
    $result = $conn->query($sql);
    $row=[];
    if($result->num_rows > 0){
        $row = $result->fetch_all();
        
    }
    return $row;
    }
    catch (customException $e) {
        die('test');
        //display custom message
        die( $e->errorMessage());
      }
}

function getPriceByBloodBank($banks,$bloods,$conn){
    $sql = "SELECT PricePerUnit FROM `mstbloodbank`
    where BloodBankCode = '$banks' && BloodGroupCode  = '$bloods'";
    
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['PricePerUnit'];
}
function addTwoDigitInlast($foo){
    return number_format((float)$foo, 2, '.', '');
}

function getQtyByBankBlood($banks,$bloods,$conn){
    $sql = "SELECT QuantityAvailable FROM `mstbloodbank`
    where BloodBankCode = '$banks' && BloodGroupCode  = '$bloods'";
    
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['QuantityAvailable'];
}
function getUsedQtyByBankBlood($banks,$bloods,$conn){
    $sql = "SELECT SUM(Quantity) as usedQty FROM `tbltransaction`
    where BloodBankCode = '$banks' && BloodGroupCode  = '$bloods'";
    
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['usedQty'];
}
function getAvailabelQtyByBankBlood($banks,$bloods,$conn){
    $qtyAvailble = getQtyByBankBlood($banks,$bloods,$conn);
    $qtyUsed = getUsedQtyByBankBlood($banks,$bloods,$conn);
    $availbleQty =  $qtyAvailble- $qtyUsed;
    return $availbleQty;
}
if(isset($_POST['action']) && $_POST['action']=='getGroupCode'){

    $bankCode = $_POST['bankCode'];
   
    $groups = getAllGroup($conn,$bankCode); 
    $option = '<option value="">Please Select </option>';
    foreach ($groups as $value) {
        $option .= '<option value="'.$value[0].'">'.$value[1].'</option>';
       }
    echo $option;
    die;
}

if(isset($_POST['action']) && $_POST['action']=='getPrice'){

    $bankCode = $_POST['bankCode'];
    $groudCode = $_POST['groudCode'];

    $sql = "SELECT PricePerUnit FROM `mstbloodbank`
    where BloodBankCode = '$bankCode' && BloodGroupCode  = '$groudCode'";
    
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    echo json_encode( $row);
    die;
}


if(isset($_POST['action']) && $_POST['action']=='submitForm'){

    echo '<pre>';
    print_r($_POST);

    
    $banks = $_POST['banks'];
    $bloods = $_POST['bloods'];
    $cutomertypes = $_POST['cutomertypes'];
    $qty = addTwoDigitInlast($_POST['qty']);
    
   // $cost = $_POST['cost'];
   // $discount = $_POST['discount'];
   // $amountpayble = $_POST['amountpayble'];
   if($qty ==0 || $qty ==''|| $banks ==''|| $bloods ==''|| $cutomertypes ==''){
    $_SESSION["msg"] ='please enter all required fields';
    header("Location:/bloodbank/index.php");
    die;
    
   }
    $availQty = getAvailabelQtyByBankBlood($banks,$bloods,$conn);

    if($availQty >= $qty ){
  
        $price = addTwoDigitInlast(getPriceByBloodBank($banks,$bloods,$conn));
        $cost = addTwoDigitInlast($price* $qty);
    //  echo  $cost; die;
        $discount = addTwoDigitInlast(0);
        if($cutomertypes == 'Employee'){
            $discount = addTwoDigitInlast($cost*20/100);
        }
        $amountpayble = addTwoDigitInlast($cost- $discount);
        $date = date("Y-m-d");
        $sql = "INSERT INTO `tbltransaction`( `BloodBankCode`, `BloodGroupCode`, `CustomerType`, `DateOfTransaction`, `Quantity`, `Cost`, `Discount`, `AmountPayable`) VALUES ($banks,$bloods,'".$cutomertypes."','".$date."',$qty,'".$cost."','".$discount."','".$amountpayble."')";
        $result = $conn->query($sql);
        $_SESSION["msg"] ='Enter successfully';
        header("Location:/bloodbank/index.php");
    }else{
        $_SESSION["msg"] ='only '. $availQty. ' Available';
        header("Location:/bloodbank/index.php");
    }
}