
/*  Getting Restaurants  */

const fetchJSON = async (url) => {
    const response = await fetch(url)
    const json  = await response.json()
    return json
}

const fetchText = async (url) =>{
    const response = await fetch(url)
    const text = response.text()
    return text
}


const searchBar = document.querySelector('#search-bar')

if (searchBar) {
  searchBar.addEventListener('input', async function() {

    const restaurants = await fetchJSON("../api/restaurants_search.php?search="+this.value)

    const restaurantsList = document.querySelector('.restaurants-list')
    restaurantsList.innerHTML = ''

    for (const restaurant of restaurants) {
        console.log(restaurant);
        const text = await fetchText("../api/restaurat_draw.php?restaurant="+JSON.stringify(restaurant))
        console.log(text)
        restaurantsList.innerHTML += text
    }
  })
}