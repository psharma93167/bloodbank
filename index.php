<?php require_once('process.php');
$banks =  getAllBanks($conn);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="custom.js"></script>
</head>
<body>

<div class="container">
<a href="/bloodbank/firstreport.php">Report First</a>|
<a href="/bloodbank/secondreport.php">Report Second</a>

  <h2>blood bank </h2>
  <?php 
  if(isset($_SESSION['msg'])){
   echo $_SESSION['msg'];
   unset($_SESSION['msg']);
} ?>
  <form class="form-horizontal" action="/bloodbank/process.php" method="post" onsubmit="return formValidation()">
    
    <div class="form-group">
      <label class="control-label col-sm-2" for="pwd">Please Select Bank:</label>
      <div class="col-sm-10">          
      <select class="form-control" id="banks" name="banks">
      <option value="">Please Select </option>
        <?php 

        foreach ($banks as $value) {
           echo '<option value="'.$value[0].'">'.$value[1].'</option>';
          }
        ?>
           
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="pwd">Please select Blood Group:</label>
      <div class="col-sm-10">  
      <select class="form-control" id="bloods" name="bloods">        
      <option value="">Please Select </option>
      
        </select>
      </div>
      </div>
      <div class="form-group">
      <label class="control-label col-sm-2" for="pwd">customer type:</label>
      <div class="col-sm-10">          
        <select class="form-control" id="cutomertypes" name="cutomertypes">
            <option>select customer type</option>
            <option>Employee</option>
            <option>Individual</option>
        </select>
      </div>
      </div>
   
      <div class="form-group">
      <label class="control-label col-sm-2" for="pwd">Quantity:</label>
      <div class="col-sm-10">          
        <input type="text" class="form-control" id="qty" placeholder="Quantity" name="qty">
        
      </div>
      </div>
      <div class="form-group">
      <label class="control-label col-sm-2" for="pwd">Cost:</label>
      <div class="col-sm-10">          
        <input readonly type="text" class="form-control" id="cost" placeholder="Cost" name="cost">
      </div>
      </div>
      <div class="form-group">
      <label class="control-label col-sm-2" for="pwd">Discount:</label>
      <div class="col-sm-10">          
        <input readonly type="text" class="form-control" id="discount" placeholder="Discount" name="discount">
      </div>
      </div>
      <div class="form-group">
      <label class="control-label col-sm-2" for="pwd">AmountPayable:</label>
      <div class="col-sm-10">          
        <input readonly type="text" class="form-control" id="amountpayble" placeholder="AmountPayable" name="amountpayble">
      </div>
      </div>
      <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
        <input type="hidden" name="action" value="submitForm"> 
        <button type="submit" class="btn btn-default">Submit</button>
      </div>
      </div>
    </div>
  </form>
</div>
</body>
</html>
