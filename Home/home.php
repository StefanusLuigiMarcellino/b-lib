<?php 
    session_start();

    require '../Functions/functions.php';
    if(!isset($_SESSION["signin"])){
        // redirect to sign in page
        header("Location: ../Sign In/sign-in.php");
        exit;
    }

    $data = getData($_SESSION["nip"]);
    
    // return the book automatically
    $nip = $_SESSION["nip"];
    $todaydate = date('Y-m-d');
    returnAuto($todaydate, $nip);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./Asset/Logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="home-side.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap">
    <title>HOME</title>
</head>

<body>
    <header>
        <div class="alert-container 
            <?php if($_SESSION["signin"] == True) : 
                echo 'active'; 
                // set one time only
                $_SESSION["signin"] = False; 
                endif; ?>">
            <div class="alert">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                <p>SUCCESSFULLY SIGNED IN!</p>
            </div> 
        </div>
        <div class="header">
            <nav>
                <div class="bca-logo-img">
                    <img class="logo-bca" src="./Asset/Bank BCA Logo (PNG-1080p) - FileVector69 1.svg">
                </div>
                <h2 class="title">B-Lib</h2>
                <div class="line-1"></div>
                <ul>
                    <li><a href="home.php" class="active">Home</a></li>
                    <li><a href="../Catalogs/catalogs.php">Catalogs</a></li>
                    <li><a href="../My Books/mybooks.php">My Books</a></li>
                </ul>

                <a href="../Functions/sign-out.php" class="signout">SIGN OUT</a>
            </nav>
            <div class="line-container">
                <div class="line-2"></div>
            </div>
        </div>
    </header>
    <section id="header-background">
        <div class="welcome">
            <img class="book-image" src="./Asset/banner-img-books.png" >
            <p class="welcome-text">Hi, Welcome <?php echo $data["NamaUser"]; ?>!</p>
        </div>
        <div class="date-info">
            <p class="date-text"><?php echo date('l, jS F Y'); ?></p>
        </div>
    </section>

    <div class="history-text">
        <h1 class="history-title">Our History</h1>
        <p>The work of embracing both the effective and the quantitative,<br>developing thriving online library to help you learn easy</p>
        <br>
        <div class="line-between-text"></div>
        <br>
        <p class="main-text"><span class="bold-text">B-Lib</span> is an interactive web library founded in 2022 by group project, <span class="bold-text">SOS (Six One Six)</span>. Starting from the development of features over time which creates one great online library. The focus of B-Lib is to reach the efficiency of borrowing book system, provides books to equip the inhabitant of BCA Learning Institute and many others. B-Lib has a mission to provide and expand quality education in reading books for all users. We also hope that we can provide an interesting reading experience that hopefully, of course can be useful for all of the users.</p>
    </div>

    <div class="home-middle-image">
        <img class="mid-image" src="./Asset/image-middle.png">
    </div>

    <div class="registered-book-text">
        <div class="flex-text">
            <div class="left-text">
                <p>Over 2000 books registered with the official<br> license straight from the authors and also the<br> e-book for some books.</p>
            </div>
            <div class="middletext-line"></div>
            <div class="right-text">
                <p>2000++ Books</p>
            </div>
        </div>
    </div>

    <div class="lower-content">
        <div class="flex-image-text">
            <div class="image-lower">
                <img class="image-lower" src="./Asset/home-learner.png">
            </div>
            <div class="flex-text-inside"></div>
            <div class="text-inside-left">
                <p>Be a learner for life</p>
            </div>
            <div class="middletext-line2"></div>
            <div class="text-inside-right">
                <p>There is always a room for improvement <br> Learn the BCA way and become industry-ready to grow in<br> your career</p>
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
    <script src="home.js"></script>
</body>
</html>