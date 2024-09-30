<?php
session_start();

// Ambil data task yang akan diedit jika ada parameter 'index' di URL
$edit_index = null;
$edit_task = null;

if (isset($_GET['index'])) {
    $edit_index = $_GET['index'];
    $edit_task = $_SESSION['tasks'][$edit_index];
}

// Update Task
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['tasks'][$edit_index]['name'] = $_POST['name'];
    $_SESSION['tasks'][$edit_index]['jam_masuk'] = $_POST['jam_masuk'];
    $_SESSION['tasks'][$edit_index]['jam_keluar'] = $_POST['jam_keluar'];
    $_SESSION['tasks'][$edit_index]['priority'] = $_POST['priority'];
    $_SESSION['message'] = "Task berhasil diupdate!";
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2 class="text-center">Edit Task</h2>

    <form method="POST" action="update.php?index=<?php echo $edit_index; ?>">
        <div class="mb-3">
            <label for="name" class="form-label">Nama Kegiatan</label>
            <input type="text" name="name" class="form-control" required value="<?php echo $edit_task['name']; ?>">
        </div>
        <div class="mb-3">
            <label for="jam_masuk" class="form-label">Jam Masuk</label>
            <input type="time" name="jam_masuk" class="form-control" required value="<?php echo $edit_task['jam_masuk']; ?>">
        </div>
        <div class="mb-3">
            <label for="jam_keluar" class="form-label">Jam Keluar</label>
            <input type="time" name="jam_keluar" class="form-control" required value="<?php echo $edit_task['jam_keluar']; ?>">
        </div>
        <div class="mb-3">
            <label for="priority" class="form-label">Prioritas</label>
            <select name="priority" class="form-select" required>
                <option value="Low" <?php echo $edit_task['priority'] == 'Low' ? 'selected' : ''; ?>>Low</option>
                <option value="Medium" <?php echo $edit_task['priority'] == 'Medium' ? 'selected' : ''; ?>>Medium</option>
                <option value="High" <?php echo $edit_task['priority'] == 'High' ? 'selected' : ''; ?>>High</option>
            </select>
        </div>
        <button type="submit" class="btn btn-warning">Update Task</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
