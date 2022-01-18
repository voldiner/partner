<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_id')->comment('номер квитка');
            $table->integer('number_place')->comment('номер місця');
            $table->integer('kod_flight')->comment('код рейсу');
            $table->decimal('time_flight',4,2)->comment('час відправки рейсу');
            $table->string('name_stop')->comment('назва зупинки');
            $table->decimal('sum',12,2)->nullable()->comment('сума квитка');
            $table->string('num_certificate')->nullable()->comment('номер посвідчення');
            $table->string('name_benefit')->nullable()->comment('назва пільги');
            $table->string('name_passenger')->nullable()->comment('прізвище пільговика');
            $table->integer('type')->nullable()->comment('тип квитка');


            $table->foreignId('report_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('places');
    }
}
