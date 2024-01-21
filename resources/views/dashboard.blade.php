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
                    <h5 class="font-weight-bolder mb-0">
                    OFF
                    </h5>
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
                    <p class="text-lg mb-0 text-capitalize font-weight-bold">Light Dimmer</p>
                    <h5 class="font-weight-bolder mb-0">
                    0%
                    </h5>
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
                    <h5 class="font-weight-bolder mb-0">
                    OFF
                    </h5>
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
                    <p class="text-lg mb-0 text-capitalize font-weight-bold">Kelembaban</p>
                    <h5 class="font-weight-bolder mb-0">
                    0%
                    </h5>
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
                    <h5 class="font-weight-bolder mb-0">
                    0%
                    </h5>
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
                    <p class="text-lg mb-0 text-capitalize font-weight-bold">PH</p>
                    <h5 class="font-weight-bolder mb-0">
                    0%
                    </h5>
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

        <div class="col-xl-3 col-sm-6">
        <div class="card">
            <div class="card-body p-3">
            <div class="row">
                <div class="col-8">
                <div class="numbers">
                    <p class="text-lg mb-0 text-capitalize font-weight-bold">Suhu</p>
                    <h5 class="font-weight-bolder mb-0">
                    0%
                    </h5>
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
@endsection

@section('js')
    <script>
        $('.li-dashboard').addClass('active');
    </script>
@endsection
