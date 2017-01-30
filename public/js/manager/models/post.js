Manager.Model.Post = Backbone.Model.extend({
	urlRoot : function () {
		return '/blogadmin/posts';
	},
	
	defaults : {
		title      : '',
		content    : '',
		created_at : '',
		status     : ''
	},
	
	link : function (action) {
		var id = this.get('id') ? this.get('id').toString() : '';
		
		if ('edit' == action) {
			return 'manager/edit/' + id;
		}
		
		return 'manager/' + id;
	}
});
