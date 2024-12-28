 /*============== Toggle icon NavBar============*/

 let menuIcon = document.querySelector(' #menu-icon');
 let navbar= document.querySelector(' .navbar');
 
 menuIcon.onclick = ()=>{
 
     menuIcon.classList.toggle('bx-x');
     navbar.classList.toggle('active');
 }
  /*==============  Scroll Section active link========*/
 
 let sections = document.querySelectorAll('section');
 let navlinks = document.querySelectorAll('header nav a');
 window.onscroll = ()=>{
 sections.forEach(sec =>{
 let top = window.scrollY;
 let offset = sec.offsetTop - 150;
 let height = sec.offsetHeight;
 let id = sec.getAttribute('id');
 
 if(top >= offset && top < offset + height){
     navlinks.forEach(links =>{
         links.classList.remove('active');
         document.querySelector('header nav a[href*='+ id +']').classList.add('active')
     });
 
 };
 
 });
  /*============== Sticky Nav Bar ========*/
 let header = document.querySelector('header');
 header.classList.toggle('sticky', window.scrollY > 100);
 
  /*============== Scroll Remove Section ========*/
  menuIcon.classList.remove('bx-x');
     navbar.classList.remove('active');
 };
 
 /*============== Scroll Reveal ========*/
 
 ScrollReveal({
     
 //reset: true,
 distance: '80px',
 duration: 2000,
 delay: 200
 
 
 });
 
 ScrollReveal().reveal(' .home-content, .heading', {origin: 'top'});
 ScrollReveal().reveal(' .home-img, .services-container, .portfolio-box, .contact form', {origin: 'bottom'});
 ScrollReveal().reveal(' .home-content h1, .about-img', {origin: 'left'});
 ScrollReveal().reveal(' .home-content p, .about-content', {origin: 'right'});
 
 
 
 const typed = new Typed('.multiple-text',{strings: ['Welcome to the Employee Management System', 'Our Vision','is to Provide', 'a comprehensive and user-friendly platform designed to streamline HR processes and enhance workforce management'], typeSpeed: 100, backSpeed: 100, backDelay: 1000, loop: true});