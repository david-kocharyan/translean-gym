@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="white-box" style="overflow-y: auto;">
                <input type="hidden" class="user_id" name="id" value="{{$user->id}}">

                <div class="container m-t-10 m-b-20" >
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
                                    <span class="input-group-addon" style="background: none; border: none; cursor: pointer;">
                                        <i class="glyphicon glyphicon-th"></i>
                                    </span>
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
                            <input type="text" class="clockpicker activity_from form-control">
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

    <div id="meal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Meals</h4>
                </div>
                <div class="modal-body">
                    <h3 class="text-danger m-t-20 m-b-20 error_modal_meal"></h3>
                    <div class="form-group">
                        <label for="activity_list">Choose Meal</label>
                        <select name="activity" id="meal_list" class="meal_list form-control">
                            @foreach($meals as $key => $val)
                                <option value="{{$val->id}}">{{$val->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="meal_from">From</label>
                            <input type="text" class="clockpicker meal_from form-control">
                        </div>

                        <div class="form-group">
                            <label for="meal_to">To</label>
                            <input type="text" class="clockpicker meal_to form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success meal_save">Save</button>
                </div>
            </div>

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
            });
            $('.activity_to').clockpicker({
                autoclose: true,
            });

            $('.meal_from').clockpicker({
                autoclose: true,
            });
            $('.meal_to').clockpicker({
                autoclose: true,
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
                } else if(dateString != null) {
                    date = new Date(dateString);
                    date.setDate(date.getDate());
                }else{
                    date = new Date();
                    date.setDate(date.getDate());
                }

                let day = ("0" + date.getDate()).slice(-2);
                let month = ("0" + (date.getMonth() + 1)).slice(-2);
                let dateShow = date.getFullYear() + "-" + (month) + "-" + (day);

                $('.date-show').html(dateShow);
                fill_table();
            }

            $('.date').datepicker({ autoclose: true, format: 'yyyy-mm-dd'}).on('changeDate', function(e) {
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

            $('.meal_save').click(function () {
                $('.error_modal_meal').empty();

                let data = {
                    meal: $('#meal_list').find(":selected").val(),
                    from: $('.meal_from').val(),
                    to: $('.meal_to').val(),
                    date: $('.date-show').html(),
                    id: $('.user_id').val(),
                };

                for (let i in data) {
                    if (data[i] === '' || data[i] === null) {
                        $('.error_modal_meal').html('Please Fill All Inputs!')
                        return;
                    }
                }

                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    },
                    url: '{{ url('/day/add-meals') }}',
                    data: data,
                    success: function (res) {
                        $('#meal').modal('toggle');
                        let date = $('.date-show').html()
                        show_date(0, date);
                    }
                });

            });

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
                                                        <td class="intake_fat_d">${res.meal[h].get_meals.fat}</td>
                                                        <td class="intake_carb_g">${res.meal[h].get_meals.carbs}</td>
                                                        <td class="intake_carb_d">${res.meal[h].get_meals.carbs}</td>
                                                        <td class="intake_protein_g">${res.meal[h].get_meals.proteins}</td>
                                                        <td class="intake_protein_d">${res.meal[h].get_meals.proteins}</td>`);

                            var m_result = m_to[h] - m_from[h];
                            var m = m_from[h];
                            for (var n = 1; n <= m_result; n++) {
                                $('.meal_' + (m + n)).remove();
                                $('.int_' + (m + n)).remove();
                            }

                        }

                        // --------------------------------------------------------

                    }
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

        /*# sourceMappingURL=style.css.map */
    </style>
@endpush



