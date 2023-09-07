<p align="center"><a href="https://aoe-elo.com/" target="_blank"><img src="https://media.githubusercontent.com/media/aoe-elo/aoe-elo-backend/main/assets/logo-light-300.png" width="150" alt="Aoe-Elo Logo"></a></p>

# AoE Tournament Elo (Backend)

🌐 Hosted here: <https://aoe-elo.com> (still the old backend)\
🗨 Discord: <https://discord.gg/hZzheB2kVE>

## Tech Stack

Backend (here):

- PHP 8.2
- SQLite database
- Hosted on root server with Docker(?)

[Frontend](https://github.com/aoe-elo/aoe-elo-frontend):

- Svelte(Kit)
- Tailwind CSS

## Development

You need both `node.js` (for frontend development) and `php` + `composer` (for
backend development). The installation instructions for the frontend you will find in the [frontend repository](https://github.com/aoe-elo/aoe-elo-frontend).

### Installing language tooling

#### Windows

Utilizing [`scoop`](https://scoop.sh/) is probably the easiest here:

- Install [`scoop`](https://scoop.sh/)

- open PowerShell ( `Win + R` -> type in `powershell` )

- run `scoop install SQLite,git-crypt,php,composer,hurl,fnm,just,curl`

- add `fnm` to your `powershell` profile:
  <https://github.com/Schniz/fnm#powershell>

- navigate to the repository root

- run `fnm install` to install the node.js version from `.node-version`

### Setup php.ini

Make sure to have the following extensions enabled in your `php.ini` and set the
correct path to the `curl-ca-bundle.crt` (installed with `curl`) file:

```ini
memory_limit = 256M

extension=intl
extension=curl
extension=fileinfo
extension=mbstring
extension=openssl
extension=pdo_sqlite
extension=sodium

; development only
;extension=pdo_mysql
;extension=sodium

[curl]
; A default value for the CURLOPT_CAINFO option. This is required to be an
; absolute path.
curl.cainfo = "<scoop_directory>\apps\curl\current\bin\curl-ca-bundle.crt"

[openssl]
; The location of a Certificate Authority (CA) file on the local filesystem
; to use when verifying the identity of SSL/TLS peers. Most users should
; not specify a value for this directive as PHP will attempt to use the
; OS-managed cert stores in its absence. If specified, this value may still
; be overridden on a per-stream basis via the "cafile" SSL stream context
; option.
openssl.cafile="<scoop_directory>\apps\curl\current\bin\curl-ca-bundle.crt"
```

or copy the `php.ini` from `/php.ini-development` to your `php` installation and
set `openssl.cafile` and `curl.cainfo` to the correct path.

### Installing dependencies

Run `composer install` and `npm install`.

### Setup database

**Note**: If you have gotten a `git-crypt` key from the maintainers, you can
just run `git-crypt unlock <path-to-key>`. And then regenerate the backend key
with Laravel in the env file - meaning you can skip to `Running` for now.

> **Note**: You should have installed SQLite (e.g. via `scoop install SQLite`)
> by now.

Run `php artisan migrate --seed`.

> **Note**: `--seed` is the same as running `php artisan db:seed` afterwards to
> import legacy data into the `legacy_` tables.

### Setup .env

Rename the `.env.example` to `.env`. If `composer`s post install action didn't
work. Change the settings to fit your needs.

### Dev-Documentation

We use `just` as our task runner. Run `just -l` to see all available commands.

- **just fmt**: Format the whole project
- **just fix**: Fix errors and warnings the backend part of the project
- **just blint**: Lint the backend part of the project
- **just flint**: Lint the `frontend` part of the project
- **just btest**: Test the `backend` part of the project
- **just ftest**: Test the `frontend` part of the project

Before committing, make sure to run `just fmt` and depending on what you have
changed:

- **Backend**: `just btest`

- **Frontend**: `just flint` **and** `just ftest` or

You can also check the [`Development docs`](/docs/dev/) and
[Dev-FAQ](/docs/dev/FAQ.md) to make it easier to get started.

### Running

First generate the app key with: `php artisan key:generate`. If `composer`s post
install action didn't work.

Then run `php artisan serve`, `php artisan inertia:start-ssr` and then
`npm run dev`. Go to `http://127.0.0.1:8000` in your web browser.

And here you go, happy coding! :)

#### Production

Run:

- `php artisan route:cache`
- `php artisan config:cache`

### Debugging

You can debug inside the backend using `dd()` or chain `->dd()`.

You can also use the `telescope` UI that is exposed during `local` development
under `http://127.0.0.1:8000/telescope`.

## License

The aoe-elo backend is open-sourced software licensed under the
[GNU Affero General Public License v3.0 or later](./LICENSE).
