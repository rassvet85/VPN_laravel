var commands,modal;voice_command_auto=!(voice_command=!0),voice_command_lang="en-US",voice_localStorage=!1,voice_command&&(commands={"show dashboard":function(){$('nav a[href="ajax/dashboard.html"]').trigger("click")},"show inbox":function(){$('nav a[href="ajax/inbox.html"]').trigger("click")},"show graphs":function(){$('nav a[href="ajax/flot.html"]').trigger("click")},"show flotchart":function(){$('nav a[href="ajax/flot.html"]').trigger("click")},"show morris chart":function(){$('nav a[href="ajax/morris.html"]').trigger("click")},"show inline chart":function(){$('nav a[href="ajax/inline-charts.html"]').trigger("click")},"show dygraphs":function(){$('nav a[href="ajax/dygraphs.html"]').trigger("click")},"show tables":function(){$('nav a[href="ajax/table.html"]').trigger("click")},"show data table":function(){$('nav a[href="ajax/datatables.html"]').trigger("click")},"show jquery grid":function(){$('nav a[href="ajax/jqgrid.html"]').trigger("click")},"show form":function(){$('nav a[href="ajax/form-elements.html"]').trigger("click")},"show form layouts":function(){$('nav a[href="ajax/form-templates.html"]').trigger("click")},"show form validation":function(){$('nav a[href="ajax/validation.html"]').trigger("click")},"show form elements":function(){$('nav a[href="ajax/bootstrap-forms.html"]').trigger("click")},"show form plugins":function(){$('nav a[href="ajax/plugins.html"]').trigger("click")},"show form wizards":function(){$('nav a[href="ajax/wizards.html"]').trigger("click")},"show bootstrap editor":function(){$('nav a[href="ajax/other-editors.html"]').trigger("click")},"show dropzone":function(){$('nav a[href="ajax/dropzone.html"]').trigger("click")},"show image cropping":function(){$('nav a[href="ajax/image-editor.html"]').trigger("click")},"show general elements":function(){$('nav a[href="ajax/general-elements.html"]').trigger("click")},"show buttons":function(){$('nav a[href="ajax/buttons.html"]').trigger("click")},"show fontawesome":function(){$('nav a[href="ajax/fa.html"]').trigger("click")},"show glyph icons":function(){$('nav a[href="ajax/glyph.html"]').trigger("click")},"show flags":function(){$('nav a[href="ajax/flags.html"]').trigger("click")},"show grid":function(){$('nav a[href="ajax/grid.html"]').trigger("click")},"show tree view":function(){$('nav a[href="ajax/treeview.html"]').trigger("click")},"show nestable lists":function(){$('nav a[href="ajax/nestable-list.html"]').trigger("click")},"show jquery U I":function(){$('nav a[href="ajax/jqui.html"]').trigger("click")},"show typography":function(){$('nav a[href="ajax/typography.html"]').trigger("click")},"show calendar":function(){$('nav a[href="ajax/calendar.html"]').trigger("click")},"show widgets":function(){$('nav a[href="ajax/widgets.html"]').trigger("click")},"show gallery":function(){$('nav a[href="ajax/gallery.html"]').trigger("click")},"show maps":function(){$('nav a[href="ajax/gmap-xml.html"]').trigger("click")},"show pricing tables":function(){$('nav a[href="ajax/pricing-table.html"]').trigger("click")},"show invoice":function(){$('nav a[href="ajax/invoice.html"]').trigger("click")},"show search":function(){$('nav a[href="ajax/search.html"]').trigger("click")},"go back":function(){history.back(1)},"scroll up":function(){$("html, body").animate({scrollTop:0},100)},"scroll down":function(){$("html, body").animate({scrollTop:$(document).height()},100)},"hide navigation":function(){$.root_.hasClass("container")&&!$.root_.hasClass("menu-on-top")?$("span.minifyme").trigger("click"):$("#hide-menu > span > a").trigger("click")},"show navigation":function(){$.root_.hasClass("container")&&!$.root_.hasClass("menu-on-top")?$("span.minifyme").trigger("click"):$("#hide-menu > span > a").trigger("click")},mute:function(){$.sound_on=!1,$.smallBox({title:"MUTE",content:"All sounds have been muted!",color:"#a90329",timeout:4e3,icon:"fa fa-volume-off"})},"sound on":function(){$.sound_on=!0,$.speechApp.playConfirmation(),$.smallBox({title:"UNMUTE",content:"All sounds have been turned on!",color:"#40ac2b",sound_file:"voice_alert",timeout:5e3,icon:"fa fa-volume-up"})},stop:function(){smartSpeechRecognition.abort(),$.root_.removeClass("voice-command-active"),$.smallBox({title:"VOICE COMMAND OFF",content:"Your voice commands has been successfully turned off. Click on the <i class='fa fa-microphone fa-lg fa-fw'></i> icon to turn it back on.",color:"#40ac2b",sound_file:"voice_off",timeout:8e3,icon:"fa fa-microphone-slash"}),$("#speech-btn .popover").is(":visible")&&$("#speech-btn .popover").fadeOut(250)},help:function(){$("#voiceModal").removeData("modal").modal({remote:"ajax/modal-content/modal-voicecommand.html",show:!0}),$("#speech-btn .popover").is(":visible")&&$("#speech-btn .popover").fadeOut(250)},"got it":function(){$("#voiceModal").modal("hide")},logout:function(){$.speechApp.stop(),window.location=$("#logout > span > a").attr("href")}}),SpeechRecognition=root.SpeechRecognition||root.webkitSpeechRecognition||root.mozSpeechRecognition||root.msSpeechRecognition||root.oSpeechRecognition,SpeechRecognition&&voice_command?($.root_.on("click",'[data-action="voiceCommand"]',function(e){$.root_.hasClass("voice-command-active")?$.speechApp.stop():($.speechApp.start(),$("#speech-btn .popover").fadeIn(350)),e.preventDefault()}),$(document).mouseup(function(e){$("#speech-btn .popover").is(e.target)||0!==$("#speech-btn .popover").has(e.target).length||$("#speech-btn .popover").fadeOut(250)}),(modal=$('<div class="modal fade" id="voiceModal" tabindex="-1" role="dialog" aria-labelledby="remoteModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"></div></div></div>')).appendTo("body"),debugState&&root.console.log("This browser supports Voice Command"),$.speechApp=function(e){return e.start=function(){smartSpeechRecognition.addCommands(commands),smartSpeechRecognition?(smartSpeechRecognition.start(),$.root_.addClass("voice-command-active"),$.speechApp.playON(),voice_localStorage&&localStorage.setItem("sm-setautovoice","true")):alert("speech plugin not loaded")},e.stop=function(){smartSpeechRecognition&&(smartSpeechRecognition.abort(),$.root_.removeClass("voice-command-active"),$.speechApp.playOFF(),voice_localStorage&&localStorage.setItem("sm-setautovoice","false"),$("#speech-btn .popover").is(":visible")&&$("#speech-btn .popover").fadeOut(250))},e.playON=function(){var e=document.createElement("audio");navigator.userAgent.match("Firefox/")?e.setAttribute("src",$.sound_path+"voice_on.ogg"):e.setAttribute("src",$.sound_path+"voice_on.mp3"),e.addEventListener("load",function(){e.play()},!0),$.sound_on&&(e.pause(),e.play())},e.playOFF=function(){var e=document.createElement("audio");navigator.userAgent.match("Firefox/")?e.setAttribute("src",$.sound_path+"voice_off.ogg"):e.setAttribute("src",$.sound_path+"voice_off.mp3"),$.get(),e.addEventListener("load",function(){e.play()},!0),$.sound_on&&(e.pause(),e.play())},e.playConfirmation=function(){var e=document.createElement("audio");navigator.userAgent.match("Firefox/")?e.setAttribute("src",$.sound_path+"voice_alert.ogg"):e.setAttribute("src",$.sound_path+"voice_alert.mp3"),$.get(),e.addEventListener("load",function(){e.play()},!0),$.sound_on&&(e.pause(),e.play())},e}({})):$("#speech-btn").addClass("display-none"),function(n){"use strict";if(!SpeechRecognition)return root.smartSpeechRecognition=null,n;function s(e){e.forEach(function(e){e.callback.apply(e.context)})}function r(){e()||root.smartSpeechRecognition.init({},!1)}var t,a,l=[],h={start:[],error:[],end:[],result:[],resultMatch:[],resultNoMatch:[],errorNetwork:[],errorPermissionBlocked:[],errorPermissionDenied:[]},i=0,c=/\s*\((.*?)\)\s*/g,g=/(\(\?:[^)]+\))\?/g,m=/(\(\?)?:\w+/g,u=/\*\w+/g,d=/[\-{}\[\]+?.,\\\^$|#]/g,e=function(){return t!==n};root.smartSpeechRecognition={init:function(e,o){o=o===n||!!o,t&&t.abort&&t.abort(),(t=new SpeechRecognition).maxAlternatives=5,t.continuous=!0,t.lang=voice_command_lang||"en-US",t.onstart=function(){s(h.start),debugState&&(root.console.log("%c ✔ SUCCESS: User allowed access the microphone service to start ",debugStyle_success),root.console.log("Language setting is set to: "+t.lang,debugStyle)),$.root_.removeClass("service-not-allowed"),$.root_.addClass("service-allowed")},t.onerror=function(e){switch(s(h.error),e.error){case"network":s(h.errorNetwork);break;case"not-allowed":case"service-not-allowed":a=!1,$.root_.removeClass("service-allowed"),$.root_.addClass("service-not-allowed"),debugState&&root.console.log("%c WARNING: Microphone was not detected (either user denied access or it is not installed properly) ",debugStyle_warning),(new Date).getTime()-i<200?s(h.errorPermissionBlocked):s(h.errorPermissionDenied)}},t.onend=function(){var e;s(h.end),a&&((e=(new Date).getTime()-i)<1e3?setTimeout(root.smartSpeechRecognition.start,1e3-e):root.smartSpeechRecognition.start())},t.onresult=function(e){s(h.result);for(var o,t=e.results[e.resultIndex],a=0;a<t.length;a++){o=t[a].transcript.trim(),debugState&&root.console.log("Speech recognized: %c"+o,debugStyle);for(var n=0,r=l.length;n<r;n++){var i=l[n].command.exec(o);if(i){var c=i.slice(1);debugState&&(root.console.log("command matched: %c"+l[n].originalPhrase,debugStyle),c.length&&root.console.log("with parameters",c)),l[n].callback.apply(this,c),s(h.resultMatch);return["sound on","mute","stop"].indexOf(l[n].originalPhrase)<0&&($.smallBox({title:l[n].originalPhrase,content:"loading...",color:"#333",sound_file:"voice_alert",timeout:2e3}),$("#speech-btn .popover").is(":visible")&&$("#speech-btn .popover").fadeOut(250)),!0}}}return s(h.resultNoMatch),$.smallBox({title:'Error: <strong> " '+o+' " </strong> no match found!',content:"Please speak clearly into the microphone",color:"#a90329",timeout:5e3,icon:"fa fa-microphone"}),$("#speech-btn .popover").is(":visible")&&$("#speech-btn .popover").fadeOut(250),!1},o&&(l=[]),e.length&&this.addCommands(e)},start:function(e){r(),a=(e=e||{}).autoRestart===n||!!e.autoRestart,i=(new Date).getTime(),t.start()},abort:function(){a=!1,e&&t.abort()},debug:function(e){debugState=!(0<arguments.length)||!!e},setLanguage:function(e){r(),t.lang=e},addCommands:function(e){var o,t,a;for(var n in r(),e)if(e.hasOwnProperty(n)){if("function"!=typeof(o=root[e[n]]||e[n]))continue;a=(a=n).replace(d,"\\$&").replace(c,"(?:$1)?").replace(m,function(e,o){return o?e:"([^\\s]+)"}).replace(u,"(.*?)").replace(g,"\\s*$1?\\s*"),t=new RegExp("^"+a+"$","i"),l.push({command:t,callback:o,originalPhrase:n})}debugState&&root.console.log("Commands successfully loaded: %c"+l.length,debugStyle)},removeCommands:function(t){l=t!==n?(t=Array.isArray(t)?t:[t],l.filter(function(e){for(var o=0;o<t.length;o++)if(t[o]===e.originalPhrase)return!1;return!0})):[]},addCallback:function(e,o,t){var a;h[e]===n||"function"==typeof(a=root[o]||o)&&h[e].push({callback:a,context:t||this})}}}.call(this);var autoStart=function(){smartSpeechRecognition.addCommands(commands),smartSpeechRecognition?(smartSpeechRecognition.start(),$.root_.addClass("voice-command-active"),voice_localStorage&&localStorage.setItem("sm-setautovoice","true")):alert("speech plugin not loaded")};SpeechRecognition&&voice_command&&"true"==localStorage.getItem("sm-setautovoice")&&autoStart(),SpeechRecognition&&voice_command_auto&&voice_command&&autoStart();