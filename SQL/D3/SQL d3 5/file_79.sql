--1    Вибрати усіх студентів бібліотеки. Показати групу та факультет кожного студента.
--2    Показати у процентному відношенні взяті книги кожним факультетом. За 100% вважати книги, що були взяті в бібліотеці вцілому.
--3    Показати тих студентів, що жодного разу не відвідували бібліотеку.
--4    Показати усі книги певного видавництва. Назву видавництва (або його частину) ввести з клавіатури.
--5    Вивести на екран тільки ті факультети, студенти яких хоча б один раз були в бібліотеці.
--6    Показати книги, що були взяти факультетом програмування.
--7    Показати усі групи і кількість студентів у кожній з них. Якщо в деякої групи студентів нема – група все одно повинна бути в переліку.
--8    Вивести авторів, книги яких представлені в бібліотеці трьома різними екземплярами.
--9    Показати сумарну ціну всіх книг. Згрупувати по авторам.
--10   Вивести на екран авторів, книги яких не бралися на протязі деякого часу. Час ввести з клавіатури (в днях).  

--MariaDB

--1
SELECT CONCAT(s.FirstName, ' ', s.LastName), g.Name AS "Group", f.Name AS "Faculty"
FROM `Students` s
       LEFT JOIN `Groups` g ON s.Id_Group = g.Id
       LEFT JOIN `Faculties` f ON g.Id_Faculty = f.Id
  - -2
SELECT f.Name AS `Name`, CONCAT(COUNT(s.Id) * 100 / (SELECT COUNT(*) FROM `S_Cards`), "%") AS `Percantage`
FROM `Groups` g
       RIGHT JOIN `Faculties` f ON g.Id_Faculty = f.Id
       LEFT JOIN `Students` s ON s.Id_Group = g.Id
       LEFT JOIN `S_Cards` c ON c.Id_Student = s.Id
GROUP BY `Name`
UNION
SELECT "Overal", "100%"
FROM `S_Cards` --3
SELECT CONCAT(s.FirstName, ' ', s.LastName) AS `Name`
FROM `Students` s
       LEFT JOIN `S_Cards` c ON c.Id_Student = s.Id
WHERE c.Id_Student IS NULL
  - -4
SELECT b.Name
FROM `Books` b
       LEFT JOIN `Press` p ON b.Id_Press = p.Id
WHERE p.Name LIKE "%Dia%"
  - -5
SELECT DISTINCT f.Name
FROM `Faculties` f
       LEFT JOIN `Groups` g ON g.Id_Faculty = f.Id
       LEFT JOIN `Students` s ON s.Id_Group = g.Id
       LEFT JOIN `S_Cards` c ON c.Id_Student = s.Id
WHERE c.Id_Student IS NOT NULL
  - -6
SELECT DISTINCT b.Name
FROM `Books` b
       LEFT JOIN `S_Cards` c ON c.Id_Book = b.Id
       LEFT JOIN `Students` s ON s.Id = c.Id_Student
       LEFT JOIN `Groups` g ON s.Id_Group = g.Id
       LEFT JOIN `Faculties` f ON f.Id = g.Id_Faculty
WHERE f.Name LIKE "Прог%"
  - -7
SELECT g.Name, COUNT(s.Id) AS "Count"
FROM `Groups` g
       LEFT JOIN `Students` s ON s.Id_Group = g.Id
GROUP BY g.Name
           - -8
SELECT CONCAT(a.FirstName, ' ', a.LastName)
FROM `Authors` a
       LEFT JOIN `Books` b ON b.Id_Author = a.Id
WHERE b.Quantity = 3
  - -9
SELECT CONCAT(a.FirstName, ' ', a.LastName) AS "Author", SUM(b.Price + 0) AS "Price"
FROM `Authors` a
       LEFT JOIN `Books` b ON b.Id_Author = a.Id
GROUP BY a.FirstName
           - -10
SELECT DISTINCT CONCAT(a.FirstName, ' ', a.LastName) AS "Author"
FROM `Authors` a
       LEFT JOIN `Books` b ON b.Id_Author = a.Id
       LEFT JOIN `S_Cards` c ON c.Id_Book = b.Id
WHERE DATEDIFF(CURDATE(), c.DateOut) > 117