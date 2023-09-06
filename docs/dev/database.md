# Database

## Migrating from the old schema

Use [`atlas`](https://github.com/ariga/atlas) to extract the schemas:

```bash
atlas schema inspect -u "sqlite://database_old.sqlite" --format '{{ json . }}' > schema_old.json

atlas schema inspect -u "sqlite://database.sqlite" --format '{{ json . }}' > schema.json
```

You can use [jq](https://github.com/jqlang/jq) and the
[playground](https://jqplay.org/) for looking up values. This is the root path
for the database tables:

```bash
.[][].tables[]
```

To filter out the `legacy_` and the `migration` tables and sort for the name of
the table:

```bash
jq --sort-keys '[.[][].tables[] | select(.name | contains("legacy_") or contains("migration") | not)] | sort_by(.name)'
```

## New schema

The new schema is based on the old one, but with some changes:

![New schema](./ERD.png)

## Migration Guide

### 1. Analysis

1. **Understand the Legacy System:** Begin by fully understanding the legacy
   database schema. Map out tables, relationships, indexes, views, stored
   procedures, and any other objects.
1. **Determine Requirements:** Document the requirements for the new schema.
   These might be based on performance needs, newer features, or simply a more
   logical structuring.
1. **Identify Data Types and Transformations:** Some data types in the legacy
   database might not directly map to the new system. Identify these mismatches
   early.

### 2. Design

1. **Schema Design:** Design the new schema keeping in mind best practices for
   the specific database platform, as well as any new requirements.
1. **Mapping Document:** Create a detailed mapping document to show how data
   will move from the legacy system to the new one. This should include any
   transformations or translations required.

### 3. Development

1. **Write Migration Scripts:** Based on the mapping document, write scripts or
   use ETL (Extract, Transform, Load) tools to transfer data from the old to the
   new schema.
1. **Handle Special Cases:** Some data might not transfer cleanly, or might need
   special processing. Write scripts or processes to handle these cases.
1. **Test the Scripts:** Before running the migration in a production
   environment, test the scripts on a backup or a copy of the legacy database.

### 4. Testing

1. **Staging Environment:** Set up a staging environment that mimics the
   production system. Run the migration scripts here first.
1. **Data Validation:** After migration, validate the data in the new schema.
   Ensure that all data was transferred correctly and that there are no missing
   or corrupted records.
1. **Performance Testing:** Check the performance of the new schema under load
   to ensure it meets the requirements.

### 5. Migration

1. **Backup:** Always backup the legacy system before starting the migration.
1. **Downtime:** Depending on the migration approach, you might need some
   downtime. Inform stakeholders and users in advance.
1. **Execute Migration:** Run the migration scripts on the production database.
1. **Monitor:** After migration, monitor the database for any errors,
   performance issues, or other potential problems.

### 6. Post-Migration

1. **Optimization:** Based on the monitoring, make any required optimizations to
   the new schema or system.
1. **Documentation:** Update all system documentation to reflect the new
   database schema and any changes in processes.
1. **Inform Stakeholders:** Once the migration is complete and stable, inform
   all relevant stakeholders.
