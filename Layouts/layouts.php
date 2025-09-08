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
      <title>Jumbotron example · Bootstrap v5.3</title>
      <link href="https://getbootstrap.com/docs/5.3/dist/css/bootstrap.min.css" rel="stylesheet">
      <meta name="theme-color" content="#712cf9">
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
               <a class="navbar-brand" href="#">Expand at lg</a> <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample05" aria-controls="navbarsExample05" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button> 
               <div class="collapse navbar-collapse" id="navbarsExample05">
                  <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                     <li class="nav-item"> <a class="nav-link active" aria-current="page" href="./">Home</a> </li>
                     <li class="nav-item"> <a class="nav-link" href="signup.php">Sign Up</a> </li>
                     <li class="nav-item"> <a class="nav-link" href="signin.php">Sign In</a> </li>

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
            <div class="p-5 mb-4 bg-body-tertiary rounded-3">
               <div class="container-fluid py-5">
                  <h1 class="display-5 fw-bold">Custom jumbotron</h1>
                  <p class="col-md-8 fs-4">Using a series of utilities, you can create this jumbotron, just like the one in previous versions of Bootstrap. Check out the examples below for how you can remix and restyle it to your liking.</p>
                  <button class="btn btn-primary btn-lg" type="button">Example button</button> 
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
    public function form_content($conf, $ObjForm) {
        ?>
                <div class="row align-items-md-stretch">
               <div class="col-md-6">
                  <div class="h-100 p-5 text-bg-light rounded-3">
<?php if($_SERVER['PHP_SELF'] == '/tol/signup.php') { $ObjForm->signup(); }else{ $ObjForm->signin();} ?>
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
      <script src="https://getbootstrap.com/docs/5.3/dist/js/bootstrap.bundle.min.js" class="astro-vvvwv3sm"></script>
   </body>
</html>

<?php
    }
}