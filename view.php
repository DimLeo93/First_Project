 <html>
    <head>
       <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
       <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
<body>

<?php 
include 'connect.php';
include 'header.php';
$_GET   = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

$sql = "SELECT first_name, last_name, email, user_image FROM users  WHERE id=".$_GET['id'];
$result = mysqli_query($conn, $sql);
?>
<div id="content">

  <table class="table">
      <thead>
      <tr>
        <th>Profile Photo</th>
        <th>First name</th>
        <th>Last name</th>
        <th>Email</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = $result->fetch_assoc()) { ?>
      <tr>
        <td><img src=<?php  echo $row['user_image']; ?> alt="Profile Photo" style="width:60px;height:60px;"></td>
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