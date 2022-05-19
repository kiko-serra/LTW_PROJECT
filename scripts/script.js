const searchBar = document.getElementById('search-bar');
searchBar.addEventListener('keyup', (e) =>{
    
    const searchString = e.target.value.toLowerCase();
    const hpCharacters = <?php ?>

    const filteredCharacters = hpCharacters.filter((character) => {
        return (
            character.name.toLowerCase().includes(searchString) ||
            character.house.toLowerCase().includes(searchString)
        );

});