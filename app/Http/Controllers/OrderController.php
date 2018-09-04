<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tariff;

/**
 * Controller for the order endpoints
 */
class OrderController extends Controller
{
    /**
     * Order form page
     */
    public function index()
    {
        $tariffs = Tariff::query()->orderBy('price')->get();

        return view('form', [
            'tariffs' => $tariffs->map(function (Tariff $tariff) {
                return $tariff->only(['id', 'name', 'price', 'days']);
            })
        ]);
    }

    /**
     * HTTP endpoint for the order form
     */
    public function order(Request $request)
    {
        //
    }
}
