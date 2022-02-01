<?php require_once("../Includes/DB.php"); ?>
<?php require_once("../Includes/Functions.php"); ?>
<?php require_once("../Includes/Sessions.php"); ?>
<?php 
Confirm_Login(); 
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin: Dashboard</title>
      
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
             <a href="Dashboard.php" class="nav-link text-white font-weight-bold">Dashboard</a>   
             </li>
                <li class="nav-item">
             <a href="post.php" class="nav-link text-white font-weight-bold">Posts</a>   
             </li>
                
                 <li class="nav-item">
             <a href="#" class="nav-link text-white font-weight-bold">Admin</a>   
             </li>
                <li class="nav-item">
             <a href="#" class="nav-link text-white font-weight-bold">Users</a>   
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
          
        <h1> <i class="fas fa-chart-line"></i> Dashboard</h1>
        </div>
        
    </div>    
    </div>    
    </header> 
     <section class="my-3">
       <div class="container">
         <div class="row">
            <div class="col-md-3">
               <div class="card text-center bg-primary text-white mb-3">
               <div class="card-body">
                 <h1>Posts</h1>
                   <h4 class="display-5">
                    <i class="fab fa-readme"></i>
                     <?php 
                       $ConnectingDB;
                       $sql = "SELECT COUNT(*) FROM post";
                       $stmt = $ConnectingDB ->query($sql);
                       $TotalRows= $stmt->fetch();
                       $TotalPosts= array_shift($TotalRows);
                       echo $TotalPosts;
                       ?>
                   </h4>
                </div> 
               </div>
                <div class="card text-center bg-primary text-white mb-3">
               <div class="card-body">
                 <h1 >Categories</h1>
                   <h4 class="display-5">
                    <i class="fas fa-folder"></i>
                      <?php 
                       $ConnectingDB;
                       $sql = "SELECT COUNT(*) FROM category";
                       $stmt = $ConnectingDB ->query($sql);
                       $TotalRows= $stmt->fetch();
                       $TotalCategories= array_shift($TotalRows);
                       echo $TotalCategories;
                       ?>
                   </h4>
                </div> 
               </div>
                <div class="card text-center bg-primary text-white mb-3">
               <div class="card-body">
                 <h1>Views</h1>
                   <h4 class="display-5">
                   <i class="fas fa-eye"></i>
                     <?php 
                       $ConnectingDB;
                       $sql = "SELECT COUNT(*) FROM counter_table";
                       $stmt = $ConnectingDB ->query($sql);
                       $TotalRows= $stmt->fetch();
                       $TotalCategories= array_shift($TotalRows);
                       echo $TotalCategories;
                       ?>  
                   </h4>
                </div> 
               </div>
             </div> 
              <div class="col-md-9">
              <div class="card ">
      <div class="card-header bg-primary text-white">Posts Table</div>
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
                <th>Post</th>
                <th>Banner</th>
                <th>Preview</th>
                
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
                <td> 
                    <?php 
                         if(strlen($PostText)>20){$PostText=substr($PostTitle,0,18).'..';}
                         echo $PostTitle; 
                    ?>
                </td>
                
                
                <td class="text-center">
                    <img src="../uploads/<?php echo $Image;?>" width="170px"; height="80px">
                </td>
                
                <td class="text-center">
                    <a href="../fullpost.php?id=<?php echo $Id; ?>"><span class="btn btn-primary"><i class="fas fa-search"></i></span></a>
                    
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