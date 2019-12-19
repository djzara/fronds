## What are Actions?

Actions are anything in Fronds that manipulate content. Actions are just Laravel resource
controllers, they're just simple CRUD operations.
They live in the API space as they are only for interacting with content in that regard.

For example:

```php
php artisan make:controller api/v1/Action/PageActionController --api
```

For convenience, there is an artisan command to quickly generate controllers of this fashion, and
already configured in the Fronds context

```php
php artisan fronds:action ActionName
```

ActionController is added to the end automatically, as per the convention this creates. Once
created, you can customize these however you see fit.