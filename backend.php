<?php

// baglanti.php sayfası ile iletişim sağlama.
require_once 'baglanti.php';

// =======================================ÖĞRENCİ EKLEME İŞLEMİ============================================ //
// Öğrenci Ekle, Eğer POST ile ogrenci_ekle geldi ise
if(isset($_POST['ogrenci_ekle'])){
    $ortalama = ($_POST['not1'] + $_POST['not2'] + $_POST['not3'])/3; // Form dan POST methodu ile gelen not bilgilerinin ortalamasını hesaplama.
    
    // PDO ile Insert İşlemi, sinif tablosundaki sütünların değişkenlerini belirleme.
    $insert = $db->prepare("INSERT into sinif SET 
    isim=:a,
    soyisim=:b,
    numara=:c,
    not1=:d,
    not2=:e,
    not3=:f,
    ortalama=:g
    ");

    // Veritabanına form dan POST methodu ile gelen bilgileri yukarıda belirlenen değişkenlere görme eşitleme.
    $insert = $insert->execute(array(
        "a" => $_POST['isim'],
        "b" => $_POST['soyisim'],
        "c" => $_POST['numara'],
        "d" => $_POST['not1'],
        "e" => $_POST['not2'],
        "f" => $_POST['not3'],
        "g" => $ortalama // Yukarıda hesaplanan ortalama
    ));

    // Insert işlemi bittikten sonra kullanıcıyı index.php sayfasına islem adında bir parametre ile beraber geri gönderme.
    if($insert){
        // Insert İşlemi doğru ise islem adındaki parametre 'success' e eşitlenerek gönderilsin. *success = Başarılı
        Header("Location: index.php?islem=success");
        exit; 
    }
    else{
        // Insert işleminde bir hata varsa kullanıcıyı islem adındaki parametre 'error' a eşitlenerek index.php ye gönderilsin.
        Header("Location: index.php?islem=error");
        exit;
    }
}

// =======================================ÖĞRENCİ SİLME İŞLEMİ============================================ //
// Öğrenci Sil, eğer URL ye sil paramteresi geldi ise
if(isset($_GET['sil'])){
    /* sinif tablosundan url den gelen sil parametresinin eşit olduğu id yi sil */
    $delete = $db->prepare("DELETE from sinif where id=:a");
    $delete = $delete->execute(array(
        "a" => $_GET['sil'] // url den gelen sil parametresi tabloda tıklanılan öğrencinin id'sine eşit
    ));

    /* Öğrenci Ekle de yapılan işlemin aynısı */
    if($delete){
        Header("Location: index.php?islem=success");
        exit;
    }
    else{
        Header("Location: index.php?islem=error");
        exit;
    }
}

// =======================================ÖĞRENCİ GÜNCELLEME İŞLEMİ============================================ //
// Öğrenci Güncelle, eğer URL ye güncelle parametresi geldi ise
if(isset($_POST['ogrenci_guncelle'])){
    $ortalama = ($_POST['not1'] + $_POST['not2'] + $_POST['not3'])/3; // Form dan POST methodu ile gelen not bilgilerinin ortalamasını hesaplama.
    $update = $db->prepare("UPDATE sinif SET
        isim=:a,
        soyisim=:b,
        numara=:c,
        not1=:d,
        not2=:e,
        not3=:f,
        ortalama=:g
        where id=:h
    ");
    $update = $update->execute(array(
        "a" => $_POST['isim'],
        "b" => $_POST['soyisim'],
        "c" => $_POST['numara'],
        "d" => $_POST['not1'],
        "e" => $_POST['not2'],
        "f" => $_POST['not3'],
        "g" => $ortalama, // Yukarıda hesaplanan ortalama
        "h" => $_POST['id'] // form dan POST methodu ile gelen güncellenin eşit olduğu id(Kimlik) ye göre sınıf tablosundaki kullanıcı */
    ));

    /* Öğrenci Ekle de yapılan işlemin aynısı */
    if($update){
        Header("Location: index.php?islem=success");
        exit;
    }
    else{
        Header("Location: index.php?islem=error");
        exit;
    }
}
?>
