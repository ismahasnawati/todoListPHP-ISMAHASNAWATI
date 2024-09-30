<?php
session_start();

// Periksa apakah task sudah ada dalam session
if (!isset($_SESSION['tasks'])) {
    $_SESSION['tasks'] = [];
}

// Hapus Task
if (isset($_GET['index'])) {
    $index = $_GET['index'];
    if (isset($_SESSION['tasks'][$index])) {
        unset($_SESSION['tasks'][$index]);
        $_SESSION['tasks'] = array_values($_SESSION['tasks']); // Reset array index
        $_SESSION['message'] = "Task berhasil dihapus!";
    } else {
        $_SESSION['message'] = "Task tidak ditemukan!";
    }
    header('Location: index.php'); // Kembali ke halaman index setelah penghapusan
    exit;
} else {
    // Jika tidak ada index yang diberikan
    $_SESSION['message'] = "Tidak ada task yang dipilih untuk dihapus!";
    header('Location: index.php');
    exit;
}
?>
