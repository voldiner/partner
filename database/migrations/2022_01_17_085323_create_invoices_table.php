<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();

            $table->integer('kod_atp')->comment('код перевізника з fxp');
            $table->string('number')->unique()->comment('номер рахунку');
            $table->date('date_invoice')->comment('дата рахунку');
            $table->integer('month_status')->comment('місяць для станом на');
            $table->integer('year_status')->comment('рік для станом на');
            $table->integer('month')->comment('розрахунковий місяць');
            $table->integer('year')->comment('розрахунковий рік');
            $table->decimal('balance_begin',12,2)->nullable()->comment('залишок на початок');
            $table->decimal('calculation_for_billing',12,2)->nullable()->comment('відрахування від виручки');
            $table->decimal('calculation_for_baggage',12,2)->nullable()->comment('відрахування від багажу');
            $table->decimal('sum_for_transfer',12,2)->nullable()->comment('сума до перерахування');
            $table->decimal('sum_month_transfer',12,2)->nullable()->comment('перераховано за місяць');
            $table->decimal('get_cash',12,2)->nullable()->comment('отримано готівки');
            $table->decimal('balance_end',12,2)->nullable()->comment('залишок на кінець');
            $table->integer('balance_for_who')->nullable()->comment('сальдо на користь 0-нічиє 1-вопас 2-атп');
            $table->decimal('pdv',12,2)->nullable()->comment('сума в т.ч. ПДВ');
            $table->decimal('sum_for_tax',12,2)->nullable()->comment('сума до оподаткування');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();

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
        Schema::dropIfExists('invoices');
    }
}
