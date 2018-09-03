<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Tariff model
 *
 * @property int $id Identifier
 * @property string $name Name
 * @property float $price Price (≥ 0)
 * @property int[] $days The days possible for this tariff (week day numbers as in ISO-8601; 1 - Monday ... 7 - Sunday)
 * @property Carbon|null $created_at Create date and time
 * @property Carbon|null $updated_at Last update date and time
 *
 * @property-read Order[]|Collection $orders Orders made with the tariff
 */
class Tariff extends Model
{
    /**
     * {@inheritDoc}
     */
    protected $casts = [
        'name' => 'string',
        'price' => 'float',
        'days' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Setter for the `price` attribute
     */
    public function setPriceAttribute(float $value)
    {
        if ($value < 0) {
            throw new \InvalidArgumentException('The `price` attribute must be greater or equal 0');
        }

        $this->attributes['price'] = $value;
    }

    /**
     * Setter for the `days` attribute
     */
    public function setDaysAttribute(array $value)
    {
        $days = [];

        foreach ($value as $index => $day) {
            if (!is_numeric($day)) {
                throw new \InvalidArgumentException("The `days` attribute array item #$index is not a number");
            }

            $day = (int)$day;

            if ($day < 1 || $day > 7) {
                throw new \InvalidArgumentException("The `days` attribute array item #$index is not a number from 1 to 7");
            }

            $days[$day] = true; // Using this with arrays_keys required less code and faster then array_unique: http://php.net/manual/en/function.array-unique.php#98453
        }

        $days = array_keys($days);
        sort($days);
        $this->attributes['days'] = json_encode($days);
    }

    /**
     * Tells the framework that a tariff has many orders
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
