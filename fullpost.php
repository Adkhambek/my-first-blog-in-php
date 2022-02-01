<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php require_once("Includes/db_counter.php"); ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BEKBLOG</title>
      
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css" >
    <script src="js/jquery-3.4.1.slim.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script> 
     
      
     <!-- fontawesome -->
      <script src="https://kit.fontawesome.com/8c685f9586.js" crossorigin="anonymous"></script>
    
  </head>
    <body>
      <header > 
          <div class="container">
            <div class="">
             <div class="col">
                 
                 
                 <nav class="navbar navbar-expand-lg border-bottom navbar-light bg-faded ">
        <div class="container">
            
            <a href="#" class="navbar-brand  font-weight-bold"><h3>BEKBLOG</h3></a>
           
        
            <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarcollapseCMS">
            <ul class="navbar-nav mr-auto">
             
              <li class="nav-item dropdown">
             <a href="Blog.php" class="nav-link font-weight-bold text-primary dropdown-toggle " data-toggle="dropdown">Mavzular</a> 
                <div class="dropdown-menu">
                    

                       <a class="dropdown-item" href="#">Texnologiya</a>
                       <a class="dropdown-item" href="#">Ta'lim</a>
                       <a class="dropdown-item" href="#">Sport</a>
                           
                   
                    
                   
      
    </div>  
             </li>
                <li class="nav-item">
             <a href="#" class="nav-link font-weight-bold text-primary">Ingliz tili</a>   
             </li>
                <li class="nav-item">
             <a href="Blog.php" class="nav-link font-weight-bold text-primary">Xizmatlarimiz</a>   
             </li>
                 <li class="nav-item">
             <a href="#" class="nav-link font-weight-bold text-primary">Biz haqimizda</a>   
             </li>
                <li class="nav-item">
             <a href="#" class="nav-link font-weight-bold text-primary">Bog'lanish</a>   
             </li>
                
            </ul>
            
                </div>
        </div>
    
        </nav>
            </div>
          </div>
          </div>
      </header> 
        <section class="mt-5">
          <div class="container">
             <div class="row">
               
                 
                 <div class="col-md-8">
                     <?php
           echo ErrorMessage();
           echo SuccessMessage();
           ?>
                     <?php
                     
                     
                     //user counts
                     $total_visiters;
                     $ConnectingDB;
                     if(isset($_GET["search"])){
                        $Search=$_GET["Search"];
                         $sql="SELECT * FROM post 
                         WHERE datetime LIKE :search 
                         OR title LIKE :search 
                         OR category LIKE :search 
                         OR post LIKE :search"; 
                         $stmt = $ConnectingDB->prepare($sql);
                         $stmt->bindValue(':search','%'.$Search.'%');
                         $stmt->execute();
                     }
                     
                 
                     else{
                         $postidurl = $_GET["id"];
                         if(!isset($postidurl)){
                             $_SESSION["ErrorMessage"]="Kiritgan URLingizda xatolik bor !";
                             Redirect_to("blog.php");
                         }
                         $sql = "SELECT * FROM post WHERE  id='$postidurl' ";
                         $stmt = $ConnectingDB->query($sql);
                     }
                 
                 while($DataRows = $stmt->fetch()){
                     $PostId = $DataRows["id"];
                     $DateTime = $DataRows["datetime"];
                     $PostTitle = $DataRows["title"];
                     $Category = $DataRows["category"];
                     $Image = $DataRows["image"];
                     $PostDescription = $DataRows["post"];
                     
                 
                 ?>
                   <div class="card mb-3 rounded-0">
      
            <img src="uploads/<?php echo htmlentities($Image); ?>" style="max-height:450px;" class="img-fluid w-100" >
          
          
            <div class="card-body px-3 py-3">
              <h4 class="card-title"><?php echo $PostTitle;  ?></h4>
                <small class="card-subtitle text-muted mr-1"><i class="far fa-clock" aria-hidden="true"></i> <?php echo htmlentities($DateTime); ?></small>
                <small class="card-subtitle text-muted mr-1"><i class="fas fa-tags"></i> <?php echo $Category; ?></small>
                <small class="card-subtitle text-muted "><i class="fas fa-eye"></i> <?php
                   echo $total_visiters; 
                    ?></small>
              <p class="card-text"> <?php echo $PostDescription; ?></p>
              
            </div>
         
            
        
      </div>
                     <?php } ?>
                     
                     
   
       
                     
                 </div>
                 
                 
                 
                 <div class="col-md-4">
                      <!--Search-->
                     <div class="mb-3">
                   <form class=" d-inline w-100" action="blog.php">
            <div class="input-group">                    
                <input type="text" name="Search" class="form-control rounded-0 shadow-none" placeholder="Qidirish...">
                
                <div class="input-group-append ">
                    <button  name="search" class="btn btn-primary rounded-0 shadow-none"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form> 
                         </div>
                     <!--Status-->
                  <div class="card rounded-0 mb-3">
  <div class="card-header bg-dark text-white rounded-0">
    <div class="font-weight-bold">Kun Statusi</div>
  </div>
  <div class="card-body">
    <blockquote class="blockquote">
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
      <footer class="blockquote-footer">Someone famous in <cite title="Source Title">Source Title</cite></footer>
    </blockquote>
  </div>
</div>
                     <!--Hot Topics-->
                     <div class="card rounded-0 mb-3">
  <div class="card-header bg-primary text-white rounded-0">
    <div class="font-weight-bold">Qaynoq Mavzular</div>
  </div>
  <div class="card-body">
      <ul class="list-unstyled">
       <ul>
           <li><a href="#">IELTS topshirish...</a></li>
           <li><a href="#">PHP dasturlash tili</a></li>
           <li><a href="#">Bloger bo'lish uchun..</a></li>
           <li><a href="#">Bolalar yoqtirgan ovqat</a></li>
           <li><a href="#">Hayvonat olami</a></li>
        </ul>
      </ul>
  </div>
</div>
                     <!--Obuna-->
                     <div class="card rounded-0  mb-3">
  <div class="card-header  rounded-0" style="background: white">
    <div class="font-weight-bold"><h5>Xabarnomalar obunasi</h5></div>
  </div>
  <div class="card-body">
      <form>
      <div class="form-group text-center">
    
    <input type="email" class="form-control shadow-none rounded-0 mb-3" placeholder="Email manzilingiz">
    <button type="submit" class="btn btn-primary rounded-0 shadow-none">Obuna bo'lish</button>

  </div>
      </form>
  </div>
</div>
                     <!--Diqqat-->
                     <div class="card rounded-0 border-0 mb-3">
  <div class="card-header border-botton rounded-0" style="background: white">
    <div class="font-weight-bold"><h5>Diqqat!</h5></div>
  </div>
  <div class="card-body">
      <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
      fugiat nulla pariatur. Excepteur sint occaecat cupidatat </p>
  </div>
</div>
                     
                 </div>
              </div>
            </div>
        </section>
        <footer class=" border-top mt-3 pt-3 ">
            <div class="top-footer">
            <div class="container">
                <div class="row">
                 <div class="col-md-4">
                    <h5 class="text-center">BEKBLOG</h5>
                     <p>
                     Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.
                     </p>
                    </div>
                    <div class="col-md-4 footer-links text-center">
                    <h5>KATIGORIYA</h5>
                        <ul class="list-unstyled">
                            <li><a href="#" >Xizmatlarimiz</a></li>
                            <li><a href="#" >Biz haqimizda</a></li>
                            <li><a href="#">Bog'lanish</a></li>
                            <li><a href="#">Reklama</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4 text-right">
                        <div class="text-center">
                      <h5 class="text-center">BOG'LANISH</h5>
                        <p>
                         <strong>Phone:</strong> +998 99 8000334<br>
                            <strong>Email:</strong> bekblog@info<br>
                            
                            
                            
                        </p>
                        <div class="social-links">
                           <a href="#" class="mr-2"><img src="images/telegram.svg" height="30" width="30"></a>
                          <a href="#" class="mr-2"><img src="images/instagram.svg" height="30" width="30"></a>
                          <a href="#" class="mr-2"><img src="images/facebook.svg" height="30" width="30"></a>
                            <a href="#" ><img src="images/youtube.svg" height="30" width="30"></a>
                        </div>
                            </div>
                    </div>
                </div>
                </div>
           </div> 
            <div class="bottom-footer border-top mt-3 pt-2">
             <div class="container">
        <div class="row">
            <div class="col">
       
           <p class="text-center">Copyright &copy; 2020- <span id="year"></span> <a href="blog.php">Bekblog.uz</a> Creative group | Barcha Xuquqlar Himoyalangan</p>     
        </div>    
        </div>
        </div>
            </div>
        
        </footer>
        <script>
       $('#year').text(new Date().getFullYear()); 
       </script> 
    </body>
</html>