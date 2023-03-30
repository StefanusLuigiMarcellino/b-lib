<?php 
    session_start();

    require '../Functions/functions.php';

    $ebook = getEBook($_SESSION["ebook"]);
    $bookid = $ebook["E-BookID"];
    $nip = $_SESSION["nip"];
    $todaydate = date('Y-m-d');
    $dayremain = daysEBook($bookid, $nip);
    
    // borrow button clicked
    if(isset($_POST["borrow"])){
        // set borrow session True
        $_SESSION["borrow"] = True;

        // insert data to e-peminjaman table
        if($ebook["StokE-Book"] > 0){
            $bataspeminjaman = 14;
    
            $res = mysqli_query($conn, "INSERT INTO `e-peminjaman` (`E-BookID`, NIP, `E-TglPinjam`, `E-BatasPeminjaman`) VALUES ('$bookid', '$nip', '$todaydate', '$bataspeminjaman')");
            
            // update the stock (min 1)
            mysqli_query($conn, "UPDATE `e-book` SET `StokE-Book` = `StokE-Book` - 1 WHERE `E-BookID` = '$bookid'");

            // redirect to my books page
            header("Location: ../My Books/mybooks.php");
            exit;
        }else{
            // set flag for showing alert
            $emptystock = True;
        }
    }

    // read button clicked
    if(isset($_POST["read"])){
        header("Location: ../Read Book/readbook.php");
        exit;
    }

    // extend button clicked
    if(isset($_POST["extend"])){
        $_SESSION["extend"] = $_POST["extend"];
        header("Location: ../ExtendReqTime/extendebook.php");
        exit;
    }

    // return button clicked
    if(isset($_POST["return"])){
        returnEBook($bookid, $nip, $todaydate);

        // update the stock (plus 1)
        mysqli_query($conn, "UPDATE `e-book` SET `StokE-Book` = `StokE-Book` + 1 WHERE `E-BookID` = '$bookid'");

        // set session return True
        $_SESSION["return"] = True;

        // redirect to my books page
        header("Location: ../My Books/mybooks.php");
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
    <link rel="stylesheet" href="bookdescebook-side.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap">
    <title>Book Desc-Ebook</title>
</head>

<body>
    <div class="alert-container
            <?php if($_SESSION["borrow"] == True) {
                if($emptystock == True){
                    echo 'active';
                    // set one time only
                    $_SESSION["borrow"] = False;
                    $emptystock = False;
                }
            } ?>">
        <div class="alert">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            <p>THE E-BOOK IS OUT OF STOCK!</p>
        </div>
    </div>
    <div class="flex-content">
        <div class="left-content">
            <div class="cover-container">
                <div class="book">
                    <img class="book-image" src="../<?= $ebook["CoverImgE-Book"]; ?>">
                </div>

                <form action="" method="post">
                    <div class="borrow
                                <?php if(borrowEBook($bookid, $nip) == 0): echo 'active'; endif; ?>">
                        <button type="submit" name="borrow" class="borrow-book">Borrow Book</button>
                    </div>

                    <div class="read-ext-ret
                                <?php if(borrowEBook($bookid, $nip) == 0): echo 'none'; endif; ?>">
                        <div class="readbook">
                            <button type="submit" name="read" value="" class="readbutton">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path fill="currentColor" d="m19 1l-5 5v11l5-4.5V1m2 4v13.5c-1.1-.35-2.3-.5-3.5-.5c-1.7 0-4.15.65-5.5 1.5V6c-1.45-1.1-3.55-1.5-5.5-1.5c-1.95 0-4.05.4-5.5 1.5v14.65c0 .25.25.5.5.5c.1 0 .15-.05.25-.05C3.1 20.45 5.05 20 6.5 20c1.95 0 4.05.4 5.5 1.5c1.35-.85 3.8-1.5 5.5-1.5c1.65 0 3.35.3 4.75 1.05c.1.05.15.05.25.05c.25 0 .5-.25.5-.5V6c-.6-.45-1.25-.75-2-1M10 18.41C8.75 18.09 7.5 18 6.5 18c-1.06 0-2.32.19-3.5.5V7.13c.91-.4 2.14-.63 3.5-.63c1.36 0 2.59.23 3.5.63v11.28Z"/></svg>   
                            </button>
                            <div class="hide">Read Book</div>
                        </div>
                        
                        <div class="extendtime
                                    <?php if(extendEBook($bookid, $nip) > 0): echo 'active'; endif;  ?>">
                            <button type="submit" name="extend" value="<?= $ebook["E-BookID"]; ?>" class="extendbutton">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path fill="currentColor" d="M10 8v6l4.7 2.9l.8-1.2l-4-2.4V8z"/><path fill="currentColor" d="M17.92 12A6.957 6.957 0 0 1 11 20c-3.9 0-7-3.1-7-7s3.1-7 7-7c.7 0 1.37.1 2 .29V4.23c-.64-.15-1.31-.23-2-.23c-5 0-9 4-9 9s4 9 9 9a8.963 8.963 0 0 0 8.94-10h-2.02z"/><path fill="currentColor" d="M20 5V2h-2v3h-3v2h3v3h2V7h3V5z"/></svg>
                            </button>
                            <div class="hide">Extend Time</div>
                        </div>
                        
                        <div class="returnbook">
                            <button type="submit" name="return" value="" class="returnbutton">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M14 20H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h12v5"/><path d="M11 16H6a2 2 0 0 0-2 2m11-2l3-3l3 3m-3-3v9"/></g></svg>
                            </button>
                            <div class="hide">Return Book</div>
                        </div>
                    </div>
                    
                    <div class="daysremaining
                                <?php if(borrowEBook($bookid, $nip) == 0): echo 'none'; endif; ?>">
                        <p class="daystext"><?= $dayremain['days']; ?> day(s) remaining!</p>
                    </div>
                </form>
            </div>
        </div>

        <div class="right-content">
            <div class="right-header">
                <h2 class="book-title"><?= $ebook["JudulE-Book"]; ?></h2>
                <p class="book-author"><?= $ebook["PenulisE-Book"]; ?></p>
            </div>
            <div class="line-at-right"></div>
            <div class="book-description">
                <h3 class="bookdesc-title">Book Description</h3>
                <p class="description"><?= $ebook["BlurbE-Book"]; ?></p>
            </div>
            <div class="book-detail">
                <h3 class="bookdetail-title">Book Detail</h3>
                <div class="detail-container">
                    <div class="left-detail">
                        <h4>Total Page</h4>
                        <p><?= $ebook["JumlahHalamanE-Book"]; ?></p>
                        <h4>Publisher</h4>
                        <p><?= $ebook["PenerbitE-Book"]; ?></p>
                        <h4>Genre</h4>
                        <p><?= $ebook["GenreE-Book"]; ?></p>
                    </div>
                    <div class="right-detail">
                        <h4>ISBN</h4>
                        <p><?= $ebook["ISBNE-Book"]; ?></p>
                        <h4>Stock</h4>
                        <p><?= $ebook["StokE-Book"]; ?></p>
                        <h4>File Size</h4>
                        <p><?= $ebook["UkuranFile"]; ?> MB</p>
                    </div>
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
</body>
</html>