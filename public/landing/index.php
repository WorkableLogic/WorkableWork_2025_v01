<?php
require_once('../../private/config/initialize.php');

use App\Repository\LocentRepository;

if(!$session->isLoggedIn()) {
    redirect_to(url_for('/landing/login.php'));
}

$locentRepository = new LocentRepository();
$locents = $locentRepository->findForUser($session->getUserId());

?>

<?php $page_title = 'Dashboard'; ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Workable Data | Dashboard</title>

    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <!-- Workable Data CSS -->
    <link href="../css/wd_grid.css" rel="stylesheet">
    <link href="../css/wd_style.css" rel="stylesheet">
    

</head>
<body>

  <div class="container_public">
  
    
    <div class="wd_grid_public_head1">
      <img class="wd_logo_header_long" src="../logo/Logo-01_small.jpg">
      
    </div>
    
    <div class="wd_grid_public_head_info">
      Logged in: <h3><?php echo h($session->getUsername()); ?></h3>
    </div>


    <div class="wd_grid_public_head1_right">
        <a class="button_login" href="<?php echo url_for('/landing/logout.php'); ?>">
          <button type="button">Logout</button>
        </a>
      
    </div>
    
    <div class="wd_grid_public_body_upper">
     
       <h1>Dashboard</h1>

        <div class="landing_card-container">
            <?php foreach($locents as $locent): ?>
                <div class="landing_card" onclick="window.location.href='<?php echo url_for('/landing/set_locent.php?id=' . h($locent->id) . '&name=' . urlencode(h($locent->name)) . '&page=' . urlencode($locent->page)); ?>'">
                    <h3><?php echo h($locent->name); ?></h3>
                </div>
            <?php endforeach; ?>
        </div>
 
    </div>

    <div class="wd_grid_public_body_left">
      <p>Select a location to continue.</p>

           
    </div>
    
     <div class="wd_grid_public_body_right">
              
            
      </div>
    

    <footer class="wd_grid_public_footer">
      &copy; <?php echo date('Y'); ?> - Footer information - Contact: info@workabledata.com
    </footer>
  
  </div>




  </body>
</html>
