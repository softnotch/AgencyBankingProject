<?php
include 'Controller.php';
logout();
session_destroy();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Banking Agency</title>
        <link type="text/css" rel="stylesheet" href="style.css" media="screen"/>
        <link rel="stylesheet" href="jquery/css/themes/default/default.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="jquery/css/themes/bar/bar.css" type="text/css" media="screen"/>
        <link rel="stylesheet" href="jquery/css/nivo-slider.css" type="text/css" media="screen"/> 
        <script type="text/javascript" src="jquery/js/jquery-1.8.2.js"></script>
        <script type="text/javascript" src="jquery/js/jquery.nivo.slider.js"></script>
        <script type="text/javascript">
        $(window).load(function() {
            $('#slider').nivoSlider();
        });
    </script>
    </head>
    <body>
        <div id="wrapper">
          <div id="header" >
              <span id="loginError">
                      <?php 
                        if (isset($_SESSION['error']))
                        {
                            echo $_SESSION['error'];
                            unset($_SESSION['error']);
                        }  
                      ?>
              </span>
              <div id="logintable">
                <form method="POST" action="Controller.php">
                 <table>
                    <tr>
                        <td><span>Username:</span>
                         <input type="text" name="username" size="12" value="" /> 
                      </td><td>
                            <span>Pin:</span><input type="password" name="password" size="12" value="" /></td>
                        <td><input type="submit" value="log in" name="Login" id="log"/></td>  
                    </tr>
                  </table>
                    </form>
                </div>
          </div>
          <div id="content">
          <div class="slider-wrapper theme-default">
            <div id="slider" class="nivoSlider">
                <img src="./images/1.jpg" data-thumb="./images/1.jpg" alt="" title="branchless banking"/>
                <img src="./images/2+.jpg" data-thumb="./images/2+.jpg" alt="" title="Unbanking Undeserved" />
                <img src="./images/3+.jpg" data-thumb="./images/3+.jpg" alt="" data-transition="slideInLeft" title="Need Opportunity"/>
                <img src="./images/4+.jpg" data-thumb="./images/4+.jpg" alt="" title="models" data-transition="slideInRight" />
                <img src="./images/5.jpg" data-thumb="./images/5.jpg" alt="" title="Benefits" />
                <img src="./images/6.jpg" data-thumb="./images/6.jpg" alt="" title="Costs structures and customers transport" />
                <img src="./images/7.jpg" data-thumb="./images/7.jpg" alt="" title="How it works" />
            </div>
        </div>

            </div>
            <div id="footer"></div>
        </div>
     

    </body>
</html>
