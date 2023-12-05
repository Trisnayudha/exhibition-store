@extends('index')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-3">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home"
                                role="tab" aria-controls="v-pills-home" aria-selected="true">General Information</a>

                            <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile"
                                role="tab" aria-controls="v-pills-profile" aria-selected="false">Representatives
                                Profile</a>

                            <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages"
                                role="tab" aria-controls="v-pills-messages" aria-selected="false">Media/Resources</a>

                            <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings"
                                role="tab" aria-controls="v-pills-settings" aria-selected="false">Products/Services</a>

                            <a class="nav-link" id="v-pills-projects-tab" data-toggle="pill" href="#v-pills-projects"
                                role="tab" aria-controls="v-pills-projects" aria-selected="false">Projects</a>

                            <a class="nav-link" id="v-pills-news-tab" data-toggle="pill" href="#v-pills-news" role="tab"
                                aria-controls="v-pills-news" aria-selected="false">News</a>
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                                aria-labelledby="v-pills-home-tab">
                                @include('frontend.form.form-2.general')
                            </div>
                            <div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
                                aria-labelledby="v-pills-profile-tab">
                                @include('frontend.form.form-2.representative')</div>
                            <div class="tab-pane fade" id="v-pills-messages" role="tabpanel"
                                aria-labelledby="v-pills-messages-tab">
                                @include('frontend.form.form-2.media')</div>
                            <div class="tab-pane fade" id="v-pills-settings" role="tabpanel"
                                aria-labelledby="v-pills-settings-tab">
                                @include('frontend.form.form-2.products')</div>
                            <div class="tab-pane fade" id="v-pills-projects" role="tabpanel"
                                aria-labelledby="v-pills-projects-tab">
                                @include('frontend.form.form-2.project')</div>
                            <div class="tab-pane fade" id="v-pills-news" role="tabpanel" aria-labelledby="v-pills-news-tab">
                                @include('frontend.form.form-2.news')</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end">
                <a href="{{ url('form?type=indonesia-miner-directory') }}" class="btn btn-secondary mr-2">Previous</a>
                <a href="{{ url('form?type=promotional') }}" class="btn btn-info">Next</a>
            </div>
        </div>

    </div>
@endsection
