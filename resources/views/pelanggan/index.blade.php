@extends('layouts.admin')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title">Data Pelanggan</div>
        </div>

        <div class="panel-body">
            <a href="#" class="btn btn-primary" id="tambah">
                <i class="icon-add"></i> Add New Pelanggan
            </a>

            <table class="table table-striped" id="data"></table>
        </div>
    </div>

    <div id="tampilmodal"></div>
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


            function showData(){
                $('#data').DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    destroy: true,
                    ajax: "{{URL::to('pelanggan')}}",
                    columns: [
                        {data:'no',name:'no',title:'No',searchable:false},
                        {data:'id_pelanggan',name:'id_pelanggan',title:'ID Pelanggan'},
                        {data: 'nama', name: 'nama',title:'Nama'},
                        {data: 'alamat', name: 'alamat',title:'Alamat'},
                        {data: 'kd_daya', name: 'kd_daya',title:'Type Daya'},
                        {data: 'daya', name: 'daya',title:'Daya'},
                        {data: 'rp_per_kwh', name: 'rp_per_kwh',title:'RP / Kwh'},
                        {data: 'rek_minimum', name: 'rek_minimum',title:'Rek Minimum'},
                        {data: 'detail', name: 'detail',title:'',searchable:false},
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

            $(document).on("click","#tambah",function(){
                $.ajax({
                    url:"{{URL::to('tarif')}}",
                    type:"GET",
                    success:function(result){
                        var el="";
                        el+='<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">'+
                            '<div class="modal-dialog" role="document">'+
                                '<form name="form" id="form" class="form-horizontal" onsubmit="return false;" enctype="multipart/form-data" method="post" accept-charset="utf-8">'+
                                '<div class="modal-content">'+
                                    '<div class="modal-header">'+
                                        '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                                        '<h4 class="modal-title" id="myModalLabel">Add New Pelanggan</h4>'+
                                    '</div>'+
                                    '<div class="modal-body">'+
                                        '<div id="pesan"></div>'+
                                            '<div class="form-group">'+
                                                '<label class="col-lg-3 control-label">ID Pelanggan</label>'+
                                                '<div class="col-lg-8">'+
                                                    '<input class="form-control" id="idpelanggan" name="idpelanggan" placeholder="Isi Nama" value="{{$kode}}" required readonly>'+
                                                '</div>'+
                                            '</div>'+

                                            '<div class="form-group">'+
                                                '<label class="col-lg-3 control-label">Nama</label>'+
                                                '<div class="col-lg-8">'+
                                                    '<input class="form-control" id="nama" name="nama" placeholder="Isi Nama" required>'+
                                                '</div>'+
                                            '</div>'+

                                            '<div class="form-group">'+
                                                '<label class="col-lg-3 control-label">Alamat</label>'+
                                                '<div class="col-lg-8">'+
                                                    '<input class="form-control" id="alamat" name="alamat" placeholder="Isi Alamat" required>'+
                                                '</div>'+
                                            '</div>'+

                                            '<div class="form-group">'+
                                                '<label class="col-lg-3 control-label">Tarif</label>'+
                                                '<div class="col-lg-8">'+
                                                    '<select name="tarif" id="tarif" class="form-control">'+
                                                        '<option value="">--Pilih Tarif--</option>';
                                                        $.each(result.data,function(a,b){
                                                            el+='<option value="'+b.kd_tarif+'">'+b.kd_tarif+'</option>';
                                                        })
                                                    el+='</select>'+
                                                '</div>'+
                                            '</div>'+

                                            '<div class="form-group">'+
                                                '<label class="col-lg-3 control-label">Type Daya</label>'+
                                                '<div class="col-lg-8">'+
                                                    '<div id="divTypeDaya">'+
                                                        '<select name="typedaya" id="typedaya" class="form-control"'+
                                                            '<option value="">--Pilih Type Daya--</option>'+
                                                        '</select>'+
                                                    '</div>'+
                                                '</div>'+
                                            '</div>'+

                                            '<div class="form-group">'+
                                                '<label class="col-lg-3 control-label">Daya</label>'+
                                                '<div class="col-lg-8">'+
                                                    '<input type="number" class="form-control" id="daya" name="daya" placeholder="Daya" required>'+
                                                '</div>'+
                                            '</div>'+
                                    '</div>'+
                                    '<div class="modal-footer">'+
                                        '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'+
                                        '<button type="submit" class="btn btn-primary">Save changes</button>'+
                                    '</div>'+
                                '</div>'+
                                '</form>'+
                            '</div>'+
                        '</div>';

                        $("#tampilmodal").empty().html(el);
                        $("#type").val("add");
                        $("#myModal").modal("show");
                    }
                })
            })

            $(document).on("change","#tarif",function(){
                var tarif=$("#tarif option:selected").val();

                $.ajax({
                    url:"{{URL::to('daya-by-tarif')}}/"+tarif,
                    type:"GET",
                    success:function(result){
                        console.log(result);
                        var el="";
                        if(result.length>0){
                            el+='<select name="typedaya" id="typedaya" class="form-control">'+
                                '<option value="">--Pilih Type Daya--</option>';
                                $.each(result,function(a,b){
                                    el+='<option value="'+b.kd_daya+'">'+b.daya+'</option>';
                                })
                            el+='</select>';
                        }else{
                            el+='<select name="typedaya" id="typedaya" class="form-control">'+
                                '<option value="">--Type Daya Not Found--</option>'+
                            '</select>';
                        }
                        $("#divTypeDaya").empty().html(el);
                    }
                })
            })

            function showTarifDaya(tarif,daya){
                $.ajax({
                    url:"{{URL::to('daya-by-tarif')}}/"+tarif,
                    type:"GET",
                    success:function(result){
                        console.log(result);
                        var el="";
                        if(result.length>0){
                            el+='<select name="typedaya" id="typedaya" class="form-control">'+
                                '<option value="">--Pilih Type Daya--</option>';
                                $.each(result,function(a,b){
                                    var pilih="";
                                    if(b.kd_daya==daya){
                                        pilih="selected='selected'";
                                    }
                                    el+='<option value="'+b.kd_daya+'" '+pilih+'>'+b.daya+'</option>';
                                })
                            el+='</select>';
                        }else{
                            el+='<select name="typedaya" id="typedaya" class="form-control">'+
                                '<option value="">--Type Daya Not Found--</option>'+
                            '</select>';
                        }
                        $("#divTypeDaya").empty().html(el);
                    }
                })
            }

            $(document).on("click",".edit",function(){
                var kode=$(this).attr("kode");

                $.ajax({
                    url:"{{URL::to('pelanggan')}}/"+kode,
                    type:"GET",
                    success:function(result){
                        var el="";
                        el+='<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">'+
                            '<div class="modal-dialog" role="document">'+
                                '<form name="form" id="form" class="form-horizontal" onsubmit="return false;" enctype="multipart/form-data" method="post" accept-charset="utf-8">'+
                                '<div class="modal-content">'+
                                    '<div class="modal-header">'+
                                        '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                                        '<h4 class="modal-title" id="myModalLabel">Add New Pelanggan</h4>'+
                                    '</div>'+
                                    '<div class="modal-body">'+
                                        '<div id="pesan"></div>'+
                                            '<div class="form-group">'+
                                                '<label class="col-lg-3 control-label">ID Pelanggan</label>'+
                                                '<div class="col-lg-8">'+
                                                    '<input class="form-control" id="idpelanggan" name="idpelanggan" value="'+result.pelanggan.id_pelanggan+'" placeholder="Isi Nama" required readonly>'+
                                                    '<input type="hidden" class="form-control" id="kode" name="kode" value="'+result.pelanggan.id_pelanggan+'" placeholder="Isi Nama" required>'+
                                                '</div>'+
                                            '</div>'+

                                            '<div class="form-group">'+
                                                '<label class="col-lg-3 control-label">Nama</label>'+
                                                '<div class="col-lg-8">'+
                                                    '<input class="form-control" id="nama" name="nama" value="'+result.pelanggan.nama+'" placeholder="Isi Nama" required>'+
                                                '</div>'+
                                            '</div>'+

                                            '<div class="form-group">'+
                                                '<label class="col-lg-3 control-label">Alamat</label>'+
                                                '<div class="col-lg-8">'+
                                                    '<input class="form-control" id="alamat" value="'+result.pelanggan.alamat+'" name="alamat" placeholder="Isi Alamat" required>'+
                                                '</div>'+
                                            '</div>'+

                                            '<div class="form-group">'+
                                                '<label class="col-lg-3 control-label">Tarif</label>'+
                                                '<div class="col-lg-8">'+
                                                    '<select name="tarif" id="tarif" class="form-control">'+
                                                        '<option value="">--Pilih Tarif--</option>';
                                                        $.each(result.tarif,function(a,b){
                                                            var pilih="";
                                                            if(b.kd_tarif==result.pelanggan.dayas.kd_tarif){
                                                                pilih="selected='selected'";
                                                            }
                                                            el+='<option value="'+b.kd_tarif+'" '+pilih+'>'+b.kd_tarif+'</option>';
                                                        })
                                                    el+='</select>'+
                                                '</div>'+
                                            '</div>'+

                                            '<div class="form-group">'+
                                                '<label class="col-lg-3 control-label">Type Daya</label>'+
                                                '<div class="col-lg-8">'+
                                                    '<div id="divTypeDaya">'+
                                                        '<select name="typedaya" id="typedaya" class="form-control"'+
                                                            '<option value="">--Pilih Type Daya--</option>'+
                                                        '</select>'+
                                                    '</div>'+
                                                '</div>'+
                                            '</div>'+

                                            '<div class="form-group">'+
                                                '<label class="col-lg-3 control-label">Daya</label>'+
                                                '<div class="col-lg-8">'+
                                                    '<input class="form-control" id="daya" name="daya" value="'+result.pelanggan.daya+'" placeholder="Isi Daya" required>'+
                                                '</div>'+
                                            '</div>'+
                                    '</div>'+
                                    '<div class="modal-footer">'+
                                        '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'+
                                        '<button type="submit" class="btn btn-primary">Save changes</button>'+
                                    '</div>'+
                                '</div>'+
                                '</form>'+
                            '</div>'+
                        '</div>';

                        $("#tampilmodal").empty().html(el);
                        $("#type").val("edit");
                        $("#myModal").modal("show");
                        showTarifDaya(result.pelanggan.dayas.kd_tarif,result.pelanggan.kd_daya);
                    },
                    error:function(){
                        alert('Link detail pelanggan not found');
                    }
                })
            })

            $(document).on("submit","#form",function(e){
                var data = new FormData(this);
                if($("#form")[0].checkValidity()) {
                    //updateAllMessageForms();
                    e.preventDefault();
                    $.ajax({
                        url			: "{{URL::to('pelanggan')}}",
                        type		: 'post',
                        data		: data,
                        dataType	: 'JSON',
                        contentType	: false,
                        cache		: false,
                        processData	: false,
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
                            url:"{{URL::to('pelanggan')}}/"+kode,
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