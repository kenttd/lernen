const __vite__fileDeps=["ContactList.js","app.js","app.css","empty-users.js","RequestList.js"],__vite__mapDeps=i=>i.map(i=>__vite__fileDeps[i]);
import{J as q,u as w,s as y,r as l,K as E,E as I,I as u,_ as p,o as n,c as d,d as e,w as _,n as v,e as h,t as i,f,i as T,p as m,A as k,L as B,M as S,N as A}from"./app.js";const r=s=>(S("data-v-8df70a44"),s=s(),A(),s),V={id:"userlist",class:"at-userlist_tab active"},x={class:"at-userchat_tab"},D=r(()=>e("i",{class:"laraguppy-user"},null,-1)),M=r(()=>e("svg",{width:"14",height:"5",viewBox:"0 0 14 5",fill:"none"},[e("path",{d:"M4.5423 4.17642C5.73661 5.27452 8.26339 5.27453 9.4577 4.17642L14 0H0L4.5423 4.17642Z",fill:"#070611"})],-1)),N=r(()=>e("i",{class:"laraguppy-user-request"},null,-1)),$=r(()=>e("svg",{width:"14",height:"5",viewBox:"0 0 14 5",fill:"none"},[e("path",{d:"M4.5423 4.17642C5.73661 5.27452 8.26339 5.27453 9.4577 4.17642L14 0H0L4.5423 4.17642Z",fill:"#070611"})],-1)),P={key:0,class:"at-notify"},R={__name:"UserList",setup(s){const C=w(),{unreadCounts:c}=y(C),t=l("contacts"),L=l("");E(a=>{L.value=a});const b=I(()=>t.value?{contacts:u(()=>p(()=>import("./ContactList.js"),__vite__mapDeps([0,1,2,3]))),requests:u(()=>p(()=>import("./RequestList.js"),__vite__mapDeps([4,1,2,3])))}[t.value]:"");return(a,o)=>(n(),d("div",V,[e("div",x,[e("a",{href:"javascript:void(0);",onClick:o[0]||(o[0]=_(g=>t.value="contacts",["prevent"])),class:v({"at-tabactive":t.value=="contacts"})},[D,e("span",null,[h(i(a.$t("chatapp.contacts")),1),M])],2),e("a",{href:"javascript:void(0);",onClick:o[1]||(o[1]=_(g=>t.value="requests",["prevent"])),class:v({"at-tabactive":t.value=="requests"})},[N,e("span",null,[h(i(a.$t("chatapp.requests")),1),$]),f(c).request_list?(n(),d("em",P,i(f(c).request_list),1)):T("",!0)],2)]),(n(),m(B,null,[(n(),m(k(b.value),{id:t.value},null,8,["id"]))],1024))]))}},H=q(R,[["__scopeId","data-v-8df70a44"]]);export{H as default};
