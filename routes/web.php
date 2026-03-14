<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ArticleController;

Route::get('/', [ArticleController::class, 'index'])->name('home');
Route::get('/category/{slug}', [ArticleController::class, 'category'])->name('category.show');
Route::get('/articles/{slug}', [ArticleController::class, 'show'])->name('articles.show');
Route::get('/search', [ArticleController::class, 'search'])->name('search');
Route::get('/{slug}', [\App\Http\Controllers\PageController::class, 'show'])->name('page.show');

Route::get('/init-admin', function () {
    try {
        // Ensure the Admin role exists (using Spatie)
        $adminRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Admin']);
        
        // Create or update the Admin User
        $user = \App\Models\User::updateOrCreate(
            ['email' => 'admin@domain.com'],
            [
                'name' => 'Admin User',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
            ]
        );

        // Assign the role if not already assigned
        if (!$user->hasRole('Admin')) {
            $user->assignRole($adminRole);
        }

        return "Admin user initialized successfully!<br>Email: admin@domain.com<br>Password: password<br><br><b>Please DELETE this route from routes/web.php after use for security!</b>";
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});

