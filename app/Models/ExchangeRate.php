<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * ExchangeRate Model
 *
 * @property int $id
 * @property int $currency_a_id
 * @property int $currency_b_id
 * @property float|null $rate_buy
 * @property float|null $rate_sell
 * @property float|null $rate_cross
 * @property int $date
 * @property-read \App\Models\Currency $currencyA
 * @property-read \App\Models\Currency $currencyB
 * @method static \Database\Factories\ExchangeRateFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExchangeRate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExchangeRate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExchangeRate query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExchangeRate whereCurrencyAId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExchangeRate whereCurrencyBId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExchangeRate whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExchangeRate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExchangeRate whereRateBuy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExchangeRate whereRateCross($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExchangeRate whereRateSell($value)
 * @mixin \Illuminate\Database\Eloquent\Model
 */
class ExchangeRate extends Model
{
    public $timestamps = false;

    /** @phpstan-use \Illuminate\Database\Eloquent\Factories\HasFactory<\Database\Factories\ExchangeRateFactory> */
    use HasFactory;

    protected $fillable = [
        'currency_a_id',
        'currency_b_id',
        'rate_buy',
        'rate_sell',
        'rate_cross',
        'date',
    ];

    /**
     * Defines relationship to Currency model for currency A.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Currency, $this>
     */
    public function currencyA(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_a_id');
    }

    /**
     * Defines relationship to Currency model for currency B.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Currency, $this>
     */
    public function currencyB(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_b_id');
    }

    /**
     * This method is used to restructure data to save all in one SQL query.
     *
     * @param mixed[] $apiData Date array
     * @return mixed[]
     */
    public function getRestructuredData(array $apiData): array
    {
        $data = [];
        foreach ($apiData as $item) {
            $exchangeRate = self::newInstance([
                'currency_a_id' => $this->currencyA()->getRelated()->getIdByCode($item['currencyCodeA']),
                'currency_b_id' => $this->currencyA()->getRelated()->getIdByCode($item['currencyCodeB']),
                'date' => $item['date'],
                'rate_buy' => $item['rateBuy'] ?? null,
                'rate_sell' =>  $item['rateSell'] ?? null,
                'rate_cross' => $item['rateCross'] ?? null,
            ]);
            $data[] = $exchangeRate->toArray();
        }
        return $data;
    }
}
