<ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="">
                        <i class="ni ni-tv-2 text-primary"></i> {{ __('Dashboard') }}
                    </a>
                </li>
                <li class="nav-item">
                    {{-- <a class="nav-link" href="/live"> --}}
                    <a class="nav-link" href="">
                        <i class="ni ni-basket text-success"></i> {{ __('Live Orders') }}<div class="blob red"></div>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link" href="{{ route('orders.index') }}">
                        <i class="ni ni-basket text-orange"></i> {{ __('Orders') }}
                    </a>
                </li> --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('users.index') }}">
                        <i class="ni ni-delivery-fast text-pink"></i> {{ __('Users') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('roles.index') }}">
                        <i class="ni ni-single-02 text-blue"></i> {{ __('Roles') }}
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.driver.payment.index') }}">
                        <i class="fa fa-money-bill text-red"></i> {{ __('Driver\'s Statements') }}
                    </a>
                </li>
                <li class="nav-item has-submenu dropdown">
                    <a class="nav-link dropdown-toggle" href="#">
                        <i class="fa fa-money-bill text-blue"></i> {{ __('Client Invoices') }} <span class="caret"></span>
                    </a>
                    <ul class="submenu collapse">
                        <li><a class="nav-link" href="{{ route('admin.postpaid.payment.index') }}">Postpaid Client </a></li>
                        <li><a class="nav-link" href="{{ route('admin.prepaid.client.order.list') }}">Prepaid Client </a></li>
                    </ul>
                </li>
                <li class="nav-item has-submenu dropdown">
                    <a class="nav-link dropdown-toggle" href="#">
                        <i class="ni ni-delivery-fast text-red"></i> {{ __('Delivery Fare Table') }} <span class="caret"></span>
                    </a>
                    <ul class="submenu collapse">
                        <li><a class="nav-link" href="{{ route('milages.index') }}">Mileage Fare Table </a></li>
                        <li><a class="nav-link" href="{{ route('fixedFare.index') }}">Fixed Fare Table </a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('cleanZone.index') }}">
                        <i class="ni ni-single-02 text-blue"></i> {{ __('Clean Air Zone') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('settings.index') }}">
                        <i class="ni ni-settings text-black"></i> {{ __('Settings') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('restorants.index') }}">
                        <i class="ni ni-shop text-info"></i> {{ __('Vendors') }}
                    </a>
                </li> --}}
            </ul>
