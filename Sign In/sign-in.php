<?php 
    session_start();

    if(isset($_SESSION["signin"])){
        // redirect to home page
        header("Location: ../Home/home.php");
        exit;
    }

    require '../Functions/functions.php';

    if(isset($_POST["signin"])){
        if(login($_POST) === 1){
            // set session
            $_SESSION["signin"] =  True;
            $_SESSION["nip"] = $_POST["nip"];

            // redirect to home page
            header("Location: ../Home/home.php");
            exit;
        }
        // for error message
        $error = True;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./Asset/Logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="sign-in-side.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap">
    <title>SIGN IN</title>
</head>

<body>
    <header id="header-background">
        <div class="alert-container <?php if($_SESSION["add"] == True) : 
                echo 'active'; 
                // set one time only
                $_SESSION["add"] = False; 
                endif; ?>">
            <div class="alert">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                <p>SUCCESSFULLY REGISTERED, SIGN IN NOW!</p>
            </div>
        </div>
        <div class="header">
            <nav>
                <img class="logo-bca" src="./Asset/Bank BCA Logo (PNG-1080p) - FileVector69 1.svg">
                <div class="line-1"></div>
                <h2 class="title">B-Lib</h2>
            </nav>
            <br>
            <div class="line-container">
                <div class="line-2"></div>
            </div>
            <div class="register">
                <img class="book-image" src="./Asset/banner-img-books.png" >
                <h1 class="register-text">BCA Learning Institute <br> Web Library</h1>
            </div>
        </div>
    </header>

    <div class="rectangle">
        <div class="form-container">
            <div class="flex-container">
                <div class="side-image">
                    <img class="side-image" src="./Asset/luwi.png">
                </div>

                <div class="side-form">
                    <div class="box-text-title">
                        <div class="create-account">
                            <h1>Start Reading Now!</h1>
                            <p>Continuous learning is key to our journey <br>to becoming future-proof.</p>
                        </div>
                    </div>
                    
                    <form action="" method="post" id="form">
                        <?php if(isset($error)) : ?>
                            <p class="error">Authentification failed!</p>
                        <?php endif; ?>

                        <div class="form-input">
                            <input type="text" name="nip" id="nip" placeholder="Enter your NIP" <?php if(isset($error)): echo 'autofocus'?> <?php endif; ?>>
                            <p class="error" id="nip-validation"></p>
                        </div>

                        <div class="form-input">
                            <input type="password" name="password" id="password" placeholder="Enter your Password">
                            <p class="error" id="password-validation"></p>
                        </div>
            
                        <button type="submit" name="signin" id="signin">SIGN IN</button>
                        
                        <div class="signup-link">
                            <p>Don't have an account?</p>
                            <a class="link-register" href="../Sign Up/sign-up.php">SIGN UP!</a>
                        </div>
                    </form>
                </div>
            </div>
        </div> 
    </div>
    <footer>
        <div class="rectangle-footer">
            <div id="footer">
                <img class="footer-background" src="./Asset/Rectangle 31.png">
                <div class="footer-text">
                    <div class="footer-text-group">
                        <h1 class="footer-title">B-Lib</h1>
                        <p class="footer-contact">Having a Problem? <span><a  class="contact" href="https://api.whatsapp.com/send?phone=6287858885955">Contact Us!</a></span></p>
                        <div class="line-3"></div>
                        <p class="footer-copyright">Copyright &copy;2022 All Rights Reserved | Designed by SOS</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>   
    
    <script src="sign-in.js"></script>
</body>
</html>