 <html>
 <head>
 
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
   
</head>
<body>
 <?php
 
 require 'connect.php';

$sql = "SELECT Id, first_name, last_name, email  FROM users";
$result = $conn->query($sql);
?>
<h1> Database results </h1>
<?php  echo "<a href=create.php?"."'>Click to add user</a>"; ?>
<div id="content">

  <table class="table">
      <thead>
      <tr>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>Email</th>
        <th>Details</th>
        <th>Update</th>
        <th>Delete</th>

      </tr>
    </thead>
    <tbody>
      <?php while($row = $result->fetch_assoc()) { ?>
      <tr>
        <td><?php echo $row['first_name']; ?></td>
        <td><?php echo $row['last_name']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td><?php  echo "<a href='view.php?id=".$row["Id"]."'>Click to view details</a>"; ?></td>
        <td><?php  echo "<a href='update.php?id=".$row["Id"]."'>Click to update user</a>"; ?></td>
        <td><?php  echo "<a href=delete.php?id=".$row["Id"]."'>Click to remove user</a>"; ?></td>



      </tr>
      </tbody>
      <?php } ?>
    </table>

   </div>
</body>
</html>