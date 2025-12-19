<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Currency;
use App\Repositories\Interfaces\CurrencyRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class CurrencyRepository implements CurrencyRepositoryInterface
{
    /**
     * @var \App\Models\Currency
     */
    protected Currency $model;

    /**
     * Constructor
     *
     * @param Currency $currency Currency model
     */
    public function __construct(Currency $currency)
    {
        $this->model = $currency;
    }

    /**
     * @inheritDoc
     */
    public function getIdByCode(int $code): ?int
    {
        //TODO optimize query with caching
        /** @var Builder<Currency> $query */
        $query = $this->model->newModelQuery();
        $result = $query
            ->where('numeric_code', $code)
            ->value('id');
        return $result !== null ? (int)$result : null;
    }
}
