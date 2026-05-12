use App\Http\Controllers\StudentLookupController;
 
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/students/{id}', [StudentLookupController::class, 'lookup']);
});