document.addEventListener("DOMContentLoaded",()=>{m.init(),new g;const t=document.querySelector(".header");let e=0;window.addEventListener("scroll",()=>{const s=window.pageYOffset;s>680?t.classList.add("scrolled"):t.classList.remove("scrolled"),s>e&&s>100?t.classList.add("hidden"):t.classList.remove("hidden"),e=s})});const m={init(){this.initSmoothScroll(),this.initAnimationsScroll(),this.initBurgerMenu(),this.initFAQ()},initSmoothScroll(){document.querySelectorAll('a[href^="#"]').forEach(e=>{e.addEventListener("click",function(s){s.preventDefault();const i=document.querySelector(this.getAttribute("href"));i&&i.scrollIntoView({behavior:"smooth",block:"start"})})})},initAnimationsScroll(){const t={threshold:.1},e=new IntersectionObserver((i,o)=>{i.forEach(a=>{a.isIntersecting&&(a.target.classList.add("animate"),o.unobserve(a.target))})},t);document.querySelectorAll(".carte-activite, .membre-equipe, .faq-item").forEach(i=>e.observe(i))},initBurgerMenu(){const t=document.querySelector(".hamburger"),e=t?t.querySelector("i"):null,s=document.querySelector(".menu-mobile");t&&s&&e&&t.addEventListener("click",()=>{s.classList.toggle("open");const i=s.classList.contains("open");e.className=i?"fa-solid fa-xmark":"fa-solid fa-bars"})},initFAQ(){const t=document.querySelectorAll(".faq-item");t.forEach(e=>{const s=e.querySelector(".faq-question");s&&s.addEventListener("click",i=>{i.stopPropagation(),t.forEach(o=>{if(o!==e){o.classList.remove("active");const a=o.querySelector(".faq-question");a&&a.setAttribute("aria-expanded","false")}}),e.classList.toggle("active"),s.setAttribute("aria-expanded",e.classList.contains("active")?"true":"false")}),e.addEventListener("click",i=>i.stopPropagation())})}};class g{constructor(){this.carousel=document.querySelector(".carousel"),this.slides=Array.from(document.querySelectorAll(".slide")),this.dots=Array.from(document.querySelectorAll(".dot")),this.currentSlide=0,this.slideInterval=null,this.init()}init(){this.dots.forEach((e,s)=>{e.addEventListener("click",()=>this.goToSlide(s))}),this.startSlideshow(),this.carousel.addEventListener("mouseenter",()=>this.pauseSlideshow()),this.carousel.addEventListener("mouseleave",()=>this.startSlideshow())}goToSlide(e){this.slides[this.currentSlide].classList.remove("active"),this.dots[this.currentSlide].classList.remove("active"),this.currentSlide=e,this.slides[this.currentSlide].classList.add("active"),this.dots[this.currentSlide].classList.add("active")}nextSlide(){const e=(this.currentSlide+1)%this.slides.length;this.goToSlide(e)}prevSlide(){const e=(this.currentSlide-1+this.slides.length)%this.slides.length;this.goToSlide(e)}startSlideshow(){this.slideInterval||(this.slideInterval=setInterval(()=>this.nextSlide(),5e3))}pauseSlideshow(){this.slideInterval&&(clearInterval(this.slideInterval),this.slideInterval=null)}}const n=[{quote:"Charger de supervise et coordonne les activités du comité, représente officiellement le groupe et prend les décisions stratégiques.",name:"SORO Eméric Jamel",designation:"Président du comité d'organisation (PCO)",src:"backend/client/assets/images/Emeric.jpg"},{quote:"Charger d'assister le président, le remplace en son absence et supervise des projets ou sous-comités spécifiques.",name:"ADJE Aude-esther",designation:"Vice président du comité d'organisation (Vice-PCO)",src:"backend/client/assets/images/default.jpg"},{quote:"Charger de gèrer la documentation, rédige les procès-verbaux, prépare les ordres du jour et assure la communication interne.",name:"TRA Lou Océane",designation:"Sécrétaire et Responsable du comité logiciel",src:"backend/client/assets/images/oceane.png"},{quote:"Charger de gèrer les finances, prépare les budgets, suit les dépenses/recettes et veille à la transparence financière.",name:"IRIE Anne Jemima",designation:"Trésorier",src:"backend/client/assets/images/Jemima.jpg"}];let r=0;function h(){const t=document.getElementById("imageContainer");n.forEach((e,s)=>{const i=document.createElement("img");i.src=e.src,i.alt=e.name,i.className=`testimonial-image ${s===0?"active":"inactive"}`,i.id=`image-${s}`,t.appendChild(i)})}function c(t){document.getElementById("name").textContent=n[t].name,document.getElementById("designation").textContent=n[t].designation;const e=document.getElementById("quote");e.textContent=n[t].quote,e.classList.remove("active"),setTimeout(()=>e.classList.add("active"),50),document.querySelectorAll(".testimonial-image").forEach((s,i)=>{s.className=`testimonial-image ${i===t?"active":"inactive"}`})}function d(){r=(r+1)%n.length,c(r)}function v(){r=(r-1+n.length)%n.length,c(r)}function p(){setInterval(d,5e3)}document.addEventListener("DOMContentLoaded",()=>{h(),c(0),document.getElementById("nextButton").addEventListener("click",d),document.getElementById("prevButton").addEventListener("click",v),p()});const l=[{img:"assets/images/partenaires/logo1.jpeg"},{img:"assets/images/partenaires/logo2.jpg"},{img:"assets/images/partenaires/logo3.png"},{img:"assets/images/partenaires/logo3.jpg"},{img:"assets/images/partenaires/logo3.png"},{img:"assets/images/partenaires/logo1.jpeg"}];function f(t){return`<img src="${t.img}" alt="" />`}function S(t){const e=t.innerHTML;t.innerHTML=e+e}const E=l.slice(0,l.length/2),u=document.getElementById("firstRow");u.innerHTML=E.map(f).join("");S(u);
