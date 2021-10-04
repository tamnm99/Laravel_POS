@extends('dashboard.layouts.app')
@section('title', 'Profile')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Hồ Sơ</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Trang Chủ</a></li>
                            <li class="breadcrumb-item active">Hồ Sơ</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                {{--Form Update Profile Information--}}
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">Thông Tin Cá Nhân</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i
                                    class="fas fa-expand"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.profile.updateProfile', $user->id)}}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="full_name">Họ và Tên <span style="color: red">*</span></label>
                                        <input type="text" class="form-control @error('full_name') is-invalid @enderror"
                                               id="full_name" name="full_name" value="{{$user->full_name}}">
                                        @error('full_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                    </div>

                                    <div class="form-group">
                                        <label for="birthday">Ngày Sinh <span style="color: red">*</span></label>
                                        <input type="text" class="form-control  @error('birthday') is-invalid @enderror"
                                               id="birthday" placeholder="dd/mm/yyyy" name="birthday"
                                               value="{{($user->birthday != '') ? date('d-m-Y',strtotime($user->birthday)): ''}}">
                                        @error('birthday')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="form-group">
                                        <label for="role">Vai Trò</label>
                                        <select class="form-control" id="role" disabled>
                                            @foreach($user->roles as $key => $role)
                                                <option>{{$role->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="birthday">Avatar</label>
                                        <input type="file" class="form-control @error('avatar') is-invalid @enderror"
                                               id="avatar" name="avatar">
                                        @error('avatar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                               value="{{$user->email}}" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="address">Địa Chỉ  <span style="color: red">*</span></label>
                                        <input type="text" class="form-control  @error('address') is-invalid @enderror"
                                               id="address" name="address" value="{{$user->address}}">
                                        @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="permissions">Quyền Hạn</label>
                                        <select multiple class="form-control select2" disabled id="permissions"
                                                data-placeholder="Chọn Quyền Hạn">
                                            @foreach($user->permissions as $key => $permissions)
                                                <option selected>{{$permissions->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    @if($user->avatar==null)
                                        <img class="img-thumbnail" width="150px" alt="User Image"
                                             src="{{asset('image/avatar_icon.png')}}">
                                    @else
                                        <img class="img-thumbnail" width="150px" alt="User Image"
                                             src="{{asset($user->avatar)}}">
                                    @endif
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </form>
                    </div>
                </div>

                {{--Form Update Password--}}
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">Đổi Mật Khẩu</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <form action="{{route('admin.profile.changePassword', $user->id)}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="old_password">Mật Khẩu Cũ</label>
                                <input type="password" class="form-control @error('old_password') is-invalid @enderror"
                                       id="old_password" name="old_password">
                                @error('old_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="new_password">Mật Khẩu Mới</label>
                                <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                                       id="new_password" name="new_password">
                                @error('new_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="retype_new_password">Nhập Lại Mật Khẩu Mới</label>
                                <input type="password"
                                       class="form-control @error('retype_new_password') is-invalid @enderror"
                                       id="retype_new_password" name="retype_new_password">
                                @error('retype_new_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Đổi Mật Khẩu</button>
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
        @if(session('success'))
        toastr.success('{{session("success")}}', 'Thành công !!!', {timeOut: 5000});
        @php session()->forget('success');@endphp
        @endif
        @if(session('error'))
        toastr.error('{{session("error")}}', 'Thất bại !!!', {timeOut: 5000});
        @php session()->forget('success');@endphp
        @endif
    </script>

    <script>
        $(document).ready(function () {
            $('.select2').select2();

            $('#birthday').datepicker({format: 'dd-mm-yyyy',});

        });
    </script>
@stop









