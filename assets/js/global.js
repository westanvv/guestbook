var module_container_index = 0;

//==============================================================================    
    function CLASS_SITE() {
        
        var self = this;
        this.authorizationData = {
            id:             0,
            id_institution: 0,
            login:          "",
            name:           "",
            id_group:       0,
            hash:           ""
        };
        this.exec_file = false;
        this.app = false;
        this.module = false;
        this.action = false;        
        this.module_container = "body";
        this.parent_container = "body";
        this.error_hash = "a8155b269b2799c8db674bea3c83e03b";
        this.crypt = false;
//------------------------------------------------------------------------------
        this.setExecFile = function(value) {
            this.exec_file = value;
        };
//------------------------------------------------------------------------------
        this.setApp = function(value) {
            this.app = value;
        };
//------------------------------------------------------------------------------
        this.setAction = function(value) {
            this.action = value;
        };
//------------------------------------------------------------------------------
        this.setModule = function(value) {
            this.module = value;
        };
//------------------------------------------------------------------------------
        this.setContainer = function(value) {
            this.module_container = "module_" + value;
            this.parent_container = $("#" + this.module_container).parent("div").attr("id");
        };
//------------------------------------------------------------------------------
        this.setModuleContainer = function(value) {
            this.module_container = "module_" + value;
        };
//------------------------------------------------------------------------------
        this.setParentContainer = function(value) {
            this.parent_container = value;
        };
//------------------------------------------------------------------------------
        this.useCache = function(value) {
            this.use_cache = value;            
        };
//------------------------------------------------------------------------------
        this.setCrypt = function(value) {
            this.crypt = value;            
        };
//------------------------------------------------------------------------------
        this.getExecFile = function() {
            return this.exec_file;
        };
//------------------------------------------------------------------------------
        this.getApp = function() {
            return this.app;
        };
//------------------------------------------------------------------------------
        this.getModule = function() {
            return this.module;
        };
//------------------------------------------------------------------------------
        this.getAction = function() {
           return this.action;
        };
//------------------------------------------------------------------------------
        this.getModuleContainer = function() {
           return this.module_container;
        };
//------------------------------------------------------------------------------
        this.getParentContainer = function() {
           return this.parent_container;
        };
//==============================================================================
//AJAX запроссы
//------------------------------------------------------------------------------
        this.ajaxParam = {
            async: true
        };
//------------------------------------------------------------------------------
        this.ajax = function(param) {
//Функция непосредственной отправки запроса            
            function ajaxSend(self) {
                var data = "";
                if (param.data) {
                    for (value in param.data) {
                        data += "&" + value + "=" + encodeURIComponent(param.data[value]);
                    }
                }
                var lang = window.location.href;
                lang = lang.split("/");
                
                data =  "query=ajax"+
                        "&apps="+(param.apps ? param.apps : self.app)+
                        "&module="+(param.module ? param.module : self.module)+
                        "&action="+(param.action ? param.action : self.action)+
                        "&lang="+((lang[3] == "") || (lang[3].length > 2) || (self.app == "backend") ? "ru" : lang[3])+
                        (param.dataType ? "&data_type="+param.dataType : "") +
                        data;
                if (!param.crypt && self.crypt) {
                    data = "d=" + crypt.encode(data) +
                           "&c=" + crypt.encode(data.length.toString());
                }
                   
                $.ajax({
                    url: '/'+(param.exec_file ? param.exec_file : self.exec_file),
                    global: false,
                    cache: false,
                    type: "POST",
                    data: data,
                    dataType:  (param.dataType ? param.dataType : "html"),
                    async: (param.async ? param.async : self.ajaxParam.async),
                    beforeSend: function() {
                        if (param.onBefore) {
                            param.onBefore();
                        }
                        else {
                            //
                        }
                    },
                    success: function(response){
                        if (typeof response == 'string' && (response.indexOf("<b>Fatal error</b>:") != -1 || response.indexOf(self.error_hash) != -1)) {
                            if (response.indexOf(self.error_hash) != -1) {
                                response = "Во время выполнения скрипта произошла ошибка<br/>" + response.substring(self.error_hash.length, response.length);
                            }
                            var dlg_id = getDialogNewId();
//                            var dlg_prev = dlg_id;
////Закрытие предыдущего диалога
//                            $("#dlg" + (dlg_prev.substring(4, dlg_prev.length) - 1)).fb_dialog("close");                            
//Создание нового диалога                            
                            $(dlg_id).fb_dialog({
                                title: "Ошибка",
                                msg: response,
                                draggable: true,
                                buttons: [
                                    {
                                        title: "Закрыть",
                                        event: function() {
                                            $(dlg_id).fb_dialog("close");
                                        }
                                    }
                                ]
                            });
                            $(dlg_id).fb_dialog("open"); 
                        }
                        else {
                            if (param.onSuccess) {
                                param.onSuccess(response);
                            }
                            else {
                                //
                            }
                        }
                    }
                });
            }
//------------------------------------------------------------------------------   
            ajaxSend(this);
        };
//==============================================================================
//Получение данных авторизации пользователей        
        this.getAuthorizationData = function() {
            if (getCookie('asp')) {
                var data =  "query=ajax" + 
                            "&action=getAuthorizationData" +
                            "&lang=ru" +
                            "&javascript_use=1";
                if (self.crypt) {
                    data = "d=" + crypt.encode(data) +
                           "&c=" + crypt.encode(data.length.toString());
                }
                
                $.ajax({
                    url: '/index.php',
                    global: false,
                    type: "POST",
                    data: data,
                    async: false,
                    success: function(response) {                        
                        if (response != 0) {
                            response = crypt.decode(response);
                            var data = response.split("&");
                            var authorizationData = data[0].split("|");
                            self.authorizationData = {
                                id:             authorizationData[0],
                                id_institution: authorizationData[1],
                                login:          authorizationData[2],
                                name:           authorizationData[3],
                                id_group:       authorizationData[4],
                                timezone:       authorizationData[5],
                                hash:           data[1]
                            };    
                        }
                     }
                });
            }
        };
//==============================================================================        
        this.initialization = function() {}; 
//==============================================================================
        this.setData = function(value) { 
            if (this.uninitialization != undefined) {
                this.uninitialization();
            }
            $("#" + this.module_container).html(value);
            if (this.initialization != undefined) {
                this.initialization();
            }
        }; 
//==============================================================================
        this.cleanData = function() {
           $("#" + this.module_container).empty();
        };    
//==============================================================================
        this.log = function(title, value) {
            if (DEBUG) {
                if (isUndefined(value)) 
                    console.info(this.module + ": " + title);
                else 
                    console.info(this.module + "(" + title + "): " + value);
            }
        };
//==============================================================================
        this.error = function(title, value) {
           if (isUndefined(value)) 
                console.warn(this.module + ": " + title);
            else 
                console.warn(this.module + "(" + title + "): " + value);
        };
    }