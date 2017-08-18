@extends('layouts.admin')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title">Data Pembayaran</div>
        </div>

        <div class="panel-body">
            <a href="#" class="btn btn-primary" id="tambah">
                <i class="icon-add"></i> Add New Pembayaran
            </a>
            
            <table class="table table-striped" id="data"></table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" data-backdrop="static" data-keyboard="false">
        <form name="form" id="form" class="form-horizontal" onsubmit="return false;" enctype="multipart/form-data" method="post" accept-charset="utf-8">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add New Pemeriksaan</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="" class="col-lg-4 control-label">No. Pembayaran</label>             
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" id="pembayaran" name="pembayaran"  readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="" class="col-lg-4 control-label">Tgl. Pembayaran</label>             
                                <div class="col-lg-8">
                                    <div class="input-group date">
                                        <input type="text" name="tanggal" class="form-control daterange-basic" value="{{date('d-m-Y')}}" name="tanggal" id="tanggal" required>
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <hr>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div id="divPemeriksaan"></div>

                                    <div class="form-group">
                                        <label for="" class="col-lg-4 control-label">Tgl. Pemeriksaan</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="tglpemeriksaan" name="tglpemeriksaan" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="" class="col-lg-4 control-label">Tarif</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="tarif" name="tarif" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="" class="col-lg-4 control-label">ID Pelanggan</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="pelanggan" name="pelanggan" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="" class="col-lg-4 control-label">Nama Pelanggan</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="nama" name="nama" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="" class="col-lg-4 control-label">Daya</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="daya" name="daya" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="" class="col-lg-2 control-label">Hasil Pemeriksaan</label>
                                <div class="col-lg-10">
                                    <input type="text" name="hasil" id="hasil" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-lg-2 control-label">Saving KWH</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="saving" id="saving" placeholder="Saving KWH" readonly>
                                    <input type="hidden" class="form-control" name="type" id="type" placeholder="Saving KWH">
                                </div>
                            </div>
                            <hr>

                            <div class="form-group">
                                <label for="" class="col-lg-2 control-label">Biaya Beban</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="beban" id="beban" placeholder="Beban" required readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-lg-2 control-label">Rp. Bayar</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="biaya" id="biaya" placeholder="Rp. Bayar" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="pesan"></div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
        </form>
    </div>
@stop

@section('js')
    <script>
        $(function(){
            var kode="";

            $.extend( $.fn.dataTable.defaults, {
                autoWidth: false,
                columnDefs: [{ 
                    orderable: false,
                    width: '100px',
                    targets: [ 5 ]
                }],
                dom: '<"datatable-header"fCl><"datatable-scroll"t><"datatable-footer"ip>',
                language: {
                    search: '<span>Filter:</span> _INPUT_',
                    lengthMenu: '<span>Show:</span> _MENU_',
                    paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
                },
                drawCallback: function () {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
                },
                preDrawCallback: function() {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
                }
            });

            function getIdPemeriksaan(type){
                $.ajax({
                    url:"{{URL::to('get-id')}}",
                    data:"type="+type,
                    type:"GET",
                    success:function(result){
                        $("#pembayaran").val(result);
                    }
                })
            }


            function showData(){
                $('#data').DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    destroy: true,
                    ajax: "{{URL::to('pembayaran')}}",
                    columns: [
                        {data:'no',name:'no',title:'No',searchable:false},
                        {data: 'id_pembayaran', name: 'id_pembayaran',title:'No. Pembayaran'},
                        {data: 'tgl_pembayaran', name: 'tgl_pembayaran',title:'Tgl Pembayaran'},
                        {data: 'no_agenda', name: 'no_agenda',title:'No. Agenda'},
                        {data: 'biaya_beban', name: 'biaya_beban',title:'Biaya Beban'},
                        {data: 'rp_bayar', name: 'rp_bayar',title:'Rp. Bayar'},
                        //{data: 'edit', name: 'edit',title:'',searchable:false},
                        {data: 'action', name: 'action',title:'',searchable:false,width:'7%'}
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

            function kosong(){
                $("#type").val("edit");
                $("#tanggal").val("{{date('d-m-Y')}}");
                $("#pelanggan").val('');
                $("#nama").val('');
                $("#tglpemeriksaan").val('');
                $("#hasil").val('');
                $("#saving").val('');
                $("#biaya").val('');
                $("#biaya").prop("disabled",true);
                $("#pesan").empty();
                $("#tarif").val('');
                getIdPemeriksaan('pembayaran');
            }

            $(document).on("click","#tambah",function(){
                $.ajax({
                    url:"{{URL::to('list-pembayaran')}}",
                    type:"GET",
                    beforeSend:function(){
                        kosong();
                    },
                    success:function(result){
                        var el="";
                        el+='<div class="form-group">'+
                            '<label class="col-lg-4 control-label">No. Agenda</label>'+
                            '<div class="col-lg-8">'+
                                '<select class="select2" id="agenda" name="agenda">'+
                                    '<option value="" selected>--Select Agenda--</option>';
                                    $.each(result,function(a,b){
                                        el+="<option value='"+b.no_agenda+"'>"+b.no_agenda+"</option>";
                                    })
                                el+='</select>'+
                            '</div>'+
                        '</div>';

                        $("#divPemeriksaan").empty().html(el);

                        $('.select2').select2();
                        $("#myModal").modal("show");
                        $("#type").val("add");
                        $('.daterange-basic').datepicker();
                        $("#biaya").prop("disabled",false);
                    }
                })
            })

            $(document).on("change","#agenda",function(){
                var agenda=$("#agenda option:selected").val();

                $.ajax({
                    url:"{{URL::to('pemeriksaan')}}/"+agenda,
                    type:"GET",
                    success:function(result){
                        var beban=result.list.pelanggan.dayas.rp_per_kva*result.list.pelanggan.daya/1000;

                        var tarif=result.list.pelanggan.dayas.kd_tarif;
                        var hasil=result.list.hasil_pemeriksaan;
                        var daya=result.list.pelanggan.daya;
                        var biaya=0;
                        var rekmin=0;

                        switch(hasil){
                            case "P1":
                                    switch(tarif){
                                        case "S2":
                                                switch(daya){
                                                    case "450":
                                                    case "900":
                                                            //=6*(2*DAYA TERSAMBUNG/1000)*BIAYA BEBAN)
                                                            biaya=6*(2*daya/1000)*beban;
                                                            $("#biaya").val(biaya);
                                                        break;
                                                    default:
                                                            //=6 X (2 X Rekening Minimum (Rupiah) pelanggan sesuai Tarif Tenaga Listrik).

                                                            //rekmin=$rp=40*$query->daya*$query->dayas->rp_per_kwh/1000;
                                                            rekmin=40*daya*result.list.pelanggan.dayas.rp_per_kwh/1000;

                                                            biaya=6*(2*rekmin);
                                                            $("#biaya").val(biaya);
                                                        break;
                                                }
                                            break;
                                        case "R1":
                                                switch(daya){
                                                    case "450":
                                                    case "900":
                                                            //=6*(2*DAYA TERSAMBUNG/1000)*BIAYA BEBAN)
                                                            biaya=6*(2*daya/1000)*beban;
                                                            $("#biaya").val(biaya);
                                                        break;
                                                    default:
                                                            //=6 X (2 X Rekening Minimum (Rupiah) pelanggan sesuai Tarif Tenaga Listrik).

                                                            //rekmin=$rp=40*$query->daya*$query->dayas->rp_per_kwh/1000;
                                                            rekmin=40*daya*result.list.pelanggan.dayas.rp_per_kwh/1000;

                                                            biaya=6*(2*rekmin);
                                                            $("#biaya").val(biaya);
                                                        break;
                                                }
                                            break;
                                        case "B1":
                                                switch(daya){
                                                    case "450":
                                                    case "900":
                                                            //=6*(2*DAYA TERSAMBUNG/1000)*BIAYA BEBAN)
                                                            biaya=6*(2*daya/1000)*beban;
                                                            $("#biaya").val(biaya);
                                                        break;
                                                    default:
                                                            //=6 X (2 X Rekening Minimum (Rupiah) pelanggan sesuai Tarif Tenaga Listrik).

                                                            //rekmin=$rp=40*$query->daya*$query->dayas->rp_per_kwh/1000;
                                                            rekmin=40*daya*result.list.pelanggan.dayas.rp_per_kwh/1000;

                                                            biaya=6*(2*rekmin);
                                                            $("#biaya").val(biaya);
                                                        break;
                                                }
                                            break;
                                        case "l1":
                                                switch(daya){
                                                    case "450":
                                                    case "900":
                                                            //=6*(2*DAYA TERSAMBUNG/1000)*BIAYA BEBAN)
                                                            biaya=6*(2*daya/1000)*beban;
                                                            $("#biaya").val(biaya);
                                                        break;
                                                    default:
                                                            //=6 X (2 X Rekening Minimum (Rupiah) pelanggan sesuai Tarif Tenaga Listrik).

                                                            //rekmin=$rp=40*$query->daya*$query->dayas->rp_per_kwh/1000;
                                                            rekmin=40*daya*result.list.pelanggan.dayas.rp_per_kwh/1000;

                                                            biaya=6*(2*rekmin);
                                                            $("#biaya").val(biaya);
                                                        break;
                                                }
                                            break;
                                        case "P1":
                                                switch(daya){
                                                    case "450":
                                                    case "900":
                                                            //=6*(2*DAYA TERSAMBUNG/1000)*BIAYA BEBAN)
                                                            biaya=6*(2*daya/1000)*beban;
                                                            $("#biaya").val(biaya);
                                                        break;
                                                    default:
                                                            //=6 X (2 X Rekening Minimum (Rupiah) pelanggan sesuai Tarif Tenaga Listrik).

                                                            //rekmin=$rp=40*$query->daya*$query->dayas->rp_per_kwh/1000;
                                                            rekmin=40*daya*result.list.pelanggan.dayas.rp_per_kwh/1000;

                                                            biaya=6*(2*rekmin);
                                                            $("#biaya").val(biaya);
                                                        break;
                                                }
                                            break;
                                    }
                                break;
                            case "P2":
                            case "P3":
                                    //=9*720*0,85*DAYA/1000*RP/KWH (BERDASARKAN TARIF/DAYA)
                                    biaya=9*720*0.85*daya/1000*result.list.pelanggan.dayas.rp_per_kwh;
                                    $("#biaya").val(biaya);
                                break;
                            case "P4":
                                    //=9*720*0,85*DAYA/1000
                                    biaya=9*720*0.85*daya/1000;
                                    $("#biaya").val(biaya);
                                break;
                            case "K2":
                                    $("#biaya").prop("disabled",false);
                                    $("#biaya").focus();
                                break;
                            default:
                                    $("#biaya").prop("disabled",true);
                                break;
                        }

                        $("#pelanggan").val(result.list.id_pelanggan);
                        $("#nama").val(result.list.pelanggan.nama);
                        $("#tglpemeriksaan").val(result.list.tgl_pemeriksaan);
                        $("#hasil").val(result.list.hasil_pemeriksaan);
                        $("#saving").val(result.list.saving_kwh);
                        $("#tarif").val(result.list.pelanggan.dayas.kd_tarif);
                        $("#daya").val(result.list.pelanggan.daya);
                        $("#beban").val(beban);
                    },
                    error:function(){
                        alert('Link detail pelanggan not found');
                    }
                })
            })

            $(document).on("submit","#form",function(e){
                //var data = new FormData(this);
                //var hasil = CKEDITOR.instances.hasil.getData();
                var data={
                    pembayaran:$("#pembayaran").val(),
                    tanggal:$("#tanggal").val(),
                    agenda:$("#agenda").val(),
                    biaya:$("#biaya").val(),
                    beban:$("#beban").val(),
                    type:$("#type").val()
                }
                if($("#form")[0].checkValidity()) {
                    //updateAllMessageForms();
                    e.preventDefault();
                    $.ajax({
                        url			: "{{URL::to('pembayaran')}}",
                        type		: 'post',
                        data		: data,
                        //dataType	: 'JSON',
                        //contentType	: false,
                        cache		: false,
                        //processData	: false,
                        beforeSend	: function (){
                            $('#pesan').html('<div class="alert alert-info"><i class="fa fa-spinner fa-2x fa-spin"></i>&nbsp;Please wait for a few minutes</div>');
                        },
                        success	: function (result) {
                            if(result.success==true){
                                $('#pesan').html('&nbsp;'+result.pesan);
                                new PNotify({
                                    title: 'Info notice',
                                    text: result.pesan,
                                    addclass: 'alert-styled-left',
                                    type: 'info'
                                });
                                $("#myModal").modal("hide");
                                showData();
                            }else{
                                $('#pesan').empty().html("<pre>"+result.error+"</pre><br>");
                                new PNotify({
                                    title: 'Info notice',
                                    text: result.pesan,
                                    addclass: 'alert-styled-left',
                                    type: 'error'
                                });
                            }
                        },
                        error	:function() {  
                            $('#pesan').html('<div class="alert alert-danger">Your request not Sent...</div>');
                        }
                    });
                }else console.log("invalid form");
            });

            $(document).on("click",".edit",function(){
                $("#pesan").empty();
                var kode=$(this).attr("kode");

                $.ajax({
                    url:"{{URL::to('pembayaran')}}/"+kode,
                    type:"GET",
                    success:function(result){
                        console.log(result);
                        $("#type").val("edit");
                        $("#pembayaran").val(result.list.id_pembayaran);
                        $("#tanggal").val(result.list.tgl_pembayaran);
                        $("#pelanggan").val(result.list.pemeriksaan.id_pelanggan);
                        $("#nama").val(result.list.pemeriksaan.pelanggan.nama);
                        $("#tglpemeriksaan").val(result.list.pemeriksaan.tgl_pemeriksaan);
                        $("#hasil").val(result.list.pemeriksaan.hasil_pemeriksaan);
                        $("#saving").val(result.list.pemeriksaan.saving_kwh);
                        $("#bayar").val(result.list.rp_bayar);

                        var el="";
                        el+='<div class="form-group">'+
                            '<label class="col-lg-4 control-label">No. Agenda</label>'+
                            '<div class="col-lg-8">'+
                                '<select class="select2" id="agenda" name="agenda">'+
                                    '<option value="" selected>--Select Agenda--</option>';
                                    $.each(result.pemeriksaan,function(a,b){
                                        var pilih="";
                                        if(result.list.no_agenda==b.no_agenda){
                                            pilih="selected='selected'";
                                        }else{
                                            pilih="";
                                        }

                                        el+="<option value='"+b.no_agenda+"' "+pilih+">"+b.no_agenda+"</option>";
                                    })
                                el+='</select>'+
                            '</div>'+
                        '</div>';

                        $("#divPemeriksaan").empty().html(el);
                        $('.select2').select2();

                        $("#myModal").modal("show");
                        showEditor();
                    },
                    error:function(){
                        alert('Link detail pemeriksaan not found');
                    }
                })
            })

            $(document).on("click","a.hapus",function(){
                kode=$(this).attr("kode");

                swal({
                    title: "Are you sure?",
                    text: "You will delete data!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function(isConfirm){
                    if (isConfirm) {
                        $.ajax({
                            url:"{{URL::to('pembayaran')}}/"+kode,
                            type:"DELETE",
                            success:function(result){
                                if(result.success=true){
                                    swal("Deleted!", result.pesan, "success");
                                    showData();
                                }else{
                                    swal("Error!", result.pesan, "error");
                                }
                            }
                        })
                    } else {
                        swal("Cancelled", "Your data is safe :)", "error");
                    }
                });
            })

            showData();
        })
    </script>
@stop