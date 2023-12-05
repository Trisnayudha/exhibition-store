<section id="delegate-pass">
    <h4>Exhibitor Pass</h4>
    <div class="alert alert-info" role="alert">
        You Have 4 Exhibitor Pass
        <p>Access to</p>
        <ul>
            <li>Exhibition</li>
            <li>Online Networking Platform</li>
        </ul>
    </div>
    <div class="alert alert-danger" role="alert">
        <p>Upgrade your Exhibitor Pass to Delegate Pass for USD 280 / Pax / 3 Days with the inclusion access to:
            Conference, Exhibition, Networking Functions</p>
        Please Note: Company, Name and Position will be printed on the badge
    </div>
    <button class="btn btn-primary mb-2" data-toggle="modal" data-target="#addExhibitorModal">Tambah</button>
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
                <th>Upgrade</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="tabel-exhibitor">
            <!-- Isi tabel akan ditambahkan secara dinamis di sini -->
        </tbody>
    </table>
</section>

<!-- Modal Part 1 -->
<div class="modal fade" id="addExhibitorModal" tabindex="-1" role="dialog" aria-labelledby="addExhibitorModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addExhibitorModalLabel">Tambah Exhibitor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form inside the modal for input -->
                <form id="exhibitorForm">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="company">Company</label>
                                <input type="text" class="form-control" id="companyExhibition"
                                    name="companyExhibition">
                            </div>
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="nameExhibition" name="nameExhibition">
                            </div>
                            <div class="form-group">
                                <label for="position">Position</label>
                                <input type="text" class="form-control" id="positionExhibition"
                                    name="positionExhibition">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" id="emailExhibition" name="emailExhibition">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="mobile">Mobile</label>
                                <input type="text" class="form-control" id="mobileExhibition"
                                    name="mobileExhibition">
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="addressExhibition"
                                    name="addressExhibition">
                            </div>
                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" class="form-control" id="cityExhibition" name="cityExhibition">
                            </div>
                            <div class="form-group">
                                <label for="country">Country</label>
                                <input type="text" class="form-control" id="countryExhibition"
                                    name="countryExhibition">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="postalCode">Postal Code</label>
                                <input type="text" class="form-control" id="postalCodeExhibition"
                                    name="postalCodeExhibition">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" id="phoneExhibition" name="phoneExhibition">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="saveExhibitor()">Save</button>
            </div>
        </div>
    </div>
</div>
