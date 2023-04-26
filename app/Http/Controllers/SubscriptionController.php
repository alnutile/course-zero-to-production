<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        return \inertia('Subscriptions/Index', [
            'intent' => auth()->user()->createSetupIntent(),
        ]);
    }

    public function subscribe(Request $request)
    {
        $request->user()->newSubscription(
            'default', 'price_1N18h3DtrQsiGw9vifKvdxi9'
        )->create($request->paymentMethodId);

        request()->session()->flash('flash.banner', 'Payment Completed');

        return to_route('subscriptions.index');
    }
}
