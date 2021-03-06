<?php
include "db_con.php";
session_set_cookie_params(3600,"/");
session_start();
if( !isset($_SESSION["user4l2"]) ){
  session_unset();
  session_destroy();
  header('Location:index.php');
  exit;
}

function ckxl( $string, $action = 'e' ) {
  $secret_key = $_SESSION['pass4l2'];
  $secret_iv = 'my_simple_secret_iv';
  $output = false;
  $encrypt_method = "AES-256-CBC";
  $key = hash( 'sha256', $secret_key );
  $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
  if( $action == 'e' ) {
    $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
  }
  else if( $action == 'd' ){
    $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
  }
  return $output;
}

$user_id = "";
$user_name = $_SESSION['user4l2'];
$user_entry_date = "";
$user_status = "Active";

try {
  $sth = $dbh->prepare("SELECT * FROM tbl_users WHERE username=? limit 0,1");
  $sth->execute(array(md5($_SESSION['user4l2'])));
  $result = [];
  while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
      $result[] = $row;
  }
  if(!$result) {
      header('Location:index.php');
      exit;
  };
  $user_id = $result[0]['user_id'];
  $user_entry_date = $result[0]['entry_date'];
} catch (PDOException $e) {
  log_error("Failed to select user", $e->getMessage(), $e->getCode(), array('exception' => $e));
  session_unset();
  session_destroy();
  header('Location:index.php');
}  
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title>Account Management System V4</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sticky-footer-navbar.css" rel="stylesheet">
  </head>

  <body>

    <header>
      <!-- Fixed navbar -->
      <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="#">Welcome</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link"><?php echo($_SESSION["user4l2"]); ?> <span class="sr-only">(current)</span></a>
            </li>
          </ul>
          <form class="form-inline mt-2 mt-md-0" method="GET" action="logout.php">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Logout</button>
          </form>
        </div>
      </nav>
    </header>

    <!-- Begin page content -->
    <main role="main" class="container">
      <h1 class="mt-5">User Profile:</h1>
      <p class="lead">
        <div class="row">
          <div class="col-4 text-right">ID:</div>
          <div class="col-8 text-left"><?php echo($user_id); ?></div>
        </div>
        <div class="row">
          <div class="col-4 text-right">Username:</div>
          <div class="col-8 text-left"><?php echo($user_name); ?></div>
        </div>
        <div class="row">
          <div class="col-4 text-right">Entry Date:</div>
          <div class="col-8 text-left"><?php echo($user_entry_date); ?></div>
        </div>
        <div class="row">
          <div class="col-4 text-right">Status:</div>
          <div class="col-8 text-left"><?php echo($user_status); ?></div>
        </div>
        <div class="row">
          <div class="col-4 text-right">Flag:</div>
          <div class="col-8 text-left">
          <?php if(ckxl("cWtsWXd5a1R0WEFwbm0xZHZndHFaSnBlVUxYQ0o1YTM1NjBkRTMyd3ZYYVd2NktuMkVHMGZmWnpneUVtR3RaOQ==", 'd')){
            echo(ckxl("cWtsWXd5a1R0WEFwbm0xZHZndHFaSnBlVUxYQ0o1YTM1NjBkRTMyd3ZYYVd2NktuMkVHMGZmWnpneUVtR3RaOQ==", 'd'));
          } else if(ckxl("QmVyTXdzQkVnQkJDNWhjZzN5TEQ0bkNNT0hjMGoya1Z3aFl0bXc2RmlCdnR3WUIydGtJUFoyZmNNSjFid2tXSQ==", 'd')){
            echo(ckxl("QmVyTXdzQkVnQkJDNWhjZzN5TEQ0bkNNT0hjMGoya1Z3aFl0bXc2RmlCdnR3WUIydGtJUFoyZmNNSjFid2tXSQ==", 'd'));
          } 
          ?>
          </div>
        </div>
      </p>
      <p class="lead"></p>
    </main>

    <footer class="footer">
      <div class="container">
        <span class="text-muted"></span>
      </div>
    </footer>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery-3.3.1.slim.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/jquery-slim.min.js"><\/script>')</script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

  </body>
</html>
