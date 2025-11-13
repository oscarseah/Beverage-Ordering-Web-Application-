const bar = document.querySelector('.fa-bars');
const cross = document.querySelector('#hdcross');
const headerbar = document.querySelector('.headerbar');
const Slide = document.querySelector('.slide');
const SlideImages = document.querySelectorAll('.slide img');
const previous_button = document.querySelector('#previous_button');
const next_button = document.querySelector('#next_button');

let counter = 1;
const size = SlideImages[0].clientWidth;

Slide.style.transform = 'translateX(' + (-size * counter) + 'px)';

next_button.addEventListener('click', ()=> {
    if (counter >= SlideImages.length -1) return;
    Slide.style.transition = "transform 0.4s ease-in-out";
    counter++;
    Slide.style.transform = 'translateX(' + (-size * counter) + 'px)';
});
previous_button.addEventListener('click', ()=> {
    if (counter <= 0) return;
    Slide.style.transition = "transform 0.4s ease-in-out";
    counter--;
    Slide.style.transform = 'translateX(' + (-size * counter) + 'px)';
});

Slide.addEventListener('transitionend', ()=> {
    if (SlideImages[counter].id === 'lastClone') {
        Slide.style.transition = "none";
        counter = SlideImages.length - 2; 
        Slide.style.transform = 'translateX(' + (-size * counter) + 'px)';
    }
    if (SlideImages[counter].id === 'firstClone') {
        Slide.style.transition = "none";
        counter = SlideImages.length - counter; 
        Slide.style.transform = 'translateX(' + (-size * counter) + 'px)';
    }
});

bar.addEventListener('click', function(){
    setTimeout(() => {
        cross.style.display = 'block';
    },0);
    headerbar.style.right = '0%';
})

cross.addEventListener('click', function(){
    cross.style.display = 'none';
    headerbar.style.right = '-100%';
})

