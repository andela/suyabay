$(document).ready(function(){

    /**
     * onClick event to handle Channel delete
     */
    $("#delete_channel", this).on("click", function () {
        var id      = $(this).data("id");
        var url     = "/dashboard/channel/"+id;
        var data    =  {
            url : url,
            parameter: {
                _token       : $(this).data("token"),
                channel_id   : id,
                channel_name : $(this).data("name")
            }
        }
        // confirmDelete(data.url, data.parameter, data.parameter.channel_id, data.parameter.channel_name );
        processAjax("DELETE", data.url, data.parameter, data.parameter.channel_name );

        return false;
    });

    $("#swap_episode_delete_channel", this).on("click", function () {
        var id      = $(this).data("id");
        var url     = "/dashboard/channel/"+id;
        var data    =  {
            url : url,
            parameter: {
                _token       : $(this).data("token"),
                channel_id   : id,
                channel_name : $(this).data("name"),
                episodes : $(this).data("episoes")
            }
        }
        confirmDelete(data.url, data.parameter, data.parameter.channel_id, data.parameter.channel_name );

        return false;
    });

    /**
     * onSubmit swap channels
     */
    $("#swap_episodes").submit( function () {
        var url     = "/dashboard/channel/swap/"+id;
        var data    =
            {
                parameter  :
                {
                    _token        : $("#token").val(),
                    channel_id              : $("#channel_id").val(),
                    new_channel_id          : $("#new_channel_id").val()
                }
            }

        processAjax("POST", url, data.parameter, data.parameter.new_channel_id);

        return false;
    });

    /**
     * onSubmit event to handle Channel update
     */
    $("#channel_update").submit( function (event) {

        event.preventDefault();

        var channelName = $("#channel_name").val().trim();
        var channelDescription = $("#channel_description").val().trim();

        if( channelName.length != 0 && channelDescription.length ) {

            var data =
            {
                url        : "/dashboard/channel/edit",
                parameter  :
                {
                    _token                : $("#token").val(),
                    channel_id            : $("#channel_id").val(),
                    channel_name          : channelName,
                    channel_description   : channelDescription
                }
            }
            processAjax("PUT", data.url, data.parameter, data.parameter.channel_name );
        } else{
            swal({
                title: "Error!",
                text: "Please provide both a channel name and description",
                type: "error",
                showCancelButton: false,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
            });
        }

        return false;
    });

    /**
     * onSubmit event to handle Channel update
     */
    $("#episode_update").submit( function () {

        var data =
        {
            url        : "/dashboard/episode/edit",
            parameter  :
            {
                _token                : $("#token").val(),
                episode_id            : $("#episode_id").val(),
                episode               : $("#episode").val(),
                channel_id            : $("#channel_id").val(),
                description           : $("#description").val()
            }
        }

        processEpisodeUpdate("PUT", data.url, data.parameter, data.parameter.episode );

        // confirmUpdate(data.url, data.parameter, data.parameter.episode_name, data.parameter.channel_id);


        return false;
    });

    /**
     * onSubmit event to handle User Edit
     */
    $("#create_user").submit( function () {
        var url       = "/dashboard/user/create";
        var token     = $("#_token").val();
        var username  = $("#username").val().trim();

        //throw error if nothing was passes in the username field
        if (username.length === 0) {
            swal({
                title: "Error!",
                text: "Please provide a username",
                type: "error",
                showCancelButton: false,
                closeOnConfirm: true,
                showLoaderOnConfirm: true,
            });
            return false;
        }
        var userRole = $("#user_role").val();
        var data =
            {
                url        : url,
                parameter  :
                {
                    _token      : token,
                    username    : username,
                    user_role   : userRole
                }
            }
        processAjax("POST", data.url, data.parameter, data.parameter.username );

        return false;
    });

    /**
     * onSubmit event to handle User Edit
     */
    $("#edit_user").submit( function () {
        var data =
            {
                url        : "/dashboard/user/edit",
                parameter  :
                {
                    _token      : $("#_token").val(),
                    user_id     :  $("#user_id").val(),
                    username    : $("#username").val(),
                    user_role   : $("#user_role").val()
                }
            }
        processAjax("PUT", data.url, data.parameter, data.parameter.username );

        return false;
    });

});

/**
 *confirmDelete modal message
 *
 * @param  url
 * @param  parameter
 * @param  name
 */
function confirmDelete (url, parameter, id, name)
{
    swal({
        title: "Confirm Delete",
        text: "This Channel has Episodes, deleting it implies deleting all the Episodes under it. Are you sure you want to do this?",
        type: "info",
        showCancelButton: true,
        confirmButtonColor: "#009688",
        confirmButtonText: "Yes, please!",
        cancelButtonText: "Cancel",
        allowOutsideClick:true,
        closeOnConfirm: false,
        closeOnCancel: false,
        animation:true,
        showLoaderOnConfirm:true

    },

    function ( isConfirm )
    {
        if ( isConfirm) {
            document.location.href = "/dashboard/channel/swap/"+id;
        } else {
            document.location.href = "/dashboard/channels/all";
        }
    });
}

function confirmUpdate (url, parameter, name, id)
{
    swal({   title: "Success!",   text: id,   timer: 1500,   showConfirmButton: false });
}

/**
 * channelSuccessMessage modal message
 *
 * @param  name
 */
function channelSuccessMessage (message)
{
    swal({
            title: "Done!",
            text: message,
            type: "success",
            showCancelButton: false,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            },
            function (){
                document.location.href = "/dashboard/channels/all";
            }
        );
}

/**
 * successEditUser modal message
 */
function userSuccessMessage (message)
{
    swal({
            title: "Done!",
            text: message,
            type: "success",
            showCancelButton: false,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            },
            function (){
                document.location.href = "/dashboard/users";
            }
        );
}

/**
 * cancelDeleteMessage modal message
 *
 * @param  name
 */
function cancelDeleteMessage (name)
{
    document.location.href = "/dashboard/channels/all";
}

/**
 * errorInviteUser modal message
 */
function errorMessage (message)
{
    swal("Error", message, "error");
}

/**
 * processAjax Proccess the ajax call
 *
 * @param  url
 * @param  parameter
 * @param  name
 */
function processAjax (action, url, parameter, name)
{
    $.ajax({
        url: url,
        type: action,
        data: parameter,
        success: function(response) {
            switch( response.status_code )
            {
                case 200:
                    return channelSuccessMessage( response.message );
                    break;

                case 201:
                    return userSuccessMessage( response.message );
                    break;

                default: errorMessage( response.message );
            }
        }
    });
}


function processEpisodeUpdate (action, url, parameter, name)
{
    $.ajax({
        url: url,
        type: action,
        data: parameter,
        success: function(response) {
            switch( response.status_code )
            {
                case 200:
                    return successMessage( response.message );
                    break;

                default: errorMessage( response.message );
            }
        }
    });
}

function successMessage (message)
{
    swal("Good job!", "Episode succesfuly updated!", "success");
    document.location.href = "/dashboard/episodes";
}

var  clipboard = new Clipboard(".copy");

clipboard.on("success", function() {
    swal("Token copied successfully");
});


(function(h,o,g){var p=function(){for(var b=/audio(.min)?.js.*/,a=document.getElementsByTagName("script"),c=0,d=a.length;c<d;c++){var e=a[c].getAttribute("src");if(b.test(e))return e.replace(b,"")}}();g[h]={instanceCount:0,instances:{},flashSource:'      <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" id="$1" width="1" height="1" name="$1" style="position: absolute; left: -1px;">         <param name="movie" value="$2?playerInstance='+h+'.instances[\'$1\']&datetime=$3">         <param name="allowscriptaccess" value="always">         <embed name="$1" src="$2?playerInstance='+
h+'.instances[\'$1\']&datetime=$3" width="1" height="1" allowscriptaccess="always">       </object>',settings:{autoplay:false,loop:false,preload:true,imageLocation:p+"player-graphics.gif",swfLocation:p+"audiojs.swf",useFlash:function(){var b=document.createElement("audio");return!(b.canPlayType&&b.canPlayType("audio/mpeg;").replace(/no/,""))}(),hasFlash:function(){if(navigator.plugins&&navigator.plugins.length&&navigator.plugins["Shockwave Flash"])return true;else if(navigator.mimeTypes&&navigator.mimeTypes.length){var b=
navigator.mimeTypes["application/x-shockwave-flash"];return b&&b.enabledPlugin}else try{new ActiveXObject("ShockwaveFlash.ShockwaveFlash");return true}catch(a){}return false}(),createPlayer:{markup:'          <div class="play-pause">             <p class="play"></p>             <p class="pause"></p>             <p class="loading"></p>             <p class="error"></p>           </div>           <div class="scrubber">             <div class="progress"></div>             <div class="loaded"></div>           </div>           <div class="time">             <em class="played">00:00</em>/<strong class="duration">00:00</strong>           </div>           <div class="error-message"></div>',
playPauseClass:"play-pause",scrubberClass:"scrubber",progressClass:"progress",loaderClass:"loaded",timeClass:"time",durationClass:"duration",playedClass:"played",errorMessageClass:"error-message",playingClass:"playing",loadingClass:"loading",errorClass:"error"},css:'        .audiojs audio { position: absolute; left: -1px; }         .audiojs { width: 460px; height: 36px; background: #404040; overflow: hidden; font-family: monospace; font-size: 12px;           background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0, #444), color-stop(0.5, #555), color-stop(0.51, #444), color-stop(1, #444));           background-image: -moz-linear-gradient(center top, #444 0%, #555 50%, #444 51%, #444 100%);           -webkit-box-shadow: 1px 1px 8px rgba(0, 0, 0, 0.3); -moz-box-shadow: 1px 1px 8px rgba(0, 0, 0, 0.3);           -o-box-shadow: 1px 1px 8px rgba(0, 0, 0, 0.3); box-shadow: 1px 1px 8px rgba(0, 0, 0, 0.3); }         .audiojs .play-pause { width: 25px; height: 40px; padding: 4px 6px; margin: 0px; float: left; overflow: hidden; border-right: 1px solid #000; }         .audiojs p { display: none; width: 25px; height: 40px; margin: 0px; cursor: pointer; }         .audiojs .play { display: block; }         .audiojs .scrubber { position: relative; float: left; width: 280px; background: #5a5a5a; height: 14px; margin: 10px; border-top: 1px solid #3f3f3f; border-left: 0px; border-bottom: 0px; overflow: hidden; }         .audiojs .progress { position: absolute; top: 0px; left: 0px; height: 14px; width: 0px; background: #ccc; z-index: 1;           background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0, #ccc), color-stop(0.5, #ddd), color-stop(0.51, #ccc), color-stop(1, #ccc));           background-image: -moz-linear-gradient(center top, #ccc 0%, #ddd 50%, #ccc 51%, #ccc 100%); }         .audiojs .loaded { position: absolute; top: 0px; left: 0px; height: 14px; width: 0px; background: #000;           background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0, #222), color-stop(0.5, #333), color-stop(0.51, #222), color-stop(1, #222));           background-image: -moz-linear-gradient(center top, #222 0%, #333 50%, #222 51%, #222 100%); }         .audiojs .time { float: left; height: 36px; line-height: 36px; margin: 0px 0px 0px 6px; padding: 0px 6px 0px 12px; border-left: 1px solid #000; color: #ddd; text-shadow: 1px 1px 0px rgba(0, 0, 0, 0.5); }         .audiojs .time em { padding: 0px 2px 0px 0px; color: #f9f9f9; font-style: normal; }         .audiojs .time strong { padding: 0px 0px 0px 2px; font-weight: normal; }         .audiojs .error-message { float: left; display: none; margin: 0px 10px; height: 36px; width: 400px; overflow: hidden; line-height: 36px; white-space: nowrap; color: #fff;           text-overflow: ellipsis; -o-text-overflow: ellipsis; -icab-text-overflow: ellipsis; -khtml-text-overflow: ellipsis; -moz-text-overflow: ellipsis; -webkit-text-overflow: ellipsis; }         .audiojs .error-message a { color: #eee; text-decoration: none; padding-bottom: 1px; border-bottom: 1px solid #999; white-space: wrap; }                 .audiojs .play { background: url("$1") -2px -1px no-repeat; }         .audiojs .loading { background: url("$1") -2px -31px no-repeat; }         .audiojs .error { background: url("$1") -2px -61px no-repeat; }         .audiojs .pause { background: url("$1") -2px -91px no-repeat; }                 .playing .play, .playing .loading, .playing .error { display: none; }         .playing .pause { display: block; }                 .loading .play, .loading .pause, .loading .error { display: none; }         .loading .loading { display: block; }                 .error .time, .error .play, .error .pause, .error .scrubber, .error .loading { display: none; }         .error .error { display: block; }         .error .play-pause p { cursor: auto; }         .error .error-message { display: block; }',
trackEnded:function(){},flashError:function(){var b=this.settings.createPlayer,a=j(b.errorMessageClass,this.wrapper),c='Missing <a href="http://get.adobe.com/flashplayer/">flash player</a> plugin.';if(this.mp3)c+=' <a href="'+this.mp3+'">Download audio file</a>.';g[h].helpers.removeClass(this.wrapper,b.loadingClass);g[h].helpers.addClass(this.wrapper,b.errorClass);a.innerHTML=c},loadError:function(){var b=this.settings.createPlayer,a=j(b.errorMessageClass,this.wrapper);g[h].helpers.removeClass(this.wrapper,
b.loadingClass);g[h].helpers.addClass(this.wrapper,b.errorClass);a.innerHTML='Error loading: "'+this.mp3+'"'},init:function(){g[h].helpers.addClass(this.wrapper,this.settings.createPlayer.loadingClass)},loadStarted:function(){var b=this.settings.createPlayer,a=j(b.durationClass,this.wrapper),c=Math.floor(this.duration/60),d=Math.floor(this.duration%60);g[h].helpers.removeClass(this.wrapper,b.loadingClass);a.innerHTML=(c<10?"0":"")+c+":"+(d<10?"0":"")+d},loadProgress:function(b){var a=this.settings.createPlayer,
c=j(a.scrubberClass,this.wrapper);j(a.loaderClass,this.wrapper).style.width=c.offsetWidth*b+"px"},playPause:function(){this.playing?this.settings.play():this.settings.pause()},play:function(){g[h].helpers.addClass(this.wrapper,this.settings.createPlayer.playingClass)},pause:function(){g[h].helpers.removeClass(this.wrapper,this.settings.createPlayer.playingClass)},updatePlayhead:function(b){var a=this.settings.createPlayer,c=j(a.scrubberClass,this.wrapper);j(a.progressClass,this.wrapper).style.width=
c.offsetWidth*b+"px";a=j(a.playedClass,this.wrapper);c=this.duration*b;b=Math.floor(c/60);c=Math.floor(c%60);a.innerHTML=(b<10?"0":"")+b+":"+(c<10?"0":"")+c}},create:function(b,a){a=a||{};return b.length?this.createAll(a,b):this.newInstance(b,a)},createAll:function(b,a){var c=a||document.getElementsByTagName("audio"),d=[];b=b||{};for(var e=0,i=c.length;e<i;e++)d.push(this.newInstance(c[e],b));return d},newInstance:function(b,a){var c=this.helpers.clone(this.settings),d="audiojs"+this.instanceCount,
e="audiojs_wrapper"+this.instanceCount;this.instanceCount++;if(b.getAttribute("autoplay")!=null)c.autoplay=true;if(b.getAttribute("loop")!=null)c.loop=true;if(b.getAttribute("preload")=="none")c.preload=false;a&&this.helpers.merge(c,a);if(c.createPlayer.markup)b=this.createPlayer(b,c.createPlayer,e);else b.parentNode.setAttribute("id",e);e=new g[o](b,c);c.css&&this.helpers.injectCss(e,c.css);if(c.useFlash&&c.hasFlash){this.injectFlash(e,d);this.attachFlashEvents(e.wrapper,e)}else c.useFlash&&!c.hasFlash&&
this.settings.flashError.apply(e);if(!c.useFlash||c.useFlash&&c.hasFlash)this.attachEvents(e.wrapper,e);return this.instances[d]=e},createPlayer:function(b,a,c){var d=document.createElement("div"),e=b.cloneNode(true);d.setAttribute("class","audiojs");d.setAttribute("className","audiojs");d.setAttribute("id",c);if(e.outerHTML&&!document.createElement("audio").canPlayType){e=this.helpers.cloneHtml5Node(b);d.innerHTML=a.markup;d.appendChild(e);b.outerHTML=d.outerHTML;d=document.getElementById(c)}else{d.appendChild(e);
d.innerHTML+=a.markup;b.parentNode.replaceChild(d,b)}return d.getElementsByTagName("audio")[0]},attachEvents:function(b,a){if(a.settings.createPlayer){var c=a.settings.createPlayer,d=j(c.playPauseClass,b),e=j(c.scrubberClass,b);g[h].events.addListener(d,"click",function(){a.playPause.apply(a)});g[h].events.addListener(e,"click",function(i){i=i.clientX;var f=this,k=0;if(f.offsetParent){do k+=f.offsetLeft;while(f=f.offsetParent)}a.skipTo((i-k)/e.offsetWidth)});if(!a.settings.useFlash){g[h].events.trackLoadProgress(a);
g[h].events.addListener(a.element,"timeupdate",function(){a.updatePlayhead.apply(a)});g[h].events.addListener(a.element,"ended",function(){a.trackEnded.apply(a)});g[h].events.addListener(a.source,"error",function(){clearInterval(a.readyTimer);clearInterval(a.loadTimer);a.settings.loadError.apply(a)})}}},attachFlashEvents:function(b,a){a.swfReady=false;a.load=function(c){a.mp3=c;a.swfReady&&a.element.load(c)};a.loadProgress=function(c,d){a.loadedPercent=c;a.duration=d;a.settings.loadStarted.apply(a);
a.settings.loadProgress.apply(a,[c])};a.skipTo=function(c){if(!(c>a.loadedPercent)){a.updatePlayhead.call(a,[c]);a.element.skipTo(c)}};a.updatePlayhead=function(c){a.settings.updatePlayhead.apply(a,[c])};a.play=function(){if(!a.settings.preload){a.settings.preload=true;a.element.init(a.mp3)}a.playing=true;a.element.pplay();a.settings.play.apply(a)};a.pause=function(){a.playing=false;a.element.ppause();a.settings.pause.apply(a)};a.setVolume=function(c){a.element.setVolume(c)};a.loadStarted=function(){a.swfReady=
true;a.settings.preload&&a.element.init(a.mp3);a.settings.autoplay&&a.play.apply(a)}},injectFlash:function(b,a){var c=this.flashSource.replace(/\$1/g,a);c=c.replace(/\$2/g,b.settings.swfLocation);c=c.replace(/\$3/g,+new Date+Math.random());var d=b.wrapper.innerHTML,e=document.createElement("div");e.innerHTML=c+d;b.wrapper.innerHTML=e.innerHTML;b.element=this.helpers.getSwf(a)},helpers:{merge:function(b,a){for(attr in a)if(b.hasOwnProperty(attr)||a.hasOwnProperty(attr))b[attr]=a[attr]},clone:function(b){if(b==
null||typeof b!=="object")return b;var a=new b.constructor,c;for(c in b)a[c]=arguments.callee(b[c]);return a},addClass:function(b,a){RegExp("(\\s|^)"+a+"(\\s|$)").test(b.className)||(b.className+=" "+a)},removeClass:function(b,a){b.className=b.className.replace(RegExp("(\\s|^)"+a+"(\\s|$)")," ")},injectCss:function(b,a){for(var c="",d=document.getElementsByTagName("style"),e=a.replace(/\$1/g,b.settings.imageLocation),i=0,f=d.length;i<f;i++){var k=d[i].getAttribute("title");if(k&&~k.indexOf("audiojs")){f=
d[i];if(f.innerHTML===e)return;c=f.innerHTML;break}}d=document.getElementsByTagName("head")[0];i=d.firstChild;f=document.createElement("style");if(d){f.setAttribute("type","text/css");f.setAttribute("title","audiojs");if(f.styleSheet)f.styleSheet.cssText=c+e;else f.appendChild(document.createTextNode(c+e));i?d.insertBefore(f,i):d.appendChild(styleElement)}},cloneHtml5Node:function(b){var a=document.createDocumentFragment(),c=a.createElement?a:document;c.createElement("audio");c=c.createElement("div");
a.appendChild(c);c.innerHTML=b.outerHTML;return c.firstChild},getSwf:function(b){b=document[b]||window[b];return b.length>1?b[b.length-1]:b}},events:{memoryLeaking:false,listeners:[],addListener:function(b,a,c){if(b.addEventListener)b.addEventListener(a,c,false);else if(b.attachEvent){this.listeners.push(b);if(!this.memoryLeaking){window.attachEvent("onunload",function(){if(this.listeners)for(var d=0,e=this.listeners.length;d<e;d++)g[h].events.purge(this.listeners[d])});this.memoryLeaking=true}b.attachEvent("on"+
a,function(){c.call(b,window.event)})}},trackLoadProgress:function(b){if(b.settings.preload){var a,c;b=b;var d=/(ipod|iphone|ipad)/i.test(navigator.userAgent);a=setInterval(function(){if(b.element.readyState>-1)d||b.init.apply(b);if(b.element.readyState>1){b.settings.autoplay&&b.play.apply(b);clearInterval(a);c=setInterval(function(){b.loadProgress.apply(b);b.loadedPercent>=1&&clearInterval(c)})}},10);b.readyTimer=a;b.loadTimer=c}},purge:function(b){var a=b.attributes,c;if(a)for(c=0;c<a.length;c+=
1)if(typeof b[a[c].name]==="function")b[a[c].name]=null;if(a=b.childNodes)for(c=0;c<a.length;c+=1)purge(b.childNodes[c])},ready:function(){return function(b){var a=window,c=false,d=true,e=a.document,i=e.documentElement,f=e.addEventListener?"addEventListener":"attachEvent",k=e.addEventListener?"removeEventListener":"detachEvent",n=e.addEventListener?"":"on",m=function(l){if(!(l.type=="readystatechange"&&e.readyState!="complete")){(l.type=="load"?a:e)[k](n+l.type,m,false);if(!c&&(c=true))b.call(a,l.type||
l)}},q=function(){try{i.doScroll("left")}catch(l){setTimeout(q,50);return}m("poll")};if(e.readyState=="complete")b.call(a,"lazy");else{if(e.createEventObject&&i.doScroll){try{d=!a.frameElement}catch(r){}d&&q()}e[f](n+"DOMContentLoaded",m,false);e[f](n+"readystatechange",m,false);a[f](n+"load",m,false)}}}()}};g[o]=function(b,a){this.element=b;this.wrapper=b.parentNode;this.source=b.getElementsByTagName("source")[0]||b;this.mp3=function(c){var d=c.getElementsByTagName("source")[0];return c.getAttribute("src")||
(d?d.getAttribute("src"):null)}(b);this.settings=a;this.loadStartedCalled=false;this.loadedPercent=0;this.duration=1;this.playing=false};g[o].prototype={updatePlayhead:function(){this.settings.updatePlayhead.apply(this,[this.element.currentTime/this.duration])},skipTo:function(b){if(!(b>this.loadedPercent)){this.element.currentTime=this.duration*b;this.updatePlayhead()}},load:function(b){this.loadStartedCalled=false;this.source.setAttribute("src",b);this.element.load();this.mp3=b;g[h].events.trackLoadProgress(this)},
loadError:function(){this.settings.loadError.apply(this)},init:function(){this.settings.init.apply(this)},loadStarted:function(){if(!this.element.duration)return false;this.duration=this.element.duration;this.updatePlayhead();this.settings.loadStarted.apply(this)},loadProgress:function(){if(this.element.buffered!=null&&this.element.buffered.length){if(!this.loadStartedCalled)this.loadStartedCalled=this.loadStarted();this.loadedPercent=this.element.buffered.end(this.element.buffered.length-1)/this.duration;
this.settings.loadProgress.apply(this,[this.loadedPercent])}},playPause:function(){this.playing?this.pause():this.play()},play:function(){/(ipod|iphone|ipad)/i.test(navigator.userAgent)&&this.element.readyState==0&&this.init.apply(this);if(!this.settings.preload){this.settings.preload=true;this.element.setAttribute("preload","auto");g[h].events.trackLoadProgress(this)}this.playing=true;this.element.play();this.settings.play.apply(this)},pause:function(){this.playing=false;this.element.pause();this.settings.pause.apply(this)},
setVolume:function(b){this.element.volume=b},trackEnded:function(){this.skipTo.apply(this,[0]);this.settings.loop||this.pause.apply(this);this.settings.trackEnded.apply(this)}};var j=function(b,a){var c=[];a=a||document;if(a.getElementsByClassName)c=a.getElementsByClassName(b);else{var d,e,i=a.getElementsByTagName("*"),f=RegExp("(^|\\s)"+b+"(\\s|$)");d=0;for(e=i.length;d<e;d++)f.test(i[d].className)&&c.push(i[d])}return c.length>1?c:c[0]}})("audiojs","audiojsInstance",this);

/*
    By Osvaldas Valutis, www.osvaldas.info
    Available for use under the MIT License
*/



;(function( $, window, document, undefined )
{
    var isTouch       = 'ontouchstart' in window,
        eStart        = isTouch ? 'touchstart'  : 'mousedown',
        eMove         = isTouch ? 'touchmove'   : 'mousemove',
        eEnd          = isTouch ? 'touchend'    : 'mouseup',
        eCancel       = isTouch ? 'touchcancel' : 'mouseup',
        secondsToTime = function( secs )
        {
            var hoursDiv = secs / 3600, hours = Math.floor( hoursDiv ), minutesDiv = secs % 3600 / 60, minutes = Math.floor( minutesDiv ), seconds = Math.ceil( secs % 3600 % 60 );
            if( seconds > 59 ) { seconds = 0; minutes = Math.ceil( minutesDiv ); }
            if( minutes > 59 ) { minutes = 0; hours = Math.ceil( hoursDiv ); }
            return ( hours == 0 ? '' : hours > 0 && hours.toString().length < 2 ? '0'+hours+':' : hours+':' ) + ( minutes.toString().length < 2 ? '0'+minutes : minutes ) + ':' + ( seconds.toString().length < 2 ? '0'+seconds : seconds );
        },
        canPlayType   = function( file )
        {
            var audioElement = document.createElement( 'audio' );
            return !!( audioElement.canPlayType && audioElement.canPlayType( 'audio/' + file.split( '.' ).pop().toLowerCase() + ';' ).replace( /no/, '' ) );
        };

    $.fn.audioPlayer = function( params )
    {
        var params      = $.extend( { classPrefix: 'audioplayer', strPlay: 'Play', strPause: 'Pause', strVolume: 'Volume' }, params ),
            cssClass    = {},
            cssClassSub =
            {
                playPause:      'playpause',
                playing:        'playing',
                stopped:        'stopped',
                time:           'time',
                timeCurrent:    'time-current',
                timeDuration:   'time-duration',
                bar:            'bar',
                barLoaded:      'bar-loaded',
                barPlayed:      'bar-played',
                volume:         'volume',
                volumeButton:   'volume-button',
                volumeAdjust:   'volume-adjust',
                noVolume:       'novolume',
                muted:          'muted',
                mini:           'mini'
            };

        for( var subName in cssClassSub )
            cssClass[ subName ] = params.classPrefix + '-' + cssClassSub[ subName ];

        this.each( function()
        {
            if( $( this ).prop( 'tagName' ).toLowerCase() != 'audio' )
                return false;

            var $this      = $( this ),
                audioFile  = $this.attr( 'src' ),
                isAutoPlay = $this.get( 0 ).getAttribute( 'autoplay' ), isAutoPlay = isAutoPlay === '' || isAutoPlay === 'autoplay' ? true : false,
                isLoop     = $this.get( 0 ).getAttribute( 'loop' ),     isLoop     = isLoop     === '' || isLoop     === 'loop'     ? true : false,
                isSupport  = false;

            if( typeof audioFile === 'undefined' )
            {
                $this.find( 'source' ).each( function()
                {
                    audioFile = $( this ).attr( 'src' );
                    if( typeof audioFile !== 'undefined' && canPlayType( audioFile ) )
                    {
                        isSupport = true;
                        return false;
                    }
                });
            }
            else if( canPlayType( audioFile ) ) isSupport = true;

            var thePlayer = $( '<div class="' + params.classPrefix + '">' + ( isSupport ? $( '<div>' ).append( $this.eq( 0 ).clone() ).html() : '<embed src="' + audioFile + '" width="0" height="0" volume="100" autostart="' + isAutoPlay.toString() +'" loop="' + isLoop.toString() + '" />' ) + '<div class="' + cssClass.playPause + '" title="' + params.strPlay + '"><a href="#">' + params.strPlay + '</a></div></div>' ),
                theAudio  = isSupport ? thePlayer.find( 'audio' ) : thePlayer.find( 'embed' ), theAudio = theAudio.get( 0 );

            if( isSupport )
            {
                thePlayer.find( 'audio' ).css( { 'width': 0, 'height': 0, 'visibility': 'hidden' } );
                thePlayer.append( '<div class="' + cssClass.time + ' ' + cssClass.timeCurrent + '"></div><div class="' + cssClass.bar + '"><div class="' + cssClass.barLoaded + '"></div><div class="' + cssClass.barPlayed + '"></div></div><div class="' + cssClass.time + ' ' + cssClass.timeDuration + '"></div><div class="' + cssClass.volume + '"><div class="' + cssClass.volumeButton + '" title="' + params.strVolume + '"><a href="#">' + params.strVolume + '</a></div><div class="' + cssClass.volumeAdjust + '"><div><div></div></div></div></div>' );

                var theBar            = thePlayer.find( '.' + cssClass.bar ),
                    barPlayed         = thePlayer.find( '.' + cssClass.barPlayed ),
                    barLoaded         = thePlayer.find( '.' + cssClass.barLoaded ),
                    timeCurrent       = thePlayer.find( '.' + cssClass.timeCurrent ),
                    timeDuration      = thePlayer.find( '.' + cssClass.timeDuration ),
                    volumeButton      = thePlayer.find( '.' + cssClass.volumeButton ),
                    volumeAdjuster    = thePlayer.find( '.' + cssClass.volumeAdjust + ' > div' ),
                    volumeDefault     = 0,
                    adjustCurrentTime = function( e )
                    {
                        theRealEvent         = isTouch ? e.originalEvent.touches[ 0 ] : e;
                        theAudio.currentTime = Math.round( ( theAudio.duration * ( theRealEvent.pageX - theBar.offset().left ) ) / theBar.width() );
                    },
                    adjustVolume = function( e )
                    {
                        theRealEvent    = isTouch ? e.originalEvent.touches[ 0 ] : e;
                        theAudio.volume = Math.abs( ( theRealEvent.pageY - ( volumeAdjuster.offset().top + volumeAdjuster.height() ) ) / volumeAdjuster.height() );
                    },
                    updateLoadBar = function()
                    {
                        var interval = setInterval( function()
                        {
                            if( theAudio.buffered.length < 1 ) return true;
                            barLoaded.width( ( theAudio.buffered.end( 0 ) / theAudio.duration ) * 100 + '%' );
                            if( Math.floor( theAudio.buffered.end( 0 ) ) >= Math.floor( theAudio.duration ) ) clearInterval( interval );
                        }, 100 );
                    };

                var volumeTestDefault = theAudio.volume, volumeTestValue = theAudio.volume = 0.111;
                if( Math.round( theAudio.volume * 1000 ) / 1000 == volumeTestValue ) theAudio.volume = volumeTestDefault;
                else thePlayer.addClass( cssClass.noVolume );

                timeDuration.html( '&hellip;' );
                timeCurrent.html( secondsToTime( 0 ) );

                theAudio.addEventListener( 'loadeddata', function()
                {
                    updateLoadBar();
                    timeDuration.html( $.isNumeric( theAudio.duration ) ? secondsToTime( theAudio.duration ) : '&hellip;' );
                    volumeAdjuster.find( 'div' ).height( theAudio.volume * 100 + '%' );
                    volumeDefault = theAudio.volume;
                });

                theAudio.addEventListener( 'timeupdate', function()
                {
                    timeCurrent.html( secondsToTime( theAudio.currentTime ) );
                    barPlayed.width( ( theAudio.currentTime / theAudio.duration ) * 100 + '%' );
                });

                theAudio.addEventListener( 'volumechange', function()
                {
                    volumeAdjuster.find( 'div' ).height( theAudio.volume * 100 + '%' );
                    if( theAudio.volume > 0 && thePlayer.hasClass( cssClass.muted ) ) thePlayer.removeClass( cssClass.muted );
                    if( theAudio.volume <= 0 && !thePlayer.hasClass( cssClass.muted ) ) thePlayer.addClass( cssClass.muted );
                });

                theAudio.addEventListener( 'ended', function()
                {
                    thePlayer.removeClass( cssClass.playing ).addClass( cssClass.stopped );
                });

                theBar.on( eStart, function( e )
                {
                    adjustCurrentTime( e );
                    theBar.on( eMove, function( e ) { adjustCurrentTime( e ); } );
                })
                .on( eCancel, function()
                {
                    theBar.unbind( eMove );
                });

                volumeButton.on( 'click', function()
                {
                    if( thePlayer.hasClass( cssClass.muted ) )
                    {
                        thePlayer.removeClass( cssClass.muted );
                        theAudio.volume = volumeDefault;
                    }
                    else
                    {
                        thePlayer.addClass( cssClass.muted );
                        volumeDefault = theAudio.volume;
                        theAudio.volume = 0;
                    }
                    return false;
                });

                volumeAdjuster.on( eStart, function( e )
                {
                    adjustVolume( e );
                    volumeAdjuster.on( eMove, function( e ) { adjustVolume( e ); } );
                })
                .on( eCancel, function()
                {
                    volumeAdjuster.unbind( eMove );
                });
            }
            else thePlayer.addClass( cssClass.mini );

            thePlayer.addClass( isAutoPlay ? cssClass.playing : cssClass.stopped );

            thePlayer.find( '.' + cssClass.playPause ).on( 'click', function()
            {
                if( thePlayer.hasClass( cssClass.playing ) )
                {
                    $( this ).attr( 'title', params.strPlay ).find( 'a' ).html( params.strPlay );
                    thePlayer.removeClass( cssClass.playing ).addClass( cssClass.stopped );
                    isSupport ? theAudio.pause() : theAudio.Stop();
                }
                else
                {
                    $( this ).attr( 'title', params.strPause ).find( 'a' ).html( params.strPause );
                    thePlayer.addClass( cssClass.playing ).removeClass( cssClass.stopped );
                    isSupport ? theAudio.play() : theAudio.Play();
                }
                return false;
            });

            $this.replaceWith( thePlayer );
        });
        return this;
    };
})( jQuery, window, document );
$(document).ready(function() {

    $(".view_more_comments").on("click",function() {

        var avatar = $(this).data('avatar');
        var numOfComments = $(".load_comment").find("div#show_comment");
        var episodeId  = $("#episode_id").val();

        try {

            $.ajax({
                url:'/comment',
                type:'GET',
                data:{
                     offset: numOfComments.size(),
                     episode_id: episodeId
            },
            success: function(data) {

                for (i = 0 ; i < data.comments.length; i++) {
                    var comments = data.comments[i];

                    $('#comment-count').html(' ' + numOfComments.size());

                     var newComment = '<div id="show_comment" class="collection-item avatar show_comment">';
                     newComment    += '<div class="row">';
                     newComment    += '<div class="col s2">';
                     newComment    += '<img src="' + avatar + '" alt="" class="circle">';
                     newComment    += '</div>';
                     newComment    += '<div class="col s10">';
                     newComment    += '<div class="textarea-wrapper" ';
                     newComment    += 'data-comment-id="' + comments.id + '">';
                     newComment    += '<span>' + comments.comments + '</span>';
                     newComment    += '<div class="update-actions pull-right">';
                     newComment    += '<a href="#" id="comment_action_caret" class="fa fa-bars no-style-link"></a>';
                     newComment    += '<div id="comment_actions" style="display:none">';
                     newComment    += '<a href="#" class="fa fa-pencil comment-action-edit no-style-link" ';
                     newComment    += 'data-commentId="' + comments.id + '"></a>';
                     newComment    += '<a href="#" class="fa fa-trash comment-action-delete no-style-link" ';
                     newComment    += 'data-commentId="' + comments.id + '"></a>';
                     newComment    += '</div>';
                     newComment    += '</div>';
                     newComment    += '</div></div></div></div>';

                     $('.load_comment').last().append(newComment);
                     $('#new-comment-field').val('');
                }
            }
        });
        } catch (e) {

            console.log(e);
        }

        return false;
    });


    $('.comment-submit').on('click', function() {

        var comment = $('#new-comment-field').val();
        var avatar = $(this).data('avatar');
        var commentCount = parseInt($(this).data('comment-count')) + 1;
        var token = $(this).data('token');

        var url = '/comment';
        var user_id = $('#user_id').val();
        var episodeId = $('#episode_id').val();

        var data = {
            parameter: {
                _token: token,
                episode_id: episodeId,
                comment: comment
            }
        }
        if (comment.length > 0) {
            //Process AJAX request
            $.ajax({
                url: url,
                type: 'POST',
                data: data.parameter,

                success: function(response) {

                    switch (response.status_code) {
                        case 200:

                            var newComment = '<div id="show_comment" class="collection-item avatar show_comment">';
                            newComment += '<div class="row">';
                            newComment += '<div class="col s2">';
                            newComment += '<img src="' + avatar + '" alt="" class="circle">';
                            newComment += '</div>';
                            newComment += '<div class="col s10">';
                            newComment += '<div class="textarea-wrapper" ';
                            newComment += 'data-comment-id="' + response.commentId + '">';
                            newComment += '<span>' + comment + '</span>';
                            newComment += '<div class="update-actions pull-right">';
                            newComment += '<a href="#" id="comment_action_caret" class="fa fa-bars no-style-link"></a>';
                            newComment += '<div id="comment_actions" style="display:none">';
                            newComment += '<a href="#" class="fa fa-pencil comment-action-edit no-style-link" ';
                            newComment += 'data-commentId="' + response.commentId + '"></a>';
                            newComment += '<a href="#" class="fa fa-trash comment-action-delete no-style-link" ';
                            newComment += 'data-commentId="' + response.commentId + '"></a>';
                            newComment += '</div>';
                            newComment += '</div>';
                            newComment += '</div></div></div></div>';

                            $('.load_comment').last().append(newComment);
                            //Increase the count by 1 after submitting a comment
                            var count = $('#comment-count').html();
                            count = Number(count) + 1;

                            //Set this new value in the html
                            $('#comment-count').html(count);

                            //empty the comment field
                            $('#new-comment-field').val('');

                            break;

                        default:
                            return false;
                    }
                }
            });
        }

        return false;
    });

});

$(document).ready(function() {

    $('.load_comment').on('click', 'a#comment_action_caret', function(event) {
        event.preventDefault();
        $('.textarea-wrapper #comment_actions')
            .not($(this)
                .next())
            .hide('slow');

        $(this).next().toggle('slow');
    });

    $('.load_comment').on('click', '#comment_actions a.comment-action-delete',
        function(event) {
            event.preventDefault();

            var this_ = $(this);
            var token = $('.load_comment').attr('data-token');
            var comment = this_.attr('data-commentId');

            swal({
                title: 'Are you sure?',
                text: 'You will not be able to recover a deleted comment',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, delete it!',
                closeOnConfirm: true
            }, function() {
                //delete comment
                var deleteComment = $.ajax({
                    method: 'DELETE',
                    url: '/comment/' + comment,
                    data: {
                        _token: token
                    }
                });

                deleteComment.done(function() {
                    this_
                        .parent()
                        .parent()
                        .parent()
                        .parent()
                        .parent()
                        .parent()
                        .remove();

                });

                //Decrease comment count when one deletes a comment
                var count = $('#comment-count').html();
                count = Number(count) - 1;

                //Set this new value in the html
                $('#comment-count').html(count);

                deleteComment.fail(function() {

                    swal('Error Deleting',
                        'Error deleting your comment. please try again',
                        'error'
                    );
                });
            });
        });

    $('.load_comment').on('click', '#comment_actions a.comment-action-edit',
        function(event) {

            event.preventDefault();

            var parent = $(this)
                .parent()
                .parent()
                .parent();

            var commentWrapper = parent.find('span:first');
            var comment = commentWrapper.text().trim();

            parent.find('.update-actions').hide('slow', function() {

                var updateComment = '<div class="file-field input-field">';
                updateComment += '<div class="file-path-wrapper input-field ';
                updateComment += 'col s10 m10">';
                updateComment += '<input name="comment" id="comment-field" ';
                updateComment += 'type="text" style="margin-left:20px;" ';
                updateComment += 'class="validate" value="' + comment + '"/>';
                updateComment += '</div>';
                updateComment += '</div>';


                commentWrapper.replaceWith(updateComment);
            });
        });

    $('.load_comment').on('keypress', '#comment-field', function(event) {
        if (event.which == 13) {
            var this_ = $(this);

            var comment = this_.val().trim();
            var commentId = this_
                .parent()
                .parent()
                .parent()
                .attr('data-comment-id');

            var token = $('.load_comment').attr('data-token');

            if (comment.length === 0 ||
                commentId.length === 0 ||
                token.length === 0) {
                swal('Error Updating',
                    'Something is missing in your comment. Please try again',
                    'error'
                );
            } else {

                var updateComment = $.ajax({
                    method: 'PUT',
                    url: '/comment/' + commentId + '/edit',
                    data: {
                        _token: token,
                        comment: comment
                    }
                });

                updateComment.done(function() {

                    swal({
                        title: 'Updated!',
                        text: 'Comment successfully updated',
                        type: 'success'
                    }, function() {
                        location.reload();
                    });

                });

                updateComment.fail(function() {

                    swal('Error Updating',
                        'Error updating your comment. Please try again',
                        'error'
                    );
                });
            }
        }
    });
});
$(document).ready(function() {

    var item;

    $('.episode_action').on('change', function() {

        /*
		# Get <select/> element that was clicked on
    	*/
        var actionType = $(this).val(),

       /*
		# Get <select/> element data-action
    	*/
         action = $(this).find('option:selected').data('action');

        /*
		# Add class to parent element of the <select/> element
    	*/
        $(this).parent().closest('tr').prop('class', 'selected');


        if (actionType === 'view') {
            window.location = action;
        }

        if (actionType === 'delete') {
            deleteEpisode(action)
        };

        if (actionType === 'activate') {

            item = $(this).parent().closest('tr');
            activateEpisode(action)
        };
    });


    /*
    # Delete Episode Function
    */
    function deleteEpisode(episodeId) {
        var
            url = '/dashboard/episode/delete',
            token = document.getElementById('token').value,
            method = 'DELETE',
            episode_id = episodeId,
            functionName = arguments.callee.name;

        var data = {
            url: url,
            method: method,
            parameter: {
                _token: token,
                episode_id: episodeId
            }
        }

        swal({
                title: 'Delete Episode',
                text: 'You will not be able to recover this episode!',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                closeOnCancelnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    ajaxCall(data, functionName)
                } else {
                    swal('Cancelled', 'Your episode is safe :)', 'error');
                }
            });
    }

    /*
    # Delete Episode Function
    */
    function activateEpisode(episodeId) {

        var functionName = arguments.callee.name;
        var data = {
            url: '/dashboard/episode/activate',
            method: 'PATCH',
            parameter: {
                _token: document.getElementById('token').value,
                episode_id: episodeId
            }
        }

        swal({
                title: 'Activate Episode',
                text: 'This Episode will be visible on your channel',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'success',
                confirmButtonText: 'Activate',
                cancelButtonText: 'Cancel!',
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    ajaxCall(data, functionName)
                } else {
                    swal('Cancelled', 'Your episode is safe :)', 'error');
                }
            });
    }



    /*
    # Ajax
    */
    function ajaxCall(data, functionName) {
        $.ajax({
            url: data.url,
            type: data.method,
            data: data.parameter,
            success: function(response) {
                ajaxLogic(response, functionName)
            },
            error: function() {
                alert('Are you sure you doing this the right way?');
            },
        });
    }


    function ajaxLogic(response, functionName) {
        /*
        # Check if Response.status = 401
        */
        if (response.status === 401) {
            switch (functionName) {
                case 'deleteEpisode':
                    deleteEpisodeErrorAlert();
                    break;
                case 'activateEpisode':
                    activateEpisodeErrorAlert();
                    break;
            }
        }

        /*
        # Check if Response.status = 200
        */
        if (response.status === 200) {
            switch (functionName) {
                case 'deleteEpisode':
                    deleteEpisodeSuccessAlert();
                    break;
                case 'activateEpisode':
                    activateEpisodeSuccessAlert();
                    break;
            }
        }
    }





    /*
    # deleteEpisodeErrorAlert Message
    */
    function deleteEpisodeErrorAlert() {
        swal('Hmmmm', 'This episode does not exist ', 'error');
    }

    /*
    # deleteEpisodeSuccessAlert Message
    */
    function deleteEpisodeSuccessAlert() {
        swal('Deleted!', 'Your episode has been deleted.', 'success');
        var deleted = $('.selected');
        deleted.hide();
    }

    /*
    # activateEpisodeErrorAlert() Message
    */
    function activateEpisodeErrorAlert() {
        swal('Hmmmm', 'This episode does not exist ', 'error');
    }

    function activateEpisodeSuccessAlert() {
        swal('Activated', 'Your episode has been Activated.', 'success');

        var deleted = $('.selected');
        var newItem = $('#active_section');

        newItem.append(item[0]);

        deleted.show();
    }

});


$(document).ready(function() {

    $('.like-btn').click(function () {

        var this_ = $(this);

        var status        = $(this).attr('like-status');
        var likeCount    = $(this).html();
        var favoriteCount = $('#favorite').html();

        if (status === 'like')
        {
            $(this).removeClass('like');
            $(this).addClass('dislike');
            $(this).attr('like-status', 'dislike');

            likeEpisode();

            likeCount = Number(likeCount) + 1;
            favoriteCount = Number(favoriteCount) + 1;

            $(this).text( ' ' + likeCount);
            $('#favorite').html(favoriteCount);
        }

        if (status === 'dislike')
        {
            $(this).removeClass('dislike');
            $(this).addClass('like');
            $(this).attr('like-status', 'like');

            dislikeEpisode(this_);

            likeCount = Number(likeCount) - 1;
            favoriteCount = Number(favoriteCount) - 1;

            $(this).text(' ' + likeCount);
            $('#favorite').html(favoriteCount);

            //check if the string favorites is present in the current url
            if (/favorites/.test(window.location.pathname)) {
                location.reload();
            }
        }

        if (status === 'must_login')
        {
            window.location = '/login';
        }

    });

    /*
    # Like Episode Function
    */
    function likeEpisode()
    {
        var data =
        {
            url             : '/episode/like',
            method          : 'POST',
            parameter       : {
              _token        : document.getElementById('token').value,
              user_id       : document.getElementById('user_id').value,
              episode_id    : document.getElementById('episode_id').value
            }
        };

        ajaxCall(data);
    }

    /*
    # Dislike Episode Function
    */
    function dislikeEpisode(this_)
    {
        var data =
        {
            url             : '/episode/unlike',
            method          : 'POST',
            parameter       : {
              _token        : document.getElementById('token').value,
              user_id       : document.getElementById('user_id').value,
              episode_id    : this_.attr('data-episode-id')
            }
        };

        ajaxCall(data);
    }

    /*
    # Ajax
    */
    function ajaxCall(data)
    {
        $.ajax({
            url     : data.url,
            type    : data.method,
            data    : data.parameter,
            success: function ()
            {
            },
            error: function()
            {
                swal('Are you sure you doing this the right way?');
            },
        });
    }
})
/*
| Script By Emeke Osuagwu @dev_emeka emekaosuagwuandela@gmail.com
| Description LoginAndSigup script in create to handel ajax call
| for Suyabay Login and Register funtionality and also and Email for
| user registeration.
*/


/*
| ajaxLogic
| Process ajaxCall data and return feedback base on the data
| receives 3 parameter from ajaxClass
| @data is the array of user infomation \\console.log(data) to see properties
| @response is the ajax response coming from the api end ponit
| @funtionName is the name of the fuction called
*/
function ajaxLogic(data, response, functionName) {
    if (response.status_code === 401) {
        switch (functionName) {
            case 'login':
                loginErrorAlert();
                break;
            case 'register':
                registerErrorAlert();
                break;
        }
    } else if (response.status_code === 200) {
        switch (functionName) {
            case 'login':
                window.location = '/';
                break;
            case 'register':
                registerSuccessAlert(data);
                break;
        }
    }

}


/*
| ajaxCall
| send an ajax post request to the api end post
| receives 2 parameter from register function or login function
| @data is the array of user infomation \\console.log(data) to see properties
| @funtionName is the name of the fuction called
|*/
function ajaxCall(data, functionName) {
    $('.loader').show();
    $.post(data.url, data.parameter)
        .done(function(response) {
            ajaxLogic(data, response, functionName);
        })
        .fail(function(response) {
            console.log('this action is bad')
        })
}

/*
| loginErrorAlert
| gives error report to user
*/
function loginErrorAlert() {
    $('.loader').hide();
    swal('Oops! Login Failed', 'Username or Password not found!', 'error');
}

/*
| registerSuccessAlert
| gives Success report to user
| receives 1 parameter
*/
function registerSuccessAlert(data) {
    swal({
            title: data.parameter.username +
                ' Your SuyaBay account has been successfully created',
            text: 'Send Email Confirmation',
            type: 'success',
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
        },
        function() {
            setTimeout(function() {
                swal('Email Confirmation sent to ' + data.parameter.email);
            }, 2000);
            clearField();
            window.location = '/';
        });
}

/*
| registerErrorAlert
| gives error report to user
| receives 1 parameter
*/
function registerErrorAlert() {
    $('.loader').hide();
    swal(
        'Oops! Registration Failed',
        'Username or Email already exists click the button to try again!',
        'error'
    );
}

/*
| register
| create user information and url in to an array of object i.e @data
| and make and ajax class to function ajaxCall()
| by sending @data and @functionName
*/
function register() {
    var data = {
        url: '/signup',
        parameter: {
            _token: $('#token').val(),
            email: $('#email').val(),
            username: $('#username').val(),
            password: $('#password').val(),
            facebook: $('#facebook').val(),
            twitter: $('#twitter').val()
        }
    }
    preventFormDefault('.form')
    checkItem(data);
    var functionName = arguments.callee.name;
    ajaxCall(data, functionName);
}


/*
| login
| create user information and url in to an array of object i.e @data
| and make and ajax class to function ajaxCall()
| by sending @data and @functionName
*/
function login() {
    var functionName = arguments.callee.name;
    var data = {
        url: '/login',
        parameter: {
            _token: $('#token').val(),
            username: $('#username').val(),
            password: $('#password').val()
        }
    }
    preventFormDefault('.form');
    ajaxCall(data, functionName);
}

function checkItem(data) {

    if (
        data.parameter.email == '' ||
        data.parameter.username == '' || data.parameter.password == '') {
        swal('Oops!', 'Some required field not set!', 'error');
        end();
    }

    if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(
            data.parameter.email)) {
        swal('Oops!', 'Invalid email', 'error');
        end();
    }
}

/*
| Prevent element Default action
*/
function preventFormDefault(element) {
    $(element).submit(function(e) {
        e.preventDefault();
    });
}

/*
| Clears field
*/
function clearField() {
    $('#email').val('');
    $('#token').val('');
    $('#username').val('');
    $('#password').val('');
}

(function($) {
    $(function() {

        $('.button-collapse').sideNav({
            menuWidth: 300,
            edge: 'left',
            closeOnClick: true
        });

        $('.parallax').parallax();

    });

    // end of document ready

})(jQuery);

// end of jQuery name space

$(document).ready(function() {
    $('.materialboxed').materialbox();
});

/**
 * checkPassword: check if the two password fiedls are thesame
 * @param  {string} password
 * @param  {string} passwordConfirmation
 * @return {boolean}
 */
function checkPassword(password, passwordConfirmation) {
    if (password === passwordConfirmation) {
        return true;
    } else {
        passwordNotError();
    }
}

function passwordNotError() {
    swal('Error', 'Password does not match', 'error');
}

/**
 * passwordLength: check the length of the password
 * @param  {string} password
 * @return {boolean}
 */
function passwordLength(password) {
    if (password.length >= 6) {
        return true;
    } else {
        passwordLengthError();
    }
}

/**
 * passwordLengthError: Error message
 * @return {string} modal
 */
function passwordLengthError() {
    swal('Error', 'Password must be Six characters or more', 'error');
}

/**
 * postSuccess: Recieves the ajax post request
 * @param  {int} response
 * @return {string} modal
 */
function postSuccess(response) {
    if (response == 401) {
        postFailError();
    } else {
        swal({
                title: 'Done',
                text: 'Password updated successfully',
                type: 'success',
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
            },
            function() {
                document.location.href = '/';
            }
        );
    }
}

/**
 * postFailError: Error message
 * @return {string} modal
 */
function postFailError() {
    swal('Error', 'Error Processing request', 'error');
}

/**
 * postAjaxRequest: Sends the ajax post request
 * @param  {string} url
 * @param  {string} parameter
 * @return {string} modal
 */
function postAjaxRequest(url, parameter) {
    $.post(url, parameter)
        .done(function(response) {
            postSuccess(response.status_code);
        })
        .fail(function(response) {
            postFailError();
        });
}

$(document).ready(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name=_token').attr('content')
        }
    });

    //On form submit
    $('#new_password_form').on('submit', function(e) {
        e.preventDefault();
        swal('Proccessing Request!');
        var url = 'password/resetGetEmail';
        var email = $('#email').val();
        var token = $('#token').val();
        var newPassword = $('#password_confirmation').val();
        var oldPassword = $('#password').val();
        var data = {
            url: url,
            parameter: {
                token: token,
                email: email,
                password: oldPassword,
                password_confirmation: newPassword
            }
        }

        //check if password is thesame
        if (checkPassword(oldPassword, newPassword)) {
            //check the stringlength of the password
            if (passwordLength(newPassword)) {
                //process ajax request
                postAjaxRequest(data.url, data.parameter);
            }
        }

        return false;
    });
});

/*
| ajaxLogic
| Process ajaxCall data and return feedback base on the data
| receives 3 parameter from ajaxClass
| @data is the array of user infomation \\console.log(data) to see properties
| @response is the ajax response coming from the api end ponit
| @funtionName is the name of the fuction called
*/
function passwordResetAjaxLogic(data, response, functionName) {
    if (response.status_code == 401) {
        switch (functionName) {
            case 'passwordReset':
                passwordResetErrorAlert();
                break;
        }
    } else if (functionName == 'passwordReset') {
        passwordResetsAlert();
    } else {
        window.location = '/';
    }
}


/*
| ajaxCall
| send an ajax post request to the api end post
| receives 2 parameter from passwordReset function
| @data is the array of user infomation \\console.log(data) to see properties
| @funtionName is the name of the fuction called
|*/
function passwordResetAjaxCall(data, functionName) {
    $.post(data.url, data.parameter)

    .done(function(response) {
            passwordResetAjaxLogic(data, response, functionName);
        })
        .fail(function(response) {
            swal('this action is bad');
        });
}

/*
| passwordResetsAlert
| gives Success report to user
| receives 1 parameter
*/
function passwordResetsAlert() {
    //show modal and redirect
    swal({
            title: 'Done',
            text: 'Password reset link has been sent to your email address',
            type: 'success',
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
        },
        function() {
            document.location.href = '/';
        }
    );
}

/*
| passwordResetErrorAlert
| gives error report to user
| receives 1 parameter
*/
function passwordResetErrorAlert() {
    swal('Ooops!!!', 'Email address does not exit', 'error');
}

/*
| passwordReset
| create user information and url in to an array of object i.e @data
| and make and ajax class to function ajaxCall() by sending @data and @functionName
*/
function passwordReset() {
    var url = '/password/email';
    var email = $('#email').val();
    var token = $('#token').val();

    var data = {
        url: url,
        parameter: {
            _token: token,
            email: email
        }
    }
    var functionName = arguments.callee.name;
    passwordResetAjaxCall(data, functionName);
}

/*
| Process form on form submit
 */
$(document).ready(function() {
    $('#password_reset_form').on('submit', function() {
        swal({
            title: '',
            text: 'Processing request.',
            showConfirmButton: false
        });
        passwordReset();
        return false;
    });
});

$(document).ready(function() {
    $('.fb-share').on('click', function(event) {

        event.preventDefault();

        var desc = $(this).attr('data-desc');
        var name = $(this).attr('data-name');
        var img = $(this).attr('data-img');
        var url = $(this).attr('data-url');

        $.ajaxSetup({
            cache: true
        });

        $.getScript('//connect.facebook.net/en_US/sdk.js', function() {
            window.FB.init({
                appId: '1691359924434970',
                version: 'v2.5'
            });
            window.FB.ui({
                method: 'share',
                display: 'popup',
                href: url,
                caption: name,
                description: desc,
                picture: img
            });
        });
    });

    $('.twtr-share').on('click', function(event) {

        event.preventDefault();

        var desc = $(this).attr('data-desc').trim();
        var url = $(this).attr('data-url');

        if (desc.length >= 75) {
            desc = desc.substr(0, 75) + '.. ';
        }

        var baseUrl = 'https://twitter.com/intent/tweet?text=';
        desc = encodeURIComponent(desc);
        var link = '&url=' + url + '&hashtags=suyabay';

        window.open(baseUrl + desc + link, '_blank');
    });
});

//# sourceMappingURL=scripts.js.map
function confirmDelete(e,t,a,n){swal({title:"Confirm Delete",text:"This Channel has Episodes, deleting it implies deleting all the Episodes under it. Are you sure you want to do this?",type:"info",showCancelButton:!0,confirmButtonColor:"#009688",confirmButtonText:"Yes, please!",cancelButtonText:"Cancel",allowOutsideClick:!0,closeOnConfirm:!1,closeOnCancel:!1,animation:!0,showLoaderOnConfirm:!0},function(e){e?document.location.href="/dashboard/channel/swap/"+a:document.location.href="/dashboard/channels/all"})}function confirmUpdate(e,t,a,n){swal({title:"Success!",text:n,timer:1500,showConfirmButton:!1})}function channelSuccessMessage(e){swal({title:"Done!",text:e,type:"success",showCancelButton:!1,closeOnConfirm:!1,showLoaderOnConfirm:!0},function(){document.location.href="/dashboard/channels/all"})}function userSuccessMessage(e){swal({title:"Done!",text:e,type:"success",showCancelButton:!1,closeOnConfirm:!1,showLoaderOnConfirm:!0},function(){document.location.href="/dashboard/users"})}function cancelDeleteMessage(e){document.location.href="/dashboard/channels/all"}function errorMessage(e){swal("Error",e,"error")}function processAjax(e,t,a,n){$.ajax({url:t,type:e,data:a,success:function(e){switch(e.status_code){case 200:return channelSuccessMessage(e.message);case 201:return userSuccessMessage(e.message);default:errorMessage(e.message)}}})}function processEpisodeUpdate(e,t,a,n){$.ajax({url:t,type:e,data:a,success:function(e){switch(e.status_code){case 200:return successMessage(e.message);default:errorMessage(e.message)}}})}function successMessage(e){swal("Good job!","Episode succesfuly updated!","success"),document.location.href="/dashboard/episodes"}function ajaxLogic(e,t,a){if(401===t.status_code)switch(a){case"login":loginErrorAlert();break;case"register":registerErrorAlert()}else if(200===t.status_code)switch(a){case"login":window.location="/";break;case"register":registerSuccessAlert(e)}}function ajaxCall(e,t){$(".loader").show(),$.post(e.url,e.parameter).done(function(a){ajaxLogic(e,a,t)}).fail(function(e){console.log("this action is bad")})}function loginErrorAlert(){$(".loader").hide(),swal("Oops! Login Failed","Username or Password not found!","error")}function registerSuccessAlert(e){swal({title:e.parameter.username+" Your SuyaBay account has been successfully created",text:"Send Email Confirmation",type:"success",showCancelButton:!0,closeOnConfirm:!1,showLoaderOnConfirm:!0},function(){setTimeout(function(){swal("Email Confirmation sent to "+e.parameter.email)},2e3),clearField(),window.location="/"})}function registerErrorAlert(){$(".loader").hide(),swal("Oops! Registration Failed","Username or Email already exists click the button to try again!","error")}function register(){var e={url:"/signup",parameter:{_token:$("#token").val(),email:$("#email").val(),username:$("#username").val(),password:$("#password").val(),facebook:$("#facebook").val(),twitter:$("#twitter").val()}};preventFormDefault(".form"),checkItem(e);var t=arguments.callee.name;ajaxCall(e,t)}function login(){var e=arguments.callee.name,t={url:"/login",parameter:{_token:$("#token").val(),username:$("#username").val(),password:$("#password").val()}};preventFormDefault(".form"),ajaxCall(t,e)}function checkItem(e){""!=e.parameter.email&&""!=e.parameter.username&&""!=e.parameter.password||(swal("Oops!","Some required field not set!","error"),end()),/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(e.parameter.email)||(swal("Oops!","Invalid email","error"),end())}function preventFormDefault(e){$(e).submit(function(e){e.preventDefault()})}function clearField(){$("#email").val(""),$("#token").val(""),$("#username").val(""),$("#password").val("")}function checkPassword(e,t){return e===t?!0:void passwordNotError()}function passwordNotError(){swal("Error","Password does not match","error")}function passwordLength(e){return e.length>=6?!0:void passwordLengthError()}function passwordLengthError(){swal("Error","Password must be Six characters or more","error")}function postSuccess(e){401==e?postFailError():swal({title:"Done",text:"Password updated successfully",type:"success",showCancelButton:!0,closeOnConfirm:!1,showLoaderOnConfirm:!0},function(){document.location.href="/"})}function postFailError(){swal("Error","Error Processing request","error")}function postAjaxRequest(e,t){$.post(e,t).done(function(e){postSuccess(e.status_code)}).fail(function(e){postFailError()})}function passwordResetAjaxLogic(e,t,a){if(401==t.status_code)switch(a){case"passwordReset":passwordResetErrorAlert()}else"passwordReset"==a?passwordResetsAlert():window.location="/"}function passwordResetAjaxCall(e,t){$.post(e.url,e.parameter).done(function(a){passwordResetAjaxLogic(e,a,t)}).fail(function(e){swal("this action is bad")})}function passwordResetsAlert(){swal({title:"Done",text:"Password reset link has been sent to your email address",type:"success",showCancelButton:!0,closeOnConfirm:!1,showLoaderOnConfirm:!0},function(){document.location.href="/"})}function passwordResetErrorAlert(){swal("Ooops!!!","Email address does not exit","error")}function passwordReset(){var e="/password/email",t=$("#email").val(),a=$("#token").val(),n={url:e,parameter:{_token:a,email:t}},s=arguments.callee.name;passwordResetAjaxCall(n,s)}$(document).ready(function(){$("#delete_channel",this).on("click",function(){var e=$(this).data("id"),t="/dashboard/channel/"+e,a={url:t,parameter:{_token:$(this).data("token"),channel_id:e,channel_name:$(this).data("name")}};return processAjax("DELETE",a.url,a.parameter,a.parameter.channel_name),!1}),$("#swap_episode_delete_channel",this).on("click",function(){var e=$(this).data("id"),t="/dashboard/channel/"+e,a={url:t,parameter:{_token:$(this).data("token"),channel_id:e,channel_name:$(this).data("name"),episodes:$(this).data("episoes")}};return confirmDelete(a.url,a.parameter,a.parameter.channel_id,a.parameter.channel_name),!1}),$("#swap_episodes").submit(function(){var e="/dashboard/channel/swap/"+id,t={parameter:{_token:$("#token").val(),channel_id:$("#channel_id").val(),new_channel_id:$("#new_channel_id").val()}};return processAjax("POST",e,t.parameter,t.parameter.new_channel_id),!1}),$("#channel_update").submit(function(e){e.preventDefault();var t=$("#channel_name").val().trim(),a=$("#channel_description").val().trim();if(0!=t.length&&a.length){var n={url:"/dashboard/channel/edit",parameter:{_token:$("#token").val(),channel_id:$("#channel_id").val(),channel_name:t,channel_description:a}};processAjax("PUT",n.url,n.parameter,n.parameter.channel_name)}else swal({title:"Error!",text:"Please provide both a channel name and description",type:"error",showCancelButton:!1,closeOnConfirm:!1,showLoaderOnConfirm:!0});return!1}),$("#episode_update").submit(function(){var e={url:"/dashboard/episode/edit",parameter:{_token:$("#token").val(),episode_id:$("#episode_id").val(),episode:$("#episode").val(),channel_id:$("#channel_id").val(),description:$("#description").val()}};return processEpisodeUpdate("PUT",e.url,e.parameter,e.parameter.episode),!1}),$("#create_user").submit(function(){var e="/dashboard/user/create",t=$("#_token").val(),a=$("#username").val().trim();if(0===a.length)return swal({title:"Error!",text:"Please provide a username",type:"error",showCancelButton:!1,closeOnConfirm:!0,showLoaderOnConfirm:!0}),!1;var n=$("#user_role").val(),s={url:e,parameter:{_token:t,username:a,user_role:n}};return processAjax("POST",s.url,s.parameter,s.parameter.username),!1}),$("#edit_user").submit(function(){var e={url:"/dashboard/user/edit",parameter:{_token:$("#_token").val(),user_id:$("#user_id").val(),username:$("#username").val(),user_role:$("#user_role").val()}};return processAjax("PUT",e.url,e.parameter,e.parameter.username),!1})}),function(e,t,a){var n=function(){for(var e=/audio(.min)?.js.*/,t=document.getElementsByTagName("script"),a=0,n=t.length;n>a;a++){var s=t[a].getAttribute("src");if(e.test(s))return s.replace(e,"")}}();a[e]={instanceCount:0,instances:{},flashSource:'      <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" id="$1" width="1" height="1" name="$1" style="position: absolute; left: -1px;">         <param name="movie" value="$2?playerInstance='+e+'.instances[\'$1\']&datetime=$3">         <param name="allowscriptaccess" value="always">         <embed name="$1" src="$2?playerInstance='+e+'.instances[\'$1\']&datetime=$3" width="1" height="1" allowscriptaccess="always">       </object>',settings:{autoplay:!1,loop:!1,preload:!0,imageLocation:n+"player-graphics.gif",swfLocation:n+"audiojs.swf",useFlash:function(){var e=document.createElement("audio");return!(e.canPlayType&&e.canPlayType("audio/mpeg;").replace(/no/,""))}(),hasFlash:function(){if(navigator.plugins&&navigator.plugins.length&&navigator.plugins["Shockwave Flash"])return!0;if(navigator.mimeTypes&&navigator.mimeTypes.length){var e=navigator.mimeTypes["application/x-shockwave-flash"];return e&&e.enabledPlugin}try{return new ActiveXObject("ShockwaveFlash.ShockwaveFlash"),!0}catch(t){}return!1}(),createPlayer:{markup:'          <div class="play-pause">             <p class="play"></p>             <p class="pause"></p>             <p class="loading"></p>             <p class="error"></p>           </div>           <div class="scrubber">             <div class="progress"></div>             <div class="loaded"></div>           </div>           <div class="time">             <em class="played">00:00</em>/<strong class="duration">00:00</strong>           </div>           <div class="error-message"></div>',playPauseClass:"play-pause",scrubberClass:"scrubber",progressClass:"progress",loaderClass:"loaded",timeClass:"time",durationClass:"duration",playedClass:"played",errorMessageClass:"error-message",playingClass:"playing",loadingClass:"loading",errorClass:"error"},css:'        .audiojs audio { position: absolute; left: -1px; }         .audiojs { width: 460px; height: 36px; background: #404040; overflow: hidden; font-family: monospace; font-size: 12px;           background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0, #444), color-stop(0.5, #555), color-stop(0.51, #444), color-stop(1, #444));           background-image: -moz-linear-gradient(center top, #444 0%, #555 50%, #444 51%, #444 100%);           -webkit-box-shadow: 1px 1px 8px rgba(0, 0, 0, 0.3); -moz-box-shadow: 1px 1px 8px rgba(0, 0, 0, 0.3);           -o-box-shadow: 1px 1px 8px rgba(0, 0, 0, 0.3); box-shadow: 1px 1px 8px rgba(0, 0, 0, 0.3); }         .audiojs .play-pause { width: 25px; height: 40px; padding: 4px 6px; margin: 0px; float: left; overflow: hidden; border-right: 1px solid #000; }         .audiojs p { display: none; width: 25px; height: 40px; margin: 0px; cursor: pointer; }         .audiojs .play { display: block; }         .audiojs .scrubber { position: relative; float: left; width: 280px; background: #5a5a5a; height: 14px; margin: 10px; border-top: 1px solid #3f3f3f; border-left: 0px; border-bottom: 0px; overflow: hidden; }         .audiojs .progress { position: absolute; top: 0px; left: 0px; height: 14px; width: 0px; background: #ccc; z-index: 1;           background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0, #ccc), color-stop(0.5, #ddd), color-stop(0.51, #ccc), color-stop(1, #ccc));           background-image: -moz-linear-gradient(center top, #ccc 0%, #ddd 50%, #ccc 51%, #ccc 100%); }         .audiojs .loaded { position: absolute; top: 0px; left: 0px; height: 14px; width: 0px; background: #000;           background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0, #222), color-stop(0.5, #333), color-stop(0.51, #222), color-stop(1, #222));           background-image: -moz-linear-gradient(center top, #222 0%, #333 50%, #222 51%, #222 100%); }         .audiojs .time { float: left; height: 36px; line-height: 36px; margin: 0px 0px 0px 6px; padding: 0px 6px 0px 12px; border-left: 1px solid #000; color: #ddd; text-shadow: 1px 1px 0px rgba(0, 0, 0, 0.5); }         .audiojs .time em { padding: 0px 2px 0px 0px; color: #f9f9f9; font-style: normal; }         .audiojs .time strong { padding: 0px 0px 0px 2px; font-weight: normal; }         .audiojs .error-message { float: left; display: none; margin: 0px 10px; height: 36px; width: 400px; overflow: hidden; line-height: 36px; white-space: nowrap; color: #fff;           text-overflow: ellipsis; -o-text-overflow: ellipsis; -icab-text-overflow: ellipsis; -khtml-text-overflow: ellipsis; -moz-text-overflow: ellipsis; -webkit-text-overflow: ellipsis; }         .audiojs .error-message a { color: #eee; text-decoration: none; padding-bottom: 1px; border-bottom: 1px solid #999; white-space: wrap; }                 .audiojs .play { background: url("$1") -2px -1px no-repeat; }         .audiojs .loading { background: url("$1") -2px -31px no-repeat; }         .audiojs .error { background: url("$1") -2px -61px no-repeat; }         .audiojs .pause { background: url("$1") -2px -91px no-repeat; }                 .playing .play, .playing .loading, .playing .error { display: none; }         .playing .pause { display: block; }                 .loading .play, .loading .pause, .loading .error { display: none; }         .loading .loading { display: block; }                 .error .time, .error .play, .error .pause, .error .scrubber, .error .loading { display: none; }         .error .error { display: block; }         .error .play-pause p { cursor: auto; }         .error .error-message { display: block; }',trackEnded:function(){},flashError:function(){var t=this.settings.createPlayer,n=s(t.errorMessageClass,this.wrapper),o='Missing <a href="http://get.adobe.com/flashplayer/">flash player</a> plugin.';this.mp3&&(o+=' <a href="'+this.mp3+'">Download audio file</a>.'),a[e].helpers.removeClass(this.wrapper,t.loadingClass),a[e].helpers.addClass(this.wrapper,t.errorClass),n.innerHTML=o},loadError:function(){var t=this.settings.createPlayer,n=s(t.errorMessageClass,this.wrapper);a[e].helpers.removeClass(this.wrapper,t.loadingClass),a[e].helpers.addClass(this.wrapper,t.errorClass),n.innerHTML='Error loading: "'+this.mp3+'"'},init:function(){a[e].helpers.addClass(this.wrapper,this.settings.createPlayer.loadingClass)},loadStarted:function(){var t=this.settings.createPlayer,n=s(t.durationClass,this.wrapper),o=Math.floor(this.duration/60),r=Math.floor(this.duration%60);a[e].helpers.removeClass(this.wrapper,t.loadingClass),n.innerHTML=(10>o?"0":"")+o+":"+(10>r?"0":"")+r},loadProgress:function(e){var t=this.settings.createPlayer,a=s(t.scrubberClass,this.wrapper);s(t.loaderClass,this.wrapper).style.width=a.offsetWidth*e+"px"},playPause:function(){this.playing?this.settings.play():this.settings.pause()},play:function(){a[e].helpers.addClass(this.wrapper,this.settings.createPlayer.playingClass)},pause:function(){a[e].helpers.removeClass(this.wrapper,this.settings.createPlayer.playingClass)},updatePlayhead:function(e){var t=this.settings.createPlayer,a=s(t.scrubberClass,this.wrapper);s(t.progressClass,this.wrapper).style.width=a.offsetWidth*e+"px",t=s(t.playedClass,this.wrapper),a=this.duration*e,e=Math.floor(a/60),a=Math.floor(a%60),t.innerHTML=(10>e?"0":"")+e+":"+(10>a?"0":"")+a}},create:function(e,t){return t=t||{},e.length?this.createAll(t,e):this.newInstance(e,t)},createAll:function(e,t){var a=t||document.getElementsByTagName("audio"),n=[];e=e||{};for(var s=0,o=a.length;o>s;s++)n.push(this.newInstance(a[s],e));return n},newInstance:function(e,n){var s=this.helpers.clone(this.settings),o="audiojs"+this.instanceCount,r="audiojs_wrapper"+this.instanceCount;return this.instanceCount++,null!=e.getAttribute("autoplay")&&(s.autoplay=!0),null!=e.getAttribute("loop")&&(s.loop=!0),"none"==e.getAttribute("preload")&&(s.preload=!1),n&&this.helpers.merge(s,n),s.createPlayer.markup?e=this.createPlayer(e,s.createPlayer,r):e.parentNode.setAttribute("id",r),r=new a[t](e,s),s.css&&this.helpers.injectCss(r,s.css),s.useFlash&&s.hasFlash?(this.injectFlash(r,o),this.attachFlashEvents(r.wrapper,r)):s.useFlash&&!s.hasFlash&&this.settings.flashError.apply(r),(!s.useFlash||s.useFlash&&s.hasFlash)&&this.attachEvents(r.wrapper,r),this.instances[o]=r},createPlayer:function(e,t,a){var n=document.createElement("div"),s=e.cloneNode(!0);return n.setAttribute("class","audiojs"),n.setAttribute("className","audiojs"),n.setAttribute("id",a),s.outerHTML&&!document.createElement("audio").canPlayType?(s=this.helpers.cloneHtml5Node(e),n.innerHTML=t.markup,n.appendChild(s),e.outerHTML=n.outerHTML,n=document.getElementById(a)):(n.appendChild(s),n.innerHTML+=t.markup,e.parentNode.replaceChild(n,e)),n.getElementsByTagName("audio")[0]},attachEvents:function(t,n){if(n.settings.createPlayer){var o=n.settings.createPlayer,r=s(o.playPauseClass,t),i=s(o.scrubberClass,t);a[e].events.addListener(r,"click",function(){n.playPause.apply(n)}),a[e].events.addListener(i,"click",function(e){e=e.clientX;var t=this,a=0;if(t.offsetParent)do a+=t.offsetLeft;while(t=t.offsetParent);n.skipTo((e-a)/i.offsetWidth)}),n.settings.useFlash||(a[e].events.trackLoadProgress(n),a[e].events.addListener(n.element,"timeupdate",function(){n.updatePlayhead.apply(n)}),a[e].events.addListener(n.element,"ended",function(){n.trackEnded.apply(n)}),a[e].events.addListener(n.source,"error",function(){clearInterval(n.readyTimer),clearInterval(n.loadTimer),n.settings.loadError.apply(n)}))}},attachFlashEvents:function(e,t){t.swfReady=!1,t.load=function(e){t.mp3=e,t.swfReady&&t.element.load(e)},t.loadProgress=function(e,a){t.loadedPercent=e,t.duration=a,t.settings.loadStarted.apply(t),t.settings.loadProgress.apply(t,[e])},t.skipTo=function(e){e>t.loadedPercent||(t.updatePlayhead.call(t,[e]),t.element.skipTo(e))},t.updatePlayhead=function(e){t.settings.updatePlayhead.apply(t,[e])},t.play=function(){t.settings.preload||(t.settings.preload=!0,t.element.init(t.mp3)),t.playing=!0,t.element.pplay(),t.settings.play.apply(t)},t.pause=function(){t.playing=!1,t.element.ppause(),t.settings.pause.apply(t)},t.setVolume=function(e){t.element.setVolume(e)},t.loadStarted=function(){t.swfReady=!0,t.settings.preload&&t.element.init(t.mp3),t.settings.autoplay&&t.play.apply(t)}},injectFlash:function(e,t){var a=this.flashSource.replace(/\$1/g,t);a=a.replace(/\$2/g,e.settings.swfLocation),a=a.replace(/\$3/g,+new Date+Math.random());var n=e.wrapper.innerHTML,s=document.createElement("div");s.innerHTML=a+n,e.wrapper.innerHTML=s.innerHTML,e.element=this.helpers.getSwf(t)},helpers:{merge:function(e,t){for(attr in t)(e.hasOwnProperty(attr)||t.hasOwnProperty(attr))&&(e[attr]=t[attr])},clone:function(e){if(null==e||"object"!=typeof e)return e;var t,a=new e.constructor;for(t in e)a[t]=arguments.callee(e[t]);return a},addClass:function(e,t){RegExp("(\\s|^)"+t+"(\\s|$)").test(e.className)||(e.className+=" "+t)},removeClass:function(e,t){e.className=e.className.replace(RegExp("(\\s|^)"+t+"(\\s|$)")," ")},injectCss:function(e,t){for(var a="",n=document.getElementsByTagName("style"),s=t.replace(/\$1/g,e.settings.imageLocation),o=0,r=n.length;r>o;o++){var i=n[o].getAttribute("title");if(i&&~i.indexOf("audiojs")){if(r=n[o],r.innerHTML===s)return;a=r.innerHTML;break}}n=document.getElementsByTagName("head")[0],o=n.firstChild,r=document.createElement("style"),n&&(r.setAttribute("type","text/css"),r.setAttribute("title","audiojs"),r.styleSheet?r.styleSheet.cssText=a+s:r.appendChild(document.createTextNode(a+s)),o?n.insertBefore(r,o):n.appendChild(styleElement))},cloneHtml5Node:function(e){var t=document.createDocumentFragment(),a=t.createElement?t:document;return a.createElement("audio"),a=a.createElement("div"),t.appendChild(a),a.innerHTML=e.outerHTML,a.firstChild},getSwf:function(e){return e=document[e]||window[e],e.length>1?e[e.length-1]:e}},events:{memoryLeaking:!1,listeners:[],addListener:function(t,n,s){t.addEventListener?t.addEventListener(n,s,!1):t.attachEvent&&(this.listeners.push(t),this.memoryLeaking||(window.attachEvent("onunload",function(){if(this.listeners)for(var t=0,n=this.listeners.length;n>t;t++)a[e].events.purge(this.listeners[t])}),this.memoryLeaking=!0),t.attachEvent("on"+n,function(){s.call(t,window.event)}))},trackLoadProgress:function(e){if(e.settings.preload){var t,a;e=e;var n=/(ipod|iphone|ipad)/i.test(navigator.userAgent);t=setInterval(function(){e.element.readyState>-1&&(n||e.init.apply(e)),e.element.readyState>1&&(e.settings.autoplay&&e.play.apply(e),clearInterval(t),a=setInterval(function(){e.loadProgress.apply(e),e.loadedPercent>=1&&clearInterval(a)}))},10),e.readyTimer=t,e.loadTimer=a}},purge:function(e){var t,a=e.attributes;if(a)for(t=0;t<a.length;t+=1)"function"==typeof e[a[t].name]&&(e[a[t].name]=null);if(a=e.childNodes)for(t=0;t<a.length;t+=1)purge(e.childNodes[t])},ready:function(){return function(e){var t=window,a=!1,n=!0,s=t.document,o=s.documentElement,r=s.addEventListener?"addEventListener":"attachEvent",i=s.addEventListener?"removeEventListener":"detachEvent",l=s.addEventListener?"":"on",d=function(n){"readystatechange"==n.type&&"complete"!=s.readyState||(("load"==n.type?t:s)[i](l+n.type,d,!1),!a&&(a=!0)&&e.call(t,n.type||n))},c=function(){try{o.doScroll("left")}catch(e){return void setTimeout(c,50)}d("poll")};if("complete"==s.readyState)e.call(t,"lazy");else{if(s.createEventObject&&o.doScroll){try{n=!t.frameElement}catch(u){}n&&c()}s[r](l+"DOMContentLoaded",d,!1),s[r](l+"readystatechange",d,!1),t[r](l+"load",d,!1)}}}()}},a[t]=function(e,t){this.element=e,this.wrapper=e.parentNode,this.source=e.getElementsByTagName("source")[0]||e,this.mp3=function(e){var t=e.getElementsByTagName("source")[0];return e.getAttribute("src")||(t?t.getAttribute("src"):null)}(e),this.settings=t,this.loadStartedCalled=!1,this.loadedPercent=0,this.duration=1,this.playing=!1},a[t].prototype={updatePlayhead:function(){this.settings.updatePlayhead.apply(this,[this.element.currentTime/this.duration])},skipTo:function(e){e>this.loadedPercent||(this.element.currentTime=this.duration*e,this.updatePlayhead())},load:function(t){this.loadStartedCalled=!1,this.source.setAttribute("src",t),this.element.load(),this.mp3=t,a[e].events.trackLoadProgress(this)},loadError:function(){this.settings.loadError.apply(this)},init:function(){this.settings.init.apply(this)},loadStarted:function(){return this.element.duration?(this.duration=this.element.duration,this.updatePlayhead(),void this.settings.loadStarted.apply(this)):!1},loadProgress:function(){null!=this.element.buffered&&this.element.buffered.length&&(this.loadStartedCalled||(this.loadStartedCalled=this.loadStarted()),this.loadedPercent=this.element.buffered.end(this.element.buffered.length-1)/this.duration,this.settings.loadProgress.apply(this,[this.loadedPercent]))},playPause:function(){this.playing?this.pause():this.play()},play:function(){/(ipod|iphone|ipad)/i.test(navigator.userAgent)&&0==this.element.readyState&&this.init.apply(this),this.settings.preload||(this.settings.preload=!0,this.element.setAttribute("preload","auto"),a[e].events.trackLoadProgress(this)),this.playing=!0,this.element.play(),this.settings.play.apply(this)},pause:function(){this.playing=!1,this.element.pause(),this.settings.pause.apply(this)},setVolume:function(e){this.element.volume=e},trackEnded:function(){this.skipTo.apply(this,[0]),this.settings.loop||this.pause.apply(this),this.settings.trackEnded.apply(this)}};var s=function(e,t){var a=[];if(t=t||document,t.getElementsByClassName)a=t.getElementsByClassName(e);else{var n,s,o=t.getElementsByTagName("*"),r=RegExp("(^|\\s)"+e+"(\\s|$)");for(n=0,s=o.length;s>n;n++)r.test(o[n].className)&&a.push(o[n])}return a.length>1?a:a[0]}}("audiojs","audiojsInstance",this),function(e,t,a,n){var s="ontouchstart"in t,o=s?"touchstart":"mousedown",r=s?"touchmove":"mousemove",i=s?"touchcancel":"mouseup",l=function(e){var t=e/3600,a=Math.floor(t),n=e%3600/60,s=Math.floor(n),o=Math.ceil(e%3600%60);return o>59&&(o=0,s=Math.ceil(n)),s>59&&(s=0,a=Math.ceil(t)),(0==a?"":a>0&&a.toString().length<2?"0"+a+":":a+":")+(s.toString().length<2?"0"+s:s)+":"+(o.toString().length<2?"0"+o:o)},d=function(e){var t=a.createElement("audio");return!(!t.canPlayType||!t.canPlayType("audio/"+e.split(".").pop().toLowerCase()+";").replace(/no/,""))};e.fn.audioPlayer=function(t){var t=e.extend({classPrefix:"audioplayer",strPlay:"Play",strPause:"Pause",strVolume:"Volume"},t),a={},n={playPause:"playpause",playing:"playing",stopped:"stopped",time:"time",timeCurrent:"time-current",timeDuration:"time-duration",bar:"bar",barLoaded:"bar-loaded",barPlayed:"bar-played",volume:"volume",volumeButton:"volume-button",volumeAdjust:"volume-adjust",noVolume:"novolume",muted:"muted",mini:"mini"};for(var c in n)a[c]=t.classPrefix+"-"+n[c];return this.each(function(){if("audio"!=e(this).prop("tagName").toLowerCase())return!1;var n=e(this),c=n.attr("src"),u=n.get(0).getAttribute("autoplay"),u=""===u||"autoplay"===u,p=n.get(0).getAttribute("loop"),p=""===p||"loop"===p,m=!1;"undefined"==typeof c?n.find("source").each(function(){return c=e(this).attr("src"),"undefined"!=typeof c&&d(c)?(m=!0,!1):void 0}):d(c)&&(m=!0);var h=e('<div class="'+t.classPrefix+'">'+(m?e("<div>").append(n.eq(0).clone()).html():'<embed src="'+c+'" width="0" height="0" volume="100" autostart="'+u.toString()+'" loop="'+p.toString()+'" />')+'<div class="'+a.playPause+'" title="'+t.strPlay+'"><a href="#">'+t.strPlay+"</a></div></div>"),f=m?h.find("audio"):h.find("embed"),f=f.get(0);if(m){h.find("audio").css({width:0,height:0,visibility:"hidden"}),h.append('<div class="'+a.time+" "+a.timeCurrent+'"></div><div class="'+a.bar+'"><div class="'+a.barLoaded+'"></div><div class="'+a.barPlayed+'"></div></div><div class="'+a.time+" "+a.timeDuration+'"></div><div class="'+a.volume+'"><div class="'+a.volumeButton+'" title="'+t.strVolume+'"><a href="#">'+t.strVolume+'</a></div><div class="'+a.volumeAdjust+'"><div><div></div></div></div></div>');var v=h.find("."+a.bar),g=h.find("."+a.barPlayed),y=h.find("."+a.barLoaded),w=h.find("."+a.timeCurrent),b=h.find("."+a.timeDuration),x=h.find("."+a.volumeButton),$=h.find("."+a.volumeAdjust+" > div"),C=0,k=function(e){theRealEvent=s?e.originalEvent.touches[0]:e,f.currentTime=Math.round(f.duration*(theRealEvent.pageX-v.offset().left)/v.width())},E=function(e){theRealEvent=s?e.originalEvent.touches[0]:e,f.volume=Math.abs((theRealEvent.pageY-($.offset().top+$.height()))/$.height())},_=function(){var e=setInterval(function(){return f.buffered.length<1?!0:(y.width(f.buffered.end(0)/f.duration*100+"%"),void(Math.floor(f.buffered.end(0))>=Math.floor(f.duration)&&clearInterval(e)))},100)},P=f.volume,T=f.volume=.111;Math.round(1e3*f.volume)/1e3==T?f.volume=P:h.addClass(a.noVolume),b.html("&hellip;"),w.html(l(0)),f.addEventListener("loadeddata",function(){_(),b.html(e.isNumeric(f.duration)?l(f.duration):"&hellip;"),$.find("div").height(100*f.volume+"%"),C=f.volume}),f.addEventListener("timeupdate",function(){w.html(l(f.currentTime)),g.width(f.currentTime/f.duration*100+"%")}),f.addEventListener("volumechange",function(){$.find("div").height(100*f.volume+"%"),f.volume>0&&h.hasClass(a.muted)&&h.removeClass(a.muted),f.volume<=0&&!h.hasClass(a.muted)&&h.addClass(a.muted)}),f.addEventListener("ended",function(){h.removeClass(a.playing).addClass(a.stopped)}),v.on(o,function(e){k(e),v.on(r,function(e){k(e)})}).on(i,function(){v.unbind(r)}),x.on("click",function(){return h.hasClass(a.muted)?(h.removeClass(a.muted),f.volume=C):(h.addClass(a.muted),C=f.volume,f.volume=0),!1}),$.on(o,function(e){E(e),$.on(r,function(e){E(e)})}).on(i,function(){$.unbind(r)})}else h.addClass(a.mini);h.addClass(u?a.playing:a.stopped),h.find("."+a.playPause).on("click",function(){return h.hasClass(a.playing)?(e(this).attr("title",t.strPlay).find("a").html(t.strPlay),h.removeClass(a.playing).addClass(a.stopped),m?f.pause():f.Stop()):(e(this).attr("title",t.strPause).find("a").html(t.strPause),h.addClass(a.playing).removeClass(a.stopped),m?f.play():f.Play()),!1}),n.replaceWith(h)}),this}}(jQuery,window,document),$(document).ready(function(){$(".view_more_comments").on("click",function(){var e=$(this).data("avatar"),t=$(".load_comment").find("div#show_comment"),a=$("#episode_id").val();try{$.ajax({url:"/comment",type:"GET",data:{offset:t.size(),episode_id:a},success:function(a){for(i=0;i<a.comments.length;i++){var n=a.comments[i];$("#comment-count").html(" "+t.size());var s='<div id="show_comment" class="collection-item avatar show_comment">';s+='<div class="row">',s+='<div class="col s2">',s+='<img src="'+e+'" alt="" class="circle">',s+="</div>",s+='<div class="col s10">',s+='<div class="textarea-wrapper" ',s+='data-comment-id="'+n.id+'">',s+="<span>"+n.comments+"</span>",s+='<div class="update-actions pull-right">',s+='<a href="#" id="comment_action_caret" class="fa fa-bars no-style-link"></a>',s+='<div id="comment_actions" style="display:none">',s+='<a href="#" class="fa fa-pencil comment-action-edit no-style-link" ',s+='data-commentId="'+n.id+'"></a>',s+='<a href="#" class="fa fa-trash comment-action-delete no-style-link" ',s+='data-commentId="'+n.id+'"></a>',s+="</div>",s+="</div>",s+="</div></div></div></div>",$(".load_comment").last().append(s),$("#new-comment-field").val("")}}})}catch(n){console.log(n)}return!1}),$(".comment-submit").on("click",function(){var e=$("#new-comment-field").val(),t=$(this).data("avatar"),a=(parseInt($(this).data("comment-count"))+1,$(this).data("token")),n="/comment",s=($("#user_id").val(),$("#episode_id").val()),o={parameter:{_token:a,episode_id:s,comment:e}};return e.length>0&&$.ajax({url:n,type:"POST",data:o.parameter,success:function(a){switch(a.status_code){case 200:var n='<div id="show_comment" class="collection-item avatar show_comment">';n+='<div class="row">',n+='<div class="col s2">',n+='<img src="'+t+'" alt="" class="circle">',n+="</div>",n+='<div class="col s10">',n+='<div class="textarea-wrapper" ',n+='data-comment-id="'+a.commentId+'">',n+="<span>"+e+"</span>",n+='<div class="update-actions pull-right">',n+='<a href="#" id="comment_action_caret" class="fa fa-bars no-style-link"></a>',n+='<div id="comment_actions" style="display:none">',n+='<a href="#" class="fa fa-pencil comment-action-edit no-style-link" ',n+='data-commentId="'+a.commentId+'"></a>',n+='<a href="#" class="fa fa-trash comment-action-delete no-style-link" ',n+='data-commentId="'+a.commentId+'"></a>',n+="</div>",n+="</div>",n+="</div></div></div></div>",$(".load_comment").last().append(n);var s=$("#comment-count").html();s=Number(s)+1,$("#comment-count").html(s),$("#new-comment-field").val("");break;default:return!1}}}),!1})}),$(document).ready(function(){$(".load_comment").on("click","a#comment_action_caret",function(e){e.preventDefault(),$(".textarea-wrapper #comment_actions").not($(this).next()).hide("slow"),$(this).next().toggle("slow")}),$(".load_comment").on("click","#comment_actions a.comment-action-delete",function(e){e.preventDefault();var t=$(this),a=$(".load_comment").attr("data-token"),n=t.attr("data-commentId");swal({title:"Are you sure?",text:"You will not be able to recover a deleted comment",type:"warning",showCancelButton:!0,confirmButtonColor:"#DD6B55",confirmButtonText:"Yes, delete it!",closeOnConfirm:!0},function(){var e=$.ajax({method:"DELETE",url:"/comment/"+n,data:{_token:a}});e.done(function(){t.parent().parent().parent().parent().parent().parent().remove()});var s=$("#comment-count").html();s=Number(s)-1,$("#comment-count").html(s),e.fail(function(){swal("Error Deleting","Error deleting your comment. please try again","error")})})}),$(".load_comment").on("click","#comment_actions a.comment-action-edit",function(e){e.preventDefault();var t=$(this).parent().parent().parent(),a=t.find("span:first"),n=a.text().trim();t.find(".update-actions").hide("slow",function(){var e='<div class="file-field input-field">';e+='<div class="file-path-wrapper input-field ',e+='col s10 m10">',e+='<input name="comment" id="comment-field" ',e+='type="text" style="margin-left:20px;" ',e+='class="validate" value="'+n+'"/>',e+="</div>",e+="</div>",a.replaceWith(e)})}),$(".load_comment").on("keypress","#comment-field",function(e){if(13==e.which){var t=$(this),a=t.val().trim(),n=t.parent().parent().parent().attr("data-comment-id"),s=$(".load_comment").attr("data-token");
if(0===a.length||0===n.length||0===s.length)swal("Error Updating","Something is missing in your comment. Please try again","error");else{var o=$.ajax({method:"PUT",url:"/comment/"+n+"/edit",data:{_token:s,comment:a}});o.done(function(){swal({title:"Updated!",text:"Comment successfully updated",type:"success"},function(){location.reload()})}),o.fail(function(){swal("Error Updating","Error updating your comment. Please try again","error")})}}})}),$(document).ready(function(){function e(e){var t="/dashboard/episode/delete",n=document.getElementById("token").value,s="DELETE",o=arguments.callee.name,r={url:t,method:s,parameter:{_token:n,episode_id:e}};swal({title:"Delete Episode",text:"You will not be able to recover this episode!",type:"warning",showCancelButton:!0,confirmButtonColor:"#DD6B55",confirmButtonText:"Yes, delete it!",cancelButtonText:"No, cancel!",closeOnCancelnConfirm:!1,closeOnCancel:!1},function(e){e?a(r,o):swal("Cancelled","Your episode is safe :)","error")})}function t(e){var t=arguments.callee.name,n={url:"/dashboard/episode/activate",method:"PATCH",parameter:{_token:document.getElementById("token").value,episode_id:e}};swal({title:"Activate Episode",text:"This Episode will be visible on your channel",type:"warning",showCancelButton:!0,confirmButtonColor:"success",confirmButtonText:"Activate",cancelButtonText:"Cancel!",closeOnConfirm:!1,closeOnCancel:!1},function(e){e?a(n,t):swal("Cancelled","Your episode is safe :)","error")})}function a(e,t){$.ajax({url:e.url,type:e.method,data:e.parameter,success:function(e){n(e,t)},error:function(){alert("Are you sure you doing this the right way?")}})}function n(e,t){if(401===e.status)switch(t){case"deleteEpisode":s();break;case"activateEpisode":r()}if(200===e.status)switch(t){case"deleteEpisode":o();break;case"activateEpisode":i()}}function s(){swal("Hmmmm","This episode does not exist ","error")}function o(){swal("Deleted!","Your episode has been deleted.","success");var e=$(".selected");e.hide()}function r(){swal("Hmmmm","This episode does not exist ","error")}function i(){swal("Activated","Your episode has been Activated.","success");var e=$(".selected"),t=$("#active_section");t.append(l[0]),e.show()}var l;$(".episode_action").on("change",function(){var a=$(this).val(),n=$(this).find("option:selected").data("action");$(this).parent().closest("tr").prop("class","selected"),"view"===a&&(window.location=n),"delete"===a&&e(n),"activate"===a&&(l=$(this).parent().closest("tr"),t(n))})}),$(document).ready(function(){function e(){var e={url:"/episode/like",method:"POST",parameter:{_token:document.getElementById("token").value,user_id:document.getElementById("user_id").value,episode_id:document.getElementById("episode_id").value}};a(e)}function t(e){var t={url:"/episode/unlike",method:"POST",parameter:{_token:document.getElementById("token").value,user_id:document.getElementById("user_id").value,episode_id:e.attr("data-episode-id")}};a(t)}function a(e){$.ajax({url:e.url,type:e.method,data:e.parameter,success:function(){},error:function(){swal("Are you sure you doing this the right way?")}})}$(".like-btn").click(function(){var a=$(this),n=$(this).attr("like-status"),s=$(this).html(),o=$("#favorite").html();"like"===n&&($(this).removeClass("like"),$(this).addClass("dislike"),$(this).attr("like-status","dislike"),e(),s=Number(s)+1,o=Number(o)+1,$(this).text(" "+s),$("#favorite").html(o)),"dislike"===n&&($(this).removeClass("dislike"),$(this).addClass("like"),$(this).attr("like-status","like"),t(a),s=Number(s)-1,o=Number(o)-1,$(this).text(" "+s),$("#favorite").html(o),/favorites/.test(window.location.pathname)&&location.reload()),"must_login"===n&&(window.location="/login")})}),function(e){e(function(){e(".button-collapse").sideNav({menuWidth:300,edge:"left",closeOnClick:!0}),e(".parallax").parallax()})}(jQuery),$(document).ready(function(){$(".materialboxed").materialbox()}),$(document).ready(function(){$.ajaxSetup({headers:{"X-CSRF-Token":$("meta[name=_token").attr("content")}}),$("#new_password_form").on("submit",function(e){e.preventDefault(),swal("Proccessing Request!");var t="password/resetGetEmail",a=$("#email").val(),n=$("#token").val(),s=$("#password_confirmation").val(),o=$("#password").val(),r={url:t,parameter:{token:n,email:a,password:o,password_confirmation:s}};return checkPassword(o,s)&&passwordLength(s)&&postAjaxRequest(r.url,r.parameter),!1})}),$(document).ready(function(){$("#password_reset_form").on("submit",function(){return swal({title:"",text:"Processing request.",showConfirmButton:!1}),passwordReset(),!1})}),$(document).ready(function(){$(".fb-share").on("click",function(e){e.preventDefault();var t=$(this).attr("data-desc"),a=$(this).attr("data-name"),n=$(this).attr("data-img"),s=$(this).attr("data-url");$.ajaxSetup({cache:!0}),$.getScript("//connect.facebook.net/en_US/sdk.js",function(){window.FB.init({appId:"1691359924434970",version:"v2.5"}),window.FB.ui({method:"share",display:"popup",href:s,caption:a,description:t,picture:n})})}),$(".twtr-share").on("click",function(e){e.preventDefault();var t=$(this).attr("data-desc").trim(),a=$(this).attr("data-url");t.length>=75&&(t=t.substr(0,75)+".. ");var n="https://twitter.com/intent/tweet?text=";t=encodeURIComponent(t);var s="&url="+a+"&hashtags=suyabay";window.open(n+t+s,"_blank")})});
