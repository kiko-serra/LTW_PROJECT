PRAGMA foreign_keys = on;

BEGIN TRANSACTION;

DROP TABLE IF EXISTS RestaurantOwner;
DROP TABLE IF EXISTS DishInMenu;
DROP TABLE IF EXISTS MenuInOrder;
DROP TABLE IF EXISTS Photo;
DROP TABLE IF EXISTS Review;
DROP TABLE IF EXISTS ORDER2;
DROP TABLE IF EXISTS Dish;
DROP TABLE IF EXISTS Menu;
DROP TABLE IF EXISTS Restaurant;
DROP TABLE IF EXISTS User;


-- Table: User


CREATE TABLE User (
    id_user   INTEGER PRIMARY KEY AUTOINCREMENT,
    first_name  TEXT CONSTRAINT null_User_firstName NOT NULL,
    last_name   TEXT CONSTRAINT null_User_lastName NOT NULL,
    email       TEXT CONSTRAINT null_User_email NOT NULL CONSTRAINT unique_User_email UNIQUE,
    address     TEXT,
    username   TEXT CONSTRAINT null_User_username NOT NULL CONSTRAINT unique_User_username UNIQUE,
    phone_number TEXT CONSTRAINT unique_User_phoneNumber UNIQUE,
    password    TEXT CONSTRAINT null_User_password NOT NULL
);

-- Table: Restaurant


CREATE TABLE Restaurant (
    id_restaurant     INTEGER PRIMARY KEY,
    name      TEXT CONSTRAINT null_Restaurant_name NOT NULL,
    address   TEXT CONSTRAINT null_Restaurant_address NOT NULL,
    category  TEXT CONSTRAINT null_Restaurant_category NOT NULL,
    review_score  INTEGER,
    title TEXT
);

-- Table: Menu


CREATE TABLE Menu (
    id_menu  INTEGER PRIMARY KEY,
    name        TEXT CONSTRAINT null_Menu_name NOT NULL CONSTRAINT unique_Menu_name UNIQUE,
    price      INTEGER CONSTRAINT null_Menu_price NOT NULL,
    description TEXT,
    id_restaurant INTEGER REFERENCES Restaurant ON DELETE CASCADE ON UPDATE CASCADE,
    id_photo INTEGER REFERENCES Photo ON DELETE SET NULL ON UPDATE CASCADE
);

-- Table: Dish


CREATE TABLE Dish (
    id_dish       INTEGER PRIMARY KEY,
    name         TEXT CONSTRAINT null_Dish_name NOT NULL CONSTRAINT unique_Dish_name UNIQUE,
    category     TEXT CONSTRAINT null_Dish_category NOT NULL
);

-- Table: ORDER2


CREATE TABLE ORDER2 (
    id_order  INTEGER PRIMARY KEY,
    id_user   INTEGER REFERENCES User ON DELETE SET NULL ON UPDATE CASCADE,
    price     INTEGER CONSTRAINT null_Order_price NOT NULL
);

-- Table: Review


CREATE TABLE Review (
    id_review        INTEGER PRIMARY KEY,
    id_order     INTEGER REFERENCES ORDER2 ON DELETE SET NULL ON UPDATE CASCADE,
    comment     TEXT CONSTRAINT null_Review_comment NOT NULL,
    rating      INTEGER CONSTRAINT null_Review_rating NOT NULL
);

-- Table: Photo


CREATE TABLE Photo (
    id_photo   INTEGER PRIMARY KEY,
    link TEXT,
    photo     BLOB CONSTRAINT null_Photo_photo NOT NULL

);

-- Table: MenuInOrder


CREATE TABLE MenuInOrder (
    id_menu      INTEGER REFERENCES Menu ON DELETE CASCADE ON UPDATE CASCADE,
    id_order     INTEGER REFERENCES ORDER2 ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY(id_menu, id_order)
);

-- Table: DishInMenu


CREATE TABLE DishInMenu (
    id_menu      INTEGER REFERENCES Menu ON DELETE CASCADE ON UPDATE CASCADE,
    id_dish      INTEGER REFERENCES Dish ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY(id_menu, id_dish)
);

-- Table: RestaurantOwner


CREATE TABLE RestaurantOwner (
    id_user   INTEGER REFERENCES User ON DELETE CASCADE ON UPDATE CASCADE,
    id_restaurant INTEGER REFERENCES Restaurant ON DELETE CASCADE ON UPDATE CASCADE,
    balance   INTEGER CONSTRAINT null_RestaurantOwner_balance NOT NULL,
    PRIMARY KEY(id_user, id_restaurant)
);

COMMIT TRANSACTION;

PRAGMA foreign_keys = on;