@extends('layouts/project')

{{-- Page title --}}
@section('title')
    PMO
    @parent
@stop

@section('titlebody')
    <strong style="text-align: center;font-family:Renogare Soft, sans-serif;">
        Welcome to Project Management Office.
    </strong>
    @parent
@stop

@section('header_right')
    <a href="{{ route('companies.create') }}" class="btn btn-primary pull-right">
        {{ trans('general.create') }}</a>
@stop
{{-- Page content --}}
@section('content')
    <div class="row">
        <div class="col-md-9">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Projects</h3>
                </div>
                <div class="box-body">
                    <ul>
                        {{-- @foreach ($projects as $project)
                            <li>{{ $project->name }}</li>
                        @endforeach --}}
                    </ul>
                </div>
            </div>

            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Tasks</h3>
                </div>
                <div class="box-body">
                    <ul>
                        {{-- @foreach ($tasks as $task)
                            <li>{{ $task->name }} - {{ $task->project->name }}</li>
                        @endforeach --}}
                    </ul>
                </div>
            </div>
        </div>

        <!-- side address column -->
        <div class="col-md-3">
            <!-- You can add additional content or widgets here -->
        </div>
    </div>

@stop

@section('moar_scripts')
    @include ('partials.bootstrap-table')
@stop
