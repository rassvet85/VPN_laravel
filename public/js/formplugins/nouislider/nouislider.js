!function(t){"function"==typeof define&&define.amd?define([],t):"object"==typeof exports?module.exports=t():window.noUiSlider=t()}(function(){"use strict";var ut="14.5.0";function ct(t){t.parentElement.removeChild(t)}function a(t){return null!=t}function pt(t){t.preventDefault()}function o(t){return"number"==typeof t&&!isNaN(t)&&isFinite(t)}function ft(t,e,r){0<r&&(mt(t,e),setTimeout(function(){gt(t,e)},r))}function dt(t){return Math.max(Math.min(t,100),0)}function ht(t){return Array.isArray(t)?t:[t]}function e(t){var e=(t=String(t)).split(".");return 1<e.length?e[1].length:0}function mt(t,e){t.classList&&!/\s/.test(e)?t.classList.add(e):t.className+=" "+e}function gt(t,e){t.classList&&!/\s/.test(e)?t.classList.remove(e):t.className=t.className.replace(new RegExp("(^|\\b)"+e.split(" ").join("|")+"(\\b|$)","gi")," ")}function vt(t){var e=void 0!==window.pageXOffset,r="CSS1Compat"===(t.compatMode||"");return{x:e?window.pageXOffset:r?t.documentElement.scrollLeft:t.body.scrollLeft,y:e?window.pageYOffset:r?t.documentElement.scrollTop:t.body.scrollTop}}function p(t,e){return 100/(e-t)}function f(t,e,r){return 100*e/(t[r+1]-t[r])}function c(t,e){for(var r=1;t>=e[r];)r+=1;return r}function r(t,e,r){if(r>=t.slice(-1)[0])return 100;var n,i,o=c(r,t),s=t[o-1],a=t[o],l=e[o-1],u=e[o];return l+(i=r,f(n=[s,a],n[0]<0?i+Math.abs(n[0]):i-n[0],0)/p(l,u))}function n(t,e,r,n){if(100===n)return n;var i,o,s=c(n,t),a=t[s-1],l=t[s];return r?(l-a)/2<n-a?l:a:e[s-1]?t[s-1]+(i=n-t[s-1],o=e[s-1],Math.round(i/o)*o):n}function d(t,e,r){var n;if("number"==typeof e&&(e=[e]),!Array.isArray(e))throw new Error("noUiSlider ("+ut+"): 'range' contains invalid value.");if(!o(n="min"===t?0:"max"===t?100:parseFloat(t))||!o(e[0]))throw new Error("noUiSlider ("+ut+"): 'range' value isn't numeric.");r.xPct.push(n),r.xVal.push(e[0]),n?r.xSteps.push(!isNaN(e[1])&&e[1]):isNaN(e[1])||(r.xSteps[0]=e[1]),r.xHighestCompleteStep.push(0)}function i(t,e,r){var n;this.xPct=[],this.xVal=[],this.xSteps=[r||!1],this.xNumSteps=[!1],this.xHighestCompleteStep=[],this.snap=e;var i,o,s,a,l,u,c=[];for(n in t)t.hasOwnProperty(n)&&c.push([t[n],n]);for(c.length&&"object"==typeof c[0][0]?c.sort(function(t,e){return t[0][0]-e[0][0]}):c.sort(function(t,e){return t[0]-e[0]}),n=0;n<c.length;n++)d(c[n][1],c[n][0],this);for(this.xNumSteps=this.xSteps.slice(0),n=0;n<this.xNumSteps.length;n++)i=n,o=this.xNumSteps[n],s=this,a=void 0,o&&(s.xVal[i]!==s.xVal[i+1]?(s.xSteps[i]=f([s.xVal[i],s.xVal[i+1]],o,0)/p(s.xPct[i],s.xPct[i+1]),a=(s.xVal[i+1]-s.xVal[i])/s.xNumSteps[i],l=Math.ceil(Number(a.toFixed(3))-1),u=s.xVal[i]+s.xNumSteps[i]*l,s.xHighestCompleteStep[i]=u):s.xSteps[i]=s.xHighestCompleteStep[i]=s.xVal[i])}i.prototype.getDistance=function(t){for(var e=[],r=0;r<this.xNumSteps.length-1;r++){var n=this.xNumSteps[r];if(n&&t/n%1!=0)throw new Error("noUiSlider ("+ut+"): 'limit', 'margin' and 'padding' of "+this.xPct[r]+"% range must be divisible by step.");e[r]=f(this.xVal,t,r)}return e},i.prototype.getAbsoluteDistance=function(t,e,r){var n=0;if(t<this.xPct[this.xPct.length-1])for(;t>this.xPct[n+1];)n++;else t===this.xPct[this.xPct.length-1]&&(n=this.xPct.length-2);r||t!==this.xPct[n+1]||n++;for(var i=1,o=e[n],s=0,a=0,l=0,u=0,c=r?(t-this.xPct[n])/(this.xPct[n+1]-this.xPct[n]):(this.xPct[n+1]-t)/(this.xPct[n+1]-this.xPct[n]);0<o;)s=this.xPct[n+1+u]-this.xPct[n+u],100<e[n+u]*i+100-100*c?(a=s*c,i=(o-100*c)/e[n+u],c=1):(a=e[n+u]*s/100*i,i=0),r?(l-=a,1<=this.xPct.length+u&&u--):(l+=a,1<=this.xPct.length-u&&u++),o=e[n+u]*i;return t+l},i.prototype.toStepping=function(t){return t=r(this.xVal,this.xPct,t)},i.prototype.fromStepping=function(t){return function(t,e,r){if(100<=r)return t.slice(-1)[0];var n,i=c(r,e),o=t[i-1],s=t[i],a=e[i-1],l=e[i];return(r-a)*p(a,l)*((n=[o,s])[1]-n[0])/100+n[0]}(this.xVal,this.xPct,t)},i.prototype.getStep=function(t){return t=n(this.xPct,this.xSteps,this.snap,t)},i.prototype.getDefaultStep=function(t,e,r){var n=c(t,this.xPct);return(100===t||e&&t===this.xPct[n-1])&&(n=Math.max(n-1,1)),(this.xVal[n]-this.xVal[n-1])/r},i.prototype.getNearbySteps=function(t){var e=c(t,this.xPct);return{stepBefore:{startValue:this.xVal[e-2],step:this.xNumSteps[e-2],highestStep:this.xHighestCompleteStep[e-2]},thisStep:{startValue:this.xVal[e-1],step:this.xNumSteps[e-1],highestStep:this.xHighestCompleteStep[e-1]},stepAfter:{startValue:this.xVal[e],step:this.xNumSteps[e],highestStep:this.xHighestCompleteStep[e]}}},i.prototype.countStepDecimals=function(){var t=this.xNumSteps.map(e);return Math.max.apply(null,t)},i.prototype.convert=function(t){return this.getStep(this.toStepping(t))};var l={to:function(t){return void 0!==t&&t.toFixed(2)},from:Number},u={target:"target",base:"base",origin:"origin",handle:"handle",handleLower:"handle-lower",handleUpper:"handle-upper",touchArea:"touch-area",horizontal:"horizontal",vertical:"vertical",background:"background",connect:"connect",connects:"connects",ltr:"ltr",rtl:"rtl",textDirectionLtr:"txt-dir-ltr",textDirectionRtl:"txt-dir-rtl",draggable:"draggable",drag:"state-drag",tap:"state-tap",active:"active",tooltip:"tooltip",pips:"pips",pipsHorizontal:"pips-horizontal",pipsVertical:"pips-vertical",marker:"marker",markerHorizontal:"marker-horizontal",markerVertical:"marker-vertical",markerNormal:"marker-normal",markerLarge:"marker-large",markerSub:"marker-sub",value:"value",valueHorizontal:"value-horizontal",valueVertical:"value-vertical",valueNormal:"value-normal",valueLarge:"value-large",valueSub:"value-sub"};function s(t){if("object"==typeof(e=t)&&"function"==typeof e.to&&"function"==typeof e.from)return 1;var e;throw new Error("noUiSlider ("+ut+"): 'format' requires 'to' and 'from' methods.")}function h(t,e){if(!o(e))throw new Error("noUiSlider ("+ut+"): 'step' is not numeric.");t.singleStep=e}function m(t,e){if("object"!=typeof e||Array.isArray(e))throw new Error("noUiSlider ("+ut+"): 'range' is not an object.");if(void 0===e.min||void 0===e.max)throw new Error("noUiSlider ("+ut+"): Missing 'min' or 'max' in 'range'.");if(e.min===e.max)throw new Error("noUiSlider ("+ut+"): 'range' 'min' and 'max' cannot be equal.");t.spectrum=new i(e,t.snap,t.singleStep)}function g(t,e){if(e=ht(e),!Array.isArray(e)||!e.length)throw new Error("noUiSlider ("+ut+"): 'start' option is incorrect.");t.handles=e.length,t.start=e}function v(t,e){if("boolean"!=typeof(t.snap=e))throw new Error("noUiSlider ("+ut+"): 'snap' option must be a boolean.")}function x(t,e){if("boolean"!=typeof(t.animate=e))throw new Error("noUiSlider ("+ut+"): 'animate' option must be a boolean.")}function b(t,e){if("number"!=typeof(t.animationDuration=e))throw new Error("noUiSlider ("+ut+"): 'animationDuration' option must be a number.")}function S(t,e){var r,n=[!1];if("lower"===e?e=[!0,!1]:"upper"===e&&(e=[!1,!0]),!0===e||!1===e){for(r=1;r<t.handles;r++)n.push(e);n.push(!1)}else{if(!Array.isArray(e)||!e.length||e.length!==t.handles+1)throw new Error("noUiSlider ("+ut+"): 'connect' option doesn't match handle count.");n=e}t.connect=n}function w(t,e){switch(e){case"horizontal":t.ort=0;break;case"vertical":t.ort=1;break;default:throw new Error("noUiSlider ("+ut+"): 'orientation' option is invalid.")}}function y(t,e){if(!o(e))throw new Error("noUiSlider ("+ut+"): 'margin' option must be numeric.");0!==e&&(t.margin=t.spectrum.getDistance(e))}function E(t,e){if(!o(e))throw new Error("noUiSlider ("+ut+"): 'limit' option must be numeric.");if(t.limit=t.spectrum.getDistance(e),!t.limit||t.handles<2)throw new Error("noUiSlider ("+ut+"): 'limit' option is only supported on linear sliders with 2 or more handles.")}function C(t,e){var r;if(!o(e)&&!Array.isArray(e))throw new Error("noUiSlider ("+ut+"): 'padding' option must be numeric or array of exactly 2 numbers.");if(Array.isArray(e)&&2!==e.length&&!o(e[0])&&!o(e[1]))throw new Error("noUiSlider ("+ut+"): 'padding' option must be numeric or array of exactly 2 numbers.");if(0!==e){for(Array.isArray(e)||(e=[e,e]),t.padding=[t.spectrum.getDistance(e[0]),t.spectrum.getDistance(e[1])],r=0;r<t.spectrum.xNumSteps.length-1;r++)if(t.padding[0][r]<0||t.padding[1][r]<0)throw new Error("noUiSlider ("+ut+"): 'padding' option must be a positive number(s).");var n=e[0]+e[1],i=t.spectrum.xVal[0];if(1<n/(t.spectrum.xVal[t.spectrum.xVal.length-1]-i))throw new Error("noUiSlider ("+ut+"): 'padding' option must not exceed 100% of the range.")}}function N(t,e){switch(e){case"ltr":t.dir=0;break;case"rtl":t.dir=1;break;default:throw new Error("noUiSlider ("+ut+"): 'direction' option was not recognized.")}}function P(t,e){if("string"!=typeof e)throw new Error("noUiSlider ("+ut+"): 'behaviour' must be a string containing options.");var r=0<=e.indexOf("tap"),n=0<=e.indexOf("drag"),i=0<=e.indexOf("fixed"),o=0<=e.indexOf("snap"),s=0<=e.indexOf("hover"),a=0<=e.indexOf("unconstrained");if(i){if(2!==t.handles)throw new Error("noUiSlider ("+ut+"): 'fixed' behaviour must be used with 2 handles");y(t,t.start[1]-t.start[0])}if(a&&(t.margin||t.limit))throw new Error("noUiSlider ("+ut+"): 'unconstrained' behaviour cannot be used with margin or limit");t.events={tap:r||o,drag:n,fixed:i,snap:o,hover:s,unconstrained:a}}function U(t,e){if(!1!==e)if(!0===e){t.tooltips=[];for(var r=0;r<t.handles;r++)t.tooltips.push(!0)}else{if(t.tooltips=ht(e),t.tooltips.length!==t.handles)throw new Error("noUiSlider ("+ut+"): must pass a formatter for all handles.");t.tooltips.forEach(function(t){if("boolean"!=typeof t&&("object"!=typeof t||"function"!=typeof t.to))throw new Error("noUiSlider ("+ut+"): 'tooltips' must be passed a formatter or 'false'.")})}}function A(t,e){s(t.ariaFormat=e)}function V(t,e){s(t.format=e)}function k(t,e){if("boolean"!=typeof(t.keyboardSupport=e))throw new Error("noUiSlider ("+ut+"): 'keyboardSupport' option must be a boolean.")}function D(t,e){t.documentElement=e}function M(t,e){if("string"!=typeof e&&!1!==e)throw new Error("noUiSlider ("+ut+"): 'cssPrefix' must be a string or `false`.");t.cssPrefix=e}function O(t,e){if("object"!=typeof e)throw new Error("noUiSlider ("+ut+"): 'cssClasses' must be an object.");if("string"==typeof t.cssPrefix)for(var r in t.cssClasses={},e)e.hasOwnProperty(r)&&(t.cssClasses[r]=t.cssPrefix+e[r]);else t.cssClasses=e}function xt(e){var r={margin:0,limit:0,padding:0,animate:!0,animationDuration:300,ariaFormat:l,format:l},n={step:{r:!1,t:h},start:{r:!0,t:g},connect:{r:!0,t:S},direction:{r:!0,t:N},snap:{r:!1,t:v},animate:{r:!1,t:x},animationDuration:{r:!1,t:b},range:{r:!0,t:m},orientation:{r:!1,t:w},margin:{r:!1,t:y},limit:{r:!1,t:E},padding:{r:!1,t:C},behaviour:{r:!0,t:P},ariaFormat:{r:!1,t:A},format:{r:!1,t:V},tooltips:{r:!1,t:U},keyboardSupport:{r:!0,t:k},documentElement:{r:!1,t:D},cssPrefix:{r:!0,t:M},cssClasses:{r:!0,t:O}},i={connect:!1,direction:"ltr",behaviour:"tap",orientation:"horizontal",keyboardSupport:!0,cssPrefix:"noUi-",cssClasses:u};e.format&&!e.ariaFormat&&(e.ariaFormat=e.format),Object.keys(n).forEach(function(t){if(!a(e[t])&&void 0===i[t]){if(n[t].r)throw new Error("noUiSlider ("+ut+"): '"+t+"' is required.");return!0}n[t].t(r,a(e[t])?e[t]:i[t])}),r.pips=e.pips;var t=document.createElement("div"),o=void 0!==t.style.msTransform,s=void 0!==t.style.transform;r.transformRule=s?"transform":o?"msTransform":"webkitTransform";return r.style=[["left","top"],["right","bottom"]][r.dir][r.ort],r}function L(t,g,o){var l,u,s,a,i,c,e,p,f=window.navigator.pointerEnabled?{start:"pointerdown",move:"pointermove",end:"pointerup"}:window.navigator.msPointerEnabled?{start:"MSPointerDown",move:"MSPointerMove",end:"MSPointerUp"}:{start:"mousedown touchstart",move:"mousemove touchmove",end:"mouseup touchend"},d=window.CSS&&CSS.supports&&CSS.supports("touch-action","none")&&function(){var t=!1;try{var e=Object.defineProperty({},"passive",{get:function(){t=!0}});window.addEventListener("test",null,e)}catch(t){}return t}(),h=t,y=g.spectrum,v=[],x=[],m=[],b=0,S={},w=t.ownerDocument,E=g.documentElement||w.documentElement,C=w.body,N=-1,P=0,U=1,A=2,V="rtl"===w.dir||1===g.ort?0:100;function k(t,e){var r=w.createElement("div");return e&&mt(r,e),t.appendChild(r),r}function D(t,e){var r=k(t,g.cssClasses.origin),n=k(r,g.cssClasses.handle);return k(n,g.cssClasses.touchArea),n.setAttribute("data-handle",e),g.keyboardSupport&&(n.setAttribute("tabindex","0"),n.addEventListener("keydown",function(t){return function(t,e){if(O()||L(e))return!1;var r=["Left","Right"],n=["Down","Up"],i=["PageDown","PageUp"],o=["Home","End"];g.dir&&!g.ort?r.reverse():g.ort&&!g.dir&&(n.reverse(),i.reverse());var s,a=t.key.replace("Arrow",""),l=a===i[0],u=a===i[1],c=a===n[0]||a===r[0]||l,p=a===n[1]||a===r[1]||u,f=a===o[0],d=a===o[1];if(!(c||p||f||d))return!0;if(t.preventDefault(),p||c){var h=c?0:1,m=lt(e)[h];if(null===m)return!1;!1===m&&(m=y.getDefaultStep(x[e],c,10)),(u||l)&&(m*=5),m=Math.max(m,1e-7),m*=c?-1:1,s=v[e]+m}else s=d?g.spectrum.xVal[g.spectrum.xVal.length-1]:g.spectrum.xVal[0];return nt(e,y.toStepping(s),!0,!0),K("slide",e),K("update",e),K("change",e),K("set",e),!1}(t,e)})),n.setAttribute("role","slider"),n.setAttribute("aria-orientation",g.ort?"vertical":"horizontal"),0===e?mt(n,g.cssClasses.handleLower):e===g.handles-1&&mt(n,g.cssClasses.handleUpper),r}function M(t,e){return!!e&&k(t,g.cssClasses.connect)}function r(t,e){return!!g.tooltips[e]&&k(t.firstChild,g.cssClasses.tooltip)}function O(){return h.hasAttribute("disabled")}function L(t){return u[t].hasAttribute("disabled")}function z(){i&&(J("update.tooltips"),i.forEach(function(t){t&&ct(t)}),i=null)}function H(){z(),i=u.map(r),G("update.tooltips",function(t,e,r){var n;i[e]&&(n=t[e],!0!==g.tooltips[e]&&(n=g.tooltips[e].to(r[e])),i[e].innerHTML=n)})}function j(m,g,v){var x={},t=y.xVal[0],e=y.xVal[y.xVal.length-1],b=!1,S=!1,w=0;return(v=v.slice().sort(function(t,e){return t-e}).filter(function(t){return!this[t]&&(this[t]=!0)},{}))[0]!==t&&(v.unshift(t),b=!0),v[v.length-1]!==e&&(v.push(e),S=!0),v.forEach(function(t,e){var r,n,i,o,s,a,l,u,c,p,f=t,d=v[e+1],h="steps"===g;if(h&&(r=y.xNumSteps[e]),r=r||d-f,!1!==f&&void 0!==d)for(r=Math.max(r,1e-7),n=f;n<=d;n=+(n+r).toFixed(7)){for(u=(s=(o=y.toStepping(n))-w)/m,p=s/(c=Math.round(u)),i=1;i<=c;i+=1)x[(a=w+i*p).toFixed(5)]=[y.fromStepping(a),0];l=-1<v.indexOf(n)?U:h?A:P,!e&&b&&n!==d&&(l=0),n===d&&S||(x[o.toFixed(5)]=[n,l]),w=o}}),x}function F(o,s,a){var l=w.createElement("div"),i=[];i[P]=g.cssClasses.valueNormal,i[U]=g.cssClasses.valueLarge,i[A]=g.cssClasses.valueSub;var u=[];u[P]=g.cssClasses.markerNormal,u[U]=g.cssClasses.markerLarge,u[A]=g.cssClasses.markerSub;var c=[g.cssClasses.valueHorizontal,g.cssClasses.valueVertical],p=[g.cssClasses.markerHorizontal,g.cssClasses.markerVertical];function f(t,e){var r=e===g.cssClasses.value,n=r?i:u;return e+" "+(r?c:p)[g.ort]+" "+n[t]}return mt(l,g.cssClasses.pips),mt(l,0===g.ort?g.cssClasses.pipsHorizontal:g.cssClasses.pipsVertical),Object.keys(o).forEach(function(t){var e,r,n,i;r=o[e=t][0],n=o[t][1],(n=s?s(r,n):n)!==N&&((i=k(l,!1)).className=f(n,g.cssClasses.marker),i.style[g.style]=e+"%",P<n&&((i=k(l,!1)).className=f(n,g.cssClasses.value),i.setAttribute("data-value",r),i.style[g.style]=e+"%",i.innerHTML=a.to(r)))}),l}function R(){a&&(ct(a),a=null)}function T(t){R();var e=t.mode,r=t.density||1,n=t.filter||!1,i=j(r,e,function(t,e,r){if("range"===t||"steps"===t)return y.xVal;if("count"===t){if(e<2)throw new Error("noUiSlider ("+ut+"): 'values' (>= 2) required for mode 'count'.");var n=e-1,i=100/n;for(e=[];n--;)e[n]=n*i;e.push(100),t="positions"}return"positions"===t?e.map(function(t){return y.fromStepping(r?y.getStep(t):t)}):"values"===t?r?e.map(function(t){return y.fromStepping(y.getStep(y.toStepping(t)))}):e:void 0}(e,t.values||!1,t.stepped||!1)),o=t.format||{to:Math.round};return a=h.appendChild(F(i,n,o))}function B(){var t=l.getBoundingClientRect(),e="offset"+["Width","Height"][g.ort];return 0===g.ort?t.width||l[e]:t.height||l[e]}function q(n,i,o,s){function e(t){return!!(t=function(t,e,r){var n,i,o=0===t.type.indexOf("touch"),s=0===t.type.indexOf("mouse"),a=0===t.type.indexOf("pointer");0===t.type.indexOf("MSPointer")&&(a=!0);if(o){var l=function(t){return t.target===r||r.contains(t.target)||t.target.shadowRoot&&t.target.shadowRoot.contains(r)};if("touchstart"===t.type){var u=Array.prototype.filter.call(t.touches,l);if(1<u.length)return!1;n=u[0].pageX,i=u[0].pageY}else{var c=Array.prototype.find.call(t.changedTouches,l);if(!c)return!1;n=c.pageX,i=c.pageY}}e=e||vt(w),(s||a)&&(n=t.clientX+e.x,i=t.clientY+e.y);return t.pageOffset=e,t.points=[n,i],t.cursor=s||a,t}(t,s.pageOffset,s.target||i))&&(!(O()&&!s.doNotReject)&&(e=h,r=g.cssClasses.tap,!((e.classList?e.classList.contains(r):new RegExp("\\b"+r+"\\b").test(e.className))&&!s.doNotReject)&&(!(n===f.start&&void 0!==t.buttons&&1<t.buttons)&&((!s.hover||!t.buttons)&&(d||t.preventDefault(),t.calcPoint=t.points[g.ort],void o(t,s))))));var e,r}var r=[];return n.split(" ").forEach(function(t){i.addEventListener(t,e,!!d&&{passive:!0}),r.push([t,e])}),r}function X(t){var e,r,n,i,o,s,a=dt(a=100*(t-(e=l,r=g.ort,n=e.getBoundingClientRect(),i=e.ownerDocument,o=i.documentElement,s=vt(i),/webkit.*Chrome.*Mobile/i.test(navigator.userAgent)&&(s.x=0),r?n.top+s.y-o.clientTop:n.left+s.x-o.clientLeft))/B());return g.dir?100-a:a}function Y(t,e){"mouseout"===t.type&&"HTML"===t.target.nodeName&&null===t.relatedTarget&&I(t,e)}function _(t,e){if(-1===navigator.appVersion.indexOf("MSIE 9")&&0===t.buttons&&0!==e.buttonsProperty)return I(t,e);var r=(g.dir?-1:1)*(t.calcPoint-e.startCalcPoint);tt(0<r,100*r/e.baseSize,e.locations,e.handleNumbers)}function I(t,e){e.handle&&(gt(e.handle,g.cssClasses.active),--b),e.listeners.forEach(function(t){E.removeEventListener(t[0],t[1])}),0===b&&(gt(h,g.cssClasses.drag),rt(),t.cursor&&(C.style.cursor="",C.removeEventListener("selectstart",pt))),e.handleNumbers.forEach(function(t){K("change",t),K("set",t),K("end",t)})}function W(t,e){if(e.handleNumbers.some(L))return!1;var r;1===e.handleNumbers.length&&(r=u[e.handleNumbers[0]].children[0],b+=1,mt(r,g.cssClasses.active)),t.stopPropagation();var n=[],i=q(f.move,E,_,{target:t.target,handle:r,listeners:n,startCalcPoint:t.calcPoint,baseSize:B(),pageOffset:t.pageOffset,handleNumbers:e.handleNumbers,buttonsProperty:t.buttons,locations:x.slice()}),o=q(f.end,E,I,{target:t.target,handle:r,listeners:n,doNotReject:!0,handleNumbers:e.handleNumbers}),s=q("mouseout",E,Y,{target:t.target,handle:r,listeners:n,doNotReject:!0,handleNumbers:e.handleNumbers});n.push.apply(n,i.concat(o,s)),t.cursor&&(C.style.cursor=getComputedStyle(t.target).cursor,1<u.length&&mt(h,g.cssClasses.drag),C.addEventListener("selectstart",pt,!1)),e.handleNumbers.forEach(function(t){K("start",t)})}function n(t){t.stopPropagation();var i,o,s,e=X(t.calcPoint),r=(i=e,s=!(o=100),u.forEach(function(t,e){var r,n;L(e)||(r=x[e],((n=Math.abs(r-i))<o||n<=o&&r<i||100===n&&100===o)&&(s=e,o=n))}),s);if(!1===r)return!1;g.events.snap||ft(h,g.cssClasses.tap,g.animationDuration),nt(r,e,!0,!0),rt(),K("slide",r,!0),K("update",r,!0),K("change",r,!0),K("set",r,!0),g.events.snap&&W(t,{handleNumbers:[r]})}function $(t){var e=X(t.calcPoint),r=y.getStep(e),n=y.fromStepping(r);Object.keys(S).forEach(function(t){"hover"===t.split(".")[0]&&S[t].forEach(function(t){t.call(c,n)})})}function G(t,e){S[t]=S[t]||[],S[t].push(e),"update"===t.split(".")[0]&&u.forEach(function(t,e){K("update",e)})}function J(t){var n=t&&t.split(".")[0],i=n&&t.substring(n.length);Object.keys(S).forEach(function(t){var e=t.split(".")[0],r=t.substring(e.length);n&&n!==e||i&&i!==r||delete S[t]})}function K(r,n,i){Object.keys(S).forEach(function(t){var e=t.split(".")[0];r===e&&S[t].forEach(function(t){t.call(c,v.map(g.format.to),n,v.slice(),i||!1,x.slice(),c)})})}function Q(t,e,r,n,i,o){var s;return 1<u.length&&!g.events.unconstrained&&(n&&0<e&&(s=y.getAbsoluteDistance(t[e-1],g.margin,0),r=Math.max(r,s)),i&&e<u.length-1&&(s=y.getAbsoluteDistance(t[e+1],g.margin,1),r=Math.min(r,s))),1<u.length&&g.limit&&(n&&0<e&&(s=y.getAbsoluteDistance(t[e-1],g.limit,0),r=Math.min(r,s)),i&&e<u.length-1&&(s=y.getAbsoluteDistance(t[e+1],g.limit,1),r=Math.max(r,s))),g.padding&&(0===e&&(s=y.getAbsoluteDistance(0,g.padding[0],0),r=Math.max(r,s)),e===u.length-1&&(s=y.getAbsoluteDistance(100,g.padding[1],1),r=Math.min(r,s))),!((r=dt(r=y.getStep(r)))===t[e]&&!o)&&r}function Z(t,e){var r=g.ort;return(r?e:t)+", "+(r?t:e)}function tt(t,n,r,e){var i=r.slice(),o=[!t,t],s=[t,!t];e=e.slice(),t&&e.reverse(),1<e.length?e.forEach(function(t,e){var r=Q(i,t,i[t]+n,o[e],s[e],!1);!1===r?n=0:(n=r-i[t],i[t]=r)}):o=s=[!0];var a=!1;e.forEach(function(t,e){a=nt(t,r[t]+n,o[e],s[e])||a}),a&&e.forEach(function(t){K("update",t),K("slide",t)})}function et(t,e){return g.dir?100-t-e:t}function rt(){m.forEach(function(t){var e=50<x[t]?-1:1,r=3+(u.length+e*t);u[t].style.zIndex=r})}function nt(t,e,r,n){return!1!==(e=Q(x,t,e,r,n,!1))&&(function(t,e){x[t]=e,v[t]=y.fromStepping(e);var r="translate("+Z(10*(et(e,0)-V)+"%","0")+")";u[t].style[g.transformRule]=r,it(t),it(t+1)}(t,e),!0)}function it(t){var e,r,n,i,o;s[t]&&(r=100,(e=0)!==t&&(e=x[t-1]),t!==s.length-1&&(r=x[t]),i="translate("+Z(et(e,n=r-e)+"%","0")+")",o="scale("+Z(n/100,"1")+")",s[t].style[g.transformRule]=i+" "+o)}function ot(t,e){return null===t||!1===t||void 0===t?x[e]:("number"==typeof t&&(t=String(t)),t=g.format.from(t),!1===(t=y.toStepping(t))||isNaN(t)?x[e]:t)}function st(t,e){var r=ht(t),n=void 0===x[0];e=void 0===e||!!e,g.animate&&!n&&ft(h,g.cssClasses.tap,g.animationDuration),m.forEach(function(t){nt(t,ot(r[t],t),!0,!1)});for(var i=1===m.length?0:1;i<m.length;++i)m.forEach(function(t){nt(t,x[t],!0,!0)});rt(),m.forEach(function(t){K("update",t),null!==r[t]&&e&&K("set",t)})}function at(){var t=v.map(g.format.to);return 1===t.length?t[0]:t}function lt(t){var e=x[t],r=y.getNearbySteps(e),n=v[t],i=r.thisStep.step,o=null;if(g.snap)return[n-r.stepBefore.startValue||null,r.stepAfter.startValue-n||null];!1!==i&&n+i>r.stepAfter.startValue&&(i=r.stepAfter.startValue-n),o=n>r.thisStep.startValue?r.thisStep.step:!1!==r.stepBefore.step&&n-r.stepBefore.highestStep,100===e?i=null:0===e&&(o=null);var s=y.countStepDecimals();return null!==i&&!1!==i&&(i=Number(i.toFixed(s))),null!==o&&!1!==o&&(o=Number(o.toFixed(s))),[o,i]}return mt(e=h,g.cssClasses.target),0===g.dir?mt(e,g.cssClasses.ltr):mt(e,g.cssClasses.rtl),0===g.ort?mt(e,g.cssClasses.horizontal):mt(e,g.cssClasses.vertical),mt(e,"rtl"===getComputedStyle(e).direction?g.cssClasses.textDirectionRtl:g.cssClasses.textDirectionLtr),l=k(e,g.cssClasses.base),function(t,e){var r=k(e,g.cssClasses.connects);u=[],(s=[]).push(M(r,t[0]));for(var n=0;n<g.handles;n++)u.push(D(e,n)),m[n]=n,s.push(M(r,t[n+1]))}(g.connect,l),(p=g.events).fixed||u.forEach(function(t,e){q(f.start,t.children[0],W,{handleNumbers:[e]})}),p.tap&&q(f.start,l,n,{}),p.hover&&q(f.move,l,$,{hover:!0}),p.drag&&s.forEach(function(t,e){var r,n,i;!1!==t&&0!==e&&e!==s.length-1&&(r=u[e-1],n=u[e],i=[t],mt(t,g.cssClasses.draggable),p.fixed&&(i.push(r.children[0]),i.push(n.children[0])),i.forEach(function(t){q(f.start,t,W,{handles:[r,n],handleNumbers:[e-1,e]})}))}),st(g.start),g.pips&&T(g.pips),g.tooltips&&H(),G("update",function(t,e,s,r,a){m.forEach(function(t){var e=u[t],r=Q(x,t,0,!0,!0,!0),n=Q(x,t,100,!0,!0,!0),i=a[t],o=g.ariaFormat.to(s[t]),r=y.fromStepping(r).toFixed(1),n=y.fromStepping(n).toFixed(1),i=y.fromStepping(i).toFixed(1);e.children[0].setAttribute("aria-valuemin",r),e.children[0].setAttribute("aria-valuemax",n),e.children[0].setAttribute("aria-valuenow",i),e.children[0].setAttribute("aria-valuetext",o)})}),c={destroy:function(){for(var t in g.cssClasses)g.cssClasses.hasOwnProperty(t)&&gt(h,g.cssClasses[t]);for(;h.firstChild;)h.removeChild(h.firstChild);delete h.noUiSlider},steps:function(){return m.map(lt)},on:G,off:J,get:at,set:st,setHandle:function(t,e,r){if(!(0<=(t=Number(t))&&t<m.length))throw new Error("noUiSlider ("+ut+"): invalid handle number, got: "+t);nt(t,ot(e,t),!0,!0),K("update",t),r&&K("set",t)},reset:function(t){st(g.start,t)},__moveHandles:function(t,e,r){tt(t,e,x,r)},options:o,updateOptions:function(e,t){var r=at(),n=["margin","limit","padding","range","animate","snap","step","format","pips","tooltips"];n.forEach(function(t){void 0!==e[t]&&(o[t]=e[t])});var i=xt(o);n.forEach(function(t){void 0!==e[t]&&(g[t]=i[t])}),y=i.spectrum,g.margin=i.margin,g.limit=i.limit,g.padding=i.padding,g.pips?T(g.pips):R(),(g.tooltips?H:z)(),x=[],st(e.start||r,t)},target:h,removePips:R,removeTooltips:z,getTooltips:function(){return i},getOrigins:function(){return u},pips:T}}return{__spectrum:i,version:ut,cssClasses:u,create:function(t,e){if(!t||!t.nodeName)throw new Error("noUiSlider ("+ut+"): create requires a single element, got: "+t);if(t.noUiSlider)throw new Error("noUiSlider ("+ut+"): Slider was already initialized.");var r=L(t,xt(e),e);return t.noUiSlider=r}}});