<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Order model
 *
 * @property int $id Identifier
 * @property int $first_day The first order day (a week day number as in ISO-8601; 1 - Monday ... 7 - Sunday)
 * @property string $address Order address
 * @property Carbon|null $created_at Create date and time
 * @property Carbon|null $updated_at Last update date and time
 *
 * @property-read Client|null $client The order client
 * @property-read Tariff|null $tariff The order tariff
 */
class Order extends Model
{
    /**
     * {@inheritDoc}
     */
    protected $casts = [
        'first_day' => 'integer',
        'address' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * {@inheritDoc}
     */
    protected $attributes = [
        'address' => ''
    ];

    /**
     * Setter for the `first_day` attribute
     */
    public function setFirstDayAttribute(int $value)
    {
        if ($value < 1 || $value > 7) {
            throw new \InvalidArgumentException('The `first_day` value is not a number from 1 to 7');
        }

        $this->attributes['first_day'] = $value;
    }

    /**
     * Tells the framework that an order belongs to a client
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Tells the framework that an order belongs to a tariff
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tariff()
    {
        return $this->belongsTo(Tariff::class);
    }
}
