# External APIs

## Liquipedia

Querying for sets, tournaments, player data, etc.

- documentation: <https://api.liquipedia.net/documentation/api/v3>

- special endpoints:
  <https://liquipedia.net/ageofempires/Special:LiquipediaDB/Arabia>

- matches need to be queried for `ageofempires` on `v1` endpoint as they are not
  migrated to `v3` yet
  - so `v1/match` instead of `v3/match2`

## esportsearnings

- documentation: <https://www.esportsearnings.com/apidocs>

## aoe2map

Querying for map names

- endpoint: <https://aoe2map.net/api/allmaps>

## aoc-ref-data

Querying for validated player data, teams might be outdated and not kept
up-to-date

- players:
  <https://raw.githubusercontent.com/SiegeEngineers/aoc-reference-data/master/data/players.yaml>'
- teams:
  <https://raw.githubusercontent.com/SiegeEngineers/aoc-reference-data/master/data/teams.json>
