const axios = require('axios');

const SOAP_URL = 'http://localhost:8000';

exports.rechargeWallet = async (req, res) => {
    try {
        const soapResponse = await axios.post(`${SOAP_URL}/recharge-wallet`, req.body);
        res.json(soapResponse.data);
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
};

exports.checkBalance = async (req, res) => {
    try {
        const params = new URLSearchParams({
            document: req.query.document,
            phone: req.query.phone,
        });

        const soapResponse = await axios.get(`${SOAP_URL}/check-balance?${params.toString()}`);
        res.json(soapResponse.data);
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
};
