<form action="{{ url('test') }}" method="POSt" enctype="multipart/form-data">
    @csrf
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
    </div>

    <div class="form-group">
        <label for=""> Value Propositions</label>
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
        <label for="">Social Media</label>
        <p>
            <small>Please input URL (URL should include https://)</small>
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
        <p>
            <small>Please input URL (URL should include https://)</small>
        </p>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default">
                    Main Video
                </span>
            </div>
            <input type="text" class="form-control" aria-label="Sizing example input"
                aria-describedby="inputGroup-sizing-default" name="main_video" id="main_video"
                value="{{ $video['main_video'] ?? '' }}">
        </div>
        <!-- Other Videos -->
        @if (count($video) > 0)
            @foreach ($video as $key => $url)
                @if (strpos($key, 'video_') === 0)
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">
                                {{ ucfirst($key) }}
                            </span>
                        </div>
                        <input type="text" class="form-control" aria-label="Sizing example input"
                            aria-describedby="inputGroup-sizing-default" name="{{ $key }}"
                            id="{{ $key }}" value="{{ $url }}">
                    </div>
                @endif
            @endforeach
        @else
            @for ($i = 1; $i <= 3; $i++)
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">
                            Video {{ $i }}
                        </span>
                    </div>
                    <input type="text" class="form-control" aria-label="Sizing example input"
                        aria-describedby="inputGroup-sizing-default" name="video_{{ $i }}"
                        id="video_{{ $i }}" value="">
                </div>
            @endfor
        @endif


    </div>
    <div class="alert alert-danger" role="alert">
        Lu HARUS KLIK BUTTON SAVE BUAT NYIMPEN DATA ! !
    </div>
    <button class="btn btn-primary btn-lg btn-block" id="saveGeneral"> SAVE </button>
</form>
