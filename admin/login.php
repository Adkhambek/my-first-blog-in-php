<?php require_once("../Includes/DB.php"); ?>
<?php require_once("../Includes/Functions.php"); ?>
<?php require_once("../Includes/Sessions.php"); ?>
<?php
if(isset($_SESSION["UserId"])){
  Redirect_to("Dashboard.php");
}
if (isset($_POST["Submit"])) {
  $Username = $_POST["Username"];
  $Password = $_POST["Password"];
  if (empty($Username)||empty($Password)) {
    $_SESSION["ErrorMessage"]= "All fields must be filled out";
    Redirect_to("Login.php");
  }else {
    // code for checking username and password from Database
    $Found_Account=Login_Attampt($Username, $Password);
    if($Found_Account){
        $_SESSION["UserId"]=$Found_Account["id"];
        $_SESSION["UserName"]=$Found_Account["username"];
        $_SESSION["SuccessMessage"]= "Welcom ".$_SESSION["UserName"]."!";
        
        if (isset($_SESSION["TrackingURL"])) {
        Redirect_to($_SESSION["TrackingURL"]);
      }else{
      Redirect_to("Dashboard.php");
    }
    } else{
        $_SESSION["ErrorMessage"]="Incorrect Username/Password";
        Redirect_to("login.php");
    }     
          
  }
}



?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ADMIN LOGIN</title>
      
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css" >
    <script src="../js/jquery-3.4.1.slim.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script> 
     
     <!-- fontawesome -->
      <script src="https://kit.fontawesome.com/8c685f9586.js" crossorigin="anonymous"></script>
    
  </head>
    
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark text-white bg-primary">
        <div class="container">
        <a href="#" class="navbar-brand font-weight-bold">BEKBLOG ADMIN</a>
        </div>
      </nav>
     <section class="mt-5">
       <div class="container ">
         <div class="row">
           
             <div class="col-md-6 mx-auto ">
              <div class="card rounded-0">
      <div class="card-header bg-primary text-white rounded-0">LOGIN</div>
         <div class="card-body">
             <?php
           echo ErrorMessage();
           echo SuccessMessage();
           ?>
             <form action="login.php" method="post">
                 <div class="form-group">
                  <label for="username"><span class="FieldInfo">Username:</span></label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text text-white bg-primary"> <i class="fas fa-user"></i> </span>
                    </div>
                    <input type="text" class="form-control shadow-none rounded-0" name="Username" id="username" value="">
                  </div>
                </div>
                <div class="form-group">
                  <label for="password"><span class="FieldInfo">Password:</span></label>
                  <div class="input-group mb-4">
                    <div class="input-group-prepend">
                      <span class="input-group-text text-white bg-primary"> <i class="fas fa-lock"></i> </span>
                    </div>
                    <input type="password" class="form-control shadow-none rounded-0" name="Password" id="password" value="">
                  </div>
                </div> 
                 
                <input type="submit" name="Submit" class="btn btn-primary shadow-none rounded-0" value="Kirish">
                 
                </form>        
                  
                  
                  
         </div>
    </div>
             </div>
           </div>
         </div>
     </section>
     
      <script src="../js/ckeditor.js"></script> 
      <script>
      ClassicEditor
    .create( document.querySelector( '#postbody' ), {
        toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ],
        heading: {
            options: [
                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' }
            ]
        }
    } )
    .catch( error => {
        console.log( error );
    } );
      </script>
  </body>
</html>