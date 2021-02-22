@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-heading">{{$action." ".$title}}</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        <form method="post" action="{{ $route }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="name">Name</label>
                                @error('name')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="text" class="form-control" id="name"
                                       placeholder="Name" name="name" value="{{old('name')}}">
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="total_mass">Total Mass</label>
                                    <input type="number" class="form-control" id="total_mass" placeholder="Total Mass"
                                           name="total_mass" readonly required>
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="total_carbs">Total Carbs</label>
                                    <input type="number" class="form-control" id="total_carbs" placeholder="Total Carbs"
                                           name="total_carbs" readonly required>
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="total_fat">Total Fat</label>
                                    <input type="number" class="form-control" id="total_fat" placeholder="Total Fat"
                                           name="total_fat" readonly required>
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="total_proteins">Total Proteins</label>
                                    <input type="number" class="form-control" id="total_proteins"
                                           placeholder="Total Proteins" name="total_proteins" readonly required>
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="total_calories">Total Calories</label>
                                    <input type="number" class="form-control" id="total_calories"
                                           placeholder="Total Calories" name="total_calories" readonly required>
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="total_ph">Total PH</label>
                                    <input type="number" class="form-control" id="total_ph" placeholder="Total PH"
                                           name="total_ph" readonly required>
                                </div>
                                
                                 <div class="form-group col-md-2">
                                    <label for="total_ph">Total Fiber</label>
                                    <input type="number" class="form-control" id="total_fiber" placeholder="Total Fiber"
                                           name="total_fiber" readonly required>
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
                                        <button type="button" class="btn btn-success col-md-2 m-b-20 plus"><i
                                                class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">
                                        Save {{$title}}
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('header')
    <style>
        .plus {
            height: 200px;
            width: 200px;
        }

        .plus i {
            font-size: 100px;
        }
    </style>
@endpush

@push('footer')
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
                                <div class="form-group col-md-2 row_${row} food_items">
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
                let total_fiber = 0;

                // other variable
                var ph_sum = 0;
                var ph_d = 0;
                var gl_sum = 0;
                var gl_d = 0;


                $(document).find(".food_items").each(function () {

                    let mass = parseFloat($(this).find("#mass").val());
                    food_mass = parseFloat($(this).find("#food_sel").find(":selected").data('quantity_measure'));

                    total_mass += parseFloat($(this).find("#mass").val());
                    total_carbs += parseFloat($(this).find("#food_sel").find(":selected").data('carbs'))/food_mass*mass;
                    total_fat += parseFloat($(this).find("#food_sel").find(":selected").data('fat'))/food_mass*mass;
                    total_proteins += parseFloat($(this).find("#food_sel").find(":selected").data('proteins'))/food_mass*mass;
                    total_calories += parseFloat($(this).find("#food_sel").find(":selected").data('calories'))/food_mass*mass;
                    total_fiber += parseFloat($(this).find("#food_sel").find(":selected").data('fiber'))/food_mass*mass;

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
                    $('#total_fiber').val(total_fiber);
                });
            }

        })
    </script>
@endpush
