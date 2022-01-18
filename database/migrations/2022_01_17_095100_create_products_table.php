<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->integer('kod_ac');
            $table->decimal('sum_tariff',12,2)->nullable()->comment('сума тариф');
            $table->decimal('sum_baggage',12,2)->nullable()->comment('сума багаж');
            $table->decimal('sum_insurance', 12, 2)->nullable()->comment('сума страх збір');
            $table->string('num_invoice');
            $table->foreignId('station_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('invoice_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();

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
        Schema::dropIfExists('products');
    }
}
