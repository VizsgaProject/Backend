<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddResetPasswordTokenToUsersTable extends Migration
{
    /**
     * A tábla módosításának végrehajtása.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Hozzáadjuk a reset_password_token oszlopot
            $table->string('reset_password_token')->nullable();
        });
    }

    /**
     * A tábla módosításának visszavonása.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Ha szükséges, visszaállítjuk az oszlopot
            $table->dropColumn('reset_password_token');
        });
    }
}
