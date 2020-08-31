<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateColumnApartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apartments', function (Blueprint $table) {
          $table->dropColumn('cover_image');
          $table->dropColumn('visibility');
          $table->dropColumn('lon');
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
          $table->decimal('lon', 11, 8)->after('lat');
          $table->string('cover_image')->after('lon');
          $table->boolean('visibility')->after('cover_image');
        });
    }
}
