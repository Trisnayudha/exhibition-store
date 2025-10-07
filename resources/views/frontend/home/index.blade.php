@extends('index')

@section('content')
    <div class="container-fluid mt-2">
        <div class="card">
            <div class="card-body">
                <img src="https://sin1.contabostorage.com/ee5317510fad4e33b9e308839348b77b:indonesiaminer/web/img/topbannerwestin.png"
                    alt="" width="100%" style="border-radius:20px" height="0%" class="mb-2">
                <div class="alert alert-primary" role="alert">
                    <h4 class="alert-heading"> Welcome to the Indonesia Miner Conference & Exhibition 2025 Sponsor &
                        Exhibitor Portal - your
                        all-in-one platform for submitting key information related to your participation package.</h4>
                    <p>
                        This platform also allows you to purchase additional event passes at a special discounted rate, as
                        well
                        as rent exhibition items, ensuring you have everything you need before the event days.
                    </p>
                    <p>
                        Please note that each form has its own deadline. Kindly ensure that you complete and submit them
                        before
                        the specified date. If you encounter any issues requiring a late submission, we ask that you notify
                        our
                        operational team promptly, as delays in submission may affect the processing timeline.
                    </p>
                    <p>
                        In addition to the above, we are excited about your participation in our upcoming event. We truly
                        appreciate your support and attention to this matter.
                    </p>
                    <hr>
                    <p style="margin-bottom: 0px;">
                        The Operational Team
                    </p>
                    <p style="margin-top: 0px">
                        Indonesia Miner Conference & Exhibition 2025
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
