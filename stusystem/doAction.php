<?php
session_start();

header('content-type:text/html;charset=utf-8');
require_once 'functions/mysql.func.php';
require_once 'config/config.php';
require_once 'functions/common.func.php';
//接受信息

$username=$_REQUEST['username'];
$password=md5($_POST['password']);
$link=connect3();
$table='login';


$_SESSION['user']=$username;

//检测用户是否在

$username=mysqli_real_escape_string($link, $username);  //转义特殊字符防止注入
$sql1="SELECT user FROM {$table} WHERE user='{$username}'";
$result=mysqli_query($link, $sql1);
$row=mysqli_fetch_row($result);
if($row==null)
    echo  alertMes('用户名不存在','index.php');
else{
    $username=addslashes($username);     //转义特殊字符防止注入
    $sql2="SELECT user FROM {$table} WHERE user='{$username}' AND pwd='{$password}'";
    $result=mysqli_query($link, $sql2);
    $row=mysqli_fetch_row($result);
    if($row){

        alertMes('登陆成功，跳转到首页','student/layout-index.php');

    }else{
        echo $password;
        alertMes('用户名或密码错误，重新登陆','index.php');
    }
}




