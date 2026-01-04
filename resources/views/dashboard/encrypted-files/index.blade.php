@extends('layouts.dashboard')

@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <div class="row align-items-center justify-content-between">
                <div class="col-6 col-sm-auto d-flex align-items-center pr-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">All Encrypted Files</h5>
                </div>
            </div>
        </div>
        <div class="card-body px-0 pt-0">
            <div class="dashboard-data-table">
                <table class="table table-sm table-dashboard fs--1 data-table border-bottom"
                    data-options='{"responsive":false,"pagingType":"simple","lengthChange":false,"searching":false,"pageLength":8,"columnDefs":[{"targets":[0,6],"orderable":false}],"language":{"info":"_START_ to _END_ Items of _TOTAL_ — <a href=https://prium.github.io/"#!\" class=\"font-weight-semi-bold\"> view all <span class=\"fas fa-angle-right\" data-fa-transform=\"down-1\"></span> </a>"},"buttons":["copy","excel"]}'>
                    <tr>
                        <th class="sort pr-1 align-middle">#</th>
                        <th class="sort pr-1 align-middle">Encrypted File</th>
                        <th class="sort pr-1 align-middle">Secret File Size</th>
                        <th class="sort pr-1 align-middle">Amount Paid</th>
                        <th class="sort pr-1 align-middle">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse($files as $file)
                            <tr class="btn-reveal-trigger">
                                <td class="align-middle">{{ $loop->iteration }}</td>
                                <td class="align-middle"><img src="{{$file->path }}" height="100px" width="100px" alt="encrypted file"></td>
                                <td class="align-middle">{{ $file->size }}</td>
                                <td class="align-middle">${{ $file->amount }}</td>
                                
                                <td class="align-middle">
                                    {{-- <a href="{{ route('user.file.download', $file->id) }}"
                                        class="btn btn-primary btn-sm">
                                        <i class="fas fa-download"></i>
                                    </a> --}}
                                    <a href="{{ route('user.file.destroy', $file->id) }}">
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to delete this file?');">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No encrypted file available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
