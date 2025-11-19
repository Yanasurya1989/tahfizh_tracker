<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('mutabaahs', function (Blueprint $table) {
            $table->boolean('shalat_duha')->default(0)->after('ayat_akhir');
            $table->boolean('qiyamul_lail')->default(0)->after('shalat_duha');
        });
    }

    public function down()
    {
        Schema::table('mutabaahs', function (Blueprint $table) {
            $table->dropColumn(['shalat_duha', 'qiyamul_lail']);
        });
    }
};
