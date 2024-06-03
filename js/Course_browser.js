
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