# Frontend development

## About `Inertia`

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

## Code map

### [`/resources/css`](/resources/css/)

Collected CSS files from the legacy backend for future use.

### [`/resources/js/`](/resources/js/)

#### [`Pages`](/resources/js/Pages/)

Directories containing `*.svelte` files/components that are used solely on the
main pages

#### [`Shared/`](/resources/js/Shared/)

Shared Svelte-Components

#### [`Shared/Layouts`](/resources/js/Shared/Layouts)

Layouts that are being used within the web-app

#### [`Shared/lib`](/resources/js/Shared/lib)

Legacy JS-code that might be useful rebuilding the web-app in Svelte

#### [`app.js`](/resources/js/app.js)

`Inertia`-App-Entrypoint

#### [`bootstrap.js`](/resources/js/bootstrap.js)

Bootstrapping our frontend application.

We'll load the axios HTTP library which allows us to easily issue requests to
our Laravel back-end. This library automatically handles sending the CSRF token
as a header based on the value of the "XSRF" token cookie.

#### [`ssr.js`](/resources/js/ssr.js)

Inertia-SSR server, run with `php artisan inertia:start-ssr`.

#### [`ziggy.js`](/resources/js/ziggy.js)

> Ziggy provides a JavaScript `route()` helper function that works like
> Laravel's, making it easy to use your Laravel named routes in JavaScript.

### `/resources/views`

#### [`app.blade.php`](/resources/views/app.blade.php)

PHP-View/Page embedding the `inertia` glue code.
