from re import I
import string
import random
import sqlite3

import download_images

from abc import ABC, abstractmethod


def generate_random_password(length):

    base = string.ascii_letters
    base += string.punctuation
    base += string.digits

    password = "".join([random.choice(base) for _ in range(length)])
    return password


def trim(line):
    return str(line).replace("\n", "")


def read_random_lines(filename, n):
    lines_to_read = set()
    with open(filename, "r") as f:
        lines = f.readlines()
    while len(lines_to_read) < n:
        lines_to_read.add(random.randint(0, len(lines)-1))
    res = [trim(lines[c]) for c in lines_to_read]
    return res


class Savable(ABC):
    current_id = 0

    @classmethod
    def get_id(cls):
        id = cls.current_id
        cls.current_id += 1
        return id

    @classmethod
    def set_id(cls, new_id):
        cls.current_id = new_id

    @abstractmethod
    def save(self, cur):
        pass


class User(Savable):

    def __init__(self, name, surname, number, address):
        self.name = name
        self.surname = surname
        self.number = number
        self.address = address

        self.nickname = self.get_nick()
        self.password = generate_random_password(10)
        self.email = self.get_email()
        self.id = User.get_id()

    def __str__(self) -> str:
        return f"""<{self.name} {self.surname}> Nº:{self.number} A:{self.address}
        Nick:{self.nickname}
        @:{self.email}
        """

    def get_nick(self):
        return self.name + "_" + self.surname

    def get_email(self):
        return (self.name + "." + self.surname).lower() + str(random.randint(0, 100)) + "@hotmail.com"

    def save(self, cur):
        cur.execute("insert into User (first_name,last_name,email, address,username,phone_number,password) values (?,?,?,?,?,?,?)",
                    (self.name, self.surname, self.email, self.address, self.nickname, self.number, self.password))

    @classmethod
    def generate_random_users(cls, name_f, surname_f, phone_f, address_f, count):
        names = read_random_lines(name_f, count)
        surnames = read_random_lines(surname_f, count)
        phones = read_random_lines(phone_f, count)
        addresses = read_random_lines(address_f, count)
        zipped = zip(names, surnames, phones, addresses)
        return [User(*z) for z in zipped]


class Dish(Savable):
    def __init__(self, name,photo) -> None:
        self.name = name
        self.category = Dish.get_category()
        self.id = Dish.get_id()
        self.photo = photo

    def save(self, cur):
        self.photo.save(cur)
        cur.execute("insert into Dish (id_dish,name,category,id_photo) values (?,?,?,?)",
                    (self.id, self.name, self.category,self.photo.id))

    def __str__(self) -> str:
        return f"<{self.name} : {self.category}"

    @classmethod
    def get_category(cls):
        return random.randint(1,10)

    @classmethod
    def generate_random_dishes(cls, dish_f, count):
        dish_names = read_random_lines(dish_f, count)
        photos = Photo.generate_photos(dish_names)
        builder = zip(dish_names,photos)
        return [Dish(name,photo) for (name,photo) in builder]


class Restaurant(Savable):
    max_rating = 5

    def __init__(self, name, address,photo):
        self.name = name
        self.address = address

        self.category = Restaurant.get_category()
        self.description = self.get_description()
        self.review = Restaurant.get_review()
        self.id = Restaurant.get_id()
        self.photo = photo

    def __str__(self) -> str:
        return f"""<{self.name}> C: {self.category}
        -> {self.description}

        Stars: {self.review}
        """

    def get_description(self):
        return f"This is a very nice restaurant"

    def save(self, cur):
        self.photo.save(cur)
        cur.execute(
            "insert into Restaurant (id_restaurant,name,address,category,review_score,title,id_photo) values (?,?,?,?,?,?,?)",
            (self.id, self.name, self.address, self.category, self.review, self.description,self.photo.id))

    @classmethod
    def get_category(cls):
        return random.randint(1,10)

    @classmethod
    def get_review(cls):
        return round(random.randint(0, 5*1000) / 1000.0, 3)

    @classmethod
    def generate_random_restaurants(cls, name_f, address_f, count):
        names = read_random_lines(name_f, count)
        addresses = read_random_lines(address_f, count)
        photos = Photo.generate_photos(names)
        zipped = zip(names, addresses,photos)
        return [Restaurant(*z) for z in zipped]


class Photo(Savable):
    def __init__(self, link) -> None:
        self.link = link
        self.id = Photo.get_id()

    def save(self, cur):
        cur.execute("insert into Photo (id_photo,link) values (?,?)",
                    (self.id, self.link))

    def __str__(self) -> str:
        return self.link

    @classmethod
    def generate_photos(cls, names):
        links = download_images.get_links_paralel(names)
        return [Photo(link) for link in links]


class Menu(Savable):
    def __init__(self, restaurant_id, dishes):
        self.restaurant = restaurant_id
        self.dishes = dishes

        self.main_dish = self.get_main_dish()
        self.name = self.main_dish.name
        self.price = self.get_price()
        self.description = self.get_description()
        self.id = Menu.get_id()
        self.photo = ""

    def get_main_dish(self):
        return random.choice(self.dishes)

    def get_description(self):
        return f"This is a {self.main_dish.category} dish"

    def get_price(self):
        return len(self.dishes) * (random.randint(10, 50) / 10)

    def save(self, cur):
        cur.execute("insert into Menu (id_menu,name,price,description,id_restaurant,id_photo) values (?,?,?,?,?,?)",
                    (self.id, self.name, self.price, self.description, self.restaurant, self.main_dish.photo.id))

        for dish in self.dishes:
            cur.execute(
                "insert into DishInMenu (id_menu,id_dish) values (?,?)", (self.id, dish.id))

    def __str__(self) -> str:
        dish_names = "\n".join([d.name for d in self.dishes])
        return f"<Menu {self.name}> Price: {self.price} {dish_names}"

    @classmethod
    def generate_random_menus(cls, dishes,restaurant_id, count):
        res = []
        for i in range(count):
            n_items = random.randint(2, 5)
            uniques = set()
            current_len = 0
            items = []
            while len(uniques) != n_items:
                selected = random.choice(dishes)
                uniques.add(selected.id)
                if(len(uniques) > current_len):
                    current_len += 1
                    items.append(selected)
            res.append(Menu(restaurant_id,items))
            
        return res


def save_all(savable_list, cur):
    for savable in savable_list:
        savable.save(cur)


def populate_db():
    name_f = "data/names.txt"
    surname_f = "data/surnames.txt"
    phone_f = "data/phoneNumbers.txt"
    address_f = "data/address.txt"
    rest_f = "data/restaurantNames.txt"
    dish_f = "data/Dishnames.txt"
    Photo.set_id(20)
    tup = (name_f, surname_f, phone_f, address_f, 20)
    usrs = User.generate_random_users(*tup)
    rest = Restaurant.generate_random_restaurants(rest_f, address_f, 30)
    dishs = Dish.generate_random_dishes(dish_f, 50)
    menus = []
    for r in rest:
        menus.extend(Menu.generate_random_menus(dishs,r.id, 10))

    con = sqlite3.connect("../uber.db")
    cur = con.cursor()
    save_all(usrs, cur)
    save_all(rest, cur)
    save_all(dishs, cur)    
    save_all(menus, cur)
    con.commit()
    con.close()


if __name__ == "__main__":
    populate_db()
