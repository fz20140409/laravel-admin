@extends('admin.layouts.default')
@section('content')
    <section class="sidebar">
        <div class="row">
            <div class="col-xs-12">
                <ul class="sidebar-menu">

                {!! $permissions !!}
                </ul>
            </div>
        </div>
    </section>
@endsection