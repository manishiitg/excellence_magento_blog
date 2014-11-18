var express = require('express');
var router = express.Router();

router.get('/', function (req, res, next) {
    res.render('index');
});

router.get('/layout', function (req, res, next) {
    res.render('index', {
        layout: '2column-left'
    });
});

router.get('/variable', function (req, res, next) {
    res.render('variable', {
        title: 'Basic Variable',
        user: {
            firstname: 'Manish',
            lastname: 'Prakash',
            email: 'manish@excellencetechnologies.in'
        }
    }
    );
});

router.get('/loop', function (req, res, next) {
    res.render('loop', {
        title: 'Basic If Conditions and Loop',
        "employees": [
            {"firstName": "John", "lastName": "Doe"},
            {"firstName": "Anna", "lastName": "Smith"},
            {"firstName": "Peter", "lastName": "Jones"}
        ]
    }
    );
});

router.get('/helper', function (req, res, next) {
    res.render('helper', {
        title: 'Using Helpers',
        helpers: {
            canDisplayDeal: function (options) {
                if (this.is_publish == 1 || this.is_publish == '1') {
                    return options.fn(this);
                } else {
                    return options.inverse(this);
                }
            }
        },
        deals: [
            {
                "is_publish": "1",
                "name": "LG L90 Dual D410 Smartphone at Rs.11599"
            },
            {
                "is_publish": "0",
                "name": "Sony MDR-XB250 Headphone"
            },
            {
                "is_publish": "1",
                "name": "Philips HTB7150 Blu Ray Bluetooth Soundbar with Subwoofer Rs.27999"
            },
            {
                "is_publish": "0",
                "name": "Get 65% off On Over 5000 Books"
            },
            {
                "is_publish": "0", "name": "HealthKart Health & Beauty Products Rs. 100 off on Rs. 101"
            }
        ]
    }
    );
});

module.exports = router;
