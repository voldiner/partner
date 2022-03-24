<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Models\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @mixin \Eloquent
 * @property int $id
 * @property string|null $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $user_type
 * @property int $is_active
 * @property string $password_fxp тимчасовий пароль для створення користувача
 * @property int $kod_fxp код перевізника з програми
 * @property string|null $full_name
 * @property string|null $short_name
 * @property float|null $percent_retention_tariff процент відрахування з тарифу
 * @property float|null $percent_retention__insurance процент відрахування вопас
 * @property float|null $percent_retention__insurer процент відрахування страховику
 * @property float|null $percent_retention__baggage процент відрахування багаж
 * @property int|null $attribute Невідома ознака
 * @property int|null $collection договір інкасація
 * @property string|null $insurer назва страховика
 * @property string|null $surname прізвище імя по батькові
 * @property string|null $identifier ідентифікаційний код
 * @property string|null $address адреса
 * @property int $is_pdv ознака платника пдв
 * @property string|null $certificate номер свідоцтва
 * @property string|null $certificate_tax індивідуальний податковий номер
 * @property string|null $num_contract номер договора
 * @property string|null $date_contract дата договора
 * @property string|null $telephone телефон
 * @property string|null $edrpou код едрпоу
 * @property string|null $statistic  json статистика
 *
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        // ---
        'kod_fxp',
        'full_name',
        'short_name',
        'percent_retention_tariff',
        'percent_retention__insurance',
        'percent_retention__insurer',
        'percent_retention__baggage',
        'attribute',
        'collection',
        'insurer',
        'surname',
        'identifier',
        'address',
        'is_pdv',
        'certificate',
        'certificate_tax',
        'num_contract',
        'date_contract',
        'telephone',
        'edrpou',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        // --
        'user_type',
        'is_active'
    ];

    protected $dates = [
        'date_contract',
    ];




    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'statistic' => 'array'
    ];

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function reports()
    {
         return $this->hasMany(Report::class);
    }

}
