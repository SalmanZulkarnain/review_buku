<?php 

$db = new SQLite3('review_buku_db.sqlite');

if(!$db) {
    echo $db->lastErrorMsg();
}


$db->query("CREATE TABLE IF NOT EXISTS review_buku
(
id INTEGER PRIMARY KEY,
judul TEXT NOT NULL,
ulasan TEXT NOT NULL,
gambar TEXT NOT NULL,
tahun_terbit DATETIME,
penulis TEXT NOT NULL,
penerbit TEXT NOT NULL,
harga INTEGER NOT NULL
)");

// $db->query("DROP TABLE review_buku");