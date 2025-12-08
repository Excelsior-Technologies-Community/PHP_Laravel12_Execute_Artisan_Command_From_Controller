# ⚡ Laravel 12 – Run Artisan Command from Controller  
![Laravel](https://img.shields.io/badge/Laravel-12-orange)
![PHP](https://img.shields.io/badge/PHP-8.2-blue)
![Artisan](https://img.shields.io/badge/Artisan-Commands-green)

This guide explains how to execute **Artisan commands directly from a controller** in Laravel 12, using a simple example of running database migrations.

(Content source: your uploaded DOCX file)

---

# ⭐ Overview  
With this method, you can run **any Artisan command** (migration, storage link, cache clear, custom commands, etc.) using controller actions.

Common use cases include:  
- Running migrations  
- Clearing cache  
- Creating storage link  
- Running queue workers  
- Triggering custom Artisan commands  

---

# 🧱 Step 1 — Install Laravel 12  
```
composer create-project laravel/laravel your-folder-name
```

---

# 🛠 Step 2 — Create Controller  
Create a controller named **ItemController**:

```
php artisan make:controller ItemController
```

### Example Code  
```php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Run the artisan command from the controller
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Running the artisan migrate command
        Artisan::call("migrate");

        // Returning a response after command execution
        return response()->json([
            "message" => "Artisan migrate command executed successfully!",
            "output"  => Artisan::output() // Output of the Artisan command
        ]);
    }
}
```

---

# 🚏 Step 3 — Add Route to Execute Artisan Command  
Add this route in **routes/web.php**:

```php
use App\Http\Controllers\ItemController;

Route::get('/run-migrate', [ItemController::class, 'index']);
```

This will run the **`php artisan migrate`** command when the route is visited.

---

# ▶ Step 4 — Run the Application  
Start the Laravel server:

```
php artisan serve
```

Now open the URL to trigger the command:

```
http://localhost:8000/run-migrate
```

You will receive a JSON response containing:

- A success message  
- The output of the executed command  
<img width="731" height="174" alt="image" src="https://github.com/user-attachments/assets/eb52af80-bf39-4a81-a5c5-4c2041fb0d24" />
