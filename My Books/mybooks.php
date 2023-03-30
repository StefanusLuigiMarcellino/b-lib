<?php
    session_start();

    require '../Functions/functions.php';
    if(!isset($_SESSION["signin"])){
        // redirect to sign in page
        header("Location: ../Sign In/sign-in.php");
        exit;
    }

    // get current reads books
    $pres = getPCurrMyBooks($_SESSION["nip"]);
    $eres = getECurrMyBooks($_SESSION["nip"]);

    // get finished reading books
    $fpres = getPFinishMyBooks($_SESSION["nip"]);
    $feres = getEFinishMyBooks($_SESSION["nip"]);

    if(isset($_POST["book"])){
        // set session
        $_SESSION["book"] = $_POST["book"];
        header("Location: ../Book-Desc-Physical/bookdesc-physical.php");
        exit;
    }

    if(isset($_POST["ebook"])){
        // set session
        $_SESSION["ebook"] = $_POST["ebook"];
        header("Location: ../Book-Desc-Ebook/bookdesc-ebook.php");
        exit;
    }

    $currentRead = False;
    $finishRead = False;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./Asset/Logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="mybooks-side.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap">
    <title>My Books</title>
</head>

<body>
    <header>
        <div class="alert-container
                <?php if($_SESSION["borrow"] == True){
                    echo 'active';
                    // set one time only
                    $_SESSION["borrow"] = False;
                }?>">
            <div class="alert">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                <p>SUCCESSFULLY BORROWED!</p>
            </div> 
        </div>
        <div class="alert-container-return
                <?php if($_SESSION["return"] == True){
                    echo 'active';
                    // set one time only
                    $_SESSION["return"] = False;
                }?>">
            <div class="alertReturn">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                <p>THE BOOK IS SUCCESSFULLY RETURNED!</p>
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
                    <li><a href="../Home/home.php">Home</a></li>
                    <li><a href="../Catalogs/catalogs.php">Catalogs</a></li>
                    <li><a href="../My Books/mybooks.html" class="active">My Books</a></li>
                </ul>

                <a href="../Functions/sign-out.php" class="signout">SIGN OUT</a>
            </nav>
            <div class="line-container">
                <div class="line-2"></div>
            </div>
        </div>
    </header>
    <section id="header-background">
        <div class="quote-container">
            <div class="quote">
                <h1 class="quote-text">“A room without books is like a body without a soul.”</h1>
            </div>
            <div class="quote-person">
                <h1 class="quote-name">- Marcus Tullius Cicero -</h1>
            </div>
        </div>
    </section>

    <div class="boxunderimage">
        <h1>Current Reads</h1>
        <div class="headerlinecontainer">
            <div class="headerline"></div>
        </div>
    </div>

    <div class="book-container">
        <form action="" method="post" class="list-container">
            <?php while($fetch_pres = mysqli_fetch_assoc($pres)) : ?>
                <button type="submit" name="book" class="box-container" value="<?= $fetch_pres["BookID"] ?>">
                    <div class="image-container">
                        <img class="book-image" src="../<?= $fetch_pres["CoverImg"]?>">
                    </div>
                    <div class="text-in-box">
                        <h1 class="book-title"><?= $fetch_pres["Judul"]; ?></h1>
                        <p class="book-author"><?= $fetch_pres["Penulis"]; ?></p>
                    </div>
                </button>
                <?php $currentRead = True; ?>
            <?php endwhile; ?>
            <?php while($fetch_eres = mysqli_fetch_assoc($eres)) : ?>
                <button type="submit" name="ebook" class="box-container" value="<?= $fetch_eres["E-BookID"]?>">
                    <div class="ebook-mark-container">
                        <img src="./Asset/label.svg" class="ebook-mark-img">
                    </div>
                    <div class="image-container">
                        <img class="book-image" src="../<?= $fetch_eres["CoverImgE-Book"]?>">
                    </div>
                    <div class="text-in-box">
                        <h1 class="book-title"><?= $fetch_eres["JudulE-Book"]; ?></h1>
                        <p class="book-author"><?= $fetch_eres["PenulisE-Book"]; ?></p>
                    </div>
                </button>
                <?php $currentRead = True; ?>
            <?php endwhile; ?>
        </form>

        <div class="no-books
                <?php if($currentRead == False){
                    echo 'active';
                }?>">
            <img class="currentImg"src="./Asset/CurrentRead.png" alt="">
            <p class="currentText">You haven't borrowed any books. Let's find one!</p>
        </div>
    </div>

    <div class="boxunderimage">
        <h1>Finished Reading</h1>
        <div class="headerlinecontainer">
            <div class="headerline"></div>
        </div>
    </div>

    <div class="book-container">
        <form action="" method="post" class="list-container">
            <?php while($fetch_fpres = mysqli_fetch_assoc($fpres)) : ?>
                <button type="submit" name="book" class="box-container" value="<?= $fetch_fpres["BookID"] ?>">
                    <div class="image-container">
                        <img class="book-image" src="../<?= $fetch_fpres["CoverImg"]; ?>">
                    </div>
                    <div class="text-in-box">
                        <h1 class="book-title"><?= $fetch_fpres["Judul"]; ?></h1>
                        <p class="book-author"><?= $fetch_fpres["Penulis"]; ?></p>
                    </div>
                </button>
                <?php $finishRead = True; ?>
            <?php endwhile; ?>
            <?php while($fetch_feres = mysqli_fetch_assoc($feres)) : ?>
                <button type="submit" name="ebook" class="box-container" value="<?= $fetch_feres["E-BookID"] ?>">
                    <div class="ebook-mark-container">
                        <img src="./Asset/label.svg" class="ebook-mark-img">
                    </div>
                    <div class="image-container">
                        <img class="book-image" src="../<?= $fetch_feres["CoverImgE-Book"]; ?>">
                    </div>
                    <div class="text-in-box">
                        <h1 class="book-title"><?= $fetch_feres["JudulE-Book"]; ?></h1>
                        <p class="book-author"><?= $fetch_feres["PenulisE-Book"]; ?></p>
                    </div>
                </button>
                <?php $finishRead = True; ?>
            <?php endwhile; ?>
        </form>
        <div class="no-books
                <?php if($finishRead == False){
                    echo 'active';
                }?>">
            <p class="finishedText">You haven't finished reading any books.</p>
            <img class="finishedImg"src="./Asset/FinishedRead.png" alt="">
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
    <script src="mybooks.js"></script>
</body>
</html>