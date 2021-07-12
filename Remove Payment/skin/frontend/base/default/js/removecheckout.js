var Excellence = Class.create(Checkout, {
	initialize: function($super,accordion, urls){
		$super(accordion, urls);
		//New Code Addded
		this.steps = ['login','billing', 'shipping', 'shipping_method', 'review'];
	}
});
var ExcellenceShippingMethod = Class.create(ShippingMethod , {
	initialize: function($super,form, saveUrl){
		$super(form, saveUrl);
	},
	nextStep: function(transport){
        if (transport && transport.responseText){
            try{
                response = eval('(' + transport.responseText + ')');
            }
            catch (e) {
                response = {};
            }
        }

        if (response.error) {
            alert(response.message);
            return false;
        }
        checkout.setStepResponse(response);
    }
});
var ExcellenceReview = Class.create(Review,{
	initialize: function($super,saveUrl, successUrl, agreementsForm){
		$super(saveUrl, successUrl, agreementsForm);
	},
	save: function(){
        if (checkout.loadWaiting!=false) return;
        checkout.setLoadWaiting('review');
        var params = 'payment[method]=free';
        if (this.agreementsForm) {
            params += '&'+Form.serialize(this.agreementsForm);
        }
        params.save = true;
        var request = new Ajax.Request(
            this.saveUrl,
            {
                method:'post',
                parameters:params,
                onComplete: this.onComplete,
                onSuccess: this.onSave,
                onFailure: checkout.ajaxFailure.bind(checkout)
            }
        );
    }
});