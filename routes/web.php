use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

// ---Ruta para usuarios no autenticados---
Route::middleware('guest') ->group(function () {
    //Registro
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    //Login
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

// ---Ruta para usuarios autenticados---
Route::middleware('auth')->group(function () {
    // ---Ruta para logout
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    // ---Ruta para probar que se inició sesión
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// ---Redirección---
Route::get('/', function () {
    return view('welcome');
});
