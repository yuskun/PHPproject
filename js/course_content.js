const tabs = document.querySelectorAll('nav a');
const contents = document.querySelectorAll('.tab-content');
const courseProgress = document.getElementById('course-progress');
const completeBtns = document.querySelectorAll('.complete_btn');
let completedTasks = 0;
const totalTasks = completeBtns.length;

function updateProgress() {
    const progressPercentage = (completedTasks / totalTasks) * 100;
    courseProgress.style.width = progressPercentage + '%';
}

completeBtns.forEach(btn => {
    btn.addEventListener('click', function () {
        if (this.textContent === '未完成') {
            this.textContent = '完成';
            completedTasks++;
        } else {
            this.textContent = '未完成';
            completedTasks--;
        }
        updateProgress();
    });
});

tabs.forEach(tab => {
    tab.addEventListener('click', function (e) {
        e.preventDefault();
        tabs.forEach(t => t.classList.remove('active'));
        contents.forEach(c => c.classList.remove('active'));
        this.classList.add('active');
        const contentId = this.getAttribute('href').substring(1);
        document.getElementById(contentId).classList.add('active');
    });
});
