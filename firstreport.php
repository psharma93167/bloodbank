<?php require_once('process.php');
    $row=[];
    if(isset($_GET['action']) && $_GET['action']=='searchdate'){
     
      $fromdate = $_GET['fromdate'];
      $todate = $_GET['todate'];
  
  
      if($fromdate =='' || $todate==''){
          echo 'Please select from date and to date';
      }else{
      $sql = "SELECT DateOfTransaction ,CustomerType,SUM(Discount) 
      FROM tbltransaction 
      WHERE DateOfTransaction BETWEEN '$fromdate' AND '$todate' GROUP BY DateOfTransaction ,CustomerType";
  
      $result = $conn->query($sql);
     
      $row = $result->fetch_all();
      }
  }

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
<a href="/bloodbank/index.php">Home Page</a>|
<a href="/bloodbank/secondreport.php">Report Second</a>

  <h2>Firt Report </h2>
  <form class="form-inline" action="#" method="GET">
    <div class="form-group">
      <label for="email">From Date:</label>
      <input type="date" class="form-control" id="fromdate"  name="fromdate">
    </div>
    <div class="form-group">
      <label for="pwd">To Date:</label>
      <input type="date" class="form-control" id="todate"  name="todate">
    </div>
    <input type="hidden" name="action" value="searchdate"> 
    <button type="submit" class="btn btn-default">Submit</button>
  </form>
<table border="1" style="width:100%">
  <tr>
    <th>Sr No</th>
    <th>Date</th>
    <th>Customer Type</th>
    <th>Discount</th>
  </tr>
  <?php 
$i=1;
foreach ($row as $value) {
  echo ' <tr>
    <td>'.$i.'</td>
    <td>'.$value[0].'</td>
    <td>'.$value[1].'</td>
    <td>'.$value[2].'</td>
  </tr>';
   $i++;
  }
?>
 
  
</table>

</div>
</body>
</html>
