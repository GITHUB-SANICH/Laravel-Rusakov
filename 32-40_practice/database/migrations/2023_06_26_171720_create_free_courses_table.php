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
        Schema::create('free_courses', function (Blueprint $table) {
            $table->id();
            $table->integer('delivery_id'); //номер рассылки - он определяет подписку пользователя
            $table->string('title', 255); //названеи курса
            $table->string('alias', 255)->uniqid(); //алиас - псевданим ссылки
				$table->text('description'); //описание курса
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('free_courses');
    }
};
