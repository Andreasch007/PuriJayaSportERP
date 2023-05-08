<?php

use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('location', 'LocationCrudController');
    Route::crud('category', 'CategoryCrudController');
    Route::crud('sub-category', 'SubCategoryCrudController');
    Route::crud('purchase-invoice', 'PurchaseInvoiceCrudController');
    Route::crud('supplier', 'SupplierCrudController');
    // Route::get('purchase-invoice/list', [PurchaseInvoiceCrudController::class, 'purchase_detail'])->name('purchase.detail');
    // Route::get('purchase-invoice/list', 'PurchaseInvoiceCrudController@purchase_detail')->name('purchase.detail');
    Route::get('purchase-invoice/list/{id}', 'PurchaseInvoiceCrudController@purchase_detail');
    Route::crud('customers', 'CustomersCrudController');
}); // this should be the absolute last line of this file