@extends('layouts.dashboard')

@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <div class="row align-items-center justify-content-between">
                <div class="col-6 col-sm-auto d-flex align-items-center pr-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">{{$pageTitle}}</h5>
                </div>
                <div class="col-6 col-sm-auto ml-auto text-right pl-0">
                    <a href={{route('dashboard.quantumography.plan.create')}} class="btn btn-primary btn-sm">Add New Plan</a>
                </div>
            </div>
        </div>
        <div class="card-body px-0 pt-0">
            <div class="dashboard-data-table">
                <table class="table table-sm table-dashboard fs--1 data-table border-bottom"
                    data-options='{"responsive":false,"pagingType":"simple","lengthChange":false,"searching":false,"pageLength":8,"columnDefs":[{"targets":[0,6],"orderable":false}],"language":{"info":"_START_ to _END_ Items of _TOTAL_ — <a href=https://prium.github.io/"#!\" class=\"font-weight-semi-bold\"> view all <span class=\"fas fa-angle-right\" data-fa-transform=\"down-1\"></span> </a>"},"buttons":["copy","excel"]}'>
                    <tr>
                        <th class="sort pr-1 align-middle">#</th>
                        <th class="sort pr-1 align-middle">Name</th>
                        <th class="sort pr-1 align-middle">Secret File Size (MB)</th>
                        <th class="sort pr-1 align-middle">Amount</th>
                        <th class="sort pr-1 align-middle">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse($plans as $plan)
                            <tr class="btn-reveal-trigger">
                                <td class="align-middle">{{ $loop->iteration }}</td>
                                <td class="align-middle">{{ $plan->plan_name }}</td>
                                <td class="align-middle">{{ $plan->size }} MB</td>
                                <td class="align-middle">${{ $plan->price}} </td>
                                <td class="align-middle">
                                    <a href="{{ route('dashboard.quantumography.plan.edit', $plan->id) }}"
                                        class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('dashboard.quantumography.plan.destroy', $plan->id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to delete this Plan?');">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11">No Vangography plan available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
