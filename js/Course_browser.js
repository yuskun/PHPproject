
function Search_ResultPage() {
    const carousel = document.querySelector(".carousel");
const container = document.querySelector(".container");
const extra = document.querySelector("#extra");
const more_info = document.querySelector(".more_info");
const title_text = document.querySelector(".title_text");
    carousel.style.display = "none";
    container.style.justifyContent = "none";
    extra.style.display = "none";
    more_info.innerHTML = "";
    title_text.innerHTML = "搜尋結果";
}
function Search_Default() {
    carousel.style.display = "flex";
    container.style.justifyContent = "space-around";
    extra.style.display = "flex";
    more_info.innerHTML = "查看更多";
    title_text.innerHTML = "最新上線";
}


    document.addEventListener('DOMContentLoaded', () => {
        let currentIndex = 0;
        const indicators = document.querySelectorAll('.indicator');
        const totalIndicators = indicators.length;

        function updateCarousel(index) {
            const pictureControl = document.querySelector('.pictureControl');
            indicators.forEach((indicator, i) => {
                indicator.classList.toggle('active', i === index);
            });
            pictureControl.style.left = `-${index * 100}%`;
        }

        document.querySelector('.arrow.left').addEventListener('click', () => {
            currentIndex = (currentIndex === 0) ? totalIndicators - 1 : currentIndex - 1;
            updateCarousel(currentIndex);
        });

        document.querySelector('.arrow.right').addEventListener('click', () => {
            currentIndex = (currentIndex === totalIndicators - 1) ? 0 : currentIndex + 1;
            updateCarousel(currentIndex);
        });

        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                currentIndex = index;
                updateCarousel(currentIndex);
            });
        });


        updateCarousel(currentIndex);
    });