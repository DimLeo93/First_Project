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
 require_once 'paginator.php';

    $limit      = ( isset( $_GET['limit'] ) ) ? $_GET['limit'] : 5;
    $page       = ( isset( $_GET['page'] ) ) ? $_GET['page'] : 1;
    $links      = ( isset( $_GET['links'] ) ) ? $_GET['links'] : 7;    
    $query = "SELECT * FROM users WHERE ( first_name LIKE  '%".$_POST['prefix']."%' OR last_name LIKE  '%".$_POST['prefix']."%')";

    $Paginator  = new Paginator( $conn, $query );
    $results    = $Paginator->getData( $limit, $page );
    

?>

<div class="container">
                <div class="col-md-10 col-md-offset-1">
                    <h1> Search results </h1>
                     <form action="" method="post"> 
                         <input type="text" name="prefix" placeholder= "Search.." /><br /> 
                        <input type="submit" value="Submit" /> 
                    </form> 

                <table class="table table-striped table-condensed table-bordered table-rounded">
                        <thead>
                                <tr>
                                <th>Name</th>
                                <th width="20%">Surname</th>
                                <th width="20%">Email Address</th>
                                <th>Details</th>
                                <th>Update</th>
                                <th>Delete</th>
                        </tr>
                        </thead>
                        <tbody>
                             <?php for( $i = 0; $i < count( $results->data ); $i++ ) : ?>
                                    <tr>
                                            <td><?php echo $results->data[$i]['first_name']; ?></td>
                                            <td><?php echo $results->data[$i]['last_name']; ?></td>
                                            <td><?php echo $results->data[$i]['email']; ?></td>  
                                            <td><?php  echo "<a href='view.php?id=". $results->data[$i]['Id'] ."'>Click to view details</a>"; ?></td>
                                            <td><?php  echo "<a href='update.php?id=".$results->data[$i]['Id']."'>Click to update user</a>"; ?></td>
                                            <td><?php  echo "<a href=delete.php?id=".$results->data[$i]['Id']."'>Click to remove user</a>"; ?></td>  
                                    </tr>
                            <?php endfor; ?>                   
                        </tbody>
                </table>
                 <?php echo $Paginator->createLinks( $links, 'pagination pagination-sm' ); ?>
                </div>
        </div>

        </html>