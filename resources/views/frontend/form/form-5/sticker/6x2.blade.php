<div class="container">
    <div class="row">
        <form action="{{ url('sticker') }}" method="POST" enctype="multipart/form-data" id="secondForm">
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
                            <td>BACK - Flexy Indoor Sticker 600cm x 300cm</td>
                            <td>-</td>
                            <td>
                                <input type="number" id="back-doff-basic" class="form-control" value="0" readonly>
                                {{--
                                <input type="hidden" name="back-doof-product-basic" id="back-doof-product-basic" value="BACK - Flexy Indoor Sticker 600cm x 300cm + Polyfoam">
                                <input type="hidden" name="back-doof-section-basic" id="back-doof-section-basic" value="Additional Sticker">
                                <input type="hidden" name="back-doof-price-basic" id="back-doof-price-basic" value="1650000">
                                <input type="hidden" name="back-doof-image-basic" id="back-doof-image-basic" value="{{ asset('form5/sticker/6x2.png') }}">
                                --}}
                            </td>
                        </tr>
                        <tr>
                            <td>TABLE - Doff Laminated Indoor Vinyl Sticker 120x100x50cm</td>
                            <td>-</td>
                            <td>
                                <input type="number" id="table-basic" class="form-control" value="0" readonly>
                                {{--
                                <input type="hidden" name="table-doof-product-basic" id="table-doof-product-basic" value="TABLE - Doff Laminated Indoor Vinyl Sticker 120x100x50cm + Polyfoam">
                                <input type="hidden" name="table-doof-section-basic" id="table-doof-section-basic" value="Additional Sticker">
                                <input type="hidden" name="table-doof-price-basic" id="table-doof-price-basic" value="1000000">
                                <input type="hidden" name="table-doof-image-basic" id="table-doof-image-basic" value="{{ asset('form5/sticker/6x2.png') }}">
                                --}}
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
                            <img src="{{ asset('form5/sticker/6x2.png') }}" alt="" class="img-thumbnail">
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
                                        @php
                                            // Helper function to find sticker by position
                                            function getStickerByPosition($stickerCollection, $position)
                                            {
                                                return $stickerCollection->firstWhere('printing_position', $position);
                                            }
                                        @endphp

                                        @foreach (['A', 'B'] as $position)
                                            @php
                                                $stickerItem = getStickerByPosition($sticker, $position);
                                            @endphp
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $position }}</td>
                                                <td>
                                                    <input type="checkbox" name="basic{{ $position }}"
                                                        id="basic{{ $position }}"
                                                        class="form-control checkbox-class"
                                                        {{ $stickerItem ? 'checked' : '' }}>
                                                </td>
                                                <td class="file-td">
                                                    @if ($stickerItem)
                                                        <!-- Link to view existing file -->
                                                        <a href="{{ asset($stickerItem->file ?? $stickerItem->note) }}"
                                                            target="_blank" class="view-file-link"
                                                            data-position="{{ $position }}">View File</a>
                                                        <!-- Hidden file input for potential replacement -->
                                                        <input type="file" name="file-basic{{ $position }}"
                                                            id="file-basic{{ $position }}" style="display: none;">
                                                    @else
                                                        <!-- File input if no existing sticker -->
                                                        <input type="file" name="file-basic{{ $position }}"
                                                            id="file-basic{{ $position }}">
                                                    @endif
                                                </td>
                                                <!-- Notes section -->
                                                @if ($stickerItem && $stickerItem->note)
                                                    <td class="notes-td">
                                                        <textarea name="note-basic{{ $position }}" cols="20" rows="2">{{ $stickerItem->note }}</textarea>
                                                    </td>
                                                @else
                                                    <td class="notes-td" style="display:none;">
                                                        <small class="text-danger d-block">File too large. Please upload
                                                            via
                                                            your personal Google Drive and include the link
                                                            here.</small>
                                                        <textarea name="note-basic{{ $position }}" cols="20" rows="2"></textarea>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block mt-3 save-btn" disabled>Save to
                            cart</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>



<script>
    $(document).ready(function() {
        // Iterate through each form on the page
        $('form').each(function() {
            var $form = $(this);

            // Function to check if at least one checkbox is checked within the current form
            function checkAtLeastOneCheckbox() {
                return $form.find(".checkbox-class:checked").length > 0;
            }

            // Enable/Disable the submit button based on checkbox state within the current form
            $form.find(".checkbox-class").change(function() {
                $form.find(".save-btn").prop("disabled", !checkAtLeastOneCheckbox());
            });

            // Initially disable the submit button if no checkbox is checked
            $form.find(".save-btn").prop("disabled", !checkAtLeastOneCheckbox());

            // Function to update quantity values based on checked checkboxes within the current form
            function updateValue() {
                var backDoffBasicValue = 0;
                var tableBasicValue = 0;

                if ($form.find("#basicA").is(":checked")) {
                    backDoffBasicValue += 1;
                }
                if ($form.find("#basicB").is(":checked")) {
                    tableBasicValue += 1;
                }

                $form.find("#back-doff-basic").val(backDoffBasicValue);
                $form.find("#table-basic").val(tableBasicValue);
            }

            // Function to set file input as required based on checkbox within the current form
            function updateFileValidation() {
                $form.find("#file-basicA").prop("required", $form.find("#basicA").is(":checked"));
                $form.find("#file-basicB").prop("required", $form.find("#basicB").is(":checked"));
            }

            // Function to update checkbox state based on file input within the current form
            function updateCheckbox() {
                var basics = ['A', 'B'];
                basics.forEach(function(basic) {
                    var fileValue = $form.find("#file-basic" + basic).val();
                    if (fileValue) {
                        $form.find("#basic" + basic).prop("checked", true);
                    } else {
                        $form.find("#basic" + basic).prop("checked", false);
                    }
                });
            }

            // Function to check file size within the current form
            function checkFileSize(input) {
                var file = input[0].files[0];
                if (file && file.size > (3 * 1024 * 1024)) { // 3MB
                    var inputId = input.attr('id');
                    var basic = inputId.split('-').pop(); // e.g., basicA or basicB
                    var basicLetter = basic.charAt(basic.length - 1); // A or B

                    // Show Swal alert in English
                    Swal.fire({
                        title: 'File Too Large',
                        text: 'Referring to weekly planning, shouldn`t a Google Drive link be provided for them to upload the material?',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    });

                    // Remove the file input
                    input.remove();

                    // Hide the file td and show the notes td
                    var fileTd = $form.find(".file-td").eq(basicLetter === 'A' ? 0 : 1);
                    var notesTd = $form.find(".notes-td").eq(basicLetter === 'A' ? 0 : 1);

                    fileTd.hide();
                    notesTd.show();

                    // Uncheck the related checkbox as the file is invalid
                    $form.find("#basic" + basicLetter).prop("checked", false);

                    // Disable the submit button if no checkboxes are checked
                    $form.find(".save-btn").prop("disabled", !checkAtLeastOneCheckbox());
                } else if (file) {
                    // If file size is acceptable, ensure the notes are hidden
                    var inputId = input.attr('id');
                    var basic = inputId.split('-').pop();
                    var basicLetter = basic.charAt(basic.length - 1);

                    var fileTd = $form.find(".file-td").eq(basicLetter === 'A' ? 0 : 1);
                    var notesTd = $form.find(".notes-td").eq(basicLetter === 'A' ? 0 : 1);

                    // Ensure notes are hidden when a valid file is uploaded
                    notesTd.hide();
                }
            }

            // Prevent manual checking/unchecking of checkboxes
            $form.find(".checkbox-class").on('click', function(e) {
                e.preventDefault();
            });

            // Update quantity and file validation when checkboxes change within the current form
            $form.find(".checkbox-class").change(function() {
                updateValue();
                updateFileValidation();
            });

            // Initial checkbox state update within the current form
            updateCheckbox();

            // Event listener for file input changes within the current form
            $form.find("input[type=file]").change(function() {
                var input = $(this);
                checkFileSize(input);
                updateCheckbox();
                updateFileValidation();
                $form.find(".save-btn").prop("disabled", !checkAtLeastOneCheckbox());
            });

            // Event listener for textarea input within the current form
            $form.find("textarea").on('input', function() {
                var textarea = $(this);
                var hasContent = $.trim(textarea.val()).length > 0;
                var name = textarea.attr('name'); // e.g., note-basicA

                // Extract the corresponding checkbox id from the name
                var basic = name.replace('note-', ''); // e.g., basicA
                var checkbox = $form.find("#" + basic);

                if (hasContent) {
                    checkbox.prop("checked", true);
                } else {
                    checkbox.prop("checked", false);
                }

                // Update quantity and file validation based on checkbox state
                updateValue();
                updateFileValidation();

                // Enable/Disable the submit button based on checkbox state
                $form.find(".save-btn").prop("disabled", !checkAtLeastOneCheckbox());
            });
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
