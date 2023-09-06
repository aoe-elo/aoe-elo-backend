# Backend development

> Check out a general overview here
> [Directory Structure](./backend-structure.md). The following document assumes
> you have knowledge about the general Laravel-framework structure.

## Code map

### [`app/Http/Controllers`](/app/Http/Controllers/)

Most `route` development happens here, see in the
[official docs](https://laravel.com/docs/10.x/controllers).

### [`app/legacy`](/app/legacy/)

Legacy code from the old PHP-Backend you will find here. We will migrate it
piece by piece.

### [`app/Repositories`](/app/Repositories/)

We apply the
[Repository pattern](https://web.archive.org/web/20220808222425/https://www.twilio.com/blog/repository-pattern-in-laravel-application).
This means, that we wrap the `Eloquent models` with a `repository Interface`
(for easy mocking/testing) in [`app\Interfaces`](/app/Interfaces/), then we
implement that interface for the repository.

Afterwards we register both in
[`app\Providers\RepositoryServiceProvider.php`](/app/Providers/RepositoryServiceProvider.php#L20).

Then we use the `repository interface` in the controllers' constructor, e.g. for
the
[`TournamentRepositoryInterface`](/app/Interfaces/TournamentRepositoryInterface.php)
we add to the
[`TournamentController`](/app/Http/Controllers/Web/TournamentController.php):

```php
    private TournamentRepositoryInterface $tournamentRepository;

    public function __construct(TournamentRepositoryInterface $tournamentRepository)
    {
        $this->tournamentRepository = $tournamentRepository;
    }
```

### [`app/Models`](/app/Models/)

Generated models to be used with the SQLite database can be found here.

> The `Legacy` subdirectory contains models to be used with the `legacy_`
> tables.

### [`routes/`](/routes/)

#### [`routes/api.php`](/routes/api.php)

Contains our public and internal (authenticated) API endpoints

#### [`routes/web.php`](/routes/web.php)

Contains endpoints to be used with `inertia::render` or corresponding
controllers that return `intertia` rendered pages. These routes exchange data
with the frontend.

> At its core, Inertia is essentially a client-side routing library. It allows
> you to make page visits without forcing a full page reload. This is done using
> the <Link> component, a light-weight wrapper around a normal anchor link. When
> you click an Inertia link, Inertia intercepts the click and makes the visit
> via XHR instead. You can even make these visits programmatically in JavaScript
> using router.visit().

> When Inertia makes an XHR visit, the server detects that it's an Inertia visit
> and, instead of returning a full HTML response, it returns a JSON response
> with the JavaScript page component name and data (props). Inertia then
> dynamically swaps out the previous page component with the new page component
> and updates the browser's history state. -
> [Source](https://inertiajs.com/how-it-works)
