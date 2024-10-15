<?php

require 'db.php';
require 'functions.php';

$pesan = '';

$books = viewBook();

deleteBook();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'tambah':
                $pesan = insertBook();
                break;
            case 'update':
                updateBook();
                break;
        }
    }
}

$film_edit = null;
if (isset($_GET['edit'])) {
    $film_edit = ambilBook();
}
$book_edit = null;
if (isset($_GET['detail'])) {
    $book_edit = readBook();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REVIEW BUKU</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">

        <!-- MODAL CONTAINER -->
        <div class="modal-container">
            <!-- TAMBAH -->
            <input type="checkbox" id="modal-tambah" class="modal-tambah">
            <label class="modal-btn" for="modal-tambah">TAMBAH</label>
            <div class="modal">
                <div class="modal-content">
                    <h2>Isi Identitas Buku</h2>
                    <form action="index.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="tambah">
                        <?php if ($film_edit): ?>
                            <input type="hidden" name="id">
                        <?php endif; ?>

                        <div class="input-group">
                            <input type="text" name="judul" placeholder="Masukkan nama buku">
                        </div>
                        <div class="input-group">
                            <input type="text" name="penerbit" placeholder="Masukkan penerbit buku">
                        </div>
                        <div class="input-group">
                            <input type="text" name="penulis" placeholder="Masukkan penulis buku">
                        </div>
                        <div class="input-group">
                            <input type="number" name="harga" placeholder="Masukkan harga buku">
                        </div>
                        <div class="input-group">
                            <textarea name="ulasan" placeholder="Masukkan ulasan buku"></textarea>
                        </div>
                        <div class="input-group">
                            <input type="date" name="tahun_terbit" placeholder="Masukkan tanggal film">
                        </div>
                        <div class="input-group">
                            <input type="file" name="gambar" accept="image/*">
                        </div>
                        <div class="input-group">
                            <input type="submit" name="submit" value="Submit">
                        </div>
                    </form>
                    <label class="modal-close" for="modal-tambah">Tutup</label>
                </div>
            </div>

            <!-- EDIT  -->
            <?php if (isset($_GET['edit'])): ?>
                <div class="modal" style="display:block;">
                    <div class="modal-content">
                        <h2>Edit Film</h2>
                        <form action="index.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="update">
                            <?php if ($film_edit): ?>
                                <input type="hidden" name="id" value="<?php echo isset($film_edit['id']); ?>">
                            <?php endif; ?>

                            <div class="input-group">
                                <input type="text" name="judul" value="<?php echo $film_edit['judul']; ?>" placeholder="Masukkan judul buku">
                            </div>
                            <div class="input-group">
                                <input type="text" name="penerbit" value="<?php echo $film_edit['penerbit']; ?>" placeholder="Masukkan penerbit buku">
                            </div>
                            <div class="input-group">
                                <input type="text" name="penulis" value="<?php echo $film_edit['penulis']; ?>" placeholder="Masukkan penulis buku">
                            </div>
                            <div class="input-group">
                                <textarea name="ulasan" placeholder="Masukkan ulasan buku"><?php echo $film_edit['ulasan']; ?></textarea>
                            </div>
                            <div class="input-group">
                                <input type="date" name="tahun_terbit" value="<?php echo $film_edit['tahun_terbit']; ?>" placeholder="Masukkan tanggal terbit">
                            </div>
                            <div class="input-group">
                                <input type="file" name="gambar" accept="image/*">
                            </div>
                            <div class="input-group">
                                <input type="submit" name="submit" value="Update">
                            </div>
                        </form>
                        <a href="index.php" class="modal-close" for="modal-update">Tutup</a>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (!empty($pesan)): ?>
                <p style="color: red; margin-bottom: 20px;"><?php echo $pesan; ?></p>
            <?php endif; ?>

            <!-- DETAIL BOOK -->
            <?php if (isset($_GET['detail'])): ?>
                <div class="modal" style="display:block;">
                    <div class="modal-content detail-content">
                        <div class="image-detail">
                            <img src="<?php echo $book_edit['gambar']; ?>" width="200px" alt="">
                            <a href="index.php" class="modal-close">Tutup</a>
                        </div>
                        <div class="book-detail">
                            <p>Judul: <?php echo $book_edit['judul']; ?></p>
                            <p>Penulis: <?php echo $book_edit['penulis']; ?></p>
                            <p>Penerbit: <?php echo $book_edit['penerbit']; ?></p>
                            <p>Tahun Terbit: <?php echo $book_edit['tahun_terbit']; ?></p>
                            <p>Harga: Rp<?php echo number_format($book_edit['harga']); ?></p>
                            <p>Ulasan: <?php echo $book_edit['ulasan']; ?></p>
                        </div>
                        <!-- Tampilkan detail buku lainnya -->
                    </div>  
                </div>
            <?php endif; ?>
        </div>

        <!-- CARD CONTAINER -->
        <div class="card-container">
            <?php foreach ($books as $key => $film) { ?>
                <a href="index.php?detail=<?php echo $film['id']; ?>" class="detail-anchor">
                    <div class="card">
                        <div class="image-container">
                            <img src="<?php echo $film['gambar']; ?>" alt="<?php echo $film['judul']; ?>">
                        </div>
                        <div class="film-container">
                            <h3><?php echo $film['judul']; ?></h3>
                            <h3>Rp<?php echo number_format($film['harga']); ?></h3>
                            <div class="action-btn">
                                <a href="index.php?edit=<?php echo $film['id']; ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                <a href="index.php?delete=<?php echo $film['id']; ?>" onclick="return confirm('Apakah anda yakin ingin menghapus?')"><i class="fa-solid fa-trash"></i></a>
                            </div>
                        </div>
                    </div>
                </a>
            <?php } ?>
        </div>
    </div>
</body>

</html>