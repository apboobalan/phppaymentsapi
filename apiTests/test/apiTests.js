const frisby = require('icedfrisby')
const Joi = require('joi')
 
const URL = 'http://localhost:8080/'

frisby.create('Clear payment Collection')
    .delete(URL + 'payment')
    .expectStatus(200)
    .expectJSONTypes({"message": Joi.string(),"code": Joi.number()})
    .expectJSON({"message": "payments collection removed","code": 200})
    .toss()

frisby.create('Clear charge Collection')
    .delete(URL + 'charge')
    .expectStatus(200)
    .expectJSONTypes({ "message": Joi.string(), "code": Joi.number() })
    .expectJSON({ "message": "charges collection removed", "code": 200 })
    .toss()

frisby.create('Get all charges initially')
    .get(URL + 'charge')
    .expectStatus(200)
    .expectJSON([])
    .toss() 

frisby.create('Create Payment with Debit card')
    .post(URL + 'payment',{"id":1,"name":"booDebit","type":"dd","iban":"IBAN"})
    .expectStatus(200)
    .expectJSONTypes({"id": Joi.string(),"name": Joi.string(),"type": Joi.string(),"iban": Joi.string()})
    .expectJSON({"id": "1","name": "booDebit","type": "dd","iban": "IBAN"})
    .toss()

frisby.create('Get 409 Error when id already exists')
    .post(URL + 'payment', { "id": 1, "name": "booDebit", "type": "dd", "iban": "IBAN" })
    .expectStatus(409)
    .expectJSONTypes({ "message": Joi.string(), "code": Joi.number() })
    .expectJSON({ "message": "Data conflict", "code": 409 })
    .toss()

frisby.create('Create Payment with credit card')
    .post(URL + 'payment', {"id":2,"name":"booCredit","type":"cc","expiry":"2012-12-12T00:00:00.000Z","cc":"c","ccv":"cc"})
    .expectStatus(200)
    .expectJSONTypes({"id": Joi.string(),"name": Joi.string(),"type": Joi.string(),"expiry": Joi.string(),"cc": Joi.string(),"ccv": Joi.string()})
    .expectJSON({"id": "2","name": "booCredit","type": "cc","expiry": "2012-12-12T00:00:00.000Z","cc": "c","ccv": "cc"
    })
    .toss()


frisby.create('Get 400 Error when payment created with wrong parameters')
    .post(URL + 'payment', { "id": 3, "name": "booDebit", "type": "dd" })
    .expectStatus(400)
    .expectJSONTypes({ "message": Joi.string(), "code": Joi.number()})
    .expectJSON({"message": "Invalid parameters","code": 400})
    .toss()

frisby.create('Create Charge with debit card')
    .post(URL + 'charge', {"id":"1","payment_id":"1","amount":"200"})
    .expectStatus(200)
    .expectJSONTypes({ "id": Joi.string(), "payment_id": Joi.string(), "amount": Joi.number()})
    .expectJSON({"id": "1","payment_id": "1","amount": 214})
    .toss()

frisby.create('Get 409 Error when id already exists')
    .post(URL + 'charge', {"id":"1","payment_id":"1","amount":"200"})
    .expectStatus(409)
    .expectJSONTypes({ "message": Joi.string(), "code": Joi.number() })
    .expectJSON({ "message": "Data conflict", "code": 409 })
    .toss()

frisby.create('Create Charge with credit card')
    .post(URL + 'charge', { "id": "2", "payment_id": "2", "amount": "200" })
    .expectStatus(200)
    .expectJSONTypes({ "id": Joi.string(), "payment_id": Joi.string(), "amount": Joi.number() })
    .expectJSON({ "id": "2", "payment_id": "2", "amount": 220 })
    .toss()

frisby.create('Get 400 Error when charge created with wrong parameters')
    .post(URL + 'charge', { "i": "3", "payment_id": "2", "amount": "200" })
    .expectStatus(400)
    .expectJSONTypes({ "message": Joi.string(), "code": Joi.number() })
    .expectJSON({ "message": "Invalid parameters", "code": 400 })
    .toss()


frisby.create('Get 404 Error when payment id for charge is not present')
    .post(URL + 'charge', { "id": "3", "payment_id": "3", "amount": "200" })
    .expectStatus(404)
    .expectJSONTypes({ "message": Joi.string(), "code": Joi.number() })
    .expectJSON({ "message": "Resource doesn't exist", "code": 404 })
    .toss()

frisby.create('Get all charges')
    .get(URL + 'charge')
    .expectStatus(200)
    .expectJSON([{"payment_id": "1","amount": 214},{"payment_id": "2","amount": 220}
    ])
    .toss()

frisby.create('Get charge for id 1')
    .get(URL + 'charge/1')
    .expectStatus(200)
    .expectJSONTypes({
        payment_id: Joi.string(),
        amount: Joi.number()
    })
    .expectJSON({
        "payment_id": "1",
        "amount": 214
    })
    .toss()

frisby.create('Get 404 charge for id 11')
    .get(URL + 'charge/11')
    .expectStatus(404)
    .expectJSONTypes({ "message": Joi.string(), "code": Joi.number() })
    .expectJSON({ "message": "Resource doesn't exist", "code": 404 })
    .toss()