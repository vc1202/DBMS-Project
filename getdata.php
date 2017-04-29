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
<a href="index.php">HOME</a>
<?php
session_start();
error_reporting(0);
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

// Create connection
$conn = new mysqli('localhost',root, $dbname);
//Check if the connection is established
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

if(empty($_SESSION['cname']))
{
     //header("Location: index.php");
     //die();
} 

$cname = mysql_real_escape_string($_POST['cname'])?: '';  //Escape any Special Characters for Usage in Query(Security)
$keywords = mysql_real_escape_string($_POST['keywords'])?: ''; //Same with Above
if(!empty($cname))
    {
        $_SESSION['cname'] = $cname;
    } else {        
}
if(!empty($_SESSION['cname']))
{
    $cname = $_SESSION['cname'];
}    

    
    $result1 = $conn->query("SELECT cname FROM customer WHERE cname = '$cname'");
if($result1->num_rows == 0) {
    echo '<b>customer does not exist.Please Enter a Valid Customer Name</b></br>';
    echo '<a href="index.php">Click here and enter valid customer name</a>';
    
}else{
  
echo 'Welcome     ',$_SESSION['cname'];

$sql = "SELECT pname,pdescription,pprice,pstatus FROM product WHERE pdescription like '%". mysql_real_escape_string($keywords) ."%'";
$result = $conn->query($sql);
$count = 1;
if ($result->num_rows > 0) { ?>
<h2>List of Items according to the Keyword Entered</h2>
 <table>
      <tr>
         <td>Sr. No</td>
     <td>Product Name</td>
     <td>Product Description</td>
     <td>Purchase Price</td>
      <td>Cart</td>
     </tr>
 <?php   // output data of each row
    while($row = $result->fetch_assoc()) {?>
     <form action="orders.php" method="POST">
  <tr>
      <td width="10px"><?php echo $count++?></td>
      <td><input type="hidden" name="pname" value="<?php echo $row['pname']?>"><?php echo $row['pname']?></td>
      
    <td><?php echo $row['pdescription']?></td>
    <td><input type="hidden" name="pprice" value="<?php echo $row['pprice']?>"><?php echo $row['pprice']?></td>
    <td><?php if($row['pstatus']==='available') echo '<button type="submit">Add to cart</button>'?>
        <?php if($row['pstatus']!=='available') echo 'Not available'?> </td>    
    
     </form>
  </tr>

   <?php 
    } ?>
  </table>
<?php
} else {
    echo "No results With Selected Options";
}
}
