<?php

require __DIR__ . './commerce_2/router.php';

Route::add('/', function() {
    require __DIR__ . '/commerce_2/views/home.php';
});

Route::add('/login', function() {
    require __DIR__ . '/commerce_2/views/login.php';
});

Route::add('/register', function() {
    require __DIR__ . '/commerce_2/views/register.php';
});

Route::add('/logout', function() {
    require __DIR__ . '/commerce_2/views/logout.php';
});

Route::add('/item', function() {
    require __DIR__ . '/commerce_2/views/item.php';
});

Route::add('/products', function() {
    require __DIR__ . '/commerce_2/views/products.php';
});

Route::add('/profile', function() {
    require __DIR__ . '/commerce_2/views/profile.php';
});

Route::add('/orders', function() {
    require __DIR__ . '/commerce_2/views/orders.php';
});

Route::add('/order-details', function() {
    require __DIR__ . '/commerce_2/views/order-details.php';
});

Route::add('/cart', function() {
    require __DIR__ . '/commerce_2/views/cart.php';
});

Route::add('/cart-remove-item', function() {
    require __DIR__ . '/commerce_2/views/cart-remove-item.php';
});

Route::add('/confirmation', function() {
    require __DIR__ . '/commerce_2/views/confirmation.php';
});

Route::add('/faq', function() {
    require __DIR__ . '/commerce_2/views/faq.php';
});

Route::add('/about', function() {
    require __DIR__ . '/commerce_2/views/about.php';
});

Route::add('/privacy-policy', function() {
    require __DIR__ . '/commerce_2/views/privacy-policy.php';
});

Route::add('/forgot-password', function() {
    require __DIR__ . '/commerce_2/views/forgot-password.php';
});

Route::add('/reset', function() {
    require __DIR__ . '/commerce_2/views/reset.php';
});

Route::add('/400', function() {
    require __DIR__ . '/commerce_2/views/400.php';
});

Route::add('/robots.txt', function() {
    require __DIR__ . '/commerce_2/views/robots.php';
});

Route::add('/sitemap.xml', function() {
    require __DIR__ . '/commerce_2/views/sitemap.xml';
});

Route::add('/admin/home', function() {
    require __DIR__ . '/commerce_2/views/admin/home.php';
});

Route::add('/admin/login', function() {
    require __DIR__ . '/commerce_2/views/admin/login.php';
});

Route::add('/admin/logout', function() {
    require __DIR__ . '/commerce_2/views/admin/logout.php';
});

Route::add('/admin/reset-password', function() {
    require __DIR__ . '/commerce_2/views/reset-password.php';
});

Route::add('/admin/products', function() {
    require __DIR__ . '/commerce_2/views/admin/products.php';
});

Route::add('/admin/customers', function() {
    require __DIR__ . '/commerce_2/views/admin/customers.php';
});

Route::add('/admin/orders', function() {
    require __DIR__ . '/commerce_2/views/admin/orders.php';
});

Route::add('/admin/faq', function() {
    require __DIR__ . '/commerce_2/views/admin/faq.php';
});

Route::add('/admin/settings', function() {
    require __DIR__ . '/commerce_2/views/admin/settings.php';
});

Route::add('/admin/products/create', function() {
    require __DIR__ . '/commerce_2/views/admin/create-product.php';
});

Route::add('/admin/customers/create', function() {
    require __DIR__ . '/commerce_2/views/admin/create-customer.php';
});

Route::add('/admin/faq/create', function() {
    require __DIR__ . '/commerce_2/views/admin/create-faq.php';
});

Route::add('/admin/stats', function() {
    require __DIR__ . '/commerce_2/views/admin/stats.php';
});

Route::submit();
