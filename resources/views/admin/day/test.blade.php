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
                                class="mode-switcher-button exportExcel"
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
                            <span @click="hideZeroToEight" style="margin-left: 8px">
                                <i class="fas fa-bed"></i>
                            </span>
                        </th>
                    </tr>
                </thead>

                <tbody v-for="(time, i) in staticTimes" :key="time.time" v-if="time.show">
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
                        <th colspan="1" class="position-relative text-right">
                            <span>&nbsp;</span>
                            <button
                                class="mode-switcher-button"
                                data-toggle="modal"
                                data-target="#clearAllActivityPopup">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button
                                class="mode-switcher-button "
                                data-toggle="modal"
                                data-target="#duplicateActivity"
                            >
                                <i class="fas fa-clone"></i>
                            </button>
                        </th>
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
                    <tr v-for="(activity, i) in staticTimes" :key="activity.time" v-if="activity.show">

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
                            :class="{ hoverBox: !activity_info.borderColor, 'edit-activity' : activity_info.borderColor }"
                            @click="!activity_info.borderColor ? openHoveredAddActivity(activity_info) : openEditActionPopup(activity_info.minuteActivityPopover)"
                            
                            data-toggle="modal" data-target="#activity"
                        >
                        <!-- :data-toggle=" !activity_info.borderColor && 'modal' "
                            :data-target=" !activity_info.borderColor && '#activity' " -->


                            <span v-show="!activity_info.borderColor"><i class="fas fa-plus"></i></span>
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
                <tbody v-for="(time, i) in staticTimes" :key="time.time" v-if="time.show">
                    <tr  @click="toggleTimes(i)" >
                        <td><b>@{{ time.totals.totalCal }}</b></td>
                        <td v-if='energyExpendedMode'></td>
                        <td v-if='energyExpendedMode'><b>@{{ time.totals.totalFatC }}</b></td>
                        <td><b>@{{ time.totals.totalFatG }}</b></td>
                        <td v-if='energyExpendedMode'></td>
                        <td v-if='energyExpendedMode'><b>@{{ time.totals.totalCarbC }}</b></td>
                        <td><b>@{{ time.totals.totalCarbG }}</b></td>
                    </tr>

                    <tr v-for="(minute, j) in time.minutes" :key="j"
                        v-if="minute.show"
                    >
                        <td><span class="green" v-if="minute.borderColor">@{{ parseFloat(minute.energyExpenditure.totalCal).toFixed(2) }}</span></td>
                        <td v-if='energyExpendedMode'><span v-if="minute.borderColor">@{{ minute.energyExpenditure.fatPercentage }}</span></td>
                        <td v-if='energyExpendedMode'><span class="green" v-if="minute.borderColor">@{{ parseFloat(minute.energyExpenditure.fatC).toFixed(2) }}</span></td>
                        <td><span v-if="minute.borderColor">@{{ parseFloat(minute.energyExpenditure.fatG).toFixed(2) }}</span></td>
                        <td v-if='energyExpendedMode'><span v-if="minute.borderColor">@{{ minute.energyExpenditure.carbPercentage }}</span></td>
                        <td v-if='energyExpendedMode'><span v-if="minute.borderColor">@{{ parseFloat(minute.energyExpenditure.carbC).toFixed(2) }}</span></td>
                        <td><span v-if="minute.borderColor">@{{ parseFloat(minute.energyExpenditure.carbG).toFixed(2) }}</span></td>
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

                    <tr v-for="(meal, i) in mealGraphic" :key="meal.time" v-if="meal.show">

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

                                <div class="edit-meal" data-toggle="modal" data-target="#meal" 
                                    @click="openEditMealPopup(meal_info)" 
                                    v-if="!meal_info.water"> 
                                    <i class="fas fa-edit"></i> 
                                </div>
                                
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
                <tbody v-for="(meal, i) in mealGraphic" :key="meal.time" v-if="meal.show">
                    <tr  @click="toggleTimes(i)" >
                        <td><b>@{{ meal.totals.totalFat }}</b></td>
                        <td><b>@{{ meal.totals.totalFatD }}</b></td>
                        <td><b>@{{ meal.totals.totalCarb }}</b></td>
                        <td><b>@{{ meal.totals.totalCarbD }}</b></td>
                        <td><b>@{{ meal.totals.totalProteinG }}</b></td>
                        <td class="p-0">
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
                        <td><span class="green" v-if="meal_info.mealType == 2 && meal_info.name && !meal_info.water">@{{ parseFloat(meal_info.intake.fatG).toFixed(2) }}</span></td>
                        <td><span v-if="meal_info.mealType == 2">@{{ parseFloat(meal_info.intake.fatD).toFixed(2) }}</span></td>
                        <td><span class="green" v-if="meal_info.mealType == 2 && meal_info.name && !meal_info.water">@{{ parseFloat(meal_info.intake.carbG).toFixed(2) }}</span></td>
                        <td><span v-if="meal_info.mealType == 2">@{{ parseFloat(meal_info.intake.carbD).toFixed(2) }}</span></td>
                        <td><span v-if="meal_info.mealType == 2 && meal_info.name && !meal_info.water">@{{ parseFloat(meal_info.intake.proteinG).toFixed(2) }}</span></td>
                        <td><span v-if="meal_info.mealType == 2">@{{ parseFloat(meal_info.intake.proteinD).toFixed(2) }}</span></td>
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
                <tbody v-for="(status, i) in mealGraphic" :key="status.time" v-if="status.show">
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
                    <h4 v-show="!editMeal" class="modal-title">Add Meals</h4>
                    <h4 v-show="editMeal" class="modal-title">Edit Meals</h4>
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
                        <li role="presentation" class="" v-show="!editMeal">
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
                                        <label for="activity_list">Choose Meal 44</label>
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

                                        <div class="row">
                                            <div class="col-md-1 p-0">
                                                <table class="firs-table table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="1">&nbsp;</th>
                                                        </tr>
                                                        <tr>
                                                            <th>&nbsp;</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody v-for="(time, i) in mealPopupData" :key="i">
                                                        <tr>
                                                            <th class="parent-time">
                                                                @{{ time.headTime }}
                                                            </th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-md-3 p-0">
                                                <table class="energy-table table table-striped border-green">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="2" class="text-center position-relative">
                                                                Energy Expenditure
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th>Carb</th>
                                                            <th>Fat</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody v-for="(time, i) in mealPopupData" :key="i">
                                                        <tr>
                                                            <td>@{{time.totals.totalCarb}}</td>
                                                            <td>@{{time.totals.totalFat}}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-md-3 p-0">
                                                <table class="energy-table table table-striped border-green">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="2" class="text-center position-relative">
                                                                Intake
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th>Carb</th>
                                                            <th>Fat</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody v-for="(time, i) in mealGraphicPopup" :key="i">
                                                        <tr>
                                                            <td>@{{time.totals.totalCarb}}</td>
                                                            <td>@{{time.totals.totalFat}}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-md-4 p-0">
                                                <table class="last-table table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="2" class="text-center red">Status</th>
                                                        </tr>
                                                        <tr>
                                                            <th>Carb</th>
                                                            <th>Fat</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody v-for="(status, i) in mealStatusPopup" :key="i">
                                                        <tr>
                                                            <td class="bg-dark-p">
                                                                <div>
                                                                    @{{ Math.abs(status.carb) }}
                                                                    <span v-if="status.carb != 0">
                                                                        <span class="green" v-if="status.carb > 0">(loss)</span>
                                                                        <span class="red" v-else>(access)</span>
                                                                    </span>
                                                                </div>
                                                            </td>
                                                            <td class="bg-dark-p">
                                                                <div>
                                                                    @{{ Math.abs(status.fat) }}
                                                                    <span v-if="status.fat != 0">
                                                                        <span class="green" v-if="status.fat > 0">(loss)</span>
                                                                        <span class="red" v-else>(access)</span>
                                                                    </span>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <button v-show="editMeal" type="button" class="btn delete-personal-meal btn-danger waves-effect waves-light m-r-10">
                                            Delete Meal
                                        </button>
                                        <button v-show="!editMeal" type="button" class="btn add-personal-meal btn-success waves-effect waves-light m-r-10">
                                            Save
                                        </button>
                                        <button v-show="editMeal" type="button" class="btn edit-personal-meal btn-success waves-effect waves-light m-r-10">
                                            Edit
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

    <div id="clearAllActivityPopup" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Are you sure you want to clear all Activities?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger clear-all-activity">Yes, clear</button>
                </div>
            </div>
        </div>
    </div>

    <div id="water" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" v-show="!editWater">Add Water</h4>
                    <h4 class="modal-title" v-show="editWater">Edit Water</h4>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-12">
                            <p class="edit-water-error text-danger"></p>
                        </div>
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
                    <button class="btn btn-danger delete-water" v-show="editWater">Delete water</button>
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

    <div id="duplicateActivity" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Duplicate activity</h4>
                </div>
                <div class="modal-body">
                    <div class="copyMeal">&nbsp;</div>
                </div>
                <div class="modal-footer">
                    <button type="button"
                    class="btn btn-success duplicate-activity">Duplicate</button>
                </div>
            </div>
        </div>
    </div>

    

</div>

<div id="alerts" style="position: absolute; bottom: 32%; left: 75%; width: 100%; z-index: 99999; text-align: center;"></div>

<div  id="cont" style="display: none;">
    <div class="report-head">
        <div class="logo-parent"></div>
        <div class="info-parent">
            <div class="name"></div>
            <div class="date-pdf">
                <span class="date-pdf-month"></span> 
                <span class="date-pdf-day"></span>, 
                <span class="date-pdf-year"></span>
            </div>
            <div class="week-day"></div>
        </div>
    </div>
    <div class ="container-pdf">

        <div class="timings">
            <div> <span> 00:00 </span> AM </div>
            <div> 00:30 </div>
            <div> <span> 1:00 </span> AM </div>
            <div> 1:30 </div>
            <div> <span> 2:00 </span> AM </div>
            <div> 2:30 </div>
            <div> <span> 3:00 </span> AM </div>
            <div> 3:30 </div>
            <div> <span> 4:00 </span> AM </div>
            <div> 4:30 </div>
            <div> <span> 5:00 </span> AM </div>
            <div> 5:30 </div>
            <div> <span> 6:00 </span> AM </div>
            <div> 6:30 </div>
            <div> <span> 7:00 </span> AM </div>
            <div> 7:30 </div>
            <div> <span> 8:00 </span> AM </div>
            <div> 8:30 </div>
            <div> <span> 9:00 </span> AM </div>
            <div> 9:30 </div>
            <div> <span> 10:00 </span>AM </div>
            <div> 10:30 </div>
            <div> <span> 11:00 </span>AM </div>
            <div> 11:30 </div>
            <div> <span> 12:00 </span>PM </div>
            <div> 12:30 </div>
            <div> <span> 1:00 </span>PM </div>
            <div> 1:30 </div>
            <div> <span> 2:00 </span>PM </div>
            <div> 2:30 </div>
            <div> <span> 3:00 </span>PM </div>
            <div> 3:30 </div>
            <div> <span> 4:00 </span>PM </div>
            <div> 4:30 </div>
            <div> <span> 5:00 </span>PM </div>
            <div> 5:30 </div>
            <div> <span> 6:00 </span>PM </div>
            <div> 6:30 </div>
            <div> <span> 7:00 </span>PM </div>
            <div> 7:30 </div>
            <div> <span> 8:00 </span>PM </div>
            <div> 8:30 </div>
            <div> <span> 9:00 </span>PM </div>
            <div> 9:30 </div>
            <div> <span> 10:00 </span>PM </div>
            <div> 10:30 </div>
            <div> <span> 11:00 </span>PM </div>
            <div> 11:30 </div>
        </div>

        <div class="days" id="actions-pdf">
        </div>
        <div class="water" id="water-pdf">
        </div>
        <div class="meal" id="meal-pdf">
        </div>

        <div class="timings right-timing">
            <div> <span> 00:00 </span> AM </div>
            <div> 00:30 </div>
            <div> <span> 1:00 </span> AM </div>
            <div> 1:30 </div>
            <div> <span> 2:00 </span> AM </div>
            <div> 2:30 </div>
            <div> <span> 3:00 </span> AM </div>
            <div> 3:30 </div>
            <div> <span> 4:00 </span> AM </div>
            <div> 4:30 </div>
            <div> <span> 5:00 </span> AM </div>
            <div> 5:30 </div>
            <div> <span> 6:00 </span> AM </div>
            <div> 6:30 </div>
            <div> <span> 7:00 </span> AM </div>
            <div> 7:30 </div>
            <div> <span> 8:00 </span> AM </div>
            <div> 8:30 </div>
            <div> <span> 9:00 </span> AM </div>
            <div> 9:30 </div>
            <div> <span> 10:00 </span>AM </div>
            <div> 10:30 </div>
            <div> <span> 11:00 </span>AM </div>
            <div> 11:30 </div>
            <div> <span> 12:00 </span>PM </div>
            <div> 12:30 </div>
            <div> <span> 1:00 </span>PM </div>
            <div> 1:30 </div>
            <div> <span> 2:00 </span>PM </div>
            <div> 2:30 </div>
            <div> <span> 3:00 </span>PM </div>
            <div> 3:30 </div>
            <div> <span> 4:00 </span>PM </div>
            <div> 4:30 </div>
            <div> <span> 5:00 </span>PM </div>
            <div> 5:30 </div>
            <div> <span> 6:00 </span>PM </div>
            <div> 6:30 </div>
            <div> <span> 7:00 </span>PM </div>
            <div> 7:30 </div>
            <div> <span> 8:00 </span>PM </div>
            <div> 8:30 </div>
            <div> <span> 9:00 </span>PM </div>
            <div> 9:30 </div>
            <div> <span> 10:00 </span>PM </div>
            <div> 10:30 </div>
            <div> <span> 11:00 </span>PM </div>
            <div> 11:30 </div>
        
        </div>

    </div>
</div>

@endsection

{{--script in here --}}
@push("footer")
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.20/lodash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script src="{{asset('assets/plugins/clockpicker/dist/jquery-clockpicker.js')}}"></script>
<script src="{{asset('assets/plugins/datepicker-new/js/bootstrap-datepicker.js')}}"></script>


<script !src="">

    let foods = '<?php echo $foods ?>';
    foods = JSON.parse(foods);

    let userInfo = '<?php echo $user ?>';
    userInfo = JSON.parse(userInfo)
    $('.name').html(userInfo.name)


    let row = 0;










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
    // return plus 4 time
    function returnPlus4Time(time) {

        let roundedTime = roundTime(time);
        let start = parseInt(roundedTime.substring(0, 2));
        let startEveryHour = start
        let startsEnd = roundedTime.substring(3);
        start += 4;
        let final = start + ":" + startsEnd;

        console.log('Start time : ', time)
        console.log('Final time : ', final)

        let _finalArr = []
        let concatArr = []
        let doing = false

        // Create concat Array 
        firstLoop:
        for(let i=0; i<days.staticTimes.length; i++) {
            
            let _minutes = days.staticTimes[i].minutes

            for(let j=0; j<_minutes.length; j++) {

                if(_minutes[j].minute == time) {

                    doing = true
                    concatArr.push(_minutes[j])
                    
                }
                
                if(_minutes[j].minute == final) {

                    doing = false
                    concatArr.push(_minutes[j])

                    break firstLoop
                }

                if(doing && _minutes[j].minute != time) {
                    concatArr.push(_minutes[j])
                }

            }
            
        }

        let x = _.chunk(concatArr, 6);
        let ffArr = []

        for(let i=0; i<x.length; i++) {

            if(startEveryHour < 10) {
                startEveryHour = "0" + startEveryHour
            }

            let obj = {
                headTime: startEveryHour + ":" + startsEnd,
                minutes: x[i],
                totals: {
                    totalCarb: null,
                    totalFat: null
                }
            }

            startEveryHour++;

            let _totalCarb = 0,
                _totalFat = 0;

            for(let t=0; t<obj.minutes.length; t++) {
                if(obj.minutes[t].energyExpenditure) {
                    _totalCarb  += parseFloat(obj.minutes[t].energyExpenditure.carbG)
                    _totalFat   += parseFloat(obj.minutes[t].energyExpenditure.fatG)
                }
            }

            obj.totals.totalCarb =  _totalCarb != 0 ? _totalCarb.toFixed(2) : "";
            obj.totals.totalFat =  _totalFat != 0 ? _totalFat.toFixed(2) : "";


            ffArr.push(obj)
            
        }

        console.log('MINUTE = ', ffArr)
        days.setMealPopupData(ffArr)
        setTimeout(() => {
            days.calculateStatusPopup()
        }, 1000);

        return final
    }














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

            let months = ["January","February","March","April","May","June","July","August","September","October","November","December"];
            let weekDay = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"]
            
            let d = new Date(dateShow)
            $('.date-pdf-month').html(months[month-1]);
            $('.date-pdf-day').html(day);
            $('.date-pdf-year').html(date.getFullYear());
            $('.week-day').html(weekDay[d.getDay()])

            days.clearState();
            getActivities();

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



        $('.meal_from').clockpicker({
            autoclose: true,
            placement: 'top',
        }).change(function(){
            let finTime = returnPlus4Time($(this).val())
            let roundedTime = roundTime($(this).val())
            $(this).val(roundedTime)
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

        $('.duplicate-activity').click(function () {

            console.log(finalDatesArr)
            

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
                url: '{{ url('/day/duplicate-activities') }}',
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
                        let err = $.parseJSON(reject.responseText)
                        $('.m_errors').append('<li>' + err.msg + '</li>')
                    }
                    setTimeout(function () {
                        $('.m_errors').empty()
                    }, 10000)
                }
            })

        })

        $('.edit-personal-meal').click(function () {

            let day_meal_id = days.selectedMeal.id, 
                personal_meal_id = days.selectedMeal.personal_meal_id;

            $('.add-personal-meal-form').append(`<input type="hidden" name="day_meal_id" value=${day_meal_id} />`)
            $('.add-personal-meal-form').append(`<input type="hidden" name="personal_meal_id" value=${personal_meal_id} />`)

            var form = $('.add-personal-meal-form');
            $('.meal_date').val($('.date-show').html())

            $.ajax({
                type: "POST",
                url: "/day/edit-meals",
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
                        let err = $.parseJSON(reject.responseText)
                        $('.m_errors').append('<li>' + err.msg + '</li>')
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

        $('.clear-all-activity').click(function() {

            let data = {
                user_id: $('.user_id').val(),
                date: $('.date-show').html()
            };

            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                url: '{{ url('/day/clear-all-activities') }}',
                data: data,
                success: function (res) {
                    $('#clearAllActivityPopup').modal('toggle');
                    days.meal = []

                    getActivities()
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

                },
                error: function (reject) {
                    if (reject.status === 422) {
                        let err = $.parseJSON(reject.responseText)
                        console.log(err.msg)
                        $('.edit-water-error').html(err.msg)
                    }
                    setTimeout(function () {
                        $('.edit-water-error').empty()
                    }, 10000)
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

                },
                error: function (reject) {
                    if (reject.status === 422) {
                        let err = $.parseJSON(reject.responseText)
                        console.log(err.msg)
                        $('.edit-water-error').html(err.msg)
                    }
                    setTimeout(function () {
                        $('.edit-water-error').empty()
                    }, 10000)
                }
            });
        })

        $('.delete-water').click(function() {

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
                url: '{{ url('/day/delete-water') }}',
                data: data,
                success: function (res) {

                    $('#water').modal('toggle');

                    days.actions = []
                    days.meal = []

                    getActivities();

                }
            });

        })

        $('.delete-personal-meal').click(function() {

            let data = {
                id: days.selectedMeal.id,
                personal_meal_id: days.selectedMeal.personal_meal_id
            };

            console.log(days.selectedMeal)
            console.log('data', data)

            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                url: '{{ url('/day/delete-meals') }}',
                data: data,
                success: function (res) {

                    $('#meal').modal('toggle');

                    days.actions = []
                    days.meal = []

                    getActivities();

                }
            });

        })

        $('.exportExcel').click(function() {
            $('#cont').css('display', 'block')
            var pdf = new jsPDF('p', 'pt', 'a4');
            pdf.addHTML(document.getElementById("cont"), function() {

            ps_filename = $('.date-show').html() + '-report';
                pdf.save(ps_filename+'.pdf');
            });
           setTimeout(() => {
            $('#cont').css('display', 'none')
           }, 500);
        })

    });
</script>

<script !src="">
    $(document).ready(function () {
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
            let element = ` <div class="form-group col-md-3 row_${row} food_items">
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


            // mass bug fix later
            $(document).find(".food_items").each(function () {

                if($(this).find('input').val()) {

                    let mass = parseFloat($(this).find("#mass").val());
                    console.log('mass', mass)

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
                    console.log(tr)
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
                    $('#meal').modal('toggle');
                    getActivities();
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

                        id: meals[i].id,
                        personal_meal_id: meals[i].personal_meal_id,
                        get_personal_food: meals[i].get_personal_food,
                        get_meals: meals[i].get_meals,
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
                    days.addWater(waterObj)
                }

                days.createTimeGraphic();
                days.createMealGraphic();
                days.createStatusGraphic();


                //default events given
                const actions = [ 
                ];
                const waterEvents = [
                ]
                const meal = [
                ]

                for(let i=0; i<activities.length; i++) {

                    let startTime = activities[i].from.split(':');
                    let endTime = activities[i].to.split(':');

                    let start = (parseInt(startTime[0]) * 60) + parseInt(startTime[1])
                    let end = (parseInt(endTime[0]) * 60) + parseInt(endTime[1])
                    let name = activities[i].get_activity.name

                    let timeObj = {
                        start, end, name
                    }

                    actions.push(timeObj)
                }

                for(let i=0; i<meals.length; i++) {
                    let startTime = meals[i].from.split(':');
                    let name = meals[i].get_meals.name

                    let start =(parseInt(startTime[0]) * 60) + parseInt(startTime[1])

                    let timeObj = {
                        start, 
                        end: start + 60,
                        name
                    }

                    meal.push(timeObj)
                }
                
                for(let i=0; i<water.length; i++) {
                    console.log('WATER I', water[i])
                    let startTime = water[i].from.split(':');
                    let name = water[i].quantity + ' ml'

                    let start = (parseInt(startTime[0]) * 60) + parseInt(startTime[1])

                    let timeObj = {
                        start,
                        end: start + 60,
                        name
                    }

                    waterEvents.push(timeObj)
                }

                layOutDay(actions, 'actions-pdf');
                layOutDay(waterEvents, 'water-pdf');
                layOutDay(meal, 'meal-pdf');

                console.log('actions 777777777777777777777 = ', actions)
                console.log('water 777777777777777777777 = ', waterEvents)
                console.log('meal 777777777777777777777 = ', meal)

                if(localStorage.getItem('hide-zero-to-eight') == 'true') {
                    days.hideTimeGraphic()
                }

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
                water: [],
                color: 0,

                editWater: false,
                editMeal: false,
                id: 0,
                selectedActivity: [],
                selectedMeal: [],

                energyExpendedMode: false,
                circleCount: 0,

                editActivityPopup: false,
                proteinHourlyLimit: 0,

                mealPopupData: [],
                mealGraphicPopup: [],
                mealStatusPopup: [],
            }
        },
        methods: {
            setMealPopupData(data) {
                this.mealPopupData = []
                this.mealPopupData = data
                setTimeout(() => {
                    console.log('mealPopupData', this.mealPopupData)
                }, 3000);
            },
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
                for(let i=0; i<this.mealGraphic.length; i++) {
                    for(let j=0; j<this.mealGraphic[i].minutes.length; j++) {
                        this.mealGraphic[i].minutes[j].show = false
                    }
                }
            },
            hideTimeGraphic() {
                let times = this.staticTimes,
                    meals = this.mealGraphic;

                for(let k=0; k < 8; k++) {
                    times[k].show ? times[k].show = false : times[k].show = true
                    meals[k].show ? meals[k].show = false : meals[k].show = true
                }
            },
            hideZeroToEight() {
                this.hideTimeGraphic()

                let showHideZero = localStorage.getItem('hide-zero-to-eight');
                
                console.log(showHideZero)
                
                if(showHideZero == null) {
                    localStorage.setItem('hide-zero-to-eight', true)
                } 
                if(showHideZero == 'true') {
                    localStorage.setItem('hide-zero-to-eight', false)
                }else {
                    localStorage.setItem('hide-zero-to-eight', true)
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
                    minuteExpenditure = {}
                    popoverParent = {};

                for(let i=0; i<=23; i++) {

                    let timeObj = {
                        time: i < 10 ? '0' + i + ':00' : i + ':00',
                        minutes: [],
                        activityPopover: [],
                        show: true,
                        totals: {
                            totalCal: null,
                            totalFatC: null,
                            totalFatG: null,
                            totalCarbC: null,
                            totalCarbG: null,
                            totalFatG: null
                        }
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
                                popoverParent = popover 
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

                                    minute.minuteActivityPopover = popoverParent

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

                for(let i=0; i<=23; i++) {

                    let timeObj = {
                        time: i < 10 ? '0' + i + ':00' : i + ':00',
                        minutes: [],
                        mealPopover: [],
                        show: true,
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
                                    minute.id = this.meal[k].id
                                    minute.personal_meal_id = this.meal[k].personal_meal_id
                                    minute.get_personal_food = this.meal[k].get_personal_food
                                    minute.get_meals = this.meal[k].get_meals

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

                                    // console.log('x', x)
                                    // console.log('minute intake=',minuteIntake )

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
            createMealPopupGraphic(mealObj) {
                
                console.log(' meal graphic draw started .... ')
                console.log('obj =', mealObj)

                let fArr = []
                for(let i=0; i<5; i++) {
                    let obj = {
                        minutes: [],
                        totals: {
                            totalCarb: null,
                            totalFat: null
                        }
                    }
                    for(let j=0; j<6; j++) {

                        let carbs = mealObj.carbG,
                            load = mealObj.glycemicLoad,
                            carbD = this.carbDigestFormula(carbs, load),
                            fatD = ((mealObj.fatG / 4) / 6).toFixed(2);

                        let intake = {
                            carb: carbD,
                            fat:  fatD
                        }

                        let minuteObj = {
                            intake: intake
                        }

                        obj.minutes.push(minuteObj)
                    }

                    let _totalCarb = 0,
                        _totalFat = 0;

                    for(let t=0; t<obj.minutes.length; t++) {
                        // if(obj.minutes[t].intake) {
                            _totalCarb  += parseFloat(obj.minutes[t].intake.carb)
                            _totalFat   += parseFloat(obj.minutes[t].intake.fat)
                        // }
                    }

                    obj.totals.totalCarb =  _totalCarb != 0 ? _totalCarb.toFixed(2) : "";
                    obj.totals.totalFat =  _totalFat != 0 ? _totalFat.toFixed(2) : "";


                    fArr.push(obj)
                }
                this.mealGraphicPopup = fArr
                console.log('final final final', fArr)
            },

            // calculateStatus(fatGr, carbGr) {
            //     var fatStatus = fatGr - 0;
            //     var fatStatusText = fatStatus > 0 ? "loss" : "access";
            //     fatStatus = Math.abs(fatStatus);

            //     var carbStatus = carbGr - 0;
            //     var carbStatusText = carbStatus > 0 ? "loss" : "access";
            //     carbStatus = Math.abs(carbStatus);

            //     return {
            //         'carbStatus': carbStatus,
            //         'carbStatusText': carbStatusText,
            //         'fatStatusText': fatStatusText,
            //         'fatStatus': fatStatus
            //     }
            // },

            calculateStatusPopup() {
                console.log('Calculate popup status ...');
                this.mealStatusPopup = []

                let fatExpenditure = 0,
                    fatIntake = 0,
                    carbExpenditure = 0,
                    carbIntake = 0,
                    fatStatus = 0,
                    carbStatus = 0;

                for(let i=0; i<this.mealPopupData.length; i++) {
                    // console.log('1= ', this.mealPopupData[i].totals)
                   
                    if(this.mealPopupData[i]) {
                        fatExpenditure =  this.mealPopupData[i].totals.totalFat
                        carbExpenditure = this.mealPopupData[i].totals.totalCarb
                    }

                    if(this.mealGraphicPopup[i]) {
                        // console.log('2= ', this.mealGraphicPopup[i].totals)
                        fatIntake = this.mealGraphicPopup[i].totals.totalFat
                        carbIntake = this.mealGraphicPopup[i].totals.totalCarb
                    }

                    fatStatus = fatExpenditure - fatIntake
                    carbStatus = carbExpenditure - carbIntake

                    let statusObj = {
                        fat: parseFloat(fatStatus.toFixed(2)),
                        carb: parseFloat(carbStatus.toFixed(2))
                    }
                    
                    this.mealStatusPopup.push(statusObj)

                }
            },
            addActivity(activityObj){
                this.actions.push(activityObj)
            },
            addMeals(mealObj){
                this.meal.push(mealObj);
            },
            addWater(waterObj) {
                this.water.push(waterObj);
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
                console.log('activity', activity)
            },
            openHoveredAddActivity(activity) {
                $('.activity_from').clockpicker({
                    autoclose: true,
                    placement: 'bottom',
                }).val(activity.minute);
            },
            openEditMealPopup(meal) {
                this.editMeal = true
                this.selectedMeal = meal 
                console.log('Meal : ', meal)
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
                console.log('Actions', this.actions)
                console.log('Water', this.water)
                console.log('meals', this.meal)
            }, 3000);
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
         // detect when meal popup closed
         $('#meal').on('hidden.bs.modal', function () {
            days.editMeal = false
        });

        let foods = '<?php echo $foods ?>';
        foods = JSON.parse(foods);
        let row = 0;

        function mealListOnChange(id) {
            $.ajax({
                type: "POST",
                url: "/day/get-meal-ajax",
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                data: {id},
                success: function (data) {
                    
                    console.log('changed meal data ===== : ', data)

                    $('#m_total_mass').val(roundNumberDecimal(data.mass));
                    $('#m_total_carbs').val(roundNumberDecimal(data.carbs));
                    $('#m_total_fat').val(roundNumberDecimal(data.fat));
                    $('#m_total_proteins').val(roundNumberDecimal(data.proteins));
                    $('#m_total_calories').val(roundNumberDecimal(data.calories));
                    $('#m_total_ph').val(roundNumberDecimal(data.ph));
                    $('#m_total_glycemic_load').val(roundNumberDecimal(data.glycemic_load));
                    
                    let mealObj = {
                        glycemicLoad: data.glycemic_load,
                        carbG: data.carbs,
                        fatG: data.fat
                    }
          
                    days.createMealPopupGraphic(mealObj)
                    days.calculateStatusPopup()

                    var m_pl = `    <button type="button" class="btn btn-success col-md-2 m-b-20 m_plus" style=" height: 50px;width: 50px;">
                                        <i class="fa fa-plus" style="font-size: 25px;"></i>
                                    </button>`
                    $('.m_foods').empty();
                    $('.m_foods').append(m_pl);

                    for (var i = 0; i < data.attached_foods.length; i++) {
                        var opt = "";
                        for (var j = 0; j < foods.length; j++) {
                            console.log('foods', foods)
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
        }

        $('#meal_list').change(function () {
            var id = $(this).val();
            mealListOnChange(id)
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
            let element = `<div class="form-group row_${row} m_food_items col-md-1">
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

                    // var tr = calculateCarbDigestion(total_glycemic_load, total_carbs, total_fat);
                    // $('#meal_carb_fat').html(tr);

                    let mealObj = {
                        glycemicLoad: total_glycemic_load,
                        carbG: total_carbs,
                        fatG: total_fat
                    }

                    console.log('HHHHHHHHHHHHHHHH', mealObj)
          
                    days.createMealPopupGraphic(mealObj)
                    days.calculateStatusPopup()
                }
            });
        }

        $(document).on("click", ".edit-activity", function () {

            days.editActivityPopup = true

            let from = days.selectedActivity.start
            let to =   days.selectedActivity.end
            let id = days.selectedActivity.activity_id

            console.log(from, to, id)

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



        // edit meal
        $(document).on("click", ".edit-meal", function () {
            console.log('edit-meal', days.selectedMeal)

            let res_meals = JSON.parse('<?php echo json_encode($meals); ?>');
            let item = days.selectedMeal.name
            let id = res_meals.filter(obj => obj.name == item)
            $("#meal_list").val( id[0].id );

            $('.meal_from').clockpicker({
                autoclose: true,
                placement: 'bottom',
            }).val(days.selectedMeal.minute);

            let finTime = returnPlus4Time(days.selectedMeal.minute)


            let getMeals = days.selectedMeal.get_meals

            $('#m_total_mass').val(roundNumberDecimal(getMeals.mass));
            $('#m_total_carbs').val(roundNumberDecimal(getMeals.carbs));
            $('#m_total_fat').val(roundNumberDecimal(getMeals.fat));
            $('#m_total_proteins').val(roundNumberDecimal(getMeals.proteins));
            $('#m_total_calories').val(roundNumberDecimal(getMeals.calories));
            $('#m_total_ph').val(roundNumberDecimal(getMeals.ph));
            $('#m_total_glycemic_load').val(roundNumberDecimal(getMeals.glycemic_load));


            let mealObj = {
                glycemicLoad: getMeals.glycemic_load,
                carbG: getMeals.carbs,
                fatG: getMeals.fat
            }
    
            days.createMealPopupGraphic(mealObj)
            days.calculateStatusPopup()

            var m_pl = `<button type="button" class="btn btn-success col-md-2 m-b-20 m_plus" style=" height: 50px;width: 50px;">
                            <i class="fa fa-plus" style="font-size: 25px;"></i>
                        </button>`
            $('.m_foods').empty();
            $('.m_foods').append(m_pl);


            let personalFood = days.selectedMeal.get_personal_food

            for (var i = 0; i < personalFood.length; i++) {
                var opt = "";
                for (var j = 0; j < foods.length; j++) {
                    var sel = "";

                    if (foods[j].id == personalFood[i].food_id) {
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
                                <input type="number" name="mass[]" class="m_mass form-control m-b-20" placeholder="Mass" value="${personalFood[i].mass}" required>
                                <button type="button" class="btn btn-danger col-md-12 m-b-20 m_minus" data-row="${i}"><i class="fa fa-minus"></i></button>
                            </div>`
                $('.m_foods').prepend(elem);
                row++;
            }

        });

    })
</script>

<script>
    const containerHeight  = 1100;
    const containerWidth = 195;
    const minutesinDay = 60 * 24;

    let collisions = [];
    let width = [];
    let leftOffSet = [];

    // append one event to calendar
    var createEvent = (height, top, left, units, parentId, name) => {

        let node = document.createElement("DIV");
        

        if(parentId == 'actions-pdf') {
            node.className = "event green-event";
            node.innerHTML = "<span class='title'> " + name + " </span>";
        }
        if(parentId == 'water-pdf') {
            node.className = "event blue-event";
            node.innerHTML = "<span class='title'>" + name + "</span>";
        }
        if(parentId == 'meal-pdf') {
            node.className = "event red-event";
            node.innerHTML = "<span class='title'>" + name + "</span>";
        }


        // Customized CSS to position each event
        node.style.width = (containerWidth/units) + "px";
        node.style.height = height + "px";
        node.style.top = top + "px";
        // node.style.left = 100 + left + "px";

        document.getElementById(parentId).appendChild(node);
    }

    /* 
    collisions is an array that tells you which events are in each 30 min slot
    - each first level of array corresponds to a 30 minute slot on the calendar 
    - [[0 - 30mins], [ 30 - 60mins], ...]
    - next level of array tells you which event is present and the horizontal order
    - [0,0,1,2] 
    ==> event 1 is not present, event 2 is not present, event 3 is at order 1, event 4 is at order 2
    */

    function getCollisions (events) {

        //resets storage
        collisions = [];

        for (var i = 0; i < 24; i ++) {
            var time = [];
            for (var j = 0; j < events.length; j++) {
            time.push(0);
            }
            collisions.push(time);
        }

        events.forEach((event, id) => {
            let end = event.end;
            let start = event.start;
            let order = 1;

            while (start < end) {
            timeIndex = Math.floor(start/30);

            while (order < events.length) {
                if (collisions[timeIndex].indexOf(order) === -1) {
                break;
                }
                order ++;
            }

            collisions[timeIndex][id] = order;
            start = start + 30;
            }

            collisions[Math.floor((end-1)/30)][id] = order;
        });
    };

    /*
    find width and horizontal position

    width - number of units to divide container width by
    horizontal position - pixel offset from left
    */
    function getAttributes (events) {
        //resets storage
        width = [];
        leftOffSet = [];

        for (var i = 0; i < events.length; i++) {
            width.push(0);
            leftOffSet.push(0);
        }

        collisions.forEach((period) => {

            // number of events in that period
            let count = period.reduce((a,b) => {
                return b ? a + 1 : a;
            })

            if (count > 1) {
                period.forEach((event, id) => {
                    // max number of events it is sharing a time period with determines width
                    if (period[id]) {
                        if (count > width[id]) {
                            width[id] = count;
                        }
                    }

                    if (period[id] && !leftOffSet[id]) {
                    leftOffSet[id] = period[id];
                    }
                })
            }
        });
    };

    var layOutDay = (events, parentId) => {

        // clear any existing nodes
        var myNode = document.getElementById(parentId);
        myNode.innerHTML = '';

        // getCollisions(events);
        getAttributes(events);

        events.forEach((event, id) => {
            event.start += 9.5
            let name = event.name
            let height = (event.end - event.start) / minutesinDay * containerHeight;
            console.log(event.end, event.start, minutesinDay, containerHeight)
            let top = event.start / minutesinDay * containerHeight; 
            let end = event.end;
            let start = event.start;
            let units = width[id];
            if (!units) {units = 1};
            let left = (containerWidth / width[id]) * (leftOffSet[id] - 1) + 10;
            if (!left || left < 0) {left = 10};

            createEvent(height+9.5, top, left, units, parentId, name);
        });
    }
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

    .hoverBox:hover {
        cursor: pointer;
        border: 1px solid green;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .hoverBox i {
        display: none;
        color: green;
    }
    .hoverBox:hover i {
        display: block;
    }

</style>

@endpush
