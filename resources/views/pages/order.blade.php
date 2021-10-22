@extends('layouts.index')
@section('content')
<div class="col-lg-12 col-md-12">

    <div class="row pt-4 ml-0 mr-0">
        <div class="col-md-12 card card-border-radius mb-2 pt-4 pb-1">
            <div class="d-flex custom-top-div align-items-center">
                {{--                        @dd($order->fulfillment_status)--}}
                <div class="custom-left-arrow-div " ><a style="text-decoration: none; padding:19px; font-size: 30px; color: black;" href="{{route('home')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i></a></div>
                <div><h4>{{$order->order_number}}</h4></div>
                @if($order->financial_status == "paid")
                    <div class="ml-1"><span class="badge badge-pill badge-primary py-1 px-2">Paid</span></div>
                @elseif($order->financial_status == 'partially paid')
                    <div class="ml-1"><span class="badge badge-pill badge-primary text-white py-1 px-2">Partially Paid</span></div>
                @elseif($order->financial_status == 'pending')
                    <div class="ml-1"><span class="badge badge-pill badge-primary text-white py-1 px-2">Pending</span></div>
                @elseif($order->financial_status == 'authorized')
                    <div class="ml-1"><span class="badge badge-pill badge-primary text-white py-1 px-2">Authorized</span></div>
                @else
                    <div class="ml-1"><span class="badge badge-pill badge-primary text-white py-1 px-2">{{$order->financial_status}}</span></div>
                @endif

                @if($order->fulfillment_status == null)
                    <div class="ml-1"><span class="badge badge-pill badge-primary text-white py-1 px-2">Unfulfilled</span></div>
                @elseif($order->fulfillment_status == 'partial')
                    <div class="ml-1"><span class="badge badge-pill badge-primary text-white py-1 px-2">Partial Fulfilled</span></div>
                @elseif($order->fulfillment_status == 'fulfilled')
                    <div class="ml-1"><span class="badge badge-pill badge-primary text-white py-1 px-2">Fulfilled</span></div>
                @endif

            </div>
            <div class="ml-5 pl-3">
                <div><p>{{ \Carbon\Carbon::parse($order->created_at)->format('F d, Y ')}} at {{ \Carbon\Carbon::parse($order->created_at)->format('g:i A')}}  from Online Store</p></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-8">
            <div class="card bg-white border-0 shadow-sm">
                <div class="card-header bg-white border-light">
                    <div class="col-12 text-left">
                        @if($order->fulfillment_status == null)
                            <h6 class="badge badge-pill badge-primary text-white py-1 px-2" style="font-size: 100%;">Unfulfilled</h6>
                        @elseif($order->fulfillment_status == 'partial')
                            <h6 class="badge badge-pill badge-primary text-white py-1 px-2" style="font-size: 100%;">Partial Fulfilled</h6>
                        @elseif($order->fulfillment_status == 'fulfilled')
                            <h6 class="badge badge-pill badge-primary text-white py-1 px-2" style="font-size: 100%;">Fulfilled</h6>
                        @endif
                    </div>
                </div>

                <table class="product-table view-table">
{{--                    @dd($order->order_line_items[0]->product_varient)--}}
                    <tbody data-order-summary-section="line-items" class="table-body">
                    @foreach($order->order_line_items as $line_item)
                    <tr class="product ">
                        <td class="product__image" style="width:20%; padding-top:2em;padding-bottom: 2em;padding-left: 5%;">
                            <div class="product-thumbnail" style="position:relative;">
                                <div class="product-thumbnail__wrapper">
                                    @if(isset($line_item->product_varient->image))
                                    <img alt="image" width="70px" height="70px" src="{{$line_item->product_varient->image}}" class="product-thumbnail__image">
                                    @else
                                        <img src="https://hermes-fish-boutique.test/forblank/rsz_blankimage.jpg" width="70px" height="70px" class="product-thumbnail__image">
                                    @endif
                                </div>
                                <span class="product-thumbnail__quantity" aria-hidden="true">{{$line_item->quantity}}</span>
                            </div>
                        </td>
                        <th class="product__description text-left" style="width:30%;font-size: large;" scope="row">
                            <small class="">{{$line_item->title}}</small>
                            <br>
                            <small class="">{{$line_item->variant_title}}</small>
                            <br>
                            <small class="">{{$line_item->sku}}</small>
                        </th>
                        <td class="product__quantity" style="width:10%">
                        <span class="visually-hidden" style="display:none;">
                         {{$line_item->quantity}}
                        </span>
                        </td>
                        <td class=" text-center"  style="width:20%;">
                            <span>{{$order->currency}} {{ number_format($line_item->price,2) }} x {{$line_item->quantity}}</span>
                        </td>
                        <td class="product-price  pl-4"  style="width:20%;">
                            <span>{{$order->currency}} {{ number_format($line_item->price * $line_item->quantity,2) }}</span>
                        </td>
                    </tr>
                    <tr style="border: 1px solid #E1E3E5;"></tr>
                    @endforeach
                    </tbody>
                </table>
{{--                <div class="card-footer bg-white">--}}
{{--                    <div class="col-12 text-right">--}}
{{--                        <a href="" type="button" class="btn btn-success">Fulfill Items</a>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
            <div class="card bg-white border-0 mt-3 mb-3 shadow-sm">
                <div class="card-header bg-white border-light">
                    <div class="col-12 text-left">
                        @if($order->financial_status == "paid")
                            <h6 class="badge badge-pill badge-primary py-1 px-2" style="font-size: 18px">Paid</h6>
                        @elseif($order->financial_status == 'partially paid')
                            <h6 class="badge badge-pill badge-primary text-white py-1 px-2" style="font-size: 18px">Partially Paid</h6>
                        @elseif($order->financial_status == 'pending')
                            <h6 class="badge badge-pill badge-primary text-white py-1 px-2" style="font-size: 18px">Pending</h6>
                        @elseif($order->financial_status == 'authorized')
                            <h6 class="badge badge-pill badge-primary text-white py-1 px-2" style="font-size: 18px">Authorized</h6>
                        @else
                            <h6 class="badge badge-pill badge-primary text-white py-1 px-2" style="font-size: 18px">{{$order->financial_status}}</h6>
                        @endif
                    </div>
                </div>
                <div class="card-body bg-white border-light">
                    <div class="row">
                        <div class="col-md-3">Subtotal</div>
                        <div class="col-md-3">{{count($order->order_line_items)}} Items</div>
                        <div class="col-md-6 text-right">{{$order->currency}} {{number_format($order->sub_total,2)}}</div>
                        <div class="col-md-6 mt-2">Total</div>
                        <div class="col-md-6 mt-2 text-right">{{$order->currency}} {{number_format($order->total_price,2)}}</div>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <div class="row">
                        <div class="col-md-6">Paid by customer</div>
                        <div class="col-md-6 text-right"><b>  {{$order->currency}} {{number_format($order->total_price,2)}} </b></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4">
            <div class="card border-light border-0 text-indigo shadow-sm">
                <div class="card-header bg-white">
                    <h6>Note</h6>
                </div>

                <div class="card-body bg-white">
                    @if(isset($order->note))
                    <p>{{$order->note}}</p>
                    @else
                        <p>No Note</p>
                    @endif
                </div>

            </div>
            <div class="mt-2">
                <div class="card border-light border-0 text-indigo shadow-sm">
                    <div class="card-header bg-white">
                        <h6>Customer</h6>
                    </div>

                    <div class="card-body bg-white">
                        @if(isset($order->first_name) && ($order->last_name))
                        <p>{{$order->first_name}} {{$order->last_name  }}</p>
                        @else
                            <p>No Name</p>
                        @endif
                    </div>

                </div>
            </div>
            <div class="mt-1">
                <div class="card border-light border-0 text-indigo shadow-sm">
                    <div class="card-header bg-white">
                        <h6>CONTACT INFORMATION</h6>
                    </div>

                    <div class="card-body bg-white">
                        @if(isset($order->first_name) && ($order->last_name))
                            <span>{{$order->first_name}} {{$order->last_name  }}</span>
                        @else
                            <span>No Name</span>
                        @endif
                        <br>
                            @if(isset($order->email))
                        <span>{{$order->customer_email}}</span>
                            @else
                                <span>No Email</span>
                            @endif
                        <br>
                            @if(isset($order->customer_phone))
                        <span>{{$order->customer_phone}}</span>
                            @else
                                <span>No Phone</span>
                            @endif
                    </div>

                </div>
            </div>
            <div class="mt-1">
                <div class="card border-light border-0 text-indigo shadow-sm">
                    <div class="card-header bg-white">
                        <h6>SHIPPING ADDRESS</h6>
                    </div>

                    <div class="card-body bg-white">
                        @if(isset($order->ship_name))
                            <span>Name : {{$order->ship_name}}</span>
                        @else
                            <span>No Name</span>
                        @endif
                        <br>
                            @if(isset($order->ship_address1))
                                <span>Address1 : {{$order->ship_address1}}</span>
                            @else
                                <span>No Address</span>
                            @endif
                        <br>
                            @if(isset($order->ship_address2))
                                <span>Address2 : {{$order->ship_address2}}</span>
                            @else
                                <span>No Address</span>
                            @endif
                        <br>
                            @if(isset($order->ship_city) && $order->ship_zip)
                                <span>City & Zip : {{$order->ship_city}} {{$order->ship_zip}}</span>
                            @else
                                <span>No Code</span>
                            @endif
                        <br>
                            @if(isset($order->ship_country))
                                <span>Country : {{$order->ship_country}}</span>
                            @else
                                <span>Not Defined</span>
                            @endif
                        <br>
                            @if(isset($order->ship_phone))
                                <span>Phone : {{$order->ship_phone}}</span>
                            @else
                                <span>No Phone</span>
                            @endif
                    </div>

                </div>
            </div>
            <div class="mt-1 mb-3">
                <div class="card border-light border-0 text-indigo shadow-sm">
                    <div class="card-header bg-white">
                        <h6>BILLING  ADDRESS</h6>
                    </div>

                    <div class="card-body bg-white">
                        @if(isset($order->billing_name))
                            <span>Name : {{$order->billing_name}}</span>
                        @else
                            <span>No Name</span>
                        @endif
                        <br>
                        @if(isset($order->billing_address1))
                            <span>Address1 : {{$order->billing_address1}}</span>
                        @else
                            <span>No Address</span>
                        @endif
                        <br>
                        @if(isset($order->billing_address2))
                            <span>Address2 : {{$order->billing_address2}}</span>
                        @else
                            <span>No Address</span>
                        @endif
                        <br>
                        @if(isset($order->billing_city) && $order->billing_zip)
                            <span>City & Zip : {{$order->billing_city}} {{$order->billing_ip}}</span>
                        @else
                            <span>No Code</span>
                        @endif
                        <br>
                        @if(isset($order->billing_country))
                            <span>Country : {{$order->billing_country}}</span>
                        @else
                            <span>Not Defined</span>
                        @endif
                        <br>
                        @if(isset($order->billing_hone))
                            <span>Phone : {{$order->billing_phone}}</span>
                        @else
                            <span>No Phone</span>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
@endsection
