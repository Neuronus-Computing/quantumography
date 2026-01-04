@extends('layouts.dashboard')
@section('content')
    <div class="row no-gutters">
        <div class="col-lg-12 pr-lg-2">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Update Settings</h5>
                </div>
                <div class="card-body bg-light">
                    <form method="POST" action="{{ route('dashboard.settings.update', $setting) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="key">Key</label>
                            <input type="text" name="key" id="key" class="form-control"
                                value="{{ $setting->key }}" required>
                        </div>

                        <div class="form-group">
                            <label for="value">Value</label>
                            <input type="text" name="value" id="value" class="form-control"
                                value="{{ $setting->value }}" required>
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="1" {{ $setting->status === 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $setting->status === 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Setting</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
