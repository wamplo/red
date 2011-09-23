// www.jslint.com for testing

(function ($) {

    "use strict";
    $.redriver = {
        loadedcss   : [], 
        loadedjs    : [],
                
        getJS: function (files, index, opt) {

            var that, arr, i;
            that = this; 
            arr  = [];

            for (i = 0; i < files[index].length; i += 1) {
                if ($.inArray(files[index][i], that.loadedjs) === -1) {
                    
                    if (opt.cache === 1) {
                        arr.push($.ajax({type: "GET", url: files[index][i], dataType: "script", cache: true, async: true}));
                        that.loadedjs.push(files[index][i]);
                    }
                    if (opt.cache === 0) {
                        arr.push($.ajax({type: "GET", url: files[index][i], dataType: "script", cache: false, async: true}));
                        that.loadedjs.push(files[index][i]);
                    }               
                }
            }

            $.when.apply(null, arr).then(function () {
                if (index < files.length - 1) {
                    that.getJS(files, index + 1, opt);
                }
            });         
        },
        
        getScrip: function (files, index, opt) {

            var that, arr, i;
            that = this; 
            arr  = [];

            for (i = 0; i < files[index].length; i += 1) {
                if ($.inArray(files[index][i], that.loadedjs) === -1) {
                    var head,script;
                    head = document.getElementsByTagName('head')[0];
                    script = document.createElement('script');
                    script.type= 'text/javascript';
                    script.src= files[index][i] + '?_=' + new Date().getTime();;
                    //head.appendChild(script);
                    arr.push(head.appendChild(script));
                }       
            }

            $.when.apply(null, arr).then(function () {
                if (index < files.length - 1) {
                    setTimeout(function() {
                    that.getScrip(files, index + 1, opt);
                    }, 5);
                }  
            });  
        },

        getStyle: function (files, opt, onload) {
            var that, i, link;
            that = this;
            for (i = 0; i < files.length; i += 1) {
                if ($.inArray(files[i], that.loadedcss) === -1) {
                    link = document.createElement('link');
                    link.type = 'text/css';
                    link.rel = 'stylesheet';
                    if (opt.cache === 0) {
                        link.href = files[i] + '?_=' + new Date().getTime();
                    }
                    if (opt.cache === 1) {
                        link.href = files[i];
                    }              
                    document.head.appendChild(link);
                    that.loadedcss.push(files[i]);    
                }
                        
                if (files.length - 1 === i) {
                    if (onload && typeof (onload) === "function") {
                        onload();
                    }
                }
            }
        },

        getContent: function (obj, opt, onload) {
            $('#' + obj.id).html(obj.html);
            onload();
        },

        branch: function (obj) {
            var that, opt;
            that = this;

            // SET OPTIONS
            opt = {
                cache : obj.cache
            };

            that.getStyle(obj.css, opt, function () {
                that.getContent(obj.src, opt, function () {
                    if (obj.js) {
                        that.getJS(obj.js, 0, opt);
                    }
                });
            });
        }
    };
}(jQuery));