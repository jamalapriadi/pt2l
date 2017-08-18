@extends('layouts.admin')

@section('content')
	<div class="panel panel-default">
		<div class="panel-heading">
			<h6 class="panel-title">Report Belum Terbayar</h6>
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

            
		})
	</script>
@stop