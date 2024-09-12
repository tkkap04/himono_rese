document.addEventListener('DOMContentLoaded', function () {
    var modal = document.getElementById('myModal');
    var btn = document.getElementById('openModalBtn');
    var span = document.getElementsByClassName('close')[0];

    // ボタンをクリックしたときにモーダルを表示
    btn.onclick = function () {
        modal.style.display = 'block';
    }

    // ×ボタンをクリックしたときにモーダルを非表示
    span.onclick = function () {
        modal.style.display = 'none';
    }

    // モーダルの外側をクリックしたときにモーダルを非表示
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
});
