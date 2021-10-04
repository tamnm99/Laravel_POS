@extends('dashboard.layouts.app')
@section('title', 'Chỉnh Sửa Đơn Nhập Hàng')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Chỉnh Sửa Đơn Nhập Hàng</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Trang Chủ</a></li>
                            <li class="breadcrumb-item"><a href="{{route('admin.purchases.index')}}">Nhập Hàng</a></li>
                            <li class="breadcrumb-item active">Chỉnh Sửa</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                {{--Form create new order purchase--}}
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title"><strong>Mã Đơn:</strong> {{$purchaseOrder->code}} </h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i
                                    class="fas fa-expand"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST" id="edit_purchase_form">
                            @csrf
                            <div class="row">
                                <div class="table-repsonsive">
                                    <table class="table table-bordered" id="item_table">
                                        <thead>
                                        <tr>
                                            <th width="18%">Nhà Cung Cấp  <span style="color: red">*</span></th>
                                            <th width="15%">Sản Phẩm  <span style="color: red">*</span></th>
                                            <th>Giá Nhập</th>
                                            <th width="9%">Số Lượng  <span style="color: red">*</span></th>
                                            <th>Sản Xuất</th>
                                            <th>Hạn</th>
                                            <th>Thành Tiền</th>
                                            <th>
                                                <button type="button" name="add" class="btn btn-success btn-sm add"><i
                                                        class="fas fa-plus"></i></button>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php $i = 1 @endphp
                                        @foreach($purchaseOrder->purchase_order_details as $row)
                                            <tr>
                                                <td><select name="item_supplier[]" data-supplier_row="{{$i}}"
                                                            class="form-control item_supplier">
                                                        <option value="">Chọn</option>
                                                        @foreach($suppliers as $supplier)
                                                            @if($supplier->id == $row->suppliers->id)
                                                                <option value="{{$supplier->id}}" selected>
                                                                    {{$supplier->name}}
                                                                </option>
                                                            @else
                                                                <option value="{{$supplier->id}}">{{$supplier->name}}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td><select name="item_product[]" class="form-control item_product"
                                                            data-product_row="{{$i}}" id="item_product-{{$i}}">
                                                        <option value="">Chọn</option>
                                                        @foreach($products as $product)
                                                            @if($product->id == $row->products->id)
                                                                <option value="{{$product->id}}" selected>
                                                                    {{$product->name}}
                                                                </option>
                                                            @else
                                                                <option value="{{$product->id}}">{{$product->name}}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td><input type="text" name="item_priceIn[]"
                                                           value="{{$row->products->price_in}}"
                                                           class="form-control item_priceIn"
                                                           id="item_priceIn-{{$i}}" readonly></td>
                                                <td><input type="text" name="item_quantity[]"
                                                           value="{{$row->buying_quantity}}"
                                                           class="form-control item_quantity"
                                                           data-quantity_row="{{$i}}"
                                                           id="item_quantity-{{$i}}"/></td>
                                                <td><input type="text" name="item_mfg[]" class="form-control item_mfg datepicker"
                                                           value="{{($row->mfg != '') ? date('d-m-Y',strtotime($row->mfg)): ''}}"
                                                           id="item_mfg-{{$i}}"></td>
                                                <td><input type="text" name="item_exp[]" class="form-control item_exp datepicker"
                                                           id="item_exp-{{$i}}"
                                                           value="{{($row->exp != '') ? date('d-m-Y',strtotime($row->exp)): ''}}">
                                                </td>
                                                <td><input type="text" name="item_subTotal[]"
                                                           class="form-control item_subTotal"
                                                           data-subTotal_row="{{$i}}" value="{{$row->sub_total}}"
                                                           id="item_subTotal-{{$i}}" readonly></td>
                                                <td>
                                                    <button type="button" name="remove"
                                                            class="btn btn-danger btn-sm remove">
                                                        <i class="fas fa-minus"></i></button>
                                                </td>

                                            </tr>
                                            @php $i = $i+1; @endphp
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="payment">Hình Thức Thanh Toán  <span style="color: red">*</span></label>
                                        <select name="payment" id="payment" class="form-control">
                                            <option value="">-----Chọn-----</option>
                                            <option value="1" @if($purchaseOrder->payment == 1) selected @endif>Tiền
                                                Mặt
                                            </option>
                                            <option value="2" @if($purchaseOrder->payment == 2) selected @endif>Chuyển
                                                Khoản
                                            </option>
                                            <option value="3" @if($purchaseOrder->payment == 3) selected @endif>Thẻ
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 offset-md-7">
                                    <div class="form-group">
                                        <label for="total">Tổng Tiền</label>
                                        <input type="number" class="form-control" id="total" name="total"
                                               readonly value="{{$purchaseOrder->total}}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description">Nội Dung Nhập Hàng</label>
                                        <textarea type="text" class="form-control" id="description" name="description"
                                                  rows="3">{{$purchaseOrder->content}}</textarea>

                                    </div>
                                </div>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary">Cập Nhật</button>
                        </form>
                    </div>
                </div>

            </div>
        </section>
    </div>
    <!-- /.content-wrapper -->

@stop

@section('css')
    <link rel="stylesheet" href="{{asset('css/plugins/date-picker/bootstrap-datepicker.min.css')}}">

@stop

@section('js')
    <script src="{{asset('js/plugins/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('js/plugins/date-picker/bootstrap-datepicker.min.js')}}"></script>

    <script type="text/javascript">
        $(document).ready(function () {

            $('.datepicker').datepicker({format: 'dd-mm-yyyy'});

            var count = {{$count}};
            var suppliers = @json($suppliers);
            $(document).on('click', '.add', function () {
                count++;
                var html = '';
                html += '<tr>';
                html += '<td><select name="item_supplier[]" class="form-control item_supplier" data-supplier_row="' + count + '">' +
                    '<option value="">Chọn</option>'
                for (var i = 0; i < suppliers.length; i++) {
                    html += '<option value="' + suppliers[i].id + '">' + suppliers[i].name + '</option>';
                }
                html += '</select></td>';

                html += '<td><select name="item_product[]" class="form-control item_product" data-product_row="' + count + '" id="item_product-' + count + '">' +
                    '<option value="">Chọn</option></select></td>';
                html += '<td><input type="text" name="item_priceIn[]" class="form-control item_priceIn" id="item_priceIn-' + count + '" readonly></td>';
                html += '<td><input type="text" name="item_quantity[]" class="form-control item_quantity" data-quantity_row="' + count + '" id="item_quantity-' + count + '"/></td>';
                html += '<td><input type="text" name="item_mfg[]" class="form-control item_mfg" id="item_mfg-' + count + '"></td>';
                html += '<td><input type="text" name="item_exp[]" class="form-control item_exp"  id="item_exp-' + count + '"</td>';
                html += '<td><input type="text" name="item_subTotal[]" class="form-control item_subTotal" data-subTotal_row="' + count + '" id="item_subTotal-' + count + '"  readonly></td>';
                html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><i class="fas fa-minus"></i></button></td>';
                $('tbody').append(html);
                $('#item_mfg-' + count).datepicker({format: 'dd-mm-yyyy'});
                $('#item_exp-' + count).datepicker({format: 'dd-mm-yyyy'});
            });

            $(document).on('click', '.remove', function () {
                $(this).closest('tr').remove();
                calculate_total(count);
            });

            $(document).on('change', '.item_supplier', function () {
                var supplier_id = $(this).val();
                var supplier_row = $(this).data('supplier_row');
                var _token = $('input[name="_token"]').val();

                $.ajax({
                    url: "{{route('admin.purchases.selectProduct')}}",
                    method: "POST",
                    data: {supplier_id: supplier_id, _token: _token},
                    success: function (data) {
                        var html = '<option value="">Chọn</option>';
                        html += data;
                        $('#item_product-' + supplier_row).html(html);
                    }
                })
            });

            $(document).on('change', '.item_product', function () {
                var product_id = $(this).val();
                var product_row = $(this).data('product_row');
                var _token = $('input[name="_token"]').val();

                $.ajax({
                    url: "{{route('admin.purchases.selectPrice')}}",
                    method: "POST",
                    data: {product_id: product_id, _token: _token},
                    success: function (data) {
                        $('#item_priceIn-' + product_row).val(data);
                    }
                })
            });

            function calculate_total(count) {
                var total = 0;
                for (j = 1; j <= count; j++) {
                    var quantity = $('#item_quantity-' + j).val();
                    if (quantity > 0) {
                        var price = $('#item_priceIn-' + j).val();
                        if (price > 0) {
                            var sub_total = parseFloat(quantity) * parseFloat(price);
                            $('#item_subTotal-' + j).val(sub_total);
                            total += sub_total;
                        }
                    }
                }
                $('#total').val(total);
            }

            function compare_date(count) {
                for (k = 1; k <= count; k++) {
                    var mfg = $('#item_mfg-' + k).val();
                    var exp = $('#item_exp-' + k).val();
                    if (mfg != '' && exp == '' || mfg == '' && exp != '') {
                        toastr.error('Hạn và Ngày Sản Xuất phải được nhập cùng nhau', 'Có lỗi khi nhập hàng !', {timeOut: 7000});
                        return true;
                    } else {
                        var now_date = new Date();
                        mfg = $('#item_mfg-' + k).datepicker('getDate');
                        exp = $('#item_exp-' + k).datepicker('getDate');
                        if (mfg > exp) {
                            toastr.error('Ngày Sản xuất phải nhỏ hơn Hạn Sử Dụng', 'Có lỗi khi nhập hàng !', {timeOut: 7000});
                            return true;
                        }
                        if (mfg > now_date) {
                            toastr.error('Ngày Sản xuất phải nhỏ hơn Hiện Tại', 'Có lỗi khi nhập hàng !', {timeOut: 7000});
                            return true;
                        }
                        if (exp != null && exp < now_date) {
                            toastr.error('Hạn Sử dụng phải lớn hơn Hiện Tại', 'Có lỗi khi nhập hàng !', {timeOut: 7000});
                            return true;
                        }
                    }
                }
                return false;
            }

            $(document).on('blur', '.item_quantity', function () {
                calculate_total(count);
            });

            $('#edit_purchase_form').on('submit', function (event) {

                event.preventDefault();
                var has_error = false;
                $('.item_supplier').each(function () {
                    if ($(this).val() == '') {
                        has_error = true;
                        toastr.error('Nhà cung cấp tại hàng nào đó chưa nhập', 'Có lỗi khi nhập hàng !', {timeOut: 7000});
                        return false;
                    }
                });

                $('.item_product').each(function () {
                    if ($(this).val() == '') {
                        has_error = true;
                        toastr.error('Sản Phẩm tại hàng nào đó chưa nhập', 'Có lỗi khi nhập hàng !', {timeOut: 7000});
                        return false;
                    }
                });

                $('.item_quantity').each(function () {
                    if ($(this).val() == '') {
                        has_error = true;
                        toastr.error('Số Lượng tại hàng nào đó chưa nhập', 'Có lỗi khi nhập hàng !', {timeOut: 7000});
                        return false;
                    }
                });

                if (has_error == false) {
                    if ($('#total').val() == 0) {
                        has_error = true;
                        toastr.error('Chưa có dữ liệu nhập hàng', 'Có lỗi khi nhập hàng !', {timeOut: 7000});
                        return false;
                    }
                    has_error = compare_date(count);
                    if (($('#payment').val() < 1) && ($('#total').val() != 0)) {
                        has_error = true;
                        toastr.error('Chưa chọn hình thức thanh toán', 'Có lỗi khi nhập hàng !', {timeOut: 7000});
                        return false;
                    }
                }
                if ((has_error == false)) {
                    var form_data = $(this).serialize();
                    var _token = $('input[name="_token"]').val();
                    var total = $('#total').val();
                    var description = $('#description').val();
                    var payment = $('#payment').val();
                    $.ajax({
                        url: "{{route('admin.purchases.updateOrder', $purchaseOrder->id)}}",
                        method: "POST",
                        dataType: "JSON",
                        data: {
                            form_data: form_data,
                            total: total,
                            description: description,
                            _token: _token,
                            payment: payment
                        },
                        success: function (data) {
                            if (data == 'Success') {}
                        }
                    });
                    toastr.success( 'Cập nhật lại đơn hàng thành công !', 'Thành Công!', {timeOut: 4000});
                    window.location.href = "{{route('admin.purchases.index')}}";
                }
            });
        });

    </script>
@stop
