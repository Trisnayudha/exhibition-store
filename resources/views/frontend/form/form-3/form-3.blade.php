@extends('index')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">

                <section id="advertisement">
                    <div class="container-fluid">
                        <h4>Advertisement Artwork On Event Booklet</h4>
                        <div class="form-group">
                            <label for="">Half Page - Landscape ( A5: 2480 x 1748 px )</label>
                            <input type="file" class="form-control" id="pdfFiles" name="pdfFiles[]" accept=".pdf"
                                multiple>
                        </div>
                        <div class="form-group">
                            <label for="">Linkeable to ( Please provide the URL with https:// )</label>
                            <input type="text" name="linkAdvertisement" id="linkAdvertisement" class="form-control">
                        </div>
                        <div class="form-group">
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-primary"> Save </button>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="social-media">
                    <div class="container-fluid">
                        <h4>Social Media Promotional Content</h4>

                        <div class="form-group">
                            <label for="imageSocial">Image (1080 x 1080 px)</label>
                            <input type="file" name="imageSocial" id="imageSocial" class="form-control"
                                accept=".jpg, .jpeg, .png" multiple>
                            <small class="form-text text-muted">Upload an image in JPEG or PNG format.</small>
                        </div>

                        <div class="form-group">
                            <label for="pdfSocial">PDF</label>
                            <input type="file" name="pdfSocial" id="pdfSocial" class="form-control" accept=".pdf"
                                multiple>
                            <small class="form-text text-muted">Upload a PDF file.</small>
                        </div>

                        <div class="form-group">
                            <label for="linkSocialMedia">Linkable to (Please provide the URL with https://)</label>
                            <input type="text" name="linkSocialMedia" id="linkSocialMedia" class="form-control">
                            <small class="form-text text-muted">Provide the URL starting with https://.</small>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary"> Save </button>
                        </div>
                    </div>
                </section>


            </div>
            <div class="card-footer d-flex justify-content-end">
                <a href="{{ url('form?type=indonesia-miner-directory') }}" class="btn btn-secondary mr-2">Previous</a>
                <a href="{{ url('form?type=event-pass') }}" class="btn btn-info">Next</a>
            </div>
        </div>
    </div>
@endsection




@push('bottom')
@endpush
