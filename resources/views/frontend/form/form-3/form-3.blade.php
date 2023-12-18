@extends('index')

@section('content')
    <div class="col-sm-9">

        <div class="container">
            <div class="card border-info">
                <div class="card-body">

                    <section id="advertisement">
                        <form action="{{ url('promotional/advertisement') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="container-fluid">
                                <h4>Advertisement Artwork On Event Booklet</h4>
                                <div class="form-group">
                                    <label for="">File Input</label>
                                    <input type="file" class="form-control" id="pdfFiles" name="pdfFiles"
                                        accept=".pdf">
                                    @if (!empty($advertisement->file))
                                        <button type="button" class="btn btn-info mt-2 preview-pdf"
                                            data-pdf-url="{{ asset($advertisement->file) }}">Preview File</button>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Linkeable to ( Please provide the URL with https:// )</label>
                                    <input type="text" name="linkAdvertisement" id="linkAdvertisement"
                                        class="form-control" value="{{ $advertisement->link ?? '' }}">
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

                    <section id="social-media">
                        <form action="{{ url('promotional/sosmed') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="container-fluid">
                                <h4>Social Media Promotional Content</h4>

                                <div class="form-group">
                                    <label for="imageSocial">Wording <small>(Max 2.220 Words)</small></label>
                                    <textarea name="desc" id="desc" class="form-group ckeditor">
                                        @if (!empty($sosmed['data']['desc']))
{{ $sosmed['data']['desc'] }}
@else
<!-- Deskripsi kosong -->
@endif
                                    </textarea>

                                </div>

                                <div class="form-group">
                                    <label for="imageSocial">Image (1080 x 1080 px) <small>Max Upload 5
                                            Image</small></label>
                                    @if (count($sosmed['listImages']) < 5)
                                        <div id="imageUploadContainer">
                                            <input type="file" name="imageSocial[]" id="imageSocial" class="form-control"
                                                accept=".jpg, .jpeg, .png" multiple>
                                            <small class="form-text text-muted">Upload an image in JPEG or PNG
                                                format.</small>
                                        </div>
                                    @endif
                                    @if (!empty($sosmed['listImages']))
                                        @foreach ($sosmed['listImages'] as $key)
                                            <div class="p-2 existing-images" id="imageListContainer">
                                                <a href="{{ asset($key->file) }}" data-lightbox="image-gallery"
                                                    data-title="Image Title">
                                                    <img src="{{ asset($key->file) }}" alt="" width="100"
                                                        height="56">
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
                                    @if (count($sosmed['listPdf']) < 5)
                                        <div id="pdfUploadContainer">
                                            <input type="file" name="pdfSocial[]" id="pdfSocial" class="form-control"
                                                accept=".pdf" multiple>
                                            <small class="form-text text-muted">Upload a PDF file.</small>
                                        </div>
                                    @endif
                                    @if (!empty($sosmed['listPdf']))
                                        @foreach ($sosmed['listPdf'] as $key)
                                            <div class="existing-pdfs">
                                                <button type="button" class="btn btn-info mt-2 preview-pdf"
                                                    data-pdf-url="{{ asset($key->file) }}">Preview File</button>
                                                <button type="button" class="ml-2 btn btn-danger mt-2 delete-btn"
                                                    data-id="{{ $key->id }}">Delete</button>
                                            </div>
                                        @endforeach
                                    @endif
                                    <div id="pdfPreviewContainer"></div>
                                </div>

                                <div class="form-group">
                                    <label for="linkSocialMedia">Linkable to (Please provide the URL with https://)</label>
                                    <input type="text" name="linkSocialMedia" id="linkSocialMedia" class="form-control"
                                        value="{{ !empty($sosmed['data']['link']) ? $sosmed['data']['link'] : '' }}">
                                    <small class="form-text text-muted">Provide the URL starting with https://.</small>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-primary btn-lg btn-block"> SAVE SOCIAL MEDIA </button>
                                </div>
                            </div>
                        </form>


                    </section>


                </div>
                <div class="card-footer d-flex justify-content-end">
                    <a href="{{ url('form?type=indonesia-miner-directory') }}" class="btn btn-secondary mr-2">Previous</a>
                    <a href="{{ url('form?type=event-pass') }}" class="btn btn-info">Next</a>
                </div>
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


    {{-- Show Image --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/css/lightbox.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/js/lightbox.min.js"></script>

    <script>
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true
        });
    </script>
@endpush
