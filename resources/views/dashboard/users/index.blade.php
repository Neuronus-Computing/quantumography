@extends('layouts.dashboard')

@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <div class="row align-items-center justify-content-between">
                <div class="col-6 col-sm-auto d-flex align-items-center pr-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">All Users</h5>
                </div>
            </div>
        </div>
        <div class="card-body px-0 pt-0">
            <div class="dashboard-data-table">
                <table class="table table-sm table-dashboard fs--1 data-table border-bottom"
                    data-options='{"responsive":false,"pagingType":"simple","lengthChange":false,"searching":false,"pageLength":8,"columnDefs":[{"targets":[0,6],"orderable":false}],"language":{"info":"_START_ to _END_ Items of _TOTAL_ — <a href=https://prium.github.io/"#!\" class=\"font-weight-semi-bold\"> view all <span class=\"fas fa-angle-right\" data-fa-transform=\"down-1\"></span> </a>"},"buttons":["copy","excel"]}'>
                    <tr>
                        <th class="sort pr-1 align-middle">#</th>
                        <th class="sort pr-1 align-middle">Image</th>
                        <th class="sort pr-1 align-middle">Name</th>
                        <th class="sort pr-1 align-middle">Email</th>
                        <th class="sort pr-1 align-middle">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr class="btn-reveal-trigger">
                                <td class="align-middle">{{ $loop->iteration }}</td>
                                <td class="align-middle">
                                    @if($user->avatar)
                                        <img src="{{$user->avatar }}" height="60px" width="60px" alt="Avatar">
                                    @else
                                     <img src="{{asset('dashboard-assets/img/team/user.png')}}" height="60px" width="60px" alt="Avatar" />
                                    @endif
                                </td>
                                <td class="align-middle">{{ $user->name }}</td>
                                <td class="align-middle">{{ $user->email }}</td>

                                <td class="align-middle">
                                    <a href="#"
                                        class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No user found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
