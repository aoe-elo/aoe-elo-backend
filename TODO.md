# TODO

## Best practices

- <https://github.com/alexeymezenin/laravel-best-practices>

## Next steps

- [ ] implement Elo calculation
- [ ] implement `review` system and `ada` funtionality
- [ ] implement API Endpoints for `Players`, `Teams`, `Sets`, `Tournaments`,
      `Search`, and `Leaderboads`
  - [ ] <https://laravel.com/docs/10.x/eloquent-resources>
- [ ] check <https://github.com/nette/utils> for functionality

### Archived

- [x] implement metadata for ArdPlayer
- [x] implement metadata for player/team import
  - [x] check how to get all metadata for an `ArdPlayer`
- [x] move `Player::aliases` to `Player::metadata->alias`
- [x] move `Player::other_socials` to `Player::metadata->socials`

### Permissions

- <https://web.archive.org/web/20230605041826/https://www.honeybadger.io/blog/user-roles-permissions-in-laravel/>

### Performance

- [ ] <https://kinsta.com/blog/laravel-performance/>
- [ ] <https://newrelic.com/blog/best-practices/improve-laravel-performance>
- [ ] <https://www.cloudways.com/blog/laravel-performance-optimization/>
- [ ] <https://serversforhackers.com/laravel-perf/eager-loading>

### Forms

- add honeypot to svelte via route:
  <https://github.com/spatie/laravel-honeypot#usage-in-inertia>

### Architecture

- create overview/bird's eye

### Authentication

- Discord: <https://socialiteproviders.com/Discord/>
  - [x] Config Setup
  - [ ] Acquire Client ID and Secret
  - [x] Add Redirect URL
  - [x] `return Socialite::driver('discord')->redirect();`
- Steam: <https://socialiteproviders.com/Steam/>
  - [x] Config Setup
  - [ ] Acquire Client ID and Secret
  - [x] Add Redirect URL
  - [x] `return Socialite::driver('discord')->redirect();`
- Twitch: <https://socialiteproviders.com/Twitch/>
  - [x] Config Setup
  - [ ] Acquire Client ID and Secret
  - [x] Add Redirect URL
  - [x] `return Socialite::driver('discord')->redirect();`
- Github: <https://socialiteproviders.com/Github/> (Socialite Base)
  - [x] Config Setup
  - [ ] Acquire Client ID and Secret
  - [x] Add Redirect URL
  - [x] `return Socialite::driver('discord')->redirect();`
- possible others
  - Google: <https://socialiteproviders.com/Google/> (Socialite Base)

### DB

- [ ] Check ER diagram
- [ ] Check against Librematch Database ER:
      <https://github.com/librematch/librematch-database#entity-relationship-diagram-updated-at-2022-10-30>
- [x] Create 'news' table + model + controller
- [ ] Check models
- [x] Create migration script from old schema to new one
- [ ] Optimize queries:
      <https://omarbarbosa.com/posts/optimization-of-eloquent-queries-to-reduce-memory-usage>

### DONE: Setup inertia

- <https://inertiajs.com/server-side-setup#creating-responses>
- <https://inertiajs.com/pages>
- How to Setup Laravel with Svelte, Inertia.js and Vite:
  <https://www.youtube.com/watch?app=desktop&v=kkmVPKcnC-g>
- Learn Laravel, Inertia.js, Svelte:
  <https://www.youtube.com/watch?app=desktop&v=8Wze8o5s1Oo>
- Inertia Official Example App for Svelte:
  <https://github.com/inertiajs/pingcrm-svelte>

### General

- Routing: <https://laravel.com/docs/10.x/routing>
- Controller: <https://laravel.com/docs/10.x/controllers>
- Authentication: <https://laravel.com/docs/10.x/sanctum>
- ORM: <https://laravel.com/docs/10.x/eloquent>
