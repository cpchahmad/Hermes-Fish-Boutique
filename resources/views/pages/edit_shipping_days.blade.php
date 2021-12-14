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
            <h3>Edit Shipping Day - {{$shipping->day}}</h3>
        </div>
        <div class="col-6 text-right">
            <a href="{{route('shipping_day')}}" class="btn btn-sm btn-primary" type="button"> Back</a>


        </div>



    </div>

    <div class="row">
        <div class="col-12">
                <div class="card">
                    <form action="{{route('shipping_day.update',($shipping->id))}}" class="form repeater-default" method="POST">
                        @sessionToken
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="form-material">
                                        <label for="material-error">Day</label>
                                        <input  class="form-control" type="text"  name="day"
                                                value="{{$shipping->day}}"   placeholder="" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12" style="right: 2px;" align="right">
                                    <button data-repeater-create class="btn btn-primary" type="button">
                                        Add
                                    </button>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-material">
                                        <label for="material-error">Time</label>
                                    </div>
                                </div>
                            </div>
                            <div data-repeater-list="time_data" >
                                @foreach(json_decode($shipping->time) as $index=> $time)
                                    <div  class="row col-md-12"{{-- style="height: 75px"--}} id="time_data{{$index}}">

                                        <div class="form-group mb-1 col-sm-12 col-md-10">
                                            <input  class="form-control" type="text"  name="time[]"
                                                    value="{{$time}}"   placeholder="Enter time" required>
                                        </div>

                                        <div class="form-group col-sm-12 col-md-2 text-right" >
                                            <button type="button" class="btn btn-danger delete_time_data" data-id="{{$index}}">
                                                delete
                                            </button>
                                        </div>

                                    </div>
                                @endforeach
                                    <div data-repeater-list="time_data" >

                                        <div data-repeater-item class="row col-md-12" >


                                            <div class="form-group mb-1 col-sm-12 col-md-10">
                                                <input class="form-control " name="time" id="time"
                                                       value=""  placeholder="Enter time" required>
                                            </div>

                                            <div class="form-group col-sm-12 col-md-2 text-right" >
                                                <button type="button" class="btn btn-danger" data-repeater-delete>
                                                    delete</button>
                                            </div>
                                        </div>

                                    </div>

                            </div>
                            <div class="modal-footer">
                                <div class=" text-right border-top">
                                    <button type="submit" class="btn btn-sm btn-primary" >Update</button>
                                </div>
                                <a href="{{route('shipping_day')}}"  class="btn btn-default">Cancel</a>
                            </div>
                        </div>


                    </form>

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
        $("body").on('click', '.delete_time_data', function () {
            var id= $(this).data('id');
            $('#time_data'+id).empty();
            $('#time_data'+id).hide();

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
