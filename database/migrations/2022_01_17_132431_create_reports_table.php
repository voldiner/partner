<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();

            $table->integer('kod_atp')->comment('код перевізника');
            $table->string('num_report')->comment('номер відомості');
            $table->integer('kod_flight')->comment('код рейсу');
            $table->string('name_flight')->comment('назва рейсу');
            $table->decimal('time_flight',4,2)->default(0.0)->comment('час відправки рейсу');
            $table->date('date_flight',4,2)->comment('дата рейсу');
            $table->decimal('sum_tariff',12,2)->nullable()->comment('сума тариф');
            $table->decimal('sum_baggage',12,2)->nullable()->comment('сума багаж');
            $table->decimal('sum_insurance',12,2)->nullable()->comment('сума страх збір');
            $table->boolean('add_report')->nullable()->comment('');
            $table->integer('kod_ac')->comment('код автостанції');
            $table->integer('month')->comment('розрахунковий місяць');
            $table->integer('year')->comment('розрахунковий рік');
            $table->integer('day')->comment('розрахунковий рік');

            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('station_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
           // $table->softDeletes();
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
        Schema::dropIfExists('reports');
    }
}
