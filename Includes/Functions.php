<?php require_once("DB.php"); ?>
<?php
function Redirect_to($New_Location){
    header("Location:".$New_Location);
    exit;
}


function Login_Attampt($Username, $Password){
    global $ConnectingDB;
      $sql="SELECT * FROM admin WHERE username=:UserName AND password=:PassWord LIMIT 1";
      $stmt = $ConnectingDB->prepare($sql);
      $stmt -> bindValue(':UserName',$Username);
      $stmt -> bindValue(':PassWord',$Password);
      $stmt->execute();
      $Result = $stmt->rowcount();
      if($Result==1){
         return $Found_Account =$stmt->fetch();
      }else{
          return null;
      }
}
function Confirm_Login(){
    if(isset($_SESSION["UserId"])){
        return true;
    }else{
        $_SESSION["ErrorMessage"]="Login Required !";
            Redirect_to("login.php");
    }
}
?>