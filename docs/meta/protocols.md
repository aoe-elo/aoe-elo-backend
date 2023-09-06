# Protocols

## 2023-08-07 - Voice talk with @ghostmonkey

- simonsan explained a few things regarding the backend, so it's easier to
  determine how the Request-Business Logic-Response cycle works in it
  - basically web requests land in `Routes/web.php`, API requests land in
    `Routes/api.php` then you either use a `Controller` in
    `app/http/Controllers/web/{e.g. PageController}` to create a response in a
    method of that class or directly form a response in the corresponding
    function in `{web,api}.php`
- simonsan talked about how data can be transferred to a svelte file (from my
  current knowledge, that might change as I'm diving deeper into `laravel` and
  `inertia`)
- we talked about possible current and future use cases
- simonsan sent `players.json`, `teams.json`, and `tournaments.json` response to
  work with for drafting on the `frontend` side
- agreed on work split, so simonsan will work on the backend for now
  implementing/refactoring/migrating all the current existing business logic and
  ghostmonkey will continue to design the frontend
  - we talked about who has the final say on what is being done, and we assumed
    that we will all work together, waiting for feedback of participants in
    @here and go forward from there. in the end new things need to get used to,
    it's normal.
