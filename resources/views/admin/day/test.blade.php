@extends('layouts.app')

{{--html in here--}}
@section('content')
    @include('admin.users.tab')

<div class="row"  id="_days">

    <div class="col-md-12 text-center" id="assassmentAlert"></div>

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
                        <div>
                            <button
                                class="mode-switcher-button"
                                data-toggle="modal"
                                data-target="">
                                <i class="fas fa-cloud-download-alt"></i>
                                <input type="hidden" class="form-control">
                            </button>
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
        <div class="table-parent">

        <!-- 1 -->
        <div class="col-small mr-2 ml-2">
            <table class="firs-table table table-striped">
                <thead>
                    <tr>
                        <th colspan="1">&nbsp;</th>
                    </tr>
                    <tr>
                        <th colspan="1">
                            <a href="javascript:void(0)" @click.prevent="closeAll">Close</a>
                        </th>
                    </tr>
                </thead>

                <tbody v-for="(time, i) in staticTimes" :key="time.time">
                    <tr>
                        <th class="parent-time"
                            @click="toggleTimes(i)"
                        >
                            @{{ time.time }}
                            <div v-if="time.circle" class="red-circle"></div>
                        </th>
                    </tr>
                    <tr v-for="(minute, j) in time.minutes" :key="j"
                        :style="{ borderColor: minute.borderColor }"
                        v-if="minute.show"
                    >
                        <th
                            class="child-time"
                        >
                            @{{ minute.minute  }}
                        </th>
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
                    <tr>
                        <th class="d-flex justify-content-between align-items-center">
                            Activity
                            <button class="add-btn green" data-toggle="modal" data-target="#activity">
                                <i class="fas fa-plus-circle"></i>
                            </button>
                        </th>
                    </tr>
                </thead>
                <tbody class="font-sm">
                    <tr v-for="(activity, i) in staticTimes" :key="activity.time">

                        <td class="d-flex align-items-center activity-color"
                        @click="toggleTimes(i)" >
                            <span
                                v-for="info in activity.activityPopover"
                                class="mr-2 tooltipp"
                            >
                                @{{ info.name }}
                                <span class="tooltiptext">
                                    <div>
                                        <h3>@{{ info.name }}</h3>
                                        Start: @{{ info.start }} <br>
                                        End: @{{ info.end }} <br>
                                        <h5>Total: @{{ info.total }}</h5>
                                    </div>
                                </span>
                            </span>
                        </td>

                        <td
                            v-for="(activity_info, j) in activity.minutes"
                            :key="activity_info.minute"
                            class="d-flex justify-content-between align-items-center"
                            v-if="activity_info.show"
                        >
                            <div v-if="activity_info.name"
                                 class="w-100 green d-flex justify-content-between align-items-center"
                            >
                                <div class="tooltipp">
                                    @{{ activity_info.name }}
                                    <span class="tooltiptext">
                                        <div>
                                            <h3> @{{ activity_info.minuteActivityPopover.name }}</h3>
                                            Start: @{{ activity_info.minuteActivityPopover.start }} <br>
                                            End: @{{ activity_info.minuteActivityPopover.end }} <br>
                                            <h5>Total: @{{ activity_info.minuteActivityPopover.total }}</h5>
                                        </div>
                                    </span>
                                </div>
                                <div class="edit-activity"
                                    @click="openEditActionPopup(activity_info.minuteActivityPopover)"
                                    data-toggle="modal" data-target="#activity"> <i class="fas fa-edit"></i>
                                </div>
                            </div>
                        </td>

                    </tr>

                </tbody>
            </table>
        </div>

        <!-- 3 -->
        <div class="col-big mr-2" :class="{ 'expended-mode-on' : !energyExpendedMode}">
            <table class="energy-table table table-striped border-green">
                <thead>
                    <tr>
                        <th colspan="7" class="text-center position-relative">
                            Energy Expenditure
                            <button
                                class="mode-switcher-button mode-switcher-button-absolute"
                                @click="energyExpendedModeSwitcher">
                                <i class="fas fa-expand-alt"></i>
                            </button>
                        </th>
                    </tr>
                    <tr>
                        <td >Total&nbsp;cal</td>
                        <td v-if='energyExpendedMode'>Fat&nbsp;%</td>
                        <td v-if='energyExpendedMode'>Fat&nbsp;(c)</td>
                        <td>Fat&nbsp;(g)</td>
                        <td v-if='energyExpendedMode'>Carb&nbsp;%</td>
                        <td v-if='energyExpendedMode'>Carb&nbsp;(c)</td>
                        <td>Carb&nbsp;(g)</td>
                    </tr>
                </thead>
                <tbody v-for="(time, i) in staticTimes" :key="time.time">
                    <tr  @click="toggleTimes(i)" >
                        <td class="bg-dark-p"><b>@{{ time.totals.totalCal }}</b></td>
                        <td class="bg-dark-p" v-if='energyExpendedMode'></td>
                        <td class="bg-dark-p" v-if='energyExpendedMode'><b>@{{ time.totals.totalFatC }}</b></td>
                        <td class="bg-dark-p"><b>@{{ time.totals.totalFatG }}</b></td>
                        <td class="bg-dark-p" v-if='energyExpendedMode'></td>
                        <td class="bg-dark-p" v-if='energyExpendedMode'><b>@{{ time.totals.totalCarbC }}</b></td>
                        <td class="bg-dark-p"><b>@{{ time.totals.totalCarbG }}</b></td>
                    </tr>

                    <tr v-for="(minute, j) in time.minutes" :key="j"
                        v-if="minute.show"
                    >
                        <td><span class="green" v-if="minute.borderColor">@{{ minute.energyExpenditure.totalCal }}</span></td>
                        <td v-if='energyExpendedMode'><span v-if="minute.borderColor">@{{ minute.energyExpenditure.fatPercentage }}</span></td>
                        <td v-if='energyExpendedMode'><span class="green" v-if="minute.borderColor">@{{ minute.energyExpenditure.fatC }}</span></td>
                        <td><span v-if="minute.borderColor">@{{ minute.energyExpenditure.fatG }}</span></td>
                        <td v-if='energyExpendedMode'><span v-if="minute.borderColor">@{{ minute.energyExpenditure.carbPercentage }}</span></td>
                        <td v-if='energyExpendedMode'><span v-if="minute.borderColor">@{{ minute.energyExpenditure.carbC }}</span></td>
                        <td><span v-if="minute.borderColor">@{{ minute.energyExpenditure.carbG }}</span></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- 4 -->
        <div class="col-medium mr-2">
            <table class="medium-table table table-striped">
                <thead>
                    <tr>
                        <th colspan="1" class="position-relative text-right">
                            <span>&nbsp;</span>
                            <button
                                class="mode-switcher-button"
                                data-toggle="modal"
                                data-target="#clearAllMealPopup">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button
                                class="mode-switcher-button "
                                data-toggle="modal"
                                data-target="#duplicateMeal"
                            >
                                <i class="fas fa-clone"></i>
                            </button>
                        </th>
                    </tr>
                    <tr>
                        <th class="d-flex align-items-center">
                            Meal
                            <button class="add-btn red" data-toggle="modal" data-target="#meal">
                                <i class="fas fa-plus-circle"></i>
                            </button>
                            /
                            Water
                            <button class="add-btn red" data-toggle="modal" data-target="#water">
                                <i class="fas fa-plus-circle"></i>
                            </button>
                        </th>
                    </tr>
                </thead>
                <tbody>

                    <tr v-for="(meal, i) in mealGraphic" :key="meal.time">

                        <td class="d-flex align-items-center activity-color"
                        @click="toggleTimes(i)" >
                            <span
                                v-for="info in meal.mealPopover"
                                class="mr-2 tooltipp"
                            >
                                @{{ info.name }}
                            </span>
                        </td>

                        <td
                            v-for="(meal_info, j) in meal.minutes"
                            :key="meal_info.minute"
                            class="d-flex justify-content-between align-items-center"
                            v-if="meal_info.show"
                        >
                            <div v-if="meal_info.name"
                                class="w-100 green d-flex justify-content-between align-items-center">
                                @{{ meal_info.name }}

                                <div class="edit-meal" data-toggle="modal" data-target="#meal" v-if="!meal_info.water"> <i class="fas fa-edit"></i> </div>
                                <div class="edit-meal" data-toggle="modal" data-target="#water"
                                    @click="openEditWaterPopup( meal_info.quantity, meal_info.minute, meal_info.id )" v-else>
                                    <i class="fas fa-edit"></i>
                                </div>

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
                <tbody v-for="(meal, i) in mealGraphic" :key="meal.time">
                    <tr  @click="toggleTimes(i)" >
                        <td class="bg-dark-p"><b>@{{ meal.totals.totalFat }}</b></td>
                        <td class="bg-dark-p"><b>@{{ meal.totals.totalFatD }}</b></td>
                        <td class="bg-dark-p"><b>@{{ meal.totals.totalCarb }}</b></td>
                        <td class="bg-dark-p"><b>@{{ meal.totals.totalCarbD }}</b></td>
                        <td class="bg-dark-p"><b>@{{ meal.totals.totalProteinG }}</b></td>
                        <td class="bg-dark-p" class="p-0">
                            <b :class="{ 'text-danger' : meal.totals.proteinHourlyLimit > 0 }">
                                @{{ meal.totals.totalProtein }}
                            </b>
                            <small v-if="meal.totals.proteinHourlyLimit > 0">
                                (+@{{ meal.totals.proteinHourlyLimit }} )
                            </small>
                        </td>
                    </tr>

                    <tr v-for="(meal_info, j) in meal.minutes" :key="j"
                        v-if="meal_info.show"
                    >
                        <td><span class="green" v-if="meal_info.mealType == 2 && meal_info.name && !meal_info.water">@{{ meal_info.intake.fatG }}</span></td>
                        <td><span v-if="meal_info.mealType == 2">@{{ meal_info.intake.fatD }}</span></td>
                        <td><span class="green" v-if="meal_info.mealType == 2 && meal_info.name && !meal_info.water">@{{ meal_info.intake.carbG }}</span></td>
                        <td><span v-if="meal_info.mealType == 2">@{{ meal_info.intake.carbD }}</span></td>
                        <td><span v-if="meal_info.mealType == 2 && meal_info.name && !meal_info.water">@{{ meal_info.intake.proteinG }}</span></td>
                        <td><span v-if="meal_info.mealType == 2">@{{ meal_info.intake.proteinD }}</span></td>
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
                <tbody v-for="(status, i) in mealGraphic" :key="status.time">
                    <tr  @click="toggleTimes(i)" >
                        <td class="bg-dark-p"></td>
                        <td class="bg-dark-p"></td>
                    </tr>

                    <tr v-for="(status_info, j) in status.minutes" :key="j"
                        v-if="status_info.show"
                    >
                        <td>
                            <div>
                                @{{ Math.abs(status_info.statusObj.fat) }}
                                <span v-if="status_info.statusObj.fat != 0">
                                    <span class="green" v-if="status_info.statusObj.fat > 0">(loss)</span>
                                    <span class="red" v-else>(access)</span>
                                </span>
                            </div>
                        </td>
                        <td>
                            <div>
                                @{{ Math.abs(status_info.statusObj.carb) }}
                                <span v-if="status_info.statusObj.carb != 0">
                                    <span class="green" v-if="status_info.statusObj.carb > 0">(loss)</span>
                                    <span class="red" v-else>(access)</span>
                                </span>
                            </div>
                        </td>
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


    <div id="activity" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" v-if="!editActivityPopup">Activity</h4>
                    <h4 class="modal-title" v-else>Edit Activity</h4>
                </div>
                <div class="modal-body">
                    <h3 class="text-danger m-t-20 m-b-20 error_modal_activity"></h3>
                    <div class="form-group">
                        <label for="activity_list">Choose Activity</label>
                        <select name="activity" id="activity_list" class="activity_list form-control">
                            @foreach($activity as $key => $val)
                                <option value="{{$val->id}}"> {{$val->name}} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="activity_from">From</label>
                                <input type="text" readonly class="activity_from clockpicker form-control bg-white">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="activity_to">To</label>
                                <input type="text" readonly class="clockpicker activity_to form-control bg-white">
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <div class="d-flex justify-content-between" v-if="editActivityPopup">
                        <button class="btn btn-danger activity_delete" @click="deleteActivity">Delete Activity</button>
                        <button class="btn btn-success activity_edit" @click="editActivity">Edit</button>
                    </div>
                    <button class="btn btn-success" @click="saveActivity" v-if="!editActivityPopup">Save</button>
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
                                    <div class="form-group col-md-12">
                                        <label for="activity_list">Choose Meal</label>
                                        <select name="meal" id="meal_list" class="meal_list form-control">
                                            <option value="">Choose Meal</option>
                                            @foreach($meals as $key => $val)
                                                <option value="{{$val->id}}">{{$val->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-row display-inline">
                                    <div class="form-group col-md-1">
                                        <label for="total_mass">Total Mass</label>
                                        <input type="number" class="form-control" id="m_total_mass"
                                                placeholder="Total Mass"
                                                name="total_mass" readonly required value="">
                                    </div>

                                    <div class="form-group col-md-1">
                                        <label for="total_carbs">Total Carbs</label>
                                        <input type="number" class="form-control" id="m_total_carbs"
                                                placeholder="Total Carbs"
                                                name="total_carbs" readonly required value="">
                                    </div>

                                    <div class="form-group col-md-1">
                                        <label for="total_fat">Total Fat</label>
                                        <input type="number" class="form-control" id="m_total_fat"
                                                placeholder="Total Fat"
                                                name="total_fat" readonly required value="">
                                    </div>

                                    <div class="form-group col-md-1">
                                        <label for="total_proteins">Total Proteins</label>
                                        <input type="number" class="form-control" id="m_total_proteins"
                                                placeholder="Total Proteins" name="total_proteins" readonly required
                                                value="">
                                    </div>

                                    <div class="form-group col-md-1">
                                        <label for="total_calories">Total Calories</label>
                                        <input type="number" class="form-control" id="m_total_calories"
                                                placeholder="Total Calories" name="total_calories" readonly required
                                                value="">
                                    </div>

                                    <div class="form-group col-md-1">
                                        <label for="total_ph">Total PH</label>
                                        <input type="number" class="form-control" id="m_total_ph" placeholder="Total PH"
                                                name="total_ph" readonly required value="">
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label for="total_glycemic_load">Total Glycemic Load</label>
                                        <input type="number" class="form-control" id="m_total_glycemic_load"
                                                placeholder="Total Glycemic Load" name="total_glycemic_load" readonly
                                                required value="">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-12 no-padding">
                                        <div class="m_foods">

                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="meal_from">Time</label>
                                        <input type="text" readonly name="from" class="clockpicker meal_from form-control">
                                    </div>

                                    <div class="col-md-9 table-of-carb-fat">
                                        <table class="intake-table border-green table table-striped">
                                            <thead>
                                                <tr>
                                                    <th colspan="2">Expenditure</th>
                                                    <th colspan="2">Intake</th>
                                                    <th colspan="2">Status</th>
                                                </tr>
                                                <tr>
                                                    <th>Carb</th>
                                                    <th>Fat</th>
                                                    <th>Carb</th>
                                                    <th>Fat</th>
                                                    <th>Carb</th>
                                                    <th>Fat</th>
                                                </tr>
                                            </thead>
                                            <tbody id="meal_carb_fat"></tbody>
                                        </table>
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
                                <input type="hidden" class="user_id" name="id" value="{{$user->id}}">
                                <input type="hidden" class="meal_date" name="date">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name"
                                            placeholder="Name" name="name" value="">
                                </div>

                                <div class="form-row">

                                    <div class="form-group col-md-1">
                                        <label for="total_mass">Total Mass</label>
                                        <input type="number" class="form-control" id="total_mass"
                                                placeholder="Total Mass"
                                                name="total_mass" readonly required>
                                    </div>

                                    <div class="form-group col-md-1">
                                        <label for="total_carbs">Total Carbs</label>
                                        <input type="number" class="form-control" id="total_carbs"
                                                placeholder="Total Carbs"
                                                name="total_carbs" readonly required>
                                    </div>

                                    <div class="form-group col-md-1">
                                        <label for="total_fat">Total Fat</label>
                                        <input type="number" class="form-control" id="total_fat" placeholder="Total Fat"
                                                name="total_fat" readonly required>
                                    </div>

                                    <div class="form-group col-md-1">
                                        <label for="total_proteins">Total Proteins</label>
                                        <input type="number" class="form-control" id="total_proteins"
                                                placeholder="Total Proteins" name="total_proteins" readonly required>
                                    </div>

                                    <div class="form-group col-md-1">
                                        <label for="total_calories">Total Calories</label>
                                        <input type="number" class="form-control" id="total_calories"
                                                placeholder="Total Calories" name="total_calories" readonly required>
                                    </div>

                                    <div class="form-group col-md-1">
                                        <label for="total_ph">Total PH</label>
                                        <input type="number" class="form-control" id="total_ph" placeholder="Total PH"
                                                name="total_ph" readonly required>
                                    </div>

                                    <div class="form-group col-md-2">
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
                                                    style="height: 100px;width: 100px;margin-top: 24px;">
                                                <i class="fa fa-plus" style="font-size: 60px;"></i></button>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group col-md-3">
                                            <label for="meal_from">Time</label>
                                            <input type="text" name="from" readonly
                                                    class="clockpicker create_meal_time form-control">
                                        </div>
                                        <div class="col-md-9 table-of-carb-fat">
                                            <table class="intake-table border-green table table-striped">
                                                <thead>
                                                <tr>
                                                    <th colspan="2">Expenditure</th>
                                                    <th colspan="2">Intake</th>
                                                    <th colspan="2">Status</th>
                                                </tr>
                                                <tr>
                                                    <th>Carb</th>
                                                    <th>Fat</th>
                                                    <th>Carb</th>
                                                    <th>Fat</th>
                                                    <th>Carb</th>
                                                    <th>Fat</th>
                                                </tr>
                                                </thead>
                                                <tbody id="meal_carb_fat_add"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <button
                                            type="button"
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

    <div id="clearAllMealPopup" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Are you sure you want to clear all meals?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger clear-all-meal">Yes, clear</button>
                </div>
            </div>
        </div>
    </div>

    <div id="water" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Water</h4>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <form>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for=""> Quantity (ml) </label>
                                    <input type="text" name="waterQuantity" id="quantity" class="form-control quantity">
                                </div>
                                <div class="form-group col-md-12 mb-0">
                                    <label for="" class="mb-2">Time</label>
                                    <input type="text" readonly name="waterTime" class="clockpicker water_time form-control">
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
                <div class="modal-footer">
                    <button  class="btn btn-success add-water" v-show="!editWater">Add</button>
                    <button  class="btn btn-success edit-water" v-show="editWater">Edit</button>
                </div>
            </div>
        </div>
    </div>

    <div id="duplicateMeal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Duplicate meal</h4>
                </div>
                <div class="modal-body">
                    <div class="copyMeal">&nbsp;</div>
                </div>
                <div class="modal-footer">
                    <button type="button"
                    class="btn btn-success duplicate-meal">Duplicate</button>
                </div>
            </div>
        </div>
    </div>

</div>

<div id="alerts" style="position: absolute; bottom: 32%; left: 75%; width: 100%; z-index: 99999; text-align: center;"></div>



@endsection

{{--script in here --}}
@push("footer")
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="{{asset('assets/plugins/clockpicker/dist/jquery-clockpicker.js')}}"></script>
<script src="{{asset('assets/plugins/datepicker-new/js/bootstrap-datepicker.js')}}"></script>


<script !src="">
    $(document).ready(function () {

        show_date();

        // Protein Hourly limit
        let res = JSON.parse('<?php echo json_encode($user); ?>');
        days.proteinHourlyLimit = res.protein_hourly_limit


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

            days.clearState();
            getActivities();

        }

        function roundTime(time) {

            let timePart = time.split(':');

            let minPart = parseInt(timePart[1]);

            let newTime = '';

            if (minPart % 10) {

                let afterTimeRounded = (minPart % 10 > 5) ?
                    Math.ceil(minPart / 10) * 10
                    : Math.floor(minPart / 10) * 10;

                if (!afterTimeRounded) {
                    afterTimeRounded = '00';
                }

                if(afterTimeRounded == '60') {

                    afterTimeRounded = '00'

                    let newTimepart = parseInt(timePart[0]) + 1


                    if(newTimepart < 10) {
                        newTimepart = '0' + newTimepart
                    }

                    timePart[0] = newTimepart

                }

                newTime = timePart[0] + ':' + afterTimeRounded
                return newTime;
            }

            return time;
        }

        $('.activity_from').clockpicker({
            autoclose: true,
            placement: 'bottom',
        }).change(function(){
            let roundedTime = roundTime($(this).val())
            $(this).val(roundedTime)
        });

        $('.activity_to').clockpicker({
            autoclose: true,
            placement: 'bottom',
        }).change(function(){
            let roundedTime = roundTime($(this).val())
            $(this).val(roundedTime)
        });

        function returnPlus4Time(time) {
            let roundedTime = roundTime(time);
            let start = parseInt(roundedTime.substring(0, 2));
            let startsEnd = roundedTime.substring(3);
            start += 4;
            let final = start + ":" + startsEnd;
            console.log('Start time : ', time)
            console.log('Final time : ', final)
            return final
        }

        $('.meal_from').clockpicker({
            autoclose: true,
            placement: 'top',
        }).change(function(){

            let finTIme = returnPlus4Time($(this).val())
        

            $(this).val($(this).val())
        });

        $('.water_time').clockpicker({
            autoclose: true,
            placement: 'top',
        }).change(function(){
            let roundedTime = roundTime($(this).val())
            $(this).val(roundedTime)
        });

        $('.create_meal_time').clockpicker({
            autoclose: true,
            placement: 'top',
        }).change(function(){
            let roundedTime = roundTime($(this).val())
            $(this).val(roundedTime)
        });

        $('.date').datepicker({autoclose: true, format: 'yyyy-mm-dd'}).on('changeDate', function (e) {
            let str = new Date(e.date)
            mnth = ("0" + (str.getMonth() + 1)).slice(-2),
                day = ("0" + str.getDate()).slice(-2);
            let date = [str.getFullYear(), mnth, day].join("-");
            $('.date-show').html(date);
            show_date(0, date);
        });

        let finalDatesArr = []

        $('.copyMeal').datepicker({
            multidate: true,
            format: 'yyyy-mm-dd',
            inline: true
        }).on('changeDate', function (e) {

            finalDatesArr = []

            let dates = e.dates,
                copyDatesArr = []

            for(let i=0; i<dates.length; i++) {
                let str = dates[i],
                    mnth = ("0" + (str.getMonth() + 1)).slice(-2),
                    day = ("0" + str.getDate()).slice(-2),
                    date = [str.getFullYear(), mnth, day].join("-");
                    copyDatesArr.push(date);
            }

            finalDatesArr = copyDatesArr

        });

        $('.duplicate-meal').click(function () {

            let data = {
                user_id: $('.user_id').val(),
                date_from: $('.date-show').html(),
                date_to: finalDatesArr
            };

            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                url: '{{ url('/day/duplicate-meals') }}',
                data: data,
                success: function (res) {
                    let alert =
                        $('<div class="alert alert-success alert-dismissable" style="width: 25%;">' +
                        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
                        res.msg + '</div>');
                    alert.appendTo("#alerts");
                    alert.slideDown("slow").delay(3000).fadeOut(2000, function(){
                        $(this).remove();
                    });
                }
            });

        });

        $('.date-plus').click(function () {
            let dateString = $('.date-show').html();
            show_date(1, dateString)
        });

        $('.date-minus').click(function () {
            let dateString = $('.date-show').html();
            show_date(2, dateString)
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
                success: function (res) {
                    $('#meal').modal('toggle');
                    getActivities();
                },
                error: function (reject) {
                    $('.m_errors').empty()
                    $('.m_success').empty()
                    if (reject.status === 422) {
                        var err = $.parseJSON(reject.responseText)
                        $('.m_errors').append(`<li>Please choose a meal!</li>`)
                    }
                    setTimeout(function () {
                        $('.m_errors').empty()
                    }, 10000)
                }
            })
        })

        $('.clear-all-meal').click(function() {

            let data = {
                user_id: $('.user_id').val(),
                date: $('.date-show').html()
            };

            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                url: '{{ url('/day/clear-all-meals') }}',
                data: data,
                success: function (res) {
                    $('#clearAllMealPopup').modal('toggle');
                    days.meal = []

                    days.createTimeGraphic()
                    days.createMealGraphic()
                    days.createStatusGraphic()
                }
            });
        })

        $('.add-water').click(function() {
            let data = {
                user_id: $('.user_id').val(),
                date: $('.date-show').html(),

                quantity: parseFloat($('.quantity').val()),
                from: $('.water_time').val()
            };

            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                url: '{{ url('/day/add-water') }}',
                data: data,
                success: function (res) {
                    $('#water').modal('toggle');

                    let waterObj = {
                        id: res.water.id,
                        name: res.water.quantity + ' ml',
                        quantity: res.water.quantity,
                        start: res.water.from,
                        type: 'water'
                    };

                    days.addMeals(waterObj)


                    days.createTimeGraphic();
                    days.createMealGraphic();
                    days.createStatusGraphic();

                }
            });
        })

        $('.edit-water').click(function() {

            let data = {
                user_id: $('.user_id').val(),
                date: $('.date-show').html(),

                quantity: parseFloat($('.quantity').val()),
                from: $('.water_time').val(),
                id: days.id
            };

            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                url: '{{ url('/day/edit-water') }}',
                data: data,
                success: function (res) {

                    $('#water').modal('toggle');

                    days.actions = []
                    days.meal = []

                    getActivities();

                }
            });
        })


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

                if($(this).find('input').val()) {

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

                    var tr = calculateCarbDigestion(total_glycemic_load, total_carbs, total_fat);
                    $('#meal_carb_fat_add').html(tr);
                }
            });
        }

        $('.create-meal').click(function () {

            $('.meal_date').val($('.date-show').html())
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
                            if(key == 'name'){
                                $('.errors').append(`<li>Please Add Meal Name!</li>`)
                            }
                            if(key == 'food'){
                                $('.errors').append(`<li>A Meal Must Have At Least One Food Item!</li>`)
                            }
                            if(key == 'from'){
                                $('.errors').append(`<li>Please Select A Time!</li>`)
                            }
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

<!-- VUE -->
<script defer>

    var bodyWeight = 55;

    function roundNumberDecimal(number) {
        let floatNumber = parseFloat(number);
        return Math.round((floatNumber + Number.EPSILON) * 100) / 100
    }

    function calculateCarbDigestion(glycemicLoad , carbs, fat) {
        var tr = "";
        var carb = (glycemicLoad <= 40 ) ? carbs / 4 : (glycemicLoad > 40 && glycemicLoad <= 55) ? carbs / 3 : (glycemicLoad > 55 && glycemicLoad <= 70) ? carbs / 2 : carbs;
        var fourHourFat = fat / 4;
        var prevCarb = 0;
        for (var i = 1; i < 5; i++) {
            let fatGr = $('.energy-table tbody:nth-child('+(i+1)+')').find('tr:first').find('td.fatGr span').text();
            let carbGr = $('.energy-table tbody:nth-child('+(i+1)+')').find('tr:first').find('td.fatGr span').text();
            prevCarb += carb;
            var currentCarb = (prevCarb != carbs) ? roundNumberDecimal(carb) : '-'
            let carbStatus = (currentCarb != '-') ? currentCarb - carbGr : '-';
            let carbStatusText = (carbStatus > 0 && carbStatus != '-') ? roundNumberDecimal(Math.abs(currentCarb - carbGr)) + " access" : roundNumberDecimal(Math.abs(currentCarb - carbGr)) + ' loss';
            let fatStatus = fourHourFat - fatGr;
            let fatStatusText = (fatStatus > 0) ? roundNumberDecimal(Math.abs(fourHourFat - fatGr)) + " access " : roundNumberDecimal(Math.abs(fourHourFat - fatGr)) + ' loss';
            tr += `<tr>
                        <td>${carbGr}</td>
                        <td>${fatGr}</td>
                        <td>${currentCarb}</td>
                        <td>${roundNumberDecimal(fourHourFat)}</td>
                        <td>${carbStatusText}</td>
                        <td>${fatStatusText}</td>
                    </tr>`;
        }
        return tr;
    }

    function calculateProteinLimit() {

        let data = {
            date: $('.date-show').html(),
            id: $('.user_id').val()
        };

        $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            },
            url: "{{ url('/day/calculate-protein-limit') }}",
            data: data,
            success: function (res) {
                $('.protein_must').html(res.protein_must_eat);
            }
        });
    }

    function drawAssassmentAlert() {
        $('#assassmentAlert').html('');
        let html = ' <div class="alert warning-alert alert-dismissible">' +
            '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' +
            '<strong>Warning:</strong> The user does not have a projection or an assessment. System can not calculate the protein limit.' +
            '</div>'
        $('#assassmentAlert').append(html);
    }

    function getActivities() {

        console.log('Get activities')

        calculateProteinLimit();

        days.actions = []
        days.meal = []

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

                console.log('Data = ', res)

                if(!res.assessment_status) {
                    drawAssassmentAlert();
                }


                let p_met = 0;
                for (var z = 0; z < res.meal.length; z++){
                    p_met += parseFloat(res.meal[z].get_meals.proteins)
                }
                $('.protein_eat').html(p_met);


                let activities = res.activity,
                    meals = res.meal,
                    water = res.water;


                for(let i=0; i<activities.length; i++) {

                    let activityObj = {
                        id: activities[i].id,
                        activity_id: activities[i].activity_id,
                        activity: true,
                        name: activities[i].get_activity.name,
                        start: activities[i].from,
                        end: activities[i].to,

                        fatPercentage: activities[i].get_activity.fat_ratio,
                        carbPercentage: activities[i].get_activity.carb_ratio,
                        met: activities[i].get_activity.met
                    };
                    days.addActivity(activityObj)
                }

                for(let i=0; i<meals.length; i++) {

                    let time = days.existMealTimeFormula( meals[i].get_meals.glycemic_load )
                    let start = parseInt(meals[i].from.substring(0, 2))
                    let startsEnd = meals[i].from.substring(3)
                    let end = start + time + ":" + startsEnd

                    let mealObj = {
                        meal: true,
                        name: meals[i].get_meals.name,
                        start: meals[i].from,
                        end: end,

                        fatG: meals[i].get_meals.fat,
                        fatD: 0,

                        carbG: meals[i].get_meals.carbs,
                        carbD: 0,

                        proteinG:  meals[i].get_meals.proteins,
                        proteinD: 0,
                        glycemicLoad: meals[i].get_meals.glycemic_load,
                    };

                    days.addMeals(mealObj)
                }

                for(let i=0; i<water.length; i++) {
                    let waterObj = {
                        id: water[i].id,
                        name: water[i].quantity + ' ml',
                        quantity:  water[i].quantity,
                        start: water[i].from,
                        type: 'water'
                    };

                    days.addMeals(waterObj)
                }

                days.createTimeGraphic();
                days.createMealGraphic();
                days.createStatusGraphic();

            }
        })
    }

    let days = new Vue({
        el: '#_days',
        data() {
            let self = this;
            return {
                staticTimes: [],
                mealGraphic: [],
                actions: [],
                meal: [],
                color: 0,

                editWater: false,
                id: 0,
                selectedActivity: [],

                energyExpendedMode: false,
                circleCount: 0,

                editActivityPopup: false,
                proteinHourlyLimit: 0,
            }
        },
        methods: {
            returnRandomColor() {
                this.color = this.color + 1
                if(this.color % 2) {
                    return '#F9C402'
                } else {
                    return '#FF6000'
                }
            },
            closeAll() {
                for(let i=0; i<this.staticTimes.length; i++) {
                    for(let j=0; j<this.staticTimes[i].minutes.length; j++) {
                        this.staticTimes[i].minutes[j].show = false
                    }
                }
            },
            toggleTimes(i) {
                let times = this.staticTimes[i].minutes
                for(let k=0; k < times.length; k++) {
                    times[k].show ? times[k].show = false : times[k].show = true
                }

                let meals = this.mealGraphic[i].minutes
                for(let k=0; k < meals.length; k++) {
                    meals[k].show ? meals[k].show = false : meals[k].show = true
                }
            },
            totalCalFormula(mets, bodyWeight) {
                return (mets * 3.5 * bodyWeight / 200) * 10
            },
            facCFormula(number, percentage) {
                return (number * percentage) / 100
            },
            fatGFormula(fatC) {
                return (fatC / 9).toFixed(2)
            },
            carbGFormula(carbC) {
                return (carbC / 4).toFixed(2)
            },
            existMealTimeFormula(glycemicLoad) {

                if(glycemicLoad < 40) {
                    return 4
                }

                if(glycemicLoad > 40 && glycemicLoad < 55) {
                    return 3
                }

                if(glycemicLoad > 55 && glycemicLoad < 70) {
                    return 2
                }

                if(glycemicLoad > 70) {
                    return 1
                }

            },
            carbDigestFormula(carb, glycemicLoad) {

                if(glycemicLoad < 40) {
                    // digestion is divided on 4 hours
                    return ((carb / 4) / 6).toFixed(2)
                }

                if(glycemicLoad > 40 && glycemicLoad < 55) {
                    // digestion is divided on 3 hours
                    return ((carb / 3) / 6).toFixed(2)
                }

                if(glycemicLoad > 55 && glycemicLoad < 70) {
                    // digestion is divided on 2 hours
                    return ((carb / 2) / 6).toFixed(2)
                }

                if(glycemicLoad > 70) {
                    // digestion is divided on 1 hours
                    return ((carb / 1) / 6).toFixed(2)
                }

            },

            createTimeGraphic() {

                console.log('Create time graphic..')

                let timeArr = [],
                    end = null,
                    color = this.returnRandomColor(),
                    // totalCount = 0,
                    minuteExpenditure = {};

                for(let i=8; i<=20; i++) {

                    let timeObj = {
                        time: i < 10 ? '0' + i + ':00' : i + ':00',
                        minutes: [],
                        activityPopover: [],
                        totals: {
                            totalCal: null,
                            totalFatC: null,
                            totalFatG: null,
                            totalCarbC: null,
                            totalCarbG: null,
                            totalFatG: null
                        }
                        // mealPopover: [],
                    }

                    for(let j=0; j<6; j++) {

                        let m = i + ':' + j + '0';
                        let fm = i < 10 ? '0' + m : m;

                        let minute = {
                            minute: fm,
                            show: false
                        }

                        for(let k=0; k<this.actions.length; k++) {

                            let totalCal = this.totalCalFormula(this.actions[k].met, 80),
                                fatC = this.facCFormula(totalCal, this.actions[k].fatPercentage),
                                fatG = this.fatGFormula(fatC),
                                carbC = this.facCFormula(totalCal, this.actions[k].carbPercentage),
                                carbG = this.carbGFormula(carbC);

                            let expenditure = {
                                totalCal: totalCal,
                                fatPercentage: this.actions[k].fatPercentage,
                                fatC: fatC,
                                fatG: fatG,
                                carbPercentage: this.actions[k].carbPercentage,
                                carbC: carbC,
                                carbG: carbG
                            }

                            if(fm == this.actions[k].start) {

                                end = this.actions[k].end

                                // ################### Hashvark te qani hat 10 rope ka ###################

                                let t1 = parseInt(this.actions[k].start.substring(0,2)),
                                    t11 = parseInt(this.actions[k].start.substring(3,5));

                                let t2 = parseInt(end.substring(0,2)),
                                    t22 = parseInt(end.substring(3,5));

                                let result1 = t2 -t1,
                                    result2 = t22 - t11;

                                let finalResult = parseInt((result1 * 60) + result2);
                                // #########################################################################

                                minute.borderColor = color
                                minute.name = this.actions[k].name

                                minute.energyExpenditure = expenditure
                                minuteExpenditure = expenditure

                                let popover = {
                                    id: this.actions[k].id,
                                    name: this.actions[k].name,
                                    start: this.actions[k].start,
                                    end: this.actions[k].end,
                                    activity_id: this.actions[k].activity_id,
                                    total: ((finalResult / 10) * totalCal).toFixed(2),
                                }

                                timeObj.activityPopover.push(popover)
                                minute.minuteActivityPopover = popover

                            } else {

                                if(end == fm) {
                                    end = null
                                    color = this.returnRandomColor()
                                    // totalCount = 0;
                                }

                                else if(fm != this.actions[k].start && end != null) {

                                    minute.borderColor = color
                                    minute.actionType = 1

                                    if( !minute.energyExpenditure ) {
                                        // totalCount++;
                                        minute.energyExpenditure = minuteExpenditure
                                    }
                                }

                            }

                        }


                        // Red cyrcle
                        if(!minute.borderColor) {
                            timeObj.circle = true
                        }

                        timeObj.minutes.push(minute)
                    }

                    let _totalCal = 0,
                        _totalFatC = 0,
                        _totalFatG = 0,
                        _totalCarbC = 0,
                        _totalCarbG = 0;

                    for(let i=0; i<timeObj.minutes.length; i++) {
                        if(timeObj.minutes[i].energyExpenditure) {
                            _totalCal += parseFloat (timeObj.minutes[i].energyExpenditure.totalCal)
                            _totalFatC += parseFloat (timeObj.minutes[i].energyExpenditure.fatC)
                            _totalFatG += parseFloat (timeObj.minutes[i].energyExpenditure.fatG)
                            _totalCarbC += parseFloat (timeObj.minutes[i].energyExpenditure.carbC)
                            _totalCarbG += parseFloat (timeObj.minutes[i].energyExpenditure.carbG)
                        }
                    }

                    timeObj.totals.totalCal = _totalCal != 0 ? _totalCal.toFixed(2) : ""
                    timeObj.totals.totalFatC = _totalFatC != 0 ? _totalFatC.toFixed(2) : ""
                    timeObj.totals.totalFatG = _totalFatG != 0 ? _totalFatG.toFixed(2) : ""
                    timeObj.totals.totalCarbC = _totalCarbC != 0 ? _totalCarbC.toFixed(2) : ""
                    timeObj.totals.totalCarbG = _totalCarbG != 0 ? _totalCarbG.toFixed(2) : ""

                    timeArr.push(timeObj)
                }

                this.staticTimes = timeArr
                console.log('Static Times : ', this.staticTimes)

            },
            createMealGraphic() {
                console.log('Create Meal graphic..')

                let mealArr = [],
                end = null,
                minuteIntake = {},
                sw = false;
                let x = {}

                for(let i=8; i<=20; i++) {

                    let timeObj = {
                        time: i < 10 ? '0' + i + ':00' : i + ':00',
                        minutes: [],
                        mealPopover: [],
                        totals: {
                            totalFat: null,
                            totalFatD: null,
                            totalCarb: null,
                            totalCarbD: null,
                            totalProteinG: null,
                            totalProtein: null,
                            proteinHourlyLimit: null
                        }
                    }

                    for(let j=0; j<6; j++) {

                        let m = i + ':' + j + '0';
                        let fm = i < 10 ? '0' + m : m;

                        let minute = {
                            minute: fm,
                            show: false
                        }

                        for(let k=0; k<this.meal.length; k++) {

                            if(this.meal[k].type) {

                                if(fm == this.meal[k].start) {
                                    minute.name = this.meal[k].name
                                    minute.quantity = this.meal[k].quantity
                                    minute.water = true
                                    minute.id = this.meal[k].id
                                    let popover = {
                                        name: this.meal[k].name
                                    }
                                    timeObj.mealPopover.push(popover)
                                }

                            }

                            else {

                                let carbs = this.meal[k].carbG,
                                    load = this.meal[k].glycemicLoad,
                                    carbD = this.carbDigestFormula(carbs, load);

                                let intake = {
                                    fatG: this.meal[k].fatG,
                                    fatD: ((this.meal[k].fatG / 4) / 6).toFixed(2),

                                    carbG: carbs,
                                    carbD: carbD,

                                    proteinG: this.meal[k].proteinG,
                                    proteinD: ((this.meal[k].proteinG / 4) / 6).toFixed(2)
                                }

                                if(fm == this.meal[k].start) {

                                    end = this.meal[k].end
                                    minute.name = this.meal[k].name
                                    minute.mealType = 2

                                    let popover = {
                                        name: this.meal[k].name
                                    }
                                    timeObj.mealPopover.push(popover)

                                    minuteIntake = intake

                                    if( !minute.intake ) {
                                        minute.intake = intake
                                    } else {
                                        sw = true
                                        x = {
                                            fatG: intake.fatG,
                                            fatD: parseFloat(minute.intake.fatD) + parseFloat(minuteIntake.fatD),

                                            carbG: intake.carbG,
                                            carbD: parseFloat(minute.intake.carbD) + parseFloat(minuteIntake.carbD),

                                            proteinG: intake.proteinG,
                                            proteinD: parseFloat(minute.intake.proteinD) + parseFloat(minuteIntake.proteinD),
                                        }
                                        minute.intake = x
                                    }

                                } else {

                                    if(end == fm) {
                                        end = null
                                    }

                                    else if(fm != this.meal[k].start && end != null) {
                                        minute.mealType = 2

                                        if( !minute.intake ) {
                                            minute.intake = minuteIntake
                                        }

                                        if(minute.intake && sw) {
                                            minute.intake = x
                                        }
                                    }
                                }

                            }

                        }

                        timeObj.minutes.push(minute)
                    }

                    let _totalFat = 0,
                        _totalFatD = 0,
                        _totalCarb = 0,
                        _totalCarbD = 0,
                        _totalProteinG = 0,
                        _totalProtein = 0,
                        _proteinHourlyLimit = 0;

                    for(let i=0; i<timeObj.minutes.length; i++) {
                        if(timeObj.minutes[i].intake) {
                            if(timeObj.minutes[i].name && !timeObj.minutes[i].water) {
                                _totalFat += parseFloat(timeObj.minutes[i].intake.fatG)
                                _totalCarb += parseFloat(timeObj.minutes[i].intake.carbG)
                                _totalProteinG += parseFloat(timeObj.minutes[i].intake.proteinG)
                            }

                            _totalFatD += parseFloat(timeObj.minutes[i].intake.fatD)
                            _totalCarbD += parseFloat(timeObj.minutes[i].intake.carbD)
                            _totalProtein += parseFloat(timeObj.minutes[i].intake.proteinD)
                        }
                    }

                    let proteinHLFinal = parseFloat(_totalProtein) - this.proteinHourlyLimit

                    timeObj.totals.totalFat = _totalFat != 0 ? _totalFat.toFixed(2) : ""
                    timeObj.totals.totalFatD = _totalFatD != 0 ? _totalFatD.toFixed(2) : ""
                    timeObj.totals.totalCarb = _totalCarb != 0 ? _totalCarb.toFixed(2) : ""
                    timeObj.totals.totalCarbD = _totalCarbD != 0 ? _totalCarbD.toFixed(2) : ""
                    timeObj.totals.totalProteinG = _totalProteinG != 0 ? _totalProteinG.toFixed(2) : ""
                    timeObj.totals.totalProtein = _totalProtein != 0 ? _totalProtein.toFixed(2) : ""
                    timeObj.totals.proteinHourlyLimit = proteinHLFinal != 0 ? proteinHLFinal.toFixed(2) : ""

                    mealArr.push(timeObj)
                }

                this.mealGraphic = mealArr
                console.log('Meal graphic : ', this.mealGraphic)
            },
            createStatusGraphic() {
                for(let i=0; i<this.staticTimes.length; i++) {
                    let minutes = this.staticTimes[i].minutes
                    for(let j=0; j<minutes.length; j++) {

                        let intake = this.mealGraphic[i].minutes[j].intake,
                            fatG = 0, carbG = 0,
                            fatD = 0, carbD = 0,
                            fatStatus = 0,
                            carbStatus = 0;


                        if(minutes[j].energyExpenditure) {
                            fatG = minutes[j].energyExpenditure.fatG
                            carbG = minutes[j].energyExpenditure.carbG
                        }

                        if(intake) {
                            fatD = parseFloat(intake.fatD)
                            carbD = parseFloat(intake.carbD)
                        }


                        fatStatus = fatG - fatD;
                        carbStatus = carbG - carbD;


                        let statusObj = {
                            fat: parseFloat(fatStatus.toFixed(2)),
                            carb: parseFloat(carbStatus.toFixed(2))
                        }

                        this.mealGraphic[i].minutes[j].statusObj = statusObj

                        // console.log( 'Status = ', fatStatus.toFixed(2), carbStatus.toFixed(2) )
                    }
                }
                console.log('status = ',this.mealGraphic )
            },

            calculateStatus(fatGr, carbGr) {
                var fatStatus = fatGr - 0;
                var fatStatusText = fatStatus > 0 ? "loss" : "access";
                fatStatus = Math.abs(fatStatus);

                var carbStatus = carbGr - 0;
                var carbStatusText = carbStatus > 0 ? "loss" : "access";
                carbStatus = Math.abs(carbStatus);

                return {
                    'carbStatus': carbStatus,
                    'carbStatusText': carbStatusText,
                    'fatStatusText': fatStatusText,
                    'fatStatus': fatStatus
                }
            },

            addActivity(activityObj){
                this.actions.push(activityObj)
            },
            addMeals(mealObj){
                this.meal.push(mealObj);
            },
            clearState() {
                this.staticTimes = []
                this.mealGraphic = []
                this.actions = []
                this.meal = []
            },
            openEditWaterPopup(quantity, time, id) {
                this.editWater = true
                this.id = id

                $('#quantity').val(quantity)
                $('.water_time').clockpicker({
                    autoclose: true,
                    placement: 'bottom'
                }).val(time);

            },
            openEditActionPopup(activity) {
                this.id = activity.id
                this.selectedActivity = activity
            },

            deleteActivity() {

                let data = {
                    activity_id: days.id
                };

                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    },
                    url: '{{ url('/day/delete-activity') }}',
                    data: data,
                    success: function (res) {
                        console.log(res)
                        $('#activity').modal('toggle');
                        getActivities()
                    }
                });

            },
            saveActivity() {

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
                        getActivities()
                    },
                    error: function (reject) {
                        $('.error_modal_activity').empty()
                        console.log(reject)
                        if (reject.status === 422) {
                            let err = $.parseJSON(reject.responseText)
                            $('.error_modal_activity').append(err.success)
                        }
                        setTimeout(function () {
                            $('.error_modal_activity').empty()
                        }, 6000)
                    }
                });
            },
            editActivity() {

                let data = {
                    activity:       $('#activity_list').find(":selected").val(),
                    from:           $('.activity_from').val(),
                    to:             $('.activity_to').val(),
                    date:           $('.date-show').html(),
                    id:             days.selectedActivity.id,
                    user_id:        $('.user_id').val(),
                    activity_id:    days.selectedActivity.activity_id
                };

                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    },
                    url: '{{ url('/day/edit-activity') }}',
                    data: data,
                    success: function (res) {
                        $('#activity').modal('toggle');
                        getActivities()
                    },
                    error: function (reject) {
                        $('.error_modal_activity').empty()
                        console.log(reject)
                        if (reject.status === 422) {
                            let err = $.parseJSON(reject.responseText)
                            $('.error_modal_activity').append(err.success)
                        }
                        setTimeout(function () {
                            $('.error_modal_activity').empty()
                        }, 6000)
                    }
                });
            },


            clearActivity() {
                this.activities = []
                // this.activity();
            },
            clearMeals() {
                this.meal = []
                // this.meals();
            },
            energyExpendedModeSwitcher() {
                this.energyExpendedMode = !this.energyExpendedMode
            },
            // roundNumberDecimal(number) {
            //     let floatNumber = parseFloat(number);
            //     return Math.round((floatNumber + Number.EPSILON) * 100) / 100
            // },
            minCountFromStartToEnd(start, end) {
                //08:10 - 12:40 = 3:30
                var startParts = start.split(":");
                var endParts = end.split(":");
                var startHour = parseInt(startParts[0])
                var startMin = parseInt(startParts[1])
                var endHour = parseInt(endParts[0])
                var endMin = parseInt(endParts[1])
                var hourDiff = endHour - startHour
                var minDiff = Math.abs(endMin - startMin);
                var hourMinDiff = hourDiff * 5;
                var minMinDiff = minDiff / 10;
                var diffPerTenMin = hourMinDiff + minMinDiff;

                return {'hourCount': hourDiff, 'minDiff': diffPerTenMin}
            }
        },
        mounted() {

            this.createTimeGraphic();
            this.createMealGraphic();

            setTimeout(() => {
                this.createStatusGraphic()
            }, 1000);
        }
    })

</script>

<script !src="">
    $(document).ready(function () {

        // detect when water popup closed
        $('#water').on('hidden.bs.modal', function () {
            days.editWater = false
        });
        // detect when activity popup closed
        $('#activity').on('hidden.bs.modal', function () {
            days.editActivityPopup = false
            $('.activity_from').clockpicker({
                autoclose: true,
                placement: 'bottom',
            }).val('');

            $('.activity_to').clockpicker({
                autoclose: true,
                placement: 'bottom',
            }).val('');

            $('.error_modal_activity').empty()

        });

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
                    console.log('data meal : ', data)

                    $('#m_total_mass').val(roundNumberDecimal(data.mass));
                    $('#m_total_carbs').val(roundNumberDecimal(data.carbs));
                    $('#m_total_fat').val(roundNumberDecimal(data.fat));
                    $('#m_total_proteins').val(roundNumberDecimal(data.proteins));
                    $('#m_total_calories').val(roundNumberDecimal(data.calories));
                    $('#m_total_ph').val(roundNumberDecimal(data.ph));
                    $('#m_total_glycemic_load').val(roundNumberDecimal(data.glycemic_load));

                    var tr = calculateCarbDigestion(data.glycemic_load, data.carbs, data.fat);
                    $('#meal_carb_fat').html(tr);

                    var m_pl = ` <button type="button" class="btn btn-success col-md-2 m-b-20 m_plus"
                                                style=" height: 100px;width: 100px;">
                                            <i class="fa fa-plus" style="font-size: 60px;"></i></button>`
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

                        var elem = `<div class="form-group row_${i} m_food_items col-md-1">
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
                            <div class="form-group row_${row} m_food_items col-md-1">
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

                if($(this).find('input').val()) {

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

                    $('#m_total_mass').val(roundNumberDecimal(total_mass));
                    $('#m_total_carbs').val(roundNumberDecimal(total_carbs));
                    $('#m_total_fat').val(roundNumberDecimal(total_fat));
                    $('#m_total_proteins').val(roundNumberDecimal(total_proteins));
                    $('#m_total_calories').val(roundNumberDecimal(total_calories));
                    $('#m_total_ph').val(total_ph);
                    $('#m_total_glycemic_load').val(total_glycemic_load);

                    var tr = calculateCarbDigestion(total_glycemic_load, total_carbs, total_fat);
                    $('#meal_carb_fat').html(tr);
                }
            });
        }

        $(document).on("click", ".edit-activity", function () {

            days.editActivityPopup = true

            let from = days.selectedActivity.start
            let to =   days.selectedActivity.end
            let id = days.selectedActivity.activity_id

            $('.activity_from').clockpicker({
                autoclose: true,
                placement: 'bottom',
            }).val(from);

            $('.activity_to').clockpicker({
                autoclose: true,
                placement: 'bottom',
            }).val(to);

            $("#activity_list").val( id );


        });

        $(document).on("click", ".edit-meal", function () {
            console.log('edit-meal')
        });

    })
</script>

@endpush

{{--style in here--}}
@push("header")
<link href="{{asset('assets/plugins/clockpicker/dist/jquery-clockpicker.min.css')}}" rel="stylesheet">
<link href="{{asset('assets/plugins/datepicker-new/css/bootstrap-datepicker.css')}}" rel="stylesheet">

<style>

.bg-dark-p {
    background: #dbdcdd !important;
}

    .red-circle {
        position: absolute;
        width: 8px;
        height: 8px;
        background: #F44336;
        border-radius: 0;
        right: -1px;
        bottom: 1px;
    }

    .position-relative {
        position: relative;
    }

    .pointer {
        cursor: pointer;
    }

    .display-none {
        display: none;
    }

    .clockpicker-popover {
        z-index: 99999;
    }

    .table-condensed tr, .table-condensed td {
        height: auto !important;
    }

    .mode-switcher-button {

        margin-left: 10px;
        background: transparent;
        border: 1px solid #d4d4d4;
        border-radius: 5px;
    }
    .mode-switcher-button-absolute {
        position: absolute;
        right: 0;
    }

    .mode-switcher-button:hover {
        background-color: #fff;
    }

    .circle {
        position: relative;
    }
    .circle:before {
        content: "";
        position: absolute;
        width: 6px;
        height: 6px;
        background: #F44336;
        border-radius: 50%;
        left: 95px;
    }
    .font-big {
        border-right: none;
    }
    .datepicker {
        z-index: 9999 !important;
    }

    .text-right {
        text-align: right !important;
    }

    .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
        background-color: #fff;
        opacity: 1;
    }

</style>

@endpush
