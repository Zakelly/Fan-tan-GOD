jQuery.fn.serializeObject = function () {
    var o = {};
    var a = this.serializeArray();
    $.each(a, function () {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        }
        else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};
$(document).on('submit', 'form[method=POST]', function () {
    var $this = $(this);
    $.post($this.prop('action'), $this.serializeObject(), function (response) {
        if (response.success) {
            $this.find(".success").show();
            $this.find(".fail").hide();
            if (response.redirect)
                location.href = response.redirect;
        }
        else {
            $this.find(".fail").show().text(response.message);
            $this.find(".success").hide();
        }
    });
});
//# sourceMappingURL=global.js.map