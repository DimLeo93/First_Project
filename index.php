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
    <body>
    <?php
    $_GET   = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
    $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    require_once 'initial.php';
    require_once 'paginator.php';
    require 'connect.php';
    include 'header.php';
    
    $limit      = ( isset( $_GET['limit'] ) ) ? $_GET['limit'] : 5;
    $page       = ( isset( $_GET['page'] ) ) ? $_GET['page'] : 1;
    $links      = ( isset( $_GET['links'] ) ) ? $_GET['links'] : 7;
    $query      = "SELECT * FROM users";
    
 
    $Paginator  = new Paginator( $conn, $query );
    $results    = $Paginator->getData( $limit, $page );
    ?>


        <div class="container">
                <div class="col-md-10 col-md-offset-1">
                    <h1> Database results </h1>
                    <?php  echo "<a href=create.php?"."'>Click to add user</a>"; ?> <p>

                     <form action="search.php" method="post"> 
                         <input type="text" name="prefix" placeholder= "Search.." /><br /> 
                        <input type="submit" value="Submit" /> 
                    </form> 
                    
                <?php echo $Paginator->createLinks( $links, 'pagination pagination-sm' ); ?>
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
                            <?php for( $i = 0; $i < count( $results->data ); $i++ ) : 
                                   if($results->data[$i]['user_image']==NULL){
                                        $results->data[$i]['user_image'] = 'uploads/default.jpg';
                                   }
                                   ?>
                                    <tr>
                                        <td><img src=<?php  echo $results->data[$i]['user_image']; ?> alt="Profile Photo" style="width:60px;height:60px;"></td>
                                        <td><?php echo $results->data[$i]['first_name']; ?></td>
                                        <td><?php echo $results->data[$i]['last_name']; ?></td>
                                        <td><?php echo $results->data[$i]['email']; ?></td>  
                                        <td><?php  echo "<a href='view.php?id=". $results->data[$i]['Id'] ."'>View details</a>"; ?></td>
                                        <td><?php  echo "<a href='update.php?id=".$results->data[$i]['Id']."'>Update User Info</a>"; ?></td>
                                        <td><?php  echo "<a href='update_image.php?id=".$results->data[$i]['Id']."'>Change Image</a>"; ?></td>
                                        <td><?php  echo "<a href=delete.php?id=".$results->data[$i]['Id']."'>Remove user</a>"; ?></td>  
                                    </tr>
                            <?php endfor; ?>                        
                        </tbody>
                </table>
                 <?php echo $Paginator->createLinks( $links, 'pagination pagination-sm' ); ?>
                </div>
        </div>
        </body>
</html>