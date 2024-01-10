@extends('index')

@section('content')
    <div class="container-fluid mt-2">
        <div class="card-body">
            @if ($log)
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    Last update :
                    <strong>
                        {{ optional($log->updated_at)->format('d F Y, g:i A') }} GMT + 7
                    </strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{-- <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    Invoice will be sent to your email ({{ $company->pic_email }})
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div> --}}
            @endif
            <div class="card border-info mb-3">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Invoice#</th>
                                    <th>Invoice Date</th>
                                    <th>Due Date</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list as $item)
                                    <tr>
                                        <td>{{ $item->code_payment }}</td>
                                        <td> {{ $item->invoice_date ? $item->invoice_date : '-' }} </td>
                                        <td> {{ $item->invoice_due_date ? $item->invoice_due_date : '-' }} </td>
                                        <td>Rp. {{ number_format($item->total_price, 2, ',', '.') }}</td>
                                        <td>
                                            @if ($item->status == 'draft')
                                                Invoice on Process
                                            @else
                                                {{ $item->status }}
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex">

                                                <form action="{{ url('dl/invoice') }}">
                                                    <input type="hidden" name="code_payment"
                                                        value="{{ $item->code_payment }}">
                                                    <button class="btn btn-warning"
                                                        {{ $item->status === 'draft' ? 'disabled' : '' }}>Download </button>
                                                </form>
                                                <form action="{{ url('invoice/detail') }}">
                                                    <input type="hidden" name="code_payment"
                                                        value="{{ $item->code_payment }}">
                                                    <button class="btn btn-primary ml-2"
                                                        {{ $item->status === 'draft' ? 'disabled' : '' }}>Manage</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('bottom')
    <script>
        new DataTable('.table');

        @if (session('success'))
            Swal.fire({
                title: 'Invoice on Process',
                text: 'Your invoice is being reviewed before we provide the payment link. The details will be sent via email to {{ $company->pic_email }}',
                confirmButtonText: 'OK'
            });
        @endif
    </script>
@endpush
