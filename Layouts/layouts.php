<?php
class layouts {
    public function header() {
         global $conf;
        ?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="<?php print $conf['site_title']; ?>">
      <meta name="author" content="<?php print implode(', ', $conf['site_authors']); ?>">
      <meta name="generator" content="<?php print $conf['version']; ?>">
      <title><?php print $conf['site_title']; ?></title>
      <link href="<?php print $conf['site_url']; ?>css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
   </head>
   <body>
      <main>
         <div class="container py-4">
        <?php
    }
    public function navbar() {
         global $conf, $ObjFncs;
         ?>
         <nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Fifth navbar example">
            <div class="container-fluid">
               <a class="navbar-brand" href="<?php print $ObjFncs->home_url(); ?>"><?php print $conf['site_name']; ?></a> <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample05" aria-controls="navbarsExample05" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button> 
               <div class="collapse navbar-collapse" id="navbarsExample05">
                  <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                     <li class="nav-item"> <a class="nav-link <?php if(basename($_SERVER['PHP_SELF']) == 'index.php') print 'active'; ?>" aria-current="page" href="<?php print $ObjFncs->home_url(); ?>">Home</a> </li>
                     <?php if(isset($_SESSION['consort']) && $_SESSION['consort'] === true) { ?>
                     <li class="nav-item"> <a class="nav-link <?php if(basename($_SERVER['PHP_SELF']) == 'dashboard.php') print 'active'; ?>" href="dashboard.php">Dashboard</a> </li>
                     <li class="nav-item"> <a class="nav-link" href="?signout">Sign out</a> </li>
                     <?php } else { ?>
                     <li class="nav-item"> <a class="nav-link <?php if(basename($_SERVER['PHP_SELF']) == 'signup.php') print 'active'; ?>" href="signup.php">Sign Up</a> </li>
                     <li class="nav-item"> <a class="nav-link <?php if(basename($_SERVER['PHP_SELF']) == 'signin.php') print 'active'; ?>" href="signin.php">Sign In</a> </li>
                     <?php } ?>
                  </ul>
                  <form role="search"> <input class="form-control" type="search" placeholder="Search" aria-label="Search"> </form>
               </div>
            </div>
         </nav>
    <?php
                  }
public function banner() {
         global $conf;
        ?>
            <div class="p-1 mb-4 bg-body-tertiary rounded-3">
               <div class="container-fluid py-1">
                  <h1 class="display-5 fw-bold">Welcome to <?php print $conf['site_name']; ?></h1>
                  <h2 class="display-5"><?php print $conf['site_slogan']; ?></h2>
                  <p class="col-md-8 fs-4">Check out the examples below for how you can remix and restyle it to your liking.</p>
                  <button class="btn btn-primary btn-lg" type="button">Join now</button> 
               </div>
            </div>
        <?php
    }
public function content() {
         global $conf;
        ?>
            <div class="row align-items-md-stretch">
               <div class="col-md-6">
                  <div class="h-100 p-5 text-bg-dark rounded-3">
                     <h2>Change the background</h2>
                     <p>Swap the background-color utility and add a `.text-*` color utility to mix up the jumbotron look. Then, mix and match with additional component themes and more.</p>
                     <button class="btn btn-outline-light" type="button">Example button</button> 
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="h-100 p-5 bg-body-tertiary border rounded-3">
                     <h2>Add borders</h2>
                     <p>Or, keep it light and add a border for some added definition to the boundaries of your content. Be sure to look under the hood at the source HTML here as we've adjusted the alignment and sizing of both column's content for equal-height.</p>
                     <button class="btn btn-outline-secondary" type="button">Example button</button> 
                  </div>
               </div>
            </div>
        <?php
    }
    public function form_content() {
         global $conf, $ObjForm, $ObjFncs;
        ?>
            <div class="row align-items-md-stretch">
               <div class="col-md-6">
                  <div class="h-100 p-5 text-bg-dark rounded-3">
                     <?php if(basename($_SERVER['PHP_SELF']) == 'signup.php') {$ObjForm->signup(); } elseif(basename($_SERVER['PHP_SELF']) == 'signin.php') {$ObjForm->signin(); } elseif(basename($_SERVER['PHP_SELF']) == 'verify_code.php') {$ObjForm->verify_code(); } elseif(basename($_SERVER['PHP_SELF']) == 'forgot_password.php')  {$ObjForm->forgot_password(); } elseif(basename($_SERVER['PHP_SELF']) == 'change_password.php')  {$ObjForm->change_password(); } ?>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="h-100 p-5 bg-body-tertiary border rounded-3">
                     <h2>Add borders</h2>
                     <p>Or, keep it light and add a border for some added definition to the boundaries of your content. Be sure to look under the hood at the source HTML here as we've adjusted the alignment and sizing of both column's content for equal-height.</p>
                     <button class="btn btn-outline-secondary" type="button">Example button</button> 
                  </div>
               </div>
            </div>
        <?php
    }
    public function footer() {
         global $conf;
        ?>
            <footer class="pt-3 mt-4 text-body-secondary border-top">
              <p>Copyright &copy; <?php print date("Y"); ?> <?php print $conf['site_name']; ?> - All Rights Reserved</p> 
            </footer>
         </div>
      </main>
      <script src="<?php print $conf['site_url']; ?>js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
   </body>
</html>
        <?php
    }
}