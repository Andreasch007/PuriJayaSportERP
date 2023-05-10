<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i>
        {{ trans('backpack::base.dashboard') }}</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('location') }}'><i class='nav-icon la la-map-marker'></i>
        Locations</a></li>
@if (backpack_user()->hasRole('Super Admin'))
    <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-users"></i> Authentication</a>
        <ul class="nav-dropdown-items">
            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i
                        class="nav-icon la la-user"></i> <span>Users</span></a></li>
            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('role') }}"><i
                        class="nav-icon la la-id-badge"></i> <span>Roles</span></a></li>
            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('permission') }}"><i
                        class="nav-icon la la-key"></i> <span>Permissions</span></a></li>
        </ul>
    </li>
@endif
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('category') }}'><i class='nav-icon la la-question'></i>
        Kategori</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('sub-category') }}'><i
            class='nav-icon la la-question'></i> Sub Kategori</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('product') }}'><i class='nav-icon la la-question'></i>
        Produk</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('purchase-invoice') }}'><i
            class='nav-icon la la-question'></i> Faktur Pembelian</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('outgoing-invoice-header') }}'><i
            class='nav-icon la la-question'></i> Faktur Keluar</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('supplier') }}'><i class='nav-icon la la-question'></i>
        Supplier</a></li>
{{-- <li class='nav-item'><a class='nav-link' href='{{ backpack_url('outgoing-invoice-detail') }}'><i class='nav-icon la la-question'></i> Outgoing invoice details</a></li> --}}

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('customers') }}'><i class='nav-icon la la-question'></i> Pembeli</a></li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('stock-adjustment') }}'><i class='nav-icon la la-question'></i> Penyesuaian Stok</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('document-flow') }}'><i class='nav-icon la la-question'></i> Document flows</a></li>