<?php

$server="localhost";
$username="root";
$password="";
$database="shubham";

$conn = new mysqli($server,$username,$password,$database);
if($conn -> connect_error ){
    die("some error in database");
}
$name =$_GET['name'];
$mob= $_GET['no'];
$email=$_GET['email'];
$pass= $_GET['pass'];
$pass2=$_GET['pass2'];
if ($pass == $pass2){


$sql="insert into login (name, email, mobile, pass) values ('$name','$email',$mob,'$pass')";

if ($conn -> query($sql) == TRUE ){
// Redirect to an HTML page
header("Location: login.php");
exit; // Make sure to exit after the redirect


}
else{
    echo "Error";

}}
else{
    echo "Password missmatch";
}


$conn->close();

?>