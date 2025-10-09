@extends('index')

@section('content')
    @php
        $isLocked = false;
        if (!empty($data->deadline_2)) {
            $deadlineDate = \Carbon\Carbon::parse($data->deadline_2)->startOfDay();
            $now = \Carbon\Carbon::now()->startOfDay();

            // Lock jika tanggal sekarang lebih dari tanggal deadline
            if ($now->greaterThan($deadlineDate)) {
                $isLocked = true;
            }
        }
    @endphp

    <div class="col-sm-9">
        <div class="container-fluid">
            @if ($data->deadline_2 != null)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <p><b> 🔔 Form Deadline:
                            {{ \Carbon\Carbon::parse($data->deadline)->format('d F Y') }}.</b></p>
                    <p>Running behind or need to update something later? Just give our operations team a heads-up so we
                        can help keep things on track.
                    </p>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="alert alert-primary alert-dismissible fade show" role="alert">
                <b>
                    All the information you fill in this form will be displayed in Mining Directory on Indonesia Miner
                    website - https://indonesiaminer.com/directory and Indonesia Miner mobile app, available to attendees
                    during the event.

                </b>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="card border-info">
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                aria-orientation="vertical">
                                <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home"
                                    role="tab" aria-controls="v-pills-home" aria-selected="true">General Information</a>
                                <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile"
                                    role="tab" aria-controls="v-pills-profile" aria-selected="false">Representatives
                                    Profile</a>
                                <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages"
                                    role="tab" aria-controls="v-pills-messages"
                                    aria-selected="false">Media/Resources</a>
                                <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings"
                                    role="tab" aria-controls="v-pills-settings"
                                    aria-selected="false">Products/Services</a>
                                <a class="nav-link" id="v-pills-projects-tab" data-toggle="pill" href="#v-pills-projects"
                                    role="tab" aria-controls="v-pills-projects" aria-selected="false">Projects</a>
                                <a class="nav-link" id="v-pills-news-tab" data-toggle="pill" href="#v-pills-news"
                                    role="tab" aria-controls="v-pills-news" aria-selected="false">News</a>
                            </div>
                        </div>

                        <!-- Wrap .col-9 in a position: relative container and apply lock if needed -->
                        <div class="col-9"
                            style="position: relative; @if ($isLocked) pointer-events:none; opacity:0.7; @endif">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                                    aria-labelledby="v-pills-home-tab">
                                    @include('frontend.form.form-2.general')
                                </div>
                                <div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
                                    aria-labelledby="v-pills-profile-tab">
                                    @include('frontend.form.form-2.representative')
                                </div>
                                <div class="tab-pane fade" id="v-pills-messages" role="tabpanel"
                                    aria-labelledby="v-pills-messages-tab">
                                    @include('frontend.form.form-2.media')
                                </div>
                                <div class="tab-pane fade" id="v-pills-settings" role="tabpanel"
                                    aria-labelledby="v-pills-settings-tab">
                                    @include('frontend.form.form-2.products')
                                </div>
                                <div class="tab-pane fade" id="v-pills-projects" role="tabpanel"
                                    aria-labelledby="v-pills-projects-tab">
                                    @include('frontend.form.form-2.project')
                                </div>
                                <div class="tab-pane fade" id="v-pills-news" role="tabpanel"
                                    aria-labelledby="v-pills-news-tab">
                                    @include('frontend.form.form-2.news')
                                </div>
                            </div>

                            @if ($isLocked)
                                <!-- Overlay hanya di area col-9 -->
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
                                        The submission period for this form has ended.
                                    </h3>
                                    <p style="max-width:70%; text-align:center;">
                                        For any special requests or additional support, please reach out to our operations
                                        team.
                                        You can still navigate between sections using the Next/Previous buttons below.
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @include('frontend.form.button_dynamic')
            </div>

        </div>
    </div>
@endsection

@push('bottom')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var input = document.getElementById('company_logo_input');
            var image = document.getElementById('cropped_logo');
            var cropper;

            input.addEventListener('change', function(e) {
                var files = e.target.files;

                if (files && files.length > 0) {
                    var file = files[0];

                    if (cropper) {
                        cropper.destroy();
                        cropper = null;
                    }

                    if (URL) {
                        image.src = URL.createObjectURL(file);
                        image.onload = function() {
                            cropper = new Cropper(image, {
                                aspectRatio: 600 / 400,
                                viewMode: 1,
                                autoCropArea: 1,
                                background: false
                            });
                        };
                    }
                }
            });

            document.getElementById('saveGeneral').addEventListener('click', function() {
                if (cropper) {
                    var croppedData = cropper.getCroppedCanvas().toDataURL();
                    document.getElementById('cropped_image_input').value = croppedData;
                }
            });
        });
    </script>
@endpush
