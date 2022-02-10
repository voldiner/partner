<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Report
 *
 * @property int $id
 * @property int $kod_atp код перевізника
 * @property string $num_report номер відомості
 * @property string $name_flight назва рейсу
 * @property string $time_flight час відправки рейсу
 * @property \Illuminate\Support\Carbon $date_flight дата рейсу
 * @property string|null $sum_tariff сума тариф
 * @property string|null $sum_baggage сума багаж
 * @property string|null $sum_insurance сума страх збір
 * @property int|null $add_report
 * @property int $kod_ac код автостанції
 * @property int $month розрахунковий місяць
 * @property int $year розрахунковий рік
 * @property int $day розрахунковий рік
 * @property int $user_id
 * @property int $station_id
 * @property int $kod_flight
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at

 * @mixin \Eloquent
 */
class Report extends Model
{
    use HasFactory;


    protected $fillable = [
        'kod_atp',
        'num_report',
        'name_flight',
        'time_flight',
        'date_flight',
        'sum_tariff',
        'sum_baggage',
        'sum_insurance',
        'add_report',
        'kod_ac',
        'month',
        'year',
        'day',
        'user_id',
        'station_id',
    ];
    protected $dates =[
        'date_flight',
    ];

    public function places()
    {
        return $this->hasMany(Place::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
