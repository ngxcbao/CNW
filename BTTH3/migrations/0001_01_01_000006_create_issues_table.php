<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->id(); // Mã vấn đề báo cáo
            $table->unsignedBigInteger('computer_id'); // Khóa ngoại tham chiếu computers.id
            $table->string('reported_by', 50)->nullable(); // Người báo cáo sự cố (tùy chọn)
            $table->dateTime('reported_date'); // Thời gian báo cáo
            $table->text('description'); // Mô tả chi tiết vấn đề
            $table->enum('urgency', ['Low', 'Medium', 'High']); // Mức độ sự cố
            $table->enum('status', ['Open', 'In Progress', 'Resolved']); // Trạng thái xử lý
            $table->timestamps(); // created_at, updated_at

            // Thiết lập khóa ngoại
            $table->foreign('computer_id')->references('id')->on('computers')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('issues');
    }
};