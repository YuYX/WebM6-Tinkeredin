// const { set } = require("lodash");


$(function(){   
    // const form = document.querySelector(".top-banner form");
    // const input = document.querySelector(".top-banner input");
    // const msg = document.querySelector(".top-banner .msg");
    //const list = document.querySelector(".ajax-section .cities");
    /*SUBSCRIBE HERE FOR API KEY: https://home.openweathermap.org/users/sign_up*/
    const apiKey = "4d8fb5b93d4af21d66a2948710284366"; 

    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

    effects_On_Component(".profile-image", "animate__flipInY animate__slower animate__infinite");  
       
    //fetch_weather_info("Singapore",apiKey); 

    if(checkCookie("weather_city")){
      var w_city = getCookie("weather_city"); 
      if(w_city != ""){
        fetch_weather_info(w_city,apiKey);  
      } 
    }

    // const form_user_search = document.querySelector(".user-search-form");
    // const input_user_search = document.querySelector(".user-search");
    // form_user_search.addEventListener("submit", e => {
    //   e.preventDefault();
    //   let inputKeyword = input_user_search.value;  
    // });  

    const form_weather = document.querySelector(".weather-form form");
    const input_weather=document.querySelector(".weather-form input");
    const msg = document.querySelector(".weather-form .msg");
    const list = document.querySelector(".cities");
    form_weather.addEventListener("submit", e => {
        e.preventDefault();
        let inputVal = input_weather.value;   

        //check if there's already a city
        const listItems = list.querySelectorAll(".weather-form .city");
        //Only display one city - YYX
         
        if(listItems.length>0) listItems[0].remove();
        const listItemsArray = Array.from(listItems); 
        
        if (listItemsArray.length > 0) {
          const filteredArray = listItemsArray.filter(el => {
            let content = "";
            //athens,gr
            if (inputVal.includes(",")) {
              //athens,grrrrrr->invalid country code, so we keep only the first part of inputVal
              if (inputVal.split(",")[1].length > 2) {
                inputVal = inputVal.split(",")[0];
                content = el
                  .querySelector(".city-name span")
                  .textContent.toLowerCase();
              } else {
                content = el.querySelector(".city-name").dataset.name.toLowerCase();
              }
            } else {
              //athens
              content = el.querySelector(".city-name span").textContent.toLowerCase();
            }
            return content == inputVal.toLowerCase();
          }); 
          
          if (filteredArray.length > 0) {
            msg.textContent = `You already know the weather for ${
              filteredArray[0].querySelector(".city-name span").textContent
            } ...otherwise be more specific by providing the country code as well 😉`;
            form.reset();
            input.focus();
            return;
          }
        } 
      
        //ajax here
        fetch_weather_info(inputVal,apiKey); 
      
        msg.textContent = "";
        form.reset();
        input.focus();  
    });
});  

// window.onscroll = function() {
//   if (window.innerHeight + window.pageYOffset >= document.body.offsetHeight) {
//    alert("At the bottom!")
//   }
//  }

$(window).on("scroll", function() { 
  // if ((window.innerHeight + window.scrollY) >= document.body.scrollHeight){
  //   alert("At the bottom!");
  // }

  localStorage.setItem("scrollTop", window.scrollY.toFixed());
  document.getElementById("x-location").innerHTML = window.scrollY.toFixed(); 

});

$(window).on("load", function(){ 
  if (localStorage.scrollTop != 'undefined') {  
    $(window).scrollTop(localStorage.scrollTop);
    document.getElementById("x-location").innerHTML = localStorage.scrollTop;   
  }; 
}); 

function fetch_weather_info(inputVal, apiKey){
  const url = `https://api.openweathermap.org/data/2.5/weather?q=${inputVal}&appid=${apiKey}&units=metric`;
         
        fetch(url)
          .then(response => response.json())
          .then(data => {
            const { main, name, sys, weather } = data;
            const icon = `https://s3-us-west-2.amazonaws.com/s.cdpn.io/162656/${
              weather[0]["icon"]
            }.svg`;   

            const li = document.createElement("li");
            li.classList.add("city"); 
            const markup = `
              <h2 class="city-name" data-name="${name},${sys.country}">
                <span>${name}</span>
                <sup>${sys.country}</sup>
              </h2>
              <div class="city-temp">${Math.round(main.temp)}<sup>°C</sup></div>
              <figure>
                <img class="city-icon" src="${icon}" alt="${
              weather[0]["description"]
            }">
                <figcaption>${weather[0]["description"]}</figcaption>
              </figure>
            `;
            li.innerHTML = markup;   
            // const list = document.querySelector(".cities"); 
            // list.appendChild(li);   
            var tmpFirstChild = $(".cities").children(":first");
            if(tmpFirstChild != null) { 
              tmpFirstChild.remove();
            }
            $(".cities").prepend(li);  
            
            setCookie("weather_city", inputVal, 10);
          })
          .catch(() => {
            // msg.textContent = "Please search for a valid city 😩";
          });
      
        // msg.textContent = "";
} 

function update_featuredImage(imageSrc, featuredImageID, imagePreviewID){
  const objImg = document.querySelector("#"+featuredImageID);
  objImg.style.height="auto"; //To keep images' aspect ratio.
  objImg.style['object-fit'] = "contain";
  objImg.style.opacity=0.7;
  objImg.setAttribute("src",imageSrc);  

  objImg.addEventListener("click", function(){
    const objPreviewImg = document.querySelector("#"+imagePreviewID);
    objPreviewImg.setAttribute("src", this.src);
  });
  objImg.addEventListener("mouseover", function(){
    this.style.opacity=1;
    this.style.transition = '0.5s';
  });
  objImg.addEventListener("mouseleave", function(){
    this.style.opacity=0.7;
    this.style.transition = '0.5s';
  });

  const objContainer = document.querySelector("#"+imageContainerID);
  objContainer.appendChild(objImg); 
}

function add_image2list(imageSrc, imageClass,imageContainerID,imagePreviewID){  
  
  const objImg = document.createElement("img"); 
  objImg.classList.add(imageClass);
  objImg.classList.add("modal-image") ;
  objImg.classList.add("img-thumbnail") ;
  objImg.classList.add("col-sm-6") ;
  objImg.classList.add("col-md-4") ; 
  objImg.style.height="auto"; //To keep images' aspect ratio.
  objImg.style['object-fit'] = "contain";
  objImg.style.opacity=0.7;
  objImg.setAttribute("src",imageSrc);  

  objImg.addEventListener("click", function(){
    const objPreviewImg = document.querySelector("#"+imagePreviewID);
    objPreviewImg.setAttribute("src", this.src);
  });
  objImg.addEventListener("mouseover", function(){
    this.style.opacity=1;
    this.style.transition = '0.5s';
  });
  objImg.addEventListener("mouseleave", function(){
    this.style.opacity=0.7;
    this.style.transition = '0.5s';
  });

  const objContainer = document.querySelector("#"+imageContainerID);
  objContainer.appendChild(objImg); 
 
}  

function postImgOnClick2(e){   
  const modal = document.getElementById('myModal');
  var curModalImg = document.querySelector('.modal-content');
  if(curModalImg == null){
    curModalImg = document.createElement('img'); 
    curModalImg.setAttribute('class','modal-content');
  }
  curModalImg.src = e.target.src; 
  
  // var CurCaptionText = document.getElementById("caption");
  modal.style.display = "block";    
  modal.appendChild(curModalImg);
}   

function apply_offcanvas_location(location)
{
  component = ".offcanvas";
  location_list = ["offcanvas-start",
                   "offcanvas-end",
                   "offcanvas-top",
                   "offcanvas-bottom"];  

  $("#"+location).parents('label').css("color","black");
  
          for(var ocitem=0; ocitem<location_list.length; ocitem++){
            if(location_list[ocitem] != location){

              $("#"+location_list[ocitem]).parents('label').css("color","lightblue");

              if($(component).hasClass(location_list[ocitem])){
                $(component).removeClass(location_list[ocitem]);
              }
            } 
          } 
          if($(component).hasClass(location) == false){
            $(component).addClass(location);
          }
} 

function effects_On_Component(component, effect) { 
    $(component).addClass("animate__animated " + effect); 
};

function setCookie(cname, cvalue, exdays) {
  const d = new Date();
  d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
  let expires = "expires="+d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
  let name = cname + "=";
  let ca = document.cookie.split(';');
  for(let i = 0; i < ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

function checkCookie(cname) {
  let cookiename = getCookie(cname);
  return (cookiename != "");
}  

// For Post-Input-Prompt Component
function sayHi(){
  $(".post-input-prompt").removeClass("animate__bounceInRight");
  $(".post-input-prompt").addClass("animate__shakeX animate__repeat"); 
  $(".profile-image").removeClass("animate__flipInY"); 
  $(".profile-image").addClass("animate__heartBeat");  
}

function sayBye(){
  $(".post-input-prompt").removeClass("animate__shakeX animate__repeat");
  $(".post-input-prompt").addClass("animate__bounceInRight"); 
  $(".profile-image").removeClass("animate__heartBeat"); 
  $(".profile-image").addClass("animate__flipInY");
}

function onMouseOverProfileImagePost(postId){
  $(".profile-image-4-post-"+postId).addClass("animate__animated animate__heartBeat");
}
function onMouseOutProfileImagePost(postId){
  $(".profile-image-4-post-"+postId).removeClass("animate__animated animate__heartBeat");
}

function onMouseOverLike(id){ 
    $(".post-like-icon-"+id).addClass("fa-beat"); 
};
function onMouseOutLike(id){ 
    $(".post-like-icon-"+id).removeClass("fa-beat"); 
};
function onMouseOverComment(id){ 
    $(".post-comment-icon-"+id).addClass("fa-beat-fade"); 
};
function onMouseOutComment(id){ 
    $(".post-comment-icon-"+id).removeClass("fa-beat-fade"); 
};
function onMouseOverShare(id){ 
    $(".post-share-icon-"+id).addClass("fa-flip"); 
};
function onMouseOutShare(id){ 
    $(".post-share-icon-"+id).removeClass("fa-flip"); 
};


 