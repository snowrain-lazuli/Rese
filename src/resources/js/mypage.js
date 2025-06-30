require('./bootstrap');

document.addEventListener('DOMContentLoaded', () => {
  const items = document.querySelectorAll('.reservation-item');
  if (items.length === 0) return;

  const modal = document.getElementById('deleteModal');
  const confirmDeleteBtn = document.getElementById('confirmDelete');
  const cancelDeleteBtn = document.getElementById('cancelDelete');
  let targetDeleteForm = null;

  // 一つ以外全て閉じる
  function closeAllExcept(openItem) {
    items.forEach(item => {
      const icon = item.querySelector('.reservation-icon');
      const info = item.querySelector('.reservation-info');
      const deleteBtn = item.querySelector('.reservation-delete-button');
      const details = item.querySelector('.reservation-details');
      const note = item.querySelector('.reservation-note');

      if (item === openItem) {
        icon?.classList.remove('hidden');
        info?.classList.add('hidden');
        deleteBtn?.classList.remove('hidden');
        details?.classList.remove('hidden');
        note?.classList.remove('hidden');
      } else {
        icon?.classList.add('hidden');
        info?.classList.remove('hidden');
        deleteBtn?.classList.add('hidden');
        details?.classList.add('hidden');
        note?.classList.add('hidden');
      }
    });
  }

  closeAllExcept(items[0]);

  items.forEach(item => {
    const header = item.querySelector('.reservation-header');
    const details = item.querySelector('.reservation-details');

    header.addEventListener('click', (e) => {
      if (e.target.classList.contains('reservation-delete-button')) return;
      const isOpen = !details.classList.contains('hidden');
      if (isOpen) return;
      closeAllExcept(item);
    });

    const deleteBtn = item.querySelector('.reservation-delete-button');
    deleteBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      targetDeleteForm = item.querySelector('.reservation-delete-form');
      modal?.classList.remove('hidden');
    });
  });

  confirmDeleteBtn?.addEventListener('click', () => {
    if (targetDeleteForm) targetDeleteForm.submit();
  });

  cancelDeleteBtn?.addEventListener('click', () => {
    modal?.classList.add('hidden');
    targetDeleteForm = null;
  });
});
