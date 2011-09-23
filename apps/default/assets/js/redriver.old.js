(function($) {
    $.redriver = {

        loadedcss   : [],
        loadedjs    : [],
                
        getJS: function(files, index, opt){
        var that = this;
        var arr = [];
            for(var i = 0; i < files[index].length; i++) {
                if ($.inArray(files[index][i],that.loadedjs) == -1) {
                    if (opt.cache === 1) {
                         arr.push($.ajax({url: files[index][i],async:true, cache: true,dataType: "script"}));
                         that.loadedjs.push(files[index][i]);
                    };
                    if (opt.cache === 0) {
                         arr.push($.getScript(files[index][i]));
                         that.loadedjs.push(files[index][i]);
                    };                 
                };
            }
            $.when.apply(null, arr).then(function() {
                if(index < files.length - 1) {
                    that.getJS(files, index + 1, opt);
                }
            });         
        },

        getStyle: function(files, opt, onload){
        var that = this;
            for(var i = 0; i < files.length; i++) {
                if ($.inArray(files[i],that.loadedcss) == -1) {
                var link = document.createElement('link');
                    link.type = 'text/css';
                    link.rel = 'stylesheet';
                    if (opt.cache === 0) {
                        link.href = files[i] + '?_=' + new Date().getTime();
                    };
                    if (opt.cache === 1) {
                        link.href = files[i];
                    };                  
                    document.head.appendChild(link);
                    that.loadedcss.push(files[i]);    
                };
                        
                if (files.length - 1 === i) {
                    if (onload && typeof(onload) === "function") {
                        onload();
                    }
                };    
            }
        },


        getContent: function(obj, opt, onload){
            $('#'+obj.id).html(obj.html);
            onload();
        },

        branch: function(obj) {
            var that = this;

            // SET OPTIONS
            opt = new Object;
            opt.cache = obj.cache;

            this.getStyle(obj.css, opt, function(){
                that.getContent(obj.src, opt, function(){
                    if (obj.js) {
                        that.getJS(obj.js, 0, opt);
                    };
                });
            });
        }
    }
})(jQuery);