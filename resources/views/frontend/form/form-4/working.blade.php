<section id="delegate-pass">
    <h4>Working Pass (Only If Needed)</h4>
    <div class="alert alert-info" role="alert">
        You Have 4 Working Pass
        <ul>
            <li>Working pass is only valid during the setup and dismantling period</li>
            <li>Working pass can only be obtained by exchanging the ID Card (KTP/SIM/Passport)</li>
        </ul>
    </div>
    <div class="alert alert-danger" role="alert">
        Please Note: Company, Name and Position will be printed on the badge
    </div>
    <button class="btn btn-primary mb-2" data-toggle="modal" data-target="#addWorkingModal">Tambah</button>
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
        <tbody id="tabel-working">
            <!-- Isi tabel akan ditambahkan secara dinamis di sini -->
        </tbody>
    </table>
</section>

<!-- Modal Part 1 -->
<div class="modal fade" id="addWorkingModal" tabindex="-1" role="dialog" aria-labelledby="addWorkingModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addWorkingModalLabel">Tambah Working</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form inside the modal for input -->
                <form id="workingForm">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="company">Company</label>
                                <input type="text" class="form-control" id="companyWorking" name="companyWorking">
                            </div>
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="nameWorking" name="nameWorking">
                            </div>
                            <div class="form-group">
                                <label for="position">Position</label>
                                <input type="text" class="form-control" id="positionWorking" name="positionWorking">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" id="emailWorking" name="emailWorking">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="mobile">Mobile</label>
                                <input type="text" class="form-control" id="mobileWorking" name="mobileWorking">
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="addressWorking" name="addressWorking">
                            </div>
                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" class="form-control" id="cityWorking" name="cityWorking">
                            </div>
                            <div class="form-group">
                                <label for="country">Country</label>
                                <input type="text" class="form-control" id="countryWorking" name="countryWorking">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="postalCode">Postal Code</label>
                                <input type="text" class="form-control" id="postalCodeWorking"
                                    name="postalCodeWorking">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" id="phoneWorking" name="phoneWorking">
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
