<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
        $this->attributes['phone'] = static::normalizePhone($value);
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
     * Finds a client by phone and updates his/her credentials. If a client with the given phone doesn't exist, creates
     * him/her. Saves the changes to the database. Race condition protection is enabled.
     *
     * @param string $name Client name
     * @param string $phone Client phone in any form
     * @return Client The created/updated client
     */
    public static function updateOrCreate(string $name, string $phone): self
    {
        $phone = static::normalizePhone($phone);

        return static::lockTable(function () use ($phone, $name) {
            $client = static::findByPhone($phone);

            if (!$client) {
                $client = new static();
                $client->phone = $phone;
            }

            $client->name = $name;
            $client->save();

            return $client;
        });
    }

    /**
     * Lock the clients table and calls the given function during the lock. Unlocks the table as soon as the function
     * finishes.
     *
     * Warning! Works only with MySQL.
     *
     * @param callable $whileLock
     * @return mixed The value returned by the function
     */
    protected static function lockTable(callable $whileLock)
    {
        $tableName = DB::getTablePrefix().(new static)->getTable();
        DB::unprepared("LOCK TABLES `$tableName` WRITE");

        try {
            return $whileLock();
        } finally {
            DB::unprepared("UNLOCK TABLES");
        }
    }
}
