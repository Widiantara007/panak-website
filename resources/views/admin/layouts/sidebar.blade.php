<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color:#790C5A !important;background-image:linear-gradient(
180deg,#790C5A 10%,#570339 100%) !important;">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('admin')}}">
        <div class="sidebar-brand-icon">
            <!-- <i class="fas fa-laugh-wink"></i> --><img src="{{asset('assets/img/logo.svg')}}" style="width:60px;">
        </div>
        <div class="sidebar-brand-text mx-3">PANAK.ID</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{last(request()->segments()) == 'admin' ? 'active':''}}">
        <a class="nav-link" href="{{route('admin')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Bisnak
    </div>

    <li class="nav-item {{ Request::segment(2)=='project-owner' ? 'active':'' }}">
        <a class="nav-link" href="{{route('project-owner.index')}}">
            <i class="fas fa-people-carry"></i>
            <span>Project Owner</span></a>
    </li>
    <li class="nav-item {{ Request::segment(2)=='project-type' ? 'active':'' }}">
        <a class="nav-link" href="{{route('project-type.index')}}">
            <i class="fas fa-list-ol"></i>
            <span>Project Type</span></a>
    </li>
    <li class="nav-item {{ Request::segment(2)=='project' ? 'active':'' }}">
        <a class="nav-link" href="{{route('project.index')}}">
            <i class="fas fa-tasks"></i>
            <span>Project</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('withdrawals.index')}}">
            <i class="fab fa-google-wallet"></i>
            <span>Withdrawal</span></a>


        <hr class="sidebar-divider">

        <div class="sidebar-heading">
            Pasarnak
        </div>
    <li class="nav-item {{ Request::segment(2)=='product' ? 'active':'' }}">
        <a class="nav-link" href="{{route('product.index')}}">
            <i class="fab fa-product-hunt"></i>
            <span>Product</span></a>
    </li>
    <li class="nav-item {{ Request::segment(2)=='order' ? 'active':'' }}">
        <a class="nav-link" href="{{route('order.index')}}">
            <i class="fas fa-shopping-cart"></i>
            <span>Order</span></a>
    </li>
    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Edunak
    </div>
    <li class="nav-item {{ Request::segment(2)=='edunak-article' ? 'active':'' }}">
        <a class="nav-link" href="{{route('edunak-article.index')}}">
            <i class="fas fa-newspaper"></i>
            <span>Artikel</span></a>
    </li>

    <li class="nav-item {{ Request::segment(2)=='edunak-category' ? 'active':'' }}">
        <a class="nav-link" href="{{route('edunak-category.index')}}">
            <i class="far fa-newspaper"></i>
            <span>Category</span></a>
    </li>
    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Manajemen
    </div>

    <li class="nav-item {{ Request::segment(2)=='user' ? 'active':'' }}">
        <a class="nav-link" href="{{route('user.index')}}">
            <i class="fas fa-users"></i>
            <span>User</span></a>
    </li>
    <li class="nav-item {{ Request::segment(2)=='user_verification' ? 'active':'' }}">
        <a class="nav-link" href="{{route('user.verification.index')}}">
            <i class="fas fa-user-check"></i>
            <span>User Verification</span></a>
    </li>
    <li class="nav-item {{ Request::segment(2)=='bank' ? 'active':'' }}">
        <a class="nav-link" href="{{route('bank.index')}}">
            <i class="fas fa-piggy-bank"></i>
            <span>Bank</span></a>
    </li>
    <li class="nav-item {{ Request::segment(2)=='log' ? 'active':'' }}">
        <a class="nav-link" href="{{route('log.index')}}">
            <i class="fas fa-clipboard-list"></i>
            <span>Log</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('slider.index')}}">
            <i class="fas fa-ad"></i>
            <span>Slider</span></a>
    </li>





    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>