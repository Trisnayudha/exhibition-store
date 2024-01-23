@extends('index')

@section('content')
    <div class="col-sm-9">

        <div class="container">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <p><b> Deadline: Please complete the required form by 23 March 2024.</b></p>
                <p>If you submit or change the form after the deadline, make sure to confirm beforehand with our
                    operational team. This is important to ensure we process the final details.</p>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card border-info">
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
                                                {{ optional($log_advertisement->updated_at)->format('d F Y, g:i A') }}
                                                GMT + 7
                                            </strong>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif
                                    <h4>Advertisement Artwork On Event Booklet</h4>
                                    <div class="form-group">
                                        <label for="">File Input <small class="form-text text-muted">Half Page -
                                                Landscape (A5: 2480 x 1748
                                                px)</small></label>
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
                                            <button class="btn btn-primary btn-lg btn-block"> SAVE ADVERTISEMENT ARTWORK
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
                                                {{ optional($log_sosmed->updated_at)->format('d F Y, g:i A') }}
                                                GMT + 7
                                            </strong>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif
                                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                                        <p>Promotional content will be published on our social media, Instagram
                                            (@indonesia_miner) and LinkedIn (Indonesia Miner). The publication timing will
                                            align with your form submission and our marketing schedule.
                                        </p>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <h4>Social Media Promotional Content</h4>

                                    <div class="form-group">
                                        <label for="imageSocial">Wording <small>(Max 2.200 Words)</small></label>
                                        <textarea name="desc" id="desc" class="form-group ckeditor">
                                        {{ !empty($sosmed['data']['desc']) ? $sosmed['data']['desc'] : '' }}
                                    </textarea>

                                    </div>

                                    <div class="form-group">
                                        <label for="imageSocial">Image (1080 x 1080 px) <small>Max Upload 5
                                                Image</small></label>
                                        <p> <small><i>For Instagram (@indonesia_miner)</i></small> </p>
                                        @if (!isset($sosmed['listImages']) || count($sosmed['listImages']) < 5)
                                            <div id="imageUploadContainer">
                                                <input type="file" name="imageSocial[]" id="imageSocial"
                                                    class="form-control" accept=".jpg, .jpeg, .png" multiple>
                                                <small class="form-text text-muted">Upload an image in JPEG or PNG
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
                                                        data-id={{ $key->id }}>
                                                        Delete</button>
                                                </div>
                                            @endforeach
                                        @endif
                                        <div id="imagePreviewContainer"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="pdfSocial">PDF <small>Max Upload 5 PDF</small></label>
                                        <p><small><i>For LinkedIn (Indonesia Miner)</i></small> </p>
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
                                        <button class="btn btn-primary btn-lg btn-block"> SAVE SOCIAL MEDIA </button>
                                    </div>
                                </div>
                            </form>


                        </section>
                    @endif


                </div>
                @include('frontend.form.button_dynamic')

            </div>
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
                    <h5 class="modal-title" id="previewModalLabel">Preview File PDF</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Elemen iframe untuk menampilkan PDF -->
                    <iframe id="pdfIframe" width="100%" height="600" frameborder="0" allowfullscreen></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Tangani klik pada tombol "Preview File"
            $('.preview-pdf').on('click', function() {
                // Ambil nilai dari atribut 'href' pada tombol
                var pdfUrl = $(this).attr('data-pdf-url');

                // Isi nilai atribut 'src' pada elemen iframe dengan URL PDF
                $('#pdfIframe').attr('src', pdfUrl);

                // Tampilkan modal
                $('#previewModal').modal('show');
            });
        });
    </script>

    //Delete file
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.delete-btn').on('click', function() {
                const imageId = $(this).data('id');

                // Show SweetAlert confirmation dialog
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
                        // Send AJAX request to delete image by ID
                        $.ajax({
                            type: 'DELETE',
                            url: `/promotional/${imageId}`, // Replace with your actual delete endpoint
                            success: function(response) {
                                // Handle success, for example, remove the deleted image from the DOM
                                Swal.fire('Deleted!', 'Your file has been deleted.',
                                    'success');
                                location.reload(); // Corrected line to reload the page
                            },
                            error: function(error) {
                                Swal.fire('Error!', 'Failed to delete the file.',
                                    'error');
                            }
                        });
                    }
                });
            });
        });
    </script>

    {{-- Validation Total --}}
    <script>
        $(document).ready(function() {
            $('#imageSocial').on('change', function() {
                var totalImageFiles = this.files.length + $('.existing-images').length;

                if (totalImageFiles > 5) {
                    alert('Max 5 files allowed for images.');
                    $(this).val(''); // Clear the selected files
                }
            });

            $('#pdfSocial').on('change', function() {
                var totalPdfFiles = this.files.length + $('.existing-pdfs').length;

                if (totalPdfFiles > 5) {
                    alert('Max 5 files allowed for PDFs.');
                    $(this).val(''); // Clear the selected files
                }
            });
        });
    </script>
@endpush
