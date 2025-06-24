require('./bootstrap');

document.addEventListener('DOMContentLoaded', () => {
  const cards = document.querySelectorAll('.reservation-card');
  if (cards.length === 0) return;

  const modal = document.getElementById('deleteModal');
  const confirmDeleteBtn = document.getElementById('confirmDelete');
  const cancelDeleteBtn = document.getElementById('cancelDelete');
  let targetDeleteForm = null;

  // すべて閉じて、指定のカードだけ開く
  function closeAllExcept(openCard) {
    cards.forEach(card => {
      const icon = card.querySelector('.reservation-icon');
      const deleteBtn = card.querySelector('.delete-button');
      const body = card.querySelector('.reservation-body');

      if (card === openCard) {
        icon?.classList.remove('mypage-hidden');
        deleteBtn?.classList.remove('mypage-hidden');
        body?.classList.remove('mypage-hidden');
      } else {
        icon?.classList.add('mypage-hidden');
        deleteBtn?.classList.add('mypage-hidden');
        body?.classList.add('mypage-hidden');
      }
    });
  }

  // 初期状態で最初のカードだけ開く
  closeAllExcept(cards[0]);

  // 各カードのヘッダークリック時の動作
  cards.forEach(card => {
    const header = card.querySelector('.reservation-header');
    const body = card.querySelector('.reservation-body');

    header.addEventListener('click', (e) => {
      // ×ボタンがクリックされた場合はモーダル処理に任せる
      if (e.target.classList.contains('delete-button')) return;

      const isOpen = !body.classList.contains('mypage-hidden');
      if (isOpen) return; // 既に開いている場合は何もしない

      closeAllExcept(card);
    });

    // ×ボタン処理（モーダル表示）
    const deleteBtn = card.querySelector('.delete-button');
    deleteBtn.addEventListener('click', (e) => {
      e.stopPropagation(); // ヘッダークリックを止める
      targetDeleteForm = card.querySelector('.delete-reservation-form');
      modal?.classList.remove('mypage-hidden');
    });
  });

  // モーダル内の「はい」クリックで削除実行
  confirmDeleteBtn?.addEventListener('click', () => {
    if (targetDeleteForm) targetDeleteForm.submit();
  });

  // モーダル内の「いいえ」でキャンセル
  cancelDeleteBtn?.addEventListener('click', () => {
    modal?.classList.add('mypage-hidden');
    targetDeleteForm = null;
  });
  
  function closeAllExcept(openCard) {
    cards.forEach(card => {
      const icon = card.querySelector('.reservation-icon');
      const summary = card.querySelector('.reservation-summary');
      const deleteBtn = card.querySelector('.delete-button');
      const body = card.querySelector('.reservation-body');
      const hint = card.querySelector('.change-hint'); // ← 追加
  
      if (card === openCard) {
        icon.classList.remove('mypage-hidden');
        summary.classList.add('mypage-hidden');
        deleteBtn.classList.remove('mypage-hidden');
        body.classList.remove('mypage-hidden');
        if (hint) hint.classList.remove('mypage-hidden'); // ← 表示
      } else {
        icon.classList.add('mypage-hidden');
        summary.classList.remove('mypage-hidden');
        deleteBtn.classList.add('mypage-hidden');
        body.classList.add('mypage-hidden');
        if (hint) hint.classList.add('mypage-hidden'); // ← 非表示
      }
    });
  }

  
});
