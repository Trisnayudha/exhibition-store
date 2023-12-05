<section id="delegate-pass">
    <h4>Delegate Pass</h4>
    <div class="alert alert-info" role="alert">
        You Have 3 Delegate Pass
        <p>Access to: </p>
        <ul>
            <li>Conference</li>
            <li>Exhibition</li>
            <li>Networking Functions</li>
        </ul>
    </div>
    <div class="alert alert-danger" role="alert">
        Please Note: Company, Name and Position will be printed on the badge
    </div>
    <button class="btn btn-primary mb-2" data-toggle="modal" data-target="#addDelegateModal">Tambah</button>
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
        <tbody id="tabel-delegate">
            <!-- Isi tabel akan ditambahkan secara dinamis di sini -->
        </tbody>
    </table>
</section>

<!-- Modal Part 1 -->
<div class="modal fade" id="addDelegateModal" tabindex="-1" role="dialog" aria-labelledby="addDelegateModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDelegateModalLabel">Tambah Delegate</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form inside the modal for input -->
                <form id="delegateForm">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="company">Company</label>
                                <input type="text" class="form-control" id="companyDelegate" name="companyDelegate">
                            </div>
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="nameDelegate" name="nameDelegate">
                            </div>
                            <div class="form-group">
                                <label for="position">Position</label>
                                <input type="text" class="form-control" id="positionDelegate"
                                    name="positionDelegate">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" id="emailDelegate" name="emailDelegate">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="mobile">Mobile</label>
                                <input type="text" class="form-control" id="mobileDelegate" name="mobileDelegate">
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="addressDelegate" name="addressDelegate">
                            </div>
                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" class="form-control" id="cityDelegate" name="cityDelegate">
                            </div>
                            <div class="form-group">
                                <label for="country">Country</label>
                                <input type="text" class="form-control" id="countryDelegate" name="countryDelegate">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="postalCode">Postal Code</label>
                                <input type="text" class="form-control" id="postalCodeDelegate"
                                    name="postalCodeDelegate">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" id="phoneDelegate" name="phoneDelegate">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="saveDelegate()">Save</button>
            </div>
        </div>
    </div>
</div>
