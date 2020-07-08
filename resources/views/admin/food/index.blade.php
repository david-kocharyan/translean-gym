@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 text-right">
            <a href="{{$route."/create"}}" class="btn btn-success m-b-30"><i class="fas fa-plus"></i> Add {{$title}}</a>
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
                            <th>Id</th>
                            <th>Name</th>
                            <th>Quantity Measure</th>
                            <th>Carbs</th>
                            <th>Fat</th>
                            <th>Proteins</th>
                            <th>Calories</th>
                            <th>Fiber</th>
                            <th>Glycemic Index</th>
                            <th>Glycemic Load</th>
                            <th>PH</th>
                            <th>Options</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($data as $key=>$val)
                            <tr>
                                <td>{{$key + 1}}</td>
                                <td>{{$val->name}}</td>
                                <td>{{$val->quantity_measure}}</td>
                                <td>{{$val->carbs}}</td>
                                <td>{{$val->fat}}</td>
                                <td>{{$val->proteins}}</td>
                                <td>{{$val->calories}}</td>
                                <td>{{$val->fiber}}</td>
                                <td>{{$val->glycemic_index}}</td>
                                <td>{{$val->glycemic_load}}</td>
                                <td>{{$val->ph}}</td>
                                <td>
                                    <a href="{{$route."/".$val->id."/edit"}}" data-toggle="tooltip"
                                       data-placement="top" title="Edit" class="btn btn-info btn-circle tooltip-info">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form style="display: inline-block" action="{{ $route."/".$val->id }}"
                                          method="post" id="work-for-form">
                                        @csrf
                                        @method("DELETE")
                                        <a href="javascript:void(0);" data-text="{{ $title }}" class="delForm"
                                           data-id="{{$val->id}}">
                                            <button data-toggle="tooltip"
                                                    data-placement="top" title="Remove"
                                                    class="btn btn-danger btn-circle tooltip-danger"><i
                                                    class="fas fa-trash"></i></button>
                                        </a>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('footer')
    <script src="{{asset('assets/plugins/swal/sweetalert.min.js')}}"></script>
    <script>
        $('#datatable').DataTable();
    </script>
@endpush




