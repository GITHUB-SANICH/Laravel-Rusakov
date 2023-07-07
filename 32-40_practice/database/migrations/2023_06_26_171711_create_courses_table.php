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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id'); //id продукта
            $table->string('title', 255); //названеи курса
            $table->string('alias', 255)->uniqid(); //алиас - псевданим ссылки
            $table->text('slider_description'); //интро текст курса
            $table->text('full_description'); //полный текст описания курса
            $table->decimal('price', 10, 2); //цена курса. 1-й арг: название поля, 2-й: кол-во символов, 3-й кол-во символов после запятой
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
