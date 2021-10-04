@extends('dashboard.layouts.app')
@section('title', 'Nhập Hàng')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Quản Lý Nhập Hàng</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Trang Chủ</a></li>
                            <li class="breadcrumb-item active">Nhập Hàng</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Tất Cả Hóa Đơn Nhập Hàng</h3>
                                <a href="{{route('admin.purchases.createOrder')}}"
                                   class="btn btn-primary fa-pull-right">Thêm Mới</a>
                            </div>

                            <div class="card-body">
                                <table id="table-purchases" class="table table-bordered table-striped display nowrap">
                                    <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Mã</th>
                                        <th>Người Nhập</th>
                                        <th>Vai Trò</th>
                                        <th>Tổng Tiền</th>
                                        <th>Thanh Toán</th>
                                        <th>Ngày Nhập</th>
                                        <th>Nội Dung</th>
                                        <th>Quản Lý</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                    <tr>
                                        <th>STT</th>
                                        <th>Mã</th>
                                        <th>Người Nhập</th>
                                        <th>Vai Trò</th>
                                        <th>Tổng Tiền</th>
                                        <th>Thanh Toán</th>
                                        <th>Ngày Nhập</th>
                                        <th>Nội Dung</th>
                                        <th>Quản Lý</th>
                                    </tr>
                                    </tfoot>
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
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Modal See Detail of one Purchase Order-->
    <div class="modal fade" id="purchaseDetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Xem Chi Tiết Đơn Hàng Nhập</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="detail_information" class="row">

                    </div>
                </div>
                <div class="modal-footer" id="modalFooter">
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')

    <link rel="stylesheet" href="{{asset('css/plugins/datatables/buttons.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/plugins/datatables/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/plugins/datatables/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/plugins/sweetalert2/sweetalert2.min.css')}}">

@stop


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
    <script src="{{asset('js/plugins/sweetalert2/sweetalert2.min.js')}}"></script>

    <script type="text/javascript">
        @if(session('success'))
        toastr.success('{{session("success")}}', 'Thành Công !', {timeOut: 5000});
        @php session()->forget('success'); @endphp
        @endif

        @if(session('error'))
        toastr.error('{{session("error")}}', 'Thất Bại !', {timeOut: 5000});
        @php session()->forget('error');@endphp
        @endif
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            //JS Custom dataTable
            $("#table-purchases").DataTable({
                scrollX: true, lengthChange: false, autoWidth: false,
                dom: 'lBfrtip',
                lengthMenu: [[10, 25, 50], ['10', '25', '50']],
                buttons: ["pageLength", "copy",
                    {
                        extend: 'csvHtml5',
                        charset: 'utf-8',
                        bom: true,
                        text: window.csvButtonTrans,
                        exportOptions: {columns: ':visible'}
                    },
                    {
                        extend: 'excel',
                        text: window.excelButtonTrans,
                        exportOptions: {columns: ':visible'}
                    },
                    {
                        extend: 'pdf',
                        text: window.pdfButtonTrans,
                        exportOptions: {columns: ':visible'}

                    }, {
                        extend: 'print',
                        text: window.printButtonTrans,
                        exportOptions: {columns: ':visible'}
                    }, "colvis"],
                ajax: "{{route('admin.purchases.list')}}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'code', name: 'code'},
                    {data: 'user', name: 'user'},
                    {data: 'role', name: 'role'},
                    {data: 'total', name: 'total'},
                    {data: 'payment', name: 'payment'},
                    {data: 'date', name: 'date'},
                    {data: 'content', name: 'content'},
                    {data: 'actions', name: 'actions'},
                ],
            }).buttons().container().appendTo('#table-purchases_wrapper .col-md-6:eq(0)');

            $(document).on('click', '.btn_detail', function (e) {
                $('#purchaseDetail').modal('show');
                var purchaseOrderId = $(this).val();
                var html ='<a href="https://pos_team3.example.com/purchases/print-pdf/'+purchaseOrderId+'" class="btn btn-success">In PDF</a>';
                html += '<button type="button" class="btn btn-primary" data-dismiss="modal">Đóng</button>';
                $('#modalFooter').html(html);
                $.ajax({
                    type: "GET",
                    url: "{{route('admin.purchases.detail')}}",
                    data: {purchaseOrderId: purchaseOrderId},
                    success: function (data) {
                        if (data) {
                            $('#detail_information').html(data);
                        }
                    }
                });
            });

            $(document).on('click', '.delete_btn', function (e) {
                e.preventDefault();
                var purchaseOrderId = $(this).val();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

                Swal.fire({
                    title: "Bạn có chắc muốn xóa ?", icon: "warning",
                    text: "Dữ liệu này sẽ bị xóa và không thể phục hồi :((",
                    showCancelButton: true,  showCancleButton: true,
                    confirmButtonText: "Đồng Ý", cancelButtonText: "Hủy",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: "{{route('admin.purchases.delete')}}",
                            data: {purchaseOrderId: purchaseOrderId},
                            success: function (response) {
                                if (response.status == '422' || response.status == '404') {
                                    Swal.fire({title: "Xóa thất bại !", text: response.msg, icon: "error"});
                                }
                                if (response.status == '200') {
                                    Swal.fire({title: "Xóa dữ liệu thành công !", icon: "succes"});
                                    $('#table-purchases').DataTable().ajax.reload(null, false);
                                }
                            }
                        });
                    } else if (result.dismiss) {
                        Swal.fire({title: "Hủy xóa dữ liệu !", icon: "info"});
                    }
                })
            });
        });
    </script>
@stop
