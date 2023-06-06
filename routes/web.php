<?php

use Psy\Util\Str;
use App\Models\City;
use App\Models\Length;
use App\Http\Controllers\CartCont;
use App\Http\Controllers\CouponCont;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ChargesCont;
use App\Http\Controllers\CustRegCont;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckoutCont;
use App\Http\Controllers\CustLoginCont;
use App\Http\Controllers\cataController;
use App\Http\Controllers\CustomerCont;
use App\Http\Controllers\userController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SubcateController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\OrderCont;
use App\Http\Controllers\RoleCont;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\StripePaymentController;

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

Route::get('/login', function () {
    return view('login');
});

Auth::routes();


// === Frontend ===
Route::get('/', [FrontendController::class, 'home_page'])->name('home_page');
Route::get('/customer_login', [FrontendController::class, 'customer_login'])->name('customer_login');

Route::get('/product/details/{slug}', [FrontendController::class, 'product_details'])->name('product.details');
Route::post('/product/review/{product_id}', [FrontendController::class, 'product_review'])->name('product.review');
Route::post('/get_size', [FrontendController::class, 'get_size']);
Route::post('/get_quantity', [FrontendController::class, 'get_quantity']);

Route::get('/about_us', [FrontendController::class, 'about_page'])->name('about_page');
Route::get('/shop', [FrontendController::class, 'shop_page'])->name('shop_page');
Route::get('/contact', [FrontendController::class, 'contact_page'])->name('contact_page');



// === Customer Register ===
Route::post('/customer/register', [CustRegCont::class, 'customer_register'])->name('customer.register');
Route::get('/customer/registered_email_verify/{token}', [CustRegCont::class, 'reg_email_verify'])->name('reg_email.verify');



// === Customer Login ===
Route::post('/customer/login', [CustLoginCont::class, 'customer_login'])->name('customer.login');
Route::get('/customer/logout', [CustLoginCont::class, 'customer_logout'])->name('customer.logout');

Route::get('/customer/lost_password', [CustLoginCont::class, 'lost_password'])->name('lost.pass');
Route::post('/customer/email_verify', [CustLoginCont::class, 'email_verify'])->name('email.verify');

Route::get('/customer/new_password/{token}', [CustLoginCont::class, 'new_password'])->name('new.pass');
Route::post('/customer/reset_password', [CustLoginCont::class, 'reset_password'])->name('reset.pass');



// === Customer ===
Route::get('/customer/profile', [CustomerCont::class, 'customer_profile'])->name('customer.profile');
Route::post('/customer/profile/update', [CustomerCont::class, 'cust_profile_update'])->name('cust_profile.update');
Route::post('/prof_get_city', [CustomerCont::class, 'prof_get_city']);
Route::post('/prof_get_code', [CustomerCont::class, 'prof_get_code']);
Route::get('/customer/order', [CustomerCont::class, 'customer_order'])->name('customer.order');
Route::get('/customer/wishlist', [CustomerCont::class, 'customer_wishlist'])->name('customer.wishlist');



// === Cart ===
Route::post('/cart', [CartCont::class, 'add_cart'])->name('cart.store');
Route::get('/cart/remove/{card_id}', [CartCont::class, 'remove_cart'])->name('cart.remove');
Route::get('/cart/remove_all', [CartCont::class, 'remove_all_cart'])->name('cart.remove_all');
Route::post('/wishlist/store', [CartCont::class, 'add_wishlist'])->name('wishlist.store');
Route::get('/wishlist/remove/{wish_id}', [CartCont::class, 'remove_wishlist'])->name('wishlist.remove');
Route::get('/wishlist/remove_all', [CartCont::class, 'remove_all_wishlist'])->name('wishlist.remove_all');
Route::get('/wishlist/remove_btn/{product_id}', [CartCont::class, 'remove_btn_wishlist'])->name('wishlist.remove.btn');
Route::get('/cart/store_update', [CartCont::class, 'cart_store_update'])->name('cart.store.update');
Route::post('/cart/store_updated', [CartCont::class, 'cart_updated'])->name('cart.updated');
Route::get('/cart_page/remove/{card_id}', [CartCont::class, 'remove_cart_page'])->name('cart.remove.page');



// === Coupon ===
Route::get('/coupon/add_coupon', [CouponCont::class, 'add_coupon'])->name('add.coupon');
Route::post('/coupon/add_coupon_type', [CouponCont::class, 'add_coupon_type'])->name('add.coupon_type');
Route::post('/coupon/store', [CouponCont::class, 'coupon_store'])->name('coupon.store');
Route::get('/coupon_type/edit/{ctype_id}', [CouponCont::class, 'coupon_type_edit'])->name('ctype.edit');
Route::post('/coupon_type/update', [CouponCont::class, 'coupon_type_update'])->name('ctype.update');
Route::get('/coupon_type/delete/{ctype_id}', [CouponCont::class, 'coupon_type_delete'])->name('ctype.delete');
Route::get('/coupon_list', [CouponCont::class, 'coupon_list'])->name('coupon_list');
Route::get('/coupon/soft_del/{coupon_id}', [CouponCont::class, 'coupon_soft_del'])->name('coupon.soft_del');
Route::get('/coupon/force_del/{coupon_id}', [CouponCont::class, 'coupon_force_del'])->name('coupon.force_del');
Route::get('/coupon/restore/{coupon_id}', [CouponCont::class, 'coupon_restore'])->name('coupon.restore');
Route::get('/coupon/edit/{coupon_id}', [CouponCont::class, 'coupon_edit'])->name('coupon.edit');
Route::post('/coupon/update', [CouponCont::class, 'coupon_update'])->name('coupon.update');



// === Checkout ===
Route::get('/checkout', [CheckoutCont::class, 'checkout'])->name('checkout');
Route::post('/checkout/billing_details', [CheckoutCont::class, 'billing_details'])->name('billing.store');
Route::post('/get_city', [CheckoutCont::class, 'get_city']);
Route::post('/get_code', [CheckoutCont::class, 'get_code']);
Route::get('/order_complete', [CheckoutCont::class, 'order_complete'])->name('order.complete');
Route::get('/order_failed', [CheckoutCont::class, 'order_failed'])->name('order.failed');



// Mail Check ===
Route::get('/mailable', function () {
    $order_id = session('order_id_inv');
    return new App\Mail\InvoiceMail($order_id);
});



// SSLCommerz ===
Route::get('/pay', [SslCommerzPaymentController::class, 'index'])->name('ssl.pay');
Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);
Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);



// Stripe ===
Route::controller(StripePaymentController::class)->group(function(){
    Route::get('stripe', 'stripe')->name('stripe');
    Route::post('stripe', 'stripePost')->name('stripe.post');
});





// ======================
// Backend
// ======================


// === Dashboard ===
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// ==== Users ====
Route::get('/user_list', [userController::class, 'user_list'])->name('user_list');
Route::get('/user/delete/{user_id}', [userController::class, 'user_del'])->name('user_del');
Route::get('/user/profile', [userController::class, 'profile'])->name('user.profile');
Route::post('/user/info/update', [userController::class, 'user_info_upd'])->name('user.info.update');
Route::post('/user/pass/update', [userController::class, 'user_pass_upd'])->name('user.pass.update');
Route::post('/user/pic/update', [userController::class, 'user_pic_upd'])->name('user.pic.update');

Route::get('/user/add_user', [userController::class, 'add_user'])->name('add.user');
Route::post('/user/insert_user', [userController::class, 'insert_user'])->name('insert.user');



// ==== Roles ====
Route::get('/permission_list', [RoleCont::class, 'perm_store'])->name('perm.store');
Route::post('/permission/group_insert', [RoleCont::class, 'perm_group_insert'])->name('perm_group.insert');
Route::get('/permission/group/delete/{group_id}', [RoleCont::class, 'perm_group_delete'])->name('perm_group.delete');

Route::post('/permission/insert', [RoleCont::class, 'perm_insert'])->name('perm.insert');
Route::get('/permission/edit/{group_id}', [RoleCont::class, 'perm_group_edit'])->name('perm.edit');
Route::get('/permission/delete/{perm_id}', [RoleCont::class, 'perm_delete'])->name('perm.delete');
Route::post('/permission/update', [RoleCont::class, 'perm_update'])->name('perm.update');

Route::get('/manage_roles', [RoleCont::class, 'role_store'])->name('role.store');
Route::post('/roles/insert', [RoleCont::class, 'insert_role'])->name('role.insert');
Route::get('/roles/delete/{role_id}', [RoleCont::class, 'delete_role'])->name('role.delete');
Route::get('/roles/edit/{role_id}', [RoleCont::class, 'edit_role'])->name('role.edit');
Route::post('/role/update', [RoleCont::class, 'role_update'])->name('role.update');

Route::post('/role/assign', [RoleCont::class, 'role_assign'])->name('role.assign');
Route::get('/roles/users', [RoleCont::class, 'users_role'])->name('role.users');
Route::get('/roles/users/edit_roles/{user_id}', [RoleCont::class, 'user_role_edit'])->name('user_role.edit');
Route::post('/roles/users/update_roles', [RoleCont::class, 'user_role_update'])->name('user_role.update');
Route::get('/roles/users/remove/{user_id}', [RoleCont::class, 'user_role_remove'])->name('user_role.remove');



// === Category ===
Route::get('/category_list', [cataController::class, 'cata_list'])->name('category_list');
Route::post('/category_update', [cataController::class, 'cata_upd'])->name('category_update');
Route::get('/category/delete/{cata_id}', [cataController::class, 'cata_del'])->name('category.delete');
Route::get('/category/restore/{cata_id}', [cataController::class, 'cata_restore'])->name('category.restore');
Route::get('/category/force_delete/{cata_id}', [cataController::class, 'cata_f_del'])->name('category.force_delete');
Route::get('/category/edit/{cata_id}', [cataController::class, 'cata_edit'])->name('category.edit');
Route::post('/category_info.update', [cataController::class, 'cata_info_upd'])->name('category_info.update');



// === Sub-Category ===
Route::get('/subcategory_list', [SubcateController::class, 'sub_cata_list'])->name('subcategory_list');
Route::post('/subcategory/add', [SubcateController::class, 'sub_cata_add'])->name('subcatagory.add');
Route::get('/subcategory/delete/{subcata_id}', [SubcateController::class, 'sub_cata_del'])->name('subcategory.delete');
Route::get('/subcategory/force_delete/{subcata_id}', [SubcateController::class, 'subcata_f_del'])->name('subcategory.force.delete');
Route::get('/subcategory/restore/{subcata_id}', [SubcateController::class, 'subcata_restore'])->name('subcategory.restore');
Route::get('/subcategory/edit/{subcata_id}', [SubcateController::class, 'subcata_edit'])->name('subcategory.edit');
Route::post('/subcategory/update', [SubcateController::class, 'subcata_upd'])->name('subcategory.update');



// === Product Controller===

// === Add Product ===
Route::get('/add_product', [ProductController::class, 'add_product'])->name('add.product');
Route::post('/get_subcata', [ProductController::class, 'get_subcata']);
Route::post('/product/store', [ProductController::class, 'product_store'])->name('product.store');
Route::get('/product_list', [ProductController::class, 'product_list'])->name('product_list');
Route::post('/product/get_cata_products', [ProductController::class, 'get_cata_products'])->name('product.cata_items');
Route::get('/product/clear_cata_selection', [ProductController::class, 'clear_cata_selection'])->name('clear.cata');

Route::post('/product/delete_checked', [ProductController::class, 'product_del_checked'])->name('delete.checked');
Route::post('/product/restore_checked', [ProductController::class, 'product_restore_checked'])->name('restore.checked');
Route::post('/product/force_delete_checked', [ProductController::class, 'product_fdel_checked'])->name('fdel.checked');


// === Variation ===
Route::get('/product/variation', [ProductController::class, 'product_variation'])->name('product.variation');
Route::post('/product/variation/add_color', [ProductController::class, 'add_color'])->name('add.color');
Route::get('/product/variation/delete_color/{color_id}', [ProductController::class, 'del_color'])->name('color.delete');
Route::get('/product/variation/edit_color/{color_id}', [ProductController::class, 'edit_color'])->name('color.edit');
Route::post('/product/variation/update_color/', [ProductController::class, 'update_color'])->name('color.update');
Route::post('/product/variation/add_size', [ProductController::class, 'add_size'])->name('add.size');


// === Size ===
Route::get('/product/variation/delete_size/{size_id}', [ProductController::class, 'del_size'])->name('size.delete');
Route::get('/product/variation/edit_size/{size_id}', [ProductController::class, 'edit_size'])->name('size.edit');
Route::post('/product/variation/update_size', [ProductController::class, 'update_size'])->name('size.update');


// === Measure/Size-Type ===
Route::post('/product/add_size-type', [ProductController::class, 'add_size_type'])->name('add.size_type');
Route::get('/product/variation/delete_size_type/{measure_id}', [ProductController::class, 'delete_measure'])->name('measure.delete');
Route::get('/product/variation/edit_size_type/{measure_id}', [ProductController::class, 'edit_measure'])->name('measure.edit');
Route::post('/product/variation/update_size_type', [ProductController::class, 'update_measure'])->name('measure.update');


// === Length ===
Route::post('/product/variation/add_length', [ProductController::class, 'add_length'])->name('add.length');
Route::get('/product/variation/delete_length/{length_id}', [ProductController::class, 'del_length'])->name('length.delete');
Route::get('/product/variation/edit_length/{length_id}', [ProductController::class, 'edit_length'])->name('length.edit');
Route::post('/product/variation/update_length', [ProductController::class, 'update_length'])->name('length.update');


// === Product Delete ===
Route::get('/product/delete_product/{product_id}', [ProductController::class, 'del_product'])->name('product.delete');
Route::get('/product/force_delete_product/{product_id}', [ProductController::class, 'force_del_product'])->name('product.force_delete');
Route::get('/product/product_restore/{product_id}', [ProductController::class, 'product_restore'])->name('product.restore');
Route::get('/product/edit/{product_id}', [ProductController::class, 'edit_product'])->name('product.edit');
Route::post('/product/update', [ProductController::class, 'update_product'])->name('product.update');


// === Inventory ===
Route::get('/product/inventory/{product_id}', [ProductController::class, 'product_inventory'])->name('product.inventory');
Route::post('/product/add_inventory', [ProductController::class, 'add_inventory'])->name('add.inventory');
Route::get('/product/delete_inventory/{inv_id}', [ProductController::class, 'delete_inventory'])->name('inventory.delete');
Route::get('/product/force_delete_inventory/{inv_id}', [ProductController::class, 'force_delete_inventory'])->name('inv_force.delete');
Route::get('/product/restore_inventory/{inv_id}', [ProductController::class, 'restore_inventory'])->name('inv.restore');
Route::get('/product/edit_inventory/{inv_id}', [ProductController::class, 'edit_inventory'])->name('inv.edit');
Route::post('/product/update_inventory', [ProductController::class, 'update_inventory'])->name('inv.update');
Route::get('/product/repeat_inventory/{inv_id}', [ProductController::class, 'repeat_inventory'])->name('repeat.inv');


// === Charges ===
Route::get('/product/charges', [ChargesCont::class, 'charges_store'])->name('charge.delivery');
Route::post('/product/charges/add_location', [ChargesCont::class, 'add_location'])->name('add.location');
Route::get('/product/delete_delivery_location/{charge_id}', [ChargesCont::class, 'delete_location'])->name('delete.location');
Route::get('/product/edit_delivery_location/{charge_id}', [ChargesCont::class, 'edit_location'])->name('edit.location');
Route::post('/product/update_charges', [ChargesCont::class, 'charges_update'])->name('update.charge');


// === Order ===
Route::get('/order_list', [OrderCont::class, 'order_list'])->name('order_list');
Route::post('/order_list/order_status_update', [OrderCont::class, 'order_status_update'])->name('order_status.update');


