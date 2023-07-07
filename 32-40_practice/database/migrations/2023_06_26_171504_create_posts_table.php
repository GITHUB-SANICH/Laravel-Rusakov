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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255); //заголовок
            $table->boolean('is_release'); //пост - рассылка или нет
            $table->string('alias', 255)->uniqid(); //чпу ссылки
            $table->text('intro_text'); //вводный текст
            $table->text('full_text'); //текст поста
            $table->string('meta_desc', 255); //мета описание
            $table->string('meta_key', 255); //мета ключ
            $table->integer('hits'); //просмотры
            $table->dateTime('date_show'); //заданное время отображения поста (анонс).
				$table->softDeletes(); //мягкое удаление
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
