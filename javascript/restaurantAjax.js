
/*  Getting Restaurants  */

const fetchJSON = async (url) => {
  const response = await fetch(url)
  const json = await response.json()
  return json
}

const fetchText = async (url) => {
  const response = await fetch(url)
  const text = response.text()
  return text
}

const redrawRestaurants = async (restaurants) => {
  const restaurantsList = document.querySelector('.restaurants-list')
  let final = ""
  for (const r of restaurants) {
    text =
      `<section class="restaurant-container" onclick="restaurantCardClick(${r.id})"> 
            <section class = "restaurant-container-img">
                <img src = "${r.img_url}">
            </section>
            <section class = "restaurant-container-description">
                <header>
                    <h2>${r.name}</h2>
                </header>
                <span class = "restaurant-sentence">
                    <p>${r.title}</p>
                </span>
            </section>
            
        </section>`
    final += text
  }
  restaurantsList.innerHTML = final
}

const buildFilterQuery = (filters) => {
  return "filters=" + encodeURI(JSON.stringify(filters))
}
const getActiveFilters = () => {
  const selected_categories = document.querySelectorAll("article.feature-food-card[selected]")
  const categorylist = []
  for (const category of selected_categories)
    categorylist.push(category.getAttribute("category-id"))
  return categorylist
}


const searchBar = document.querySelector('#search-bar')

const filteredSearch = async () => {
  const filters = getActiveFilters()
  let filterquery = ""
  if (filters.length > 0)
    filterquery = buildFilterQuery(filters)
  const query = "../api/restaurants_search.php?search=" + searchBar.value + "&" + filterquery
  console.log(query)
  const restaurants = await fetchJSON(query)
  console.log(restaurants)
  redrawRestaurants(restaurants)
}

if (searchBar) {
  searchBar.addEventListener('input', filteredSearch)
}

const featureFoods = document.querySelectorAll("article.feature-food-card")

const toggleSelected = function () {
  this.toggleAttribute("selected")
  filteredSearch()


}

for (const card of featureFoods) {
  card.addEventListener("click", toggleSelected)
}