require('./bootstrap');

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.input-file').forEach(input => {
        input.addEventListener('change', function () {
            const file = this.files[0];

            if (!file) return;

            // create / update どちらかを判定
            const shopId = this.dataset.shopId;
            const formType = this.dataset.formType;

            // upload-status と preview のクラス名を決定
            const identifier = shopId || formType;

            const statusElement = document.querySelector(`.status-${identifier}`);
            const previewImage = document.querySelector(`.preview-${identifier}`);

            // ファイル名を表示
            if (statusElement) {
                statusElement.textContent = `${file.name} をアップロードしました`;
            }

            // プレビュー表示
            if (previewImage) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImage.src = e.target.result;
                    previewImage.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    });
});
