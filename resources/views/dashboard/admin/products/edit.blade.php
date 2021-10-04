@extends('dashboard.layouts.app')
@section('title', 'Cập Nhật Sản Phẩm')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Cập Nhật Sản Phẩm</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Trang Chủ</a></li>
                            <li class="breadcrumb-item"><a href="{{route('admin.products.index')}}">Sản Phẩm</a></li>
                            <li class="breadcrumb-item active">Cập Nhật</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card card-default">
                    <div class="card-body">
                        <form action="{{route('admin.products.edit.update',$product->id)}}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Tên Sản Phẩm <span style="color: red">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                               id="name" name="name" value="{{old('name', $product->name)}}">
                                        @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="price_in">Giá Nhập <span style="color: red">*</span></label>
                                        <input type="number"
                                               class="form-control @error('price_in') is-invalid @enderror"
                                               id="price_in" name="price_in" placeholder=".....VNĐ"
                                               value="{{old('price_in', $product->price_in)}}">
                                        @error('price_in')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="price_out">Giá Bán <span style="color: red">*</span></label>
                                        <input type="number"
                                               class="form-control @error('price_out') is-invalid @enderror"
                                               id="price_out" name="price_out" placeholder=".....VNĐ"
                                               value="{{old('price_out', $product->price_out)}}">
                                        @error('price_out')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="quantity">Số Lượng <span style="color: red">*</span></label>
                                        <input type="number"
                                               class="form-control  @error('quantity') is-invalid @enderror"
                                               id="quantity" name="quantity"
                                               value="{{old('quantity', $product->quantity)}}">
                                        @error('quantity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="quantity_alert">Số Lượng Cảnh Báo <span style="color: red">*</span></label>
                                        <input type="number"
                                               class="form-control  @error('quantity_alert') is-invalid @enderror"
                                               id="quantity_alert" name="quantity_alert"
                                               value="{{old('quantity_alert', $product->quantity_alert)}}">
                                        @error('quantity_alert')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="category_id">Danh Mục Sản Phẩm <span
                                                style="color: red">*</span></label>
                                        <select class="form-control  @error('category_id') is-invalid @enderror"
                                                name="category_id" id="category_id">
                                            <option value="">-----Chọn Danh Mục Sản Phẩm-----</option>
                                            @foreach($categories as $c)
                                                <option value="{{$c->id}}"
                                                        @if($c->id == $product->category->id) selected @endif>{{$c->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="brand_id">Thương Hiệu Sản Phẩm<span
                                                style="color: red">*</span></label>
                                        <select class="form-control @error('brand_id') is-invalid @enderror" name="brand_id" id="brand_id">
                                            <option value="">-----Chọn Thương Hiệu Sản Phẩm-----</option>
                                            @foreach($brands as $b)
                                                <option value="{{$b->id}}"
                                                        @if($b->id == $product->brand->id) selected @endif>{{$b->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('brand_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="supplier_id">Nhà Cung Cấp <span style="color: red">*</span></label>
                                        <select class="form-control @error('supplier_id') is-invalid @enderror" name="supplier_id" id="supplier_id">
                                            <option value="">-----Chọn Nhà Cung Cấp Sản Phẩm-----</option>
                                            @foreach($suppliers as $s)
                                                <option value="{{$s->id}}"
                                                        @if($s->id == $product->supplier->id) selected @endif>{{$s->name}}</option>

                                            @endforeach
                                        </select>
                                        @error('supplier_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="photo">Ảnh</label>
                                        <input class="form-control  @error('photo') is-invalid @enderror" type="file"
                                               id="photo" name="photo">
                                        @error('photo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    @if($product->photo==null)
                                        <img class="img-thumbnail" width="150px" alt="Product Image"
                                             src="{{asset('image/no_img.png')}}">
                                    @else
                                        <img class="img-thumbnail" width="150px" alt="User Image"
                                             src="{{asset($product->photo)}}">
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="description">Mô Tả</label>
                                        <textarea class="form-control  @error('description') is-invalid @enderror"
                                                  id="ckeditor1" name="description"
                                                  placeholder="Description">{{old('description', $product->description)}}</textarea>
                                        @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="mfg">Ngày Sản Xuất</label>
                                        <input type="text"
                                               class="form-control datepicker @error('mfg') is-invalid @enderror"
                                               id="mfg" name="mfg"
                                               value="{{old('mfg',(($product->mfg != null) ? date('d-m-Y',strtotime($product->mfg)) : ''))}}">
                                        @error('mfg')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                    </div>
                                    <div class="form-group">
                                        <label for="exp">Ngày Hết Hạn</label>
                                        <input type="text"
                                               class="form-control datepicker @error('exp') is-invalid @enderror"
                                               id="exp" name="exp"
                                               value="{{old('exp',(($product->exp != null) ? date('d-m-Y',strtotime($product->exp)) : ''))}}">
                                        @error('exp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="unit_id">Đơn Vị Tính <span style="color: red">*</span></label>
                                        <select class="form-control @error('unit_id') is-invalid @enderror" name="unit_id" id="unit_id">
                                            <option value="">-----Chọn Đơn Vị Tính-----</option>
                                            @foreach($units as $u)
                                                <option value="{{$u->id}}" @if($product->unit->id == $u->id ) selected @endif >
                                                    {{$u->unit_name}}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('unit_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="barcode">Mã Vạch <span style="color: red">*</span></label>
                                        <input type="number"
                                               class="form-control  @error('barcode') is-invalid @enderror"
                                               id="barcode" name="barcode"
                                               value="{{old('barcode', $product->barcode)}}">
                                        @error('barcode')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Cập Nhật</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </section>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{asset('css/plugins/date-picker/bootstrap-datepicker.min.css')}}">
@stop


@section('js')

    <script src="{{asset('js/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>

    <script src="//cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script src="{{asset('js/plugins/date-picker/bootstrap-datepicker.min.js')}}"></script>


    <script type="text/javascript">
        CKEDITOR.replace('ckeditor1');
        $('.datepicker').datepicker({format: 'dd-mm-yyyy',});
    </script>
@stop
