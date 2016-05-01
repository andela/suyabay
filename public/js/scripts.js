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

$("#delete-api").click(function() {
    var id   = $(this).data("id");
    var url  = "/developer/myapp/"+id+"/delete";

    confirmApiDelete(url);

    return false;
});

/**
 *process the ajax call
 *
 * @param  url
 * @param  parameter
 */
function processDeleteAjaxCall(url, parameter)
{
    $.ajax({
        url: url,
        type: "GET",
        data: parameter,
        success: function(response) {
            if (response.status_code == 200) {
                deleteSuccessMessage();
            } else {
                swal({
            	    title: "Cancelled",
            	    text:   "Your app is retained",
    			    confirmButtonColor: "#26a69a",
    			    type: "error"
    		    });
            }
        }
    });
}

/**
 *confirmDelete modal message
 *
 * @param  url
 */
function confirmApiDelete(url)
{
    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this app!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#26a69a",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, retain my app!",
        closeOnConfirm: false,
        closeOnCancel: false
    },

    function(isConfirm)
    {
        if (isConfirm) {
    	    processDeleteAjaxCall(url);
        } else {
    	    swal("Cancelled", "Your app will be retained", "error");
        }
    });
}

/**
 *Sweetalert Delete message
 *
 */
function deleteSuccessMessage()
{
    swal({
        title: "Done!",
        text: "App deleted successfully",
        type: "success",
        showCancelButton: false,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
    },

    function (){
        document.location.href = "/developer/myapp/";
    });
}

/**
 * onSubmit event to handle app update
 */
$("#app-update").submit( function (e) {
    e.preventDefault();
    e.stopImmediatePropagation();

    var id           = $("#id").val();
    var name         = $("#name").val().trim();
    var homepage_url = $("#homepage_url").val().trim();
    var description  = $("#description").val().trim();

    if( name.length !== 0 && description.length  ) {

        var data = {
            url: "/developer/myapp/edit/",
            parameter:
            {
                id: id,
                name: name,
                homepage_url: homepage_url,
                description: description
            }
        }   
        processUpdateAjaxCall("PUT", data.url, data.parameter);
    } else{
        swal({
            title: "Error!",
            text: "Please provide both name and description",
            type: "error",
            showCancelButton: false,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
        });
    }

    return false;
});


/**
 * processUpdateAjaxCall Proccess the ajax call
 *
 * @param  url
 * @param  parameter
 * @param  name
 */
function processUpdateAjaxCall (action, url, parameter)
{
    $.ajax({
        url: url,
        type: action,
        data: parameter,
        success: function(response) {
            if ( response.status_code === 200) {
                updateSuccessMessage();
            } else if (response.status_code === 404) {
                 swal("Cancelled", "Your app was unable to update successfully", "error");
            } else {
                 swal("Cancelled", "App already exist", "error");
            }
        }, error: function (error) {
            swal({
                title: "Done!",
                text: "Please input the right url format",
                type: "error",
                showCancelButton: false,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
            })
        }
    });
}

/**
 *Sweetalert update message
 *
 */
function updateSuccessMessage()
{
    swal({
        title: "Done!",
        text: "App updated successfully",
        type: "success",
        showCancelButton: false,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
    },

    function (){
        document.location.href = "/developer/myapp/";
    });
}

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
