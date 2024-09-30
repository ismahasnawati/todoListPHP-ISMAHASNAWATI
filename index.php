<?php
session_start();

if (!isset($_SESSION['tasks'])) {
    $_SESSION['tasks'] = [];
}

// Pesan peringatan jika ada task yang ditambahkan, diupdate, atau dihapus
if (isset($_SESSION['message'])) {
    echo '<div class="alert alert-success" role="alert">' . $_SESSION['message'] . '</div>';
    unset($_SESSION['message']); // Hapus pesan setelah ditampilkan
}

// Proses pencarian
$search_keyword = "";
if (isset($_GET['search'])) {
    $search_keyword = $_GET['search'];
}

// Filter tasks berdasarkan pencarian
$filtered_tasks = [];
if (!empty($search_keyword)) {
    foreach ($_SESSION['tasks'] as $task) {
        if (strpos(strtolower($task['name']), strtolower($search_keyword)) !== false) {
            $filtered_tasks[] = $task;
        }
    }
} else {
    // Jika tidak ada pencarian, tampilkan semua task
    $filtered_tasks = $_SESSION['tasks'];
}

// Hapus Task
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['index'])) {
    $index = $_GET['index'];
    unset($_SESSION['tasks'][$index]);
    $_SESSION['tasks'] = array_values($_SESSION['tasks']); // Reset array index
    $_SESSION['message'] = "Task berhasil dihapus!";
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kegiatan Organisasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2 class="text-center">Daftar Kegiatan Organisasi</h2>

    <!-- Form Search -->
    <form method="GET" action="index.php" class="mb-3">
        <div class="row">
            <div class="col">
                <input type="text" name="search" class="form-control" placeholder="Cari Nama Kegiatan" value="<?php echo $search_keyword; ?>">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
            <div class="col-auto">
                <a href="index.php" class="btn btn-secondary">Reset</a>
            </div>
        </div>
    </form>

    <!-- Tautan untuk Tambah Task -->
    <a href="create.php" class="btn btn-success mb-3">Tambah Task Baru</a>

    <!-- Daftar Task -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nama Kegiatan</th>
                <th>Jam Masuk</th>
                <th>Jam Keluar</th>
                <th>Prioritas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($filtered_tasks) > 0): ?>
                <?php foreach ($filtered_tasks as $index => $task): ?>
                    <tr>
                        <td><?php echo $task['name']; ?></td>
                        <td><?php echo $task['jam_masuk']; ?></td>
                        <td><?php echo $task['jam_keluar']; ?></td>
                        <td><?php echo $task['priority']; ?></td>
                        <td>
                            <a href="update.php?index=<?php echo $index; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="index.php?action=delete&index=<?php echo $index; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus task ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">Tidak ada kegiatan yang sesuai dengan pencarian.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
