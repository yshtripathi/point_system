<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('user')}}">
      <div class="sidebar-brand-text mx-3">RiseBeyond</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Request::is('user') ? 'active' : '' }}">
      <a class="nav-link" href="{{route('user')}}">
        <i class="fas fa-fw fa-th-large"></i>
        <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">Learning & Orders</div>
    
    <!--Orders -->
    <li class="nav-item {{ Request::is('user/order*') ? 'active' : '' }}">
        <a class="nav-link" href="{{route('user.order.index')}}">
            <i class="fas fa-shopping-bag"></i>
            <span>My Orders</span>
        </a>
    </li>

    <!-- Reviews -->
    <li class="nav-item {{ Request::is('user/review*') ? 'active' : '' }}">
        <a class="nav-link" href="{{route('user.productreview.index')}}">
            <i class="fas fa-star"></i>
            <span>Reviews</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">Account Settings</div>
    
    <!-- Profile -->
    <li class="nav-item {{ Request::is('user/setting*') ? 'active' : '' }}">
      <a class="nav-link" href="{{route('user.setting')}}">
          <i class="fas fa-user-cog"></i>
          <span>Profile Settings</span>
      </a>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline mt-4">
      <button class="rounded-circle border-0" id="sidebarToggle" style="background: rgba(0,0,0,0.05); color: #94a3b8;"></button>
    </div>

</ul>