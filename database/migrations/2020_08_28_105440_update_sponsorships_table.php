<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSponsorshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sponsorships', function (Blueprint $table) {
          $table->foreign('rate_id')
          ->references('id')
          ->on('rates');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sponsorships', function (Blueprint $table) {
          $table->dropForeign("sponsorships_rate_id_foreign");
        });
    }
}
