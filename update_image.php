
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


    $sql = "SELECT user_image FROM users WHERE Id=".$_GET['id'];
    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc();
    $def_image = $row["user_image"];


?>

        <div class="container">
        <div class="well">
        <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?id=".$_GET['id']);?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="entry_id" value='<?php echo $_GET['id'];?>'>
            <div class="form-group">
                <label class="control-label col-sm-2"></label>
                <div class="col-sm-10">
                    <h1>Change Image<h1>    
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="fileToUpload">Upload Image:</label>
                <div class="col-sm-10">
                <input type="file" hidden name="fileToUpload" class="form-control" value=<?php echo htmlspecialchars($def_image); ?> id="fileToUpload"></label>
                </div>
            </div>  
            <div class="form-group">        
                <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default" value="Update User Image" name="submit">Submit</button>
                </div>
            </div>
        </form>
        </div>
        </div>


<?php

if ($_POST['submit']) {

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$uploadfinal = 0;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image

    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image." .  "<br/>\n";
        $uploadOk = 0;
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

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file) ) {
        echo "The file ".$def_image . " has been replaced." .  "<br/>\n";
        $bool = true;

    } else {
        echo "Sorry, there was an error uploading your file." .  "<br/>\n";
        $bool = false;
    }

     
      //delete the previous image
        $sql = "SELECT user_image FROM users WHERE Id=".$_POST['entry_id'];
        $result2 = mysqli_query($conn, $sql);
        $row2 = $result2->fetch_assoc();
        if($row2["user_image"]!= NULL)
           unlink($row2["user_image"]);
           else
           echo "First Image Added".  "<br/>\n"; 
      //update the database 
        $sql = "UPDATE users SET user_image='$target_file' WHERE Id='".$_POST['entry_id']."'";
     if (mysqli_query($conn, $sql)) {
        echo "Database updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    } 
}
}
?>

</body>
</html>