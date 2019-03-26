--HW

--Task No.1
CREATE TRIGGER CountBooks
  ON books AFTER DELETE AS DECLARE @id int
select @id = id
FROM deleted
UPDATE books
SET quantity = quantity - 1
WHERE id = @id
  - -Task No.2
CREATE TRIGGER CountSoldBooks
  ON books
  FOR DELETE AS
  DECLARE @id int
SELECT @id = id
FROM deleted
  if
  (SELECT quantity FROM Books WHERE id = @id)
  =
  (SELECT quantity FROM Sales WHERE id_book = @id)
BEGIN
  RAISERROR
('Quantity of sold books cannot be less than quantity of available books', 10, 1)
ROLLBACK TRAN
END 
else
COMMIT TRAN

--Task No.3
CREATE TRIGGER CopyDeletedBook
  ON books
  FOR DELETE AS
  DECLARE @id int, @ name varchar (MAX)
SELECT @id = id, @name = name
FROM deleted
INSERT INTO BooksHistory([Dbook_id], [Dbook_name])
VALUES (@id, @ name)


  --Task No.4
CREATE TRIGGER ComparePrices
  ON books
  FOR DELETE AS
  DECLARE
  @book_id int,
  @book_price int,
  @sale_price int
SELECT @book_id = id, @book_price = price
FROM deleted
SELECT @sale_price = (SELECT price FROM Sales WHERE id = @book_id)
  if @sale_price
     < @book_price
BEGIN
  RAISERROR
  ('Price of sold book cannot be less than price of the book', 10, 2)
ROLLBACK TRAN
	END

--Task No.5
CREATE TRIGGER ForbidAppending
  ON books
  FOR INSERT AS
  DECLARE
  @book_id int
SELECT @book_id = id
FROM inserted
  if NOT EXISTS (SELECT dateOfPublish FROM Books)
BEGIN
  RAISERROR
  ('Date of the book must be specifyed', 10, 3)
ROLLBACK TRAN
END

--don't write task No.6

--Task No.7
CREATE TRIGGER BooksHistory ON Books AFTER INSERT, DELETE, UPDATE AS 
DECLARE
@old_name varchar(MAX),
@new_name varchar(MAX)
if EXISTS(SELECT 1 FROM inserted) and EXISTS(SELECT 1 FROM deleted) --Update
BEGIN
	SELECT @old_name = name FROM deleted
	SELECT @new_name = name FROM inserted	
	INSERT INTO BooksHistory([Action], [aDate], [User], [Data])
	VALUES('
Update ', SYSDATETIME(), USER_NAME(), ' Name ' + @old_name + ' was changed for ' + @new_name+ '.')
END
else if EXISTS(SELECT 1 FROM deleted) --Delete
BEGIN
	SELECT @old_name = name FROM deleted
	INSERT INTO BooksHistory([Action], [aDate], [User], [Data])
	VALUES('
Delete ', SYSDATETIME(), USER_NAME(), ' Name ' + @old_name + ' was deleted.')
END
else if EXISTS(SELECT 1 FROM inserted) --Insert
BEGIN
	SELECT @new_name = name FROM inserted	
	INSERT INTO BooksHistory([Action], [aDate], [User], [Data])
	VALUES('
Insert ', SYSDATETIME(), USER_NAME(), '
  Name
  ' + @new_name + '
  was
  inserted
  .
  ')
  END
