<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table tr th{
            padding:10px; /* table elementi içindeki tr elementi içindeki th elementlerine 10 piksel boşluk ver */
        }
        input{
            padding:10px; /* Tüm inputlara 10 piksel boşluk ver */
        }
    </style>
    <?php require_once 'baglanti.php'; /* baglanti.php Sayfası ile iletişim sağlama */?>
</head>

<body>
    <h2>Öğrenci Ekle</h2>
    <!-- POST -> İnputlara girilen bilgileri URL de gözükmeyecek şekilde backend.php ye gönderir. Daha güvenlidir -->
    <form action="backend.php" method="POST">
        <!-- name parametreleri input içine girilen değerleri çekmek için kullanıyor -->
        <input type="textbox" placeholder="İsim Giriniz" name="isim"> 
        <input type="textbox" placeholder="Soyisim Giriniz" name="soyisim">
        <input type="number" placeholder="Numara" name="numara">
        <input type="number" placeholder="Not 1" name="not1">
        <input type="number" placeholder="Not 2" name="not2">
        <input type="number" placeholder="Not 3" name="not3">
        <input type="submit" value="Ekle" name="ogrenci_ekle"> <!-- Kullanıcı butona tıkladığında kullanıcının girdiği tüm verileri(name ile verileri çekiyor) backend.php ye gönder. -->
    </form>
    <hr style = "margin-top:20px;">
    <h2>Öğrenci Listesi</h2>
    <table border  = "1" style = "border-collapse:collapse;">
        <thead>
            <tr>
                <th>Öğrenci İsim</th>
                <th>Öğrenci Soyisim</th>
                <th>Öğrenci Numara</th>
                <th>Öğrenci Not 1</th>
                <th>Öğrenci Not 2</th>
                <th>Öğrenci Not 3</th>
                <th>Öğrenci Ortalama</th>
                <th colspan = "2">İşlem</th>
            </tr>
        </thead>
        <tbody>
            <?php
            /* sinif tablosundaki tüm verileri çek */
            $sorgu = $db->prepare("SELECT * from sinif");
            $sorgu->execute();
            /* Çekilen verileri $veri değişkenine  PDO::FETCH_ASSOC methodu ile eşitle */
            /* PDO::FETCH_ASSOC -> Veritabanından çekilen bilgileri dizi halinde $veri değişkenini eşitler */
            while($veri=$sorgu->fetch(PDO::FETCH_ASSOC)){
                ?>
                <tr>
                    <!-- $veri değişkeni içindeki sütünların değerlerini yazdır -->
                    <th><?php echo $veri["isim"] ?></th>
                    <th><?php echo $veri["soyisim"] ?></th>
                    <th><?php echo $veri["numara"] ?></th>
                    <th><?php echo $veri["not1"] ?></th>
                    <th><?php echo $veri["not2"] ?></th>
                    <th><?php echo $veri["not3"] ?></th>
                    <th><?php echo $veri["ortalama"] ?></th>
                    <th><a href="backend.php?sil=<?php echo $veri['id'] ?>">Sil</a></th> <!-- Sil' e tıklandığında backend.php ye sil paramteresi ile beraber gönder ve sil parametresini veri değişkeni içindeki id(Kimlik) ye eşitle -->
                    <th><a href="index.php?ogrenci_degistir=<?php echo $veri['id'] ?>">Güncelle</a></th> <!-- Güncelleye'ye tıklandığında kullanıcıyı bulunduğumuz index.php sayfasına tekrar gönder fakat ogrenci_guncelle parametresi ile gonder ve ogrenci_guncelle parametresi kullanıcının tıkladığı ogrencinin id(Kimlik) ye eşitle -->
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <hr style = "margin-top:20px;">
    <?php
    if(isset($_GET['ogrenci_degistir'])){ /* Eğer URL ye ogrenci_degistir kısmı geldi ise ogrenci_duzenle forumu göster */
        /* Öğrenci Bul, sinif tablosundan URL den gelen id(Kimlik) e göre öğrenciyi bul*/
        $ogrenci_bul = $db->prepare("SELECT * from sinif where id=:a");
        $ogrenci_bul->execute(array(
            "a" => $_GET['ogrenci_degistir'] // id yi satır 72 de 'a' değişkenine eşitledik a değişkenini ise url den gelen ogrenci_degistir parametresinin eşit olduğu, tabloda tıkladığımız öğrencinin id(Kimliği) sini eşitledik. */ 
        )); 
        $veri = $ogrenci_bul->fetch(PDO::FETCH_ASSOC); /* Tabloda bulunan öğrenciyi veri değişkenini PDO::FETCH_ASSOC methodu ile eşitle */
        /* PDO::FETCH_ASSOC -> Veritabanından çekilen bilgileri dizi halinde $veri değişkenini eşitler */
        ?>
        <h2 style = "margin-top:30px;">Öğrenci Güncelle</h2>
        <form action="backend.php" method="POST">
            <!-- name parametreleri input içine girilen değerleri çekmek için kullanıyor -->
            <!-- Value parametreleri input içine yukarıdaki sorgudan çekilen öğrencinin bilgilerini yazdırıyor -->
            <input type="textbox" placeholder="İsim Giriniz" name="isim" value = "<?php echo $veri['isim'] ?>"> 
            <input type="textbox" placeholder="Soyisim Giriniz" name="soyisim" value = "<?php echo $veri['soyisim'] ?>">
            <input type="number" placeholder="Numara" name="numara" value = "<?php echo $veri['numara'] ?>">
            <input type="number" placeholder="Not 1" name="not1" value = "<?php echo $veri['not1'] ?>">
            <input type="number" placeholder="Not 2" name="not2" value = "<?php echo $veri['not2'] ?>">
            <input type="number" placeholder="Not 3" name="not3" value = "<?php echo $veri['not3'] ?>">
            <input type="hidden" name = "id" value = "<?php echo $veri['id'] ?>"> <!-- Kullanıcının Id si ekranda gözükmemesi gerek olduğundan type ına hidden verildi, Kullanıcı Id si kullanıcıyı güncellerken hnagi kullanıcıyı güncellememizi gösterecek. Kullanıcı Kimliği(id) -->
            <input type="submit" value="Güncelle" name="ogrenci_guncelle"> <!-- Kullanıcı butona tıkladığında kullanıcının girdiği tüm verileri(name ile verileri çekiyor) backend.php ye gönder. -->
        </form>
    <?php }
    ?>
    <?php
    if (isset($_GET['islem'])) { /* Eğer URL ye islem adında bir parametre geldi ise */
        if ($_GET['islem'] == "success") { /* Eğer islem parametresi 'success' e eşise 'İşlem başarılı' yazdır*/
            ?> <p style = "color:green;">İşlem Başarılı</p> <?php
        }
        else if($_GET['islem'] == "error"){ /* Eğer işlem parametresi 'error' a eşitse 'İşlem Hatalı' yazdır */
            ?> <p style = "color:red;">İşlem Hatalı</p> <?php
        }
    }
    ?>
</body>

</html>