<?php
//index01.php
session_start();

include("database_connection.php");

if(isset($_SESSION['user_mobile']))
{
   $user_mobile = $_SESSION['user_mobile'];
   $query = "
         SELECT * FROM users
         WHERE user_mobile = :user_mobile
       ";
   $statement = $connect->prepare($query);
   $statement->execute(
       array(
             'user_mobile' => $user_mobile
       )
   );
   $count = $statement->rowCount();
   $i = 0;
   $output = '';

   if($count > 0)
   {
       $result = $statement->fetchAll();
       foreach($result as $row)
       {
           $my_mobile = $row["user_mobile"];
           $my_name = $row["user_name"];
           $user_name = $row["user_name"];
           $my_email = $row["user_email"];
           $user_email = $row["user_email"];
           $user_type = $row["user_type"];
           $join_date = $row["join_date"];
           $user_coin = $row["user_coin"];
           $user_coin = number_format($user_coin);
           $my_coin = $user_coin;
           
       }
   }

   $query = "
      SELECT * FROM users
   ";
   $statement = $connect->prepare($query);
   $statement->execute();
   $count = $statement->rowCount();

}

if(!isset($_COOKIE["type"]))
{  
   header("location:login.php");      
}

$key = '1234567891011120';
//echo '$my_mobile->'.$my_mobile;
//echo '$user_mobile->'.$_SESSION['user_mobile'];
$plaintext = $my_mobile; //"message to be encrypted";
$cipher = "aes-128-gcm";
if (in_array($cipher, openssl_get_cipher_methods()))
{
    $ivlen = openssl_cipher_iv_length($cipher);
    $iv = openssl_random_pseudo_bytes($ivlen);
    $ciphertext = openssl_encrypt($plaintext, $cipher, $key, $options=0, $iv, $tag);
    //store $cipher, $iv, and $tag for decryption later
    $original_plaintext = openssl_decrypt($ciphertext, $cipher, $key, $options=0, $iv, $tag);
    //echo $original_plaintext."\n";
}


?>

<!DOCTYPE html>
<html lang="ko">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>HintChain</title>
   
   <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
   <link rel="stylesheet" href="jquery-ui.css">
   <link rel="stylesheet" href="bootstrap.min.css" />
   <script src="jquery.min.js"></script>  
	<script src="jquery-ui.js"></script>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.2/css/materialize.min.css">

   

   <style type="text/css">
    .parallax-container {
      position: relative;
      overflow: hidden;
      height: 900px;
    }
    .tabs .tab a {
        padding: 0px 4px;
    }
    .sidenav {
        width: 300px;
    }
    /* All in one selector */
    .banner01 {
      display: block;
      -moz-box-sizing: border-box;
      box-sizing: border-box;
      background: url(http://hintchain.io/static/media/c-phone.9182e21b.png) no-repeat;
      width: 422px; /* Width of new image */
      height: 291.41px; /* Height of new image */
      /*padding-left: 320px; /* Equal to width of new image */
    }
    .banner02 {
      display: block;
      -moz-box-sizing: border-box;
      box-sizing: border-box;
      background: url(http://hintchain.io/static/media/c-apps.5f666041.png) no-repeat;
      width: 422px; /* Width of new image */
      height: 239px; /* Height of new image */
      /*padding-left: 320px; /* Equal to width of new image */
    }

    .txtedit {
        display: none;
        width: 99%;
        height: 30px;
    }

    /*#user_dialog {
        display: none;
    }*/
   </style>

   <script>
   
    function cbChange(obj)
    {
        //console.log('1');
        var cbs = document.getElementsByClassName("filled-in");
        for (var i = 0; i < cbs.length; i++)
        {
            cbs[i].checked = false;
        }
        obj.checked = true;        
    }
   </script>
</head>
<body>

   <nav class="navbar nav-extended indigo" role="navigation">     
      <div class="nav-wrapper container">
         <a id="logo-container" href="index.php" class="brand-logo center"><img src="http://hintchain.io/static/media/logo.833b60c1.svg"></a>
         <ul class="right hide-on-med-and-down">
               <li><a href="#!"><?php echo $user_type.' 님입니다.'; ?></a></li>
               <li><a href="logout.php">Logout</a></li>          
         </ul>
         <ul id="slide-out" class="sidenav">           
               <li>
                  <div class="user-view">
                  <div class="background">
                     <img src="images/main.jpg">
                  </div>
                     <a href="#user"><img class="circle" src="images/food02.jpg"></a>
                     <a href="#name"><span class="center-align white-text name"><?php echo '<h6><strong>'.$my_mobile.'</strong></h6>'; ?></span></a>
                     <a href="#email"><span class="center-align white-text email"><?php echo '<h6><strong>'.$my_email.'</strong></h6>'; ?></span></a>
                  </div>
               </li>        
               <li><div class="divider"></div></li>
               <li>
                  <a href="#!">내지갑&nbsp;<span><?php echo $my_coin. ' HINT'; ?></span></a>
               </li>
               <li>
                  <a onclick="M.toast({html: 'Hint Chain ICO<br/>마감후에 지갑간 받기/보내기 가능합니다.'})" class="btn" id="send_coin">코인보내기</a>
               </li>
               <li><div class="divider"></div></li>
               <li>
                  <a onclick="M.toast({html: 'Hint Chain ICO<br/>마감후에 지갑간 받기/보내기 가능합니다.'})" class="btn" id="get_coin">코인받기</a>
               </li>
               <li><div class="divider"></div></li>
               <li>
                  <a href="#!" id="history">거래내역</a>
               </li>
               
               <li><div class="divider"></div></li>
               <li>
                  <a href="logout.php">Logout</a>
               </li>        
         </ul>
         <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
      </div>
   </nav>
   <div class="container"> <!--  style="position: absolute; left: 5px; top: 30px;" -->
        <div class="section">
            <!--<div class="col s10 offset-m4">-->
            <div class="card">
                <div class="card-image">
                    <!--<img src="images/background1.jpg" alt="Unsplashed background img 1">-->
                    <!--<span class="card-title">User Info</span>-->
                    <!--<a class="btn-floating halfway-fab waves-effect waves-light red"><i class="material-icons">add</i></a>-->
                </div>
            </div>
            <div class="card-content">
                <ul class="tabs indigo darken-2">
                    <li class="tab col s8"><a href="#test1"><span class="white-text text-darken-2">Wallwet</span></a></li>
                    <li class="tab col s8"><a href="#test2"><span class="white-text text-darken-2">Send Coin</span></a></li>
                    <li class="tab col s8"><a href="#test3"><span class="white-text text-darken-2">Get Coin</span></a></li>
                    <li class="tab col s8"><a href="#test4"><span class="white-text text-darken-2">History</span></a></li>
                </ul>
                <div id="test1" class="col s8">
                    <p><strong>My Wallet Address:<?php echo ' '.$my_mobile.' '.$ciphertext.' '; ?></strong><br/><?php echo '<h7><strong>'.$my_coin.' Hint</h7>'; ?></strong></p>
                </div>
                <div id="test2" class="col s8">
                    <p><strong>Send Coin Hint Chain ICO<br/>마감후에 지갑간 받기/보내기 가능합니다.</strong></p>
                </div>
                <div id="test3" class="col s8">
                    <p><strong>Get Coin Hint Chain ICO<br/>마감후에 지갑간 받기/보내기 가능합니다.</strong></p>
                </div>
                <div id="test4" class="col s8"><p>
                    <strong>History</strong></p>
                </div>
            </div>
        </div>    
   </div>
   <div class="container">
        <div class="section">      
            <!-- slider section -->
            <div class="slider">
                <ul class="slides">
                    <li>
                        <img src="images/food07.jpg"> <!-- random image -->
                        <div class="caption right-align">
                        <h3>HINT Chain</h3>
                        <h4 class="right-align light grey-text text-lighten-3">This is Hope of the world.</h4>
                        </div>
                    </li>
                    <li>
                        <img src="images/food02.jpg"> <!-- random image -->
                        <div class="caption center-align">
                        <h3>소비자와 푸드기업 플랫폼</h3>
                        <h4 class="right-align light grey-text text-lighten-3">VITAL-HINT 해먹남녀.</h4>
                        </div>
                    </li>
                    <li>
                        <img src="images/food08.jpg"> <!-- random image -->
                        <div class="caption right-align">
                        <h3>해먹남녀</h3>
                        <h4 class="right-align light grey-text text-lighten-3">Here's our small slogan.</h4>
                        </div>
                    </li>
                    <li>
                        <img src="images/food09.jpg"> <!-- random image -->
                        <div class="caption center-align">
                        <h3>This is our big Tagline!</h3>
                        <h5 class="light grey-text text-lighten-3">Here's our small slogan.</h5>
                        </div>
                    </li>
                </ul>
            </div>
        </div>    
   </div>
<?php
if($user_type == "master")
{
?>
   <div class="container">
      <div class="row">
         <div class="col s12">
            <div class="card">
               <div class="table-responsive" id="user_data">
				
			      </div>
            </div>
            
            <div class="card-content">
               <p class="right"><?php echo '회원수 '.$count.'명'; ?></p>
            </div>
            <div class="footer-wrapper">
               <div class="dataTables_length">
                  <div class="dataTables_lenth" id="table-custom-elements_length"></div>
               </div>
               <div class="paging-info">
               </div>
            </div>
         </div>
      </div> 
   </div>
<?php
}
?>   
   <div id="user_dialog" title="Add Data">
		<form method="post" id="user_form">
				<div class="form-group">
					<label>user_mobile</label>
					<input type="text" name="user_mobile" id="user_mobile" class="form-control" />
					<span id="error_user_mobile" class="text-danger"></span>
				</div>
				<div class="form-group">
					<label>user_coin</label>
					<input type="text" name="user_coin" id="user_coin" class="form-control" />
					<span id="error_user_coin" class="text-danger"></span>
				</div>
				<div class="form-group">
					<input type="hidden" name="action" id="action" value="insert" />
					<input type="hidden" name="hidden_id" id="hidden_id" />
					<input type="submit" name="form_action" id="form_action" class="btn btn-info" value="Insert" />
				</div>
		</form>
	</div>
		
	<div id="action_alert" title="Action">
			
	</div>
		
	<div id="delete_confirmation" title="Confirmation">
	   <p>Are you sure you want to Delete this data?</p>
	</div>
		   
   <footer class="page-footer white">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <h5 class="grey-text">HINT Chain</h5>          
                    <p class="grey-text text-dark-4">Business Ecosystem<br>블록체인 기술을 통해 푸드 프로필을 관리하고 공유하며<br>개인에게는 푸드 솔루션을, 기업에게는 이를 제공할 창구를<br>마련해주는 비즈니스 생태계입니다.</p>    
                </div>
                <div class="col s12">
                    <div class="header">        
                        <img src="http://hintchain.io/static/media/c-phone.9182e21b.png" style="padding: 2px 0px 4px 14px; width: 100%; height: 100%;">
                    </div>
                </div>
                <div class="col s12">
                    <div class="header">        
                        <img src="http://hintchain.io/static/media/c-apps.5f666041.png" style="padding: 2px 0px 4px 14px; width: 100%; height: 100%;">
                    </div>
                </div>
                <div class="col s12">    
                    <h5 class="grey-text">VITAL-HINT</h5>          
                    <p class="grey-text text-dark-4">바이탈힌트는<br>힌트체인의 첫번째 핵심 파트너로,&nbsp;음식관련 46만건의 메타데이터 및&nbsp;300만 유저의 '푸드프로필'을 분석해&nbsp;맞춤형&nbsp;레시피를<br>제공하고 있습니다.<br>바이탈힌트가 운영하는<br>한국의 '해먹남녀', 중국의 '미식남녀', 동남아시아의<br>'Foodiest'는 힌트체인에 푸드컨텐츠 및 데이터기술을&nbsp;제공하는 중요한 DApp이 될 것입니다.</p>    
                </div>
            </div>
        </div>
        <div class="footer-copyright indigo">
            <div class="container">
                <p style="center-align">Copyright 2018. VITAL-HINT all rights reserved.&nbsp;&nbsp;&nbsp;Power by<a class="brown-text text-lighten-3" href="http://hintchain.io/">VITAL-HINT</a></p>
            </div>
        </div>
   </footer>
   
   <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.2/js/materialize.min.js"></script>
<script>
   $(document).ready(function(){
      $('.slider').slider();
      $('.sidenav').sidenav();
      $('.parallax').parallax();
      $('.tabs').tabs();
      $("#test2").click(function(){
         //$('ul.tabs').tabs('select_tab', 'test2');
         M.toast({html: 'I am a toast!'});
      });

      //refresh data table 
      load_data();

      function load_data()
	   {
         $.ajax({
            url:"fetch.php",
            method:"POST",
            success:function(data)
            {
               $('#user_data').html(data);
            }
         });
	   }

      $("#user_dialog").dialog({
		   autoOpen:false,
		   width:400
	   });
      
      //
      $('#user_form').on('submit', function(event){
         event.preventDefault();
         var error_user_mobile = '';
         var error_user_coin = '';
         if($('#user_mobile').val() == '')
         {
            error_user_mobile = 'mobile num is required';
            $('#error_user_mobile').text(error_user_mobile);
            $('#user_mobile').css('border-color', '#cc0000');
         }
         else
         {
            error_user_mobile = '';
            $('#error_user_mobile').text(error_user_mobile);
            $('#user_mobile').css('border-color', '');
         }
         if($('#user_coin').val() == '')
         {
            error_user_coin = 'user coin is required';
            $('#error_user_coin').text(error_user_coin);
            $('#user_coin').css('border-color', '#cc0000');
         }
         else
         {
            error_user_coin = '';
            $('#error_user_coin').text(error_user_coin);
            $('#user_coin').css('border-color', '');
         }
         
         if(error_user_mobile != '' || error_user_coin != '')
         {
            return false;
         }
         else
         {
            $('#form_action').attr('disabled', 'disabled');
            var form_data = $(this).serialize();
            $.ajax({
               url:"action.php",
               method:"POST",
               data:form_data,
               success:function(data)
               {
                  $('#user_dialog').dialog('close');
                  $('#action_alert').html(data);
                  $('#action_alert').dialog('open');
                  load_data();
                  $('#form_action').attr('disabled', false);
               }
            });
         }
		
	   });
      //

      $('#action_alert').dialog({
		   autoOpen:false
	   });

      //
      $(document).on('click', '.edit', function(){

         console.log('edit');
		   var id = $(this).attr('id');
         console.log(id);
		   var action = 'fetch_single';
         $.ajax({
            url:"action.php",
            method:"POST",
            data:{id:id, action:action},
            dataType:"json",
            success:function(data)
            {
               console.log(data);
               $('#user_mobile').val(data.user_mobile);
               $('#user_coin').val(data.user_coin);
               $('#user_dialog').attr('title', 'Edit Data');
               $('#action').val('update');
               $('#hidden_id').val(id);
               $('#form_action').val('Update');
               $('#user_dialog').dialog('open');
            }
		   });
	   });
      //
      $('#delete_confirmation').dialog({
         autoOpen:false,
         modal: true,
         buttons:{
            Ok : function(){
               var id = $(this).data('user_mobile');
               var action = 'delete';
               $.ajax({
                  url:"action.php",
                  method:"POST",
                  data:{id:id, action:action},
                  success:function(data)
                  {
                     $('#delete_confirmation').dialog('close');
                     $('#action_alert').html(data);
                     $('#action_alert').dialog('open');
                     load_data();
                  }
               });
            },
            Cancel : function(){
               $(this).dialog('close');
            }
         }	
	   });
      //
      $(document).on('click', '.delete', function(){
		   var id = $(this).attr("id");
		   $('#delete_confirmation').data('id', id).dialog('open');
	   });
	
   });
</script>
</body>
</html>