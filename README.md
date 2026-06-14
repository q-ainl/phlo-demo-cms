# Phlo CMS demo - a blog on SQLite

A small but complete blog/magazine running on the **Phlo CMS**. The whole admin
(navigation, list views, record views, create/edit forms, a REST API and CSRF
protection) is generated from five schema declarations. Nothing here is
hand-built HTML for the admin.


## What it shows

- **Schema-driven CRUD.** Five models (`article`, `author`, `category`,
  `topic`, `comment`), each a `static schema => arr(field(type: ...))`. The CMS
  reads the schema and builds everything else.
- **Every relation type.**
  - `parent` - an article belongs to one author and one category.
  - `many` - an article has many topics (m2m via the `article_topic` table).
  - `child` - an author/category/article exposes its articles/comments.
- **Uploads.** The `image` field on `article.cover` and `author.avatar` stores
  the file plus a token, and writes a thumbnail. Files live under
  `data/uploads/` (gitignored).
- **Rich text.** The article body uses the `wysiwyg` field.
- **One portable database.** Every model stores in a single SQLite file,
  `data/cms.db`, so you can copy the whole dataset or re-seed it in one command.

## Run it

```sh
# 1. install Faker (used only by the seeder)
composer install -d data/

# 2. create the tables and fill them with ~30 articles, authors, comments
php www/app.php seed::run

# 3. point a host at www/ (see /srv/control/sites/phlo-demos.caddy) and open it
```

The first HTTP request compiles the `.phlo` sources into `php/` automatically
(`build: true`). Re-running `seed::run` drops and recreates every table, so it is
always safe to start over.

## Layout

```
app.phlo            # models + sidebar menu + the only custom route (/ -> /articles)
entity.phlo         # base model: every table lives in one SQLite file
modules/*.phlo      # the five blog models (schema only)
seed.phlo           # CLI seeder: creates tables, fills them with Faker data
data/app.json       # wires the CMS resources, fields and SQLite driver
data/composer.json  # Faker (dev/seed only)
www/app.php         # the entry point (host, paths, build flags)
```

## Replicate this for your own content

1. Copy this folder.
2. Replace the models in `modules/` with your own schema.
3. Update `%app->models` and `%app->menu` in `app.phlo` to match.
4. Adjust the `CREATE TABLE` statements in `seed.phlo` (or write your own
   migration) to match the schema columns. Relation columns use the **related
   model's short name** as the column (e.g. `article.author`, and the join table
   `article_topic(article, topic)`).
