@extends('layouts.dashboard')

@section('content')
<style>
.dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
    color: #fff !important;
    border: 1px solid #3247b3 !important;
    background-color: white;
    background: #3248b3 !important;
    border-radius: 50%;
}
.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    color: white !important;
    border: 1px solid #5c6cc3 !important;
    background-color: #585858 !important;
    background: #3247b3cc !important;
    border-radius: 50%;
}
.dataTables_wrapper .dataTables_paginate .next.paginate_button:hover,
.dataTables_wrapper .dataTables_paginate .previous.paginate_button:hover {
    border-radius: 5px;
}
.dataTables_wrapper .dataTables_paginate .next.paginate_button.disabled, 
.dataTables_wrapper .dataTables_paginate .next.paginate_button.disabled:hover, 
.dataTables_wrapper .dataTables_paginate .next.paginate_button.disabled:active,
.dataTables_wrapper .dataTables_paginate .previous.paginate_button.disabled, 
.dataTables_wrapper .dataTables_paginate .previous.paginate_button.disabled:hover, 
.dataTables_wrapper .dataTables_paginate .previous.paginate_button.disabled:active{
    color: #666 !important;
    border: 1px solid transparent !important;
    background: transparent !important;
}
</style>
    <div class="card mb-3">
        <div class="card-header">
            <div class="row align-items-center justify-content-between">
                <div class="col-6 col-sm-auto d-flex align-items-center pr-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">All Payments</h5>
                </div>
                <div class="col-6 col-sm-auto ml-auto text-right pl-0">
                   
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="dashboard-data-table">
                <table class="table table-sm table-dashboard fs--1 data-table border-bottom"  id="myTable">
                    <thead>
                    <tr>
                        <th class="sort pr-1 align-middle">#</th>
                        <th class="sort pr-1 align-middle">Order No</th>
                        <th class="sort pr-1 align-middle">Amount</th>
                        <th class="sort pr-1 align-middle">Period</th>
                        <th class="sort pr-1 align-middle">Transaction ID</th>
                        @if (auth()->user()->role == 'admin')
                            <th class="sort pr-1 align-middle">User Name</th>
                        @endif
                        <th class="sort pr-1 align-middle">Details</th>
                    </tr>
                    </thead>
                    <tbody id="purchases">
                        @forelse($paymentHistory as $payment)
                            <tr class="btn-reveal-trigger">
                                <td class="align-middle">{{ $loop->iteration }}</td>
                                <td class="align-middle">{{ $payment->order_no }}</td>
                                <td class="align-middle">€{{ $payment->amount }}</td>
                                <td class="align-middle">{{ $payment->period }} Month</td>
                                <td class="align-middle">{{ $payment->transaction_id }}</td>
                                @if (auth()->user()->role == 'admin')
                                    <td class="align-middle">{{ $payment->user->name }}</td>
                                @endif
                                <td class="align-middle">
                                    <a class="details text--base" style="cursor:pointer" data-expiry="{{ $payment->expiry_date }}"
                                        data-vm_location="{{ $payment->vm_location }}"
                                        data-vpn_location="{{ $payment->vpn_location }}"
                                        data-vm="{{ $payment->virtualMachine->name }}"
                                        data-email="{{ $payment->user->email }}"
                                        data-os="{{ $payment->operatingSystem->name }}">More Details</a>
                                </td>
                            </tr>
                        @empty
                        <!-- <tr>
                            <td colspan="11">No payment data available.</td>
                        </tr> -->
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="paymentDetailsModal" tabindex="-1" aria-labelledby="paymentDetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentDetailsModalLabel">Payment Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="paymentDetails">
                    <!-- Display payment details here -->
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $(document).on('click', '.details', function() {
                var expiry = $(this).data('expiry');
                var vm_location = $(this).data('vm_location');
                var vpn_location = $(this).data('vpn_location');
                var os = $(this).data('os');
                var vm = $(this).data('vm');
                var email = $(this).data('email');
                var modalBody = $('#paymentDetails');
                var table = $('<table class="table table-bordered table-striped">');
                table.append('<tr><td><strong>Email:</strong></td><td>' + email + '</td></tr>');
                table.append('<tr><td><strong>Virtual Machine:</strong></td><td>' + vm + '</td></tr>');
                table.append('<tr><td><strong>OS:</strong></td><td>' + os + '</td></tr>');
                table.append('<tr><td><strong>Expiry Date:</strong></td><td>' + expiry + '</td></tr>');
                table.append('<tr><td><strong>VM Location:</strong></td><td>' + vm_location + '</td></tr>');
                table.append('<tr><td><strong>VPN Location:</strong></td><td>' + vpn_location + '</td></tr>');
                modalBody.empty().append(table);
                $('#paymentDetailsModal').modal('show');
            });
        </script>
    @endpush
@endsection
