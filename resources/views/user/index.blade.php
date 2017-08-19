@extends('layouts.admin')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title">Data User</div>
        </div>

        <div class="panel-body">
            <!--
            <a href="#" class="btn btn-primary" id="tambah">
                <i class="icon-add"></i> Add New User
            </a>
            -->

            <table class="table table-striped" id="data"></table>
        </div>
    </div>

    <div id="tampilmodal"></div>
@stop

@section('js')
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.js"></script>

    <script>
        $(function(){
            var kode="";

            $.extend( $.fn.dataTable.defaults, {
                autoWidth: false,
                columnDefs: [{ 
                    orderable: false,
                    width: '100px',
                    targets: [ 4 ]
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
                    ajax: "{{URL::to('user')}}",
                    columns: [
                        {data:'no',name:'no',title:'No',searchable:false},
                        {data: 'email', name: 'email',title:'Email'},
                        {data:'name',name:'name',title:'Nama'},
                        {data: 'level', name: 'level',title:'Level'},
                        {data: 'action', name: 'action',title:'',searchable:false}
                    ]
                }); 
            }

            $(document).on("click","#tambah",function(){
                var el="";
                el+='<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">'+
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
                                        '<label class="col-lg-2 control-label">Nama</label>'+
                                        '<div class="col-lg-9">'+
                                            '<input class="form-control" id="nama" name="nama" placeholder="Isi Nama" required>'+
                                        '</div>'+
                                    '</div>'+

                                    '<div class="form-group">'+
                                        '<label class="col-lg-2 control-label">Tarif</label>'+
                                        '<div class="col-lg-9">'+
                                            '<input class="form-control" id="tarif" name="tarif" placeholder="Isi Tarif" required>'+
                                        '</div>'+
                                    '</div>'+

                                    '<div class="form-group">'+
                                        '<label class="col-lg-2 control-label">Daya</label>'+
                                        '<div class="col-lg-9">'+
                                            '<input class="form-control" id="daya" name="daya" placeholder="Isi Daya" required>'+
                                        '</div>'+
                                    '</div>'+

                                    '<div class="form-group">'+
                                        '<label class="col-lg-2 control-label">Alamat</label>'+
                                        '<div class="col-lg-9">'+
                                            '<input class="form-control" id="alamat" name="alamat" placeholder="Isi Alamat" required>'+
                                        '</div>'+
                                    '</div>'+

                                    '<div class="form-group">'+
                                        '<label class="col-lg-2 control-label">No. BA</label>'+
                                        '<div class="col-lg-9">'+
                                            '<input class="form-control" id="noba" name="noba" placeholder="Isi No. BA" required>'+
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
                $("#myModal").modal("show");
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
                                /*
                                new PNotify({
                                    title: 'Info notice',
                                    text: data.pesan,
                                    addclass: 'alert-styled-left',
                                    type: 'info'
                                });
                                */
                                $("#myModal").modal("hide");
                                showData();
                            }else{
                                $('#pesan').empty().html("<pre>"+result.error+"</pre><br>");
                                /*
                                new PNotify({
                                    title: 'Info notice',
                                    text: result.pesan,
                                    addclass: 'alert-styled-left',
                                    type: 'error'
                                });
                                */
                            }
                        },
                        error	:function() {  
                            $('#pesan').html('<div class="alert alert-danger">Your request not Sent...</div>');
                        }
                    });
                }else console.log("invalid form");
            });

            showData();
        })
    </script>
@stop