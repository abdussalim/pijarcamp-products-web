<?php

//MEMERIKSA VALIDASI PINDAH HALAMAN

if(isset($_GET['id'])&&isset($_GET['halaman'])) {
  $_SESSION['pindah_halaman']=true;
}

if (!isset($_SESSION['pindah_halaman'])) {
  header('location: index.php');
}

require 'function.php';

// AMBIL DATA

$isi_data = query("SELECT * FROM produk");

//PAGINASI (PEMBAGI HALAMAN)
//Konfigurasi
$jumlahDataPerHalaman = 4;
$jumlahData = count($isi_data);
$jumlahHalaman = ceil($jumlahData/$jumlahDataPerHalaman);
$halamanAktif = ( isset($_GET['halaman']) ) ? $_GET['halaman'] : 1;
$awalData = ($jumlahDataPerHalaman*$halamanAktif) - $jumlahDataPerHalaman;

if(NULL!==$_GET["id"]){

    $id = $_GET["id"];

  if(hapus_data($id)>0){

    echo "<script>
          alert('Data BERHASIL dihapus!');
          document.location.href='index.php?halaman=$halamanAktif';
         </script>";

  } 
  else{

    echo "<script>
          alert('Data GAGAL dihapus!');
          // document.location.href='index.php?halaman=$halamanAktif';
         </script>";
  }

}

?>