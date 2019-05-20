<?php

/********************* PUBLIC *********************/

// INDEX
Route::get('/', 'Index\PublicController@index')->name('public.index');

// AUTHENTICATION
Auth::routes();
Route::get('verification/error', 'Auth\RegisterController@getVerificationError')->name('email-verification.error');
Route::get('verification/check/{token}', 'Auth\RegisterController@getVerification')->name('email-verification.check');

// PAGE
Route::get('page/{slug}', 'Page\PublicController@show')->name('public.page.show');

// FAQ
Route::get('faq', 'Faq\Post\PublicController@index')->name('public.faq.index');

// NEWS
Route::get('news', 'News\PublicController@index')->name('public.news.index');
Route::get('news/{slug}', 'News\PublicController@show')->name('public.news.show');

// EXHIBITION
Route::get('exhibition', 'Exhibition\PublicController@index')->name('public.exhibition.index');
Route::get('exhibition/post/{slug}', 'Exhibition\PublicController@show')->name('public.exhibition.show');
Route::get('exhibition/calendar', 'Exhibition\PublicController@calendar_index')->name('public.exhibition.calendar.index');
Route::get('exhibition/catalogue', 'Exhibition\PublicController@catalogue_index')->name('public.exhibition.catalogue.index');
Route::get('exhibition/catalogue/post/{id}', 'Exhibition\PublicController@catalogue_show')->name('public.exhibition.catalogue.show');
Route::get('exhibition/calendar/post/{id}', 'Exhibition\PublicController@calendar_show')->name('public.exhibition.calendar.show');

Route::group(['middleware' => ['auth']], function () {
    Route::get('exhibition/catalogue/post/{id}/exhibitors', 'Exhibition\PublicController@catalogue_exhibitors')->name('public.exhibition.catalogue.exhibitors');
});

// CONTACT
Route::get('contact', 'Contact\PublicController@create')->name('public.contact.create');
Route::post('contact', 'Contact\PublicController@store')->name('public.contact.store');

// USER
Route::group(['prefix' => 'user', 'namespace' => 'User'], function () {
    Route::get('seller', 'PublicController@index')->name('public.user.seller.index');
    Route::get('buyer', 'PublicController@index')->name('public.user.buyer.index');
    Route::get('{id}', 'PublicController@show')->name('public.user.show');
    Route::get('user/{id}/qr', 'PublicController@qr')->name('public.user.qr');
});

// PRODUCT
Route::get('product', 'Product\Post\PublicController@index')->name('public.product.index');
Route::get('product/post/{id}', 'Product\Post\PublicController@show')->name('public.product.show');

// SEARCH
Route::get('search', 'Search\PublicController@index')->name('public.search.index');

Route::get('cpanel', function () {
    return redirect()->to('http://88.99.137.32/cpanel');
});

/********************* MEMBER *********************/

Route::group([
    'middleware' => ['auth', 'role:seller|buyer', 'isVerified', 'complete'],
    'prefix'     => 'member',
], function () {

    // INDEX
    Route::get('/', 'Index\MemberController@index')->name('member.index');

    // PACKAGE
    Route::get('package', 'Package\MemberController@index')->name('member.package.index');
    Route::post('package', 'Package\MemberController@store')->name('member.package.store');

    // PROFILE
    Route::group(['namespace' => 'User'], function () {
        Route::get('profile', 'MemberController@general')->name('member.profile.general');
        Route::get('profile/company', 'MemberController@company')->name('member.profile.company');
        Route::get('profile/profile', 'MemberController@profile')->name('member.profile.profile');
        Route::get('profile/category', 'MemberController@category')->name('member.profile.category');
        Route::get('profile/banners', 'MemberController@banners')->name('member.profile.banners');
        Route::get('profile/media', 'MemberController@media')->name('member.profile.media');
        Route::get('profile/complete', 'MemberController@complete')->name('member.profile.complete');
        Route::put('profile', 'MemberController@update')->name('member.profile.update');

        Route::post('profile/media/upload', 'MediaController@store')->name('member.profile.media.store');
        Route::delete('profile/media/destroy/{id}', 'MediaController@destroy')->name('member.profile.media.destroy');
    });

    // PRODUCT
    Route::group(['namespace' => 'Product\Post'], function () {
        Route::get('product', 'MemberController@index')->name('member.product.post.index');
        Route::get('product/create', 'MemberController@create')->name('member.product.post.create');
        Route::post('product', 'MemberController@store')->name('member.product.post.store');
        Route::get('product/{id}/edit', 'MemberController@edit')->name('member.product.post.edit');
        Route::put('product/{id}', 'MemberController@update')->name('member.product.post.update');
        Route::delete('product/{id}', 'MemberController@destroy')->name('member.product.post.destroy');

        Route::post('product/{id}/media', 'MediaController@store')->name('member.product.post.media.upload');
        Route::delete('product/{id}/media', 'MediaController@destroy')->name('member.product.post.media.destroy');
    });

    // TRAFFIC
    Route::get('traffic', 'Traffic\MemberController@index')->name('member.traffic.index');
    Route::get('traffic/{id}', 'Traffic\MemberController@show')->name('member.traffic.show');

    // MESSAGE
    Route::group(['namespace' => 'Message'], function () {
        Route::get('message', 'MemberController@index')->name('member.message.index');
        Route::get('message/create', 'MemberController@create')->name('member.message.create');
        Route::post('message', 'MemberController@store')->name('member.message.store');
        Route::get('message/{id}', 'MemberController@show')->name('member.message.show');
        Route::put('message/{id}', 'MemberController@update')->name('member.message.update');
    });

});

/********************* ADMIN *********************/

Route::group([
    'middleware' => ['auth', 'isAdmin'],
    'prefix'     => config('app.admin_path'),
], function () {

    // INDEX
    Route::get('/', 'Index\AdminController@index')->name('admin.index');

    // PROFILE
    Route::group(['namespace' => 'User'], function () {
        Route::get('profile', 'AdminController@profile')->name('admin.profile');
        Route::put('profile', 'AdminController@profileUpdate')->name('admin.profile.update');
    });

    // FAQ
    Route::group(['prefix' => 'faq'], function () {
        Route::resource('category', 'Faq\Category\AdminController', [
            'only'  => [
                'index',
                'create',
                'store',
                'edit',
                'update',
                'destroy',
            ],
            'names' => [
                'index'   => 'admin.faq.category.index',
                'create'  => 'admin.faq.category.create',
                'store'   => 'admin.faq.category.store',
                'edit'    => 'admin.faq.category.edit',
                'update'  => 'admin.faq.category.update',
                'destroy' => 'admin.faq.category.destroy',
            ],
        ]);
        Route::resource('post', 'Faq\Post\AdminController', [
            'only'  => [
                'index',
                'create',
                'store',
                'edit',
                'update',
                'destroy',
            ],
            'names' => [
                'index'   => 'admin.faq.post.index',
                'create'  => 'admin.faq.post.create',
                'store'   => 'admin.faq.post.store',
                'edit'    => 'admin.faq.post.edit',
                'update'  => 'admin.faq.post.update',
                'destroy' => 'admin.faq.post.destroy',
            ],
        ]);
    });

    // PAGE
    Route::resource('page', 'Page\AdminController', [
        'only'  => [
            'index',
            'create',
            'store',
            'edit',
            'update',
            'destroy',
        ],
        'names' => [
            'index'   => 'admin.page.index',
            'create'  => 'admin.page.create',
            'store'   => 'admin.page.store',
            'edit'    => 'admin.page.edit',
            'update'  => 'admin.page.update',
            'destroy' => 'admin.page.destroy',
        ],
    ]);

    // NEWS
    Route::resource('news', 'News\AdminController', [
        'only'  => [
            'index',
            'create',
            'store',
            'edit',
            'update',
            'destroy',
        ],
        'names' => [
            'index'   => 'admin.news.index',
            'create'  => 'admin.news.create',
            'store'   => 'admin.news.store',
            'edit'    => 'admin.news.edit',
            'update'  => 'admin.news.update',
            'destroy' => 'admin.news.destroy',
        ],
    ]);
    Route::post('news/{id}/media', 'News\MediaController@store')->name('admin.news.media.store');
    Route::delete('news/{id}/media', 'News\MediaController@destroy')->name('admin.news.media.destroy');

    // EXHIBITION
    Route::resource('exhibition', 'Exhibition\AdminController', [
        'only'  => [
            'index',
            'create',
            'store',
            'edit',
            'update',
            'destroy',
        ],
        'names' => [
            'index'   => 'admin.exhibition.index',
            'create'  => 'admin.exhibition.create',
            'store'   => 'admin.exhibition.store',
            'edit'    => 'admin.exhibition.edit',
            'update'  => 'admin.exhibition.update',
            'destroy' => 'admin.exhibition.destroy',
        ],
    ]);
    Route::post('exhibition/{id}/media', 'Exhibition\MediaController@store')->name('admin.exhibition.media.store');
    Route::delete('exhibition/{id}/media', 'Exhibition\MediaController@destroy')->name('admin.exhibition.media.destroy');

    // EXHIBITION ASSIGN
    Route::resource('exhibition/{id}/exhibition_assign', 'ExhibitionAssign\AdminController', [
        'only'  => [
            'index',
            'create',
            'store',
            'edit',
            'update',
            'destroy',
        ],
        'names' => [
            'index'   => 'admin.exhibition_assign.index',
            'create'  => 'admin.exhibition_assign.create',
            'store'   => 'admin.exhibition_assign.store',
            'edit'    => 'admin.exhibition_assign.edit',
            'update'  => 'admin.exhibition_assign.update',
            'destroy' => 'admin.exhibition_assign.destroy',
        ],
    ]);
    Route::post('exhibition/{id}/media', 'Exhibition\MediaController@store')->name('admin.exhibition.media.store');
    Route::delete('exhibition/{id}/media', 'Exhibition\MediaController@destroy')->name('admin.exhibition.media.destroy');

    // EXHIBITOR
    Route::resource('exhibitor', 'Exhibitor\AdminController', [
        'only'  => [
            'index',
            'create',
            'store',
            'edit',
            'update',
            'destroy',
        ],
        'names' => [
            'index'   => 'admin.exhibitor.index',
            'create'  => 'admin.exhibitor.create',
            'store'   => 'admin.exhibitor.store',
            'edit'    => 'admin.exhibitor.edit',
            'update'  => 'admin.exhibitor.update',
            'destroy' => 'admin.exhibitor.destroy',
        ],
    ]);
    Route::post('exhibitor/{id}/media', 'Exhibitor\MediaController@store')->name('admin.exhibitor.media.store');
    Route::delete('exhibitor/{id}/media', 'Exhibitor\MediaController@destroy')->name('admin.exhibitor.media.destroy');

    // CONTACT
    Route::resource('contact', 'Contact\AdminController', [
        'only'  => [
            'index',
        ],
        'names' => [
            'index' => 'admin.contact.index',
        ],
    ]);

    // USER
    Route::get('user/export', 'User\AdminController@export')->name('admin.user.export');
    Route::post('user/export', 'User\AdminController@export_process')->name('admin.user.export.process');
    Route::get('user/import', 'User\AdminController@import')->name('admin.user.import');
    Route::post('user/import', 'User\AdminController@import_process')->name('admin.user.import.process');
    Route::get('user/seller', 'User\AdminController@index')->name('admin.user.index.seller');
    Route::get('user/buyer', 'User\AdminController@index')->name('admin.user.index.buyer');
    Route::resource('user', 'User\AdminController', [
        'only'  => [
            'index',
            'create',
            'store',
            'show',
            'edit',
            'update',
            'destroy',
        ],
        'names' => [
            'index'   => 'admin.user.index',
            'create'  => 'admin.user.create',
            'store'   => 'admin.user.store',
            'show'    => 'admin.user.show',
            'edit'    => 'admin.user.edit',
            'update'  => 'admin.user.update',
            'destroy' => 'admin.user.destroy',
        ],
    ]);

    // ROLE
    Route::resource('role', 'User\Role\AdminController', [
        'only'  => [
            'index',
            'create',
            'store',
            'show',
            'edit',
            'update',
            'destroy',
        ],
        'names' => [
            'index'   => 'admin.role.index',
            'create'  => 'admin.role.create',
            'store'   => 'admin.role.store',
            'show'    => 'admin.role.show',
            'edit'    => 'admin.role.edit',
            'update'  => 'admin.role.update',
            'destroy' => 'admin.role.destroy',
        ],
    ]);

    // ADMIN
    Route::resource('admin', 'User\Admin\AdminController', [
        'only'  => [
            'index',
            'create',
            'store',
            'show',
            'edit',
            'update',
            'destroy',
        ],
        'names' => [
            'index'   => 'admin.admin.index',
            'create'  => 'admin.admin.create',
            'store'   => 'admin.admin.store',
            'show'    => 'admin.admin.show',
            'edit'    => 'admin.admin.edit',
            'update'  => 'admin.admin.update',
            'destroy' => 'admin.admin.destroy',
        ],
    ]);

    // PRODUCT
    Route::resource('product/post', 'Product\Post\AdminController', [
        'only'  => [
            'index',
            'create',
            'store',
            'show',
            'edit',
            'update',
            'destroy',
        ],
        'names' => [
            'index'   => 'admin.product.post.index',
            'create'  => 'admin.product.post.create',
            'store'   => 'admin.product.post.store',
            'show'    => 'admin.product.post.show',
            'edit'    => 'admin.product.post.edit',
            'update'  => 'admin.product.post.update',
            'destroy' => 'admin.product.post.destroy',
        ],
    ]);

    Route::resource('product/category', 'Product\Category\AdminController', [
        'only'  => [
            'index',
            'create',
            'store',
            'show',
            'edit',
            'update',
            'destroy',
        ],
        'names' => [
            'index'   => 'admin.product.category.index',
            'create'  => 'admin.product.category.create',
            'store'   => 'admin.product.category.store',
            'show'    => 'admin.product.category.show',
            'edit'    => 'admin.product.category.edit',
            'update'  => 'admin.product.category.update',
            'destroy' => 'admin.product.category.destroy',
        ],
    ]);

    // TRAFFIC
    Route::resource('traffic', 'Traffic\AdminController', [
        'only'  => [
            'index',
            'create',
            'store',
            'show',
            'edit',
            'update',
            'destroy',
        ],
        'names' => [
            'index'   => 'admin.traffic.index',
            'create'  => 'admin.traffic.create',
            'store'   => 'admin.traffic.store',
            'show'    => 'admin.traffic.show',
            'edit'    => 'admin.traffic.edit',
            'update'  => 'admin.traffic.update',
            'destroy' => 'admin.traffic.destroy',
        ],
    ]);

    // SEARCH
    Route::resource('search', 'Search\AdminController', [
        'only'  => [
            'index',
        ],
        'names' => [
            'index' => 'admin.search.index',
        ],
    ]);

    // PACKAGE
    Route::resource('package', 'Package\AdminController', [
        'only'  => [
            'index',
            'create',
            'store',
            'show',
            'edit',
            'update',
            'destroy',
        ],
        'names' => [
            'index'   => 'admin.package.index',
            'create'  => 'admin.package.create',
            'store'   => 'admin.package.store',
            'show'    => 'admin.package.show',
            'edit'    => 'admin.package.edit',
            'update'  => 'admin.package.update',
            'destroy' => 'admin.package.destroy',
        ],
    ]);

    // COUPON
    Route::resource('coupon', 'Coupon\AdminController', [
        'only'  => [
            'index',
            'create',
            'store',
            'show',
            'edit',
            'update',
            'destroy',
        ],
        'names' => [
            'index'   => 'admin.coupon.index',
            'create'  => 'admin.coupon.create',
            'store'   => 'admin.coupon.store',
            'show'    => 'admin.coupon.show',
            'edit'    => 'admin.coupon.edit',
            'update'  => 'admin.coupon.update',
            'destroy' => 'admin.coupon.destroy',
        ],
    ]);

    // ENDORSEMENT
    Route::resource('endorsement', 'Endorsement\AdminController', [
        'only'  => [
            'index',
            'create',
            'store',
            'edit',
            'update',
            'destroy',
        ],
        'names' => [
            'index'   => 'admin.endorsement.index',
            'create'  => 'admin.endorsement.create',
            'store'   => 'admin.endorsement.store',
            'edit'    => 'admin.endorsement.edit',
            'update'  => 'admin.endorsement.update',
            'destroy' => 'admin.endorsement.destroy',
        ],
    ]);
    Route::post('endorsement/{id}/media', 'Endorsement\MediaController@store')->name('admin.endorsement.media.store');
    Route::delete('endorsement/{id}/media', 'Endorsement\MediaController@destroy')->name('admin.endorsement.media.destroy');

    // MESSAGE
    Route::resource('message', 'Message\AdminController', [
        'only'  => [
            'index',
            'create',
            'store',
            'edit',
            'update',
            'destroy',
        ],
        'names' => [
            'index'   => 'admin.message.index',
            'create'  => 'admin.message.create',
            'store'   => 'admin.message.store',
            'edit'    => 'admin.message.edit',
            'update'  => 'admin.message.update',
            'destroy' => 'admin.message.destroy',
        ],
    ]);

    // SETTING
    Route::get('setting/index', 'Setting\AdminController@index')->name('admin.setting.index');
    Route::get('setting/company', 'Setting\AdminController@company')->name('admin.setting.company');
    Route::get('setting/application', 'Setting\AdminController@application')->name('admin.setting.application');
    Route::get('setting/email', 'Setting\AdminController@email')->name('admin.setting.email');
    Route::put('setting', 'Setting\AdminController@update')->name('admin.setting.update');
});

/********************/

Route::group(['middleware' => ['auth']], function () {
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');

    Route::get('ajax/product/category', 'Product\Category\AjaxController@index')->name('ajax.product.category.index');
    Route::get('ajax/product/category/{id}', 'Product\Category\AjaxController@show')->name('ajax.product.category.show');

    Route::get('ajax/coupon/{id}', 'Coupon\AjaxController@show')->name('ajax.coupon.show');
});
