<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeColumnArwahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('arwahs', function (Blueprint $table) {
            $table->enum('arwah_type',['Saudara', 'Saudari', 'Bapak', 'Ibu', 'Adik']);
        });
    }
}
