<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
<?php
error_reporting(0);
session_start();
if(!isset($_SESSION))
{
    header("Location: index.php");
die();
}    
echo '<a href="getdata.php">List of available products</a>';
    
$servername = "localhost:3306";
$username = "root";
$password = "";
$
$dbname = "Ecommerce";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$cname = mysql_real_escape_string($_SESSION['cname'])?: '';
$pname = mysql_real_escape_string($_POST['pname'])?: '';
$pprice  = mysql_real_escape_string($_POST['pprice'])?: '';
$datetime = date_create()->format('Y-m-d H:i:s');
if($pname === "")
{
     header("Location: getdata.php");
     die();
}

$result1 = $conn->query("SELECT cname FROM customer WHERE cname = '$cname'");
if($result1->num_rows == 0) {
    echo '<b>customer does not exist</b></br>';
    echo '<a href="index.php">Click here and enter valid customer name</a>';
    
}else{
$result = $conn->query("SELECT cname FROM purchase WHERE pname = '$pname' and cname = '$cname' and status='pending'");
if($result->num_rows == 0) {
     $sql = "INSERT INTO purchase (cname, pname, putime,quantity,puprice,status) VALUES ('$cname', '$pname', '$datetime',1,'$pprice','pending')";

if ($conn->query($sql) === TRUE) {
   
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
} else {
    $sql = "UPDATE purchase set putime = '$datetime' , quantity = quantity+1,puprice = '$pprice'+puprice where pname='$pname' and cname='$cname' and status='pending'";
    if ($conn->query($sql) === TRUE) {
   
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
}
}
$count = 1;

$sql = "SELECT pname,putime,quantity,puprice FROM purchase WHERE cname = '$cname' AND status='pending'";
$result = $conn->query($sql);
$count = 1;
if ($result->num_rows > 0) { ?>
<h2>List of Pending Orders</h2>
 <table>
     <tr>
         <td>Sr. No</td>
     <td>Product Name</td>
     <td>Purchase Time</td>
     <td>Quantity</td>
      <td>Purchase Price</td>
     </tr>
 <?php   // output data of each row
    while($row = $result->fetch_assoc()) {?>
  <tr>
      <td width="10px"><?php echo $count++?></td>     
    <td><?php echo $row['pname']?></td>
    <td><?php echo $row['putime']?></td>
     <td><?php echo $row['quantity']?></td>
      <td><?php echo $row['puprice']?></td>
  </tr>

   <?php 
    } ?>
  </table>
<?php
} else {
    echo "0 results";
}

$conn->close();
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

