@extends('index')

@section('content')
    <div class="col-sm-9">
        <div class="container">
            <div class="container-fluid">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <p>Deadline: Please complete the required form by 23 March 2024.</p>
                    <p>If additional time is needed for completion after the deadline, please confirm with the Operational
                        Team of Indonesia Miner in advance.</p>
                    <p>All data will be considered final unless there is further confirmation indicating the need for
                        additional time.</p>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card border-info">
                    <div class="card-body" style="margin-bottom:-7px;">
                        @if (optional($personal_information)->updated_at != null)
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                Last update :
                                <strong>
                                    {{ optional($personal_information->updated_at)->format('d F Y, g:i A') }} GMT + 7
                                </strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif


                        <div class="content-login mb-25">
                            <h4 class="title-gray">Personal Information</h4>
                        </div>

                        @if (session()->get('status'))
                            <div class="alert-text-danger alert-back">
                                <i class="ri-information-line"></i> {{ session()->get('message') }}
                            </div>
                        @endif

                        <form action="{{ url('postPersonal') }}" method="POST" id="personalInformation">
                            @csrf
                            <div class="form-group">
                                <label>Full Name <i class="text-danger" title="This field is required">*</i></label>
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12">
                                        <input type="text" name="name" id="name" class="form-control validation"
                                            placeholder="Input name" value="{{ old('name', $data->company_name ?? '') }}"
                                            required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Company Type <i class="text-danger" title="This field is required">*</i></label>
                                <div class="row">
                                    <div class="col-lg-2 col-sm-12">
                                        <select name="company_type" id="company_type" class="form-control validation"
                                            placeholder="Company Type">
                                            <option value="">Choose type</option>
                                            @foreach ($company_type as $c => $crow)
                                                <option @if ($crow->name == 'PT') selected @endif
                                                    {{ old('company_type', $data->ms_company_type_id) == $crow->id ? 'selected' : '' }}
                                                    value="{{ $crow->id }}">{{ $crow->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-10 col-sm-12">
                                        <input type="text" name="company_name" id="company_name"
                                            class="form-control validation" placeholder="Input company name"
                                            value="{{ old('company_name', $data->name) }}" required>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group">
                                <label for="job_title">Job Title <i class="text-danger"
                                        title="This field is required">*</i></label>
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12">
                                        <input type="text" name="job_title" class="form-control validation"
                                            placeholder="Input job title" value="{{ old('job_title', $data->job_title) }}"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="alternative_email">Email <i class="text-danger"
                                        title="This field is required">*</i></label>
                                <input type="email" name="alternative_email" id="alternative_email"
                                    class="form-control validation" placeholder="Input your Alternative email"
                                    value="{{ old('alternative_email', $data->email_alternate) }}" required>
                            </div>
                            <div class="form-group">
                                <label>Mobile Number <i class="text-danger" title="This field is required">*</i></label>
                                <div class="row">
                                    <div class="col-lg-2 col-sm-12">
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
                                    <div class="col-lg-10 col-sm-12">
                                        <input type="number" name="phone" id="phone" class="form-control validation"
                                            placeholder="Input mobile number" value="{{ old('phone', $data->phone) }}"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-2 mb-2">
                                <button class="btn btn-primary btn-lg btn-block" type="submit">SAVE PERSONAL
                                    INFORMATION</button>
                            </div>
                        </form>
                    </div>

                </div>

                <div class="line"></div>
                <div class="card border-info mt-2">
                    <div class="card-body" style="margin-bottom:-7px;">
                        <form action="{{ url('postCompany') }}" method="POST">
                            <div class="row">

                                <div class="container-fluid">
                                    @if (optional($company_information)->updated_at != null)
                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                            Last update :
                                            <strong>
                                                {{ optional($company_information->updated_at)->format('d F Y, g:i A') }}
                                                GMT + 7
                                            </strong>
                                            <button type="button" class="close" data-dismiss="alert"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif
                                    <h4 class="title-gray">Company Information</h4>
                                </div>
                                @csrf
                                <div class="col-lg-12 col-sm-12">
                                    <div class="form-group">
                                        <label>NPWP</label>
                                        <input type="text" name="npwp" id="npwp"
                                            class="form-control validation" placeholder="Input company website"
                                            value="{{ old('npwp', $data->npwp) }}">
                                        <small class="text-muted"> Only for Indonesian Company, <i>No Required</i></small>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-sm-12">
                                    <div class="form-group">
                                        <label>Company Website <i class="text-danger"
                                                title="This field is required">*</i></label>
                                        <input type="text" name="company_web" id="company_web"
                                            class="form-control validation" placeholder="Input company website"
                                            value="{{ old('company_web', $data->company_web) }}">
                                        <small class="text-muted">Example : www.example.com</small>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-sm-12">
                                    <div class="form-group">
                                        <label>Company Email <small class="text-muted"> <i>(This Email will be used for
                                                    company
                                                    login)</i> </small> </label>
                                        <input type="text" name="email" id="email"
                                            class="form-control validation" placeholder="Input company website"
                                            value="{{ old('email', $data->email) }}">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-sm-12">
                                    <div class="form-group">
                                        <label>Company Profile (Max. 200 Words) </label>
                                        <small> <i>This Profile will also be used on Indonesia Miner Website and Event
                                                Booklet</i></small>
                                        <textarea name="desc" id="desc" class="form-control validation" placeholder="Input company website"
                                            rows="5" maxlength="200">{{ old('desc', $data->desc) }}
                                </textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-sm-12">
                                    <div class="form-group">
                                        <label>Non Residence <i class="text-danger"
                                                title="This field is required">*</i></label>
                                        <div class="d-flex">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="nonresidence"
                                                    id="nonresidence1" value="Yes"
                                                    {{ $data->nonresidence == 'Yes' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="nonresidence1">
                                                    Yes
                                                </label>
                                            </div>
                                            <div class="form-check ml-5">
                                                <input class="form-check-input" type="radio" name="nonresidence"
                                                    id="nonresidence2" value="No"
                                                    {{ $data->nonresidence == 'No' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="nonresidence2">
                                                    No
                                                </label>
                                            </div>
                                        </div>
                                        <div class="answerresidence">
                                            <label for="answerresidence"> If Yes, please input company name &
                                                address</label>
                                            <textarea name="answerresidence" id="answerresidence" rows="5" class="form-control">{{ $data->answerresidence }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-sm-12">
                                    <div class="form-group">
                                        <label>Company Address <span class="text-danger"
                                                title="This field is required">*</span></label>
                                        <textarea rows="5" name="company_address" id="company_address_another" class="form-control validation-summary"
                                            placeholder="Input company address">{{ old('company_address', $data->company_address) }}</textarea>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Country <i class="text-danger" title="This field is required">*</i></label>
                                        <input type="text" name="country" id="country"
                                            class="form-control validation" placeholder="Input Country"
                                            value="{{ old('country', $data->country) }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label>State <i class="text-danger" title="This field is required">*</i></label>
                                        <input type="text" name="state" id="state"
                                            class="form-control validation" placeholder="Input State"
                                            value="{{ old('state', $data->state) }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label>City <i class="text-danger" title="This field is required">*</i></label>
                                        <input type="text" name="city" id="city"
                                            class="form-control validation" placeholder="Input City"
                                            value="{{ old('city', $data->city) }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Postal Code <span class="text-danger"
                                                title="This field is required">*</span></label>
                                        <input type="number" name="post_code" id="post_code"
                                            class="form-control validation-summary" placeholder="Input postal code"
                                            v-model="form.post_code" value="{{ old('post_code', $data->post_code) }}">
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
                                                    class="form-control validation"
                                                    placeholder="Input company phone number"
                                                    value="{{ old('company_phone', $data->company_phone) }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-sm-12">
                                    <div class="form-group">
                                        <label>Category Company <i class="text-danger"
                                                title="This field is required">*</i></label>
                                        <select name="company_category" id="company_category"
                                            class="form-control validation" placeholder="Company Category">
                                            <option value="">Choose category company</option>
                                            @foreach ($company_category as $o => $orow)
                                                <option
                                                    {{ old('company_category', $data->ms_company_category_id) == $orow->id ? 'selected' : '' }}
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
                                            <option value="">Choose origin manufacturer and technology company
                                            </option>
                                            @foreach ($origin_manufacturer as $z => $zrow)
                                                <option
                                                    {{ old('origin_manufacturer', $data->ms_origin_manufactur_company_id) == $zrow->id ? 'selected' : '' }}
                                                    value="{{ $zrow->id }}" data-name="{{ $zrow->name }}">
                                                    {{ $zrow->name }}</option>
                                            @endforeach
                                            <option {{ old('origin_manufacturer') == 'Other' ? 'selected' : '' }}
                                                value="Other">
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
                                                <option
                                                    {{ old('ms_company_class', $data->ms_company_class_id) == $orow->id ? 'selected' : '' }}
                                                    value="{{ $orow->id }}" data-name="{{ $orow->name }}">
                                                    {{ $orow->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-sm-12">
                                    <div class="form-group selection_eighteen">
                                        <label>Project Type <i class="text-danger"
                                                title="This field is required">*</i></label>
                                        <select name="project_type" id="ms_company_class_id"
                                            class="form-control validation" placeholder="Project Type">
                                            <option value="">Choose project type</option>
                                            @foreach ($project_type as $m => $mrow)
                                                <option
                                                    {{ old('project_type', $data->ms_company_project_type_id) == $mrow->id ? 'selected' : '' }}
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
                                    placeholder="Classify Type" style="width: 100%">
                                    <option value="">Choose classify your minerals company</option>
                                    @foreach ($classify_minerals as $g => $grow)
                                        <option
                                            {{ old('classify_minerals', $data->ms_class_company_minerals_id) == $grow->id ? 'selected' : '' }}
                                            value="{{ $grow->id }}" data-name="{{ $grow->name }}">
                                            {{ $grow->name }}
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
                                        <option
                                            {{ old('classify_mining', $data->ms_class_company_mining_id) == $jrow->id ? 'selected' : '' }}
                                            value="{{ $jrow->id }}" data-name="{{ $jrow->name }}">
                                            {{ $jrow->name }}
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
                                <select name="commodities_minerals" id="commodities_minerals"
                                    class="form-control validation"
                                    placeholder="commodities for minerals producer company" style="width: 100%">
                                    <option value="">Choose commodities for minerals producer company</option>
                                    @foreach ($commodities_minerals as $k => $krow)
                                        <option
                                            {{ old('commodities_minerals', $data->ms_commod_company_minerals_id) == $krow->id ? 'selected' : '' }}
                                            value="{{ $krow->id }}" data-name="{{ $krow->name }}">
                                            {{ $krow->name }}
                                        </option>
                                    @endforeach
                                    <option value="Other">Other</option>
                                </select>

                                <input type="text" name="commodities_minerals_other"
                                    class="form-control validation mt-3"
                                    placeholder="Other commodities for minerals producer company"
                                    value="{{ old('commodities_minerals_other') }}">
                            </div>
                            <div class="form-group selection_fifth">
                                <label>Commodities For Minerals Processing Company <i class="text-danger"
                                        title="This field is required">*</i></label>
                                <select name="commodities_minerals_coal" id="commodities_minerals_coal"
                                    class="form-control validation"
                                    placeholder="commodities for minerals processing company" style="width: 100%">
                                    <option value="">Choose commodities for minerals processing company</option>
                                    @foreach ($commodities_minerals_coal as $i => $irow)
                                        <option
                                            {{ old('commodities_minerals_coal', $data->ms_commod_company_minerals_coal_id) == $irow->id ? 'selected' : '' }}
                                            value="{{ $irow->id }}" data-name="{{ $irow->name }}">
                                            {{ $irow->name }}
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
                                        <option
                                            {{ old('commodities_mining', $data->ms_commod_company_mining_id) == $yrow->id ? 'selected' : '' }}
                                            value="{{ $yrow->id }}" data-name="{{ $yrow->name }}">
                                            {{ $yrow->name }}
                                        </option>
                                    @endforeach
                                    <option value="Other">Other</option>
                                </select>

                                <input type="text" name="commodities_mining_other"
                                    class="form-control validation-detail mt-3"
                                    placeholder="Other commodities for coal mining company"
                                    value="{{ old('commodities_mining_other') }}">
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-12 col-sm-6">
                                        <div class="filter-type">
                                            <input type="checkbox" name="question_term" id="question_term"
                                                value="Yes" class="validation" placeholder="Agree term and privacy"
                                                @if (old('question_term', $data->with_information) === 'Yes') checked @endif>
                                            <label for="question_term">
                                                <div class="custom-radio-wrapper">
                                                    <i class="ri-check-line"></i>
                                                    <div class="title-icon">
                                                        <span style="max-width: 100%">I agree to the <a
                                                                href="{{ url('term-condition') }}" target="_blank">Term &
                                                                Conditions</a> and
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
                                            <input type="checkbox" name="question_would" id="question_would1"
                                                value="Yes" class="validation"
                                                placeholder="I agree to receive the emails to keep me updates"
                                                @if (old('question_would', $data->with_information) === 'Yes') checked @endif>

                                            <label for="question_would1">
                                                <div class="custom-radio-wrapper">
                                                    <i class="ri-check-line"></i>
                                                    <div class="title-icon">
                                                        <span style="max-width: 100%">I agree to receive the emails to keep
                                                            me
                                                            updates<span class="text-danger"
                                                                title="This field is required">*</span></span>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-2 mb-2">
                                <button type="submit" class="btn btn-primary btn-lg btn-block">SAVE COMPANY
                                    INFORMATION</button>
                            </div>
                        </form>

                    </div>
                </div>
                @include('frontend.form.button_dynamic')
            </div>

        </div>
    </div>
@endsection

@push('bottom')
    <script src="{{ asset('js/register.js') }}?{{ date('Y-m-dHis') }}"
type="application/javascript"></script>
@endpush
