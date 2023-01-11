@extends('layouts.app')

@section('page-title')
    
@endsection

@push('head-script')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.bootstrap.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/daterange-picker/daterangepicker.css') }}" />

 <!-- Google Font: Source Sans Pro -->
 <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('AdminLTE-3.2.0')}}/plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('AdminLTE-3.2.0')}}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="{{asset('AdminLTE-3.2.0')}}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="{{asset('AdminLTE-3.2.0')}}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('AdminLTE-3.2.0')}}/dist/css/adminlte.min.css">

@endpush

@section('content')

<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            
            <!-- /.card -->

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Office Expense</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                  
                    <th>Item name</th>                   
                    <th>Price</th>
                    <th>Purchased from</th>
                    <th>Employes</th>
                    <th>Purchase Date</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
     <?php $office_expenses=DB::table('office_expenses')->get(); 
    // echo '<pre>';print_r($office_expenses);die;
    $usersss="";
     ?>     
     
     @foreach($office_expenses as $office_expense)
     <?php $usersss=DB::table('users')->where('id',$office_expense->user_id)->first(); ?>
                  <tr>
                    <td>{{$office_expense->item_name}}</td>
                    <td>{{$office_expense->price}}</td>
                    <td>{{$office_expense->purchase_from}}</td>
                    <td> <?php $usersss=DB::table('users')->where('id',$office_expense->user_id)->first(); 
                         if(isset($usersss->name)){
                            echo $usersss->name;
                         }
                    ?></td>
                    <td>{{$office_expense->purchase_date}}</td>
                    <td>{{$office_expense->status}}</td>

                    <td>
                    <div class="btn-group">
                    <button type="button" class="btn btn-danger">Action</button>
                    <button type="button" class="btn btn-danger dropdown-toggle dropdown-icon" data-toggle="dropdown">
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu" role="menu">
                      <a class="dropdown-item" href="{{url('office-exp-status',$office_expense->id)}}/pending">pending</a>
                      <a class="dropdown-item" href="{{url('office-exp-status',$office_expense->id)}}/approved">approved</a>
                      <a class="dropdown-item" href="{{url('office-exp-status',$office_expense->id)}}/rejected">rejected</a>
                     
                  </div>
                    </td>
                  </tr>

           @endforeach       
                 
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>

@endsection

@push('footer-script')
<script src="{{ asset('plugins/bower_components/datatables/jquery.dataTables.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/responsive.bootstrap.min.js"></script><script src="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
@if($global->locale == 'en')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/locales/bootstrap-datepicker.{{ $global->locale }}-AU.min.js"></script>
@else
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/locales/bootstrap-datepicker.{{ $global->locale }}.min.js"></script>
@endif
<script src="{{ asset('plugins/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('js/datatables/buttons.server-side.js') }}"></script>
<script src="{{ asset('plugins/bower_components/moment/moment.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/daterange-picker/daterangepicker.js') }}"></script>
{!! $dataTable->scripts() !!}

<script>
    $(function() {
        var dateformat = '{{ $global->moment_format }}';

        var start = '';
        var end = '';

        function cb(start, end) {
            if(start){
                $('#start-date').val(start.format(dateformat));
                $('#end-date').val(end.format(dateformat));
                $('#reportrange span').html(start.format(dateformat) + ' - ' + end.format(dateformat));
            }

        }
        moment.locale('{{ $global->locale }}');
        $('#reportrange').daterangepicker({
            // startDate: start,
            // endDate: end,
            locale: {
                language: '{{ $global->locale }}',
                format: '{{ $global->moment_format }}',
            },
            linkedCalendars: false,
            ranges: dateRangePickerCustom
        }, cb);

        cb(start, end);

    });
    $(".select2").select2({
        formatNoMatches: function () {
            return "{{ __('messages.noRecordFound') }}";
        }
    });
    var table;
    $(function() {
        $('#expenses-table').on('preXhr.dt', function (e, settings, data) {
            var startDate = $('#start-date').val();

            if (startDate == '') {
                startDate = null;
            }

            var endDate = $('#end-date').val();

            if (endDate == '') {
                endDate = null;
            }

            var status = $('#status').val();
            var employee = $('#employee').val();
            var project = $('#project_id').val();
            var category_id = $('#category_id').val();
            
            data['startDate'] = startDate;
            data['endDate'] = endDate;
            data['status'] = status;
            data['employee'] = employee;
            data['project'] = project;
            data['category_id'] = category_id;

        });
        jQuery('#date-range').datepicker({
            toggleActive: true,
            format: '{{ $global->date_picker_format }}',
            language: '{{ $global->locale }}',
            autoclose: true,
            weekStart:'{{ $global->week_start }}',
        });
        loadTable();

        $('body').on('click', '.sa-params', function(){
            var id = $(this).data('expense-id');
            swal({
                title: "@lang('messages.sweetAlertTitle')",
                text: "@lang('messages.confirmation.recoverExpense')",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "@lang('messages.deleteConfirmation')",
                cancelButtonText: "@lang('messages.confirmNoArchive')",
                closeOnConfirm: true,
                closeOnCancel: true
            }, function(isConfirm){
                if (isConfirm) {

                    var url = "{{ route('admin.expenses.destroy',':id') }}";
                    url = url.replace(':id', id);

                    var token = "{{ csrf_token() }}";

                    $.easyAjax({
                        type: 'POST',
                            url: url,
                            data: {'_token': token, '_method': 'DELETE'},
                        success: function (response) {
                            if (response.status == "success") {
                                $.unblockUI();
                                loadTable();
                            }
                        }
                    });
                }
            });
        });
    });

    function loadTable(){
        window.LaravelDataTables["expenses-table"].draw();
    }

    $('.toggle-filter').click(function () {
        $('#ticket-filters').toggle('slide');
    })

    $('#apply-filters').click(function () {
        loadTable();
    });

    $('#reset-filters').click(function () {
        $('#filter-form')[0].reset();
        $('.select2').val('all').trigger('change');
        $('#start-date').val('');
        $('#end-date').val('');
        $('#reportrange span').html('');
        loadTable();
    })
    $(document).on('click', '.view-expense', function () {
        var id = $(this).data('expense-id');
        var url = "{{ route('admin.expenses.show',':id') }}";
        url = url.replace(':id', id);

        $('#modelHeading').html('Reject Reason');
        $.ajaxModal('#leave-details', url);
    });

    $(document).on('click', '.change-status', function () {
        var url = "{{route('admin.expenses.changeStatus')}}";
        var token = "{{ csrf_token() }}";
        var id =  $(this).data('expense-id');
        var status =  $(this).data('status');

        $.easyAjax({
            url: url,
            type: "POST",
            data: {'_token': token, expenseId: id, status: status},
            success: function (data) {
                if (data.status == "success") {
                    loadTable();
                }
            }
        })
    })


</script>

<!-- jQuery -->
<script src="{{asset('AdminLTE-3.2.0')}}/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('AdminLTE-3.2.0')}}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="{{asset('AdminLTE-3.2.0')}}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{asset('AdminLTE-3.2.0')}}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{asset('AdminLTE-3.2.0')}}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{asset('AdminLTE-3.2.0')}}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{asset('AdminLTE-3.2.0')}}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{asset('AdminLTE-3.2.0')}}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="{{asset('AdminLTE-3.2.0')}}/plugins/jszip/jszip.min.js"></script>
<script src="{{asset('AdminLTE-3.2.0')}}/plugins/pdfmake/pdfmake.min.js"></script>
<script src="{{asset('AdminLTE-3.2.0')}}/plugins/pdfmake/vfs_fonts.js"></script>
<script src="{{asset('AdminLTE-3.2.0')}}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{{asset('AdminLTE-3.2.0')}}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="{{asset('AdminLTE-3.2.0')}}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="{{asset('AdminLTE-3.2.0')}}/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
@endpush
