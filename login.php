<?php
//3
include 'config.php';
session_start();
// $_SESSION
// suppose we want to store the infromation temperorly on the server we use session
//usually used on login pages when the user logs in it will be active and when logs out it willl be destroyed
//3 steps
//session_start
//$_SESSION['NAME']=VALUE
//to show this we use echo'$_session['name'];
// to delete the session 2 steps
//session_unset --- destroys all the variables that were assigned while cretaing session
//session_destroy --destroys the session
if(isset($_POST['submit'])){
    //super variables are the varaibles suppose we create a file1.php and define and assign a varaible here 
    // and we want to acess that in another file suppose file2.php then we make use of super varaibles
    //  ----- $_GET we use this variable when we want to show the data which we enter while logging in on the url usuallly used during searching something
    //------- $_POST same as get but doesnt show the information on the url is used to maintain secrecy of data which we enter
    
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
//mysqli_escape is used to escape sepcial characters
    //md5 is an algorithm which converts the pass to hexadeciaml cagarcters
   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select_users) > 0){

      $row = mysqli_fetch_assoc($select_users);

      if($row['user_type'] == 'admin'){

         $_SESSION['admin_name'] = $row['name'];
         $_SESSION['admin_email'] = $row['email'];
         $_SESSION['admin_id'] = $row['id'];
         header('location:admin_page.php');

      }elseif($row['user_type'] == 'user'){

         $_SESSION['user_name'] = $row['name'];
         $_SESSION['user_email'] = $row['email'];
         $_SESSION['user_id'] = $row['id'];
         header('location:home.php');

      }

   }else{
      $message[] = 'incorrect email or password!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

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
   
<div class="form-container">

   <form action="" method="post">
      <h3>login now</h3>
      <input type="email" name="email" placeholder="enter your email" required class="box">
      <input type="password" name="password" placeholder="enter your password" required class="box">
      <input type="submit" name="submit" value="login now" class="btn">
      <p>don't have an account? <a href="register.php">register now</a></p>
   </form>

</div>

</body>
</html>