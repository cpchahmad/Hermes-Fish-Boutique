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

    <div class="row mt-2">
        <div class="col-12">
            <div class="card">
                @if (count($orders) > 0)
                    <table class="table table-hover">
                        <thead class="border-0">
                        <tr>
                            <th>Order</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Currency</th>
                            <th class="text-end">Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($orders as $index => $order)
                            <tr>
                                <td style="display: flex;justify-content: space-between;">
                                    <a href="{{route('check.order.view',($order->id))}}">{{ $order->id }}</a>
                                </td>
                                <td class="">{{\Illuminate\Support\Carbon::createFromTimeString($order->created_at)->format('d-m-Y')}}</td>
                                <td class="">{{ $order->currency }} {{ number_format(($order->total_price)/100, 2) }}</td>
                                <td class="">{{ $order->currency }}</td>
                                <td>
                                    <a href="{{route('check.order.view',($order->id))}}" class="btn btn-sm btn-primary" type="button">@if($order->create_status == 'yes') Edit @else view @endif</a>
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
