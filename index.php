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

if (isset($_GET['edit'])) {
    $book_edit = ambilBook();
} else {
    $book_edit = null;
}

if (isset($_GET['detail'])) {
    $book_detail = readBook();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REVIEW BUKU</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="style/style.css">
</head>

<body>
    <div class="container">
        <!-- MODAL CONTAINER -->
        <div class="modal-container">
            <!-- MODAL TAMBAH/EDIT -->
            <input type="checkbox" id="<?php echo $book_edit ? 'modal-update' : 'modal-tambah'; ?>" class="<?php echo $book_edit ? 'modal-update' : 'modal-tambah'; ?>" <?php echo $book_edit ? 'checked' : ''; ?>>
            <label class="modal-btn" for="<?php echo $book_edit ? 'modal-update' : 'modal-tambah'; ?>">TAMBAH</label>
            <div class="modal">
                <div class="modal-content">
                    <h2><?php echo isset($book_edit) ? 'Edit Buku' : 'Tambah Buku'; ?></h2>
                    <?php if (!empty($pesan)) : ?>
                        <p style="color: red; margin-bottom: 20px;"><?php echo $pesan; ?></p>
                    <?php endif; ?>
                    <form action="index.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="<?php echo $book_edit ? 'update' : 'tambah'; ?>">
                        <?php if ($book_edit) : ?>
                            <input type="hidden" name="id" value="<?php echo $book_edit['id']; ?>">
                        <?php endif; ?>
                        <div class="input-group">
                            <input type="text" name="judul" placeholder="Masukkan nama buku" value="<?php echo $book_edit ? $book_edit['judul'] : ''; ?>">
                        </div>
                        <div class="input-group">
                            <input type="text" name="penerbit" placeholder="Masukkan penerbit buku" value="<?php echo $book_edit ? $book_edit['penerbit'] : ''; ?>">
                        </div>
                        <div class="input-group">
                            <input type="text" name="penulis" placeholder="Masukkan penulis buku" value="<?php echo $book_edit ? $book_edit['penulis'] : ''; ?>">
                        </div>
                        <div class="input-group">
                            <input type="number" name="harga" placeholder="Masukkan harga buku" value="<?php echo $book_edit ? $book_edit['harga'] : ''; ?>">
                        </div>
                        <div class="input-group">
                            <textarea name="ulasan" placeholder="Masukkan ulasan buku"><?php echo $book_edit ? $book_edit['ulasan'] : ''; ?></textarea>
                        </div>
                        <div class="input-group">
                            <input type="date" name="tahun_terbit" placeholder="Masukkan tanggal film" value="<?php echo $book_edit ? $book_edit['tahun_terbit'] : ''; ?>">
                        </div>
                        <div class="input-group">
                            <input type="file" name="gambar" accept="image/*">
                        </div>
                        <div class="input-group">
                            <input type="submit" name="submit" value="<?php echo $book_edit ? 'Update' : 'Tambah' ?>">
                        </div>
                    </form>
                    <label class="modal-close" for="<?php echo $book_edit ? 'modal-update' : 'modal-tambah'; ?>">Tutup</label>
                </div>
            </div>

            <!-- DETAIL BOOK -->
            <?php if (isset($_GET['detail'])): ?>
                <div class="modal" style="display:block;">
                    <div class="modal-content detail-content">
                        <div class="image-detail">
                            <img src="<?php echo $book_detail['gambar']; ?>" width="200px" alt="">
                            <a href="index.php" class="modal-close">Tutup</a>
                        </div>
                        <div class="book-detail">
                            <p>Judul: <?php echo $book_detail['judul']; ?></p>
                            <p>Penulis: <?php echo $book_detail['penulis']; ?></p>
                            <p>Penerbit: <?php echo $book_detail['penerbit']; ?></p>
                            <p>Tahun Terbit: <?php echo $book_detail['tahun_terbit']; ?></p>
                            <p>Harga: Rp<?php echo number_format($book_detail['harga']); ?></p>
                            <p>Ulasan: <?php echo $book_detail['ulasan']; ?></p>
                        </div>
                    </div>  
                </div>
            <?php endif; ?>
        </div>

        <!-- CARD CONTAINER -->
        <div class="card-container">
            <?php foreach ($books as $key => $book) { ?>
                <a href="index.php?detail=<?php echo $book['id']; ?>" class="detail-anchor">
                    <div class="card">
                        <div class="image-container">
                            <img src="<?php echo $book['gambar']; ?>" alt="<?php echo $book['judul']; ?>">
                        </div>
                        <div class="film-container">
                            <h3><?php echo $book['judul']; ?></h3>
                            <h3>Rp<?php echo number_format($book['harga']); ?></h3>
                            <div class="action-btn">
                                <a href="index.php?edit=<?php echo $book['id']; ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                <a href="index.php?delete=<?php echo $book['id']; ?>" onclick="return confirm('Apakah anda yakin ingin menghapus?')"><i class="fa-solid fa-trash"></i></a>
                            </div>
                        </div>
                    </div>
                </a>
            <?php } ?>
        </div>
    </div>  
</body>

</html>