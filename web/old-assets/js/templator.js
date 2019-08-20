var Templator = (function() {

	function Templator(string) {
		this.template = string;
	};

	Templator.prototype.compile = function(data) {
		if(!this.template) {
			return null;
		};

		return this.template.replace(/\{\{(.*?)\}\}/g, function(match, keysString) {
			var keys = keysString.split('.');
			var value = data;

			for (var i = 0; i < keys.length; i++) {

				if(value.hasOwnProperty(keys[i])) {
					value = value[keys[i]];
				} else {
					value = '';
					break;
				};
			};

			return value;
		});
	};

	return Templator;	

})();
