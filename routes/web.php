<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['auth']], function() {
    Route::get('/', 'HomeController@index');
    Route::get('/visitors', 'HomeController@visitors');
    Route::get('/getVisitors', 'HomeController@getVisitors');
    Route::get('/delete-Visitor/{id}', 'HomeController@deleteVisitor');

    // User Routes
    Route::get('/users', 'UserController@users');
    Route::get('/getUserData', 'UserController@getUserData');
    Route::post('/addUser', 'UserController@addUser');
    Route::get('/delete-User/{id}', 'UserController@deleteUser');
    Route::get('/getUserEditDetails/{id}', 'UserController@getUserEditDetails');
    Route::post('/updateUserDetails', 'UserController@updateUserDetails');

// User Profile Routes
    Route::get('/profile', 'ProfileController@userProfile');
    Route::get('/getProfileData', 'ProfileController@getProfileData');
    Route::get('/getProfileEditDetails', 'ProfileController@getProfileEditDetails');
    Route::post('/updateProfileInfo', 'ProfileController@updateProfileInfo');

// Password Update Routes
    Route::get('/update-password', 'ProfileController@updatePassword');
    Route::post('/checkCurrentPass', 'ProfileController@checkCurrentPass');
    Route::post('/updatePass', 'ProfileController@updatePass');

// Supplier Routes
    Route::get('/suppliers', 'SupplierController@index');
    Route::get('/getSuppliers', 'SupplierController@getSuppliers');
    Route::post('/addSupplier', 'SupplierController@addSupplier');
    Route::get('/getSupplierDetails/{id}', 'SupplierController@getSupplierDetails');
    Route::post('/updateSupplierDetails', 'SupplierController@updateSupplierDetails');
    Route::get('/delete-Supplier/{id}', 'SupplierController@deleteSupplier');

// Customer Routes
    Route::get('/customers', 'CustomerController@index');
    Route::get('/getCustomers', 'CustomerController@getCustomers');
    Route::post('/addCustomer', 'CustomerController@addCustomer');
    Route::get('/getCustomerDetails/{id}', 'CustomerController@getCustomerDetails');
    Route::post('/updateCustomerDetails', 'CustomerController@updateCustomerDetails');
    Route::get('/delete-Customer/{id}', 'CustomerController@deleteCustomer');
    Route::get('/credit-customers', 'CustomerController@creditCustomers');
    Route::get('/getCreditCustomers', 'CustomerController@getCreditCustomers');
    Route::get('/print/credit-customers', 'CustomerController@creditCustomersPdf');
    Route::post('/getEditInvoiceDetails', 'CustomerController@getEditInvoiceDetails');
    Route::post('/updateCustomerInvoice', 'CustomerController@updateCustomerInvoice');
    Route::post('/getInvoiceDetails', 'CustomerController@getInvoiceDetails');
    Route::get('/print/customer-payment-summary/{id}/{invoice}', 'CustomerController@paymentSummaryPdf');
    Route::get('/paid-customers', 'CustomerController@paidCustomers');
    Route::get('/getPaidCustomers', 'CustomerController@getPaidCustomers');
    Route::post('/getPaidCustomersDetails', 'CustomerController@getPaidCustomersDetails');
    Route::get('/print/paid-customer-invoice/{id}/{invoiceNo}', 'CustomerController@paidCustomerInvoiceReport');

// Unit Routes
    Route::get('/units', 'UnitController@index');
    Route::get('/getUnits', 'UnitController@getUnits');
    Route::post('/addUnit', 'UnitController@addUnit');
    Route::get('/getUnitDetails/{id}', 'UnitController@getUnitDetails');
    Route::post('/updateUnitDetails', 'UnitController@updateUnitDetails');
    Route::get('/delete-Unit/{id}/', 'UnitController@deleteUnit');

// Category Routes
    Route::get('/categories', 'CategoryController@index');
    Route::get('/getCategories', 'CategoryController@getcategories');
    Route::post('/addCategory', 'CategoryController@addCategory');
    Route::get('/getCategoryDetails/{id}', 'CategoryController@getCategoryDetails');
    Route::post('/updateCategoryDetails', 'CategoryController@updateCategoryDetails');
    Route::get('/delete-Category/{id}', 'CategoryController@deleteCategory');

// Product Routes
    Route::get('/products', 'ProductController@index');
    Route::get('/getProducts', 'ProductController@getproducts');
    Route::post('/addProduct', 'ProductController@addProduct');
    Route::get('/getProductDetails/{id}', 'ProductController@getProductDetails');
    Route::post('/updateProductDetails', 'ProductController@updateProductDetails');
    Route::get('/delete-Product/{id}', 'ProductController@deleteProduct');

// Purchase Routes
    Route::get('/purchase', 'PurchaseController@index');
    Route::get('/getPurchases', 'PurchaseController@getPurchases');
    Route::get('/getPurchaseInfo', 'PurchaseController@getPurchaseInfo');
    Route::post('/addPurchase', 'PurchaseController@addPurchase');
    Route::get('/getPurchaseDetails/{id}', 'PurchaseController@getPurchaseDetails');
    Route::post('/updatePurchaseDetails', 'PurchaseController@updatePurchaseDetails');
    Route::get('/delete-Purchase/{id}', 'PurchaseController@deletePurchase');
    Route::get('/pending-purchase', 'PurchaseController@pendingPurchase');
    Route::get('/pendingPurchaseList', 'PurchaseController@pendingPurchaseList');
    Route::post('/update-Purchase-status', 'PurchaseController@updatePurchaseStatus');
    Route::get('/daily-purchase', 'PurchaseController@dailyPurchase');
    Route::get('/print/dailyPurchase', 'PurchaseController@dailyPurchasePdf');

// Default Routes
    Route::get('/getProductInfo', 'DefaultController@getProductInfo');
    Route::post('/getCategories', 'DefaultController@getCategories');
    Route::post('/getProducts', 'DefaultController@getProducts');
    Route::post('/getProductStock', 'DefaultController@getProductStock');
    Route::get('/getInvoiceNoAndCurrentDate', 'DefaultController@getInvoiceNoAndCurrentDate');

// Invoice Routes
    Route::get('/invoice', 'InvoiceController@index');
    Route::get('/getInvoices', 'InvoiceController@getInvoices');
    Route::post('/addInvoice', 'InvoiceController@addInvoice');
    Route::get('/pending-invoice', 'InvoiceController@pendingInvoice');
    Route::get('/pendingInvoiceList', 'InvoiceController@pendingInvoiceList');
    Route::get('/delete-Invoice/{id}', 'InvoiceController@deleteInvoice');
    Route::get('/getApproveInvoiceDetails/{id}', 'InvoiceController@getApproveInvoiceDetails');
    Route::post('/approveInvoice', 'InvoiceController@approveInvoice');
    Route::get('/print-invoice', 'InvoiceController@printInvoicePage');
    Route::get('/getPrintInvoices', 'InvoiceController@getPrintInvoices');
    Route::get('/printInvoiceList', 'InvoiceController@printInvoiceList');
    Route::get('invoicePdf', 'InvoiceController@invoicePdf');
    Route::get('/print/invoice/{invoiceNo}', 'InvoiceController@printInvoice');
    Route::get('/daily-invoice', 'InvoiceController@dailyInvoice');
    Route::get('/print/dailyInvoice', 'InvoiceController@dailyInvoicePdf');

// Stock Routes
    Route::get('/stock-report','StockController@stockReport');
    Route::get('/print/stock','StockController@printStock');
    Route::get('/stock-report-product-supplier-wise','StockController@supplierOrProductWise');
    Route::get('/print/supplier-wise-stock','StockController@supplierWisePdf');
    Route::get('/print/product-wise-stock','StockController@productWisePdf');
});

Auth::routes();
