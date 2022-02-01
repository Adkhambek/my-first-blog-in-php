<?php require_once("../Includes/DB.php"); ?>
<?php require_once("../Includes/Functions.php"); ?>
<?php require_once("../Includes/Sessions.php"); ?>
<?php 


?>
<?php
$SearchQueryParameter = $_GET['id'];
if(isset($_POST["Submit"])){
  $PostTitle = $_POST["PostTitle"];
  $Category  = $_POST["Category"];
  $Image     = $_FILES["Image"]["name"];
  $Target    = "../uploads/".basename($_FILES["Image"]["name"]);
  $PostText  = $_POST["PostDescription"];
  
  date_default_timezone_set("Asia/Tashkent");
  $CurrentTime = time();
  $DateTime    = strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);

  if(empty($PostTitle)){
    $_SESSION["ErrorMessage"]= "Title Cant be empty";
    Redirect_to("edit.php");
  }elseif (strlen($PostTitle)<5) {
    $_SESSION["ErrorMessage"]= "Post Title should be greater than 5 characters";
    Redirect_to("edit.php");
  }elseif (strlen($PostText)>9999) {
    $_SESSION["ErrorMessage"]= "Post Description should be less than than 1000 characters";
    Redirect_to("edit.php");
  }else{
    // Query to Update Post in DB When everything is fine
    global $ConnectingDB;
    if (!empty($_FILES["Image"]["name"])) {
      $sql = "UPDATE post
              SET title='$PostTitle', category='$Category', image='$Image', post='$PostText'
              WHERE id='$SearchQueryParameter'";
    }else {
      $sql = "UPDATE post
              SET title='$PostTitle', category='$Category', post='$PostText'
              WHERE id='$SearchQueryParameter'";
    }
    $Execute= $ConnectingDB->query($sql);
    move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
    //var_dump($Execute);
    if($Execute){
      $_SESSION["SuccessMessage"]="Post Updated Successfully";
      Redirect_to("table.php");
    }else {
      $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
      Redirect_to("table.php");
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
    <title>ADMIN: Post Edit</title>
      
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
          
        <h1> <i class="fas fa-cog"></i>Edit Post</h1>
        </div>
        
    </div>    
    </div>    
    </header> 
     <section class="my-3">
       <div class="container ">
         <div class="row">
           
             <div class="col-md-9 mx-auto">
              <div class="card ">
      <div class="card-header bg-primary text-white">Editing Existed Post</div>
         <div class="card-body">
             <?php
       echo ErrorMessage();
       echo SuccessMessage();
       // Fetching Existing Content according to our
       global $ConnectingDB;
       $sql  = "SELECT * FROM post WHERE id='$SearchQueryParameter'";
       $stmt = $ConnectingDB ->query($sql);
       while ($DataRows=$stmt->fetch()) {
         $TitleToBeUpdated    = $DataRows['title'];
         $CategoryToBeUpdated = $DataRows['category'];
         $ImageToBeUpdated    = $DataRows['image'];
         $PostToBeUpdated     = $DataRows['post'];
         // code...
       }
       ?>
             <form action="edit.php?id=<?php echo $SearchQueryParameter; ?>" method="post" enctype="multipart/form-data">
                  <div class="form-group">
                    <label class="font-weight-bold text-muted">Post title:</label>
                    <input type="text" name="PostTitle" class="form-control  shadow-none" placeholder="Post Title" value="<?php echo $TitleToBeUpdated; ?>" >
                  </div>
                  <div class="form-group">
                      <span class="FieldInfo text-warning">Existed Category:</span>
                      <?php echo $CategoryToBeUpdated;?>
                      <br>
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
                     <span class="FieldInfo text-warning">Existed Image:</span>
                      <img class="mb-2" src="../uploads/<?php echo $ImageToBeUpdated;?>" width="100px"; height="70px"; >
                   <div class="custom-file">
                 <input class="custom-file-input shadow-none" type="File" name="Image" id="imageSelect" value="">
                     <label for="imageSelect" class="custom-file-label">Select Image</label>
                 </div>
                    
                  </div>
                 <div class="form-group">
                    <label class="font-weight-bold text-muted">Post body:</label>
                    <textarea class="" name="PostDescription" id="postbody">
                      <?php echo $PostToBeUpdated;?>
                    </textarea>
                  </div>
                 <div class="row">
                 <div class="col-lg-6 mb-2">
                 <a href="post.php" class="btn btn-warning btn-block text-white"><i class="fas fa-arrow-left"></i> Back to Post</a>
                 </div> 
                 <div class="col-lg-6 mb-2">
                <button type="submit" name="Submit" class="btn btn-primary btn-block">
                     <i class="fas fa-check"></i> Publish
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