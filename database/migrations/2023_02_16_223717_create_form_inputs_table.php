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
        Schema::create('form_inputs', function (Blueprint $table) {
            $table->id();
            $table->text('full_name')->nullable();
            $table->text('gender')->nullable();
            $table->text('date_of_birth')->nullable();
            $table->text('address')->nullable();
            $table->text('state')->nullable();
            $table->text('city')->nullable();
            $table->text('country')->nullable();
            $table->text('postal_code')->nullable();
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
        Schema::dropIfExists('form_inputs');
    }
};
