<?php

//MEMBERI VALIDASI PINDAH HALAMAN

session_start();

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

// TAMPILKAN DATA

$halaman_data = query("SELECT * FROM produk ORDER BY id DESC LIMIT $awalData, $jumlahDataPerHalaman");

//TAMBAH DATA

if(isset($_POST["tambah"])){

  if(tambah_data($_POST)>0){

    header('refresh:4');

    echo '

      <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
      <strong>Data Berhasil Ditambahkan!</strong> silahkan untuk mengecek data pada tabel.
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
      </div>

      ';

  } 
  else{

    header('refresh:4');

    echo '<div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
      <strong>Data Gagal Ditambahkan!</strong> silahkan untuk mengecek ulang data yang Anda inputkan!
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
      </div>';      

  }
   
}

// KOSONGKAN DATA

if(isset($_POST["kosongkan"])){

  if(kosongkan_data()==0){

    echo "<script>
          alert('Data BERHASIL dikosongkan!');
          document.location.href='index.php';
         </script>";

  } 
  else{

    echo "<script>
          alert('Data GAGAL dikosongkan!');
          document.location.href='index.php';
         </script>";

  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- BOOTSTRAP -->
  <link rel="stylesheet" href="bootstrap-4.6.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">

  <script src="jquery-3.6.0/jquery-3.6.0.js"></script>

  <title>Level 3 - Tugas 10</title>
</head>
<body>

<!-- AWAL MODALS TAMBAH DATA-->

  <div class="modal fade" id="staticBackdrop1" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Tambah Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

              <form action="" method="POST">

                <div class="form-group">
                  <label for="nama_produk">Nama Produk</label>
                  <input type="text" class="form-control" id="nama_produk" name="nama_produk" placeholder="nama produk . . ." value="" required>
                </div>
                <div class="form-group">
                  <label for="keterangan">Keterangan</label>
                  <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="keterangan singkat mengenai produk . . ." required>
                </div>
                <div class="form-group">
                  <label for="harga">Harga</label>
                  <input type="text" class="form-control" id="harga" name="harga" placeholder="Misal: 4000 (dalam satuan Rp.) . . ." required>
                </div>
                <div class="form-group">
                  <label for="jumlah">Jumlah</label>
                  <input type="text" class="form-control" id="jumlah" name="jumlah" placeholder="Misal: 2 (dalam bilangan bulat) . . ." required>
                </div>  
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                  <button type="submit" name="tambah" class="btn btn-primary" >Simpan</button>
                </div>

              </form>

    </div>
  </div>
</div>

  <!-- AKHIR MODALS TAMBAH DATA-->
  
  <!-- AWAL HOMEPAGE UTAMA BERISI-->

<?php if(count($isi_data)<1):?>

<div class="container d-block text-center mb-5 mt-5">
    
    <h1><strong>DATA KOSONG!</strong> Silahkan klik > <span><a class="tambah-data-awal" data-toggle="modal" data-target="#staticBackdrop1">menambahkan data</a></span>.</h1>

    <img src="img/pijarcamp.png" width="60%" height="70%" alt="">
        

</div>

<?php elseif(count($isi_data)>0):?>

<h1 class="text-center mt-5">Tabel Produk Pijarcamp</h1>

<div class="container d-block text-center">
  <div class="row">
    <div class="col d-inline text-right mt-5 mb-2">
      <form action="" method="POST">
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop1">
      TAMBAH DATA
      </button>
       <button type="submit" name="kosongkan" class="btn btn-danger ml-2" onclick="return confirm('APAKAH ANDA YAKIN MENGOSONGKAN SELURUH TABEL?')">
      KOSONGKAN DATA
      </button>
      </form>
    </div>
  </div>

  <div class="row">
    <div class="col">
      <table class="table table-borderless table-striped text-center mt-2">
        
        <thead class="thead-dark">
          <tr>

              <th scope="col">No</th>
              <th scope="col">Nama Produk</th>
              <th scope="col">Keterangan</th>
              <th scope="col">Harga (Rp.)</th>
              <th scope="col">Jumlah</th>
              <th scope="col">Aksi</th>

          </tr>
        </thead>
        <tbody class="table-hover">

<?php $no=1; ?>
<?php foreach($halaman_data as $d): ?>
          <tr>
              <td><?= $no+$awalData; ?></td>           
              <td><?= $d["nama_produk"]; ?></td>    
              <td><?= $d["keterangan"]; ?></td>
              <td><?= $d["harga"]; ?></td>
              <td><?= $d["jumlah"]; ?></td>
              <td>

              <a type="button" class="btn btn-warning text-white" href="ubah.php?id=<?=$d["id"];?>&halaman=<?=$halamanAktif;?>">
              Ubah
              </a>
              &nbsp&nbsp&nbsp
              <a type="button" class="btn btn-danger" href="hapus.php?id=<?=$d["id"];?>&halaman=<?=$halamanAktif;?>" onclick="return confirm('apakah anda yakin untuk menghapus data ini?')">
              Hapus
              </a>

              </td>
          </tr>
<?php $no++; ?>
<?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

<?php endif; ?>

<!-- AKHIR HOMEPAGE UTAMA -->

<!-- NAVIGASI PAGINASI -->

<?php if(count($isi_data)>=$jumlahDataPerHalaman): ?>

    <?php if($halamanAktif<=2 && $jumlahHalaman<=2 || $halamanAktif<=2 && $jumlahHalaman>=2): ?>

          <nav aria-label="Page navigation example">
          <ul class="pagination">
            <?php if($halamanAktif>1): ?>
            <li class="page-item">
              <a class="page-link" href="?halaman=<?=$halamanAktif-1;?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
              </a>
            </li>
            <?php endif; ?>
            <?php for($i=1; $i<=2; $i++): ?>

                  <?php if($i==$halamanAktif): ?>

                  <li class="page-item"><a class="page-link" style="font-weight: bold; color: black;" href="?halaman=<?=$i;?>"> <?=$i;?> </a></li>

                  <?php else : ?>

                  <li class="page-item"><a class="page-link" href="?halaman=<?=$i;?>"> <?=$i;?> </a></li>

                  <?php endif; ?>

            <?php endfor; ?>
            <?php if($halamanAktif>=1 && $jumlahHalaman>$halamanAktif): ?>
            <li class="page-item">
              <a class="page-link" href="?halaman=<?=$halamanAktif+1;?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Next</span>
              </a>
            </li>
            <?php endif; ?>
          </ul>
        </nav>

    <?php elseif($halamanAktif>1 && $jumlahHalaman<=2 || $halamanAktif>1 && $jumlahHalaman>=2): ?>

          <nav aria-label="Page navigation example">
          <ul class="pagination">
            <li class="page-item">
              <a class="page-link" href="?halaman=<?=$halamanAktif-1;?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
              </a>
            </li>

            <?php if($halamanAktif<$jumlahHalaman): ?>
            
            <?php for($i=$halamanAktif-2; $i<=$halamanAktif; $i++): ?>

                  <?php if($i==$halamanAktif): ?>

                  <li class="page-item"><a class="page-link" style="font-weight: bold; color: black;" href="?halaman=<?=$i;?>"> <?=$i;?> </a></li>

                  <?php else : ?>

                  <li class="page-item"><a class="page-link" href="?halaman=<?=$i;?>"> <?=$i;?> </a></li>

                  <?php endif; ?>

            <?php endfor; ?>

            <li class="page-item">
              <a class="page-link" href="?halaman=<?=$halamanAktif+1;?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Next</span>
              </a>
            </li>

            <?php elseif($halamanAktif>=$jumlahHalaman): ?>
       
            <?php for($i=$halamanAktif-1; $i<=$jumlahHalaman; $i++): ?>

                  <?php if($i==$halamanAktif): ?>

                  <li class="page-item"><a class="page-link" style="font-weight: bold; color: black;" href="?halaman=<?=$i;?>"> <?=$i;?> </a></li>

                  <?php else : ?>

                  <li class="page-item"><a class="page-link" href="?halaman=<?=$i;?>"> <?=$i;?> </a></li>

                  <?php endif; ?>

            <?php endfor; ?>

            <?php endif; ?>         

          </ul>
        </nav>

    <?php endif; ?>

<?php endif; ?>

<!-- AKHIR NAVIGASI PAGINASI -->

</div>

<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>

<script src="bootstrap-4.6.1/js/bootstrap.min.js"></script>
<script src="bootstrap-4.6.1/js/bootstrap.bundle.min.js"></script>

</body>
</html>