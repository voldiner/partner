<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Place
 *
 * @property int $id
 * @property string $ticket_id номер квитка
 * @property int $number_place номер місця
 * @property int $kod_flight код рейсу
 * @property string $time_flight час відправки рейсу
 * @property string $name_stop назва зупинки
 * @property string|null $sum сума квитка
 * @property string|null $num_certificate номер посвідчення
 * @property string|null $name_benefit назва пільги
 * @property string|null $name_passenger прізвище пільговика
 * @property int|null $type тип квитка
 * @property int $report_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @mixin \Eloquent
 */
class Place extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'ticket_id',
        'number_place',
        'kod_flight',
        'time_flight',
        'name_stop',
        'sum',
        'num_certificate',
        'name_benefit',
        'name_passenger',
        'type',
        'report_id'
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }


}
