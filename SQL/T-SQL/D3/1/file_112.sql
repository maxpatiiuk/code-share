CREATE TABLE Themes
(
  [
  id_theme]
  INT
  PRIMARY
  KEY
  DEFAULT
  0, [
  nameTheme]
  VARCHAR
(
  MAX
) NOT NULL
  );

CREATE TABLE country
(
  [
  id_country]
  INT
  PRIMARY
  KEY
  DEFAULT
  0, [
  nameCountry]
  VARCHAR
(
  MAX
) NOT NULL
  );

CREATE TABLE Authors
(
  [
  id_author]
  INT
  PRIMARY
  KEY
  DEFAULT
  0, [
  firstName]
  VARCHAR
(
  MAX
), [lastName] VARCHAR (MAX), [id_country] int FOREIGN KEY REFERENCES Country(id_country)
);

CREATE TABLE Shops
(
  [
  id_shop]
  INT
  PRIMARY
  KEY
  DEFAULT
  0, [
  nameShop]
  VARCHAR
(
  MAX
), [id_country] int FOREIGN KEY REFERENCES Country(id_country)
);

CREATE TABLE Books
(
  [
  id_book]
  INT
  PRIMARY
  KEY
  DEFAULT
  0, [
  nameBook]
  VARCHAR
(
  MAX
), [id_theme] INT FOREIGN KEY REFERENCES Themes(id_theme), [id_author] INT FOREIGN KEY REFERENCES Authors(id_author), [price] INT DEFAULT 10, [drawingOfBook] VARCHAR(MAX), [dateOfPublish] INT DEFAULT 0, [pages] int DEFAULT 100
);

CREATE TABLE Sales
(
  [
  id_sale]
  int
  PRIMARY
  KEY
  DEFAULT
  0, -
  -
  IDENTITY
(
  1,
  1
)
  [id_book] int FOREIGN KEY REFERENCES Books
(
  id_book
), [DateOfSale] int DEFAULT 1, [price] int DEFAULT 1, [quantity] int DEFAULT 1, [id_shop] int FOREIGN KEY REFERENCES Shops(id_shop)
);