<?php

require 'koneksi.php';

function query($query){

    global $conn;

    $result = mysqli_query($conn, $query);
    $rows = [];
    while ( $row = mysqli_fetch_assoc($result)){
        $rows[] = $row;
    }
    return $rows;

};

function tambah_data($data) {

	global $conn;

  //Ambil tiap elemen data

  $nama_produk = htmlspecialchars($data["nama_produk"]);
  $keterangan = htmlspecialchars($data["keterangan"]);
  $harga = htmlspecialchars($data["harga"]);
  $jumlah = htmlspecialchars($data["jumlah"]);

  //Masukkan data kedalam

  mysqli_query($conn, "INSERT INTO produk VALUES (NULL,'$nama_produk','$keterangan','$harga','$jumlah')" );

  //Cek data berhasil ditambah atau tidak

  return mysqli_affected_rows($conn);

}

function ubah_data($data) {

    global $conn;

  //Ambil tiap elemen data
  $id = $data["id"];
  $nama_produk = htmlspecialchars($data["nama_produk"]);
  $keterangan = htmlspecialchars($data["keterangan"]);
  $harga = htmlspecialchars($data["harga"]);
  $jumlah = htmlspecialchars($data["jumlah"]);

  //Masukkan data kedalam

  mysqli_query($conn, "UPDATE produk SET

               id = '$id',
               nama_produk = '$nama_produk',
               keterangan = '$keterangan',
               harga = '$harga',
               jumlah = '$jumlah' 

               WHERE id = '$id'")
 ;

  //Cek data berhasil diperbaharui atau tidak

  return mysqli_affected_rows($conn);

}

function hapus_data($id) {

    global $conn;

  //Hapus data dengan ID dimaksud

  mysqli_query($conn, "DELETE FROM produk WHERE id = '$id'");

  //Cek data berhasil dihapus atau tidak

  return mysqli_affected_rows($conn);

}

function kosongkan_data() {

    global $conn;

  //Query kosongkan seluruh data dalam tabel

  mysqli_query($conn, "TRUNCATE TABLE produk");

  //Cek data berhasil kosongkan atau tidak

  return mysqli_affected_rows($conn);

}

?>