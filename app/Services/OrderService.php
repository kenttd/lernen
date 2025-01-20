<?php

namespace App\Services;

use App\Casts\OrderStatusCast;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class OrderService {

    public function getOrderDetail($orderId) {
        return Order::find($orderId);
    }

    public function getOrders($status, $search, $sortby,$selectedSubject,$selectedSubGroup, $userId = null)
    {
        $orders = OrderItem::withWhereHas('orders' , function($query) use ($status, $userId) {
            $query->select('id', 'status','transaction_id');
            if(!empty($userId) && Auth::user()->hasRole('student')){
                $query->where('student_id' , $userId);
            }
            if (isset(OrderStatusCast::$statuses[$status])) {
                $query->whereStatus(OrderStatusCast::$statuses[$status]);
            }
        })
        ->withWhereHas('orderable', function($query) use ($userId) {
            if(!empty($userId) && Auth::user()->hasRole('tutor')){
                $query->where('tutor_id' , $userId);
            }
            $query->select('id','student_id','tutor_id')->with([ 'student','tutor']);
        });

        // if (!empty($search)) {
        //     $orders->where(function ($query) use ($search) {
        //         $query->where('subject', $search);
        //     });
        // }

        if (!empty($search)) {
            $orders->where(function ($query) use ($search) {
                $query->where('options->subject', $search);
            });
        }


        if (!empty($selectedSubject)) {
            $orders->where(function ($query) use ($selectedSubject) {
                $query->where('options->subject', $selectedSubject);
            });
        }

        if (!empty($selectedSubGroup)) {
            $orders->where(function ($query) use ($selectedSubGroup) {
                $query->where('options->subject_group', $selectedSubGroup);
            });
        }

        $orders = $orders->orderBy('id', $sortby ?? 'asc')
            ->paginate(setting('_general.per_page_opt') ?? 10);

        return $orders;
    }



    public function createOrder($billingDetail) {
    return  Order::create($billingDetail);
    }

    public function updateOrder ($order , $newDetails) {
        if ($order->update($newDetails)) {
            return $order;
        }
        return false;
    }

    public function storeOrderItems($orderId,$items) {
        $order = Order::find($orderId);
        if ($order) {
            foreach ($items as $item) {
                $order->items()->updateOrCreate(
                    ['orderable_id' => $item['orderable_id'], 'order_id' => $orderId],
                    $item
                );
            }
        }
        return true;
    }


    public function orderItem($tutorId) {
        return Order::whereHas('items', function ($query) use ($tutorId) {
                $query->whereHas('orderable', function ($query) use ($tutorId) {
                    $query->where('tutor_id', $tutorId);
                });
        })->first();
    }

    public function updateOrderItem($orderItem, $newDetails) {
        if ($orderItem->update($newDetails)) {
            return true;
        }
        return false;
    }

    public function getTotalCommission() {
        return OrderItem::sum('platform_fee');
    }


}
