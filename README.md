# Laravel - Onion architecture template

Configuration steps:

1. Replace `api.php` and `web.php` route files with the files in this repo.

    Each module must have `api.php` and `web.php` in `Presentation/routes` directory
2. Add following code to `boot()` method of `AppServiceProvider.php`:
```php
// Register view namespaces
foreach (scandir($path = app_path('Modules')) as $moduleDir) {
    View::addNamespace($moduleDir, "{$path}/{$moduleDir}/Presentation/views");
}
```

Each module manages views in `Presentation/views` directory under *Module folder name* namespace. (e.g. `view('Welcome::index')`)

3. Add `DependencyInjectionServiceProvider.php` file, and register the provider in `app.php` in `config` directory

4. Additionally, add this code before the last line in `Kernel.php` in `app/Console` directory:

   ```php
   foreach (scandir($path = app_path('Modules')) as $dir) {
       if (file_exists($folder_path = "{$path}/{$dir}/Presentation/Commands")) {
           $this->load($folder_path);
       }
   }
   ```

5. Refer to Welcome module for default structure

