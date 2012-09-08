// JavaScript Document
(function(c){function j(a){return a.replace(/^\s+|\s+$/g,"")}function m(){if(!c.publishableKey)throw"No Publishable API Key: Call Stripe.setPublishableKey to provide your key.";}var d=null,k={};typeof window!=="undefined"&&!window.JSON&&(window.JSON={});(function(){if(typeof JSON.parse!=="function")JSON.parse=function(a,b){function d(a,e){var c,g,f=a[e];if(f&&typeof f==="object")for(c in f)Object.hasOwnProperty.call(f,c)&&(g=d(f,c),g!==void 0?f[c]=g:delete f[c]);return b.call(a,e,f)}var e=RegExp("[\\u0000\\u00ad\\u0600-\\u0604\\u070f\\u17b4\\u17b5\\u200c-\\u200f\\u2028-\\u202f\\u2060-\\u206f\\ufeff\\ufff0-\\uffff]",
"g"),a=String(a);e.lastIndex=0;e.test(a)&&(a=a.replace(e,function(a){return"\\u"+("0000"+a.charCodeAt(0).toString(16)).slice(-4)}));if(/^[\],:{}\s]*$/.test(a.replace(/\\(?:["\\\/bfnrt]|u[0-9a-fA-F]{4})/g,"@").replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g,"]").replace(/(?:^|:|,)(?:\s*\[)+/g,"")))return e=eval("("+a+")"),typeof b==="function"?d({"":e},""):e;throw new SyntaxError("JSON.parse");}})();var u=function(a){function b(){d=null;var a=document.getElementsByTagName("body")[0],
b=document.createElement("iframe");l="stripeFrame"+(new Date).getTime();p=i.apiURL+"/js/v1/apitunnel.html";var h=p+"#"+encodeURIComponent(window.location.href);b.setAttribute("src",h);b.setAttribute("name",l);b.setAttribute("id",l);b.setAttribute("frameborder","0");b.setAttribute("scrolling","no");b.setAttribute("allowtransparency","true");b.setAttribute("width",0);b.setAttribute("height",0);b.setAttribute("style","position:absolute;top:0;left:0;width:0;height:0");h=function(){d=window.frames[l];
c()};b.attachEvent?b.attachEvent("onload",h):b.onload=h;a.appendChild(b)}function c(){if(d){var b=o.length;if(b>0){for(var e=0;e<b;++e){var h=o[e].message,q=h.id;g[q]=o[e].callback;a.postMessage(h,i.apiURL,p,d);f[q]=window.setTimeout(function(a){g[a](504,{error:{message:"There was an error processing your card"}});delete g[a];delete f[a]},6E4,q)}o=[]}}}if(typeof a==="undefined"){var a={},e=function(a){if(typeof a==="undefined"){var a={},b=function(){var a={};a.serialize=function(b,e){var d=[],c;for(c in b)if(b.hasOwnProperty(c)){var t=
e?e+"["+c+"]":c,f=b[c];d.push(typeof f=="object"?a.serialize(f,t):encodeURIComponent(t)+"="+encodeURIComponent(f))}return d.join("&")};a.deserialize=function(a){for(var b={},a=a.split("&"),e=a.length,c=null,d=null,h=0;h<e;++h)if(d=a[h].split("="),d[0]=decodeURIComponent(d[0]),d[1]=decodeURIComponent(d[1]),c=d[0].match(/\[\w+\]/g),c===null)b[d[0]]=d[1];else{var f=d[0].substr(0,d[0].indexOf("["));typeof b[f]==="undefined"&&(b[f]={});for(var n=b[f],s=c.length,g=0;g<s-1;++g)f=c[g].substr(1,c[g].length-
2),typeof n[f]==="undefined"&&(n[f]={}),n=n[f];c=c[s-1];f=c.substr(1,c.length-2);n[f]=d[1]}return b};return a};typeof a!=="undefined"?a=b():exports.createSerializer=b}b={};b.postMessage=function(b,c,d,e){if(typeof window!=="undefined")b=a.serialize(b),typeof window.postMessage==="undefined"?e.location.href=d+"#"+ +new Date+Math.floor(Math.random()*1E3)+"&"+b:e.postMessage(b,c)};b.receiveMessage=function(b,c){if(typeof window!=="undefined")if(window.postMessage)attachedCallback=function(d){if(d.origin!==
c)return false;b(a.deserialize(d.data))},window.addEventListener?window.addEventListener("message",attachedCallback,false):window.attachEvent("onmessage",attachedCallback);else{var d=window.location.hash;setInterval(function(){var c=window.location.hash,e=/^#?\d+&/;if(c!==d&&e.test(c))d=c,window.location.hash="",b(a.deserialize(c.replace(e,"")))},100)}};return b};typeof a!=="undefined"?a=e():exports.createXD=e}var d=null,o=[],k=0,g={},f={},j=false,l,p,i={apiURL:"https://api.stripe.com",onMessage:function(a){var b=
a.id,c=null,c=a.response===null||a.response===""?{error:{message:"There was an error processing your card"}}:JSON.parse(a.response);g[b](parseInt(a.status),c);window.clearTimeout(f[b]);delete g[b];delete f[b]}},m=false,r=function(){b();m||(a.receiveMessage(i.onMessage,i.apiURL),m=true)};i.init=function(){if(!l||!document.getElementById(l))typeof document!=="undefined"&&document&&document.body?r():typeof window!=="undefined"&&window&&!j&&(window.addEventListener?window.addEventListener("load",r,false):
window.attachEvent&&window.attachEvent("onload",r)),j=true};i.callAPI=function(a,b,d,e,f){if(a!=="POST"&&a!=="GET"&&a!=="DELETE")throw"You can only call the API with POST, GET or DELETE";i.init();var g=(k++).toString();o.push({message:{id:g,method:a,url:"/v1/"+b,params:d,key:e},callback:f});c()};return i};typeof k!=="undefined"?k=u():exports.createTransport=u;c.transport=k;c.validateCardNumber=function(a){var a=a.replace(/\s+|-/g,""),b;if(b=a.length>=10)if(b=a.length<=16)if(a.match(/^[0-9]+$/)===
null)b=false;else{var a=a.split("").reverse().join(""),c=0,d;for(b=0;b<a.length;++b)d=parseInt(a.charAt(b),10),b%2!=0&&(d*=2),c+=d<10?d:d-9;b=c!=0&&c%10==0}return b};c.cardType=function(a){if(!d){d={};for(var b=40;b<=49;++b)d[b]="Visa";for(b=50;b<=59;++b)d[b]="MasterCard";d[34]=d[37]="American Express";d[60]=d[62]=d[64]=d[65]="Discover";d[35]="JCB";d[30]=d[36]=d[38]=d[39]="Diners Club"}a=d[a.substr(0,2)];return typeof a==="undefined"?"Unknown":a};c.validateCVC=function(a){a=j(a);return a.match(/^[0-9]+$/)!==
null&&a.length>=3&&a.length<=4};c.validateExpiry=function(a,b){var a=j(a),b=j(b),c=new Date;return a.match(/^[0-9]+$/)!==null&&b.match(/^[0-9]+$/)!==null&&b>c.getFullYear()||b==c.getFullYear()&&a>=c.getMonth()+1};c.createToken=function(a,b,d){typeof b==="function"&&(d=b,b=0);m();var e={expMonth:"exp_month",expYear:"exp_year",addressLine1:"address_line_1",addressLine2:"address_line_2",addressZip:"address_zip",addressState:"address_state",addressCountry:"address_country"};for(convertibleParam in e)e.hasOwnProperty(convertibleParam)&&
a.hasOwnProperty(convertibleParam)&&(a[e[convertibleParam]]=a[convertibleParam],delete a[convertibleParam]);c.transport.callAPI("POST","tokens",{card:a,amount:b},c.publishableKey,d)};c.getToken=function(a,b){m();c.transport.callAPI("GET","tokens/"+a,{},c.publishableKey,b)};c.setPublishableKey=function(a){c.publishableKey=a};k.init()})(typeof exports!=="undefined"&&exports!==null?exports:window.Stripe={});