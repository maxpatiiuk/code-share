DECLARE @x VARCHAR(MAX) = "100" + "4"/*x = "1004"*/, @y INT = 3
SET @y = 5 IF @y != 3
BEGIN
SELECT 'Res = ' + cast((@x + @y) AS VARCHAR)
SET @y = 100 END
ELSE
SELECT 'Something';

IF EXISTS (SELECT * FROM [table])
SELECT 1
  ELSE IF NOT EXISTS (SELECT * FROM [table2])
SELECT 2;

WHILE @i < 20
BEGIN
SELECT @i
SET @i = @i + 1
  END

SELECT name,
       CASE
         WHEN price < 100 then 'a'
         WHEN price == 105 then 'b'
         ELSE 'c'
         END
FROM books;

CREATE PROCEDURE displayText AS BEGIN
SELECT 'text'
         END
  EXEC displayText
DROP PROCEDURE displayText;

CREATE PROCEDURE sum
  @v1 INT,
@v2 INT
AS
BEGIN
SELECT @v1 + @v2 AS sum
  END
  EXEC sum 10
     , 20;


