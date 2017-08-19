@extends('layouts.admin')

@section('content')
<div class="container">
    <!--
    <div class="panel panel-default">
        <div class="panel-heading">Dashboard</div>

        <div class="panel-body">
            You are logged in!
        </div>
    </div>
    -->
    <!-- Info alert -->
    <div class="alert alert-info alert-styled-left alert-arrow-left alert-component">
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
        <h6 class="alert-heading text-semibold"><strong>Home</strong> - Dashboard</h6>
        Please select your menu
    </div>
    <!-- /info alert -->

    <div class="row">
        <div class="col-lg-4">
            <!-- Members online -->
            <div class="panel bg-teal-400">
                <div class="panel-body">
                    <h3 class="no-margin" id="divPelanggan"></h3>
                    Pelanggan
                </div>
                <div class="container-fluid">
                    <!--
                    <div id="divPelanggan"></div>
                    -->
                </div>
            </div>
            <!-- /members online -->
        </div>

        <div class="col-lg-4">
            <!-- Current server load -->
            <div class="panel bg-pink-400">
                <div class="panel-body">
                    <h3 class="no-margin" id="sumPemeriksaan"></h3>
                    Pemeriksaan
                </div>
                <div id="divPemeriksaan"></div>
            </div>
            <!-- /current server load -->
        </div>

        <div class="col-lg-4">
            <!-- Today's revenue -->
            <div class="panel bg-blue-400">
                <div class="panel-body">
                    <h3 class="no-margin" id="sumTindakan"></h3>
                    Tindakan
                </div>
                <div id="divTindakan"></div>
            </div>
            <!-- /today's revenue -->
        </div>
    </div>

    <!-- TOP -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title">Total Tindakan Per Pelanggan</h6>
        </div>
        <div class="panel-body">
            <table class="table table-striped" id="data"></table>
        </div>
    </div>
    <!-- END TOP -->
</div>
@endsection

@section('js')
    <script>
        $(function(){
            function showPelanggan(){
                $.ajax({
                    url:"{{URL::to('home')}}",
                    type:"GET",
                    success:function(result){
                        $("#divPelanggan").empty().html(result.pelanggan);
                        $("#sumPemeriksaan").empty().html(result.pemeriksaan);
                        $("#sumTindakan").empty().html(result.tindakan);
                    },
                    error:function(){
                        alert('link pelanggan not found');
                    }
                })
            }

            function topPelanggan(){
                $('#data').DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: true,
                    destroy: true,
                    ajax: "{{URL::to('top-pelanggan')}}",
                    columns: [
                        {data: 'no', name: 'no',title:'No.'},
                        {data: 'id_pelanggan', name: 'id_pelanggan',title:'ID Pelanggan'},
                        {data: 'nama', name: 'nama',title:'Nama'},
                        {data: 'alamat', name: 'alamat',title:'Alamat'},
                        {data: 'sum', name:'sum', title:'Total Pemeriksaan'}
                    ]
                }); 

                // Launch Uniform styling for checkboxes
                $('.ColVis_Button').addClass('btn btn-primary btn-icon').on('click mouseover', function() {
                    $('.ColVis_collection input').uniform();
                });


                // Add placeholder to the datatable filter option
                $('.dataTables_filter input[type=search]').attr('placeholder', 'Type to filter...');


                // Enable Select2 select for the length option
                $('.dataTables_length select').select2({
                    minimumResultsForSearch: "-1"
                }); 
            }

            showPelanggan();
            topPelanggan();
        })
    </script>
@stop
