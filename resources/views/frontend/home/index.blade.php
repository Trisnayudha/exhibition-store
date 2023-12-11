@extends('index')

@section('content')
    <div class="container-fluid mt-2">

        <div class="card">
            <div class="card-body">

                <h1>Form Progress</h1>
                <div class="row">
                    <div class="col-sm-3">

                        <div class="card border-primary mb-2">
                            <div class="card-header">Company Information</div>
                            <div class="card-body position-relative">
                                <canvas id="companyInformationChart" width="100" height="100"></canvas>
                                <div class="progress-text">75%</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">

                        <div class="card border-success mb-2">
                            <div class="card-header">Indonesia Miner Directory</div>
                            <div class="card-body position-relative">
                                <canvas id="minerDirectoryChart" width="100" height="100"></canvas>
                                <div class="progress-text">50%</div>
                            </div>
                        </div>
                    </div>
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
        function createDoughnutChart(chartId, dataValue, label, backgroundColor) {
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
                    cutout: '70%', // Adjust the cutout to control the size of the center hole
                    plugins: {
                        datalabels: {
                            display: false, // Hide the labels
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
                        display: false // Hide the legend
                    }
                }
            });

            // Ensure the legend is hidden
            myChart.legend.options.display = false;
        }





        // Call the function for each chart
        createDoughnutChart('companyInformationChart', 75, 'Company Info', '#007BFF'); // Change this color
        createDoughnutChart('minerDirectoryChart', 50, 'Miner Directory', '#28A745'); // Change this color
        // Call similar functions for other charts
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
