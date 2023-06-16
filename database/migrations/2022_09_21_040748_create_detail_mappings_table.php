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
        Schema::create('detail_mappings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mapping_id')
                ->constrained()
                ->restrictOnDelete();
            $table->string('name');
            $table->string('image');
            $table->integer('width');
            $table->integer('height');
            $table->boolean('is_default')->default(0);
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
        Schema::dropIfExists('detail_mappings');
    }
};
