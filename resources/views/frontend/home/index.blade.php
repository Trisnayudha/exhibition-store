@extends('index')

@section('content')
    <div class="container-fluid mt-2">

        <div class="card">
            <div class="card-body">

                <h1>Form Progress</h1>
                <div class="row">
                    <div class="col-sm-3">
                        <a href="{{ url('form?type=company-information') }}">
                            <div class="card border-primary mb-2">
                                <div class="card-header">Company Information</div>
                                <div class="card-body position-relative">
                                    <canvas id="companyInformationChart" width="100" height="100"></canvas>
                                    <div class="progress-text"></div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-3">
                        <a href="{{ url('form?type=indonesia-miner-directory') }}">
                            <div class="card border-success mb-2">
                                <div class="card-header">Indonesia Miner Directory</div>
                                <div class="card-body position-relative">
                                    <canvas id="minerDirectoryChart" width="100" height="100"></canvas>
                                    <div class="progress-text"></div>
                                </div>
                            </div>
                        </a>

                    </div>
                    @if ($access['promotional_access'] == 1)
                        <div class="col-sm-3">
                            <a href="form?type=promotional">
                                <div class="card border-success mb-2">
                                    <div class="card-header">Promotional</div>
                                    <div class="card-body position-relative">
                                        <canvas id="promotionalChart" width="100" height="100"></canvas>
                                        <div class="progress-text"></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                    @if ($access['eventpass_access'] == 1)
                        <div class="col-sm-3">
                            <a href="{{ url('form?type=event-pass') }}">
                                <div class="card border-success mb-2">
                                    <div class="card-header">Event Pass</div>
                                    <div class="card-body position-relative">
                                        <canvas id="eventPassChart" width="100" height="100"></canvas>
                                        <div class="progress-text"></div>
                                    </div>
                                </div>
                            </a>

                        </div>
                    @endif
                    @if ($access['exhibition_access'] == 1)
                        <div class="col-sm-3">
                            <a href="{{ url('form?type=exhibition') }}">

                                <div class="card border-success mb-2">
                                    <div class="card-header">Exhibition</div>
                                    <div class="card-body position-relative">
                                        <canvas id="exhibitionChart" width="100" height="100"></canvas>
                                        <div class="progress-text"></div>
                                    </div>
                                </div>
                            </a>

                        </div>
                    @endif

                    <!-- Add similar blocks for other cards -->

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script>
        // Function to create doughnut chart
        // Function to create doughnut chart
        function createDoughnutChart(chartId, dataValue, label) {
            // Tentukan warna berdasarkan persentase
            var backgroundColor = getWarnaBerdasarkanPersentase(dataValue);

            var ctx = document.getElementById(chartId).getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [dataValue, 100 - dataValue],
                        backgroundColor: [backgroundColor, '#E0E0E0'],
                    }],
                    labels: [label, ''],
                },
                options: {
                    cutout: '70%', // Sesuaikan cutout untuk mengontrol ukuran lubang tengah
                    plugins: {
                        datalabels: {
                            display: false, // Sembunyikan label
                            formatter: (value, context) => {
                                return value + '%';
                            },
                            color: '#fff',
                            font: {
                                size: '20',
                                weight: 'bold'
                            }
                        }
                    },
                    legend: {
                        display: false // Sembunyikan legend
                    }
                }
            });

            // Tampilkan persentase di tengah chart
            var progressText = document.createElement('div');
            progressText.className = 'progress-text';
            progressText.innerHTML = dataValue + '%';
            ctx.canvas.parentNode.appendChild(progressText);
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
        createDoughnutChart('promotionalChart', {{ $countPromotional }}, 'Promotional');
        createDoughnutChart('eventPassChart', 30, 'Miner Directory');
        createDoughnutChart('exhibitionChart', 10, 'Exhibition');
        // Panggil fungsi serupa untuk chart lainnya
    </script>

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
@endsection
