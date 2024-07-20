@extends('layouts.main')

@section('content')
    <div class="row">
        <h4>Data List</h4>
        <div class="mb-xl-0 mb-4 mt-2">
            <table id="datatable" class="table table-bordered table-striped table-sm display">
                <thead>
                    <tr>
                        <th style="text-align: center">No.</th>
                        <th style="text-align: center">Tanggal & Waktu</th>
                        <th style="text-align: center">Kipas</th>
                        <th style="text-align: center">Lampu</th>
                        <th style="text-align: center">Mist Maker</th>
                        <th style="text-align: center">Kelembaban</th>
                        <th style="text-align: center">LDR</th>
                        <th style="text-align: center">Suhu</th>
                        <th style="text-align: center">CO2</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $value)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $value['d_waktu'] }}</td>
                        <td>{{ $value['d_kipas'] ? 'ON' : 'OFF' }}</td>
                        <td>{{ $value['d_light'] ? 'ON' : 'OFF' }}</td>
                        <td>{{ $value['d_mistmaker'] ? 'ON' : 'OFF' }}</td>
                        <td>{{ $value['d_kelembapan'] }} %</td>
                        <td>{{ $value['d_lux'] }}</td>
                        <td>{{ $value['d_suhu'] }}°</td>
                        <td>{{ $value['d_ppm'] }}°</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('.li-data-log').addClass('active');

        $(document).ready(function() {
            console.log('Initializing DataTable');
            $('#datatable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: 'Export to Excel',
                        className: 'btn btn-success'
                    }
                ]
            });
            console.log('DataTable initialized');
        });
    </script>
@endsection
