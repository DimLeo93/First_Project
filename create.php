 
 <html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<?php include 'header.php'; ?>

<div class="container">
<div class="well">
  <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
      <div class="form-group">
      <label class="control-label col-sm-2"></label>
      <div class="col-sm-10">
        <h1>Add User<h1>    
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="fileToUpload">Upload Image:</label>
      <div class="col-sm-10">
      <input type="file" hidden name="fileToUpload" class="form-control" id="fileToUpload" required></label>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="email">Email:</label>
      <div class="col-sm-10">          
       <input type="email" class="form-control" id="email" name="email" maxlength="60" placeholder="example@domain.com" required><br>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="first_name">First Name:</label>
      <div class="col-sm-10">          
    <input type="text" class="form-control" name="first_name" id="first_name" maxlength="50" placeholder="John" required><br>
      </div>
    </div>
        <div class="form-group">
      <label class="control-label col-sm-2" for="email">Last Name:</label>
      <div class="col-sm-10">          
    <input type="text" class="form-control" name="last_name" id="last_name" maxlength="50" placeholder="Doe" required><br>
      </div>
    </div>
    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default" value="Create User" name="submit">Submit</button>
      </div>
    </div>
  </form>
</div>
</div>

<?php
include 'connect.php';

$_GET   = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
if ($_POST['submit']) {

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$uploadfinal = 0;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        //echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists." .  "<br/>\n";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large." .  "<br/>\n";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed." .  "<br/>\n";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded." .  "<br/>\n";
// if everything is ok, try to upload file
} else {
    $uploadfinal=1;
}
if($uploadfinal == 1){

    $result2 = mysqli_query($conn, "SELECT Id FROM users ORDER BY Id DESC 
                        LIMIT 1");
    $row2 = $result2->fetch_row();
    echo $row2;
    $row2[0]++;

    $sql = "INSERT INTO users (Id, first_name, last_name, email,user_image)
    VALUES ('$row2[0]','".$_POST['first_name']."', '".$_POST['last_name']."','".$_POST['email']."','$target_file')";

if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file) ) {
        //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        $bool = true;

    } else {
        echo "Sorry, there was an error uploading your file." .  "<br/>\n";
        $bool = false;
    }
if($bool){
    if (mysqli_query($conn, $sql)) {
        echo "User added. You will be redirected to the home page";
    } else {
        unlink($target_file); //if the create has an error, delete the new picture that was uploaded
        echo "image has been deleted" .  "<br/>\n";
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    } 
}
header( "refresh:1;url=index.php" );

}

}
?>

</body>
</html>


