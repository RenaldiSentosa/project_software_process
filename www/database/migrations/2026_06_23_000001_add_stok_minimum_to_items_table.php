<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('items', function (Blueprint $table) {
        if (!Schema::hasColumn('items', 'stok_minimum')) {
            $table->integer('stok_minimum')->default(0)->after('stok');
        }
    });
}

    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('stok_minimum');
        });
    }
};