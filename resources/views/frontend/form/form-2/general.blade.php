<form action="{{ url('postGeneral') }}" method="POSt" enctype="multipart/form-data">
    @csrf
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        Please click the SAVE button upon completing the form to ensure it is recorded.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    @if (optional($general)->updated_at != null)
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            Last update :
            <strong>
                {{ optional($general->updated_at)->format('d F Y, g:i A') }} GMT + 7
            </strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="form-group">
        <label for="company_logo">Company Logo</label>
        <input type="file" class="form-control" name="company_logo" id="company_logo_input">

        <small>Dimension 600 x 400 px ( format PNG and Maximum size 500kb )</small>
    </div>
    <div class="form-group">
        <label for="cropped_logo">Cropped Logo</label>
        <div>
            <img id="cropped_logo" style="max-width: 100%;" />
            <input type="hidden" name="cropped_image" id="cropped_image_input">

        </div>
        <img src="{{ env('IMAGE_BASE_URL') . $data->image }}" alt="" height="100">
    </div>

    <div class="form-group">
        <label for=""><b>Value Propositions</b></label>
        <p>
            <small>
                <i>
                    Highlight your company’s core strengths that represent your brand.
                </i>
            </small>
        </p>
        <input type="text" name="info_one" id="info_one" class="form-control" placeholder="Value Proposition 1"
            value="{{ old('info_one', $data->info_one) }}">
    </div>
    <div class="form-group">
        <input type="text" name="info_two" id="info_two" class="form-control" placeholder="Value Proposition 2"
            value="{{ old('info_two', $data->info_two) }}">
    </div>
    <div class="form-group">
        <input type="text" name="info_three" id="info_three" class="form-control" placeholder="Value Proposition 3"
            value="{{ old('info_three', $data->info_three) }}">
    </div>
    <div class="form-group">
        <label for=""><b>Social Media</b></label>
        <p>
            <small>
                <i>
                    Provide your official company social media links, including the full URL starting with https://
                </i>
            </small>
        </p>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default">
                    <i class="fab fa-linkedin"></i>
                </span>
            </div>
            <input type="text" class="form-control" aria-label="Sizing example input"
                aria-describedby="inputGroup-sizing-default" name="linkedin" id="linkedin"
                value="{{ old('linkedin', $data->linkedin) }}">
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default">
                    <i class="fab fa-facebook"></i>
                </span>
            </div>
            <input type="text" class="form-control" aria-label="Sizing example input"
                aria-describedby="inputGroup-sizing-default" name="facebook" id="facebook"
                value="{{ old('facebook', $data->facebook) }}">
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default">
                    <i class="fab fa-instagram"></i>
                </span>
            </div>
            <input type="text" class="form-control" aria-label="Sizing example input"
                aria-describedby="inputGroup-sizing-default" name="instagram" id="instagram"
                value="{{ old('instagram', $data->instagram) }}">
        </div>
    </div>

    <div class="form-group">
        <label for="">Videos</label>

        <p><small><i>Share links to your company videos (e.g., company profile, product demos, project highlights). The
                    Main Video field is for the key video content you want to feature in your profile. Please input URL
                    (URL should include https://)
                </i>
                </i></small>
            <br>
        </p>


        @for ($i = 0; $i < 4; $i++)
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default">
                        @if ($i == 0)
                            Main Video
                        @else
                            Video {{ $i }}
                        @endif
                    </span>
                </div>
                <input type="text" class="form-control" aria-label="Sizing example input"
                    aria-describedby="inputGroup-sizing-default" name="{{ $i == 0 ? 'main_video' : 'video_' . $i }}"
                    id="{{ $i == 0 ? 'main_video' : 'video_' . $i }}"
                    value="{{ $video[$i == 0 ? 'main_video' : 'video_' . $i] ?? '' }}">
            </div>
        @endfor


    </div>
    <button class="btn btn-primary btn-lg btn-block loadpayment" id="saveGeneral"> SAVE </button>
</form>
