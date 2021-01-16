@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-6 col-xs-12">
            <div class="row d-flex align-items-center justify-content-center">
                <form action="{{$route}}" method="GET" class="col-md-12" >
                    <div class="col-md-6">
                        <input type="text" name="search" class="form-control" placeholder="Enter Username or Name">
                    </div>
                    <div class="col-md-2 d-flex">
                        <button type="submit" class="btn btn-danger display-inline"><i class="fas fa-search"></i></button>
                        <button type="submit" class="m-l-5 btn btn-primary display-inline"><i class="fas fa-sync-alt"></i></button>
                    </div>
                    <div class="col-md-2">

                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-6 col-xs-12 text-right">
            <a href="{{$route."/create"}}" class="btn btn-success m-b-30"><i class="fas fa-plus"></i>
                Add User</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @foreach($data as $key=>$val)
                <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading rounded-top">
                            {{$val->name}} ({{$val->username}})
                            <div class="panel-action">
                                <a href="{{$route."/".$val->id}}">Basic Info</a>
                            </div>
                        </div>
                        <div class="panel-wrapper collapse in">
                            <div class="panel-body">
                                @if($val->image != null)
                                    <img src="{{asset("uploads/$val->image")}}" alt="{{$val->username}}" width="150" height="150" class="img-circle">
                                @else
                                    <img src="{{asset('assets/images/def.png')}}" alt="{{$val->username}}" width="150" height="150" class="img-circle">
                                @endif
                                <ul>
{{--                                    <li>Phone: {{$val->phone}}</li>--}}
{{--                                    <li>Email: {{$val->email ?? "Empty"}}</li>--}}
                                    <li>DOB: {{$val->dob}}</li>
                                    <li>Gender: {{App\Model\User::GENDER[$val->gender]}} </li>
                                    <li>Height: {{$val->height}}</li>
{{--                                    <li>Dimmer: {{$val->dimmer}}</li>--}}
{{--                                    <li>Protein hourly limit: {{$val->protein_hourly_limit}}</li>--}}
                                </ul>
                            </div>
                            <div class="panel-footer text-right">
                                <a href="{{"/assessments/".$val->id}}" data-toggle="tooltip"
                                   data-placement="top" title="Assessments"
                                   class="btn btn-warning btn-circle tooltip-warning">
                                    <i class="fas fa-sort-amount-up"></i>
                                </a>

                                <a href="{{"/day/".$val->id}}" data-toggle="tooltip"
                                   data-placement="top" title="Day View"
                                   class="btn btn-success btn-circle tooltip-success">
                                    <i class="fas fa-user-ninja"></i>
                                </a>

                                <a href="{{$route."/".$val->id."/edit"}}" data-toggle="tooltip"
                                   data-placement="top" title="Edit"
                                   class="btn btn-info btn-circle tooltip-info">
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
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 text-center">
            {{ $data->links() }}
        </div>
    </div>
@endsection

@push('footer')
        <script src="{{asset('assets/plugins/swal/sweetalert.min.js')}}"></script>
@endpush

@push('header')
    <style>
        .panel-body{
            display: flex;
            justify-content: flex-start;
            align-items: center;
            flex-wrap: wrap;
        }
    </style>
    @endpush

