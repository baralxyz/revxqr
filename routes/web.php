<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Website\WebController;
use App\Http\Controllers\Website\MailerController;

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

// Installer Middleware
Route::group(['middleware' => 'Installer'], function () {

    // Website routes
    Route::get('/', [App\Http\Controllers\Website\WebController::class, "webIndex"])->name("web.index");
    Route::get('/about', [App\Http\Controllers\Website\WebController::class, "webAbout"])->name("web.about");
    Route::get('/pricing', [App\Http\Controllers\Website\WebController::class, "webPricing"])->name("web.pricing");
    Route::get('/contact', [App\Http\Controllers\Website\WebController::class, "webContact"])->name("web.contact");
    Route::post("/send-email", [App\Http\Controllers\Website\MailerController::class, "composeEmail"])->name("send-email");
    Route::get('/faq', [App\Http\Controllers\Website\WebController::class, "webFAQ"])->name("web.faq");
    Route::get('/privacy-policy', [App\Http\Controllers\Website\WebController::class, "webPrivacy"])->name("web.privacy");
    Route::get('/refund-policy', [App\Http\Controllers\Website\WebController::class, "webRefund"])->name("web.refund");
    Route::get('/terms-and-conditions', [App\Http\Controllers\Website\WebController::class, "webTerms"])->name("web.terms");

    // Custom pages
    Route::get('/p/{id}', [App\Http\Controllers\Website\WebController::class, "customPage"])->name("web.custom.page");

    // QR Code Generator
    Route::get('/g/{id}', [App\Http\Controllers\Website\QRGeneratorController::class, "qrGenerator"])->name("web.qr.generator");
    Route::post('generate-qr', [App\Http\Controllers\Website\QRGeneratorController::class, "generateQr"])->name("web.generate.qr");
    Route::post('download-count', [App\Http\Controllers\Website\QRGeneratorController::class, "downloadCount"])->name("qr.download.count");

    // Auth routes
    Auth::routes();

    // Admin routes
    Route::group(['as' => 'admin.', 'prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'admin'], 'where' => ['locale' => '[a-zA-Z]{2}']], function () {
        // Dashboard
        Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, "index"])->name('dashboard');

        // Check QR Code
        if (env('APP_TYPE') == 'QRCODE' || env('APP_TYPE') == 'BOTH') {
            // Create QR Code
            Route::get('qrcodes/all', [App\Http\Controllers\Admin\QRCodeController::class, "index"])->name('all.qr');
            Route::get('qrcode/create', [App\Http\Controllers\Admin\QRCodeController::class, "CreateQr"])->name('create.qr');
            Route::post('qrcode/save', [App\Http\Controllers\Admin\QRCodeController::class, "saveQr"])->name('save.qr');
            Route::get('qrcode/edit/{id}', [App\Http\Controllers\Admin\QRCodeController::class, "editQr"])->name('edit.qr');
            Route::post('qrcode/update', [App\Http\Controllers\Admin\QRCodeController::class, "updateQr"])->name('update.qr');
            Route::post('qrcode/regenerate-qr', [App\Http\Controllers\Admin\QRCodeController::class, "regenerateQr"])->name('regenerate.qr');
            Route::get('qrcode/statistics/{id}', [App\Http\Controllers\Admin\StatisticsController::class, "qrStatistics"])->name('qr.statistics');

            // EPC QRcode
            Route::get('qrcodes/all-epc', [App\Http\Controllers\Admin\EPCQRCodeController::class, "index"])->name('all.epc.qr');
            Route::get('qrcode/create-epc', [App\Http\Controllers\Admin\EPCQRCodeController::class, "CreateEPCQr"])->name('create.epc.qr');
            Route::post('qrcode/save-epc', [App\Http\Controllers\Admin\EPCQRCodeController::class, "saveEPCQr"])->name('save.epc.qr');
            Route::get('qrcode/edit-epc/{id}', [App\Http\Controllers\Admin\EPCQRCodeController::class, "editEPCQr"])->name('edit.epc.qr');
            Route::post('qrcode/update-epc', [App\Http\Controllers\Admin\EPCQRCodeController::class, "updateEPCQr"])->name('update.epc.qr');
            Route::post('qrcode/regenerate-epc-qr', [App\Http\Controllers\Admin\EPCQRCodeController::class, "regenerateEPCQr"])->name('regenerate.epc.qr');
            Route::get('qrcode/epc/{id}', [App\Http\Controllers\Admin\QRCodeController::class, "downloadEPCQrCode"])->name("download.epc.qrcode");

            // Get Type Wise QR Codes
            Route::get('/qrcode/qrcodes/{type}', [App\Http\Controllers\Admin\QRCodeController::class, "getTypeQRCode"])->name("type.qrcodes");
            // Update QR Code Status
            Route::get('qrcode/update-qr-status', [App\Http\Controllers\Admin\QRCodeController::class, "updateQrCodeStatus"])->name('update.qr.status');
            // Delete QR Code
            Route::get('qrcode/delete-qr', [App\Http\Controllers\Admin\QRCodeController::class, "deleteQrCode"])->name('delete.qr');
            // Download QR Code
            Route::get('qrcode/{id}', [App\Http\Controllers\Admin\QRCodeController::class, "downloadQrCode"])->name("download.qrcode");
        }

        // Check Barcode
        if (env('APP_TYPE') == 'BARCODE' || env('APP_TYPE') == 'BOTH') {
            // Create Barcode
            Route::get('barcodes/all', [App\Http\Controllers\Admin\BarCodeController::class, "index"])->name('all.barcode');
            Route::get('barcode/create', [App\Http\Controllers\Admin\BarCodeController::class, "CreateBarCode"])->name('create.barcode');
            Route::post('barcode/save', [App\Http\Controllers\Admin\BarCodeController::class, "saveBarCode"])->name('save.barcode');
            Route::get('barcode/edit/{id}', [App\Http\Controllers\Admin\BarCodeController::class, "editBarCode"])->name('edit.barcode');
            Route::post('barcode/update', [App\Http\Controllers\Admin\BarCodeController::class, "updateBarCode"])->name('update.barcode');
            Route::post('barcode/regenerate-barcode', [App\Http\Controllers\Admin\BarCodeController::class, "regenerateBarCode"])->name('regenerate.barcode');
            // Update Barcode Status
            Route::get('barcode/update-barcode-status', [App\Http\Controllers\Admin\BarCodeController::class, "updateBarCodeStatus"])->name('update.barcode.status');
            // Delete Barcode
            Route::get('barcode/delete-barcode', [App\Http\Controllers\Admin\BarCodeController::class, "deleteBarCode"])->name('delete.barcode');
            // Download Barcode
            Route::get('barcode/barcode/{id}', [App\Http\Controllers\Admin\BarCodeController::class, "downloadBarCode"])->name("download.barcode");

            // Groups
            Route::get('barcodes/groups/all', [App\Http\Controllers\Admin\GroupController::class, "index"])->name('all.groups');
            Route::get('barcode/group/create', [App\Http\Controllers\Admin\GroupController::class, "createGroup"])->name('create.group');
            Route::post('barcode/group/save', [App\Http\Controllers\Admin\GroupController::class, "saveGroup"])->name('save.group');
            Route::get('barcode/group/view/{id}', [App\Http\Controllers\Admin\GroupController::class, "viewGroup"])->name('view.group');
            Route::get('barcode/group/edit/{id}', [App\Http\Controllers\Admin\GroupController::class, "editGroup"])->name('edit.group');
            Route::post('barcode/group/update', [App\Http\Controllers\Admin\GroupController::class, "updateGroup"])->name('update.group');
            Route::get('barcode/group/update-group-status', [App\Http\Controllers\Admin\GroupController::class, "updateGroupStatus"])->name('update.group.status');
            Route::get('barcode/group/delete', [App\Http\Controllers\Admin\GroupController::class, "deleteGroup"])->name('delete.group');
            Route::get('barcode/group/download/{id}', [App\Http\Controllers\Admin\GroupController::class, "downloadGroup"])->name("download.group");

            // Bulk upload
            Route::get('barcodes/bulk', [App\Http\Controllers\Admin\BulkUploadController::class, "index"])->name('bulk.upload');
            Route::post('barcode/bulk-upload', [App\Http\Controllers\Admin\BulkUploadController::class, "importBulkUpload"])->name('import.bulk.upload');
        }

        // Users
        Route::get('users', [App\Http\Controllers\Admin\UserController::class, "index"])->name('users');
        Route::get('edit-user/{id}', [App\Http\Controllers\Admin\UserController::class, "editUser"])->name('edit.user');
        Route::post('update-user', [App\Http\Controllers\Admin\UserController::class, "updateUser"])->name('update.user');
        Route::get('view-user/{id}', [App\Http\Controllers\Admin\UserController::class, "viewUser"])->name('view.user');
        Route::get('change-user-plan/{id}', [App\Http\Controllers\Admin\UserController::class, "ChangeUserPlan"])->name('change.user.plan');
        Route::post('update-user-plan', [App\Http\Controllers\Admin\UserController::class, "UpdateUserPlan"])->name('update.user.plan');
        Route::get('update-status', [App\Http\Controllers\Admin\UserController::class, "updateStatus"])->name('update.status');
        Route::get('delete-user', [App\Http\Controllers\Admin\UserController::class, "deleteUser"])->name('delete.user');
        Route::get('login-as/{id}', [App\Http\Controllers\Admin\UserController::class, "authAs"])->name('login-as.user');

        // Plans
        Route::get('plans', [App\Http\Controllers\Admin\PlanController::class, "index"])->name('index.plans');
        Route::get('add-plan', [App\Http\Controllers\Admin\PlanController::class, "addPlan"])->name('add.plan');
        Route::post('save-plan', [App\Http\Controllers\Admin\PlanController::class, "savePlan"])->name('save.plan');
        Route::get('edit-plan/{id}', [App\Http\Controllers\Admin\PlanController::class, "editPlan"])->name('edit.plan');
        Route::post('update-plan', [App\Http\Controllers\Admin\PlanController::class, "updatePlan"])->name('update.plan');
        Route::get('delete-plan', [App\Http\Controllers\Admin\PlanController::class, "deletePlan"])->name('delete.plan');

        // Payment Gateways
        Route::get('payment-methods', [App\Http\Controllers\Admin\PaymentMethodController::class, "index"])->name('payment.methods');
        Route::get('add-payment-method', [App\Http\Controllers\Admin\PaymentMethodController::class, "addPaymentMethod"])->name('add.payment.method');
        Route::post('save-payment-method', [App\Http\Controllers\Admin\PaymentMethodController::class, "savePaymentMethod"])->name('save.payment.method');
        Route::get('edit-payment-method/{id}', [App\Http\Controllers\Admin\PaymentMethodController::class, "editPaymentMethod"])->name('edit.payment.method');
        Route::post('update-payment-method', [App\Http\Controllers\Admin\PaymentMethodController::class, "updatePaymentMethod"])->name('update.payment.method');
        Route::get('delete-payment-method', [App\Http\Controllers\Admin\PaymentMethodController::class, "deletePaymentMethod"])->name('delete.payment.method');

        // Transactions
        Route::get('transactions', [App\Http\Controllers\Admin\TransactionController::class, "index"])->name('transactions');
        Route::get('transaction-status/{id}/{status}', [App\Http\Controllers\Admin\TransactionController::class, "transactionStatus"])->name('trans.status');
        Route::get('offline-transactions', [App\Http\Controllers\Admin\TransactionController::class, "offlineTransactions"])->name('offline.transactions');
        Route::get('offline-transaction-status/{id}/{status}', [App\Http\Controllers\Admin\TransactionController::class, "offlineTransactionStatus"])->name('offline.trans.status');
        Route::get('view-invoice/{id}', [App\Http\Controllers\Admin\TransactionController::class, "viewInvoice"])->name('view.invoice');

        // Account Setting
        Route::get('account', [App\Http\Controllers\Admin\AccountController::class, "index"])->name('index.account');
        Route::get('edit-account', [App\Http\Controllers\Admin\AccountController::class, "editAccount"])->name('edit.account');
        Route::post('update-account', [App\Http\Controllers\Admin\AccountController::class, "updateAccount"])->name('update.account');
        Route::get('change-password', [App\Http\Controllers\Admin\AccountController::class, "changePassword"])->name('change.password');
        Route::post('update-password', [App\Http\Controllers\Admin\AccountController::class, "UpdatePassword"])->name('update.password');

        // Change theme
        Route::get('theme/{id}', [App\Http\Controllers\Admin\AccountController::class, "changeTheme"])->name('change.theme');

        // Pages
        Route::get('pages', [App\Http\Controllers\Admin\PageController::class, "index"])->name('pages');
        Route::get('add-page', [App\Http\Controllers\Admin\PageController::class, "addPage"])->name('add.page');
        Route::post('save-page', [App\Http\Controllers\Admin\PageController::class, "savePage"])->name('save.page');
        Route::get('custom-page/{id}', [App\Http\Controllers\Admin\PageController::class, "editCustomPage"])->name('edit.custom.page');
        Route::post('custom-update-page', [App\Http\Controllers\Admin\PageController::class, "updateCustomPage"])->name('update.custom.page');
        Route::get('status-page', [App\Http\Controllers\Admin\PageController::class, "statusPage"])->name('status.page');
        Route::get('page/{id}', [App\Http\Controllers\Admin\PageController::class, "editPage"])->name('edit.page');
        Route::post('update-page/{id}', [App\Http\Controllers\Admin\PageController::class, "updatePage"])->name('update.page');
        Route::get('disable-page', [App\Http\Controllers\Admin\PageController::class, "disablePage"])->name('disable.page');
        Route::get('delete-page', [App\Http\Controllers\Admin\PageController::class, "deletePage"])->name('delete.page');

        Route::post('upload-image', [App\Http\Controllers\Admin\PageController::class, "uploadImage"])->name('upload.image');

        // Setting
        Route::get('settings', [App\Http\Controllers\Admin\SettingController::class, "index"])->name('settings');
        Route::post('change-general-settings', [App\Http\Controllers\Admin\SettingController::class, "changeGeneralSettings"])->name('change.general.settings');
        Route::post('change-website-settings', [App\Http\Controllers\Admin\SettingController::class, "changeWebsiteSettings"])->name('change.website.settings');
        Route::post('change-website-qr-generator-settings', [App\Http\Controllers\Admin\SettingController::class, "changeWebsiteQrGeneratorSettings"])->name('change.website.qr.generator.settings');
        Route::post('change-payments-settings', [App\Http\Controllers\Admin\SettingController::class, "changePaymentsSettings"])->name('change.payments.settings');
        Route::post('change-google-settings', [App\Http\Controllers\Admin\SettingController::class, "changeGoogleSettings"])->name('change.google.settings');
        Route::post('change-email-settings', [App\Http\Controllers\Admin\SettingController::class, "changeEmailSettings"])->name('change.email.settings');

        Route::get('tax-setting', [App\Http\Controllers\Admin\SettingController::class, "taxSetting"])->name('tax.setting');
        Route::post('update-tex-setting', [App\Http\Controllers\Admin\SettingController::class, "updateTaxSetting"])->name('update.tax.setting');
        Route::post('update-email-setting', [App\Http\Controllers\Admin\SettingController::class, "updateEmailSetting"])->name('update.email.setting');
        Route::get('test-email', [App\Http\Controllers\Admin\SettingController::class, "testEmail"])->name('test.email');

        // License
        Route::get('license', [App\Http\Controllers\Admin\LicenseController::class, "license"])->name('license');
        Route::post('verify-license', [App\Http\Controllers\Admin\LicenseController::class, "verifyLicense"])->name('verify.license');

        // Log Authentication
        Route::get('logs', [App\Http\Controllers\Admin\AuthenticationLogController::class, "index"])->name('logs');
        Route::get('clear-logs', [App\Http\Controllers\Admin\AuthenticationLogController::class, "clearLogs"])->name('clear.logs');

        // Clear cache
        Route::get('clear', [App\Http\Controllers\Admin\SettingController::class, "clear"])->name('clear');
        // Check update
        Route::get('check', [App\Http\Controllers\Admin\UpdateController::class, 'check'])->name('check');
        Route::post('check-update', [App\Http\Controllers\Admin\UpdateController::class, 'checkUpdate'])->name('check.update');
        Route::post('update-code', [App\Http\Controllers\Admin\UpdateController::class, 'updateCode'])->name('update.code');
    });

    // User routes
    Route::group(['as' => 'user.', 'prefix' => 'user', 'namespace' => 'User', 'middleware' => ['auth', 'user'], 'where' => ['locale' => '[a-zA-Z]{2}']], function () {
        // Dashboard
        Route::get('dashboard', [App\Http\Controllers\User\DashboardController::class, "index"])->name('dashboard');

        // Plans
        Route::get('plans', [App\Http\Controllers\User\PlanController::class, "index"])->name('plans');

        // Check QR Code
        if (env('APP_TYPE') == 'QRCODE' || env('APP_TYPE') == 'BOTH') {
            // Create QR Code
            Route::get('qrcodes/all', [App\Http\Controllers\User\QRCodeController::class, "index"])->name('all.qr');
            Route::get('qrcode/create', [App\Http\Controllers\User\QRCodeController::class, "CreateQr"])->name('create.qr');
            Route::post('qrcode/save', [App\Http\Controllers\User\QRCodeController::class, "saveQr"])->name('save.qr');
            Route::get('qrcode/edit/{id}', [App\Http\Controllers\User\QRCodeController::class, "editQr"])->name('edit.qr');
            Route::post('qrcode/update', [App\Http\Controllers\User\QRCodeController::class, "updateQr"])->name('update.qr');
            Route::post('qrcode/regenerate-qr', [App\Http\Controllers\User\QRCodeController::class, "regenerateQr"])->name('regenerate.qr');
            Route::get('qrcode/statistics/{id}', [App\Http\Controllers\User\StatisticsController::class, "qrStatistics"])->name('qr.statistics');

            // EPC QRcode
            Route::get('qrcodes/all-epc', [App\Http\Controllers\User\EPCQRCodeController::class, "index"])->name('all.epc.qr');
            Route::get('qrcode/create-epc', [App\Http\Controllers\User\EPCQRCodeController::class, "CreateEPCQr"])->name('create.epc.qr');
            Route::post('qrcode/save-epc', [App\Http\Controllers\User\EPCQRCodeController::class, "saveEPCQr"])->name('save.epc.qr');
            Route::get('qrcode/edit-epc/{id}', [App\Http\Controllers\User\EPCQRCodeController::class, "editEPCQr"])->name('edit.epc.qr');
            Route::post('qrcode/update-epc', [App\Http\Controllers\User\EPCQRCodeController::class, "updateEPCQr"])->name('update.epc.qr');
            Route::post('qrcode/regenerate-epc-qr', [App\Http\Controllers\User\EPCQRCodeController::class, "regenerateEPCQr"])->name('regenerate.epc.qr');
            Route::get('qrcode/epc/{id}', [App\Http\Controllers\User\QRCodeController::class, "downloadEPCQrCode"])->name("download.epc.qrcode");
        }

        // Check Bar Code
        if (env('APP_TYPE') == 'BARCODE' || env('APP_TYPE') == 'BOTH') {
            // Create Bar Code
            Route::get('barcodes/all', [App\Http\Controllers\User\BarCodeController::class, "index"])->name('all.barcode');
            Route::get('barcode/create', [App\Http\Controllers\User\BarCodeController::class, "CreateBarCode"])->name('create.barcode');
            Route::post('barcode/save', [App\Http\Controllers\User\BarCodeController::class, "saveBarCode"])->name('save.barcode');
            Route::get('barcode/edit/{id}', [App\Http\Controllers\User\BarCodeController::class, "editBarCode"])->name('edit.barcode');
            Route::post('barcode/update', [App\Http\Controllers\User\BarCodeController::class, "updateBarCode"])->name('update.barcode');
            Route::post('barcode/regenerate-barcode', [App\Http\Controllers\User\BarCodeController::class, "regenerateBarCode"])->name('regenerate.barcode');
            // Update QR Code Status
            Route::get('barcode/update-barcode-status', [App\Http\Controllers\User\BarCodeController::class, "updateBarCodeStatus"])->name('update.barcode.status');
            // Delete QR Code
            Route::get('barcode/delete-barcode', [App\Http\Controllers\User\BarCodeController::class, "deleteBarCode"])->name('delete.barcode');
            // Download Bar Code
            Route::get('barcode/barcode/{id}', [App\Http\Controllers\User\BarCodeController::class, "downloadBarCode"])->name("download.barcode");

            // Groups
            Route::get('barcodes/groups/all', [App\Http\Controllers\User\GroupController::class, "index"])->name('all.groups');
            Route::get('barcode/group/create', [App\Http\Controllers\User\GroupController::class, "createGroup"])->name('create.group');
            Route::post('barcode/group/save', [App\Http\Controllers\User\GroupController::class, "saveGroup"])->name('save.group');
            Route::get('barcode/group/view/{id}', [App\Http\Controllers\User\GroupController::class, "viewGroup"])->name('view.group');
            Route::get('barcode/group/edit/{id}', [App\Http\Controllers\User\GroupController::class, "editGroup"])->name('edit.group');
            Route::post('barcode/group/update', [App\Http\Controllers\User\GroupController::class, "updateGroup"])->name('update.group');
            Route::get('barcode/group/update-group-status', [App\Http\Controllers\User\GroupController::class, "updateGroupStatus"])->name('update.group.status');
            Route::get('barcode/group/delete', [App\Http\Controllers\User\GroupController::class, "deleteGroup"])->name('delete.group');
            Route::get('barcode/group/download/{id}', [App\Http\Controllers\User\GroupController::class, "downloadGroup"])->name("download.group");

            // Bulk upload
            Route::get('barcodes/bulk', [App\Http\Controllers\User\BulkUploadController::class, "index"])->name('bulk.upload');
            Route::post('barcode/bulk-upload', [App\Http\Controllers\User\BulkUploadController::class, "importBulkUpload"])->name('import.bulk.upload');
        }

        // Get Type Wise QR Codes
        Route::get('/qrcode/qrcodes/{type}', [App\Http\Controllers\User\QRCodeController::class, "getTypeQRCode"])->name("type.qrcodes");
        // Update QR Code Status
        Route::get('qrcode/update-qr-status', [App\Http\Controllers\User\QRCodeController::class, "updateQrCodeStatus"])->name('update.qr.status');
        // Delete QR Code
        Route::get('qrcode/delete-qr', [App\Http\Controllers\User\QRCodeController::class, "deleteQrCode"])->name('delete.qr');

        // Download QR Code
        Route::get('qrcode/{id}', [App\Http\Controllers\User\QRCodeController::class, "downloadQrCode"])->name("download.qrcode");

        // Media
        Route::get('media', [App\Http\Controllers\User\MediaController::class, "media"])->name('media');
        Route::get('add-media', [App\Http\Controllers\User\MediaController::class, "addMedia"])->name('add.media');
        Route::post('upload-media', [App\Http\Controllers\User\MediaController::class, "uploadMedia"])->name('upload.media');
        Route::get('delete-media/{id}', [App\Http\Controllers\User\MediaController::class, "deleteMedia"])->name('media.delete');

        //Addtional Tootls -> QR Maker
        Route::get('tools/whois-lookup', [App\Http\Controllers\User\AdditionalController::class, "whoisLookup"])->name('whois-lookup');
        Route::post('tools/whois-lookup', [App\Http\Controllers\User\AdditionalController::class, "resultWhoisLookup"])->name('result.whois-lookup');
        Route::get('tools/dns-lookup', [App\Http\Controllers\User\AdditionalController::class, "dnsLookup"])->name('dns-lookup');
        Route::post('tools/dns-lookup', [App\Http\Controllers\User\AdditionalController::class, "resultDnsLookup"])->name('result.dns-lookup');
        Route::get('tools/ip-lookup', [App\Http\Controllers\User\AdditionalController::class, "ipLookup"])->name('ip-lookup');
        Route::post('tools/ip-lookup', [App\Http\Controllers\User\AdditionalController::class, "resultIpLookup"])->name('result.ip-lookup');

        // Transactions
        Route::get('transactions', [App\Http\Controllers\User\TransactionsController::class, "indexTransactions"])->name('transactions');
        Route::get('view-invoice/{id}', [App\Http\Controllers\User\TransactionsController::class, "viewInvoice"])->name('view.invoice');

        // Billing
        Route::get('billing/{id}', [App\Http\Controllers\User\BillingController::class, "billing"])->name('billing');
        Route::post('update-billing', [App\Http\Controllers\User\BillingController::class, "updateBilling"])->name('update.billing');

        // Checkout
        Route::get('checkout/{id}', [App\Http\Controllers\User\CheckOutController::class, "checkout"])->name('checkout');

        // Account Setting
        Route::get('account', [App\Http\Controllers\User\AccountController::class, "index"])->name('index.account');
        Route::get('edit-account', [App\Http\Controllers\User\AccountController::class, "editAccount"])->name('edit.account');
        Route::post('update-account', [App\Http\Controllers\User\AccountController::class, "updateAccount"])->name('update.account');
        Route::get('change-password', [App\Http\Controllers\User\AccountController::class, "changePassword"])->name('change.password');
        Route::post('update-password', [App\Http\Controllers\User\AccountController::class, "updatePassword"])->name('update.password');

        // Change theme
        Route::get('theme/{id}', [App\Http\Controllers\User\AccountController::class, "changeTheme"])->name('change.theme');

        // Resend Email Verfication
        Route::get('verify-email-verification', [App\Http\Controllers\User\VerificationController::class, "verifyEmailVerification"])->name('verify.email.verification');
        Route::get('resend-email-verification', [App\Http\Controllers\User\VerificationController::class, "resendEmailVerification"])->name('resend.email.verification');
    });

    // Google auth routes
    Route::get('/google-login', [App\Http\Controllers\Auth\LoginController::class, "redirectToProvider"])->name('login.google');
    Route::get('/sign-in-with-google', [App\Http\Controllers\Auth\LoginController::class, "handleProviderCallback"]);


    Route::group(['middleware' => 'checkType'], function () {


        // Choose Payment Gateway
        Route::post('/prepare-payment/{planId}', [App\Http\Controllers\Payment\PaymentController::class, "preparePaymentGateway"])->name('prepare.payment.gateway');

        // PayPal Payment Gateway
        Route::get('/payment-paypal/{planId}', [App\Http\Controllers\Payment\PaypalController::class, "paywithpaypal"])->name('paywithpaypal');
        Route::get('/payment/status', [App\Http\Controllers\Payment\PaypalController::class, "paypalPaymentStatus"])->name('paypalPaymentStatus');

        // Phonepe
        Route::get('/payment-phonepe/{planId}', [App\Http\Controllers\Payment\PhonepeController::class, 'preparePhonpe'])->name('paywithphonepe');
        Route::any('/phonepe-payment-status', [App\Http\Controllers\Payment\PhonepeController::class, 'phonepePaymentStatus'])->name('phonepe.payment.status');

        // RazorPay
        Route::get('/payment-razorpay/{planId}', [App\Http\Controllers\Payment\RazorPayController::class, "prepareRazorpay"])->name('paywithrazorpay');
        Route::get('/razorpay-payment-status/{oid}/{paymentId}', [App\Http\Controllers\Payment\RazorPayController::class, "razorpayPaymentStatus"])->name('razorpay.payment.status');

        // Stripe
        Route::get('/payment-stripe/{planId}', [App\Http\Controllers\Payment\StripeController::class, "stripeCheckout"])->name('paywithstripe');
        Route::post('/stripe-payment-status/{paymentId}', [App\Http\Controllers\Payment\StripeController::class, "stripePaymentStatus"])->name('stripe.payment.status');
        Route::get('/stripe-payment-cancel/{paymentId}', [App\Http\Controllers\Payment\StripeController::class, "stripePaymentCancel"])->name('stripe.payment.cancel');

        // Paystack
        Route::get('/payment-paystack/{planId}', [App\Http\Controllers\Payment\PaystackController::class, "paystackCheckout"])->name('paywithpaystack');
        Route::get('/paystack-payment/callback', [App\Http\Controllers\Payment\PaystackController::class, 'paystackHandleGatewayCallback'])->name('paystack.handle.gateway.callback');

        // Mollie
        Route::get('/payment-mollie/{planId}', [App\Http\Controllers\Payment\MollieController::class, "prepareMollie"])->name('paywithmollie');
        Route::get('/mollie-payment-status', [App\Http\Controllers\Payment\MollieController::class, "molliePaymentStatus"])->name('mollie.payment.status');

        // Offline
        Route::get('/payment-offline/{planId}', [App\Http\Controllers\Payment\OfflineController::class, "offlineCheckout"])->name('paywithoffline');
        Route::post('/mark-offline-payment', [App\Http\Controllers\Payment\OfflineController::class, "markOfflinePayment"])->name('mark.payment.payment');
    });

    // Dynamic links
    Route::get('qr/{id}', [App\Http\Controllers\User\StatisticsController::class, "dynamicLink"])->name('dynamic.link');
});
