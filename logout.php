<?php
session_start();

/* HAPUS SEMUA SESSION */
session_unset();
session_destroy();

/* BALIK KE HALAMAN UTAMA */
header("Location: index.php");
exit;
