<?php

    require_once("dbconnection.php");

    //Korisnicki podaci
    $korisnicko = $_POST['nUser']??"Anonimus";
    $email = $_POST['nEmail']??"";
    $sifra = $_POST['nPass']??"";


    //Validacija podataka
    $korisnicko=filter_var($korisnicko,FILTER_SANITIZE_STRING);
    if(!filter_var($email,FILTER_VALIDATE_EMAIL))
    {
        
        die("<h2>Email adresa nije dobra!</h2>");
        
    }
    $email = filter_var($email,FILTER_SANITIZE_EMAIL);
    
    $pattern="/[a-zA-Z0-9$!@#]{9,}/gm";
    if(!preg_match("/[a-zA-Z0-9$!@#]{9,}/",$sifra))
    {
        die("Sifra nije dobra!");
    }

    $sifra = sha1($sifra."@#$%tt180"); //pass sa dodatkom
    //Insert into db

    $stmt = $conn->prepare("INSERT INTO `korisnici` (`id`, `username`, `password`, `email`, `role`, `ts`) VALUES (NULL, ?, ?, ?, 'sub', current_timestamp())");
    $stmt->bind_param("sss",$korisnicko,$sifra,$email);
    if($stmt->execute())
    {
        echo("Uspesno ste se registrovali!");
    }
    else{
        echo("GRESKA!");
    }
    
?>