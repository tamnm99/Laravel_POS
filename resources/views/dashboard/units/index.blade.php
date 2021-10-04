@extends('dashboard.layouts.app')
@section('title', 'Units')
@section('css')
 <link rel="stylesheet" href="{{asset('css/plugins/datatables/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/plugins/datatables/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/plugins/datatables/buttons.bootstrap4.min.css')}}">
@stop
@section('content')
     <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-10">
                        <h1 class="m-0">Bảng Đơn Vị</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-2">
                            <a type="button" class="btn btn-sm btn-outline-secondary" href="{{route('admin.units.create')}}">Create Unit</a>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
         
       
        <!-- Main content -->
       
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                
                        <div class="card">
                            <div class="card-header border-0">
                              
                                <div class="card-tools">
                                    <a href="#" class="btn btn-tool btn-sm">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <a href="#" class="btn btn-tool btn-sm">
                                        <i class="fas fa-bars"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="card-body ">
                                <table id="example1" class="table table-bordered table-striped">
                                  <thead>
                                  <tr>
                                    <th>#</th>
                                    <th>Unit Code</th>
                                    <th>Unit Name</th>
                                    <th>Action</th>
                                   
                                  </tr>
                                  </thead>
                                 </table>
                               </div>
                        </div>
                        <!-- /.card -->
                    
                    <!-- /.col-md-6 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    </div>
@stop
<!-- Modal -->
@section('modal')
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel">Delete Unit!</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
        </div>
        <div class="modal-body">
            Are you want to delete this Unit?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-danger" name="ok_button" id="ok_button">Delete</button>
        </div>
      </div>
    </div>
  </div>
@endsection


@section('js')
<script src="{{asset('js/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('js/plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('js/plugins/datatables/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('js/plugins/datatables/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('js/plugins/datatables/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('js/plugins/datatables/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('js/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('js/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('js/plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('js/plugins/datatables/buttons.html5.min.js')}}"></script>
<script src="{{asset('js/plugins/datatables/buttons.print.min.js')}}"></script>
<script src="{{asset('js/plugins/datatables/buttons.colVis.min.js')}}"></script>

 <script type="text/javascript">
     
$(document).ready(function(){
    $('#example1').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
       "lengthChange": false,
        "autoWidth": false,
        dom: 'lBfrtip',
            buttons: [
                "copy",
                {
                    extend: "csv",
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: "pdf",
                    exportOptions: {
                        columns: ':visible'
                    }
                }, 
                {
                    extend: "print",
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                "colvis"
            ],

        
        ajax: "{{ route('admin.units.index')}}",
        columns: [
            { data: 'id', name: 'id' },
            { data: 'unit_code', name: 'unit_code' },
            { data: 'unit_name', name: 'unit_name' },
            { data: 'action', name: 'action', orderable: false }
        ]
        
    }).buttons() .container() .appendTo('#example1_wrapper .col-md-6:eq(0)');


  
  
        var unit_id;
        $(document).on('click', '.delete', function(){
            unit_id = $(this).attr('id');
            $('#deleteModal').modal('show');
        });
        $('#ok_button').click(function (){
            $.ajax({
                url: "/units/delete/"+unit_id,
                beforeSend:function (){
//                     $('#ok_button').text('Ok');
                },
                success:function(data){
                    setTimeout(function(){
                        $('#deleteModal').modal('hide');
                        $('#example1').DataTable().ajax.reload();
                        alert('Data deleted');
                    },1000 );
                },
            })
        });
});
</script>

@stop


