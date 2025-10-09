@extends('index')

@section('content')
    <div class="container-fluid mt-2">
        <div class="card-body">
            <div class="card border-info mb-3">
                <div class="card-body">

                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#eventPass"
                                        aria-expanded="true" aria-controls="eventPass">
                                        EVENT PASS
                                    </button>
                                </h5>
                            </div>

                            <div id="eventPass" class="collapse show" aria-labelledby="" data-parent="#accordion">
                                <div class="card-body">
                                    {{-- start event pass --}}
                                    <div id="eventPass">
                                        <div class="card">
                                            <div class="card-header" id="headingOne">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link" data-toggle="collapse" data-target="#epOne"
                                                        aria-expanded="true" aria-controls="epOne">
                                                        When will I receive my e-ticket?
                                                    </button>
                                                </h5>
                                            </div>

                                            <div id="epOne" class="collapse show" aria-labelledby="headingOne"
                                                data-parent="#eventPass">
                                                <div class="card-body">
                                                    Once your registration is completed, your barcode will be sent to your
                                                    email, this barcode will be used to obtain a badge at our on-site
                                                    registration
                                                    desk.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" id="eventPassTwo">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link collapsed" data-toggle="collapse"
                                                        data-target="#epTwo" aria-expanded="false" aria-controls="epTwo">
                                                        I haven't received any confirmation email or barcode, what should I
                                                        do?
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="epTwo" class="collapse" aria-labelledby="eventPassTwo"
                                                data-parent="#eventPass">
                                                <div class="card-body">
                                                    Please double-check your inbox, and if you don’t find it there, we
                                                    recommend also looking in your spam or junk folder. If it's still
                                                    missing, feel free to reach out to our team via WhatsApp at
                                                    +628111798599 or email us at callula@indonesiaminer.com
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" id="eventPassThree">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link collapsed" data-toggle="collapse"
                                                        data-target="#epThree" aria-expanded="false"
                                                        aria-controls="epThree">
                                                        Is substitution possible?
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="epThree" class="collapse" aria-labelledby="eventPassThree"
                                                data-parent="#eventPass">
                                                <div class="card-body">
                                                    In case there is any changes on your representatives who will attend the
                                                    event after received the confirmation email, you can send a substitute
                                                    to
                                                    replace for no extra cost which the name of the substitute should be
                                                    provided at least 7 days to the event.
                                                    <p></p>
                                                    <p>
                                                        Please be advised, any name change will be valid for access
                                                        throughout
                                                        all three days of the event.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" id="eventPassThree">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link collapsed" data-toggle="collapse"
                                                        data-target="#epFour" aria-expanded="false" aria-controls="epFour">
                                                        When do I get my badge?
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="epFour" class="collapse" aria-labelledby="eventPassThree"
                                                data-parent="#eventPass">
                                                <div class="card-body">
                                                    To collect your badge, please present the barcode included in your
                                                    e-ticket, which has been sent to your registered email. Badge collection
                                                    begins on May 4, 2026, at 5:00 PM (Jakarta time) at the registration
                                                    area.

                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" id="eventPassThree">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link collapsed" data-toggle="collapse"
                                                        data-target="#epFive" aria-expanded="false" aria-controls="epFive">
                                                        Can I purchase one day event pass?
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="epFive" class="collapse" aria-labelledby="eventPassThree"
                                                data-parent="#eventPass">
                                                <div class="card-body">
                                                    We don't have day pass, In case you are not available for 3 days you can
                                                    attend the event for just 1 day.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- end event pass --}}
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#conference"
                                        aria-expanded="false" aria-controls="conference">
                                        CONFERENCE
                                    </button>
                                </h5>
                            </div>
                            <div id="conference" class="collapse" aria-labelledby="" data-parent="#accordion">
                                <div class="card-body">
                                    {{-- start conference --}}
                                    <div id="eventPass">
                                        <div class="card">
                                            <div class="card-header" id="headingOne">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link" data-toggle="collapse"
                                                        data-target="#cOne" aria-expanded="true" aria-controls="cOne">
                                                        How can I see the conference program?
                                                    </button>
                                                </h5>
                                            </div>

                                            <div id="cOne" class="collapse show" aria-labelledby="headingOne"
                                                data-parent="#conference">
                                                <div class="card-body">
                                                    The conference program will be published through our app
                                                    www.indonesiaminer.com as soon as it is finalized and displayed on some
                                                    digital
                                                    signage on-site.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" id="eventPassTwo">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link collapsed" data-toggle="collapse"
                                                        data-target="#cTwo" aria-expanded="false" aria-controls="cTwo">
                                                        Will the presentation available for download?
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="cTwo" class="collapse" aria-labelledby="eventPassTwo"
                                                data-parent="#conference">
                                                <div class="card-body">
                                                    All presentation materials allowed by the speakers to be shared will be
                                                    available to download through our app Indonesia Miner for all
                                                    the Delegate Pass holders only.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" id="eventPassThree">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link collapsed" data-toggle="collapse"
                                                        data-target="#cThree" aria-expanded="false"
                                                        aria-controls="cThree">
                                                        Can I get the copy of recording?
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="cThree" class="collapse" aria-labelledby="eventPassThree"
                                                data-parent="#conference">
                                                <div class="card-body">
                                                    All session recordings allowed by the speaker will be available to
                                                    re-watch through our app Indonesia Miner for all the Delegate
                                                    Pass
                                                    holders only.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- end conference --}}
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed" data-toggle="collapse"
                                        data-target="#exhibition" aria-expanded="false" aria-controls="exhibition">
                                        EXHIBITION
                                    </button>
                                </h5>
                            </div>
                            <div id="exhibition" class="collapse" aria-labelledby="" data-parent="#accordion">
                                <div class="card-body">
                                    {{-- start exhibition --}}
                                    <div id="exhibition">
                                        <div class="card">
                                            <div class="card-header" id="headingOne">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link" data-toggle="collapse"
                                                        data-target="#eOne" aria-expanded="true" aria-controls="eOne">
                                                        How can I order other things additionally that unlisted on the
                                                        Exhibitor Form?
                                                    </button>
                                                </h5>
                                            </div>

                                            <div id="eOne" class="collapse show" aria-labelledby="headingOne"
                                                data-parent="#exhibition">
                                                <div class="card-body">
                                                    Please contact our operational team directly for the availability.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" id="exhibitionTwo">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link collapsed" data-toggle="collapse"
                                                        data-target="#eTwo" aria-expanded="false" aria-controls="eTwo">
                                                        Is it possible to customize the counter/table?
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="eTwo" class="collapse" aria-labelledby="exhibitionTwo"
                                                data-parent="#exhibition">
                                                <div class="card-body">
                                                    For the Standard, Standard Plus, Super, Prime, and Foyer Booth - It's
                                                    possible where the communication will be made directly between the
                                                    exhibitor
                                                    and official stand contractor.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" id="exhibitionThree">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link collapsed" data-toggle="collapse"
                                                        data-target="#eThree" aria-expanded="false"
                                                        aria-controls="eThree">
                                                        Can we have a seamless wallsticker printing?
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="eThree" class="collapse" aria-labelledby="exhibitionThree"
                                                data-parent="#exhibition">
                                                <div class="card-body">
                                                    The seamless printing service for shell schemes is available. For more
                                                    information regarding this, please contact our operations team.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" id="exhibitionThree">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link collapsed" data-toggle="collapse"
                                                        data-target="#eFour" aria-expanded="false" aria-controls="eFour">
                                                        Can we distribute marketing materials to event attendees in event
                                                        area?
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="eFour" class="collapse" aria-labelledby="exhibitionThree"
                                                data-parent="#exhibition">
                                                <div class="card-body">
                                                    Distribution of marketing materials is only allowed in your booth area.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" id="exhibitionThree">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link collapsed" data-toggle="collapse"
                                                        data-target="#eFive" aria-expanded="false" aria-controls="eFive">
                                                        Can I serve food and beveragesto visitor that stop by the booth?
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="eFive" class="collapse" aria-labelledby="exhibitionThree"
                                                data-parent="#exhibition">
                                                <div class="card-body">
                                                    Exhibitors who plan to bring or distribute food and beverages at the
                                                    booth must obtain approval from the organizers.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" id="exhibitionThree">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link collapsed" data-toggle="collapse"
                                                        data-target="#eSix" aria-expanded="false" aria-controls="eSix">
                                                        Are there any services provided by the Organizer to print the
                                                        brochure/flyer/roll up banner?
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="eSix" class="collapse" aria-labelledby="exhibitionThree"
                                                data-parent="#exhibition">
                                                <div class="card-body">
                                                    Yes, please contact our exhibition team for the details. Please note
                                                    that the printing costs will be covered by the exhibitors.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- end event pass --}}
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#imd"
                                        aria-expanded="false" aria-controls="imd">
                                        INDONESIA MINER DIRECTORY
                                    </button>
                                </h5>
                            </div>
                            <div id="imd" class="collapse" aria-labelledby="" data-parent="#accordion">
                                <div class="card-body">
                                    {{-- start event pass --}}
                                    <div id="IMD">
                                        <div class="card">
                                            <div class="card-header" id="headingOne">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link" data-toggle="collapse"
                                                        data-target="#imdOne" aria-expanded="true"
                                                        aria-controls="imdOne">
                                                        What is an Online Directory Profile?
                                                    </button>
                                                </h5>
                                            </div>

                                            <div id="imdOne" class="collapse show" aria-labelledby="headingOne"
                                                data-parent="#IMD">
                                                <div class="card-body">
                                                    A function that will enable the Exhibitor showcase their product
                                                    innovation or service 24/7 accessibility in front of a worldwide
                                                    audiences.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" id="eventPassTwo">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link collapsed" data-toggle="collapse"
                                                        data-target="#imdTwo" aria-expanded="false"
                                                        aria-controls="imdTwo">
                                                        How long is our Online Directory profile available for viewing?
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="imdTwo" class="collapse" aria-labelledby="eventPassTwo"
                                                data-parent="#IMD">
                                                <div class="card-body">
                                                    Your Online Directory profile will be available for viewing starting on
                                                    May 4, 2026 until June 4, 2026.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" id="eventPassThree">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link collapsed" data-toggle="collapse"
                                                        data-target="#imdThree" aria-expanded="false"
                                                        aria-controls="imdThree">
                                                        How will we get access to the Online Directory profile?
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="imdThree" class="collapse" aria-labelledby="eventPassThree"
                                                data-parent="#IMD">
                                                <div class="card-body">
                                                    The Online Directory profile access (login details) will be sent to your
                                                    representative email. Login will be through the Indonesia Miner website
                                                    (www.indonesiaminer.com).
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" id="eventPassThree">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link collapsed" data-toggle="collapse"
                                                        data-target="#imdFour" aria-expanded="false"
                                                        aria-controls="imdFour">
                                                        How many contents can we upload on each section?
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="imdFour" class="collapse" aria-labelledby="eventPassThree"
                                                data-parent="#IMD">
                                                <div class="card-body">
                                                    <ul>
                                                        <li>Media/Resources
                                                            <p>Each Media/Resource section is allowed to add one Image and
                                                                one File.</p>
                                                        </li>
                                                        <li>Products/Services
                                                            <p>Each Products/Services section is allowed to add Multiple
                                                                Images and one Catalogue/Brochure.</p>
                                                        </li>
                                                        <li>Projects
                                                            <p>Each Projects section is allowed to add one Image.</p>
                                                        </li>
                                                        <li>News
                                                            <p>Each News section is allowed to add one Image.</p>
                                                        </li>
                                                        <li>Video
                                                            <p>Each Video section is allowed to add multiple videos URLs
                                                                that are linked to youtube.</p>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" id="eventPassThree">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link collapsed" data-toggle="collapse"
                                                        data-target="#imdFive" aria-expanded="false"
                                                        aria-controls="imdFive">
                                                        How to upload our video?
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="imdFive" class="collapse" aria-labelledby="eventPassThree"
                                                data-parent="#IMD">
                                                <div class="card-body">
                                                    Please upload the video to your YouTube account and provide the link to
                                                    the Indonesia Miner team.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" id="eventPassThree">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link collapsed" data-toggle="collapse"
                                                        data-target="#imdSix" aria-expanded="false"
                                                        aria-controls="imdSix">
                                                        How to upload our video if we do not have any YouTube account?
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="imdSix" class="collapse" aria-labelledby="eventPassThree"
                                                data-parent="#IMD">
                                                <div class="card-body">
                                                    Click Profile YouTube > Click "Your Channel" > Click "Upload Videos" >
                                                    Please follow the steps > on "Visibility" step, choose who can see your
                                                    video
                                                    save as "Unlisted"(your video will not come up in search results or on
                                                    your channel) or as"Public: (anybody can see your video).
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- end event pass --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('top')
@endpush
