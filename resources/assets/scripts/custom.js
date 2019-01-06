/**
Custom module for you to write your own javascript functions
**/
var Custom = function () {

    // private functions & variables

    var activeMenu = function() {
        var $pageIdentity = $("#page-identity");
        var parent = $pageIdentity.attr("data-parent");
        var parent2 = $pageIdentity.attr("data-parent2");
        var menu = $pageIdentity.attr("data-menu");
        if(parent!=""){
            $(parent).addClass("active");
        }
        if(parent2!=""){
            $(parent2).addClass("active");
        }
        $(menu).addClass("active");
    }

    // public functions
    return {

        //main function
        init: function () {
            //initialize here something.  
            activeMenu();       
            jQuery.validator.addMethod("filesize_max", function (value, element, param) {
                var isOptional = this.optional(element),
                    file;

                if (isOptional) {
                    return isOptional;
                }

                if ($(element).attr("type") === "file") {

                    if (element.files && element.files.length) {

                        file = element.files[0];
                        var size = file.size / 1024;
                        return (size <= param);
                    }
                }
                return false;
            }, "File size is too large.");
            jQuery.validator.addMethod("extension", function (value, element, param) {
                param = typeof param === "string" ? param.replace(/,/g, '|') : "png|jpe?g|gif";
                return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
            }, "Please enter a value with a valid extension.");   
        },

        //some helper function
        GenpasswordToElement: function (id,length) {
            var chars = "abcdefghijklmnopqrstuvwxyz!@#$%^&*()-+<>ABCDEFGHIJKLMNOP1234567890";
            var pass = "";
            for (var x = 0; x < length; x++) {
                var i = Math.floor(Math.random() * chars.length);
                pass += chars.charAt(i);
            }
            $(id).val(pass);
            // return pass;
        }

    };

}();

/***
Usage
***/
Custom.init();