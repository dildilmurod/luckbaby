@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Patient ID {{$record->patient_id}}</div>
                    <h4 class="title">&nbsp&nbsp{{$record->name}}  {{$record->surname}}</h4>

                    <div class="panel-body">
                        {{$record->file}}

                        <div id="waveform">
                        </div>
                        <script>

                        var wavesurfer = WaveSurfer.create({
                        container: '#waveform',
                        waveColor: 'violet',
                        progressColor: 'purple'
                        });
                        wavesurfer.on('ready', function () {
                            wavesurfer.play();
                        });

                        wavesurfer.load("{{ asset('/audio/'.$record->file) }}");
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection