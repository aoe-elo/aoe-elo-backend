set dotenv-load
now := `date +"%s"`
db := "./database/database.sqlite"

# Showing this message
default:
    @just --choose

# Run the development server
serve:
    php artisan serve

# Format the whole project
fmt:
    ./vendor/bin/php-cs-fixer fix
    dprint fmt

# Lint the backend part of the project
blint:
    ./vendor/bin/phpcs --standard=PSR12 --report=code,summary -p --file-list=.phpcsinclude --tab-width=4 --parallel=10 --ignore=legacy,vendor,css,js,html

# Fix errors and warnings the backend part of the project
fix: fmt
    ./vendor/bin/phpcbf --standard=PSR12 --report=code,summary -p --file-list=.phpcsinclude --parallel=10 --ignore=legacy,vendor,css,js,html

# Test the backend part of the project
btest:
    ./vendor/bin/pest --coverage-text --profile --stop-on-failure --parallel

# Run all available recipes before opening a pull request
pr: blint btest fix

# Create Web/Controller for a model *MODEL with requests and pest tests
makewebcontroller *MODEL:
    php artisan make:controller --pest Web/{{MODEL}}Controller -m {{MODEL}} -R

# Refresh the database schema and seed
dbfreshs:
    @just dbrecreate
    php artisan migrate:fresh --seed

# Refresh the database schema (doesn't seed)
dbfresh:
    @just dbrecreate
    php artisan migrate:fresh

# Generates Eloquent models from a database table *ARG
dbmodels *ARG:
        php artisan code:models -t {{ARG}}
        @just fmt

# Refreshes & seeds the database, then imports the AoE reference data
# NOTE: is now in seeder, so only run for testing
dbimportref:
        @just dbfreshs
        php artisan app:import-aoe-ref-data
        @just dbclone importref

# Migrates players and teams from the old database
dbmigrate_pte:
        @just dbfreshs
        php artisan app:migrate-legacy-data --pte
        @just dbclone playersteams

# Migrates tournaments from the old database
dbmigrate_to:
        @just dbrestore playersteams
        php artisan app:migrate-legacy-data --to
        @just dbclone tournaments

# Migrates matches from the old database
dbmigrate_se:
        @just dbrestore tournaments
        php artisan app:migrate-legacy-data --se
        @just dbclone matches

# Runs all commands to prepare for calculating the Elo ratings
prepare_elo_calc:
        @just dbmigrate_pte
        @just dbmigrate_to
        @just dbmigrate_se

# Calculates the Elo ratings
elocalc:
        @just dbrestore matches
        php artisan app:calculate-elo
        @just dbclone elo_calc

# Create some test reviews
test_reviews:
        @just dbrecreate
        @just dbrestore matches
        php artisan db:seed --class=ReviewSeeder

# Clones the database to a backup file *ARG
dbclone *ARG:
        sqlite3 {{db}} ".timeout 1000" ".backup './database/backups/aoe-elo-dev.sqlite.{{ARG}}.bkp'"

# Restores the database from a backup file *ARG
dbrestore *ARG:
        sqlite3 {{db}} ".timeout 1000" ".restore './database/backups/aoe-elo-dev.sqlite.{{ARG}}.bkp'"

# Backs up the database using the SQLite backup command
dbbackup:
        sqlite3 {{db}} ".timeout 1000" ".backup './database/backups/aoe-elo.sqlite.{{now}}.bkp'"

# Enables WAL mode for the telescope database
dbsetwal *ARG:
        php artisan app:sqlite-enable-wal {{ARG}}

# Recreates the development databases
@dbrecreate:
    if [[ -f {{db}} ]]; then \
    rm {{db}}; \
    fi

    touch {{db}}

    if [[ -f "./database/telescope.sqlite" ]]; then \
    rm ./database/telescope.sqlite; \
    fi

    touch ./database/telescope.sqlite
    @just dbsetwal telescope_sqlite

