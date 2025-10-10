@extends('index')

@section('content')
    <div class="container-fluid mt-2">
        <div class="card">
            <div class="card-body">
                <img src="{{ asset('images/homepage_new.png') }}" alt="" width="100%" style="border-radius:20px"
                    height="0%" class="mb-2">
                <div class="alert alert-primary" role="alert">
                    <h4 class="alert-heading"> Welcome to the Sponsor & Exhibitor Portal for Indonesia Miner Conference &
                        Exhibition 2026!
                    </h4>
                    <p>

                        This portal is your central hub for managing all aspects of your participation in the event.

                    </p>
                    <p>
                        Here, you can:
                    </p>
                    <ul>
                        <li>
                            Submit all necessary details and key information related to your package.
                        </li>
                        <li>
                            Purchase additional event passes at special discounted rates to bring more team members or
                            guests to the conference.
                        </li>
                        <li>
                            Arrange extra exhibition needs (such as furniture, equipment, or other booth essentials) not
                            included in your participation package.
                        </li>
                    </ul>
                    <p>
                        🔔 Important:
                        <br>
                        Each form comes with its own deadline. Please ensure all submissions are completed on time. If you
                        foresee any delays or need help or an extension, just let our operational team know.

                    </p>
                    <p>We’re thrilled to have you on board and truly appreciate your involvement in the event!
                    </p>
                    <hr>
                    <p style="margin-bottom: 0px;">
                        The Operational Team
                    </p>
                    <p style="margin-top: 0px">
                        Indonesia Miner Conference & Exhibition 2026
                    </p>
                </div>
                <h1>Form Progress</h1>
                <div class="row justify-content-center"> <!-- Menyelaraskan ke tengah -->
                    <div class="col-sm-2 mb-2">
                        <a href="{{ url('form?type=company-information') }}">
                            <div class="card border-info">
                                <div class="card-header" style="font-size: 14px;">Company Information</div>
                                <div class="card-body position-relative">
                                    <div id="companyInformationChart" width="100" height="100"></div>
                                    <div class="progress-text"></div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @if ($access['directory_access'] == 1)
                        <div class="col-sm-2 mb-2">
                            <a href="{{ url('form?type=indonesia-miner-directory') }}">
                                <div class="card border-info">
                                    <div class="card-header" style="font-size: 14px;">Indonesia Miner Directory</div>
                                    <div class="card-body position-relative">
                                        <div id="minerDirectoryChart" width="100" height="100"></div>
                                        <div class="progress-text"></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                    @if ($access['promotional_access'] == 1)
                        <div class="col-sm-2 mb-2">
                            <a href="form?type=promotional">
                                <div class="card border-info">
                                    <div class="card-header" style="font-size: 14px;">Promotional</div>
                                    <div class="card-body position-relative">
                                        <div id="promotionalChart" width="100" height="100"></div>
                                        <div class="progress-text"></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                    @if ($access['eventpass_access'] == 1)
                        <div class="col-sm-2 mb-2">
                            <a href="{{ url('form?type=event-pass') }}">
                                <div class="card border-info">
                                    <div class="card-header" style="font-size: 14px;">Event Pass</div>
                                    <div class="card-body position-relative">
                                        <div id="eventPassChart" width="100" height="100"></div>
                                        <div class="progress-text"></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                    @if ($access['exhibition_access'] == 1)
                        <div class="col-sm-2 mb-2">
                            <a href="{{ url('form?type=exhibition') }}">
                                <div class="card border-info">
                                    <div class="card-header" style="font-size: 14px;">Exhibition</div>
                                    <div class="card-body position-relative">
                                        <div id="exhibitionChart" width="100" height="100"></div>
                                        <div class="progress-text"></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @include('frontend.home.general-information')
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <script>
        // Function to create doughnut chart
        function createDoughnutChart(chartId, dataValue, label) {
            var options = {
                series: [dataValue, 100 - dataValue],
                chart: {
                    type: 'donut',
                },
                labels: [label, ''],
                colors: [getWarnaBerdasarkanPersentase(dataValue), '#E0E0E0'],
                dataLabels: {
                    enabled: false, // Sembunyikan label
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '70%', // Sesuaikan cutout untuk mengontrol ukuran lubang tengah
                        }
                    }
                },
                legend: {
                    show: false, // Sembunyikan legend
                },
            };

            var chart = new ApexCharts(document.querySelector("#" + chartId), options);
            chart.render();

            // Tampilkan persentase di tengah chart
            var progressText = document.createElement('div');
            progressText.className = 'progress-text';
            progressText.innerHTML = dataValue + '%';
            document.querySelector("#" + chartId).appendChild(progressText);
        }

        // Fungsi untuk mendapatkan warna berdasarkan persentase
        function getWarnaBerdasarkanPersentase(persentase) {
            if (persentase < 30) {
                return '#FF4F4F'; // Merah
            } else if (persentase < 50) {
                return '#FFD700'; // Kuning
            } else if (persentase < 80) {
                return '#4F94CD'; // Biru
            } else {
                return '#2ECC71'; // Hijau
            }
        }

        // Panggil fungsi untuk setiap chart
        createDoughnutChart('companyInformationChart', {{ $countCompany }}, 'Company Info');
        @if ($access['directory_access'] == 1)
            createDoughnutChart('minerDirectoryChart', {{ $countMiningDirectory }}, 'Miner Directory');
        @endif
        @if ($access['promotional_access'] == 1)
            createDoughnutChart('promotionalChart', {{ $countPromotional }}, 'Promotional');
        @endif
        @if ($access['eventpass_access'] == 1)
            createDoughnutChart('eventPassChart', {{ $countEventPass }}, 'Miner Directory');
        @endif
        @if ($access['exhibition_access'] == 1)
            createDoughnutChart('exhibitionChart', {{ $countExhibition }}, 'Exhibition');
        @endif
    </script>
@endsection

@push('top')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <style>
        .progress-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: black;
            font-size: 20px;
            font-weight: bold;
        }
    </style>
@endpush
