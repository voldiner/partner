<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Invoice
 *
 * @property int $id
 * @property int $kod_atp код перевізника з fxp
 * @property string $number номер рахунку
 * @property \Illuminate\Support\Carbon $date_invoice дата рахунку
 * @property int $month_status місяць для станом на
 * @property int $year_status рік для станом на
 * @property int $month розрахунковий місяць
 * @property int $year розрахунковий рік
 * @property string|null $balance_begin залишок на початок
 * @property string|null $calculation_for_billing відрахування від виручки
 * @property string|null $calculation_for_baggage відрахування від багажу
 * @property string|null $sum_for_transfer сума до перерахування
 * @property string|null $sum_month_transfer перераховано за місяць
 * @property string|null $get_cash отримано готівки
 * @property string|null $balance_end залишок на кінець
 * @property int|null $balance_for_who сальдо на користь 0-нічиє 1-вопас 2-атп
 * @property string|null $pdv сума в т.ч. ПДВ
 * @property string|null $sum_for_tax сума до оподаткування
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at

 * @mixin \Eloquent
 */
class Invoice extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'kod_atp',
        'number',
        'date_invoice',
        'month_status',
        'year_status',
        'month',
        'year',
        'balance_begin',
        'calculation_for_billing',
        'calculation_for_baggage',
        'sum_for_transfer',
        'sum_month_transfer',
        'get_cash',
        'balance_end',
        'balance_for_who',
        'pdv',
        'sum_for_tax',
        'user_id',
    ];

    protected $dates = [
        'date_invoice',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function retentions()
    {
        return $this->hasMany(Retention::class);
    }

}
