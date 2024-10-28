const navMenu = document.getElementById('nav-menu')
const navToggle = document.getElementById('nav-toggle')

navToggle.addEventListener('click', () => {
  navMenu.classList.toggle('show-menu')
})

// Tutup menu saat link diklik
const navLinks = document.querySelectorAll('.nav__link')
navLinks.forEach(link => {
  link.addEventListener('click', () => {
    navMenu.classList.remove('show-menu')
  })
})

