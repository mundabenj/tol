<?php
class Layouts {
    public function header($conf) {
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="">
      <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
      <meta name="generator" content="Astro v5.13.2">
      <title><?php echo $conf['site_name']; ?></title>
      <link href="<?php echo $conf['site_url']; ?>/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
   </head>
<?php
    }
    public function navbar($conf) {
?>
   <body>

      <main>
         <div class="container py-4">
            <header class="pb-3 mb-4 border-bottom">
 <nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Fifth navbar example">
            <div class="container-fluid">
               <a class="navbar-brand" href="./"><?php echo $conf['site_name']; ?></a> <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample05" aria-controls="navbarsExample05" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button> 
               <div class="collapse navbar-collapse" id="navbarsExample05">
                  <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                     <li class="nav-item"> <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>" aria-current="page" href="./">Home</a> </li>
                     <li class="nav-item"> <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'signup.php') ? 'active' : ''; ?>" href="signup.php">Sign Up</a> </li>
                     <li class="nav-item"> <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'signin.php') ? 'active' : ''; ?>" href="signin.php">Sign In</a> </li>
                  </ul>
                  <form role="search"> <input class="form-control" type="search" placeholder="Search" aria-label="Search"> </form>
               </div>
            </div>
         </nav>
            </header>
<?php
    }

    public function banner($conf) {
        ?>
            <div class="p-1 mb-4 bg-body-tertiary rounded-3">
               <div class="container-fluid py-1">
                  <h1 class="display-5 fw-bold">Welcome to <?php echo $conf['site_name']; ?></h1>
                  <p class="col-md-8 fs-4">Using a series of utilities, you can create this jumbotron, just like the one in previous versions of Bootstrap.</p>
                  <button class="btn btn-primary btn-lg" type="button">Join Now</button> 
               </div>
            </div>
        <?php
    }
    public function content($conf) {
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
    public function form_content($conf, $ObjForm, $ObjFncs) {
        ?>
                <div class="row align-items-md-stretch">
               <div class="col-md-6">
                  <div class="h-100 p-5 text-bg-dark rounded-3">
<?php if(basename($_SERVER['PHP_SELF']) == 'signup.php') { $ObjForm->signup($conf, $ObjFncs); }else{ $ObjForm->signin($conf, $ObjFncs); } ?>
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
    public function footer($conf) {
?>

            <footer class="pt-3 mt-4 text-body-secondary border-top">
            <p>Copyrights &copy; <?php echo date("Y") . " {$conf['site_name']}. All rights reserved.</p>"; ?>
            </footer>
         </div>
      </main>
      <script src="<?php echo $conf['site_url']; ?>/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
   </body>
</html>

<?php
    }
}