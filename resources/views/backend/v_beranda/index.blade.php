@extends('backend.v_layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Card Dashboard -->
        <div class="col-md-6 col-lg-3">
            <a href="{{ route('backend.admin.pengaduan') }}">
                <div class="card card-hover">
                    <div class="box bg-cyan text-center">
                        <h1 class="font-light text-white"><i class="bi bi-laptop"></i></h1>
                        <h4 class="text-white">Pengaduan</h4>
                        <span class="text-white aduanBaru">{{ $aduanBaru }} Aduan Baru</span>
                        <br>
                        <span class="text-white">Tangani segera!!!</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-3">
            <a href="{{ route('backend.admin.pengaduan') }}">
                <div class="card card-hover">
                    <div class="box bg-success text-center">
                        <h1 class="font-light text-white"><i class="bi bi-ui-checks"></i></h1>
                        <h4 class="text-white">Total Aduan</h4>
                        <span class="text-white aduanHariIni">Hari ini: {{ $aduanHariIni }} Aduan</span>
                        <br>
                        <span class="text-white aduanBulanIni">Bulan ini: {{ $aduanBulanIni }} Aduan</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-3">
            <a href="{{ route('backend.admin.pengaduan') }}">
                <div class="card card-hover">
                    <div class="box bg-warning text-center">
                        <h1 class="font-light text-white"><i class="bi bi-person-fill-check"></i></h1>
                        <h4 class="text-white">Aduan Diproses</h4>
                        <span class="text-white aduanDiprosesHariIni">Hari ini: {{ $aduanDiprosesHariIni }}</span>
                        <br><br>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-3">
            <a href="{{ route('backend.admin.pengaduan') }}">
                <div class="card card-hover">
                    <div class="box bg-danger text-center">
                        <h1 class="font-light text-white"><i class="bi bi-ban"></i></h1>
                        <h4 class="text-white">Aduan Ditolak</h4>
                        <span class="text-white aduanDitolakHariIni">Hari ini: {{ $aduanDitolakHariIni }}</span>
                        <br><br>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Chart Bar & Pie -->
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Pengaduan Hari ini</h5>
                    <canvas id="bars" style="height: 400px;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Pengaduan Bulan ini</h5>
                    <canvas id="pie" style="height: 400px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Kategori -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Berdasarkan Kategori Bulan Ini</h5>
                    <canvas id="kategoriBars" style="height: 400px;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Chart.js CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Mapping status ke label yang diinginkan
    function mapStatusLabel(status) {
        switch(status) {
            case 'belum ditangani': return 'Belum Ditangani';
            case 'diterima': return 'Diterima';
            case 'diproses': return 'Diproses';
            case 'ditolak': return 'Ditolak';
            case 'selesai': return 'Selesai';
            default: return status;
        }
    }

    // Chart Bar
    const barLabelsRaw = {!! json_encode($barData->keys()) !!};
    const barLabels = barLabelsRaw.map(mapStatusLabel);
    const barValues = {!! json_encode($barData->values()) !!};
    const barsChart = new Chart(document.getElementById('bars'), {
        type: 'bar',
        data: {
            labels: barLabels,
            datasets: [{
                label: 'Jumlah Pengaduan',
                data: barValues,
                backgroundColor: 'rgba(0, 188, 212, 0.7)'
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } }
        }
    });

    // Chart Pie
    const pieLabelsRaw = {!! json_encode($pieData->keys()) !!};
    const pieLabels = pieLabelsRaw.map(mapStatusLabel);
    const pieValues = {!! json_encode($pieData->values()) !!};
    const pieColors = ['#607d8b', '#00bcd4', '#ff9800', '#4caf50', '#f44336', '#9c27b0'];
    const pieChart = new Chart(document.getElementById('pie'), {
        type: 'pie',
        data: {
            labels: pieLabels,
            datasets: [{
                data: pieValues,
                backgroundColor: pieColors
            }]
        },
        options: {
            responsive: true
        }
    });

    // Chart Kategori
    const kategoriLabels = {!! json_encode($kategoriData->keys()) !!};
    const kategoriValues = {!! json_encode($kategoriData->values()) !!};
    const kategoriColors = ['#607d8b', '#00bcd4', '#4caf50', '#ff9800', '#f44336', '#9c27b0', '#795548', '#e91e63'];

    const kategoriChart = new Chart(document.getElementById('kategoriBars'), {
        type: 'bar',
        data: {
            labels: kategoriLabels,
            datasets: [{
                label: 'Jumlah Pengaduan',
                data: kategoriValues,
                backgroundColor: kategoriColors,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } }
        }
    });
</script>

{{-- Pusher & Echo --}}
<script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.15.0/echo.iife.js"></script>
<script>
window.Echo = new window.Echo({
    broadcaster: 'pusher',
    key: '{{ env('PUSHER_APP_KEY') }}',
    cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
    forceTLS: true
});

window.Echo.channel('dashboard')
    .listen('PengaduanUpdated', (e) => {
        updateDashboardData();
    });

function updateDashboardData() {
    fetch('{{ route('backend.admin.dashboard.data') }}')
        .then(res => res.json())
        .then(data => {
            // Update angka dashboard
            document.querySelector('.aduanBaru').textContent = data.aduanBaru + ' Aduan Baru';
            document.querySelector('.aduanDitolakHariIni').textContent = 'Hari ini: ' + data.aduanDitolakHariIni;
            document.querySelector('.aduanDiprosesHariIni').textContent = 'Hari ini: ' + data.aduanDiprosesHariIni;
            document.querySelector('.aduanHariIni').textContent = 'Hari ini: ' + data.aduanHariIni + ' Aduan';
            document.querySelector('.aduanBulanIni').textContent = 'Bulan ini: ' + data.aduanBulanIni + ' Aduan';

            // Update chart bar
            const barLabels = Object.keys(data.barData).map(mapStatusLabel);
            barsChart.data.labels = barLabels;
            barsChart.data.datasets[0].data = Object.values(data.barData);
            barsChart.update();

            // Update chart pie
            const pieLabels = Object.keys(data.pieData).map(mapStatusLabel);
            pieChart.data.labels = pieLabels;
            pieChart.data.datasets[0].data = Object.values(data.pieData);
            pieChart.update();

            // Update chart kategori
            const kategoriLabels = Object.keys(data.kategoriData);
            kategoriChart.data.labels = kategoriLabels;
            kategoriChart.data.datasets[0].data = Object.values(data.kategoriData);
            kategoriChart.update();
        });
}
</script>
@endsection
