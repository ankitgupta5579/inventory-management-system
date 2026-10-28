<div class="sidebar">
    <div class="brand"><i class="bi bi-box-seam"></i> InventoryPro</div>

    <ul class="nav flex-column">
        <li class="section-title">Main</li>
        <li><a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
            <i class="bi bi-speedometer2"></i> Dashboard</a></li>

        <li class="section-title">Data Management</li>
        <li><a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">
            <i class="bi bi-box"></i> Products</a></li>
        <li><a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">
            <i class="bi bi-tags"></i> Categories</a></li>
        <li><a class="nav-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }}" href="{{ route('suppliers.index') }}">
            <i class="bi bi-truck"></i> Suppliers</a></li>

        <li class="section-title">Transactions</li>
        <li><a class="nav-link {{ request()->routeIs('purchases.*') ? 'active' : '' }}" href="{{ route('purchases.index') }}">
            <i class="bi bi-cart-plus"></i> Purchases</a></li>
        <li><a class="nav-link {{ request()->routeIs('sales.*') ? 'active' : '' }}" href="{{ route('sales.index') }}">
            <i class="bi bi-receipt"></i> Sales & Billing</a></li>

        <li class="section-title">Analysis</li>
        <li><a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}">
            <i class="bi bi-graph-up"></i> Reports</a></li>

        {{-- Only admins see this part --}}
        @if(auth()->user()->role === 'admin')
            <li class="section-title">Admin Panel</li>
            <li><a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                <i class="bi bi-people"></i> Manage Users</a></li>
        @endif
    </ul>
</div>