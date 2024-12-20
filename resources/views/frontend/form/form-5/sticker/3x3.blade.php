<div class="container">
    <div class="row">
        <form action="{{ url('sticker') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="table-responsive" id="sticker-basic-cart">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Printing</th>
                            <th>Price</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>BACK - Doff Laminated Indoor Vinyl Sticker 96x246cm + Polyfoam</td>
                            <td>IDR. 1.700.000</td>
                            <td>
                                <input type="number" name="back-doff-basic" id="back-doff-basic" class="form-control"
                                    value="0" readonly>
                                <input type="hidden" name="back-doof-product-basic" id="back-doof-product-basic"
                                    value="BACK - Doff Laminated Indoor Vinyl Sticker 96x246cm + Polyfoam">
                                <input type="hidden" name="back-doof-section-basic" id="back-doof-section-basic"
                                    value="Additional Sticker">
                                <input type="hidden" name="back-doof-price-basic" id="back-doof-price-basic"
                                    value="1700000">
                                <input type="hidden" name="back-doof-image-basic" id="back-doof-image-basic"
                                    value="{{ asset('form5/sticker/3x3.png') }}">
                            </td>
                        </tr>
                        <tr>
                            <td>SIDE - Doff Laminated Indoor Vinyl Sticker 96x246cm + Polyfoam</td>
                            <td>IDR. 1.700.000</td>
                            <td>
                                <input type="number" name="side-doff-basic" id="side-doff-basic" class="form-control"
                                    value="0" readonly>
                                <input type="hidden" name="side-doof-product-basic" id="side-doof-product-basic"
                                    value="SIDE - Doff Laminated Indoor Vinyl Sticker 96x246cm + Polyfoam">
                                <input type="hidden" name="side-doof-section-basic" id="side-doof-section-basic"
                                    value="Additional Sticker">
                                <input type="hidden" name="side-doof-price-basic" id="side-doof-price-basic"
                                    value="1700000">
                                <input type="hidden" name="side-doof-image-basic" id="side-doof-image-basic"
                                    value="{{ asset('form5/sticker/3x3.png') }}">
                            </td>
                        </tr>
                        <tr>
                            <td>TABLE - Doff Laminated Indoor Vinyl Sticker 96x71cm + Polyfoam</td>
                            <td>IDR. 850.000</td>
                            <td>
                                <input type="number" name="table-basic" id="table-basic" class="form-control"
                                    value="0" readonly>
                                <input type="hidden" name="table-doof-product-basic" id="table-doof-product-basic"
                                    value="TABLE - Doff Laminated Indoor Vinyl Sticker 96x71cm + Polyfoam">
                                <input type="hidden" name="table-doof-section-basic" id="table-doof-section-basic"
                                    value="Additional Sticker">
                                <input type="hidden" name="table-doof-price-basic" id="table-doof-price-basic"
                                    value="850000">
                                <input type="hidden" name="table-doof-image-basic" id="table-doof-image-basic"
                                    value="{{ asset('form5/sticker/3x3.png') }}">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="container mt-5 p-1">
                <div class="row">
                    <div class="col-6">
                        <p>Wall Printing Position You Want to Install:</p>
                        <img src="{{ asset('form5/sticker/3x3.png') }}" alt="" class="img-thumbnail">
                    </div>
                    <div class="col-6">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Printing Position</th>
                                        <th>Checklist</th>
                                        <th>File</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'] as $position)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $position }}</td>
                                            <td>
                                                <input type="checkbox" name="basic{{ $position }}"
                                                    id="basic{{ $position }}" class="form-control checkbox-class"
                                                    disabled>
                                            </td>
                                            <td>
                                                <input type="file" name="file-basic{{ $position }}"
                                                    id="file-basic{{ $position }}">
                                                <textarea name="note-basic{{ $position }}" id="note-link-basic{{ $position }}"
                                                    class="form-control mt-2 google-drive-link" placeholder="Upload link Google Drive Anda" style="display: none;"></textarea>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block mt-3 save-btn" disabled>Add to Cart</button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Fungsi untuk memperbarui nilai di tabel sticker-basic-cart
        function updateStickerCartValues() {
            let backDoffBasicValue = 0;
            let sideDoffBasicValue = 0;
            let tableBasicValue = 0;

            // Iterasi semua checkbox untuk menghitung nilai
            $(".checkbox-class:checked").each(function() {
                const position = $(this).attr("id").replace("basic",
                    ""); // Ambil posisi, misalnya "A", "B"

                if (["A", "B", "C", "G", "H", "I"].includes(position)) {
                    sideDoffBasicValue += 1;
                } else if (["D", "E", "F"].includes(position)) {
                    backDoffBasicValue += 1;
                } else if (["J"].includes(position)) {
                    tableBasicValue += 1;
                }
            });

            // Perbarui nilai di tabel
            $("#back-doff-basic").val(backDoffBasicValue);
            $("#side-doff-basic").val(sideDoffBasicValue);
            $("#table-basic").val(tableBasicValue);
        }

        // Fungsi untuk mengatur status checkbox dan validasi ukuran file untuk posisi tertentu
        function validateFileUploadForPosition(position) {
            const fileInput = $(`#file-basic${position}`);
            const checkbox = $(`#basic${position}`);
            const googleDriveNote = $(`#note-link-basic${position}`);

            // Validasi ukuran file
            if (fileInput[0].files.length > 0) {
                const fileSize = fileInput[0].files[0].size / (1024 * 1024); // Ukuran file dalam MB
                if (fileSize > 3) {
                    // File terlalu besar, tampilkan teks area untuk link Google Drive
                    googleDriveNote.show();
                    checkbox.prop("disabled", true).prop("checked", false);

                    // Reset input file menjadi null
                    fileInput.val("");

                    // Notifikasi dengan SweetAlert
                    Swal.fire({
                        text: 'As the printing material requires a high resolution, please provide a link for us to download the file. Please make sure the file name matches the area where you want the sticker to be applied.',
                        icon: 'warning',
                        confirmButtonText: 'Ok',
                    });
                } else {
                    // File valid, sembunyikan teks area Google Drive
                    googleDriveNote.hide();
                    checkbox.prop("disabled", false).prop("checked", true);
                }
            } else {
                // Tidak ada file, reset state
                googleDriveNote.hide();
                checkbox.prop("disabled", true).prop("checked", false);
            }

            // Perbarui nilai tabel
            updateStickerCartValues();

            // Perbarui tombol "Save to Cart"
            updateSaveButtonState();
        }

        // Fungsi untuk mengatur status checkbox berdasarkan Google Drive link untuk posisi tertentu
        function validateGoogleDriveLinkForPosition(position) {
            const googleDriveNote = $(`#note-link-basic${position}`);
            const checkbox = $(`#basic${position}`);

            // Aktifkan checkbox jika teks area memiliki isi
            if (googleDriveNote.val().trim() !== "") {
                checkbox.prop("disabled", false).prop("checked", true);
            } else {
                checkbox.prop("disabled", true).prop("checked", false);
            }

            // Perbarui nilai tabel
            updateStickerCartValues();

            // Perbarui tombol "Save to Cart"
            updateSaveButtonState();
        }

        // Fungsi untuk memperbarui tombol "Save to Cart"
        function updateSaveButtonState() {
            $(".save-btn").prop("disabled", $(".checkbox-class:checked").length === 0);
        }

        // Event listener untuk setiap file input
        $("input[type=file]").on("change", function() {
            const position = $(this).attr("id").replace("file-basic",
                ""); // Dapatkan posisi, misalnya "A", "B"
            validateFileUploadForPosition(position);
        });

        // Event listener untuk setiap teks area Google Drive link
        $(".google-drive-link").on("input", function() {
            const position = $(this).attr("id").replace("note-link-basic",
                ""); // Dapatkan posisi, misalnya "A", "B"
            validateGoogleDriveLinkForPosition(position);
        });

        // Panggil fungsi untuk memperbarui tombol "Save to Cart" saat halaman dimuat
        updateStickerCartValues();
        updateSaveButtonState();
    });
</script>

<script>
    @if (session('success'))
        Swal.fire({
            text: "{{ session('success') }}",
            icon: "success",
            showConfirmButton: true,
        });
    @endif
</script>
