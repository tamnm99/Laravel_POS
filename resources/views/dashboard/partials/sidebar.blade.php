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
                            Qu???n L?? S???n Ph???m
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.suppliers.index') }}" class="nav-link">
                                <i class="fas fa-arrow-right" style="margin-left: 10px"></i>
                                <p>Nh?? cung c???p</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.products.index')}}" class="nav-link">
                                <i class="fas fa-arrow-right" style="margin-left: 10px"></i>
                                <p> S???n Ph???m</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.categories.index')}}" class="nav-link">
                                <i class="fas fa-arrow-right" style="margin-left: 10px"></i>
                                <p> Danh M???c</p>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.brands.index')}}" class="nav-link">
                                <i class="fas fa-arrow-right" style="margin-left: 10px"></i>
                                <p>Th????ng Hi???u</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.units.index') }}" class="nav-link">
                                <i class="fas fa-arrow-right" style="margin-left: 10px"></i>
                                <p>????n V??? T??nh</p></a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-file-invoice-dollar"></i>
                        <p>
                            H??a ????n B??n
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.posInvoices.index')}}" class="nav-link">
                                <i class="fas fa-arrow-right" style="margin-left: 10px"></i>
                                <p>H??a ????n B??n POS</p>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.saleInvoices.index')}}" class="nav-link">
                                <i class="fas fa-arrow-right" style="margin-left: 10px"></i>
                                <p>H??a ????n B??n H??ng</p>
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="nav-item">
                    <a href="{{ route('admin.customers.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>
                            Kh??ch h??ng
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.quotations.index') }}" class="nav-link">
                      <i class="nav-icon fas fa-tags"></i>
                      <p>
                        B???ng gi??
                      </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-store-alt"></i>
                        <p>
                            Nh???p H??ng
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.purchases.index')}}" class="nav-link">
                                <i class="fas fa-arrow-right" style="margin-left: 10px"></i>
                                <p>H??a ????n Nh???p H??ng</p>
                            </a>
                        </li>
                    </ul>
                </li>

                @role('Qu???n Tr???')
                <li class="nav-item">
                    <a href="{{route('admin.users.index')}}" class="nav-link">
                        <i class="fas fa-users-cog"></i>
                        <p> Nh??n Vi??n </p>
                    </a>
                </li>
                @endrole

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-cogs"></i>
                        <p>
                            C??i ?????t
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item" style="margin-left: 4px">
                            <a href="{{route('admin.deliveries.index')}}" class="nav-link">
                                <i class="fas fa-arrow-right" style="margin-left: 10px"></i>
                                <p>V???n Chuy???n</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.taxes.index')}}" class="nav-link">
                                <i class="fas fa-arrow-right" style="margin-left: 10px"></i>
                                <p>Thu???</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.customerGroups.index')}}" class="nav-link">
                                <i class="fas fa-arrow-right" style="margin-left: 10px"></i>
                                <p>Nh??m Kh??ch H??ng</p>
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
