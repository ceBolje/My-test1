$(document).ready(function () {

    try {

        /**
         * @constructor
         */
        function getPrize() {

            const that = this;

            this.assignPageHandlers = function (isUnbind, object) {


                var node = $('body').find('[data-handler]');

                if (typeof object === 'undefined' || object === null) {
                    object = this;
                }

                node.each(function () {

                    var handler = $(this).attr('data-handler');

                    if(handler.substr(0, 2) !== 'on' || typeof(object[handler]) !== 'function') {

                        return;
                    }

                    var action = $(this).attr('data-handler-action');

                    if (typeof action === 'undefined' || action === '') {
                        action = that.getTagDefaultAction($(this).prop('tagName'));
                    }

                    if (isUnbind === true) {
                        $(this).unbind(action);
                    }

                    $(this).bind(action, function (event) {
                        object[handler](this, event);
                    });
                });
            };

            this.getTagDefaultAction = function (tagName) {

                switch (tagName) {
                    case 'SELECT':
                    case 'INPUT':
                        return 'change';
                    case 'FORM':
                        return 'submit';
                    case 'A':
                    default:
                        return 'click';
                }
            };

            this.onGetPrize = function (n, e) {

                this.remoteCall('/prizes/getprize').done(function (res) {
                    //var data = JSON.parse(res);
                     console.log(res);
                    if(res && res.code == 200) {

                        $('#prizeActions').removeClass('d-none');
                        $( '#'+ res.type + 'Action').removeClass('d-none');
                        $('#prize').html(that.switchPrize(res));

                    } else {
                        //show error
                    }

                }).fail(function () {
                    //show error
                });

            };

            this.switchPrize = function (data) {

                var prize;
                switch (data.type) {
                    case 'money':
                        prize = data.amount +  ' coins';
                        break;
                    case 'points':
                        prize = data.amount +  ' points';
                        break;
                    case 'goods':
                        prize = data.goods;
                        break;
                }
                return prize;
            };


            this.remoteCall    = function (url, data, method, callback) {

                if (!method) method = 'GET';
                if (!url) return false;
                if (!data) data = [];
                if (typeof params != 'object') params = {};

                var ajaxParams                  = {
                    type: method,
                    url: url,
                    data: data,
                    dataType: 'JSON',
                    beforeSend: function () {
                        $('#loader').removeClass('d-none');
                    },
                    success: function (res) {
                    },
                    complete: function (res) {
                        $('#loader').addClass('d-none');
                        $('#loading').remove();

                        try {
                            res = JSON.parse(res.responseText);
                        } catch (e) {
                            res.response = {message : 'empty response', fail_reason: 'Unknown'};
                        }

                        if (typeof callback === 'function') {
                            callback(res);
                        }
                    }
                };

                if(typeof params.processData !== 'undefined') {
                    ajaxParams.processData      = params.processData;
                }

                if(typeof params.contentType !== 'undefined') {
                    ajaxParams.contentType      = params.contentType;
                }

                return $.ajax(ajaxParams);
            };

           
            this.init = function (html) {
                this.assignPageHandlers(true);
            };
        }

        function initPage(html) {
            console.log(123);
            window.app = new getPrize();
            window.app.init(html);
        }

        initPage();

    } catch (error) {

        console.log(error);
    }

});