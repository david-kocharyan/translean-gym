@extends('layouts.app')

@section('content')
    @include('admin.users.tab')

    <div class="row">
        <div class="col-lg-12">
            <div class="white-box">
                <div class="">
                    <h2 class="m-b-0 m-t-0">{{$user->name}}</h2> <small class="text-muted db ">{{$user->username}}</small>
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
