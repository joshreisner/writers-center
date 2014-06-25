$(function(){

	var StripeBilling = {

		init: function() {
			this.form = $("form#support");
			this.submitButton = this.form.find("input[type=submit]");
			Stripe.setPublishableKey($("meta[name=stripe_key]").attr("content"));
			this.form.on("submit", $.proxy(this.sendToken, this));
		},
		
		sendToken: function(event) {
			event.preventDefault();
			Stripe.createToken(this.form, $.proxy(this.stripeResponseHandler, this));
		},

		stripeResponseHandler: function(status, response) {
			if (response.error) {
				if (!this.form.find(".alert").size()) $("<div>", { class: "alert alert-warning" }).prependTo(this.form);
				this.form.find(".alert").text(response.error.message);
				return this.submitButton.prop("disabled", false);
			}

			$("<input>", {
				type: "hidden",
				name: "stripeToken",
				value: response.id
			}).appendTo(this.form);

			this.form[0].submit();
		}

	};

	StripeBilling.init();

});