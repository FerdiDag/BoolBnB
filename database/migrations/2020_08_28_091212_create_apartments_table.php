<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->string('description_title');
            $table->integer('number_of_rooms');
            $table->integer('number_of_bathrooms');
            $table->integer('square_meters');
            $table->decimal('lat', 10, 8);
            $table->decimal('lon', 10, 8);
            $table->string('cover_image');
            $table->boolean('visibility');
            $table->string('slug')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apartments');
    }
}
