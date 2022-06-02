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

DROP TABLE IF EXISTS Category;

-- Table: User
CREATE TABLE User (
    id_user INTEGER PRIMARY KEY AUTOINCREMENT,
    first_name TEXT CONSTRAINT null_User_firstName NOT NULL,
    last_name TEXT CONSTRAINT null_User_lastName NOT NULL,
    email TEXT CONSTRAINT null_User_email NOT NULL CONSTRAINT unique_User_email UNIQUE,
    address TEXT,
    username TEXT CONSTRAINT null_User_username NOT NULL CONSTRAINT unique_User_username UNIQUE,
    phone_number TEXT CONSTRAINT unique_User_phoneNumber UNIQUE,
    password TEXT CONSTRAINT null_User_password NOT NULL
);

-- Table: Restaurant
CREATE TABLE Restaurant (
    id_restaurant INTEGER PRIMARY KEY,
    name TEXT CONSTRAINT null_Restaurant_name NOT NULL,
    address TEXT CONSTRAINT null_Restaurant_address NOT NULL,
    category INTEGER REFERENCES Category ON DELETE CASCADE ON UPDATE CASCADE,
    review_score INTEGER,
    title TEXT,
    id_photo INTEGER REFERENCES Photo ON DELETE
    SET
        NULL ON UPDATE CASCADE
);

-- Table: Menu
CREATE TABLE Menu (
    id_menu INTEGER PRIMARY KEY,
    name TEXT CONSTRAINT null_Menu_name NOT NULL,
    price INTEGER CONSTRAINT null_Menu_price NOT NULL,
    description TEXT,
    category INTEGER REFERENCES Category ON DELETE CASCADE ON UPDATE CASCADE,
    id_restaurant INTEGER REFERENCES Restaurant ON DELETE CASCADE ON UPDATE CASCADE,
    id_photo INTEGER REFERENCES Photo ON DELETE
    SET
        NULL ON UPDATE CASCADE
);

-- Table: Dish
CREATE TABLE Dish (
    id_dish INTEGER PRIMARY KEY,
    name TEXT CONSTRAINT null_Dish_name NOT NULL,
    category INTEGER REFERENCES Category ON DELETE CASCADE ON UPDATE CASCADE,
    id_photo INTEGER REFERENCES Photo ON DELETE
    SET
        NULL ON UPDATE CASCADE
);

-- Table: ORDER2
CREATE TABLE ORDER2 (
    id_order INTEGER PRIMARY KEY,
    id_user INTEGER REFERENCES User ON DELETE
    SET
        NULL ON UPDATE CASCADE,
        price INTEGER CONSTRAINT null_Order_price NOT NULL
);

-- Table: Review
CREATE TABLE Review (
    id_review INTEGER PRIMARY KEY,
    id_order INTEGER REFERENCES ORDER2 ON DELETE
    SET
        NULL ON UPDATE CASCADE,
        comment TEXT CONSTRAINT null_Review_comment NOT NULL,
        rating INTEGER CONSTRAINT null_Review_rating NOT NULL
);

-- Table: Photo
CREATE TABLE Photo (
    id_photo INTEGER PRIMARY KEY,
    link TEXT
);

-- Table: MenuInOrder
CREATE TABLE MenuInOrder (
    id_menu INTEGER REFERENCES Menu ON DELETE CASCADE ON UPDATE CASCADE,
    id_order INTEGER REFERENCES ORDER2 ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY(id_menu, id_order)
);

-- Table: DishInMenu
CREATE TABLE DishInMenu (
    id_menu INTEGER REFERENCES Menu ON DELETE CASCADE ON UPDATE CASCADE,
    id_dish INTEGER REFERENCES Dish ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY(id_menu, id_dish)
);

-- Table: RestaurantOwner
CREATE TABLE RestaurantOwner (
    id_user INTEGER REFERENCES User ON DELETE CASCADE ON UPDATE CASCADE,
    id_restaurant INTEGER REFERENCES Restaurant ON DELETE CASCADE ON UPDATE CASCADE,
    balance INTEGER CONSTRAINT null_RestaurantOwner_balance NOT NULL,
    PRIMARY KEY(id_user, id_restaurant)
);

-- Table: Category
CREATE TABLE Category (
    id_category INTEGER PRIMARY KEY,
    name TEXT CONSTRAINT null_Menu_name NOT NULL,
    id_photo INTEGER REFERENCES Photo ON DELETE
    SET
        NULL ON UPDATE CASCADE
);

COMMIT TRANSACTION;

PRAGMA foreign_keys = on;


INSERT INTO Photo (id_photo,link) VALUES
   (1,"https://www.mashed.com/img/gallery/this-is-how-hamburgers-really-got-their-name/l-intro-1599897652.jpg"),
   (2,"https://claudia.abril.com.br/wp-content/uploads/2020/07/pizza-pepperoni.jpg"),
   (3,"https://claudia.abril.com.br/wp-content/uploads/2020/07/pizza-pepperoni.jpg"),
   (4,"https://insanelygoodrecipes.com/wp-content/uploads/2021/05/Cherry-Cheesecake-with-Berry-Sauce.png"),
   (5,"https://media.glamour.com/photos/61bcb8f968c608fa532e0bbc/3:4/w_1500,h_2000,c_limit/healthy%20food%20delivery.jpg"),
   (6,"https://www.thespruceeats.com/thmb/I_M3fmEbCeNceaPrOP5_xNZ2xko=/3160x2107/filters:fill(auto,1)/vegan-tofu-tikka-masala-recipe-3378484-hero-01-d676687a7b0a4640a55be669cba73095.jpg"),
   (7,"https://myfoodbook.com.au/sites/default/files/collections_image/passage_to_asia_honey_soy_chicken_and_vegetable_skewers.jpg"),
   (8,"https://assets.bonappetit.com/photos/5b9a901947aaaf7cd9ea90f2/2:3/w_1874,h_2811,c_limit/ba-recipe-pasta-al-limone.jpg"),
   (9,"https://www.thespruceeats.com/thmb/X6mg_2VBCQQ2X8VrLcPTf8_4ce0=/2733x2050/smart/filters:no_upscale()/chinese-take-out-472927590-57d31fff3df78c5833464e7b.jpg"),
    (10,"https://www.thespruceeats.com/thmb/TTsydZkvlx25nvMQPZq0wB5o87c=/1500x1500/smart/filters:no_upscale()/GettyImages-1042998066-518ca1d7f2804eb09039e9e42e91667c.jpg");


INSERT INTO Category (id_category, name,id_photo)
VALUES 
   (1, "Hamburgers",1),
   (2, "Pizza",2),
   (3, "Sushi",3),
   (4, "Desserts",4),
   (5, "Healthy",5),
   (6, "Indian Food",6),
   (7, "Barbecue",7),
   (8, "Pasta",8),
   (9, "Chinese Food",9),
    (10, "Thai Food",10);
