<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD"
          crossorigin="anonymous">
    <title>Quản lý Vấn Đề</title>
</head>
<body>

<h1 style="margin: 50px 50px">Thêm Vấn Đề Mới</h1>

<form action="<?php echo e(route('issues.store')); ?>" method="POST" style="margin: 50px 50px">
    <?php echo csrf_field(); ?>
    <div class="mb-3">
        <label for="computer_id" class="form-label">Máy tính</label>
        <select class="form-control" id="computer_id" name="computer_id" required>
            <?php $__currentLoopData = $computers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $computer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($computer->id); ?>"><?php echo e($computer->computer_name); ?> (<?php echo e($computer->model); ?>)</option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="reported_by" class="form-label">Người báo cáo</label>
        <input type="text" class="form-control" id="reported_by" name="reported_by" required>
    </div>

    <div class="mb-3">
        <label for="reported_date" class="form-label">Thời gian báo cáo</label>
        <input type="datetime-local" class="form-control" id="reported_date" name="reported_date" required>
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Mô tả vấn đề</label>
        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
    </div>

    <div class="mb-3">
        <label for="urgency" class="form-label">Mức độ</label>
        <select class="form-control" id="urgency" name="urgency" required>
            <option value="Low">Low</option>
            <option value="Medium">Medium</option>
            <option value="High">High</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="status" class="form-label">Trạng thái</label>
        <select class="form-control" id="status" name="status" required>
            <option value="Open">Mở</option>
            <option value="In Progress">Đang xử lý</option>
            <option value="Resolved">Đã giải quyết</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Thêm Vấn Đề</button>
</form>

</body>
</html><?php /**PATH C:\xampp\htdocs\BTTH4\resources\views/issues/create.blade.php ENDPATH**/ ?>