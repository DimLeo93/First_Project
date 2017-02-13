<html>
    <head>
       <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
       <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
       <style> 
            input[type=text] {
                width: 130px;
                box-sizing: border-box;
                border: 2px solid #ccc;
                border-radius: 4px;
                font-size: 16px;
                background-color: white;
                background-image: url('searchicon.png');
                background-position: 10px 10px; 
                background-repeat: no-repeat;
                padding: 12px 20px 12px 40px;
                -webkit-transition: width 0.4s ease-in-out;
                transition: width 0.4s ease-in-out;
            }

            input[type=text]:focus {
                width: 100%;
            }
       </style>
    </head>

<?php
include 'connect.php';
include 'header.php';
$_GET   = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
$results_per_page = 5;

if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };
if (isset($_GET["term"])) { $term  = $_GET["term"]; } else { $term=''; };
$start_from = ($page-1) * $results_per_page;
$sql = "SELECT * FROM users WHERE first_name LIKE '%$term%' OR last_name LIKE '%$term%' LIMIT $start_from,$results_per_page";
$result = mysqli_query($conn, $sql);
 while ( $row = mysqli_fetch_assoc($result) ) {
        $results[]  = $row;

    }
 
$sql = "SELECT COUNT(*) AS total FROM users WHERE first_name LIKE '%$term%' OR last_name LIKE '%$term%'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$total_pages = ceil($row['total'] / $results_per_page); // calculate total pages with results
  

?>
 <div class="container">


        <div class="col-md-10 col-md-offset-1">
            <form action="" method="get">
               <input type="text" name="term"><br>
               <input type="submit" name="submit" value="Search.."/> 
             </form> 
            <h1> Database Results </h1>
            <?php
            for ($i=1; $i<=$total_pages; $i++) {  // print links for all pages
                        //echo "<a href='view.php?id=". $results[$i]['Id'] ."'>Click to view details</a>";
                        echo "<a href='index.php?page=$i&term=$term'";
                        if ($i==$page)  echo " class='curPage'";
                        echo ">".$i."</a> "; 
            }
            ?> 
        <table class="table table-striped table-condensed table-bordered table-rounded">
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Name</th>
                    <th width="20%">Surname</th>
                    <th width="20%">Email Address</th>
                    <th>Details</th>
                    <th>Update Info</th>
                    <th>Change Image</th>
                    <th>Delete</th>
                    </tr>
            </thead>
            <tbody>
                <?php for( $i = 0; $i < count( $results ); $i++ ){ 
                        if($results[$i]['user_image']==NULL){
                            $results[$i]['user_image'] = 'uploads/default.jpg';
                        }
                }
                ?>
                <?php for( $i = 0; $i < count( $results ); $i++ ) : ?>
                    <tr>
                        <td><img src=<?php  echo $results[$i]['user_image']; ?> alt="Profile Photo" style="width:60px;height:60px;"></td>
                        <td><?php echo $results[$i]['first_name']; ?></td>
                        <td><?php echo $results[$i]['last_name']; ?></td>
                        <td><?php echo $results[$i]['email']; ?></td>  
                        <td><?php  echo "<a href='view.php?id=".$results[$i]['Id']."'>View details</a>"; ?></td>
                        <td><?php  echo "<a href='update.php?id=".$results[$i]['Id']."'>Update User Info</a>"; ?></td>
                        <td><?php  echo "<a href='update_image.php?id=".$results[$i]['Id']."'>Change Photo</a>"; ?></td>
                        <td><?php  echo "<a  href='delete.php?id=".$results[$i]['Id']."' >Remove User</a>"; ?></td>
                    </tr>
                <?php endfor; ?>                   
            </tbody>
        </table>
        </div>
    </div>
</html>