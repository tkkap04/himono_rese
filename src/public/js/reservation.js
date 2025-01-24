// ページのHTMLが完全に読み込まれた後に実行される
document.addEventListener("DOMContentLoaded", function () {
// 入力要素と表示要素を取得
    const form = document.getElementById("reservation-form");
    const dateInput = document.getElementById("reservation-date");
    const timeSelect = document.getElementById("reservation-time");
    const peopleSelect = document.getElementById("reservation-people");
    const summaryDate = document.getElementById("summary-date");
    const summaryTime = document.getElementById("summary-time");
    const summaryPeople = document.getElementById("summary-people");

// ユーザーがフォームの入力要素を変更するたびに表示要素を更新
    function updateSummary() {
        summaryDate.textContent = dateInput.value;
        summaryTime.textContent = timeSelect.value;
        summaryPeople.textContent = peopleSelect.value;
    }

// 10時から22時までの15分ごとの時間選択オプションを生成
    function generateTimeOptions() {
        const startTime = new Date();
        startTime.setHours(10, 0, 0);

        const endTime = new Date();
        endTime.setHours(22, 0, 0);

        while (startTime <= endTime) {
            const option = document.createElement('option');
            const hours = startTime.getHours().toString().padStart(2, '0');
            const minutes = startTime.getMinutes().toString().padStart(2, '0');
            option.value = `${hours}:${minutes}`;
            option.text = `${hours}:${minutes}`;
            timeSelect.appendChild(option);

            startTime.setMinutes(startTime.getMinutes() + 15);
        }
    }

// 1から99までの人数選択オプションを生成
    function generatePeopleOptions() {
        for (let i = 1; i <= 99; i++) {
            const option = document.createElement('option');
            option.value = i;
            option.text = `${i}人`;
            peopleSelect.appendChild(option);
        }
    }

// 上記のオプションに従って実際に選択肢を生成
    generateTimeOptions();
    generatePeopleOptions();

// 日付、時間、人数を変更したときにupdateSummary関数を呼び出して更新
    dateInput.addEventListener("change", updateSummary);
    timeSelect.addEventListener("change", updateSummary);
    peopleSelect.addEventListener("change", updateSummary);
});

