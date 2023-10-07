<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Status;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        return view('admin.order.index');
    }
    public function category(): View
    {
        $categories = Category::all();
        return view('admin.order.category', [
            'categories'=> $categories,
        ]);
    }

    public function status(): View
    {
        $orders = Order::all();
        $statuses = Status::all();
        return view('admin.order.status', [
            'orders'=> $orders,
            'statuses'=> $statuses
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validator =  $request->validate([
            'title' => ['required', 'string', 'unique:categories,title']
        ]);
        $category = new Category();
        $category->title = $validator['title'];
        $category->save();
        return back();
    }

    public function formStatusCompleted(string $id): View
    {
        return view('admin.order.statuses.completed', [
            'id' => $id
        ]);
    }

    public function formStatusCancel(string $id): View
    {
        return view('admin.order.statuses.reject', [
            'id' => $id
        ]);
    }

    public function editStatusOnComplete(string $id, Request $request)
    {
        $validator = $request->validate([
           'image' => ['required', 'mimes:jpg,jpeg,png', 'max:100']
        ]);

        if($validator) {
            $file = $request->file('image');
            $extesion = $file->getClientOriginalExtension();
            $newName = Str::random(10) . '.' . $extesion;
            Storage::putFileAs('public/image/orders', $file, $newName);

            $order = Order::where('id', $id)->update([
                'after_url' => $newName,
                'status_id' => 2
            ]);

            return redirect(route('manage.statuses'));
        }
    }

    public function editStatusOnCancel(string $id, Request $request)
    {
        $validator = $request->validate([
            'message' => ['required', 'string', 'min:10']
        ]);

        if($validator) {
            $order = Order::where('id', $id)->update([
                'rejection_reason' => $validator['message'],
                'status_id' => 3
            ]);

            return redirect(route('manage.statuses'));
        }
    }

    public function destroy(string $id)
    {
        $category = Category::find($id);
        if($category){
            $category->delete();
        }
        return back()->withInput();
    }
}
