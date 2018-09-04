<?php

namespace App\Http\Controllers;

use App\Client;
use App\Order;
use App\Tariff;
use Illuminate\Http\Request;

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
        return view('form', [
            'tariffs' => Tariff::orderBy('price')->get()
        ]);
    }

    /**
     * HTTP endpoint for the order form
     */
    public function order(Request $request)
    {
        // Basic request validation
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:50|regex:/[0-9]/',
            'tariff' => 'required|integer|exists:tariffs,id',
            'start_day' => 'required|integer|min:1|max:7',
            'address' => 'required|string|max:65535'
        ]);

        /** @var Tariff $tariff */
        $tariff = Tariff::find($request->input('tariff'));

        // Check whether the start day available for the tariff
        if (array_search($request->input('start_day'), $tariff->days) === false) {
            abort(422, 'The chosen start day is not available for the chosen tariff');
        }

        // Save the ordre data to the database
        $client = Client::updateOrCreate($request->input('name'), $request->input('phone'));
        $order = new Order();
        $order->client()->associate($client);
        $order->tariff()->associate($tariff);
        $order->first_day = $request->input('first_day');
        $order->address = $request->input('address');
        $order->save();

        return response()->json([
            'orderId' => $order->id
        ]);
    }
}
