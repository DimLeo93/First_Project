 
 <html>
<body>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
Select image:   <input type="file" name="fileToUpload" id="fileToUpload"  maxlength="92" required> <br>
first_name: <input type="text" name="first_name"  maxlength="50" placeholder="John" required><br>
last_name: <input type="text" name="last_name" maxlength="50" placeholder="Doe" required><br>
email: <input type="email" name="email" maxlength="60" placeholder="example@domain.com" required><br>
<input type="submit" name="submit"  value="Create User">
</form>

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

    $result2 = mysqli_query($conn, "SELECT count(*) FROM users");
    $row2 = $result2->fetch_row();
    $row2[0]++;

    $sql = "INSERT INTO users (Id, first_name, last_name, email,user_image)
    VALUES ('$row2[0]','".$_POST['first_name']."', '".$_POST['last_name']."','".$_POST['email']."','$target_file')";

if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file) ) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        $bool = true;

    } else {
        echo "Sorry, there was an error uploading your file.";
        $bool = false;
    }
    //if image gets uploaded succesfully, add the user too
if($bool){
    if (mysqli_query($conn, $sql)) {
        echo "User updated successfully";
    } else {
        unlink($target_file); //if the create has an error, delete the new picture that was uploaded
        echo "image has been deleted";
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    } 
}

}

}
?>

</body>
</html>