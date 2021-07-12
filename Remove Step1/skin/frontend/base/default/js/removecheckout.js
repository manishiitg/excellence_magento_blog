var Excellence = Class.create(Checkout, {
	initialize: function($super,accordion, urls){
		$super(accordion, urls);
		//New Code Addded
		this.steps = ['billing', 'shipping', 'shipping_method', 'payment', 'review'];
	},
	setMethodGuest: function(){
		Element.hide('register-customer-password');
	},
	setMethodRegister: function(){
		Element.show('register-customer-password');
	}
});