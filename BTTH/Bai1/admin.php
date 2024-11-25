<?php
// File lưu trữ dữ liệu
$dataFile = 'data.php';

// Nếu file dữ liệu không tồn tại, tạo file mới
if (!file_exists($dataFile)) {
    file_put_contents($dataFile, "<?php\n\$flowers = [];\n");
}

// Gọi mảng dữ liệu
include $dataFile;

// Thêm hoa mới
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $image = $_FILES['image'];

    // Lưu file ảnh vào thư mục images/
    $targetDir = "images/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir);
    }
    $targetFile = $targetDir . basename($image['name']);
    move_uploaded_file($image['tmp_name'], $targetFile);

    // Thêm hoa mới vào mảng
    $flowers[] = [
        'name' => $name,
        'description' => $description,
        'image' => $targetFile
    ];

    // Lưu lại mảng vào file
    file_put_contents($dataFile, "<?php\n\$flowers = " . var_export($flowers, true) . ";");
    header("Location: admin.php");
    exit;
}

// Sửa hoa
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];

    // Kiểm tra nếu có upload ảnh mới
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image'];
        $targetDir = "images/";
        $targetFile = $targetDir . basename($image['name']);
        move_uploaded_file($image['tmp_name'], $targetFile);
        $imagePath = $targetFile;

        // Xóa ảnh cũ
        if (file_exists($flowers[$id]['image'])) {
            unlink($flowers[$id]['image']);
        }
    } else {
        $imagePath = $flowers[$id]['image']; // Giữ nguyên ảnh cũ
    }

    // Cập nhật thông tin hoa
    $flowers[$id] = [
        'name' => $name,
        'description' => $description,
        'image' => $imagePath
    ];

    // Lưu lại mảng vào file
    file_put_contents($dataFile, "<?php\n\$flowers = " . var_export($flowers, true) . ";");
    header("Location: admin.php");
    exit;
}

// Xóa hoa
if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $id = $_GET['id'];

    // Xóa ảnh khỏi thư mục
    if (file_exists($flowers[$id]['image'])) {
        unlink($flowers[$id]['image']);
    }

    // Xóa hoa khỏi mảng
    array_splice($flowers, $id, 1);

    // Lưu lại mảng vào file
    file_put_contents($dataFile, "<?php\n\$flowers = " . var_export($flowers, true) . ";");
    header("Location: admin.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản trị danh sách hoa</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
        img { max-width: 100px; height: auto; border-radius: 5px; }
        .button { padding: 10px 20px; background-color: #28a745; color: #fff; border: none; cursor: pointer; border-radius: 5px; margin: 5px 0; }
        .button-danger { background-color: #dc3545; }
        .modal { display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 400px; background: #fff; box-shadow: 0 0 15px rgba(0,0,0,0.5); padding: 20px; border-radius: 8px; z-index: 1000; }
        .modal.active { display: block; }
        .modal-header { font-weight: bold; margin-bottom: 10px; }
        .modal-footer { margin-top: 20px; text-align: right; }
        .overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 999; }
        .overlay.active { display: block; }
    </style>
</head>
<body>
    <h1>Quản trị danh sách các loài hoa</h1>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
        color: #343a40;
        margin: 0;
        padding: 20px;
    }

    h1 {
        text-align: center;
        color: #495057;
        margin-bottom: 30px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    th, td {
        padding: 12px 15px;
        text-align: left;
    }

    th {
        background-color: #007bff;
        color: #fff;
        text-transform: uppercase;
        font-size: 14px;
        letter-spacing: 0.03em;
    }

    td {
        border-bottom: 1px solid #dee2e6;
    }

    tr:hover {
        background-color: #f1f3f5;
    }

    img {
        max-width: 80px;
        height: auto;
        border-radius: 5px;
        border: 1px solid #dee2e6;
    }

    .button {
        display: inline-block;
        padding: 8px 16px;
        color: #fff;
        background-color: #007bff;
        text-decoration: none;
        border: none;
        border-radius: 5px;
        font-size: 14px;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .button:hover {
        background-color: #0056b3;
    }

    .button-danger {
        background-color: #dc3545;
    }

    .button-danger:hover {
        background-color: #b21f2d;
    }

    .modal {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 400px;
        background: #fff;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        z-index: 1000;
        padding: 20px;
    }

    .modal.active {
        display: block;
    }

    .modal-header {
        font-size: 18px;
        font-weight: bold;
        color: #343a40;
        margin-bottom: 15px;
        border-bottom: 1px solid #dee2e6;
        padding-bottom: 10px;
    }

    .modal-footer {
        margin-top: 20px;
        text-align: right;
    }

    .overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 999;
    }

    .overlay.active {
        display: block;
    }

    form label {
        font-size: 14px;
        font-weight: bold;
        color: #495057;
        margin-bottom: 8px;
        display: block;
    }

    form input[type="text"], 
    form textarea, 
    form input[type="file"] {
        width: 100%;
        padding: 10px;
        font-size: 14px;
        margin-bottom: 15px;
        border: 1px solid #ced4da;
        border-radius: 5px;
    }

    form textarea {
        resize: vertical;
        height: 100px;
    }
</style>


    <!-- Nút thêm mới -->
    <button class="button" id="addFlowerButton">Thêm mới</button>

    <!-- Bảng hiển thị danh sách hoa -->
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Tên Hoa</th>
                <th>Mô Tả</th>
                <th>Hình Ảnh</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($flowers as $id => $flower): ?>
                <tr>
                    <td><?= $id + 1 ?></td>
                    <td><?= htmlspecialchars($flower['name']) ?></td>
                    <td><?= htmlspecialchars($flower['description']) ?></td>
                    <td><img src="<?= htmlspecialchars($flower['image']) ?>" alt="<?= htmlspecialchars($flower['name']) ?>"></td>
                    <td>
                        <button class="button" onclick="openEditModal(<?= $id ?>)">Sửa</button>
                        <a href="admin.php?action=delete&id=<?= $id ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa?')" class="button button-danger">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Overlay -->
    <div class="overlay" id="modalOverlay"></div>

    <!-- Modal thêm/sửa -->
    <div class="modal" id="flowerModal">
        <div class="modal-header" id="modalTitle">Thêm hoa mới</div>
        <form action="admin.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action" id="modalAction" value="add">
            <input type="hidden" name="id" id="flowerId">
            <label>Tên hoa:</label>
            <input type="text" name="name" id="flowerName" required>
            <br><br>
            <label>Mô tả:</label>
            <textarea name="description" id="flowerDescription" required></textarea>
            <br><br>
            <label>Hình ảnh:</label>
            <input type="file" name="image" id="flowerImage">
            <br><br>
            <div class="modal-footer">
                <button type="submit" class="button">Lưu</button>
                <button type="button" class="button button-danger" onclick="closeModal()">Hủy</button>
            </div>
        </form>
    </div>

    <script>
        const addFlowerButton = document.getElementById('addFlowerButton');
        const modalOverlay = document.getElementById('modalOverlay');
        const flowerModal = document.getElementById('flowerModal');
        const modalTitle = document.getElementById('modalTitle');
        const modalAction = document.getElementById('modalAction');
        const flowerId = document.getElementById('flowerId');
        const flowerName = document.getElementById('flowerName');
        const flowerDescription = document.getElementById('flowerDescription');
        const flowerImage = document.getElementById('flowerImage');

        addFlowerButton.onclick = () => {
            openModal('add');
        };

        function openModal(action, id = '', name = '', description = '') {
            modalTitle.innerText = action === 'add' ? 'Thêm hoa mới' : 'Sửa thông tin hoa';
            modalAction.value = action;
            flowerId.value = id;
            flowerName.value = name;
            flowerDescription.value = description;
            flowerModal.classList.add('active');
            modalOverlay.classList.add('active');
        }

        function openEditModal(id) {
            const flower = <?= json_encode($flowers) ?>[id];
            openModal('edit', id, flower.name, flower.description);
        }

        function closeModal() {
            flowerModal.classList.remove('active');
            modalOverlay.classList.remove('active');
        }
    </script>
</body>
</html>
