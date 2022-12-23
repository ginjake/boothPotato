<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gift_caches', function (Blueprint $table) {
            $table->bigInteger('categoryId')->after('id');
            $table->text('boothUrl')->after('url');
            $table->integer('price')->nullable()->after('title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gift_caches', function (Blueprint $table) {
            $table->dropColumn('boothUrl');
            $table->dropColumn('categoryId');
            $table->dropColumn('price');
        });
    }
};
