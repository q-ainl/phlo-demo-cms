# data/app.json notes

This demo wires the Phlo CMS the same way the production dashboard does:

- `paths.resources` adds `/srv/control/CMS/` (the CMS framework) and
  `%app/modules/` (this app's models). Resources are resolved by name against
  these paths.
- `icons` points at the CMS icon set.
- The five models (`article`, `author`, `category`, `comment`, `topic`) are
  listed in `resources` so the builder compiles them from `%app/modules/`. The
  CMS finds them at runtime via `%app->models`.
- `DB/SQLite` is the only database driver loaded; `entity.phlo` points every
  model at `data/cms.db`.
- The `fields/*` list is the set of field types the schemas use, plus the
  `image`/`file`/`wysiwyg` fields the dashboard does not ship by default.
- `tags.form` provides the `button()` helper the CMS record view uses.

To run translations or add MySQL later, add the relevant resources here.
