@extends('index')

@section('content')
    <div class="col-sm-9">

        <div class="container-fluid">
            @if ($data->deadline != null)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <p><b> Deadline: Please complete the required form by
                            {{ \Carbon\Carbon::parse($data->deadline)->format('d F Y') }}.</b></p>
                    <p>Please kindly notify our operations team in advance if you need to submit any details after the
                        specified deadline or make any amendments to your submission. This will help ensure that all
                        information is processed according to your final entries.</p>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
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
                                <div class="tab-pane fade" id="v-pills-news" role="tabpanel"
                                    aria-labelledby="v-pills-news-tab">
                                    @include('frontend.form.form-2.news')</div>
                            </div>
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

                    // Hancurkan instance Cropper sebelumnya jika ada
                    if (cropper) {
                        cropper.destroy();
                        cropper = null;
                    }

                    if (URL) {
                        image.src = URL.createObjectURL(file);
                        // Pastikan gambar sudah dimuat sebelum membuat instance Cropper baru
                        image.onload = function() {
                            cropper = new Cropper(image, {
                                aspectRatio: 600 /
                                    400, // Sesuaikan dengan dimensi yang diinginkan
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
