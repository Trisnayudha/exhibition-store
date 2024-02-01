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

            <div class="container">

                <div class="mt-5 p-1">
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
                                        <tr>
                                            <td>3</td>
                                            <td class="text-center">C</td>
                                            <td><input type="checkbox" name="basicC" id="basicC"
                                                    class="form-control">
                                            </td>
                                            <td><input type="file" name="file-basicC" id="file-basicC"></td>
                                            <td>
                                                <textarea name="note-basicC" id="" cols="20" rows="2"></textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td class="text-center">D</td>
                                            <td><input type="checkbox" name="basicD" id="basicD"
                                                    class="form-control">
                                            </td>
                                            <td><input type="file" name="file-basicD" id="file-basicD"></td>
                                            <td>
                                                <textarea name="note-basicD" id="" cols="20" rows="2"></textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td class="text-center">E</td>
                                            <td><input type="checkbox" name="basicE" id="basicE"
                                                    class="form-control">
                                            </td>
                                            <td><input type="file" name="file-basicE" id="file-basicE"></td>
                                            <td>
                                                <textarea name="note-basicE" id="" cols="20" rows="2"></textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>6</td>
                                            <td class="text-center">F</td>
                                            <td><input type="checkbox" name="basicF" id="basicF"
                                                    class="form-control">
                                            </td>
                                            <td><input type="file" name="file-basicF" id="file-basicF"></td>
                                            <td>
                                                <textarea name="note-basicE" id="" cols="20" rows="2"></textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>7</td>
                                            <td class="text-center">G</td>
                                            <td><input type="checkbox" name="basicG" id="basicG"
                                                    class="form-control">
                                            </td>
                                            <td><input type="file" name="file-basicG" id="file-basicG"></td>
                                            <td>
                                                <textarea name="note-basicE" id="" cols="20" rows="2"></textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>8</td>
                                            <td class="text-center">H</td>
                                            <td><input type="checkbox" name="basicH" id="basicH"
                                                    class="form-control">
                                            </td>
                                            <td><input type="file" name="file-basicH" id="file-basicH"></td>
                                            <td>
                                                <textarea name="note-basicE" id="" cols="20" rows="2"></textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>9</td>
                                            <td class="text-center">I</td>
                                            <td><input type="checkbox" name="basicH" id="basicI"
                                                    class="form-control">
                                            </td>
                                            <td><input type="file" name="file-basicI" id="file-basicI"></td>
                                            <td>
                                                <textarea name="note-basicE" id="" cols="20" rows="2"></textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>10</td>
                                            <td class="text-center">J</td>
                                            <td><input type="checkbox" name="basicJ" id="basicJ"
                                                    class="form-control">
                                            </td>
                                            <td><input type="file" name="file-basicJ" id="file-basicJ"></td>
                                            <td>
                                                <textarea name="note-basicE" id="" cols="20" rows="2"></textarea>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block mt-3 loadpayment">Save to
                            cart</button>
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
                sideDoffBasicValue += 1;
            }

            // Cek apakah checkbox B dicentang
            if ($("#basicB").is(":checked")) {
                sideDoffBasicValue += 1;
            }

            // Cek apakah checkbox C dicentang
            if ($("#basicC").is(":checked")) {
                sideDoffBasicValue += 1;
            }

            // Cek apakah checkbox D dicentang
            if ($("#basicD").is(":checked")) {
                backDoffBasicValue += 1;
            }

            // Cek apakah checkbox E dicentang
            if ($("#basicE").is(":checked")) {
                backDoffBasicValue += 1;
            }

            if ($("#basicF").is(":checked")) {
                backDoffBasicValue += 1;
            }

            if ($("#basicG").is(":checked")) {
                sideDoffBasicValue += 1;
            }

            if ($("#basicH").is(":checked")) {
                sideDoffBasicValue += 1;
            }

            if ($("#basicI").is(":checked")) {
                sideDoffBasicValue += 1;
            }

            if ($("#basicJ").is(":checked")) {
                tableBasicValue += 1;
            }

            // Mengatur nilai input berdasarkan hasil perhitungan
            $("#back-doff-basic").val(backDoffBasicValue);
            $("#side-doff-basic").val(sideDoffBasicValue);
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

            // Checkbox C
            if ($("#basicC").is(":checked")) {
                $("#file-basicC").prop("required", true);
            } else {
                $("#file-basicC").prop("required", false);
            }

            // Checkbox D
            if ($("#basicD").is(":checked")) {
                $("#file-basicD").prop("required", true);
            } else {
                $("#file-basicD").prop("required", false);
            }

            // Checkbox E
            if ($("#basicE").is(":checked")) {
                $("#file-basicE").prop("required", true);
            } else {
                $("#file-basicE").prop("required", false);
            }

            // Checkbox F
            if ($("#basicF").is(":checked")) {
                $("#file-basicF").prop("required", true);
            } else {
                $("#file-basicF").prop("required", false);
            }

            // Checkbox G
            if ($("#basicG").is(":checked")) {
                $("#file-basicG").prop("required", true);
            } else {
                $("#file-basicG").prop("required", false);
            }

            // Checkbox H
            if ($("#basicH").is(":checked")) {
                $("#file-basicH").prop("required", true);
            } else {
                $("#file-basicH").prop("required", false);
            }

            // Checkbox I
            if ($("#basicI").is(":checked")) {
                $("#file-basicI").prop("required", true);
            } else {
                $("#file-basicI").prop("required", false);
            }

            // Checkbox J
            if ($("#basicJ").is(":checked")) {
                $("#file-basicJ").prop("required", true);
            } else {
                $("#file-basicJ").prop("required", false);
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
