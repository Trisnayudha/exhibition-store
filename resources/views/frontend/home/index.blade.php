@extends('index')

@section('content')
    <div class="container-fluid mt-2">
        <div class="card">
            <div class="card-body">
                <img src="https://indonesiaminer.com/img/topbannerwestin.png" alt="" width="100%"
                    style="border-radius:20px" height="0%" class="mb-2">
                <div class="alert alert-primary" role="alert">
                    <h4 class="alert-heading">Welcome to Indonesia Miner Conference & Exhibition 2024 - Sponsor & Exhibitor
                        Portal!</h4>
                    <p>This portal is a dedicated platform for sponsors and exhibitors to submit information related to the
                        operational requirements of Indonesia Miner Conference & Exhibition 2024. This portal enables you to
                        submit company information, promotional materials, event passes, and exhibition-related information.
                        Furthermore, the portal also allows for the purchase of additional event passes with special price
                        and the rental of exhibition items.</p>
                    <p>Please note that each form has a submission deadline. We kindly ask you to fill out the form before
                        the deadline. In case there are urgent conditions that require you to submit afterwards, please
                        confirm beforehand with our operational team. Late submission may cause delays for our team in
                        processing your request.</p>
                    <p>Once again, thank you for your support and understanding. We look forward to working with you.</p>
                    <hr>
                    <p class="mb-0">The Operational Team</p>
                    <p>Indonesia Miner Conference & Exhibition 2024</p>
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
        createDoughnutChart('minerDirectoryChart', {{ $countMiningDirectory }}, 'Miner Directory');
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
