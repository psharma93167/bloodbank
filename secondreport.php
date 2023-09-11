<?php require_once('process.php');
 $row=[];
$sql = "SELECT mstbloodbank.BloodBankName, mstbloodgroup.BloodGroupName, tbltransaction.CustomerType,SUM(tbltransaction.Quantity)   FROM tbltransaction 
LEFT JOIN mstbloodbank ON mstbloodbank.BloodBankCode=tbltransaction.BloodBankCode
LEFT JOIN mstbloodgroup ON mstbloodgroup.BloodGroupCode = tbltransaction.BloodGroupCode
GROUP BY mstbloodbank.BloodBankName, mstbloodgroup.BloodGroupName, tbltransaction.CustomerType";

$result = $conn->query($sql);

$row = $result->fetch_all();

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
<a href="/bloodbank/index.php">Home Page</a>|

  <h2>Second Report </h2>
  <table border="1" style="width:100%">
  <tr>
    <th>Sr No</th>
    <th>Bank Name</th>
    <th>Group Name</th>
    <th>Customer Type</th>
    <th>Sold</th>
  </tr>
  <?php 
$i=1;
foreach ($row as $value) {
  echo ' <tr>
    <td>'.$i.'</td>
    <td>'.$value[0].'</td>
    <td>'.$value[1].'</td>
    <td>'.$value[2].'</td>
    <td>'.$value[3].'</td>
  </tr>';
   $i++;
  }
?>
 
  
</table>
 </div>


 

</body>
</html>
