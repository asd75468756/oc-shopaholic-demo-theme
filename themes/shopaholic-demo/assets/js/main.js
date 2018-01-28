// Product page, choose offer
$('body').on('change', '._choose_offer_field input', function (e) {
    var _this = $(e.currentTarget),
        quantity = _this.attr('data-quantity'),
        offer_id = _this.val(),
        sCartOfferList = $('._cart_info').attr('data-offer-list');

    _this.parents('form').find('._quantity_field').attr('max', quantity);

    if(!sCartOfferList) {
        return;
    }

    var arCartOfferList = sCartOfferList.split('|');
    if(!arCartOfferList) {
        return;
    }

    if(arCartOfferList.indexOf(offer_id) === -1) {
        $('._offer_buy_button').removeClass('uk-hidden');
        $('._offer_in_cart_button').addClass('uk-hidden');
    } else {
        $('._offer_buy_button').addClass('uk-hidden');
        $('._offer_in_cart_button').removeClass('uk-hidden');
    }
});

//Add offer to cart
$('body').on('submit', '._choose_offer_form', function (e) {

    e.preventDefault();

    var _this = $(e.currentTarget),
        offer_id = _this.find('._choose_offer_field input:checked').val(),
        quantity = _this.find('._quantity_field').val();

    if(!offer_id) {
        return;
    }

    $.request('Cart::onAdd', {
        data: {
            'cart': [{'offer_id': offer_id, 'quantity': quantity}]
        },
        update: {'cart/cart_info': '._cart_info_wrapper'},
        complete: function () {
            $('._offer_buy_button').addClass('uk-hidden');
            $('._offer_in_cart_button').removeClass('uk-hidden');
        }
    });
});

// Cart page, choose offer
$('body').on('change', '._choose_cart_offer_field input', function (e) {
    var _this = $(e.currentTarget),
        quantity = _this.attr('data-quantity'),
        offer_id = _this.val(),
        sCartOfferList = $('._cart_info').attr('data-offer-list');

    _this.parents('fieldset').find('._quantity_field').attr('max', quantity);

    if(!sCartOfferList) {
        return;
    }

    var arCartOfferList = sCartOfferList.split('|');
    if(!arCartOfferList) {
        return;
    }

    if(arCartOfferList.indexOf(offer_id) === -1) {
        _this.parents('form').find('._offer_add_cart_button').removeClass('uk-hidden');
        _this.parents('form').find('._offer_update_cart_button').addClass('uk-hidden');
    } else {
        _this.parents('form').find('._offer_add_cart_button').addClass('uk-hidden');
        _this.parents('form').find('._offer_update_cart_button').removeClass('uk-hidden');
    }
});

//Add offer to cart
$('body').on('click', '._offer_add_cart_button', function (e) {

    e.preventDefault();

    var _this = $(e.currentTarget),
        _form = _this.parents('form'),
        offer_id = _form.find('._choose_cart_offer_field input:checked').val(),
        quantity = _form.find('._quantity_field').val();

    if(!offer_id) {
        return;
    }

    $.request('Cart::onAdd', {
        data: {
            'cart': [{'offer_id': offer_id, 'quantity': quantity}]
        },
        update: {
            'cart/cart_info': '._cart_info_wrapper',
            'cart/cart_item_list': '._cart_item_list',
            'cart/cart_total_cost': '._cart_total_cost'
        }
    });
});

//Update offer quantity in cart
$('body').on('submit', '._cart_item_form', function (e) {

    e.preventDefault();

    var _this = $(e.currentTarget),
        offer_id = _this.find('._choose_cart_offer_field input:checked').val(),
        quantity = _this.find('._quantity_field').val();

    if(!offer_id) {
        return;
    }

    $.request('Cart::onUpdate', {
        data: {
            'cart': [{'offer_id': offer_id, 'quantity': quantity}]
        },
        update: {
            'cart/cart_info': '._cart_info_wrapper',
            'cart/cart_item_list': '._cart_item_list',
            'cart/cart_total_cost': '._cart_total_cost'
        }
    });
});

//Remove offer from cart
$('body').on('click', '._offer_remove_cart_button', function (e) {

    e.preventDefault();

    var _this = $(e.currentTarget),
        _form = _this.parents('form'),
        offer_id = _form.find('._choose_cart_offer_field input:checked').val();

    if(!offer_id) {
        return;
    }

    $.request('Cart::onRemove', {
        data: {
            'cart': [offer_id]
        },
        update: {
            'cart/cart_info': '._cart_info_wrapper',
            'cart/cart_item_list': '._cart_item_list',
            'cart/cart_total_cost': '._cart_total_cost'
        }
    });
});

//Make order
$('body').on('submit', '._make_order_form', function (e) {

    e.preventDefault();
    $('._make_order_error').addClass('uk-hidden');

    var _this = $(e.currentTarget),
        data = {
            'order': {
                'payment_method_id': _this.find('input[name="payment_method_id"]:checked').val(),
                'shipping_type_id': _this.find('input[name="shipping_type_id"]:checked').val(),
                'property': {
                    'address': _this.find('input[name="address"]').val()
                }
            },
            'user': {
                'name': _this.find('input[name="name"]').val(),
                'last_name': _this.find('input[name="last_name"]').val(),
                'email': _this.find('input[name="email"]').val(),
                'phone': _this.find('input[name="phone"]').val()
            }
        };

    $.request('MakeOrder::onCreate', {
        data: data,
        update: {
            'cart/cart_item_list': '._cart_item_list'
        },
        complete: function (response) {

            var data = response.responseJSON;
            if(data.status) {
                return;
            }

            $('._make_order_error p').html(data.message);
            $('._make_order_error').removeClass('uk-hidden');
        }
    });
});

//Open product modal
$('body').on('click', '._open_product_modal', function (e) {

    var _this = $(e.currentTarget),
        product_id = _this.parents('.product_cart_wrapper').attr('data-id');

    $.request('ProductData::onAjaxRequest', {
        data: {'product_id': product_id},
        update: {'ajax/ajax_product_modal': '._modal_product_wrapper'},
        complete: function () {
            UIkit.modal('._modal_product').show();
        }
    });
});