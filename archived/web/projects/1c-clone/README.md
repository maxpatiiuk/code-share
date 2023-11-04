# 1c-clone

Date: December 2018

A simple shop revenue and expense tracking system.

> NOTE, this project has been rewritten from scratch with more modern
> tech stack. See
> [small-retail-management](http://localhost:3000/projects/small-retail-management)

Instead of paying for a licence of https://v8.1c.ru/, my parents asked me to
create a similar software (albeit MUCH simpler, due to their simpler
requirements).

This tool is still in production use every day.

Features:
- Supports both desktop and mobile
- Can enter data, and see charts
- Has two levels of access (cashier and manager)
- Has flexible configuration. Can do CRUD on:
  - Shops
  - Categories
  - Workers
  - Revenues
  - Salaries

Note, the entire tool is a single php file due to me being in a hurry when
writing this: almost all of the code was written in a single day.

## Configuration

1. Install PHP 7.4
2. Come up with a password, encrypt it using md5, and set the `HASH`
   constant at the top of the [`index.php`](./index.php) to that
   password
3. Edit MySQL credentials at the top of the [`index.php`](./index.php) file
4. Create a database based on the [`schema.sql`](./schema.sql) file
5. Install a web server and start PHP