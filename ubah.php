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

// TAMPILKAN DATA

$halaman_data = query("SELECT * FROM produk ORDER BY id DESC LIMIT $awalData, $jumlahDataPerHalaman");


//Memilih data berdasarkan ID

$id = $_GET['id'];

$pilih_data = query("SELECT * FROM produk WHERE id='$id'")[0];

//EDIT DATA

if(isset($_POST["ubah"])){


  if(ubah_data($_POST)>0){

    echo "<script>
          alert('Data BERHASIL diperbaharui!');
          document.location.href='index.php?halaman=$halamanAktif';
         </script>";

  } 
  else{

    echo "<script>
          alert('Data GAGAL diperbaharui!');
          document.location.href='index.php?halaman=$halamanAktif';
         </script>";
  }

}

?>

<!DOCTYPE html>
<html lang="en">
<head  onload="tampilModalEdit()">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- BOOTSTRAP -->
  <link rel="stylesheet" href="bootstrap-4.6.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">

  <script src="jquery-3.6.0/jquery-3.6.0.js"></script>

  <title>Level 3 - Tugas 10</title>
</head>
<body onload="tampilModalEdit()">

  <!-- AWAL MODALS EDIT DATA-->

  <div class="modal fade" id="staticBackdrop2" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Prubaharui Data</h5>
        <button type="button" onclick="window.location='index.php?halaman=<?=$halamanAktif?>'" class="close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

              <form action="" method="POST">

                <div class="form-group">
                  <label for="nama_produk" hidden>ID</label>
                  <input type="text" class="form-control" id="id" name="id" placeholder="nama produk . . ." value="<?=$pilih_data["id"];?>" hidden>
                </div>
                <div class="form-group">
                  <label for="nama_produk">Nama Produk</label>
                  <input type="text" class="form-control" id="nama_produk" name="nama_produk" placeholder="nama produk . . ." value="<?=$pilih_data["nama_produk"];?>" required>
                </div>
                <div class="form-group">
                  <label for="keterangan">Keterangan</label>
                  <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="keterangan singkat mengenai produk . . ." value="<?=$pilih_data["keterangan"];?>" required>
                </div>
                <div class="form-group">
                  <label for="harga">Harga</label>
                  <input type="text" class="form-control" id="harga" name="harga" placeholder="Misal: 4000 (dalam satuan Rp.) . . ." value="<?=$pilih_data["harga"];?>" required>
                </div>
                <div class="form-group">
                  <label for="jumlah">Jumlah</label>
                  <input type="text" class="form-control" id="jumlah" name="jumlah" placeholder="Misal: 2 (dalam bilangan bulat) . . ." value="<?=$pilih_data["jumlah"];?>" required>
                </div>  
                </div>
                <div class="modal-footer">
                  <button type="button" onclick="window.location='index.php?halaman=<?=$halamanAktif?>'" class="btn btn-secondary">Batal
                  </button>
                  <button type="submit" name="ubah" class="btn btn-primary" >Simpan</button>
                </div>

              </form>

    </div>
  </div>
</div>

  <!-- AKHIR MODALS EDIT DATA-->
  
  <!-- AWAL HOMEPAGE UTAMA BERISI-->

<h1 class="text-center mt-5">Tabel Produk Pijarcamp</h1>

<div class="container d-block text-center">
  <div class="row">
    <div class="col d-inline text-right mt-5 mb-2">
      <form action="" method="POST">
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop2">
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

              <a type="button" class="btn btn-warning text-white" href="ubah.php?id=<?=$d["id"]?>" >
              Ubah
              </a>
              &nbsp&nbsp&nbsp
              <a type="button" class="btn btn-danger" href="hapus.php?id=<?=$d["id"];?>" onclick="return confirm('apakah anda yakin untuk menghapus data ini?')">
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

  function tampilModalEdit() {
  window.document.onload(

    $('#staticBackdrop2').modal('show')

  );
}

</script>

<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>

<script src="bootstrap-4.6.1/js/bootstrap.min.js"></script>
<script src="bootstrap-4.6.1/js/bootstrap.bundle.min.js"></script>

</body>
</html>