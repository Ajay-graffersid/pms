@extends('layouts.app')

@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 bg-title-left">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ __($pageTitle) }}</h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12 bg-title-right">
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}">@lang('app.menu.home')</a></li>
                <li class="active">{{ __($pageTitle) }}</li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
@endsection

@push('head-script')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.bootstrap.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">


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
                <h3 class="card-title">Bench Employes</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>

                  
                  
                    <th>Id</th>                   
                    <th>Name</th>
                    <th>Email</th>
                   
                    <th>Status</th>
                    <th>createdAt</th>
                  <!--   <th>Action</th> -->
                  </tr>
                  </thead>
                  <tbody>
     <?php  
   /*  $notAssignedProject=DB::table('Users')->select('users.*')
     ->join('role_user', 'role_user.user_id', '=', 'users.id')
     ->join('roles', 'roles.id', '=', 'role_user.role_id')
     ->whereNotIn('users.id', function ($query) {

        $query->select('user_id as id')->from('project_members');
    })
    ->where('roles.name', '<>', 'client')
    ->get(); */
     $notAssignedProjects = App\User::join('role_user', 'role_user.user_id', '=', 'users.id')
        ->join('roles', 'roles.id', '=', 'role_user.role_id')
        ->select('users.*')
        ->whereNotIn('users.id', function ($query) {

            $query->select('user_id as id')->from('project_members');
        })
        ->where('roles.name', '<>', 'client')
        ->get();
   // $usersss="";
   // echo '<pre>';print_r($notAssignedProjects);die;
     ?>     
     
    @foreach($notAssignedProjects as $notAssignedProject) 
     <?php // $usersss=DB::table('users')->where('id',$office_expense->user_id)->first(); ?>
                  <tr>
                    <td>{{$notAssignedProject->id}}</td>
                    <td>{{$notAssignedProject->name}}</td>
                    <td>{{$notAssignedProject->email}}</td>
                    
                    <td>{{$notAssignedProject->status}}</td>
                    <td>{{date('d-m-Y',strtotime($notAssignedProject->created_at))}}</td>

                   
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
    <!-- .row -->

@endsection

@push('footer-script')
<script src="{{ asset('plugins/bower_components/datatables/jquery.dataTables.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/responsive.bootstrap.min.js"></script>
<script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script>

    $(".select2").select2({
        formatNoMatches: function () {
            return "{{ __('messages.noRecordFound') }}";
        }
    });
    var table;

    $(function() {
        loadTable();

        $('body').on('click', '.sa-params', function(){
            var id = $(this).data('user-id');
            swal({
                title: "@lang('messages.sweetAlertTitle')",
                text: "@lang('messages.confirmation.recoverDeleteUser')",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "@lang('messages.deleteConfirmation')",
                cancelButtonText: "@lang('messages.confirmNoArchive')",
                closeOnConfirm: true,
                closeOnCancel: true
            }, function(isConfirm){
                if (isConfirm) {

                    var url = "{{ route('admin.employees.destroy',':id') }}";
                    url = url.replace(':id', id);

                    var token = "{{ csrf_token() }}";

                    $.easyAjax({
                        type: 'POST',
                            url: url,
                            data: {'_token': token, '_method': 'DELETE'},
                        success: function (response) {
                            if (response.status == "success") {
                                $.unblockUI();
//                                    swal("Deleted!", response.message, "success");
                                table._fnDraw();
                            }
                        }
                    });
                }
            });
        });

        $('body').on('click', '.assign_role', function(){
            var id = $(this).data('user-id');
            var role = $(this).data('role-id');
            var token = "{{ csrf_token() }}";


            $.easyAjax({
                url: '{{route('admin.employees.assignRole')}}',
                type: "POST",
                data: {role: role, userId: id, _token : token},
                success: function (response) {
                    if(response.status == "success"){
                        $.unblockUI();
                        table._fnDraw();
                    }
                }
            })

        });
    });
    function loadTable(){

        table = $('#users-table').dataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            destroy: true,
            stateSave: true,
            ajax: '{!! route('admin.employees.freeEmployees') !!}',
            language: {
                "url": "<?php echo __("app.datatable") ?>"
            },
            "fnDrawCallback": function( oSettings ) {
                $("body").tooltip({
                    selector: '[data-toggle="tooltip"]'
                });
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'status', name: 'status'},
                { data: 'created_at', name: 'created_at' },
                { data: 'action', name: 'action', width: '15%' }
            ]
        });
    }

    $('.toggle-filter').click(function () {
        $('#ticket-filters').toggle('slide');
    })

    $('#apply-filters').click(function () {
        loadTable();
    });

    $('#reset-filters').click(function () {
        $('#filter-form')[0].reset();
        $('#status').val('all');
        $('.select2').val('all');
        $('#filter-form').find('select').select2();
        loadTable();
    })

    function exportData(){

        var employee = $('#employee').val();
        var status   = $('#status').val();
        var role     = $('#role').val();

        var url = '{{ route('admin.employees.export', [':status' ,':employee', ':role']) }}';
        url = url.replace(':role', role);
        url = url.replace(':status', status);
        url = url.replace(':employee', employee);

        window.location.href = url;
    }

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
    //  "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
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