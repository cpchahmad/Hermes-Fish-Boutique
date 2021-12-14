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
                        <form action="{{route('shipping_day.add')}}" class="form repeater-default" method="post">
                            @sessionToken

                        <div class="modal-body">
                            <div class="form-group  text-left">
                                <label for="day" class="form-label">Day</label>
                                <input class="form-control bg-white" name="day" id="day" placeholder="Enter day name" required>
                            </div>
                            <div class="form-group  text-left">
                                <div class="col-md-12" style="position: absolute;right: 2px;" align="right">
                                    <button data-repeater-create class="btn btn-primary" type="button">
                                        Add
                                    </button>
                                </div>
                                <label for="time" class="form-label">Time</label>

                            </div>
                            <div data-repeater-list="time_data" style="min-height: 200px;max-height: 200px !important; overflow-y: scroll;">

                                <div data-repeater-item class="row col-md-12" style="height: 75px">


                                    <div class="form-group mb-1 col-sm-12 col-md-10">
                                        <input class="form-control " name="time" id="time"
                                               value=""  placeholder="Enter time" required>
                                    </div>

                                    <div class="form-group col-sm-12 col-md-2 text-right" >
                                        <button type="button" class="btn btn-danger" data-repeater-delete>
                                            delete</button>
                                    </div>

                                    <hr>
                                </div>

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
{{--                            <th>time</th>--}}
                            <th class="text-end text-right">Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($shipping_days as $index => $shipping)
                            <tr>

                                <td class="">{{ $shipping->day}} </td>
{{--                                <td class="">{{ $shipping->time}}</td>--}}


                                <td class="text-right">

                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal-{{$shipping->id}}">
                                        View
                                    </button>
                                    <a href="{{route('shipping_day.edit',($shipping->id))}}" class="btn btn-sm btn-primary" type="button"> Edit</a>
                                    <a href="{{route('shipping_day.delete',($shipping->id))}}" class="btn btn-sm btn-danger" type="button"> Delete</a>

                                    <div class="modal fade" id="editModal-{{$shipping->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">View Time</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table">
                                                        <thead class="border-0">
                                                        <tr>
                                                            <th scope="col"><h6>Time</h6></th>


                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach(\GuzzleHttp\json_decode($shipping->time) as $time)
                                                            <tr>
                                                                <td>{{$time}}</td>
                                                            </tr>
                                                        @endforeach

                                                        </tbody>

                                                    </table>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>

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
@section('scripts')
<script>
    $(document).ready(function () {
        $('.repeater-default').repeater({
            show: function () {
                $(this).slideDown();
            },
            hide: function (deleteElement) {
                // if (confirm('Are you sure you want to delete this element?')) {
                $(this).slideUp(deleteElement);
                // }
            }
        });
        $('.repeater-update').repeater({
            show: function () {
                $(this).slideDown();
            },
            hide: function (deleteElement) {
                // if (confirm('Are you sure you want to delete this element?')) {
                $(this).slideUp(deleteElement);
                // }
            }
        });
    });
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
@endsection
