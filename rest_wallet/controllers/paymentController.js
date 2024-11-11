const axios = require('axios');

const SOAP_URL = 'http://localhost:8000';

exports.pay = async (req, res) => {
    try {
        const soapResponse = await axios.post(`${SOAP_URL}/pay`, req.body);
        res.json(soapResponse.data);
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
};

exports.confirmPayment = async (req, res) => {
    try {
        const soapResponse = await axios.post(`${SOAP_URL}/confirm-pay`, req.body);
        res.json(soapResponse.data);
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
};
