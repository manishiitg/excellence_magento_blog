var express = require('express');
var router = express.Router();

/* GET home page. */
router.get('/', function (req, res, next) {
    res.render('index', {
        title: 'Express',
        helpers: {
            canDisplayDeal: function (options) {
                if (this.is_publish == 1 || this.is_publish == '1') {
                    return options.fn(this);
                } else {
                    return options.inverse(this);
                }
            }
        },
        user: {
            firstname: 'Manish',
            lastname: 'Prakash',
            email: 'manish@excellencetechnologies.in'
        },
        "employees": [
            {"firstName": "John", "lastName": "Doe"},
            {"firstName": "Anna", "lastName": "Smith"},
            {"firstName": "Peter", "lastName": "Jones"}
        ],
        deals: [{"is_publish": "1", "name": "LG L90 Dual D410 Smartphone at Rs.11599", "image": "http:\/\/excellencetechnologies.co.in\/deals\/public\/assets\/dealsimg\/1416227135_lg3-144x110.png", "link": "http:\/\/www.amazon.in\/LG-L90-Dual-D410-White\/dp\/B00JFOIOPU\/ref=sr_1_157\/280-7842355-6211215?s=electronics&ie=UTF8&qid=1416182469&sr=1-157&linkCode=as2&tag=pricegenie-21", "is_offer": "0", "price": "17999", "deal_price": "11599", "query_id": "7c00ee701cfd9a2eda9a4fb8e6dab9df", "query_updated": "0", "website": "amazon", "graph_unique": "B00JFOIOPU", "hasGraph": 1, "cat_id": "1", "major_cat_name": "Today's Deals"}, {"is_publish": "0", "name": "Sony MDR-XB250 Headphone", "image": "http:\/\/excellencetechnologies.co.in\/deals\/public\/assets\/dealsimg\/1416227077_41mrKUIcJ5L.jpg", "link": "http:\/\/www.amazon.in\/Sony-XB250-MDR-XB250-Headphone-Black\/dp\/B00ND4OM5O\/?tag=pricegenie-21&ascsubtag=16CL1Xdeals&linkCode=as2", "is_offer": "0", "price": "1490", "deal_price": "790", "query_id": "", "query_updated": "0", "website": "amazon", "hasGraph": 0, "cat_id": "1", "major_cat_name": "Today's Deals"}, {"is_publish": "0", "name": "Philips HTB7150 Blu Ray Bluetooth Soundbar with Subwoofer Rs.27999 \u2013 Infibeam", "image": "http:\/\/excellencetechnologies.co.in\/deals\/public\/assets\/dealsimg\/1416226736_71.jpg.19fd431cb9.999x200x200.jpg", "link": "http:\/\/www.infibeam.com\/Home_Entertainment\/philips-htb7150-sound-bar\/P-hoen-38877853306-cat-z.html?trackId=rin", "is_offer": "0", "price": "54990", "deal_price": "27999", "query_id": "", "query_updated": "0", "website": "Infibeam", "hasGraph": 0, "cat_id": "1203", "major_cat_name": "Today's Deals"}, {"is_publish": "0", "name": "Get 65% off On Over 5000 Books", "image": "http:\/\/excellencetechnologies.co.in\/deals\/public\/assets\/dealsimg\/1416225688_leftbanner.jpg", "link": "http:\/\/www.buybooksindia.com\/the-great-indian-book-sale-books-p42.php", "is_offer": "0", "price": "150", "deal_price": "53", "query_id": "", "query_updated": "0", "website": "buybooksindia", "hasGraph": 0, "cat_id": "9", "major_cat_name": "Today's Deals"}, {"is_publish": "0", "name": "HealthKart Health & Beauty Products Rs. 100 off on Rs. 101", "image": "http:\/\/excellencetechnologies.co.in\/deals\/public\/assets\/dealsimg\/1416225170_healthkart2.jpg", "link": "http:\/\/www.healthkart.com", "is_offer": "0", "price": "120", "deal_price": "70", "query_id": "", "query_updated": "0", "website": "healthkart", "hasGraph": 0, "cat_id": -1, "major_cat_name": "Today's Deals"}, {"is_publish": "0", "name": "Remson Travel Iron at Rs.321", "image": "http:\/\/excellencetechnologies.co.in\/deals\/public\/assets\/dealsimg\/1416224979_remson-iron-134x110.png", "link": "http:\/\/www.greendust.com\/Dry-Iron\/remson-travel-iron-p-32250.html?src=omg", "is_offer": "0", "price": "499", "deal_price": "321", "query_id": "", "query_updated": "0", "website": "greendust", "hasGraph": 0, "cat_id": "1005", "major_cat_name": "Today's Deals"}, {"is_publish": "1", "name": "Moto X 2nd Gen Mobile Rs. 25999 (Exchange) or Rs. 31999 @ Flipkart", "image": "http:\/\/excellencetechnologies.co.in\/deals\/public\/assets\/dealsimg\/1416223193_motox.jpg", "link": "http:\/\/www.flipkart.com\/moto-x-2nd-gen\/p\/itmdzu9exd9vhfvu?pid=MOBDZ3FVVZT38WQH&srno=b_41&ref=55575cc9-d061-4767-8c83-a179de56ff1a&affid=manishexce", "is_offer": "0", "price": "0", "deal_price": "31999", "query_id": "1fdfdab16b2b8171ddfb693c670e6300", "query_updated": "0", "website": "Flipkart", "graph_unique": "itmdzu9exd9vhfvu-MOBDZ3FVVZT38WQH", "hasGraph": 1, "cat_id": "1", "major_cat_name": "Today's Deals"}, {"is_publish": "0", "name": "Cooler Master POWER FORT 3000 mAh Power Bank + iDance SLAM 10 Wired Headphone @ Rs. 999 \u2013 Flipkart", "image": "http:\/\/excellencetechnologies.co.in\/deals\/public\/assets\/dealsimg\/1416220550_powerbank.jpg", "link": "http:\/\/www.flipkart.com\/cooler-master-power-fort-rechargeable-backup-battery-pack\/p\/itmdswcv73njq9gj?affid=manishexce", "is_offer": "0", "price": "1999", "deal_price": "999", "query_id": "", "query_updated": "0", "website": "Flipkart", "hasGraph": 0, "cat_id": "6095", "major_cat_name": "Today's Deals"}, {"is_publish": "0", "name": "Pepperfry Offers : Up to 37% + Extra 10% OFF on New Range of Tupperware Products", "image": "http:\/\/excellencetechnologies.co.in\/deals\/public\/assets\/dealsimg\/1416218565_pepperfry27-144x110.png", "link": "http:\/\/www.pepperfry.com\/kitchen-dining-deals.html", "is_offer": "0", "price": "275", "deal_price": "162", "query_id": "", "query_updated": "0", "website": "Pepperfry", "hasGraph": 0, "cat_id": -1, "major_cat_name": "Today's Deals"}, {"is_publish": "0", "name": "Freecultr Exclusive Sale : Flat Rs.400 OFF on Rs.750 + Extra 5% OFF | Valid on Entire Store", "image": "http:\/\/excellencetechnologies.co.in\/deals\/public\/assets\/dealsimg\/1416218560_freecultr14-144x110.png", "link": "https:\/\/www.freecultr.com\/", "is_offer": "0", "price": "750", "deal_price": "350", "query_id": "", "query_updated": "0", "website": "freecultr", "hasGraph": 0, "cat_id": "5204", "major_cat_name": "Today's Deals"}]
    }
    );
});

module.exports = router;
