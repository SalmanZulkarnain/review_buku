<?php 

require 'db.php';

function insertBook() {
    global $db;
    
    $pesan = '';
    if(isset($_POST['submit'])) {
        $judul = $_POST['judul'];
        $ulasan = $_POST['ulasan'];
        $tahun_terbit = $_POST['tahun_terbit'];
        $penulis = $_POST['penulis'];
        $penerbit = $_POST['penerbit'];
        $harga = $_POST['harga'];

        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["gambar"]["name"]);

        $check = getimagesize($_FILES["gambar"]["tmp_name"]);
        if($check !== false) {
            if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
                $gambar = $target_file;
            
                $query = "INSERT INTO review_buku (judul, ulasan, tahun_terbit, penulis, penerbit, harga, gambar) VALUES ('$judul', '$ulasan', '$tahun_terbit', '$penulis', '$penerbit', '$harga', '$gambar')";
                
                if ($db->query($query)) {
                    header('Location: index.php');
                    exit;
                } else {
                    $pesan = "Gagal menyimpan data ke database.";
                }
            } else {
                $pesan = "Maaf, terjadi kesalahan saat mengupload file.";
            }
        } else {
            $pesan = "File bukan gambar.";
        }
    }
    return $pesan;
}

function viewBook() {
    global $db;
    
    $result = $db->query("SELECT * FROM review_buku");
    $data = [];
    while($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $data[] = $row;
    }

    return $data;
}

function ambilBook() {
    global $db;

    if (!isset($_GET['edit'])) {
        return null; 
    }

    $id = $_GET['edit'];
    $ambil = $db->query("SELECT * FROM review_buku WHERE id = '$id'");
    
    return $ambil->fetchArray(SQLITE3_ASSOC);
}   

function readBook() {
    global $db;

    if (!isset($_GET['detail'])) {
        return null; 
    }

    $id = $_GET['detail'];
    $ambil = $db->query("SELECT * FROM review_buku WHERE id = '$id'");
    
    return $ambil->fetchArray(SQLITE3_ASSOC);
}

function updateBook() {
    global $db;

    if(isset($_POST['id'])) {
        $id = $_POST['id'];
        $judul = $_POST['judul'];
        $ulasan = $_POST['ulasan'];
        $tahun_terbit = $_POST['tahun_terbit'];

        $formattedDate = DateTime::createFromFormat('d/m/Y', $tahun_terbit);

        if ($formattedDate) {
            $tahun_terbit = $formattedDate->format('Y-m-d');
        } 
        
        if (!empty($judul)) {
            $db->query("UPDATE tasks SET judul = '$judul', ulasan = '$ulasan', tahun_terbit = '$tahun_terbit' WHERE id = '$id'");
            header('Location: index.php');
        }
    }
}

function deleteBook() {
    global $db;

    if(isset($_GET['delete'])) {
        $id = $_GET['delete'];
        $db->query("DELETE FROM review_buku WHERE id = '$id'");
        header('Location: index.php');
        exit;
    }
}