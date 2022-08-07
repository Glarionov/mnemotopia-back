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
        Schema::create('qparts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained();
            $table->integer('position')->default(1);
            $table->integer('hide_level')->default(1);
            $table->unique(['question_id', 'position']);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('qparts');
    }
};
