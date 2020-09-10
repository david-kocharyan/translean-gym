@extends('layouts.app')

{{--html in here--}}
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
            <!-- ################# -->
            <!-- ################# -->
            <!-- ################# -->
            <div class="table-parent" id="_days">

            <!-- 1 -->
            <div class="col-small mr-2 ml-2">
                <table class="firs-table table table-striped">
                    <thead>
                        <tr>
                            <th colspan="1">&nbsp;</th>
                        </tr>
                        <tr>
                            <th colspan="1">
                                <a href="javascript:void(0)" @click.prevent="closeALl">Close</a>
                            </th>
                        </tr>
                    </thead>
                    <tbody v-for="(time, i) in staticTimes" :key="time.id">
                        <tr 
                            v-for="(minute, j) in time.minutes" :key="minute.minute"
                            v-if="minute.show"
                            :class="[minute.font]"
                            :style="{ borderColor: minute.color }"
                            @click="toggleTimes(i, j)"
                        >
                            <th> @{{ minute.minute }} </th>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- 2 -->
            <div class="col-medium mr-2">
                <table class="medium-table table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody class="font-sm">
                        <tr>
                            <th class="d-flex justify-content-between align-items-center">
                                Activity 
                                <!-- <div class="green">
                                    <i class="fas fa-plus-circle"></i>
                                </div> -->
                                <button class="add-btn green" data-toggle="modal" data-target="#activity">
                                    <i class="fas fa-plus-circle"></i>
                                </button>
                            </th>
                        </tr>
                        <tr v-for="(activity, j) in finalActivityArray" :key="j">
                            <td 
                                v-for="(activity_info, j) in activity.arr" :key="j" 
                                class="activity-td d-flex justify-content-between align-items-center"

                                :class="{ 'activity-color text-success' : j == 0 }"
                                v-if="activity_info.show" 
                            >

                            <div v-if="!activity_info.open && j == 0"
                                v-for="(activity_infojj, g) in activity.arr" :key="g" >
                                    @{{ activity_infojj.name }} 
                            </div>

                            <div v-if="activity_info.open">
                                <span>
                                    @{{ activity_info.name }}
                                </span>
                            </div>

                            <div  v-if="activity_info.head && activity_info.open">
                                <i class="fas fa-edit"></i>
                            </div>

                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- 3 -->
            <div class="col-big mr-2">
                <table class="energy-table table table-striped border-green">
                    <thead>
                        <tr>
                            <th colspan="7" class="text-center position-relative">
                                Energy Expenditure
                            </th>
                        </tr>
                        <tr>
                            <td>Total&nbsp;cal</td>
                            <td>Fat&nbsp;%</td>
                            <td>Fat&nbsp;(c)</td>
                            <td>Fat&nbsp;(g)</td>
                            <td>Carb&nbsp;%</td>
                            <td>Carb&nbsp;(c)</td>
                            <td>Carb&nbsp;(g)</td>
                        </tr>
                    </thead>
                    <tbody
                        v-for="(exp, k) in finalActivityArray" :key="k" 
                    >
                        <tr
                            v-for="(exp_info, l) in exp.arr" :key="l" 
                            v-if="exp_info.show"
                        >
                            <td> <span v-if="exp_info.full" class="green"> 10 </span> </td>
                            <td> <span v-if="exp_info.full" :class="{ 'text-dark font-weight-bold' : l == 0 }">20</span></td>
                            <td><span v-if="exp_info.full" :class="{ 'text-dark font-weight-bold' : l == 0 }">400</span></td>
                            <td><span v-if="exp_info.full" :class="{ 'text-dark font-weight-bold' : l == 0 }">800</span></td>
                            <td><span v-if="exp_info.full" :class="{ 'text-dark font-weight-bold' : l == 0 }">5000</span></td>
                            <td><span v-if="exp_info.full" :class="{ 'text-dark font-weight-bold' : l == 0 }">600</span></td>
                            <td><span v-if="exp_info.full" :class="{ 'text-dark font-weight-bold' : l == 0 }">480</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- 4 -->
            <div class="col-medium mr-2">
                <table class="medium-table table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="d-flex justify-content-between align-items-center">
                                Meal / Water
                                <button class="add-btn red" data-toggle="modal" data-target="#meal">
                                    <i class="fas fa-plus-circle"></i>
                                </button>
                            </th>
                        </tr>
                        <tr v-for="(meal, j) in finalMealArray" :key="j">
                            <td
                                v-for="(meal_info, b) in meal.arr" :key="b" 
                                class="activity-td d-flex justify-content-between align-items-center"
                                :class="{ 'activity-color text-success' : b == 0 }"
                                v-if="meal_info.show" 
                            >

                                <div>
                                    @{{ meal_info.name }}
                                </div>

                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- 5 -->
            <div class="col-big mr-2 ">
                <table class="intake-table border-green table table-striped">
                    <thead>
                        <tr>
                            <th colspan="6" class="text-center">Intake</th>
                        </tr>
                        <tr>
                            <td>Fat&nbsp;(g)</td>
                            <td>Fat&nbsp;Diges.</td>
                            <td>Carb&nbsp;(g)</td>
                            <td>Carb&nbsp;Dig.</td>
                            <td>Protein&nbsp;(g)</td>
                            <td>Protein&nbsp;Dig.</td>
                        </tr>
                    </thead>
                    <tbody
                        v-for="(exp, k) in finalMealArray" :key="k" 
                    >
                        <tr
                            v-for="(exp_info, l) in exp.arr" :key="l" 
                            v-if="exp_info.show"
                        >
                            <td> <span v-if="exp_info.full" class="green"> 10 </span> </td>
                            <td> <span v-if="exp_info.full" :class="{ 'text-dark font-weight-bold' : l == 0 }">20</span></td>
                            <td><span v-if="exp_info.full" :class="{ 'text-dark font-weight-bold' : l == 0 }">400</span></td>
                            <td><span v-if="exp_info.full" :class="{ 'text-dark font-weight-bold' : l == 0 }">800</span></td>
                            <td><span v-if="exp_info.full" :class="{ 'text-dark font-weight-bold' : l == 0 }">5000</span></td>
                            <td><span v-if="exp_info.full" :class="{ 'text-dark font-weight-bold' : l == 0 }">600</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- 6 -->
            <div class="col-medium-two">
                <table class="last-table table table-striped">
                    <thead>
                        <tr>
                            <th colspan="2" class="text-center red">Status</th>
                        </tr>
                        <tr class="bg-white">
                            <td class="text-center">Fat</td>
                            <td class="text-center">Carb</td>
                        </tr>
                    </thead>
                    <tbody
                        v-for="(exp, k) in finalActivityArray" :key="k" 
                    >
                        <tr
                            v-for="(exp_info, l) in exp.arr" :key="l" 
                            v-if="exp_info.show"
                        >
                            <td> <span v-if="exp_info.full"> 10   <span class="green">(loss)</span> </span> </td>
                            <td> <span v-if="exp_info.full">20  <span class="red">(access)</span></span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            </div>
            <!-- ################# -->
            <!-- ################# -->
            <!-- ################# -->
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

{{--script in here --}}
@push("footer")
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="{{asset('assets/plugins/clockpicker/dist/jquery-clockpicker.js')}}"></script>
    <script src="{{asset('assets/plugins/datepicker-new/js/bootstrap-datepicker.js')}}"></script>

    <script !src="">
        $(document).ready(function () {

            show_date();
            getActivities();

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
            }

            function getActivities() {
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
                        console.log('activities : ', res)
                        
                        let activities = res.activity
                        for(let i=0; i<activities.length; i++) {
                            let activityObj = {
                                name: activities[i].get_activity.name,
                                start: activities[i].from,
                                end: activities[i].to
                            }
                            days.addActivity(activityObj)
                        }
                        let meals = res.meal
                        for(let i=0; i<meals.length; i++) {
                            let activityObj = {
                                name: meals[i].get_meals.name,
                                start: meals[i].from,
                                end: meals[i].to
                            }
                            days.addMeals(activityObj)
                        }
                    }
                })
            }

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
                        $('#meal').modal('toggle');

                        let activityObj = {
                            name: $('#meal_list').find(":selected").text(),
                            start: $('.meal_from').val(),
                            end: $('.meal_to').val()
                        }

                        console.log(activityObj)

                        days.closeALl()
                        days.addMeals(activityObj)

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


            $('.activity_save').click(function () {
                $('.error_modal_activity').empty();

                let data = {
                    activity: $('#activity_list').find(":selected").val(),
                    from: $('.activity_from').val(),
                    to: $('.activity_to').val(),
                    date: $('.date-show').html(),
                    id: $('.user_id').val(),
                };

                let activityObj = {
                    name: $('#activity_list').find(":selected").text(),
                    start: $('.activity_from').val(),
                    end: $('.activity_to').val()
                }

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
                        // let date = $('.date-show').html()

                        // console.log(res)
                        // console.log(date)

                        days.closeALl()
                        days.addActivity(activityObj)

                        setTimeout(() => {
                            console.log(days.$data.activities)
                        }, 1000);

                    }
                });
            });
        });
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


<script defer>
    let days = new Vue({
        el: '#_days',
        data() {
            let self = this; 
            return {
                staticTimes: [],
                activities: [],
                meal: [],
                finalActivityArray: [],
                finalMealArray: [],
            }
        },
        methods: {
            returnRandomColor() {
                return "#" + ((1<<24) * Math.random()|0).toString(16)
            },
            closeALl() {
                let times = this.staticTimes
                for(let i=0; i<times.length; i++) {
                    for(let k=0; k < times[i].minutes.length; k++) {
                        if(k != 0) {
                            times[i].minutes[k].show = false
                        }
                    }
                }

                let activities = this.finalActivityArray
                for(let j=0; j<activities.length; j++) {
                    for(let k=0; k < activities[j].arr.length; k++) {
                        if(k != 0) {
                            activities[j].arr[k].show = false
                        }
                    }
                }
            },
            toggleTimes(i, j) {
                if(j == 0) {
                    let minutes = this.staticTimes[i].minutes
                    for(let k=0; k < minutes.length; k++) {
                        if(k != 0) {
                            minutes[k].show ? minutes[k].show = false : minutes[k].show = true
                        }
                    }

                    let = activities = this.finalActivityArray[i].arr
                    activities[0].open ? activities[0].open = false : activities[0].open = true

                    for(let l=0; l < activities.length; l++) {
                        if(l != 0) {
                            activities[l].show ? activities[l].show = false : activities[l].show = true
                        }
                    }

                    let = meals = this.finalMealArray[i].arr
                    meals[0].open ? meals[0].open = false : meals[0].open = true

                    for(let l=0; l < meals.length; l++) {
                        if(l != 0) {
                            meals[l].show ? meals[l].show = false : meals[l].show = true
                        }
                    }


                }
            },
            createTimeGraphic() {
                let timeArr = []
                for(let i=8; i<=20; i++) {
                    let timeObj = { 
                        id: i,
                        time: i,
                        minutes: []
                    }
                    for(let j=0; j<6; j++) {
                        let m = i + ':' + j + '0'
                        let fm = i < 10 ? '0' + m : m
                        let minObj = {
                            minute: fm,
                            show: j == 0 ? true : false,
                            font: j == 0 ? 'font-big' : 'font-sm'
                        }
                        timeObj.minutes.push(minObj)
                    }
                    timeArr.push(timeObj)
                }
                console.log('TIME ARRAY : ', timeArr)
                this.staticTimes = timeArr
            },
            activity() {

                let activitiesFinalArray = []
                let staicTimes = this.staticTimes
                let activities = this.activities
                let end = null
                let color = this.returnRandomColor()
            

                for(let i=0; i<staicTimes.length; i++) {

                    activitiesFinalArray.push(    { arr: [] }     )
                    let minutes = staicTimes[i].minutes
                    

                    for(let j=0; j<minutes.length; j++) {
                        let minute = staicTimes[i].minutes[j].minute
                        
                        for(let t=0; t<activities.length; t++) {

                            let activityObj = { 
                                time: minute,
                                show: j == 0 ? true : false,
                            }
                            
                            if(activities[t].start == minute) {

                                activityObj.start = minute  
                                activityObj.end = activities[t].end
                                activityObj.name = activities[t].name
                                activityObj.full = true
                                activityObj.head = true

                                end = activities[t].end

                                this.staticTimes[i].minutes[j].color = color
                                // color = this.returnRandomColor()

                                activitiesFinalArray[i].arr = activitiesFinalArray[i].arr.filter(ac => ac.time !== minute)
                                activitiesFinalArray[i].arr.push(activityObj)

                            }
                            else {
                                if(end != null) {
                                    if(activityObj.time == end ) {
                                        activityObj.full = true
                                        this.staticTimes[i].minutes[j].color = color
                                        end = null
                                        color = this.returnRandomColor()
                                    } else {
                                        activityObj.full = true
                                        this.staticTimes[i].minutes[j].color = color
                                    }
                                    
                                }
                            
                                let index = activitiesFinalArray[i].arr
                                    .findIndex(activity => activity.time === minute)
                            
                                if(index === -1) {
                                    activitiesFinalArray[i].arr.push(activityObj)
                                }
                            }
                        }
                    }
                }
                this.finalActivityArray = activitiesFinalArray
                // console.log(this.finalActivityArray)
            },
            meals() {
                let mealFinalArray = []
                let staicTimes = this.staticTimes
                let meals = this.meal
                let end = null
                let color = this.returnRandomColor()
            

                for(let i=0; i<staicTimes.length; i++) {

                    mealFinalArray.push(    { arr: [] }     )
                    let minutes = staicTimes[i].minutes
                    

                    for(let j=0; j<minutes.length; j++) {
                        let minute = staicTimes[i].minutes[j].minute
                        
                        for(let t=0; t<meals.length; t++) {

                            let activityObj = { 
                                time: minute,
                                show: j == 0 ? true : false,
                            }
                            
                            if(meals[t].start == minute) {

                                activityObj.start = minute  
                                activityObj.end = meals[t].end
                                activityObj.name = meals[t].name
                                activityObj.full = true
                                activityObj.head = true

                                end = meals[t].end

                                this.staticTimes[i].minutes[j].color = color
                                // color = this.returnRandomColor()

                                mealFinalArray[i].arr = mealFinalArray[i].arr.filter(ac => ac.time !== minute)
                                mealFinalArray[i].arr.push(activityObj)

                            }
                            else {
                                if(end != null) {
                                    if(activityObj.time == end ) {
                                        activityObj.full = true
                                        this.staticTimes[i].minutes[j].color = color
                                        end = null
                                        color = this.returnRandomColor()
                                    } else {
                                        activityObj.full = true
                                        this.staticTimes[i].minutes[j].color = color
                                    }
                                    
                                }
                            
                                let index = mealFinalArray[i].arr
                                    .findIndex(activity => activity.time === minute)
                            
                                if(index === -1) {
                                    mealFinalArray[i].arr.push(activityObj)
                                }
                            }
                        }
                    }
                }
                this.finalMealArray = mealFinalArray
            },
            addActivity(activityObj){
                this.activities.push(activityObj)
                this.activity();
            },
            addMeals(activityObj){
                this.meal.push(activityObj)
                this.meals();
                setTimeout(() => {
                    console.log('Meal final array : ', this.finalMealArray)
                }, 2000);
            }
        },
        mounted() {
            this.createTimeGraphic();
            setTimeout(()=>{
                this.activity();
                console.log('STATIC TIMES : ', this.staticTimes)
            }, 1000)
        }
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

{{--style in here--}}
@push("header")
<link href="{{asset('assets/plugins/clockpicker/dist/jquery-clockpicker.min.css')}}" rel="stylesheet">
<link href="{{asset('assets/plugins/datepicker-new/css/bootstrap-datepicker.css')}}" rel="stylesheet">    
<style>
    .clockpicker-popover {
        z-index: 99999;
    }
</style>
@endpush
