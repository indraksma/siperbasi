@section('title', 'Survey Kepuasan')
@push('headscripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush
@push('footscripts')
    <script>
        const chart = new Chart(
            document.getElementById('chart'), {
                type: 'doughnut',
                data: {
                    labels: @json($labels),
                    datasets: @json($dataset)
                },
                options: {
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    },
                    responsive: true,
                    // scales: {
                    //     x: {
                    //         stacked: true,
                    //     },
                    //     y: {
                    //         stacked: true
                    //     }
                    // }
                }
            }
        );
    </script>
@endpush
<div>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Survey Kepuasan</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Survey</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <canvas id="chart"></canvas>
                            </div>
                            <div class="col-md-6">
                                <h5>10 Hasil Survey Terbaru</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr class="text-center">
                                                <th>Waktu, Tanggal</th>
                                                <th>Hasil Survey</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($survey->isNotEmpty())
                                                @foreach ($survey as $data)
                                                    <tr class="text-center">
                                                        <td style="padding: 4px;">
                                                            {{ \Carbon\Carbon::parse($data->created_at)->format('H:i, d/m/Y') }}
                                                        </td>
                                                        <td style="padding: 4px;">
                                                            @if ($data->survey == 4)
                                                                <span class="badge badge-primary">Sangat
                                                                    Memuaskan</span>
                                                            @elseif($data->survey == 3)
                                                                <span class="badge badge-info">Memuaskan</span>
                                                            @elseif($data->survey == 2)
                                                                <span class="badge badge-warning">Cukup Memuaskan</span>
                                                            @elseif($data->survey == 1)
                                                                <span class="badge badge-secondary">Kurang
                                                                    Memuaskan</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr class="text-center">
                                                    <td colspan="2">Belum Ada Data</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
