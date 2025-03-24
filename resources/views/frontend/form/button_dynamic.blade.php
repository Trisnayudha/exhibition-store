{{-- Contoh untuk form company-information --}}

<div class="card-footer d-flex justify-content-end">
    @if ($type == 'company-information')
        @if ($access['directory_access'] == 1)
            <a href="{{ url('form?type=indonesia-miner-directory') }}" class="btn btn-info">Next</a>
        @elseif ($access['promotional_access'] == 1)
            <a href="{{ url('form?type=promotional') }}" class="btn btn-info">Next</a>
        @elseif ($access['eventpass_access'] == 1)
            <a href="{{ url('form?type=event-pass') }}" class="btn btn-info">Next</a>
        @elseif ($access['exhibition_access'] == 1)
            <a href="{{ url('form?type=exhibition') }}" class="btn btn-info">Next</a>
        @else
            {{-- Jika tidak ada akses lain, tampilkan tombol submit atau semacamnya --}}
        @endif
    @elseif ($type == 'indonesia-miner-directory')
        <a href="{{ url('form?type=company-information') }}" class="btn btn-secondary mr-2">Previous</a>
        @if ($access['promotional_access'] == 1)
            <a href="{{ url('form?type=promotional') }}" class="btn btn-info">Next</a>
        @elseif ($access['eventpass_access'] == 1)
            <a href="{{ url('form?type=event-pass') }}" class="btn btn-info">Next</a>
        @elseif ($access['exhibition_access'] == 1)
            <a href="{{ url('form?type=exhibition') }}" class="btn btn-info">Next</a>
        @else
            {{-- Jika tidak ada akses lain, tampilkan tombol submit atau semacamnya --}}
        @endif
    @elseif($type == 'promotional')
        @if ($access['directory_access'] == 1)
            <a href="{{ url('form?type=indonesia-miner-directory') }}" class="btn btn-secondary mr-2">Previous</a>
        @else
            <a href="{{ url('form?type=company-information') }}" class="btn btn-secondary mr-2">Previous</a>
        @endif
        @if ($access['eventpass_access'] == 1)
            <a href="{{ url('form?type=event-pass') }}" class="btn btn-info">Next</a>
        @elseif ($access['exhibition_access'] == 1)
            <a href="{{ url('form?type=exhibition') }}" class="btn btn-info">Next</a>
        @else
            {{-- Jika tidak ada akses lain, tampilkan tombol submit atau semacamnya --}}
        @endif
    @elseif($type == 'event-pass')
        @if ($access['promotional_access'] == 1)
            <a href="{{ url('form?type=promotional') }}" class="btn btn-secondary mr-2">Previous</a>
        @else
            <a href="{{ url('form?type=indonesia-miner-directory') }}" class="btn btn-secondary mr-2">Previous</a>
        @endif
        @if ($access['exhibition_access'] == 1)
            <a href="{{ url('form?type=exhibition') }}" class="btn btn-info">Next</a>
        @endif
    @else
        @if ($access['directory_access'] == 1)
            <a href="{{ url('form?type=indonesia-miner-directory') }}" class="btn btn-secondary mr-2">Previous</a>
        @elseif ($access['eventpass_access'] == 1)
            <a href="{{ url('form?type=event-pass') }}" class="btn btn-secondary mr-2">Previous</a>
        @elseif($access['promotional_access'] == 1)
            <a href="{{ url('form?type=promotional') }}" class="btn btn-secondary mr-2">Previous</a>
        @else
            <a href="{{ url('form?type=indonesia-miner-directory') }}" class="btn btn-secondary mr-2">Previous</a>
        @endif
    @endif

    {{-- Ulangi logika serupa untuk tipe form lainnya sesuai kebutuhan --}}
</div>
