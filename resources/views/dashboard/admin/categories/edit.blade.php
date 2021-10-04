@extends('dashboard.layouts.app')
@section('title', 'Cập Nhật Danh Mục')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Cập Nhật Danh Mục</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Trang Chủ</a></li>
                            <li class="breadcrumb-item"><a href="{{route('admin.categories.index')}}">Danh Mục</a></li>
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
                        <form action="{{route('admin.categories.edit.update', $category->id)}}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Tên Danh Mục <span style="color: red;">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                               id="name" name="name" value="{{old('name', $category->name)}}">
                                        @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="parent_id">Danh Mục Cha <span style="color: red;">*</span></label>
                                        <select name="parent_id" id="parent_id"
                                                class="form-control @error('parent_id') is-invalid @enderror">
                                            <option value="">-----Chọn Danh Mục Cha-----</option>
                                            <option value="0" @if($category->parent_id == 0) selected @endif>Không
                                            </option>
                                            @foreach($categories as $c)
                                                <option value="{{$c->id}}"
                                                        @if($c->id == $category->parent_id) selected @endif>{{$c->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('parent_id')
                                        <div class=" invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="description">Mô Tả </label>
                                        <textarea class="form-control @error('description') is-invalid @enderror"
                                                  id="description" name="description"
                                                  rows="5">{{$category->description}}</textarea>
                                        @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Cập Nhật</button>
                        </form>
                    </div>
                </div>
            </div>

        </section>
    </div>
@endsection


@section('js')
    <script src="{{asset('js/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
@stop
