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
        $this->arrtibutes['phone'] = static::normalizePhone($value);
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

    /**
     * Converts a phone number to the normal format. Removes everything but digits.
     */
    public static function normalizePhone(string $phone): string
    {
        return preg_replace('/[^0-9]/', '', $phone);
    }

    /**
     * Finds a client by its phone
     *
     * @param string $phone The phone number in any form
     * @return Client|null
     */
    public static function findByPhone(string $phone): ?self
    {
        return static::where('phone', static::normalizePhone($phone))->first();
    }

    /**
     * Gets or creates a client for the given credentials
     *
     * @param string $name Client name
     * @param string $phone Client phone in any form
     * @return Client
     */
    public static function findOrCreate(string $name, string $phone): self
    {
        if ($client = static::findByPhone($phone)) {
            return $client;
        }

        $client = new static();
        $client->name = $name;
        $client->phone = $phone;
        $client->save();

        return $client;
    }
}
