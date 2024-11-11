const express = require('express');
const bodyParser = require('body-parser');
const clientRoutes = require('./routes/clientRoutes');
const walletRoutes = require('./routes/walletRoutes');
const paymentRoutes = require('./routes/paymentRoutes');
const { swaggerUi, swaggerDocs } = require('./swagger');

const app = express();
const port = 3000;

app.use(bodyParser.json());

app.use('/client', clientRoutes);
app.use('/wallet', walletRoutes);
app.use('/payment', paymentRoutes);

app.use('/api-docs', swaggerUi.serve, swaggerUi.setup(swaggerDocs));

app.listen(port, () => {
    console.log(`REST API is running on http://localhost:${port}`);
});
