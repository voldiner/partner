<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Station
 *
 * @property int $id
 * @property int $kod
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at

 * @mixin \Eloquent
 */
class Station extends Model
{
    use HasFactory;
    protected $fillable = [
      'name',
      'kod',
    ];


    public function products(){

        return $this->hasMany(Product::class);
    }

    public function reports(){

        return $this->hasMany(Report::class);
    }


}
