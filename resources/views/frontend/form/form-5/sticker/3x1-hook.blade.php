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
                            <td>BACK - Doff Laminated Indoor Vinyl Sticker 290x244cm</td>
                            <td>IDR. 3.600.000</td>
                            <td>
                                <input type="number" name="back-doff-basic" id="back-doff-basic" class="form-control"
                                    value="0" readonly>
                                <input type="hidden" name="back-doof-product-basic" id="back-doof-product-basic"
                                    value="BACK - Doff Laminated Indoor Vinyl Sticker 290x244cm">
                                <input type="hidden" name="back-doof-section-basic" id="back-doof-section-basic"
                                    value="Additional Sticker">
                                <input type="hidden" name="back-doof-price-basic" id="back-doof-price-basic"
                                    value="3600000">
                                <input type="hidden" name="back-doof-image-basic" id="back-doof-image-basic"
                                    value="{{ asset('form5/sticker/3x1_hook.jpg') }}">
                            </td>
                        </tr>
                        <tr>
                            <td>TABLE - Doff Laminated Indoor Vinyl Sticker 100x100</td>
                            <td>IDR. 1.050.000</td>
                            <td>
                                <input type="number" name="table-basic" id="table-basic" class="form-control"
                                    value="0" readonly>
                                <input type="hidden" name="table-doof-product-basic" id="table-doof-product-basic"
                                    value="TABLE - Doff Laminated Indoor Vinyl Sticker 100x100">
                                <input type="hidden" name="table-doof-section-basic" id="table-doof-section-basic"
                                    value="Additional Sticker">
                                <input type="hidden" name="table-doof-price-basic" id="table-doof-price-basic"
                                    value="1050000">
                                <input type="hidden" name="table-doof-image-basic" id="table-doof-image-basic"
                                    value="{{ asset('form5/sticker/3x1_hook.jpg') }}">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="container">

                <div class="mt-5 p-1">
                    <div class="row">
                        <div class="col-6">
                            <p>Wall Printing Position You Want to Install:</p>
                            <img src="{{ asset('form5/sticker/3x1_hook.jpg') }}" alt="" class="img-thumbnail">
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
                                            <th>Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td class="text-center">A</td>
                                            <td><input type="checkbox" name="basicA" id="basicA"
                                                    class="form-control">
                                            </td>
                                            <td><input type="file" name="file-basicA" id="file-basicA"></td>
                                            <td>
                                                <textarea name="note-basicA" id="" cols="20" rows="2"></textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td class="text-center">B</td>
                                            <td><input type="checkbox" name="basicB" id="basicB"
                                                    class="form-control">
                                            </td>
                                            <td><input type="file" name="file-basicB" id="file-basicB"></td>
                                            <td>
                                                <textarea name="note-basicB" id="" cols="20" rows="2"></textarea>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block mt-3 loadpayment">Save to cart</button>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>
<script>
    $(document).ready(function() {
        // Fungsi untuk menghitung nilai input berdasarkan checkbox yang dicentang
        function updateValue() {
            var backDoffBasicValue = 0;
            var sideDoffBasicValue = 0;
            var tableBasicValue = 0;

            // Cek apakah checkbox A dicentang
            if ($("#basicA").is(":checked")) {
                backDoffBasicValue += 1;
            }

            // Cek apakah checkbox B dicentang
            if ($("#basicB").is(":checked")) {
                tableBasicValue += 1;
            }
            // Mengatur nilai input berdasarkan hasil perhitungan
            $("#back-doff-basic").val(backDoffBasicValue);
            $("#table-basic").val(tableBasicValue);
        }

        // Memanggil fungsi updateValue() setiap kali checkbox berubah
        $("input[type=checkbox]").change(updateValue);
    });
</script>

<script>
    $(document).ready(function() {
        // Fungsi untuk mengatur validasi file input berdasarkan checkbox yang dicentang
        function updateFileValidation() {
            // Checkbox A
            if ($("#basicA").is(":checked")) {
                $("#file-basicA").prop("required", true);
            } else {
                $("#file-basicA").prop("required", false);
            }

            // Checkbox B
            if ($("#basicB").is(":checked")) {
                $("#file-basicB").prop("required", true);
            } else {
                $("#file-basicB").prop("required", false);
            }

        }

        // Memanggil fungsi updateFileValidation() setiap kali checkbox berubah
        $("input[type=checkbox]").change(updateFileValidation);

        // Mengirimkan formulir ketika tombol "SUBMIT" diklik
        $("#myForm").submit(function() {
            // Tambahan logika validasi lainnya jika diperlukan
            // Jika validasi berhasil, formulir akan dikirim, jika tidak formulir tidak akan dikirim
        });
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
