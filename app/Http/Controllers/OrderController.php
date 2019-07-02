<?php

namespace App\Http\Controllers;

use App\Mail\OrderPerformed;
use App\Order;
use App\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list(Request $request)
    {
        $on_page = 0;
        switch ($request->type) {
            case 'overdue':
                /**
                 * просроченные
                 * дата доставки раньше текущего момента
                 * статус заказа 10
                 * сортировка по дате доставки по убыванию
                 */
                $models = Order::whereRaw('delivery_dt<NOW()')
                    ->where('status', '10')
                    ->orderBy('delivery_dt', 'desc');
                $on_page = config('prj.order_tabs.overdue.on_page');
                break;

            case 'current':
                /**
                 * текущие
                 * дата доставки 24 часа с текущего момента
                 * статус заказа 10
                 * сортировка по дате доставки по возрастанию
                 */
                $models = Order::whereRaw('delivery_dt>DATE_ADD(NOW(), INTERVAL 1 DAY)')
                    ->where('status', '10')
                    ->orderBy('delivery_dt');
                $on_page = config('prj.order_tabs.current.on_page');
                break;

            case 'new':
                /**
                 * новые
                 * дата доставки после текущего момента
                 * статус заказа 0
                 * сортировка по дате доставки по возрастанию
                 */
                $models = Order::whereRaw('delivery_dt>NOW()')
                    ->where('status', '0')
                    ->orderBy('delivery_dt');
                $on_page = config('prj.order_tabs.new.on_page');
                break;

            case 'performed':
                /**
                 * выполненные
                 * дата доставки в текущие сутки
                 * статус заказа 20
                 * сортировка по дате доставки по убыванию
                 */
                $models = Order::whereRaw('DATE(delivery_dt)=CURDATE()')
                    ->where('status', '20')
                    ->orderBy('delivery_dt', 'decs');
                $on_page = config('prj.order_tabs.performed.on_page');
                break;

            default:
                $on_page = config('prj.orders_on_page');
                $models = Order::orderBy('delivery_dt', 'desc');
        }

        if ($on_page>0) {
            $orders = $models->paginate($on_page);
        } else {
            $orders = $models->paginate();
        }

        return view('order-list', [
            'page_title' => 'Список заказов'.($request->page ? ', страница '.$request->page : ''),
            'orders' => $orders
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $order = Order::findOrFail($id);
        return view('order-edit', [
            'page_title' => 'Редактировать заказ #'.$order->id,
            'order' => $order,
            'partners' => Partner::orderBy('name')->get()
        ]);
    }

    /**
     * @param Request $request
     */
    public function update(Request $request)
    {
        $validator = $request->validate([
            'client_email' => 'required|email|max:255',
            'partner_id' => 'required|exists:partners,id',
            'status' => [
                'required',
                Rule::in(array_keys(config('prj.status_list')))
            ]
        ]);

        $order = Order::find($request->id);
        $old_status = $order->status;
        $order->status = $request->status;
        $order->client_email = $request->client_email;
        $partner = Partner::find($request->partner_id);
        $order->partner()->associate($partner);
        $order->save();

        $return_status = 'Заказ отредактирован.';

        if (20 == $request->status && $old_status != $request->status) {
            $emails = [];
            $collection = collect([
                [
                    'email' => $order->partner['email'],
                    'name' => $order->partner['name']
                ]
            ]);
            $emails[] = $order->partner['email'];
            foreach ($order->products as $product) {
                $collection->push([
                    'email' => $product->vendor['email'],
                    'name' => $product->vendor['name']
                ]);
                $emails[] = $product->vendor['email'];
            }
            Mail::to($collection)->send(new OrderPerformed($order));
            $return_status .= "\n<br> Уведомление отправлено партнеру и всем поставщикам продуктов на адреса - ".implode(', ', $emails);
        }

        return redirect()->route('order.edit', ['id' => $order->id])->with('status', $return_status);
    }
}
