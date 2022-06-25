/*Вибрати усіх студентів, які навчаються на факультету програмування, брали хоча б 1 раз будь-яку книгу та повернули її в бібліотеку на протязі місяця з часу взяття.
Вивести ФІО бібліотекара, який видав хоча б одну книгу категорії Язык SQL.
Показати усі книги, які місять в назві букву «о», та були взяті в поточному столітті.
Вибрати тематики книг, кількість яких в бібліотеці більше 5 екземплярів.
Показати 3 найдорожчих книги в бібліотеці. Критерієм є ціна за 1 сторінку.
Вивести на екран книги, що були надруковані в 2000, 2010 або 2018 році.*/

/*MariaDB*/

/*1*/
SELECT s.*
FROM `Students` s,
     `Groups` g,
     `S_Cards` c
WHERE s.id_Group = g.id
  AND g.Id_Faculty IN (SELECT id FROM `Faculties` WHERE Name LIKE 'Програм%')
  AND s.id = c.Id_Student
  AND c.DateIn IS NOT NULL
  AND DATEDIFF(c.DateOut, c.DateIn) / 30 <= 1

/*2*/ SELECT DISTINCT CONCAT(l.FirstName, ' ', l.LastName) AS fullName
      FROM `S_Cards` c,
           `Libs` l,
           `Books` b
      WHERE c.id_Lib = l.id
        AND c.Id_Book = b.Id
        AND b.Id_Category = (SELECT id FROM `Categories` WHERE name LIKE "%SQL%")

/*3*/ SELECT DISTINCT b.Name AS dif
      FROM `S_Cards` s,
           `Books` b
      WHERE s.Id_Book IN (SELECT id FROM `Books` WHERE b.Name LIKE "%о%")
        AND DATEDIFF(s.DateOut, CURDATE()) < 7 * 4 * 12 * 100

/*4*/SELECT c.Name
     FROM `Books` b,
          `Categories` c
     WHERE b.Id_Category = c.Id
       AND b.Quantity > 5

/*5*/SELECT Name
     FROM `Books`
     ORDER BY CAST(Price AS INT) / Pages DESC
     LIMIT 3

/*6*/SELECT Name, YearPress
     FROM `Books`
     WHERE YearPress IN (2000, 2010, 2018)