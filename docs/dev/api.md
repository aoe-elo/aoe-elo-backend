# API

## Current

### api?request=players

- [ ] ordered by rank
  - should be optional or under `Leaderboards`
  - when is rank `null`?
- [ ] elo_peak
- [ ] last_series_time
- [ ] team subobject
- [ ] link to player page
- [ ] link to team page
- [ ] link to player api

```json
{
    "id": 29,
    "name": "TheViper",
    "elo": 2419,
    "elo_peak": 2419,
    "rank": 2,
    "url": "\/player\/29\/TheViper",
    "api_url": "https:\/\/aoe-elo.com\/api?request=player&id=29",
    "team_name": "GamerLegion",
    "last_series_time": "2023-08-27"
}
```

### api?request=player&id=1

```json
{
    "id": 1,
    "name": "DauT",
    "elo": 2336,
    "rank": 6,
    "url": "https:\/\/aoe-elo.com\/player\/1\/DauT",
    "steam_id": null,
    "first_series_timestamp": 1030751999,
    "first_series_time": "Aug 2002",
    "peak_timestamp": 1693094400,
    "peak_time": "Aug 2023",
    "peak_elo": 2336,
    "inactive": false,
    "retired": false,
    "series_played": 557,
    "series_won": 374,
    "games_played": 1882,
    "tournaments_played": 149,
    "tournaments_list": [
        2,
        4,
        6,
        7,
        ...
    ]
}
```

### /api?request=tournaments

```json
{
    "id": 599,
    "name": "MetaWorldTour",
    "url": "https:\/\/aoe-elo.com\/tournament\/599\/MetaWorldTour",
    "api_url": "https:\/\/aoe-elo.com\/api?request=tournament&id=599",
    "start_timestamp": 1693267200,
    "end_timestamp": 1698019199
}
```

### api?request=tournament&id=40

```json
{
    "id": 40,
    "name": "Escape Gaming Masters 3",
    "type": "cup",
    "start_timestamp": 1509494400,
    "end_timestamp": 1510617599,
    "players": [
        1,
        11,
        14,
        16,
        24,
        29,
        30,
        31,
        55,
        94,
        100,
        103
    ],
    "url": "https:\/\/aoe-elo.com\/tournament\/40\/Escape-Gaming-Masters-3",
    "series": 18
}
```

## Next

### Possible additional `stats` endpoints

- `/api/v1/players/{id}/stats`
- `/api/v1/teams/{id}/stats`
- `/api/v1/tournaments/{id}/stats`
- `/api/v1/sets/{id}/stats`
- `/api/v1/leaderboards/{id}/stats`

### /api/v1/search

- [ ] search for players, teams, tournaments, sets, leaderboards
  - [ ] search for players by steam_id
  - [ ] search for players by relic_link_id
  - [ ] search for players by name
  - [ ] search for teams by name
  - [ ] search for tournaments by name
- [ ] create index with model name, e.g. `App\Models\Player` and
      `App\Models\Team`
  - so they can be easily access afterwards by casting them to a variable

### /api/v1/players

### /api/v1/players/{id}

### /api/v1/teams

### /api/v1/teams/{id}

### /api/v1/tournaments

### /api/v1/tournaments/{id}

### /api/v1/sets

### /api/v1/sets/{id}

### /api/v1/leaderboards

### /api/v1/leaderboards/{id}
