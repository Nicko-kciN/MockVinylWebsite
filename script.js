// Featured Slider
let slides =[];
let slideIndex = 0;
let timer = null;

// Search Bar
const searchHome = document.getElementById("searchHome");
if (searchHome) {
    searchHome.addEventListener("input", filterVinyls);

    searchHome.addEventListener("keydown", function(event){

        if (event.key == 'Enter') {

            const search = searchHome.value.trim();

            if (search) {
                window.location.href = `vinyl_main.html?search=${encodeURIComponent(search)}`
            }
        }
    })
}

//Main Search Bar
const searchMain = document.getElementById("mainSearch");
if (searchMain) {
    searchMain.addEventListener("input", filterVinylMain);
}

//Main genre select
const mainGenre = document.getElementById("mainGenre");
if (mainGenre) {
    mainGenre.addEventListener("change", filterVinylMain)
}

//Preview Image
const imageLink = document.getElementById("vinylImage");
if (imageLink) {
    imageLink.addEventListener("input", imagePreview);
}

//Intersection Oberserver
document.addEventListener("DOMContentLoaded", async() => {

    await slideContent();

    //Homepage slider
    initialiseSlider();
    // Header Search 
    await headerVinyls();

    //Change Header if logged in
    changeHeader();

    //Vinyl main
    await showVinyls();

    //Url filters
    genreByUrl();
    searchByUrl();

    //Filter functions
    filterVinylMain();
    filterVinyls();

    //Vinyl content page
    await contentDisplay();

    //Listing page
    await displayListing();

    //Display cart
    await displayCart();

	//Intersection Oberserver
	const observer = new IntersectionObserver(entries => {
	  entries.forEach(entry => {
		if (entry.isIntersecting) {
		  entry.target.classList.add('in-view');
		  return;
		}
		entry.target.classList.remove('in-view');
	  });
	});

	const allAnimatedElements = document.querySelectorAll('.anim');

	allAnimatedElements.forEach((element) => observer.observe(element));

}); 

function initialiseSlider(){
    slides = document.querySelectorAll(".featured-slides .content");

    if(slides.length > 0 ) {
        nextSlide();
        slides[slideIndex].classList.add("displaySlide");
        timer = setInterval(nextSlide, 10000);
    }
} 

async function slideData() {
    const get = await fetch("sliderData.php");
    const data = await get.json();
    return data;
}

async function slideContent() {
    const slideCont = document.querySelector(".featured-slides");
    
    if(slideCont) {
        data = await slideData();

        data.forEach(slide => {
            slideCont.innerHTML += `<div class="content">
                <img src="${slide.vinyl_image}">
                <div class="content-text-container">
                    <div class="content-text-inner">
                        <h2>${slide.vinyl_name}</h2>
                        <p>${slide.vinyl_desc}</p>
                    </div>
                </div>
                </div>`
        })
    }
    else {
        return null;
    }
}

function showSlide(index, direction) {

    if (index >= slides.length) {
        slideIndex = 0
    }
    else if(index < 0){
        slideIndex = slides.length - 1;
    } 

    slides.forEach(content => {
        content.classList.remove("displaySlide", "prev-anim", "next-anim");
    })

    if (direction == "next" ) {
        slides[slideIndex].classList.add("next-anim");
    }
    else if (direction == "prev" ) {
        slides[slideIndex].classList.add("prev-anim");
    }

    slides[slideIndex].classList.add("displaySlide");


    const sliderBg = document.querySelector(".slider-bg");
    const ContentImage = slides[slideIndex].querySelector("img");
    const imageUrl = ContentImage.src;
    sliderBg.style.backgroundImage = `linear-gradient(180deg, rgba(51, 51, 51, 0.9) 10%, rgba(255, 255, 255, 0.9) 200%), url('${imageUrl}')`;

    animFadeIn(sliderBg);
}

function prevSlide() {
    clearInterval(timer)
    slideIndex--;
    showSlide(slideIndex, "prev");
}

function nextSlide() {
    clearInterval(timer)
    slideIndex++;
    showSlide(slideIndex, "next");

}

function animFadeIn (element) {
    element.style.animation = "none";
    void element.offsetWidth;
    element.style.animationName = "fadeIn";
    element.style.animationDuration = "2s";
}

//Sign up Dropbox
function showBox() {
    const dropbox = document.getElementById("drop")
    dropbox.classList.toggle("show");
}

//Change dropbox button value
function changeBttnName(statusId) {
    const status = document.getElementById(statusId);
    const statusValue = status.innerHTML;

    const dropBttn = document.getElementById("dropBttn");

    dropBttn.value = statusValue;
}

//Image Preview
function imagePreview() {
    const preview = document.getElementById("preview");
    const imgInput = document.getElementById("vinylImage").value;

    preview.src = imgInput;


} 

//Aysnc function to get data from php
async function dataFetcher() {
    try {
        const get = await fetch('dataStorage.php');
        const data = await get.json();
        return data;
    }
     
    catch (error) {
        return null;
    }
}

//checks if user is logged in
async function changeHeader() {
    const data = await dataFetcher();
    if (!data) {
        return;
    }

    const status = data.user_logged;
    const name = data.user_name;
    const admin = data.admin;

    const head1 = document.getElementById("header1");
    const head2 = document.getElementById("header2");

    const listing = document.getElementById("nav-listing");

    if (!head1 || !head2) {
        return;
    }
    
    if (status == true) {
        head1.innerHTML = `<a href="/profile.php" id="header1">${name}</a>`;
        head2.innerHTML = '<a href="account/logout.php" id="header2">Logout</a>';
    }
    else {
        head1.innerHTML = '<a href="account/login.php" id="header1">Login</a>';
        head2.innerHTML = '<a href="account/signup.php" id="header2">Sign Up</a>';
    }

    if (admin == 1) {
        listing.innerHTML = "User Listings"
        head1.innerHTML = `<a href="/profile.php" id="header1">Admin: ${name}</a>`;
    }
    else {
        listing.innerHTML = "My Listings"
    }
}

//fetch vinyl data through vinylData
async function vinylFetcher() {
    const get = await fetch('vinylData.php');
    const data = await get.json();
    return data; 
}

//Vinyls for the vinyl_main page
async function showVinyls() {
    const context = document.querySelector('.main-content')
    if (context) {
        const data = await vinylFetcher();
    
        data.forEach(vinyl => {
            context.innerHTML += `<div class="main" data-genre="${vinyl.vinyl_genre}">
                                <a href="vinyl_content.html?id=${vinyl.vinyl_id}">
                                <img src="${vinyl.vinyl_image}"></a>  
                                <span>${vinyl.vinyl_name}</span>
                                </div>`             
    })
    }
    else {
        return null;
    }
}

//Filter functions
//Main_vinyl filter
function filterVinylMain() {
    const vinylSearch = document.getElementById("mainSearch");
    const vinylGenre = document.getElementById("mainGenre");

    if (!vinylSearch || !vinylGenre) {
        return null;
    }
    else {
        const searchValue = vinylSearch.value.toLowerCase();
        const selectedGenre = vinylGenre.value;

        const vinylSearchItems = document.querySelectorAll(".main");

        vinylSearchItems.forEach(searchQuery => {
        const vinylName = searchQuery.querySelector("span");
        const name = vinylName ? vinylName.textContent.toLowerCase() : "";

        const genre = searchQuery.dataset.genre;


        if (((name.includes(searchValue)) && (selectedGenre == "" || genre == selectedGenre))) {
            searchQuery.style.display = "";
        }
        else {
            searchQuery.style.display = "none";
        } 
    });
    }
}

//Function for setting filtering by url
function genreByUrl() {
    const url = new URLSearchParams(window.location.search);

    const genreUrl = url.get('genre');

    if (genreUrl) {
        const genreFilter = document.getElementById('mainGenre');
        if (genreFilter) {
            genreFilter.value = genreUrl;
        }
    }
}

//For the search bar in the header
async function headerVinyls() {
    const context = document.querySelector('.search-vinyl')

    if (context) {
        const data = await vinylFetcher();

    
        data.forEach(vinyl => {
            context.innerHTML += `<div class="search-name">
                                <a href="vinyl_content.html?id=${vinyl.vinyl_id}" class="v-name">${vinyl.vinyl_name}</a>
                                </div>`                       
    })
    }
    else {
        return null;
    }
}

//Header search bar filter
function filterVinyls() {

    if (!searchHome) {
        return null;
    }

    const vinylSearch = document.querySelector(".search-vinyl");
    const vinylSearchItems = document.querySelectorAll(".search-name");
    const searchValue = searchHome.value.toLowerCase();
    let result = false;

    vinylSearchItems.forEach(searchQuery => {
        const vinylName = searchQuery.querySelector(".v-name");
        const name = vinylName ? vinylName.textContent.toLowerCase() : "";

        if (name.includes(searchValue)) {
            searchQuery.style.display = "block";
            result =true;
        } 
        else {
            searchQuery.style.display = "none";
        }
    });

    if (result && searchValue !=="" ) {
        vinylSearch.classList.add("show");
    } 
    else {
        vinylSearch.classList.remove("show");
    }
}

//Gets the Url parameters
function searchByUrl() {
    const url = new URLSearchParams(window.location.search);

    const searchUrl = url.get('search');

    if (searchUrl) {
        const searchFilter = document.getElementById('mainSearch');
        if (searchFilter) {
            searchFilter.value = searchUrl;
        }
    }
}

//Get id from URL 
function idUrl() {
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get('id');

    return id;
}

//fetch data from getVinyl.php
async function contentData() {
    const id = idUrl();
    const get = await fetch(`getVinyl.php?id=${id}`);
    const data = await get.json();
    return data;
}

async function contentDisplay() {
    const content = document.querySelector(".vinyl-content");

    if (content) {
        try {
        const data = await contentData();

        const vinyl_data = data.vinyl_data;
        const user_data = data.user_data;

        const genre = convertGenre(vinyl_data.vinyl_genre)
        
        content.innerHTML = `<div class="vinyl-img">
                            <img src="${vinyl_data.vinyl_image}">
                            </div>  
                                <div class="vinyl-info">
                                    <div class="vinyl-headline">
                                    <h3>Genre: ${genre}</h3>
                                    <h2>${vinyl_data.vinyl_name}</h2>
                                    </div>
                                <p>${vinyl_data.vinyl_desc}</p>
                                <h5>Uploaded by: ${user_data.user_name}</h5>
                                    <div class="vinyl-price">
                                        <h4>RM ${vinyl_data.vinyl_price}</h4>
                                        <a href="addCart.php?id=${vinyl_data.vinyl_id}">
                                        <button>Add to cart</button>
                                        </a> 
                                    </div>
                                </div>`
                                }
        catch (error) {
            window.location.replace("error.html")
        }                
    }
    else {
        return null;
    }
}

function convertGenre(genre) {

    switch(genre) {
        case "jpop":
            return "J-pop";
        case "pop":
            return "Pop";
        case "rock":
            return "Rock";
        case "electronic":
            return "Electronic";
        case "classical":
            return "Classical";
        case "vg":
            return "Video Game";
        case "jazz":
            return "Jazz";
    }
}

async function listingFetcher() {
    const get = await fetch("listingData.php");
    const data = await get.json();
    return data;
}

async function displayListing() {
    const context = document.querySelector(".vinyl-listing");

    if (context) {
        const data = await listingFetcher();

        data.forEach(listing => {
            const genre = convertGenre(listing.vinyl_genre);

            context.innerHTML += `<div class="listing-item">
                <img src="${listing.vinyl_image}" class="listing-image">
                <div class="listing-details">
                    <span class="big">${listing.vinyl_name}</span><br>
                    <span>${genre}</span>
                </div>
                <div class="item-price">RM ${listing.vinyl_price}</div>
                <a href="deleteVinyl.php?id=${listing.vinyl_id}">
                    <button class="delete-btn">Delete</button>
                </a>
                <a href='vinyl_edit.php?id=${listing.vinyl_id}'> 
                    <button class="edit-btn">Edit</button>
                </a>
            </div>`
        })
    }
}

async function cartFetcher() {
    const get = await fetch("getCart.php");
    const data = await get.json();
    return data;
}

async function displayCart() {
    const context = document.querySelector(".cart"); 

    if (context) {
        const data = await cartFetcher();
        
        data.forEach(item => {
            const genre = convertGenre(item.vinyl_genre);

            context.innerHTML += `<div class="cart-item" >
                                <img src="${item.vinyl_image}" class="item-image">
                                <div class="item-details">
                                    <span class="big">${item.vinyl_name}</span><br>
                                    <span>${genre}</span>
                                </div>
                                <div class="item-price">RM ${item.vinyl_price}</div>
                                <a href='removeCart.php?id=${item.vinyl_id}'> 
                                    <button class="delete-btn">Remove</button>
                                </a>
                            </div>`
            
        })
    }
}