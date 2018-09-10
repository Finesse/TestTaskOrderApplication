<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

/**
 * Helps to prevent race condition using the database.
 */
class DatabaseMutex
{
    /**
     * Creates a lock and calls the given function during the lock. Removes the lock as soon as the function finishes.
     * It prevents two calls of this method with the same $name from running simultaneously.
     *
     * @param string $name The lock name. The corresponding row must exist in the `locks` table.
     * @param callable $whileLock
     * @return mixed The value returned by the function
     */
    public static function lock(string $name, callable $whileLock)
    {
        return DB::transaction(function () use ($name, $whileLock) {
            DB::table('locks')->where('name', $name)->lockForUpdate()->get();

            return $whileLock();
        }, 5);
    }
}
