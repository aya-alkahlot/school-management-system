<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subject_online_class_pivot', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('online_classe_id'); // تغيير هنا
            $table->unsignedBigInteger('subject_id');
            $table->timestamps();
            $table->foreign('online_classe_id')->references('id')->on('online_classes')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subject_online_class_pivot');
    }
};