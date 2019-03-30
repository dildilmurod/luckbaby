@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 col-md-5">
                <div class="card card-user">
                    <div class="image">
                        <img src="{{ asset('img/background.jpg') }}" alt="..."/>
                    </div>
                    <div class="content">
                        <div class="author">
                            <img class="avatar border-white" src="{{ asset('img/faces/face-7.jpg') }}" alt="..."/>
                            <h4 class="title">Rustem Yusupbaev Bazarbaevich<br />
                                <a href="#"><small></small></a>
                            </h4>
                        </div>
                        <p class="description text-center">
                            {{--"I like the way you work it <br>--}}
                            {{--No diggity <br>--}}
                        </p>
                    </div>
                    <hr>
                </div>

            </div>
            <div class="col-lg-8 col-md-7">
                <div class="card">
                    <div class="header">
                        <h4 class="title">Edit Profile</h4>
                    </div>
                    <div class="content">
                        <form>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <input type="text" class="form-control border-input" placeholder="First Name" value="Rustem" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input type="text" class="form-control border-input" placeholder="Last Name" value="Yusupbaev" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Education</label>
                                        <input type="text" class="form-control border-input" placeholder="Education" value="Tashkent Medical University 1996" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Birth date and place</label>
                                        <input type="text" class="form-control border-input" placeholder="Education" value="1969, Russia, Ufa" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Degree</label>
                                        <input type="text" class="form-control border-input" placeholder="Degree" value="Doctor of Medical Science" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Position</label>
                                        <input type="text" class="form-control border-input" placeholder="Position" value="Center of obstetrics and gynecology of Republic. Higher medical staff" readonly>
                                    </div>
                                </div>
                            </div>

                            {{--<div class="text-center">--}}
                                {{--<button type="submit" class="btn btn-info btn-fill btn-wd">Update Profile</button>--}}
                            {{--</div>--}}
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection
