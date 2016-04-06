<?php
require_once 'dbConfig.php';
session_start();

$error_msg = "";

if(!isset($_SESSION['username'])){
    if(isset($_POST['submit'])){//用户提交登录表单时执行如下代码
        $dbc = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
        $user_username = mysqli_real_escape_string($dbc,trim($_POST['name']));
        $user_password = mysqli_real_escape_string($dbc,trim($_POST['password']));

        if(!empty($user_username)&&!empty($user_password)){
            //MySql中的SHA()函数用于对字符串进行单向加密
            $query = "SELECT name FROM users WHERE name = '$user_username' AND password = '$user_password'";
            //用用户名和密码进行查询
            $data = mysqli_query($dbc,$query);
            //若查到的记录正好为一条，则设置SESSION，同时进行页面重定向
            if(mysqli_num_rows($data)==1){
                $row = mysqli_fetch_array($data);
                //$_SESSION['user_id']=$row['id'];
                $_SESSION['username']=$row['name'];
                $home_url = 'memberHome.php';
                header('Location: '.$home_url);
            }else{//若查到的记录不对，则设置错误信息
                die("<script>alert('Sorry, you must input valid username and password.');location.href='".$_SERVER["HTTP_REFERER"]."';</script>");

            }
        }else{
                die("<script>alert('Sorry, you must input your username and password.');location.href='".$_SERVER["HTTP_REFERER"]."';</script>");
        }
    }
}else{//如果用户已经登录，则直接跳转到已经登录页面
    $home_url = 'memberHome.php';
    header('Location: '.$home_url);
}
?>

<!DOCTYPE HTML>
<html>
    <body>
    <head>
        <title>Utickets Sign In</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
        <link rel="stylesheet" href="assets/css/main.css" />
        <!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
                    <!--<style>
                    #example1{
                        background: url(images/background.jpg);
                        background-position: left top;
                        background-repeat: no-repeat;
                    }
                    </style>
                -->
    </head>
    <?php
        if(!isset($_SESSION['username'])){
            echo '<p class="error">'.$error_msg.'</p>';
    ?>
    <div id="page-wrapper">
       
            <!-- Header -->
                <header id="header">

                    <img src="images/bird_ticket.png", style="width:80px">

                    <h1><font size="4"><a href="index.php"><ul><ul><ul><ul><ul>UTickets</font></h1>
                    <nav id="nav">
                        <ul>
                            <li><a href="index.php">Home</a></li>
                            <li>
                            <li><a href="about.php">About Us</a></li>
                            <li>
                                <!--<a href="#" class="icon fa-angle-down">Layouts</a>
                                <ul>
                                    <li><a href="generic.html">Generic</a></li>
                                    <li><a href="contact.html">Contact</a></li>
                                    <li><a href="elements.html">Elements</a></li>
                                    <li>
                                        <a href="#">Submenu</a>
                                        <ul>
                                            <li><a href="#">Option One</a></li>
                                            <li><a href="#">Option Two</a></li>
                                            <li><a href="#">Option Three</a></li>
                                            <li><a href="#">Option Four</a></li>
                                        </ul>
                                    </li>
                                </ul>-->
                            </li>
                            <li><a href="signup.html" class="button">Sign Up</a></li>
                        </ul>

                    </nav>

                </header>

            <!-- Main -->
                <section id="main" class="container 50%">
                    <header>
                        <h2>Welcome Back!</h2>
                        <p>Enter Your E-mail Address and Password</p>
                    </header>

                    <div class="box">
                        <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>" name="myform" id="payment-form" >
                            <br>
                            <div class="row uniform 50%">
                                <div class="12u">
                                    <input type="text" name="name" value="" value="" placeholder="Username" >
                                </div>
                            </div>
                            <br>
                            <div class="row uniform 50%">
                                <div class="12u">
                                    <input type="text" name="password" id="passord" value="" placeholder="Password" />
                                </div>
                            </div>
                            <p class="forgot">
                                <a href="#">Forgot Password?</a>
                            </p>
                        
                            <div class="row uniform">
                                <div class="12u">
                                    <ul class="actions align-center">
                                        <li><input type="submit" value="Sign In" name='submit' class="btn btn-lg btn-primary btn-block"></li>
                                    </ul>
                                </div>
                            </div>

                            <!--<div class="row uniform">
                                <div class="12u">
                                    <ul class="actions align-center">
                                        <li><button type="submit" class="submit-button">Submit Payment</button></li>
                                    </ul>
                                </div>
                            </div>-->
                        </form>
        

                          <!-- jQuery is used only for this example; it isn't required to use Stripe -->
                        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>

                    </div>
                </section>

            <!-- Footer -->
                <footer id="footer">
                    <ul class="icons">
                        <li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
                        <li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
                        <li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
                        <li><a href="#" class="icon fa-github"><span class="label">Github</span></a></li>
                        <li><a href="#" class="icon fa-dribbble"><span class="label">Dribbble</span></a></li>
                        <li><a href="#" class="icon fa-google-plus"><span class="label">Google+</span></a></li>
                    </ul>

                </footer>

        </div>
        <?php
        }
        ?>

        <!-- Scripts -->
            <script src="assets/js/jquery.min.js"></script>
            <script src="assets/js/jquery.dropotron.min.js"></script>
            <script src="assets/js/jquery.scrollgress.min.js"></script>
            <script src="assets/js/skel.min.js"></script>
            <script src="assets/js/util.js"></script>
            <!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
            <script src="assets/js/main.js"></script>

    </body>
</html>
