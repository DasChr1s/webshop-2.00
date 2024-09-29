<div class="row ml-5 mr-5">
    <div class="col-md-12">
        <div class="">
            <div class="card-header">Bestellungen für den Monat <span class="font-weight-bold text-decoration-underline">{{ $currentMonthName }}</span></div>
            <div class="">
                <canvas id="orderChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var orderCounts = @json(array_values($orderCounts));
        var days = [...Array({{ $daysInMonth }}).keys()].map(i => i + 1);

        var ctx = $('#orderChart')[0].getContext('2d');
        
        var myChart = new Chart(ctx, {
            type: 'bar', 
            data: {
                labels: days, // Tage des Monats als Labels auf der X-Achse
                datasets: [{
                    label: 'Anzahl der Bestellungen',
                    data: orderCounts, // Bestellungen pro Tag
                    backgroundColor: [
                     
                        'rgba(255, 159, 64, 0.2)',   
                   
                    ],
                    borderColor: [
                  
                        'rgba(255, 159, 64, 1)',   
                       
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1 // Zeigt Schritte in ganzen Zahlen an
                        }
                    }
                }
            }
        });
    });
</script>
