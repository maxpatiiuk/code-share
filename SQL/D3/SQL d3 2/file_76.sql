SELECT *
FROM d3_products;
SELECT names
FROM books
WHERE quantitu IS NULL;
SELECT DISTINCT category
FROM d3_products;
SELECT *
FROM books
WHERE quatitu > 10
  AND year_of_relyse IN (2008, 2009)
ORDER BY year_of_relyse + 0 ASC;
SELECT DISTINCT names
FROM books
WHERE year_of_relyse < YEAR(GETDATE())
  AND month_of_relyse < MONTH(GETDATE());
SELECT name, publisher
FROM books
WHERE category=="БД";
SELECT name, category
FROM books
WHERE category != "БД"
  AND (publisher LIKE '%K' OR publisher LIKE '%M');
SELECT name, author, publisher
FROM books
WHERE categpry IN ("Language SQL", "Delphi", "C++ Builder")
  AND price_of_delivery < 50
  AND delivery_time between "01/01/2006" and CONVERT(date, GETDATE());
SELECT name, publisher, author, category
FROM books
WHERE category = "FrontPage"
  AND quatitu = 100;