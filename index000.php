<?php
//index.php
session_start();

include("database_connection.php");

if(isset($_SESSION['user_mobile']))
{
    //echo $_SESSION['user_mobile'];
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
    //$my_mobile = crypt($my_mobile, 'st');
    // echo $my_mobile;
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
if($user_type == 'master')
{
    $query = "
        SELECT * FROM users
    ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $count = $statement->rowCount();
    $output = '';
    $i = 0;

    if($count > 0)
    {
        $result = $statement->fetchAll();

        foreach($result as $row)
        {
            $i += 1;
            $tb_user_mobile = $row["user_mobile"];
            $tb_join_date = $row["join_date"];
            $tb_user_coin = $row["user_coin"];
            $tb_user_coin = number_format($tb_user_coin);

            if($i%2 == 1)
            {
                $check_odd = "odd";
            }
            else
            {
                $check_odd = "even";
            }

            $output .= '
                <tr role="row" class="edit_tr '.$check_odd.'" id="'.$i.'">
                    <td id="checkbox"><label><input type="checkbox" class="filled-in" onchange="cbChange(this)"><span>'.$i.'</span></label></td>
                    <td>'.$tb_user_mobile.'</td>
                    <td>'.$tb_join_date.'</td>
                    <td><div class="edit">'.$tb_user_coin.'</div></td>
                    <td><button data-target="modal1" class="btn-floating modal-trigger btn-small red">edit</button></td>
                </tr>
            ';
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
    <!-- Modal Trigger -->
    <!--<a class="waves-effect waves-light btn modal-trigger" href="#modal1">Modal</a>-->
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
                    <p><strong>My Wallet Address:<?php echo ' '.$my_mobile.' openssl_encrypt-> '.$ciphertext.' '; ?></strong><br/><?php echo '<h7><strong>'.$my_coin.' HintCoin</h7>'; ?></strong></p>
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
  <!--</div>-->
  <!--</div>-->  
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
    <!-- tables -->
    <?php
    if($user_type == "master")
    {
    ?>        
    <div class="container">
        <div class="row">
            <div class="col s12">
                <h6 class="section-title"></h6>
                <div class="card">
                    <div id="table-custom-elements_wrapper" class="dataTables_wrapper no-footer">
                        <div id="table-custom-elements_filter" class="dataTables_filter"> 
                            <label class="right">
                                <input type="search" class placeholder="Enter search term" aria-controls="table-custom-elements" name="" id="">
                            </label>
                        </div>
                        <div class="datatables_scroll">
                            <div class="dataTables_scrollHead">
                            </div>
                            <div class="dataTables_scrollBody">
                                <table id="table-custom-elements" class="striped row-border dataTable no-footer">
                                    <thead>
                                        <tr role="row" style="height: 0px;">
                                            <th>No</th>
                                            <th>아이디</th>
                                            <th>가입일자</th>
                                            <th>코인금액</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                   
                                        <?php echo $output; ?>
                                        
                                    </tbody>
                                </table>
                            </div>
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
    </div>
    <!-- user_dialog -->
    <div id="user_dialog" title="Add Data">
        <!-- Modal Structure -->
        <div id="modal1" class="modal">
            <div class="modal-content">
                <form method="post" id="user_form">
                    <h4>Customer Info</h4>
                    <div class="form_group">
                        <label>No.</label>
                        <input type="text" id="user_id" class="form_control">
                    </div>
                    <div class="form_group">
                        <label>아이디</label>
                        <input type="text" id="user_mobile" class="form_control">
                    </div>
                    <div class="form_group">
                        <label>가입일자</label>
                        <input type="text" id="join_date" class="form_control">
                    </div>
                    <div class="form_group">
                        <label>코인금액</label>
                        <input type="text" id="user_coin" class="form_control">
                    </div>
                    <div class="from-group">
                        <input type="hidden" name="action" id="action" value="insert" />
                        <input type="hidden" name="hidden_id" id="hidden_id" />
                        <input type="submit" name="form_action" id="form_action" class="modal-close btn btn-flate btn-small" value="Confirm">
                    </div>
                </form>
            </div>
            <div class="modal-footer">            
            <!--<a href="#!" class="modal-close waves-effect waves-green btn-flat">Confirm</a>-->
            </div>
        </div>
    </div>    
    <?php
    }
    ?>
       
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
    
  <!--  Scripts-->
  <!--<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.2/js/materialize.min.js"></script>

  <script>
      
      (function($){
          
            $(function(){
               
               var user_coin = 0;

               $('.slider').slider();
               $('.sidenav').sidenav();
               $('.parallax').parallax();
               $('.tabs').tabs();
               $("#test2").click(function(){
                    //$('ul.tabs').tabs('select_tab', 'test2');
                    M.toast({html: 'I am a toast!'});
               });
               
               
               $("#table-custom-elements tr").click(function(){
                   //e.stopPropagation();
                   //console.log('1');
                   let arr = new Array();
                   var tr_id = $(this).attr("id");
                   var td_id = $(this).closest('tr').find('td').each(function (i){
                       //console.log($(this).text());                        
                       arr = $(this).text();
                       console.log(arr);                       
                       //console.log(arr[1]);
                       //var a1 = $(this).text();
                   });
                   //console.log(td_id[1]);
                  

                   var str = removeTag(td_id[1]); // user_mobile
                   //console.log("td_id[1]-->"+str);
                   let g5_user_id = '';
                   let g5_user_mobile = '';
                   let g5_join_date = '';
                   let g5_user_coin = '';
                   let g5_change_coin = 0; 
                   
                   g5_user_id = removeTag(td_id[0]);
                   g5_user_mobile = removeTag(td_id[1]);
                   g5_join_date = removeTag(td_id[2]);
                   g5_user_coin = removeTag(td_id[3]);
                   g5_nocomma_coin = removeCommas(g5_user_coin);
                   g5_change_coin = Number(g5_nocomma_coin);
                   user_coin = g5_change_coin;
                   
                   //console.log(user_coin);

                   $("#user_id").val(g5_user_id);
                   $("#user_mobile").val(g5_user_mobile);
                   $("#join_date").val(g5_join_date);
                   $("#user_coin").val(user_coin);

                   //var modal1 = td_id[4];
                   //console.log(modal1);
                   //document.querySelctor("td#user_edit")
                   //var cb = document.querySelector("td#checkbox input[type=checkbox]");
                   //console.log(cb);
                   //var chk = cbChange(cb);

                   //var id = $(this).attr('id');  // user_id  
                   //console.log('attr--->'+id); 
                  
                                     
               });               
               
               $('.modal').modal({
                   ready: function(modal, trigger)
                   {
                        $(this).options.dismissible = false;
                        $("div#modal1 input user.coin").val('1000000000');
                   }
               });
               $("#modal1").click(function(){
                    console.log('modal1');
                    //$("#user_id").val(user_id);
                    //$("#user_mobile").val(user_mobile);
                    //$("#join_date").val(join_date);
                    //$("#user_coin").val(user_coin);
                    var id = $('#user_id').val();
                    var action = 'update';
                    var mobile_no = $('#user_mobile').val();
                    var cur_coin = $('#user_coin').val();
                    
                    
               });
               

               
               function removeTag(html){
                   return html.innerHTML.replace(/<[^>]*>/g,''); //html.replace(/(<([^>]+)>)/gi, "");
               }

               function removeCommas(str){
                   return(str.replace(/,/g,''));
               }
               
               //var checked = document.querySelector("td#checkbox input[type=checkbox]").checked;
               //console.log(checked);


               
               //var instance = M.Tabs.init(el,options);
               //console.log(instance);

            }); // end of document ready
      })(jQuery); // end of jQuery name space
  </script>
</body>
</html>

   
   