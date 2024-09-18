/===== MENU SHOW =====/ 
const showMenu = (toggleId, navId) => {
    const toggle = document.getElementById(toggleId),
    nav = document.getElementById(navId)

    if(toggle && nav){
        toggle.addEventListener('click', ()=>{
            nav.classList.toggle('show')
        })
    }
}
showMenu('nav-toggle','nav-menu')
/*===== REMOVE MENU MOBILE =====*/
const navLink = document.querySelectorAll('.nav__link')

function linkAction(){
    const navMenu = document.getElementById('nav-menu')
    navMenu.classList.remove('show')
}
navLink.forEach(n => n.addEventListener('click' , linkAction))
/*===== SCROLL SECTIONS ACTIVE LINK =====*/
const sections = document.querySelectorAll('section[id]')
window.addEventListener('scroll' , scrollActive)

function scrollActive(){
    const scrollY = window.pageYOffset

    sections.forEach(current =>{
        const sectionHeight = current.offsetHeight
        const sectionTop = current.offsetTop - 50;
        sectionId = current.getAttribute('id')

        if(scrollY > sectionTop && scrollY <= sectionTop + sectionHeight){
            document.querySelector('.nav__menu a[href*= '+ sectionId +' ]').classList.add('active')
        }else{
            document.querySelector('.nav__menu a[href*=' + sectionId + ']').classList.remove('active')
        }
    })
}
/*===== SCROLL REVEAL ANIMATION =====*/
const sr = ScrollReveal({
    origin: 'top',
    distance: '80px',
    duration:  2000,
    reset: true
})

/*SCROLL HOME*/
sr.reveal('.home__title',{})
sr.reveal('.home__scroll', {delay:200})
sr.reveal('home__img',{origin:'right',delay:400})

/*SCROLL reserve*/
sr.reveal('.reserve__img',{delay:500})
sr.reveal('.reserve__subtitle',{delay:300})
sr.reveal('.reserve__profession', {delay:400})
sr.reveal('.reserve__text', {delay:500})
sr.reveal('.reserve__social-icon',{delay:600, interval:200})

/*SCROLL menuS*/
sr.reveal('.menus__subtitle',{})
sr.reveal('.menus__name',{distance:'20px',delay:50,interval:100})
sr.reveal('.menus__img',{delay:400})

document.querySelector('#close-edit').onclick = () =>{
    document.querySelector('.edit-form-container').style.display = 'none';
    window.location.href = 'admin.php';
 };