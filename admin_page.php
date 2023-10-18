<?php
require_once 'email.php';
include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin panel</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

      <style>
table {
  background-color: var(--color-white);
  width: 100%;
  padding: var(--card-padding);
  text-align: center;
  box-shadow: var(--box-shadow);
  border-radius: var(--card-border-radius);
  transition: all 0.3s ease;
}

table:hover {
  box-shadow: none;
}

table tbody td {
  height: 2.8rem;
  border-bottom: 1px solid var(--color-light);
  color: var(--color-dark-variant);
}

table tbody tr:last-child td {
  border: none;
}




 /* Style the reset button */
      #resetButton {
         background-color: #ff5555;
         color: #ffffff;
         padding: 20px 80px; /* Add more padding for spacing */
         border: none;
         cursor: pointer;
         font-size: 16px;
         border-radius: 5px;
         
      }
      #resetButton:hover {
         background-color: #ff0000;
      }


  </style>

</head>
<body>
   
<?php include 'admin_header.php'; ?>

   <h1 class="title">Analytics</h1>

<!-- admin dashboard section starts  -->


<!-- admin dashboard section ends -->
        <main>

            <!-- Analyses -->
            <div class="analyse">



                <div class="sales">
                    <div class="status">
                        <div class="info">
         <?php
            $total_completed = 0;
            $select_completed = mysqli_query($conn, "SELECT total_price FROM `orders` WHERE payment_status = 'completed'") or die('query failed');
            if(mysqli_num_rows($select_completed) > 0){
               while($fetch_completed = mysqli_fetch_assoc($select_completed)){
                  $total_price = $fetch_completed['total_price'];
                  $total_completed += $total_price;
               };
            };
         ?>        
         <h3>completed payments</h3>
         <h1>R<?php echo $total_completed; ?></h1>

                        </div>
 
                    </div>
                </div>




                <div class="sales">
                    <div class="status">
                        <div class="info">
         <?php
            $total_pendings = 0;
            $select_pending = mysqli_query($conn, "SELECT total_price FROM `orders` WHERE payment_status = 'pending'") or die('query failed');
            if(mysqli_num_rows($select_pending) > 0){
               while($fetch_pendings = mysqli_fetch_assoc($select_pending)){
                  $total_price = $fetch_pendings['total_price'];
                  $total_pendings += $total_price;
               };
            };
         ?>  
         <h3>total pendings</h3>
         <h1>R<?php echo $total_pendings; ?></h1>
                        </div>
                        
                    </div>
                </div>





                <div class="sales">
                    <div class="status">
                        <div class="info">
         <?php 
            $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'user'") or die('query failed');
            $number_of_users = mysqli_num_rows($select_users);
         ?>  
         <h3>normal users</h3>
         <h1><?php echo $number_of_users; ?></h1>

                        </div>
                        
                    </div>
                </div>


                                <div class="sales">
                    <div class="status">
                        <div class="info">
         <?php 
            $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'user'") or die('query failed');
            $number_of_users = mysqli_num_rows($select_users);
         ?>

         <h3>normal users</h3>
         <h1><?php echo $number_of_users; ?></h1>
         

                        </div>
                        
                    </div>
                </div>


                  <div class="sales">
                    <div class="status">
                        <div class="info">
         <?php 
            $select_admins = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'admin'") or die('query failed');
            $number_of_admins = mysqli_num_rows($select_admins);
         ?>  

         <h3>admin users</h3>
         <h1><?php echo $number_of_admins; ?></h1>


                        </div>
                       
                    </div>
                </div>









                 <div class="sales">
                    <div class="status">
                        <div class="info">
         <?php 
            $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
            $number_of_orders = mysqli_num_rows($select_orders);
         ?>
         <h3>order placed</h3>
         <h1><?php echo $number_of_orders; ?></h1>


                        </div>
                        
                    </div>
                </div>
            </div>

         </main>




<section class="messages">
<h1 class="title"> messages </h1>

<div class="box-container">
<table>
  <thead>
    <tr>
      <th>User ID</th>
      <th>Name</th>
      <th>Email</th>
      <th>Message</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $select_message = mysqli_query($conn, "SELECT * FROM `message`") or die('query failed');
      if(mysqli_num_rows($select_message) > 0){
        while($fetch_message = mysqli_fetch_assoc($select_message)){

          $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `users` WHERE id = '{$fetch_message['user_id']}'"));

    ?>
    <tr>
      <td><?= $fetch_message['user_id']; ?></td>
      <td><?= $user['name']; ?></td>
      <td><?= $user['email']; ?></td>
      <td><?= $fetch_message['message']; ?></td>
      
    </tr>
    <?php
        }
      }else{
        echo '<tr><td colspan="4">No messages yet!</td></tr>';
      }
    ?>
  </tbody>
</table>
</div>

</section>









<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>







</body>
</html>