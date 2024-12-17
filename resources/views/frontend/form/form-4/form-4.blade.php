@extends('index')

@section('content')
    @php
        $isLocked = false;
        if (!empty($data->deadline_4)) {
            $deadlineDate = \Carbon\Carbon::parse($data->deadline_4)->startOfDay();
            $now = \Carbon\Carbon::now()->startOfDay();

            // Lock jika tanggal sekarang lebih dari tanggal deadline
            if ($now->greaterThan($deadlineDate)) {
                $isLocked = true;
            }
        }
    @endphp

    <div class="col-sm-9">
        <div class="container-fluid">
            @if ($data->deadline_4 != null)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <p><b>Deadline: Please complete the required form by
                            {{ \Carbon\Carbon::parse($data->deadline_4)->format('d F Y') }}.</b></p>
                    <p>Please kindly notify our operations team in advance if you need to submit any details after the
                        specified deadline or make any amendments to your submission. This will help ensure that all
                        information is processed according to your final entries. </p>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <!-- Wrapper card, tombol navigasi akan diletakkan di luar -->
            <div class="card border-info">
                <div class="card-body">
                    <ul class="nav nav-pills mb-3 d-flex justify-content-center" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-event-pass-tab" data-toggle="pill" href="#pills-event-pass"
                                role="tab" aria-controls="pills-event-pass" aria-selected="true">Event Pass</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-wishlist-tab" data-toggle="pill" href="#pills-wishlist"
                                role="tab" aria-controls="pills-wishlist" aria-selected="false">Mining Pass</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="pills-tabContent">
                        <!-- Tab Event Pass -->
                        <div class="tab-pane fade show active" id="pills-event-pass" role="tabpanel"
                            aria-labelledby="pills-event-pass-tab">
                            <div class="row">
                                <div class="col-3">
                                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                        aria-orientation="vertical">
                                        <a class="nav-link active" id="v-pills-delegate-tab" data-toggle="pill"
                                            href="#v-pills-delegate" role="tab" aria-controls="v-pills-delegate"
                                            aria-selected="true">Delegate Pass</a>
                                        <a class="nav-link" id="v-pills-exhibitor-tab" data-toggle="pill"
                                            href="#v-pills-exhibitor" role="tab" aria-controls="v-pills-exhibitor"
                                            aria-selected="false">Exhibitor Pass</a>
                                        <a class="nav-link" id="v-pills-working-tab" data-toggle="pill"
                                            href="#v-pills-working" role="tab" aria-controls="v-pills-working"
                                            aria-selected="false">Working Pass</a>
                                        <a class="nav-link" id="v-pills-additional-tab" data-toggle="pill"
                                            href="#v-pills-additional" role="tab" aria-controls="v-pills-additional"
                                            aria-selected="false">Additional Delegate Pass</a>
                                    </div>
                                </div>

                                <!-- Area form di event pass yang akan dikunci jika $isLocked true -->
                                <div class="col-9"
                                    style="position: relative; @if ($isLocked) pointer-events:none; opacity:0.7; @endif">
                                    <div class="tab-content" id="v-pills-tabContent">
                                        <div class="tab-pane fade show active" id="v-pills-delegate" role="tabpanel"
                                            aria-labelledby="v-pills-delegate-tab">
                                            @include('frontend.form.form-4.delegate')
                                        </div>
                                        <div class="tab-pane fade" id="v-pills-exhibitor" role="tabpanel"
                                            aria-labelledby="v-pills-exhibitor-tab">
                                            @include('frontend.form.form-4.exhibitor')
                                        </div>
                                        <div class="tab-pane fade" id="v-pills-working" role="tabpanel"
                                            aria-labelledby="v-pills-working-tab">
                                            @include('frontend.form.form-4.working')
                                        </div>
                                        <div class="tab-pane fade" id="v-pills-additional" role="tabpanel"
                                            aria-labelledby="v-pills-additional-tab">
                                            @include('frontend.form.form-4.additional')
                                        </div>
                                    </div>

                                    @if ($isLocked)
                                        <!-- Overlay hanya di area form event pass -->
                                        <div class="form-lock-overlay"
                                            style="
                                            position: absolute;
                                            top:0; left:0; width:100%; height:100%;
                                            display:flex; flex-direction:column; justify-content:center; align-items:center;
                                            background: rgba(0,0,0,0.5);
                                            color:#fff;
                                            z-index: 999;
                                        ">
                                            <i class="fas fa-lock" style="font-size:80px;"></i>
                                            <h3 style="margin-top:20px; text-align:center;">
                                                This form is locked because the deadline has passed.
                                            </h3>
                                            <p style="max-width:70%; text-align:center;">
                                                Please contact our operations team if you need further assistance.
                                                You can still navigate between sections using the Next/Previous buttons.
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Tab Mining Pass -->
                        <div class="tab-pane fade" id="pills-wishlist" role="tabpanel" aria-labelledby="pills-wishlist-tab">
                            <div class="row">
                                <div class="col-3">
                                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                        aria-orientation="vertical">
                                        <a class="nav-link active" id="v-pills-visitor-tab" data-toggle="pill"
                                            href="#v-pills-visitor" role="tab" aria-controls="v-pills-visitor"
                                            aria-selected="true">Mining Pass</a>
                                    </div>
                                </div>

                                <!-- Area form di mining pass yang akan dikunci jika $isLocked true -->
                                <div class="col-9"
                                    style="position: relative; @if ($isLocked) pointer-events:none; opacity:0.7; @endif">
                                    <div class="tab-content" id="v-pills-tabContent">
                                        <div class="tab-pane fade show active" id="v-pills-visitor" role="tabpanel"
                                            aria-labelledby="v-pills-visitor-tab">
                                            @include('frontend.form.form-4.mining')
                                        </div>
                                    </div>

                                    @if ($isLocked)
                                        <!-- Overlay hanya di area form mining pass -->
                                        <div class="form-lock-overlay"
                                            style="
                                            position: absolute;
                                            top:0; left:0; width:100%; height:100%;
                                            display:flex; flex-direction:column; justify-content:center; align-items:center;
                                            background: rgba(0,0,0,0.5);
                                            color:#fff;
                                            z-index: 999;
                                        ">
                                            <i class="fas fa-lock" style="font-size:80px;"></i>
                                            <h3 style="margin-top:20px; text-align:center;">
                                                This form is locked because the deadline has passed.
                                            </h3>
                                            <p style="max-width:70%; text-align:center;">
                                                Please contact our operations team if you need further assistance.
                                                You can still navigate between sections using the Next/Previous buttons.
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pindahkan tombol navigasi di luar area yang di-lock -->
            </div>

            @include('frontend.form.button_dynamic')
        </div>
    </div>
@endsection

@push('bottom')
@endpush

@push('top')
    <style>
        iframe {
            width: 100%;
            height: 100vh;
            border: none;
        }
    </style>
@endpush
