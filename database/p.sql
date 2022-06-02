DROP TABLE IF EXISTS Category;

CREATE TABLE Category (
    id_category  INTEGER PRIMARY KEY,
    name        TEXT CONSTRAINT null_Menu_name NOT NULL,
    image_link  TEXT CONSTRAINT null_image_category NOT NULL
);


INSERT INTO Category (id_category, name, image_link)
VALUES 
   (1, "Hamburgers","https://www.mashed.com/img/gallery/this-is-how-hamburgers-really-got-their-name/l-intro-1599897652.jpg"),
   (2, "Pizza","https://claudia.abril.com.br/wp-content/uploads/2020/07/pizza-pepperoni.jpg"),
   (3, "Sushi","https://claudia.abril.com.br/wp-content/uploads/2020/07/pizza-pepperoni.jpg"),
   (4, "Desserts","https://insanelygoodrecipes.com/wp-content/uploads/2021/05/Cherry-Cheesecake-with-Berry-Sauce.png"),
   (5, "Healthy","https://media.glamour.com/photos/61bcb8f968c608fa532e0bbc/3:4/w_1500,h_2000,c_limit/healthy%20food%20delivery.jpg"),
   (6, "Indian Food","https://www.thespruceeats.com/thmb/I_M3fmEbCeNceaPrOP5_xNZ2xko=/3160x2107/filters:fill(auto,1)/vegan-tofu-tikka-masala-recipe-3378484-hero-01-d676687a7b0a4640a55be669cba73095.jpg"),
   (7, "Barbecue","https://myfoodbook.com.au/sites/default/files/collections_image/passage_to_asia_honey_soy_chicken_and_vegetable_skewers.jpg"),
   (8, "Pasta","https://assets.bonappetit.com/photos/5b9a901947aaaf7cd9ea90f2/2:3/w_1874,h_2811,c_limit/ba-recipe-pasta-al-limone.jpg"),
   (9, "Chinese Food","https://www.thespruceeats.com/thmb/X6mg_2VBCQQ2X8VrLcPTf8_4ce0=/2733x2050/smart/filters:no_upscale()/chinese-take-out-472927590-57d31fff3df78c5833464e7b.jpg"),
    (10, "Thai Food","https://www.thespruceeats.com/thmb/TTsydZkvlx25nvMQPZq0wB5o87c=/1500x1500/smart/filters:no_upscale()/GettyImages-1042998066-518ca1d7f2804eb09039e9e42e91667c.jpg");

