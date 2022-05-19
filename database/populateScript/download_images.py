from bs4 import BeautifulSoup
from selenium import webdriver
from selenium.webdriver.chrome.service import Service
import concurrent.futures
from webdriver_manager.chrome import ChromeDriverManager
from selenium.webdriver.chrome.options import Options

import time


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
    endlink = "&tbm=isch&sxsrf=APq-WBu23ameSt6T0wLcGlNCW_n33zVYew%3A1650995376968&source=hp&biw=1536&bih=732&ei=sDBoYpWNOeePlwTOkJi4Bg&iflsig=AHkkrS4AAAAAYmg-wCGFq9kD666nb7zO7-EhNGw6vkAz&ved=0ahUKEwiVpd-HpbL3AhXnx4UKHU4IBmcQ4dUDCAc&uact=5&oq=Striped+bass+saute+meuniere&gs_lcp=CgNpbWcQAzoHCCMQ7wMQJzoFCAAQgAQ6CggjEO8DEOoCECdQAFjsCmCiDWgBcAB4AIABmQGIAYkCkgEDMC4ymAEAoAEBoAECqgELZ3dzLXdpei1pbWewAQo&sclient=img"
    parsed_name = parse_query_word(dish_name)
    return inlink + parsed_name + endlink


def accept_cookie(driver):
    cookie = driver.find_element_by_css_selector("button.")
    cookie.click()
    time.sleep(0.5)


def get_dish_photo_link(dish_name, driver):
    link = get_query(dish_name)
    driver.get(link)
    innerHTML = driver.execute_script("return document.body.innerHTML")
    soup = BeautifulSoup(innerHTML, "html.parser")
    imagem = soup.find(attrs={'class': 'rg_i'})
    try:
        return imagem.attrs["src"]
    except:
        driver.refresh()
        driver.get(link)
        driver.delete_all_cookies()
        innerHTML = driver.execute_script("return document.body.innerHTML")
        soup = BeautifulSoup(innerHTML, "html.parser")
        imagem = soup.find(attrs={'class': 'rg_i'})
        try:
            return imagem.attrs["src"]
        except:
            driver.maximize_window()
            driver.refresh()
            driver.get('https://www.google.com/')
            driver.get(link)
            print("Link:", link)
            print("DISH:", dish_name)
            try:
                innerHTML = driver.execute_script(
                    "return document.body.innerHTML")
                soup = BeautifulSoup(innerHTML, "html.parser")
                imagem = soup.find(attrs={'class': 'rg_i'})
                return imagem.attrs["src"]
            except:
                return "bad link"


def get_img(link, name):
    return f'<tr><td>{name}</td><td><img src="{link}"></td></tr>\n'


def write_html(list_links, names):
    with open("index.html", "w") as f:
        f.write(
            "<!DOCTYPE html> <html> <head> <meta charset='utf-8'> <title>comidas</title> </head> <body> ")
        f.write("<table>")
        for i in range(len(list_links)):
            f.write(get_img(list_links[i], names[i]))
        f.write("</table>")
        f.write("</body> </html>")


def get__dishes_names(number_dishes):
    to_return = []
    with open("data/Dish.csv", "r") as f:
        header = f.readline()
        for i in range(number_dishes):
            to_return.append(f.readline().split(",")[1])
    return to_return


def get_dishes_link(dishes):
    driver = init_driver()
    dishes_links = []
    for dish in dishes:
        dishes_links.append(get_dish_photo_link(dish, driver))
    try:
        driver.quit()
    except:
        print("COuldn't quit browser don't know why")
    return dishes_links


def multi_thread_get_dish_links(dishes, threads):
    dishes_threads = []
    counter = 0
    dishes_per_list = int(len(dishes)/threads)
    for i in range(threads):
        list_dishes = []
        for c in range(dishes_per_list):
            list_dishes.append(dishes[counter])
            counter += 1
        dishes_threads.append(list_dishes)

    # Putting whats left in the last list
    dishes_threads[-1] += dishes[counter:]
    all_links = []
    with concurrent.futures.ThreadPoolExecutor() as executor:
        results = executor.map(get_dishes_link, dishes_threads)
        for result in results:
            all_links.extend(result)

    return all_links

def get_links_paralel(dishes_names):
    links = multi_thread_get_dish_links(dishes_names,10)
    return links



def main_paralel():
    start = time.perf_counter()
    dishes = get__dishes_names(100)
    links = multi_thread_get_dish_links(dishes, 20)
    write_html(links, dishes)
    finish = time.perf_counter()
    delta = finish - start
    print(f"Took about {(delta)}s : {round(delta/60,3)} min")


def main_sync():
    start = time.perf_counter()
    dishes = get__dishes_names(100)
    links = get_dishes_link(dishes)
    write_html(links, dishes)
    finish = time.perf_counter()
    delta = finish - start
    print(f"Took about {(delta)}s : {round(delta/60,3)} min")


def pretify_html(html_doc):
    with open(html_doc, "r") as f_html:
        soup = BeautifulSoup(f_html, "html.parser")

    splited_name = html_doc.split(".")
    new_name = ".".join(splited_name[:-1]) + "_pretty" + "." + splited_name[-1]
    with open(new_name, "w") as f:
        for line in soup.prettify():
            f.write(line)


if __name__ == "__main__":
    main_paralel()
    #pretify_html("index.html")
