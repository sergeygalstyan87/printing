var FilePondPluginImageEditor=function(){"use strict";const y=e=>e instanceof File,J=e=>/^image/.test(e.type),K=e=>typeof e=="string";function re(e,o){o.split(";").forEach(f=>{const[I,s]=f.split(":");if(!I.length||!s)return;const[c,h]=s.split("!important");e.style.setProperty(I,c,K(h)?"important":void 0)})}const x=(e,o,f=[])=>{const I=document.createElement(e),s=Object.getOwnPropertyDescriptors(I.__proto__);for(const c in o)c==="style"?re(I,o[c]):s[c]&&s[c].set||/textContent|innerHTML/.test(c)||typeof o[c]=="function"?I[c]=o[c]:I.setAttribute(c,o[c]);return f.forEach(c=>I.appendChild(c)),I};let V=null;const P=()=>(V===null&&(V=typeof window<"u"&&typeof window.document<"u"),V),ae=P()&&!!Node.prototype.replaceChildren?(e,o)=>e.replaceChildren(o):(e,o)=>{for(;e.lastChild;)e.removeChild(e.lastChild);o!==void 0&&e.append(o)},v=P()&&x("div",{class:"PinturaMeasure",style:"position:absolute;left:0;top:0;width:99999px;height:0;pointer-events:none;contain:strict;margin:0;padding:0;"});let Y;const se=e=>(ae(v,e),v.parentNode||document.body.append(v),clearTimeout(Y),Y=setTimeout(()=>{v.remove()},500),e);let j=null;const Ee=()=>(j===null&&(j=P()&&/^((?!chrome|android).)*(safari|iphone|ipad)/i.test(navigator.userAgent)),j),de=e=>new Promise((o,f)=>{let I=!1;!e.parentNode&&Ee()&&(I=!0,e.style.cssText="position:absolute;visibility:hidden;pointer-events:none;left:0;top:0;width:0;height:0;",se(e));const s=()=>{const h=e.naturalWidth,z=e.naturalHeight;h&&z&&(I&&e.remove(),clearInterval(c),o({width:h,height:z}))};e.onerror=h=>{clearInterval(c),f(h)};const c=setInterval(s,1);s()}),ce=e=>new Promise((o,f)=>{const I=()=>{o({width:e.videoWidth,height:e.videoHeight})};if(e.readyState>=1)return I();e.onloadedmetadata=I,e.onerror=()=>f(e.error)}),le=e=>new Promise(o=>{const f=K(e)?e:URL.createObjectURL(e),I=()=>{const c=new Image;c.src=f,o(c)};if(e instanceof Blob&&J(e))return I();const s=document.createElement("video");s.preload="metadata",s.onloadedmetadata=()=>o(s),s.onerror=I,s.src=f}),Ie=e=>e.nodeName==="VIDEO",_e=async e=>{let o;e.src?o=e:o=await le(e);let f;try{f=Ie(o)?await ce(o):await de(o)}finally{y(e)&&URL.revokeObjectURL(o.src)}return f},X=e=>e instanceof Blob&&!(e instanceof File),Z=(...e)=>{},q=e=>{e.width=1,e.height=1;const o=e.getContext("2d");o&&o.clearRect(0,0,1,1)};let b=null;const ue=()=>{if(b===null)if("WebGL2RenderingContext"in window){let e;try{e=x("canvas"),b=!!e.getContext("webgl2")}catch{b=!1}e&&q(e),e=void 0}else b=!1;return b},Te=(e,o)=>ue()?e.getContext("webgl2",o):e.getContext("webgl",o)||e.getContext("experimental-webgl",o);let H=null;const fe=()=>{if(H===null){let e=x("canvas");H=!!Te(e),q(e),e=void 0}return H},ge=()=>Object.prototype.toString.call(window.operamini)==="[object OperaMini]",me=()=>"Promise"in window,pe=()=>"URL"in window&&"createObjectURL"in window.URL,Oe=()=>"visibilityState"in document,Re=()=>"performance"in window,he=()=>"File"in window;let k=null;const ee=()=>(k===null&&(k=P()&&!ge()&&Oe()&&me()&&he()&&pe()&&Re()),k),te=e=>{const{addFilter:o,utils:f,views:I}=e,{Type:s,createRoute:c}=f,{fileActionButton:h}=I,Q=(({parallel:i=1,autoShift:n=!0})=>{const r=[];let t=0;const E=()=>{if(!r.length)return g.oncomplete();t++,r.shift()(()=>{t--,t<i&&_()})},_=()=>{for(let u=0;u<i-t;u++)E()},g={queue:u=>{r.push(u),n&&_()},runJobs:_,oncomplete:()=>{}};return g})({parallel:1}),N=i=>i===null?{}:i;o("SHOULD_REMOVE_ON_REVERT",(i,{item:n,query:r})=>new Promise(t=>{const{file:E}=n,_=r("GET_ALLOW_IMAGE_EDITOR")&&r("GET_IMAGE_EDITOR_ALLOW_EDIT")&&r("GET_IMAGE_EDITOR_SUPPORT_EDIT")&&r("GET_IMAGE_EDITOR_SUPPORT_IMAGE")(E);t(!_)})),o("DID_LOAD_ITEM",(i,{query:n,dispatch:r})=>new Promise((t,E)=>{if(i.origin>1){t(i);return}const{file:_}=i;if(!n("GET_ALLOW_IMAGE_EDITOR")||!n("GET_IMAGE_EDITOR_INSTANT_EDIT")||!n("GET_IMAGE_EDITOR_SUPPORT_IMAGE")(_))return t(i);const g=()=>{if(!U.length)return;const{item:p,resolve:m,reject:O}=U[0];r("EDIT_ITEM",{id:p.id,handleEditorResponse:u(p,m,O)})},u=(p,m,O)=>G=>{U.shift(),G?m(p):O(p),r("KICK"),g()};Ge({item:i,resolve:t,reject:E}),U.length===1&&g()})),o("DID_CREATE_ITEM",(i,{query:n,dispatch:r})=>{i.getMetadata("color")&&i.setMetadata("colors",i.getMetadata("color")),i.extend("edit",()=>{r("EDIT_ITEM",{id:i.id})})});const U=[],Ge=i=>(U.push(i),i),Ae=i=>{const{imageProcessor:n,imageReader:r,imageWriter:t}=N(i("GET_IMAGE_EDITOR"));return i("GET_IMAGE_EDITOR_WRITE_IMAGE")&&i("GET_IMAGE_EDITOR_SUPPORT_WRITE_IMAGE")&&n&&r&&t},Me=(i,n)=>{const r=i("GET_FILE_POSTER_HEIGHT"),t=i("GET_FILE_POSTER_MAX_HEIGHT");return r?(n.width=r*2,n.height=r*2):t&&(n.width=t*2,n.height=t*2),n},ie=(i,n,r=()=>{})=>{if(!n)return;if(!i("GET_FILE_POSTER_FILTER_ITEM")(n))return r();const{imageProcessor:t,imageReader:E,imageWriter:_,editorOptions:g,legacyDataToImageState:u,imageState:p}=N(i("GET_IMAGE_EDITOR"));if(!t)return;const[m,O]=E,[G=Z,L]=_,D=n.file,A=n.getMetadata("imageState"),w=Me(i,{width:512,height:512}),C={...g,imageReader:m(O),imageWriter:G({...L||{},canvasMemoryLimit:w.width*w.height*2,preprocessImageState:(M,S,ne,B)=>!A&&u?{...M,...u(void 0,B.size,{...n.getMetadata()})}:M}),imageState:{...p,...A}};Q.queue(M=>{t(D,C).then(({dest:S})=>{n.setMetadata("poster",URL.createObjectURL(S),!0),M(),r()})})};o("CREATE_VIEW",i=>{const{is:n,view:r,query:t}=i;if(!t("GET_ALLOW_IMAGE_EDITOR")||!t("GET_IMAGE_EDITOR_SUPPORT_WRITE_IMAGE"))return;const E=t("GET_ALLOW_FILE_POSTER");if(!(n("file-info")&&!E||n("file")&&E))return;const{createEditor:g,imageReader:u,imageWriter:p,editorOptions:m,legacyDataToImageState:O,imageState:G}=N(t("GET_IMAGE_EDITOR"));if(!u||!p||!m||!m.locale)return;delete m.imageReader,delete m.imageWriter;const[L,D]=u,A=a=>{const{id:d}=a;return t("GET_ITEM",d)},w=a=>{if(!t("GET_ALLOW_FILE_POSTER"))return!1;const d=A(a);return d?t("GET_FILE_POSTER_FILTER_ITEM")(d)?!!d.getMetadata("poster"):!1:void 0},C=({root:a,props:d,action:l})=>{const{handleEditorResponse:T}=l,R=A(d),oe=y(R.file)||X(R.file),Pe=oe?R.file:R.source,F=g({...m,imageReader:L(D),src:Pe});F.on("load",({size:$})=>{let W=R.getMetadata("imageState");!W&&O&&(W=O(F,$,R.getMetadata())),F.imageState={...G,...W}}),F.on("process",({src:$,imageState:W})=>{oe||R.setFile($),R.setMetadata("imageState",W),T&&T(!0)}),F.on("close",()=>{T&&T(!1)})},M=({root:a,props:d})=>{const{id:l}=d,T=t("GET_ITEM",l);if(!T)return;const R=T.file;t("GET_IMAGE_EDITOR_SUPPORT_IMAGE")(R)&&(t("GET_ALLOW_FILE_POSTER")&&!T.getMetadata("poster")&&a.dispatch("REQUEST_CREATE_IMAGE_POSTER",{id:l}),!(!t("GET_IMAGE_EDITOR_ALLOW_EDIT")||!t("GET_IMAGE_EDITOR_SUPPORT_EDIT"))&&S(a,d))},S=(a,d)=>{if(a.ref.handleEdit||(a.ref.handleEdit=l=>{l.stopPropagation(),a.dispatch("EDIT_ITEM",{id:d.id})}),w(d)){a.ref.editButton&&a.ref.editButton.parentNode&&a.ref.editButton.parentNode.removeChild(a.ref.editButton);const l=r.createChildView(h,{label:"edit",icon:t("GET_IMAGE_EDITOR_ICON_EDIT"),opacity:0});l.element.classList.add("filepond--action-edit-item"),l.element.dataset.align=t("GET_STYLE_IMAGE_EDITOR_BUTTON_EDIT_ITEM_POSITION"),l.on("click",a.ref.handleEdit),a.ref.buttonEditItem=r.appendChildView(l)}else{a.ref.buttonEditItem&&a.removeChildView(a.ref.buttonEditItem);const l=r.element.querySelector(".filepond--file-info-main"),T=document.createElement("button");T.className="filepond--action-edit-item-alt",T.type="button",T.innerHTML=t("GET_IMAGE_EDITOR_ICON_EDIT")+"<span>edit</span>",T.addEventListener("click",a.ref.handleEdit),l.appendChild(T),a.ref.editButton=T}},ne=({root:a,props:d,action:l})=>{if(/imageState/.test(l.change.key)&&t("GET_ALLOW_FILE_POSTER"))return a.dispatch("REQUEST_CREATE_IMAGE_POSTER",{id:d.id});/poster/.test(l.change.key)&&(!t("GET_IMAGE_EDITOR_ALLOW_EDIT")||!t("GET_IMAGE_EDITOR_SUPPORT_EDIT")||S(a,d))};r.registerDestroyer(({root:a})=>{a.ref.buttonEditItem&&a.ref.buttonEditItem.off("click",a.ref.handleEdit),a.ref.editButton&&a.ref.editButton.removeEventListener("click",a.ref.handleEdit)});const B={EDIT_ITEM:C,DID_LOAD_ITEM:M,DID_UPDATE_ITEM_METADATA:ne,DID_REMOVE_ITEM:({props:a})=>{const{id:d}=a,l=t("GET_ITEM",d);if(!l)return;const T=l.getMetadata("poster");T&&URL.revokeObjectURL(T)},REQUEST_CREATE_IMAGE_POSTER:({root:a,props:d})=>ie(a.query,A(d)),DID_FILE_POSTER_LOAD:void 0};if(E){const a=({root:d})=>{d.ref.buttonEditItem&&(d.ref.buttonEditItem.opacity=1)};B.DID_FILE_POSTER_LOAD=a}r.registerWriter(c(B))}),o("SHOULD_PREPARE_OUTPUT",(i,{query:n,change:r,item:t})=>new Promise(E=>{if(!n("GET_IMAGE_EDITOR_SUPPORT_IMAGE")(t.file)||r&&!/imageState/.test(r.key))return E(!1);E(!n("IS_ASYNC"))}));const Se=(i,n,r)=>new Promise(t=>{if(!Ae(i)||r.archived||!y(n)&&!X(n)||!i("GET_IMAGE_EDITOR_SUPPORT_IMAGE")(n))return t(!1);_e(n).then(()=>{const E=i("GET_IMAGE_TRANSFORM_IMAGE_FILTER");if(E){const _=E(n);if(typeof _=="boolean")return t(_);if(typeof _.then=="function")return _.then(t)}t(!0)}).catch(()=>{const E=i("GET_IMAGE_EDITOR_SUPPORT_IMAGE_FORMAT");if(E&&E(n)){t(!0);return}t(!1)})});return o("PREPARE_OUTPUT",(i,{query:n,item:r})=>{const t=E=>new Promise((_,g)=>{const u=()=>{Q.queue(p=>{const m=r.getMetadata("imageState"),{imageProcessor:O,imageReader:G,imageWriter:L,editorOptions:D,imageState:A}=N(n("GET_IMAGE_EDITOR"));if(!O||!G||!L||!D)return;const[w,C]=G,[M=Z,S]=L;O(E,{...D,imageReader:w(C),imageWriter:M(S),imageState:{...A,...m}}).then(_).catch(g).finally(p)})};n("GET_ALLOW_FILE_POSTER")&&!r.getMetadata("poster")?ie(n,r,u):u()});return new Promise(E=>{Se(n,i,r).then(_=>{if(!_)return E(i);t(i).then(g=>{const u=n("GET_IMAGE_EDITOR_AFTER_WRITE_IMAGE");if(u)return Promise.resolve(u(g)).then(E);E(g.dest)})})})}),{options:{allowImageEditor:[!0,s.BOOLEAN],imageEditorInstantEdit:[!1,s.BOOLEAN],imageEditorAllowEdit:[!0,s.BOOLEAN],imageEditorSupportEdit:[P()&&ee()&&fe(),s.BOOLEAN],imageEditorSupportImage:[J,s.FUNCTION],imageEditorSupportImageFormat:[null,s.FUNCTION],imageEditorSupportWriteImage:[ee(),s.BOOLEAN],imageEditorWriteImage:[!0,s.BOOLEAN],imageEditorBeforeOpenImage:[void 0,s.FUNCTION],imageEditorAfterWriteImage:[void 0,s.FUNCTION],imageEditor:[null,s.OBJECT],imageEditorIconEdit:['<svg width="26" height="26" viewBox="0 0 26 26" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M8.5 17h1.586l7-7L15.5 8.414l-7 7V17zm-1.707-2.707l8-8a1 1 0 0 1 1.414 0l3 3a1 1 0 0 1 0 1.414l-8 8A1 1 0 0 1 10.5 19h-3a1 1 0 0 1-1-1v-3a1 1 0 0 1 .293-.707z" fill="currentColor" fill-rule="nonzero"/></svg>',s.STRING],styleImageEditorButtonEditItemPosition:["bottom center",s.STRING]}}};return P()&&document.dispatchEvent(new CustomEvent("FilePond:pluginloaded",{detail:te})),te}();
