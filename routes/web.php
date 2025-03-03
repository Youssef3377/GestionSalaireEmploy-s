<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PayementController;
use Illuminate\Support\Facades\Route;

/*Route::get('/', function () {
    return view('welcome');
});*/
//Route de connexion
Route::get('/',[AuthController::class,'login'])->name('login');
Route::post('/',[AuthController::class,'handleLogin'])->name('handleLogin');
Route::get('/validate-account/{email}',[AdminController::class, 'defineAccess']);
Route::post('/validate-account/{email}',[AdminController::class, 'submitDefineAccess'])->name('submitDefineAccess');
//route securisée


Route::middleware('auth')->group(function(){
 // Les  routes a l'interieur de groupe sont protégées par le middleware 'auth'

    Route::get('/dashbord',[AppController::class,'index'])->name('dashbord');

    Route::prefix('employer')->group(function(){
        Route::get('/index',[EmployerController::class,'index'])->name('employer.index');

        Route::get('/create',[EmployerController::class,'create'])->name('employer.create');

        Route::post('/create',[EmployerController::class,'store'])->name('employer.store');

        Route::get('/edit',[EmployerController::class,'edit'])->name('employer.edit');

        Route::resource('employer', EmployerController::class);
        });

        Route::prefix('departement')->group(function(){
            Route::get('/',[DepartementController::class,'index'])->name('departement.index');

            Route::get('/create',[DepartementController::class,'create'])->name('departement.create');

            Route::post('/create',[DepartementController::class,'store'])->name('departement.store');

            Route::get('/edit/{departement}',[DepartementController::class,'edit'])->name('departement.edit');
            Route::put('/update/{departement}',[DepartementController::class,'update'])->name('departement.update');
            Route::resource('departement', DepartementController::class);



            });
            Route::prefix('configuration')->group(function(){
                Route::get('/',[ConfigController::class,'index'])->name('configuration.index');

                Route::get('/create',[ConfigController::class,'create'])->name('configuration.create');

                Route::post('/create',[ConfigController::class,'store'])->name('configuration.store');

                Route::get('/edit/{configuration}',[ConfigController::class, 'edit'])->name('configuration.edit');

                Route::put('/update/{configuration}',[ConfigController::class, 'update'])->name('configuration.update');

                Route::resource('configuration', ConfigController::class);
                });


                Route::prefix('administrateur')->group(function(){

                    Route::get('/',[AdminController::class, 'index'])->name('administrateur.index');
                    Route::get('/create',[AdminController::class, 'create'])->name('administrateur.create');
                    Route::post('/create',[AdminController::class, 'store'])->name('administrateur.store');
                    Route::put('/update/{administrateur}',[AdminController::class, 'update'])->name('administrateur.update');
                    Route::get('/edit/{administrateur}',[AdminController::class, 'edit'])->name('administrateur.edit');

                   // Route::resource('administrateur', AdminController::class);
                   //Route::get('/destroy/{administrateur}', [AdminController::class ,'destroy'])->name ('administrateur.destroy');

                   Route::delete('/administrateur/delete/{administrateur}', [AdminController::class, 'destroy'])->name('administrateur.destroy');
                   // Route::delete('/delete/{administrateur}', [AdminController::class, 'destroy'])->name('administrateur.destroy');
                });


                Route::prefix('payement')->group(function(){
                    Route::get('/',[PayementController::class,'index'])->name('payement');
                });

});
