"use strict";var UWTabs=function(){var t=document.querySelectorAll("#tabs-tour-container");if(1<t.length)for(var e=0;e<t.length;e++)t[e].id="tabs-tour-container-"+e;var n=document.querySelectorAll(".tab-tour ul.nav-tabs");if(1<n.length)for(var r=Array.prototype.slice.call(n),a=r.map(function(t){return t.id}),l=r.filter(function(e){return 1<a.filter(function(t){return t===e.id}).length})[0].id,o=0;o<n.length;o++)if(l===n[o].id){n[o].id=l+"-"+o;for(var i=n[o].getElementsByClassName("nav-link"),c=0;c<i.length;c++)i[c].id="title-"+l+"-"+o+"-"+c,i[c].href="#content-"+l+"-"+o+"-"+c,i[c].setAttribute("aria-controls","content-"+l+"-"+o+"-"+c);n[o].parentElement.getElementsByClassName("tab-content")[0].id="tab-content-"+l+"-"+o;for(var u=n[o].parentElement.getElementsByClassName("tab-pane"),s=0;s<u.length;s++)u[s].id="content-"+l+"-"+o+"-"+s,u[s].setAttribute("aria-labelledby","title-"+l+"-"+o+"-"+s)}document.querySelectorAll(".tab-tour").forEach(function(t){var s=Array.prototype.slice.call(t.querySelectorAll(".nav-link"));t.addEventListener("keydown",function(t){var e=t.target,n=t.which,r=35,a=36,l=39,o=40;if(o===n||l===n||37===n||38===n){t.preventDefault();var i=s.indexOf(e),c=l===n||o===n?1:-1,u=s.length;s[(i+u+c)%u].focus()}else switch(n){case r:t.preventDefault(),s[s.length-1].focus();break;case a:t.preventDefault(),s[0].focus()}})})};new UWTabs;