import{g as i}from"../index.js";/**
 * @license lucide v0.484.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const X={xmlns:"http://www.w3.org/2000/svg",width:24,height:24,viewBox:"0 0 24 24",fill:"none",stroke:"currentColor","stroke-width":2,"stroke-linecap":"round","stroke-linejoin":"round"};/**
 * @license lucide v0.484.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Y=([n,u,a])=>{const l=document.createElementNS("http://www.w3.org/2000/svg",n);return Object.keys(u).forEach(d=>{l.setAttribute(d,String(u[d]))}),a!=null&&a.length&&a.forEach(d=>{const m=Y(d);l.appendChild(m)}),l},ie=(n,u={})=>{const a="svg",l={...X,...u};return Y([a,l,n])};/**
 * @license lucide v0.484.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ae=n=>Array.from(n.attributes).reduce((u,a)=>(u[a.name]=a.value,u),{}),se=n=>typeof n=="string"?n:!n||!n.class?"":n.class&&typeof n.class=="string"?n.class.split(" "):n.class&&Array.isArray(n.class)?n.class:"",ce=n=>n.flatMap(se).map(a=>a.trim()).filter(Boolean).filter((a,l,d)=>d.indexOf(a)===l).join(" "),le=n=>n.replace(/(\w)(\w*)(_|-|\s*)/g,(u,a,l)=>a.toUpperCase()+l.toLowerCase()),U=(n,{nameAttr:u,icons:a,attrs:l})=>{var v;const d=n.getAttribute(u);if(d==null)return;const m=le(d),f=a[m];if(!f)return console.warn(`${n.outerHTML} icon name was not found in the provided icons object.`);const c=ae(n),y={...X,"data-lucide":d,...l,...c},h=ce(["lucide",`lucide-${d}`,c,l]);h&&Object.assign(y,{class:h});const E=ie(f,y);return(v=n.parentNode)==null?void 0:v.replaceChild(E,n)};/**
 * @license lucide v0.484.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const de=[["path",{d:"m15 18-.722-3.25"}],["path",{d:"M2 8a10.645 10.645 0 0 0 20 0"}],["path",{d:"m20 15-1.726-2.05"}],["path",{d:"m4 15 1.726-2.05"}],["path",{d:"m9 18 .722-3.25"}]];/**
 * @license lucide v0.484.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ue=[["path",{d:"M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"}],["circle",{cx:"12",cy:"12",r:"3"}]];/**
 * @license lucide v0.484.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const V=({icons:n={},nameAttr:u="data-lucide",attrs:a={}}={})=>{if(!Object.values(n).length)throw new Error(`Please provide an icons object.
If you want to use all the icons you can import it like:
 \`import { createIcons, icons } from 'lucide';
lucide.createIcons({icons});\``);if(typeof document>"u")throw new Error("`createIcons()` only works in a browser environment.");const l=document.querySelectorAll(`[${u}]`);if(Array.from(l).forEach(d=>U(d,{nameAttr:u,icons:n,attrs:a})),u==="data-lucide"){const d=document.querySelectorAll("[icon-name]");d.length>0&&(console.warn("[Lucide] Some icons were found with the now deprecated icon-name attribute. These will still be replaced for backwards compatibility, but will no longer be supported in v1.0 and you should switch to data-lucide"),Array.from(d).forEach(m=>U(m,{nameAttr:"icon-name",icons:n,attrs:a})))}};document.addEventListener("DOMContentLoaded",function(){const n=document.querySelectorAll(".question-item"),u=document.querySelectorAll(".option"),a=document.getElementById("next-btn"),l=document.getElementById("prev-btn"),d=document.getElementById("question-number"),m=document.querySelector(".progress-bar-inner"),f=document.getElementById("total-score");let c=0,y=0;const h=[];n.forEach((e,t)=>{t!==0&&i.set(e,{display:"none",opacity:0}),e.style.willChange="transform, opacity"});function E(){a.disabled=!0,l.disabled=c===0}function v(){const e=(c+1)/n.length*100;m.style.width=`${e}%`}u.forEach(e=>{e.addEventListener("click",function(){n[c].querySelectorAll(".option").forEach(r=>r.classList.remove("selected")),this.classList.add("selected");const o=parseInt(this.dataset.score,10)||0;h[c]={question:n[c].querySelector(".question").textContent.trim(),response:this.textContent.trim(),score:o},a.disabled=!1})});function M(e,t){i.to(e,{opacity:0,x:-40,duration:.25,ease:"power2.in",onComplete:()=>{e.style.display="none",t&&t()}})}function P(e,t){i.set(e,{display:"block",opacity:0,x:40}),i.to(e,{opacity:1,x:0,duration:.25,ease:"power2.out",onComplete:()=>{t&&t()}})}a.addEventListener("click",function(){const e=h[c];e&&(y+=e.score),f&&(f.value=y),a.disabled=!0,l.disabled=!0;const t=n[c];M(t,function(){if(c++,c<n.length){const o=n[c];d.innerText=c+1,v(),P(o,function(){E()})}else I(null,"ajout-photo")})}),l.addEventListener("click",function(){if(c>0){const e=h[c];e&&(y-=e.score),f&&(f.value=y),a.disabled=!0,l.disabled=!0;const t=n[c];M(t,function(){if(c--,c>=0){const o=n[c];d.innerText=c+1,v(),P(o,function(){E()})}})}}),v(),E(),i.from(".quiz-container",{opacity:0,scale:.95,duration:.5,ease:"power2.out"});const w=document.getElementById("inscription"),L=document.getElementById("connexion"),S=document.getElementById("parrainage"),k=document.getElementById("ajout-photo"),J=window.matchMedia("(max-width: 530px)").matches;function I(e,t=null){e&&e.preventDefault(),t=t||(e?e.target.getAttribute("href").substring(1):window.location.hash.substring(1));let o,r;t==="connexion"?(o=w,r=L,document.body.classList.remove("parrainage-active")):t==="inscription"?(o=L,r=w,document.body.classList.remove("parrainage-active")):t==="parrainage"?(o=w,r=S,document.body.classList.add("parrainage-active")):t==="ajout-photo"&&(o=S,r=k,document.body.classList.add("parrainage-active")),[w,L,S,k].forEach(re=>{i.set(re,{zIndex:-1,display:"none",opacity:0})});let s=150,p=0,x=-150,ne=0;(t==="parrainage"||t==="ajout-photo")&&J&&(s=0,p=200),i.to(o,{opacity:0,x,y:ne,scale:.95,duration:.3,ease:"power2.in",onComplete:()=>{o.style.display="none"}}),r.style.display="block",i.fromTo(r,{opacity:0,x:s,y:p,scale:.9},{opacity:1,x:0,y:0,scale:1,duration:.4,ease:"power2.out",onStart:()=>{r.style.zIndex=1},onComplete:()=>{r.style.zIndex=2}})}document.querySelectorAll('a[href="#connexion"], a[href="#inscription"]').forEach(e=>{e.addEventListener("click",I)});const q=document.querySelector("#inscription form"),T=document.querySelector("#ajout-photo form");q&&q.addEventListener("submit",function(e){e.preventDefault();const t=new FormData(q);t.forEach((r,s)=>{localStorage.setItem(s,r)});const o=t.get("niveau");o==="L1"||o==="L3"?I(null,"parrainage"):I(null,"ajout-photo")}),T&&(T.querySelectorAll("input, select").forEach(t=>{const o=localStorage.getItem(t.name);o&&(t.value=o)}),T.addEventListener("submit",function(){["nom","prenoms","niveau","email","motDePasse","confirmMotDePasse"].forEach(o=>{const r=localStorage.getItem(o);if(r){const s=document.querySelector(`#hidden-${o}`);s&&(s.value=r)}})})),i.set(L,{zIndex:-1,opacity:0,display:"none"}),i.set(S,{zIndex:-1,opacity:0,display:"none"}),i.set(k,{zIndex:-1,opacity:0,display:"none"}),i.set(w,{zIndex:1,opacity:1,display:"block"}),i.timeline().from(".principal-container",{opacity:0,scale:.9,y:50,duration:.5,ease:"power3.out"}).from(".section-droite",{opacity:0,x:40,duration:.5,ease:"power3.out"},"-=0.3").from("#inscription .header-form h3",{opacity:0,y:20,duration:.4,ease:"power2.out",stagger:.1},"-=0.2").from("#inscription .body-form .input-group, #inscription .body-form .select-group",{opacity:0,y:20,duration:.4,ease:"power2.out",stagger:.1},"-=0.2").from("#inscription .footer-form button",{opacity:0,y:20,duration:.4,ease:"power2.out",stagger:.1},"-=0.2"),document.querySelectorAll(".input-group input, .select-group select").forEach(e=>{e.addEventListener("focus",()=>{i.timeline({defaults:{ease:"power2.inOut"}}).to(e,{x:-10,duration:.1}).to(e,{x:10,duration:.2}).to(e,{x:-5,duration:.15}).to(e,{x:5,duration:.15}).to(e,{x:0,duration:.07,onComplete:()=>{i.to(e,{boxShadow:"0 4px 10px rgba(0, 0, 0, 0.15)",duration:.2,ease:"power2.out"})}})}),e.addEventListener("blur",()=>{i.to(e,{x:0,boxShadow:"none",duration:.3,ease:"power2.in"})})});const O=document.getElementById("inscription-nom"),F=document.getElementById("inscription-prenoms"),C=document.createElement("ul"),A=document.createElement("ul");C.className="suggestions-list",A.className="suggestions-list",O.parentNode.appendChild(C),F.parentNode.appendChild(A);let z={etudiants:[]};fetch("/etudiants.json").then(e=>{if(!e.ok)throw new Error("Erreur lors du chargement du fichier JSON");return e.json()}).then(e=>{z=e}).catch(e=>console.error("Erreur :",e)),document.addEventListener("click",e=>{e.target.closest(".suggestions-list")||e.target.matches("input")||[C,A].forEach(o=>{o.style.display==="block"&&i.to(o,{opacity:0,y:-10,duration:.2,onComplete:()=>o.style.display="none"})})});function B(e,t){return e?z.etudiants.filter(o=>o[t].toLowerCase().includes(e.toLowerCase())):[]}function $(e,t,o){if(t.innerHTML="",o.length===0){t.style.display==="block"&&i.to(t,{opacity:0,y:-10,duration:.2,onComplete:()=>t.style.display="none"});return}o.forEach(r=>{const s=document.createElement("li");s.textContent=r,s.addEventListener("mouseenter",()=>{i.to(s,{backgroundColor:"var(--background-secondary)",duration:.2})}),s.addEventListener("mouseleave",()=>{i.to(s,{backgroundColor:"var(--background-primary)",duration:.2})}),s.addEventListener("click",()=>{e.value=r,i.to(t,{opacity:0,y:-10,duration:.2,onComplete:()=>t.style.display="none"})}),t.appendChild(s)}),t.style.display="block",t.style.opacity="0",i.fromTo(t,{opacity:0,y:-10},{opacity:1,y:0,duration:.3}),i.fromTo(t.children,{opacity:0,y:-10},{opacity:1,y:0,duration:.3,stagger:.05})}function R(e,t){const o=e.parentNode.querySelector(".erreur-message");o&&i.to(o,{opacity:0,y:10,duration:.2,onComplete:()=>o.remove()});const r=document.createElement("span");r.className="erreur-message",r.textContent=t,e.parentNode.appendChild(r),e.classList.add("input-error"),i.timeline().to(e,{x:-10,duration:.1}).to(e,{x:10,duration:.2}).to(e,{x:-5,duration:.15}).to(e,{x:5,duration:.15}).to(e,{x:0,duration:.07,onComplete:()=>{i.to(e,{boxShadow:"0 4px 10px rgba(0, 0, 0, 0.15)",duration:.2,ease:"power2.out"})}}),i.fromTo(r,{opacity:0,y:-10},{opacity:1,y:0,duration:.3}),setTimeout(()=>{i.to(r,{opacity:0,y:10,duration:.3,onComplete:()=>{r.remove(),e.classList.remove("input-error")}})},3e3)}[{input:O,suggestions:C,type:"nom"},{input:F,suggestions:A,type:"prenoms"}].forEach(({input:e,suggestions:t,type:o})=>{e.addEventListener("input",()=>{const r=e.value,s=B(r,o).map(p=>p[o]);$(e,t,s)}),e.addEventListener("focus",()=>{const r=e.value,s=B(r,o).map(p=>p[o]);$(e,t,s)}),e.addEventListener("blur",()=>{setTimeout(()=>{const r=e.value,s=B(r,o);r&&s.length===0?(e.setAttribute("invalid","true"),R(e,"Cette donnée est inexistante")):e.removeAttribute("invalid")},200)})});const Q=document.getElementById("inscription-mdp"),b=document.getElementById("inscription-confirm-mdp");b.addEventListener("blur",()=>{setTimeout(()=>{const e=b.value;Q.value!==e?(b.setAttribute("invalid","true"),R(b,"Les mots de passe ne correspondent pas")):b.removeAttribute("invalid")},200)});const G={icons:{EyeClosed:de,Eye:ue}};document.querySelectorAll(".input-group").forEach(e=>{const t=e.querySelector('input[type="password"], input[type="text"]'),o=e.querySelector("[data-lucide]");if(t&&o){let r=t.type==="text";r?o.setAttribute("data-lucide","eye"):o.setAttribute("data-lucide","eye-closed"),V(G);const s=x=>{i.to(o,{duration:.5,scale:1.1,blur:15,ease:"elastic.out(1, 0.5)",onComplete:()=>{i.to(o,{duration:.3,scale:1,blur:0,ease:"power2.out"})}})},p=x=>{i.to(t,{duration:.3,blur:10,opacity:0,ease:"power2.inOut",onComplete:()=>{t.type=x?"text":"password",o.setAttribute("data-lucide",x?"eye":"eye-closed"),V(G),i.to(t,{duration:.3,blur:0,opacity:1,ease:"power2.out",clearProps:"y"})}})};o.addEventListener("click",()=>{s(),p(!r),r=!r})}});const g=document.querySelector(".upload-zone"),N=document.getElementById("photo-profil"),j=document.querySelector(".preview-container"),W=document.getElementById("preview-image"),Z=document.querySelector(".remove-preview"),D=document.querySelector(".error-message");function _(e){return["image/jpeg","image/png","image/gif"].includes(e.type)}function H(e){if(!_(e)){D.classList.add("active"),N.value="";return}D.classList.remove("active");const t=new FileReader;t.onload=function(o){W.src=o.target.result,j.classList.add("active"),i.from(j,{opacity:0,y:20,duration:.3,ease:"power2.out"})},t.readAsDataURL(e)}["dragenter","dragover","dragleave","drop"].forEach(e=>{g.addEventListener(e,K,!1)});function K(e){e.preventDefault(),e.stopPropagation()}["dragenter","dragover"].forEach(e=>{g.addEventListener(e,ee,!1)}),["dragleave","drop"].forEach(e=>{g.addEventListener(e,te,!1)});function ee(){g.classList.add("drag-over")}function te(){g.classList.remove("drag-over")}g.addEventListener("drop",oe,!1);function oe(e){const o=e.dataTransfer.files[0];H(o)}N.addEventListener("change",function(){this.files&&this.files[0]&&H(this.files[0])}),Z.addEventListener("click",function(){N.value="",j.classList.remove("active"),D.classList.remove("active")})});
