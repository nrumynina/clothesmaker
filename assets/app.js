/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';

$(function () {
    refreshCartCount();
})

function refreshCartCount() {
    $.ajax({
        url: '/cart/count',
        type: "GET",
        success: function (response) {
            $('#cart-count').text(response['count']);
        }
    });
}
