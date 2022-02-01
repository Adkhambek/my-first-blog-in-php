<?php require_once("../Includes/DB.php"); ?>
<?php require_once("../Includes/Functions.php"); ?>
<?php require_once("../Includes/Sessions.php"); ?>
<?php 
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
Confirm_Login(); 
?>
<?php
$SearchQueryParameter = $_GET['id'];
// Fetching Existing Content according to our
       global $ConnectingDB;
       $sql  = "SELECT * FROM post WHERE id='$SearchQueryParameter'";
       $stmt = $ConnectingDB ->query($sql);
       while ($DataRows=$stmt->fetch()) {
         $TitleToBeDeleted    = $DataRows['title'];
         $CategoryToBeDeleted = $DataRows['category'];
         $ImageToBeDeleted    = $DataRows['image'];
         $PostToBeDeleted     = $DataRows['post'];
         // code...
       }
//echo $ImageToBeUpdated;

if(isset($_POST["Submit"])){
 //Query to Delete Post in DB 
 global $ConnectingDB;
 $sql="DELETE FROM post WHERE id='$SearchQueryParameter' ";   
    $Execute= $ConnectingDB->query($sql);
    
    //var_dump($Execute);
    if($Execute){
        $DELETE_Image = "../uploads/$ImageToBeDeleted";
        unlink($DELETE_Image);
      $_SESSION["SuccessMessage"]="Post Deleted Successfully";
      Redirect_to("table.php");
    }else {
      $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
      Redirect_to("table.php");
    }
  
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ADMIN: Post Delete</title>
      
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
             <a href="post.php" class="nav-link text-white font-weight-bold">Posts</a>   
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
          
        <h1> <i class="fas fa-cog"></i>Delete Post</h1>
        </div>
        
    </div>    
    </div>    
    </header> 
     <section class="my-3">
       <div class="container ">
         <div class="row">
           
             <div class="col-md-9 mx-auto">
              <div class="card ">
      <div class="card-header bg-primary text-white">Delete Existed Post</div>
         <div class="card-body">
             <?php
       echo ErrorMessage();
       echo SuccessMessage();
       
       ?>
             <form action="delete.php?id=<?php echo $SearchQueryParameter; ?>" method="post" enctype="multipart/form-data">
                  <div class="form-group">
                    <label class="font-weight-bold text-muted">Post title:</label>
                    <input type="text" name="PostTitle" disabled class="form-control  shadow-none" placeholder="Post Title" value="<?php echo $TitleToBeDeleted; ?>" >
                  </div>
                  <div class="form-group">
                      <span class="FieldInfo text-warning">Existed Category:</span>
                      <?php echo $CategoryToBeDeleted;?>
                      <br>
                    
                  </div>
                 <div class="form-group ">
                     <span class="FieldInfo text-warning">Existed Image:</span>
                      <img class="mb-2" src="../uploads/<?php echo $ImageToBeDeleted;?>" width="100px"; height="70px"; >
                   
                    
                  </div>
                 <div class="form-group">
                    <label class="font-weight-bold text-muted">Post body:</label>
                    <textarea disabled class="form-control" name="PostDescription" >
                      <?php echo $PostToBeDeleted;?>
                    </textarea>
                  </div>
                 
                <div class="row">
                 <div class="col-lg-6 mb-2">
                 <a href="post.php" class="btn btn-warning btn-block text-white"><i class="fas fa-arrow-left"></i> Back to Post</a>
                 </div> 
                 <div class="col-lg-6 mb-2">
                <button type="submit" name="Submit" class="btn btn-danger btn-block">
                     <i class="fas fa-trash"></i> Delete
                 </button>
                 </div>
                     </div>
                </form>        
                  
                  
                  
         </div>
    </div>
             </div>
           </div>
         </div>
     </section>
     
      
      
      
  </body>
</html>