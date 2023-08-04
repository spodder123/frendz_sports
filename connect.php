<?php
    if (!defined('DB_DSN')) {
        define('DB_DSN', 'mysql:host=localhost;dbname=frendz_sports;charset=utf8');
    }

    if (!defined('DB_USER')) {
        define('DB_USER', 'root');
    }

    if (!defined('DB_PASS')) {
        define('DB_PASS', '');
    }





    // define('DB_DSN','mysql:host=localhost;dbname=frendz_sports;charset=utf8');
    // define('DB_USER','root');
     //define('DB_PASS','');

     try {
         $db = new PDO(DB_DSN, DB_USER, DB_PASS);
     } catch (PDOException $e) {
         print "Error: " . $e->getMessage();
         die();

     }
 ?>