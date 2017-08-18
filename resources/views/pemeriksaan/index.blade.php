@extends('layouts.admin')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title">Data Pemeriksaan</div>
        </div>

        <div class="panel-body">
            <a href="#" class="btn btn-primary" id="tambah">
                <i class="icon-add"></i> Add New Pemeriksaan
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
                                <label for="" class="col-lg-4 control-label">No. Agenda</label>             
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" id="agenda" name="agenda" value="{{$idpem}}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="" class="col-lg-4 control-label">Tgl. Pemeriksaan</label>             
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
                                    <div id="divPelanggan"></div>

                                    <div class="form-group">
                                        <label for="" class="col-lg-4 control-label">Nama</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="nama" name="nama" readonly>
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
                                        <label for="" class="col-lg-4 control-label">Type Daya</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="typedaya" name="typedaya" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="" class="col-lg-4 control-label">Daya</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="daya" name="daya" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="" class="col-lg-4 control-label">Alamat</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="alamat" name="alamat" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <hr>
                            <div class="form-group">
                                <label for="" class="col-lg-2 control-label">No. BA</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="noba" name="noba">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-lg-2 control-label">Hasil Pemeriksaan</label>
                                <div class="col-lg-10">
                                    <select name="hasil" id="hasil" class="form-control" disabled="true">
                                        <option value="">--Select Hasil Pemeriksaan--</option>
                                        <option value="P1">P1</option>
                                        <option value="P2">P2</option>
                                        <option value="P3">P3</option>
                                        <option value="P4">P4</option>
                                        <option value="K2">K2</option>
                                        <option value="N">Normal</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-lg-2 control-label">Saving KWH</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="saving" id="saving" placeholder="Saving KWH" disabled="true">
                                    <input type="hidden" class="form-control" name="type" id="type" placeholder="Saving KWH">
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
    {{Html::script('limitless/assets/js/core/libraries/jquery_ui/datepicker.min.js')}}
    {{Html::script('limitless/assets/js/plugins/ui/moment/moment.min.js')}}
	{{Html::script('limitless/assets/js/plugins/pickers/daterangepicker.js')}}
	{{Html::script('limitless/assets/js/plugins/pickers/anytime.min.js')}}
	{{Html::script('limitless/assets/js/plugins/pickers/pickadate/picker.js')}}
	{{Html::script('limitless/assets/js/plugins/pickers/pickadate/picker.date.js')}}
	{{Html::script('limitless/assets/js/plugins/pickers/pickadate/picker.time.js')}}
	{{Html::script('limitless/assets/js/plugins/pickers/pickadate/legacy.js')}}

    <script>
        $(function(){
            var kode="";
            $("#type").val("add");

            function showEditor(){
                
            }

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


            function showData(){
                $('#data').DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    destroy: true,
                    ajax: "{{URL::to('pemeriksaan')}}",
                    columns: [
                        {data:'no',name:'no',title:'No',searchable:false},
                        {data: 'no_agenda', name: 'no_agenda',title:'No. Agenda'},
                        {data: 'tgl_pemeriksaan', name: 'tgl_pemeriksaan',title:'Tgl Pemeriksaan'},
                        {data: 'no_ba', name: 'no_ba',title:'No. BA'},
                        {data: 'plg', name: 'plg',title:'Pelanggan'},
                        {data: 'hasil_pemeriksaan', name: 'hasil_pemeriksaan',title:'Hasil Pemeriksaan'},
                        {data: 'saving_kwh', name: 'saving_kwh',title:'Saving Kwh'},
                        //{data: 'edit', name: 'edit',title:'',searchable:false},
                        {data: 'action', name: 'action',title:'',searchable:false}
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
                $("#pelanggan").prop('selectedIndex',0);
                $("#nama").val('');
                $("#tarif").val('');
                $("#daya").val('');
                $("#typedaya").val('');
                $("#alamat").val('');
                $("#noba").val('');
                $("#typedaya").val();
                $("#hasil").val('');
                $("#saving").val('');
                $("#pesan").empty();
            }

            function getIdPemeriksaan(type){
                $.ajax({
                    url:"{{URL::to('get-id')}}",
                    data:"type="+type,
                    type:"GET",
                    success:function(result){
                        $("#agenda").val(result);
                    }
                })
            }

            $(document).on("click","#tambah",function(){
                $.ajax({
                    url:"{{URL::to('list-pelanggan')}}",
                    type:"GET",
                    success:function(result){
                        var el="";
                        el+='<div class="form-group">'+
                            '<label class="col-lg-4 control-label">Pelanggan</label>'+
                            '<div class="col-lg-8">'+
                                '<select class="select2" id="pelanggan" name="pelanggan">'+
                                    '<option value="" disabled>--Select Pelanggan--</option>';
                                    $.each(result,function(a,b){
                                        el+="<option value='"+b.id_pelanggan+"'>"+b.id_pelanggan+"</option>";
                                    })
                                el+='</select>'+
                            '</div>'+
                        '</div>';

                        $("#divPelanggan").empty().html(el);

                        $("#myModal").modal("show");
                        $('#pelanggan').val( $('#pelanggan').prop('defaultSelected') );
                        kosong();
                        showEditor();
                        $("#type").val("add");
                        $('.daterange-basic').datepicker();
                        $('.select2').select2();
                        getIdPemeriksaan('pemeriksaan');
                    }
                })
            })

            $(document).on("change","#pelanggan",function(){
                var pelanggan=$("#pelanggan option:selected").val();

                $.ajax({
                    url:"{{URL::to('pelanggan')}}/"+pelanggan,
                    type:"GET",
                    success:function(result){
                        $("#nama").val(result.pelanggan.nama);
                        $("#tarif").val(result.pelanggan.dayas.kd_tarif);
                        $("#daya").val(result.pelanggan.daya);
                        $("#typedaya").val(result.pelanggan.dayas.daya);
                        $("#alamat").val(result.pelanggan.alamat);
                        $("#hasil").prop("disabled",false);
                    },
                    error:function(){
                        $("#hasil").prop("disabled",true);
                        alert('Link detail pelanggan not found');
                    }
                })
            })

            $(document).on("submit","#form",function(e){
                var data={
                    type:$("#type").val(),
                    agenda:$("#agenda").val(),
                    saving:$("#saving").val(),
                    tanggal:$("#tanggal").val(),
                    pelanggan:$("#pelanggan").val(),
                    hasil:$("#hasil").val(),
                    noba:$("#noba").val()
                }
                console.log(data);
                //var data = new FormData(this);
                //var hasil = CKEDITOR.instances.hasil.getData();
                if($("#form")[0].checkValidity()) {
                    //updateAllMessageForms();
                    e.preventDefault();
                    $.ajax({
                        url			: "{{URL::to('pemeriksaan')}}",
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
                var kode=$(this).attr("kode");

                $.ajax({
                    url:"{{URL::to('pemeriksaan')}}/"+kode,
                    type:"GET",
                    success:function(result){
                        console.log(result);
                        $("#type").val("edit");
                        $("#agenda").val(result.list.no_agenda);
                        $("#nama").val(result.list.pelanggan.nama);
                        $("#daya").val(result.list.pelanggan.daya);
                        $("#typedaya").val(result.list.pelanggan.dayas.daya);
                        $("#tarif").val(result.list.pelanggan.dayas.kd_tarif);
                        $("#alamat").val(result.list.pelanggan.alamat);
                        $("#noba").val(result.list.no_ba);
                        $("#hasil").val(result.list.hasil_pemeriksaan);
                        $("#saving").val(result.list.saving_kwh);
                        $("#tanggal").val(result.list.tgl_pemeriksaan);
                        $("#pelanggan").val(result.list.id_pelanggan);

                        var el="";
                        el+='<div class="form-group">'+
                            '<label class="col-lg-4 control-label">Pelanggan</label>'+
                            '<div class="col-lg-8">'+
                                '<select class="select2" id="pelanggan" name="pelanggan">'+
                                    '<option value="" disabled>--Select Pelanggan--</option>';
                                    $.each(result.pelanggan,function(a,b){
                                        var pilih="";
                                        if(result.list.id_pelanggan==b.id_pelanggan){
                                            pilih="selected='selected'";
                                        }else{
                                            pilih="";
                                        }
                                        el+="<option value='"+b.id_pelanggan+"' "+pilih+">"+b.id_pelanggan+"</option>";
                                    })
                                el+='</select>'+
                            '</div>'+
                        '</div>';

                        $("#divPelanggan").empty().html(el);
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
                            url:"{{URL::to('pemeriksaan')}}/"+kode,
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

            $(document).on("change","#hasil",function(){
                var hasil=$("#hasil option:selected").val();
                var daya=$("#daya").val();
                var jumlah=0;

                if(daya==""){
                    new PNotify({
                        title: 'Info notice',
                        text: 'Silahkan pilih pelanggan terlebih dahulu',
                        addclass: 'alert-styled-left',
                        type: 'error'
                    });
                }else{
                    switch(hasil){
                        case "N":
                                jumlah=0;
                                $("#saving").prop("disabled",true);
                            break;
                        case "P1":
                                jumlah=0;
                                $("#saving").prop("disabled",true);
                            break;
                        case "P2":
                        case "P3":
                        case "P4":
                                jumlah=9*720*0.85*daya/1000;
                                $("#saving").prop("disabled",true);
                            break;
                        case "K2":
                                $("#saving").prop("disabled",false);
                                $("#saving").focus();
                            break;
                    }

                    $("#saving").val(jumlah);
                }
            })

            showData();
        })
    </script>
@stop