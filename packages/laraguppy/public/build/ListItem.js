const __vite__fileDeps=["app.js","app.css"],__vite__mapDeps=i=>i.map(i=>__vite__fileDeps[i]);
import{J as z,r,u as G,b as H,j as J,s as I,o as s,c as n,F as u,l as U,d as o,n as v,f as d,G as Z,t as c,i as m,w as _,e as g,p as q,I as K,_ as Q,R as S,M as W,N as X,g as Y}from"./app.js";const k=l=>(W("data-v-aa06b0b2"),l=l(),X(),l),x=["id"],tt=["src","alt"],et={class:"at-userbar_title"},at={class:"at-userbar_right"},st={key:0,class:"at-msgload"},nt=k(()=>o("i",{class:"at-spinericon"},null,-1)),ot=[nt],it=["onClick"],lt=k(()=>o("i",{class:"laraguppy-plus"},null,-1)),ct={class:"at-infotolltip"},dt={key:1,class:"at-btn-blocked"},rt={class:"at-infotolltip"},pt=k(()=>o("i",{class:"laraguppy-block"},null,-1)),ut={key:0,class:"laraguppy-check"},vt={key:1,class:"laraguppy-plus"},_t=["onClick"],bt=["onClick"],ht={__name:"ListItem",props:["tabRecord","tab"],emits:["scrollList"],setup(l,{emit:$}){const C=$,L=K(()=>Q(()=>import("./app.js").then(e=>e.bZ),__vite__mapDeps([0,1]))),p=r(!1);r(!1);const b=r("");r("");const h=r(!0),y=G(),R=H(),{toggleModal:T}=R,{emit:M}=Y(),w=r(!1),A=J(),{updateStatus:B,updateTabList:ft}=y,{tabRecord:mt,tab:E}=l,{loadingStatus:j}=I(y),{settings:f}=I(A),N=async(e,a)=>{if(a=="declined"?a="invited":a=a||"invited",["invited","declined"].includes(a)){b.value=e,p.value=!0;let t={userId:e,friendStatus:a},i=await S.updateRecord("friends/update",t);if(p.value=!1,(i==null?void 0:i.type)==="success"){let P={tab:E,userId:e,status:i.data.statusText};B(P)}w.value=!1}},V=e=>{switch(e){case"invited":return"at-idle-btn at-sendbtn";case"declined":return"at-btn-resend";case"invite_blocked":return"at-user-blocked";default:return"at-invitebtn"}},O=((e,a)=>{let t;return(...i)=>{clearTimeout(t),t=setTimeout(()=>{e(...i)},a)}})(({target:{clientHeight:e,scrollTop:a,scrollHeight:t}})=>{a+e+5>=t&&C("scrollList","isScrolling")},250),D=e=>{T("respond",!0),M("respondInvite",e)},F=async e=>{await S.postRecord(`start-chat/${e.userId}`)};return(e,a)=>l.tabRecord.length?(s(),n("ul",{key:0,onScroll:a[1]||(a[1]=_(t=>d(O)(t),["prevent"]))},[(s(!0),n(u,null,U(l.tabRecord,t=>(s(),n("li",{key:t.user_id,id:`contact_${t.userId}`,class:"at-userbar"},[o("figure",{class:v(["at-userbar_profile",{"at-shimmer":h.value}])},[o("span",{class:v(["at-userstatus",t.isOnline?"online":"offline"])},null,2),o("img",{onLoad:a[0]||(a[0]=()=>h.value=!1),class:v({"at-none":h.value}),src:t.photo?t.photo:d(f).defaultAvatar?d(f).defaultAvatar:d(Z),alt:t.name},null,42,tt)],2),o("div",et,[o("h3",null,c(t.name),1)]),o("div",at,[p.value&&b.value==t.userId?(s(),n("span",st,ot)):m("",!0),l.tab=="contact_list"?(s(),n(u,{key:1},[d(f).enableChatInvitation?(s(),n("a",{key:0,onClick:_(i=>N(t.userId,t.friendStatus),["prevent"]),href:"javascript:void(0);",class:v(["at-btn-sm",[V(t.friendStatus),{"at-idle-btn":b.value==t.userId&&p.value}]])},[t.friendStatus=="declined"?(s(),n(u,{key:0},[lt,g(" "+c(e.$t(`chatapp.${t.friendStatus}`)),1),o("span",ct,[o("em",null,c(e.$t("chatapp.declined_info")),1)])],64)):t.friendStatus=="invite_blocked"?(s(),n("strong",dt,[o("span",rt,[pt,o("em",null,c(e.$t("chatapp.invite_blocked_desc")),1)]),g(" "+c(e.$t("chatapp.invite_blocked")),1)])):(s(),n(u,{key:2},[g(c(t.friendStatus?e.$t(`chatapp.${t.friendStatus}`):e.$t("chatapp.invite"))+" ",1),t.friendStatus=="invited"?(s(),n("i",ut)):(s(),n("i",vt))],64))],10,it)):(s(),n("a",{key:1,href:"javascript:void(0);",onClick:_(i=>F(t),["prevent"]),class:"at-invitebtn at-btn-sm"},c(e.$t("chatapp.start_chat")),9,_t))],64)):(s(),n("a",{key:2,href:"javascript:void(0);",onClick:_(i=>D(t),["prevent"]),class:"at-btn-respond at-bgsuccess"},c(e.$t("chatapp.respond")),9,bt))])],8,x))),128)),d(j)({tab:"contact_list",loadingType:"isScrolling"})?(s(),q(d(L),{key:0,type:"innerLoading"})):m("",!0)],32)):m("",!0)}},yt=z(ht,[["__scopeId","data-v-aa06b0b2"]]);export{yt as default};
