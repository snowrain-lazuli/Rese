require('./bootstrap');

document.addEventListener('DOMContentLoaded', () => {
    const dateInput = document.getElementById('reservation-date');
    const timeSelect = document.getElementById('reservation-time');
    const numberSelect = document.getElementById('reservation-number');

    const summaryDate = document.getElementById('summary-date');
    const summaryTime = document.getElementById('summary-time');
    const summaryNumber = document.getElementById('summary-number');

    if (!dateInput || !timeSelect || !numberSelect) return;

    const updateSummary = () => {
        summaryDate.textContent = dateInput.value ? dateInput.value : '----';
        summaryTime.textContent = timeSelect.value || '----';
        summaryNumber.textContent = numberSelect.value ? numberSelect.value + '人' : '--人';

    };

    dateInput.addEventListener('change', updateSummary);
    timeSelect.addEventListener('change', updateSummary);
    numberSelect.addEventListener('change', updateSummary);

    // ページロード直後に一旦 ---- にしたい場合はここで明示的にセット
    summaryDate.textContent = '----';
    summaryTime.textContent = '----';
    summaryNumber.textContent = '--人';

    updateSummary();
});
