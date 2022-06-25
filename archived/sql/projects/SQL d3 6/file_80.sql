--Написати запит на створення таблиці, що містить 5 найдорожчих книг.
--Написати параметризований запит, що повертає 2 найбільш популярні книги вказаної категорії.
--Написати запит, що додає нову книгу з даними, які введено з клавіатури.
--Зменшити ціну книг, введеного з клавіатури видавництва, на 15 відсотків.
--Видалити книги, ціна яких менша ніж в середньому по бібліотеці.
--«Заставити» здати всіх студентів книги в бібліотеку. Датою здачі вважати завтра.
--Видалити студентів, що жодного разу не брали книги в бібліотеці.
--Додати поле «дата народження» для студентів.
--Проставити дату народження студентів перше січня 2000 року, якщо дата народження порожня.
--Видалити всі книги деякого видавництва. Назва видавництва ввести з клавіатури.

--1
CREATE TABLE `topBooks`
(
  `id`    INT         NOT NULL,
  `name`  VARCHAR(90) NOT NULL,
  `price` INT         NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = MyISAM;
INSERT INTO `topBooks`
SELECT Id, Name, Price + 0
FROM `Books`
ORDER BY price + 0 DESC
LIMIT 5;

--2
SELECT b.Name
FROM `Books` b
       LEFT JOIN `Categories` c ON b.Id_Category = c.id
       LEFT JOIN `S_Cards` k ON k.Id_Book = b.id
WHERE c.Name LIKE "%SQL%"
GROUP BY b.Id
ORDER BY COUNT(k.id) DESC
LIMIT 2 --3
INSERT INTO `Books`(Name, Pages, YearPress, Id_Themes, Id_Category, Id_Press, Comment, Quantity, Price)
VALUES ("1", "2", "3", "4", "5", "6", "7", "8", "9") --4
UPDATE `Books` b
SET b.price=(b.price + 0) * (1 - 0.15)
WHERE b.Id_Press = (SELECT p.Id FROM `Press` p WHERE p.Name LIKE "%4%")
  - -5
SET @A = (SELECT AVG(b.price)
          FROM `Books` b);
DELETE
FROM `Books`
WHERE price < @A
  - -6
UPDATE `S_Cards` c
SET DateIn=DATE_ADD(LOCALTIME(), INTERVAL 1 DAY)
WHERE DateIn IS NULL
   OR DateIn = ""
   OR LENGTH(DateIn) < 1
  - -7
DELETE *
FROM `Students`
WHERE id NOT IN (SELECT DISTINCT Id_Student FROM `S_Cards`)
        - -8
ALTER TABLE `Students`
  ADD birthDate VARCHAR(20) NULL --9
UPDATE `Students`
SET birthDate="2000-01-01"
WHERE birthDate IS NULL
   OR LENGTH(birthDate) < 1
  - -10
DELETE
FROM `Books`
WHERE Id_Press = (SELECT Id FROM `Press` WHERE Name LIKE "%4%")