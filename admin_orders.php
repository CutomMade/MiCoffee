<?php
require_once 'email.php';
include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

if(isset($_POST['update_order'])){

   $order_update_id = $_POST['order_id'];
   $update_payment = $_POST['update_payment'];
   mysqli_query($conn, "UPDATE `orders` SET payment_status = '$update_payment' WHERE id = '$order_update_id'") or die('query failed');
   $message[] = 'payment status has been updated!';

}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `orders` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_orders.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Orders</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

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

<section class="orders">

  <h1 class="title">Order History</h1>

  <div class="box-container">
<table>
  <thead>
    <tr>
      <th>User ID</th>
      <th>Placed on</th>
      <th>Name</th>
      <th> Order Number</th>
      <th>Email</th>
      <th>Total products</th>
      <th>Total price</th>
      <th>Payment method</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
  <?php
    $select_orders = mysqli_query($conn, "SELECT * FROM `orders`ORDER BY id DESC") or die('query failed');
    if(mysqli_num_rows($select_orders) > 0){
      while($fetch_orders = mysqli_fetch_assoc($select_orders)){

        $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `users` WHERE id = '{$fetch_orders['user_id']}'"));
        ?>
        <tr>
          <td><?= $fetch_orders['user_id']; ?></td>
          <td><?= $fetch_orders['placed_on']; ?></td>
          <td><?= $user['name']; ?></td>
          <td><?= $fetch_orders['Order_Number']; ?></td>
          <td><?= $user['email']; ?></td>
          <td><?= $fetch_orders['total_products']; ?></td>
          <td>R<?= $fetch_orders['total_price']; ?></td>
          <td><?= $fetch_orders['method']; ?></td>
          <td>
            <form action="" method="post">
              <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
              <select name="update_payment">
                <option value="" selected disabled><?= $fetch_orders['payment_status']; ?></option>
                <option value="pending">Order Pending</option>
                
                <option value="45 mins">45 mins till order made</option>
                
                <option value="30 mins">30 mins till ready</option>
                
                <option value="15 mins">15 mins</option>
                
                <option value="completed">Ready!</option>
              </select>
              <input type="submit" value="Update" name="update_order" class="option-btn">
              <a href="admin_orders.php?delete=<?= $fetch_orders['id']; ?>" onclick="return confirm('Delete this order?');" class="delete-btn">Delete</a>
            </form>
          </td>
        </tr>
        <?php
      }
    } else {
      echo '<tr><td colspan="8">No orders placed yet!</td></tr>';
    }
    ?>
  </tbody>
</table>
  </div>

</section>




<script src="js/admin_script.js"></script>



</body>
</html>
