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

                    if (handler.substr(0, 2) !== 'on' || typeof(object[handler]) !== 'function') {

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

                this.hideNodes(['.prize-actions', '#prizeActions']);

                this.remoteCall('/prizes/getprize').done(function (res) {

                    if (res && res.code == 200) {

                        that.showNodes(['#prizeActions', '#' + res.type + 'Action']);

                        $('#prize').html(that.switchPrize(res));

                        $('.link-action').attr('data-id', res.transaction);

                    } else {

                        console.log('Error occurred');
                    }

                }).fail(function () {

                    console.log('Error occurred');
                });

            };

            this.onTransferToBank = function (n, e) {

                e.preventDefault();

                var transactionId = $(n).attr('data-id');

                this.hideNodes(['.prize-actions', '#prizeActions']);

                this.remoteCall('/prizes/bank').done(function (res) {

                    if (res && res.code == 200) {

                        that.remoteCall('/prizes/tobank/' + transactionId + '/noredirect').done(function (res) {

                            that.hideNodes(['#prizeActions', '#' + res.type + 'Action']);

                            that.onHandlePrize(n, e);
                        });


                    } else {

                        console.log('Error occurred');
                    }

                }).fail(function () {

                    console.log('Error occurred');

                });

            };

            this.onHandlePrize = function (n, e) {

                e.preventDefault();

                var transactionId = $(n).attr('data-id'),
                    url = $(n).attr('href');


                this.hideNodes(['.prize-actions', '#prizeActions']);

                this.remoteCall(url + transactionId + '/noredirect').done(function (res) {

                    if (res && res.code == 200) {

                    
                        that.showAlert('The Prize has been processed', 'success');

                    } else {

                        console.log('Error occurred');
                    }

                }).fail(function () {

                    console.log('Error occurred');

                });

            };


            this.switchPrize = function (data) {

                var prize;
                switch (data.type) {
                    case 'money':
                        prize = data.amount + ' coins';
                        break;
                    case 'points':
                        prize = data.amount + ' points';
                        break;
                    case 'goods':
                        prize = data.goods;
                        break;
                }
                return prize;
            };


            this.remoteCall = function (url, data, method, callback) {

                if (!method) method = 'GET';
                if (!url) return false;
                if (!data) data = [];
                if (typeof params != 'object') params = {};

                var ajaxParams = {
                    type: method,
                    url: url,
                    data: data,
                    dataType: 'JSON',
                    beforeSend: function () {

                        that.showNodes(['#loader']);
                    },
                    success: function (res) {
                    },
                    complete: function (res) {
                        that.hideNodes(['#loader']);

                        try {
                            res = JSON.parse(res.responseText);
                        } catch (e) {
                            res.response = {message: 'empty response', fail_reason: 'Unknown'};
                        }

                        if (typeof callback === 'function') {
                            callback(res);
                        }
                    }
                };

                if (typeof params.processData !== 'undefined') {
                    ajaxParams.processData = params.processData;
                }

                if (typeof params.contentType !== 'undefined') {
                    ajaxParams.contentType = params.contentType;
                }

                return $.ajax(ajaxParams);
            };

            this.showNodes = function (nodes) {
                $.each(nodes, function (i, n) {
                    $(n).removeClass('d-none');
                });
            };

            this.hideNodes = function (nodes) {
                $.each(nodes, function (i, n) {
                    $(n).addClass('d-none');
                });
            };


            this.init = function (html) {
                this.assignPageHandlers(true);
            };

            this.showAlert = function (msg, type) {

                $('#message').html(msg);
                $('.myalert').addClass('alert-' + type);
                this.showNodes(['.myalert']);

                setTimeout(function () {
                    that.hideNodes(['.myalert']);
                }, 1500);


            };
        }

        function initPage(html) {
            window.app = new getPrize();
            window.app.init(html);
        }

        initPage();

    } catch (error) {

        console.log(error);
    }

});