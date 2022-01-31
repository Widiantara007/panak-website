<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProjectBatchController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\EdunakArticleController;
use App\Http\Controllers\EdunakCategoryController;
use App\Http\Controllers\EdunakController;
use App\Http\Controllers\InvestnakController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\PasarnakController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectOwnerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectTypeController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WithdrawalsController;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\Auth;
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

Route::get('/',[LandingController::class,'index'])->name('landing');


Route::prefix('bisnak')->group(function(){
    Route::get('/', [InvestnakController::class, 'index'])->name('investnak');
    Route::get('/{id}', [InvestnakController::class, 'show'])->name('investnak.show');
});

Route::prefix('pasarnak')->group(function(){
    Route::get('/', [PasarnakController::class, 'index'])->name('pasarnak');
    Route::get('/{id}', [PasarnakController::class, 'show'])->name('pasarnak.show');
});

Route::prefix('edunak')->group(function(){
    Route::get('/', [EdunakController::class, 'index'])->name('edunak');
    Route::get('/{slug}', [EdunakController::class, 'show'])->name('edunak.show');
});


Route::middleware(['auth','role:Admin'])->prefix('admin')->group(function() {
    Route::get('/', [AdminController::class, 'index'])->name('admin');
    //bisnak
    Route::resource('project', ProjectController::class);

    Route::patch('project/{project_id}/batch/{batch_id}/status/update', [ProjectBatchController::class, 'updateStatus'])->name('project.batch.status.update');
    Route::patch('project/{project_id}/batch/{batch_id}/pay_return', [ProjectBatchController::class, 'payReturn'])->name('project.batch.payReturn');
    Route::resource('project.batch', ProjectBatchController::class);
    Route::resource('project-owner', ProjectOwnerController::class);
    Route::resource('project-type', ProjectTypeController::class);
    Route::patch('withdrawals/acc/{id}', [WithdrawalsController::class,'accept'])->name('withdraw.acc') ;
    Route::patch('withdrawals/reject/{id}', [WithdrawalsController::class,'reject'])->name('withdraw.reject') ;
    Route::resource('withdrawals', WithdrawalsController::class);
    //pasarnak
    Route::get('order/{order_id}/{order_detail_id}/destroy', [OrderController::class, 'destroy_order_detail'])->name('order_detail.destroy');
    Route::patch('order/{order_id}/status/update', [OrderController::class, 'updateStatus'])->name('order.update.status');
    Route::resource('order', OrderController::class);
    Route::resource('product', ProductController::class);

    //edunak
    Route::resource('edunak-article', EdunakArticleController::class);
    Route::resource('edunak-category',EdunakCategoryController::class);

    //manajemen
    Route::resource('user', UserController::class);
    Route::patch('/user_verification/reject', [UserController::class, 'userVerificationReject'])->name('user.verification.reject');
    Route::patch('/user_verification/accept', [UserController::class, 'userVerificationAccept'])->name('user.verification.accept');
    Route::get('/user_verification/{user_id}', [UserController::class, 'userVerificationModalBody'])->name('user.verification.modal-body');
    Route::get('/user_verification', [UserController::class, 'userVerificationIndex'])->name('user.verification.index');

    Route::resource('bank', BankController::class);
    Route::resource('slider', SliderController::class);
    Route::get('log',[LogController::class,'index'])->name('log.index');

});


Auth::routes();
/// arahkan ke link ini ketika user klik "login with google"
Route::get('auth/google', [App\Http\Controllers\Auth\LoginController::class, 'google'])->name('auth.google');
/// siapkan route untuk menampung callback dari google
Route::get('auth/google/callback', [App\Http\Controllers\Auth\LoginController::class, 'google_callback']);


///
Route::post('region',[AddressController::class, 'get_data'])->name('region');

Route::middleware(['auth', 'role:User|Admin'])->group(function(){
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    //Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/store', [CartController::class, 'store'])->name('cart.store');
    Route::get('/cart/{id}/destroy', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/process', [CartController::class, 'checkoutProcess'])->name('checkout.process');

    /// Profile user
    Route::get('/profile',[ProfileController::class,'index'])->name('profile');
    Route::patch('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::patch('/profile/changePassword', [ProfileController::class, 'changePassword'])->name('profile.changePassword');
    Route::patch('/profile/changePhotoProfile', [ProfileController::class, 'changePhotoProfile'])->name('profile.changePhotoProfile');
    Route::patch('/profile/changeDocument', [ProfileController::class, 'changeDocument'])->name('profile.changeDocument');
    Route::patch('/profile/changeNPWP', [ProfileController::class, 'changeNPWP'])->name('profile.changeNPWP');
    Route::post('/profile/storeBank', [ProfileController::class, 'storeBank'])->name('profile.storeBank');
    Route::get('/profile/portofolio', [ProfileController::class, 'portofolio'])->name('profile.portofolio');
    Route::get('/profile/portofolio/showCBC/{id}', [CertificateController::class, 'showCBC'])->name('profile.portofolio.showCBC');
    Route::get('/profile/portofolio/showCertificate/{id}', [CertificateController::class, 'showCertificate'])->name('profile.portofolio.showCertificate');
    Route::get('/profile/transaction', [ProfileController::class, 'transaction'])->name('profile.transaction');
    Route::get('/profile/transaction/modal/{id}', [ProfileController::class, 'transactionModalBody'])->name('profile.transaction.modal');
    Route::get('/profile/wallet', [ProfileController::class, 'wallet'])->name('profile.wallet');
    
    Route::get('/profile/notification', [ProfileController::class, 'notification'])->name('profile.notification');
    
    Route::post('/markNotification', [ProfileController::class, 'markNotification'])->name('markNotification');
    
    Route::patch('order/{order_id}/status/update/done', [OrderController::class, 'updateDone'])->name('order.update.done');
    Route::post('/profile/withdraw/store', [ProfileController::class, 'withdrawStore'])->name('profile.withdraw.store');

    //Address
    Route::post('/user/storeAddress', [UserController::class, 'storeAddress'])->name('user.storeAddress');

    //Payment
    Route::post('/pay/bisnak/{project_id}/{project_batch_id}', [PaymentController::class, 'payInvestnak'])->name('pay.investnak')->middleware('document.verified');
    Route::post('/pay/pasarnak', [PaymentController::class, 'payPasarnak'])->name('pay.pasarnak');
    Route::post('/pay/withdrawal/{withdrawal_id}', [PaymentController::class, 'payWithdrawal'])->name('pay.withdrawal');
    Route::post('/pay/topup', [PaymentController::class, 'payTopup'])->name('pay.topup');

});

Route::get('/about-us', function () {
    return view('aboutus');
})->name('about-us');
Route::get('/jadi-pec', function () {
    return view('jadipec');
})->name('jadi-pec');
Route::get('/migo-product', function () {
    return view('migoproduct');
})->name('migo-product');
Route::get('/emisertif', [CertificateController::class, 'emisertif'])->name('emisertif');
Route::get('/emisertif/generate', [CertificateController::class, 'generate']);
Route::get('/sertifikat', function () {
    return view('sertifikat');
})->name('sertifikat');