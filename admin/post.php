<?php require_once("../Includes/DB.php"); ?>
<?php require_once("../Includes/Functions.php"); ?>
<?php require_once("../Includes/Sessions.php"); ?>
<?php 
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];

Confirm_Login(); ?>
<?php
if(isset($_POST["Submit"])){ 
 $PostTitle=$_POST["PostTitle"];  
 $Category=$_POST["Category"];
 $Image = $_FILES["Image"]["name"];
$Target = "../uploads/".basename($_FILES["Image"]["name"]);
 $PostText = $_POST["PostDescription"];
 
 //date
    
    date_default_timezone_set("Asia/Tashkent");
    $CurrentTime=time();
    $DateTime=strftime("%d-%m-%Y %H:%M:%S",$CurrentTime);
    
// Error & Success
    
    if(empty($PostTitle)){
        $_SESSION["ErrorMessage"]= "Title cannot be empty";
        Redirect_to("post.php");
    }elseif(strlen($PostTitle)<5){
     $_SESSION["ErrorMessage"]= "Post title should be greater than 5 characters";
        Redirect_to("post.php");   
    }elseif(strlen($PostText)>10000){
     $_SESSION["ErrorMessage"]= "Post discription should be less than 10000 characters";
        Redirect_to("post.php");   
    }else{
        //Query to insert Post in DB When everything is fine
        $sql = "INSERT INTO post(datetime,title,category,image,post)";
        $sql .= "VALUES(:dateTime,:postTitle,:categoryName,:imageName,:postDescription)";
        $stmt = $ConnectingDB->prepare($sql);
        $stmt->bindValue(':dateTime',$DateTime);
        $stmt->bindValue(':postTitle',$PostTitle);
        $stmt->bindValue(':categoryName',$Category);
        $stmt->bindValue(':imageName',$Image);
        $stmt->bindValue(':postDescription',$PostText);
        $Execute=$stmt->execute();
        
        move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
        
        if($Execute){
            $_SESSION["SuccessMessage"]="Post Added Successfully";
            Redirect_to("post.php");
        }else{
         $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
        Redirect_to("post.php");     
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
    <title>BEKBLOG: Admin Post</title>
      
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
             <li class="nav-item"><a href="logout.php" class="nav-link text-white font-weight-bold"><i class="fas fa-power-off"></i> Logout</a></li>
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
  <a href="post.php" class="list-group-item list-group-item-action active">
    <i class="fas fa-edit"></i> New post
  </a>
  <a href="category.php" class="list-group-item list-group-item-action"><i class="fas fa-folder-plus"></i> Adding category</a>
  <a href="table.php" class="list-group-item list-group-item-action"><i class="fas fa-table"></i> Published posts</a>

</div>
             </div>
             <div class="col-md-9">
              <div class="card ">
      <div class="card-header bg-primary text-white">Adding New Post</div>
         <div class="card-body">
             <?php
         echo ErrorMessage();
         echo SuccessMessage();
         ?>
             <form action="post.php" method="post" enctype="multipart/form-data">
                  <div class="form-group">
                    <label class="font-weight-bold text-muted">Post title:</label>
                    <input type="text" name="PostTitle" class="form-control  shadow-none" placeholder="Post Title" >
                  </div>
                  <div class="form-group">
                    <label class="font-weight-bold text-muted">Categories:</label>
                      <select class="form-control shadow-none" name="Category">
                       <?php 
                       //Fetching all the categories 
                          
                          $ConnectingDB; 
                          $sql= "SELECT id,title FROM category";
                          $stmt= $ConnectingDB->query($sql);
                          while($DateRows= $stmt->fetch()){
                              $Id = $DateRows["id"];
                              $CategoryName = $DateRows["title"];
                          
                       ?>
                          <option><?php echo $CategoryName ?></option>
                          <?php } ?>
                      </select>
                  </div>
                 <div class="form-group">
                   <div class="custom-file">
                 <input class="custom-file-input shadow-none" type="File" name="Image" id="imageSelect" value="">
                     <label for="imageSelect" class="custom-file-label">Select Image</label>
                 </div>
                    
                  </div>
                 <div class="form-group">
                    <label class="font-weight-bold text-muted">Post body:</label>
                    <textarea class="" name="PostDescription" id="postbody"></textarea>
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