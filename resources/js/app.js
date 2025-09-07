import './bootstrap';


document.addEventListener('DOMContentLoaded', () => {
  // para todo .collapse: ao abrir, rola e foca no primeiro campo do form
  document.querySelectorAll('.collapse').forEach(el => {
    el.addEventListener('shown.bs.collapse', () => {
      el.scrollIntoView({ behavior: 'smooth', block: 'start' });
      const firstField = el.querySelector('input, textarea, select');
      if (firstField) firstField.focus();
    });
  });
});

