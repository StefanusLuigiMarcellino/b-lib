<?php 
    session_start();

    require '../Functions/functions.php';

    if(isset($_POST["signup"])){
        if(registration($_POST) > 0){
            // set succesfully added user
            $_SESSION["add"] = True;
            header("Location: ../Sign In/sign-in.php");
            exit;
        }else{
            $error = True;
            echo mysqli_error($conn);
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./Asset/Logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="sign-up-side.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap">
    <title>SIGN UP</title>
</head>

<body>
    <header id="header-background">
        <div class="alert-container <?php if(isset($error)) : echo 'active' ?> <?php endif; ?>">
            <div class="alert">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                <p>YOUR NIP HAS ALREADY REGISTERED!</p>
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
                <img class="book-image" src="./Asset/banner-img-books.png">
                <h1 class="register-text">Register Now, <br> Start Reading!</h1>
            </div>
        </div>
    </header>

    <div class="rectangle">
        <div class="form-container">
            <div class="flex-container">
                <div class="side-image">
                    <img class="side-image" src="./Asset/kwannie.png">
                </div>

                <div class="side-form">
                    <div class="box-text-title">
                        <div class="create-account">
                            <h1>Registration Form</h1>
                            <p> Please fill-out this form</p>
                        </div>
                    </div>

                    <form action="" method="post" id="form">
                        <div class="form-input">
                            <input type="text" name="nip" id="nip" placeholder="Enter your NIP">
                            <p class="error" id="nip-validation"></p>
                        </div>
            
                        <div class="form-input">
                            <select name="program" id="program">
                                <option value="" disabled selected hidden>Choose your Program</option>
                                <option value="PPBP">PPBP</option>
                                <option value="PPTI">PPTI</option>
                                <option value="Trainee">Trainee</option>
                                <option value="Employee">Employee</option>
                            </select>
                            <p class="error" id="program-validation"></p>
                        </div>

                        <div class="form-input">
                            <input type="text" name="name" id="name" placeholder="Enter your Name">
                            <p class="error" id="name-validation"></p>
                        </div>
            
                        <div class="form-input">
                            <input type="text" name="email" id="email" placeholder="Enter your Email">
                            <p class="error" id="email-validation"></p>
                        </div>

                        <div class="form-input">
                            <input type="password" name="password" id="password" placeholder="Enter your Password">
                            <p class="error" id="password-validation"></p>
                        </div>
            
                        <button type="submit" name="signup" id="signup">SIGN UP</button>

                        <div class="signin-link">
                            <p>Already have an account?</p>
                            <a class="link-register" href="../Sign In/sign-in.php">SIGN IN!</a>
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

    <script src="sign-up.js"></script>
</body>
</html>