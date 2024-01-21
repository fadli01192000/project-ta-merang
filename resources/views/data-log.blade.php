@extends('layouts.main')

@section('content')
    <div class="row">
        <h4>Data List</h4>
        <div class="mb-xl-0 mb-4 mt-2">
            <table id="myTable" class="table table-bordered table-striped table-sm">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>21/01/2024 00:00</td>
                        <td>Aktif</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>21/01/2024 01:00</td>
                        <td>Aktif</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>21/01/2024 02:00</td>
                        <td>Aktif</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>21/01/2024 03:00</td>
                        <td>Tidak Aktif</td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>21/01/2024 04:00</td>
                        <td>Aktif</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('.li-data-log').addClass('active');

        $('#myTable').DataTable();
    </script>
@endsection
