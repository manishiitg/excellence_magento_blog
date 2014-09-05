var Excellence = Class.create(Checkout, {
	initialize: function($super,accordion, urls){
		$super(accordion, urls);
		//New Code Addded
		this.steps = ['login', 'excellence' ,'billing', 'shipping', 'excellence2' , 'shipping_method', 'payment','excellence3', 'review'];
	},
	setMethod: function(){
	    if ($('login:guest') && $('login:guest').checked) {
	        this.method = 'guest';
	        var request = new Ajax.Request(
	            this.saveMethodUrl,
	            {method: 'post', onFailure: this.ajaxFailure.bind(this), parameters: {method:'guest'}}
	        );
	        Element.hide('register-customer-password');
	        this.gotoSection('excellence'); //New Code Here
	    }
	    else if($('login:register') && ($('login:register').checked || $('login:register').type == 'hidden')) {
	        this.method = 'register';
	        var request = new Ajax.Request(
	            this.saveMethodUrl,
	            {method: 'post', onFailure: this.ajaxFailure.bind(this), parameters: {method:'register'}}
	        );
	        Element.show('register-customer-password');
	        this.gotoSection('excellence'); //New Code Here
	    }
	    else{
	        alert(Translator.translate('Please choose to register or to checkout as a guest'));
	        return false;
	    }
	}
});


var ExcellenceMethod = Class.create();
ExcellenceMethod.prototype = {
    initialize: function(form, saveUrl){
        this.form = form;
        if ($(this.form)) {
            $(this.form).observe('submit', function(event){this.save();Event.stop(event);}.bind(this));
        }
        this.saveUrl = saveUrl;
        this.validator = new Validation(this.form);
        this.onSave = this.nextStep.bindAsEventListener(this);
        this.onComplete = this.resetLoadWaiting.bindAsEventListener(this);
    },

    validate: function() {
        if(!this.validator.validate()) {
            return false;
        }
        return true;
    },

    save: function(){

        if (checkout.loadWaiting!=false) return;
        if (this.validate()) {
            checkout.setLoadWaiting('excellence');
            var request = new Ajax.Request(
                this.saveUrl,
                {
                    method:'post',
                    onComplete: this.onComplete,
                    onSuccess: this.onSave,
                    onFailure: checkout.ajaxFailure.bind(checkout),
                    parameters: Form.serialize(this.form)
                }
            );
        }
    },

    resetLoadWaiting: function(transport){
        checkout.setLoadWaiting(false);
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

        if (response.update_section) {
            $('checkout-'+response.update_section.name+'-load').update(response.update_section.html);
        }


        if (response.goto_section) {
            checkout.gotoSection(response.goto_section);
            checkout.reloadProgressBlock();
            return;
        }

        checkout.setBilling();
    }
}

var ExcellenceMethod2 = Class.create();
ExcellenceMethod2.prototype = {
    initialize: function(form, saveUrl){
        this.form = form;
        if ($(this.form)) {
            $(this.form).observe('submit', function(event){this.save();Event.stop(event);}.bind(this));
        }
        this.saveUrl = saveUrl;
        this.validator = new Validation(this.form);
        this.onSave = this.nextStep.bindAsEventListener(this);
        this.onComplete = this.resetLoadWaiting.bindAsEventListener(this);
    },

    validate: function() {
        if(!this.validator.validate()) {
            return false;
        }
        return true;
    },

    save: function(){

        if (checkout.loadWaiting!=false) return;
        if (this.validate()) {
            checkout.setLoadWaiting('excellence2');
            var request = new Ajax.Request(
                this.saveUrl,
                {
                    method:'post',
                    onComplete: this.onComplete,
                    onSuccess: this.onSave,
                    onFailure: checkout.ajaxFailure.bind(checkout),
                    parameters: Form.serialize(this.form)
                }
            );
        }
    },

    resetLoadWaiting: function(transport){
        checkout.setLoadWaiting(false);
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

        if (response.update_section) {
            $('checkout-'+response.update_section.name+'-load').update(response.update_section.html);
        }


        if (response.goto_section) {
            checkout.gotoSection(response.goto_section);
            checkout.reloadProgressBlock();
            return;
        }

        checkout.setShippingMethod();
    }
}

var ExcellenceMethod3 = Class.create();
ExcellenceMethod3.prototype = {
    initialize: function(saveUrl){
        this.saveUrl = saveUrl;
        this.onSave = this.nextStep.bindAsEventListener(this);
        this.onComplete = this.resetLoadWaiting.bindAsEventListener(this);
    },
    save: function(){

        if (checkout.loadWaiting!=false) return;
            checkout.setLoadWaiting('excellence3');
            var request = new Ajax.Request(
                this.saveUrl,
                {
                    method:'post',
                    onComplete: this.onComplete,
                    onSuccess: this.onSave,
                    onFailure: checkout.ajaxFailure.bind(checkout)
                }
            );
    },

    resetLoadWaiting: function(transport){
        checkout.setLoadWaiting(false);
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

        if (response.update_section) {
            $('checkout-'+response.update_section.name+'-load').update(response.update_section.html);
        }


        if (response.goto_section) {
            checkout.gotoSection(response.goto_section);
            checkout.reloadProgressBlock();
            return;
        }

        checkout.setReview();
    }
}