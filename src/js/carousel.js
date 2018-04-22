const rightControl = document.querySelector('#right');
const leftControl = document.querySelector('#left');

const img_1 = document.querySelector('.img-1');
const img_2 = document.querySelector('.img-2');
const img_3 = document.querySelector('.img-3');
const img_4 = document.querySelector('.img-4');

const slider = [img_1, img_2, img_3, img_4];
let index = 0;
// Time throttle
let timeNow = Date.now();

function initialRight() {
    slider.forEach(img => {
        img.classList.add('moveTransition');
    });
    slider.filter(img => img !== slider[index]).forEach(img => {
        img.classList.add('translateRight');
    });
}

initialRight();

rightControl.addEventListener('click', () => {
    if (Date.now() - timeNow > 1000) {
        timeNow = Date.now();

        slider[index].classList.add('moveTransition');
        slider[index].classList.add('translateLeft');
        setTimeout(() => {
            if (index - 1 !== -1) {
                slider[index - 1].classList.remove('moveTransition');
                slider[index - 1].classList.remove('translateLeft');
                slider[index - 1].classList.add('translateRight');
            }
            if (slider[slider.length - 1].classList.contains('translateLeft')) {
                slider[slider.length - 1].classList.remove('moveTransition');
                slider[slider.length - 1].classList.remove('translateLeft');
                slider[slider.length - 1].classList.add('translateRight');
            }
        }, 1000);
        if (index === slider.length - 1) {
            index = -1;
        }
        index++;
        slider[index].classList.add('moveTransition');
        slider[index].classList.remove('translateRight');
        // console.log(`current index: ${index}`);
        slider[index].dispatchEvent(typeWriter);
    }
});

leftControl.addEventListener('click', () => {
    // Get rid of auto carousel mode
    // clearInterval(autoCarousel)
    if (Date.now() - timeNow > 1000) {
        timeNow = Date.now();
        if (index - 1 === -1) {
            slider[slider.length - 1].classList.remove('moveTransition');
            slider[slider.length - 1].classList.remove('translateRight');
            slider[slider.length - 1].classList.add('translateLeft');
        }
        setTimeout(() => {
            slider[index].classList.add('moveTransition');
            slider[index].classList.add('translateRight');
            if (index - 1 === -1) {
                index = slider.length;
            }
            index--;
            // console.log(`current index: ${index}`);
            slider[index].dispatchEvent(typeWriter);
            if (slider[index].classList.contains('translateRight')) {
                slider[index].classList.remove('moveTransition');
                slider[index].classList.remove('translateRight');
                slider[index].classList.add('translateLeft');

                setTimeout(() => {
                    slider[index].classList.add('moveTransition');
                    slider[index].classList.remove('translateLeft');
                }, 20);
                return;
            }
            slider[index].classList.add('moveTransition');
            slider[index].classList.remove('translateLeft');
        }, 0);
    }
});

// Create event when slide on he page
const typeWriter = new Event('typing');
// Attach event listener on each image
for (let img of slider) {
    img.addEventListener('typing', () => {
        const h1 = img.children[0].children[0];
        const h2 = img.children[0].children[1];
        const temp = h2.textContent;
        h2.textContent = '';
        setTimeout(() => {
            let i = 0;
            const typewriter2 = setInterval(() => {
                h2.textContent += temp[i];
                i++;
                if (i === temp.length) clearInterval(typewriter2);
            }, 50);
        }, 1000);
    });
}

//Set up auto carousel when page load
const autoCarousel = setInterval(() => {
    rightControl.click();
}, 10000);
