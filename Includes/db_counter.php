<?php

$ConnectDB= mysqli_connect('localhost','root','','bekblog');
if(mysqli_connect_errno()){
    die("Error connecting to the Database");
} 

$visitor_ip=$_SERVER['REMOTE_ADDR'];





$query="SELECT * FROM counter_table WHERE ip_address='$visitor_ip'";
$result= mysqli_query($ConnectDB, $query );

if(!$result){
    die("Retriving Query Error". $query);
    } 
$total_visiters=mysqli_num_rows($result);
if($total_visiters<1){
 $query="INSERT INTO counter_table(ip_address) VALUES('$visitor_ip')";
$result= mysqli_query($ConnectDB, $query );   
}


$query="SELECT * FROM counter_table";
$result= mysqli_query($ConnectDB, $query );

if(!$result){
    die("Retriving Query Error". $query);
    } 
$total_visiters=mysqli_num_rows($result);

?>