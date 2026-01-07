@extends('layouts.dashboard')
@section('content')
    <div class="row no-gutters">
        <div class="col-lg-12 pr-lg-2">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">{{$pageTitle}}</h5>
                </div>
                <div class="card-body bg-light">
                    <form method="POST" action="{{ route('dashboard.quantumography.plan.store') }}" class="">
                        @csrf
                        <div class="form-group">
                            <label for="plan_name">Plan Name</label>
                            <input type="text" name="plan_name" id="plan_name" class="form-control"
                                value="{{ old('plan_name') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="size">Secret File Size (MB)</label>
                            <input type="text" name="size" id="size" class="form-control"
                                value="{{ old('size') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="price">Price ($)</label>
                            <input type="number" name="price" id="price" class="form-control"
                                value="{{ old('price') }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Plan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
