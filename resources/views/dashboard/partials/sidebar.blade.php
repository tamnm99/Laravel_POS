<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('admin.dashboard')}}" class="brand-link">
        <img src="{{asset('image/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">TEAM 3</span>
    </a>


    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">

            <div class="image">
                @php $user = Auth::user();

                @endphp
                @if($user->avatar==null)
                    <img src="{{asset('image/avatar_icon.png')}}" class="img-circle elevation-2" alt="User Image">
                @else
                    <img src="{{asset($user->avatar)}}" class="img-circle elevation-2" alt="User Image">
                @endif
            </div>

            <div class="info">
                <a href="{{route('admin.profile.index')}}" class="d-block">{{$user->full_name}}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.dashboard')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.pos.index') }}" class="nav-link">
                        <p><i class="fas fa-cart-plus"></i> POS </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fab fa-product-hunt"></i>
                        <p>
                            Quản Lý Sản Phẩm
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.suppliers.index') }}" class="nav-link">
                                <i class="fas fa-arrow-right" style="margin-left: 10px"></i>
                                <p>Nhà cung cấp</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.products.index')}}" class="nav-link">
                                <i class="fas fa-arrow-right" style="margin-left: 10px"></i>
                                <p> Sản Phẩm</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.categories.index')}}" class="nav-link">
                                <i class="fas fa-arrow-right" style="margin-left: 10px"></i>
                                <p> Danh Mục</p>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.brands.index')}}" class="nav-link">
                                <i class="fas fa-arrow-right" style="margin-left: 10px"></i>
                                <p>Thương Hiệu</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.units.index') }}" class="nav-link">
                                <i class="fas fa-arrow-right" style="margin-left: 10px"></i>
                                <p>Đơn Vị Tính</p></a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-file-invoice-dollar"></i>
                        <p>
                            Hóa Đơn Bán
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.posInvoices.index')}}" class="nav-link">
                                <i class="fas fa-arrow-right" style="margin-left: 10px"></i>
                                <p>Hóa Đơn Bán POS</p>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.saleInvoices.index')}}" class="nav-link">
                                <i class="fas fa-arrow-right" style="margin-left: 10px"></i>
                                <p>Hóa Đơn Bán Hàng</p>
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="nav-item">
                    <a href="{{ route('admin.customers.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>
                            Khách hàng
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.quotations.index') }}" class="nav-link">
                      <i class="nav-icon fas fa-tags"></i>
                      <p>
                        Bảng giá
                      </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-store-alt"></i>
                        <p>
                            Nhập Hàng
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.purchases.index')}}" class="nav-link">
                                <i class="fas fa-arrow-right" style="margin-left: 10px"></i>
                                <p>Hóa Đơn Nhập Hàng</p>
                            </a>
                        </li>
                    </ul>
                </li>

                @role('Quản Trị')
                <li class="nav-item">
                    <a href="{{route('admin.users.index')}}" class="nav-link">
                        <i class="fas fa-users-cog"></i>
                        <p> Nhân Viên </p>
                    </a>
                </li>
                @endrole

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-cogs"></i>
                        <p>
                            Cài Đặt
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item" style="margin-left: 4px">
                            <a href="{{route('admin.deliveries.index')}}" class="nav-link">
                                <i class="fas fa-arrow-right" style="margin-left: 10px"></i>
                                <p>Vận Chuyển</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.taxes.index')}}" class="nav-link">
                                <i class="fas fa-arrow-right" style="margin-left: 10px"></i>
                                <p>Thuế</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.customerGroups.index')}}" class="nav-link">
                                <i class="fas fa-arrow-right" style="margin-left: 10px"></i>
                                <p>Nhóm Khách Hàng</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
