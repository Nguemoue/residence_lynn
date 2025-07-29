<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\{
    HomeController,
    CategoryController,
    ProductController,
    CartController,
    CheckoutController,
    OrderController,
    BlogController,
    FaqController,
    NewsletterController,
    ContactController,
};

/*
|--------------------------------------------------------------------------
| Web Routes – Frontend
|--------------------------------------------------------------------------
| Toutes retournent des vues ou redirigent vers celles-ci.
| Les routes API (JSON) iraient classiquement dans routes/api.php.
*/

/* Home */
Route::get('/', HomeController::class)->name('home');

/* Catégories & Produits -------------------------------------------------- */
Route::prefix('categories')->group(function () {
    Route::get('/',              [CategoryController::class, 'index'])->name('categories.index');
    Route::get('{category:slug}',[CategoryController::class, 'show' ])->name('categories.show');
});

Route::prefix('products')->group(function () {
    Route::get('/',             [ProductController::class, 'index'])->name('products.index');
    Route::get('{product:slug}',[ProductController::class, 'show' ])->name('products.show');
});

/* Panier --------------------------------------------------------------- */
Route::prefix('cart')->controller(CartController::class)->group(function () {
    Route::get('/',   'show')->name('cart.show');
});

/* Passage en caisse ---------------------------------------------------- */
Route::middleware([
    \App\Http\Middleware\InjectValidationErrorsIntoFlasherMiddleware::class
])->group(function (){
    Route::get('checkout',  [CheckoutController::class, 'show' ])->name('checkout.show');
    Route::post('checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('checkout/actions/success',\App\Http\Controllers\Frontend\CheckoutActionSuccessController::class)->name('checkout.success');
    Route::get('checkout/actions/cancel',\App\Http\Controllers\Frontend\CheckoutActionCancelController::class)->name('checkout.cancel');

});

/* Suivi de commande (UUID public) ------------------------------------- */
Route::get('orders/{order:uuid}', [OrderController::class, 'show'])
    ->name('orders.track');

/* Telechargement du PDF*/
Route::get('/orders/{order:uuid}/pdf', \App\Http\Controllers\Frontend\DownloadOrderPdfController::class)->name('orders.pdf');

/* Blog ----------------------------------------------------------------- */
Route::prefix('blog')->group(function () {
    Route::get('/',          [BlogController::class, 'index'])->name('blog.index');
    Route::get('{post:slug}',[BlogController::class, 'show' ])->name('blog.show');
});

/* FAQ ------------------------------------------------------------------ */
Route::get('faq', FaqController::class)->name('faq.index');

/* Newsletter ----------------------------------------------------------- */
Route::post('newsletter', [NewsletterController::class, 'store'])->name('newsletter.store');

/* Contact -------------------------------------------------------------- */
Route::get('contact',  [ContactController::class, 'create'])->name('contact.create');
Route::post('contact', [ContactController::class, 'store' ])->name('contact.store');

/* About ------------------------------------------------------------*/
Route::get("about",\App\Http\Controllers\Frontend\AboutController::class)->name('about.show');

/* -----------------------------------------------------------------
 | Suivi de commande
 |------------------------------------------------------------------
 |  - GET  /suivi-commande       => formulaire de recherche
 |  - POST /suivi-commande       => soumet le n° de commande
 |  - GET  /suivi-commande/{order:uuid}
 |                              => détail et avancement
 */
Route::controller(\App\Http\Controllers\Frontend\OrderTrackingController::class)->prefix('suivi-commande')->group(function () {
    Route::get('/',       'index')->name('orders.track.index');   // formulaire
    Route::post('/',      'search')->name('orders.track.search'); // traite le n°
    Route::get('/{order:uuid}/track', 'show')->name('orders.track.show');     // détail
});


Route::post('/webhooks/payment/{driver}', \App\Http\Controllers\PaymentWebhookController::class)->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

Route::get("test",\App\Http\Controllers\TestController::class);
Route::get("mail",function (){
    return new \App\Mail\OrderPaidMail(order: \App\Models\Order::first());
});
