<?php
// index.php
session_start();

include("database_connection.php");

if(isset($_COOKIE["type"]))
{
    header("location:index.php");
}

$message = '';

if(isset($_POST["register"]))
{
    if(empty($_POST["user_mobile"]) && empty($_POST["user_password"]))
    {
        $message = "<div class='alert alert-danger'>Both Fields are required</div>";
    }
    else
    {
        $query = "
          SELECT * FROM users
          WHERE user_mobile = :user_mobile
        ";
        $statement = $connect->prepare($query);
        $statement->execute(
            array(
                'user_mobile' => $_POST["user_mobile"]
            )
        );
        $count = $statement->rowCount();
        if($count > 0)
        {
            $message = "<div class='alert alert-danger'>Already exists. Please enter another number</div>";
        }
        else
        {
            $user_mobile = $_POST["user_mobile"];
            $user_password = $_POST["user_password"];
            $user_coin = 0.0;
            $date = new DateTime();
            $join_date = $date->format('Y-m-d H:i:s');
            $user_type = "user";
            $query = "
              INSERT INTO users (user_mobile, user_password, user_coin, join_date, user_type)
              VALUES (:user_mobile, :user_password, :user_coin, :join_date, :user_type)
            ";
            $statement = $connect->prepare($query);
            $statement->execute(
              array(
                 'user_mobile'   => $user_mobile,
                 'user_password' => $user_password,
                 'user_coin'     => $user_coin,
                 'join_date'     => $join_date,                 
                 'user_type'     => $user_type  
              )
            );
            $message = "<div class='alert alert-danger'>Add user</div>";
            
            setcookie("type", $user_type, time()+3600);
            $_SESSION['user_mobile'] = $user_mobile;
            $_SESSION['user_coin'] = 0.0;
            
            header("location:login.php");
        }
    }
}

if(isset($_POST["login"]))
{
    if(empty($_POST["user_mobile"]) || empty($_POST["user_password"]))
    {
        $message = "<div class='alert alert-danger'>Both Fields are required</div>";
    }
    else
    {
        $query = "
          SELECT * FROM users
          WHERE user_mobile = :user_mobile
        ";
        $statement = $connect->prepare($query);
        $statement->execute(
            array(
                'user_mobile' => $_POST["user_mobile"]
            )
        );
        $count = $statement->rowCount();
        if($count > 0)
        {
            $result = $statement->fetchAll();
            foreach($result as $row)
            {
              //$hashed_password = password_hash($row["user_password"],PASSWORD_DEFAULT);
               // if(password_verify($_POST["user_password"], $hashed_password))
                if($_POST["user_password"] == $row["user_password"])
                {
                    setcookie("type", $row["user_type"], time()+3600);
                    $_SESSION['user_mobile'] = $row["user_mobile"];
                    $_SESSION['user_coin'] = $row["user_coin"];
                    header("location:index.php");
                }
                else
                {
                    $message = '<div class="alert alert-danger">wrong Password</div>';
                }
            }
        }
        else
        {
            $message = "<div class='alert alert-danger'>Wrong user phone number</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>HintChain</title>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
   <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.2/css/materialize.min.css">

   <style type="text/css">

   </style>
</head>
<body class="has-fixed-sidenav">
  <header>
  <div class="navbar-fixed">
  <nav class="indigo" role="navigation">
    <div class="nav-wrapper container">
      <a id="logo-container" href="index.php" class="brand-logo"><img src="http://hintchain.io/static/media/logo.833b60c1.svg"></a>
      <ul class="right hide-on-med-and-down">
        <li><a href="login.php">login</a></li>
      </ul>

      <ul id="slide-out" class="sidenav">
        <li>
          <div class="user-view">
            <div class="background">
              <img src="images/main.jpg">
            </div>
            <a href="#user"><img class="circle" src="images/yuna.jpg"></a>
            <a href="#name"><span class="white-text name">John Doe</span></a>
            <a href="#email"><span class="white-text email">jdandturk@gmail.com</span></a>
            </div>
        </li>
        
        <li><div class="divider"></div></li>
        <li>
          <a href="#!">내지갑</a>
        </li>
        <li>
          <a href="#!">코인보내기</a>
        </li>
        <li><div class="divider"></div></li>
        <li>
          <a href="#!">코인받기</a>
        </li>
        <li><div class="divider"></div></li>
        <li>
          <a href="#!">거래내역</a>
        </li>
        
        <li><div class="divider"></div></li>
        <!--
        <li><a href="#!">Second Link</a></li>
        <li><div class="divider"></div></li>
        <li><a class="subheader">Subheader</a></li>
        <li><a class="waves-effect" href="#!">Third Link With Waves</a></li>
        <li><a class="waves-effect" href="#!">login</a></li>-->
    </ul>
    <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
    </div>
  </nav>
  
  <div id="index-banner" class="parallax-container">
    
    <div class="parallax"><img src="images/background1.jpg" alt="Unsplashed background img 1"></div>
  
  </div>
  <div class="container">
    <div class="row">
      <div class="col m6 s12" style="position: absolute; left: 0px; top: 120px;">
        <div class="card card-login">
          <div class="card-content">            
            <span class="card-title">회원가입</span>
            <br>
            <form method="post" action="register.php">                      
              <div class="input-group">
                <label for="login">핸드폰번호</label>
                <input type="text" name="user_mobile" id="user_mobile" placeholder="핸드폰 번호를 입력해 주세요." class="form-control">
              </div>
              <div class="input-group">
                <label for="password">비밀번호</label>
                <input type="password" name="user_password" id="user_password" placeholder="비밀번호를 입력해 주세요." class="form-control">
              </div>
              <div class="input-group">
                <label for="password">비밀번호 확인</label>
                <input type="password" name="user_password2" id="user_password2" placeholder="비밀번호를 다시 입력해 주세요." class="form-control">
              </div>
              <div class="row">
                <!--<input type="submit" id="login" name="login" value="LOG IN" class="btn right">-->                
                <input type="submit" id="register" name="register" value="회원가입" class="btn right red">
                <p class="col s6 m6">이미 회원이시라면?<a href="login.php">로그인</a></p>
              </div>
              <p><?php echo $message; ?></p>              
            </form>           
          </div>      
        </div>
      </div>
    </div>
  </div>
  <footer class="page-footer teal">
    <div class="container">
      <div class="row">
      </div>
    </div>
    <div class="footer-copyright">
      <div class="container">
          <p style="center-align">Copyright 2018. VITAL-HINT all rights reserved.&nbsp;&nbsp;&nbsp;Power by <a class="brown-text text-lighten-3" href="http://hintchain.io/">VITAL-HINT</a></p>  
      </div>
    </div>
  </footer>
  <!-- Copyright 2018. VITAL-HINT all rights reserved. -->
  <!--  Scripts-->    
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.2/js/materialize.min.js"></script>
  <script>
     (function($){
         $(function(){

            $('.sidenav').sidenav();
            $('.parallax').parallax();
            $('#register').click(function(){
                console.log('1');                
                window.location.href = 'http://localhost.hintchain/login.php?action=register';
            });
            $('#login').click(function(){
                console.log('2');                
                window.location.href = 'http://localhost.hintchain/login.php?action=login';
            });

         }); // end of document ready
     })(jQuery); // end of jQuery name space

  </script>
</body>
</html>