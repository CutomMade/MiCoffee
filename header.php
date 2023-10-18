<?php
include 'config.php';
require_once 'email.php';
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

 

<header class="header" >

 

 

   <div class="header-2">
<div class="flex">

 

<div class="nuts" style="width: 20%; text-align: center; margin: auto;">
<img src="images/logo.png" alt="" style="max-width: 100%; height: auto;">
</div>
<nav class="navbar">
<a href="home.php">Home</a>
<a href="about.php">About</a>
<a href="shop.php">Menu</a>
<a href="contact.php">Contact Us</a>
<a href="orders.php">Order history</a>
<a href="user_promotion.php">Promotions</a>
</nav>

 

         <div class="icons">
<div id="menu-btn" class="fas fa-bars"></div>
<a href="search_page.php" class="fas fa-search"></a>
<div id="user-btn" class="btn">Profile</div>
<?php
               $select_cart_number = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
               $cart_rows_number = mysqli_num_rows($select_cart_number); 
            ?>
<a href="cart.php" class="btn">Cart<span>(<?php echo $cart_rows_number; ?>)</span> </a>
</div>

 

         <div class="user-box">
<p>username : <span><?php echo $_SESSION['user_name']; ?></span></p>
<p>email : <span><?php echo $_SESSION['user_email']; ?></span></p>
<a href="logout.php" class="delete-btn">logout</a>
</div>
</div>
</div>

 

</header>