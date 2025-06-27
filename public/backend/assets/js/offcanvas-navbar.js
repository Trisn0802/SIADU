(() => {
  'use strict';

  // Tampilkan sidebar 
  document.querySelector('#navbarSideCollapse').addEventListener('click', () => {
    document.querySelector('.offcanvas-collapse').classList.toggle('open');
  });

  // Tutup sidebar jika link dengan class yang sama di klik
  document.querySelectorAll('.nav-offcollapse-link').forEach(link => {
    link.addEventListener('click', () => {
      document.querySelector('.offcanvas-collapse').classList.remove('open');
    });
  });
})();
