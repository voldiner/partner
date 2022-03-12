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
 * @property string|null $retention_for_collection утримання за інкасацію
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

    /**
     * Возвращает сумму прописью
     * @author runcore
     * @uses morph(...)
     * @return string
     */
    public function getBalanceEnd()
    {
        $num = $this->balance_end;
        $nul = 'нуль';
        $ten = array(
            array('', 'один', 'два', 'три', 'чотири', 'п"ять', 'шість', 'сім', 'вісім', 'дев"ять'),
            array('', 'одна', 'дві', 'три', 'чотири', 'п"ять', 'шість', 'сімь', 'вісім', 'дев"ять')
        );
        $a20 = array('десять', 'одинадцять', 'дванадцять', 'тринадцять', 'четирнадцять', 'п"ятнадцять', 'шістнадцять', 'сімнадцять', 'вісімнадцять', 'дев"ятнадцять');
        $tens = array(2 => 'двадцять', 'тридцять', 'сорок', 'п"ятдесят', 'шістдесят', 'сімдесят', 'вісімдесят', 'дев"яносто');
        $hundred = array('', 'сто', 'двісті', 'триста', 'четириста', 'п"ятсот', 'шістсот', 'сімсот', 'вісімсот', 'дев"ятсот');
        $unit = array(
            array('копійка' , 'копійки',   'копійок',     1),
            array('гривня',    'гривні',     'гривень',     0),
            array('тисяча',   'тисячі',    'тисяч',      1),
            array('мільйон',  'мільйона',  'мільйонів',  0),
            array('мільярд', 'мільярда', 'мільярдів', 0),
        );

        list($rub, $kop) = explode('.', sprintf("%015.2f", floatval($num)));
        $out = array();
        if (intval($rub) > 0) {
            foreach (str_split($rub, 3) as $uk => $v) {
                if (!intval($v)) continue;
                $uk = sizeof($unit) - $uk - 1;
                $gender = $unit[$uk][3];
                list($i1, $i2, $i3) = array_map('intval', str_split($v, 1));
                // mega-logic
                $out[] = $hundred[$i1]; // 1xx-9xx
                if ($i2 > 1) $out[] = $tens[$i2] . ' ' . $ten[$gender][$i3]; // 20-99
                else $out[] = $i2 > 0 ? $a20[$i3] : $ten[$gender][$i3]; // 10-19 | 1-9
                // units without rub & kop
                if ($uk > 1) $out[] = $this->morph($v, $unit[$uk][0], $unit[$uk][1], $unit[$uk][2]);
            }
        } else {
            $out[] = $nul;
        }
        $out[] = $this->morph(intval($rub), $unit[1][0], $unit[1][1], $unit[1][2]); // rub
        $out[] = $kop . ' ' . $this->morph($kop, $unit[0][0], $unit[0][1], $unit[0][2]); // kop
        return trim(preg_replace('/ {2,}/', ' ', join(' ', $out)));
    }

    /**
     * Склоняем словоформу
     * @author runcore
     */
    protected function morph($n, $f1, $f2, $f5)
    {
        $n = abs(intval($n)) % 100;
        if ($n > 10 && $n < 20) return $f5;
        $n = $n % 10;
        if ($n > 1 && $n < 5) return $f2;
        if ($n == 1) return $f1;
        return $f5;
    }
}
