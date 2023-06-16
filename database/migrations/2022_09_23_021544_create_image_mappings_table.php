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
        Schema::create('image_mappings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('detail_mapping_id')
                ->constrained()
                ->restrictOnDelete();
            $table->string('name');
            $table->string('type');
            $table->unsignedTinyInteger('action')->comment("1 => Open Product; 2 => Open Other Map");
            $table->unsignedBigInteger('action_id')->comment("product_id | detail_mapping_id");
            $table->string('latLng');
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
        Schema::dropIfExists('image_mappings');
    }
};
