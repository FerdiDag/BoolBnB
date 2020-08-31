<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnApartments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apartments', function (Blueprint $table) {
          $table->decimal('lon', 11, 8)->after('lat');
          $table->string('cover_image')->nullable()->after('lon');
          $table->boolean('visibility')->nullable()->after('cover_image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('apartments', function (Blueprint $table) {
           $table->dropColumn('visibility');
           $table->dropColumn('cover_image');
           $table->dropColumn('lon');
        });
    }
}
