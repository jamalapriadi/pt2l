@extends('layouts.admin')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title">Data Tindak Lanjut</div>
        </div>

        <div class="panel-body">
            <a href="#" class="btn btn-primary" id="tambah">
                <i class="icon-add"></i> Add New Tindak Lanjut
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
                    <h4 class="modal-title" id="myModalLabel">Add New Tindakan</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="" class="col-lg-4 control-label">No. Tindakan</label>             
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" id="tindakan" name="tindakan" value="{{$idtindakan}}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="" class="col-lg-4 control-label">Tgl. Tindakan</label>             
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
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="" class="col-lg-2 control-label">Hasil Pemeriksaan</label>
                                <div class="col-lg-10">
                                    <input type="text" name="hasil" class="form-control" id="hasil" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-lg-2 control-label">Saving KWH</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="saving" id="saving" placeholder="Saving KWH" readonly>
                                    <input type="hidden" class="form-control" name="type" id="type" placeholder="Saving KWH">
                                </div>
                            </div>
                            <!--
                            <div class="form-group">
                                <label for="" class="col-lg-2 control-label">Beban</label>
                                <div class="col-lg-10">
                                    <input type="text" name="beban" class="form-control" id="beban" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-lg-2 control-label">Rp. Bayar</label>
                                <div class="col-lg-10">
                                    <input type="text" name="biaya" class="form-control" id="biaya" readonly>
                                </div>
                            </div>
                            -->
                            <hr>

                            <div class="form-group">
                                <label for="" class="col-lg-2 control-label">Tindak Lanjut</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="tindaklanjut" id="tindaklanjut" placeholder="Tindak Lanjut" required>
                                </div>
                            </div>

                            <!--

                            <div class="form-group">
                                <label for="" class="col-lg-2 control-label">Petugas</label>
                                <div class="col-lg-10">
                                    <select name="petugas" id="Petugas" class="form-control">
                                        <option value="">--Select Petugas--</option>
                                    </select>
                                </div>
                            </div>

                            -->

                            <!--
                            <div class="form-group">
                                <label for="" class="col-lg-2 control-label">Keterangan</label>
                                <div class="col-lg-10">
                                    <textarea name="keterangan" id="keterangan" cols="30" rows="5" class="form-control"></textarea>
                                </div>
                            </div>
                            -->
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
                        $("#tindakan").val(result);
                    }
                })
            }


            function showData(){
                $('#data').DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    destroy: true,
                    ajax: "{{URL::to('tindakan')}}",
                    columns: [
                        {data:'no',name:'no',title:'No',searchable:false},
                        {data: 'id_tindakan', name: 'id_tindakan',title:'No. Tindakan'},
                        {data: 'tgl_tindakan', name: 'tgl_tindakan',title:'Tgl Tindakan'},
                        {data: 'no_agenda', name: 'no_agenda',title:'No. Agenda'},
                        {data: 'tindak_lanjut', name: 'tindak_lanjut',title:'Tindak Lanjut'},
                        //{data: 'keterangan', name: 'keterangan',title:'Keterangan'},
                        //{data: 'edit', name: 'edit',title:'',searchable:false},
                        {data: 'action', name: 'action',title:'',searchable:false,width:'15%'}
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
                $("#type").val("add");
                $("#pembayaran").val("{{$idtindakan}}");
                $("#tanggal").val("{{date('d-m-Y')}}");
                $("#pelanggan").val('');
                $("#nama").val('');
                $("#tglpemeriksaan").val('');
                $("#hasil").val('');
                $("#saving").val('');
                $("#biaya").val('');
                $("#beban").val('');
                $("#tindaklanjut").val('');
                $("#pesan").empty();
            }

            $(document).on("click","#tambah",function(){
                $.ajax({
                    url:"{{URL::to('list-agenda-tindakan')}}",
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
                        kosong();
                        $("#type").val("add");
                        getIdPemeriksaan('tindakan');
                        $('.daterange-basic').datepicker();
                    }
                })
            })

            $(document).on("change","#agenda",function(){
                var agenda=$("#agenda option:selected").val();

                $.ajax({
                    url:"{{URL::to('pemeriksaan')}}/"+agenda,
                    type:"GET",
                    success:function(result){

                        $("#pelanggan").val(result.list.id_pelanggan);
                        $("#nama").val(result.list.pelanggan.nama);
                        $("#tglpemeriksaan").val(result.list.tgl_pemeriksaan);
                        $("#hasil").val(result.list.hasil_pemeriksaan);
                        $("#saving").val(result.list.saving_kwh);
                        $("#beban").val(result.list.pembayaran.biaya_beban);
                        $("#biaya").val(result.list.pembayaran.rp_bayar);
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
                    type:$("#type").val(),
                    tindakan:$("#tindakan").val(),
                    tanggal:$("#tanggal").val(),
                    agenda:$("#agenda").val(),
                    tindaklanjut:$("#tindaklanjut").val()
                }
                if($("#form")[0].checkValidity()) {
                    //updateAllMessageForms();
                    e.preventDefault();
                    $.ajax({
                        url			: "{{URL::to('tindakan')}}",
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
                    url:"{{URL::to('tindakan')}}/"+kode,
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
                        //showEditor();
                    },
                    error:function(){
                        alert('Link detail pemeriksaan not found');
                    }
                })
            })

            $(document).on("click",".edit",function(){
                $("#pesan").empty();
                var kode=$(this).attr("kode");

                $.ajax({
                    url:"{{URL::to('tindakan')}}/"+kode,
                    type:"GET",
                    success:function(result){
                        console.log(result);
                        $("#type").val("edit");
                        $("#tindakan").val(result.list.id_tindakan);
                        $("#tanggal").val(result.list.tgl_tindakan);
                        $("#pelanggan").val(result.list.pemeriksaan.id_pelanggan);
                        $("#nama").val(result.list.pemeriksaan.pelanggan.nama);
                        $("#tglpemeriksaan").val(result.list.pemeriksaan.tgl_pemeriksaan);
                        $("#hasil").val(result.list.pemeriksaan.hasil_pemeriksaan);
                        $("#saving").val(result.list.pemeriksaan.saving_kwh);
                        $("#tindaklanjut").val(result.list.tindak_lanjut);
                        $("#keterangan").val(result.list.keterangan);

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
                        //showEditor();
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
                            url:"{{URL::to('tindakan')}}/"+kode,
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