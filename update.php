 <html>
 <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<?php 
include 'connect.php';
include 'header.php';

    $sql = "SELECT * FROM users WHERE Id=".$_GET['id'];
    $result4 = mysqli_query($conn, $sql);
    $row4 = $result4->fetch_assoc();
    $def_fname = $row4["first_name"];
    $def_lname = $row4["last_name"];
    $def_email = $row4["email"];
    $def_image = $row4["user_image"];


?>

<div class="container">
<div class="well">
  <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?id=".$_GET['id']);?>" method="post" enctype="multipart/form-data">
     <input type="hidden" name="entry_id" value='<?php echo $_GET['id'];?>'>
      <div class="form-group">
      <label class="control-label col-sm-2"></label>
      <div class="col-sm-10">
        <h1>Update User Info<h1>    
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2" for="email">Email:</label>
      <div class="col-sm-10">          
       <input type="email" class="form-control" id="email" name="new_email" value=<?php echo $def_email; ?> maxlength="60" placeholder="example@domain.com" required><br>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="first_name">First Name:</label>
      <div class="col-sm-10">          

    <input type="text" class="form-control" name="new_first_name" id="first_name" value=<?php echo htmlspecialchars($def_fname); ?> maxlength="50" placeholder="John" required><br>
      </div>
    </div>
        <div class="form-group">
      <label class="control-label col-sm-2" for="email">Last Name:</label>
      <div class="col-sm-10">          
    <input type="text" class="form-control" name="new_last_name" id="last_name" value=<?php echo htmlspecialchars($def_lname); ?> maxlength="50" placeholder="Doe" required><br>
      </div>
    </div>
    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default" value="Update User" name="submit">Submit</button>
      </div>
    </div>
  </form>
</div>
</div>

<?php
$_GET   = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

if ($_POST['submit']) {

    $sql = "UPDATE users SET first_name='".$_POST['new_first_name']."', last_name='".$_POST['new_last_name']."', email= '".$_POST['new_email']."' WHERE Id=".$_POST['entry_id'];

    if (mysqli_query($conn, $sql)) {
        echo "User updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    } 
}

?>

</body>
</html>