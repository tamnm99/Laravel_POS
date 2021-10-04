@extends('dashboard.layouts.app')
@section('title', 'Customer')
@section('css')

    <link rel="stylesheet" href="{{asset('css/plugins/datatables/buttons.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/plugins/datatables/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/plugins/datatables/responsive.bootstrap4.min.css')}}">

@stop

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Khách Hàng</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Customer</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header" style="height: 60px;display: flex;">
                            <h3 class="card-title" style="margin-top: 5px;">Thêm dữ liệu Khách hàng</h3>
                            <a class="btn btn-success" href="{{route('admin.customers.create')}}"  style="margin-left: 30px;"><i class="fa fa-plus"></i> Tạo mới</a>
                            <a class="btn btn-primary" href="{{ route('admin.customers.data.import')}}" style="margin-left: 30px;"><i class="fa fa-upload"></i> Nhập File</a> 
                        </div>

                        <div class="card-body">
                            <table class="table table-bordered table-striped" id="customers-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên</th>
                                        <th>SĐT</th>
                                        <th>Email</th>
                                        <th>Ghi chú</th>
                                        <th>Địa chỉ</th>
                                        <th>Nhóm KH</th>
                                        <th>Tác vụ</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('modal')
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel">Xóa Khách hàng!</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
        </div>
        <div class="modal-body">
            Bạn có muốn xóa khách hàng này ?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            <button type="button" class="btn btn-danger" name="ok_button" id="ok_button">Xóa</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')

<!-- DataTables  & Plugins -->
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


<script type=text/javascript>
    $(document).ready(function(){
        
        $('#customers-table').DataTable({
            processing: true,
            serverSide: false,

            responsive: true, lengthChange: true, autoWidth: false,
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
            ajax:{
            url:"{{ route('admin.customers.index') }}",
        	},
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'phone', name: 'phone' },
                { data: 'email', name: 'email' },
                { data: 'note', name: 'note' },
                { data: 'address', name: 'address' },
                { data: 'customer_group_id', name: 'customer_group_id' },
                { data: 'action', name: 'action', orderable: false }
            ]
        }).buttons().container().appendTo('#customers-table_wrapper .col-md-6:eq(0)');
        
        // Modal Delete
        var customer_id;

        $(document).on('click', '.delete', function(){
            customer_id = $(this).attr('id');
            $('#deleteModal').modal('show');
        });
        $('#ok_button').click(function (){
            $.ajax({
                url: "/customers/delete/"+customer_id,
                // beforeSend:function (){
                //     $('#ok_button').text('Deleting...');
                // },
                success:function(data){
                    setTimeout(function(){
                        $('#deleteModal').modal('hide');
                        $('#customers-table').DataTable().ajax.reload();
                        alert('Data deleted');
                    }, 500);
                },
            })
        });

    });

</script>
@stop

