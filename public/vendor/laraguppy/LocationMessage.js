const __vite__fileDeps=["MessageActions.js","app.js","app.css","QuoteMessageList.js","v3.js","GeoMap.js","GeoMap.css","AudioPlayer.js","AudioPlayer.css","video-js.js","video-js.css"],__vite__mapDeps=i=>i.map(i=>__vite__fileDeps[i]);
import{J as k,o as a,c as o,f as s,t as v,i as n,p as c,z as l,y as m,I as p,_ as g,M as D,N as E,d as I}from"./app.js";import{_ as u}from"./GeoMap.js";const h=t=>(D("data-v-668f1473"),t=t(),E(),t),L={class:"at-message at-locationmap"},M={key:0},S={key:1,class:"at-msgload"},V=h(()=>I("i",{class:"at-spinericon"},null,-1)),w=[V],x={key:4,class:"at-msgload"},A=h(()=>I("i",{class:"at-spinericon"},null,-1)),B=[A],N={__name:"LocationMessage",props:["message"],setup(t){const d=p(()=>g(()=>import("./MessageActions.js"),__vite__mapDeps([0,1,2]))),f=p(()=>g(()=>import("./QuoteMessageList.js"),__vite__mapDeps([3,4,1,2,5,6,7,8,9,10]))),y=t,{message:e}=y;return(C,P)=>{var i,_,r;return a(),o("div",L,[!((i=s(e))!=null&&i.isSender)&&((_=s(e))==null?void 0:_.threadType)=="group"?(a(),o("h5",M,v((r=s(e))==null?void 0:r.name),1)):n("",!0),s(e).parent&&!s(e).messageId?(a(),o("span",S,w)):n("",!0),s(e).parent?(a(),c(s(f),{key:2,message:s(e).parent,msgId:s(e).messageId,threadId:s(e).threadId},{message_actions:l(()=>[s(e).messageId?(a(),c(s(d),{key:0,isDownload:!1,message:s(e)},null,8,["message"])):n("",!0)]),default:l(()=>[m(u,{location:s(e).location},null,8,["location"])]),_:1},8,["message","msgId","threadId"])):n("",!0),m(u,{location:s(e).location,msgId:s(e).messageId},null,8,["location","msgId"]),s(e).messageId?(a(),c(s(d),{key:3,isDownload:!1,message:s(e)},null,8,["message"])):(a(),o("span",x,B))])}}},R=k(N,[["__scopeId","data-v-668f1473"]]);export{R as default};
