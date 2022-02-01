<?php require_once("../Includes/DB.php"); ?>
<?php require_once("../Includes/Functions.php"); ?>
<?php require_once("../Includes/Sessions.php"); ?>
<?php 
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
Confirm_Login(); 
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BEKBLOG: Admin Table</title>
      
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css" >
    <script src="../js/jquery-3.4.1.slim.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script> 
     
     <!-- fontawesome -->
      <script src="https://kit.fontawesome.com/8c685f9586.js" crossorigin="anonymous"></script>
      
    <!-- DataTable -->
     <link rel="stylesheet" href="../css/dataTables.bootstrap4.min.css"> 
      <script src="../js/jquery.dataTables.min.js"></script>
      <script src="../js/dataTables.bootstrap4.min.js"></script>
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
             <a href="#" class="nav-link text-white font-weight-bold">Users</a>   
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
  <a href="category.php" class="list-group-item list-group-item-action "><i class="fas fa-folder-plus"></i> Adding category</a>
  <a href="table.php" class="list-group-item list-group-item-action active"><i class="fas fa-table"></i> Published posts</a>

</div>
             </div>
             <div class="col-md-9">
              <div class="card ">
      <div class="card-header bg-primary text-white">Published Posts Table</div>
         <div class="card-body">
             <?php
         echo ErrorMessage();
         echo SuccessMessage();
         ?>
               <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Title</th>
                <th>Banner</th>
                <th>Action</th>
                
            </tr>
        </thead>
              
        <tbody>
             
            <?php
            $ConnectingDB;
            $sql = "SELECT* FROM post";
            $stmt= $ConnectingDB -> query($sql);
            $Sr = 0;
            
            while ($DateRows=$stmt->fetch()){
                    $Id= $DateRows["id"];
                    $DateTime=$DateRows["datetime"];
                    $PostTitle=$DateRows["title"];
                    $Image=$DateRows["image"];
                    $PostText=$DateRows["post"];
                    $Sr++;
                
            ?> 
            <tr>
                
                <td><?php echo $Sr; ?></td>
                <td>
                    <?php 
                          if(strlen($DateTime)>11){$DateTime=substr($DateTime,0,11).'..';}
                          echo $DateTime; 
                    ?>
                </td>
                
                <td> 
                    <?php 
                         if(strlen($PostTitle)>20){$PostTitle=substr($PostTitle,0,18).'..';}
                         echo $PostTitle; 
                    ?>
                </td>
                
                
                
                <td class="text-center">
                    <img src="../uploads/<?php echo $Image;?>" width="170px"; height="80px">
                </td>
                
                <td class="text-center">
                    <a href="edit.php?id=<?php echo $Id; ?>"><span class="btn btn-warning "><i class="fas fa-edit"></i></span></a>
                    <a href="delete.php?id=<?php echo $Id; ?>"><span class="btn btn-danger "><i class="fas fa-trash-alt"></i></span></a>
                </td>
                
                
           </tr>
            <?php }?>
            
                   </tbody>
                   
             </table>
                  
         </div>
    </div>
             </div>
           </div>
         </div>
     </section>
     <script>
      $(document).ready(function() {
    $('#example').DataTable({
         
        
        'columnDefs': [{
            'targets':[3,4],
            'orderable': false,
        }]
        
    });
          
} );
      </script>
  </body>
</html>