DROP TABLE IF EXISTS Category;

CREATE TABLE Category (
    id_category  INTEGER PRIMARY KEY,
    name        TEXT CONSTRAINT null_Menu_name NOT NULL
);


INSERT INTO Category (id_category, name)
VALUES 
   (1, "Hamburgers"),
   (2, "Pizza"),
   (3, "Sushi"),
   (4, "Desserts"),
   (5, "Healthy"),
   (6, "Indian Food"),
   (7, "Barbecue"),
   (8, "Pasta"),
   (9, "Chinese Food"),
    (10, "Thai Food");
