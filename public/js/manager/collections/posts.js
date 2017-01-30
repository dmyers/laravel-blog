Manager.Collection.Posts = Backbone.Collection.extend({
	url   : function () {
		return '/blogadmin/posts';
	},
	model : Manager.Model.Post
});
