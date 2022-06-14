const infoList = document.querySelector(".profile-info");
const details_button = document.querySelector("#details-button");
details_button.onclick = function () {
    infoList.scrollIntoView({ behavior: 'smooth', block: 'end'});
};

const restaurantsList = document.querySelector(".profile-restaurants");
const restaurants_button = document.querySelector("#restaurants-button");
restaurants_button.onclick = function () {
    restaurantsList.scrollIntoView({ behavior: 'smooth', block: 'end'});
};

const orderList = document.querySelector(".profile-orders");
const orders_button = document.querySelector("#orders-button");
orders_button.onclick = function () {
    orderList.scrollIntoView({ behavior: 'smooth', block: 'end'});
};

const favList = document.querySelector(".profile-favourites");
const fav_button = document.querySelector("#favourites-button");
fav_button.onclick = function () {
    favList.scrollIntoView({ behavior: 'smooth', block: 'end'});
};