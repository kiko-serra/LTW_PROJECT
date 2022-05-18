from bs4 import BeautifulSoup
from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from webdriver_manager.chrome import ChromeDriverManager

def init_driver():
    opt = Options()
    opt.add_argument("--no-sandbox")
    opt.add_argument('--ignore-certificate-errors')
    opt.add_argument('--ignore-ssl-errors')
    opt.add_argument('--ignore-gpu-blacklist')
    opt.add_argument('--use-gl')
    opt.add_argument('--disable-web-security')
    opt.add_experimental_option(
        "prefs", {"profile.default_content_setting_values.cookies": 2})
    driver = webdriver.Chrome(service=Service(
        ChromeDriverManager().install()), options=opt)
    #driver.minimize_window()
    return driver


def parse_query_word(query_word):
    res = query_word.split(" ")
    res = "+".join(res)
    return res


def get_query(dish_name):
    inlink = "https://www.google.com/search?q="
    endlink= "&tbm=isch&sxsrf=APq-WBu23ameSt6T0wLcGlNCW_n33zVYew%3A1650995376968&source=hp&biw=1536&bih=732&ei=sDBoYpWNOeePlwTOkJi4Bg&iflsig=AHkkrS4AAAAAYmg-wCGFq9kD666nb7zO7-EhNGw6vkAz&ved=0ahUKEwiVpd-HpbL3AhXnx4UKHU4IBmcQ4dUDCAc&uact=5&oq=Striped+bass+saute+meuniere&gs_lcp=CgNpbWcQAzoHCCMQ7wMQJzoFCAAQgAQ6CggjEO8DEOoCECdQAFjsCmCiDWgBcAB4AIABmQGIAYkCkgEDMC4ymAEAoAEBoAECqgELZ3dzLXdpei1pbWewAQo&sclient=img"
    parsed_name = parse_query_word(dish_name)
    return inlink + parsed_name + endlink

def get_dish_photo_link(dish_name,driver):
    link = get_query(dish_name)
    driver.get(link)
    innerHTML = driver.execute_script("return document.body.innerHTML")
    soup = BeautifulSoup(innerHTML, "html.parser")
    #print(soup.prettify())
    imagem = soup.find(attrs={'class': 'rg_i'})
    print(link)
    return imagem.attrs["src"]


def get_img(link,name):
    return f'<tr><td>{name}</td><td><img src="{link}"></td></tr>'
    
def write_html(list_links,names):
    with open("index.html","w") as f:
        f.write("<!DOCTYPE html> <html> <head> <meta charset='utf-8'> <title>comidas</title> </head> <body> ")
        f.write("<table>")
        for i in range(len(list_links)):
            f.write(get_img(list_links[i],names[i]))
        f.write("</table>")
        f.write( "</body> </html>")


def get__dishes_names(number_dishes):
    to_return= []
    with open("Dish.csv","r") as f:
        header= f.readline()
        for i in range(number_dishes):
            to_return.append(f.readline().split(",")[1])
    return to_return

def main():
    driver = init_driver()
    dishes = get__dishes_names(5)
    dishes_links= []
    for dish in dishes:
        dishes_links.append(get_dish_photo_link(dish,driver))
    write_html(dishes_links,dishes)


if __name__ == "__main__":
    main()
