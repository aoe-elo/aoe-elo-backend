# Database Mapping

## Country / countries

| Table   | Column  | Data Type    | Nullable | Indexes | Primary Key | Maps to           |
| ------- | ------- | ------------ | -------- | ------- | ----------- | ----------------- |
| country | id      | int unsigned | false    |         | true        | countries.id      |
| country | iso_key | varchar(10)  | false    |         | false       | countries.iso_key |
| country | name    | text         | false    |         | false       | countries.name    |

## Match 1v1 / sets + set_items

| Table     | Column        | Data Type    | Nullable | Indexes      | Primary Key | Comment                                                | Maps to                                 |
| --------- | ------------- | ------------ | -------- | ------------ | ----------- | ------------------------------------------------------ | --------------------------------------- |
| match_1v1 | id            | int unsigned | false    |              | true        |                                                        | sets.id                                 |
| match_1v1 | date          | date         | true     |              | false       | when this match was played (null=auto from tournament) | sets.played_at (conversion to dateTime) |
| match_1v1 | tournament_id | int unsigned | true     |              | false       |                                                        | sets.tournament_id (foreign)            |
| match_1v1 | stage_id      | int unsigned | false    |              | false       |                                                        | sets.stage_id (foreign)                 |
| match_1v1 | player_1_id   | int unsigned | false    |              | false       |                                                        | set_item.entity_id (foreign)            |
| match_1v1 | player_2_id   | int unsigned | false    |              | false       |                                                        | set_item.entity_id (foreign)            |
| match_1v1 | score_1       | int unsigned | false    |              | false       |                                                        | set_item.score                          |
| match_1v1 | score_2       | int unsigned | false    |              | false       |                                                        | set_item.score                          |
| match_1v1 | create_user   | int unsigned | false    | created_user | false       |                                                        | sets.created_user_id (foreign)          |
| match_1v1 | create_time   | datetime     | false    |              | false       |                                                        | timestamps()                            |
| match_1v1 | update_user   | int unsigned | false    | update_user  | false       |                                                        | sets.updated_user_id (foreign)          |
| match_1v1 | update_time   | datetime     | false    |              | false       |                                                        | timestamps()                            |

## Match 1v1 Event / - (removed)

| Table           | Column        | Data Type    | Nullable | Indexes         | Primary Key | Maps to |
| --------------- | ------------- | ------------ | -------- | --------------- | ----------- | ------- |
| match_1v1_event | id            | int unsigned | false    |                 | true        | -       |
| match_1v1_event | date          | date         | true     |                 | false       | -       |
| match_1v1_event | time          | time         | true     |                 | false       | -       |
| match_1v1_event | tournament_id | int unsigned | false    | tournament_id_2 | false       | -       |
| match_1v1_event | stage_id      | int unsigned | false    | stage_id        | false       | -       |
| match_1v1_event | player_1_id   | int unsigned | true     | tournament_id   | false       | -       |
| match_1v1_event | player_2_id   | int unsigned | true     | tournament_id   | false       | -       |
| match_1v1_event | bo            | int unsigned | true     |                 | false       | -       |
| match_1v1_event | create_user   | int unsigned | false    | create_user     | false       | -       |
| match_1v1_event | create_time   | datetime     | false    |                 | false       | -       |
| match_1v1_event | update_user   | int unsigned | false    | update_user     | false       | -       |
| match_1v1_event | update_time   | datetime     | false    |                 | false       | -       |

## Player / players

| Table  | Column          | Data Type    | Nullable | Indexes     | Primary Key | Comment         | Maps to                                                                         |
| ------ | --------------- | ------------ | -------- | ----------- | ----------- | --------------- | ------------------------------------------------------------------------------- |
| player | id              | int unsigned | false    |             | true        |                 | players.id                                                                      |
| player | name            | varchar(30)  | false    | name        | false       |                 | players.name                                                                    |
| player | alias           | varchar(255) | false    |             | false       | comma-separated | players.aliases (JSON array of alias names: ["alias1", "alias2"])               |
| player | team_id         | int unsigned | true     | team_id     | false       |                 | players.team_id (foreign)                                                       |
| player | country_key     | varchar(10)  | true     |             | false       |                 | players.country_id (foreign, lookup id?)                                        |
| player | initial_elo_1v1 | int unsigned | true     |             | false       |                 | players.base_elo                                                                |
| player | voobly_id       | int unsigned | true     |             | false       |                 | players.voobly_id                                                               |
| player | steam_id        | varchar(40)  | true     |             | false       |                 | players.steam_id                                                                |
| player | steam_id_failed | varchar(40)  | true     |             | false       |                 | players.steam_id_failed                                                         |
| player | twitch          | text         | true     |             | false       |                 | merge into players.socials ('{"name": "twitch", "value": "<twitch-link>"}')     |
| player | youtube         | text         | true     |             | false       |                 | merge into players.socials ('{"name": "youtube", "value": "<youtube-link>"}')   |
| player | twitter         | text         | true     |             | false       |                 | merge into players.socials ('{"name": "twitter", "value": "<twitter-link>"}')   |
| player | facebook        | text         | true     |             | false       |                 | merge into players.socials ('{"name": "facebook", "value": "<facebook-link>"}') |
| player | create_user     | int unsigned | false    | create_user | false       |                 | players.created_user_id (foreign)                                               |
| player | create_time     | datetime     | false    |             | false       |                 | timestamps()                                                                    |
| player | update_user     | int unsigned | false    | update_user | false       |                 | players.updated_user_id (foreign)                                               |
| player | update_time     | datetime     | false    |             | false       |                 | timestamps()                                                                    |

## Player Info / players_info (TODO: what is the use case for this?)

| Table       | Column      | Data Type    | Nullable | Indexes     | Primary Key | Maps to                                |
| ----------- | ----------- | ------------ | -------- | ----------- | ----------- | -------------------------------------- |
| player_info | id          | int unsigned | false    |             | true        | players_info.id                        |
| player_info | player      | int unsigned | false    | player      | false       | players_info.player_id (foreign)       |
| player_info | type        | varchar(255) | false    |             | false       | players_info.type                      |
| player_info | value_int   | int          | true     |             | false       | players_info.value_int                 |
| player_info | value_str   | text         | true     |             | false       | players_info.value_str                 |
| player_info | create_time | datetime     | false    |             | false       | timestamps()                           |
| player_info | create_user | int unsigned | false    | create_user | false       | players_info.created_user_id (foreign) |

## Stage / stages

| Table | Column     | Data Type    | Nullable | Indexes | Primary Key | Maps to                                                               |
| ----- | ---------- | ------------ | -------- | ------- | ----------- | --------------------------------------------------------------------- |
| stage | id         | int unsigned | false    |         | true        | stages.id                                                             |
| stage | name       | text         | false    |         | false       | stages.name                                                           |
| stage | bracket    | int unsigned | false    |         | false       | stages.bracket (TODO: could be foreign and own table?)                |
| stage | index      | int unsigned | false    |         | false       | stages.index                                                          |
| stage | weight     | float        | false    |         | false       | stages.weight (convert to integer 1 => 10, intval(stage.weight * 10)) |
| stage | importance | int unsigned | false    |         | false       | stages.importance                                                     |

## Team / teams

| Table | Column          | Data Type    | Nullable | Indexes     | Primary Key | Maps to                         |
| ----- | --------------- | ------------ | -------- | ----------- | ----------- | ------------------------------- |
| team  | id              | int unsigned | false    |             | true        | teams.id                        |
| team  | name            | varchar(100) | false    | name        | false       | teams.name                      |
| team  | tag             | varchar(30)  | false    |             | false       | teams.tag                       |
| team  | primary_color   | varchar(30)  | true     |             | false       | teams.primary_color             |
| team  | secondary_color | varchar(30)  | true     |             | false       | teams.secondary_color           |
| team  | create_user     | int unsigned | true     | create_user | false       | teams.created_user_id (foreign) |
| team  | create_time     | datetime     | true     |             | false       | timestamps()                    |
| team  | update_user     | int unsigned | true     | update_user | false       | teams.updated_user_id (foreign) |
| team  | update_time     | datetime     | true     |             | false       | timestamps()                    |

## Tournament / tournaments

| Table      | Column      | Data Type                                                                           | Nullable | Indexes     | Primary Key | Comment | Maps to                                         |
| ---------- | ----------- | ----------------------------------------------------------------------------------- | -------- | ----------- | ----------- | ------- | ----------------------------------------------- |
| tournament | id          | int unsigned                                                                        | false    |             | true        |         | tournaments.id                                  |
| tournament | name        | varchar(255)                                                                        | false    | name        | false       |         | tournaments.name                                |
| tournament | short       | varchar(100)                                                                        | false    |             | false       |         | tournaments.short_name                          |
| tournament | start       | date                                                                                | true     |             | false       |         | tournaments.started_at (conversion to dateTime) |
| tournament | end         | date                                                                                | true     |             | false       |         | tournaments.ended_at (conversion to dateTime)   |
| tournament | weight      | int unsigned                                                                        | false    |             | false       |         | tournaments.weight                              |
| tournament | type        | enum('cup','qualifier')                                                             | false    |             | false       |         | tournaments.type                                |
| tournament | prizemoney  | int unsigned                                                                        | true     |             | false       | in $    | tournaments.prize_money                         |
| tournament | parent_id   | int unsigned                                                                        | true     | parent_id   | false       |         | tournaments.parent_tournament_id (foreign)      |
| tournament | structure   | enum('single-elemination','double-elimination','league','other','group','group-ko') | false    |             | false       |         | tournaments.structure                           |
| tournament | evaluation  | varchar(30)                                                                         | true     |             | false       |         | tournaments.evaluation                          |
| tournament | website     | text                                                                                | true     |             | false       |         | tournaments.website                             |
| tournament | comment     | text                                                                                | true     |             | false       |         | tournaments.comments                            |
| tournament | create_user | int unsigned                                                                        | false    | create_user | false       |         | tournaments.created_user_id (foreign)           |
| tournament | create_time | datetime                                                                            | false    |             | false       |         | timestamps()                                    |
| tournament | update_user | int unsigned                                                                        | false    | update_user | false       |         | tournaments.updated_user_id (foreign)           |
| tournament | update_time | datetime                                                                            | false    |             | false       |         | timestamps()                                    |

## Tournament Info / tournaments_info

| Table           | Column        | Data Type    | Nullable | Indexes       | Primary Key | Comment                                                               | Maps to                                    |
| --------------- | ------------- | ------------ | -------- | ------------- | ----------- | --------------------------------------------------------------------- | ------------------------------------------ |
| tournament_info | id            | int unsigned | false    |               | true        |                                                                       | tournaments_info.id                        |
| tournament_info | create_user   | int unsigned | false    | create_user   | false       |                                                                       | tournaments_info.created_user_id (foreign) |
| tournament_info | create_time   | datetime     | false    |               | false       |                                                                       | timestamps()                               |
| tournament_info | tournament_id | int unsigned | false    | tournament_id | false       |                                                                       | tournaments_info.tournament_id (foreign)   |
| tournament_info | type          | int unsigned | false    | type          | false       | 1: challonge bracket, 2: bracket URL, 3: public res., 4: private res. | tournaments_info.type (enum)               |
| tournament_info | description   | text         | false    |               | false       |                                                                       | tournaments_info.description               |
| tournament_info | value         | text         | false    |               | false       |                                                                       | tournaments_info.value                     |

## Tournament Result / tournaments_results

| Table             | Column      | Data Type    | Nullable | Indexes     | Primary Key | Comment                                  | Maps to                                       |
| ----------------- | ----------- | ------------ | -------- | ----------- | ----------- | ---------------------------------------- | --------------------------------------------- |
| tournament_result | id          | int unsigned | false    |             | true        |                                          | tournaments_results.id                        |
| tournament_result | tournament  | int unsigned | false    | tournament  | false       |                                          | tournaments_results.tournament_id (foreign)   |
| tournament_result | player      | int unsigned | false    | player      | false       |                                          | tournaments_results.player_id (foreign)       |
| tournament_result | type        | int unsigned | true     | type        | false       | 1: win, ..., 5: semi-finals, null: other | tournaments_results.type                      |
| tournament_result | money       | int unsigned | true     |             | false       |                                          | tournaments_results.money                     |
| tournament_result | source      | text         | true     |             | false       |                                          | tournaments_results.source                    |
| tournament_result | create_time | datetime     | false    |             | false       |                                          | timestamps()                                  |
| tournament_result | create_user | int unsigned | false    | create_user | false       |                                          | tournaments_results.created_user_id (foreign) |

## User / users .. permissions

| Table | Column           | Data Type    | Nullable | Indexes | Primary Key | Comment                                             | Maps to                      |
| ----- | ---------------- | ------------ | -------- | ------- | ----------- | --------------------------------------------------- | ---------------------------- |
| user  | id               | int unsigned | false    |         | true        |                                                     | users.id                     |
| user  | name             | varchar(100) | false    | name    | false       |                                                     | users.name                   |
| user  | pass             | varchar(255) | false    |         | false       |                                                     | removed due to social logins |
| user  | rank             | int unsigned | false    |         | false       | 1: admin, 2: normal                                 | migrate to permission system |
| user  | allow_tournament | int unsigned | true     |         | false       | 0: nothing, 1: create, 2: and update, 3: and remove | migrate to permission system |
| user  | allow_player     | int unsigned | true     |         | false       |                                                     | migrate to permission system |
| user  | allow_match      | int          | true     |         | false       |                                                     | migrate to permission system |
| user  | allow_see        | int unsigned | true     |         | false       | 0: nothing, 1: stats                                | migrate to permission system |
