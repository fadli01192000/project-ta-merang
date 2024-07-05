@extends('layouts.main')

@section('content')
    <h1>Halaman Pengaturan</h1>
    <div class="row mt-3">
        <div class="col-sm-12 mb-3">
            <div class="card shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3>Otomatis</h3>
                        </div>
                        <div class="col-sm-6 mt-2" style="text-align: right">
                            <button type="button" class="btn btn-danger b-otomatis">TIDAK AKTIF</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card shadow">
                <div class="card-body">
                    <h3>Mist Maker</h3>
                    <span>Status : <button class="btn btn-success btn-sm mt-3 b-mist">ON</button></span>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card shadow">
                <div class="card-body">
                    <h3>Kipas</h3>
                    <span>Status : <button class="btn btn-danger btn-sm mt-3 b-kipas">OFF</button></span>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card shadow">
                <div class="card-body">
                    <h3>Lampu</h3>
                    <span>Status : <button class="btn btn-success btn-sm mt-3 b-lampu">ON</button></span>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('.li-pengaturan').addClass('active');

        var database = firebase.database();

        function updateButtonState(b_kipas, b_lampu, b_mist) {
            if (b_mist) {
                $(".b-mist").removeClass("btn-danger").addClass("btn-success").text("ON");
            } else {
                $(".b-mist").removeClass("btn-success").addClass("btn-danger").text("OFF");
            }

            if (b_kipas) {
                $(".b-kipas").removeClass("btn-danger").addClass("btn-success").text("ON");
            } else {
                $(".b-kipas").removeClass("btn-success").addClass("btn-danger").text("OFF");
            }

            if (b_lampu) {
                $(".b-lampu").removeClass("btn-danger").addClass("btn-success").text("ON");
            } else {
                $(".b-lampu").removeClass("btn-success").addClass("btn-danger").text("OFF");
            }
        }

        function toggleDisableButtons(disabled) {
            if (disabled) {
                $(".b-mist, .b-kipas, .b-lampu").attr("disabled", true);
            } else {
                $(".b-mist, .b-kipas, .b-lampu").attr("disabled", false);
            }
        }

        database.ref('Kontrol').on("value", function(snap) {
            var b_kipas = snap.val().kipas;
            var b_lampu = snap.val().light;
            var b_mist = snap.val().mistmaker;
            var b_otomatis = snap.val().otomatis;

            if (b_otomatis) {
                $(".b-otomatis").removeClass("btn-danger").addClass("btn-success").text("AKTIF");
            } else {
                $(".b-otomatis").removeClass("btn-success").addClass("btn-danger").text("TIDAK AKTIF");
            }

            toggleDisableButtons(b_otomatis);
            updateButtonState(b_kipas, b_lampu, b_mist);
        });

        $(".b-otomatis").click(function() {
            var b_otomatis = !$(this).hasClass("btn-success");
            updateFirebaseStatus('otomatis', b_otomatis);
        });

        $(".b-mist").click(function() {
            if (!$(".b-otomatis").hasClass("btn-success")) {
                var b_mist = $(this).hasClass("btn-success") ? false : true;
                updateFirebaseStatus('mistmaker', b_mist);
            }
        });

        $(".b-kipas").click(function() {
            if (!$(".b-otomatis").hasClass("btn-success")) {
                var b_kipas = $(this).hasClass("btn-success") ? false : true;
                updateFirebaseStatus('kipas', b_kipas);
            }
        });

        $(".b-lampu").click(function() {
            if (!$(".b-otomatis").hasClass("btn-success")) {
                var b_lampu = $(this).hasClass("btn-success") ? false : true;
                updateFirebaseStatus('light', b_lampu);
            }
        });

        function updateFirebaseStatus(device, status) {
            var updates = {};
            updates[device] = status;
            database.ref('Kontrol').update(updates)
                .then(function() {
                    console.log("Status updated successfully!");
                })
                .catch(function(error) {
                    console.error("Error updating status: ", error);
                });
        }
    </script>
@endsection
