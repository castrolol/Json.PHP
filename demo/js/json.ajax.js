if (!Function.prototype.bind) {
  Function.prototype.bind = function(oThis) {
    if (typeof this !== 'function') {
      // closest thing possible to the ECMAScript 5
      // internal IsCallable function
      throw new TypeError('Function.prototype.bind - what is trying to be bound is not callable');
    }

    var aArgs   = Array.prototype.slice.call(arguments, 1),
        fToBind = this,
        fNOP    = function() {},
        fBound  = function() {
          return fToBind.apply(this instanceof fNOP && oThis
                 ? this
                 : oThis,
                 aArgs.concat(Array.prototype.slice.call(arguments)));
        };

    fNOP.prototype = this.prototype;
    fBound.prototype = new fNOP();

    return fBound;
  };
}

(function(w){

	function RequestBuilder(method){

		this.method = method;
		this.url = "";
		this.data = null;

		_listeners = [];

		function getListeners(type){
			var retorno = [];
			for(var i = 0; i < _listeners.length; i++){
				if( _listeners[i].type != type ) continue;
				retorno.push( _listeners[i] );
			}
			return retorno;
		}

		function notifyListeners(type, data){
			var listeners = getListeners(type).concat(getListeners("always"));

			for(var i = 0; i < listeners.length; i++){
				listeners[i].callback(data, type);
			}

		}

		this.inUrl = function(url){
			this.url = url;
			return this;
		};

		this.send = function(data){

			this.data = data;

			var xmlHttpRequest = new XMLHttpRequest();
			xmlHttpRequest.open(this.method, this.url);
			function getResponse(){
				return { 
						status: xmlHttpRequest.statusText,
						statusCode: xmlHttpRequest.status, 
						headers: xmlHttpRequest.getAllResponseHeaders(), 
						response: function(){ xmlHttpRequest.response; }
					};
			};

			xmlHttpRequest.onload = function(){
				var data = JSON.parse(xmlHttpRequest.responseText);
				notifyListeners("done", data, getResponse())
			};			

			xmlHttpRequest.onerror = function(){				
				var data = xmlHttpRequest.responseText;
				notifyListeners("done",data, getResponse());
			};	

			xmlHttpRequest.send(JSON.stringify(data));
			return this;
		};

		this.done = function(cb){
			_listeners.push({
				type: "done",
				callback: cb
			});
			return this;
		};

		this.fail = function(cb){
			_listeners.push({
				type: "done",
				callback: cb
			});
			return this;
		};

		this.always = function(cb){
			_listeners.push({
				type: "always",
				callback: cb
			});
			return this;
		};

	}

	function Server(){
		var self = this;
		var methods = [ "post", "put", "delete"];
		for(var i = 0; i < methods.length; i++){
			this[methods[i]] = self.httpMethod.bind(self, methods[i]);			
		}

	}

	Server.prototype.httpMethod = function(method) {
		
		return new RequestBuilder(method);

	};

 

	w.Server = new Server();

}(window));