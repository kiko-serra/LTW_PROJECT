

const bList = document.querySelector("#menu-breakfast");
const bbutton = document.querySelector("#bbutton");
bbutton.onclick = function () {
    bList.scrollIntoView({ behavior: 'smooth', block: 'end'});
};

const fdList = document.querySelector("#menu-dish");
const fdbutton = document.querySelector("#fdbutton");
fdbutton.onclick = function () {
    fdList.scrollIntoView({ behavior: 'smooth', block: 'end'});
};

const dList = document.querySelector("#menu-dessert");
const dbutton = document.querySelector("#dbutton");
dbutton.onclick = function () {
    dList.scrollIntoView({ behavior: 'smooth', block: 'end'});
};
