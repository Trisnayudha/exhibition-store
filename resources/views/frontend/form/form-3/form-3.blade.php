@extends('index')

@section('content')
    @php
        $isLocked = false;
        if (!empty($data->deadline_3)) {
            $deadlineDate = \Carbon\Carbon::parse($data->deadline_3)->startOfDay();
            $now = \Carbon\Carbon::now()->startOfDay();

            // Lock jika tanggal sekarang lebih dari tanggal deadline
            if ($now->greaterThan($deadlineDate)) {
                $isLocked = true;
            }
        }
    @endphp

    <div class="col-sm-9">
        <div class="container">
            @if ($data->deadline_3 != null)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <p><b> Deadline: Please complete the required form by
                            {{ \Carbon\Carbon::parse($data->deadline_3)->format('d F Y') }}.</b></p>
                    <p>Please kindly notify our operations team in advance if you need to submit any details after the
                        specified deadline or make any amendments to your submission. This will help ensure that all
                        information is processed according to your final entries.</p>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <!-- Wrapper form dengan position: relative; pointer-events:none jika terkunci -->
            <div class="card border-info"
                style="position: relative; @if ($isLocked) pointer-events:none; opacity:0.7; @endif">
                <div class="card-body">
                    @if (auth()->user()->level != 'exhibition')
                        <section id="advertisement">
                            <form action="{{ url('promotional/advertisement') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="container-fluid">
                                    @if (optional($log_advertisement)->updated_at != null)
                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                            Last update :
                                            <strong>
                                                {{ optional($log_advertisement->updated_at)->format('d F Y, g:i A') }} GMT +
                                                7
                                            </strong>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif
                                    <h4>Advertisement Artwork On Event Booklet</h4>
                                    <div class="form-group">
                                        <label for="">File Input <small class="form-text text-muted">
                                                {{ $data->size_promotional }}
                                            </small></label>
                                        <input type="file" class="form-control" id="pdfFiles" name="pdfFiles"
                                            accept=".pdf">
                                        @if (!empty($advertisement->file))
                                            <button type="button" class="btn btn-info mt-2 preview-pdf"
                                                data-pdf-url="https://docs.google.com/gview?url={{ urlencode(env('IMAGE_BASE_URL') . $advertisement->file) }}&embedded=true">Preview
                                                File</button>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="">Linkeable to ( Please provide the URL with https:// )</label>
                                        <input type="text" name="linkAdvertisement" id="linkAdvertisement"
                                            class="form-control" value="{{ $advertisement->link ?? '' }}" required>
                                    </div>
                                    <div class="form-group">
                                        <div class="d-flex justify-content-end">
                                            <button class="btn btn-primary btn-lg btn-block loadpayment">
                                                SAVE ADVERTISEMENT ARTWORK
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </section>
                    @endif

                    @if (auth()->user()->level == 'exhibition')
                        <section id="social-media">
                            <form action="{{ url('promotional/sosmed') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="container-fluid">
                                    @if (optional($log_sosmed)->updated_at != null)
                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                            Last update :
                                            <strong>
                                                {{ optional($log_sosmed->updated_at)->format('d F Y, g:i A') }} GMT + 7
                                            </strong>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif
                                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                                        <p>Promotional content will be posted on Instagram (@indonesia_miner) and LinkedIn
                                            (Indonesia Miner) according to the next available slot in our marketing
                                            timeline, once our operations team receives your approval of the provided
                                            preview.</p>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <h4>Social Media Promotional Content</h4>

                                    <div class="form-group">
                                        <label for="imageSocial">Wording <small>(Max 2.200 Words)</small></label>
                                        <textarea name="desc" id="desc" class="form-group summernote">
                                            {{ !empty($sosmed['data']['desc']) ? $sosmed['data']['desc'] : '' }}
                                        </textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="imageSocial">Image (1080 x 1080 px) <small>Max Upload 5
                                                Image</small></label>
                                        <p><small><i>For Instagram (@indonesia_miner)</i></small></p>
                                        @if (!isset($sosmed['listImages']) || count($sosmed['listImages']) < 5)
                                            <div id="imageUploadContainer">
                                                <input type="file" name="imageSocial[]" id="imageSocial"
                                                    class="form-control" accept=".jpg, .jpeg, .png" multiple>
                                                <small class="form-text text-muted">Upload images in JPEG or PNG
                                                    format.</small>
                                            </div>
                                        @endif
                                        @if (isset($sosmed['listImages']))
                                            @foreach ($sosmed['listImages'] as $key)
                                                <div class="p-2 existing-images" id="imageListContainer">
                                                    <a href="{{ env('IMAGE_BASE_URL') . $key->file }}"
                                                        data-lightbox="image-gallery" data-title="Image Title">
                                                        <img src="{{ env('IMAGE_BASE_URL') . $key->file }}" alt=""
                                                            width="100" height="56">
                                                    </a>
                                                    <button type="button" class="ml-2 btn btn-danger delete-btn"
                                                        data-id={{ $key->id }}>Delete</button>
                                                </div>
                                            @endforeach
                                        @endif
                                        <div id="imagePreviewContainer"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="pdfSocial">PDF <small>Max Upload 5 PDF</small></label>
                                        <p><small><i>For LinkedIn (Indonesia Miner)</i></small></p>
                                        @if (!isset($sosmed['listPdf']) || count($sosmed['listPdf']) < 5)
                                            <div id="pdfUploadContainer">
                                                <input type="file" name="pdfSocial[]" id="pdfSocial" class="form-control"
                                                    accept=".pdf" multiple>
                                                <small class="form-text text-muted">Upload a PDF file.</small>
                                            </div>
                                        @endif
                                        @if (isset($sosmed['listPdf']))
                                            @foreach ($sosmed['listPdf'] as $key)
                                                <div class="existing-pdfs">
                                                    <button type="button" class="btn btn-info mt-2 preview-pdf"
                                                        data-pdf-url="https://docs.google.com/gview?url={{ urlencode(env('IMAGE_BASE_URL') . $key->file) }}&embedded=true">Preview
                                                        File</button>
                                                    <button type="button" class="ml-2 btn btn-danger mt-2 delete-btn"
                                                        data-id="{{ $key->id }}">Delete</button>
                                                </div>
                                            @endforeach
                                        @endif
                                        <div id="pdfPreviewContainer"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="linkSocialMedia">Linkable to (Please provide the URL with
                                            https://)</label>
                                        <input type="text" name="linkSocialMedia" id="linkSocialMedia"
                                            class="form-control"
                                            value="{{ !empty($sosmed['data']['link']) ? $sosmed['data']['link'] : '' }}"
                                            required>
                                        <small class="form-text text-muted">Provide the URL starting with https://.</small>
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <button class="btn btn-primary btn-lg btn-block loadpayment"> SAVE SOCIAL MEDIA
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </section>
                    @endif
                </div>

                @if ($isLocked)
                    <!-- Overlay hanya di area form -->
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

            <!-- Taruh tombol navigasi di luar wrapper yang di-lock -->
            @include('frontend.form.button_dynamic')
        </div>
    </div>
@endsection

@push('bottom')
    <!-- Modal untuk Preview PDF -->
    <div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Preview File PDF</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe id="pdfIframe" width="100%" height="600" frameborder="0" allowfullscreen></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete file dan preview --}}
    <script>
        $(document).ready(function() {
            // Preview PDF
            $('.preview-pdf').on('click', function() {
                var pdfUrl = $(this).attr('data-pdf-url');
                $('#pdfIframe').attr('src', pdfUrl);
                $('#previewModal').modal('show');
            });

            // Delete File
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.delete-btn').on('click', function() {
                const imageId = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You won\'t be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'DELETE',
                            url: `/promotional/${imageId}`,
                            success: function(response) {
                                Swal.fire('Deleted!', 'Your file has been deleted.',
                                    'success');
                                location.reload();
                            },
                            error: function(error) {
                                Swal.fire('Error!', 'Failed to delete the file.',
                                    'error');
                            }
                        });
                    }
                });
            });

            // Validation Max Files
            $('#imageSocial').on('change', function() {
                var totalImageFiles = this.files.length + $('.existing-images').length;
                if (totalImageFiles > 5) {
                    alert('Max 5 files allowed for images.');
                    $(this).val('');
                }
            });

            $('#pdfSocial').on('change', function() {
                var totalPdfFiles = this.files.length + $('.existing-pdfs').length;
                if (totalPdfFiles > 5) {
                    alert('Max 5 files allowed for PDFs.');
                    $(this).val('');
                }
            });
        });
    </script>
@endpush
