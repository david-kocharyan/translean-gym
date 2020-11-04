@extends('layouts.app')

@section('content')
    @include('admin.users.tab')

    <div class="row">
        <div class="col-md-10 text-left">
            <button class="btn btn-success m-b-30 assessment" data-toggle="modal" data-target="#largeModal">New
                Assessments
            </button>
            <button class="btn btn-success m-b-30 projection" data-toggle="modal" data-target="#largeModal">Add
                Projection
            </button>
        </div>
        <div class="col-md-2 text-center summ">
            <span> Summary All</span>
            <label class="switch">
                <input type="checkbox" class="summary">
                <span class="slider round"></span>
            </label>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                {{--table--}}
                <div class="table-responsive">
                    <table id="datatable" class="display table table-hover table-striped nowrap" cellspacing="0"
                           width="100%">
                        <thead>
                        <tr>
                            <th>Activity Level</th>
                            <th>Date</th>
                            <th>Weight (kg) <i class="fas fa-chart-bar weight m-l-10" data-toggle="modal"
                                               data-target="#graffModal"></i></th>
                            <th>Total Fat (%) <i class="fas fa-chart-bar fat m-l-10" data-toggle="modal"
                                                 data-target="#graffModal"></i></th>
                            <th>Metabolic Age <i class="fas fa-chart-bar age m-l-10" data-toggle="modal"
                                                 data-target="#graffModal"></i></th>
                            <th>Visceral Fat (rating) <i class="fas fa-chart-bar visceral m-l-10" data-toggle="modal"
                                                         data-target="#graffModal"></i></th>
                            <th>Muscle Mass (kg) <i class="fas fa-chart-bar muscle m-l-10" data-toggle="modal"
                                                    data-target="#graffModal"></i></th>
                            <th>Lean Mass (kg) <i class="fas fa-chart-bar lean m-l-10" data-toggle="modal"
                                                  data-target="#graffModal"></i></th>
                            <th>Assessments Type</th>
                            <th>Options</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($assessments as $key=>$val)
                            <tr>
                                <td>{{$val->activity_level}}</td>
                                <td>{{$val->date}}</td>
                                <td>{{$val->weight}}</td>
                                <td>{{$val->total_fat}}</td>
                                <td>{{$val->metabolic_age}}</td>
                                <td>{{$val->visceral_fat}}</td>
                                <td>{{$val->muscle_mass}}</td>
                                <td>{{$val->lean_mass}}</td>
                                <td class="ass_type" data-type="{{$val->type}}">
                                    @if($val->type == 0 AND $key == 0)
                                        First Assessment
                                    @elseif($val->type == 2)
                                        Projection
                                    @elseif($val->type == 1)
                                        Current Assessment
                                    @else

                                    @endif
                                </td>
                                <td></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    {{--    assessment and projection modal --}}
    <div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                <div class="modal-body">

                    <input type="hidden" class="type" name="type">
                    <input type="hidden" class="id" name="id" value="{{$user->id}}">


                    <div class="row form-inline">
                        <div class="col-md-6">
                            <div class="form-group col-md-12 m-b-20">
                                <label>User Height (cm)</label>
                                <input type="text" class="form-control" disabled value="{{$user->height}}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group col-md-12 m-b-20">
                                <label>User Age</label>
                                <input type="text" class="form-control" disabled
                                       value="{{\Carbon\Carbon::parse($user->dob)->age}}">
                            </div>
                        </div>
                    </div>
                    <hr>

                    <div class="row form-inline">
                        <div class="col-md-6">
                            <div class="form-group col-md-12 m-b-20">
                                <label>Activity Level</label>
                                <select class="form-control" name="activity_level">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group col-md-12 m-b-20">
                                <label>Date</label>
                                <input type="date" class="form-control" name="date" required>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="row form-inline">
                        <div class="col-md-6">
                            <div class="form-group col-md-12 m-b-20">
                                <label>Weight (kg)</label>
                                <input type="number" class="form-control" name="weight" required>
                            </div>

                            <div class="form-group col-md-12 m-b-20">
                                <label>Total Fat (%)</label>
                                <input type="number" class="form-control" name="total_fat" required>
                            </div>

                            <div class="form-group col-md-12 m-b-20">
                                <label>Right Arm (%)</label>
                                <input type="number" class="form-control" name="right_arm" required>
                            </div>

                            <div class="form-group col-md-12 m-b-20">
                                <label>Left Arm (%)</label>
                                <input type="number" class="form-control" name="left_arm" required>
                            </div>

                            <div class="form-group col-md-12 m-b-20">
                                <label>Right Leg (%)</label>
                                <input type="number" class="form-control" name="right_leg" required>
                            </div>

                            <div class="form-group col-md-12 m-b-20">
                                <label>Left Leg (%)</label>
                                <input type="number" class="form-control" name="left_leg" required>
                            </div>

                            <div class="form-group col-md-12 m-b-20">
                                <label>Trunk (%)</label>
                                <input type="number" class="form-control" name="trunk" required>
                            </div>
                        </div>
                        {{--right--}}
                        <div class="col-md-6">
                            <div class="form-group col-md-12 m-b-20">
                                <label>Muscle Mass (kg)</label>
                                <input type="number" class="form-control" name="muscle_mass" required>
                            </div>

                            <div class="form-group col-md-12 m-b-20">
                                <label>Right Arm Mass (kg)</label>
                                <input type="number" class="form-control" name="right_arm_mass" required>
                            </div>

                            <div class="form-group col-md-12 m-b-20">
                                <label>Left Arm Mass (kg)</label>
                                <input type="number" class="form-control" name="left_arm_mass" required>
                            </div>

                            <div class="form-group col-md-12 m-b-20">
                                <label>Right Leg Mass (kg)</label>
                                <input type="number" class="form-control" name="right_leg_mass" required>
                            </div>

                            <div class="form-group col-md-12 m-b-20">
                                <label>Left Leg Mass (kg)</label>
                                <input type="number" class="form-control" name="left_leg_mass" required>
                            </div>

                            <div class="form-group col-md-12 m-b-20">
                                <label>Trunk Mass (kg)</label>
                                <input type="number" class="form-control" name="trunk_mass" required>
                            </div>

                            <div class="form-group col-md-12 m-b-20">
                                <label>Lean Mass (kg)</label>
                                <input type="number" class="form-control" name="lean_mass" disabled required>
                            </div>

                        </div>
                    </div>

                    <hr>
                    <div class="row form-inline">
                        <div class="col-md-6">
                            <div class="form-group col-md-12 m-b-20">
                                <label>Bone Mass (kg)</label>
                                <input type="number" class="form-control" name="bone_mass" required>
                            </div>
                            <div class="form-group col-md-12 m-b-20">
                                <label>Metabolic age</label>
                                <input type="number" class="form-control" name="metabolic_age" required>
                            </div>
                        </div>

                        <div class="col-md-6 down">
                            <div class="form-group col-md-12 m-b-20">
                                <label>Body Water (%)</label>
                                <input type="number" class="form-control" name="body_water" required>
                            </div>
                            <div class="form-group col-md-12 m-b-20">
                                <label>Visceral Fat (rating)</label>
                                <input type="number" class="form-control" name="visceral_fat" required>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary save_modal">Save</button>
                </div>
            </div>
        </div>
    </div>

    {{--    grafics modal--}}
    <div class="modal fade" id="graffModal" tabindex="-1" role="dialog" aria-labelledby="graffModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title-graff" id="myModalLabel"></h4>
                </div>
                <div class="modal-body">
                    <div class="chart-container body-graff" style="position: relative; height:500px; width:850px">
                        <canvas id="myChart" width="400" height="400"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('footer')
    <script src="{{asset('assets/plugins/swal/sweetalert.min.js')}}"></script>
    <script src="{{asset('assets/plugins/chart.js/Chart.min.js')}}"></script>
    <script !src="">
        var res = JSON.parse('<?php echo json_encode($assessments); ?>');

        $('#datatable').DataTable({
            dom: "Bfrtip",
            bSort: false,
            data: res,
            createdRow: function (row, data, dataIndex) {
                $(row).attr('data-type', data.type);
            },
            columns: [
                {data: 'activity_level'},
                {data: 'date'},
                {data: 'weight'},
                {data: 'total_fat'},
                {data: 'metabolic_age'},
                {data: 'visceral_fat'},
                {data: 'muscle_mass'},
                {data: 'lean_mass'},
                {
                    data: 'type',
                    render: function (data, type, row, meta) {
                        var t = "";
                        if (data == 0 && meta.row == 0)
                            t = 'First Assessment'
                        else if (data == 2)
                            t = 'Projection'
                        else if (data == 1) {
                            t = 'Current Assessment'
                        } else {
                            t = ""
                        }
                        return `${t}`
                    }
                },
                {
                    data: 'id',
                    render: function (data) {
                        return `        <a href="/assessments/show/${data}" class="btn btn-success btn-circle ">
                                             <i class="fas fa-eye"></i>
                                        </a>

                                        <a href="/assessments/edit/${data}" class="btn btn-info btn-circle edit">
                                             <i class="fas fa-edit"></i>
                                        </a>

                                        <a href="#" class="btn btn-danger btn-circle delete" data-id='${data}'>
                                            <i class="fas fa-trash"></i>
                                        </a>`
                    },
                }
            ],
        });

        $(document).on('click', '.delete', function () {
            let id = $(this).data('id');
            swal({
                title: "Are You Sure?",
                icon: "warning",
                dangerMode: true,
                buttons: ['No', 'Yes'],
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: 'POST',
                        url: '/deleteAssessment',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {id},
                        success: function (data) {
                            location.reload();
                        },
                    });
                } else {
                    swal.close();
                }
            });
        })
    </script>

    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.assessment').click(function () {
                $('.modal-title').html('Assessment');
                $('.type').val(1);
                $('.form-control').removeClass('error');
                $('.glycogen_store').remove();
            });

            $('.projection').click(function () {
                $('.modal-title').html('Projection');
                $('.type').val(2);
                $('.form-control').removeClass('error');
                $('.down').append(`<div class="form-group col-md-12 m-b-20 glycogen_store">
                                        <label>Glycogen Store (gr)</label>
                                        <input type="number" class="form-control" name="glycogen_store" disabled>
                                    </div>`)
            });

            $('input[name=bone_mass]').on('input', function () {
                let bone_mass = parseFloat($(this).val());
                let muscle_mass = parseFloat($('input[name=muscle_mass]').val());
                $('input[name=lean_mass]').val(bone_mass + muscle_mass)
            });

            $('input[name=muscle_mass]').on('input', function () {
                let bone_mass = parseFloat($('input[name=bone_mass]').val());
                let muscle_mass = parseFloat($(this).val());
                $('input[name=lean_mass]').val(bone_mass + muscle_mass)
            });

            $('input[name=weight]').on('input', function () {
                let weight = parseFloat($(this).val());
                $('input[name=glycogen_store]').val(weight * 5.6)
            });

            $('tr').each(function (index, item) {
                if ($(item).data('type') === 2) {
                    $('.projection').attr('disabled', true);
                    return false;
                }
            });

            $(".save_modal").click(function (e) {
                $('.form-control').removeClass('error');
                let id = $("input[name=id]").val();
                let data = {};
                data = {
                    'id': id,
                    'activity_level': $('select[name=activity_level] option').filter(':selected').val(),
                    'date': $("input[name=date]").val(),
                    'weight': $("input[name=weight]").val(),
                    'total_fat': $("input[name=total_fat]").val(),
                    'right_arm': $("input[name=right_arm]").val(),
                    'left_arm': $("input[name=left_arm]").val(),
                    'right_leg': $("input[name=right_leg]").val(),
                    'left_leg': $("input[name=left_leg]").val(),
                    'trunk': $("input[name=trunk]").val(),
                    'muscle_mass': $("input[name=muscle_mass]").val(),
                    'right_arm_mass': $("input[name=right_arm_mass]").val(),
                    'left_arm_mass': $("input[name=left_arm_mass]").val(),
                    'right_leg_mass': $("input[name=right_leg_mass]").val(),
                    'left_leg_mass': $("input[name=left_leg_mass]").val(),
                    'trunk_mass': $("input[name=trunk_mass]").val(),
                    'bone_mass': $("input[name=bone_mass]").val(),
                    'metabolic_age': $("input[name=metabolic_age]").val(),
                    'body_water': $("input[name=body_water]").val(),
                    'visceral_fat': $("input[name=visceral_fat]").val(),
                    'lean_mass': $("input[name=lean_mass]").val(),
                    'glycogen_store': $("input[name=glycogen_store]").val(),
                    'type': $("input[name=type]").val()
                };

                let validate = true;
                for (let i in data) {
                    if (data[i] === '' || data[i] === null) {
                        $(`input[name=${i}]`).addClass("error")
                        validate = false;
                    }
                }
                if (validate == false) return;

                $.ajax({
                    type: 'POST',
                    url: '/assessments/' + id,
                    data: data,
                    success: function (data) {
                        location.reload();
                    }
                });
            });

            $('.summary').change(function () {
                if ($(this).is(":checked")) {
                    let id = $("input[name=id]").val();
                    $.ajax({
                        type: 'POST',
                        url: '/summary/assessments',
                        data: {id: id},
                        success: function (res) {
                            $('#datatable').DataTable().clear();
                            $('#datatable').DataTable().rows.add(res).draw();
                        }
                    });
                } else {
                    location.reload()
                }
            });

            $(document).on('change', '.form-control', function () {
                if ($(this).val() != "") {
                    $(this).removeClass('error')
                } else {
                    $(this).addClass('error')
                }
            })
        })
    </script>

    {{--grafics --}}
    <script !src="">

        $('.weight').click(function () {
            $('.modal-title-graff').html('Weight');
            $('.body-graff').empty();
            $('.body-graff').append(`<canvas id="myChart" width="400" height="400"></canvas>`);
            chartCreate('weight');
        });

        $('.fat').click(function () {
            $('.modal-title-graff').html('Total Fat');
            $('.body-graff').empty();
            $('.body-graff').append(`<canvas id="myChart" width="400" height="400"></canvas>`);
            chartCreate('total_fat');
        });

        $('.age').click(function () {
            $('.modal-title-graff').html('Metabolic Age');
            $('.body-graff').empty();
            $('.body-graff').append(`<canvas id="myChart" width="400" height="400"></canvas>`);
            chartCreate('age');
        });

        $('.visceral').click(function () {
            $('.modal-title-graff').html('Visceral Fat');
            $('.body-graff').empty();
            $('.body-graff').append(`<canvas id="myChart" width="400" height="400"></canvas>`);
            chartCreate('visceral_fat');
        });

        $('.muscle').click(function () {
            $('.modal-title-graff').html('Muscle Mass');
            $('.body-graff').empty();
            $('.body-graff').append(`<canvas id="myChart" width="400" height="400"></canvas>`);
            chartCreate('muscle');
        });

        $('.lean').click(function () {
            $('.modal-title-graff').html('Lean Mass');
            $('.body-graff').empty();
            $('.body-graff').append(`<canvas id="myChart" width="400" height="400"></canvas>`);
            chartCreate('lean');
        });

        function chartCreate(type) {
            let id = $("input[name=id]").val();

            $.ajax({
                type: 'POST',
                url: '/getAssessment',
                data: {id: id},
                success: function (res) {
                    let labels = [""];
                    let data = [];
                    let projection_data = [];
                    console.log(res)

                    for (let i = 0; i < res.length; i++) {
                        labels.push(res[i].date);
                        if (type === 'weight' && res[i].type != 2) {
                            data.push(res[i].weight);
                        } else if (type === 'total_fat' && res[i].type != 2) {
                            data.push(res[i].total_fat);
                        } else if (type === 'age' && res[i].type != 2) {
                            data.push(res[i].metabolic_age);
                        } else if (type === 'visceral_fat' && res[i].type != 2) {
                            data.push(res[i].visceral_fat);
                        } else if (type === 'muscle' && res[i].type != 2) {
                            data.push(res[i].muscle_mass);
                        } else if (type === 'lean' && res[i].type != 2) {
                            data.push(res[i].lean_mass);
                        }

                        for (var j = 0; j < 6; j++) {
                            if (type === 'weight' && res[i].type == 2) {
                                projection_data.push(res[i].weight);
                            } else if (type === 'total_fat' && res[i].type == 2) {
                                projection_data.push(res[i].total_fat);
                            } else if (type === 'age' && res[i].type == 2) {
                                projection_data.push(res[i].metabolic_age);
                            } else if (type === 'visceral_fat' && res[i].type == 2) {
                                projection_data.push(res[i].visceral_fat);
                            } else if (type === 'muscle' && res[i].type == 2) {
                                projection_data.push(res[i].muscle_mass);
                            } else if (type === 'lean' && res[i].type == 2) {
                                projection_data.push(res[i].lean_mass);
                            }
                        }

                    }

                    new Chart(document.getElementById("myChart"),
                        {
                            "type": "line",
                            "data": {
                                "labels": labels,
                                "datasets": [{
                                    "data": data,
                                    "fill": true,
                                    "borderColor": '#3b8e34',
                                    "backgroundColor": '#e5e5e57d',
                                    "lineTension": 0.01,
                                },
                                    {
                                        data: projection_data,
                                        "fill": false,
                                        "borderColor": '#8e5804',
                                        "lineTension": 0.01,
                                    }
                                ],
                                annotation: {
                                    annotations: [{
                                        type: 'line',
                                        mode: 'horizontal',
                                        scaleID: 'y-axis-0',
                                        value: 30,
                                        borderColor: 'rgb(75, 192, 192)',
                                        borderWidth: 4,
                                        label: {
                                            enabled: true,
                                            content: 'Test label'
                                        }
                                    }]
                                }
                            },
                            options: {scales: {
                                    yAxes: [{
                                        ticks: {
                                            beginAtZero: true
                                        }
                                    }]
                                },
                                legend: {
                                    display: false
                                },
                                tooltips: {
                                    callbacks: {
                                        label: function (tooltipItem) {
                                            return tooltipItem.yLabel;
                                        }
                                    }
                                },
                                maintainAspectRatio: false,
                            }
                        });
                }
            });
        }
    </script>
@endpush

@push('header')
    <style>
        .modal label {
            width: 40%;
        }

        th i {
            color: #fb9905;
        }

        th i:hover {
            cursor: pointer;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            display: none;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #3b8e34;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #3b8e34;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

        .summ {
            display: flex;
            justify-content: space-evenly;
            align-items: center;
            color: #3b8e34;
            font-weight: bold;
            font-size: 20px;
            padding: 5px;
        }

        .error {
            border: 1px solid red;
        }
    </style>
@endpush


