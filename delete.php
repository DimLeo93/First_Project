 
 <?php
 include 'connect.php'; 
 include 'header.php';

// sql to delete a record
$_GET   = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
$sql = "DELETE FROM users WHERE Id='".$_GET['id'] ."'";

if (mysqli_query($conn, $sql)) {
    echo "Record deleted successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
?> 