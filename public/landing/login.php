<?php
require_once('../../private/config/initialize.php');

use App\Repository\UserRepository;

$errors = [];
$username = '';
$password = '';

if(is_post_request()) {

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if(is_blank($username)) {
        $errors[] = "Username cannot be blank.";
    }
    if(is_blank($password)) {
        $errors[] = "Password cannot be blank.";
    }

    if(empty($errors)) {
        $userRepository = new UserRepository();
        $user = $userRepository->findByUsername($username);

        if($user && password_verify($password, $user->hashedPassword)) {
            $session->login($user);
            redirect_to(url_for('/landing/index.php'));
        } else {
            $errors[] = "Log in was unsuccessful.";
        }
    }
}

?>

<?php $page_title = 'Log in'; ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Workable Data | Login</title>

    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <!-- Workable Data CSS -->
<link href="../css/wd_grid.css" rel="stylesheet">


</head>
<body>

  <div class="container_public">
  
    
    <div class="wd_grid_public_head1">
      <img class="wd_logo_header_long" src="../logo/Logo-01_small.jpg">
      
    </div>
    
    <div class="wd_grid_public_head_info">
      Welcome: Guest
    </div>


    <div class="wd_grid_public_head1_right">
        <a class="button_login" href="<?php echo url_for('/index.html'); ?>">
          <button type="button">Public Page</button>
        </a>
      
    </div>
    
    <div class="wd_grid_public_body_upper">
     
       <h1>Log in</h1>

            <?php echo display_errors($errors); ?>

            <form action="login.php" method="post">
              Username:<br />
              <input type="text" name="username" value="<?php echo h($username); ?>" /><br />
              Password:<br />
              <input type="password" name="password" value="" /><br />
              <input type="submit" name="submit" value="Submit"  />
            </form>
 
    </div>

    <div class="wd_grid_public_body_left">
      <p>Contact Workable Data if you need login credentials</p>

           
    </div>
    
     <div class="wd_grid_public_body_right">
              
            
      </div>
    

    <footer class="wd_grid_public_footer">
      &copy; <?php echo date('Y'); ?> - Footer information - Contact: info@workabledata.com
    </footer>
  
  </div>




  </body>
</html>


