/*1*/SELECT 'Count' AS name, COUNT(id) AS value
     FROM `Books`
     UNION
     SELECT 'Max price', MAX(Price + 0)
     FROM `Books`
     UNION
     SELECT 'Average price', AVG(Price + 0)
     FROM `Books`;
/*2*/SELECT COUNT(id)
     FROM `Books`
     WHERE YearPres > 2010;
/*3*/SELECT MIN(b.Price + 0), p.Name
     FROM `Books` b,
          `Press` p
     WHERE b.Id_Press = p.id
     GROUP BY p.Name AND DATEDIFF(b.YearPress, CURDATE()) < 20
     ORDER BY p.Name;
/*4*/SELECT b.Name
     FROM `Books` b
     WHERE b.Id_Category = (SELECT most.Id
                            FROM (SELECT Count(b.Id) AS count, c.Id
                                  FROM `Categories` c,
                                       `Books` b
                                  WHERE b.Id_Category = c.Id
                                  GROUP BY c.Id
                                  ORDER BY count
                                  LIMIT 1) AS most)
/*5*/SELECT DISTINCT b.Name
     FROM `Books` b,
          `S_Cards` s
     WHERE s.id_Book = b.Id
       AND s.Id_Lib = (
       SELECT s.Id_Lib
       FROM (SELECT COUNT(s.Id) AS cou, s.Id_Lib FROM `S_Cards` s GROUP BY s.Id_Lib ORDER BY cou DESC LIMIT 1) AS s
     )
/*6*/SELECT COUNT(c.id) AS books_taken, g.Name
     FROM `S_Cards` c,
          `Students` s,
          `Groups` g
     WHERE s.Id_Group = g.Name
     GROUP BY g.Name
     ORDER BY books_taken DESC
     LIMIT 3;
/*7*/
SELECT Name, Price
FROM `Books`
WHERE Price + 0 > (SELECT avg(Price + 0) FROM `Books`)