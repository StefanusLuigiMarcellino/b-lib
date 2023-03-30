<?php 
    $conn = mysqli_connect("localhost", "root", "", "b-lib");

    function registration($data){
        global $conn;

        $nip = htmlspecialchars($data["nip"]);
        $nama = htmlspecialchars(stripslashes($data["name"]));
        $program = htmlspecialchars($data["program"]);
        $email = htmlspecialchars($data["email"]);
        $password = htmlspecialchars(mysqli_real_escape_string($conn, $data["password"]));

        // check available NIP
        $res = mysqli_query($conn, "SELECT NIP FROM user WHERE NIP = '$nip'");
        if(mysqli_fetch_assoc($res)){
            return -1;
        }

        // encrypt password
        $password = password_hash($password, PASSWORD_DEFAULT);
        
        // add user to database
        mysqli_query($conn, "INSERT INTO user VALUES ('$nip', '$nama', '$program', '$email', '$password')");

        return mysqli_affected_rows($conn);
    }

    function login($data){
        global $conn;

        $nip = $data["nip"];
        $password = $data["password"];

        $res = mysqli_query($conn, "SELECT * FROM user WHERE NIP = '$nip'");

        // check nip
        if(mysqli_num_rows($res) === 1){
            // verify password
            $fetch_res = mysqli_fetch_assoc($res);
            if(password_verify($password, $fetch_res["Password"])){
                return 1;
            }
        }
    }

    function getData($data){
        global $conn;
        $nip = $data;
        $res = mysqli_query($conn, "SELECT * FROM user WHERE NIP = '$nip'");

        if(mysqli_num_rows($res) === 1){
            return mysqli_fetch_assoc($res);
        }
    }

    function getPBookCatalogs(){
        global $conn;
        $res = mysqli_query($conn, "SELECT * FROM physicalbook LIMIT 4");
        return $res;
    }

    function getEBookCatalogs(){
        global $conn;
        $res = mysqli_query($conn, "SELECT * FROM `e-book` LIMIT 4");
        return $res;
    }

    function getPBookCatalogsGenre($data){
        global $conn;
        $genre = $data;
        $res = mysqli_query($conn, "SELECT * FROM physicalbook WHERE Genre = '$genre' LIMIT 4");
        return $res;
    }

    function getEBookCatalogsGenre($data){
        global $conn;
        $genre = $data;
        $res = mysqli_query($conn, "SELECT * FROM `e-book`WHERE `GenreE-Book` = '$genre' LIMIT 4");
        return $res;
    }

    function getPBook($data){
        global $conn;
        $id = $data;
        $res = mysqli_query($conn, "SELECT * FROM physicalbook WHERE BookID = '$id'");

        if(mysqli_num_rows($res) === 1){
            return mysqli_fetch_assoc($res);
        }
    }

    function getEBook($data){
        global $conn;
        $id = $data;
        $res = mysqli_query($conn, "SELECT * FROM `e-book` WHERE `E-BookID` = '$id'");

        if(mysqli_num_rows($res) === 1){
            return mysqli_fetch_assoc($res);
        }
    }

    function getPCurrMyBooks($nip){
        global $conn;
        $res = mysqli_query($conn, "SELECT * FROM peminjaman p JOIN physicalbook pb ON p.BookID = pb.BookID WHERE p.TglKembali IS NULL AND p.NIP = '$nip'");
        return $res;
    }

    function getECurrMyBooks($nip){
        global $conn;
        $res = mysqli_query($conn, "SELECT * FROM `e-peminjaman` ep JOIN `e-book` epb ON ep.`E-BookID` = epb.`E-BookID` WHERE `E-tglKembali` IS NULL AND NIP = '$nip'");
        return $res;
    }

    function getPFinishMyBooks($nip){
        global $conn;
        $res = mysqli_query($conn, "SELECT * FROM peminjaman p JOIN physicalbook pb ON p.BookID = pb.BookID WHERE p.TglKembali IS NOT NULL AND p.NIP = '$nip'");
        return $res;
    }

    function getEFinishMyBooks($nip){
        global $conn;
        $res = mysqli_query($conn, "SELECT * FROM `e-peminjaman` ep JOIN `e-book` epb ON ep.`E-BookID` = epb.`E-BookID` WHERE `E-tglKembali` IS NOT NULL AND NIP = '$nip'");
        return $res;
    }

    function updatePeminjamanTable($bookid, $nip, $time){
        global $conn;
        mysqli_query($conn, "UPDATE peminjaman 
                            SET BatasPeminjaman = BatasPeminjaman + $time,
                            Perpanjangan = 1
                            WHERE BookID = '$bookid' AND NIP = '$nip'");
    }

    function updateEPeminjamanTable($bookid, $nip, $time){
        global $conn;
        mysqli_query($conn, "UPDATE `e-peminjaman` 
                            SET `E-BatasPeminjaman` = `E-BatasPeminjaman` + $time,
                            `E-Perpanjangan` = 1
                            WHERE `E-BookID` = '$bookid' AND NIP = '$nip'");
    }

    function borrowPBook($bookid, $nip){
        global $conn;
        $res = mysqli_query($conn, "SELECT * FROM peminjaman WHERE BookID = '$bookid' AND NIP = '$nip' AND TglKembali IS NULL");
        return mysqli_num_rows($res);
    }

    function extendPBook($bookid, $nip){
        global $conn;
        $res = mysqli_query($conn, "SELECT * FROM peminjaman WHERE BookID = '$bookid' AND NIP = '$nip' AND Perpanjangan = 0");
        return mysqli_num_rows($res);
    }

    function borrowEBook($bookid, $nip){
        global $conn;
        $res = mysqli_query($conn, "SELECT * FROM `e-peminjaman` WHERE `E-BookID` = '$bookid' AND NIP = '$nip' AND `E-tglKembali` IS NULL");
        return mysqli_num_rows($res);
    }

    function extendEBook($bookid, $nip){
        global $conn;
        $res = mysqli_query($conn, "SELECT * FROM `e-peminjaman` WHERE `E-BookID` = '$bookid' AND NIP = '$nip' AND `E-Perpanjangan` = 0");
        return mysqli_num_rows($res);
    }

    function returnPBook($bookid, $nip, $tglKembali){
        global $conn;
        mysqli_query($conn, "UPDATE peminjaman
                            SET TglKembali = '$tglKembali'
                            WHERE BookID = '$bookid' AND NIP = '$nip'");
    }

    function returnEBook($bookid, $nip, $tglKembali){
        global $conn;
        mysqli_query($conn, "UPDATE `e-peminjaman`
                            SET `E-tglKembali` = '$tglKembali'
                            WHERE `E-BookID` = '$bookid' AND NIP = '$nip'");
    }

    function returnAuto($todayDate, $nip){
        global $conn;
        mysqli_query($conn, "UPDATE `e-peminjaman` ep JOIN `e-book` eb ON ep.`E-BookID` = eb.`E-BookID`
                            SET eb.`StokE-Book` = eb.`StokE-Book` + 1,
                            ep.`E-tglKembali` = '$todayDate'
                            WHERE DATEDIFF('$todayDate', ep.`E-tglPinjam`) >= ep.`E-BatasPeminjaman` AND ep.NIP = '$nip' AND ep.`E-tglKembali` IS NULL");
    }

    function daysEBook($bookid, $nip){
        global $conn;
        $res = mysqli_query($conn, "SELECT `E-BatasPeminjaman` - DATEDIFF(CURDATE(), `E-tglPinjam`) as 'days'
                            FROM `e-peminjaman` WHERE `E-BookID` = '$bookid' AND NIP = '$nip'");
        return mysqli_fetch_assoc($res);
    }

    function daysPBook($bookid, $nip){
        global $conn;
        $res = mysqli_query($conn, "SELECT BatasPeminjaman - DATEDIFF(CURDATE(), TglPinjam) as 'days'
                            FROM peminjaman WHERE BookID = '$bookid' AND NIP = '$nip'");
        return mysqli_fetch_assoc($res);
    }
?>