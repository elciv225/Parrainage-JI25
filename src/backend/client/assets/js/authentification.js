import{g as r}from"../index.js";document.addEventListener("DOMContentLoaded",function(){const p=document.querySelectorAll(".question-item"),$=document.querySelectorAll(".option"),f=document.getElementById("next-btn"),E=document.getElementById("prev-btn"),j=document.getElementById("question-number"),G=document.querySelector(".progress-bar-inner"),w=document.getElementById("total-score");let l=0,L=0;const C=[];p.forEach((e,t)=>{t!==0&&r.set(e,{display:"none",opacity:0}),e.style.willChange="transform, opacity"});function T(){f.disabled=!0,E.disabled=l===0}function I(){const e=(l+1)/p.length*100;G.style.width=`${e}%`}$.forEach(e=>{e.addEventListener("click",function(){p[l].querySelectorAll(".option").forEach(n=>n.classList.remove("selected")),this.classList.add("selected");const o=parseInt(this.dataset.score,10)||0;C[l]={question:p[l].querySelector(".question").textContent.trim(),response:this.textContent.trim(),score:o},f.disabled=!1})});function z(e,t){r.to(e,{opacity:0,x:-40,duration:.25,ease:"power2.in",onComplete:()=>{e.style.display="none",t&&t()}})}function H(e,t){r.set(e,{display:"block",opacity:0,x:40}),r.to(e,{opacity:1,x:0,duration:.25,ease:"power2.out",onComplete:()=>{t&&t()}})}f.addEventListener("click",function(){const e=C[l];e&&(L+=e.score),w&&(w.value=L),f.disabled=!0,E.disabled=!0;const t=p[l];z(t,function(){if(l++,l<p.length){const o=p[l];j.innerText=l+1,I(),H(o,function(){T()})}else S(null,"ajout-photo")})}),E.addEventListener("click",function(){if(l>0){const e=C[l];e&&(L-=e.score),w&&(w.value=L),f.disabled=!0,E.disabled=!0;const t=p[l];z(t,function(){if(l--,l>=0){const o=p[l];j.innerText=l+1,I(),H(o,function(){T()})}})}}),I(),T(),r.from(".quiz-container",{opacity:0,scale:.95,duration:.5,ease:"power2.out"});const v=document.getElementById("inscription"),b=document.getElementById("connexion"),x=document.getElementById("parrainage"),A=document.getElementById("ajout-photo"),J=window.matchMedia("(max-width: 530px)").matches;function S(e,t=null){e&&e.preventDefault(),t=t||(e?e.target.getAttribute("href").substring(1):window.location.hash.substring(1));let o,n;t==="connexion"?(o=v,n=b,document.body.classList.remove("parrainage-active")):t==="inscription"?(o=b,n=v,document.body.classList.remove("parrainage-active")):t==="parrainage"?(o=v,n=x,document.body.classList.add("parrainage-active")):t==="ajout-photo"&&(o=x,n=A,document.body.classList.add("parrainage-active")),[v,b,x,A].forEach(ee=>{r.set(ee,{zIndex:-1,display:"none",opacity:0})});let i=150,a=0,F=-150,_=0;(t==="parrainage"||t==="ajout-photo")&&J&&(i=0,a=200),r.to(o,{opacity:0,x:F,y:_,scale:.95,duration:.3,ease:"power2.in",onComplete:()=>{o.style.display="none"}}),n.style.display="block",r.fromTo(n,{opacity:0,x:i,y:a,scale:.9},{opacity:1,x:0,y:0,scale:1,duration:.4,ease:"power2.out",onStart:()=>{n.style.zIndex=1},onComplete:()=>{n.style.zIndex=2}})}document.querySelectorAll('a[href="#connexion"], a[href="#inscription"]').forEach(e=>{e.addEventListener("click",S)});const k=document.querySelector("#inscription form"),B=document.querySelector("#ajout-photo form");k&&k.addEventListener("submit",function(e){e.preventDefault();const t=new FormData(k);t.forEach((n,i)=>{localStorage.setItem(i,n)});const o=t.get("niveau");o==="L1"||o==="L3"?S(null,"parrainage"):S(null,"ajout-photo")}),B&&(B.querySelectorAll("input, select").forEach(t=>{const o=localStorage.getItem(t.name);o&&(t.value=o)}),B.addEventListener("submit",function(){["nom","prenoms","niveau","email","motDePasse","confirmMotDePasse"].forEach(o=>{const n=localStorage.getItem(o);if(n){const i=document.querySelector(`#hidden-${o}`);i&&(i.value=n)}})})),r.set(b,{zIndex:-1,opacity:0,display:"none"}),r.set(x,{zIndex:-1,opacity:0,display:"none"}),r.set(A,{zIndex:-1,opacity:0,display:"none"}),r.set(v,{zIndex:1,opacity:1,display:"block"}),r.timeline().from(".principal-container",{opacity:0,scale:.9,y:50,duration:.5,ease:"power3.out"}).from(".section-droite",{opacity:0,x:40,duration:.5,ease:"power3.out"},"-=0.3").from("#inscription .header-form h3",{opacity:0,y:20,duration:.4,ease:"power2.out",stagger:.1},"-=0.2").from("#inscription .body-form .input-group, #inscription .body-form .select-group",{opacity:0,y:20,duration:.4,ease:"power2.out",stagger:.1},"-=0.2").from("#inscription .footer-form button",{opacity:0,y:20,duration:.4,ease:"power2.out",stagger:.1},"-=0.2"),document.querySelectorAll(".input-group input, .select-group select").forEach(e=>{e.addEventListener("focus",()=>{r.timeline({defaults:{ease:"power2.inOut"}}).to(e,{x:-10,duration:.1}).to(e,{x:10,duration:.2}).to(e,{x:-5,duration:.15}).to(e,{x:5,duration:.15}).to(e,{x:0,duration:.07,onComplete:()=>{r.to(e,{boxShadow:"0 4px 10px rgba(0, 0, 0, 0.15)",duration:.2,ease:"power2.out"})}})}),e.addEventListener("blur",()=>{r.to(e,{x:0,boxShadow:"none",duration:.3,ease:"power2.in"})})});const s=document.getElementById("inscription-nom"),c=document.getElementById("inscription-prenoms"),u=document.createElement("ul"),d=document.createElement("ul");u.className="suggestions-list",d.className="suggestions-list",s.parentNode.insertBefore(u,s.nextSibling),c.parentNode.insertBefore(d,c.nextSibling);let m={etudiants:[]};fetch("/etudiants.json").then(e=>{if(!e.ok)throw new Error(`Erreur HTTP ${e.status} lors du chargement du JSON`);return e.json()}).then(e=>{if(!e||!Array.isArray(e.etudiants))throw new Error("Format JSON invalide : 'etudiants' doit être un tableau.");m=e}).catch(e=>{g(s,"Erreur chargement données"),g(c,"Erreur chargement données")}),document.addEventListener("click",e=>{const t=e.target===s||e.target===c,o=e.target.closest(".suggestions-list");!t&&!o&&[u,d].forEach(n=>{n.style.display==="block"&&r.to(n,{opacity:0,y:-10,duration:.2,onComplete:()=>n.style.display="none"})})});function N(e){if(!e||!m.etudiants.length)return[];const t=e.toLowerCase(),o=new Set;return m.etudiants.forEach(n=>{n.nom&&n.nom.toLowerCase().includes(t)&&o.add(n.nom)}),Array.from(o)}function D(e,t){if(!t||!e||!m.etudiants.length)return[];const o=e.toLowerCase(),n=t.toLowerCase(),i=new Set;return m.etudiants.forEach(a=>{a.nom&&a.nom.toLowerCase()===n&&a.prenoms&&a.prenoms.toLowerCase().includes(o)&&i.add(a.prenoms)}),Array.from(i)}function q(e,t,o,n){if(t.innerHTML="",o.length===0){t.style.display==="block"&&r.to(t,{opacity:0,y:-10,duration:.2,onComplete:()=>t.style.display="none"});return}o.forEach(i=>{const a=document.createElement("li");a.textContent=i,a.addEventListener("mouseenter",()=>{r.to(a,{backgroundColor:"var(--background-secondary)",duration:.2})}),a.addEventListener("mouseleave",()=>{r.to(a,{backgroundColor:"var(--background-primary)",duration:.2})}),a.addEventListener("click",()=>{e.value=i,r.to(t,{opacity:0,y:-10,duration:.2,onComplete:()=>t.style.display="none"}),typeof n=="function"&&n(i)}),t.appendChild(a)}),t.style.display!=="block"&&(t.style.display="block",t.style.opacity="0",r.fromTo(t,{opacity:0,y:-10},{opacity:1,y:0,duration:.3}),r.fromTo(t.children,{opacity:0,y:-10},{opacity:1,y:0,duration:.3,stagger:.05}))}function g(e,t){const o=e.parentNode.querySelector(".erreur-message");o&&r.to(o,{opacity:0,y:10,duration:.2,onComplete:()=>o.remove()});const n=document.createElement("span");n.className="erreur-message",n.textContent=t,e.parentNode.insertBefore(n,e.nextSibling),e.classList.add("input-error"),r.timeline().to(e,{x:-10,duration:.1}).to(e,{x:10,duration:.1}).to(e,{x:-5,duration:.08}).to(e,{x:5,duration:.08}).to(e,{x:0,duration:.05}),r.fromTo(n,{opacity:0,y:-10},{opacity:1,y:0,duration:.3}),setTimeout(()=>{r.to(n,{opacity:0,y:10,duration:.3,onComplete:()=>{n.remove(),e.classList.remove("input-error")}})},3e3)}s.addEventListener("input",()=>{const e=s.value,t=N(e);q(s,u,t,()=>{c.value="",d.innerHTML="",d.style.display="none"}),e||(d.innerHTML="",d.style.display="none"),s.removeAttribute("invalid");const o=s.parentNode.querySelector(".erreur-message");o&&o.remove()}),s.addEventListener("focus",()=>{const e=s.value,t=N(e);q(s,u,t,()=>{c.value="",d.innerHTML="",d.style.display="none"})}),s.addEventListener("blur",()=>{setTimeout(()=>{if(document.activeElement===u||u.contains(document.activeElement))return;const e=s.value,t=m.etudiants.some(o=>o.nom&&o.nom.toLowerCase()===e.toLowerCase());e&&!t&&N(e).filter(n=>n.toLowerCase()===e.toLowerCase()).length===0?(s.setAttribute("invalid","true"),g(s,"Ce nom est inconnu")):s.removeAttribute("invalid"),u.style.display==="block"&&!s.hasAttribute("invalid")&&r.to(u,{opacity:0,y:-10,duration:.2,onComplete:()=>u.style.display="none"})},200)}),c.addEventListener("input",()=>{const e=c.value,t=s.value,o=D(e,t);q(c,d,o),c.removeAttribute("invalid");const n=c.parentNode.querySelector(".erreur-message");n&&n.remove()}),c.addEventListener("focus",()=>{const e=c.value,t=s.value;if(t){const o=D(e,t);q(c,d,o)}}),c.addEventListener("blur",()=>{setTimeout(()=>{if(document.activeElement===d||d.contains(document.activeElement))return;const e=c.value,t=s.value;if(e&&t){const o=m.etudiants.some(i=>i.nom&&i.nom.toLowerCase()===t.toLowerCase()&&i.prenoms&&i.prenoms.toLowerCase()===e.toLowerCase()),n=D(e,t).filter(i=>i.toLowerCase()===e.toLowerCase());!o&&n.length===0?(c.setAttribute("invalid","true"),g(c,"Prénom inconnu pour ce nom")):c.removeAttribute("invalid")}else c.removeAttribute("invalid");d.style.display==="block"&&!c.hasAttribute("invalid")&&r.to(d,{opacity:0,y:-10,duration:.2,onComplete:()=>d.style.display="none"})},200)});const R=document.getElementById("inscription-mdp"),h=document.getElementById("inscription-confirm-mdp");h.addEventListener("blur",()=>{setTimeout(()=>{const e=h.value;R.value!==e?(h.setAttribute("invalid","true"),g(h,"Les mots de passe ne correspondent pas")):h.removeAttribute("invalid")},200)}),document.querySelectorAll(".input-group").forEach(e=>{const t=e.querySelector('input[type="password"]'),o=e.querySelector(".toggle-password");if(t&&o){const n=o.querySelector(".eye-open"),i=o.querySelector(".eye-closed"),a=r.timeline({paused:!0});a.to(o,{duration:.4,rotation:180,ease:"back.out(1.7)",transformOrigin:"center center"}),a.to(i,{duration:.2,opacity:0,scale:.5,ease:"power2.out"},0),a.to(n,{duration:.3,opacity:1,scale:1,ease:"power2.out"},0);const F=()=>{r.to(t,{duration:.12,filter:"blur(5px)",ease:"power1.out",onComplete:()=>{t.type=t.type==="password"?"text":"password",t.type==="text"?a.play():a.reverse(),r.to(t,{duration:.3,filter:"blur(0px)",ease:"power1.out"})}})};o.addEventListener("click",function(){F()})}});const y=document.querySelector(".upload-zone"),P=document.getElementById("photo-profil"),M=document.querySelector(".preview-container"),U=document.getElementById("preview-image"),X=document.querySelector(".remove-preview"),O=document.querySelector(".error-message");function Y(e){return["image/jpeg","image/png","image/gif"].includes(e.type)}function Q(e){if(!Y(e)){O.classList.add("active"),P.value="";return}O.classList.remove("active");const t=new FileReader;t.onload=function(o){U.src=o.target.result,M.classList.add("active"),r.from(M,{opacity:0,y:20,duration:.3,ease:"power2.out"})},t.readAsDataURL(e)}["dragenter","dragover","dragleave","drop"].forEach(e=>{y.addEventListener(e,V,!1)});function V(e){e.preventDefault(),e.stopPropagation()}["dragenter","dragover"].forEach(e=>{y.addEventListener(e,W,!1)}),["dragleave","drop"].forEach(e=>{y.addEventListener(e,Z,!1)});function W(){y.classList.add("drag-over")}function Z(){y.classList.remove("drag-over")}y.addEventListener("drop",K,!1);function K(e){const o=e.dataTransfer.files[0];Q(o)}P.addEventListener("change",function(){this.files&&this.files[0]&&Q(this.files[0])}),X.addEventListener("click",function(){P.value="",M.classList.remove("active"),O.classList.remove("active")})});
