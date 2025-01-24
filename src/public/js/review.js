document.addEventListener('DOMContentLoaded', () => {
    // 文字数カウント
    const setupCharCount = () => {
        const textarea = document.getElementById('comment');
        const charCount = document.getElementById('char-count');

        if (textarea && charCount) {
            textarea.addEventListener('input', () => {
                const currentLength = textarea.value.length;
                charCount.textContent = `${currentLength}/400(最高文字数)`;
            });
        }
    };

    // 星評価のセットアップ
    const setupRatingStars = () => {
        const stars = document.querySelectorAll('.rating__star');

        if (stars.length === 0) return;

        const selectedValue = document.querySelector('.rating input:checked')?.value || 0;
        stars.forEach((star, index) => {
            star.style.backgroundImage = index < selectedValue
                ? "url('/images/star_blue.png')"
                : "url('/images/star_gray.png')";
        });

        // 星のホバー・クリックイベント設定
        stars.forEach((star, index) => {
            star.addEventListener('mouseenter', () => {
                stars.forEach((s, i) => {
                    s.style.backgroundImage = i <= index ? "url('/images/star_blue.png')" : "url('/images/star_gray.png')";
                });
            });

            star.addEventListener('mouseleave', () => {
                const selectedValue = document.querySelector('.rating input:checked')?.value || 0;
                stars.forEach((s, i) => {
                    s.style.backgroundImage = i < selectedValue ? "url('/images/star_blue.png')" : "url('/images/star_gray.png')";
                });
            });

            star.addEventListener('click', () => {
                const value = star.getAttribute('data-value');
                document.getElementById(`star${value}`).checked = true;

                stars.forEach((s, i) => {
                    s.style.backgroundImage = i < value ? "url('/images/star_blue.png')" : "url('/images/star_gray.png')";
                });
            });
        });
    };

    // 画像プレビューとドラッグ＆ドロップのセットアップ
    const setupImagePreview = () => {
        const dropArea = document.getElementById('drop-area');
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('image-preview');

        if (!dropArea || !imageInput) return;


        dropArea.addEventListener('dragover', (event) => {
            event.preventDefault();
            dropArea.classList.add('dragover');
        });

        dropArea.addEventListener('dragleave', () => dropArea.classList.remove('dragover'));

        dropArea.addEventListener('drop', (event) => {
            event.preventDefault();
            dropArea.classList.remove('dragover');
            const files = event.dataTransfer.files;
            if (files.length > 0) handleFile(files[0]);
        });

        imageInput.addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (file) handleFile(file);
        });

        function handleFile(file) {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    imagePreview.innerHTML = `<img src="${e.target.result}" alt="プレビュー画像" style="max-width: 200px;">`;
                };
                reader.readAsDataURL(file);
            } else {
                imagePreview.innerHTML = '<p style="color: red;">画像ファイル（jpeg/png）を選択してください。</p>';
            }
        }
    };

    // 各機能の初期化
    setupCharCount();
    setupRatingStars();
    setupImagePreview();
});
