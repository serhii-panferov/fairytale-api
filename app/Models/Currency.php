<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use PhpParser\Builder;

/**
 *
 *
 * @property int $id
 * @property string $name
 * @property string $iso_code
 * @property string $numeric_code
 * @property string|null $minor_unit
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ExchangeRate> $exchangeRatesA
 * @property-read int|null $exchange_rates_a_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ExchangeRate> $exchangeRatesB
 * @property-read int|null $exchange_rates_b_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency whereIsoCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency whereMinorUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency whereNumericCode($value)
 * @mixin \Illuminate\Database\Eloquent\Model
 */
class Currency extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'iso_code',
        'numeric_code',
        'minor_unit',
    ];

    /**
     * Defines relationship to ExchangeRate model where this currency is currency A.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<ExchangeRate, $this>
     */
    public function exchangeRatesA(): HasMany
    {
        return $this->hasMany(ExchangeRate::class, 'currency_a_id');
    }

    /**
     * Defines relationship to ExchangeRate model where this currency is currency B.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<ExchangeRate, $this>
     */
    public function exchangeRatesB(): HasMany
    {
        return $this->hasMany(ExchangeRate::class, 'currency_b_id');
    }

    /**
     * Returns currency Id by numeric code.
     *
     * @param int $code Numeric currency code.
     * @return int|null
     */
    public static function getIdByCode(int $code): ?int
    {
        /** @var \Illuminate\Database\Eloquent\Builder<Currency>  */
        $query= self::query();
        $currency = $query->where(['numeric_code' => $code])->first();
        return $currency->id ?? null;
    }
}
