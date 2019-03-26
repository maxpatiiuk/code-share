--1
SELECT p.name AS "Name"
FROM (SELECT p.name, COUNT(p.id) AS "Count"
      FROM `Press` p
             LEFT JOIN `Books` b ON b.id_press = p.id
             LEFT JOIN `S_Cards` c ON c.id_book = b.id) AS p
WHERE Count > 2
GROUP BY p.Name
ORDER BY Count DESC
  --2
SELECT COUNT(b.Name)
FROM (SELECT DISTINCT c.Name
      FROM `Categories` c
             INNER JOIN `Books` b ON b.id_category = c.id
             INNER JOIN `S_Cards` sc ON sc.id_book = b.id
      WHERE LENGTH(sc.DateIn) > 1
        AND sc.DateOut BETWEEN CAST("2000-01-01" AS DATE) AND CAST("2010-01-01" AS DATE)) AS b --3
SELECT p.*
FROM `Press` p
WHERE p.id = ANY (SELECT p.Id
                  FROM (SELECT p.id, COUNT(b.id) AS count
                        FROM `Press` p
                               INNER JOIN `Books` b ON b.id_press = p.id
                        WHERE b.quantity < 2
                        GROUP BY p.id) AS p)
        - -4
SELECT DISTINCT name
FROM (
       SELECT DISTINCT b.name
       FROM `Books` b
              RIGHT JOIN `S_Cards` sc ON sc.id_book = b.id
       WHERE LENGTH(b.name) > 1
         AND b.name IS NOT NULL
       UNION
       SELECT DISTINCT b.name
       FROM `Books` b
       WHERE b.price + 0 < 50
     ) AS t --5
SELECT b.name
FROM `Books` b
WHERE b.price + 0 > ALL (
  SELECT b2.price + 0
  FROM `Books` b2
         RIGHT JOIN `Press` p ON b2.id_press = p.id
  WHERE p.name LIKE "П%"
)
        - -6
SELECT b.name
FROM `Books` b
WHERE b.price + 0 > (
                      SELECT MAX(b2.price + 0)
                      FROM `Books` b2
                             RIGHT JOIN `Press` p ON b2.id_press = p.id
                      WHERE p.name LIKE "П%"
                    )
  - -7
SELECT DISTINCT b.name
FROM `Books` b
       INNER JOIN `S_Cards` sc ON sc.id_book = b.id
WHERE sc.DateOut IS NOT NULL
  AND LENGTH(sc.DateOut) > 1
  AND ((YEAR(sc.DateOut) % 4 = 0 AND YEAR(sc.DateOut) % 100 <> 0) OR YEAR(sc.DateOut) % 400 = 0)
  - -8
SELECT f.name, CONCAT(s.FirstName, ' ', s.LastName)
FROM `Faculties` f
       INNER JOIN `Groups` g ON g.id_faculty = f.id
       INNER JOIN `Students` s ON s.id_group = g.id
WHERE NOT EXISTS(
              SELECT DISTINCT s2.id
              FROM `Students` s2
                     INNER JOIN `S_Cards` sc ON sc.id_student = s2.id
              WHERE s2.id = s.id
            )
  - -9
SELECT MIN(YEAR(sc.DateOut)) INTO @minYear
FROM `S_Cards` sc;
SELECT @minYear + sc.id
FROM `S_Cards` sc
WHERE NOT EXISTS(
              SELECT sc2.id FROM `S_Cards` sc2 WHERE YEAR(sc2.DateOut) = @minYear + sc.id
            )
  - -10
SELECT t.FirstName
FROM `Teachers` t
WHERE NOT EXISTS(SELECT s.id FROM `Students` s WHERE s.FirstName = t.FirstName)