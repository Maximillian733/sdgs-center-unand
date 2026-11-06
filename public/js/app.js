(function () {
  var b = document.querySelector('.burger'), n = document.getElementById('nav');
  if (b && n) b.addEventListener('click', function () {
    var o = n.classList.toggle('open'); b.setAttribute('aria-expanded', o);
  });
  // konfirmasi sebelum hapus
  document.addEventListener('submit', function (e) {
    var m = e.target.getAttribute('data-confirm');
    if (m && !window.confirm(m)) e.preventDefault();
  });
  // lightbox galeri (pratinjau foto/video)
  var d = document.getElementById('lb');
  if (d) {
    var box = d.querySelector('.box2'), cap = d.querySelector('.cap');
    document.querySelectorAll('.thumb').forEach(function (t) {
      t.addEventListener('click', function () {
        box.innerHTML = '';
        var el = document.createElement(t.dataset.type === 'video' ? 'video' : 'img');
        el.src = t.dataset.src;
        if (el.tagName === 'VIDEO') { el.controls = true; el.autoplay = true; } else { el.alt = t.dataset.alt; }
        box.appendChild(el); cap.textContent = t.dataset.alt; d.showModal();
      });
    });
    d.querySelector('.close').addEventListener('click', function () { d.close(); });
    d.addEventListener('close', function () { box.innerHTML = ''; });
    d.addEventListener('click', function (e) { if (e.target === d) d.close(); });
  }
})();
