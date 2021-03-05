<?php
try {

    // Veritabanı Bağlantısı, dbname=veritabanıadı
    // Not: Veritabanı Adı, 'ders'
    $db = new PDO("mysql:host=localhost;dbname=ders;charset=utf8", 'root', '');

    //echo "Veritabanı bağlantısı başarılı";

} catch (PDOException $e) {

    echo $e->getMessage();
}
