# PHP_Laravel12_Execute_Artisan_Command_From_Controller

This guide explains how to run an Artisan command directly from a controller in Laravel 12.  
The example uses the **migrate** command, but you can run any Artisan command.

---

## Step 1: Install Laravel 12

Create a fresh Laravel 12 project using the terminal:

```
composer create-project laravel/laravel your-folder-name
```

This will generate a new Laravel 12 application with all default configurations.

---

## Step 2: Add Controller

Create a new controller named **ItemController**:

```
php artisan make:controller ItemController
```

After running this command, open the file:

```
app/Http/Controllers/ItemController.php
```

And paste the following code:

```php
<?php

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

## Explanation  
- `Artisan::call('migrate')` runs Laravel migration command from inside the controller.  
- You can replace `"migrate"` with any artisan command like:  
  - `cache:clear`  
  - `config:cache`  
  - `route:list`  
  - custom commands  
- `Artisan::output()` returns the terminal output in JSON response.

---

## Step 3: Add Route

Add the route inside `routes/web.php`:

```php
use App\Http\Controllers\ItemController;

Route::get('/run-migrate', [ItemController::class, 'index']);
```

This route will trigger the Artisan command when accessed through the browser.

---

## Step 4: Run Laravel Application

Start the development server:

```
php artisan serve
```

Now open the URL in your browser:

```
http://localhost:8000/run-migrate
```


You will receive a JSON response containing:

- A success message  
- The output of the executed command  
<img width="731" height="174" alt="image" src="https://github.com/user-attachments/assets/eb52af80-bf39-4a81-a5c5-4c2041fb0d24" />
