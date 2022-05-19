import string
import random
import sqlite3

import download_images


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


class User:
    def __init__(self, name, surname, number, address):
        self.name = name
        self.surname = surname
        self.number = number
        self.address = address

        self.nickname = self.get_nick()
        self.password = generate_random_password(10)
        self.email = self.get_email()

    def __str__(self) -> str:
        return f"""<{self.name} {self.surname}> Nº:{self.number} A:{self.address}
        Nick:{self.nickname}
        @:{self.email}
        """

    def get_nick(self):
        return self.name + "_" + self.surname

    def get_email(self):
        return (self.name + "." + self.surname).lower() + str(random.randint(0, 100)) + "@hotmail.com"

    def save(self,cur):
        cur.execute("insert into User (first_name,last_name,email, address,username,phone_number,password) values (?,?,?,?,?,?,?)",
            (self.name,self.surname,self.email,self.address,self.nickname,self.number,self.password))



    @classmethod
    def generate_random_users(_class, name_f, surname_f, phone_f, address_f, count):
        names = read_random_lines(name_f, count)
        surnames = read_random_lines(surname_f, count)
        phones = read_random_lines(phone_f, count)
        addresses = read_random_lines(address_f, count)
        zipped = zip(names, surnames, phones, addresses)
        return [User(*z) for z in zipped]


class Dish:
    def __init__(self,name) -> None:
        self.name = name
        self.category =Dish.get_category()
    
    def save(self,cur):
        cur.execute("insert into Dish (name,category) values (?,?",
        (self.name, self.category))
    
    def __str__(self) -> str:
        return f"<{self.name} : {self.category}"
    @classmethod
    def get_category(_class):
        cat = ["Fast Food", "Traditional", "French Cuisine",
            "Italian", "Indian", "Sushi", "Chinese"]
        return random.choice(cat)
    
    @classmethod
    def generate_random_dishes(_class,dish_f,count):
        dish_names = read_random_lines(dish_f,count)
        return [Dish(name) for name in dish_names]

  

class Restaurant:
    max_rating = 5

    def __init__(self, name, address):
        self.name = name
        self.address = address

        self.category = Restaurant.get_category()
        self.description = self.get_description()
        self.review = Restaurant.get_review()

    def __str__(self) -> str:
        return f"""<{self.name}> C: {self.category}
        -> {self.description}

        Stars: {self.review}
        """

    def get_description(self):
        return f"This is a {self.category} restaurant"

    def save(self, cur):
        cur.execute(
            "insert into Restaurant (name,address,category,review_score,title) values (?,?,?,?,?)",
            (self.name,self.address,self.category,self.review,self.description))

    @classmethod
    def get_category(_class):
        cat = ["Fast Food", "Traditional", "French Cuisine",
            "Italian", "Indian", "Sushi", "Chinese"]
        return random.choice(cat)

    @classmethod
    def get_review(_class):
        return round(random.randint(0, 5*1000) / 1000.0, 3)

    @classmethod
    def generate_random_restaurants(_class, name_f, address_f,count):
        names = read_random_lines(name_f, count)
        addresses = read_random_lines(address_f, count)
        zipped = zip(names, addresses)
        return [Restaurant(*z) for z in zipped]

class Photo:
    def __init__(self,link) -> None:
        self.link = link
    def save(self,cur):
        cur.execute("insert into Photo (link) values (?)",(self.link))
    def __str__(self) -> str:
        return self.link
    @classmethod
    def generate_photos(_class,names):
        links = download_images.get_links_paralel(names)
        return [Photo(link) for link in links]
        
    

if __name__ == "__main__":
    name_f = "data/names.txt"
    surname_f = "data/surnames.txt"
    phone_f = "data/phoneNumbers.txt"
    address_f = "data/address.txt"
    rest_f = "data/restaurantNames.txt"
    dish_f = "data/Dishnames.txt"
    tup = (name_f, surname_f, phone_f,address_f,20)
    usrs = User.generate_random_users(*tup)
    rest = Restaurant.generate_random_restaurants(rest_f, address_f, 30)
    dishs = Dish.generate_random_dishes(dish_f,50)
    photos = Photo.generate_photos([d.name for d in dishs])
    """ 
    con = sqlite3.connect("../uber.db")
    cur = con.cursor()

    for r in rest:
        r.save(cur)
    
    for u in usrs:
        u.save(cur)
    
    for r in cur.execute("select * from Restaurant "):
        print(r)
    
    for u in cur.execute("select * from User"):
        print(u)

    con.commit()

    con.close()
    """
    for d in photos:
        print("\n"*5)
        print(d)