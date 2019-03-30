@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4 class="title">All records</h4>
                        <p class="category">Here is all records of patients</p>
                    </div>
                    <div class="content table-responsive table-full-width">
                        <table class="table table-striped">
                            <thead>
                            <th>Patient ID</th>
                            <th>Name</th>
                            <th>Surname</th>
                            <th>Action</th>
                            </thead>
                            <tbody>
                            @foreach($records as $record)
                            <tr>
                                <td>{{$record->patient_id}}</td>
                                <td>{{$record->name}}</td>
                                <td>{{$record->surname}}</td>
                                <td><a class="btn btn-link" href="/record/{{$record->id}}">Open</a></td>
                            </tr>

                                @endforeach

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection


