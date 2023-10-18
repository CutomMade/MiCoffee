<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

   <div class="flex">

      <!--<a href="admin_page.php" class="logo">Admin<span>Panel</span></a>-->
      <img src="images/logo.png" alt="" style="max-width: 20%; height: auto;">

      <nav class="navbar">
         <a href="admin_page.php">Home</a>
         <a href="admin_products.php">Products</a>
         <a href="admin_orders.php">Orders</a>
         <a href="admin_users.php">Users</a>
         <a href="admin_contacts.php">Messages</a>
                  <a href="promotion.php">Promotions</a>
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="btn">Profile</div>
      </div>

      <div class="account-box">
         <p>Username : <span><?php echo $_SESSION['admin_name']; ?></span></p>
         <p>Email : <span><?php echo $_SESSION['admin_email']; ?></span></p>
         <a href="logout.php" class="delete-btn">Logout</a>
         </div>

   </div>

</header>