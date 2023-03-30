<?php
    session_start();

    require '../Functions/functions.php';

    $book = getPBook($_SESSION["extend"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./Asset/Logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="successpbook.css">
    <title>Extend Time</title>
</head>
<body>
    <div class="container">
        <div class="header">
            <p class="title">Successed!</p>
        </div>

        <div class="content">
            <div class="box">
                <div class="coverBox">
                    <div class="cover">
                        <img src="../<?= $book["CoverImg"]; ?>" alt="">
                    </div>
                    <div class="bContainer">
                        <p class="bTitle"><?= $book["Judul"]; ?></p> 
                    </div>
                    <p class="bWriter"><?= $book["Penulis"]; ?></p>
                </div>
                <p class="text">The book has been successfully extended!</p>
                <div class="Menu">
                    <a href="../My Books/mybooks.php" class="return-to-my-books">Back to My Books</a>
                </div>
            </div>
        </div>

    </div>

    
    

</body>
</html>