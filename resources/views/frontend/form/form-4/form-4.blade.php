@extends('index')

@section('content')
    <div class="col-sm-9">

        <div class="container-fluid">
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
                                            aria-selected="false">Working
                                            Pass</a>

                                        <a class="nav-link" id="v-pills-additional-tab" data-toggle="pill"
                                            href="#v-pills-additional" role="tab" aria-controls="v-pills-additional"
                                            aria-selected="false">Additional Delegate
                                            Pass</a>

                                    </div>
                                </div>
                                <div class="col-9">
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
                                </div>
                            </div>
                        </div>
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
                                <div class="col-9">
                                    <div class="tab-content" id="v-pills-tabContent">
                                        <div class="tab-pane fade show active" id="v-pills-visitor" role="tabpanel"
                                            aria-labelledby="v-pills-visitor-tab">
                                            @include('frontend.form.form-4.visitor')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="card-footer d-flex justify-content-end">
                    <a href="{{ url('form?type=promotional') }}" class="btn btn-secondary mr-2">Previous</a>
                    <a href="{{ url('form?type=exhibition') }}" class="btn btn-info">Next</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('bottom')
@endpush
