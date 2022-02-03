<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email',100)->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->integer('user_type');
            $table->boolean('is_active');
            $table->string('password_fxp',20)->comment('тимчасовий пароль для створення користувача');
            $table->integer('kod_fxp')->unique()->comment('код перевізника з програми');
            $table->string('full_name')->nullable();
            $table->string('short_name')->nullable();
            $table->float('percent_retention_tariff',5,2)->nullable()->comment('процент відрахування з тарифу');
            $table->float('percent_retention__insurance',5,2)->nullable()->comment('процент відрахування вопас');
            $table->float('percent_retention__insurer',5,2)->nullable()->comment('процент відрахування страховику');
            $table->float('percent_retention__baggage',5,2)->nullable()->comment('процент відрахування багаж');
            $table->integer('attribute')->nullable()->comment('Невідома ознака');
            $table->boolean('collection')->comment('договір інкасація');
            $table->string('insurer')->nullable()->comment('назва страховика');
            $table->string('surname')->nullable()->comment('прізвище імя по батькові');
            $table->string('identifier')->nullable()->comment('ідентифікаційний код');
            $table->string('address')->nullable()->comment('адреса');
            $table->boolean('is_pdv')->comment('ознака платника пдв');
            $table->string('certificate')->nullable()->comment('номер свідоцтва');
            $table->string('certificate_tax')->nullable()->comment('індивідуальний податковий номер');
            $table->string('num_contract')->nullable()->comment('номер договора');
            $table->date('date_contract')->nullable()->comment('дата договора');
            $table->string('telephone')->nullable()->comment('телефон');
            $table->string('edrpou')->nullable()->comment('код едрпоу');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
