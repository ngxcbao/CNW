<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('computers', function (Blueprint $table) {
            $table->id(); // Mã máy tính
            $table->string('computer_name', 50); // Tên máy tính
            $table->string('model', 100); // Phiên bản
            $table->string('operating_system', 50); // Hệ điều hành
            $table->string('processor', 50); // Bộ vi xử lý
            $table->integer('memory'); // Bộ nhớ RAM (GB)
            $table->boolean('available'); // Trạng thái hoạt động
            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('computers');
    }
};