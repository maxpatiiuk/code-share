# Chrome Omnibox Shortcuts editing

## Files

- Chrome profile: `~/Library/Application Support/Google/Chrome/Default/`
- Shortcuts SQLite database: `~/Library/Application Support/Google/Chrome/Default/Shortcuts`
- Table: `omni_box_shortcuts`
- Useful columns: `id`, `text`, `fill_into_edit`, `url`, `contents`, `contents_class`, `description`, `description_class`, `keyword`, `last_access_time`, `number_of_hits`

## Backups Created

Make backup before edits. For a new backup, quit Chrome first and use a new, non-existing destination path:

```sh
PROFILE="$HOME/Library/Application Support/Google/Chrome/Default"
SHORTCUTS="$PROFILE/Shortcuts"
BACKUP="$HOME/d/Shortcuts_backup_$(date +%Y%m%d_%H%M%S).sqlite"

sqlite3 -readonly "$SHORTCUTS" ".backup '$BACKUP'"
sqlite3 -readonly "$BACKUP" "PRAGMA integrity_check; SELECT COUNT(*) FROM omni_box_shortcuts;"
```

Expected integrity output is `ok`. Check that the target backup path does not already exist before running the command.

## Safe Workflow

1. Make and verify a fresh SQLite backup before each edit. Keep backups outside the profile.
2. Inspect the schema and preview the exact target rows with `sqlite3 -readonly` before writing. Compare destination URLs exactly, and decide how to handle rows that already have a mapped equivalent.
3. Freeze selected row IDs in a temporary table inside a transaction before updating. This prevents rows changed earlier in the same operation from affecting the target selection.
4. Update only intended columns. Preserve IDs and unrelated metadata. If changing displayed text, inspect `contents_class` / `description_class`; those strings encode highlight classifications and may need offset adjustment if replacements change text lengths.
5. Check affected-row counts, query for remaining old strings in the selected rows, run `PRAGMA integrity_check`, commit only if checks pass, then restart Chrome and test the actual Omnibox.

Use `last_access_time` conversion below when reading metadata; Chrome timestamps are microseconds since the Windows epoch:

```sql
datetime(last_access_time / 1000000.0 - 11644473600, 'unixepoch')
```

For rollback, quit Chrome completely first. Restore only from a verified backup, then reopen Chrome. Avoid restoring while Chrome is running because it may keep stale state in memory or write it back.

