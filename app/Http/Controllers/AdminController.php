<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Models\CheckOrderLine;
use App\Models\CheckoutOrder;
use App\Models\Line_Item;
use App\Models\Order;
use App\Models\OrderLineItem;
use App\Models\Product;
use App\Models\ProductVarient;
use App\Models\ShippingDay;
use App\Models\Varient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Profiler\Profile;

class AdminController extends Controller
{
    public function orders(){
        $orders = Order::latest()->paginate(20);
        $notification = CheckoutOrder::where('status',0)->count();
        return view('pages.orders')->with([
            'orders'=>$orders,
            'notification'=>$notification,
        ]);
    }
    public function ShopifyOrders($next = null)
    {
        $shop = Auth::user();
        $orders = $shop->api()->rest('GET', '/admin/orders.json', [
            'limit' => 250,
            'page_info' => $next
        ]);
        $orders = json_decode(json_encode($orders));
        foreach ($orders->body->orders as $order) {
            $this->createShopifyOrders($order, $shop);
        }
        if (isset($orders->link->next)) {
            $this->ShopifyOrders($orders->link->next);
        }
        return Redirect::tokenRedirect('home', ['notice' => 'Orders Synced Successfully']);
    }

    public function createShopifyOrders($order, $shop)
    {
        $o = Order::where('shopify_id', $order->id)->first();
        if ($o === null) {
            $o = new Order();
        }
        $o->shopify_id = $order->id;
        $o->order_number = $order->name;
        $o->note = $order->note;
        $o->date = $order->created_at;
        if(isset($order->customer)) {
            $o->first_name = $order->customer->first_name;
            $o->last_name = $order->customer->last_name;
            $o->customer_phone = $order->customer->phone;
            $o->customer_email = $order->customer->email;
        }
        $o->currency = $order->currency;
        $o->total_price = $order->total_price;
        $o->financial_status = $order->financial_status;
        $o->fulfillment_status = $order->fulfillment_status;
        $o->total_discount = $order->total_discounts;

        $o->ship_name = $order->shipping_address->name;
        $o->ship_address1 = $order->shipping_address->address1;
        $o->ship_address2 = $order->shipping_address->address2;
        $o->ship_phone = $order->shipping_address->phone;
        $o->ship_city = $order->shipping_address->city;
        $o->ship_zip = $order->shipping_address->zip;
        $o->ship_province = $order->shipping_address->province;
        $o->ship_country = $order->shipping_address->country;

        $o->billing_name = $order->billing_address->name;
        $o->billing_address1 = $order->billing_address->address1;
        $o->billing_address2 = $order->billing_address->address2;
        $o->billing_phone = $order->billing_address->phone;
        $o->billing_city = $order->billing_address->city;
        $o->billing_zip = $order->billing_address->zip;
        $o->billing_province = $order->billing_address->province;
        $o->billing_country = $order->billing_address->country;

        if (isset($order->shipping_lines[0])){
            $o->total_shipping = $order->shipping_lines[0]->price;
        }
        $o->sub_total = $order->subtotal_price;
        $o->save();

        foreach ($order->line_items as $item) {
            $ol = OrderLineItem::where('shopify_id', $item->id)->first();
            if ($ol === null) {
                $ol = new OrderLineItem();
            }
            $ol->order_id = $order->id;
            $ol->shopify_id = $item->id;
            $ol->product_id = $item->product_id;
            $ol->sku = $item->sku;
            $ol->title = $item->title;
            $ol->price = $item->price;
            $ol->quantity = $item->quantity;
            $ol->variant_id = $item->variant_id;
            $ol->variant_title = $item->variant_title;
            $ol->save();
        }

    }
    public function order_view($id){
        $order = Order::where('id',$id)->first();
        $notification = CheckoutOrder::where('status',0)->count();
        return view('pages.order')->with([
            'order'=>$order,
            'notification'=>$notification,
        ]);
    }
    public function filter_orders(Request $request){
//        dd($request->all());
        $filtered_orders = Order::where('financial_status','like', '%' . $request->filter . '%')->paginate(20);
        $notification = CheckoutOrder::where('status',0)->count();
        return view('pages.orders')->with([
            'orders'=>$filtered_orders,
            'notification'=>$notification,
        ]);
    }

    public function ShopifyProducts($next = null)
    {
        $shop = Auth::user();
        $products = $shop->api()->rest('GET', '/admin/products.json', [
            'limit' => 250,
            'page_info' => $next
        ]);
        $products = json_decode(json_encode($products));

        foreach ($products->body->products as $product) {
            $this->createShopifyProducts($product, $shop);
        }
        if (isset($products->link->next)) {
            $this->ShopifyProducts($products->link->next);
        }
        return Redirect::tokenRedirect('home', ['notice' => 'Products Synced Successfully']);
    }

    public function createShopifyProducts($product, $shop)
    {
        $p = Product::where('shopify_id', $product->id)->first();
        if ($p === null) {
            $p = new Product();
        }
        if ($product->images) {
            $image = $product->images[0]->src;
        } else {
            $image = '';
        }
        $p->shopify_id = $product->id;
        $p->title = $product->title;
        $p->description = $product->body_html;
        $p->handle = $product->handle;
        $p->vendor = $product->vendor;
        $p->type = $product->product_type;
        $p->featured_image = $image;
        $p->tags = $product->tags;
        $p->options = json_encode($product->options);
        $p->status = $product->status;
        $p->published_at = $product->published_at;
        $p->save();
        if (count($product->variants) >= 1) {
            foreach ($product->variants as $variant) {
                $v = ProductVarient::where('shopify_id', $variant->id)->first();
                if ($v === null) {
                    $v = new ProductVarient();
                }
                $v->shopify_id = $variant->id;
                $v->shopify_product_id = $variant->product_id;
                $v->title = $variant->title;
                $v->option1 = $variant->option1;
                $v->option2 = $variant->option2;
                $v->option3 = $variant->option2;
                $v->sku = $variant->sku;
                $v->requires_shipping = $variant->requires_shipping;
                $v->fulfillment_service = $variant->fulfillment_service;
                $v->taxable = $variant->taxable;
                if (isset($product->images)){
                foreach ($product->images as $image){
                    if (isset($variant->image_id)){
                        if ($image->id == $variant->image_id){
                        $v->image = $image->src;
                        }
                    }else{
                        $v->image = "";
                    }
                }
                }
                $v->price = $variant->price;
                $v->compare_at_price = $variant->compare_at_price;
                $v->weight = $variant->weight;
                $v->grams = $variant->grams;
                $v->weight_unit = $variant->weight_unit;
                $v->inventory_item_id = $variant->inventory_item_id;
                $v->save();
            }
        }
    }
    public function checkout_orders(){
        $orders = CheckoutOrder::where('status',0)->latest()->paginate(20);
        $notification = CheckoutOrder::where('status',0)->count();
        return view('pages.checkout-orders')->with([
            'orders'=> $orders,
            'notification'=>$notification,
        ]);
    }public function draft_orders(){
        $orders = CheckoutOrder::where('status',1)->latest()->paginate(20);
        $notification = CheckoutOrder::where('status',0)->count();
        return view('pages.checkout-orders')->with([
            'orders'=> $orders,
            'notification'=>$notification,
        ]);
    }
    public function check_order_view($id){
        $order = CheckoutOrder::where('id',$id)->first();
        $notification = CheckoutOrder::where('status',0)->count();
        return view('pages.checkout-order')->with([
            'order'=>$order,
            'notification'=>$notification,
        ]);
    }
    public function checkout_data(Request $request){

        $check_items = /*json_decode(json_encode(*/$request->checkout_items/*))*/;
        $o = new CheckoutOrder();
//        $o->note = $check_items->note;
        dd($check_items->currency);
        if($check_items !=null){


        $o->currency = $check_items->currency;
        $o->total_price = $check_items->total_price;
        $o->total_discount = $check_items->total_discount;
        $o->total_weight = $check_items->total_weight;
        }

        if ($request->news == 'on'){
            $o->news = $request->news;
        }else{
            $o->news = 'off';
        }
        if ($request->shipping_day != null && $request->shipping_time != null){

             $o->note = "Shipping Day: ".$request->shipping_day." Shipping Time: ".$request->shipping_time;

        }else{
            if($check_items !=null) {
                $o->note = $check_items->note;
            }else{
                $o->note ="";
            }

        }

        $o->emailorphone = $request->emailorphone;
        $o->country = $request->country;
        $o->first_name = $request->first_name;
        $o->last_name = $request->last_name;
        $o->address = $request->address;
        $o->apartment = $request->apartment;
        if ($request->city1 != null){
            $o->city = $request->city1;
        }
        elseif ($request->city2 != null){
            $o->city = $request->city2;
        }else{
            $o->city = '';
        }
        if ($request->postal1 != null){
            $o->postal = $request->postal1;
        }elseif ($request->postal2 != null){
            $o->postal = $request->postal2;
        }else{
            $o->postal = '';
        }

        if (isset($request->province)){
            $o->province = $request->province;
        }else{
            $o->province = '';
        }
        $o->save();

//        dd($check_items);
        if($check_items !=null) {
            foreach ($check_items->items as $item) {

                $ol = new CheckOrderLine();
                $ol->order_id = $o->id;
                $ol->product_id = $item->product_id;
                $ol->sku = $item->sku;
                $ol->title = $item->title;
                $ol->price = $item->price;
                $ol->quantity = $item->quantity;
                $ol->variant_id = $item->variant_id;
                $ol->variant_title = $item->variant_title;
                $ol->image = $item->image;
                $ol->save();
            }
        }
        return redirect('https://hermes-fish-boutique.myshopify.com/pages/thanks-for-order');
    }
    public function create_order(Request $request){

        $shop = Auth::user();
        $order = CheckoutOrder::where('id',$request->order_id)->first();
        $items = CheckOrderLine::where('order_id',$request->order_id)->get();
        $line_items = [];
        $has_extra_procucts = [];
        $for_discounts = [];
        $no_changes = [];
        $order_total_after_edit = 0;
        foreach ($items as $index => $item){
            $comparison_price = $item->price/100;
            if ($request->edited_price[$index] > $comparison_price){
                array_push($has_extra_procucts,[
                    'varient_id'=>$item->variant_id,
                    'charges'=> (json_decode($request->edited_price[$index])) - ($item->price/100),
                    'quantity'=>$item->quantity,
                ]);
                $item->price = json_decode($request->edited_price[$index]) * 100 ;

                $order_total_after_edit += (json_decode($request->edited_price[$index])) * $item->quantity;

            }

            if ($request->edited_price[$index] < $comparison_price){
                array_push($for_discounts,[
                    'varient_id'=>$item->variant_id,
                    'discount'=> ($item->price/100) - (json_decode($request->edited_price[$index])),
                    'quantity'=>$item->quantity,
                ]);
                $item->price = json_decode($request->edited_price[$index]) * 100;
                $order_total_after_edit += (json_decode($request->edited_price[$index])) * $item->quantity;
            }

            if ($comparison_price == $request->edited_price[$index]){
                array_push($no_changes,[
                    'varient_id'=>$item->variant_id,
                    'quantity'=> $item->quantity,
                ]);
                $order_total_after_edit += (json_decode($request->edited_price[$index])) * $item->quantity;
            }
            $item->save();
        }

        $order->total_price = $order_total_after_edit * 100 ;
        if (count($has_extra_procucts) > 0){
            foreach ($has_extra_procucts as $has_extra_procuct){
                array_push($line_items, [
                    "title" => "Extra  Charge",
                    "price" => $has_extra_procuct['charges'],
                    "quantity" => 1
                ]);
                array_push($line_items, [
                    "variant_id"=> $has_extra_procuct['varient_id'],
                    "quantity"=> $has_extra_procuct['quantity'],
                ]);
            }
        }

        if (count($for_discounts) > 0){
            foreach ($for_discounts as $for_discount){
                array_push($line_items, [
                    "variant_id"=> $for_discount['varient_id'],
                    "quantity"=> $for_discount['quantity'],
                    'applied_discount' => [ 'value_type'=> 'fixed_amount', 'value'=> $for_discount['discount'], 'amount'=> $for_discount['discount'] ]
                ]);

            }
        }

        if (count($no_changes) > 0){
            foreach ($no_changes as $no_change){
                array_push($line_items, [
                    "variant_id"=> $no_change['varient_id'],
                    "quantity"=> $no_change['quantity'],
                ]);

            }
        }

        $for_update = 'no';
        if (isset($order->draft_order_id) && $order->draft_order_id != null){
            $draft_order = $shop->api()->rest('PUT', '/admin/draft_orders/'.$order->draft_order_id.'.json', [
                "draft_order"=> [
                    "line_items"=>  $line_items,
                ]
            ]);
            $for_update = 'yes';
        }else{
            $draft_order = $shop->api()->rest('post', '/admin/draft_orders.json', [
                "draft_order"=> [
                    "line_items"=>  $line_items,
//                "shipping_line"=> [
//                    "title"=>"custom shipping",
//                    "custom"=> true,
//                    "handle"=> null,
//                    "price"=> $shipping_fee,
//                ]
                ]
            ]);
        }

        $draft_order = json_decode(json_encode($draft_order));
        $draft_order_id = $draft_order->body->draft_order->id;
        $invoice_url = $draft_order->body->draft_order->invoice_url;

        $draft_order_invoice = $shop->api()->rest('post', '/admin/draft_orders/'.$draft_order_id.'/send_invoice.json',[
              "draft_order_invoice"=> [
                        "to"=> $order->emailorphone,
                        "from"=> "yasir@tetralogicx.com",
                        "subject"=> "Order Trackify  Invoice",
                        "custom_message"=> "Thank you for ordering!",
                        "bcc"=> [
                            "yasir@tetralogicx.com"
                        ]
              ]
            ]);
        $order->status = 1 ;
        $order->create_status = 'yes';
        $order->draft_order_id = $draft_order_id;
        $order->invoice_url = $invoice_url;
        $order->save();
        if ($for_update = 'yes'){
        return Redirect::tokenRedirect('home', ['notice' => 'Order Updated Successfully']);
        }else{
            return Redirect::tokenRedirect('home', ['notice' => 'Order Created Successfully']);
        }
    }


    public function shipping_day(){
        $shipping_days = ShippingDay::latest()->paginate(20);
        $notification = CheckoutOrder::where('status',0)->count();
        return view('pages.shipping_days')->with([
            'shipping_days'=>$shipping_days,
            'notification'=>$notification,
        ]);
    }
    public function add_shipping_day(Request $request){

//        dd($request->all());
        $check_day=ShippingDay::where('day',$request->day)->first();
        if($check_day !=null){
            return Redirect::tokenRedirect('shipping_day', ['notice' => 'Day already exist!']);
        }
        $time_data=$request->time_data;
        if($time_data==null){

            return Redirect::tokenRedirect('shipping_day', ['notice' => 'Please add discount!']);
        }
        $time_array=array();
        foreach ($time_data as $data){
           array_push($time_array,$data['time']) ;
        }
//        dd($time_array);

        $time_array=json_encode($time_array);
        $shipping_day = new ShippingDay();
        $shipping_day->day=$request->day;
        $shipping_day->time=$time_array;
        $shipping_day->save();

        $this->addUpdateShopMetafields();


        return Redirect::tokenRedirect('shipping_day', ['notice' => 'Shipping Day Created Successfully']);
    }
    public function edit_shipping_day($id){
        $shipping = ShippingDay::findorfail($id);
        $notification = CheckoutOrder::where('status',0)->count();
        return view('pages.edit_shipping_days')->with([
            'shipping'=>$shipping,
            'notification'=>$notification,
        ]);
    }
    public function update_shipping_day($id,Request $request){
        $check_day=ShippingDay::where('day',$request->day)->where('id','!=',$id)->first();
        if($check_day !=null){
            return Redirect::tokenRedirect('shipping_day', ['notice' => 'Day already exist!']);
        }
        $time_data=$request->time_data;

        $time_array=array();
        if($request->input('time') !=null){
            $count=count($request->input('time'));

            for($i=0;$i<$count;$i++){
                array_push($time_array,$request->input('time')[$i]) ;
            }
        }
        if($time_data !=null) {

            foreach ($time_data as $data){
                array_push($time_array,$data['time']) ;
            }
        }

        $time_array=json_encode($time_array);
//dd($time_array);
        $shipping_day = ShippingDay::findorfail($id);
        $shipping_day->day=$request->day;
        $shipping_day->time=$time_array;
        $shipping_day->save();

        $this->addUpdateShopMetafields();

        return Redirect::tokenRedirect('shipping_day', ['notice' => 'Shipping Day Updated Successfully']);
    }
    public function delete_shipping_day($id){
        $shipping_day = ShippingDay::findorfail($id);
        $shipping_day->delete();
        $this->addUpdateShopMetafields();

        return Redirect::tokenRedirect('shipping_day', ['notice' => 'Shipping Day Deleted Successfully']);
    }

    public function addUpdateShopMetafields(){
        $shipping_days = ShippingDay::all();
//        $shipping_days=json_encode($shipping_days);
        $f_data=array();

        foreach ($shipping_days as $shipping_day){
            $data=array();
            $data['day']=$shipping_day->day;
            $data['time']=json_decode($shipping_day->time);
            array_push($f_data,$data);
        }
        $f_data=json_encode($f_data);

//        dd($shipping_days);
        $shop=Auth::user();
        $shop_metafield = $shop->api()->rest('post', '/admin/metafields.json', [
          "metafield" =>array(
              "key" => 'shipping_days',
              "value" => $f_data,
              "value_type" => "json_string",
              "namespace" => "shop",
          )

              /*[
              "namespace" => "shop",
              "key" => "test",
              "value" => "213232",
              "type" => "string"
              ]*/
        ]);
//            dd($shop_metafield);
        if($shop_metafield['errors']==true) {

            $metafields = $shop->api()->rest('get', '/admin/metafields.json');
            $metafields = json_decode(json_encode($metafields['body']['container']['metafields']));
//            dd($metafields);
            foreach ($metafields as $metafield){
//            dd($metafield);
                if($metafield->key=='shipping_days') {
                    $customers = $shop->api()->rest('put', '/admin/metafields/' . $metafield->id . '.json', [
                        "metafield" => [
                            "value" => $f_data,
                        ]
                    ]);
                }
            }
        }
    }
}
