<?php

namespace App\Services;

use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class CartService
{
    protected $userId;
    protected $items;

    public function __construct()
    {

        $this->userId = Auth::id();
        $this->items = CartItem::where('user_id', $this->userId)->get();
    }

    public function add($id, $name, $qty, $price, $options = [])
    {
        $existingItem = $this->items->firstWhere('id', $id);

        if ($existingItem) {
            return $existingItem;
        } else {
            $item = CartItem::create([
                'booking_id'=> $id,
                'user_id'   => $this->userId,
                'name'      => $name,
                'qty'       => $qty,
                'price'     => $price,
                'options'   => json_encode($options),
            ]);


            $this->reloadItems();

            return $item;
        }
    }

    public function remove($id)
    {

        CartItem::where('user_id', $this->userId)
            ->where('booking_id', $id)
            ->delete();
        $this->reloadItems();
    }

    public function update($id, $qty)
    {
        CartItem::where('user_id', $this->userId)
            ->where('booking_id', $id)
            ->update(['qty' => $qty]);

        $this->reloadItems();
    }

    public function get($id)
    {
        return CartItem::where('user_id', $this->userId)
            ->where('booking_id', $id)
            ->first();
    }

    public function content()
    {
        return $this->items->map(function ($item) {

            if (!empty(Cache::get('remove-cart-' . $item->booking_id))) {
                $this->remove($item->id);
                Cache::forget('remove-cart-' . $item->booking_id);
            }
            $itemArray = $item->toArray();

            $itemArray['price'] = number_format($itemArray['price'], 2);

            if (!empty($itemArray['options'])) {
                $itemArray['options'] = json_decode($itemArray['options'], true);
            }

            return $itemArray;
        });
    }

    public function total($format = true)
    {

        $subtotal = $this->getSubtotal();
        $tax = 0;
        $shipping = 0;
        $total = $subtotal + $tax + $shipping;
        return $format ? formatAmount($total) : $total;
    }

    protected function getSubtotal()
    {

        return $this->items->sum(function ($item) {
            return $item->qty * $item->price;
        });
    }

    public function subtotal($format = true)
    {

        $subtotal = $this->getSubtotal();
        return $format ? formatAmount($subtotal) : $subtotal;
    }

    public function clear()
    {
        CartItem::where('user_id', $this->userId)->delete();
        $this->items = collect();
    }

    protected function reloadItems()
    {
        $this->items = CartItem::where('user_id', $this->userId)->get();
    }
}
