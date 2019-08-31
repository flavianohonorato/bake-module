
# Custom Laravel skeleton module generator

How to use:

```
php artisan bake:module [ModuleName]
```

Run name on plural and uppercase, for example: Posts

```
php artisan bake:module Posts
```
Add your module service provider to ```config/app.php```
```
Modules\Posts\Providers\PostServiceProvider::class,
```
This command generates the following structure with its respective files.
```
Facades
Http/Controllers
Interfaces
Models
Providers
Routes
Services
```
