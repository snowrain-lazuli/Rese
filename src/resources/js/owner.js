require('./bootstrap');

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.custom-file-input').forEach(input => {
        input.addEventListener('change', function () {
            const shopId = this.dataset.shopId;
            const file = this.files[0];

            if (file) {
                // ファイル名表示
                const statusEl = document.querySelector('.upload-status-' + shopId);
                statusEl.textContent = `${file.name} をアップロードしました`;

                // プレビュー画像の差し替え
                const reader = new FileReader();
                reader.onload = function (e) {
                    const preview = document.querySelector('.preview-' + shopId);
                    preview.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    });

    document.querySelectorAll('.custom-file-input').forEach(input => {
        input.addEventListener('change', function () {
            const formType = this.dataset.formType;
            const file = this.files[0];

            if (file) {
                const statusEl = document.querySelector('.upload-status-' + formType);
                statusEl.textContent = `${file.name} をアップロードしました`;

                const reader = new FileReader();
                reader.onload = function (e) {
                    const preview = document.querySelector('.preview-' + formType);
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    });
});