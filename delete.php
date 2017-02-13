 
 <?php
 include 'connect.php'; 
 include 'header.php';

// sql to delete a record
$_GET   = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

$sql = "DELETE FROM users WHERE Id=".$_GET['id'];
$sql2 = "SELECT * FROM users WHERE Id=".$_GET['id'];

$result = mysqli_query($conn, $sql2);
$row = $result->fetch_assoc();


if (mysqli_query($conn, $sql)) {
    if($row["user_image"]!= NULL){
        unlink($row["user_image"]);
    }
    echo "Record deleted successfully. You will be redirected to the home page";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn) . ". You will be redirected to the home page";
}
header( "refresh:1;url=index.php" );

?> 