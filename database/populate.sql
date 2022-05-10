PRAGMA foreign_keys = on;
BEGIN TRANSACTION;

INSERT INTO User VALUES (1, 'John', 'Doe', 'tromp.beaulah@herman.com', '553 Boulevard Saint-Séverin, 0 étage, 17677, Montpellier, Nord-Pas-de-Calais, France', 'Aspect', '(611) 976-2286', '12345');
INSERT INTO User VALUES (2, 'Michael', 'Chen', 'feil.ibrahim@mayer.info', '599 Rue Joubert, Apt. 089, 40785, Besançon, Centre, France', 'Kraken', '(582) 318-4286', '54321');

INSERT INTO Photo VALUES (1, 1);

INSERT INTO Restaurant VALUES (1, 'Parallel 37', '6 Rue de Richelieu, 7 étage, 78682, Villeneuve-dAscq, Languedoc-Roussillon, France', 'Gastronomie', 4.5, 'Restaurant de cuisine française');

INSERT INTO Menu VALUES (1, 'Salade de poireaux', 10, 'Salade de poireaux', 1, 1);

INSERT INTO Dish VALUES (1, 'Salade de FRANGO', 'Gourmet');

INSERT INTO ORDER2 VALUES (1, 2, 12);

INSERT INTO Review VALUES (1, 1, 'Excellente salade de poireaux', 4);


INSERT INTO MenuInOrder VALUES (1, 1);

INSERT INTO DishInMenu VALUES (1, 1);

INSERT INTO RestaurantOwner VALUES (1, 1, 432);

COMMIT TRANSACTION;