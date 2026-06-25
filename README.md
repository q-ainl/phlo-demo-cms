# Phlo CMS demo - a blog on SQLite

A small but complete blog/magazine running on the **Phlo CMS**. The whole admin
(navigation, list views, record views, create/edit forms, a REST API and CSRF
protection) is generated from a handful of schema declarations. Nothing here is
hand-built HTML for the admin.

The repo ships with a **ready-made dataset**: clone it and you immediately have a
populated CMS - articles, authors, comments, and real cover images, avatars and
downloadable attachments. No build or seed step required.

## What it shows

- **Schema-driven CRUD.** The models (`article`, `author`, `category`, `topic`,
  `comment`, `plan`, `attachment`) are each a `static schema => arr(field(type: ...))`.
  The CMS reads the schema and builds everything else.
- **Every relation type.**
  - `parent` - an article belongs to one author and one category.
  - `many` - an article has many topics (m2m via the `article_topic` table).
  - `child` - an author/category exposes its articles/comments.
- **Uploads.** The `image` field on `article.cover` and `author.avatar` stores the
  file plus a token and writes a thumbnail; the `file` field on `attachment.file`
  stores downloadable documents. The media ships in `data/uploads/`.
- **Rich text.** The article body uses the `wysiwyg` field.
- **One portable database.** Every model stores in a single SQLite file,
  `data/cms.db`, committed with the repo. Copy it, ship it, or regenerate it in
  one command.

## Run it

```sh
# 1. Point www/app.php at your Phlo engine (edit the require path) and set host.
# 2. Serve www/ (FrankenPHP, php -S, Caddy php_server, ...).
```

The committed dataset (`data/cms.db` plus the cover/avatar/attachment files under
`data/uploads/`) is already in place, so the CMS is populated on first load. The
first HTTP request compiles the `.phlo` sources into `php/` automatically
(`build: true`).

To regenerate the dataset (it is fully deterministic and has no dependencies):

```sh
php www/app.php seed::run
```

This drops and recreates every table, refills them with the same curated content,
and regenerates the covers, avatars and attachment PDFs.

## Layout

```
app.phlo            # models + sidebar menu + the only custom route (/ -> /articles)
entity.phlo         # base model: every table lives in one SQLite file
modules/*.phlo      # the blog models (schema only)
seed.phlo           # curated, deterministic seeder (regenerates cms.db + media)
data/cms.db         # the committed SQLite dataset
data/uploads/       # committed cover images, avatars and attachment files
data/app.json       # wires the CMS resources, fields and SQLite driver
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
