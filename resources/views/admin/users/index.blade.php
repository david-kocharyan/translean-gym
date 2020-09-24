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
                            <th>Date of Birth</th>
                            <th>Gender</th>
                            <th>Height (sm) </th>
                            <th>Dimmer </th>
                            <th>Protein Hourly Limit </th>
                            <th>Options</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($data as $key=>$val)
                            <tr>
                                <td>{{$key + 1}}</td>
                                <td>{{$val->name}}</td>
                                <td>{{$val->dob}}</td>
                                <td>
                                    {{App\Model\User::GENDER[$val->gender]}}
                                </td>
                                <td>{{$val->height}}</td>
                                <td>{{$val->dimmer}}</td>
                                <td>{{$val->protein_hourly_limit}}</td>
                                <td>

                                    <a href="{{"/assessments/".$val->id}}" data-toggle="tooltip"
                                       data-placement="top" title="Assessments" class="btn btn-warning btn-circle tooltip-warning">
                                        <i class="fas fa-sort-amount-up"></i>
                                    </a>

                                    <a href="{{"/day/".$val->id}}" data-toggle="tooltip"
                                       data-placement="top" title="Day View" class="btn btn-success btn-circle tooltip-success">
                                        <i class="fas fa-user-ninja"></i>
                                    </a>

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




