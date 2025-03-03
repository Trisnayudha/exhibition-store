@if (optional($log_sticker)->updated_at != null)
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        Last update :
        <strong>
            {{ optional($log_sticker->updated_at)->format('d F Y, g:i A') }}
            GMT + 7
        </strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if ($data->booth == 'Booth 3x1')
    @include('frontend.form.form-5.sticker.3x1')
@elseif ($data->booth == 'Booth 3x1 Hook')
    @include('frontend.form.form-5.sticker.3x1-hook')
@elseif ($data->booth == 'Booth 3x2 Den')
    @include('frontend.form.form-5.sticker.3x2-den')
@elseif ($data->booth == 'Booth 3x2 Den Hook D2')
    @include('frontend.form.form-5.sticker.3x2-den-hook-d2')
@elseif ($data->booth == 'Booth 3x2 Den Hook D3')
    @include('frontend.form.form-5.sticker.3x2-den-hook-d3')
@elseif ($data->booth == 'Booth 3x2')
    @include('frontend.form.form-5.sticker.3x2')
@elseif ($data->booth == 'Booth 3x2 Hook')
    @include('frontend.form.form-5.sticker.3x2-hook')
@elseif ($data->booth == 'Booth 3x3')
    @include('frontend.form.form-5.sticker.3x3')
@elseif ($data->booth == 'Booth 3x3 Hook')
    @include('frontend.form.form-5.sticker.3x3-hook')
@elseif ($data->booth == 'Booth 5x3')
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <p>Stickers are already included with your purchase of the 5 x 3 booth package!</p>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @if (optional($log_sticker)->updated_at != null)
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <p>Your file has been successfully uploaded.
            </p>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @include('frontend.form.form-5.sticker.5x3')
@elseif ($data->booth == 'Booth 6x2')
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <p>Stickers are already included with your purchase of the 6 x 2 booth package!</p>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @if (optional($log_sticker)->updated_at != null)
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <p>Your file has been successfully uploaded.
            </p>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @include('frontend.form.form-5.sticker.6x2')
@endif
