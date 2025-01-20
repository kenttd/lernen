import{i as ie,n as Re,f as le,e as ae,d as z,q as A,o as w,r as se,b as de,u as Y,m as x,P as U,k as S,T as ke,s as Pe,v as ce,I as fe,l as Ce,a as W,A as Me,N as Ne,w as He,_ as Be,x as xe,y as oe,g as re,j as We}from"./transition-ba5cebc1.js";import{d as J,r as g,p as d,e as R,R as N,Q as T,F as je,N as K,q,J as Ue,P as X,S as Z,W as Ye}from"./app-8e9cf622.js";function qe(e){function t(){document.readyState!=="loading"&&(e(),document.removeEventListener("DOMContentLoaded",t))}typeof window<"u"&&typeof document<"u"&&(document.addEventListener("DOMContentLoaded",t),t())}let F=[];qe(()=>{function e(t){t.target instanceof HTMLElement&&t.target!==document.body&&F[0]!==t.target&&(F.unshift(t.target),F=F.filter(n=>n!=null&&n.isConnected),F.splice(10))}window.addEventListener("click",e,{capture:!0}),window.addEventListener("mousedown",e,{capture:!0}),window.addEventListener("focus",e,{capture:!0}),document.body.addEventListener("click",e,{capture:!0}),document.body.addEventListener("mousedown",e,{capture:!0}),document.body.addEventListener("focus",e,{capture:!0})});function ve(e){if(!e)return new Set;if(typeof e=="function")return new Set(e());let t=new Set;for(let n of e.value){let a=w(n);a instanceof HTMLElement&&t.add(a)}return t}var pe=(e=>(e[e.None=1]="None",e[e.InitialFocus=2]="InitialFocus",e[e.TabLock=4]="TabLock",e[e.FocusLock=8]="FocusLock",e[e.RestoreFocus=16]="RestoreFocus",e[e.All=30]="All",e))(pe||{});let C=Object.assign(J({name:"FocusTrap",props:{as:{type:[Object,String],default:"div"},initialFocus:{type:Object,default:null},features:{type:Number,default:30},containers:{type:[Object,Function],default:g(new Set)}},inheritAttrs:!1,setup(e,{attrs:t,slots:n,expose:a}){let l=g(null);a({el:l,$el:l});let o=d(()=>ie(l)),u=g(!1);R(()=>u.value=!0),N(()=>u.value=!1),Ve({ownerDocument:o},d(()=>u.value&&!!(e.features&16)));let i=_e({ownerDocument:o,container:l,initialFocus:d(()=>e.initialFocus)},d(()=>u.value&&!!(e.features&2)));Ge({ownerDocument:o,container:l,containers:e.containers,previousActiveElement:i},d(()=>u.value&&!!(e.features&8)));let r=Re();function c(p){let v=w(l);v&&(h=>h())(()=>{Y(r.value,{[x.Forwards]:()=>{U(v,S.First,{skipElements:[p.relatedTarget]})},[x.Backwards]:()=>{U(v,S.Last,{skipElements:[p.relatedTarget]})}})})}let m=g(!1);function y(p){p.key==="Tab"&&(m.value=!0,requestAnimationFrame(()=>{m.value=!1}))}function E(p){if(!u.value)return;let v=ve(e.containers);w(l)instanceof HTMLElement&&v.add(w(l));let h=p.relatedTarget;h instanceof HTMLElement&&h.dataset.headlessuiFocusGuard!=="true"&&(me(v,h)||(m.value?U(w(l),Y(r.value,{[x.Forwards]:()=>S.Next,[x.Backwards]:()=>S.Previous})|S.WrapAround,{relativeTo:p.target}):p.target instanceof HTMLElement&&A(p.target)))}return()=>{let p={},v={ref:l,onKeydown:y,onFocusout:E},{features:h,initialFocus:b,containers:k,...O}=e;return T(je,[!!(h&4)&&T(le,{as:"button",type:"button","data-headlessui-focus-guard":!0,onFocus:c,features:ae.Focusable}),z({ourProps:v,theirProps:{...t,...O},slot:p,attrs:t,slots:n,name:"FocusTrap"}),!!(h&4)&&T(le,{as:"button",type:"button","data-headlessui-focus-guard":!0,onFocus:c,features:ae.Focusable})])}}}),{features:pe});function Ie(e){let t=g(F.slice());return q([e],([n],[a])=>{a===!0&&n===!1?se(()=>{t.value.splice(0)}):a===!1&&n===!0&&(t.value=F.slice())},{flush:"post"}),()=>{var n;return(n=t.value.find(a=>a!=null&&a.isConnected))!=null?n:null}}function Ve({ownerDocument:e},t){let n=Ie(t);R(()=>{K(()=>{var a,l;t.value||((a=e.value)==null?void 0:a.activeElement)===((l=e.value)==null?void 0:l.body)&&A(n())},{flush:"post"})}),N(()=>{t.value&&A(n())})}function _e({ownerDocument:e,container:t,initialFocus:n},a){let l=g(null),o=g(!1);return R(()=>o.value=!0),N(()=>o.value=!1),R(()=>{q([t,n,a],(u,i)=>{if(u.every((c,m)=>(i==null?void 0:i[m])===c)||!a.value)return;let r=w(t);r&&se(()=>{var c,m;if(!o.value)return;let y=w(n),E=(c=e.value)==null?void 0:c.activeElement;if(y){if(y===E){l.value=E;return}}else if(r.contains(E)){l.value=E;return}y?A(y):U(r,S.First|S.NoScroll)===ke.Error&&console.warn("There are no focusable elements inside the <FocusTrap />"),l.value=(m=e.value)==null?void 0:m.activeElement})},{immediate:!0,flush:"post"})}),l}function Ge({ownerDocument:e,container:t,containers:n,previousActiveElement:a},l){var o;de((o=e.value)==null?void 0:o.defaultView,"focus",u=>{if(!l.value)return;let i=ve(n);w(t)instanceof HTMLElement&&i.add(w(t));let r=a.value;if(!r)return;let c=u.target;c&&c instanceof HTMLElement?me(i,c)?(a.value=c,A(c)):(u.preventDefault(),u.stopPropagation(),A(r)):A(a.value)},!0)}function me(e,t){for(let n of e)if(n.contains(t))return!0;return!1}function Qe(e){let t=Ue(e.getSnapshot());return N(e.subscribe(()=>{t.value=e.getSnapshot()})),t}function ze(e,t){let n=e(),a=new Set;return{getSnapshot(){return n},subscribe(l){return a.add(l),()=>a.delete(l)},dispatch(l,...o){let u=t[l].call(n,...o);u&&(n=u,a.forEach(i=>i()))}}}function Je(){let e;return{before({doc:t}){var n;let a=t.documentElement;e=((n=t.defaultView)!=null?n:window).innerWidth-a.clientWidth},after({doc:t,d:n}){let a=t.documentElement,l=a.clientWidth-a.offsetWidth,o=e-l;n.style(a,"paddingRight",`${o}px`)}}}function Ke(){return Pe()?{before({doc:e,d:t,meta:n}){function a(l){return n.containers.flatMap(o=>o()).some(o=>o.contains(l))}t.microTask(()=>{var l;if(window.getComputedStyle(e.documentElement).scrollBehavior!=="auto"){let i=ce();i.style(e.documentElement,"scrollBehavior","auto"),t.add(()=>t.microTask(()=>i.dispose()))}let o=(l=window.scrollY)!=null?l:window.pageYOffset,u=null;t.addEventListener(e,"click",i=>{if(i.target instanceof HTMLElement)try{let r=i.target.closest("a");if(!r)return;let{hash:c}=new URL(r.href),m=e.querySelector(c);m&&!a(m)&&(u=m)}catch{}},!0),t.addEventListener(e,"touchstart",i=>{if(i.target instanceof HTMLElement)if(a(i.target)){let r=i.target;for(;r.parentElement&&a(r.parentElement);)r=r.parentElement;t.style(r,"overscrollBehavior","contain")}else t.style(i.target,"touchAction","none")}),t.addEventListener(e,"touchmove",i=>{if(i.target instanceof HTMLElement)if(a(i.target)){let r=i.target;for(;r.parentElement&&r.dataset.headlessuiPortal!==""&&!(r.scrollHeight>r.clientHeight||r.scrollWidth>r.clientWidth);)r=r.parentElement;r.dataset.headlessuiPortal===""&&i.preventDefault()}else i.preventDefault()},{passive:!1}),t.add(()=>{var i;let r=(i=window.scrollY)!=null?i:window.pageYOffset;o!==r&&window.scrollTo(0,o),u&&u.isConnected&&(u.scrollIntoView({block:"nearest"}),u=null)})})}}:{}}function Xe(){return{before({doc:e,d:t}){t.style(e.documentElement,"overflow","hidden")}}}function Ze(e){let t={};for(let n of e)Object.assign(t,n(t));return t}let D=ze(()=>new Map,{PUSH(e,t){var n;let a=(n=this.get(e))!=null?n:{doc:e,count:0,d:ce(),meta:new Set};return a.count++,a.meta.add(t),this.set(e,a),this},POP(e,t){let n=this.get(e);return n&&(n.count--,n.meta.delete(t)),this},SCROLL_PREVENT({doc:e,d:t,meta:n}){let a={doc:e,d:t,meta:Ze(n)},l=[Ke(),Je(),Xe()];l.forEach(({before:o})=>o==null?void 0:o(a)),l.forEach(({after:o})=>o==null?void 0:o(a))},SCROLL_ALLOW({d:e}){e.dispose()},TEARDOWN({doc:e}){this.delete(e)}});D.subscribe(()=>{let e=D.getSnapshot(),t=new Map;for(let[n]of e)t.set(n,n.documentElement.style.overflow);for(let n of e.values()){let a=t.get(n.doc)==="hidden",l=n.count!==0;(l&&!a||!l&&a)&&D.dispatch(n.count>0?"SCROLL_PREVENT":"SCROLL_ALLOW",n),n.count===0&&D.dispatch("TEARDOWN",n)}});function et(e,t,n){let a=Qe(D),l=d(()=>{let o=e.value?a.value.get(e.value):void 0;return o?o.count>0:!1});return q([e,t],([o,u],[i],r)=>{if(!o||!u)return;D.dispatch("PUSH",o,n);let c=!1;r(()=>{c||(D.dispatch("POP",i??o,n),c=!0)})},{immediate:!0}),l}let _=new Map,M=new Map;function ue(e,t=g(!0)){K(n=>{var a;if(!t.value)return;let l=w(e);if(!l)return;n(function(){var u;if(!l)return;let i=(u=M.get(l))!=null?u:1;if(i===1?M.delete(l):M.set(l,i-1),i!==1)return;let r=_.get(l);r&&(r["aria-hidden"]===null?l.removeAttribute("aria-hidden"):l.setAttribute("aria-hidden",r["aria-hidden"]),l.inert=r.inert,_.delete(l))});let o=(a=M.get(l))!=null?a:0;M.set(l,o+1),o===0&&(_.set(l,{"aria-hidden":l.getAttribute("aria-hidden"),inert:l.inert}),l.setAttribute("aria-hidden","true"),l.inert=!0)})}let ge=Symbol("StackContext");var G=(e=>(e[e.Add=0]="Add",e[e.Remove=1]="Remove",e))(G||{});function tt(){return Z(ge,()=>{})}function nt({type:e,enabled:t,element:n,onUpdate:a}){let l=tt();function o(...u){a==null||a(...u),l(...u)}R(()=>{q(t,(u,i)=>{u?o(0,e,n):i===!0&&o(1,e,n)},{immediate:!0,flush:"sync"})}),N(()=>{t.value&&o(1,e,n)}),X(ge,o)}let lt=Symbol("DescriptionContext");function at({slot:e=g({}),name:t="Description",props:n={}}={}){let a=g([]);function l(o){return a.value.push(o),()=>{let u=a.value.indexOf(o);u!==-1&&a.value.splice(u,1)}}return X(lt,{register:l,slot:e,name:t,props:n}),d(()=>a.value.length>0?a.value.join(" "):void 0)}var ot=(e=>(e[e.Open=0]="Open",e[e.Closed=1]="Closed",e))(ot||{});let Q=Symbol("DialogContext");function he(e){let t=Z(Q,null);if(t===null){let n=new Error(`<${e} /> is missing a parent <Dialog /> component.`);throw Error.captureStackTrace&&Error.captureStackTrace(n,he),n}return t}let j="DC8F892D-2EBD-447C-A4C8-A03058436FF4",it=J({name:"Dialog",inheritAttrs:!1,props:{as:{type:[Object,String],default:"div"},static:{type:Boolean,default:!1},unmount:{type:Boolean,default:!0},open:{type:[Boolean,String],default:j},initialFocus:{type:Object,default:null},id:{type:String,default:null},role:{type:String,default:"dialog"}},emits:{close:e=>!0},setup(e,{emit:t,attrs:n,slots:a,expose:l}){var o,u;let i=(o=e.id)!=null?o:`headlessui-dialog-${fe()}`,r=g(!1);R(()=>{r.value=!0});let c=!1,m=d(()=>e.role==="dialog"||e.role==="alertdialog"?e.role:(c||(c=!0,console.warn(`Invalid role [${m}] passed to <Dialog />. Only \`dialog\` and and \`alertdialog\` are supported. Using \`dialog\` instead.`)),"dialog")),y=g(0),E=Ce(),p=d(()=>e.open===j&&E!==null?(E.value&W.Open)===W.Open:e.open),v=g(null),h=d(()=>ie(v));if(l({el:v,$el:v}),!(e.open!==j||E!==null))throw new Error("You forgot to provide an `open` prop to the `Dialog`.");if(typeof p.value!="boolean")throw new Error(`You provided an \`open\` prop to the \`Dialog\`, but the value is not a boolean. Received: ${p.value===j?void 0:e.open}`);let b=d(()=>r.value&&p.value?0:1),k=d(()=>b.value===0),O=d(()=>y.value>1),ee=Z(Q,null)!==null,[we,Ee]=Me(),{resolveContainers:I,mainTreeNodeRef:te,MainTreeNode:ye}=Ne({portals:we,defaultContainers:[d(()=>{var s;return(s=P.panelRef.value)!=null?s:v.value})]}),be=d(()=>O.value?"parent":"leaf"),ne=d(()=>E!==null?(E.value&W.Closing)===W.Closing:!1),Le=d(()=>ee||ne.value?!1:k.value),$e=d(()=>{var s,f,L;return(L=Array.from((f=(s=h.value)==null?void 0:s.querySelectorAll("body > *"))!=null?f:[]).find($=>$.id==="headlessui-portal-root"?!1:$.contains(w(te))&&$ instanceof HTMLElement))!=null?L:null});ue($e,Le);let Te=d(()=>O.value?!0:k.value),Se=d(()=>{var s,f,L;return(L=Array.from((f=(s=h.value)==null?void 0:s.querySelectorAll("[data-headlessui-portal]"))!=null?f:[]).find($=>$.contains(w(te))&&$ instanceof HTMLElement))!=null?L:null});ue(Se,Te),nt({type:"Dialog",enabled:d(()=>b.value===0),element:v,onUpdate:(s,f)=>{if(f==="Dialog")return Y(s,{[G.Add]:()=>y.value+=1,[G.Remove]:()=>y.value-=1})}});let Fe=at({name:"DialogDescription",slot:d(()=>({open:p.value}))}),H=g(null),P={titleId:H,panelRef:g(null),dialogState:b,setTitleId(s){H.value!==s&&(H.value=s)},close(){t("close",!1)}};X(Q,P);let De=d(()=>!(!k.value||O.value));He(I,(s,f)=>{s.preventDefault(),P.close(),Ye(()=>f==null?void 0:f.focus())},De);let Ae=d(()=>!(O.value||b.value!==0));de((u=h.value)==null?void 0:u.defaultView,"keydown",s=>{Ae.value&&(s.defaultPrevented||s.key===We.Escape&&(s.preventDefault(),s.stopPropagation(),P.close()))});let Oe=d(()=>!(ne.value||b.value!==0||ee));return et(h,Oe,s=>{var f;return{containers:[...(f=s.containers)!=null?f:[],I]}}),K(s=>{if(b.value!==0)return;let f=w(v);if(!f)return;let L=new ResizeObserver($=>{for(let V of $){let B=V.target.getBoundingClientRect();B.x===0&&B.y===0&&B.width===0&&B.height===0&&P.close()}});L.observe(f),s(()=>L.disconnect())}),()=>{let{open:s,initialFocus:f,...L}=e,$={...n,ref:v,id:i,role:m.value,"aria-modal":b.value===0?!0:void 0,"aria-labelledby":H.value,"aria-describedby":Fe.value},V={open:b.value===0};return T(oe,{force:!0},()=>[T(Be,()=>T(xe,{target:v.value},()=>T(oe,{force:!1},()=>T(C,{initialFocus:f,containers:I,features:k.value?Y(be.value,{parent:C.features.RestoreFocus,leaf:C.features.All&~C.features.FocusLock}):C.features.None},()=>T(Ee,{},()=>z({ourProps:$,theirProps:{...L,...n},slot:V,attrs:n,slots:a,visible:b.value===0,features:re.RenderStrategy|re.Static,name:"Dialog"})))))),T(ye)])}}}),st=J({name:"DialogPanel",props:{as:{type:[Object,String],default:"div"},id:{type:String,default:null}},setup(e,{attrs:t,slots:n,expose:a}){var l;let o=(l=e.id)!=null?l:`headlessui-dialog-panel-${fe()}`,u=he("DialogPanel");a({el:u.panelRef,$el:u.panelRef});function i(r){r.stopPropagation()}return()=>{let{...r}=e,c={id:o,ref:u.panelRef,onClick:i};return z({ourProps:c,theirProps:r,slot:{open:u.dialogState.value===0},attrs:t,slots:n,name:"DialogPanel"})}}});export{st as G,it as Y};
