# Laravel - Onion architecture template

Configuration steps:

1. Replace `api.php` and `web.php` route files with the files in this repo.

    Each module must have `api.php` and `web.php` in **your** `Presentation/routes` directory

2. Add these files to **your** `app/Http/Middleware`:
    - `app/Http/Middleware/HoldMessageBus.php`
    - `app/Http/Middleware/ReleaseMessageBus.php`

    Then, register the middlewares to `$middleware` protected variable your of `app/Http/Kernel.php`

3. Modify `report()` method of **your** `app/Exceptions/Handler.php`:
    ```php
    public function report(Throwable $exception)
    {
        MessageBus::resetMessages(); // add this line
        parent::report($exception);
    }
    ```

3. Add following code to `boot()` method of **your** `app/Providers/AppServiceProvider.php`:

    ```php
    // Register view namespaces
    foreach (scandir($path = app_path('Modules')) as $moduleDir) {
        View::addNamespace($moduleDir, "{$path}/{$moduleDir}/Presentation/views");
    }
    ```

    Each module manages views in **your** `Presentation/views` directory under *Module folder name* namespace. (e.g. `view('Welcome::index')`)

4. Add these method definitions in **your** `app/Providers/EventServiceProvider.php`:

   ```php
   public function shouldDiscoverEvents()
   {
       return true;
   }
   
   protected function discoverEventsWithin()
   {
       $discovered_directories = [];
       foreach (scandir($path = app_path('Modules')) as $dir) {
           if (file_exists($folder_path = "{$path}/{$dir}/Core/Application/EventListener")) {
               $discovered_directories[] = $folder_path;
           }
       }
   
       return array_merge(parent::discoverEventsWithin(), $discovered_directories);
   }
   ```

5. Add following provider files:

    - `app/Providers/DependencyInjectionServiceProvider.php`
    - `app/Providers/MessagingServiceProvider.php`

    and register the provider in `app.php` in `config` directory

6. Additionally, add this code before the last line in `Kernel.php` in `app/Console` directory:

    ```php
    foreach (scandir($path = app_path('Modules')) as $dir) {
        if (file_exists($folder_path = "{$path}/{$dir}/Presentation/Commands")) {
            $this->load($folder_path);
        }
    }
    ```



Refer to Welcome module for default structure

