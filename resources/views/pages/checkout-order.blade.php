@extends('layouts.index')
@section('content')
    <div class="col-lg-12 col-md-12">
        <form action="{{route('create.order')}}" method="POST">
            @sessionToken
        <div class="row">
            <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-success">@if ($order->create_status == 'yes') Update Order @else Create Order @endif</button>
{{--                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalCenter">--}}
{{--                    Create Order--}}
{{--                </button>--}}
{{--                <!-- Modal -->--}}
{{--                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">--}}
{{--                    <div class="modal-dialog modal-dialog-centered" role="document">--}}
{{--                        <div class="modal-content">--}}
{{--                            <div class="modal-header">--}}
{{--                                <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>--}}
{{--                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                                    <span aria-hidden="true">&times;</span>--}}
{{--                                </button>--}}
{{--                            </div>--}}
{{--                            <div class="modal-body">--}}
{{--                                ...--}}
{{--                            </div>--}}
{{--                            <div class="modal-footer">--}}
{{--                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>--}}
{{--                                <button type="button" class="btn btn-primary">Submit</button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
        </div>
            <input type="hidden" name="order_id" value="{{$order->id}}">
        <div class="row pt-2 ml-0 mr-0">
            <div class="col-md-12 card card-border-radius mb-2 pt-4 pb-1">
                <div class="d-flex custom-top-div align-items-center">
                    <div class="custom-left-arrow-div " ><a style="text-decoration: none; padding:19px; font-size: 30px; color: black;" href="@if ($order->create_status == 'yes') {{route('draft.orders')}} @else {{route('checkout.orders')}} @endif"><i class="fa fa-arrow-left" aria-hidden="true"></i></a></div>
                    <div><h4>#{{$order->id}}</h4></div>
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
{{--                        <div class="col-12 text-left">--}}
{{--                            @if($order->fulfillment_status == null)--}}
{{--                                <h6 class="badge badge-pill badge-primary text-white py-1 px-2" style="font-size: 100%;">Unfulfilled</h6>--}}
{{--                            @elseif($order->fulfillment_status == 'partial')--}}
{{--                                <h6 class="badge badge-pill badge-primary text-white py-1 px-2" style="font-size: 100%;">Partial Fulfilled</h6>--}}
{{--                            @elseif($order->fulfillment_status == 'fulfilled')--}}
{{--                                <h6 class="badge badge-pill badge-primary text-white py-1 px-2" style="font-size: 100%;">Fulfilled</h6>--}}
{{--                            @endif--}}
{{--                        </div>--}}
                    </div>

                    <table class="product-table view-table">
                        {{--                    @dd($order->order_line_items[0]->product_varient)--}}
                        <tbody data-order-summary-section="line-items" class="table-body">
                        @foreach($order->checklineitems as $line_item)
                            <tr class="product ">
                                <td class="product__image" style="width:20%; padding-top:2em;padding-bottom: 2em;padding-left: 5%;">
                                    <div class="product-thumbnail" style="position:relative;">
                                        <div class="product-thumbnail__wrapper">
                                            @if(isset($line_item->image))
                                                <img alt="image" width="70px" height="70px" src="{{$line_item->image}}" class="product-thumbnail__image">
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
{{--                                <td><a href="#">Edit</a></td>--}}
                                <td class="product__quantity" style="width:10%">
                        <span class="visually-hidden" style="display:none;">
                         {{$line_item->quantity}}
                        </span>
                                </td>
                                <td class="text-center"  style="width:20%;">
                                    <span>{{$order->currency}} <input style="width: 50%;" id="edited_price" class="" type="number" name="edited_price[]" data-quantity="{{$line_item->quantity}}" value="{{ number_format(($line_item->price)/100,0) }}"> x {{$line_item->quantity}}</span>
                                </td>
                                <td class="product-price  pl-4"  style="width:20%;">
                                    <span>{{$order->currency}} {{ number_format((($line_item->price)/100) * $line_item->quantity,2) }}</span>
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
                <div class="card bg-white border-0 mt-1 mb-3 shadow-sm">
                    <div class="card-header bg-white border-light">
{{--                        <div class="col-12 text-left">--}}
{{--                            @if($order->financial_status == "paid")--}}
{{--                                <h6 class="badge badge-pill badge-primary py-1 px-2" style="font-size: 18px">Paid</h6>--}}
{{--                            @elseif($order->financial_status == 'partially paid')--}}
{{--                                <h6 class="badge badge-pill badge-primary text-white py-1 px-2" style="font-size: 18px">Partially Paid</h6>--}}
{{--                            @elseif($order->financial_status == 'pending')--}}
{{--                                <h6 class="badge badge-pill badge-primary text-white py-1 px-2" style="font-size: 18px">Pending</h6>--}}
{{--                            @elseif($order->financial_status == 'authorized')--}}
{{--                                <h6 class="badge badge-pill badge-primary text-white py-1 px-2" style="font-size: 18px">Authorized</h6>--}}
{{--                            @else--}}
{{--                                <h6 class="badge badge-pill badge-primary text-white py-1 px-2" style="font-size: 18px">{{$order->financial_status}}</h6>--}}
{{--                            @endif--}}
{{--                        </div>--}}
                    </div>
                    <div class="card-body bg-white border-light">
                        <div class="row">
                            <div class="col-md-3">Subtotal</div>
                            <div class="col-md-3">{{count($order->checklineitems)}} Items</div>
                            <div class="col-md-6 text-right">{{$order->currency}} {{number_format(($order->total_price)/100,2)}}</div>
                            <div class="col-md-6 mt-2">Total</div>
                            <div class="col-md-6 mt-2 text-right">{{$order->currency}} {{number_format(($order->total_price)/100,2)}}</div>
                        </div>
                    </div>
                    <div class="card-footer bg-white">
                        <div class="row">
                            <div class="col-md-6">Paid by customer</div>
                            <div class="col-md-6 text-right"><b>  {{$order->currency}} {{number_format(($order->total_price)/100,2)}} </b></div>
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
{{--                <div class="mt-2">--}}
{{--                    <div class="card border-light border-0 text-indigo shadow-sm">--}}
{{--                        <div class="card-header bg-white">--}}
{{--                            <h6>Customer</h6>--}}
{{--                        </div>--}}

{{--                        <div class="card-body bg-white">--}}
{{--                            @if(isset($order->first_name) && ($order->last_name))--}}
{{--                                <p>{{$order->first_name}} {{$order->last_name  }}</p>--}}
{{--                            @else--}}
{{--                                <p>No Name</p>--}}
{{--                            @endif--}}
{{--                        </div>--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="mt-1">--}}
{{--                    <div class="card border-light border-0 text-indigo shadow-sm">--}}
{{--                        <div class="card-header bg-white">--}}
{{--                            <h6>CONTACT INFORMATION</h6>--}}
{{--                        </div>--}}

{{--                        <div class="card-body bg-white">--}}
{{--                            @if(isset($order->first_name) && ($order->last_name))--}}
{{--                                <span>{{$order->first_name}} {{$order->last_name  }}</span>--}}
{{--                            @else--}}
{{--                                <span>No Name</span>--}}
{{--                            @endif--}}
{{--                            <br>--}}
{{--                            @if(isset($order->email))--}}
{{--                                <span>{{$order->customer_email}}</span>--}}
{{--                            @else--}}
{{--                                <span>No Email</span>--}}
{{--                            @endif--}}
{{--                            <br>--}}
{{--                            @if(isset($order->customer_phone))--}}
{{--                                <span>{{$order->customer_phone}}</span>--}}
{{--                            @else--}}
{{--                                <span>No Phone</span>--}}
{{--                            @endif--}}
{{--                        </div>--}}

{{--                    </div>--}}
{{--                </div>--}}
                <div class="mt-1">
                    <div class="card border-light border-0 text-indigo shadow-sm">
                        <div class="card-header bg-white">
                            <h6>SHIPPING ADDRESS</h6>
                        </div>

                        <div class="card-body bg-white">
                            @if(isset($order) && $order->first_name && $order->last_name)
                                <span>Name : {{$order->first_name}} {{$order->last_name}}</span>
                            @else
                                <span>Name : No Name</span>
                            @endif
                            <br>
                            @if(isset($order) && $order->address)
                                <span>Address : {{$order->address}}</span>
                            @else
                                <span> Address :  No Address</span>
                            @endif
                            <br>
                            @if(isset($order->city) && $order->zip)
                                <span>City & Zip : {{$order->city}} {{$order->zip}}</span>
                            @else
                                <span>Zip : No Code</span>
                            @endif
                            <br>
                            @if(isset($order->country))
                                <span>Country : {{$order->country}}</span>
                            @else
                                <span>Country : Not Defined</span>
                            @endif
                            <br>
                            @if(isset($order->emailorphone))
                                <span>Email or Phone : {{$order->emailorphone}}</span>
                            @else
                                <span> Email or Phone :  No Defined</span>
                            @endif
                        </div>
                    </div>
                </div>
{{--                <div class="mt-1 mb-3">--}}
{{--                    <div class="card border-light border-0 text-indigo shadow-sm">--}}
{{--                        <div class="card-header bg-white">--}}
{{--                            <h6>BILLING  ADDRESS</h6>--}}
{{--                        </div>--}}

{{--                        <div class="card-body bg-white">--}}
{{--                            @if(isset($order->billing_name))--}}
{{--                                <span>Name : {{$order->billing_name}}</span>--}}
{{--                            @else--}}
{{--                                <span>No Name</span>--}}
{{--                            @endif--}}
{{--                            <br>--}}
{{--                            @if(isset($order->billing_address1))--}}
{{--                                <span>Address1 : {{$order->billing_address1}}</span>--}}
{{--                            @else--}}
{{--                                <span>No Address</span>--}}
{{--                            @endif--}}
{{--                            <br>--}}
{{--                            @if(isset($order->billing_address2))--}}
{{--                                <span>Address2 : {{$order->billing_address2}}</span>--}}
{{--                            @else--}}
{{--                                <span>No Address</span>--}}
{{--                            @endif--}}
{{--                            <br>--}}
{{--                            @if(isset($order->billing_city) && $order->billing_zip)--}}
{{--                                <span>City & Zip : {{$order->billing_city}} {{$order->billing_ip}}</span>--}}
{{--                            @else--}}
{{--                                <span>No Code</span>--}}
{{--                            @endif--}}
{{--                            <br>--}}
{{--                            @if(isset($order->billing_country))--}}
{{--                                <span>Country : {{$order->billing_country}}</span>--}}
{{--                            @else--}}
{{--                                <span>Not Defined</span>--}}
{{--                            @endif--}}
{{--                            <br>--}}
{{--                            @if(isset($order->billing_hone))--}}
{{--                                <span>Phone : {{$order->billing_phone}}</span>--}}
{{--                            @else--}}
{{--                                <span>No Phone</span>--}}
{{--                            @endif--}}
{{--                        </div>--}}

{{--                    </div>--}}
{{--                </div>--}}
            </div>
        </div>
            <div class="row pt-2 ml-0 mr-0">
                <div class="col-md-12 card card-border-radius mb-2 pt-4 pb-3">
                    <div class="d-flex custom-top-div align-items-center">
                        <div class="custom-left-arrow-div"><h4>Invoice Url</h4></div>
                    </div>
                    <div>
                        @if($order->invoice_url != null)
                            <div style="display: flex; justify-content: space-between;"><input value="{{$order->invoice_url}}" class="form-control linkToCopy" type="text" disabled style="font-size: 16px; font-family: 'OpenSans'; width: 91% !important;  border-right: 0px !important;margin-bottom: 0px !important;cursor: text">
                        <button type="button" style="font-family: 'OpenSans-Bold';" class="btn btn-success copyButton">Copy to ClipBoard</button></div>
                        @else
                        <div style="display: flex; justify-content: space-between;">You have not created order yet!</div>
                        @endif
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $('button.copyButton').click(function(){

            $(this).siblings('input.linkToCopy').prop('disabled',false);
            $(this).siblings('input.linkToCopy').select();
            document.execCommand("copy");
            $(this).siblings('input.linkToCopy').prop('disabled',true);
        });
    </script>
@endsection
