@extends('dashboard.layouts.app')
@section('title', 'Phân Quyền')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Phân Quyền</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Trang Chủ</a></li>
                            <li class="breadcrumb-item"><a href="{{route('admin.users.index')}}">Người Dùng</a></li>
                            <li class="breadcrumb-item active">Phân Quyền</li>
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
                        <form action="{{route('admin.users.assignRole.process', $user->id)}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="full_name">Họ và Tên</label>
                                        <input type="text" class="form-control" id="full_name" name="full_name"
                                               value="{{$user->full_name}}" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="birthday">Ngày Sinh</label>
                                        <input type="text" class="form-control" id="birthday" name="birthday"
                                               value="{{$user->birthday}}" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="role">Chọn Vai Trò  <span style="color: red">*</span></label>
                                        <select class="form-control" id="role" name="role">
                                            @foreach($allRoles as $role)
                                                <option value="{{$role->id}}"
                                                        @if($role->id == $userRoleId) selected @endif>
                                                    {{$role->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                               value="{{$user->email}}" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="address">Địa Chỉ</label>
                                        <input type="text" class="form-control" id="address" name="address"
                                               value="{{$user->address}}" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="permissions">Quyền Hạn  <span style="color: red">*</span></label>
                                        <select multiple class="form-control select2 @error('permissions') is-invalid @enderror" id="permissions"
                                                name="permissions[]" data-placeholder="Chọn Quyền Hạn">
                                            @foreach($allPermissions as $permission)
                                                <option value="{{$permission->id}}"
                                                        @if(in_array($permission->name, $userPermissions->toArray())) selected @endif>
                                                    {{$permission->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('permissions')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Phân Quyền</button>
                        </form>
                    </div>
                </div>
            </div>

        </section>
    </div>
@stop

@section('css')

@stop


@section('js')

    <script src="{{asset('js/plugins/select2/select2.full.min.js')}}"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('.select2').select2();
        });
    </script>
@stop

