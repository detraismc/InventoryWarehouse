<div class="sidebar">
    <h4 class="mb-4">Detrais-Inventory</h4>

    <h6>Menu</h6>
    <a href="{{ route('inventory.dashboard') }}"
        class="{{ request()->routeIs('inventory.dashboard') ? 'active' : '' }}">Dashboard</a>

    <a href="{{ route('inventory.supply') }}"
        class="{{ request()->routeIs('inventory.supply') || request()->routeIs('inventory.supply.show') ? 'active' : '' }}">
        Supply
    </a>

    <a href="{{ route('inventory.transaction') }}"
        class="{{ request()->routeIs('inventory.transaction') ? 'active' : '' }}">
        Transaction

        @if (!empty($pendingTransactionsCount) && $pendingTransactionsCount > 0)
            <span class="badge bg-danger ms-2">{{ $pendingTransactionsCount }}</span>
        @endif
    </a>



    @if (in_array(Auth::user()->role, ['admin', 'manager']))
        <a href="{{ route('inventory.log.transaction') }}"
            class="{{ request()->routeIs('inventory.log.transaction', 'inventory.log.account', 'inventory.log.setup') ? 'active' : '' }}">
            Log
        </a>
    @endif


    @if (in_array(Auth::user()->role, ['admin', 'manager']))
        <h6>Setup</h6>
        <a href="{{ route('inventory.warehouse') }}"
            class="{{ request()->routeIs('inventory.warehouse') ? 'active' : '' }}">Warehouse</a>

        <a href="{{ route('inventory.category') }}"
            class="{{ request()->routeIs('inventory.category') ? 'active' : '' }}">Category</a>

        <a href="{{ route('inventory.item') }}"
            class="{{ request()->routeIs('inventory.item') ? 'active' : '' }}">Item</a>
    @endif


    @if (Auth::user()->role === 'admin')
        <a href="{{ route('inventory.user') }}"
            class="{{ request()->routeIs('inventory.user') ? 'active' : '' }}">User</a>
    @endif

    <h6>Others</h6>
    <a href="{{ route('inventory.account') }}"
        class="{{ request()->routeIs('inventory.account') ? 'active' : '' }}">Account</a>


</div>
