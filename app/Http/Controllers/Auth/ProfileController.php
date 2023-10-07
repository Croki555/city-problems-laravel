<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ProfileController extends Controller
{
    public function index(Request $request): View
    {
        $statuses = Status::all();

        if ($request->query('status')) {
            $orders = Order::where('user_id', auth()->user()->id)
                ->where('status_id', '=', $request->query('status'))
                ->orderBy('created_at', 'desc')->get();
        } else {
            $orders = Order::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->get();
        }

        return view('auth.profile', [
            'orders' => $orders,
            'statuses' => $statuses,
            'oldStatus' => $request->query('status'),
        ]);
    }

    public function create(): View
    {
        return view('auth.order.create', [
            'categories' => Category::all(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validator = $request->validate([
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'category' => ['required', 'integer'],
            'before_url' => ['required', 'mimes:jpg,jpeg,png', 'max:100']
        ]);

        if ($validator) {
            $file = $request->file('before_url');
            $exten = $file->getClientOriginalExtension();
            $newName = Str::random(10) . '.' . $exten;

            Storage::putFileAs('public/image/orders', $file, $newName);


            $order = new Order();
            $order->title = $validator['title'];
            $order->description = $validator['description'];
            $order->before_url = $newName;
            $order->status_id = 1;
            $order->category_id = $validator['category'];
            $order->user_id = auth('web')->user()->id;
            $order->save();
            return redirect(route('profile'));
        }


        return back()->withErrors([$validator])->withInput(['title', 'description', 'before_url']);
    }

    public function destroy(string $id): RedirectResponse
    {
        $order = Order::find($id);
        if($order)
        {
            $order->delete();
        }

        return redirect()->route('profile');
    }
}
