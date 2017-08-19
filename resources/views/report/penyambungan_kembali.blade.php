@extends('layouts.admin')

@section('content')
	<div class="panel panel-default">
		<div class="panel-heading">
			<h6 class="panel-title">Report Penyambungan Kembali</h6>
		</div>
		<div class="panel-body">
			<form onsubmit="return false;" class="form-horizontal" id="form">
				<div class="form-group">
                    <label for="" class="col-lg-2 control-label">Periode</label>
                    <div class="col-lg-8">
                        <input type="text" name="periode" class="form-control daterange-buttons"> 
                    </div>
                </div>

                <hr>

                <div class="form-group">
                    <label for="" class="col-lg-2 control-label"></label>
                    <div class="col-lg-8">
                        <button class="btn btn-primary">
                            <i class="icon-printer2"></i>
                            Preview
                        </button>
                    </div>
                </div>
			</form>
		</div>
	</div>

    <div id="divPreview"></div>
@stop

@section('js')
	<!-- Theme JS files -->
	{{Html::script('limitless/assets/js/core/libraries/jquery_ui/datepicker.min.js')}}
	{{Html::script('limitless/assets/js/core/libraries/jquery_ui/effects.min.js')}}
	{{Html::script('limitless/assets/js/plugins/notifications/jgrowl.min.js')}}
	{{Html::script('limitless/assets/js/plugins/ui/moment/moment.min.js')}}
	{{Html::script('limitless/assets/js/plugins/pickers/daterangepicker.js')}}
	{{Html::script('limitless/assets/js/plugins/pickers/anytime.min.js')}}
	{{Html::script('limitless/assets/js/plugins/pickers/pickadate/picker.js')}}
	{{Html::script('limitless/assets/js/plugins/pickers/pickadate/picker.date.js')}}
	{{Html::script('limitless/assets/js/plugins/pickers/pickadate/picker.time.js')}}
	{{Html::script('limitless/assets/js/plugins/pickers/pickadate/legacy.js')}}


	<script>
		$(function(){
			$('.daterange-predefined').daterangepicker(
                {
                    startDate: moment().subtract('days', 29),
                    endDate: moment(),
                    minDate: '01/01/2014',
                    maxDate: '12/31/2016',
                    dateLimit: { days: 60 },
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                        'Last 7 Days': [moment().subtract('days', 6), moment()],
                        'Last 30 Days': [moment().subtract('days', 29), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
                    },
                    opens: 'left',
                    applyClass: 'btn-small bg-slate',
                    cancelClass: 'btn-small btn-default',
                    format: 'MM/DD/YYYY'
                },
                function(start, end) {
                    $('.daterange-predefined span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                    $.jGrowl('Date range has been changed', { header: 'Update', theme: 'bg-primary', position: 'center', life: 1500 });
                }
            );

            // Display date format
            $('.daterange-predefined span').html(moment().subtract('days', 29).format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));

            // Button class options
            $('.daterange-buttons').daterangepicker({
                applyClass: 'btn-success',
                cancelClass: 'btn-danger'
            });

            $(document).on("submit","#form",function(e){
                var data = new FormData(this);
                //var hasil = CKEDITOR.instances.hasil.getData();
                if($("#form")[0].checkValidity()) {
                    //updateAllMessageForms();
                    e.preventDefault();
                    $.ajax({
                        url         : "{{URL::to('report/preview-penyambungan-kembali')}}",
                        type        : 'post',
                        data        : data,
                        dataType  : 'JSON',
                        contentType   : false,
                        cache       : false,
                        processData   : false,
                        beforeSend  : function (){
                            $('#divPreview').html('<div class="alert alert-info"><i class="fa fa-spinner fa-2x fa-spin"></i>&nbsp;Please wait for a few minutes</div>');
                        },
                        success : function (result) {
                            var el="";
                            el+="<div class='panel panel-default'>"+
                                '<div class="panel-heading">'+
                                    '<h6 class="panel-title">Preview</h6>'+
                                    '<div class="heading-elements">'+

                                    '</div>'+
                                '</div>'+
                                '<div class="panel-body">'+
                                    '<table class="table table-striped>"'+
                                        '<thead>'+
                                            '<tr>'+
                                                '<td>No.</td>'+
                                                '<td>ID Tindakan</td>'+
                                                '<td>Tgl Tindakan</td>'+
                                                '<td>ID / Nama Pelanggan</td>'+
                                                '<td>Alamat</td>'+
                                                '<td>No. BA</td>'+
                                                '<td>Saving Kwh</td>'+
                                                '<td>Tindakan</td>'+
                                            '</tr>'+
                                        '</thead>'+
                                        '<tbody>';
                                            var no=0;
                                            $.each(result,function(a,b){
                                                no++;
                                                el+='<tr>'+
                                                    '<td>'+no+'</td>'+
                                                    '<td>'+b.id_tindakan+'</td>'+
                                                    '<td>'+b.tgl_pemeriksaan+'</td>'+
                                                    '<td>'+b.pemeriksaan.id_pelanggan+' / '+b.pemeriksaan.pelanggan.nama+'</td>'+
                                                    '<td>'+b.pemeriksaan.pelanggan.alamat+'</td>'+
                                                    '<td>'+b.pemeriksaan.no_ba+'</td>'+
                                                    '<td>'+b.pemeriksaan.saving_kwh+'</td>'+
                                                    '<td>'+b.tindak_lanjut+'</td>'+
                                                '</tr>';
                                            })

                                        el+='</tbody>'+
                                    '</table>'+
                                '</div>'+
                            '</div>';

                            $("#divPreview").empty().html(el);
                        },
                        error   :function() {  
                            $('#pesan').html('<div class="alert alert-danger">Your request not Sent...</div>');
                        }
                    });
                }else console.log("invalid form");
            });

            
		})
	</script>
@stop