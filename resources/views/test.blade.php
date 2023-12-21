<!DOCTYPE html>
<html>

<head>
    <title>Donut Chart with ApexCharts</title>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>

<body>

    <div id="chart"></div>

    <script>
        var options = {
            series: [75], // Persentase progress
            chart: {
                height: 350,
                type: 'radialBar',
            },
            plotOptions: {
                radialBar: {
                    hollow: {
                        size: '70%',
                    },
                    dataLabels: {
                        show: true,
                        name: {
                            show: false,
                        },
                        value: {
                            fontSize: '30px',
                            show: true,
                        }
                    }
                }
            },
            labels: ['Progress'],
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    </script>

</body>

</html>
