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
                            <th>ID</th>
                            <th>Action</th>
                            </thead>
                            <tbody>
                            @foreach($records as $record)
                            <tr>
                                <td>{{$record->id}}</td>
                                <td><a href="/record/{{$record->id}}">Open</a></td>
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


