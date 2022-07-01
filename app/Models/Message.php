<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'administrator_id',
        'text',
        'from'
    ];


    /**
     * створює строку з датою і часом для виводу в вікні чата
     * @param Carbon $date
     * @return string
     */
    public function getDateMessage()
    {
        if ($this->created_at->isYesterday()) {
            $result = 'вчора ' . $this->created_at->format('H:i');
        } elseif ($this->created_at->isToday()) {
            $result = 'сьогодні ' . $this->created_at->format('H:i');
        } else {
            $result = $this->created_at->format('d.m.Y H:i');
        }

        return $result;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function administrator()
    {
        return $this->belongsTo(Administrator::class);
    }

}
