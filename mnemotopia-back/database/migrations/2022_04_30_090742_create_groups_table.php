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
        Schema::dropIfExists('groups');

        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('text_id')->constrained();
            $table->boolean('shared_answers')->default(false);

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('groups', function (Blueprint $table) {
            $table->unsignedBigInteger('parent_group_id')->nullable();
            $table->foreign('parent_group_id')->references('id')->on('groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groups');
    }
};
