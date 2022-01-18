<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property int $kod_ac
 * @property string|null $sum_tariff сума тариф
 * @property string|null $sum_baggage сума багаж
 * @property string|null $sum_insurance сума страх збір
 * @property string $num_invoice
 * @property int $station_id
 * @property int $invoice_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @mixin \Eloquent
 */
class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'kod_ac',
        'sum_tariff',
        'sum_baggage',
        'sum_insurance',
        'num_invoice',
        'station_id',
        'invoice_id',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function station()
    {
        return $this->belongsTo(Station::class);
    }
}
