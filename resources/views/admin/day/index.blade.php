@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="white-box" style="overflow-y: auto;">
                <input type="hidden" class="user_id" name="id" value="{{$user->id}}">

                <div class="container m-t-10 m-b-20">
                    <div class="row">
                        <div class="col-md-12" style="display: flex; justify-content: center; align-items: center">
                            <div class="day-parent" style="display: flex; justify-content: center; align-items: center">
                                <div style="cursor: pointer" class="date-minus">
                                    <i class="fas fa-angle-left"></i>
                                </div>
                                <div class="m-r-10 m-l-10 date-show"></div>
                                <div style="cursor: pointer" class="date-plus">
                                    <i class="fas fa-angle-right"></i>
                                </div>

                                <div class="date" style="margin-left: 30px;">
                                    <input type="hidden" class="form-control">
                                    <span class="input-group-addon"
                                          style="background: none; border: none; cursor: pointer;">
                                        <i class="glyphicon glyphicon-th"></i>
                                    </span>
                                </div>
                            </div>
                            <div style="position:absolute; right: 0%;">
                                <h5>Protein` </h5>
                                <div>
                                    <span class="protein_eat">0</span>
                                    /
                                    <span class="protein_must">0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-parent">
                    <div class="col-small m-r-5">
                        <table class="firs-table table table-striped">
                            <thead>
                            <tr>
                                <th colspan="1">&nbsp;</th>
                            </tr>
                            <tr>
                                <th colspan="1">Time</th>
                            </tr>
                            </thead>
                            <tbody class="time_body">
                            </tbody>
                        </table>
                    </div>

                    <div class="col-medium m-r-5">
                        <table class="medium-table table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">&nbsp;</th>
                            </tr>
                            </thead>
                            <tbody class="font-sm activity_body">
                            <tr>
                                <th style="display: flex; justify-content: space-between; align-items: center;">
                                    Activity
                                    <button class="add-btn green" data-toggle="modal" data-target="#activity">
                                        <i class="fas fa-plus-circle"></i>
                                    </button>
                                </th>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-big m-r-5">
                        <table class="energy-table table table-striped border-green">
                            <thead>
                            <tr>
                                <th colspan="7" class="text-center">
                                    Energy Expenditure
                                </th>
                            </tr>
                            </thead>
                            <tbody class="energy_body">
                            <tr>
                                <td>Total&nbsp;cal</td>
                                <td>Fat&nbsp;%</td>
                                <td>Fat&nbsp;(c)</td>
                                <td>Fat&nbsp;(g)</td>
                                <td>Carb&nbsp;%</td>
                                <td>Carb&nbsp;(c)</td>
                                <td>Carb&nbsp;(g)</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-medium m-r-5">
                        <table class="medium-table table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">&nbsp;</th>
                            </tr>
                            </thead>
                            <tbody class="meal_body">
                            <tr>
                                <th style="display: flex; justify-content: space-between; align-items: center;">
                                    Meal / Water
                                    <button class="add-btn red" data-toggle="modal" data-target="#meal">
                                        <i class="fas fa-plus-circle"></i>
                                    </button>
                                </th>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-big m-r-5 ">
                        <table class="intake-table border-green table table-striped">
                            <thead>
                            <tr>
                                <th colspan="6" class="text-center">Intake</th>
                            </tr>
                            </thead>
                            <tbody class="intake_body">
                            <tr>
                                <td>Fat&nbsp;(g)</td>
                                <td>Fat&nbsp;Diges.</td>
                                <td>Carb&nbsp;(g)</td>
                                <td>Carb&nbsp;Dig.</td>
                                <td>Protein&nbsp;(g)</td>
                                <td>Protein&nbsp;Dig.</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-medium-two">
                        <table class="last-table table table-striped">
                            <thead>
                            <tr>
                                <th colspan="2" class="text-center red">Status</th>
                            </tr>
                            </thead>
                            <tbody class="status_body">
                            <tr class="bg-white">
                                <td class="text-center">Fat</td>
                                <td class="text-center">Carb</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div id="activity" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Activity</h4>
                </div>
                <div class="modal-body">
                    <h3 class="text-danger m-t-20 m-b-20 error_modal_activity"></h3>
                    <div class="form-group">
                        <label for="activity_list">Choose Activity</label>
                        <select name="activity" id="activity_list" class="activity_list form-control">
                            @foreach($activity as $key => $val)
                                <option value="{{$val->id}}">{{$val->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="activity_from">From</label>
                            <input type="text" class="activity_from clockpicker form-control">
                        </div>

                        <div class="form-group">
                            <label for="activity_to">To</label>
                            <input type="text" class="clockpicker activity_to form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success activity_save">Save</button>
                </div>
            </div>

        </div>
    </div>

    <div id="meal" class="modal fade bs-example-modal-lg in" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Meals</h4>
                </div>

                <div class="modal-body" style="position: relative; overflow-y: auto;">
                    <!-- Nav tabs -->
                    <ul class="nav customtab nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#personal" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true">
                                <span class="visible-xs"><i class="ti-home"></i></span>
                                <span class="hidden-xs">Choose Meal</span>
                            </a>
                        </li>
                        <li role="presentation" class="">
                            <a href="#add" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false">
                                <span class="visible-xs"><i class="ti-user"></i></span>
                                <span class="hidden-xs">Create Meal</span>
                            </a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="personal">
                            <div class="m_success text-success"></div>
                            <div class=" text-danger">
                                <ul class="m_errors"></ul>
                            </div>
                            <form class="add-personal-meal-form">
                                <input type="hidden" class="user_id" name="id" value="{{$user->id}}">
                                <input type="hidden" class="meal_date" name="date">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="activity_list">Choose Meal</label>
                                        <select name="meal" id="meal_list" class="meal_list form-control">
                                            <option value="">Choose Meal</option>
                                            @foreach($meals as $key => $val)
                                                <option value="{{$val->id}}">{{$val->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="total_mass">Total Mass</label>
                                        <input type="number" class="form-control" id="m_total_mass"
                                               placeholder="Total Mass"
                                               name="total_mass" readonly required value="">
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="total_carbs">Total Carbs</label>
                                        <input type="number" class="form-control" id="m_total_carbs"
                                               placeholder="Total Carbs"
                                               name="total_carbs" readonly required value="">
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="total_fat">Total Fat</label>
                                        <input type="number" class="form-control" id="m_total_fat"
                                               placeholder="Total Fat"
                                               name="total_fat" readonly required value="">
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="total_proteins">Total Proteins</label>
                                        <input type="number" class="form-control" id="m_total_proteins"
                                               placeholder="Total Proteins" name="total_proteins" readonly required
                                               value="">
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="total_calories">Total Calories</label>
                                        <input type="number" class="form-control" id="m_total_calories"
                                               placeholder="Total Calories" name="total_calories" readonly required
                                               value="">
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="total_ph">Total PH</label>
                                        <input type="number" class="form-control" id="m_total_ph" placeholder="Total PH"
                                               name="total_ph" readonly required value="">
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="total_glycemic_load">Total Glycemic Load</label>
                                        <input type="number" class="form-control" id="m_total_glycemic_load"
                                               placeholder="Total Glycemic Load" name="total_glycemic_load" readonly
                                               required value="">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="m_foods">

                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="meal_from">From</label>
                                        <input type="text" name="from" class="clockpicker meal_from form-control">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="meal_to">To</label>
                                        <input type="text" name="to" class="clockpicker meal_to form-control">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <button type="button"
                                                class="btn add-personal-meal btn-success waves-effect waves-light m-r-10">
                                            Save
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>


                        <div role="tabpanel" class="tab-pane fade" id="add">

                            <div class="success text-success"></div>
                            <div class=" text-danger">
                                <ul class="errors"></ul>
                            </div>

                            <form class="create_meal_form">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name"
                                           placeholder="Name" name="name" value="">
                                </div>

                                <div class="form-row">

                                    <div class="form-group col-md-3">
                                        <label for="total_mass">Total Mass</label>
                                        <input type="number" class="form-control" id="total_mass"
                                               placeholder="Total Mass"
                                               name="total_mass" readonly required>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="total_carbs">Total Carbs</label>
                                        <input type="number" class="form-control" id="total_carbs"
                                               placeholder="Total Carbs"
                                               name="total_carbs" readonly required>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="total_fat">Total Fat</label>
                                        <input type="number" class="form-control" id="total_fat" placeholder="Total Fat"
                                               name="total_fat" readonly required>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="total_proteins">Total Proteins</label>
                                        <input type="number" class="form-control" id="total_proteins"
                                               placeholder="Total Proteins" name="total_proteins" readonly required>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="total_calories">Total Calories</label>
                                        <input type="number" class="form-control" id="total_calories"
                                               placeholder="Total Calories" name="total_calories" readonly required>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="total_ph">Total PH</label>
                                        <input type="number" class="form-control" id="total_ph" placeholder="Total PH"
                                               name="total_ph" readonly required>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="total_glycemic_load">Total Glycemic Load</label>
                                        <input type="number" class="form-control" id="total_glycemic_load"
                                               placeholder="Total Glycemic Load" name="total_glycemic_load" readonly
                                               required>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="foods">
                                            <button type="button" class="btn btn-success col-md-2 m-b-20 plus"
                                                    style=" height: 200px;width: 200px;">
                                                <i class="fa fa-plus" style="font-size: 100px;"></i></button>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <button type="button"
                                                class="btn create-meal btn-success waves-effect waves-light m-r-10">
                                            Save
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>{{--end tab content--}}
                </div>{{--end modal body--}}
            </div>{{--end modal content--}}
        </div>
    </div>

@endsection

@push('footer')
    {{--Clock pickers for activity choose and meals choose--}}
    <script src="{{asset('assets/plugins/clockpicker/dist/jquery-clockpicker.js')}}"></script>
    <script src="{{asset('assets/plugins/datepicker-new/js/bootstrap-datepicker.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('.activity_from').clockpicker({
                autoclose: true,
                placement: 'bottom',
            });
            $('.activity_to').clockpicker({
                autoclose: true,
                placement: 'top',
            });

            $('.meal_from').clockpicker({
                autoclose: true,
                placement: 'top',
            });
            $('.meal_to').clockpicker({
                autoclose: true,
                placement: 'top',
            });
        });
    </script>

    <script !src="">
        $(document).ready(function () {

            {{--date switcher script--}}
            show_date();

            function show_date(type = 0, dateString = null) {
                let date = 0;

                if (type == 1) {
                    date = new Date(dateString);
                    date.setDate(date.getDate() + 1);
                } else if (type == 2) {
                    date = new Date(dateString);
                    date.setDate(date.getDate() - 1);
                } else if (dateString != null) {
                    date = new Date(dateString);
                    date.setDate(date.getDate());
                } else {
                    date = new Date();
                    date.setDate(date.getDate());
                }

                let day = ("0" + date.getDate()).slice(-2);
                let month = ("0" + (date.getMonth() + 1)).slice(-2);
                let dateShow = date.getFullYear() + "-" + (month) + "-" + (day);

                $('.date-show').html(dateShow);
                fill_table();
            }

            $('.date').datepicker({autoclose: true, format: 'yyyy-mm-dd'}).on('changeDate', function (e) {
                let str = new Date(e.date)
                mnth = ("0" + (str.getMonth() + 1)).slice(-2),
                    day = ("0" + str.getDate()).slice(-2);
                let date = [str.getFullYear(), mnth, day].join("-");
                $('.date-show').html(date);
                show_date(0, date);
            });

            $('.date-plus').click(function () {
                let dateString = $('.date-show').html();
                show_date(1, dateString)
            });

            $('.date-minus').click(function () {
                let dateString = $('.date-show').html();
                show_date(2, dateString)
            });

            $('.activity_save').click(function () {
                $('.error_modal_activity').empty();

                let data = {
                    activity: $('#activity_list').find(":selected").val(),
                    from: $('.activity_from').val(),
                    to: $('.activity_to').val(),
                    date: $('.date-show').html(),
                    id: $('.user_id').val(),
                };

                for (let i in data) {
                    if (data[i] === '' || data[i] === null) {
                        $('.error_modal_activity').html('Please Fill All Inputs!')
                        return;
                    }
                }

                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    },
                    url: '{{ url('/day/add-activity') }}',
                    data: data,
                    success: function (res) {
                        $('#activity').modal('toggle');
                        let date = $('.date-show').html()
                        show_date(0, date);
                    }
                });
            });

            $('.add-personal-meal').click(function () {
                var form = $('.add-personal-meal-form');
                $('.meal_date').val($('.date-show').html())

                $.ajax({
                    type: "POST",
                    url: "/day/add-meals",
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    },
                    data: form.serialize(),
                    success: function (data) {
                        console.log(data)
                        $('#meal').modal('toggle');
                        let date = $('.date-show').html()
                        show_date(0, date);
                    },
                    error: function (reject) {
                        $('.m_errors').empty()
                        $('.m_success').empty()
                        if (reject.status === 422) {
                            var err = $.parseJSON(reject.responseText);
                            $.each(err.errors, function (key, val) {
                                $('.m_errors').append(`<li>${val[0]}</li>`)
                            });
                        }
                        setTimeout(function () {
                            $('.m_errors').empty();
                        }, 10000);
                    }
                })
            })

            function fill_table() {
                var minutes = ['00', '10', '20', '30', '40', '50'];
                var hour = ['08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '01', '02', '03', '04', '05', '06', '07'];
                var count = 0;
                $('.tiem_tracer').each(function () {
                    $(this).remove()
                });
                $('.activity_name').each(function () {
                    $(this).remove()
                });
                $('.energy_name').each(function () {
                    $(this).remove()
                });
                $('.meal_name').each(function () {
                    $(this).remove()
                });
                $('.intake_name').each(function () {
                    $(this).remove()
                });
                $('.status_name').each(function () {
                    $(this).remove()
                });

                for (let i = 0; i < hour.length; i++) {
                    for (let j = 0; j < minutes.length; j++) {
                        $('.time_body').append(` <tr class="tiem_tracer">
                                                <th>${hour[i]}:${minutes[j]}</th>
                                             </tr>`)

                        $('.activity_body').append(`<tr class="activity_name act_${count} act_${i}_${j}" data-count="${count}" data-time="${hour[i]}:${minutes[j]}">
                                                    <td style="display: flex; justify-content: space-between; align-items: center;">
                                                        <div class="green"></div>
                                                        <div class="edit"></div>
                                                    </td>
                                                </tr>`);

                        $('.energy_body').append(`<tr class="energy_name eng_${count} eng_${i}_${j}" data-time="${hour[i]}:${minutes[j]}">
                                                    <td class="energy_total"></td>
                                                    <td class="energy_fat_p"></td>
                                                    <td class="energy_fat_c"></td>
                                                    <td class="energy_fat_g"></td>
                                                    <td class="energy_carb_p"></td>
                                                    <td class="energy_carb_c"></td>
                                                    <td class="energy_carb_g"></td>
                                                </tr>`);

                        $('.meal_body').append(`<tr class="meal_name meal_${count} meal_${i}_${j}" data-time="${hour[i]}:${minutes[j]}">
                                                    <td style="display: flex; align-items: center; justify-content: space-between">
                                                        <div class="red"></div>
                                                        <div class="edit_m"></div>
                                                    </td>
                                                </tr>`);

                        $('.intake_body').append(`<tr class="intake_name int_${count} int_${i}_${j}" data-time="${hour[i]}:${minutes[j]}">
                                                    <td class="intake_fat_g"></td>
                                                    <td class="intake_fat_d"></td>
                                                    <td class="intake_carb_g"></td>
                                                    <td class="intake_carb_d"></td>
                                                    <td class="intake_protein_g"></td>
                                                    <td class="intake_protein_d"></td>
                                                </tr>`);

                        $('.status_body').append(`<tr class="status_name stat_${count} stat_${i}_${j}" data-time="${hour[i]}:${minutes[j]}">
                                                     <td class="status_fat"></td>
                                                     <td class="status_carb"></td>
                                                </tr>`);
                        count++;
                    }
                }

                let data = {
                    date: $('.date-show').html(),
                    id: $('.user_id').val(),
                };

                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    },
                    url: '{{ url('/day/get-all-data') }}',
                    data: data,
                    success: function (res) {
                        console.log(res)
                        var from = [];
                        var to = [];
                        for (var i = 0; i < res.activity.length; i++) {
                            $(".activity_name").each(function (index) {
                                if (res.activity[i].from == $(this).data('time')) {
                                    from.push(index);
                                }
                                if (res.activity[i].to == $(this).data('time')) {
                                    to.push(index);
                                }
                            });

                        }

                        for (var j = 0; j < from.length; j++) {
                            $('.act_' + from[j]).attr('style', `height: ${50 * (to[j] - from[j] + 1)}px !important`);
                            $('.act_' + from[j]).find('.green').html(res.activity[j].get_activity.name);
                            $('.act_' + from[j]).find('.edit').html(`<i class="fas fa-edit" aria-hidden="true" data-activity-id="${res.activity[j].id}"></i>`)

                            $('.eng_' + from[j]).attr('style', `height: ${50 * (to[j] - from[j] + 1)}px !important`)
                            $('.eng_' + from[j]).html(`<td class="energy_total">${res.activity[j].get_activity.met}</td>
                                                       <td class="energy_fat_p">${res.activity[j].get_activity.fat_ratio}</td>
                                                       <td class="energy_fat_c">${res.activity[j].get_activity.fat_ratio}</td>
                                                       <td class="energy_fat_g">${res.activity[j].get_activity.fat_ratio}</td>
                                                       <td class="energy_carb_p">${res.activity[j].get_activity.carb_ratio}</td>
                                                       <td class="energy_carb_c">${res.activity[j].get_activity.carb_ratio}</td>
                                                       <td class="energy_carb_g">${res.activity[j].get_activity.carb_ratio}</td>`);

                            var result = to[j] - from[j];
                            var c = from[j];
                            for (var k = 1; k <= result; k++) {
                                $('.act_' + (c + k)).remove();
                                $('.eng_' + (c + k)).remove();
                            }

                        }

                        // --------------------------------------------------------
                        var m_from = [];
                        var m_to = [];
                        for (var l = 0; l < res.meal.length; l++) {
                            $(".meal_name").each(function (index) {
                                if (res.meal[l].from == $(this).data('time')) {
                                    m_from.push(index);
                                }
                                if (res.meal[l].to == $(this).data('time')) {
                                    m_to.push(index);
                                }
                            });
                        }

                        for (var h = 0; h < m_from.length; h++) {
                            $('.meal_' + m_from[h]).attr('style', `height: ${50 * (m_to[h] - m_from[h] + 1)}px !important`);
                            $('.meal_' + m_from[h]).find('.red').html(res.meal[h].get_meals.name);
                            $('.meal_' + m_from[h]).find('.edit_m').html(`<i class="fas fa-edit" aria-hidden="true" data-activity-id="${res.meal[h].id}"></i>`)

                            $('.int_' + m_from[h]).attr('style', `height: ${50 * (m_to[h] - m_from[h] + 1)}px !important`)
                            $('.int_' + m_from[h]).html(` <td class="intake_fat_g">${res.meal[h].get_meals.fat}</td>
                                                        <td class="intake_fat_d">${parseFloat(res.meal[h].get_meals.fat) / 4}</td>
                                                        <td class="intake_carb_g">${res.meal[h].get_meals.carbs}</td>
                                                        <td class="intake_carb_d"></td>
                                                        <td class="intake_protein_g">${res.meal[h].get_meals.proteins}</td>
                                                        <td class="intake_protein_d">${parseFloat(res.meal[h].get_meals.proteins) / 4}</td>`);

                            var m_result = m_to[h] - m_from[h];
                            var m = m_from[h];
                            for (var n = 1; n <= m_result; n++) {
                                $('.meal_' + (m + n)).remove();
                                $('.int_' + (m + n)).remove();
                            }

                        }

                        // --------------------------------------------------------
                        var p_met = 0;
                        for (var z = 0; z < res.meal.length; z++){
                            p_met += parseFloat(res.meal[z].get_meals.proteins)
                        }
                        $('.protein_eat').html(p_met);
                        $('.protein_must').html(res.protein_must_eat);
                    }
                });
            }
        })
    </script>

    <script !src="">
        $(document).ready(function () {
            let foods = '<?php echo $foods ?>';
            foods = JSON.parse(foods);
            let row = 0;
            add();

            function add() {
                let food = '';
                for (var i = 0; i < foods.length; i++) {
                    food += `<option value="${foods[i].id}"
                             data-carbs="${foods[i].carbs}"
                             data-fat="${foods[i].fat}"
                             data-proteins="${foods[i].proteins}"
                             data-calories="${foods[i].calories}"
                             data-fiber="${foods[i].fiber}"
                             data-glycemic_index="${foods[i].glycemic_index}"
                             data-glycemic_load="${foods[i].glycemic_load}"
                             data-ph="${foods[i].ph}"
                             data-quantity_measure="${foods[i].quantity_measure}"
                            >${foods[i].name}</option>`
                }

                let btn = `<button type="button" class="btn btn-danger col-md-12 m-b-20 minus" data-row="${row}"><i class="fa fa-minus"></i></button>`
                let element = `
                                <div class="form-group col-md-3 row_${row} food_items">
                                    <label for="name">Food</label>
                                    <select name="food[]" id="food_sel" class="form-control m-b-20">
                                        ${food}
                                    </select>
                                    <input type="number" name="mass[]" id="mass" class="form-control m-b-20" placeholder="Mass" required>
                                    ${btn}
                                </div>`

                $('.foods').prepend(element);
                row++;
            }

            $(document).on('click', '.plus', function () {
                add();
                row++;
            });

            $(document).on('click', '.minus', function () {
                let food_row = $(this).data('row');
                $('.row_' + food_row).remove();
                row--;
                calculate();
            });

            $(document).find(".food_items").each(function () {
                $(document).on('change', '#food_sel', function () {
                    calculate();
                });
                $(document).on('input', '#mass', function () {
                    calculate();
                });
            });

            function calculate() {
                let total_mass = 0;
                let total_carbs = 0;
                let total_fat = 0;
                let total_proteins = 0;
                let total_calories = 0;
                let total_ph = 0;
                let total_glycemic_load = 0;
                let food_mass = 0;

                // other variable
                var ph_sum = 0;
                var ph_d = 0;
                var gl_sum = 0;
                var gl_d = 0;


                $(document).find(".food_items").each(function () {

                    let mass = parseFloat($(this).find("#mass").val());
                    food_mass = parseFloat($(this).find("#food_sel").find(":selected").data('quantity_measure'));

                    total_mass += parseFloat($(this).find("#mass").val());
                    total_carbs += parseFloat($(this).find("#food_sel").find(":selected").data('carbs')) / food_mass * mass;
                    total_fat += parseFloat($(this).find("#food_sel").find(":selected").data('fat')) / food_mass * mass;
                    total_proteins += parseFloat($(this).find("#food_sel").find(":selected").data('proteins')) / food_mass * mass;
                    total_calories += parseFloat($(this).find("#food_sel").find(":selected").data('calories')) / food_mass * mass;

                    let nums = $('.food_items').length;

                    // ph calculate Average (Sum of (Food Item Mass * PH) / total Mass)
                    let ph = Number($(this).find("#food_sel").find(":selected").data('ph'));
                    ph_sum += parseFloat(mass * ph);
                    ph_d += ph_sum / total_mass;
                    total_ph = parseFloat(ph_d / nums).toFixed(2);

                    // total_glycemic_load calculate Average (Sum of (Food Item Mass * Glycemic Load) / total Mass)
                    let gl = parseFloat($(this).find("#food_sel").find(":selected").data('glycemic_load'));
                    gl_sum += parseFloat(mass * gl);
                    gl_d += gl_sum / total_mass;
                    total_glycemic_load = parseFloat(gl_d / nums).toFixed(2);

                    $('#total_mass').val(total_mass);
                    $('#total_carbs').val(total_carbs);
                    $('#total_fat').val(total_fat);
                    $('#total_proteins').val(total_proteins);
                    $('#total_calories').val(total_calories);
                    $('#total_ph').val(total_ph);
                    $('#total_glycemic_load').val(total_glycemic_load);
                });
            }

            $('.create-meal').click(function () {
                var form = $('.create_meal_form');

                $.ajax({
                    type: "POST",
                    url: "/day/create-meals",
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    },
                    data: form.serialize(),
                    success: function (data) {
                        $('.errors').empty()
                        $('.success').empty()
                        $('.success').append(`<span>${data.msg}</span>`)
                        setTimeout(function () {
                            $('.success').empty();
                        }, 5000);

                        $("input[name='name']").val('');
                        $("input[name='total_mass']").val('');
                        $("input[name='total_carbs']").val('');
                        $("input[name='total_fat']").val('');
                        $("input[name='total_proteins']").val('');
                        $("input[name='total_calories']").val('');
                        $("input[name='total_ph']").val('');
                        $("input[name='total_glycemic_load']").val('');

                        $('.foods').empty()
                        $('.foods').append(`<button type="button" class="btn btn-success col-md-2 m-b-20 plus"
                                                    style=" height: 200px;width: 200px;">
                                                <i class="fa fa-plus" style="font-size: 100px;"></i></button>`)
                        $('#meal_list').append(`<option value="${data.meal.id}"
                                                    data-carbs="${data.meal.carbs}"
                                                    data-fat="${data.meal.fat}"
                                                    data-proteins="${data.meal.proteins}"
                                                    data-calories="${data.meal.calories}"
                                                    data-fiber="${data.meal.fiber}"
                                                    data-glycemic_index="${data.meal.glycemic_index}"
                                                    data-glycemic_load="${data.meal.glycemic_load}"
                                                    data-ph="${data.meal.ph}"
                                                    data-quantity_measure="${data.meal.quantity_measure}">
                                                            ${data.meal.name}
                                                    </option>`)
                    },
                    error: function (reject) {
                        $('.errors').empty()
                        $('.success').empty()
                        if (reject.status === 422) {
                            var err = $.parseJSON(reject.responseText);
                            $.each(err.errors, function (key, val) {
                                $('.errors').append(`<li>${val[0]}</li>`)
                            });
                        }
                        setTimeout(function () {
                            $('.errors').empty();
                        }, 10000);
                    }
                });

            })

        })
    </script>

    <script !src="">
        $(document).ready(function () {
            let foods = '<?php echo $foods ?>';
            foods = JSON.parse(foods);
            let row = 0;

            $('#meal_list').change(function () {
                var id = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "/day/get-meal-ajax",
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    },
                    data: {id},
                    success: function (data) {
                        $('#m_total_mass').val(data.mass);
                        $('#m_total_carbs').val(data.carbs);
                        $('#m_total_fat').val(data.fat);
                        $('#m_total_proteins').val(data.proteins);
                        $('#m_total_calories').val(data.calories);
                        $('#m_total_ph').val(data.ph);
                        $('#m_total_glycemic_load').val(data.glycemic_load);

                        var m_pl = ` <button type="button" class="btn btn-success col-md-2 m-b-20 m_plus"
                                                    style=" height: 200px;width: 200px;">
                                                <i class="fa fa-plus" style="font-size: 100px;"></i></button>`
                        $('.m_foods').empty();
                        $('.m_foods').append(m_pl);

                        for (var i = 0; i < data.attached_foods.length; i++) {
                            var opt = "";
                            for (var j = 0; j < foods.length; j++) {
                                var sel = "";
                                if (foods[j].id == data.attached_foods[i].food_id) {
                                    sel = "selected"
                                }

                                opt += `<option value="${foods[j].id}"
                                                    data-carbs="${foods[j].carbs}"
                                                    data-fat="${foods[j].fat}"
                                                    data-proteins="${foods[j].proteins}"
                                                    data-calories="${foods[j].calories}"
                                                    data-fiber="${foods[j].fiber}"
                                                    data-glycemic_index="${foods[j].glycemic_index}"
                                                    data-glycemic_load="${foods[j].glycemic_load}"
                                                    data-ph="${foods[j].ph}"
                                                    data-quantity_measure="${foods[j].quantity_measure}" ${sel}>
                                                            ${foods[j].name}
                                                    </option>`
                            }

                            var elem = `<div class="form-group row_${i} m_food_items col-md-3">
                                                <select name="food[]" class="form-control m-b-20 m_food_sel">
                                                    ${opt}
                                                </select>
                                                <input type="number" name="mass[]" class="m_mass form-control m-b-20" placeholder="Mass" value="${data.attached_foods[i].mass}" required>
                                                <button type="button" class="btn btn-danger col-md-12 m-b-20 m_minus" data-row="${i}"><i class="fa fa-minus"></i></button>
                                            </div>`
                            $('.m_foods').prepend(elem);
                            row++;
                        }
                    }
                })
            });

            function m_add() {
                let food = '';
                for (var i = 0; i < foods.length; i++) {
                    food += `<option
                            value="${foods[i].id}"
                            data-carbs = "${foods[i].carbs}"
                            data-fat="${foods[i].fat}"
                            data-proteins="${foods[i].proteins}"
                            data-calories="${foods[i].calories}"
                            data-fiber="${foods[i].fiber}"
                            data-glycemic_index="${foods[i].glycemic_index}"
                            data-glycemic_load="${foods[i].glycemic_load}"
                            data-ph="${foods[i].ph}"
                            data-quantity_measure="${foods[i].quantity_measure}"
                                >${foods[i].name} </option>`
                }

                let btn = `<button type="button" class="btn btn-danger col-md-12 m-b-20 m_minus" data-row="${row}"><i class="fa fa-minus"></i></button>`
                let element = `
                                <div class="form-group row_${row} m_food_items col-md-3">
                                    <select name="food[]" class="form-control m-b-20 m_food_sel">
                                        ${food}
                                    </select>
                                    <input type="number" name="mass[]" class="form-control m-b-20 m_mass" placeholder="Mass" required>
                                    ${btn}
                                </div>`;

                $('.m_foods').prepend(element);
                row++;
            }

            $(document).on('click', '.m_plus', function () {
                m_add();
                row++;
            });

            $(document).on('click', '.m_minus', function () {
                let food_row = $(this).data('row');
                $('.row_' + food_row).remove();
                row--;
                console.log(row)
                m_calculate();
            });

            $(document).find(".food_items").each(function () {
                $(document).on('change', '.m_food_sel', function () {
                    m_calculate();
                });
                $(document).on('input', '.m_mass', function () {
                    m_calculate();
                });
            });

            function m_calculate() {
                let total_mass = 0;
                let total_carbs = 0;
                let total_fat = 0;
                let total_proteins = 0;
                let total_calories = 0;
                let total_ph = 0;
                let total_glycemic_load = 0;
                let food_mass = 0;

                // other variable
                var ph_sum = 0;
                var ph_d = 0;
                var gl_sum = 0;
                var gl_d = 0;


                $(document).find(".m_food_items").each(function () {

                    let mass = parseFloat($(this).find(".m_mass").val());
                    food_mass = parseFloat($(this).find(".m_food_sel").find(":selected").data('quantity_measure'));

                    total_mass += parseFloat($(this).find(".m_mass").val());
                    total_carbs += parseFloat($(this).find(".m_food_sel").find(":selected").data('carbs')) / food_mass * mass;
                    total_fat += parseFloat($(this).find(".m_food_sel").find(":selected").data('fat')) / food_mass * mass;
                    total_proteins += parseFloat($(this).find(".m_food_sel").find(":selected").data('proteins')) / food_mass * mass;
                    total_calories += parseFloat($(this).find(".m_food_sel").find(":selected").data('calories')) / food_mass * mass;

                    let nums = $('.food_items').length;

                    // ph calculate Average (Sum of (Food Item Mass * PH) / total Mass)
                    let ph = Number($(this).find(".m_food_sel").find(":selected").data('ph'));
                    ph_sum += parseFloat(mass * ph);
                    ph_d += ph_sum / total_mass;
                    total_ph = parseFloat(ph_d / nums).toFixed(2);

                    // total_glycemic_load calculate Average (Sum of (Food Item Mass * Glycemic Load) / total Mass)
                    let gl = parseFloat($(this).find(".m_food_sel").find(":selected").data('glycemic_load'));
                    gl_sum += parseFloat(mass * gl);
                    gl_d += gl_sum / total_mass;
                    total_glycemic_load = parseFloat(gl_d / nums).toFixed(2);

                    $('#m_total_mass').val(total_mass);
                    $('#m_total_carbs').val(total_carbs);
                    $('#m_total_fat').val(total_fat);
                    $('#m_total_proteins').val(total_proteins);
                    $('#m_total_calories').val(total_calories);
                    $('#m_total_ph').val(total_ph);
                    $('#m_total_glycemic_load').val(total_glycemic_load);
                });
            }

        })
    </script>
@endpush

@push('header')
    <link href="{{asset('assets/plugins/clockpicker/dist/jquery-clockpicker.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/plugins/datepicker-new/css/bootstrap-datepicker.css')}}" rel="stylesheet">

    <style>
        .clockpicker-popover {
            z-index: 99999;
        }

        .table-condensed tr, .table-condensed td {
            height: auto !important;
        }

        table tr, table th {
            height: 50px !important;
            padding: 10px 8px !important;
        }

        .firs-table.table-striped tbody tr:nth-of-type(odd) {
            background-color: #a3c5a0;
        }

        .firs-table.table-striped tbody tr {
            background-color: #89bb83;
            color: #fff;
        }

        .table thead th {
            border-bottom: none !important;
        }

        .table td, .table th {
            border-top: none;
        }

        .medium-table.table-striped tbody tr:nth-of-type(odd) {
            background-color: #EEEFF1;
        }

        .medium-table.table-striped tbody tr {
            background-color: #E6E7E9;
        }

        .last-table.table-striped tbody tr:nth-of-type(odd) {
            background-color: #F6F6F6;
        }

        .last-table.table-striped tbody tr {
            background-color: #FAFAFA;
        }

        .energy-table.table-striped tbody tr:nth-of-type(odd) td:nth-child(1) {
            background-color: #F6F6F7;
        }

        .energy-table.table-striped tbody tr:nth-of-type(even) td:nth-child(1) {
            background-color: #FBF9F9;
        }

        .energy-table.table-striped tbody tr:nth-of-type(odd) td:nth-child(2) {
            background-color: #F6F4E8;
        }

        .energy-table.table-striped tbody tr:nth-of-type(even) td:nth-child(2) {
            background-color: #FAF8EC;
        }

        .energy-table.table-striped tbody tr:nth-of-type(odd) td:nth-child(3) {
            background-color: #F6F4E8;
        }

        .energy-table.table-striped tbody tr:nth-of-type(even) td:nth-child(3) {
            background-color: #FAF8EC;
        }

        .energy-table.table-striped tbody tr:nth-of-type(odd) td:nth-child(4) {
            background-color: #F6F4E8;
        }

        .energy-table.table-striped tbody tr:nth-of-type(even) td:nth-child(4) {
            background-color: #FAF8EC;
        }

        .energy-table.table-striped tbody tr:nth-of-type(odd) td:nth-child(5) {
            background-color: #F1ECF3;
        }

        .energy-table.table-striped tbody tr:nth-of-type(even) td:nth-child(5) {
            background-color: #F5EEF6;
        }

        .energy-table.table-striped tbody tr:nth-of-type(odd) td:nth-child(6) {
            background-color: #F1ECF3;
        }

        .energy-table.table-striped tbody tr:nth-of-type(even) td:nth-child(6) {
            background-color: #F5EEF6;
        }

        .energy-table.table-striped tbody tr:nth-of-type(odd) td:nth-child(7) {
            background-color: #F1ECF3;
        }

        .energy-table.table-striped tbody tr:nth-of-type(even) td:nth-child(7) {
            background-color: #F5EEF6;
        }

        .intake-table.table-striped tbody tr:nth-of-type(odd) td:nth-child(1) {
            background-color: #F6F4E8;
        }

        .intake-table.table-striped tbody tr:nth-of-type(even) td:nth-child(1) {
            background-color: #F8F8EC;
        }

        .intake-table.table-striped tbody tr:nth-of-type(odd) td:nth-child(2) {
            background-color: #F6F4E8;
        }

        .intake-table.table-striped tbody tr:nth-of-type(even) td:nth-child(2) {
            background-color: #F8F8EC;
        }

        .intake-table.table-striped tbody tr:nth-of-type(odd) td:nth-child(3) {
            background-color: #F1ECF3;
        }

        .intake-table.table-striped tbody tr:nth-of-type(even) td:nth-child(3) {
            background-color: #F5EEF6;
        }

        .intake-table.table-striped tbody tr:nth-of-type(odd) td:nth-child(4) {
            background-color: #F1ECF3;
        }

        .intake-table.table-striped tbody tr:nth-of-type(even) td:nth-child(4) {
            background-color: #F5EEF6;
        }

        .intake-table.table-striped tbody tr:nth-of-type(odd) td:nth-child(5) {
            background-color: #F7E9E9;
        }

        .intake-table.table-striped tbody tr:nth-of-type(even) td:nth-child(5) {
            background-color: #FBEDED;
        }

        .intake-table.table-striped tbody tr:nth-of-type(odd) td:nth-child(6) {
            background-color: #F7E9E9;
        }

        .intake-table.table-striped tbody tr:nth-of-type(even) td:nth-child(6) {
            background-color: #FBEDED;
        }

        .day-parent {
            background: #F6F6F6;
            padding: 5px 10px;
            border-radius: 6px;
        }

        .border-green {
            border: 1px solid #DFEBDF;
        }

        .green {
            color: #639D5D;
        }

        .red {
            color: #B89482;
        }

        .add-btn {
            background: none;
            border: none;
        }

        .bg-white {
            background-color: #fff;
        }

        .font-medium {
            font-size: 13px;
        }

        .back-arrow {
            border-radius: 50%;
            border: 2px solid #212529;
            width: 25px;
            height: 25px;
            display: flex;
            justify-content: center;
            align-items: center;
            position: absolute;
            right: 12px;
            top: 11px;
        }

        .table-parent {
            display: flex;
        }

        .table-parent .col-small {
            flex: 1;
            max-width: 90px;
            min-width: 90px;
        }

        .table-parent .col-medium {
            flex: 2;
            min-width: 160px;
        }

        .table-parent .col-medium-two {
            flex: 3;
            min-width: 240px;
        }

        .table-parent .col-big {
            flex: 5;
        }

        .expended-mode-on {
            flex: 3 !important;
        }

        /*# sourceMappingURL=style.css.map */
    </style>
@endpush



