# Transaction Data migration

A set of scripts that I used in 2024 to:

- Migrate from Rocket Money to Copilot Money
- Transfer old Bank of America statements into Copilot Money
- Transfer my financial history with my university into Copilot Money
- Clean up the data
- Verify that everything got converted correctly in the process

This was possible because Copilot added a CSV import feature using the Mint's
export format (to support people that are migrating from Mint). Thus, this set
of scripts outputs everything as a JSON file that matches the Mint's CSV
structure. You can then use a tool like https://data.page/json/csv to convert
the JSON to CSV and import into Copilot.

In Copilot, I noticed an issue where some transactions would be uploaded as
category "Unknown" despite having correct category in the CSV (i.e some
"Entertainment" transactions would be uploaded as "Unknown", while other
"Entertainment" are just fine) - I had to review those manually.

Also, for some reason any notes you had would get prepended with `\n\[` and
appended with `]` upon import - had to cleanup those manually as well 😢.
