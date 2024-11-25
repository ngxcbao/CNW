<?php
// Gọi mảng dữ liệu hoa
include 'data.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách các loài hoa</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; margin: 20px; }
        .flower-list { display: flex; flex-wrap: wrap; gap: 20px; }
        .flower-item { border: 1px solid #ddd; border-radius: 10px; padding: 10px; width: 30%; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .flower-item img { width: 100%; height: auto; border-radius: 10px; }
        .flower-item h2 { margin-top: 10px; font-size: 1.2em; }
        .flower-item p { margin-top: 5px; color: #555; }
    </style>
</head>
<body>
    <h1>Danh sách các loài hoa</h1>
    <div class="flower-list">
        <?php foreach ($flowers as $flower): ?>
            <div class="flower-item">
                <img src="<?= $flower['image'] ?>" alt="<?= $flower['name'] ?>">
                <h2><?= $flower['name'] ?></h2>
                <p><?= $flower['description'] ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
