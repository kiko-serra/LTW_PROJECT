from posixpath import supports_unicode_filenames
import string
import random
from urllib.parse import ParseResultBytes

def generate_random_password(length):

    base = string.ascii_letters
    base +=string.punctuation
    base +=string.digits

    password = "".join([random.choice(base) for _ in range(length)])
    return password

def trim(line):
    return str(line).replace("\n","")
def read_random_lines(filename,n):
    lines_to_read = set()
    with open(filename,"r") as f:
        lines = f.readlines()
    while len(lines_to_read) < n:
        lines_to_read.add(random.randint(0,len(lines)-1))
    res = [trim(lines[c]) for c in lines_to_read]
    return res 

class User :
    def __init__(self,name,surname,number,address):
        self.name= name
        self.surname= surname 
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
        return self.name + "_"  + self.surname
    def get_email(self):
        return (self.name + "."+ self.surname).lower() + str(random.randint(0,100)) + "@hotmail.com"
    @classmethod
    def generate_random_users(_class,name_f,surname_f,phone_f,address_f,count):
        names = read_random_lines(name_f,count)
        surnames = read_random_lines(surname_f,count)
        phones = read_random_lines(phone_f,count)
        addresses= read_random_lines(address_f,count)
        zipped = zip(names,surnames,phones,addresses)
        return [User(*z) for z in zipped ]





if __name__ == "__main__":
    name_f = "data/names.txt"
    surname_f ="data/surnames.txt"
    phone_f = "data/phoneNumbers.txt"
    address_f= "data/address.txt"
    tup = (name_f,surname_f,phone_f,address_f,20)
    usrs =User.generate_random_users(*tup)
  