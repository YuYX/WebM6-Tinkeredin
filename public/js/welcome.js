
$(function(){
    // $(".title")
    // .fadeIn( {duration: 2000} )
    // .css("display", "none")
    // .slideDown(2000);
    // alert("Welcome!"); 
    animeJS_effect();

    // $(".title").addClass("animate__animated animate__fadeInLeft animate__slower animate__infinite");
    // $(".underline").addClass("animate__animated animate__backInDown animate__slower");
    // $(".sub-title").addClass("animate__animated animate__heartBeat animate__slower animate__infinite");

    animated_effect_on_component('.title', "animate__fadeInLeft animate__slower animate__infinite")
    animated_effect_on_component(".underline","animate__backInDown animate__slower");
    animated_effect_on_component(".sub-title","animate__heartBeat animate__slower animate__infinite");

    // setTimeout(animated_effect_on_component(".text-gray-400", "animate__backInUp  animate__slower"), 2000); 
    //footer-icon text-gray-400
    delay_animated_effect().then(after_delay_animated_effect).then(final_animated_effect);
});

function delay_animated_effect() {
    return new Promise(function(resolve, reject) { 
        setTimeout(function(){
            animated_effect_on_component(".footer-icon", "animate__backInUp  animate__slower");
            resolve("Promise worked!");
            reject("Promise missed.");
        }, 5000); 
    });
 }

 function after_delay_animated_effect(){ 
    // alert("After");
    add_remove_class_to_component(".sub-content", "animate__heartBeat", "add");   
 }
 
 function final_animated_effect(){  
    // alert("Final");
    add_remove_class_to_component(".sub-title", "animate__infinite", "remove");   
 }

function animated_effect_on_component(component, effects){ 
    $(component).addClass("animate__animated " + effects);
}

function add_remove_class_to_component(component, class_name, is_add_or_remove){ 
    if(is_add_or_remove == "add"){
        $(component).addClass(class_name);
    }else if (is_add_or_remove == "remove"){
        $(component).removeClass(class_name);
    }
}

function animeJS_effect()
{
    window.human = false;

    var canvasEl = document.querySelector('.fireworks');
    var ctx = canvasEl.getContext('2d');
    var numberOfParticules = 50;
    var pointerX = 0;
    var pointerY = 0;
    var tap = ('ontouchstart' in window || navigator.msMaxTouchPoints) ? 'touchstart' : 'mousemove';
    var colors = ['#FF1461', '#18FF92', '#5A87FF', '#FBF38C'];

    function setCanvasSize() {
        canvasEl.width = window.innerWidth;
        canvasEl.height = window.innerHeight/5;
        canvasEl.style.width = window.innerWidth + 'px';
        canvasEl.style.height = window.innerHeight/5 + 'px';
       // canvasEl.getContext('2d').scale(2, 2);
    }

    function updateCoords(e) {
        pointerX = e.clientX || e.touches[0].clientX;
        pointerY = e.clientY || e.touches[0].clientY; 
    }

    function setParticuleDirection(p) {
        var angle = anime.random(0, 360) * Math.PI / 180;
        var value = anime.random(50, 180);
        var radius = [-1, 1][anime.random(0, 1)] * value;
        return {
            x: p.x + radius * Math.cos(angle),
            y: p.y + radius * Math.sin(angle)
        }
    }

    function createParticule(x,y) {
        var p = {};
        p.x = x;
        p.y = y;
        p.color = colors[anime.random(0, colors.length - 1)];
        p.radius = anime.random(16, 32);
        p.endPos = setParticuleDirection(p);
        p.draw = function() {
            ctx.beginPath();
            ctx.arc(p.x, p.y, p.radius, 0, 2 * Math.PI, true);
            ctx.fillStyle = p.color;
            ctx.fill();
        }
        return p;
    }

    function createCircle(x,y) {
        var p = {};
        p.x = x;
        p.y = y;
        p.color = '#FFF';
        p.radius = 0.1;
        p.alpha = .5;
        p.lineWidth = 6;
        p.draw = function() {
            ctx.globalAlpha = p.alpha;
            ctx.beginPath();
            ctx.arc(p.x, p.y, p.radius, 0, 2 * Math.PI, true);
            ctx.lineWidth = p.lineWidth;
            ctx.strokeStyle = p.color;
            ctx.stroke();
            ctx.globalAlpha = 1;
        }
        return p;
    }

    function renderParticule(anim) {
    for (var i = 0; i < anim.animatables.length; i++) {
        anim.animatables[i].target.draw();
    }
    }

    function animateParticules(x, y) {
    var circle = createCircle(x, y);
    var particules = [];
    for (var i = 0; i < numberOfParticules; i++) {
        particules.push(createParticule(x, y));
    }
    anime.timeline().add({
        targets: particules,
        x: function(p) { return p.endPos.x; },
        y: function(p) { return p.endPos.y; },
        radius: 0.1,
        duration: anime.random(1200, 1800),
        easing: 'easeOutExpo',
        update: renderParticule
    })
        .add({
        targets: circle,
        radius: anime.random(80, 160),
        lineWidth: 0,
        alpha: {
        value: 0,
        easing: 'linear',
        duration: anime.random(600, 800),  
        },
        duration: anime.random(1200, 1800),
        easing: 'easeOutExpo',
        update: renderParticule,
        offset: 0
    });
    }

    var render = anime({
    duration: Infinity,
    update: function() {
        ctx.clearRect(0, 0, canvasEl.width, canvasEl.height);
    }
    });

    document.addEventListener(tap, function(e) {
    window.human = true;
    render.play();
    updateCoords(e);
    animateParticules(pointerX, pointerY);
    }, false);

    var centerX = window.innerWidth;
    var centerY = window.innerHeight * 5;

    function autoClick() {
        if (window.human) return;
        animateParticules(
            anime.random(centerX-50, centerX+50), 
            anime.random(centerY-50, centerY+50)
        );
        anime({duration: 200}).finished.then(autoClick);
    }

    autoClick();
    setCanvasSize();
    window.addEventListener('resize', setCanvasSize, false);
}
 