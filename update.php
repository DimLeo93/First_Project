 <html>
<body>
    
<?php 
include 'connect.php';
if (!$_POST['submit']){
    $sql = "SELECT * FROM users WHERE Id=".$_GET['id'];
    $result4 = mysqli_query($conn, $sql);
    $row4 = $result4->fetch_assoc();
    $def_fname = $row4["first_name"];
    $def_lname = $row4["last_name"];
    $def_email = $row4["email"];
    $def_image = $row4["user_image"];

}


?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
Select image:   <input type="file" name="fileToUpload" id="fileToUpload"  maxlength="92" value=<?php echo htmlspecialchars($def_image); ?>> <br>
first_name: <input type="text" name="new_first_name"  maxlength="50"  value=<?php echo htmlspecialchars($def_fname); ?>><br>
last_name: <input type="text" name="new_last_name"  maxlength="50" value=<?php echo htmlspecialchars($def_lname); ?>><br>
email: <input type="email" name="new_email"  maxlength="60"  value=<?php echo $def_email; ?>><br>
<input type="submit" name="submit"  value="Update User">
</form>

<?php
$_GET   = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
include 'connect.php';
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
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    $uploadfinal=1;
}
if($uploadfinal == 1){
    

    $sql = "UPDATE users SET first_name='".$_POST['new_first_name']."', last_name='".$_POST['new_last_name']."', email= '".$_POST['new_email']."' WHERE Id=".$_GET['id'];

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file) ) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been replaced.";
        $bool = true;

    } else {
        echo "Sorry, there was an error uploading your file.";
        $bool = false;
    }
    //if image gets uploaded succesfully, add the user too
if($bool){
    if (mysqli_query($conn, $sql)) {
        echo "User updated successfully";
        //now delete the previous image
        $sql = "SELECT user_image FROM users WHERE Id=".$_GET['id'];
        $result3 = mysqli_query($conn, $sql);
        $row = $result3->fetch_assoc();
        echo $row;
           // unlink($row['user_image']);
    } else {

        unlink($target_file); //if the update has an error, delete the new picture that was uploaded
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    } 
}

}

}



?>

</body>
</html>