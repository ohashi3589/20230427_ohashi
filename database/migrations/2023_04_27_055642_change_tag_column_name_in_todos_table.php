<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTagColumnNameInTodosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('todos', function (Blueprint $table) {
            $table->renameColumn('tag', 'tag_id');
        });
    }

    public function down()
    {
        Schema::table('todos', function (Blueprint $table) {
            $table->renameColumn('tag_id', 'tag');
        });
    }
}
