@extends('index')

@section('content')
    <div class="container">
        <div class="card">
            <div class="body-card">

                <div class="container-fluid">
                    <div class="content-login mb-25">
                        <h4 class="title-gray">Personal Information</h4>
                    </div>

                    @if (session()->get('status'))
                        <div class="alert-text-danger alert-back">
                            <i class="ri-information-line"></i> {{ session()->get('message') }}
                        </div>
                    @endif

                    <div class="form-group">
                        <label>Full Name <i class="text-danger" title="This field is required">*</i></label>
                        <div class="row">
                            <div class="col-lg-12 col-sm-12">
                                <input type="text" name="name" id="name" class="form-control validation"
                                    placeholder="Input name" value="{{ old('name') }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Company Type <i class="text-danger" title="This field is required">*</i></label>
                        <div class="row">
                            <div class="col-lg-4 col-sm-12">
                                <select name="company_type" id="company_type" class="form-control validation"
                                    placeholder="Company Type">
                                    <option value="">Choose type</option>
                                    @foreach ($company_type as $c => $crow)
                                        <option @if ($crow->name == 'PT') selected @endif
                                            {{ old('company_type') == $crow->id ? 'selected' : '' }}
                                            value="{{ $crow->id }}">{{ $crow->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-8 col-sm-12">
                                <input type="text" name="company_name" id="company_name" class="form-control validation"
                                    placeholder="Input company name" value="{{ old('company_name') }}">
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="job_title">Job Title <i class="text-danger" title="This field is required">*</i></label>
                        <div class="row">
                            <div class="col-lg-12 col-sm-12">
                                <input type="text" name="job_title" class="form-control validation"
                                    placeholder="Input job title" value="{{ old('job_title') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>Email Address <i class="text-danger" title="This field is required">*</i></label>
                                <input type="email" name="company_email" id="company_email"
                                    class="form-control validation" placeholder="Input your Company email"
                                    value="{{ old('company_email') }}">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>Alternative Email</i></label>
                                <input type="email" name="alternative_email" id="alternative_email"
                                    class="form-control validation" placeholder="Input your Alternative email"
                                    value="{{ old('alternative_email') }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Mobile Number <i class="text-danger" title="This field is required">*</i></label>
                        <div class="row">
                            <div class="col-lg-4 col-sm-12">
                                <select name="phone_code" id="phone_code" class="form-control validation"
                                    placeholder="Phone code">
                                    <option alue="">Phone code</option>
                                    @foreach ($phone_code as $p => $prow)
                                        <option @if ($prow->code == '62') selected @endif
                                            {{ old('phone_code') == $prow->id ? 'selected' : '' }}
                                            value="{{ $prow->id }}">+{{ $prow->code }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-8 col-sm-12">
                                <input type="number" name="users_phone" id="users_phone" class="form-control validation"
                                    placeholder="Input mobile number" value="{{ old('users_phone') }}">
                            </div>
                        </div>
                    </div>

                    <div class="line"></div>
                    <div class="row">
                        <div class="container-fluid">
                            <h4 class="title-gray">Company Information</h4>
                        </div>
                        <div class="col-lg-12 col-sm-12">
                            <div class="form-group">
                                <label>Company Website <i class="text-danger" title="This field is required">*</i></label>
                                <input type="text" name="company_website" id="company_website"
                                    class="form-control validation" placeholder="Input company website"
                                    value="{{ old('company_website') }}">
                                <small class="text-muted">Example : www.example.com</small>
                            </div>
                        </div>
                        <div class="col-lg-12 col-sm-12">
                            <div class="form-group">
                                <label>Company Email <small class="text-muted"> <i>(This Email will be used for company
                                            login)</i> </small> </label>
                                <input type="text" name="company_website" id="company_website"
                                    class="form-control validation" placeholder="Input company website"
                                    value="{{ old('company_website') }}">
                                <small class="text-muted">Example : www.example.com</small>
                            </div>
                        </div>
                        <div class="col-lg-12 col-sm-12">
                            <div class="form-group">
                                <label>Company Profile ( Max. 200 Words) </label>
                                <small> <i>This Profile will also be used on Indonesia Miner Website and Event
                                        Booklet</i></small>
                                <textarea name="company_profile" id="company_profile" class="form-control validation"
                                    placeholder="Input company website" value="{{ old('company_profile') }}" rows="5">
                                </textarea>
                            </div>
                        </div>
                        <div class="col-lg-12 col-sm-12">
                            <div class="form-group">
                                <label>Non Residence <i class="text-danger" title="This field is required">*</i> </label>
                                <div class="d-flex">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="nonresidence"
                                            id="nonresidence1">
                                        <label class="form-check-label" for="nonresidence1">
                                            Yes
                                        </label>
                                    </div>
                                    <div class="form-check ml-5">
                                        <input class="form-check-input" type="radio" name="nonresidence"
                                            id="nonresidence2" checked>
                                        <label class="form-check-label" for="nonresidence2">
                                            No
                                        </label>
                                    </div>
                                </div>
                                <div class="answerresidence">
                                    <label for="answerresidence"> If Yes, please input company name & address</label>
                                    <textarea name="answerresidence" id="answerresidence" rows="5" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-sm-12">
                            <div class="form-group">
                                <label>Company Address <span class="text-danger"
                                        title="This field is required">*</span></label>
                                <textarea rows="5" name="company_address" id="company_address_another" class="form-control validation-summary"
                                    placeholder="Input company address">
                                </textarea>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>Country <i class="text-danger" title="This field is required">*</i></label>
                                <input type="text" name="country" id="country" class="form-control validation"
                                    placeholder="Input Country" value="{{ old('country') }}">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>State <i class="text-danger" title="This field is required">*</i></label>
                                <input type="text" name="state" id="state" class="form-control validation"
                                    placeholder="Input State" value="{{ old('state') }}">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>City <i class="text-danger" title="This field is required">*</i></label>
                                <input type="text" name="city" id="city" class="form-control validation"
                                    placeholder="Input City" value="{{ old('city') }}">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>Postal Code <span class="text-danger"
                                        title="This field is required">*</span></label>
                                <input type="number" name="postal_code" id="postal_code_another"
                                    class="form-control validation-summary" placeholder="Input postal code"
                                    v-model="form.post_code">
                            </div>
                        </div>
                        <div class="col-lg-12 col-sm-12">
                            <div class="form-group">
                                <label>Company Phone Number <i class="text-danger"
                                        title="This field is required">*</i></label>
                                <div class="row">
                                    <div class="col-lg-4 col-sm-12">
                                        <select name="" id="" class="form-control validation"
                                            placeholder="Phone code">
                                            <option alue="">Phone code</option>
                                            @foreach ($phone_code as $p => $prow)
                                                <option @if ($prow->code == '62') selected @endif
                                                    value="{{ $prow->id }}">+{{ $prow->code }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-8 col-sm-12">

                                        <input type="number" name="company_phone" id="company_phone"
                                            class="form-control validation" placeholder="Input company phone number"
                                            value="{{ old('company_phone') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-sm-12">
                            <div class="form-group">
                                <label>Category Company <i class="text-danger"
                                        title="This field is required">*</i></label>
                                <select name="company_category" id="company_category" class="form-control validation"
                                    placeholder="Company Category">
                                    <option value="">Choose category company</option>
                                    @foreach ($company_category as $o => $orow)
                                        <option {{ old('company_category') == $orow->id ? 'selected' : '' }}
                                            value="{{ $orow->id }}" data-name="{{ $orow->name }}">
                                            {{ $orow->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-12 col-sm-12">
                            <div class="form-group selection_seventh">
                                <label>Origin Manufacturer And Technology Company <i class="text-danger"
                                        title="This field is required">*</i></label>
                                <select name="origin_manufacturer" id="origin_manufacturer"
                                    class="form-control validation"
                                    placeholder="origin manufacturer and technology company" style="width: 100%">
                                    <option value="">Choose origin manufacturer and technology company</option>
                                    @foreach ($origin_manufacturer as $z => $zrow)
                                        <option {{ old('origin_manufacturer') == $zrow->id ? 'selected' : '' }}
                                            value="{{ $zrow->id }}" data-name="{{ $zrow->name }}">
                                            {{ $zrow->name }}</option>
                                    @endforeach
                                    <option {{ old('origin_manufacturer') == 'Other' ? 'selected' : '' }} value="Other">
                                        Other</option>
                                </select>

                                <input type="text" name="origin_manufacturer_other"
                                    class="form-control validation-detail mt-3"
                                    placeholder="Other origin manufacturer and technology company"
                                    value="{{ old('origin_manufacturer_other') }}">
                            </div>
                        </div>
                        <div class="col-lg-12 col-sm-12">
                            <div class="form-group selection_eighteen">
                                <label>Classification Company <i class="text-danger"
                                        title="This field is required">*</i></label>
                                <select name="ms_company_class_id" id="ms_company_class_id"
                                    class="form-control validation" placeholder="Company Category">
                                    <option value="">Choose classification company</option>
                                    @foreach ($ms_company_class as $o => $orow)
                                        <option {{ old('ms_company_class') == $orow->id ? 'selected' : '' }}
                                            value="{{ $orow->id }}" data-name="{{ $orow->name }}">
                                            {{ $orow->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12 col-sm-12">
                            <div class="form-group selection_eighteen">
                                <label>Project Type <i class="text-danger" title="This field is required">*</i></label>
                                <select name="project_type" id="project_type" class="form-control validation"
                                    placeholder="Project Type" style="width: 100%">
                                    <option value="">Choose project type</option>
                                    @foreach ($project_type as $m => $mrow)
                                        <option {{ old('project_type') == $mrow->id ? 'selected' : '' }}
                                            value="{{ $mrow->id }}" data-name="{{ $mrow->name }}">
                                            {{ $mrow->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="line"></div>
                    <div class="form-group selection_one">
                        <label>Classify Your Minerals Company <i class="text-danger"
                                title="This field is required">*</i></label>
                        <select name="classify_minerals" id="classify_minerals" class="form-control validation"
                            placeholder="classify your minerals company" style="width: 100%">
                            <option value="">Choose classify your minerals company</option>
                            @foreach ($classify_minerals as $g => $grow)
                                <option {{ old('classify_minerals') == $grow->id ? 'selected' : '' }}
                                    value="{{ $grow->id }}" data-name="{{ $grow->name }}">{{ $grow->name }}
                                </option>
                            @endforeach
                            <option value="Other">Other</option>
                        </select>

                        <input type="text" name="classify_minerals_other" class="form-control validation mt-3"
                            placeholder="Other classify your minerals company">
                    </div>
                    <div class="form-group selection_second">
                        <label>Classify Your Mining Bussiness Permit <i class="text-danger"
                                title="This field is required">*</i></label>
                        <select name="classify_mining" id="classify_mining" class="form-control validation"
                            placeholder="classify your mining bussiness permit" style="width: 100%">
                            <option value="">Choose classify your mining bussiness permit</option>
                            @foreach ($classify_mining as $j => $jrow)
                                <option {{ old('classify_mining') == $jrow->id ? 'selected' : '' }}
                                    value="{{ $jrow->id }}" data-name="{{ $jrow->name }}">{{ $jrow->name }}
                                </option>
                            @endforeach
                            <option value="Other">Other</option>
                        </select>

                        <input type="text" name="classify_mining_other" class="form-control validation mt-3"
                            placeholder="Other classify your mining bussiness permit"
                            value="{{ old('classify_mining_other') }}">
                    </div>

                    <div class="form-group selection_fourth">
                        <label>Commodities For Minerals Producer Company <i class="text-danger"
                                title="This field is required">*</i></label>
                        <select name="commodities_minerals" id="commodities_minerals" class="form-control validation"
                            placeholder="commodities for minerals producer company" style="width: 100%">
                            <option value="">Choose commodities for minerals producer company</option>
                            @foreach ($commodities_minerals as $k => $krow)
                                <option {{ old('commodities_minerals') == $krow->id ? 'selected' : '' }}
                                    value="{{ $krow->id }}" data-name="{{ $krow->name }}">{{ $krow->name }}
                                </option>
                            @endforeach
                            <option value="Other">Other</option>
                        </select>

                        <input type="text" name="commodities_minerals_other" class="form-control validation mt-3"
                            placeholder="Other commodities for minerals producer company"
                            value="{{ old('commodities_minerals_other') }}">
                    </div>
                    <div class="form-group selection_fifth">
                        <label>Commodities For Minerals Processing Company <i class="text-danger"
                                title="This field is required">*</i></label>
                        <select name="commodities_minerals_coal" id="commodities_minerals_coal"
                            class="form-control validation" placeholder="commodities for minerals processing company"
                            style="width: 100%">
                            <option value="">Choose commodities for minerals processing company</option>
                            @foreach ($commodities_minerals_coal as $i => $irow)
                                <option {{ old('commodities_minerals_coal') == $irow->id ? 'selected' : '' }}
                                    value="{{ $irow->id }}" data-name="{{ $irow->name }}">{{ $irow->name }}
                                </option>
                            @endforeach
                            <option value="Other">Other</option>
                        </select>

                        <input type="text" name="commodities_minerals_coal_other"
                            class="form-control validation-detail mt-3"
                            placeholder="Other commodities for minerals processing company"
                            value="{{ old('commodities_minerals_coal_other') }}">
                    </div>
                    <div class="form-group selection_sixth">
                        <label>Commodities For Coal Mining Company <i class="text-danger"
                                title="This field is required">*</i></label>
                        <select name="commodities_mining" id="commodities_mining" class="form-control validation"
                            placeholder="commodities for coal mining company" style="width: 100%">
                            <option value="">Choose commodities for coal mining company</option>
                            @foreach ($commodities_mining as $y => $yrow)
                                <option {{ old('commodities_mining') == $yrow->id ? 'selected' : '' }}
                                    value="{{ $yrow->id }}" data-name="{{ $yrow->name }}">{{ $yrow->name }}
                                </option>
                            @endforeach
                            <option value="Other">Other</option>
                        </select>

                        <input type="text" name="commodities_mining_other" class="form-control validation-detail mt-3"
                            placeholder="Other commodities for coal mining company"
                            value="{{ old('commodities_mining_other') }}">
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-12 col-sm-6">
                                <div class="filter-type">
                                    <input type="checkbox" name="question_term" id="question_term" value="Yes"
                                        class="validation" placeholder="Agree term and privacy"
                                        @if (old('question_term') === 'Yes') checked @endif>
                                    <label for="question_term">
                                        <div class="custom-radio-wrapper">
                                            <i class="ri-check-line"></i>
                                            <div class="title-icon">
                                                <span style="max-width: 100%">I agree to the <a
                                                        href="{{ url('term-condition') }}" target="_blank">Term &
                                                        Conditions</a> And
                                                    <a href="{{ url('privacy-policy') }}" target="_blank">Privacy
                                                        Policy</a><span class="text-danger"
                                                        title="This field is required">*</span></span>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-12 col-sm-6">
                                <div class="filter-type">
                                    <input type="checkbox" name="question_would" id="question_would1" value="Yes"
                                        class="validation" placeholder="I agree to receive the emails to keep me updates"
                                        @if (old('question_would') === 'Yes') checked @endif>

                                    <label for="question_would1">
                                        <div class="custom-radio-wrapper">
                                            <i class="ri-check-line"></i>
                                            <div class="title-icon">
                                                <span style="max-width: 100%">I agree to receive the emails to keep me
                                                    updates<span class="text-danger"
                                                        title="This field is required">*</span></span>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-muted">
                <button type="button" class="btn btn-secondary">Previous</button>
                <button type="button" class="btn btn-primary">Save</button>
                <a href="{{ url('form?type=indonesia-miner-directory') }}" class="btn btn-info">Next</a>
            </div>
        </div>

    </div>
@endsection

@push('bottom')
    <script src="{{ asset('js/register.js') }}?{{ date('Y-m-dHis') }}"
type="application/javascript"></script>
@endpush
