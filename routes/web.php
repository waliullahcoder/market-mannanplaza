<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

// api start
Route::get('/auto-increment', 'RentIncrementController@autoIncrement')->name('autoIncrement');
// api end

Route::get('/', 'HomeController@index')->name('admin.index');

Route::prefix('admin')->group(function () {
    Route::middleware('auth:admin')->group(function () {
        Route::group(['middleware' => 'menuPermission'], function () {
            //Dashboard Link url
            Route::get('/', 'HomeController@index')->name('admin.index');

            // Menu
            Route::get('/menu', 'Admin\MenuController@index')->name('menu.index');
            Route::get('/menu-add', 'Admin\MenuController@add')->name('menu.add');
            Route::post('/menu-save', 'Admin\MenuController@save')->name('menu.save');
            Route::get('/menu-edit/{id}', 'Admin\MenuController@edit')->name('menu.edit');
            Route::post('/menu-update', 'Admin\MenuController@update')->name('menu.update');
            Route::post('/menu-status', 'Admin\MenuController@status')->name('menu.status');
            Route::post('/menu-delete', 'Admin\MenuController@delete')->name('menu.delete');
            Route::post('/menu-max-order-by', 'Admin\MenuController@maxOrderBY')->name('menu.maxOrderBy');

            // Menu Action
            Route::get('/menu-action/{id}', 'Admin\MenuActionController@index')->name('menuAction.index');
            Route::get('/menu-action-add/{menuId}', 'Admin\MenuActionController@add')->name('menuAction.add');
            Route::post('/menu-action-save', 'Admin\MenuActionController@save')->name('menuAction.save');
            Route::get('/menu-action-edit/{menuActionId}', 'Admin\MenuActionController@edit')->name('menuAction.edit');
            Route::post('/menu-action-update', 'Admin\MenuActionController@update')->name('menuAction.update');
            Route::post('/menu-action-status', 'Admin\MenuActionController@status')->name('menuAction.status');
            Route::post('/menu-action/delete', 'Admin\MenuActionController@delete')->name('menuAction.delete');

            // Menu Action Type
            Route::get('/menu-action-type', 'Admin\MenuActionTypeController@index')->name('menuActionType.index');
            Route::get('/menu-action-type-add', 'Admin\MenuActionTypeController@add')->name('menuActionType.add');
            Route::post('/menu-action-type-save', 'Admin\MenuActionTypeController@save')->name('menuActionType.save');
            Route::get('/menu-action-type-edit/{id}', 'Admin\MenuActionTypeController@edit')->name('menuActionType.edit');
            Route::post('/menu-action-type-update', 'Admin\MenuActionTypeController@update')->name('menuActionType.update');
            Route::post('/menu-action-type-status', 'Admin\MenuActionTypeController@status')->name('menuActionType.status');
            Route::post('/menu-action-delete', 'Admin\MenuActionTypeController@delete')->name('menuActionType.delete');

            //User Roll Manage
            Route::get('/user-role', 'Admin\UserRoleController@index')->name('userRole.index');
            Route::get('/user-role-add', 'Admin\UserRoleController@add')->name('userRole.add');
            Route::post('/user-role-save', 'Admin\UserRoleController@save')->name('userRole.save');
            Route::get('/user-role-edit/{id}', 'Admin\UserRoleController@edit')->name('userRole.edit');
            Route::post('/user-role-upate', 'Admin\UserRoleController@update')->name('userRole.update');
            Route::post('/user-role-delete', 'Admin\UserRoleController@delete')->name('userRole.delete');
            Route::post('/user-role-status', 'Admin\UserRoleController@status')->name('userRole.status');
            Route::get('/user-role-permission/{id}', 'Admin\UserRoleController@permission')->name('userRole.permission');
            Route::post('/user-role-permission-update', 'Admin\UserRoleController@permissionUpdate')->name('userRole.permissionUpdate');

            //Site Information section
            Route::get('/website-information', 'Admin\WebsiteInformationController@index')->name('websiteInformation.index');
            Route::get('/website-information-add', 'Admin\WebsiteInformationController@add')->name('websiteInformation.add');
            Route::post('/website-information-save', 'Admin\WebsiteInformationController@save')->name('websiteInformation.save');
            Route::get('/website-information-edit/{id}', 'Admin\WebsiteInformationController@edit')->name('websiteInformation.edit');
            Route::post('/website-information-update', 'Admin\WebsiteInformationController@update')->name('websiteInformation.update');

            //Admin Information section
            Route::get('/admin-panel-information', 'Admin\AdminPanelInformationController@index')->name('adminPanelInformation.index');
            Route::get('/admin-panel-information-add', 'Admin\AdminPanelInformationController@add')->name('adminPanelInformation.add');
            Route::post('/admin-panel-information-save', 'Admin\AdminPanelInformationController@save')->name('adminPanelInformation.save');
            Route::get('/admin-panel-information-edit/{id}', 'Admin\AdminPanelInformationController@edit')->name('adminPanelInformation.edit');
            Route::post('/admin-panel-information-update', 'Admin\AdminPanelInformationController@update')->name('adminPanelInformation.update');

            //User Manage
            Route::get('/user', 'Admin\AdminController@index')->name('user.index');
            Route::get('/user-add', 'Admin\AdminController@addUser')->name('user.add');
            Route::post('/user-save', 'Admin\AdminController@saveUser')->name('user.save');
            Route::get('/user-edit/{id}', 'Admin\AdminController@editUser')->name('user.edit');
            Route::post('/user-upate', 'Admin\AdminController@updateUser')->name('user.update');
            Route::get('/user-change-password/{id}/{link?}', 'Admin\AdminController@password')->name('user.changePassword');
            Route::post('/user-save-password', 'Admin\AdminController@passwordChange')->name('user.savePassword');
            Route::get('/user-profile/{id}', 'Admin\AdminController@userProfile')->name('user.profile');
            Route::get('/user-my-profile/{id}/{link}', 'Admin\AdminController@userProfile')->name('user.myProfile');
            Route::post('/user-delete', 'Admin\AdminController@deleteUser')->name('user.delete');
            Route::post('/user-status', 'Admin\AdminController@changeUserStatus')->name('user.status');

            // User Menu
            Route::get('/front-end-menu', 'Admin\FrontEndMenuController@index')->name('frontEndMenu.index');
            Route::get('/front-end-menu-add', 'Admin\FrontEndMenuController@add')->name('frontEndMenu.add');
            Route::post('/front-end-menu-save', 'Admin\FrontEndMenuController@save')->name('frontEndMenu.save');
            Route::get('/front-end-menu-edit/{id}', 'Admin\FrontEndMenuController@edit')->name('frontEndMenu.edit');
            Route::post('/front-end-menu-update', 'Admin\FrontEndMenuController@update')->name('frontEndMenu.update');
            Route::post('/front-end-menu-status', 'Admin\FrontEndMenuController@status')->name('frontEndMenu.status');
            Route::post('/front-end-menu-menu-status', 'Admin\FrontEndMenuController@menuStatus')->name('frontEndMenu.menuStatus');
            Route::post('/front-end-menu-footer-menu-status', 'Admin\FrontEndMenuController@footerMenuStatus')->name('frontEndMenu.footerMenuStatus');
            Route::post('/front-end-menu-delete', 'Admin\FrontEndMenuController@delete')->name('frontEndMenu.delete');
            Route::post('/front-end-menu-max-order-by', 'Admin\FrontEndMenuController@maxOrderBY')->name('frontEndMenu.maxOrderBy');

            // Socila Links
            Route::get('/social-link', 'Admin\SocialLinksController@index')->name('socialLink.index');
            Route::get('/social-link-add', 'Admin\SocialLinksController@add')->name('socialLink.add');
            Route::post('/social-link-save', 'Admin\SocialLinksController@save')->name('socialLink.save');
            Route::get('/social-link-edit/{id}', 'Admin\SocialLinksController@edit')->name('socialLink.edit');
            Route::post('/social-link-update', 'Admin\SocialLinksController@update')->name('socialLink.update');
            Route::post('/social-link-status', 'Admin\SocialLinksController@status')->name('socialLink.status');
            Route::post('/social-link-delete', 'Admin\SocialLinksController@delete')->name('socialLink.delete');

            // Sliders
            Route::get('/sliders', 'Admin\SlidersController@index')->name('sliders.index');
            Route::get('/sliders-add', 'Admin\SlidersController@add')->name('sliders.add');
            Route::post('/sliders-save', 'Admin\SlidersController@save')->name('sliders.save');
            Route::get('/sliders-edit/{id}', 'Admin\SlidersController@edit')->name('sliders.edit');
            Route::post('/sliders-update', 'Admin\SlidersController@update')->name('sliders.update');
            Route::post('/sliders-status', 'Admin\SlidersController@status')->name('sliders.status');
            Route::post('/sliders-delete', 'Admin\SlidersController@delete')->name('sliders.delete');

            // Pages
            Route::get('/page', 'Admin\PageController@index')->name('page.index');
            Route::get('/page-add', 'Admin\PageController@add')->name('page.add');
            Route::post('/page-save', 'Admin\PageController@save')->name('page.save');
            Route::get('/page-edit/{id}', 'Admin\PageController@edit')->name('page.edit');
            Route::post('/page-update', 'Admin\PageController@update')->name('page.update');
            Route::post('/page-status', 'Admin\PageController@status')->name('page.status');
            Route::post('/page-delete', 'Admin\PageController@delete')->name('page.delete');

            // Posts
            Route::get('/post/{id}', 'Admin\PostController@index')->name('post.index');
            Route::get('/post-add/{pageId}', 'Admin\PostController@add')->name('post.add');
            Route::post('/post-save', 'Admin\PostController@save')->name('post.save');
            Route::get('/post-edit/{postId}', 'Admin\PostController@edit')->name('post.edit');
            Route::post('/post-update', 'Admin\PostController@update')->name('post.update');
            Route::post('/post-status', 'Admin\PostController@status')->name('post.status');
            Route::post('/post/delete', 'Admin\PostController@delete')->name('post.delete');

            // =======================================================================================================

            //Floor Setup
            Route::get('/floor-setup', 'Admin\FloorSetupController@index')->name('floorSetup.index');
            Route::get('/floor-setup-add', 'Admin\FloorSetupController@add')->name('floorSetup.add');
            Route::post('/floor-setup-save', 'Admin\FloorSetupController@save')->name('floorSetup.save');
            Route::get('/floor-setup-edit/{id}', 'Admin\FloorSetupController@edit')->name('floorSetup.edit');
            Route::post('/floor-setup-update', 'Admin\FloorSetupController@update')->name('floorSetup.update');
            Route::post('/floor-setup-delete', 'Admin\FloorSetupController@delete')->name('floorSetup.delete');
            Route::post('/floor-setup-status', 'Admin\FloorSetupController@status')->name('floorSetup.status');

            //Unit Setup
            Route::get('/unit-setup', 'Admin\UnitSetupController@index')->name('unitSetup.index');
            Route::get('/unit-setup-add', 'Admin\UnitSetupController@add')->name('unitSetup.add');
            Route::post('/unit-setup-save', 'Admin\UnitSetupController@save')->name('unitSetup.save');
            Route::get('/unit-setup-edit/{id}', 'Admin\UnitSetupController@edit')->name('unitSetup.edit');
            Route::post('/unit-setup-update', 'Admin\UnitSetupController@update')->name('unitSetup.update');
            Route::post('/unit-setup-delete', 'Admin\UnitSetupController@delete')->name('unitSetup.delete');
            Route::post('/unit-setup-status', 'Admin\UnitSetupController@status')->name('unitSetup.status');

            //Utility Setup
            Route::get('/utility-setup', 'Admin\UtilitySetupController@index')->name('utilitySetup.index');
            Route::get('/utility-setup-add', 'Admin\UtilitySetupController@add')->name('utilitySetup.add');
            Route::post('/utility-setup-save', 'Admin\UtilitySetupController@save')->name('utilitySetup.save');
            Route::get('/utility-setup-edit/{id}', 'Admin\UtilitySetupController@edit')->name('utilitySetup.edit');
            Route::post('/utility-setup-update', 'Admin\UtilitySetupController@update')->name('utilitySetup.update');
            Route::post('/utility-setup-delete', 'Admin\UtilitySetupController@delete')->name('utilitySetup.delete');
            Route::post('/utility-setup-status', 'Admin\UtilitySetupController@status')->name('utilitySetup.status');

            //Position Information
            Route::get('/position-information', 'Admin\PositionInformationController@index')->name('positionInformation.index');
            Route::get('/position-information-add', 'Admin\PositionInformationController@add')->name('positionInformation.add');
            Route::post('/position-information-save', 'Admin\PositionInformationController@save')->name('positionInformation.save');
            Route::get('/position-information-view/{position}', 'Admin\PositionInformationController@view')->name('positionInformation.view');
            Route::get('/position-information-edit/{position}', 'Admin\PositionInformationController@edit')->name('positionInformation.edit');
            Route::post('/position-information-update', 'Admin\PositionInformationController@update')->name('positionInformation.update');
            Route::post('/position-information-delete', 'Admin\PositionInformationController@delete')->name('positionInformation.delete');
            Route::post('/position-information-status', 'Admin\PositionInformationController@status')->name('positionInformation.status');

            // position info stamps
            Route::get('/position-information-stamps/{tenantId}', 'Admin\PositionInformationController@stampIndex')->name('positionInformation.index.stamp');
            Route::get('/position-information-stamps-add/{tenantId}', 'Admin\PositionInformationController@stampAdd')->name('positionInformation.add.stamps');
            Route::post('/position-information-stamps-save', 'Admin\PositionInformationController@stampSave')->name('positionInformation.save.stamps');
            Route::get('/position-information-stamps-edit/{stampId}', 'Admin\PositionInformationController@stampEdit')->name('positionInformation.edit.stamp');
            Route::post('/position-information-stamps-update', 'Admin\PositionInformationController@stampUpdate')->name('positionInformation.update.stamp');
            Route::post('/position-information-stamp-delete', 'Admin\PositionInformationController@stampDelete')->name('positionInformation.delete.stamp');

            // tenant report
            Route::get('/tentant-report', 'Admin\TenantReportController@index')->name('tenant.list.index');
            Route::get('/tentant-report-add', 'Admin\TenantReportController@add')->name('tenant.list.add');
            Route::post('/tentant-report-search', 'Admin\TenantReportController@search')->name('tenant.report.search');
            Route::post('/tentant-report-print', 'Admin\TenantReportController@print')->name('tenant.report.print');

            //New Project
            Route::get('/new-project', 'Admin\NewProjectController@index')->name('newProject.index');
            Route::get('/new-project-add', 'Admin\NewProjectController@add')->name('newProject.add');
            Route::post('/new-project-save', 'Admin\NewProjectController@save')->name('newProject.save');
            Route::get('/new-project-edit/{id}', 'Admin\NewProjectController@edit')->name('newProject.edit');
            Route::post('/new-project-update', 'Admin\NewProjectController@update')->name('newProject.update');
            Route::post('/new-project-delete', 'Admin\NewProjectController@delete')->name('newProject.delete');
            Route::post('/new-project-status', 'Admin\NewProjectController@status')->name('newProject.status');
            Route::post('/new-project-find-product-price', 'Admin\NewProjectController@findProductPrice')->name('newProject.findProductPrice');

            // jamidari prepeare
            Route::post('jamidari-prepare-search', 'Admin\JamidariPrepareController@search')->name('jamidari.prepare.search');
            Route::get('jamidari-prepare-index', 'Admin\JamidariPrepareController@index')->name('jamidari.prepare.index');
            Route::get('jamidari-prepare-add', 'Admin\JamidariPrepareController@add')->name('jamidari.prepare.add');
            Route::get('jamidari-prepare-add-individual', 'Admin\JamidariPrepareController@addindividual')->name('jamidari.prepare.add.individual');
            Route::post('jamidari-prepare-individual-save', 'Admin\JamidariPrepareController@saveIndividual')->name('jamidari.prepare.save.individual');
            Route::post('jamidari-prepare-save', 'Admin\JamidariPrepareController@save')->name('jamidari.prepare.save');
            Route::get('jamidari-prepare-view/{id}', 'Admin\JamidariPrepareController@view')->name('jamidari.prepare.view');
            Route::get('jamidari-prepare-print/{id}', 'Admin\JamidariPrepareController@print')->name('jamidari.prepare.print');
            Route::post('jamidari-prepare-delete', 'Admin\JamidariPrepareController@delete')->name('jamidari.prepare.delete');
            Route::get('get-tenant-info', 'Admin\JamidariPrepareController@getTenantInfo')->name('jamidari.tenant.info.get.ajax');
            Route::post('jamidari-prepare-delete-individual', 'Admin\JamidariPrepareController@deleteIndividual')->name('jamidari.prepare.delete.individual');

            //Banglalink
            Route::get('banglalink', 'Admin\BanglaLinkPrepareController@index')->name('banglalink.index');
            Route::get('banglalink/add', 'Admin\BanglaLinkPrepareController@add')->name('banglalink.add');
            Route::post('banglalink/store', 'Admin\BanglaLinkPrepareController@store')->name('banglalink.store');
            Route::get('banglalink/edit/{id}', 'Admin\BanglaLinkPrepareController@edit')->name('banglalink.edit');
            Route::post('banglalink/update/{id}', 'Admin\BanglaLinkPrepareController@update')->name('banglalink.update');
            Route::get('banglalink/delete', 'Admin\BanglaLinkPrepareController@delete')->name('banglalink.delete');
  
  

            // EBill prepeare
            Route::get('ebill-prepare-index', 'Admin\EbillPrepareController@index')->name('ebill.prepare.index');
            Route::get('ebill-prepare-add', 'Admin\EbillPrepareController@add')->name('ebill.prepare.add');
            Route::post('ebill-prepare-save', 'Admin\EbillPrepareController@save')->name('ebill.prepare.save');
            Route::get('ebill-prepare-add-individual', 'Admin\EbillPrepareController@addindividual')->name('ebill.prepare.add.individual');
            Route::post('ebill-prepare-individual-save', 'Admin\EbillPrepareController@saveIndividual')->name('ebill.prepare.save.individual');
            Route::get('ebill-prepare-view/{id}', 'Admin\EbillPrepareController@view')->name('ebill.prepare.view');
            Route::get('ebill-prepare-print/{id}', 'Admin\EbillPrepareController@print')->name('ebill.prepare.print');
            Route::get('wbill-prepare-print/{id}', 'Admin\EbillPrepareController@print')->name('wbill.prepare.print');
            Route::get('service-prepare-print/{id}', 'Admin\EbillPrepareController@print')->name('service.prepare.print');
            Route::post('ebill-prepare-delete', 'Admin\EbillPrepareController@delete')->name('ebill.prepare.delete');
            Route::get('get-ebill-info', 'Admin\EbillPrepareController@getEbillInfo')->name('ebill.info.get.ajax');
            Route::post('ebill-prepare-delete-individual', 'Admin\EbillPrepareController@deleteIndividual')->name('ebill.prepare.delete.individual');


            // WBill prepeare
            Route::get('wbill-prepare-index', 'Admin\WbillPrepareController@index')->name('wbill.prepare.index');
            Route::get('wbill-prepare-add', 'Admin\WbillPrepareController@add')->name('wbill.prepare.add');
            Route::post('wbill-prepare-save', 'Admin\WbillPrepareController@save')->name('wbill.prepare.save');
            Route::get('wbill-prepare-add-individual', 'Admin\WbillPrepareController@addindividual')->name('wbill.prepare.add.individual');
            Route::post('wbill-prepare-individual-save', 'Admin\WbillPrepareController@saveIndividual')->name('wbill.prepare.save.individual');
            Route::get('wbill-prepare-view/{id}', 'Admin\WbillPrepareController@view')->name('wbill.prepare.view');
            Route::post('wbill-prepare-delete', 'Admin\WbillPrepareController@delete')->name('wbill.prepare.delete');
            Route::get('get-wbill-info', 'Admin\WbillPrepareController@getWbillInfo')->name('wbill.info.get.ajax');

            // service charge prepare
            Route::get('serviceCharge-prepare', 'Admin\ServiceChargePrepareController@index')->name('service.charge.prepare');
            Route::get('serviceCharge-prepare-add-auto', 'Admin\ServiceChargePrepareController@addAuto')->name('service.charge.prepare.add.auto');
            Route::get('serviceCharge-prepare-add-individual', 'Admin\ServiceChargePrepareController@addindividual')->name('service.charge.prepare.add.individual');
            Route::post('serviceCharge-prepare-save', 'Admin\ServiceChargePrepareController@save')->name('service.charge.prepare.save');
            Route::post('serviceCharge-prepare-individual', 'Admin\ServiceChargePrepareController@saveIndividual')->name('service.charge.prepare.save.individual');
            Route::get('serviceCharge-prepare-view/{id}', 'Admin\ServiceChargePrepareController@view')->name('service.charge.prepare.view');
            Route::post('serviceCharge-prepare-delete', 'Admin\ServiceChargePrepareController@delete')->name('service.charge.prepare.delete');

			Route::post('serviceCharge-prepare-update', 'Admin\ServiceChargePrepareController@billUpdate')->name('service.charge.prepare.update');


            // collection routes
            Route::get('collection-byCode-add', 'Admin\CollectionController@addbyCode')->name('collection.add.bycode');
            Route::post('collection-byCode-add', 'Admin\CollectionController@savebyCode')->name('collection.save.bycode');

            Route::get('collection-byBarCode-add', 'Admin\CollectionController@addbyBarCode')->name('collection.add.bybarcode');
            Route::post('collection-byBarCode-get', 'Admin\CollectionController@getbyBarCode')->name('collection.add.getbybarcode');
            Route::post('collection-byBarCode-add', 'Admin\CollectionController@savebyBarCode')->name('collection.save.bybarcode');

            // register reports
            Route::get('jamidari-register', 'Admin\RegisterReportController@jamidariRegister')->name('jamidari.register.index');
            Route::get('electric-register', 'Admin\RegisterReportController@electricRegister')->name('electric.bill.register');
            Route::get('water-register', 'Admin\RegisterReportController@waterRegister')->name('water.bill.register');
            Route::get('service-register', 'Admin\RegisterReportController@serviceRegister')->name('service.charge.register');

            // rent increment controller
            Route::get('rent-increment', 'RentIncrementController@GetIncrementTenantList')->name('rent.increment');
            Route::post('rent-increment-update', 'RentIncrementController@UpdateTenantRent')->name('update.tenant.rent');


            // collection reports
            Route::get('collection-report', 'Admin\CollectionReportController@CollectionReport')->name('collection.report');
            Route::get('collection-summary-report', 'Admin\CollectionReportController@CollectionSummaryReport')->name('collection.summary.report');

            // due reports
            Route::get('jamidari-due-report', 'Admin\DueReportController@JamidariDueReport')->name('jamidari.due.report');
            Route::get('service-due-report', 'Admin\DueReportController@ServiceDueReport')->name('service.due.report');

            // reading
            Route::get('ebill-reading-sheet', 'Admin\EbillPrepareController@addReading')->name('ebill.reading.sheet');

            // reprint menu
            Route::get('jamidari-reprint-view', 'Admin\ReprintController@jamidariView')->name('jamidari.reprint.view');
            Route::post('jamidari-reprint', 'Admin\ReprintController@jamidari')->name('jamidari.reprint');

            Route::get('ebill-reprint-view', 'Admin\ReprintController@ebillView')->name('ebill.reprint.view');
            Route::post('ebill-reprint', 'Admin\ReprintController@ebill')->name('ebill.reprint');


            // Start Account Management
            // COA Setup
            Route::get('/coa-setup', 'Admin\CoaSetupController@index')->name('coaSetup.index');
            Route::get('/coa-setup-add', 'Admin\CoaSetupController@add')->name('coaSetup.add');
            Route::post('/coa-setup-action', 'Admin\CoaSetupController@action')->name('coaSetup.action');
            Route::get('/coa-setup-edit/{id}', 'Admin\CoaSetupController@edit')->name('coaSetup.edit');
            Route::post('/coa-setup-update', 'Admin\CoaSetupController@update')->name('coaSetup.update');
            Route::post('/coa-setup-delete', 'Admin\CoaSetupController@delete')->name('coaSetup.delete');
            Route::post('/coa-setup-tree', 'Admin\CoaSetupController@makeTree')->name('coaSetup.makeTree');
            Route::post('/coa-setup-new-coa-data', 'Admin\CoaSetupController@newCoaData')->name('coaSetup.newCoaData');
            Route::post('/coa-setup-load-coa-data', 'Admin\CoaSetupController@loadCoaData')->name('coaSetup.loadCoaData');

            // Debit Voucher Entry
            Route::get('/debit-entry', 'Admin\DebitEntryController@index')->name('debitEntry.index');
            Route::post('/debit-entry', 'Admin\DebitEntryController@index')->name('debitEntry.index');
            Route::post('/debit-entry-print', 'Admin\DebitEntryController@print')->name('debitEntry.print');
            Route::get('/debit-entry-add', 'Admin\DebitEntryController@add')->name('debitEntry.add');
            Route::post('/debit-entry-save', 'Admin\DebitEntryController@save')->name('debitEntry.save');
            Route::get('/debit-entry-view/{id}', 'Admin\DebitEntryController@view')->name('debitEntry.view');
            Route::get('/debit-entry-print/{id}', 'Admin\DebitEntryController@printDebitVoucher')->name('journalEntry.printDebitVoucher');
            Route::get('/debit-entry-edit/{id}', 'Admin\DebitEntryController@edit')->name('debitEntry.edit');
            Route::post('/debit-entry-update', 'Admin\DebitEntryController@update')->name('debitEntry.update');
            Route::post('/debit-entry-delete', 'Admin\DebitEntryController@delete')->name('debitEntry.delete');
            Route::post('/debit-entry-publish', 'Admin\DebitEntryController@changePublish')->name('debitEntry.publish');
            Route::post('/debit-entry-get-coa', 'Admin\DebitEntryController@getCoa')->name('debitEntry.getCoa');
            Route::post('/debit-entry-vouchar-no', 'Admin\DebitEntryController@getVoucharNo')->name('debitEntry.getVoucharNo');

            // Credit Voucher Entry
            Route::get('/credit-entry', 'Admin\CreditEntryController@index')->name('creditEntry.index');
            Route::post('/credit-entry', 'Admin\CreditEntryController@index')->name('creditEntry.index');
            Route::post('/credit-entry-print', 'Admin\CreditEntryController@print')->name('creditEntry.print');
            Route::get('/credit-entry-add', 'Admin\CreditEntryController@add')->name('creditEntry.add');
            Route::post('/credit-entry-save', 'Admin\CreditEntryController@save')->name('creditEntry.save');
            Route::get('/credit-entry-view/{id}', 'Admin\CreditEntryController@view')->name('creditEntry.view');
            Route::get('/credit-entry-print/{id}', 'Admin\CreditEntryController@printCreditVoucher')->name('journalEntry.printCreditVoucher');
            Route::get('/credit-entry-edit/{id}', 'Admin\CreditEntryController@edit')->name('creditEntry.edit');
            Route::post('/credit-entry-update', 'Admin\CreditEntryController@update')->name('creditEntry.update');
            Route::post('/credit-entry-delete', 'Admin\CreditEntryController@delete')->name('creditEntry.delete');
            Route::post('/credit-entry-publish', 'Admin\CreditEntryController@changePublish')->name('creditEntry.publish');
            Route::post('/credit-entry-get-coa', 'Admin\CreditEntryController@getCoa')->name('creditEntry.getCoa');
            Route::post('/credit-entry-vouchar-no', 'Admin\CreditEntryController@getVoucharNo')->name('creditEntry.getVoucharNo');

            // Journal Voucher Entry
            Route::get('/journal-entry', 'Admin\JournalEntryController@index')->name('journalEntry.index');
            Route::post('/journal-entry', 'Admin\JournalEntryController@index')->name('journalEntry.index');
            Route::post('/journal-entry-print', 'Admin\JournalEntryController@print')->name('journalEntry.print');
            Route::get('/journal-entry-add', 'Admin\JournalEntryController@add')->name('journalEntry.add');
            Route::post('/journal-entry-save', 'Admin\JournalEntryController@save')->name('journalEntry.save');
            Route::get('/journal-entry-view/{id}', 'Admin\JournalEntryController@view')->name('journalEntry.view');
            Route::get('/journal-entry-print/{id}', 'Admin\JournalEntryController@printJournalVoucher')->name('journalEntry.printJournalVoucher');
            Route::get('/journal-entry-edit/{id}', 'Admin\JournalEntryController@edit')->name('journalEntry.edit');
            Route::post('/journal-entry-update', 'Admin\JournalEntryController@update')->name('journalEntry.update');
            Route::post('/journal-entry-delete', 'Admin\JournalEntryController@delete')->name('journalEntry.delete');
            Route::post('/journal-entry-publish', 'Admin\JournalEntryController@changePublish')->name('journalEntry.publish');
            Route::post('/journal-entry-get-coa', 'Admin\JournalEntryController@getCoa')->name('journalEntry.getCoa');
            Route::post('/journal-entry-vouchar-no', 'Admin\JournalEntryController@getVoucharNo')->name('journalEntry.getVoucharNo');

            // Openning Balance Entry
            Route::get('/opening-balance-entry', 'Admin\OpeningBalanceController@index')->name('openingBalanceEntry.index');
            Route::post('/opening-balance-entry', 'Admin\OpeningBalanceController@index')->name('openingBalanceEntry.index');
            Route::post('/opening-balance-entry-print', 'Admin\OpeningBalanceController@print')->name('openingBalanceEntry.print');
            Route::get('/opening-balance-entry-add', 'Admin\OpeningBalanceController@add')->name('openingBalanceEntry.add');
            Route::post('/opening-balance-entry-save', 'Admin\OpeningBalanceController@save')->name('openingBalanceEntry.save');
            Route::get('/opening-balance-entry-view/{id}', 'Admin\OpeningBalanceController@view')->name('openingBalanceEntry.view');
            Route::get('/opening-balance-entry-print/{id}', 'Admin\OpeningBalanceController@printOpeningBalanceVoucher')->name('openingBalanceEntry.printOpeningBalanceVoucher');
            Route::post('/opening-balance-entry-delete', 'Admin\OpeningBalanceController@delete')->name('openingBalanceEntry.delete');
            Route::post('/opening-balance-entry-publish', 'Admin\OpeningBalanceController@changePublish')->name('openingBalanceEntry.publish');
            Route::post('/opening-balance-entry-get-coa', 'Admin\OpeningBalanceController@getCoa')->name('openingBalanceEntry.getCoa');
            Route::post('/opening-balance-entry-vouchar-no', 'Admin\OpeningBalanceController@getVoucharNo')->name('openingBalanceEntry.getVoucharNo');

            // Voucher Approve
            Route::get('/voucher-approve', 'Admin\VoucherApproveController@index')->name('voucherApprove.index');
            Route::post('/voucher-approve', 'Admin\VoucherApproveController@index')->name('voucherApprove.index');
            Route::get('/voucher-approve-view/{id}', 'Admin\VoucherApproveController@view')->name('voucherApprove.view');
            Route::post('/voucher-approve-single', 'Admin\VoucherApproveController@approve')->name('voucherApprove.approve');
            // End Account Management

            // Start Account Report
            // COA List
            Route::get('/coa-list', 'Admin\CoaListController@index')->name('coaList.index');
            Route::get('/coa-list-print', 'Admin\CoaListController@print')->name('coaList.print');

            //Voucher List
            Route::get('/voucher-list', 'Admin\VoucherListController@index')->name('voucherList.index');
            Route::post('/voucher-list', 'Admin\VoucherListController@index')->name('voucherList.index');
            Route::post('/voucher-list-print', 'Admin\VoucherListController@print')->name('voucherList.print');

            //General Ledger List
            Route::get('/general-ledger', 'Admin\GeneralLedgerController@index')->name('generalLedger.index');
            Route::post('/general-ledger', 'Admin\GeneralLedgerController@index')->name('generalLedger.index');
            Route::post('/general-ledger-print', 'Admin\GeneralLedgerController@print')->name('generalLedger.print');

            //Trasaction Ledger List
            Route::get('/transaction-ledger', 'Admin\TransactionLedgerController@index')->name('transactionLedger.index');
            Route::post('/transaction-ledger', 'Admin\TransactionLedgerController@index')->name('transactionLedger.index');
            Route::post('/transaction-ledger-print', 'Admin\TransactionLedgerController@print')->name('transactionLedger.print');

            //Cash Book
            Route::get('/cash-book', 'Admin\CashBookController@index')->name('cashBook.index');
            Route::post('/cash-book', 'Admin\CashBookController@index')->name('cashBook.index');
            Route::post('/cash-book-print', 'Admin\CashBookController@print')->name('cashBook.print');

            //Bank Book
            Route::get('/bank-book', 'Admin\bankBookController@index')->name('bankBook.index');
            Route::post('/bank-book', 'Admin\bankBookController@index')->name('bankBook.index');
            Route::post('/bank-book-print', 'Admin\bankBookController@print')->name('bankBook.print');

            //Trial Balance
            Route::get('/trial-balance', 'Admin\TrialBalanceController@index')->name('trialBalance.index');
            Route::post('/trial-balance', 'Admin\TrialBalanceController@index')->name('trialBalance.index');
            Route::post('/trial-balance-print', 'Admin\TrialBalanceController@print')->name('trialBalance.print');

            //Balance Sheets
            Route::get('/balance-sheet', 'Admin\BalanceSheetController@index')->name('balanceSheet.index');
            Route::post('/balance-sheet', 'Admin\BalanceSheetController@index')->name('balanceSheet.index');
            Route::post('/balance-sheet-print', 'Admin\BalanceSheetController@print')->name('balanceSheet.print');
            Route::post('/head-details', 'Admin\BalanceSheetController@headDetails')->name('head-details.index');

            //Income statement
            Route::get('/income-statement', 'Admin\IncomeStatementController@index')->name('incomeStatement.index');
            Route::post('/income-statement', 'Admin\IncomeStatementController@index')->name('incomeStatement.index');
            Route::post('/income-statement-print', 'Admin\IncomeStatementController@print')->name('incomeStatement.print');

            //Receive And Payment statement
            Route::get('/receive-payment-statement', 'Admin\ReceivePaymentStatementController@index')->name('receivePaymentStatement.index');
            Route::post('/receive-payment-statement', 'Admin\ReceivePaymentStatementController@index')->name('receivePaymentStatement.index');
            Route::post('/receive-payment-statement-print', 'Admin\ReceivePaymentStatementController@print')->name('receivePaymentStatement.print');
            // End Account Report


            // Collection Deposit
            Route::get('/collection-deposit', 'Admin\CollectionDepositController@index')->name('collectionDeposit.index');
            Route::post('/collection-deposit-save', 'Admin\CollectionDepositController@save')->name('collectionDeposit.save');

            // Collection Deposit report
            Route::get('/collection-status-report', 'Admin\CollectionDepositController@report')->name('collectionDeposit.report');

            // Jamidari Increase report
            Route::get('/jamidari-increase-report', 'Admin\JamiDariIncreaseReportController@report')->name('jamidariIncrease.report');

            // daily income expense
            Route::any('/daily-income-expense', 'Admin\IncomeStatementController@dailyIncomeExpense')->name('daily.income.expense');
            Route::post('/daily-income-expense-print', 'Admin\IncomeStatementController@dailyIncomeExpensePrint')->name('daily.income.expense.print');
        });
    });

    //Admin Login Url
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login');
    Route::post('/logout', 'Auth\AdminLoginController@adminLogout')->name('admin.logout');

    // Password Reset Routes...
    Route::get('/password/reset', 'Auth\AdminForgotPasswordController@passwordForget')->name('admin.password.forget');
    Route::post('/password/email', 'Auth\AdminForgotPasswordController@passwordEmail')->name('admin.password.email');
    Route::get('/new-password/{email}', 'Auth\AdminForgotPasswordController@newPassword')->name('admin.password.newPassword');
    Route::post('/password/save', 'Auth\AdminForgotPasswordController@changePasswordSave')->name('admin.password.save');
});



// Route::get('/home', 'HomeController@index')->name('home');

Route::get('/clear', function () {

    Artisan::call('optimize:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Artisan::call('clear-compiled');

    return "Cleared!";
});
