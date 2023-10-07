<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function __invoke(Request $request)
    {
        $countUsers = User::where('is_admin', 0)->count();
        $countOrdersCompleted = Order::where('status_id', 2)->count();
        $ordersCompleted = Order::where('status_id', 2)->paginate(2);

        if($request->has('countUsersApplication')) {
            return response()->json([
                'countUsers' => $countUsers,
                'countApplication' => $countOrdersCompleted
            ], 200);
        }

        return view('welcome',[
            'countUsers'=> $countUsers,
            'countOrdersCompleted' => $countOrdersCompleted,
            'ordersCompleted'=> $ordersCompleted
        ]);
    }
}
