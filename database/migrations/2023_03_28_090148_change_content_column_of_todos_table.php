<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeContentColumnOfTodosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('todos', function (Blueprint $table) {
            $table->string('content', 20)->change();
        });
    }

    public function down()
    {
        Schema::table('todos', function (Blueprint $table) {
            $table->string('content')->change();
        });
    }
}
