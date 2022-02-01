<?php require_once("../Includes/DB.php"); ?>
<?php require_once("../Includes/Functions.php"); ?>
<?php require_once("../Includes/Sessions.php"); ?>
<?php 
Confirm_Login(); 
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
?>
<?php 
if(isset($_POST["Submit"])){
    $Category=$_POST["Title"];
    //datetime
     date_default_timezone_set("Asia/Tashkent");
    $CurrentTime=time();
    $DateTime=strftime("%d-%m-%Y %H:%M:%S",$CurrentTime);
    //Session
    if(empty($Category)){
        $_SESSION["ErrorMessage"]= "All fields must be filled out";
        Redirect_to("category.php");
    }elseif (strlen($Category)<3){
       $_SESSION["ErrorMessage"]= "Category title should be greater than 2 characters";
        Redirect_to("category.php");  
    }elseif (strlen($Category)>21){
       $_SESSION["ErrorMessage"]= "Category title should be less than 20 characters";
        Redirect_to("category.php");  
    }else{
        //Query to insert category in DB When everything is fine
        $sql = "INSERT INTO category(title,datetime)";
        $sql .= "VALUES(:categoryName,:dateTime)";
        $stmt = $ConnectingDB->prepare($sql);
        $stmt->bindValue(':categoryName',$Category);
        $stmt->bindValue(':dateTime',$DateTime);
        $Execute=$stmt->execute();
        
        if($Execute){
            $_SESSION["SuccessMessage"]="This category Added Successfully";
            Redirect_to("category.php");
        }else{
         $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
        Redirect_to("category.php");     
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
    <title>BEKBLOG: Admin Category</title>
      
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
            <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarcollapseCMS">
            <ul class="navbar-nav mr-auto">
             
              <li class="nav-item">
             <a href="#" class="nav-link text-white font-weight-bold">Dashboard</a>   
             </li>
                <li class="nav-item">
             <a href="#" class="nav-link text-white font-weight-bold">Posts</a>   
             </li>
                
                 <li class="nav-item">
             <a href="#" class="nav-link text-white font-weight-bold">Admins</a>   
             </li>
                <li class="nav-item">
             <a href="#" class="nav-link text-white font-weight-bold">Comments</a>   
             </li>
                <li class="nav-item">
             <a href="#" class="nav-link text-white font-weight-bold">Live Blog</a>   
             </li>
                
            </ul>
            <ul class="navbar-nav ml-auto">
             <li class="nav-item"><a href="#" class="nav-link text-white font-weight-bold"><i class="fas fa-power-off"></i> Logout</a></li>
            </ul>
                </div>
        </div>
    
        </nav>
<header class="bg-dark text-white py-3">
    <div class="container">
    <div class="row">
        <div class="col-md-12">
          
        <h1> <i class="fas fa-cog"></i> Posts</h1>
        </div>
        
    </div>    
    </div>    
    </header> 
     <section class="my-3">
       <div class="container">
         <div class="row">
           <div class="col-md-3 mb-2">

               
<div class="list-group">
  <a href="post.php" class="list-group-item list-group-item-action ">
    <i class="fas fa-edit"></i> New post
  </a>
  <a href="category.php" class="list-group-item list-group-item-action active"><i class="fas fa-folder-plus"></i> Adding category</a>
  <a href="table.php" class="list-group-item list-group-item-action"><i class="fas fa-table"></i> Published posts</a>

</div>
             </div>
             <div class="col-md-9">
              <div class="card ">
      <div class="card-header bg-primary text-white">Adding New Category</div>
         <div class="card-body">
             <?php 
             echo ErrorMessage();
             echo SuccessMessage();
             ?>
             <form class="" action="category.php" method="post">
                  <div class="form-group">
                    <label class="font-weight-bold text-muted">Category title:</label>
                    <input type="text" name="Title" class="form-control  shadow-none" placeholder="Type here" >
                  </div>
                  
                <button type="submit" name="Submit" class="btn btn-primary">
                     <i class="fas fa-check"></i> Publish
                 </button>
                </form>        
                  
                  
                  
         </div>
    </div>
             </div>
           </div>
         </div>
     </section>
     
  </body>
</html>