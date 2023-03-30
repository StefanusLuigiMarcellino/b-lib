<?php 
    session_start();

    require '../Functions/functions.php';
    if(!isset($_SESSION["signin"])){
        // redirect to sign in page
        header("Location: ../Sign In/sign-in.php");
        exit;
    }

    $data = getData($_SESSION["nip"]);

    // set session genre
    if(isset($_POST["genre"])){
        $_SESSION["genre"] = $_POST["genre"];
        $_GET["page"] = 1;
    }

    // get page for pagination
    $totalDataEachPage = 12;
    if(isset($_SESSION["genre"]) and $_SESSION["genre"] == 'All'){
        $res = mysqli_query($conn, "SELECT * FROM `e-book`");
    }elseif(isset($_SESSION["genre"])){
        $genre = $_SESSION["genre"];
        $res = mysqli_query($conn, "SELECT * FROM `e-book` WHERE `GenreE-Book` = '$genre'");
    }
    $totalData = mysqli_num_rows($res);
    $totalPage = ceil($totalData / $totalDataEachPage);
    $activePage = (isset($_GET["page"])) ? $_GET["page"] : 1;
    $firstData = ($totalDataEachPage * $activePage) - $totalDataEachPage;
    if(isset($_SESSION["genre"]) and $_SESSION["genre"] == 'All'){
        $eres = mysqli_query($conn, "SELECT * FROM `e-book` LIMIT $firstData, $totalDataEachPage");
    }elseif(isset($_SESSION["genre"])){
        $genre = $_SESSION["genre"];
        $eres = mysqli_query($conn, "SELECT * FROM `e-book` WHERE `GenreE-Book` = '$genre' LIMIT $firstData, $totalDataEachPage");
    }

    if(isset($_POST["ebook"])){
        // set session
        $_SESSION["ebook"] = $_POST["ebook"];
        header("Location: ../Book-Desc-Ebook/bookdesc-ebook.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./Asset/Logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="ebook-side.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap">
    <title>E-Book</title>
</head>

<body>
    <header>
        <div class="header">
            <nav>
                <div class="bca-logo-img">
                    <img class="logo-bca" src="./Asset/Bank BCA Logo (PNG-1080p) - FileVector69 1.svg">
                </div>
                <h2 class="title">B-Lib</h2>
                <div class="line-1"></div>
                <ul>
                    <li><a href="../Home/home.php">Home</a></li>
                    <li><a href="../Catalogs/catalogs.php" class="active">Catalogs</a></li>
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
        <div class="quote-container">
            <div class="quote">
                <h1 class="quote-text">“I do believe something very magical can happen when you read a good book.”</h1>
            </div>
            <div class="quote-person">
                <h1 class="quote-name">- J. K. Rowling -</h1>
            </div>
        </div>
    </section>

    <div class="flex-content">
        <div class="left-content">
            <h1 class="filter-title">FILTER</h1>
            <!-- <p>Category</p>
            <li><a href="#">Physical Book</a></li>
            <li><a href="#">E-Book</a></li> -->
            <p>Genre</p>
            <form action="" method="post">
                <button type="submit" name="genre" class="genre 
                    <?php if(isset($_SESSION["genre"]) and $_SESSION["genre"] == 'Economy') : echo 'active'; endif;?>" value="Economy">Economy</button>
                <button type="submit" name="genre" class="genre
                    <?php if(isset($_SESSION["genre"]) and $_SESSION["genre"] == 'Technology') : echo 'active'; endif;?>" value="Technology">Technology</button>
                <button type="submit" name="genre" class="genre 
                    <?php if(isset($_SESSION["genre"]) and $_SESSION["genre"] == 'Education') : echo 'active'; endif;?>" value="Education">Education</button>
                <button type="submit" name="genre" class="genre 
                    <?php if(isset($_SESSION["genre"]) and $_SESSION["genre"] == 'Fiction') : echo 'active'; endif;?>" value="Fiction">Fiction</button>
                <button type="submit" name="genre" class="genre 
                    <?php if(isset($_SESSION["genre"]) and $_SESSION["genre"] == 'All') : echo 'active'; endif;?>" value="All">All</button>
            </form>
        </div>
        <div class="right-content">

            <!-- Ebook -->

            <div class="book-header-container">
                <div class="book-title-line">
                    <h1 class="ebook-title">E-Book</h1>
                    <img class="line-with-circle" src="./Asset/mark.svg">
                </div>
            </div>
            <form action="" method="post" class="list-container">
                <?php while($fetch_eres = mysqli_fetch_assoc($eres)) : ?>
                    <button type="submit" name="ebook" class="box-container" value="<?= $fetch_eres["E-BookID"] ?>">
                        <div class="ebook-mark-container">
                            <img src="./Asset/label.svg" class="ebook-mark-img">
                        </div>
                        <div class="image-container">
                            <img class="book-image" src="../<?= $fetch_eres["CoverImgE-Book"]; ?>">
                        </div>
                        <div class="text-in-box">
                            <h1 class="book-title"><?= $fetch_eres["JudulE-Book"]; ?></h1>
                            <p class="book-author"><?= $fetch_eres["PenulisE-Book"]; ?></p>
                        </div>         
                    </button>
                <?php endwhile; ?>
            </form>
        </div>
    </div>

    <!-- pagination -->
    
    <div class="pagination-container">
        <div class="pagination">
            <?php if($activePage > 1): ?>
                <a href="?page=<?= $activePage-1; ?>" class="page">&laquo;</a>
            <?php endif; ?>

            <?php for($i = 1; $i <= $totalPage; $i++): ?>
                <?php if($i == $activePage): ?>
                    <a href="?page=<?= $i; ?>" class="page active"><?= $i; ?></a>
                <?php else: ?>
                    <a href="?page=<?= $i; ?>" class="page"><?= $i; ?></a>
                <?php endif; ?>
            <?php endfor;  ?>

            <?php if($activePage < $totalPage): ?>
                <a href="?page=<?= $activePage+1; ?>" class="page">&raquo;</a>
            <?php endif; ?>
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
    <script src="ebook.js"></script>
</body>
</html>