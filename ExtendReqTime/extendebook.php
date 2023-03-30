<?php
    session_start();

    require '../Functions/functions.php';

    $ebook = getEBook($_SESSION["extend"]);
    $bookid = $ebook["E-BookID"];
    $nip = $_SESSION["nip"];
    $radiochecked = True;

    if(isset($_POST["submit"])){
        if(empty(isset($_POST["radio"]))){
            $radiochecked = False;
        }else{
            $time = $_POST["radio"];
            updateEPeminjamanTable($bookid, $nip, $time);
            header("Location: successebook.php");
            exit;
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
    <link rel="stylesheet" href="extendebook.css">
    <title>Extend Time</title>
</head>
<body>
    <div class="container">
        <div class="header">
            <p class="title">Extend this book?</p>
        </div>

        <div class="content">
            <div class="coverBox">
                <div class="ebook-mark-container">
                    <img src="./Asset/label.png" class="eImage">
                </div>
                <div class="cover">
                    <img src="../<?= $ebook["CoverImgE-Book"]; ?>" alt=""> 
                </div>
                <div class="bContainer">
                    <p class="bTitle"><?= $ebook["JudulE-Book"]; ?></p> 
                </div>
                <p class="bWriter"><?= $ebook["PenulisE-Book"]; ?></p>
            </div>
            
            <!-- method : post -->
            <form action="" method="post" class="form">
                <p class="fText">Duration</p>
                <img class="line" src="Asset\line.png" alt="">

                <p class="unchecked-radio">
                    <?php 
                        if(isset($_POST["submit"]) and $radiochecked == False){
                            echo 'Please choose the extension duration!';
                        }
                    ?>
                </p>
                <div class="input">
                    <div class="input-radio">
                        <input type="radio" name="radio" id="rad1" value="1">
                        <p class="space">......</p>
                        <label class="label-radio" for="rad1">A day</label><br>
                    </div>
                    <div class="input-radio">
                        <input type="radio" name="radio" id="rad2" value="2">
                        <p class="space">......</p>
                        <label class="label-radio" for="rad2">2 days</label><br>
                    </div>
                    <div class="input-radio">
                        <input type="radio" name="radio" id="rad3" value="3">
                        <p class="space">......</p>
                        <label class="label-radio" for="rad3">3 days</label><br>
                    </div>
                </div>
                <p class="reason">Reason (Optional)</p>
                <img class="line" src="Asset\line.png" alt="">
                <input type="text" class="reasonText" placeholder="Type your reason here...">
                <p class="alert">Note: You could only extend <b>once per book.</b></p>
                <button type="submit" name="submit" class="submit">Submit</button>
            </form>
        </div>
    </div>
    
</body>
</html>