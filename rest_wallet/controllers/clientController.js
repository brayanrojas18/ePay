const axios = require('axios');

const SOAP_URL = 'http://localhost:8000';

exports.registerClient = async (req, res) => {
    try {
        const soapResponse = await axios.post(`${SOAP_URL}/client-register`, req.body);
        res.json(soapResponse.data);
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
};
