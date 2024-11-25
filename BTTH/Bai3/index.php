<?php
// Đường dẫn đến file CSV
$filename = "students.csv";

// Mảng chứa dữ liệu sinh viên
$sinhvien = [];

// Đọc dữ liệu từ file CSV
if (($handle = fopen($filename, "r")) !== FALSE) {
    // Đọc dòng đầu tiên làm tiêu đề
    $headers = fgetcsv($handle, 1000, ",");

    // Đọc các dòng dữ liệu còn lại
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $sinhvien[] = array_combine($headers, $data);
    }
    fclose($handle);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sinh viên</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Danh sách sinh viên</h1>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Lastname</th>
                    <th>Firstname</th>
                    <th>City</th>
                    <th>Email</th>
                    <th>Course1</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Hiển thị dữ liệu sinh viên
                if (!empty($sinhvien)) {
                    foreach ($sinhvien as $sv) {
                        echo "<tr>";
                        echo "<td>{$sv['Username']}</td>";
                        echo "<td>{$sv['Password']}</td>";
                        echo "<td>{$sv['Lastname']}</td>";
                        echo "<td>{$sv['Firstname']}</td>";
                        echo "<td>{$sv['City']}</td>";
                        echo "<td>{$sv['Email']}</td>";
                        echo "<td>{$sv['Course1']}</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>Không có dữ liệu</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
