@extends('layouts.dashboard')
@section('content')
    <div class="row no-gutters">
        <div class="col-lg-12 pr-lg-2">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Add Settings</h5>
                </div>
                <div class="card-body bg-light">
                    <form method="POST" action="{{ route('dashboard.settings.store') }}" class="">
                        @csrf
                        <div class="form-group">
                            <label for="key">Key</label>
                            <input type="text" name="key" id="key" class="form-control"
                                value="{{ old('key') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="value">Value</label>
                            <input type="text" name="value" id="value" class="form-control"
                                value="{{ old('value') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Setting</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
