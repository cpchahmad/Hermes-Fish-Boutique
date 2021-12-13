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
            <h3>Shipping Days</h3>
        </div>
        <div class="col-6 text-right">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                Add days
            </button>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Shipping Day & time</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{route('shipping_day.add')}}" method="post">
                            @sessionToken

                        <div class="modal-body">
                            <div class="form-group  text-left">
                                <label for="day" class="form-label">Day</label>
                                <input class="form-control bg-white" name="day" id="day" placeholder="Enter day name" required>
                            </div>
                            <div class="form-group  text-left">
                                <label for="time" class="form-label">Time</label>
                                <input class="form-control bg-white" name="time" id="time" placeholder="Enter time" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>



    </div>

    <div class="row">
        <div class="col-12">
                <div class="card">
                    @if (count($shipping_days) > 0)
                    <table class="table table-hover">
                        <thead class="border-0">
                        <tr>
                            <th>Day</th>
                            <th>time</th>
                            <th class="text-end">Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($shipping_days as $index => $shipping)
                            <tr>

                                <td class="">{{ $shipping->day}} </td>
                                <td class="">{{ $shipping->time}}</td>


                                <td>

                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal-{{$shipping->id}}">
                                        Edit
                                    </button>
                                        <a href="{{route('shipping_day.delete',($shipping->id))}}" class="btn btn-sm btn-danger" type="button"> Delete</a>
                                </td>
                            </tr>
                            <div class="modal fade" id="editModal-{{$shipping->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Update Shipping Day & time</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{route('shipping_day.update',($shipping->id))}}" method="post">
                                            @sessionToken

                                            <div class="modal-body">
                                                <div class="form-group  text-left">
                                                    <label for="day" class="form-label">Day</label>
                                                    <input class="form-control bg-white" name="day" id="day" placeholder="Enter day name" value="{{$shipping->day}}" required>
                                                </div>
                                                <div class="form-group  text-left">
                                                    <label for="time" class="form-label">Time</label>
                                                    <input class="form-control bg-white" name="time" id="time" placeholder="Enter time" value="{{$shipping->time}}" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                        </tbody>
                    </table>
                    @else
                        <p>No Days Found</p>
                    @endif

                        <div class="pagination">
                            {{ $shipping_days->links("pagination::bootstrap-4") }}
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
