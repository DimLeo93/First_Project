 
 <html>
  <head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>  
</head>
<body>

<?php 
include 'connect.php';
//echo 'Hello ' . htmlspecialchars($_GET["id"]) . '!';


$sql = "SELECT Id, first_name, last_name, email FROM users  WHERE id=".$_GET['id'];
$result = mysqli_query($conn, $sql);
?>
<div id="content">

  <table class="table">
      <thead>
      <tr>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>Email</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = $result->fetch_assoc()) { ?>
      <tr>
        <td><?php echo $row['first_name']; ?></td>
        <td><?php echo $row['last_name']; ?></td>
        <td><?php echo $row['email']; ?></td>
      </tr>
      </tbody>
      <?php } ?>
    </table>

   </div>



</body>
</html>