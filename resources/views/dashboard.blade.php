@extends('layouts.main')

@section('content')
    <div class="row">
        <h4>Kontrol</h4>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
            <div class="row">
                <div class="col-8">
                <div class="numbers">
                    <p class="text-lg mb-0 text-capitalize font-weight-bold">Kipas</p>
                    <h5 class="font-weight-bolder mb-0 setTxtKipas">Loading..</h5>
                </div>
                </div>
                <div class="col-4 text-end">
                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
            <div class="row">
                <div class="col-8">
                <div class="numbers">
                    <p class="text-lg mb-0 text-capitalize font-weight-bold">Lampu</p>
                    <h5 class="font-weight-bolder mb-0 setTxtLightDimmer">Loading..</h5>
                </div>
                </div>
                <div class="col-4 text-end">
                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
            <div class="row">
                <div class="col-8">
                <div class="numbers">
                    <p class="text-lg mb-0 text-capitalize font-weight-bold">Mist Maker</p>
                    <h5 class="font-weight-bolder mb-0 setTxtMistMaker">Loading..</h5>
                </div>
                </div>
                <div class="col-4 text-end">
                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>

    <div class="row mt-4">
        <h4>Sensor</h4>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
            <div class="row">
                <div class="col-8">
                <div class="numbers">
                    <p class="text-lg mb-0 text-capitalize font-weight-bold">Kelembapan udara</p>
                    <h5 class="font-weight-bolder mb-0 setTxtKelembaban">Loading..</h5>
                </div>
                </div>
                <div class="col-4 text-end">
                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
            <div class="row">
                <div class="col-8">
                <div class="numbers">
                    <p class="text-lg mb-0 text-capitalize font-weight-bold">LDR</p>
                    <h5 class="font-weight-bolder mb-0 setTxtLDR">Loading..</h5>
                </div>
                </div>
                <div class="col-4 text-end">
                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>

        <div class="col-xl-3 col-sm-6">
        <div class="card">
            <div class="card-body p-3">
            <div class="row">
                <div class="col-8">
                <div class="numbers">
                    <p class="text-lg mb-0 text-capitalize font-weight-bold">Suhu</p>
                    <h5 class="font-weight-bolder mb-0 setTxtSuhu">Loading..</h5>
                </div>
                </div>
                <div class="col-4 text-end">
                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                    <div class="numbers">
                        <p class="text-lg mb-0 text-capitalize font-weight-bold">CO2</p>
                        <h5 class="font-weight-bolder mb-0 setTxtCo2">Loading..</h5>
                    </div>
                    </div>
                    <div class="col-4 text-end">
                    <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                        <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
    </div>

    <h4 class="mt-3">Grafik Kelembapan</h4>
    <div id="c_kelembapan" class="mb-2" style="width:73%;height:300px;"></div>
    <h4 class="mt-3">Grafik LDR</h4>
    <div id="c_ldr" class="mb-2" style="width:73%;height:300px;"></div>
    <h4 class="mt-3">Grafik Suhu</h4>
    <div id="c_suhu" class="mb-2" style="width:73%;height:300px;"></div>
@endsection

@section('js')
    <script>
        $('.li-dashboard').addClass('active');

        // Grafik Kelembapan
        var kelembapanData = @json($temp_kelembapan);
        var xLabelsKelembapan = @json($temp_waktu);
        var g_kelembapan = document.getElementById('c_kelembapan');

        Plotly.newPlot(g_kelembapan, [{
            x: xLabelsKelembapan,
            y: kelembapanData
        }], {
            margin: { t: 0 }
        });

        // Grafik LDR
        var ldrData = @json($temp_ldr);
        var xLabelsldr = ['Hari 1', 'Hari 2', 'Hari 3', 'Hari 4', 'Hari 5', 'Hari 6', 'Hari 7', 'Hari 8', 'Hari 9', 'Hari 10'];
        var g_ldr = document.getElementById('c_ldr');

        Plotly.newPlot(g_ldr, [{
            x: xLabelsldr,
            y: ldrData
        }], {
            margin: { t: 0 }
        });

        // Grafik Suhu
        var suhuData = @json($temp_suhu);
        var xLabelsSuhu = ['Hari 1', 'Hari 2', 'Hari 3', 'Hari 4', 'Hari 5', 'Hari 6', 'Hari 7', 'Hari 8', 'Hari 9', 'Hari 10'];
        var g_suhu = document.getElementById('c_suhu');

        Plotly.newPlot(g_suhu, [{
            x: xLabelsSuhu,
            y: suhuData
        }], {
            margin: { t: 0 }
        });
    </script>
@endsection
