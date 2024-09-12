document.addEventListener('DOMContentLoaded', function () {
    const editButtons = document.querySelectorAll('.reservation-list__edit-button');
    const saveButtons = document.querySelectorAll('.reservation-list__save-button');
    const cancelButtons = document.querySelectorAll('.reservation-list__cancel-button');

    // 10時から22時までの15分ごとの時間選択オプションを生成
    function generateTimeOptions(selectedTime) {
        let options = '';
        const startTime = new Date();
        startTime.setHours(10, 0, 0);
        const endTime = new Date();
        endTime.setHours(22, 0, 0);

        while (startTime <= endTime) {
            const hours = startTime.getHours().toString().padStart(2, '0');
            const minutes = startTime.getMinutes().toString().padStart(2, '0');
            const timeString = `${hours}:${minutes}`;
            options += `<option value="${timeString}" ${timeString === selectedTime ? 'selected' : ''}>${timeString}</option>`;
            startTime.setMinutes(startTime.getMinutes() + 15);
        }
        return options;
    }

    // 1から99までの人数選択オプションを生成
    function generatePeopleOptions(selectedNumber) {
        let options = '';
        for (let i = 1; i <= 99; i++) {
            options += `<option value="${i}" ${i == selectedNumber ? 'selected' : ''}>${i}人</option>`;
        }
        return options;
    }

    // 編集ボタン
    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const reservationCard = this.closest('.reservation-list__card');
            const dateElement = reservationCard.querySelector('.reservation-list__date');
            const timeElement = reservationCard.querySelector('.reservation-list__time');
            const numberElement = reservationCard.querySelector('.reservation-list__number');
            const editForm = reservationCard.querySelector('.reservation-list__edit-form');

            const currentDate = dateElement.textContent;
            const currentTime = timeElement.textContent;
            const currentNumber = numberElement.textContent.split('人')[0];

            dateElement.dataset.originalValue = currentDate;
            timeElement.dataset.originalValue = currentTime;
            numberElement.dataset.originalValue = currentNumber;

            // 予約情報を入力フォームに変更
            dateElement.innerHTML = `<input type="date" class="reservation-edit__date" value="${currentDate}">`;
            timeElement.innerHTML = `<select class="reservation-edit__time">${generateTimeOptions(currentTime)}</select>`;
            numberElement.innerHTML = `<select class="reservation-edit__number">${generatePeopleOptions(currentNumber)}</select>`;

            // 編集フォームを表示
            editForm.style.display = 'block';
            this.style.display = 'none';
        });
    });

    // 保存ボタン
    saveButtons.forEach(button => {
        button.addEventListener('click', function () {
            const reservationCard = this.closest('.reservation-list__card');
            const dateInput = reservationCard.querySelector('.reservation-edit__date');
            const timeSelect = reservationCard.querySelector('.reservation-edit__time');
            const numberSelect = reservationCard.querySelector('.reservation-edit__number');
            const reservationId = this.dataset.reservationId;
            const url = `/reservations/${reservationId}`;

            fetch(url, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    date: dateInput.value,
                    time: timeSelect.value,
                    number_of_people: numberSelect.value
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // 入力内容を反映
                        reservationCard.querySelector('.reservation-list__date').textContent = data.reservation.date;
                        reservationCard.querySelector('.reservation-list__time').textContent = data.reservation.time;
                        reservationCard.querySelector('.reservation-list__number').textContent = `${data.reservation.number_of_people}人`;

                        reservationCard.querySelector('.reservation-list__edit-form').style.display = 'none';
                        reservationCard.querySelector('.reservation-list__edit-button').style.display = 'inline-block';
                    } else {
                        alert('予約の更新に失敗しました。');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('エラーが発生しました。');
                });
        });
    });
    
    // キャンセルボタン
    cancelButtons.forEach(button => {
        button.addEventListener('click', function () {
            const reservationCard = this.closest('.reservation-list__card');
            restoreOriginalValues(reservationCard);
            hideEditForm(reservationCard);
        });
    });

    // 予約表示を更新する関数
    function updateReservationDisplay(card, reservation) {
        card.querySelector('.reservation-list__date').textContent = reservation.date;
        card.querySelector('.reservation-list__time').textContent = reservation.time;
        card.querySelector('.reservation-list__number').textContent = `${reservation.number_of_people}人`;
    }

    // 元の値を復元する関数
    function restoreOriginalValues(card) {
        const dateElement = card.querySelector('.reservation-list__date');
        const timeElement = card.querySelector('.reservation-list__time');
        const numberElement = card.querySelector('.reservation-list__number');

        dateElement.textContent = dateElement.dataset.originalValue;
        timeElement.textContent = timeElement.dataset.originalValue;
        numberElement.textContent = `${numberElement.dataset.originalValue}人`;
    }

    // 編集フォームを非表示にする関数
    function hideEditForm(card) {
        card.querySelector('.reservation-list__edit-form').style.display = 'none';
        card.querySelector('.reservation-list__edit-button').style.display = 'inline-block';
    }

    // QRコード表示ボタン
    const qrButtons = document.querySelectorAll('.reservation-list__qr-button');
    qrButtons.forEach(button => {
        button.addEventListener('click', function () {
            const reservationId = this.getAttribute('data-reservation-id');
            const qrCodeContainer = document.getElementById(`qr-code-${reservationId}`);
            const qrCodeImg = qrCodeContainer.querySelector('img');

            // モーダルウィンドウ
            const modal = document.createElement('div');
            modal.style.position = 'fixed';
            modal.style.top = '0';
            modal.style.left = '0';
            modal.style.width = '100%';
            modal.style.height = '100%';
            modal.style.backgroundColor = 'rgba(0,0,0,0.5)';
            modal.style.display = 'flex';
            modal.style.justifyContent = 'center';
            modal.style.alignItems = 'center';
            modal.style.zIndex = '1000';

            // QRコードの下地
            const qrContainer = document.createElement('div');
            qrContainer.style.width = '50vw';
            qrContainer.style.height = '50vw';
            qrContainer.style.backgroundColor = 'white';
            qrContainer.style.display = 'flex';
            qrContainer.style.justifyContent = 'center';
            qrContainer.style.alignItems = 'center';
            qrContainer.style.padding = '2vw';
            qrContainer.style.boxSizing = 'border-box';

            // QRコードの表示
            const largeQrCode = qrCodeImg.cloneNode(true);
            largeQrCode.style.width = '100%';
            largeQrCode.style.height = '100%';
            largeQrCode.style.objectFit = 'contain';
            largeQrCode.style.maxWidth = '100%';
            largeQrCode.style.maxHeight = '100%';

            qrContainer.appendChild(largeQrCode);
            modal.appendChild(qrContainer);

            modal.addEventListener('click', function () {
                document.body.removeChild(modal);
            });

            document.body.appendChild(modal);
        });
    });
});