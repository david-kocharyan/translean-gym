@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 text-right">
            <a href="{{$route."/create"}}" class="btn btn-success m-b-30"><i class="fas fa-plus"></i> Add {{$title}}</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @foreach($data as $key=>$val)
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            {{$val->name}} ({{$val->username}})
                            <div class="panel-action">
                                <a href="{{$route."/".$val->id}}">Basic Info</a>
                            </div>
                        </div>
                        <div class="panel-wrapper collapse in">
                            <div class="panel-body">
                                <ul>
                                    <li>Phone: {{$val->phone}}</li>
                                    <li>Email: {{$val->email ?? "Empty"}}</li>
                                    <li>DOB: {{$val->dob}}</li>
                                    <li>Gender: {{App\Model\User::GENDER[$val->gender]}} </li>
                                    <li>Height: {{$val->height}}</li>
                                    <li>Dimmer: {{$val->dimmer}}</li>
                                    <li>Protein hourly limit: {{$val->protein_hourly_limit}}</li>
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

@endpush




