<section id="delegate-pass">
    <h4>Additional Delegate Pass</h4>
    <div class="alert alert-info" role="alert">
        We offer a flat rate *
        <p>for <b>USD 400 / pax / 3 days</b> with the inclusion of access to: </p>
        <ul>
            <li>Conference</li>
            <li>Exhibition</li>
            <li>Networking Functions</li>
        </ul>
        <small>Only valid for representative from company of Sponsor or Exhibitor until March 31, 2024 and this
            additional pass require 100% within 7 days after invoice date</small>
    </div>
    <div class="alert alert-danger" role="alert">
        Please Note: Company, Name and Position will be printed on the badge
    </div>
    <button class="btn btn-primary mb-2" data-toggle="modal" data-target="#addAdditionalModal">Tambah</button>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Company</th>
                <th>Name</th>
                <th>Position</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Address</th>
                <th>City</th>
                <th>Country</th>
                <th>Postal Code</th>
                <th>Phone</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="tabel-additional">
            <!-- Isi tabel akan ditambahkan secara dinamis di sini -->
        </tbody>
    </table>
</section>

<!-- Modal Part 1 -->
<div class="modal fade" id="addAdditionalModal" tabindex="-1" role="dialog" aria-labelledby="addAdditionalModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAdditionalModalLabel">Tambah Additional Delegate</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form inside the modal for input -->
                <form id="additionalForm">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="company">Company</label>
                                <input type="text" class="form-control" id="companyAdditional"
                                    name="companyAdditional">
                            </div>
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="nameAdditional" name="nameAdditional">
                            </div>
                            <div class="form-group">
                                <label for="position">Position</label>
                                <input type="text" class="form-control" id="positionAdditional"
                                    name="positionAdditional">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" id="emailAdditional" name="emailAdditional">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="mobile">Mobile</label>
                                <input type="text" class="form-control" id="mobileAdditional"
                                    name="mobileAdditional">
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="addressAdditional"
                                    name="addressAdditional">
                            </div>
                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" class="form-control" id="cityAdditional" name="cityAdditional">
                            </div>
                            <div class="form-group">
                                <label for="country">Country</label>
                                <input type="text" class="form-control" id="countryAdditional"
                                    name="countryAdditional">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="postalCode">Postal Code</label>
                                <input type="text" class="form-control" id="postalCodeAdditional"
                                    name="postalCodeAdditional">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" id="phoneAdditional" name="phoneAdditional">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="saveWorking()">Save</button>
            </div>
        </div>
    </div>
</div>
