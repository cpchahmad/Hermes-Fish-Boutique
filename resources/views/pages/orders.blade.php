@extends('layouts.index')
@section('content')
    <style>
        .badge-success {
            background-color: green !important;
        }
        .badge-danger {
            background-color: orangered !important;
        }
        .badge-warning {
            background-color: #ffc107 !important;
        }
        .badge-info {
            background-color: #17a2b8!important;
        }

    </style>
    <div class="row">
        <div class="col-6">
            <h3>Orders</h3>
        </div>
        <div class="col-6 text-right">
            <a href="{{route('sync.products')}}" type="button" class="btn btn-primary">Sync Products</a>
            <a href="{{route('sync.orders')}}" type="button" class="btn btn-primary">Sync Orders</a>
        </div>

        <div class="col-md-12 mt-2">
            <div class="form-group">
                <form action="{{route('filter.orders')}}" method="GET">
                    @sessionToken
                <div class="input-group">
                    <select class="form-control bg-white" name="filter" id="country">
                        <option selected disabled>Search by Finanacial Status</option>
                        <option value="paid">Paid</option>
                        <option value="partially paid">Partially paid</option>
                        <option value="pending">Payment pending</option>
                        <option value="refunded">Refunded</option>
                        <option value="partially refunded">Partially refunded</option>
                        <option value="unpaid">Unpaid</option>
                    </select>
                    <button  type="submit" class="btn btn-primary">Filter</button>
                </div>
                </form>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-12">
                <div class="card">
                    @if (count($orders) > 0)
                    <table class="table table-hover">
                        <thead class="border-0">
                        <tr>
                            <th>Order</th>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th class="text-center">Payment Status</th>
                            <th>Fulfillment</th>
                            <th class="text-end">Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($orders as $index => $order)
                            <tr>
                                <td style="display: flex;justify-content: space-between;">
                                    <a href="{{route('order.view',($order->id))}}">{{ $order->order_number }}</a>
                                    @if($order->note)
                                        <a href="#" class="show-note" title="{{$order->note}}">
                                            <i class="fa fa-sticky-note" aria-hidden="true"></i>
                                    @endif
                                </td>
                                <td class="">{{\Illuminate\Support\Carbon::createFromTimeString($order->created_at)->format('d-m-Y')}}</td>
                                <td class="">{{ $order->first_name}} {{ $order->last_name}}</td>

                                <td class="">{{$order->currency}} {{ number_format($order->total_price, 2) }}</td>
                                <td class="text-center">
                                    <div class="badge badge-pill

                                    @switch($order->financial_status)
                                    @case('paid')
                                        badge-success
                                            @break
                                    @case('pending')
                                        badge-warning
                                            @break
                                    @case('rejected')
                                        badge-danger
                                            @break
                                    @case('new')
                                        badge-info
                                            @break
                                    @default
                                    @endswitch">{{ $order->financial_status }}</div>
                                </td>

                                <td class="">
                                    <div class="badge badge-pill
                                    @switch($order->fulfillment_status)
                                    @case('fulfilled')
                                        badge-success
                                        @break
                                    @case('pending')
                                        badge-warning
                                        @break
                                    @case('cancelled')
                                        badge-danger
                                        @break
                                    @case('shipped')
                                        badge-primary
                                        @break
                                    @case('partial')
                                        badge-primary
                                        @break
                                    @case('Unfulfilled')
                                        badge-danger
                                        @break

                                    @default
                                    @endswitch @if($order->fulfillment_status == null)) badge-warning @endif">
                                        @if(isset($order->fulfillment_status)){{ $order->fulfillment_status }}@else pending @endif</div>
                                </td>

                                <td>
                                        <a href="{{route('order.view',($order->id))}}" class="btn btn-sm btn-primary" type="button"> view</a>
                                </td>

                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                    @else
                        <p>No Orders Found</p>
                    @endif

                        <div class="pagination">
                            {{ $orders->links("pagination::bootstrap-4") }}
                        </div>


                </div>

        </div>
    </div>
@endsection

<script>
    $(function () {
        $(".show-note").tooltip({
            show: {
                effect: "slideDown",
                delay: 300,
                display: inline - block,
                position: absolute,

            }
        });
    });
</script>
