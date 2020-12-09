@extends('layouts.app')

@section('content')
    @include('admin.users.tab')

    <div class="row">
        <div class="col-lg-12">
            <div class="white-box">
                <div class="">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h2 class="m-b-0 m-t-0">{{$user->name}}</h2>
                            <small class="text-muted db ">{{$user->username}}</small>
                        </div>
                        <div>
                            <a href="{{"/users/".$user->id."/edit"}}" class="btn btn-info">
                                Edit <i class="fas fa-edit"></i>
                            </a>
                            <form style="display: inline-block" action="{{ $route."/".$user->id }}"
                                  method="post" id="work-for-form">
                                @csrf
                                @method("DELETE")
                                <a href="javascript:void(0);" data-text="User" class="delForm"
                                   data-id="{{$user->id}}">
                                    <button class="btn btn-danger tooltip-danger">Delete
                                        <i class="fas fa-trash"></i></button>
                                </a>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td width="390">Username</td>
                                        <td>{{$user->name}}</td>
                                    </tr>
                                    <tr>
                                        <td>Phone</td>
                                        <td>{{$user->phone}}</td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td>{{$user->email ?? "Empty"}}</td>
                                    </tr>
                                    <tr>
                                        <td>DOB</td>
                                        <td>{{$user->dob}}</td>
                                    </tr>
                                    <tr>
                                        <td>Gender</td>
                                        <td>{{App\Model\User::GENDER[$user->gender]}}</td>
                                    </tr>
                                    <tr>
                                        <td>Height</td>
                                        <td>{{$user->height}}</td>
                                    </tr>
                                    <tr>
                                        <td>Dimmer</td>
                                        <td>{{$user->dimmer}}</td>
                                    </tr>
                                    <tr>
                                        <td>Protein hourly limit</td>
                                        <td>{{$user->protein_hourly_limit}}</td>
                                    </tr>
                                    <tr>
                                        <td>Wake Up Time</td>
                                        <td>{{$user->wake_up_time}}</td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('footer')
    <script src="{{asset('assets/plugins/swal/sweetalert.min.js')}}"></script>
@endpush
