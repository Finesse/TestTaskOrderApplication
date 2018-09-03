<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Client model
 *
 * @property int $id Identifier
 * @property string $name Name
 * @property string $phone Phone number in an international format with only digits. Can be set in any format.
 * @property Carbon|null $created_at Create date and time
 * @property Carbon|null $updated_at Last update date and time
 *
 * @property-read Order[]|Collection $orders Orders made by the client
 */
class Client extends Model
{
    /**
     * {@inheritDoc}
     */
    protected $casts = [
        'name' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Setter for the `phone` attribute
     */
    public function setPhoneAttribute(string $value)
    {
        $this->arrtibutes['phone'] = preg_replace('/[^0-9]/', '', $value);
    }

    /**
     * Tells the framework that a client has many orders
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
